<?php
require '../Connect_db.php';

$darbtelpa_id = $_POST['darbtelpa_id'];
$nosaukums = $_POST['nosaukums'];
$bg_krasa = $_POST['bg_krasa'];

$sql = "INSERT INTO Deli (darbtelpa_id, nosaukums, bg_krasa) VALUES (?, ?, ?)";
$stmt = $savienojums->prepare($sql);

if ($stmt === false) {
    echo json_encode(["status" => "error", "message" => "Database prepare error: " . $savienojums->error]);
    $savienojums->close();
    exit();
}

$stmt->bind_param("iss", $darbtelpa_id, $nosaukums, $bg_krasa);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "deli_id" => $savienojums->insert_id]);
} else {
    echo json_encode(["status" => "error", "message" => "Database execute error: " . $stmt->error]);
}

$stmt->close();
$savienojums->close();
?>








