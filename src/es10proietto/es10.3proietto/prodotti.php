<?php
session_start();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $id = $_POST['product_id'];
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    // Aggiungo l'id al carrello
    $_SESSION['cart'][] = $id;
    $message = "Prodotto '$id' aggiunto al carrello.";
}

include "./headTemplate.php";
?>

<?php if ($message): ?>
    <div class="alert alert-success" role="alert"><?php echo $message; ?></div>
<?php endif; ?>

<form method="post">
  <div class="input-group mb-3 w-25 mx-auto">
    <span class="input-group-text w-50">Product 1</span>
    <button class="btn btn-outline-secondary w-50" type="submit" name="product_id" value="prod1">Add to cart</button>
  </div>
</form>

<form method="post">
  <div class="input-group mb-3 w-25 mx-auto">
    <span class="input-group-text w-50">Product 2</span>
    <button class="btn btn-outline-secondary w-50" type="submit" name="product_id" value="prod2">Add to cart</button>
  </div>
</form>

<form method="post">
  <div class="input-group mb-3 w-25 mx-auto">
    <span class="input-group-text w-50">Product 3</span>
    <button class="btn btn-outline-secondary w-50" type="submit" name="product_id" value="prod3">Add to cart</button>
  </div>
</form>

<form method="post" action="carrello.php" class="mt-3">
  <div class="input-group mb-3 w-25 mx-auto">
    <button class="btn btn-outline-secondary w-100" type="submit">Go to Cart</button>
  </div>
</form>

<?php include "./bottomTemplate.php"; ?>
