<?php
$servera_vards = "localhost";
$lietotajvards = "grobina1_alonderis";
$parole = "6!UdKnKF3";
$db_nosaukums = "grobina1_alonderis";

$savienojums = mysqli_connect($servera_vards, $lietotajvards, $parole, $db_nosaukums);

if (!$savienojums) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
