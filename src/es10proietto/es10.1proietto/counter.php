<?php include("./headTemplate.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if (!isset($_SESSION["contatore"])) {
    $_SESSION["contatore"] = 1;
}else{
    $_SESSION["contatore"] += 1;
}
?>

<p>“Hai visitato questa pagina <?php echo $_SESSION["contatore"] ?> volte durante questa sessione.”</p>
<form method="post" style="display:inline">
    <button type="submit" value="1" class="btn btn-dark">Aggiorna pagina</button>
    <button type="submit" name="reset" value="1" class="btn btn-dark">Azzera sessione</button>
</form>

<?php 
include("./bottomTemplate.php");
?>