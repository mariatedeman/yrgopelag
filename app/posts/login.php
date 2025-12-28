<?php

declare(strict_types=1);
require dirname(__DIR__) . "/autoload.php";

$errors = [];

if (isset($_POST['username'], $_POST['api_key'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['api_key']));

    if ($username !== 'Maria' || $password !== $key) {
        $errors[] = "Wrong username or password";
    } else {
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $username;
        header('Location: /app/admin.php');
    }
}

// DISPLAY ON SCREEN
require dirname(dirname(__DIR__)) . "/includes/header.php"; ?>

<section class="error-section">
    <h2>ERROR</h2>
    <div>
        <?php if (!empty($errors)) :
            foreach ($errors as $error) : ?>
                <p><?= htmlspecialchars(trim($error)) ?></p>
            <?php endforeach; ?>
            <button onclick="history.back()">Try again</button>
        <?php endif; ?>
    </div>
</section>

<?php require dirname(dirname(__DIR__)) . "/includes/footer.php";

?>