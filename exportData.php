<?php

/*Tato stranka nema mat okno*/

include_once("config.php");

$conn;
try{
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
}
catch(PDOException $e){
    echo "Chyba pripojenia " . $e->getMessage();
}
$table=$_GET["table"];

$sql="SELECT * FROM `".$table."`";
$result = $conn->query($sql)->fetchAll();

$delimiter = $_POST["oddelovac"];
$filename = $_POST["nazov"] . ".csv";

$f = fopen('php://memory', 'w');

$fields = array('ID', 'Meno', 'Body');
fputcsv($f, $fields, $delimiter);


foreach ($result as $row) {
    $lineData = array($row['id'], $row['meno'], $row['body']);
    fputcsv($f, $lineData, $delimiter);
    
}

fseek($f, 0);
    
    
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
    
fpassthru($f);

exit;
?>