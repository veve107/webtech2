<?php
include "config/config-lang.php";
if (!isset($_SESSION['type'])) {
    header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $lang['title'] ?></title>
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
        <li class="nav-item active">
            <a class="nav-link" href="index.php"><?php echo $lang['home'] ?></a>
        </li>
        <?php
        if ($_SESSION['type'] == 'admin') {
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
            echo '<li class="nav-item">
				        <a class="nav-link" href="exportToCsv.php">' . $lang['zadanie7'] . '</a>
                        </li>';
            echo '<li class="nav-item">
				        <a class="nav-link" href="readCSV.php">' . $lang['zadanie8'] . '</a>
                        </li>';
            echo '<li class="nav-item">
				        <a class="nav-link" href="autori.php">' . $lang['authors'] . '</a>
                        </li>';
        } else if ($_SESSION['type'] == 'student') {
            echo '<li class="nav-item">
				        <a class="nav-link" href="show-output.php">' . $lang['zadanie1'] . '</a>
                        </li>';
            echo '<li class="nav-item">
				        <a class="nav-link" href="uloha2_student.php">' . $lang['points_split'] . '</a>
                        </li>';
        }
        ?>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="scripts/logout.php"><?php echo $lang['logout'] ?></a>
        </li>
    </ul>
</nav>
<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-3">
            <h1 class="text-center"><?php echo $lang['title'] ?></h1>
            <p>
                <?php echo $lang['text'] ?>
            </p>
        </div>
    </div>
</div><!-- -->

<div class="footer bg-dark">
    <a href="index.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
    | <a href="index.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
<!-- MDB core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>
</body>
</html>