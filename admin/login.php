<?php
session_start();

// If user is already logged in, redirect to index.php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Include the database connection file
include '../Connect_db.php';

// Define variables and initialize with empty values
$lietotajs = $parole = "";
$lietotajs_err = $parole_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Check if username is empty
    if(empty(trim($_POST["lietotajs"]))){
        $lietotajs_err = "Please enter username.";
    } else{
        $lietotajs = trim($_POST["lietotajs"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["parole"]))){
        $parole_err = "Please enter your password.";
    } else{
        $parole = trim($_POST["parole"]);
    }
    
    // Validate credentials
    if(empty($lietotajs_err) && empty($parole_err)){
        // Prepare a select statement
        $sql = "SELECT lietotajs_id, lietotajvards, parole FROM wrelo_lietotaji WHERE lietotajvards = ?";
        
        if($stmt = $savienojums->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_lietotajs);
            
            // Set parameters
            $param_lietotajs = $lietotajs;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $lietotajs, $hashed_parole);
                    if($stmt->fetch()){
                        if(password_verify($parole, $hashed_parole)){
                            // Password is correct, start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["lietotajs"] = $lietotajs;                            
                            
                            // Redirect user to index.php page
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $parole_err = "Parole, kas tika ievadīta nav pareiza";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $lietotajs_err = "Šāds lietotājvārds netika atrasts";
                }
            } else{
                echo "Ak vai! Kaut kas nogāja greizi. Lūdzu mēģini vēlreiz.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $savienojums->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($lietotajs_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="lietotajs" class="form-control" value="<?php echo $lietotajs; ?>">
                <span class="help-block"><?php echo $lietotajs_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($parole_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="parole" class="form-control">
                <span class="help-block"><?php echo $parole_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>    
</body>
</html>







