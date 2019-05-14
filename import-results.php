<?php
include_once("config.php");
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "UTF8");

if(isset($_POST["submit"])){

    $filename = $_FILES["subor"]["tmp_name"];
    $delim = $_POST["oddelovac"];
    $predmet = $_POST["predmet"];
    $rok = $_POST["rok"];

    if($_FILES["subor"]["size"] > 0){
        $file = fopen($filename, "r");
        fgetcsv($file, 10000, $delim);
        while (($getData = fgetcsv($file, 10000, $delim)) !== FALSE){
            $check = "SELECT * FROM $predmet p WHERE p.skolskyrok = '$rok' AND p.ID = '$getData[0]'";
            $result = $conn->query($check);

            if($row = $result->fetch_assoc()){
                if($row["skolskyrok"] == $rok && $row["ID"] == $getData[0]){
                    echo $msg = "Záznam už existuje.";
                    $sql = "UPDATE $predmet p SET p.cv1 = '$getData[2]', p.cv2 = '$getData[3]', p.cv3 = '$getData[4]', p.cv4 = '$getData[5]',
                            p.cv5 = '$getData[6]', p.cv6 = '$getData[7]', p.cv7 = '$getData[8]', p.cv8 = '$getData[9]', p.cv9 = '$getData[10]',
                            p.cv10 = '$getData[11]', p.cv11 = '$getData[12]', p.Z1 = '$getData[13]', p.Z2 = '$getData[14]', p.VT = '$getData[15]',
                            p.SKT = '$getData[16]', p.SKP = '$getData[17]', p.Spolu = '$getData[18]', p.Známka = '$getData[19]'
                            WHERE p.skolskyrok = '$rok' AND p.ID = '$getData[0]'";
                }
            }else{
                $sql = "INSERT INTO $predmet (skolskyrok, ID, meno, cv1, cv2, cv3, cv4, cv5, cv6, cv7, cv8, cv9, cv10, cv11, Z1, Z2, VT, SKT, SKP, Spolu, Známka)
                   VALUES ('".$rok."','".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','".$getData[9]."','".$getData[10]."','".$getData[11]."','".$getData[12]."','".$getData[13]."','".$getData[14]."','".$getData[15]."','".$getData[16]."','".$getData[17]."','".$getData[18]."','".$getData[19]."')";

            }

            if($conn->query($sql) === FALSE)
            {
                $msg = "Niekde sa stala chyba." . $conn->error;
            }
            else {
                $msg = "CSV súbor bol úspešne nahratý.";
            }
        }

        fclose($file);
    }
}

$conn->close();
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
    <form method="post" action="import-results.php" enctype="multipart/form-data">
        <label for="rok">Školský rok</label>
        <select name="rok" required>
            <option value="2018/2019">2018/2019</option>
            <option value="2017/2018">2017/2018</option>
        </select><br>
        <label for="predmet">Názov predmetu</label>
        <select name="predmet" required>
            <option value="webtech1">Webové technológie 1</option>
            <option value="webtech2">Webové technológie 2</option>
        </select><br>
        <label for="subor">CSV súbor s výsledkami</label>
        <input type="file" name="subor" required><br>
        <label for="oddelovac">Oddeľovač v CSV</label>
        <input type="text" name="oddelovac" size="1" pattern="[,;]{1}" title="Použite ; alebo ," required><br>
        <input type="submit" name="submit" value="Vložiť">
    </form>

    <h2><a href="show-results.php">Zobraz výsledky</a></h2>

    <?php echo $msg; ?>

</div>

</body>
</html>