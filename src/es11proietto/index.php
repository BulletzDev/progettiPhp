<?php include "./headTemplate.php"; 
session_start();
$user = [
    "paolo" => "1234",
    "carlo" => "5678",
];

if(isset($_POST["username"]) && isset($_POST["password"])){
    foreach($user as $k => $v){
        if($k == $_POST["username"] && $v == $_POST["password"]){
            $_SESSION["username"]= $k;
            header('Location: ./order.php');
            exit;
        }
    }
    echo "<div class='alert alert-danger w-25 mx-auto text-center' role='alert'>Credenziali non valide!</div>";
}

if(isset($_POST["errorSess"])){
    echo "<div class='alert alert-warning w-25 mx-auto text-center' role='alert'>Devi effettuare il login per accedere alla pagina richiesta.</div>";
}

?>

<div class="input mb-3 w-25 mx-auto">
<form method="post" style="display:inline">
    <input required type="text" class="form-control my-3" placeholder="Username" name="username">
    <input required type="password" class="form-control my-3" placeholder="Password" name="password">
    <button required type="submit" value="1" class="btn btn-dark my-3">Login</button>
</form>
</div>
</div>

<?php include "./bottomTemplate.php"; ?>