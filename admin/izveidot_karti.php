<?php
require '../Connect_db.php';

$deli_id = $_POST['deli_id'];
$apraksts = $_POST['apraksts'];
$krasu_etikete = $_POST['krasu_etikete'];

$sql = "INSERT INTO Kartis (deli_id, apraksts, krasu_etikete) VALUES (?, ?, ?)";
$stmt = $savienojums->prepare($sql);

if ($stmt === false) {
    echo json_encode(["status" => "error", "message" => "Database prepare error: " . $savienojums->error]);
    $savienojums->close();
    exit();
}

$stmt->bind_param("iss", $deli_id, $apraksts, $krasu_etikete);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "kartis_id" => $savienojums->insert_id]);
} else {
    echo json_encode(["status" => "error", "message" => "Database execute error: " . $stmt->error]);
}

$stmt->close();
$savienojums->close();
?>








