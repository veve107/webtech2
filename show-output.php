<?php 
    include "config-lang.php";
	include "config.php"; 
	//include "session.php";
    $conn = new mysqli($servername, $username, $password, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_set_charset($conn, "UTF8");

	$sql = "SHOW TABLES FROM $db";
	$result0 = mysqli_query($conn,$sql);

	$i = 0;
	while ($row0 = mysqli_fetch_row($result0)) {
		$array[$i] = $row0[0];
		$i += 1;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php echo $lang['title'] ?></title>
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
			<div class="col-md-20 col-md-offset-3">

				<?php
				//ziskat id zo systemu po prihlaseni
				//$ID = "SELECT ID FROM $value";
				//$myID = $conn->query($ID);
				
				//testovacie Idecka
				//$myID = "23546";
				$myID = "12345";
				//$myID = "14520";

				foreach ($array as $value) {
					if ($value == "studenti"){
						continue;
					};
										
					$result = $conn->query("SELECT * FROM $value p WHERE p.ID = '$myID'");
					
					if ( $result->num_rows > 0 ){
						//var_dump($result);
						$value = str_replace("_", " ", $value);
						echo "<table class='table table-dark text-center'><thead><tr><th>cv1</th><th>cv2</th><th>cv3</th><th>cv4</th><th>cv5</th><th>cv6</th>
						<th>cv7</th><th>cv8</th><th>cv9</th><th>cv10</th><th>cv11</th><th>Z1</th><th>Z2</th><th>VT</th><th>SKT</th><th>SKP</th><th>"
						. $lang['together'] . "</th><th>" . $lang['mark'] . "</th></tr></thead><tbody>";
						while($row = $result->fetch_assoc()) {
							echo "<h4>" . $value . " - {$row['skolskyrok']}</h4><tr><td>{$row['cv1']}</td><td>{$row['cv2']}</td><td>{$row['cv3']}</td>
							<td>{$row['cv4']}</td><td>{$row['cv5']}</td><td>{$row['cv6']}</td><td>{$row['cv7']}</td><td>{$row['cv8']}</td><td>{$row['cv9']}</td>
							<td>{$row['cv10']}</td><td>{$row['cv11']}</td><td>{$row['Z1']}</td><td>{$row['Z2']}</td><td>{$row['VT']}</td><td>{$row['SKT']}</td>
							<td>{$row['SKP']}</td><td>{$row['Spolu']}</td><td>{$row['Známka']}</td><tr>";
						}
						echo "</tbody></table>";
						continue;
					}else{
						continue;
					}
					$conn->close();
				}
				?>			
			</div>
		</div>
	</div>

	<div class="footer bg-dark">
	<a href="show-output.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
	| <a href="show-output.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
	</div>
</body>
</html>
