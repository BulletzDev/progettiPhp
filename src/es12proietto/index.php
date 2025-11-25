<?php
session_start();
    $_SESSION['status'] = 'ds';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
        $birthdate = isset($_POST['birthdate']) ? trim($_POST['birthdate']) : '';
        $street_type = isset($_POST['street_type']) ? trim($_POST['street_type']) : '';
        $street_name = isset($_POST['street_name']) ? trim($_POST['street_name']) : '';
        $street_number = isset($_POST['street_number']) ? trim($_POST['street_number']) : '';
        $_SESSION['user_data']['data'] = [
            'name' => $name,
            'surname' => $surname,
            'birthdate' => $birthdate,
            'address' => [
                'street_type' => $street_type,
                'street_name' => $street_name,
                'street_number' => $street_number
            ]
        ];
        $_SESSION['status'] = 'cs'; 
        header('Location: ./raccoltaContatti.php');
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
        <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Cognome</label>
            <input type="text" class="form-control" name="surname" required>
        </div>
        <div class="col-md-12">
            <label class="form-label">Data di Nascita</label>
            <input type="date" class="form-control" name="birthdate" required>
        </div>
        <div class="input-group my-3">
            <input type="text" class="form-control" name="street_type" placeholder="Tipo di strada" required>
            <input type="text" class="form-control" name="street_name" placeholder="Nome della strada" required>
            <input type="number" class="form-control" name="street_number" placeholder="Numero Civico" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary my-3">Send Data</button>
        </div>
    </form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>