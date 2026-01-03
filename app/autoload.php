<?php

declare(strict_types=1);

// REQUIRE AUTOLOAD
require dirname(__DIR__) . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// DEFINE API KEY VARIABLE
$key = $_ENV['API_KEY'];

// URL ROOT
define('URL_ROOT', 'https://made-by-met.se/yrgopelag');

// START SESSION
session_start();

// CONNECT TO DATABASE
$database = new PDO ('sqlite:' . __DIR__ . '/data/yrgopelag.db');
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// REQUIRE FUNCTIONS
require __DIR__ . "/functions.php";

// HOTEL DATA
require __DIR__ . "/data/hotel-data.php";
