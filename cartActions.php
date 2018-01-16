<?php
// We require the cartClass and the base to start our session.
include 'reso/classes/cartClass.php';
include 'reso/base.php';
$cart = new Cart();

// This file is the module for dealing with the common cart actions that are needed to be performed on the main shop pages.
// It works with the required action being instigated by a link with a HTML request called action $_REQUEST['action'].
// We then run through the key actions that the other pages can make.

//If a request called action is received (post or get) and if it's not empty:
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
  //If the request action is add to cart, and the request id is not empty
  if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){
    var_dump($_REQUEST['id']);
    $productID = $_REQUEST['id'];
    //We get the product details from the database.
    $query = mysqli_query($con, "SELECT * FROM products WHERE product_id = ".$productID);
    //We change the mysqli object to an associative array or hashmap.
    $row = mysqli_fetch_assoc($query);
    // We create our own hashmap to store the important data about adding an item to the cart.
    $itemData = array(
      'id' => $row['product_id'],
      'name' => $row['title'],
      'price' => $row['price'],
      'quantity' => 1
    );
    //We send the array to the insert function in the Cart Class.
    $insertItem = $cart->insert($itemData);
    //If insertItem returns TRUE, set the location to the previous location and to the section with the product that has been added, indicated by the #.
    if($insertItem){
      $_SESSION['addedToCart']=$productID;
      header("Location: ".$_SESSION['previous_location']."#product".$productID);
    }
    // Another action we can perform is to update an item in the cart.
  } elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){
    $itemData = array(
      'rowId' => $_REQUEST['id'],
      'quantity' => $_REQUEST['quantity']
    );
    // We use the update method from the cart class.
    $updateItem = $cart->update($itemData);
    // if the update returns TRUE, send ok, else send fail
    if($updateItem){
      echo 'ok';
    } else {
      echo 'fail';
      die();
    }
    // If we choose to remove an item from our cart.
  } elseif ($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){
    // We call the remove function from the cart class.
    $deleteItem = $cart->remove($_REQUEST['id']);
    // If successful, we then go back to the cart page, which is the only place we can remove items from the cart.
    if($deleteItem){
      header("Location: cart.php");
    }
    // Finally, we have the action of placing an order.
  } elseif ($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['user'])){
    // We insert order details into the database, this will return either TRUE or FALSE
    $insertOrder = mysqli_query($con, "INSERT INTO orders (user_id, total_price) VALUES ('".$_SESSION['user']['user_id']."', '".$cart->total()."')");
    if($insertOrder){
      //specify a specific order id, mysqli_insert_id returns the auto generated id used in the latest query
      $orderID = mysqli_insert_id($con);
      $query = '';
      // get cart items from the cart_contents variable to store in the order_items table
      $cartItems = $cart->contents();
      // loop through the array of that contents() returned, and make a multi query
      foreach($cartItems as $item){
        $query .= 'INSERT INTO order_items (order_id, product_id, quantity) VALUES ("'.$orderID.'", "'.$item['id'].'", "'.$item['quantity'].'");';
      }
      //insert the order items in the order_items table by using a multi query
      $insertOrderItems = mysqli_multi_query($con, $query);
      //if the multi query returns true, send the user to the order success page including its id
      if($insertOrderItems){
        $cart->destroy();
        header("Location: orderSuccess.php?id=$orderID");
      } else {
        header("Location: checkout.php");
      }
    } else {
      header("Location: checkout.php");
    }
  }
}

 ?>
