<?php
    require('../../Connect_db.php');

    if(isset($_POST['id'])){
        $id = mysqli_real_escape_string($savienojums, $_POST['id']);
        $select_lietotajs_SQL = "SELECT * FROM wrelo_lietotaji WHERE lietotajs_id = $id";
        $select_lietotajs_result = mysqli_query($savienojums, $select_lietotajs_SQL);

        if(!$select_lietotajs_result){
            die("Kļūda!".mysqli_error($savienojums));
        }

        $json = array();
    
        while($row = mysqli_fetch_array($select_lietotajs_result)){
            $json[] = array(
                'id' => $row['lietotajs_id'],
                'lietotajvards' => $row['lietotajvards'],
                'vards' => $row['liet_vards'],
                'uzvards' => $row['liet_uzvards'],
                'epasts' => $row['liet_epasts'],
                'loma' => $row['lietotaja_loma'],
                'registrets' => $row['reg_sistema']
            );
        }

        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }
?>