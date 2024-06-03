<?php
include '../../Connect_db.php';

// Handle POST request for creating a new board
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lietotajs_id = $_POST['lietotajs_id'];
    $nosaukums = $_POST['nosaukums'];
    $bg_krasa = $_POST['bg_krasa'];

    $sql = "INSERT INTO Deli (lietotajs_id, nosaukums, bg_krasa) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iss', $lietotajs_id, $nosaukums, $bg_krasa);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "board_id" => $stmt->insert_id]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Handle GET request for retrieving boards
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $lietotajs_id = $_GET['lietotajs_id'];

    $sql = "SELECT * FROM Deli WHERE lietotajs_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $lietotajs_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $boards = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(["status" => "success", "boards" => $boards]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
