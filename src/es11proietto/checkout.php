<?php include "./headTemplate.php"; 
session_start();    
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    unset($_SESSION['cart']);
    echo '<div class="alert alert-success" role="alert">Order confirmed! Thank you for your purchase.</div>';
}
?>
<h3>Order Summary</h3>
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

<form method="post">
  <div class="input-group m-3 w-25 mx-auto">
    <button class="btn btn-outline-secondary w-50" type="submit" name="confirm_order" value="1" formaction="checkout.php">Confirm Order</button>
    <button class="btn btn-outline-secondary w-50" type="submit" formaction="carrello.php">Go to Cart</button>
  </div>
</form>

</ul>
<?php include "./bottomTemplate.php"; ?>

