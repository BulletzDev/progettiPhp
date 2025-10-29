<?php include "./headTemplate.php"; 
session_start();
if (isset($_SESSION["utente"])) {
    echo "<h1 class='text-center'>Benvenuto ".$_SESSION["utente"]."!</h1>";
} else {
    header('Location: ./login.php?errorSess=notloggedin');
    exit;
}   

if (isset($_POST["logout"])) {
    session_destroy();
    header('Location: ./login.php');
    exit;
}
?>
<form method="post" style="display:inline">
    <button required type="submit" name="logout" value="1" class="btn btn-dark my-3">Logout</button>
</form>
<?php include "./bottomTemplate.php"; ?>