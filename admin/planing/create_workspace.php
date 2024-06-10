<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../../Connect_db.php');

// Check if the connection was successful
if (!$savienojums) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Retrieve and decode the JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Debugging: Log the received input
file_put_contents('php://stderr', print_r($data, true));

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit();
}

// Extract data
$name = $data['name'] ?? '';
$user_id = $data['user_id'] ?? '';

if (empty($name) || empty($user_id)) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit();
}

// Prepare the SQL statement
$sql = "INSERT INTO workspaces (user_id, name) VALUES (?, ?)";
$stmt = $savienojums->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $savienojums->error);
}

// Bind parameters and execute
$stmt->bind_param('is', $user_id, $name);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'workspace_id' => $stmt->insert_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error creating workspace: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$savienojums->close();
?>


