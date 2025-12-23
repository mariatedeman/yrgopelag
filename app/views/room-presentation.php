<?php

$database = new PDO('sqlite:' . dirname(__DIR__) . '/database/yrgopelag.db');
$statement = $database->query('SELECT * FROM rooms');
$roomInfo = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- SELECT ROOM -->
<section>
    <h2>Our room types</h2>
    <form action="/" method="get" class="show-room-info">
        <select name="show-room-info" id="show-room-info">
            <option value="1">Budget</option>
            <option value="2">Standard</option>
            <option value="3">Luxury</option>
        </select>
    </form>

    <!-- SHOW SELECTED ROOM INFO -->
    <div class="room-info budget">
        <p class="subheading"><?= $roomInfo[0]['room_name'] ?></p>
        <p><?= $roomInfo[0]['description'] ?></p>
    </div>

    <div class="room-info standard">
        <p class="subheading"><?= $roomInfo[1]['room_name'] ?></p>
        <p><?= $roomInfo[1]['description'] ?></p>
    </div>

    <div class="room-info luxury">
        <p class="subheading"><?= $roomInfo[2]['room_name'] ?></p>
        <p><?= $roomInfo[2]['description'] ?></p>
    </div>

</section>

<!-- SLIDESHOW AND CALENDER -->

<!------------------->
<!---- SLIDESHOW ---->
<!------------------->

<section class="room-calender">
    <span>
        <section class="room-presentation">
            <section class="slideshow-container">
                <div class="slides fade">
                    <div class="img-container">
                        <img class="budget" src="/assets/images/room_budget_1.jpg" alt="Old wooden boat in calm waters">
                        <img class="standard" src="/assets/images/Gemini_Generated_Image_7wj0c27wj0c27wj0.jpg" alt="Old wooden boat in calm waters">
                        <img class="luxury" src="/assets/images/room_budget_1.jpg" alt="Old wooden boat in calm waters">
                    </div>
                </div>

                <div class="slides fade">
                    <div class="img-container">
                        <img class="budget" src="/assets/images/room_budget_2.jpg" alt="Simple and cozy bed inside wooden boat">
                        <img class="standard" src="/assets/images/room_budget_2.jpg" alt="Simple and cozy bed inside wooden boat">
                        <img class="luxury" src="/assets/images/room_budget_2.jpg" alt="Simple and cozy bed inside wooden boat">
                    </div>
                </div>

                <a onclick="plusSlides(-1)" class="prev">&#10094;</a>
                <a onclick="plusSlides(1)" class="next">&#10095;</a>

            </section>
        </section>

        <!------------------>
        <!---- CALENDAR ---->
        <!------------------>
    </span>
    <span>
        <div class="calender-container">
            <?php require_once __DIR__ . "/calender.php"; ?>
    </span>
</section>