<?php
session_start();

$message = '';

// Set/validate current table (form must POST 'table')
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = trim($_POST['table']);
    if ($table === '') {
        $message = "Inserisci un numero tavolo valido.";
    } else {
        $_SESSION['current_table'] = $table;
        $message = "Tavolo '" . htmlspecialchars($table, ENT_QUOTES) . "' impostato.";
    }
}

// Add product only if a table is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    if (!isset($_SESSION['current_table'])) {
        $message = "Imposta il tavolo prima di aggiungere prodotti.";
    } else {
        $id = trim($_POST['product_id']);
        if ($id === '') {
            $message = "Nome prodotto non valido.";
        } else {
            if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $table = $_SESSION['current_table'];
            if (!isset($_SESSION['cart'][$table]) || !is_array($_SESSION['cart'][$table])) {
                $_SESSION['cart'][$table] = [];
            }
            $_SESSION['cart'][$table][] = $id;
            $message = "Prodotto '" . htmlspecialchars($id, ENT_QUOTES) . "' aggiunto al tavolo " . htmlspecialchars($table, ENT_QUOTES) . ".";
        }
    }
}

include "./headTemplate.php";
?>

<?php if ($message): ?>
    <div class="alert alert-success" role="alert"><?php echo $message; ?></div>
<?php endif; ?>

<p class="text-center fs-5">
  Benvenuto cameriere <?php echo htmlspecialchars($_SESSION['username'] ?? 'ospite'); ?>!
</p>

<div class="container">
  <!-- Table selector -->
  <div class="row mb-3">
    <div class="col-12 text-center">
      <form id="tableForm" class="d-inline-block" method="post">
        <div class="input-group w-100 mx-auto">
          <input id="tableField" name="table" type="number" class="form-control" placeholder="Numero tavolo (es. 5)" required>
          <button class="btn btn-primary" type="submit">Imposta Tavolo</button>
        </div>
      </form>
      <div id="currentTableBadge" class="mt-2" style="font-weight:600;"></div>
    </div>
  </div>

    <?php
    $current_table = $_SESSION['current_table'] ?? '';
    $escaped_table = htmlspecialchars($current_table, ENT_QUOTES);
    ?>
    <?php if ($current_table !== ''): ?>
      <div id="currentTableBadge" class="mb-3" style="font-weight:600;">
        Tavolo corrente: <?php echo $escaped_table; ?>
      </div>
      <script>
        document.getElementById('tableField').value = '<?php echo $escaped_table; ?>';
      </script>
    <?php else: ?>
      <div id="currentTableBadge" class="mb-2" style="font-weight:600;"></div>
    <?php endif; ?>

  <div class="product-group text-center mb-3" data-category="Bevande">
    <div class="d-flex justify-content-center align-items-center gap-2">
      <form method="post" class="m-0">
        <div class="input-group mb-0">
          <span class="input-group-text">Product 1</span>
          <span class="input-group-text" value="prod2">Inserisci Bevande</span>
        </div>
      </form>
      <button type="button" class="btn btn-success add-btn" title="Aggiungi un altro prodotto in Bevande">+</button>
    </div>
  </div>


  <div class="product-group text-center mb-3" data-category="Primi">
    <div class="d-flex justify-content-center align-items-center gap-2">
      <form method="post" class="m-0">
        <div class="input-group mb-0">
          <span class="input-group-text">Product 2</span>
          <span class="input-group-text" value="prod2">Inserisci Primo</span>
        </div>
      </form>
      <button type="button" class="btn btn-success add-btn" title="Aggiungi un altro prodotto in Primi">+</button>
    </div>
  </div>

  <div class="product-group text-center mb-3" data-category="Secondi">
    <div class="d-flex justify-content-center align-items-center gap-2">
      <form method="post" class="m-0">
        <div class="input-group mb-0 ">
          <span class="input-group-text">Product 3</span>
          <span class="input-group-text" value="prod2">Inserisci Secondo</span>
        </div>
      </form>
      <button type="button" class="btn btn-success add-btn" title="Aggiungi un altro prodotto in Secondi">+</button>
    </div>
  </div>

  <div class="product-group text-center mb-3" data-category="Dolci">
    <div class="d-flex justify-content-center align-items-center gap-2">
      <form method="post" class="m-0">
        <div class="input-group mb-0">
          <span class="input-group-text">Product 4</span>
          <span class="input-group-text" value="prod2">Inserisci Dolce</span>
        </div>
      </form>
      <button type="button" class="btn btn-success add-btn" title="Aggiungi un altro prodotto in Dolci">+</button>
    </div>
  </div>

  <!-- Go to Cart -->
  <form method="post" action="carrello.php" class="mt-3 text-center">
    <div class="input-group mb-3 w-25 mx-auto">
      <button class="btn btn-outline-secondary w-100" type="submit">Go to Cart</button>
    </div>
  </form>
</div>

<script>
  // When the + button is clicked, append a small form to allow entering a custom product for that group.
  document.querySelectorAll('.add-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const group = btn.closest('.product-group');
      // Create a form with a text input named product_id so the server receives it.
      const form = document.createElement('form');
      form.method = 'post';
      form.className = 'm-0';
      form.innerHTML = `
        <div class="input-group my-2 w-25 mx-auto">
          <input type="text" name="product_id" class="form-control" placeholder="Nome piatto" required>
          <button class="btn btn-outline-primary" type="submit">Aggiungi</button>
        </div>
      `;
      group.appendChild(form);
      // Optionally focus the new input
      const input = form.querySelector('input[name="product_id"]');
      if (input) input.focus();
    });
  });
</script>

<?php include "./bottomTemplate.php"; ?>
