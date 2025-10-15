<?php 
$missing = [];

if (!isset($_POST["name"]) || empty($_POST["name"])) {
    $missing[] = "Name";
}
if (!isset($_POST["surname"]) || empty($_POST["surname"])) {
    $missing[] = "Surname";
}
if (!isset($_POST["email"]) || empty($_POST["email"])) {
    $missing[] = "Email";
}

if (!empty($missing)) {
    $error = implode(", ", $missing) . " is required";
    header("Location: index.php?error=" . urlencode($error));
    exit();
}
    
?>