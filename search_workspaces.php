<?php
session_start();
require 'Connect_db.php';

$response = array();

if (!isset($_SESSION['user_id'])) {
    echo json_encode($response);
    exit();
}

$user_id = $_SESSION['user_id'];
$search_term = $_GET['query'] ?? '';

if (!empty($search_term)) {
    $search_term = "%$search_term%";
    $query = "SELECT * FROM workspaces WHERE user_id = ? AND name LIKE ?";
    $stmt = $savienojums->prepare($query);
    $stmt->bind_param("is", $user_id, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }

    $stmt->close();
}

$savienojums->close();
echo json_encode($response);
?>
