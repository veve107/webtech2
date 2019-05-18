<?php
include_once("config.php");

$conn;
try{
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
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

        $table1="CREATE TABLE IF NOT EXISTS `".$tableName1."`
        (
            id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            meno VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            heslo VARCHAR(255) NOT NULL,
            tim INT UNSIGNED NOT NULL,
            body INT UNSIGNED NOT NULL,
            suhlas VARCHAR(255) NOT NULL
        )";

        try{
            $conn->query($table1);
            echo "Table created";
        }catch(PDOException $ex){
        echo "An error".$ex->getMessage();
        }

        $table2="CREATE TABLE IF NOT EXISTS `".$tableName2."`
        (
            tim INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            body INT UNSIGNED NOT NULL,
            suhlas VARCHAR(255) NOT NULL,
            kapitan INT UNSIGNED NOT NULL
        )";

        try{
            $conn->query($table2);
            echo "Table created";
        }catch(PDOException $ex){
        echo "An error".$ex->getMessage();
        }


        $file = fopen($filename, "r");
        $first=0;
        while (($getData = fgetcsv($file, 10000, $tag)) !== FALSE){
            if($first!=0){
                echo count($getData);

                $sql="INSERT IGNORE INTO `".$tableName1."`(id,meno,email,heslo,tim,body,suhlas) VALUES ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."',0,'nevyjadril')";
                
                if($conn->query($sql) === FALSE)
                {
                    $msg = "Niekde sa stala chyba." . $conn->error;
                }
                else {
                    $msg = "CSV súbor bol úspešne nahratý.";
                }
                $sql2="INSERT IGNORE INTO `".$tableName2."`(tim,body,suhlas) VALUES ('".$getData[4]."',0,'nevyjadril')";
                if($conn->query($sql2) === FALSE)
                {
                    $msg = "Niekde sa stala chyba." . $conn->error;
                }
                else {
                    $msg = "CSV súbor bol úspešne nahratý.";
                }
            }else{$first=1;}
        }


    }



}
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
    <h1>Úvod</h1>
</header>

<div>

    <h2>Vloženie výsledkov</h2>
    <form method="post" action="uploadCsv.php" enctype="multipart/form-data">
        <label for="rok">Školský rok</label>
        <select name="rok" required>
            <option value="2018/2019">2018/2019</option>
            <option value="2017/2018">2017/2018</option>
        </select><br>
        <label for="predmet">Názov predmetu</label>
        <input type="text" name="predmet" title="Predmet" required><br>
        <label for="subor">CSV súbor s výsledkami</label>
        <input type="file" name="subor" required><br>
        <label for="oddelovac">Oddeľovač v CSV</label>
        <input type="text" name="oddelovac" size="1" pattern="[,;]{1}" title="Použite ; alebo ," required><br>
        <input type="submit" name="submit" value="Vložiť">
    </form>

    <?php
    if(isset($_POST["submit"])){
        echo "<h2><a href="."showTeams.php".">Zobraz výsledky</a></h2>";
    }


    

     echo $msg; ?>

</div>

</body>
</html>