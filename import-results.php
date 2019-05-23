<?php
include_once("config/config.php");
include "config/config-lang.php";

if (!isset($_SESSION['type'])) {
    header("Location: login.php");
}else if($_SESSION['type'] != "admin"){
    header("Location: index.php");
}

$conn = new mysqli($servername, $usernameSQL, $passwordSQL, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "UTF8");

if (isset($_POST["submit"])) {

    $filename = $_FILES["subor"]["tmp_name"];
    $delim = $_POST["oddelovac"];
    $predmet = str_replace(" ", "_", $_POST["predmet"]);
    $rok = $_POST["rok"];

    $exist = "SELECT * FROM $predmet";
    $result0 = $conn->query($exist);
    if ($result0->num_rows == 0) {
        $create = "CREATE TABLE $predmet (
                    `skolskyrok` varchar(15) NOT NULL,
                    `ID` int(11) NOT NULL,
                    `meno` varchar(30) NOT NULL,
                    `cv1` varchar(10) DEFAULT NULL,
                    `cv2` varchar(10) DEFAULT NULL,
                    `cv3` varchar(10) DEFAULT NULL,
                    `cv4` varchar(10) DEFAULT NULL,
                    `cv5` varchar(10) DEFAULT NULL,
                    `cv6` varchar(10) DEFAULT NULL,
                    `cv7` varchar(10) DEFAULT NULL,
                    `cv8` varchar(10) DEFAULT NULL,
                    `cv9` varchar(10) DEFAULT NULL,
                    `cv10` varchar(10) DEFAULT NULL,
                    `cv11` varchar(10) DEFAULT NULL,
                    `Z1` varchar(10) DEFAULT NULL,
                    `Z2` varchar(10) DEFAULT NULL,
                    `VT` varchar(10) DEFAULT NULL,
                    `SKT` varchar(10) DEFAULT NULL,
                    `SKP` varchar(10) DEFAULT NULL,
                    `Spolu` varchar(10) DEFAULT NULL,
                    `Známka` varchar(5) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        if ($conn->query($create) === TRUE) {
            if ($_FILES["subor"]["size"] > 0) {
                $file = fopen($filename, "r");
                fgetcsv($file, 10000, $delim);
                while (($getData = fgetcsv($file, 10000, $delim)) !== FALSE) {
                    $sql = "INSERT INTO $predmet (skolskyrok, ID, meno, cv1, cv2, cv3, cv4, cv5, cv6, cv7, cv8, cv9, cv10, cv11, Z1, Z2, VT, SKT, SKP, Spolu, Známka)
                            VALUES ('" . $rok . "','" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "','" . $getData[3] . "','" . $getData[4] . "','" . $getData[5] . "','" . $getData[6] . "','" . $getData[7] . "','" . $getData[8] . "','" . $getData[9] . "','" . $getData[10] . "','" . $getData[11] . "','" . $getData[12] . "','" . $getData[13] . "','" . $getData[14] . "','" . $getData[15] . "','" . $getData[16] . "','" . $getData[17] . "','" . $getData[18] . "','" . $getData[19] . "')";
                    $msg = "Záznamy boli vložené.";

                    if ($conn->query($sql) === FALSE) {
                        $msg = "Niekde sa stala chyba." . $conn->error;
                    } else {
                        $msg = "CSV súbor bol úspešne nahratý.";
                    }
                }
                fclose($file);
            }
        } else {
            echo $conn->error;
        }
    } else {
        if ($_FILES["subor"]["size"] > 0) {
            $file = fopen($filename, "r");
            fgetcsv($file, 10000, $delim);
            while (($getData = fgetcsv($file, 10000, $delim)) !== FALSE) {
                $check = "SELECT * FROM $predmet p WHERE p.skolskyrok = '$rok' AND p.ID = '$getData[0]'";
                $result = $conn->query($check);

                if ($row = $result->fetch_assoc()) {
                    if ($row["skolskyrok"] == $rok && $row["ID"] == $getData[0]) {
                        $sql = "UPDATE $predmet p SET p.cv1 = '$getData[2]', p.cv2 = '$getData[3]', p.cv3 = '$getData[4]', p.cv4 = '$getData[5]',
                        p.cv5 = '$getData[6]', p.cv6 = '$getData[7]', p.cv7 = '$getData[8]', p.cv8 = '$getData[9]', p.cv9 = '$getData[10]',
                        p.cv10 = '$getData[11]', p.cv11 = '$getData[12]', p.Z1 = '$getData[13]', p.Z2 = '$getData[14]', p.VT = '$getData[15]',
                        p.SKT = '$getData[16]', p.SKP = '$getData[17]', p.Spolu = '$getData[18]', p.Známka = '$getData[19]'
                        WHERE p.skolskyrok = '$rok' AND p.ID = '$getData[0]'";
                        $msg = "Záznamy boli aktualizované.";
                    }
                } else {
                    $sql = "INSERT INTO $predmet (skolskyrok, ID, meno, cv1, cv2, cv3, cv4, cv5, cv6, cv7, cv8, cv9, cv10, cv11, Z1, Z2, VT, SKT, SKP, Spolu, Známka)
               VALUES ('" . $rok . "','" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "','" . $getData[3] . "','" . $getData[4] . "','" . $getData[5] . "','" . $getData[6] . "','" . $getData[7] . "','" . $getData[8] . "','" . $getData[9] . "','" . $getData[10] . "','" . $getData[11] . "','" . $getData[12] . "','" . $getData[13] . "','" . $getData[14] . "','" . $getData[15] . "','" . $getData[16] . "','" . $getData[17] . "','" . $getData[18] . "','" . $getData[19] . "')";
                    $msg = "Záznamy boli vložené.";
                }

                if ($conn->query($sql) === FALSE) {
                    $msg = "Niekde sa stala chyba." . $conn->error;
                } else {
                    $msg = "CSV súbor bol úspešne nahratý.";
                }
            }

            fclose($file);
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - <?php echo $lang['import'] ?></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/css/mdb.min.css"/>

    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style/style.css">

</head>
<body class="bg-light">
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php"><?php echo $lang['home'] ?></a>
        </li>
        <?php
        echo '<li class="nav-item">
				        <a class="nav-link" href="show-results.php">' . $lang['zadanie2'] . '</a>
                        </li>';
        echo '<li class="nav-item active">
				        <a class="nav-link" href="import-results.php">' . $lang['zadanie3'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="delete-results.php">' . $lang['zadanie4'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="showTeams.php">' . $lang['zadanie5'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="uploadCsv.php">' . $lang['zadanie6'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="exportToCsv.php">' . $lang['zadanie7'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="readCSV.php">' . $lang['zadanie8'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="autori.php">' . $lang['authors'] . '</a>
                        </li>';

        ?>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="scripts/logout.php"><?php echo $lang['logout'] ?></a>
        </li>
    </ul>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3">
            <form method="post" action="import-results.php" enctype="multipart/form-data" class="border border-light p-5">
                <p class="h2 mb-1 text-center"><?php echo $lang['import'] ?></p>
                <label for="rok"><?php echo $lang['year'] ?></label>
                <select name="rok" id="rok" class="browser-default custom-select mb-2" required>
                    <option selected disabled><?php echo $lang['default_select']?></option>
                    <option value="2018/2019">2018/2019</option>
                    <option value="2017/2018">2017/2018</option>
                </select><br>
                <label for="predmet"><?php echo $lang['subjectname'] ?></label>
                <input type="text" id="predmet" name="predmet" class = 'form-control mb-1' required><br>
                <div class="input-group mb-1">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="subor" id="subor"
                               aria-describedby="fileInput">
                        <label class="custom-file-label" for="subor"><?php echo $lang['filename'] ?></label>
                    </div>
                </div>
                <label for="oddelovac"><?php echo $lang['delimeter'] ?></label>
                <input type="text" id="oddelovac" name="oddelovac" size="1" pattern="[,;]{1}" title="Použite ; alebo ," class="form-control mb-1" required><br>
                <div class="text-center"><input type="submit" class="btn btn-primary"
                                                value="<?php echo $lang['import1'] ?>" name="submit"></div>
            </form>
            <?php echo $msg; ?>
        </div>
    </div>
</div>
<div class="footer bg-dark">
    <a href="import-results.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
    | <a href="import-results.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
<!-- MDB core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>
</body>
</html>