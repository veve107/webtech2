<?php
session_start();

include_once("config/config.php");
include "config/config-lang.php";

if (!isset($_SESSION['type'])) {
    header("Location: login.php");
} else if ($_SESSION['type'] != "admin") {
    header("Location: index.php");
}

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

if (isset($_GET["action"])) {
    $tableName2 = 'u2_' . $_SESSION["rok"] . '_' . $_SESSION["predmet"] . "_timy_body";
    if ($_GET["action"] == "body") {
        $tmpBody = $_POST["body"];
        $tmpTim = $_GET["tim"];
        $update = "UPDATE `" . $tableName2 . "` SET body = $tmpBody WHERE tim = $tmpTim";
        if ($conn->query($update) === FALSE) {
            $msg = "Niekde sa stala chyba." . $conn->error;
        } else {
            $msg = "CSV súbor bol úspešne nahratý.";
        }
    }
    if ($_GET["action"] == "suhlasim") {
        $tmpTim = $_GET["tim"];
        $update = "UPDATE `" . $tableName2 . "` SET suhlas = 'suhlasim' WHERE tim = $tmpTim";
        if ($conn->query($update) === FALSE) {
            $msg = "Niekde sa stala chyba." . $conn->error;
        } else {
            $msg = "CSV súbor bol úspešne nahratý.";
        }

    }
    if ($_GET["action"] == "nesuhlasim") {

        $tmpTim = $_GET["tim"];
        $update = "UPDATE `" . $tableName2 . "` SET suhlas = 'nesuhlasim' WHERE tim = $tmpTim";
        if ($conn->query($update) === FALSE) {
            $msg = "Niekde sa stala chyba." . $conn->error;
        } else {
            $msg = "CSV súbor bol úspešne nahratý.";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - <?php echo $lang['zadanie5'] ?></title>
    <link rel="stylesheet" href="style/showTeamsStyle.css">

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
        echo '<li class="nav-item active">
				        <a class="nav-link" href="showTeams.php">' . $lang['zadanie5'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="uploadCsv.php">' . $lang['zadanie6'] . '</a>
                        </li>';
        echo '<li class="nav-item">
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
            <form method="post" action="showTeams.php" enctype="multipart/form-data">
                <p class="h2 mb-1 text-center mt-4"><?php echo $lang['teams'] ?></p>
                <label for="rok"><?php echo $lang['year'] ?></label>
                <select name="rok" id="rok" class="browser-default custom-select mb-2" required>
                    <option value="2018/2019">2018/2019</option>
                    <option value="2017/2018">2017/2018</option>
                </select><br>
                <div class="text-center"><input type="submit" class="btn btn-primary"
                                                value="<?php echo $lang['import1'] ?>" name="submit"></div>
            </form>

            <?php
            /* Vypis predmetov v rocniku */
            if (isset($_SESSION["rok"])) {
                echo '<form method="post" action="showTeams.php" enctype="multipart/form-data" class="border border-light p-5">';
                echo '<label for="predmet">Predmet</label>';
                echo "<select name='predmet' class=\"browser-default custom-select mb-2\">";
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
                                                value="' . $lang['import1'] . '" name="submit"></div></form>';

            }
            ?>
        </div>
    </div>

    <?php
    if (isset($_SESSION["rok"])) {
        if (isset($_SESSION["predmet"])) {
            echo "<div>";
            echo "Skolsky rok: " . $_SESSION["rok"] . " Predmet: " . $_SESSION["predmet"];
            echo "</div>";
            $tableName1 = 'u2_' . $_SESSION["rok"] . '_' . $_SESSION["predmet"];
            $tableName2 = 'u2_' . $_SESSION["rok"] . '_' . $_SESSION["predmet"] . "_timy_body";

            $sqlTotal = "SELECT count(id) as total FROM `" . $tableName1 . "`";
            $resultTotal = $conn->query($sqlTotal)->fetchAll();
            /* Vypis statistik */
            echo "<div id='containerStat'>";
            echo "<div id='stat1'>";
            echo "Studenti: " . $resultTotal[0]['total'] . "<br>";
            $sqlTotalSuhlas = "SELECT suhlas,count(*) as total FROM `" . $tableName1 . "` GROUP BY suhlas";
            $resultSuhlas = $conn->query($sqlTotalSuhlas)->fetchAll();
            foreach ($resultSuhlas as $rowS) {
                echo $rowS['suhlas'] . ": " . $rowS['total'] . "<br>";

            }
            echo "</div>";
            echo "<div id='stat2'>";

            $sqlTimTotal = "SELECT count(tim) as total FROM `" . $tableName2 . "`";
            $resultTimTotal = $conn->query($sqlTimTotal)->fetchAll();
            echo "Timy: " . $resultTimTotal[0]['total'] . "<br>";
            $sqlTimSuhlas = "SELECT suhlas,count(*) as total FROM `" . $tableName2 . "` GROUP BY suhlas";
            $resultTimSuhlas = $conn->query($sqlTimSuhlas)->fetchAll();
            foreach ($resultTimSuhlas as $rowS) {
                echo $rowS['suhlas'] . ": " . $rowS['total'] . "<br>";

            }
            echo "</div>";
            echo "</div>";

            ?>

            <!-- Vypis grafov -->
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {packages: ['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Suhlas', 'Total'],
                        <?php
                        foreach ($resultSuhlas as $rowS) {
                            echo "['" . $rowS["suhlas"] . "', " . $rowS["total"] . "],";
                        }

                        ?>
                    ]);
                    var options = {
                        title: 'Statistika studentov'
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                    chart.draw(data, options);
                }
            </script>
            <script type="text/javascript">
                google.charts.load('current', {packages: ['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Suhlas', 'Total'],
                        <?php
                        foreach ($resultTimSuhlas as $rowS) {
                            echo "['" . $rowS["suhlas"] . "', " . $rowS["total"] . "],";
                        }

                        ?>
                    ]);
                    var options = {
                        title: 'Statistika timov'
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
                    chart.draw(data, options);
                }
            </script>
            <div id='container'>
                <div id='piechart'></div>
                <div id='piechart2'></div>
            </div>

            <?php
            /* Vypis timov */
            $sql = "SELECT * FROM `" . $tableName2 . "`";
            $result = $conn->query($sql)->fetchAll();
            echo "<div id='tables'>";
            foreach ($result as $row) {
                $tim = $row['tim'];
                $body = $row['body'];
                echo "Tim:" . $tim . "<br>";
                if ($row['suhlas'] == 'suhlasim') {
                    echo "Suhlasite z bodovym rozdeleni";
                }
                if ($row['suhlas'] == 'nesuhlasim') {
                    echo "Nesuhlasite z bodovym rozdeleni";
                }

                echo "<form method='post' action='showTeams.php?action=body&tim=" . $tim . "' enctype='multipart/form-data'>";
                echo "<input type='number' class=\"form-control mb-1\"name='body' min='0' value=" . $body . ">";
                echo "<div class=\"text-center\"><input type=\"submit\" class=\"btn btn-primary mb-2\"
                                                value='Odoslať' name=\"submit\"></div>";
                echo "</form>";

                echo "<table class='table table-dark text-center'>";
                echo "<tr>";
                echo "<th> Email </th>";
                echo "<th> Meno </th>";
                echo "<th> Body </th>";
                echo "<th> Suhlas </th>";
                echo "</tr>";
                $sql2 = "SELECT * FROM `" . $tableName1 . "` WHERE tim=$tim";
                $result2 = $conn->query($sql2)->fetchAll();

                foreach ($result2 as $row2) {
                    echo "<tr>";
                    echo "<td>" . $row2['email'] . "</td>";
                    echo "<td>" . $row2['meno'] . "</td>";
                    echo "<td>" . $row2['body'] . "</td>";
                    echo "<td>" . $row2['suhlas'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<br>";


                if ($row['suhlas'] == 'nevyjadril') {
                    echo "<form method='post' action='showTeams.php?action=suhlasim&tim=" . $tim . "' enctype='multipart/form-data'>";
                    echo "<input type='submit' value='Suhlasim'>";
                    echo "</form>";
                    echo "<form method='post' action='showTeams.php?action=nesuhlasim&tim=" . $tim . "' enctype='multipart/form-data'>";
                    echo "<input type='submit' value='Nesuhlasim'>";
                    echo "</form>";
                }
            }
            echo "</div>";
        }
    }
    ?>
    <br><br></div>

<div class="footer bg-dark">
    <a href="showTeams.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
    | <a href="showTeams.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
<!-- MDB core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>
</body>
</html>