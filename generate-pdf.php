<?php
include_once("config.php");
require_once("dompdf/autoload.inc.php");
use Dompdf\Dompdf;

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "UTF8");

$rok = $_GET["rok"];
$predmet = $_GET["predmet"];

$sql = "SELECT * FROM $predmet p WHERE p.skolskyrok = '$rok'";
$result = $conn->query($sql);

$sql2 = "DESCRIBE $predmet";
$result2 = $conn->query($sql2);
$filename = $predmet."-vysledky.pdf";

$dompdf = new Dompdf();

$html = '<html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
          body { font-family: Arial, sans-serif; }
          thead:before, thead:after { display: none; }
          tbody:before, tbody:after { display: none; }
          table {
              border-collapse: collapse;
              width: 100%;
            }
            table td, table th {
              border: 1px solid #ddd;
              padding: 4px;
            }
            table tr:nth-child(even){background-color: #f2f2f2;}
            table tr:hover {background-color: #ddd;}
            table th {
              padding-top: 8px;
              padding-bottom: 8px;
              text-align: left;
              background-color: #af7035;
              color: white;
            }
        </style>
        </head>
        <body><h1>'.str_replace("_", " ", $predmet).' - výsledky</h1>';
$html .= '<table><thead>';
while($row2 = $result2->fetch_assoc()){
    $html .= "<th>" . $row2["Field"] . "</th>";
}
$html .= "</thead><tbody><tr></tr>";
while($row = $result->fetch_assoc()){
    $html .= "<tr>";
    foreach ($row as $data){
        $html .= "<td>" . $data . "</td>";
    }
    $html .= "</tr>";
}
$html .= "</tbody></table></body></html>";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream($filename, array('Attachment'=>0));

$conn->close();
?>