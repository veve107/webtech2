<?php
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
    <title>zadanie</title>
</head>
<body>
<form action="readCSV.php" method="post" enctype="multipart/form-data">
    <label for="CSVfileToUpload">Vlozte subor CSV: </label>
    <input type="file" name="CSVfileToUpload" id="CSVfileToUpload" required>
    <label for="delimeter">Vlozte oddelovac: </label>
    <input type="text" name="delimeter" id="delimeter" required>
    <input type="submit" value="Odoslat" name="submit">
</form>
<?php

if ($newCSVName != null) {
    echo "<a href='output/$newCSVName'>download</a>";
}
?>
</body>
</html>
