<?php
require('../../Connect_db.php');

$user_id = $_GET['user_id'];

$sql = "SELECT id, name FROM workspaces WHERE user_id = ?";
$stmt = $savienojums->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$workspaces = [];
while ($row = $result->fetch_assoc()) {
    $workspaces[] = $row;
}

echo json_encode($workspaces);

$stmt->close();
$savienojums->close();
?>


