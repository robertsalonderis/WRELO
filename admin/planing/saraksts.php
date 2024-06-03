<?php
include '../../Connect_db.php';

// Handle POST request for creating a new checklist item
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kartis_id = $_POST['kartis_id'];
    $sar_teksts = $_POST['sar_teksts'];
    $ir_atzimets = $_POST['ir_atzimets'];

    $sql = "INSERT INTO Saraksts (kartis_id, sar_teksts, ir_atzimets) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isi', $kartis_id, $sar_teksts, $ir_atzimets);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "checklist_id" => $stmt->insert_id]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Handle GET request for retrieving checklist items
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $kartis_id = $_GET['kartis_id'];

    $sql = "SELECT * FROM Saraksts WHERE kartis_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $kartis_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $checklist = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(["status" => "success", "checklist" => $checklist]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
