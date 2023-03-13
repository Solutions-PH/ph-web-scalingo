<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

phpinfo();

$medooObject = [
    "database_type" => "mssql",
    "database_name" => "OSP_DATASTAT",
    "server" => "51.178.76.132",
    "username" => "edaubin",
    "password" => "td5dakDN5u",
];
if ($_SERVER["SERVER_NAME"] != "atlas.test") {
  //  $medooObject["driver"] = "dblib";
}

$myPDO = new \Medoo\Medoo($medooObject);

$response = $myPDO->query("SELECT TOP 10 FROM ospharea_crm")->fetchAll(\PDO::FETCH_ASSOC);

echo "<pre>";
print_r($response[0]);

phpinfo();
?>