<?php

include_once 'vendor/autoload.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

print_R(PDO::getAvailableDrivers());

$d = new RecDir("/app",false);
echo "Path: " . $d->getRootPath() . "\n";
while (false !== ($entry = $d->read())) {
    echo $entry."\n";
}
$d->close();

$d = new RecDir("/app/.apt/opt/microsoft/msodbcsql18/lib64/",false);
echo "Path: " . $d->getRootPath() . "\n";
while (false !== ($entry = $d->read())) {
    echo $entry."\n";
}
$d->close();

$serverName = "51.178.76.132\\sqlexpress"; //serverName\instanceName
$connectionInfo = array( "Database"=>"OSP_DATASTAT", "UID"=>"edaubin", "PWD"=>"td5dakDN5u");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
    echo "Connection established.<br />";
}else{
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}

phpinfo();

use Medoo\Medoo;

$medooObject = [
    "database_type" => "mssql",
    "database_name" => "OSP_DATASTAT",
    "server" => "51.178.76.132",
    "username" => "edaubin",
    "password" => "td5dakDN5u",
];

$myPDO = new \Medoo\Medoo($medooObject);

$response = $myPDO->query("SELECT TOP 10 FROM ospharea_crm")->fetchAll(\PDO::FETCH_ASSOC);

echo "<pre>";
print_r($response[0]);

phpinfo();
?>