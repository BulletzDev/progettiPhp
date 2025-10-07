<?php include './headTemplate.php';

// Connect to MySQL server (no DB yet)
$conn = mysqli_connect('localhost:3307', 'root', '');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if not exists
$dbSql = "CREATE DATABASE IF NOT EXISTS bookphone";
mysqli_query($conn, $dbSql);
mysqli_select_db($conn, 'bookphone');

// Create contacts table if not exists
$tableSql = "CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($conn, $tableSql);
$conn->close();

$conn = mysqli_connect('localhost:3307', 'root', '', 'bookphone');
if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
}
$bookPhone = array();

fetchContactsFromDB($conn, $bookPhone);

if (isset($_POST['name']) && $_POST['name'] !== "" && isset($_POST['number']) && $_POST['number'] !== "" && isset($_POST['surname']) && $_POST['surname'] !== "") {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $surname = $_POST['surname'];
    $bookPhone[] = [$name, $surname, $number];

    addContactToDB($name, $surname, $number);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();

}

function printBookPhone($bookPhone)
{
    echo '<ul class="list-group mt-4">';
    foreach ($bookPhone as $index => $contact) {
        echo '<li class="list-group-item">';
        echo "Contact $index: Name: {$contact[0]}, Surname: {$contact[1]}, Number: {$contact[2]}";
        echo '</li>';
    }
    echo '</ul>';
}

function fetchContactsFromDB($conn, &$bookPhone)
{
    $result = $conn->query("SELECT name, surname, phone FROM contacts");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookPhone[] = [$row['name'], $row['surname'], $row['phone']];
        }
    }
}

function addContactToDB($name, $surname, $number)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO contacts (name, surname, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $surname, $number);
    $stmt->execute();
    $stmt->close();
}

?>

<form class="container mt-5" style="max-width: 500px;" method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="contactName" name="name">
    </div>
    <div class="mb-3">
        <label for="surname" class="form-label">Surname</label>
        <input type="text" class="form-control" id="contactSurname" name="surname">
    </div>
    <div class="mb-3">
        <label for="number" class="form-label">phone number</label>
        <input type="number" class="form-control" id="contactNumber" name="number">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>



<?php
printBookPhone($bookPhone);
include './bottomTemplate.php'; ?>