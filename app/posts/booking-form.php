<?php

declare(strict_types=1);
require dirname(__DIR__) . "/autoload.php";

$errors = [];
$bankError = "";
$totalCost = 0;

if (isset($_POST['name'], $_POST['transfer_code'], $_POST['checkIn'], $_POST['checkOut'], $_POST['room_type'])) {
    $guestName = htmlspecialchars(trim($_POST['name']));
    $transferCode = htmlspecialchars(trim($_POST['transfer_code']));
    $checkIn = $_POST['checkIn'];
    $checkOut = $_POST['checkOut'];
    $roomType = $_POST['room_type'];

    $guestId = null;

    // CONNECT TO DATABASE
    $database = new PDO('sqlite:' . dirname(dirname(__DIR__)) . '/app/database/yrgopelag.db');
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // SHOW ERRORS

    // CHECK IF GUEST EXIST, OTHERWISE ADD
    $statement = $database->prepare('SELECT id FROM guests WHERE name = :name');
    $statement->bindParam(':name', $guestName, PDO::PARAM_STR);
    $statement->execute();
    $existingGuest = $statement->fetch(PDO::FETCH_ASSOC);

    if ($existingGuest) { // DEFINE GUEST ID
        $guestId = $existingGuest['id'];
    } else {
        $statement = $database->prepare('INSERT INTO guests (name) VALUES (:name)');
        $statement->bindParam(':name', $guestName, PDO::PARAM_STR);
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

        if ($checkIn >= $checkOut) {
            $errors[] = "Date of arrival must be before date of departure.";
        } else if ($count > 0) {
            $errors[] = "Room is not available. Choose another date.";
        } else {

            // FETCH PRICE PER NIGHT
            $getPrice = $database->prepare('SELECT price FROM rooms WHERE id = :room_id');
            $getPrice->bindParam(':room_id', $roomType);
            $getPrice->execute();

            $price = $getPrice->fetch(PDO::FETCH_ASSOC);

            // CALCULATE NUMBER OF NIGHTS
            $checkIn = DateTime::createFromFormat('Y-m-d', $checkIn);
            $checkOut = DateTime::createFromFormat('Y-m-d', $checkOut);

            if (!$checkIn || !$checkOut) {
                $errors[] = "Invalid date format.";
            } else {

                // CALCULATE TOTAL PRICE
                $nights = $checkIn->diff($checkOut);
                $totalCost = $price['price'] * ($nights->days);


                // ADD SELECTED FEATURES TO ARRAY OR KEEP AS EMPTY ARRAY
                $selectedFeatures = $_POST['features'] ?? [];
                if (!is_array($selectedFeatures)) {
                    $selectedFeatures = [];
                }

                $featuresCost = 0;
                // FEATURE NAMES FOR RECEIPT
                $featuresForReceipt = [];

                foreach ($selectedFeatures as $featureId) {

                    // FETCH PRICE FROM DATABASE
                    $getFeaturePrice = $database->prepare('SELECT price, api_key FROM features WHERE id = :id');
                    $getFeaturePrice->bindValue(':id', $featureId, PDO::PARAM_INT);
                    $getFeaturePrice->execute();

                    $feature = $getFeaturePrice->fetch(PDO::FETCH_ASSOC);

                    if ($feature) {
                        $featuresCost += $feature['price'];
                        $featuresForReceipt[] = $feature['api_key'];
                    }
                }

                $totalCost += $featuresCost;

                // CONFIRM TRANSFER CODE WITH CENTRAL BANK
                // If trasferCode is valid -> insert booking
                if (isValidTransferCode($transferCode, $totalCost, $bankError)) {

                    $receipt = postReceipt($key, $guestName, $checkIn->format('Y-m-d'), $checkOut->format('Y-m-d'), $totalCost, $hotelStars, $featuresForReceipt);

                    if ($receipt && isset($receipt['status']) && $receipt['status'] === 'success') {

                        // SAVE BOOKING IN DATABASE
                        $statement = $database->prepare('INSERT INTO bookings (checkin, checkout, guest_id, room_id, is_paid) 
                                                VALUES (:checkIn, :checkOut, :guest_id, :room_id, :is_paid)');
                        $statement->bindValue(':checkIn', $checkIn->format('Y-m-d'));
                        $statement->bindValue(':checkOut', $checkOut->format('Y-m-d'));
                        $statement->bindParam(':guest_id', $guestId, PDO::PARAM_INT);
                        $statement->bindParam(':room_id', $roomType, PDO::PARAM_INT);
                        $statement->bindValue(':is_paid', true);
                        $statement->execute();

                        $bookingId = $database->lastInsertId();

                        if (!empty($selectedFeatures)) {
                            $statement = $database->prepare('INSERT INTO bookings_features (booking_id, feature_id) VALUES (:booking_id, :feature_id)');

                            foreach ($selectedFeatures as $featureId) {
                                $statement->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);
                                $statement->bindParam(':feature_id', $featureId, PDO::PARAM_INT);

                                $statement->execute();
                            }
                        }

                        if (isset($_POST['features']) && is_array($_POST['features'])) {
                            $featureStatement = $database->prepare('INSERT INTO bookings_features (booking_id, feature_id) VALUES (:booking_id, :feature_id)');

                            foreach ($_POST['features'] as $id) {
                                $featureStatement->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);
                                $featureStatement->bindParam(':feature_id', $id, PDO::PARAM_INT);
                                $featureStatement->execute();
                            }
                        }

                        if (makeDeposit($transferCode, $bankError)) {

                            $response = [
                                'island' => 'Lyckholmen',
                                'hotel' => 'Sjöboda B&B',
                                'arrival_date' => $checkIn->format('Y-m-d'),
                                'departure_date' => $checkOut->format('Y-m-d'),
                                'total_cost' => $totalCost,
                                'stars' => $hotelStars,
                                'features' => $featuresForReceipt,
                            ];
                            header('Content-Type: application/json');
                            echo json_encode($response);
                            exit;
                        } else {
                            $errors[] = "Deposit failed: $bankError";
                        }
                    } else {
                        $errors[] = "Receipt not available: " . $receipt['error'];
                    }
                } else {
                    $errors[] = "Transfer code not valid: $bankError";
                }
            }
        }
    }
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo htmlspecialchars(trim($error));
    } ?>
    <button onclick="history.back()">Back to booking</button>
<?php }
