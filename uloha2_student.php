<?php
session_start();

include_once("config/config.php");
include "config/config-lang.php";

if (!isset($_SESSION['type'])) {
    header("Location: login.php");
} else if ($_SESSION['type'] != "student") {
    header("Location: index.php");
}

try{
    $conn = new PDO("mysql:host=" . $servername . ";dbname=" . $db, $usernameSQL, $passwordSQL);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Chyba pripojenia ".$e->getMessage();
}

if(isset($_POST["rok"])) {
    $_SESSION["rok"] = $_POST["rok"];
    if(isset($_SESSION["predmet"]))
        unset($_SESSION['predmet']);
}

if(isset($_POST["predmet"])) {
    $_SESSION["predmet"] = $_POST["predmet"];
}

if(isset($_GET["action"])) {
    $tableName2 = 'u2_'.$_SESSION["rok"].'_'.$_SESSION["predmet"];

    if($_GET["action"] == "body") {
        $tmpBody = $_POST["body"];
        $tmpId = $_GET["student"];
        $update = "UPDATE `".$tableName2."` SET body = $tmpBody, hodnoteny = 'hodnoteny' WHERE id = $tmpId";
        if($conn->query($update) === FALSE)
            $msg = "Niekde sa stala chyba.".$conn->error;
    }

    if($_GET["action"]=="suhlasim") {
        $tmpId = $_GET["student"];
        $update = "UPDATE `".$tableName2."` SET suhlas = 'suhlasim' WHERE id = $tmpId";
        if($conn->query($update) === FALSE)
            $msg = "Niekde sa stala chyba.".$conn->error;
    }

    if($_GET["action"]=="nesuhlasim") {
        $tmpId = $_GET["student"];
        $update = "UPDATE `".$tableName2."` SET suhlas = 'nesuhlasim' WHERE id = $tmpId";
        if($conn->query($update) === FALSE)
            $msg = "Niekde sa stala chyba.".$conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student - Bodovanie timov</title>
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
				        <a class="nav-link" href="show-output.php">' . $lang['zadanie1'] . '</a>
                        </li>';
        echo '<li class="nav-item active">
				        <a class="nav-link" href="uloha2_student.php">' . $lang['points_split'] . ' </a>
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
            <form method="post" action="uloha2_student.php" enctype="multipart/form-data" class="border border-light p-5">
                <p class="h2 mb-1 text-center"><?php echo $lang['teams'] ?></p>
                <label for="rok"><?php echo $lang['year'] ?></label>
                <select name="rok" id="rok" class="browser-default custom-select mb-2" required>
                    <option value="2018/2019">2018/2019</option>
                    <option value="2017/2018">2017/2018</option>
                </select><br>
                <div class="text-center"><input type="submit" class="btn btn-primary"
                                                value="<?php echo $lang['import1'] ?>" name="submit"></div>
            </form>

            <?php
            if(isset($_SESSION["rok"])) {
                echo '<form method="post" action="uloha2_student.php" enctype="multipart/form-data" class="border border-light p-5">';
                echo '<label for="predmet">'.$lang['subjectname'].'</label>';
                echo "<select id='predmet' class=\"browser-default custom-select mb-2\" name='predmet'>";

                $tables = $conn->query("show tables")->fetchAll();
                foreach ($tables as $table) {
                    $table1 = explode("_", $table[0]);
                    echo count($table1);
                    if(count($table1) == 3) {
                        if($table1[1] == $_SESSION["rok"])
                            echo "<option>".$table1[2]."</option>";
                    }
                }

                echo "</select></label><br>";
                echo '<div class="text-center"><input type="submit" class="btn btn-primary"
                                                value="' . $lang['import1'] . '" name="submit"></div></form>';
            }
            ?>

        </div>
    </div>

    <?php
    if(isset($_SESSION["rok"])) {
        if(isset($_SESSION["predmet"])) {

            //$id_prihlaseneho = $_SESSION["id"];
            $id_prihlaseneho = 10023;

            echo "Školský rok: ".$_SESSION["rok"]."<br>Predmet: ".$_SESSION["predmet"];
            echo "<br><br>";
            $tableName1 = 'u2_'.$_SESSION["rok"].'_'.$_SESSION["predmet"];
            $tableName2 = 'u2_'.$_SESSION["rok"].'_'.$_SESSION["predmet"]."_timy_body";

            $sqlTim = "SELECT tim FROM `".$tableName1."` WHERE id=$id_prihlaseneho";
            $resultTim = $conn->query($sqlTim)->fetchAll();
            $tim = $resultTim[0]['tim'];

            $sqlBody = "SELECT body FROM `".$tableName2."`WHERE tim=$tim";
            $resultBody = $conn->query($sqlBody)->fetchAll();
            $body = $resultBody[0]['body'];

            echo "<div id='tables'>";
            echo "Tím: ".$tim."<br>";
            echo "Počet udelených bodov: ".$body;

            echo "<br><br><table class=\"table table-striped\"><tr>";
            echo "<th> Email </th>";
            echo "<th> Meno </th>";
            echo "<th> Body </th>";
            echo "<th> Súhlas </th></tr>";

            $sqlLudia = "SELECT * FROM `".$tableName1."` WHERE tim=$tim";
            $resultLudia = $conn->query($sqlLudia)->fetchAll();
            foreach ($resultLudia as $clovek) {
                $id = $clovek['id'];
                echo "<tr>";
                echo "<td>".$clovek['email']."</td>";
                echo "<td>".$clovek['meno']."</td>";
                echo "<td>";

                if ($clovek['hodnoteny'] == 'nehodnoteny') {
                    $sqlBodyMax = "SELECT SUM(body) AS body FROM `".$tableName1."`WHERE tim=$tim";
                    $resultBodyMax = $conn->query($sqlBodyMax)->fetchAll();
                    $bodyMax = $resultBodyMax[0]['body'];
                    $bodyMax = $body - $bodyMax;

                    echo "<form method='post' action='uloha2_student.php?action=body&student=".$id."' enctype='multipart/form-data'>";
                    echo "<input type='number' name='body' min='0' max='".$bodyMax."' value=".$clovek['body']."><input type='submit'></form>";
                }
                else
                    echo $clovek['body'];

                echo "</td><td>".$clovek['suhlas']."</td>";
                if ($clovek['suhlas'] == 'nevyjadril' && $clovek['hodnoteny'] == 'hodnoteny') {
                    echo "<td><button type='button' class='btn btn-info' data-toggle='modal' data-target='#myModalSuhlas'>Súhlasím</button>";
                    echo "<button type='button' class='btn btn-info' data-toggle='modal' data-target='#myModalNesuhlas'>Nesúhlasím</button></td>";
                }
                echo "</tr>";
            }
            echo "</table><br><br>";
        }
    }
    ?>
</div>

<div class="modal" id="myModalSuhlas">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <p class="modal-title">Naozaj súhlasíte s pridelenými bodmi?</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                Voľba je záväzná!
                <form method='post' action='uloha2_student.php?action=suhlasim&student="<?php echo $id_prihlaseneho?>"' enctype='multipart/form-data'>
                    <input class="btn btn-success" type='submit' value='Súhlasím'>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Zavrieť</button>
            </div>

        </div>
    </div>
</div>

<div class="modal" id="myModalNesuhlas">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <p class="modal-title">Naozaj nesúhlasíte s pridelenými bodmi?</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                Voľba je záväzná!
                <form method='post' action='uloha2_student.php?action=nesuhlasim&student="<?php echo $id_prihlaseneho?>"' enctype='multipart/form-data'>
                    <input class="btn btn-success" type='submit' value='Nesúhlasím'>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Zavrieť</button>
            </div>

        </div>
    </div>
</div>

<div class="footer bg-dark">
    <a href="uloha2_student.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
    | <a href="uloha2_student.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
<!-- MDB core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>
</body>
</html>
