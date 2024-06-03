<?php
include '../../Connect_db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM Kartis WHERE kartis_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $card = $result->fetch_assoc();
        echo json_encode($card);
    } else {
        echo json_encode([]);
    }
}
?>
