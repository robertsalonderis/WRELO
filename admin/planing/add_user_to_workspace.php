<?php
require '../../Connect_db.php';

header('Content-Type: application/json');

$response = array('success' => false, 'message' => 'Unknown error');

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['workspace_id'], $data['user_id'])) {
        throw new Exception('Missing required fields');
    }

    $workspaceId = $data['workspace_id'];
    $userId = $data['user_id'];

    $query = "INSERT INTO shared_workspaces (workspace_id, user_id) VALUES (?, ?)";
    $stmt = $savienojums->prepare($query);
    $stmt->bind_param("ii", $workspaceId, $userId);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'User added to workspace successfully';
    } else {
        throw new Exception('Failed to add user to workspace: ' . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

$savienojums->close();
echo json_encode($response);
?>






