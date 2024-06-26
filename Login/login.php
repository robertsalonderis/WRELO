<?php
// Start a new session or resume the existing session
session_start();

// Include the database connection script from an external file
require_once '../Connect_db.php'; // Ensure the path is correct

// Initialize error messages
$login_error = '';
$signup_error = '';

// Check if the login form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    if (isset($_POST['lietotajvards'], $_POST['parole'])) {
        // Retrieve the submitted username and password from the form
        $lietotajvards = $_POST['lietotajvards'];
        $parole = $_POST['parole'];

        // SQL query to select the user record from the database where the username matches
        $sql = "SELECT * FROM wrelo_lietotaji WHERE lietotajvards = ?";
        
        // Prepare the SQL statement to prevent SQL injection
        if ($stmt = mysqli_prepare($savienojums, $sql)) {
            // Bind the input username to the prepared statement
            mysqli_stmt_bind_param($stmt, "s", $lietotajvards);
            
            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Get the result of the query
                $result = mysqli_stmt_get_result($stmt);
                
                // Fetch the user record from the database
                if ($row = mysqli_fetch_assoc($result)) {
                    // Verify the submitted password against the hashed password stored in the database
                    if (password_verify($parole, $row['parole'])) {
                        // If password is correct, store the user ID and username in the session
                        $_SESSION['lietotajvards'] = $lietotajvards;
                        $_SESSION['user_id'] = $row['lietotajs_id']; // Assuming the user ID field in your table is 'lietotajs_id'
                        
                        // Redirect the user to the main page
                        header("Location: ../main.php");
                        exit(); // Ensure no further code is executed after redirection
                    } else {
                        // Store an error message if the password is incorrect
                        $login_error = "Ievadītā parole nebija derīga!";
                    }
                } else {
                    // Store an error message if no user was found with the given username
                    $login_error = "Nav atrasts neviens konts ar šo lietotājvārdu!";
                }
            } else {
                // Store an error message if there was a problem executing the statement
                $login_error = "Hmm! Kaut kas nogāja greizi. Lūdzu, pamēģiniet vēlreiz vēlāk.";
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        }
    }
}

// Check if the signup form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Retrieve the submitted data from the form
    if (isset($_POST['vards'], $_POST['uzvards'], $_POST['signup_lietotajvards'], $_POST['epasts'], $_POST['signup_parole'])) {
        $vards = $_POST['vards'];
        $uzvards = $_POST['uzvards'];
        $lietotajvards = $_POST['signup_lietotajvards'];
        $epasts = $_POST['epasts'];
        $parole = $_POST['signup_parole'];

        // Hash the password before storing it in the database
        $hashed_parole = password_hash($parole, PASSWORD_DEFAULT);

        // SQL query to insert a new user record into the database
        $sql = "INSERT INTO wrelo_lietotaji (liet_vards, liet_uzvards, lietotajvards, liet_epasts, parole, statuss, lietotaja_loma) VALUES (?, ?, ?, ?, ?, 'aktīvs', 'Lietotājs')";

        // Prepare the SQL statement to prevent SQL injection
        if ($stmt = mysqli_prepare($savienojums, $sql)) {
            // Bind the input values to the prepared statement
            mysqli_stmt_bind_param($stmt, "sssss", $vards, $uzvards, $lietotajvards, $epasts, $hashed_parole);

            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect the user to the login page after successful registration
                header("Location: login.php");
                exit(); // Ensure no further code is executed after redirection
            } else {
                // Store an error message if there was a problem executing the statement
                $signup_error = "Hmm! Kaut kas nogāja greizi. Lūdzu, pamēģiniet vēlreiz vēlāk.";
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="login-style.css" />
    <title>Pieslēgties / Reģistrēties</title>
</head>
<body>
    <a href="../index.php" class="back-home-button">
        <i class="fas fa-home"></i> Atpakaļ uz sākumlapu
    </a>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="login.php" method="post">
                <h1>Izveidot kontu</h1>
                <?php if (!empty($signup_error)): ?>
                    <p class="error"><?php echo $signup_error; ?></p>
                <?php endif; ?>
                <input type="text" name="vards" placeholder="Vārds" required />
                <input type="text" name="uzvards" placeholder="Uzvārds" required />
                <input type="text" name="signup_lietotajvards" placeholder="Lietotājvārds" required />
                <input type="email" name="epasts" placeholder="E-pasts" required />
                <input type="password" name="signup_parole" placeholder="Parole" required />
                <button type="submit" name="signup">Reģistrēties</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="login.php" method="post">
                <h1>Autorizēties</h1>
                <?php if (!empty($login_error)): ?>
                    <p class="error"><?php echo $login_error; ?></p>
                <?php endif; ?>
                <input type="text" name="lietotajvards" placeholder="Lietotājvārds" required />
                <input type="password" name="parole" placeholder="Parole" required />
                <button type="submit" name="login">Pieslēgties</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Sveicināts atpakaļ!</h1>
                    <p>Ievadi savu personīgo informāciju, lai izmantotu visas vietnes funkcijas!</p>
                    <button class="hidden" id="login">Pieslēgties</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Sveiks, draugs!</h1>
                    <p>Reģistrējies ar savu personīgo informāciju, lai izmantotu visas vietnes funkcijas!</p>
                    <button class="hidden" id="register">Reģistrēties</button>
                </div>
            </div>
        </div>
    </div>
    <script src="login-script.js"></script>
</body>
</html>


