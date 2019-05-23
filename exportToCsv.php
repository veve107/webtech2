<?php
session_start();

include_once("config/config.php");
include "config/config-lang.php";

if (!isset($_SESSION['type'])) {
    header("Location: login.php");
} else if ($_SESSION['type'] != "admin") {
    header("Location: index.php");
}

$conn;
try {
    $conn = new PDO("mysql:host=" . $servername . ";dbname=" . $db, $usernameSQL, $passwordSQL);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Chyba pripojenia " . $e->getMessage();
}


if (isset($_POST["rok"])) {
    $_SESSION["rok"] = $_POST["rok"];
    if (isset($_SESSION["predmet"])) {
        unset($_SESSION['predmet']);
    }
}
if (isset($_POST["predmet"])) {
    $_SESSION["predmet"] = $_POST["predmet"];
}

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Export do csv subora</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/css/mdb.min.css"/>

    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style/style.css">

</head>
<body class="bg-light">
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php"><?php echo $lang['home'] ?></a>
        </li>
        <?php
        echo '<li class="nav-item">
				        <a class="nav-link" href="show-results.php">' . $lang['zadanie2'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="import-results.php">' . $lang['zadanie3'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="delete-results.php">' . $lang['zadanie4'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="showTeams.php">' . $lang['zadanie5'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="uploadCsv.php">' . $lang['zadanie6'] . '</a>
                        </li>';
        echo '<li class="nav-item active">
				        <a class="nav-link" href="exportToCsv.php">' . $lang['zadanie7'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="readCSV.php">' . $lang['zadanie8'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="autori.php">' . $lang['authors'] . '</a>
                        </li>';

        ?>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="scripts/logout.php"><?php echo $lang['logout'] ?></a>
        </li>
    </ul>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3">
            <p class="h2 mb-4 text-center mt-4"><?php echo $lang['csvexport'] ?></p>

            <form method="post" action="exportToCsv.php" enctype="multipart/form-data">
                <label for="rok"><?php echo $lang['year'] ?></label>
                <select name="rok" id="rok" class="browser-default custom-select mb-4" required>
                    <option value="2018/2019">2018/2019</option>
                    <option value="2017/2018">2017/2018</option>
                </select><br>
                <div class="text-center"><input type="submit" class="btn btn-primary"
                                                value="<?php echo $lang['import1'] ?>" name="submit"></div>
            </form>

            <?php
            /* Vypis predmetov v rocniku */
            if (isset($_SESSION["rok"])) {
                echo '<form method="post" action="exportToCsv.php" enctype="multipart/form-data">';
                echo '<label for="predmet">'.$lang['subject'].'</label>';
                echo "<select id='predmet' name='predmet' class=\"browser-default custom-select mb-4\">";
                $tables = $conn->query("show tables")->fetchAll();
                foreach ($tables as $table) {
                    $table1 = explode("_", $table[0]);
                    echo count($table1);
                    if (count($table1) == 3) {
                        if ($table1[1] == $_SESSION["rok"]) {
                            echo "<option>" . $table1[2] . "</option>";
                        }
                    }
                }
                echo "</select><br>";
                echo '<div class="text-center"><input type="submit" class="btn btn-primary"
                                                value="' . $lang['import1'] . '" name="submit"></div>';
                echo "</form>";

            }
            ?>
        </div>
    </div>
    <?php

    if (isset($_SESSION["rok"])) {
        if (isset($_SESSION["predmet"])) {
            echo "<p class='h4 mb-2'>".$lang['school_year'].": " . $_SESSION["rok"] . " ".$lang['subject'].": " . $_SESSION["predmet"]."</p>";
            $tableName1 = 'u2_' . $_SESSION["rok"] . '_' . $_SESSION["predmet"];

            $sql = "SELECT * FROM `" . $tableName1 . "`";
            $result = $conn->query($sql)->fetchAll();
            /*Vypis studentov v rocniku*/
            echo "<table class='table table-dark text-center'><thead>";
            echo "<tr>";
            echo "<th> Email </th>";
            echo "<th> ".$lang['username']." </th>";
            echo "<th> ".$lang['points']." </th>";
            echo "</tr></thead><tbody>";
            foreach ($result as $row) {
                $id = $row['id'];
                $meno = $row['meno'];
                $body = $row['body'];

                echo "<tr>";
                echo "<td>" . $id . "</td>";
                echo "<td>" . $meno . "</td>";
                echo "<td>" . $body . "</td>";
                echo "</tr>";


            }
            echo "</tbody></table>";
            ?>
            <?php
            echo "<form method='post' action='scripts/exportData.php?table=" . $tableName1 . "' enctype='multipart/form-data'>";
            echo "<label for='nazov'>".$lang['filename']."</label>";
            echo "<input type='text' id='nazov' class=\"form-control mb-1\" name='nazov' title='nazov' required><br>";
            echo '<label for="oddelovac">'.$lang['delimeter'].'</label>';
            echo '<input type="text" name="oddelovac" size="1" pattern="[,;]{1}" title="Použite ; alebo ," class="form-control mb-1" required><br>';
            echo '<div class="text-center"><input type="submit" class="btn btn-primary"
                                                value="' . $lang['csvexport'] . '" name="submit"></div>';
            echo "</form>";
        }
    }
    ?>
</div>
<br><br>
<div class="footer bg-dark">
    <a href="exportToCsv.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
    | <a href="exportToCsv.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
<!-- MDB core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>
</body>
</html>