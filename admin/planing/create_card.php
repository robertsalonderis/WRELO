<?php
require('../../Connect_db.php');


$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
$board_id = $data['board_id'];
$description = $data['description'];

$sql = "INSERT INTO cards (board_id, name, description) VALUES (?, ?, ?)";
$stmt = $savienojums->prepare($sql);
$stmt->bind_param('iss', $board_id, $name, $description);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'card_id' => $stmt->insert_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error creating card']);
}
$stmt->close();
$savienojums->close();
?>
