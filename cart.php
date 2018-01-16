<?php
// We first require the connection from the base.php file
require 'reso/base.php';
// We use the cart class on this page.
include 'reso/classes/cartClass.php';
$cart = new Cart;
// We require the header on every page. It contains everything that is needed in the <head> section.
require 'reso/frames/header.php';
?>
<body>
  <!-- The navbar is a frame which is used on every page. -->
  <?php include 'reso/frames/navbar.php'; ?>
<!-- This section provides a html table displaying the current contents of the cart and the total price. -->
  <div class="container" style="min-height: 22.5em !important;">
    <div class="row">
      <h3 class="ml-2 mt-2">Shopping Cart</h3>
      <table class="table">
        <thead>
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
            </tr>
        </thead>
        <tbody>
          <!-- We first check that we have some items in the cart. -->
          <?php
          if($cart->total_items() > 0){
              // We get cart items from the session (function from cartClass.php)
              $cartItems = $cart->contents();
              foreach($cartItems as $item){
                // We need to consider separately the case of having multiple copies of the same product
                if(sizeof($item)>1){
          ?>
          <tr>
              <td scope="row"><?php echo $item["name"]; ?></td>
              <td><?php echo '£'.$item["price"]; ?></td>
              <td>
                <!-- The onchange attribute of our input allows us to mirror increase and decrease in number of a product in the value in the session. -->
                <input type="number" class="form-control text-center w-50" value="<?php echo $item["quantity"]; ?>"  style="display: inline;" onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')">
                <!-- This link is displayed a button with the rubbish bin to indicate it removes an item from the cart. -->
                <a href="cartActions.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>" style="display: inline;" class="btn btn-danger w-50" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
              </td>
          </tr>
          <?php } } }else{ ?>
          <tr><td colspan="5"><p>Your cart is empty.</p></td>
          <?php } ?>
        </tbody>
<!-- At the foot of the table, the customer has the option of returning to the shop page to continue purchasing or to proceed to checkout. -->
        <tfoot>
          <tr>
            <td><a href="shop.php" class="btn btn-primary"><i class="glyphicon glyphicon-menu-left"></i> Continue Shopping</a></td>
            <!-- We only display the check-out option if the cart is non-empty. -->
            <?php if($cart->total_items() > 0){ ?>
            <td class=""><strong>Total <br> <?php echo '£'.$cart->total(); ?></strong></td>
            <td><a href="checkout.php" class="btn btn-success btn-block">Checkout</a></td>
            <?php } ?>
          </tr>
      </tfoot>
    </table>
  </div>
</div>
<!-- We include the same footer on all of our main pages and also the required scripts (in JS) at the end of the body. -->
<?php include 'reso/frames/footer.php'; ?>
<?php include 'reso/frames/scripts.php'; ?>
</body>
</html>
