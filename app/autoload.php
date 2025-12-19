<?php

declare(strict_types=1);

// REQUIRE AUTOLOAD
require dirname(__DIR__) . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// DEFINE API KEY VARIABLE
$key = $_ENV['API_KEY'];

// REQUIRE FUNCTIONS
require __DIR__ . "/functions.php";

// HOTEL DATA
$islandInfo = getIslandFeatures($key);

$islandName = htmlspecialchars(trim($islandInfo['island']['islandName']));
$hotelName = htmlspecialchars(trim($islandInfo['island']['hotelName']));
$hotelStars = (int)$islandInfo['island']['stars'];
$features[] = $islandInfo['features'];
