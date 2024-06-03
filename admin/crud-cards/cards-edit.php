<?php
include '../../Connect_db.php';

if ($_POST) {
    $id = $_POST['kartis_id'];
    $apraksts = $_POST['apraksts'];
    $krasu_etikete = $_POST['krasu_etikete'];

    $sql = "UPDATE Kartis SET apraksts = '$apraksts', krasu_etikete = '$krasu_etikete' WHERE kartis_id = $id";
    $result = $conn->query($sql);

    echo json_encode(["status" => $result ? "success" : "error"]);
}
?>
