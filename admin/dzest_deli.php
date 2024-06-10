<?php
require '../Connect_db.php';

$deli_id = $_POST['deli_id'];

if ($deli_id) {
    // Delete all cards within the board
    $sql = "DELETE FROM Kartis WHERE deli_id = ?";
    $stmt = $savienojums->prepare($sql);
    $stmt->bind_param("i", $deli_id);
    $stmt->execute();

    // Delete the board itself
    $sql = "DELETE FROM Deli WHERE deli_id = ?";
    $stmt = $savienojums->prepare($sql);
    $stmt->bind_param("i", $deli_id);
    $stmt->execute();

    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Missing board ID."]);
}
?>
