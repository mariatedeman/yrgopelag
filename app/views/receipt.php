<?php

declare(strict_types=1);
require dirname(__DIR__) . "/autoload.php";

if (!isset($_SESSION['receipt'])) {
    header('Location: /');
    exit;
}
$receipt = $_SESSION['receipt'];

require dirname(dirname(__DIR__)) . "/includes/header.php"; ?>

<section class="booking-confirmation">
    <div>
        <h2>Thank you for booking!</h2>
        <p>Your booking to <?= htmlspecialchars(trim(ucfirst($receipt['hotel']))) . " at " . htmlspecialchars(trim(ucfirst($receipt['island']))) ?> is confirmed.</p>
    </div>

    <div>
        <h3>Your receipt</h3>
        <div class="json-container" id="receipt">
            <pre><?= json_encode($receipt, JSON_PRETTY_PRINT); ?></pre>
        </div>
        <button onclick="copytext('receipt')" class="copy-text">Copy</button>

    </div>
</section>

<?php
unset($_SESSION['receipt']);

require dirname(dirname(__DIR__)) . "/includes/footer.php"; ?>