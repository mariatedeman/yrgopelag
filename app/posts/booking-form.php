<?php

declare(strict_types=1);
require dirname(dirname(__DIR__)) . "/includes/header.php";
require dirname(dirname(__DIR__)) . "/app/functions.php";

if (isset($_POST['name'], $_POST['transfer_code'], $_POST['checkIn'], $_POST['checkOut'], $_POST['room_type'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $transferCode = htmlspecialchars(trim($_POST['transfer_code']));
    $checkIn = $_POST['checkIn'];
    $checkOut = $_POST['checkOut'];
    $roomType = $_POST['room_type'];

    $guestId = null;

    // CONNECT TO DATABASE
    $database = new PDO('sqlite:' . dirname(dirname(__DIR__)) . '/app/database/yrgopelag.db');

    // CHECK IF GUEST EXIST, OTHERWISE ADD
    $statement = $database->prepare('SELECT id FROM guests WHERE name = :name');
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->execute();
    $existingGuest = $statement->fetch(PDO::FETCH_ASSOC);

    // DEFINE GUEST ID
    if ($existingGuest) {
        $guestId = $existingGuest['id'];
    } else {
        $statement = $database->prepare('INSERT INTO guests (name) VALUES (:name)');
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->execute();

        $guestId = $database->lastInsertId();
    }

    // CHECK IF ROOM IS AVAILABLE CHOSEN DATES
    if ($guestId) {
        $checkAvailability = 'SELECT COUNT(id) FROM bookings
                            WHERE room_id = :room_id
                            AND checkin < :checkOut
                            AND checkout > :checkIn';
        $statement = $database->prepare($checkAvailability);
        $statement->bindParam(':room_id', $roomType, PDO::PARAM_INT);
        $statement->bindParam(':checkIn', $checkIn);
        $statement->bindParam(':checkOut', $checkOut);
        $statement->execute();
        $count = $statement->fetchColumn();

        if ($count > 0) {
            echo "Room is not available. Choose another date.";
        } else {

            // FETCH PRICE PER NIGHT
            $getPrice = $database->prepare('SELECT price FROM rooms WHERE id = :room_id');
            $getPrice->bindParam(':room_id', $roomType);
            $getPrice->execute();

            $price = $getPrice->fetch(PDO::FETCH_ASSOC);

            // CALCULATE NUMBER OF NIGHTS
            $checkIn = DateTime::createFromFormat('Y-m-d', $checkIn);
            $checkOut = DateTime::createFromFormat('Y-m-d', $checkOut);

            if (!$checkIn || !$checkOut || $checkIn >= $checkOut) {
                return 0;
            }

            $nights = $checkIn->diff($checkOut);

            // CALCULATE TOTAL PRICE
            $totalCost = $price['price'] * ($nights->days);

            // CONFIRM TRANSFER CODE WITH CENTRAL BANK
            // If trasferCode is valid -> insert booking
            if (isValidTransferCode($transferCode, $totalCost)) {
                if (makeDeposit($transferCode)) {

                    $statement = $database->prepare('INSERT INTO bookings (checkin, checkout, guest_id, room_id, is_paid) 
                                                VALUES (:checkIn, :checkOut, :guest_id, :room_id, :is_paid)');
                    $statement->bindValue(':checkIn', $checkIn->format('Y-m-d'));
                    $statement->bindValue(':checkOut', $checkOut->format('Y-m-d'));
                    $statement->bindParam(':guest_id', $guestId, PDO::PARAM_INT);
                    $statement->bindParam(':room_id', $roomType, PDO::PARAM_INT);
                    $statement->bindValue(':is_paid', true);
                    $statement->execute();

                    echo "Booking complete!";
                } else {
                    echo "Transaction failed. Make sure to use a valid code.";
                }
            } else {
                echo "Transfer code is not valid or doesn't have enough credit.";
            }
        }
    }
}
