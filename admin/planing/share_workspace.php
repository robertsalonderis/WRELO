<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../Connect_db.php');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit();
}

$workspace_id = $data['workspace_id'] ?? '';
$user_email = $data['user_email'] ?? '';

if (empty($workspace_id) || empty($user_email)) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit();
}

// Get user ID by email
$sql_user = "SELECT lietotajs_id FROM wrelo_lietotaji WHERE liet_epasts = ?";
$stmt_user = $savienojums->prepare($sql_user);
$stmt_user->bind_param('s', $user_email);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit();
}

$user_id = $result_user->fetch_assoc()['lietotajs_id'];

// Share workspace
$sql = "INSERT INTO shared_workspaces (workspace_id, user_id) VALUES (?, ?)";
$stmt = $savienojums->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $savienojums->error);
}

$stmt->bind_param('ii', $workspace_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error sharing workspace: ' . $stmt->error]);
}

$stmt->close();
$savienojums->close();
?>


