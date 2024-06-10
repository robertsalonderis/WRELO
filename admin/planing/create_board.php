<?php
require('../../Connect_db.php');

$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
$background_color = $data['background_color'];
$workspace_id = $data['workspace_id'];

$sql = "INSERT INTO boards (workspace_id, name, background_color) VALUES (?, ?, ?)";
$stmt = $savienojums->prepare($sql);
$stmt->bind_param('iss', $workspace_id, $name, $background_color);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'board_id' => $stmt->insert_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error creating board']);
}
$stmt->close();
$savienojums->close();
?>
