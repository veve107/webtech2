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

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Export do csv subora</title>
</head>
<body>
<header>
    <h1>Export do csv subora</h1>
</header>

<div>

    <form method="post" action="exportToCsv.php" enctype="multipart/form-data">
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
        echo '<form method="post" action="exportToCsv.php" enctype="multipart/form-data">';
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

            $sql="SELECT * FROM `".$tableName1."`";
            $result = $conn->query($sql)->fetchAll();
            /*Vypis studentov v rocniku*/
            echo "<table>";
            echo "<tr>";
	        echo "<th> Email </th>";
	        echo "<th> Meno </th>";
	        echo "<th> Body </th>";
	        echo "</tr>";
            foreach ($result as $row) {
                $id=$row['id'];
                $meno=$row['meno'];
                $body=$row['body'];
                
                echo "<tr>";
                echo "<td>".$id."</td>";
                echo "<td>".$meno."</td>";
                echo "<td>".$body."</td>";
                echo "</tr>";

                
            }
            echo "</table>";
            echo "<br>";
            echo "<form method='post' action='exportData.php?table=".$tableName1."' enctype='multipart/form-data'>";
            echo "<label for='nazov'>Názov suboru</label>";
            echo "<input type='text' name='nazov' title='nazov' required><br>";
            echo '<label for="oddelovac">Oddeľovač v CSV</label>';
            echo '<input type="text" name="oddelovac" size="1" pattern="[,;]{1}" title="Použite ; alebo ," required><br>';
            echo "<input type='submit' value='Export do Csv'>";
            echo "</form>";
    }
}
?>
</body>
</html>