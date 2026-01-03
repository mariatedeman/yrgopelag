<?php

declare(strict_types=1);
require dirname(__DIR__) . '/autoload.php';

if (isset($_POST['select-room'], $_POST['room-price'])) {
    $roomId = (int)trim(filter_var($_POST['select-room'], FILTER_SANITIZE_NUMBER_INT));
    $newPrice = (int)trim(filter_var($_POST['room-price'], FILTER_SANITIZE_NUMBER_INT));

    if ($newPrice > 0) {
        $statement = $database->prepare('UPDATE rooms SET price = :price WHERE id = :id');
        $statement->bindValue(':price', $newPrice, PDO::PARAM_INT);
        $statement->bindValue(':id', $roomId, PDO::PARAM_INT);

        $statement->execute();
    }
}

if (isset($_POST['select-feature'], $_POST['feature-price'])) {
    $featureCategory = htmlspecialchars(trim($_POST['select-feature']));
    $newPrice = (int)trim(filter_var($_POST['feature-price'], FILTER_SANITIZE_NUMBER_INT));

    if ($newPrice > 0) {
        $statement = $database->prepare('UPDATE features SET price = :price WHERE price_category = :featuresCategory');
        $statement->bindValue(':price', $newPrice, PDO::PARAM_INT);
        $statement->bindValue(':featuresCategory', $featureCategory, PDO::PARAM_STR);

        $statement->execute();
    }
}

if (isset($_POST['room-price']) || isset($_POST['feature-price'])) {
    $database->exec("UPDATE settings SET setting_value = setting_value + 1 WHERE setting_name = 'cache_version'");
}

header('Location: ' . URL_ROOT . '/app/admin.php');
exit;
