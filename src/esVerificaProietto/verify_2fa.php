<?php
session_start();
if(!isset($_SESSION["cod"])){
    $_SESSION["cod"]=rand(1000,9999);
}

if(isset($_POST["codice"]) && $_SESSION["state"]=="PENDING_2FA"){
    $cod =(int)$_POST["codice"];
    if($_SESSION["cod"] == $cod){
        unset($_SESSION["cod"]);
        $_SESSION["state"]=="LOGGED_IN";
        header('Location: ./dashboard.php');
        exit;
    }
    echo "<div class='alert alert-danger w-25 mx-auto text-center' role='alert'>Codice 2fa non valido!</div>";
}
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Verification</title>
</head>
<body>
<p class="text-center fs-4 mt-3">Utente <?php echo $_SESSION["username"] ?> inserisci codice a due fattori: <?php echo $_SESSION["cod"] ?></p>
<form class="w-50 mx-auto mt-5 text-center" method="post">
  <input type="number" class="form-control my-3" placeholder="Insert code (4 cifre)" name="codice" required>
  <button class="btn btn-outline-secondary my-3" type="submit">Submit</button>
</form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>    
</body>
</html>