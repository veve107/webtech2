<?php
include "config/config-lang.php";
include_once "config/config.php";

if (!isset($_SESSION['type'])) {
    header("Location: login.php");
} else if ($_SESSION['type'] != "student") {
    header("Location: index.php");
}

//include "session.php";
$conn = new mysqli($servername, $usernameSQL, $passwordSQL, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "UTF8");

$sql = "SHOW TABLES FROM $db";
$result0 = mysqli_query($conn, $sql);

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
        echo '<li class="nav-item active">
				        <a class="nav-link" href="show-output.php">' . $lang['zadanie1'] . '</a>
                        </li>';
        echo '<li class="nav-item">
				        <a class="nav-link" href="uloha2_student.php">' . $lang['points_split'] . '</a>
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
        <div class="col-md-20 col-md-offset-3">
            <p class="h2 mb-4 text-center mt-4"><?php echo $lang['zadanie2'] ?></p>
            <?php
            //funcna verzia
            foreach ($array as $value) {
                if ($value == "webtech1") {

                    //ziskat id zo systemu po prihlaseni
                    $myID = $_SESSION["id"];

                    //testovacie Idecka
                    //$myID = "23546";
                    //$myID = "80035";
                    //$myID = "14520";

                    $result = $conn->query("SELECT * FROM webtech1 p WHERE p.ID = '$myID'");

                    if ($result->num_rows > 0) {
                        $value = str_replace("_", " ", $value);
                        echo "<table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>cv1</th>
                                    <th>cv2</th>
                                    <th>cv3</th>
                                    <th>cv4</th>
                                    <th>cv5</th>
                                    <th>cv6</th>
						            <th>cv7</th>
						            <th>cv8</th>
						            <th>cv9</th>
						            <th>cv10</th>
						            <th>cv11</th>
						            <th>Z1</th>
						            <th>Z2</th>
						            <th>VT</th>
						            <th>SKT</th>
						            <th>SKP</th>
						            <th>" . $lang['together'] . "</th>
						            <th>" . $lang['mark'] . "</th>
                                </tr>
                            </thead>
                            <tbody>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<h4>" . $value . " - {$row['skolskyrok']}</h4>
                                <tr>
                                    <td>{$row['cv1']}</td>
                                    <td>{$row['cv2']}</td>
                                    <td>{$row['cv3']}</td>
                                    <td>{$row['cv4']}</td>
                                    <td>{$row['cv5']}</td>
                                    <td>{$row['cv6']}</td>
                                    <td>{$row['cv7']}</td>
                                    <td>{$row['cv8']}</td>
                                    <td>{$row['cv9']}</td>
                                    <td>{$row['cv10']}</td>
                                    <td>{$row['cv11']}</td>
                                    <td>{$row['Z1']}</td>
                                    <td>{$row['Z2']}</td>
                                    <td>{$row['VT']}</td>
                                    <td>{$row['SKT']}</td>
                                    <td>{$row['SKP']}</td>
                                    <td>{$row['Spolu']}</td>
                                    <td>{$row['Známka']}</td>
                                <tr>";
                        }
                        echo "</tbody>
                    </table>";
                        continue;
                    } else {
                        continue;
                    }
                    $conn->close();
                }
            }
            ?>
        </div>
    </div>
</div>

<div class="footer bg-dark">
    <a href="show-output.php?lang=sk"><img src='https://restcountries.eu/data/svk.svg' width='40px'/></a>
    | <a href="show-output.php?lang=en"><img src='https://restcountries.eu/data/gbr.svg' width='40px'/></a>
</div>
<!-- MDB core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.0/js/mdb.min.js"></script>
</body>
</html>
