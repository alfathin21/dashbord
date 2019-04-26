<?php
//setting header to json
header('Content-Type: application/json');

//database
// define('DB_HOST', '127.0.0.1');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', '');
// define('DB_NAME', 'mcdr');

//get connection
//$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// if(!$mysqli){
// 	die("Connection failed: " . $mysqli->error);
// }

include "config/connect.php";
include 'jsonwrapper.php';

// $ACType = $_POST["actype"];
// $ACReg = $_POST["acreg"];
// $DateStart = $_POST["datestart"];
// $DateEnd = $_POST["dateend"];
// $ATA = $_POST["ata"];
// $Fault_code = $_POST["fault_code"];
// $Keyword = $_POST["keyword"];
// $Pimas = $_POST["pima"];

//$query = "SELECT COUNT(DATE) as pirep, DATE_FORMAT(DATE, '%m-%Y') as DATE FROM tblpirep_swift WHERE ACTYPE LIKE ".$ACType."".$ACReg."".$ATA."".$Fault_code."".$Keyword."".$Pimas."".$DateStart."".$DateEnd." GROUP BY MONTH(DATE)";

$query = "SELECT COUNT(DATE) as pirep, DATE_FORMAT(DATE, '%m-%Y') as DATE FROM tblpirep_swift WHERE ACTYPE LIKE 'B737-800' GROUP BY MONTH(DATE)";

$result = mysqli_query($link, $query);

//execute query
//$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

print_r($data);

//free memory associated with result
//$result->close();

//close connection
//$mysqli->close();

//now print the data
//print json_encode($data);