<?php include "./headTemplate.php"; 
session_start();    
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['empty_cart'])) {
    unset($_SESSION['cart']);
}
?>
<h3>Shopping Cart</h3>
<ul class="list-group">
<?php
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product) {
        echo "<li class='list-group-item'>$product</li>";
    }
} else {
    echo "<li class='list-group-item'>Your cart is empty.</li>";
}
?>
<form method="post" action="carrello.php" class="mt-3">
  <div class="input-group mb-3 w-25 mx-auto">
    <button class="btn btn-outline-secondary w-100" type="submit" name="empty_cart" value="1">Empty Cart</button>
  </div>
</form>
<form method="post">
  <div class="input-group m-3 w-25 mx-auto">
    <button class="btn btn-outline-secondary w-50" type="submit" formaction="checkout.php">Go to Checkout</button>
    <button class="btn btn-outline-secondary w-50" type="submit" formaction="prodotti.php">Go to Products</button>
  </div>
</form>
</ul>
<?php include "./bottomTemplate.php"; ?>

