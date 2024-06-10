<?php
require '../Connect_db.php';

$kartis_id = $_POST['kartis_id'];
$apraksts = $_POST['apraksts'];
$krasu_etikete = $_POST['krasu_etikete'];
$file_attachment = $_FILES['fails']['name'];
$comments = $_POST['komentari'];
$checklist = $_POST['saraksts'];

// Handle file upload if necessary
if ($file_attachment) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($file_attachment);
    move_uploaded_file($_FILES["fails"]["tmp_name"], $target_file);
}

$sql = "UPDATE Kartis SET apraksts = ?, krasu_etikete = ?, file_attachment = ?, comments = ?, checklist = ? WHERE kartis_id = ?";
$stmt = $savienojums->prepare($sql);

if ($stmt === false) {
    echo json_encode(["status" => "error", "message" => "Database prepare error: " . $savienojums->error]);
    $savienojums->close();
    exit();
}

$stmt->bind_param("sssssi", $apraksts, $krasu_etikete, $file_attachment, $comments, $checklist, $kartis_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database execute error: " . $stmt->error]);
}

$stmt->close();
$savienojums->close();
?>





