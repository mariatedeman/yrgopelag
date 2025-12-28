<?php

declare(strict_types=1);
require dirname(__DIR__) . "/autoload.php";

$errors = [];

if (isset($_POST['username'], $_POST['api_key'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['api_key']));

    if ($username !== 'Maria' || $password !== $key) {
        echo $errors[] = "Wrong username or password";
    } else {
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $username;
        header('Location: /app/admin.php');
    }
}
