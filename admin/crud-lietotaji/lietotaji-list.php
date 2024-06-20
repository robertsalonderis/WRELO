<?php
require('../../Connect_db.php');

$select_lietotaji_SQL = "SELECT * FROM wrelo_lietotaji WHERE statuss != 'dzēsts' ORDER BY lietotajs_id";
$select_lietotaji_result = mysqli_query($savienojums, $select_lietotaji_SQL);

if(!$select_lietotaji_result){
    die("Kļūda!".mysqli_error($savienojums));
}

$json = []; // Initialize an array to store the fetched data

while($row = mysqli_fetch_assoc($select_lietotaji_result)){
    // Push each row into the $json array with the desired keys
    $json[] = array(
        'id' => $row['lietotajs_id'],
        'lietotajvards' => $row['lietotajvards'],
        'vards' => $row['liet_vards'],
        'uzvards' => $row['liet_uzvards'],
        'epasts' => $row['liet_epasts'],
        'loma' => $row['lietotaja_loma'],
        'registrets' => $row['reg_sistema'],
        'statuss' => $row['statuss']
    );
}

// Encode the $json array to JSON format and send it as a response
echo json_encode($json);
?>

