<?php include "./headTemplate.php"; ?>

<?php
    if(isset($_GET["error"])){
        echo "<div class='alert alert-danger text-center w-50 m-auto' role='alert'>".htmlspecialchars($_GET["error"])."</div>";
    }
?>

<form class="row g-3 text-center m-auto w-25" method="POST" action="invioDati.php">
    <div class="col-md-6">
        <label for="inputName" class="form-label">Name</label>
        <input type="text" class="form-control" id="inputName" name="name">
    </div>
    <div class="col-md-6">
        <label for="inputSurname" class="form-label">Surname</label>
        <input type="text" class="form-control" id="inputSurname" name="surname">
    </div>
    <div class="col-12">
        <label for="inputEmail" class="form-label">Email</label>
        <input type="email" class="form-control" id="inputEmail" name="email">
    </div>
    <div class="col-12">
        <label for="inputMessage" class="form-label">Message</label>
        <textarea class="form-control" id="inputMessage" name="message" rows="3"></textarea>
    </div>
    <div class="col-12 mt-3 ">
        <button type="submit" class="btn btn-primary">Sign in</button>
    </div>
</form>

<?php include "./bottomTemplate.php"; ?>