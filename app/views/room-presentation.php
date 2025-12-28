<?php

declare(strict_types=1);

// FETCH INFO FROM DB
$database = new PDO('sqlite:' . dirname(__DIR__) . '/database/yrgopelag.db');
$statement = $database->query('SELECT * FROM rooms');
$roomInfo = $statement->fetchAll(PDO::FETCH_ASSOC);

$currentRoom = $_GET['room'] ?? 1;

?>

<section class="room-information-grid">
    <section class="room-information-row">
        <!-- CHOOSE ROOM -->
        <section class="room-information-wrapper choose-room-wrapper">
            <span>
                <h2>Our room types</h2>
                <p>Whether you seek rustic charm or refined luxury, we offer an experience for every soul. We offer rooms in every price range, all right at the water’s edge. Surrounded by the majestic beauty of the archipelago, our retreat invites you to reconnect with nature’s elements. Discover your perfect waterfront escape and let the rhythm of the waves define your stay.</p>
                <form action="/" class="show-room-info">
                    <select name="room" id="show-room-info">
                        <option value="1" <?= $currentRoom == 1 ? 'selected' : '' ?>>Budget</option>
                        <option value="2" <?= $currentRoom == 2 ? 'selected' : '' ?>>Standard</option>
                        <option value="3" <?= $currentRoom == 3 ? 'selected' : '' ?>>Luxury</option>
                    </select>
                </form>
            </span>
        </section>
        <!-- CALENDAR -->
        <section class="room-information-wrapper availability-wrapper">
            <span>
                <div class="calender-container">
                    <?php require dirname(dirname(__DIR__)) . "/includes/calender.php"; ?>
            </span>
        </section>
    </section>

    <section class="room-information-row">

        <!-- IMG SLIDESHOW -->
        <section class="room-information-wrapper img-slideshow-wrapper">
            <span class="slideshow-container">

                <section class="slides-container">

                    <div class="slides fade">
                        <div class="slides-img-container">
                            <img class="budget" src="/assets/images/room_budget_exterior.jpg" alt="Old wooden boat in calm waters">
                            <img class="standard" src="/assets/images/room_standard_exterior.jpg" alt="Row of red boat houses by calm waters">
                            <img class="luxury" src="/assets/images/room_luxury_exterior.jpg" alt="Old wooden boat in calm waters">
                        </div>
                    </div>

                    <div class="slides fade">
                        <div class="slides-img-container">
                            <img class="budget" src="/assets/images/room_budget_bed.jpg" alt="Simple and cozy bed inside wooden boat">
                            <img class="standard" src="/assets/images/room_standard_bed.jpg" alt="Simple and cozy bed inside wooden boat">
                            <img class="luxury" src="/assets/images/room_luxury_bed.jpg" alt="Simple and cozy bed inside wooden boat">
                        </div>
                    </div>

                    <div class="slides fade">
                        <div class="slides-img-container">
                            <img class="budget" src="/assets/images/room_budget_mood-2.jpg" alt="Simple and cozy bed inside wooden boat">
                            <img class="standard" src="/assets/images/room_standard_bathroom.jpg" alt="Simple and cozy bed inside wooden boat">
                            <img class="luxury" src="/assets/images/room_luxury_bathroom.jpg" alt="Simple and cozy bed inside wooden boat">
                        </div>
                    </div>

                    <div class="slides fade">
                        <div class="slides-img-container">
                            <img class="budget" src="/assets/images/room_budget_mood.jpg" alt="Simple and cozy bed inside wooden boat">
                            <img class="standard" src="/assets/images/room_standard_mood.jpg" alt="Simple and cozy bed inside wooden boat">
                            <img class="luxury" src="/assets/images/room_luxury_mood.jpg" alt="Simple and cozy bed inside wooden boat">
                        </div>
                    </div>

                    <a onclick="plusSlides(-1)" class="prev">&#10094;</a>
                    <a onclick="plusSlides(1)" class="next">&#10095;</a>

                </section>
            </span>
        </section>

        <!-- ROOM DESCRIPTION -->
        <section class="room-information-wrapper room-description-wrapper">
            <!-- SHOW SELECTED ROOM INFO -->
            <div class="room-description budget">
                <h2><?= $roomInfo[0]['room_name'] ?></h2>
                <p><?= $roomInfo[0]['description'] ?></p>
            </div>

            <div class="room-description standard">
                <h2><?= $roomInfo[1]['room_name'] ?></h2>
                <p><?= $roomInfo[1]['description'] ?></p>
            </div>

            <div class="room-description luxury">
                <h2><?= $roomInfo[2]['room_name'] ?></h2>
                <p><?= $roomInfo[2]['description'] ?></p>
            </div>
        </section>
    </section>
</section>