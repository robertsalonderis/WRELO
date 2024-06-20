<?php
require('../../Connect_db.php');

$workspace_id = $_GET['workspace_id'];

$sql = "SELECT id, name, background_color FROM boards WHERE workspace_id = ?";
$stmt = $savienojums->prepare($sql);
$stmt->bind_param('i', $workspace_id);
$stmt->execute();
$result = $stmt->get_result();

$boards = [];
while ($row = $result->fetch_assoc()) {
    $board_id = $row['id'];
    $row['cards'] = [];

    $card_sql = "SELECT id, name, description FROM cards WHERE board_id = ?";
    $card_stmt = $savienojums->prepare($card_sql);
    $card_stmt->bind_param('i', $board_id);
    $card_stmt->execute();
    $card_result = $card_stmt->get_result();

    while ($card_row = $card_result->fetch_assoc()) {
        $row['cards'][] = $card_row;
    }

    $boards[] = $row;
    $card_stmt->close();
}

echo json_encode($boards);

$stmt->close();
$savienojums->close();
?>

