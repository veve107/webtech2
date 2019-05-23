<?php
include "config/config-lang.php";
include "scripts/sendMail.php";
include_once "config/config.php";
require_once 'vendor/autoload.php';

if (!isset($_SESSION['type'])) {
    header("Location: login.php");
} else if ($_SESSION['type'] != "admin") {
    header("Location: index.php");
}
$newCSVName = null;
if (isset($_POST['submit'])) {
    if (!file_exists("output/" . $_FILES['CSVfileToUpload']['name'])) {
        $delimeter = $_POST['delimeter'];
        $row = 0;
        $tempArr = array();
        $date = date('d_m_Y_His');
        $directoryName = 'output/';
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
        $info = LDAPConnect($_POST['username'], $_POST['password']);
        if ($info == null) {
            $newCSVName = $_FILES['CSVfileToUpload']['name'];
        } else {
            $conn = mysqli_connect($servername, $usernameSQL, $passwordSQL, $db);
            $sender = $info[0]["cn"][0];
            $delimeter = $_POST['delimeter'];
            $row = 0;
            $tempArr = array();
            $headers = array();
            if (($handle = fopen($_FILES['CSVfileToUpload']['tmp_name'], "r")) !== false) {
                while (($data = fgetcsv($handle, 1000, $delimeter)) !== false) {
                    $i = 0;
                    $template = file_get_contents("scripts/template.html");
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
                        $tempArr['sender'] = $sender;
                        foreach ($tempArr as $key => $value) {
                            $template = str_replace('{{' . $key . '}}', $value, $template);
                        }
                        $meno = $tempArr['Meno'];
                        $sql = "insert into maily(meno_studenta, predmet, id_sablony) values('" . $meno . "', '" . $_POST['subjectMail'] . "', 1)";
                        $conn->query($sql);
                        sendMail($template, $sender, $tempArr['Email']);
                    }
                    $row += 1;
                }
            }
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
    <title>Úloha 3</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">

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

</head>
<body class="bg-light">
<nav class="navbar navbar-expand-sm bg-dark navbar-dark mb-4">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php"><?php echo $lang['home'] ?></a>
        </li>
        <?php
        echo '<li class="nav-item">
				        <a class="nav-link" href="show-results.php">' . $lang['zadanie2'] . '</a>
                        </li>';
        echo '<li class="nav-item">
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
        echo '<li class="nav-item active">
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
            <form action="readCSV.php" method="post" enctype="multipart/form-data" class="border border-light p-5">
                <p class="h2 mb-4 text-center"><?php echo $lang['import3'] ?></p>
                <?php
                if ($newCSVName != null) {
                    echo '<div class="text-center mb-1"><a href="output/' . $newCSVName . '" class="btn btn-primary"><i class="fa fa-download"></i> ' . $lang['download'] . '</a></div>';
                }
                ?>
                <div class="input-group mb-1">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="CSVfileToUpload" id="CSVfileToUpload"
                               aria-describedby="fileInput">
                        <label class="custom-file-label" for="CSVfileToUpload"><?php echo $lang['filename'] ?></label>
                    </div>
                </div>
                <label for="delimeter"><?php echo $lang['delimeter'] ?>: </label>
                <input type="text" class="form-control mb-1" name="delimeter" id="delimeter" value=";" required>
                <?php
                if ($newCSVName != null) {
                    echo "<label for='username'>" . $lang['username'] . ": </label>";
                    echo "<input type='text' class = 'form-control mb-1' name='username' id='username' required>";
                    echo "<label for='password'>" . $lang['password'] . ": </label>";
                    echo "<input type='password' class = 'form-control mb-1' name='password' id='password' required>";
                    echo "<label for='subjectMail'>" . $lang['subjectMail'] . ": </label>";
                    echo "<input type='text' class = 'form-control mb-1' name='subjectMail' id='subjectMail' value='Predmet' required>";
                    echo "<label for='attachment'>" . $lang['attachment'] . ": </label>";
                    echo '<div class="input-group mb-1">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input"  name = "attachment" id="fileInput" aria-describedby="fileInput">
                                    <label class="custom-file-label" for="fileInput">' . $lang['filename'] . '</label>
                                </div>
                            </div>';
                }
                ?>
                <div class="text-center"><input type="submit" class="btn btn-primary"
                                                value="<?php echo $lang['send'] ?>" name="submit"></div>
            </form>
        </div>
        <div>
            <?php
            $conn = mysqli_connect($servername, $usernameSQL, $passwordSQL, $db);
            $sql = "select * from maily";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<p class=\"h2 mb-4 text-center mt-5\">".$lang['sentEmails']."</p>";
                echo "<table class='table table-striped'>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>" . $lang['sendDate'] . "</th>
                                <th>" . $lang['students_name'] . "</th>
                                <th>" . $lang['subject'] . "</th>
                                <th>" . $lang['idTemplate'] . "</th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = $result->fetch_row()) {
                    echo "<tr>
                                <td>" . $row[0] . "</td>
                                <td>" . $row[1] . "</td>
                                <td>" . $row[2] . "</td>
                                <td>" . $row[3] . "</td>
                                <td>" . $row[4] . "</td>
                            </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<h2>" . $lang['noData'] . "</h2>";
            }
            ?>
        </div>
    </div>
</div>
<br>
<br>
<div class="footer bg-dark">
    <a href="readCSV.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
    | <a href="readCSV.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
<!-- MDB core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>
</body>
</html>
