<?php

declare(strict_types=1);

require __DIR__ . "/app/autoload.php";
require __DIR__ . "/includes/header.php";

?>

<!-- HERO IMG -->
<section class="hero-img">
    <img src="/assets/images/sjoboda_logo_white.svg" alt="">
    <button href="#booking-form">Book your stay</button>
    <div class="offer">

    </div>
</section>
<section>
    <!-- ROOM PRESENTATION -->
    <?php require_once __DIR__ . "/app/views/room-presentation.php"; ?>
</section>

<section>
    <!-- GET TRANSFER CODE AND BOOKING -->
    <?php require __DIR__ . "/app/views/get-transfercode.php";
    require __DIR__ . "/app/views/booking-form.php"; ?>
</section>

<!-- FOOTER -->
<?php require __DIR__ . "/includes/footer.php"; ?>