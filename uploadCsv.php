<?php
include_once("config.php");
include "config-lang.php";
$conn;
try{
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Chyba pripojenia " . $e->getMessage();
}
if(isset($_POST["submit"])){
    $filename = $_FILES["subor"]["tmp_name"];
    $tag = $_POST["oddelovac"];
    $predmet = $_POST["predmet"];
    $rok = $_POST["rok"];

    $tableName1='u2_'.$rok.'_'.$predmet;
    $tableName2='u2_'.$rok.'_'.$predmet."_timi_body";
    if($_FILES["subor"]["size"] > 0){
        /* Vytvorenie tabulky so zadanym nazvom */
        $table1="CREATE TABLE IF NOT EXISTS `".$tableName1."`
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

        try{
            $conn->query($table1);
        }catch(PDOException $ex){
            echo "An error".$ex->getMessage();
        }
        /* Vytvorenie tabulky so zadanym nazvom pre timi*/
        $table2="CREATE TABLE IF NOT EXISTS `".$tableName2."`
        (
            tim INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            body INT UNSIGNED NOT NULL,
            suhlas VARCHAR(255) NOT NULL
        )";

        try{
            $conn->query($table2);
        }catch(PDOException $ex){
            echo "An error".$ex->getMessage();
        }

        /* Vytvorenie tabulky so studentami*/
        $table2="CREATE TABLE IF NOT EXISTS `students`
        (
            id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            meno VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            heslo VARCHAR(255) NOT NULL
        )";

        try{
            $conn->query($table2);
        }catch(PDOException $ex){
            echo "An error".$ex->getMessage();
        }

        /* Ak tabulky existuju vymaz obsah na prepisanie */
        $del1="DELETE FROM `".$tableName1."`";
        if($conn->query($del1) === FALSE)
        {
            $msg = "Niekde sa stala chyba." . $conn->error;
        }
        $del2="DELETE FROM `".$tableName2."`";
        if($conn->query($del2) === FALSE)
        {
            $msg = "Niekde sa stala chyba." . $conn->error;
        }
        $del3="DELETE FROM `students`";
        if($conn->query($del3) === FALSE)
        {
            $msg = "Niekde sa stala chyba." . $conn->error;
        }


        $file = fopen($filename, "r");
        $first=0;
        while (($getData = fgetcsv($file, 10000, $tag)) !== FALSE){
            /* V csv subore je stlpec heslo */
            if(count($getData)==5)
            {
                if($first!=0){

                    $sql="INSERT IGNORE INTO `".$tableName1."`(id,meno,email,heslo,tim,body,suhlas,hodnoteny) VALUES ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."',0,'nevyjadril','nehodnoteny')";

                    if($conn->query($sql) === FALSE)
                    {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    }
                    $sql2="INSERT IGNORE INTO `".$tableName2."`(tim,body,suhlas) VALUES ('".$getData[4]."',0,'nevyjadril')";
                    if($conn->query($sql2) === FALSE)
                    {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    }

                    $sql3="INSERT IGNORE INTO students (id,meno,email,heslo) VALUES ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."')";
                    if($conn->query($sql3) === FALSE)
                    {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    }
                }else{$first=1;}
            }
            /* V csv subore nie je stlpec heslo */
            if(count($getData)==4)
            {
                if($first!=0){

                    $sql="INSERT IGNORE INTO `".$tableName1."`(id,meno,email,heslo,tim,body,suhlas,hodnoteny) VALUES ('".$getData[0]."','".$getData[1]."','".$getData[2]."','','".$getData[3]."',0,'nevyjadril','nehodnoteny')";

                    if($conn->query($sql) === FALSE)
                    {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    }
                    $sql2="INSERT IGNORE INTO `".$tableName2."`(tim,body,suhlas) VALUES ('".$getData[3]."',0,'nevyjadril')";
                    if($conn->query($sql2) === FALSE)
                    {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    }

                    $sql3="INSERT IGNORE INTO students (id,meno,email,heslo) VALUES ('".$getData[0]."','".$getData[1]."','".$getData[2]."','')";
                    if($conn->query($sql3) === FALSE)
                    {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    }
                }else{$first=1;}
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

            <h2><?php echo $lang['import2'] ?></h2>

            <form method="post" action="uploadCsv.php" enctype="multipart/form-data">
                <label for="rok"><?php echo $lang['year'] ?></label>
                <select name="rok" required>
                    <option value="2018/2019">2018/2019</option>
                    <option value="2017/2018">2017/2018</option>
                </select><br>
                <label for="predmet"><?php echo $lang['subjectname'] ?></label>
                <input type="text" name="predmet" title="Predmet" required><br>
                <label for="subor"><?php echo $lang['csv'] ?></label>
                <input type="file" name="subor" required><br>
                <label for="oddelovac"><?php echo $lang['delimeter'] ?></label>
                <input type="text" name="oddelovac" size="1" pattern="[,;]{1}" title="Použite ; alebo ," required><br>
                <input type="submit" name="submit" value="<?php echo $lang['import1'] ?>">
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
</body>
</html>