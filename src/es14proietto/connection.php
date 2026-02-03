<?php
$servernameDB="localhost";
$usernameDB="root";
$passwordDB="";
$dbnameDB="classicmodels";
mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli($servernameDB, $usernameDB, $passwordDB, $dbnameDB);
$conn->set_charset("utf8mb4");
if ($conn->connect_error) {
    header("Location: ../error.php");
    exit();
}
?>



