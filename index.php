<?php

include_once 'vendor/autoload.php';

print_R(PDO::getAvailableDrivers());

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

phpinfo();

use Medoo\Medoo;

$medooObject = [
    "database_type" => "mssql",
    "database_name" => "OSP_DATASTAT",
    "server" => "51.178.76.132",
    "driver" => "FreeTDS",
    "username" => "edaubin",
    "password" => "td5dakDN5u",
];

$myPDO = new \Medoo\Medoo($medooObject);

$response = $myPDO->query("SELECT TOP 10 FROM ospharea_crm")->fetchAll(\PDO::FETCH_ASSOC);

echo "<pre>";
print_r($response[0]);

phpinfo();
?>