<?php

declare(strict_types=1);

// REQUIRE AUTOLOAD
require dirname(__DIR__) . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// DEFINE API KEY VARIABLE
$key = $_ENV['API_KEY'];

// REQUIRE FUNCTIONS
// require dirname(__DIR__) . "/app/functions.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>