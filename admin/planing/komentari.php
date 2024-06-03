<?php
include '../../Connect_db.php';

// Handle POST request for creating a new comment
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kartis_id = $_POST['kartis_id'];
    $kom_teksts = $_POST['kom_teksts'];

    $sql = "INSERT INTO Komentari (kartis_id, kom_teksts) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $kartis_id, $kom_teksts);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "comment_id" => $stmt->insert_id]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Handle GET request for retrieving comments
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $kartis_id = $_GET['kartis_id'];

    $sql = "SELECT * FROM Komentari WHERE kartis_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $kartis_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(["status" => "success", "comments" => $comments]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
