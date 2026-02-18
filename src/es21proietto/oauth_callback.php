<?php
session_start();

$config = include __DIR__ . '/oauth_config.php';

if (empty($config['client_id']) || empty($config['client_secret']) || empty($config['redirect_uri'])) {
    echo "OAuth not configured. Fill oauth_config.php with your client ID/secret.";
    exit;
}

if (!isset($_GET['state']) || !isset($_SESSION['oauth2state']) || $_GET['state'] !== $_SESSION['oauth2state']) {
    unset($_SESSION['oauth2state']);
    echo "Invalid OAuth state.";
    exit;
}

if (!isset($_GET['code'])) {
    echo "Authorization code not provided.";
    exit;
}

$code = $_GET['code'];

$token_url = 'https://oauth2.googleapis.com/token';
$post_fields = [
    'code' => $code,
    'client_id' => $config['client_id'],
    'client_secret' => $config['client_secret'],
    'redirect_uri' => $config['redirect_uri'],
    'grant_type' => 'authorization_code'
];

$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
$response = curl_exec($ch);
if ($response === false) {
    echo "Failed to exchange code: " . curl_error($ch);
    exit;
}
curl_close($ch);

$token = json_decode($response, true);
if (empty($token['id_token'])) {
    echo "No id_token returned.";
    exit;
}

$id_token = $token['id_token'];

// Validate the id_token using Google's tokeninfo endpoint
$info = @file_get_contents('https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($id_token));
if ($info === false) {
    echo "Failed to validate id_token.";
    exit;
}

$info = json_decode($info, true);
if (empty($info) || !isset($info['aud']) || $info['aud'] !== $config['client_id']) {
    echo "Invalid id_token.";
    exit;
}

$email = $info['email'] ?? null;
$name = $info['name'] ?? $email;

if (!$email) {
    echo "Email not available in token.";
    exit;
}

session_regenerate_id(true);
$_SESSION['username'] = $email;
$_SESSION['state'] = 'LOGGED_IN';

header('Location: ../es14proietto/custList.php');
exit;
