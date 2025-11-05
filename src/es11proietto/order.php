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

<p class="text-center fs-5">
  Benvenuto cameriere <?php echo htmlspecialchars($_SESSION['username'] ?? 'ospite'); ?>!
</p>

<div class="container">
  <!-- Table selector -->
  <div class="row mb-3">
    <div class="col-12 text-center">
      <form id="tableForm" class="d-inline-block">
        <div class="input-group w-100 mx-auto">
          <input id="tableField" name="table" type="text" class="form-control" placeholder="Numero tavolo (es. 5)" required>
          <button class="btn btn-primary" type="submit">Imposta Tavolo</button>
        </div>
      </form>
      <div id="currentTableBadge" class="mt-2" style="font-weight:600;"></div>
    </div>
  </div>

<script>
  // Keep current table in localStorage so it persists while the waiter navigates
  let currentTable = localStorage.getItem('currentTable') || '';

  const tableField = document.getElementById('tableField');
  const tableForm = document.getElementById('tableForm');
  const tableBadge = document.getElementById('currentTableBadge');

  function renderTableBadge() {
    if (currentTable) {
      tableBadge.textContent = "Tavolo selezionato: " + currentTable;
      tableField.value = currentTable;
    } else {
      tableBadge.textContent = "Nessun tavolo selezionato";
      tableField.value = '';
    }
  }

  // Initialize display
  renderTableBadge();

  tableForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const v = tableField.value.trim();
    if (!v) {
      alert('Inserisci un numero tavolo valido.');
      return;
    }
    currentTable = v;
    localStorage.setItem('currentTable', currentTable);
    renderTableBadge();

    // Update any existing hidden product_id inputs so they include the table prefix
    document.querySelectorAll('input[name="product_id"][type="hidden"]').forEach(inp => {
      // keep only product name part (remove existing prefix if any)
      const parts = inp.value.split('|');
      const productName = parts.slice(1).join('|') || parts[0];
      inp.value = currentTable + '|' + productName;
    });
  });

  // Enhance existing static product-group forms so each has a hidden product_id and an "Aggiungi" button
  document.querySelectorAll('.product-group').forEach(group => {
    const form = group.querySelector('form');
    if (!form) return;

    // Extract first span text as product name
    const nameSpan = group.querySelector('.input-group .input-group-text');
    const productName = (nameSpan && nameSpan.textContent.trim()) || 'Prodotto';

    // Replace form contents with a consistent structure (keeps classes/layout)
    form.innerHTML = `
      <div class="input-group mb-0 w-50 mx-auto">
        <input type="hidden" name="product_id" value="${currentTable ? currentTable + '|' : ''}${productName}">
        <span class="input-group-text">${productName}</span>
        <button class="btn btn-outline-primary" type="submit">Aggiungi</button>
      </div>
    `;
  });

  // Intercept any product form submission to ensure table prefix is present.
  document.addEventListener('submit', function (e) {
    const form = e.target;
    if (!(form instanceof HTMLFormElement)) return;

    const prodInput = form.querySelector('input[name="product_id"]');
    if (!prodInput) return; // not a product form

    // Ensure a table is selected
    if (!currentTable) {
      e.preventDefault();
      alert('Imposta prima il numero del tavolo.');
      return;
    }

    // If input is text (dynamic custom product), prefix its value
    // If input is hidden (predefined product), ensure it starts with table|
    const val = prodInput.value || '';
    const hasPrefix = val.startsWith(currentTable + '|');
    if (!hasPrefix) {
      // Remove any previous numeric| prefix and then prepend current table
      const parts = val.split('|');
      const productName = parts.length > 1 ? parts.slice(1).join('|') : val;
      prodInput.value = currentTable + '|' + productName;
    }
    // allow normal submit after adjusting value
  });
</script>

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
