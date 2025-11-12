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
      $amount = isset($_POST['amount']) ? (int)$_POST['amount'] : 1;
     $category = isset($_POST['category']) ? trim($_POST['category']) : '';
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
       $message = "Numero: ".$amount. " di " .$id . " aggiunto al tavolo " .$table. ".";
       $_SESSION['cart'][$table][] = [$id, $amount, $category];
       $message = "Numero: " . $amount . " di " . $id . ($category ? " (" . htmlspecialchars($category) . ")" : "") . " aggiunto al tavolo " . $table . ".";
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

<div class="container d-flex flex-column align-items-center">
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
  ;
  ?>
  <?php if ($current_table !== ''): ?>
    <div id="currentTableBadge" class="mb-3" style="font-weight:600;">
    Tavolo corrente: <?php echo $current_table; ?>
    </div>
  <?php else: ?>
    <div id="currentTableBadge" class="mb-2" style="font-weight:600;"></div>
  <?php endif; ?>

  <div id="productContainer" class="flex"></div>

  <form method="post" action="carrello.php" class="mt-3 text-center">
  <div class="input-group mb-3 w-100 mx-auto">
    <button class="btn btn-outline-secondary w-100" type="submit">Go to Cart</button>
  </div>
  </form>
</div>

<script>
  // Categories to spawn
  const categories = {
    'Bibite': 5,
    'Antipasti': 15,  
    'Primi': 20,
    'Secondi': 25,
    'Contorni': 10,
    'Dolci': 12
  };
  const container = document.getElementById('productContainer');
  const currentTableFromServer = <?php echo json_encode($current_table); ?>;

  function createGroup(category) {
    const group = document.createElement('div');
    group.className = 'product-group text-center mb-3';
    group.dataset.category = category;

    group.style.width = '360px';
    group.style.minWidth = '360px';
    group.innerHTML = `
      <div class="d-flex">
        <form method="post" class="m-0 d-inline-block w-100 ">
          <div class="input-group mb-0">
            <span class="input-group-text " style="width: calc(100% - 56px);">
            Inserisci ${category}
            </span>
          </div>
        </form>
        <button type="button" class="btn btn-success add-btn" title="Aggiungi un altro prodotto in ${category}" style="width:56px; min-width:56px;">+</button>
      </div>
    `;
  
    // attach add handler
    const btn = group.querySelector('.add-btn');
    btn.addEventListener('click', () => addProductForm(group, category));
    return group;
  }

  function addProductForm(group, category) {
    //check if a form is already present with an id given to this form
    if (document.getElementById('existingForm')) {
      return; // Form already exists, do not add another
    }
    // Create a form that posts product_id and the current table
    const form = document.createElement('form');
    
    form.method = 'post';
    form.className = 'm-0';
    form.id="existingForm";
    

    // get current table value from the main input (if present) or from PHP
    const tableValue = (document.getElementById('tableField') && document.getElementById('tableField').value) || currentTableFromServer || '';

    form.innerHTML = `
      <div class="input-group my-2 w-100 mx-auto">
        <input type="text" name="product_id" class="form-control" placeholder="Nome piatto" required>
        <input type="hidden" name="category" value="${category}">
        <input type="hidden" name="table" value="${String(tableValue).replace(/"/g, '&quot;')}">
        <input type="number" name="amount" class="form-control" required min="1" placeholder="Quantità">
        <button class="btn btn-outline-primary" type="submit">Aggiungi</button>
      </div>
    `;
    group.appendChild(form);
    const input = form.querySelector('input[name="product_id"]');
    if (input) input.focus();
  }

  Object.keys(categories).forEach(cat => container.appendChild(createGroup(cat)));

  const tableField = document.getElementById('tableField');
  if (tableField) {
  tableField.addEventListener('input', () => {
    const hiddenInputs = document.querySelectorAll('form input[type="hidden"][name="table"]');
    hiddenInputs.forEach(h => h.value = tableField.value);
  });
  }
</script>

<?php include "./bottomTemplate.php"; ?>
