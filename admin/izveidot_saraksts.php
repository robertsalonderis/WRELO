<?php
require '../Connect_db.php';

$kartis_id = $_POST['kartis_id'];
$sar_teksts = $_POST['sar_teksts'];
$ir_atzimets = $_POST['ir_atzimets'];

// Prepare the SQL statement
$sql = "INSERT INTO Saraksts (kartis_id, sar_teksts, ir_atzimets) VALUES (?, ?, ?)";
$stmt = $savienojums->prepare($sql);

if ($stmt === false) {
    error_log('MySQL prepare error: ' . $savienojums->error);
    echo json_encode(["status" => "error", "message" => "Database prepare error: " . $savienojums->error]);
    $savienojums->close();
    exit();
}

// Bind parameters
$stmt->bind_param("isi", $kartis_id, $sar_teksts, $ir_atzimets);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "saraksts_id" => $savienojums->insert_id]);
} else {
    error_log('MySQL execute error: ' . $stmt->error);
    echo json_encode(["status" => "error", "message" => "Database execute error: " . $stmt->error]);
}

$stmt->close();
$savienojums->close();
?>
