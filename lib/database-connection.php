<?php

include 'get-env-variable.php';

$server = getEnvironmentalVariable('SERVER');
$database = getEnvironmentalVariable('DATABASE');
$user = getEnvironmentalVariable('USER');
$password = getEnvironmentalVariable('DATABASE_PASSWORD');

if ($password === false) {
    echo 'Database password not found in .env file';
    exit;
}

try {
    $databaseConnection = new PDO("mysql:host=$server;dbname=$database", $user, $password);
} catch (PDOException $exception) {
    echo 'Database connection failed: ' . $exception->getMessage();
    exit;
}
