<?php

declare(strict_types=1);

require __DIR__ . "/app/autoload.php";
require __DIR__ . "/includes/header.php"; ?>


<section class="hero-img">

</section>
<section>
    <h2>Våra rum</h2>
    <form action="/" method="get">
        <label for="show-room-info">Room type</label>
        <select name="show-room-info" id="show-room-info">
            <option value="1">Budget</option>
            <option value="2">Standard</option>
            <option value="3">Luxury</option>
        </select>
    </form>
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