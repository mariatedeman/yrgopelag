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
$islandInfo = getIslandFeatures($key);

$database = new PDO('sqlite:' . __DIR__ . "/database/yrgopelag.db");
$statement = $database->query('SELECT id, api_key FROM features');
$dbFeatures = $statement->fetchAll(PDO::FETCH_ASSOC);

$allFeatures = $islandInfo['features'];

if ($allFeatures && $dbFeatures) {
    foreach ($allFeatures as &$apiFeature) {
        foreach ($dbFeatures as $dbFeature) {
            if ($apiFeature['feature'] === $dbFeature['api_key']) {
                $apiFeature['id'] = $dbFeature['id'];
            }
        }
    }
    unset($apiFeature);
}

$islandName = htmlspecialchars(trim($islandInfo['island']['islandName']));
$hotelName = htmlspecialchars(trim($islandInfo['island']['hotelName']));
$hotelStars = (int)$islandInfo['island']['stars'];
$features = $allFeatures;
