<!-- This page informs the customer of the success of their order and provides them with an order id. -->
<?php
// We include the usual base file and the cart class.
require 'reso/base.php';
include 'reso/classes/cartClass.php';
$cart = new Cart;
// The only way to access this page is though checkout via cart actions, which will set an id. If this hasn't happened the customer will be redirected to the main page.
if(!isset($_REQUEST['id'])){
    header("Location: index.php");
}
// The head details on all pages are contained here.
require 'reso/frames/header.php';
?>
<body>
  <?php include 'reso/frames/navbar.php'; ?>
  <div class="container">
    <h1>Order Status</h1>
    <p>Your order has submitted successfully. Order ID is #<?php echo $_GET['id']; ?></p>
  </div>

  <?php include 'reso/frames/footer.php'; ?>
  <?php require 'reso/frames/scripts.php'; ?>
</body>
</html>
