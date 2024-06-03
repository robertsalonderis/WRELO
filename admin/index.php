<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WRELO | Administrēšana</title>
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="admin-style.css">
    <script src="../script.js" defer></script>

    <style>
        .box-container2 {
            display: flex;
            justify-content: space-between;
        }

        .column {
            width: 48%;
        }

        th.table-title {
            text-align: center;
            text-transform: uppercase;
            width: 50%;
        }
    </style>
</head>
<body>

<?php
    require("../Connect_db.php");
    require("navigation.php");
?>

<?php

// Check if the user is logged in
if (isset($_SESSION['lietotajvards_LYXQT'])) {
    $Lietotajvards = $_SESSION['lietotajvards_LYXQT'];

    // Fetch user role from the database
    $sql = "SELECT lietotaja_loma FROM wrelo_lietotaji WHERE lietotajvards = '$Lietotajvards'";
    $result = mysqli_query($savienojums, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $Loma = $row["lietotaja_loma"];
    }

}
?>

<div class="title">
    <div class="name">
        <i class="fas fa-tachometer-alt"></i> Sākumlapa
    </div>
</div>

<section class="info-container">
    <div class="box">
        <div class="info">
            <h3>Sveicināti!<!--<php echo htmlspecialchars($Lietotajvards)?>--></h3>
            <!--<p>Tava loma sistēmā: <php echo htmlspecialchars($Loma)?></p>-->
        </div>
    </div>
</section>

</body>
</html>
