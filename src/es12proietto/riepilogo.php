<?php 
    session_start();
    if (!isset($_SESSION['user_data']) || $_SESSION['status']=='ds' ) {
        header('Location: ./index.php');
        exit();
   }
    if ($_SESSION['status']=='cs') {
        header('Location: ./raccoltaContatti.php');
        exit();
   }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riepilogo dati</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <h1 class="text-center my-5">Riepilogo Dati</h1>
    <div class="container w-50">
        <ul class="list-group">
            <li class="list-group-item"><strong>Nome:</strong> <?php echo $_SESSION['user_data']['data']['name']; ?></li>
            <li class="list-group-item"><strong>Cognome:</strong> <?php echo $_SESSION['user_data']['data']['surname']; ?></li>
            <li class="list-group-item"><strong>Data di Nascita:</strong> <?php echo $_SESSION['user_data']['data']['birthdate']; ?></li>
            <li class="list-group-item"><strong>Indirizzo:</strong> 
                <?php 
                    echo $_SESSION['user_data']['data']['address']['street_type']    . ' ' . 
                         $_SESSION['user_data']['data']['address']['street_name'] . ', ' . 
                         $_SESSION['user_data']['data']['address']['street_number'];
                ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?php echo $_SESSION['user_data']['contacts']['email']; ?></li>
            <li class="list-group-item"><strong>Numero di Telefono:</strong> <?php echo $_SESSION['user_data']['contacts']['phone_number']; ?></li>
        </ul>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>