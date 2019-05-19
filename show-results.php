<?php
include_once("config.php");
include "config-lang.php";
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
        $sql = "SELECT * FROM $predmet p WHERE p.skolskyrok = '$rok'";
        $result = $conn->query($sql);

        $sql2 = "DESCRIBE $predmet";
        $result2 = $conn->query($sql2);
        $msg = "Nenašli sa žiadne záznamy.";
    }

}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - <?php echo $lang['show'] ?></title>
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
			<li class="nav-item">
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
        <div class="col-md-4 col-md-offset-3">
        <h2><?php echo $lang['show'] ?></h2>
        <form method="post" action="show-results.php">
            <label for="rok"><?php echo $lang['year'] ?></label>
            <select name="rok" required>
                <option value="2018/2019">2018/2019</option>
                <option value="2017/2018">2017/2018</option>
            </select><br>
            <label for="predmet"><?php echo $lang['subjectname'] ?></label>
            <input type="text" name="predmet" required><br>
            <input type="submit" name="submit" value="<?php echo $lang['show1'] ?>">
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
            echo $msg;
        }

            $conn->close();
        ?>
        </div>
    </div>
</div>
<div class="footer bg-dark">
<a href="show-results.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
| <a href="show-results.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
</body>
</html>
