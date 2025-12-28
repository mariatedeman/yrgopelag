<?php

declare(strict_types=1);

$islandInfo = getIslandFeatures($key);

$database = new PDO('sqlite:' . __DIR__ . '/yrgopelag.db');
$statement = $database->query('SELECT * FROM features');
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

$islandName = 'Lyckholmen';
$hotelName = 'Sjöboda B&B';
$hotelStars = (int)$islandInfo['island']['stars'];
$features = $allFeatures;
