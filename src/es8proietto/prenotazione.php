<?php include_once "./headTemplate.php"?>
<!--print the error message if exists-->
<?php
    if(isset($_GET["error"])){
        echo "<div class='alert alert-danger text-center w-50 m-auto' role='alert'>".htmlspecialchars($_GET["error"])."</div>";
    }
?>
<form class="row g-3 text-center m-auto w-25" method="POST" action="gestioneprenotazione.php">
    <div class="col-md-6">
        <label for="inputName" class="form-label">Name</label>
        <input type="text" class="form-control" id="inputName" name="name">
    </div>
    <div class="col-md-6">
        <label for="inputSurname" class="form-label">Surname</label>
        <input type="text" class="form-control" id="inputSurname" name="surname">
    </div>
    <div class="col-md-12">
        <label for="inputTable" class="form-label">Table</label>
        <select class="form-select" id="inputTable" name="table">
            <option selected>Choose...</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div class="col-md-12">
        <label for="inputTime" class="form-label">Time</label>
        <input type="time" class="form-control" id="inputTime" name="time">
    </div>
    <div class="col-md-12">
        <label for="inputNotes" class="form-label">Notes</label>
        <textarea class="form-control" id="inputNotes" name="notes" rows="3"></textarea>
    </div>
    <div class="col-md-12">
        <label class="form-label">What meal would you like?</label>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="appetizer" name="appetizer" value="yes">
            <label class="form-check-label" for="appetizer">Appetizer</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="main" name="main" value="yes">
            <label class="form-check-label" for="main">Main course</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="second" name="second" value="yes">
            <label class="form-check-label" for="second">Second course</label>
        </div>
    </div>
    <div class="col-md-12">
        <label class="form-label">Parking option</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="parking" id="custodito" value="custodito">
            <label class="form-check-label" for="custodito">Custodito</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="parking" id="non_custodito" value="non_custodito">
            <label class="form-check-label" for="non_custodito">Non custodito</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="parking" id="no_parking" value="none">
            <label class="form-check-label" for="no_parking">No parking</label>
        </div>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Sign in</button>
    </div>
</form>
<?php include_once "./bottomTemplate.php"?>
