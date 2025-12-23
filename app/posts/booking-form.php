<?php

declare(strict_types=1);
require dirname(__DIR__) . "/autoload.php";

$errors = [];
$bankError = "";
$totalCost = 0;
$discountFeature = 6;

if (isset($_POST['name'], $_POST['transfer_code'], $_POST['checkIn'], $_POST['checkOut'], $_POST['room_type'])) {
    $guestName = htmlspecialchars(trim($_POST['name']));
    $transferCode = htmlspecialchars(trim($_POST['transfer_code']));
    $checkIn = $_POST['checkIn'];
    $checkOut = $_POST['checkOut'];
    $roomType = $_POST['room_type'];

    $guestId = null;
    $total_nights = null;

    // CONNECT TO DATABASE
    $database = new PDO('sqlite:' . dirname(dirname(__DIR__)) . '/app/database/yrgopelag.db');
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // SHOW ERRORS

    // CHECK IF GUEST EXIST, OTHERWISE ADD
    $statement = $database->prepare('SELECT id, total_nights, loyal_discount_used FROM guests WHERE name = :name');
    $statement->bindParam(':name', $guestName, PDO::PARAM_STR);
    $statement->execute();
    $existingGuest = $statement->fetch(PDO::FETCH_ASSOC);

    if ($existingGuest) { // DEFINE GUEST ID
        $guestId = $existingGuest['id'];
        $total_nights = $existingGuest['total_nights'];
    } else {
        $statement = $database->prepare('INSERT INTO guests (name) VALUES (:name)');
        $statement->bindParam(':name', $guestName, PDO::PARAM_STR);
        $statement->execute();

        $guestId = $database->lastInsertId();
    }

    // VARIABLE TO CHECK IF DISCOUNT SHOULD BE ADDED
    $giveDiscount = ($existingGuest && $total_nights > 0 && $existingGuest['loyal_discount_used'] == false);

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
                if ($price) {
                    $nights = $checkIn->diff($checkOut);
                    $totalCost = $price['price'] * ($nights->days);

                    // ADD SELECTED FEATURES TO ARRAY OR KEEP AS EMPTY ARRAY
                    $selectedFeatures = $_POST['features'] ?? [];
                    if (!is_array($selectedFeatures)) {
                        $selectedFeatures = [];
                    }

                    $featuresCost = 0;
                    $featuresForReceipt = []; // FEATURE NAMES FOR RECEIPT

                    foreach ($selectedFeatures as $featureId) {

                        // FETCH PRICE FROM DATABASE
                        $getFeaturePrice = $database->prepare('SELECT price, activity_category, price_category, api_key FROM features WHERE id = :id');
                        $getFeaturePrice->bindValue(':id', $featureId, PDO::PARAM_INT);
                        $getFeaturePrice->execute();

                        $feature = $getFeaturePrice->fetch(PDO::FETCH_ASSOC);

                        if ($giveDiscount && $featureId == $discountFeature) {
                            $featuresForReceipt[] = ['activity' => strtolower($feature['activity_category']), 'tier' => strtolower($feature['price_category'])];
                        } else if ($feature) {
                            $featuresCost += $feature['price'];
                            $featuresForReceipt[] = ['activity' => strtolower($feature['activity_category']), 'tier' => strtolower($feature['price_category'])];
                        }

                        // IF OFFER USED, DEDUCT PRICE FOR SUPERIOR FEATURE
                        if ($roomType == 3 && $feature['api_key'] === 'seafood cruise with live music') {
                            $featuresCost -= $feature['price'];
                        }
                    }

                    $totalCost += $featuresCost;

                    // CONFIRM TRANSFER CODE WITH CENTRAL BANK
                    // If trasferCode is valid -> insert booking
                    if (isValidTransferCode($transferCode, $totalCost, $bankError)) {

                        // ADD DISCOUNTED FEATURE TO RECEIPT
                        if ($giveDiscount && !in_array($discountFeature, $selectedFeatures)) {
                            $featuresForReceipt[] = ['activity' => 'water', 'tier' => 'basic'];
                        }

                        // POST RECEIPT
                        $receipt = postReceipt($key, $guestName, $checkIn->format('Y-m-d'), $checkOut->format('Y-m-d'), $totalCost, $hotelStars, $featuresForReceipt);

                        if ($receipt && isset($receipt['status']) && $receipt['status'] === 'success') {

                            if (makeDeposit($transferCode, $bankError)) {

                                // SAVE BOOKING IN DATABASE
                                $statement = $database->prepare('INSERT INTO bookings (checkin, checkout, guest_id, room_id, is_paid, total_cost) 
                                                VALUES (:checkIn, :checkOut, :guest_id, :room_id, :is_paid, :total_cost)');
                                $statement->bindValue(':checkIn', $checkIn->format('Y-m-d'));
                                $statement->bindValue(':checkOut', $checkOut->format('Y-m-d'));
                                $statement->bindParam(':guest_id', $guestId, PDO::PARAM_INT);
                                $statement->bindParam(':room_id', $roomType, PDO::PARAM_INT);
                                $statement->bindValue(':is_paid', true);
                                $statement->bindValue(':total_cost', $totalCost, PDO::PARAM_INT);
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

                                // IF EXISTING GUEST, ADD SCUBA DIVING FOR FREE
                                if ($giveDiscount) {

                                    // UPDATE DB TO DISCOUNT USED
                                    $statement = $database->prepare('UPDATE guests SET loyal_discount_used = true WHERE id = :id');
                                    $statement->bindValue(':id', $guestId, PDO::PARAM_INT);
                                    $statement->execute();

                                    // CONNECT DISCOUNTED FEATURE TO BOOKING IN DB
                                    if (in_array($discountFeature, $selectedFeatures)) {
                                        $statement = $database->prepare('INSERT INTO bookings_features (booking_id, feature_id) VALUES (:booking_id, :feature_id)');
                                        $statement->bindValue(':booking_id', $bookingId, PDO::PARAM_INT);
                                        $statement->bindValue(':feature_id', $discountFeature, PDO::PARAM_INT);
                                        $statement->execute();
                                    }
                                }

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
                } else {
                    $errors[] = "Price not found";
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
