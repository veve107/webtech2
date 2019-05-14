<?php 
	include "config-lang.php"; 
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
			<div class="col-md-10 col-md-offset-3">
				<h1 class="text-center"><?php echo $lang['title'] ?></h1>
				<p>
				<?php echo $lang['text'] ?>
				</p>
			</div>
		</div>
	</div><!-- -->

	<div class="footer bg-dark">
	<a href="index.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
	| <a href="index.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
	</div>
</body>
</html>