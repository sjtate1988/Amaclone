<!-- index.php redirects to this main page. -->
<?php
// We first require the connection from the base.php file and the cart class.
require 'reso/base.php';
include 'reso/classes/cartClass.php';
$cart = new Cart;
// We obtain a list of genres in order to categorise our products on our main page.
$genreQuery = 'SELECT * FROM genres';
$genreSQLQuery = mysqli_query($con, $genreQuery) or die(mysqli_error($con));
$genres = mysqli_fetch_all($genreSQLQuery, MYSQLI_ASSOC);
$noOfGenres = sizeof($genres);
// We use the same headers as on our other pages.
require 'reso/frames/header.php';

// We set the location in the $_SESSION superglobal.
$_SESSION['previous_location']='frontShop.php';

// We create a pop up when an item is ordered. The information generated from the query below tells the customer what they have just added to the cart.
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

 ?>
<!-- Below starts the html for our document -->
<body>
  <?php include 'reso/frames/navbar.php';?>
<!-- Carousel -->
  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100" src="reso/static/img/SandersonBooks.png" alt="First slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="reso/static/img/VampireAcademy.png" alt="Second slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="reso/static/img/BoardGames.png" alt="Third slide">
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

<!-- Free delivery bar -->
  <div class="container-fluid bg-dark">
      <p class="text-center text-colour font-weight-bold text-white">FREE Delivery on millions of eligible items</p>
  </div>

<!-- Products Listing-->
<!-- The hidden button below is there to trigger the modal that appears once an item has been ordered. -->
<button type="button" id="addedToCartButton" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addedToCartPopUp" style="display:none;"> </button>
<!-- Below is the modal pop up, which indicates that an item has been added to the cart. -->
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

<!-- Below we create a horizontal scrollbar for each genre of product. -->
<?php
for ($i=1; $i<=$noOfGenres; $i++){
  // We query the database in order to obtain the information about the products
  $productQuery = 'SELECT * FROM products P, genres G WHERE P.genre_id=G.genre_id AND P.genre_id='.$i.' LIMIT 12';
  //We get all the information from the sql database
  $resultsProducts = mysqli_query($con, $productQuery);
  $resultsProducts = mysqli_fetch_all($resultsProducts, MYSQLI_ASSOC);
  $noResults = 12;
  $noResultsProducts = min($noResults,sizeof($resultsProducts)); ?>
  <div class="container">
    <div class="container-fluid">
        <h5 class="text-left font-weight-bold"><?php echo $resultsProducts[0]['genre'] ?> - Best Sellers</h5>
    </div>
    <div class="overflow pl-3">


    <div class="row" style="width: 1820px;">

    <!-- Starting a loop through all of the rows of the products table to create a templated card for each row -->
      <?php for($j=0; $j<$noResultsProducts; $j++){  ?>
        <!-- We create a card for each product with a picture and a button which opens a modal to show more details. -->
        <div class="productCard" style="width: 150px; height: auto;">
          <div class="card card-primary border-0 text-center">
            <div class="card-body px-0 mx-1 pb-0" style="height: 18em;" <?php echo 'id="product'.$resultsProducts[$j]['product_id'].'"'; ?>>
              <img src="<?php echo $resultsProducts[$j]['img'] ?>" class="img-responsive w-100 h-75" alt="Image">
              <button type="button" class="btn btn-primary w-100" data-toggle="modal"  data-target="<?php echo '#descriptionModal_'.$resultsProducts[$j]['product_id'] ?>" style="display:block;">
                Description
              </button>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <?php for($j=0; $j<$noResultsProducts; $j++){ ?>
        <!-- Modal  for each product with title description image and option to add the product to the cart. -->
        <div class="modal fade"  id="<?php echo 'descriptionModal_'.$resultsProducts[$j]['product_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header text-center">
                <h5 class="modal-title text-center w-100" id="exampleModalLabel"><?php echo $resultsProducts[$j]['title']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body text-center">
                <img src="<?php echo $resultsProducts[$j]['img'] ?>" class="img-responsive" style="width:40%" alt="Image">
              </div>
              <div class="modal-body text-justify">
                <?php echo $resultsProducts[$j]['description']; ?>
              </div>
              <div class="modal-body text-center">
                <b>£<?php echo $resultsProducts[$j]['price']; ?></b>
              </div>
              <div class="modal-footer">
                <a role="button" class="btn btn-primary" id="addToCart" href="cartActions.php?action=addToCart&id=<?php echo $resultsProducts[$j]['product_id']; ?>">Add to Cart</a>
              </div>
            </div>
          </div>
        </div>

<?php } ?>
</div>
<?php }
// We require the footer on every page and all the scripts that we use on every page.
include 'reso/frames/footer.php';
require 'reso/frames/scripts.php'; ?>
<!-- We have a script to make the added to cart modal pop up and automatically close after two seconds. -->
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
