<?php
include_once("config.php");
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "UTF8");

if(isset($_POST["submit"])){
    $predmet = $_POST["predmet"];
    $rok = $_POST["rok"];

    $sql = "SELECT * FROM $predmet p WHERE p.skolskyrok = '$rok'";
    $result = $conn->query($sql);

    $sql2 = "DESCRIBE $predmet";
    $result2 = $conn->query($sql2);
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Zobrazenie výsledkov</title>
</head>
<body>
<header>
    <h1>Úvod</h1>
</header>

<div>

    <h2>Zobrazenie výsledkov</h2>
    <form method="post" action="show-results.php">
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
        <input type="submit" name="submit" value="Zobraziť">
    </form>

    <?php
    if($result->num_rows > 0){
        echo "<table><thead>";
        while($row2 = $result2->fetch_assoc()){
            echo "<th>" . $row2["Field"] . "</th>";
        }
        echo "</thead><tbody>";
        while($row = $result->fetch_assoc()){
            echo "<tr>";
            foreach ($row as $data){
                echo "<td>" . $data . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "<a href='generate-pdf.php?rok=$rok&predmet=$predmet' target='_blank'>Generovať PDF</a>";
    }else{
        echo "<p>Nenašli sa žiadne záznamy.</p>";
    }

        $conn->close();
    ?>
    <h2><a href="import-results.php">Späť</a></h2>
</div>

</body>
</html>
