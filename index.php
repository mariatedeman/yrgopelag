<?php

declare(strict_types=1);

require __DIR__ . "/app/autoload.php";
require __DIR__ . "/includes/header.php";
?>

<!-- HERO IMG -->
<section class="hero-video-container">
    <span class="on-video-content">
        <img src="/assets/images/sjoboda_logo_bohuslangrey.svg" alt="">
        <h1>Your authentic west coast escape</h1>
        <a href="#transfercode-section" class="button">Book your stay</a>
        <div class="offer">
            <h6>Offer</h6>
            <div>
                <p class="subheading">January offer</p>
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

<section class="loyalty-offer">
    <div>
        <p><strong>Returning guest offer:</strong> Free scuba diving during your stay! Automatically added to your booking at checkout.</p>
    </div>
</section>

<section class="intro">
    <span>
        <h2>Experience Bohuslän at Sjöboda B&B</h2>
        <p>Discover the serene beauty of Lyckholmen.
            From cozy traditional wooden boats to premium
            suites with private jetties, we offer a unique
            waterfront escape where the sea is your closest neighbor.
            Experience the best that Bohuslän has to offer.</p>
    </span>
</section>

<section>
    <!-- ROOM PRESENTATION -->
    <?php require __DIR__ . "/app/views/room-presentation.php"; ?>
</section>

<section class="booking-section">
    <h2>Booking</h2>
    <!-- GET TRANSFER CODE AND BOOKING -->
    <?php require __DIR__ . "/app/views/get-transfercode.php";
    require __DIR__ . "/app/views/booking-form.php"; ?>
</section>

<section class="features-presentation">
    <?php require __DIR__ . "/includes/features-presentation.php"; ?>
</section>

<!-- FOOTER -->
<?php require __DIR__ . "/includes/footer.php"; ?>