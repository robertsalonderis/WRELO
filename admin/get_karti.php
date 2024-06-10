<?php
require '../Connect_db.php';

$kartis_id = $_GET['kartis_id'] ?? null;

if ($kartis_id === null) {
    echo json_encode(["status" => "error", "message" => "Missing required field."]);
    exit();
}

$sql = "SELECT * FROM Kartis WHERE kartis_id = ?";
$stmt = $savienojums->prepare($sql);

if ($stmt === false) {
    echo json_encode(["status" => "error", "message" => "Database prepare error: " . $savienojums->error]);
    exit();
}

$stmt->bind_param("i", $kartis_id);
$stmt->execute();
$result = $stmt->get_result();
$card = $result->fetch_assoc();

echo json_encode(["status" => "success", "card" => $card]);

$stmt->close();
$savienojums->close();
?>
