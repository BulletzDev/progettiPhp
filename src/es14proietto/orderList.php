<?php
include_once 'connection.php';
include_once 'headTemplate.php';

$sql = "SELECT o.orderNumber, o.orderDate, o.shippedDate, o.status, o.comments,o.customerNumber FROM orders o WHERE o.customerNumber = " . $conn->real_escape_string($_GET["customerNumber"]) . " ORDER BY orderDate DESC";
$result = $conn->query($sql);?>
    <h2>Order List</h2>
    <table cellpadding="10" class=" bordered table table-striped mx-auto">
        <tr>
            <th>Order Number</th>
            <th>Order Date</th>
            <th>Shipped Date</th>
            <th>Status</th>
            <th>Comments</th>
            <th>Customer Number</th>
        </tr>
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row["orderNumber"]); ?></td>
            <td><?php echo htmlspecialchars($row["orderDate"]); ?></td>
            <td><?php echo htmlspecialchars($row["shippedDate"]); ?></td>
            <td><?php echo htmlspecialchars($row["status"]); ?></td>
            <td><?php echo htmlspecialchars($row["comments"]); ?></td>
        </tr>
<?php
    }
} else {
    echo "0 results";
}
?><a href="custList.php">Return to Customer list</a><?php
$conn->close();
include_once 'bottomTemplate.php';
?>