<?php

declare(strict_types=1);

if (isset($_POST['name'], $_POST['transfer_code'], $_POST['checkin'], $_POST['checkout'], $_POST['room_type'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $transferCode = htmlspecialchars(trim($_POST['transfer_code']));
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $roomType = $_POST['room_type'];

    $guestId = null;

    // CONNECT TO DATABASE
    $database = new PDO('sqlite:' . dirname(dirname(__DIR__)) . '/app/database/yrgopelag.db');

    // CHECK IF GUEST EXIST, OTHERWISE ADD
    $statement = $database->prepare('SELECT id FROM guests WHERE name = :name');
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->execute();
    $existingGuest = $statement->fetch(PDO::FETCH_ASSOC);

    if ($existingGuest) {
        $guestId = $existingGuest['id'];
    } else {
        $statement = $database->prepare('INSERT INTO guests (name) VALUES (:name)');
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->execute();

        $guestId = $database->lastInsertId();
    }

    // CHECK IF BOOKING EXIST, OTHERWISE ADD

    if ($guestId) {

        $checkAvailability = 'SELECT COUNT(id) FROM bookings
                            WHERE room_id = :room_id
                            AND checkin < :checkout
                            AND checkout > :checkin';
        $statement = $database->prepare($checkAvailability);
        $statement->bindParam(':room_id', $roomType, PDO::PARAM_INT);
        $statement->bindParam(':checkin', $checkin);
        $statement->bindParam(':checkout', $checkout);
        $statement->execute();
        $count = $statement->fetchColumn();

        if ($count > 0) {
            echo "Room is not available. Choose another date.";
        } else {
            $statement = $database->prepare('INSERT INTO bookings (checkin, checkout, guest_id, room_id) 
                                                    VALUES (:checkin, :checkout, :guest_id, :room_id)');
            $statement->bindParam(':checkin', $checkin);
            $statement->bindParam(':checkout', $checkout);
            $statement->bindParam(':guest_id', $guestId, PDO::PARAM_INT);
            $statement->bindParam(':room_id', $roomType, PDO::PARAM_INT);
            $statement->execute();

            echo "Booking complete!";
        }
    }
}


?>


<form action="booking-form.php" method="post">
    <label for="text">Your name</label>
    <input type="text" name="name" placeholder="Type your name">

    <label for="text">Transfer code</label>
    <input type="text" name="transfer_code" placeholder="Type your transfer code">

    <label for="checkin">Chose arrival date</label>
    <input type="date" name="checkin" id="">

    <label for="checkout">Chose departure date</label>
    <input type="date" name="checkout" id="">

    <label for="room_type">Chose type of room</label>
    <select name="room_type" id="">
        <option value="1">Budget</option>
        <option value="2">Standard</option>
        <option value="3">Luxury</option>
    </select>

    <button type="submit">Make reservation</button>
</form>