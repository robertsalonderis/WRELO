<?php
require '../Connect_db.php';

$kartis_id = $_POST['kartis_id'];

if ($kartis_id) {
    // Delete the card itself
    $sql = "DELETE FROM Kartis WHERE kartis_id = ?";
    $stmt = $savienojums->prepare($sql);
    $stmt->bind_param("i", $kartis_id);
    $stmt->execute();

    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Missing card ID."]);
}
?>
