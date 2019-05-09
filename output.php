<?php 
	include "config.php"; 
?>

<?php
$file = fopen('file.csv', 'r');
while (($line = fgetcsv($file, 0, ";")) !== FALSE) {
	$Zapocet = $line[2] + $line[3] + $line[4] + $line[5] + $line[6] + $line[7] + $line[8] + $line[9] + $line[10] + $line[11] + $line[12] + $line[13] + $line[14];
	$Projekt = $line[16]  + $line[17];
	$Test =  $line[15];
	$Dotaznik = 0;
	$Bonus = 0;
	$Sucet = $line[18];
	$Znamka = $line[19];
  //print_r($line);
}
fclose($file);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php echo $lang['title'] ?></title>
	<link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
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
				<a class="nav-link" href="output.php"><?php echo $lang['zadanie1'] ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#"><?php echo $lang['zadanie2'] ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#"><?php echo $lang['zadanie3'] ?></a>
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
				<h4><?php echo $lang['table'] ?></h4>
				<table class="table table-dark text-center">
                <thead>
                    <tr>
                    <th scope="col">Zápočet</th>
                    <th scope="col">Projekt</th>
                    <th scope="col">Test</th>
                    <th scope="col">Dotazník</th>
                    <th scope="col">Bonus</th>
                    <th scope="col">Súčet</th>
                    <th scope="col">Známka</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td><?php echo $Zapocet;?></td>
                    <td><?php echo $Projekt;?></td>
                    <td><?php echo $Test;?></td>
                    <td><?php echo $Dotaznik;?></td>
					<td><?php echo $Bonus;?></td>
                    <td><?php echo $Sucet;?></td>
                    <td><?php echo $Znamka;?></td>
                    <!--<td>A/B/C/D/E/FX</td>-->
                    </tr>
                </tbody>
                </table>

			</div>
		</div>
	</div><!-- -->

	<div class="footer bg-dark">
	<a href="output.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
	| <a href="output.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
	</div>
</body>
</html>