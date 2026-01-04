<?php

declare(strict_types=1);

$islandInfo = [];
$islandName = 'Lyckholmen';
$hotelName = 'Sjöboda B&B';
$features = [];
$hotelStars = 0;

// === CHECK IF GUEST HAS OLD SESSION === ///
// FETCH DB VERSION
try {
    $statement = $database->query("SELECT setting_value FROM settings WHERE setting_name = 'cache_version'");
    $dbVersion = (int)$statement->fetchColumn();
} catch (PDOException $e) {
    $dbVersion = 1;
}

// COMPARE TO GUEST VERSION
if (!isset($_SESSION['cache_version']) || $_SESSION['cache_version'] < $dbVersion) {

    // UPDATE IF NEEDED
    unset($_SESSION['island_data']);
    $_SESSION['cache_version'] = $dbVersion;
}

if (!isset($_SESSION['island_data'])) {

    $islandInfo = getIslandFeatures($key);

    if ($islandInfo !== null && isset($islandInfo['features'])) {
        try {
            // FETCH ID:s FROM DATABASE
            $statement = $database->query('SELECT * FROM features');
            $dbFeatures = $statement->fetchAll(PDO::FETCH_ASSOC);

            // LOOP THROUGH FEATURES FROM API
            foreach ($islandInfo['features'] as &$apiFeature) {
                // FOR EACH API FEATURE, LOOK THROUGH DB FEATURES
                foreach ($dbFeatures as $dbFeature) {
                    // IF API FEATURE  == api_key IN DB, SAVE LOCAL ID IN API OBJECT
                    if ($apiFeature['feature'] === $dbFeature['api_key']) {
                        $apiFeature['id'] = $dbFeature['id'];
                    }
                }
            }
            unset($apiFeature);

            $_SESSION['island_data'] = $islandInfo;
        } catch (PDOException $e) {
        }
    }
}

if (isset($_SESSION['island_data'])) {
    $islandInfo = $_SESSION['island_data'];
    $features = $islandInfo['features'] ?? [];
    $hotelStars = (int)($islandInfo['island']['stars'] ?? 0);
} else {
    $errors[] = 'Could not connect to the island server. Some information might be missing.';
}


// === FEATURE CATECORIES === //
$featureCategories = [
    'Coastal Experiences' => 'hotel-specific',
    'Water' => 'water',
    'Wheels' => 'wheels',
    'Games' => 'games',
];
