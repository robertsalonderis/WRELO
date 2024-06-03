<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WRELO | Lietotāju administrēšana</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="admin-style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <script src="admin-script.js" defer></script>

</head>
<body>
<?php
    require("../Connect_db.php");
    require("navigation.php");



        // Pārbaudam lietotāja lomu
    $Loma = ''; // Definējam, lai izvairītos no iespējamām kļūdām
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
        <i class="fas fa-user"></i> Lietotāji
    </div>
    <button class="btn" id="new">Pievienot jaunu</button>
</div>

<div class="container">
    <table>
        <tr>
            <th>ID</th>
            <th>Lietotājvards</th>
            <th>Vārds</th>
            <th>Uzvārds</th>
            <th>E-pasts</th>
            <th>Loma</th>
            <th>Reģistrēts sistēmā</th>
            <th></th>
        </tr>
        <tbody id="lietotaji"></tbody>
    </table>

    <div class="modal">
        <div class="apply">
            <div class="close_modal"><i class="fas fa-times"></i></div>
            <h2>Lietotāji</h2>
                <form id="lietotajaForma">
                <div class="formElements">
                <label>Lietotājvards <span>*</span>:</label>
                <input type="text" id="lietotajvards" required>
                <label>Vārds <span>*</span>:</label>
                <input type="text" id="vards" required>
                <label>Uzvārds <span>*</span>:</label>
                <input type="text" id="uzvards" required>
                <label>E-pasta adrese <span>*</span>:</label>
                <input type="email" id="epasts" required>
                <label>Parole <span>*</span>:</label>
                <input type="password" id="parole" required>
                
                <label>Loma</label>
                <select id="loma" required>
                    <option value="Administrators">Administrators</option>
                    <option value="Moderators">Moderators</option>
                </select>

            <input type="hidden" id="lietotajiID" name="lietotajiID">
            </div>
            <input type="submit" name="pieteikties" value="Saglabāt" class="btn">
        </form>
    </div>
    </div>

    <!-- Edit FORM-->
    <div class="modal">
        <div class="apply">
            <div class="close_modal"><i class="fas fa-times"></i></div>
            <h2>Lietotāji</h2>
                <form id="editForma">
                <div class="formElements">
                <label>Lietotājvards <span>*</span>:</label>
                <input type="text" id="lietotajvards" required>
                <label>Vārds <span>*</span>:</label>
                <input type="text" id="vards" required>
                <label>Uzvārds <span>*</span>:</label>
                <input type="text" id="uzvards" required>
                <label>E-pasta adrese <span>*</span>:</label>
                <input type="email" id="epasts" required>
                <label>Parole <span>*</span>:</label>
                <input type="password" id="parole" required>
                
                <label>Loma</label>
                <select id="loma" required>
                    <option value="Administrators">Administrators</option>
                    <option value="Lietotajs">Lietotājs</option>
                </select>

            <input type="hidden" id="lietotajiID" name="lietotajiID">
            </div>
            <input type="submit" name="pieteikties" value="Saglabāt" class="btn">
        </form>
    </div>
    </div>


</div>

</body>
</html>
