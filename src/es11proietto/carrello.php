<?php
session_start();
include "./headTemplate.php";

$category_prices = [
    'Bibite'    => 5,
    'Antipasti' => 15,
    'Primi'     => 20,
    'Secondi'   => 25,
    'Contorni'  => 10,
    'Dolci'     => 12,
];

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
                        <strong>Tavolo: <?php echo $table ?></strong>
                    </div>
                    <div class="card-body d-flex flex-column p-2">
                        <?php
                          $table_total = 0.0;
                        ?>
                        <?php if (is_array($products) && count($products) > 0): ?>
                            <ul class="list-group list-group-flush mb-2">
                                <?php foreach ($products as $product): ?>
                                    <li class="list-group-item">
                                        <?php
                                            $name = '';
                                            $amount = 1;
                                            $category = '';
                                            if (is_array($product)) {
                                                $name = isset($product[0]) ? $product[0] : '';
                                                // amount may be in index 1
                                                if (isset($product[1]) && is_numeric($product[1])) {
                                                    $amount = intval($product[1]);
                                                } elseif (isset($product[2]) && is_numeric($product[2])) {
                                                    $amount = intval($product[2]);
                                                }
                                                // category expected at index 2 (if present)
                                                if (isset($product[2]) && !is_numeric($product[2])) {
                                                    $category = $product[2];
                                                } elseif (isset($product[2]) && is_string($product[2])) {
                                                    $category = $product[2];
                                                } elseif (isset($product[3])) {
                                                    $category = $product[3];
                                                }
                                            } else {
                                                // fallback: product is a string
                                                $name = $product;
                                            }

                                            $price_each = 0.0;
                                            if ($category !== '' && isset($category_prices[$category])) {
                                                $price_each = (float)$category_prices[$category];
                                            }
                                            $line_total = $price_each * $amount;
                                            $table_total += $line_total;

                                            echo htmlspecialchars($name) . ' <span class="text-muted">(x' . $amount . ')</span>';
                                            if ($price_each > 0) {
                                                echo ' <div class="text-end small">€' . number_format($price_each, 2) . ' cadauno — Tot: €' . number_format($line_total, 2) . '</div>';
                                            } else {
                                                echo ' <div class="text-end small text-muted">Prezzo non disponibile</div>';
                                            }
                                        ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <div class="text-muted mb-2">Nessun prodotto per questo tavolo.</div>
                        <?php endif; ?>
                        <div class="mt-2 fw-bold">
                          Totale tavolo: €<?php echo number_format($table_total, 2); ?>
                        </div>
                        <div class="mt-auto">
                            <form method="post" class="m-0">
                                <input type="hidden" name="remove_table" value="<?php echo $table?>">
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
    <button class="btn btn-outline-secondary w-50" type="submit" name="empty_cart" formaction="carrello.php">Svuota il carrello</button>
    <button class="btn btn-outline-secondary w-50" type="submit" formaction="order.php">Torna agli ordini</button>
  </div>
</form>

<?php
// optional: handle removal of a single table from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_table_btn']) && (isset($_POST['remove_table']) || isset($_POST['empty_cart']))) {
    $remove = $_POST['remove_table'];
    if ($remove !== '' && isset($_SESSION['cart'][$remove])) {
        unset($_SESSION['cart'][$remove]);
        exit(header('Location: ./carrello.php'));
    }
}

include "./bottomTemplate.php";
?>