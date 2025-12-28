<?php

declare(strict_types=1);

// REQUIRE AUTOLOAD
require dirname(__DIR__) . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// DEFINE API KEY VARIABLE
$key = $_ENV['API_KEY'];

// START SESSION
session_start();

// REQUIRE FUNCTIONS
require __DIR__ . "/functions.php";

// HOTEL DATA
require __DIR__ . "/database/hotel-data.php";
