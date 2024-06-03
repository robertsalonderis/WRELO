<?php
include '../../Connect_db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM Kartis WHERE kartis_id = $id";
    $result = $conn->query($sql);

    echo json_encode(["status" => $result ? "success" : "error"]);
}
?>
