<?php

declare(strict_types=1);

$firstDayOfMonth = date('N', mktime(0, 0, 0, 1, 1, 2026));
$lastDayOfMonth = date('N', mktime(0, 0, 0, 1, 31, 2026));
$daysInMonth = date('t', mktime(0, 0, 0, 1, 1, 2026));
$dayInWeek = date('l', mktime(0, 0, 0, 1, 1, 2026));

$dates = [];

try {
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $database->prepare('SELECT checkin, checkout, room_id FROM bookings');
    $statement->execute();
    $dates = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $dates = [];
}

// ARRAYS FOR BOOKED ROOMS
$bookedDatesRoomOne = [];
$bookedDatesRoomTwo = [];
$bookedDatesRoomThree = [];

// LOOP THROUGH TO FIND THE OCCUPIED DATES
foreach ($dates as $date) {
    $checkin = date('j', strtotime(htmlspecialchars(trim($date['checkin']))));
    $checkout = date('j', strtotime(htmlspecialchars(trim($date['checkout']))));

    for ($booked = $checkin; $booked < $checkout; $booked++) {
        // ADD TO CORRECT ARRAY
        if ($date['room_id'] == 1) {
            $bookedDatesRoomOne[] = $booked;
        } else if ($date['room_id'] == 2) {
            $bookedDatesRoomTwo[] = $booked;
        } else if ($date['room_id'] == 3) {
            $bookedDatesRoomThree[] = $booked;
        }
    }
} ?>

<!-- CREATE CALENDERS -->
<!-- ROOM ONE -->
<table class="calender budget">
    <caption>January 2026 (Budget)</caption>

    <tr>
        <th>M</th>
        <th>T</th>
        <th>W</th>
        <th>T</th>
        <th>F</th>
        <th>S</th>
        <th>S</th>
    </tr>

    <tr>
        <!-- EMPTY SLOTS FOR DAYS IN PREVIOUS MONTH -->
        <?php for ($i = 1; $i < $firstDayOfMonth; $i++) : ?>
            <td class="day"></td>
            <?php endfor;

        // CHECK IF DATE IS BOOKES AND ADD TO CALENDER
        for ($i = 1; $i <= $daysInMonth; $i++) :
            if (in_array($i, $bookedDatesRoomOne)) { ?>
                <td class="day booked"><?= $i ?></td>
            <?php } else { ?>
                <td class="day"><?= $i ?></td>
            <?php }

            // NEW ROW ON MONDAY
            if (($i + $firstDayOfMonth - 1) % 7 === 0) : ?>
    </tr>
    <tr>
    <?php endif;
        endfor;
        // CHECK IF LAST DAY IS A SUNDAY, IF NOT ADD EMPTY SLOTS
        if ($lastDayOfMonth !== 7) :
            for ($i = $lastDayOfMonth; $i < 7; $i++) : ?>
        <td class="day"></td>

<?php endfor;
        endif;
?>
    </tr>
</table>

<!-- ROOM TWO -->
<table class="calender standard">
    <caption>January 2026 (Standard)</caption>

    <tr>
        <th>M</th>
        <th>T</th>
        <th>W</th>
        <th>T</th>
        <th>F</th>
        <th>S</th>
        <th>S</th>
    </tr>

    <tr>
        <!-- EMPTY SLOTS FOR DAYS IN PREVIOUS MONTH -->
        <?php for ($i = 1; $i < $firstDayOfMonth; $i++) : ?>
            <td class="day"></td>
            <?php endfor;

        // CHECK IF DATE IS BOOKES AND ADD TO CALENDER
        for ($i = 1; $i <= $daysInMonth; $i++) :
            if (in_array($i, $bookedDatesRoomTwo)) { ?>
                <td class="day booked"><?= $i ?></td>
            <?php } else { ?>
                <td class="day"><?= $i ?></td>
            <?php }

            // NEW ROW ON MONDAY
            if (($i + $firstDayOfMonth - 1) % 7 === 0) : ?>
    </tr>
    <tr>
    <?php endif;
        endfor;
        // CHECK IF LAST DAY IS A SUNDAY, IF NOT ADD EMPTY SLOTS
        if ($lastDayOfMonth !== 7) :
            for ($i = $lastDayOfMonth; $i < 7; $i++) : ?>
        <td class="day"></td>

<?php endfor;
        endif;
?>
    </tr>
</table>


<!-- ROOM THREE -->
<table class="calender luxury">
    <caption>January 2026 (Luxury)</caption>

    <tr>
        <th>M</th>
        <th>T</th>
        <th>W</th>
        <th>T</th>
        <th>F</th>
        <th>S</th>
        <th>S</th>
    </tr>

    <tr>
        <!-- EMPTY SLOTS FOR DAYS IN PREVIOUS MONTH -->
        <?php for ($i = 1; $i < $firstDayOfMonth; $i++) : ?>
            <td class="day"></td>
            <?php endfor;

        // CHECK IF DATE IS BOOKES AND ADD TO CALENDER
        for ($i = 1; $i <= $daysInMonth; $i++) :
            if (in_array($i, $bookedDatesRoomThree)) { ?>
                <td class="day booked"><?= $i ?></td>
            <?php } else { ?>
                <td class="day"><?= $i ?></td>
            <?php }

            // NEW ROW ON MONDAY
            if (($i + $firstDayOfMonth - 1) % 7 === 0) : ?>
    </tr>
    <tr>
    <?php endif;
        endfor;
        // CHECK IF LAST DAY IS A SUNDAY, IF NOT ADD EMPTY SLOTS
        if ($lastDayOfMonth !== 7) :
            for ($i = $lastDayOfMonth; $i < 7; $i++) : ?>
        <td class="day"></td>

<?php endfor;
        endif;
?>
    </tr>
</table>