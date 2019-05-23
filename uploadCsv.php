<?php
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


if (isset($_POST["submit"])) {
    $filename = $_FILES["subor"]["tmp_name"];
    $tag = $_POST["oddelovac"];
    $predmet = $_POST["predmet"];
    $rok = $_POST["rok"];

    $tableName1 = 'u2_' . $rok . '_' . $predmet;
    $tableName2 = 'u2_' . $rok . '_' . $predmet . "_timy_body";
    if ($_FILES["subor"]["size"] > 0) {
        /* Vytvorenie tabulky so zadanym nazvom */
        $table1 = "CREATE TABLE IF NOT EXISTS `" . $tableName1 . "`
        (
            id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            meno VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            heslo VARCHAR(255) NOT NULL,
            tim INT UNSIGNED NOT NULL,
            body INT UNSIGNED NOT NULL,
            suhlas VARCHAR(255) NOT NULL,
            hodnoteny VARCHAR(255) NOT NULL
        )";
        try {
            $conn->query($table1);
        } catch (PDOException $ex) {
            echo "An error" . $ex->getMessage();
        }
        /* Vytvorenie tabulky so zadanym nazvom pre timi*/
        $table2 = "CREATE TABLE IF NOT EXISTS `" . $tableName2 . "`
        (
            tim INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            body INT UNSIGNED NOT NULL,
            suhlas VARCHAR(255) NOT NULL
        )";

        try {
            $conn->query($table2);
        } catch (PDOException $ex) {
            echo "An error" . $ex->getMessage();
        }

        /* Ak tabulky existuju vymaz obsah na prepisanie */
        $del1 = "DELETE FROM`" . $tableName1 . "`";
        if ($conn->query($del1) === FALSE) {
            $msg = "Niekde sa stala chyba." . $conn->error;
        }
        $del2 = "DELETE FROM`" . $tableName2 . "`";
        if ($conn->query($del2) === FALSE) {
            $msg = "Niekde sa stala chyba." . $conn->error;
        }
        $file = fopen($filename, "r");
        $first = 0;
        while (($getData = fgetcsv($file, 10000, $tag)) !== FALSE) {
            /* V csv subore je stlpec heslo */
            if (count($getData) == 5) {
                if ($first != 0) {

                    $sql = "INSERT IGNORE INTO `" . $tableName1 . "`(id,meno,email,heslo,tim,body,suhlas,hodnoteny) VALUES ('" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "','" . $getData[3] . "','" . $getData[4] . "',0,'nevyjadril', 'nehodnoteny')";

                    if ($conn->query($sql) === FALSE) {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    }
                    $sql2 = "INSERT IGNORE INTO `" . $tableName2 . "`(tim,body,suhlas) VALUES ('" . $getData[4] . "',0,'nevyjadril')";
                    if ($conn->query($sql2) === FALSE) {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    }

                    $sql3 = "INSERT IGNORE INTO studenti (id,meno,email,heslo) VALUES ('" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "','" . $getData[3] . "')";
                    if ($conn->query($sql3) === FALSE) {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    }
                } else {
                    $first = 1;
                }
            } else if (count($getData) == 4) {
                if ($first != 0) {
                    $sql = "INSERT IGNORE INTO `" . $tableName1 . "`(id,meno,email,heslo,tim,body,suhlas,hodnoteny) VALUES ('" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "','','" . $getData[3] . "',0,'nevyjadril', 'nehodnoteny')";
                    if ($conn->query($sql) === FALSE) {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    }
                    $sql2 = "INSERT IGNORE INTO `" . $tableName2 . "`(tim,body,suhlas) VALUES ('" . $getData[3] . "',0,'nevyjadril')";
                    if ($conn->query($sql2) === FALSE) {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    }
                    $sql3 = "INSERT IGNORE INTO studenti (id, meno,mail,heslo, tim) VALUES ('" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "','', " . $getData[3] . ")";
                    if ($conn->query($sql3) === FALSE) {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    }
                } else {
                    $first = 1;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Vloženie timov</title>
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
        echo '<li class="nav-item active">
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
            <form method="post" action="uploadCsv.php" enctype="multipart/form-data" class="border border-light p-5">
                <p class="h2 mb-4 text-center"><?php echo $lang['import2'] ?></p>
                <label for="rok"><?php echo $lang['year'] ?></label>
                <select name="rok" id="rok" class="browser-default custom-select mb-4" required>
                    <option selected disabled><?php echo $lang['default_select'] ?></option>
                    <option value="2018/2019">2018/2019</option>
                    <option value="2017/2018">2017/2018</option>
                </select><br>
                <label for="predmet"><?php echo $lang['subjectname'] ?></label>
                <input type="text" id="predmet" name="predmet" title="Predmet" class='form-control mb-2' required><br>
                <div class="input-group mb-1">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="subor" id="subor"
                               aria-describedby="fileInput">
                        <label class="custom-file-label" for="subor"><?php echo $lang['filename'] ?></label>
                    </div>
                </div>
                <label for="oddelovac"><?php echo $lang['delimeter'] ?></label>
                <input type="text" name="oddelovac" id="oddelovac" size="1" pattern="[,;]{1}" title="Použite ; alebo ,"
                       class='form-control mb-2' required><br>
                <div class="text-center"><input type="submit" class="btn btn-primary"
                                                value="<?php echo $lang['import1'] ?>" name="submit"></div>
            </form>

            <?php
            echo $msg; ?>
        </div>
    </div>
</div>
<div class="footer bg-dark">
    <a href="uploadCsv.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
    | <a href="uploadCsv.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
<!-- MDB core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>
</body>
</html>