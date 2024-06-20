<?php
require '../../Connect_db.php';

header('Content-Type: application/json');

$response = array();

try {
    $query = "SELECT lietotajs_id AS id, lietotajvards AS username FROM wrelo_lietotaji";
    $result = mysqli_query($savienojums, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }
    } else {
        throw new Exception("Failed to fetch users: " . mysqli_error($savienojums));
    }
} catch (Exception $e) {
    $response = array('error' => $e->getMessage());
}

mysqli_close($savienojums);
echo json_encode($response);
?>






