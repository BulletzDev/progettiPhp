<?php
session_start();
$user = [
    "paolo" => "1234",
    "carlo" => "5678",
    "gianni"=>"gianni1"
];
if(isset($_SESSION["state"]) && $_SESSION["state"]=="LOGGED_IN"){
  header('Location: ./dashboard.php');
  exit;
}

if(isset($_POST["username"]) && isset($_POST["password"])){
    foreach($user as $k => $v){
        if($k == $_POST["username"] && $v == $_POST["password"]){
            $_SESSION["username"]= $k;
            $_SESSION["state"]="PENDING_2FA";
            header('Location: ./verify_2fa.php');
            exit;
        }
    }
    echo "<div class='alert alert-danger w-25 mx-auto text-center' role='alert'>Credenziali non valide!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
<p class="text-center fs-4 mt-3">Inserisci Credenziali per l'accesso:</p>
<form class="w-50 mx-auto mt-5 text-center" method="post">
  <input type="text" class="form-control my-3" placeholder="Insert username" name="username" required>
  <input type="password" class="form-control" placeholder="Insert Password" name="password" required>
  <button class="btn btn-outline-secondary my-3" type="submit">Submit</button>
</form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>    
</body>
</html>