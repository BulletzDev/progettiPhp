<?php 
include 'headTemplate.php'; 
include_once 'connection.php';
$sql = "SELECT customerNumber, customerName, contactLastName, contactFirstName FROM customers";
$result = $conn->query($sql);
$sqlProducts = "SELECT productCode, productName, MSRP FROM products";
$resultProducts = $conn->query($sqlProducts);
$orderId = $conn->query('SELECT MAX(o.orderNumber)+1 FROM orders o')->fetch_assoc()['MAX(o.orderNumber)+1'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $customerId = $conn->real_escape_string($_POST["customer_id"]);
    $productId = $conn->real_escape_string($_POST["product_id"]);
    $amount = (int)$_POST["amount"];

    // Insert new order
    $sqlInsertOrder = "INSERT INTO orders (orderNumber,customerNumber, orderDate, status, requiredDate) VALUES ('$orderId', '$customerId', NOW(), 'In Process', DATE_ADD(NOW(), INTERVAL 5 DAY))";
    if ($conn->query($sqlInsertOrder) === TRUE) {

        $sqlInsertDetails = "INSERT INTO orderdetails (orderNumber, productCode, quantityOrdered, priceEach, orderLineNumber) VALUES ('$orderId', '$productId', '$amount', (SELECT MSRP FROM products WHERE productCode='$productId'), 1)";
        $sqlPaymentDetails = "INSERT INTO payments (customerNumber, checkNumber, paymentDate, amount) VALUES ('$customerId', 'CHK$orderId', NOW(), (SELECT MSRP FROM products WHERE productCode='$productId') * $amount)";
        if ($conn->query($sqlInsertDetails) === TRUE && $conn->query($sqlPaymentDetails) === TRUE) {
            echo "<div class='alert alert-success text-center'>Order successfully created!</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Error inserting order details: " . $conn->error . "</div>";
        } 
    } else {
        echo "<div class='alert alert-danger text-center'>Error inserting order: " . $conn->error . "</div>";
    }
}
?>

<div class="input mb-3 w-50 mx-auto">
    <form method="post" id="orderForm" class="mb-3">
        <div class="row g-3">
            <div class="col-6">
                <label class="form-label">Customer</label>
                <div class="dropdown">
                    <button id="customerBtn" class="btn btn-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Select customer
                    </button>
                    <ul class="dropdown-menu w-100">
                        <?php while($row = $result->fetch_assoc()): ?>
                            <li><a class="dropdown-item" data-value="<?php echo $row['customerNumber'] ?>"><?php echo $row['customerName'] ?></a></li>
                        <?php endwhile; ?> 
                    </ul>
                </div>
                <input type="hidden" name="customer_id" id="customer_id">
            </div>
            <div class="col-6">
                <label class="form-label">Product</label>
                <div class="dropdown">
                    <button id="productBtn" class="btn btn-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Select product
                    </button>
                    <ul class="dropdown-menu w-100">
                        <?php while($row = $resultProducts->fetch_assoc()): ?>
                            <li><a class="dropdown-item" data-value="<?php echo $row['productCode'] ?>"><?php echo $row['productName'] . " ($" . $row['MSRP'] . ")" ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <input type="hidden" name="product_id" id="product_id">
            </div>
        </div>
        <input type="number" name="amount" id="amount" class="form-control w-50 mx-auto mt-3" min="1" placeholder="Amount" required>
        <div class="text-center mt-3">
            <button id="confirmBtn" type="submit" class="btn btn-dark" disabled>Confirm</button>
        </div>
    </form>
    <a href="../es14proietto/custList.php">See customer list</a>
</div>

<script>
    (function(){
        const customerBtn = document.getElementById('customerBtn');
        const productBtn = document.getElementById('productBtn');
        const customerInput = document.getElementById('customer_id');
        const productInput = document.getElementById('product_id');
        const confirmBtn = document.getElementById('confirmBtn');

        function updateState(){
            confirmBtn.disabled = !(customerInput.value && productInput.value);
        }

        document.querySelectorAll('[data-value]').forEach(item=>{
            item.addEventListener('click', function(e){
                e.preventDefault();
                const parentMenu = this.closest('.dropdown-menu');
                if(!parentMenu) return;  
                const dropdown = parentMenu.parentElement;
                if(dropdown.contains(customerBtn) || parentMenu.previousElementSibling === customerBtn){
                    customerInput.value = this.getAttribute('data-value');
                    customerBtn.textContent = this.textContent.trim();
                } else {
                    productInput.value = this.getAttribute('data-value');
                    productBtn.textContent = this.textContent.trim();
                }
                updateState();
            });
        });

        ['customerBtn','productBtn'].forEach(id=>{
            document.getElementById(id).addEventListener('shown.bs.dropdown', ()=>{});
        });

        updateState();
    })();
</script>

<?php include 'bottomTemplate.php' ?>
