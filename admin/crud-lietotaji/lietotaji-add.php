<?php
require('../../Connect_db.php');

if (isset($_POST['lietotajvards']) && isset($_POST['parole']) && isset($_POST['loma'])) {
    $lietotajvards = $_POST['lietotajvards'];

    // Pārbaude, vai lietotājvārds jau eksistē
    $check_username_SQL = "SELECT lietotajvards FROM wrelo_lietotaji WHERE lietotajvards = '$lietotajvards'";
    $check_username_result = mysqli_query($savienojums, $check_username_SQL);

    if (!$check_username_result) {
        die("Kļūda!".mysqli_error($savienojums));
    }

    if (mysqli_num_rows($check_username_result) > 0) {
        // Lietotājvārds jau eksistē, veiciet atbilstošas darbības (piemēram, izvadiet kļūdas ziņojumu)
        echo "Lietotājvārds jau eksistē!";
    } else {
        // Lietotājvārds ir unikāls, veiciet ievadīt
        $vards = mysqli_real_escape_string($savienojums, $_POST['vards']);
        $uzvards = mysqli_real_escape_string($savienojums, $_POST['uzvards']);
        $epasts = mysqli_real_escape_string($savienojums, $_POST['epasts']);
        $plain_password = mysqli_real_escape_string($savienojums, $_POST['parole']);
        $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT); // Hash the password
        $loma = mysqli_real_escape_string($savienojums, $_POST['loma']);

        $insert_lietotajs_SQL = "INSERT INTO wrelo_lietotaji (lietotajvards, liet_vards, liet_uzvards, liet_epasts, parole, lietotaja_loma) VALUES ('$lietotajvards', '$vards', '$uzvards', '$epasts', '$hashed_password', '$loma')";

        $insert_result = mysqli_query($savienojums, $insert_lietotajs_SQL);

        if (!$insert_result) {
            die("Kļūda!".mysqli_error($savienojums));
        }

        echo "Lietotājs pievienots!";
    }
}


?>

