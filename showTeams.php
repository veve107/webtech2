<?php
session_start();

include_once("config.php");



$conn;
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
    $tableName2='u2_'.$_SESSION["rok"].'_'.$_SESSION["predmet"]."_timi_body";
    if($_GET["action"]=="body")
    {
        $tmpBody=$_POST["body"]; 
        $tmpTim= $_GET["tim"];
        $update = "UPDATE `".$tableName2."` SET body = $tmpBody WHERE tim = $tmpTim";
        if($conn->query($update) === FALSE)
        {
            $msg = "Niekde sa stala chyba." . $conn->error;
        }
        else {
            $msg = "CSV súbor bol úspešne nahratý.";
        }
    }
    if($_GET["action"]=="suhlasim")
    {
        $tmpTim= $_GET["tim"];
        $update = "UPDATE `".$tableName2."` SET suhlas = 'suhlasim' WHERE tim = $tmpTim";
        if($conn->query($update) === FALSE)
        {
            $msg = "Niekde sa stala chyba." . $conn->error;
        }
        else {
            $msg = "CSV súbor bol úspešne nahratý.";
        }
        
    }
    if($_GET["action"]=="nesuhlasim")
    {

        $tmpTim= $_GET["tim"];
        $update = "UPDATE `".$tableName2."` SET suhlas = 'nesuhlasim' WHERE tim = $tmpTim";
        if($conn->query($update) === FALSE)
        {
            $msg = "Niekde sa stala chyba." . $conn->error;
        }
        else {
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
    <title>Admin - Bodovanie timov</title>
    <link rel="stylesheet" href="showTeamsStyle.css">
</head>
<body>
<header>
    <h1>Bodovanie timov</h1>
</header>

<div>

    <form method="post" action="showTeams.php" enctype="multipart/form-data">
        <label for="rok">Školský rok</label>
        <select name="rok" required>
            <option value="2018/2019">2018/2019</option>
            <option value="2017/2018">2017/2018</option>
        </select><br>
        <input type="submit" name="submit" value="Vložiť">
    </form>

    <?php
    /* Vypis predmetov v rocniku */
    if(isset($_SESSION["rok"])){
        echo '<form method="post" action="showTeams.php" enctype="multipart/form-data">';
        echo '<label for="predmet">Predmet</label>';
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

<?php



if(isset($_SESSION["rok"])){
    if(isset($_SESSION["predmet"])){

            echo "Skolsky rok: ".$_SESSION["rok"]." Predmet: ".$_SESSION["predmet"];
            echo "<br><br>";
            $tableName1='u2_'.$_SESSION["rok"].'_'.$_SESSION["predmet"];
            $tableName2='u2_'.$_SESSION["rok"].'_'.$_SESSION["predmet"]."_timi_body";

            $sqlTotal = "SELECT count(id) as total FROM `".$tableName1."`";
            $resultTotal = $conn->query($sqlTotal)->fetchAll();
            /* Vypis statistik */
            echo "<div id='containerStat'>";
            echo "<div id='stat1'>";
            echo "Studenti: ".$resultTotal[0]['total']."<br>";
            $sqlTotalSuhlas = "SELECT suhlas,count(*) as total FROM `".$tableName1."` GROUP BY suhlas";
            $resultSuhlas = $conn->query($sqlTotalSuhlas)->fetchAll();
            foreach ($resultSuhlas as $rowS) {
                echo $rowS['suhlas'].": ".$rowS['total']."<br>";

            }
            echo "</div>";
            echo "<div id='stat2'>";

            $sqlTimTotal = "SELECT count(tim) as total FROM `".$tableName2."`";
            $resultTimTotal = $conn->query($sqlTimTotal)->fetchAll();
            echo "Timi: ".$resultTimTotal[0]['total']."<br>";
            $sqlTimSuhlas = "SELECT suhlas,count(*) as total FROM `".$tableName2."` GROUP BY suhlas";
            $resultTimSuhlas = $conn->query($sqlTimSuhlas)->fetchAll();
            foreach ($resultTimSuhlas as $rowS) {
                echo $rowS['suhlas'].": ".$rowS['total']."<br>";

            }
            echo "</div>";
            echo "</div>";
            
?>

<!-- Vypis grafov -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart()
    {
        var data = google.visualization.arrayToDataTable([
            ['Suhlas','Total'],
            <?php
            foreach ($resultSuhlas as $rowS) {
                echo "['".$rowS["suhlas"]."', ".$rowS["total"]."],";
            } 

            ?>
        ]);
        var options ={
            title: 'Statistika studentov'
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data,options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart()
    {
        var data = google.visualization.arrayToDataTable([
            ['Suhlas','Total'],
            <?php
            foreach ($resultTimSuhlas as $rowS) {
                echo "['".$rowS["suhlas"]."', ".$rowS["total"]."],";
            } 

            ?>
        ]);
        var options ={
            title: 'Statistika timov'
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
        chart.draw(data,options);
    }
</script>
<div id='container'>
<div id='piechart'></div>
<div id='piechart2'></div>
</div>

<?php
            /* Vypis timov */
            $sql="SELECT * FROM `".$tableName2."`";
            $result = $conn->query($sql)->fetchAll();
            echo "<div id='tables'>";
            foreach ($result as $row) {
                $tim=$row['tim'];
                $body=$row['body'];
                echo "Tim:".$tim."<br>";
                if($row['suhlas']=='suhlasim')
                {
                    echo "Suhlasite z bodovym rozdeleni";
                }
                if($row['suhlas']=='nesuhlasim')
                {
                    echo "Nesuhlasite z bodovym rozdeleni";
                }

                echo "<form method='post' action='showTeams.php?action=body&tim=".$tim."' enctype='multipart/form-data'>";
                echo "<input type='number' name='body' min='0' value=".$body."><input type='submit'>";
                echo "</form>";

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
                    echo "<tr>";
                    echo "<td>".$row2['email']."</td>";
                    echo "<td>".$row2['meno']."</td>";
                    echo "<td>".$row2['body']."</td>";
                    echo "<td>".$row2['suhlas']."</td>";
                    echo "</tr>";    
                }
                echo "</table>";
                echo "<br>";


                if($row['suhlas']=='nevyjadril')
                {
                    echo "<form method='post' action='showTeams.php?action=suhlasim&tim=".$tim."' enctype='multipart/form-data'>";
                    echo "<input type='submit' value='Suhlasim'>";
                    echo "</form>";
                    echo "<form method='post' action='showTeams.php?action=nesuhlasim&tim=".$tim."' enctype='multipart/form-data'>";
                    echo "<input type='submit' value='Nesuhlasim'>";
                    echo "</form>";
                }
            }
            echo "</div>";
    }
}
?>
</body>
</html>