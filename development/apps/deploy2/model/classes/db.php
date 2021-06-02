<?php

include 'db_config.php';
try
{
    $dbConnection = new PDO("mysql:host=$host;dbname=$db", $username, $password);
}
catch(Exception $ex)
{
    die($ex);
}