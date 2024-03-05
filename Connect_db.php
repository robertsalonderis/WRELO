<?php
$servera_vards = "localhost";
$lietotajvards = "root"; // The default username in XAMPP
$parole = ""; // The default password in XAMPP
$db_nosaukums = "wrelo_db"; // Replace with the name of your database

// Create a connection
$savienojums = mysqli_connect($servera_vards, $lietotajvards, $parole, $db_nosaukums);

//Check the connection
// if ($savienojums->connect_error) {
//  die("Connection failed: " . $savienojums->connect_error);
// } else {
//   echo "Veiksmīgi";
// }

// Perform database operations here

// Close the connection
?>