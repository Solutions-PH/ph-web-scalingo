<?php

include_once 'vendor/autoload.php';

class RecDir
{
    protected $currentPath;
    protected $slash;
    protected $rootPath;
    protected $recursiveTree;

    function __construct($rootPath,$win=false)
    {
        switch($win)
        {
            case true:
                $this->slash = '\\';
                break;
            default:
                $this->slash = '/';
        }
        $this->rootPath = $rootPath;
        $this->currentPath = $rootPath;
        $this->recursiveTree = array(dir($this->rootPath));
        $this->rewind();
    }

    function __destruct()
    {
        $this->close();
    }

    public function close()
    {
        while(true === ($d = array_pop($this->recursiveTree)))
        {
            $d->close();
        }
    }

    public function closeChildren()
    {
        while(count($this->recursiveTree)>1 && false !== ($d = array_pop($this->recursiveTree)))
        {
            $d->close();
            return true;
        }
        return false;
    }

    public function getRootPath()
    {
        if(isset($this->rootPath))
        {
            return $this->rootPath;
        }
        return false;
    }

    public function getCurrentPath()
    {
        if(isset($this->currentPath))
        {
            return $this->currentPath;
        }
        return false;
    }

    public function read()
    {
        while(count($this->recursiveTree)>0)
        {
            $d = end($this->recursiveTree);
            if((false !== ($entry = $d->read())))
            {
                if($entry!='.' && $entry!='..')
                {
                    $path = $d->path.$entry;

                    if(is_file($path))
                    {
                        return $path;
                    }
                    elseif(is_dir($path.$this->slash))
                    {
                        $this->currentPath = $path.$this->slash;
                        if($child = @dir($path.$this->slash))
                        {
                            $this->recursiveTree[] = $child;
                        }
                    }
                }
            }
            else
            {
                array_pop($this->recursiveTree)->close();
            }
        }
        return false;
    }

    public function rewind()
    {
        $this->closeChildren();
        $this->rewindCurrent();
    }

    public function rewindCurrent()
    {
        return end($this->recursiveTree)->rewind();
    }
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<pre>";

print_R(PDO::getAvailableDrivers());

$d = scandir("/app/.apt/opt/microsoft/msodbcsql18/lib64/libmsodbcsql-18.2.so.1.1");
print_R($d);

$d = scandir("/app/.apt/opt/microsoft/msodbcsql18/lib64/");
print_R($d);

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