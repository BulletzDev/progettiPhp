<?php
session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['phone_number'])) {
        $_SESSION['status'] = 'yes';
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $_SESSION['user_data']['contacts'] = [
            'email' => $email,
            'phone_number' => $phone_number
        ];
        header('Location: ./riepilogo.php');
        exit();
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserimento dati</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <form class="row g- w-25 text-center mx-auto my-5" method="post">
        <div class="col-md-12">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="input-group my-3">
            <input type="number" class="form-control" name="phone_number" placeholder="Numero di telefono" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary my-3">Send Data</button>
        </div>
    </form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>