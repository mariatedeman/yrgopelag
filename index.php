<?php

declare(strict_types=1);

require __DIR__ . "/app/autoload.php";
require __DIR__ . "/includes/header.php";

?>

<!-- HERO IMG -->
<section class="hero-video-container">
    <span class="on-video-content">
        <img src="/assets/images/sjoboda_logo_white.svg" alt="">
        <a href="#transfercode-section" class="button">Book your stay</a>
        <div class="offer">
            <h6>Offer</h6>
            <div>
                <p class="subheading">Januray offer</p>
                <p>Elevate your winter escape with our exclusive January offer.
                    Book a stay in our Premium Sea View Suites this month and enjoy a
                    complimentary gourmet seafood cruise through our stunning archipelago.
                    Experience the pinnacle of coastal luxury combined with the finest
                    flavours of the sea.</p>

                <a href="#transfercode-section" class="button">Book now</a>
            </div>
        </div>
    </span>

    <video autoplay muted loop id="background-video">
        <source src="/assets/images/hero-video.mp4" type="video/mp4">
    </video>
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