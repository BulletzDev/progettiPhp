<?php
session_start();
include "./headTemplate.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['empty_cart'])) {
    unset($_SESSION['cart']);
}
?>
<h3>Riepilogo comande</h3>

<?php if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
    <div class="row">
        <?php foreach ($_SESSION['cart'] as $table => $products): ?>
            <div class="col-12 col-sm-6 col-md-3 mb-3 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-header">
                        <strong>Tavolo: <?php echo htmlspecialchars($table, ENT_QUOTES); ?></strong>
                    </div>
                    <div class="card-body d-flex flex-column p-2">
                        <?php if (is_array($products) && count($products) > 0): ?>
                            <ul class="list-group list-group-flush mb-2">
                                <?php foreach ($products as $product): ?>
                                    <li class="list-group-item"><?php echo htmlspecialchars($product, ENT_QUOTES); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <div class="text-muted mb-2">Nessun prodotto per questo tavolo.</div>
                        <?php endif; ?>
                        <div class="mt-auto">
                            <form method="post" action="carrello.php" class="m-0">
                                <!-- example: remove all products for this table (optional) -->
                                <input type="hidden" name="remove_table" value="<?php echo htmlspecialchars($table, ENT_QUOTES); ?>">
                                <button type="submit" name="remove_table_btn" value="1" class="btn btn-sm btn-outline-danger w-100">Rimuovi tavolo</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <ul class="list-group">
        <li class="list-group-item">Il carrello è vuoto.</li>
    </ul>
<?php endif; ?>

<form method="post" class="mb-4">
  <div class="input-group m-3 w-25 mx-auto">
    <button class="btn btn-outline-secondary w-50" type="submit" formaction="carrello.php">Svuota il carrello</button>
    <button class="btn btn-outline-secondary w-50" type="submit" formaction="order.php">Torna agli ordini</button>
  </div>
</form>

<?php
// optional: handle removal of a single table from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_table_btn']) && isset($_POST['remove_table'])) {
    $remove = trim($_POST['remove_table']);
    if ($remove !== '' && isset($_SESSION['cart'][$remove])) {
        unset($_SESSION['cart'][$remove]);
        // simple redirect to avoid repost on refresh
        header('Location: carrello.php');
        exit;
    }
}

include "./bottomTemplate.php";
?>