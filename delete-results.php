<?php
include_once("config.php");
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "UTF8");
if(isset($_POST["submit"])){
    $predmet = str_replace(" ", "_", $_POST["predmet"]);
    $rok = $_POST["rok"];

    $exist = "SELECT * FROM $predmet";
    $result0 = $conn->query($exist);
    if($result0->num_rows == 0){
        $msg = "Zadaný predmet neexistuje.";
    }else{
        $sql = "DROP TABLE $predmet";
        if($conn->query($sql) === TRUE);{
            $msg = "Predmet " . str_replace("_", " ", $_POST["predmet"]) . " bol vymazaný.";
        }
    }

}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Vymazanie predmetu</title>
</head>
<body>
<header>
    <h1>Úvod</h1>
</header>

<div>

    <h2>Vymazanie predmetu</h2>
    <form method="post" action="delete-results.php">
        <label for="predmet">Názov predmetu</label>
        <input type="text" name="predmet" required><br>
        <input type="submit" name="submit" value="Vymazať">
    </form>

    <?php
        echo $msg;
    ?>
    <h2><a href="import-results.php">Späť</a></h2>
</div>

</body>
</html>
