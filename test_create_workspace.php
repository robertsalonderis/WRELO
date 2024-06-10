<?php
$data = [
    'name' => 'Test Workspace',
    'user_id' => 1
];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
    ],
];

$context  = stream_context_create($options);
$result = file_get_contents('https://kristovskis.lv/4pt/alonderis/WRELO/admin/planing/create_workspace.php', false, $context);

if ($result === FALSE) {
    /* Handle error */
}

var_dump($result);
?>
