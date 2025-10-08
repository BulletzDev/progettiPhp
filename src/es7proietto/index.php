<?php include "./headTemplate.php"; ?>
    <form class="row g-3 text-center m-auto w-25" method="GET" action="riepilogo.php">
  <div class="col-md-6">
    <label for="inputName" class="form-label">Name</label>
    <input type="text" class="form-control" name="name">
  </div>
    <div class="col-md-6">
    <label for="inputName" class="form-label">Surname</label>
    <input type="text" class="form-control" name="surname">
  </div>
    <div class="col-md">
    <label for="inputEmail" class="form-label">Email</label>
    <input type="email" class="form-control" name="email">
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Sign in</button>
  </div>
</form>
<?php include "bottomTemplate.php"; ?>