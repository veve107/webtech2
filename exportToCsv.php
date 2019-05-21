<?php
session_start();

include_once("config.php");
include "config-lang.php"; 


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
            <h2><?php echo $lang['csvexport'] ?></h2>

            <form method="post" action="exportToCsv.php" enctype="multipart/form-data">
                <label for="rok"><?php echo $lang['year'] ?></label>
                <select name="rok" required>
                    <option value="2018/2019">2018/2019</option>
                    <option value="2017/2018">2017/2018</option>
                </select><br>
                <input type="submit" name="submit" value="<?php echo $lang['import1'] ?>">
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
        </div>
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
<div class="footer bg-dark">
<a href="exportToCsv.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
| <a href="exportToCsv.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
</body>
</html>