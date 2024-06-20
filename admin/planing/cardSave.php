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

    if (!isset($_POST['id'], $_POST['board_id'], $_POST['name'])) {
        throw new Exception('Missing required fields');
    }

    $cardId = $_POST['id'];
    $boardId = $_POST['board_id'];
    $cardName = $_POST['name'];
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $colorLabel = isset($_POST['color_label']) ? $_POST['color_label'] : '';
    $comments = isset($_POST['comments']) ? $_POST['comments'] : '';
    $fileAttachment = null;

    if (isset($_FILES['file_attachment']) && $_FILES['file_attachment']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../../uploads/"; // Ensure this path is correct and writable
        $fileName = basename($_FILES['file_attachment']['name']);
        $targetFile = $targetDir . $fileName;

        // Validate file type and size
        $validFileTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($_FILES['file_attachment']['type'], $validFileTypes)) {
            throw new Exception('Invalid file type. Only JPEG, PNG, and PDF are allowed.');
        }

        if ($_FILES['file_attachment']['size'] > $maxFileSize) {
            throw new Exception('File size exceeds the 2MB limit.');
        }

        if (!move_uploaded_file($_FILES['file_attachment']['tmp_name'], $targetFile)) {
            throw new Exception('Failed to upload file.');
        }

        $fileAttachment = $targetFile;
    }

    // Log data before executing the query
    error_log("Updating card with data: cardId=$cardId, boardId=$boardId, cardName=$cardName, description=$description, colorLabel=$colorLabel, comments=$comments, fileAttachment=$fileAttachment");

    // Prepare and bind the SQL statement
    $query = "UPDATE cards SET name=?, description=?, color_label=?, comments=?, file_attachment=? WHERE id=? AND board_id=?";
    $stmt = $savienojums->prepare($query);

    if ($fileAttachment) {
        $stmt->bind_param("ssssssi", $cardName, $description, $colorLabel, $comments, $fileAttachment, $cardId, $boardId);
    } else {
        $query = "UPDATE cards SET name=?, description=?, color_label=?, comments=? WHERE id=? AND board_id=?";
        $stmt = $savienojums->prepare($query);
        $stmt->bind_param("sssssi", $cardName, $description, $colorLabel, $comments, $cardId, $boardId);
    }

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Card updated successfully';
        if ($fileAttachment) {
            $response['file_attachment'] = $fileAttachment;
        }
    } else {
        throw new Exception('Failed to save card: ' . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    $response['message'] = $e->getMessage();
}

$savienojums->close();
echo json_encode($response);
?>












