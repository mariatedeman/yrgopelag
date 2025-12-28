<?php

declare(strict_types=1);
require_once dirname(__DIR__) . "/autoload.php"; ?>

<?php require dirname(dirname(__DIR__)) . "/includes/header.php"; ?>

<section class="login-section">
    <h2>Admin login</h2>
    <form action="/app/posts/login.php" method="POST">
        <div>
            <span>
                <label for="username">Username</label>
                <input type="text" name="username">
            </span>
            <span>
                <label for="api_key">Your key</label>
                <input type="password" name="api_key">
            </span>
        </div>

        <button type="submit">Log in</button>
    </form>
</section>

<?php require dirname(dirname(__DIR__)) . "/includes/footer.php"; ?>