// This function allows us to call the process of updating a cart item wherever we need to.
function updateCartItem(obj,id){
  $.get("cartActions.php", {action:"updateCartItem", id:id, quantity:obj.value}, function(data){
      if(data == 'ok'){
          location.reload();
      }else{
          alert('Cart update failed, please try again.');
      }
  });
}
