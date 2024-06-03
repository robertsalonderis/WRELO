<?php
include '../../Connect_db.php';

if ($_POST) {
    $apraksts = $_POST['apraksts'];
    $krasu_etikete = $_POST['krasu_etikete'];

    $sql = "INSERT INTO Kartis (apraksts, krasu_etikete) VALUES ('$apraksts', '$krasu_etikete')";
    $result = $conn->query($sql);

    echo json_encode(["status" => $result ? "success" : "error"]);
}
?>
