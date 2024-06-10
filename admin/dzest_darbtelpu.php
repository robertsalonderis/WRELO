<?php
require '../Connect_db.php';

$darbtelpa_id = $_POST['darbtelpa_id'];

if ($darbtelpa_id) {
    // Delete all boards and their cards within the workspace
    $sql = "DELETE FROM Kartis WHERE deli_id IN (SELECT deli_id FROM Deli WHERE darbtelpa_id = ?)";
    $stmt = $savienojums->prepare($sql);
    $stmt->bind_param("i", $darbtelpa_id);
    $stmt->execute();

    $sql = "DELETE FROM Deli WHERE darbtelpa_id = ?";
    $stmt = $savienojums->prepare($sql);
    $stmt->bind_param("i", $darbtelpa_id);
    $stmt->execute();

    // Delete the workspace itself
    $sql = "DELETE FROM Darbtelpas WHERE darbtelpa_id = ?";
    $stmt = $savienojums->prepare($sql);
    $stmt->bind_param("i", $darbtelpa_id);
    $stmt->execute();

    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Missing workspace ID."]);
}
?>
