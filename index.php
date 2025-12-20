<?php

declare(strict_types=1);

require __DIR__ . "/app/autoload.php";
require __DIR__ . "/includes/header.php"; ?>


<section class="hero-img">

</section>
<section>
    <h2>Våra rum</h2>
</section>
<!-- ROOM AND CALENDER PRESETATION -->
<section class="room-calender">
    <span>
        <p>Room imgs</p>
    </span>
    <span>
        <div class="calender-container">
            <?php require_once __DIR__ . "/app/views/calender.php"; ?>
    </span>
</section>


<?php require __DIR__ . "/app/views/booking-form.php";
require __DIR__ . "/includes/footer.php"; ?>