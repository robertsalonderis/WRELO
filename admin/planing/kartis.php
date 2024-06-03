<?php
include '../../Connect_db.php';

// Handle POST request for creating a new card
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deli_id = $_POST['deli_id'];
    $apraksts = $_POST['apraksts'];
    $krasu_etikete = $_POST['krasu_etikete'];

    $sql = "INSERT INTO Kartis (deli_id, apraksts, krasu_etikete) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iss', $deli_id, $apraksts, $krasu_etikete);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "card_id" => $stmt->insert_id]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Handle GET request for retrieving cards
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $deli_id = $_GET['deli_id'];

    $sql = "SELECT * FROM Kartis WHERE deli_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $deli_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $cards = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(["status" => "success", "cards" => $cards]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
