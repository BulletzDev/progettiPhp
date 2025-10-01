<?php
include "headTemplate.php";
include "funzioni.php";
$numeri=[5,6,7,8,9];
$media=media($numeri);
echo "<h1>Calcolo della media di uno studente</h1>";
echo "<p>I voti sono: ".implode(", ",$numeri)."</p>";
echo "<p>La media è: ".$media."</p>";
echo "Lo studente è: ".stampaRisultato($media);
include "bottomTemplate.php";
?>