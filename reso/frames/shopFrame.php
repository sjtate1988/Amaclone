<!-- This is the content of all the shop pages. This page acts as a template for the database results in shop.php. -->

<div class="container" style="min-height: 321px;">
  <br>
<!-- Starting a loop through all of the rows of the products table to create a templated card for each row -->
<?php if($noResults > 0){
for($i=0; $i<$noResults; $i++){ ?>
<div class="row">
  <!-- We create a card for each product which has: the image to the left; the title (large) and author name (small) at the top with a description; and the price and an add to cart button to the right. -->
  <div class="col-lg-2">
    <div class="card border-0" >
      <img class="card-img-top  border" src="<?php echo $results[$i]['img'] ?>" alt="Card image cap">
    </div>
  </div>

  <div class="col-lg-7"  <?php echo 'id="product'.$results[$i]['product_id'].'"'; ?>>
    <div class="card border-0">
      <div class="card-heading "><h5><?php echo $results[$i]['title']?></h5></div>
      <div class="card-heading"><small class="text-muted"><?php echo $results[$i]['author']?></small></div>
      <div class="card-body p-0 mt-3"><p style="font-size:0.90em"><?php echo $results[$i]['description']; ?></p></div>
    </div>
  </div>

  <div class="col-lg-3 d-flex align-items-end">
    <div class="card border-0 w-100">
      <div class="card-footer border-0">Price £<?php echo $results[$i]['price']?></div>
      <!-- The following link sends the action addToCart with the product ID on the cartActions page, thereby adding the product to the cart. -->
      <a role="button" class="btn btn-primary color-white" id="addToCart" href="cartActions.php?action=addToCart&id=<?php echo $results[$i]['product_id']; ?>">Add to Cart</a>
    </div>
  </div>
</div>
<hr>
<?php }
// If there are no products then we tell the customer that their search was unsuccessful.
} else {
  ?>
  <div class='row'>
    <div class='col-lg-12'>
      <p>Search not found</p>
    </div>
  </div>
  <?php
} ?>
</div>
