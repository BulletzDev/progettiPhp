<?php
session_start();

$plainUsers = [
    "paolo" => "1234",
    "carlo" => "5678",
    "gianni" => "gianni1"
];

$users = [];
foreach ($plainUsers as $k => $v) {
    $users[$k] = password_hash($v, PASSWORD_DEFAULT);
}

if (isset($_SESSION["state"]) && $_SESSION["state"] == "LOGGED_IN") {
    header('Location: ../es14proietto/custList.php');
    exit;
}

$login_error = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (isset($users[$username]) && password_verify($password, $users[$username])) {
        session_regenerate_id(true);
        $_SESSION["username"] = $username;
        $_SESSION["state"] = "LOGGED_IN";
        header('Location: ../es14proietto/custList.php');
        exit;
    }
    $login_error = true;
}

include 'headTemplate.php';
?>

<?php
// Prepare Google OAuth2 link
$oauth = include __DIR__ . '/oauth_config.php';
if (!empty($oauth['client_id']) && !empty($oauth['redirect_uri'])) {
    $state = bin2hex(random_bytes(12));
    $_SESSION['oauth2state'] = $state;
    $auth_params = [
        'client_id' => $oauth['client_id'],
        'redirect_uri' => $oauth['redirect_uri'],
        'response_type' => 'code',
        'scope' => 'openid email profile',
        'state' => $state,
        'prompt' => 'select_account'
    ];
    $googleAuthUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($auth_params);
} else {
    $googleAuthUrl = '#';
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

<div class="text-center mt-3">
    <a class="btn btn-danger" href="<?php echo htmlspecialchars($googleAuthUrl); ?>">Sign in with Google</a>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>    
</body>
</html>
<?php include 'bottomTemplate.php' ?>
