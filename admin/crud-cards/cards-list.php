<?php
include '../../Connect_db.php';

$sql = "SELECT * FROM Kartis";
$result = $conn->query($sql);
$cards = [];

while ($row = $result->fetch_assoc()) {
    $cards[] = $row;
}

echo json_encode($cards);
?>
