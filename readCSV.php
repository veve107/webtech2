<?php

include "config-lang.php"; 

$newCSVName = null;
if (isset($_POST['submit'])) {
    if (!file_exists("output/" . $_FILES['CSVfileToUpload']['name'])) {
        $delimeter = $_POST['delimeter'];
        $row = 0;
        $tempArr = array();
        $date = date('d_m_Y_His');
        $directoryName = './output/';
        $newCSVName = 'outputCSV_' . $date . ".csv";
        if (($handle = fopen($_FILES['CSVfileToUpload']['tmp_name'], "r")) !== false) {
            $writeCSV = fopen($directoryName . $newCSVName, 'w');
            while (($data = fgetcsv($handle, 1000, $delimeter)) !== false) {
                $newArr = array();
                foreach ($data as $line) {
                    array_push($newArr, $line);
                }
                if ($row == 0) {
                    array_push($newArr, 'heslo');
                    array_push($newArr, 'verejnaIP');
                    array_push($newArr, 'privatnaIP');
                    array_push($newArr, 'ssh');
                    array_push($newArr, 'http');
                    array_push($newArr, 'https');
                    array_push($newArr, 'misc1');
                    array_push($newArr, 'misc2');
                } else {
                    array_push($newArr, randomPassword(15));
                    array_push($newArr, '147.175.121.210');
                    array_push($newArr, '192.168.0.' . $row);
                    array_push($newArr, '2201');
                    array_push($newArr, '8001');
                    array_push($newArr, '4401');
                    array_push($newArr, '9001');
                    array_push($newArr, '1901');
                }
                $row += 1;
                fputcsv($writeCSV, $newArr, $delimeter);
            }
            fclose($handle);
        }
    } else {
        $delimeter = $_POST['delimeter'];
        $row = 0;
        $tempArr = array();
        $headers = array();
        if (($handle = fopen($_FILES['CSVfileToUpload']['tmp_name'], "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, $delimeter)) !== false) {
                $i = 0;
                $template = file_get_contents("template.html");
                if ($row == 0) {
                    foreach ($data as $line) {
                        $tempArr[$line] = "";
                        array_push($headers, $line);
                    }
                } else {
                    foreach ($data as $line) {
                        $tempArr[$headers[$i]] = $line;
                        $i += 1;
                    }
                    $tempArr['sender'] = "V. Patkova";
                    foreach($tempArr as $key => $value){
                        $template = str_replace('{{'.$key.'}}', $value, $template);
                    }
                    // Always set content-type when sending HTML email
                    $mailHeaders = "MIME-Version: 1.0" . "\r\n";
                    $mailHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    //echo mail("w565367@nwytg.net", "Test odosielania", $template, $mailHeaders);
                }
                $row += 1;            }
        }
    }
}

function randomPassword($len = 8)
{
    //enforce min length 8
    if ($len < 8)
        $len = 8;

    //define character libraries - remove ambiguous characters like iIl|1 0oO
    $sets = array();
    $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    $sets[] = '23456789';

    $password = '';

    //append a character from each set - gets first 4 characters
    foreach ($sets as $set) {
        $password .= $set[array_rand(str_split($set))];
    }

    //use all characters to fill up to $len
    while (strlen($password) < $len) {
        //get a random set
        $randomSet = $sets[array_rand($sets)];

        //add a random char from the random set
        $password .= $randomSet[array_rand(str_split($randomSet))];
    }

    //shuffle the password string before returning!
    return str_shuffle($password);
}

?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>zadanie</title><link rel="stylesheet" href="bootstrap.min.css">
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
			<div class="col-md-6 col-md-offset-3">
            <h2><?php echo $lang['import3'] ?></h2>
            <form action="readCSV.php" method="post" enctype="multipart/form-data">
                <label for="CSVfileToUpload"><?php echo $lang['import3'] ?>: </label>
                <input type="file" name="CSVfileToUpload" id="CSVfileToUpload" required><br>
                <label for="delimeter"><?php echo $lang['delimeter'] ?>: </label>
                <input type="text" name="delimeter" id="delimeter" required><br>
                <input type="submit" value="<?php echo $lang['send'] ?>" name="submit">
            </form>
            <?php

            if ($newCSVName != null) {
                echo "<a href='output/$newCSVName'>download</a>";
            }
            ?>
            </div>
        </div>
    </div>
    <div class="footer bg-dark">
	<a href="readCSV.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
	| <a href="readCSV.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
	</div>
</body>
</html>
