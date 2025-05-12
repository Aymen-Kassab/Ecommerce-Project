<?php

use function PHPSTORM_META\sql_injection_subst;

$database = 'localhost';
$username = 'root';
$password = '';
$dbname = 'Game_Verse';
$port = '3307';

try{
    $link = mysqli_connect($database, $username, $password, $dbname, $port);
}
catch(mysqli_sql_exception){
    echo "Failed to connect";
}
?>