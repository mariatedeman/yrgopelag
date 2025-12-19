<?php

declare(strict_types=1);
require_once dirname(__DIR__) . "/autoload.php";
require_once dirname(dirname(__DIR__)) . "/includes/header.php"; ?>

<form action="/app/posts/login.php" method="POST">
    <label for="username">Username</label>
    <input type="text" name="username">

    <label for="api_key">Your key</label>
    <input type="password" name="api_key">

    <button type="submit">Log in</button>
</form>