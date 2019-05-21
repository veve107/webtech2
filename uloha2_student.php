<?php
session_start();

include_once("config.php");

try{
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Chyba pripojenia " . $e->getMessage();
}

if(isset($_POST["rok"])){
    $_SESSION["rok"] = $_POST["rok"];
    if(isset($_SESSION["predmet"])){
        unset($_SESSION['predmet']);
    }
}

if(isset($_POST["predmet"])){
    $_SESSION["predmet"] = $_POST["predmet"];
}

if(isset($_GET["action"])){
    $tableName2='u2_'.$_SESSION["rok"].'_'.$_SESSION["predmet"];
    if($_GET["action"]=="body")
    {
        $tmpBody=$_POST["body"];
        $tmpId= $_GET["student"];
        $update = "UPDATE `".$tableName2."` SET body = $tmpBody, hodnoteny = 'hodnoteny' WHERE id = $tmpId";
        if($conn->query($update) === FALSE)
        {
            $msg = "Niekde sa stala chyba." . $conn->error;
        }
    }
    if($_GET["action"]=="suhlasim")
    {
        $tmpId= $_GET["student"];
        $update = "UPDATE `".$tableName2."` SET suhlas = 'suhlasim' WHERE id = $tmpId";
        if($conn->query($update) === FALSE)
        {
            $msg = "Niekde sa stala chyba." . $conn->error;
        }
    }
    if($_GET["action"]=="nesuhlasim")
    {

        $tmpId= $_GET["student"];
        $update = "UPDATE `".$tableName2."` SET suhlas = 'nesuhlasim' WHERE id = $tmpId";
        if($conn->query($update) === FALSE)
        {
            $msg = "Niekde sa stala chyba." . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student - Bodovanie timov</title>
    <link rel="stylesheet" href="showTeamsStyle.css">
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
        <div class="col-md-6 col-md-offset-3">

            <h2><?php echo $lang['teams'] ?></h2>

            <form method="post" action="uloha2_student.php" enctype="multipart/form-data">
                <label for="rok">Školský rok</label>
                <select name="rok" required>
                    <option value="2018/2019">2018/2019</option>
                    <option value="2017/2018">2017/2018</option>
                </select><br>
                <input type="submit" name="submit" value="Vložiť">
            </form>

            <?php

            if(isset($_SESSION["rok"])){
                echo '<form method="post" action="uloha2_student.php" enctype="multipart/form-data">';
                echo '<label for="predmet">Predmet </label>';
                echo "<select name='predmet'>";
                $tables = $conn->query("show tables")->fetchAll();
                foreach ($tables as $table) {
                    $table1 = explode("_", $table[0]);
                    echo count($table1);
                    if(count($table1)==3)
                    {
                        if($table1[1]==$_SESSION["rok"])
                        {
                            echo "<option>".$table1[2]."</option>";
                        }
                    }
                }
                echo "</select><br>";
                echo '<input type="submit" name="submit" value="Vložiť"></form>';

            }
            ?>
            </div>
        </div>
    </div>

<?php



if(isset($_SESSION["rok"])){
    if(isset($_SESSION["predmet"])){

        echo "Skolsky rok: ".$_SESSION["rok"]." Predmet: ".$_SESSION["predmet"];
        echo "<br><br>";
        $tableName1='u2_'.$_SESSION["rok"].'_'.$_SESSION["predmet"];
        $tableName2='u2_'.$_SESSION["rok"].'_'.$_SESSION["predmet"]."_timi_body";

        $sqlTotal = "SELECT count(id) as total FROM `".$tableName1."`WHERE tim=2";
        $resultTotal = $conn->query($sqlTotal)->fetchAll();

        ?>

        <?php
        /* Vypis timov */
        $sql="SELECT * FROM `".$tableName2."`WHERE tim=2";
        $result = $conn->query($sql)->fetchAll();
        echo "<div id='tables'>";
        foreach ($result as $row) {
            $tim=$row['tim'];
            $body=$row['body'];
            echo "Tim:".$tim."<br>";

            echo "<br>Pocet udelenych bodov: ".$body;

            echo "<table>";
            echo "<tr>";
            echo "<th> Email </th>";
            echo "<th> Meno </th>";
            echo "<th> Body </th>";
            echo "<th> Suhlas </th>";
            echo "</tr>";
            $sql2="SELECT * FROM `".$tableName1."` WHERE tim=$tim";
            $result2 = $conn->query($sql2)->fetchAll();

            foreach ($result2 as $row2) {
                $id = $row2['id'];
                echo "<tr>";
                echo "<td>".$row2['email']."</td>";
                echo "<td>".$row2['meno']."</td>";
                echo "<td>";
                if($row2['hodnoteny']=='nehodnoteny') {
                    echo "<form method='post' action='uloha2_student.php?action=body&student=" . $id . "' enctype='multipart/form-data'>";
                    echo "<input type='number' name='body' min='0' max='" . $body . "' value=" . $row2['body'] . "><input type='submit'>";
                    echo "</form>";
                }
                else
                    echo $row2['body'];
                echo "</td>";
                echo "<td>".$row2['suhlas']."</td>";
                if($row2['suhlas']=='nevyjadril' && $row2['hodnoteny']=='hodnoteny')
                {
                    echo "<td>";
                    echo "<form method='post' action='uloha2_student.php?action=suhlasim&student=".$id."' enctype='multipart/form-data'>";
                    echo "<input type='submit' value='Suhlasim'>";
                    echo "</form>";
                    echo "<form method='post' action='uloha2_student.php?action=nesuhlasim&student=".$id."' enctype='multipart/form-data'>";
                    echo "<input type='submit' value='Nesuhlasim'>";
                    echo "</form>";
                    echo "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            echo "<br>";
            
        }
        echo "</div>";
    }
}
?>
<div class="footer bg-dark">
    <a href="showTeams.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
    | <a href="showTeams.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
</body>
</html>