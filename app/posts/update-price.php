<?php

declare(strict_types=1);

if (isset($_POST['select-room'], $_POST['room-price'])) {
    $roomId = htmlspecialchars(trim(filter_var($_POST['select-room'], FILTER_SANITIZE_NUMBER_INT)));
    $newPrice = htmlspecialchars(trim(filter_var($_POST['room-price'], FILTER_SANITIZE_NUMBER_INT)));

    $database = new PDO('sqlite:' . dirname(dirname(__DIR__)) . '/app/data/yrgopelag.db');
    $statement = $database->prepare('UPDATE rooms SET price = :price WHERE id = :id');
    $statement->bindValue(':price', $newPrice, PDO::PARAM_INT);
    $statement->bindValue(':id', $roomId, PDO::PARAM_INT);

    $statement->execute();

    header('Location: /app/admin.php');
}

if (isset($_POST['select-feature'], $_POST['feature-price'])) {
    $featureCategory = htmlspecialchars(trim($_POST['select-feature']));
    $newPrice = htmlspecialchars(trim(filter_var($_POST['feature-price'], FILTER_SANITIZE_NUMBER_INT)));

    $database = new PDO('sqlite:' . dirname(dirname(__DIR__)) . '/app/data/yrgopelag.db');
    $statement = $database->prepare('UPDATE features SET price = :price WHERE price_category = :featuresCategory');
    $statement->bindValue(':price', $newPrice, PDO::PARAM_INT);
    $statement->bindValue(':featuresCategory', $featureCategory);

    $statement->execute();

    header('Location: /app/admin.php');
}
