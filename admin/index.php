<?php
session_start();

// Check if the user is not logged in, redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include the database connection file
include '../Connect_db.php';

// Fetch the current admin's details (assuming admin's user ID is 1, change as needed)
$admin_id = $_SESSION["id"]; // Use the admin's ID stored in the session
$admin_sql = "SELECT liet_vards, liet_uzvards FROM wrelo_lietotaji WHERE lietotajs_id = $admin_id";
$admin_result = $savienojums->query($admin_sql);

if ($admin_result && $admin_result->num_rows > 0) {
    $admin_row = $admin_result->fetch_assoc();
    $admin_first_name = $admin_row['liet_vards'];
    $admin_last_name = $admin_row['liet_uzvards'];
} else {
    $admin_first_name = "Admin";
    $admin_last_name = "";
}

// Fetch users from the database
$sql = "SELECT lietotajs_id, lietotajvards, lietotaja_loma, reg_sistema, statuss FROM wrelo_lietotaji";
$result = $savienojums->query($sql);

// Check if the query was successful
if (!$result) {
    die("Error executing query: " . $savienojums->error);
}

// Logout logic
if(isset($_POST["logout"])){
    // Unset all session variables
    session_unset();
    
    // Destroy the session
    session_destroy();
    
    // Redirect to home.html
    header("location: ../home.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wrelo | Administrēšana</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }
        .sidebar {
            height: 100vh;
            background-color: #3f51b5;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            font-size: 18px;
            padding: 10px;
            text-decoration: none;
            display: block;
        }
        .sidebar a:hover {
            background-color: #5769e4;
        }
        .content {
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
        }
        .card-header {
            background-color: #3f51b5;
            color: white;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
        }
        .card-body {
            background-color: white;
            border-radius: 0 0 10px 10px;
        }
        .table th {
            background-color: #3f51b5;
            color: white;
        }
        .profile-icon {
            font-size: 80px;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                <div class="text-center">
                    <i class="fas fa-user profile-icon"></i>
                    <h4 class="text-white mt-2"><?php echo $admin_first_name . " " . $admin_last_name; ?></h4>
                </div>
                <a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="#"><i class="fas fa-users"></i> Lietotāji</a>
                <a href="#"><i class="fas fa-cogs"></i> Iestatījumi</a>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="submit" name="logout" value="Logout" class="btn btn-danger mt-3">
                </form>
            </div>
            <div class="col-md-9 content">
                <h1>Admin Panelis</h1>
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-users"></i> Lietotāja Pārskats
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Lietotāja ID</th>
                                    <th>Lietotājvārds</th>
                                    <th>Loma</th>
                                    <th>Reģistrēšanās datums</th>
                                    <th>Statuss</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["lietotajs_id"] . "</td>";
                                        echo "<td>" . $row["lietotajvards"] . "</td>";
                                        echo "<td>" . $row["lietotaja_loma"] . "</td>";
                                        echo "<td>" . $row["reg_sistema"] . "</td>";
                                        echo "<td>" . $row["statuss"] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No users found</td></tr>";
                                }
                                $savienojums->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>







