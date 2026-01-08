<?php

declare(strict_types=1);

// REQUIRE AUTOLOAD
require dirname(__DIR__) . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// DEFINE API KEY VARIABLE
$key = $_ENV['API_KEY'];

// URL ROOT
define('URL_ROOT', 'http://localhost:8000');

// START SESSION
session_start();

// REQUIRE FUNCTIONS
require __DIR__ . "/functions.php";

// DATABASE
require __DIR__ . "/data/setup.php";

$database = new PDO('sqlite:' . __DIR__ . '/data/yrgopelag.db');
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

setupDatabase($database);

// HOTEL DATA
require __DIR__ . "/data/hotel-data.php";
