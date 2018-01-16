<!-- This page is the standard page for the shop, where we are not on the index.php page. It displays the results of a search or through a link that defines a genre of product. -->
<?php
// We first require the connection from the base.php file
require 'reso/base.php';
include 'reso/classes/cartClass.php';
$cart = new Cart;
// Since we can get to this page through many requests, we obtain the exact link which got us to this page to add to the previous location entry in the $_SESSION superglobal.
$location = explode('/', $_SERVER['REQUEST_URI']);
$_SESSION['previous_location'] = $location[count($location)-1];

// We query the database in order to obtain the information about the products.
// We have three options:
// 1. We use the search command
// 2. We use the filter from the dropdown shop by department menu
// 3. We go directly to the shop page
if(isset($_GET['search']) && !empty($_GET['search'])){
  $productquery = 'SELECT * FROM products WHERE title LIKE "%'.$_GET['search'].'%" OR author LIKE "%'.$_GET['search'].'%"';
} elseif(isset($_SESSION['product_filter']) && !empty($_SESSION['product_filter'])) {
  $productquery = $_SESSION['product_filter'];
} else if(isset($_REQUEST['genre_id'])) {
  $productquery='SELECT * FROM products WHERE genre_id='.$_REQUEST['genre_id'];
} else {
  $productquery = 'SELECT * FROM products';
}
//get all the information from the sql database
$results = mysqli_query($con, $productquery);
$results = mysqli_fetch_all($results, MYSQLI_ASSOC);
//obtain the number of elements in our books table
$noResults = sizeof($results);
// If we have returned to this page via cartActions upon adding an item to the cart, then here we get the details of the item just added, which is added to an automatic pop up created later.
$orderedProduct = '';
$popUp = false;
if(isset($_SESSION['addedToCart'])){
  $productNameQuery = 'SELECT title, img  FROM products WHERE product_id='.$_SESSION['addedToCart'];
  $productsNameResult = mysqli_query($con, $productNameQuery);
  $productsNameResult = mysqli_fetch_all($productsNameResult, MYSQLI_ASSOC);
  $orderedProduct = $productsNameResult[0]['title'];
  $orderedImg = $productsNameResult[0]['img'];
  $popUp = true;
  unset($_SESSION['addedToCart']);
}
// We use the standard header on this page.
require 'reso/frames/header.php';
 ?>
<!-- Below starts the html for our document -->
<body>
<!-- This gives the navbar for our page. -->
  <?php include 'reso/frames/navbar.php'; ?>
  <!-- This is a hidden button to give the functionality of making the addedToCartPopUp modal to appear in some jquery at the bottom. -->
  <button type="button" id="addedToCartButton" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addedToCartPopUp" style="display:none;"> </button>
<!-- This is the pop up modal when an item is added to the cart. It has added to cart as its main title, an image of the product and some small text confirmation of what has been added to the cart. -->
  <div class-"container">
    <div class = 'modal fade' id ='addedToCartPopUp' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h5 class="modal-title text-center w-100">Item Added!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <?php echo '<img src="'.$orderedImg.'"/>'; ?>
          </div>
          <div class="modal-body text-justify">
            <?php echo $orderedProduct.' has been added to the cart!'; ?>
          </div>
          <div class="modal-body text-center">
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- The shop frame file contains the template for displaying the selected products. -->
  <?php include 'reso/frames/shopFrame.php'; ?>
<!-- We include the standard footer of all out pages. -->
  <?php include 'reso/frames/footer.php'; ?>
<!-- We have your standard set of scripts for each page. -->
  <?php require 'reso/frames/scripts.php'; ?>
  <!-- The script below activates the pop up of an item added, when we return to this page from the cart actions page. It allows the pop up to display for two seconds before automatically closing it. -->
  <script>
    var activatePopUp = <?php echo $popUp; ?>;
    function triggerPopUp(){
      $('#addedToCartButton').trigger('click');
    }
    if (activatePopUp==1){
      triggerPopUp();
      setTimeout(triggerPopUp, 2000);
    }
  </script>
</body>
 </html>
