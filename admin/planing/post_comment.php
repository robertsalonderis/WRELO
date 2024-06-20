<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../../php-error.log'); // Ensure this path is correct
error_reporting(E_ALL);

require '../../Connect_db.php'; // Correct path to your database connection file

header('Content-Type: application/json');

$response = array('success' => false, 'message' => 'Unknown error');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    if (!isset($_POST['card_id'], $_POST['user_id'], $_POST['comment'])) {
        throw new Exception('Missing required fields');
    }

    $cardId = $_POST['card_id'];
    $userId = $_POST['user_id'];
    $comment = $_POST['comment'];

    // Insert comment into the card_comments table
    $query = "INSERT INTO card_comments (card_id, user_id, comment) VALUES (?, ?, ?)";
    $stmt = $savienojums->prepare($query);
    $stmt->bind_param("iis", $cardId, $userId, $comment);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Comment posted successfully';

        // Get the username of the user who posted the comment
        $query = "SELECT username FROM users WHERE id=?";
        $stmt = $savienojums->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();

        $response['username'] = $username;
    } else {
        throw new Exception('Failed to post comment: ' . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    $response['message'] = $e->getMessage();
}

$savienojums->close();
echo json_encode($response);
?>


