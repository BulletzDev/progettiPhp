<?php
include_once 'connection.php';
include_once 'headTemplate.php';

if (isset($_GET["customerNumber"])) {
    $customerNumber = $_GET["customerNumber"];
    header("Location: orderList.php?customerNumber=" . urlencode($customerNumber));
    exit();
}
$sql = "SELECT customerNumber, customerName, contactLastName, contactFirstName, phone FROM customers";
$result = $conn->query($sql);?>
    <h2>Customer List</h2>
    <table cellpadding="10" class=" bordered table table-striped mx-auto">
        <tr>
            <th>Customer Number</th>
            <th>Customer Name</th>
            <th>Contact Last Name</th>
            <th>Contact First Name</th>
            <th>Phone</th>
        </tr>
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><a href="orderList.php?customerNumber=<?php echo urlencode($row["customerNumber"]); ?>"><?php echo htmlspecialchars($row["customerNumber"]); ?></a></td>
            <td><?php echo htmlspecialchars($row["customerName"]); ?></td>
            <td><?php echo htmlspecialchars($row["contactLastName"]); ?></td>
            <td><?php echo htmlspecialchars($row["contactFirstName"]); ?></td>
            <td><?php echo htmlspecialchars($row["phone"]); ?></td>
        </tr>
<?php
    }
} else {
    echo "0 results";
}
$conn->close();
include_once 'bottomTemplate.php';
?>