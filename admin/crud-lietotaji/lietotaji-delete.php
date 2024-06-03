<?php
require('../../Connect_db.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];


    // Example: Soft delete (change status to "dzēsts")
    $update_status_SQL = "UPDATE wrelo_lietotaji SET statuss = 'dzēsts' WHERE lietotajs_id = $id";
    $update_status_result = mysqli_query($savienojums, $update_status_SQL);

    if (!$update_status_result) {
        die("Kļūda!" . mysqli_error($savienojums));
    }

    echo "Lietotājs atzīmēts kā dzēsts!";
}
?>
