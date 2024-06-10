<?php
require('../../Connect_db.php');


$id = $_POST['id'];
$board_id = $_POST['board_id'];
$description = $_POST['description'];
$color_label = $_POST['color_label'];
$comments = $_POST['comments'];
$checklist = $_POST['checklist'];

$upload_dir = '../../uploads/';
$file_attachment = '';

if (isset($_FILES['file_attachment']) && $_FILES['file_attachment']['error'] == UPLOAD_ERR_OK) {
    $file_attachment = $_FILES['file_attachment']['name'];
    $uploaded_file = $upload_dir . basename($file_attachment);
    move_uploaded_file($_FILES['file_attachment']['tmp_name'], $uploaded_file);
}

$sql = "UPDATE cards SET description = ?, color_label = ?, comments = ?, file_attachment = ?, checklist = ? WHERE id = ? AND board_id = ?";
$stmt = $savienojums->prepare($sql);
$stmt->bind_param('sssssii', $description, $color_label, $comments, $file_attachment, $checklist, $id, $board_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating card']);
}
$stmt->close();
$savienojums->close();
?>
