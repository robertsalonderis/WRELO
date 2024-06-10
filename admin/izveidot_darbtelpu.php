<?php
require '../Connect_db.php';

$lietotajs_id = $_POST['lietotajs_id'] ?? null;
$nosaukums = $_POST['nosaukums'] ?? null;

if ($lietotajs_id === null || $nosaukums === null) {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
    exit();
}

$sql = "INSERT INTO Darbtelpas (lietotajs_id, nosaukums) VALUES (?, ?)";
$stmt = $savienojums->prepare($sql);

if ($stmt === false) {
    echo json_encode(["status" => "error", "message" => "Database prepare error: " . $savienojums->error]);
    $savienojums->close();
    exit();
}

$stmt->bind_param("is", $lietotajs_id, $nosaukums);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "darbtelpa_id" => $savienojums->insert_id]);
} else {
    echo json_encode(["status" => "error", "message" => "Database execute error: " . $stmt->error]);
}

$stmt->close();
$savienojums->close();
?>












