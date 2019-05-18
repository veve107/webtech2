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
        echo "suhlasim";
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
        echo "nesuhlasim";

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


echo $_SESSION["rok"];
echo $_SESSION["predmet"];


?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Vloženie výsledkov</title>
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

            $sql="SELECT * FROM `".$tableName2."`";
            $result = $conn->query($sql)->fetchAll();

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
    }
}
?>
</body>
</html>