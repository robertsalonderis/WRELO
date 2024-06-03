<?php
require('../../Connect_db.php');

if(isset($_POST['lietotajiID'])) {
    $id = $_POST['lietotajiID'];
    $lietotajvards = $_POST['lietotajvards'];
    $vards = $_POST['vards'];
    $uzvards = $_POST['uzvards'];
    $epasts = $_POST['epasts'];
    $loma = $_POST['loma'];
    $password = $_POST['parole'];
    $confirm_password = $_POST['confirm_password']; // This should be passed from the form

    // Check if the password and confirm password match
    if (!empty($password) && ($password === $confirm_password)) {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement to update the user with the new password
        $stmt = $savienojums->prepare("UPDATE wrelo_lietotaji SET lietotajvards = ?, liet_vards = ?, liet_uzvards = ?, liet_epasts = ?, lietotaja_loma = ?, parole = ? WHERE lietotajs_id = ?");
        $stmt->bind_param("ssssssi", $lietotajvards, $vards, $uzvards, $epasts, $loma, $hashed_password, $id);
    } else {
        // If passwords do not match or password is empty, prepare the SQL statement without updating the password
        $stmt = $savienojums->prepare("UPDATE wrelo_lietotaji SET lietotajvards = ?, liet_vards = ?, liet_uzvards = ?, liet_epasts = ?, lietotaja_loma = ? WHERE lietotajs_id = ?");
        $stmt->bind_param("sssssi", $lietotajvards, $vards, $uzvards, $epasts, $loma, $id);
    }

    // Execute the prepared statement
    $update_lietotaji_result = $stmt->execute();

    if(!$update_lietotaji_result) {
        die("Kļūda!".mysqli_error($savienojums));
    }

    echo "Lietotājs rediģēts!";
    $stmt->close();
} else {
    echo "Nepieciešams lietotāja ID!";
}
?>
