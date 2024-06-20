<?php
session_start();
require("../Connect_db.php");

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user information from database
$query = "SELECT * FROM wrelo_lietotaji WHERE lietotajs_id = ?";
$stmt = $savienojums->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    // Handle case where user is not found
    echo "User not found.";
    exit();
}

// Fetch counts of workspaces, boards, and cards
$workspace_count_query = "SELECT COUNT(*) AS workspace_count FROM workspaces WHERE user_id = ?";
$stmt = $savienojums->prepare($workspace_count_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$workspace_count = $result->fetch_assoc()['workspace_count'];

$board_count_query = "SELECT COUNT(*) AS board_count FROM boards WHERE workspace_id IN (SELECT id FROM workspaces WHERE user_id = ?)";
$stmt = $savienojums->prepare($board_count_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$board_count = $result->fetch_assoc()['board_count'];

$card_count_query = "SELECT COUNT(*) AS card_count FROM cards WHERE board_id IN (SELECT id FROM boards WHERE workspace_id IN (SELECT id FROM workspaces WHERE user_id = ?))";
$stmt = $savienojums->prepare($card_count_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$card_count = $result->fetch_assoc()['card_count'];

$stmt->close();
$savienojums->close();
?>

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

        .box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
        }

        .box .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #6c5ce7;
            color: #fff;
            font-size: 24px;
        }

        .box .info {
            flex: 1;
            margin-left: 15px;
        }

        .box .info h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .box .info p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>

<?php require("navigation.php"); ?>

<div class="title">
    <div class="name">
        <i class="fas fa-tachometer-alt"></i> Sākumlapa
    </div>
</div>

<section class="info-container">
    <div class="box">
        <div class="icon">
            <i class="fas fa-user"></i>
        </div>
        <div class="info">
            <h3>Sveicināti, <?php echo htmlspecialchars($user['lietotajvards']); ?>!</h3>
            <p>Tava loma sistēmā: <?php echo htmlspecialchars($user['lietotaja_loma']); ?></p>
        </div>
    </div>
    <div class="box-container2">
        <div class="column">
            <div class="box">
                <div class="icon">
                    <i class="fas fa-folder"></i>
                </div>
                <div class="info">
                    <h3><?php echo $workspace_count; ?></h3>
                    <p>Izveidotās darbvietas</p>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="box">
                <div class="icon">
                    <i class="fas fa-columns"></i>
                </div>
                <div class="info">
                    <h3><?php echo $board_count; ?></h3>
                    <p>Izveidotie dēļi</p>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="icon">
            <i class="fas fa-sticky-note"></i>
        </div>
        <div class="info">
            <h3><?php echo $card_count; ?></h3>
            <p>Izveidotās kartītes</p>
        </div>
    </div>
</section>

</body>
</html>







