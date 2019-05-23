<?php
include_once("config/config.php");
include "config/config-lang.php";

if (!isset($_SESSION['type'])) {
    header("Location: login.php");
} else if ($_SESSION['type'] != "admin") {
    header("Location: index.php");
}

$conn = new mysqli($servername, $usernameSQL, $passwordSQL, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "UTF8");
if (isset($_POST["submit"])) {
    $predmet = str_replace(" ", "_", $_POST["predmet"]);
    $rok = $_POST["rok"];

    $exist = "SELECT * FROM $predmet";
    $result0 = $conn->query($exist);
    if ($result0->num_rows == 0) {
        $msg = "Zadaný predmet neexistuje.";
    } else {
        $sql = "SELECT * FROM $predmet p WHERE p.skolskyrok = '$rok'";
        $result = $conn->query($sql);

        $sql2 = "DESCRIBE $predmet";
        $result2 = $conn->query($sql2);
        $msg = "Nenašli sa žiadne záznamy.";
    }

}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - <?php echo $lang['show'] ?></title>
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
        echo '<li class="nav-item active">
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
<div class="container" >
    <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3">
            <form method="post" action="show-results.php" class="border border-light p-5">
                <p class="h2 mb-4 text-center"><?php echo $lang['show'] ?></p>
                <label for="rok"><?php echo $lang['year'] ?></label>
                <select name="rok" id="rok" class="browser-default custom-select mb-4" required>
                    <option selected disabled><?php echo $lang['default_select']?></option>
                    <option value="2018/2019">2018/2019</option>
                    <option value="2017/2018">2017/2018</option>
                </select><br>
                <label for="predmet"><?php echo $lang['subjectname'] ?></label>
                <input type="text" id="predmet" name="predmet" class = 'form-control' required><br>
                <div class="text-center"><input type="submit" class="btn btn-primary"
                                                value="<?php echo $lang['show1'] ?>" name="submit"></div>
            </form>
        </div>
    </div>

    <?php
    if ($result->num_rows > 0) {
        echo "<table class=\"table table-striped\"><thead>";
        while ($row2 = $result2->fetch_assoc()) {
            echo "<th>" . $row2["Field"] . "</th>";
        }
        echo "</thead><tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $data) {
                echo "<td>" . $data . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "<a href='scripts/generate-pdf.php?rok=$rok&predmet=$predmet' target='_blank'>Generovať PDF</a>";
    } else {
        echo $msg;
    }

    $conn->close();
    ?>
</div>
<br>
<br>
<div class="footer bg-dark">
    <a href="show-results.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
    | <a href="show-results.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
<!-- MDB core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>
</body>
</html>
