<?php

declare(strict_types=1); ?>

<section class="get-transfercode-container" id="get-transfercode">
    <?php if (!isset($_SESSION['success'])) : ?>
        <button class="button-small" id="show-transfercode-form">Fetch transfercode</button>
    <?php endif ?>
    <section class="form-container" id="transfercode-form">
        <form action="./app/posts/get-transfer-code.php" method="post">
            <input type="hidden" name="current-room-id" id="hidden-room-id" value="<?= (int)$currentRoom ?>">

            <label for="name"></label>
            <input type="text" name="name" id="name" placeholder="Your name">

            <label for="guest_api"></label>
            <input type="text" name="guest_api" id="guest_api" placeholder="Your api key">

            <label for="amount"></label>
            <input type="number" name="amount" id="amount" placeholder="0">

            <button type="submit">></button>
        </form>
    </section>

    <!-- RESPONSE -->
    <section class="transfercode-response">

        <?php if (isset($_SESSION['error'])) { ?>
            <p><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']);
        } else if (isset($_SESSION['success'])) { ?>
            <label for="transfercode">Your transfercode</label>
            <input type="text" value="<?= htmlspecialchars(trim($_SESSION['success'])) ?>" id="transfercode">
            <button onclick="copytext('transfercode')" class="copy-text">Copy</button>
        <?php unset($_SESSION['success']);
        } ?>

    </section>
</section>