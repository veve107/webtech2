<?php
include "config-lang.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $lang['title'] ?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style type="text/css">
        .footer {
            left: 0;
            position: fixed;
            bottom: 0;
            text-align: center;
            color: white;
            width: 100%;
        }
    </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="index.php"><?php echo $lang['home'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="show-output.php"><?php echo $lang['zadanie1'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="show-results.php"><?php echo $lang['zadanie2'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="import-results.php"><?php echo $lang['zadanie3'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="delete-results.php"><?php echo $lang['zadanie4'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="uloha2_student.php"><?php echo $lang['zadanie5_1'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="showTeams.php"><?php echo $lang['zadanie5'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="uploadCsv.php"><?php echo $lang['zadanie6'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="exportToCsv.php"><?php echo $lang['zadanie7'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="readCSV.php"><?php echo $lang['zadanie8'] ?></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="login.php"><?php echo $lang['login'] ?></a>
        </li>
    </ul>
</nav>
<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div id="formular_prihlasenie">
            <form method="post" action="login.php">

                <label id="prihlasenie_login" for="login" class="form-group form-inline">
                    Login:<input id="login" name="login" type="text" class="form-control" required>
                </label>

                <label id="prihlasenie_password" for="password" class="form-group form-inline">
                    Heslo:<input id="password" name="password" type="password" class="form-control" required>
                </label>

                <!--<div class="form-group form-inline">
                    Typ prihlásenia:
                    <input id="login_type_1" name="login_type" type="radio" class="form-control login_radio" value="session" required>
                    <label for="login_type_1">Sessions</label>

                    <input id="login_type_2" name="login_type" type="radio" class="form-control login_radio" value="ldap" required>
                    <label for="login_type_2">LDAP</label>

                </div>-->

                <div id="prihlasenie_tlacidlo" class="form-group">
                    <button id="prihlasit" name="button" class="btn btn-danger">Prihlásiť sa</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="footer bg-dark">
    <a href="index.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
    | <a href="index.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
</body>
</html>