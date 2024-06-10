<?php
require '../Connect_db.php';

$lietotajs_id = $_GET['lietotajs_id'] ?? null;

if ($lietotajs_id === null) {
    echo json_encode([]);
    exit();
}

// Fetch workspaces for the user
$sql = "SELECT * FROM Darbtelpas WHERE lietotajs_id = ?";
$stmt = $savienojums->prepare($sql);
$stmt->bind_param("i", $lietotajs_id);
$stmt->execute();
$result = $stmt->get_result();
$workspaces = $result->fetch_all(MYSQLI_ASSOC);

foreach ($workspaces as &$workspace) {
    // Fetch boards for each workspace
    $sql = "SELECT * FROM Deli WHERE darbtelpa_id = ?";
    $stmt = $savienojums->prepare($sql);
    $stmt->bind_param("i", $workspace['darbtelpa_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $boards = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($boards as &$board) {
        // Fetch cards for each board
        $sql = "SELECT * FROM Kartis WHERE deli_id = ?";
        $stmt = $savienojums->prepare($sql);
        $stmt->bind_param("i", $board['deli_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $cards = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($cards as &$card) {
            // Fetch checklist items for each card
            $sql = "SELECT * FROM Saraksts WHERE kartis_id = ?";
            $stmt = $savienojums->prepare($sql);
            $stmt->bind_param("i", $card['kartis_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $card['checklist'] = $result->fetch_all(MYSQLI_ASSOC);
        }

        $board['cards'] = $cards;
    }

    $workspace['boards'] = $boards;
}

echo json_encode($workspaces);

$stmt->close();
$savienojums->close();
?>





