<?php
session_start();
session_unset();
session_destroy();
header('Location: ../es21proietto/index.php');
exit;
