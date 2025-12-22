<?php

declare(strict_types=1);

// === INCLUDES === //
// 1. GET TRANSFER CODE
// 2. VALIDATE TRANSFER CODE
// 3. MAKE DEPOSIT
// 4. POST RECEIPT
// 5. GET ACCOUNT INFO <----- Needed?
// 6. GET FEATURES
// 7. PRINT FEATURES


//////////////////////////////////////

// === GET TRASFER CODE === //

function getTransferCode(string $guestName, string $guestApi, int $amount, string &$message = ""): ?array
{

    $url = 'https://www.yrgopelag.se/centralbank/withdraw';

    // PREPARE DATA TO SEND
    $data = ['user' => $guestName, 'api_key' => $guestApi, 'amount' => $amount];

    // CREATE STREAM CONTENT POST REQUEST
    // Tells file_get_content to act as POST client
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data),
            'ignore_errors' => true,
        ]
    ];

    $context = stream_context_create($options);

    // SEND REQUEST AND GET RESPONSE
    $response = file_get_contents($url, false, $context);

    // HANDLE RESPONSE
    if ($response === false) {
        return null;
    }

    // CONVERT RESPONSE TO ASSOC ARRAY
    $transferCode = json_decode($response, true);

    if (isset($transferCode['error'])) {
        $message = $transferCode['error'];
    }

    return $transferCode;
}



/////////////////////////////////////////////////
// === VALIDATE TRANSFER CODE === //
function isValidTransferCode(string $transferCode, int $totalCost, string &$message = ''): bool
{

    $url = 'https://www.yrgopelag.se/centralbank/transferCode';

    // PREPARE DATA TO SEND
    $data = ['transferCode' => $transferCode, 'totalCost' => $totalCost];

    // CREATE STREAM CONTEXT POST REQUEST
    // Tells file_get_contents to act as POST client
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data),
            'ignore_errors' => true
        ]
    ];
    $context = stream_context_create($options);

    // SEND REQUEST AND GET RESPONSE
    $response = file_get_contents($url, false, $context);

    // HANDLE RESPONSE
    if ($response === false) {
        $message = "Could not connect to the Central bank.";
        return false;
    }

    // CONVERT RESPONSE TO ASSOC ARRAY
    $result = json_decode($response, true);

    if (isset($result['error']) || !isset($result['transferCode'])) {
        $message = $result['error'] ?? "Transfer code not valid.";
        return false;
    }

    return true;
}


//////////////////////////////////////////////////
// === MAKE DEPOSIT === //

function makeDeposit(string $transferCode, string &$message = ''): bool
{

    $url = 'https://www.yrgopelag.se/centralbank/deposit';

    // PREPARE DATA TO SEND
    $paymentInfo = ['user' => 'Maria', 'transferCode' => $transferCode];

    // CREATE STREAM CONTEXT POST REQUEST
    // Tells file_get_contents to act as POST client
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($paymentInfo),
            'ignore_errors' => true
        ]
    ];
    $context = stream_context_create($options);

    // SEND REQUEST AND GET RESPONSE
    $response = file_get_contents($url, false, $context);

    // HANDLE RESPONSE
    if ($response === false) {
        $message = "Could not connect during deposit.";
        return false;
    }

    $result = json_decode($response, true);

    if (isset($result['error'])) {
        $message = $result['error'];
        return false;
    }

    return true;
}


//////////////////////////////////////////////////
// === POST RECEIPT === //

function postReceipt(string $key, string $guestName, string $checkIn, string $checkOut, int $totalCost, int $hotelStars, array $features): ?array
{

    $url = 'https://www.yrgopelag.se/centralbank/receipt';

    $receiptInfo = [
        "user" => "Maria",
        "api_key" => $key,
        "island_id" => 212,
        "guest_name" => $guestName,
        "arrival_date" => $checkIn,
        "departure_date" => $checkOut,
        "features_used" => $features,
        "star_rating" => $hotelStars
    ];

    // CREATE STREAM CONTEXT POST REQUEST
    // Tells file_get_contents to act as POST client
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($receiptInfo),
            'ignore_errors' => true
        ]
    ];
    $context = stream_context_create($options);

    // SEND REQUEST AND GET RESPONSE
    $response = file_get_contents($url, false, $context);

    return $response ? json_decode($response, true) : null;
}


//////////////////////////////////////////////////
// === GET ACCOUNT INFO === //

function getAccountInfo(string $user, string $apiKey): ?array
{
    $url = 'https://www.yrgopelag.se/centralbank/accountInfo';

    // PREPARE DATA TO SEND
    $userInfo = ['user' => $user, 'api_key' => $apiKey];

    // CREATE STREAM CONTEXT POST REQUEST
    // Tells file_get_contents to act as POST client
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($userInfo),
        ]
    ];
    $context = stream_context_create($options);

    // SEND REQUEST AND GET RESPONSE
    $response = file_get_contents($url, false, $context);

    // HANDLE RESPONSE
    if ($response === false) {
        return null;
    }

    // CONVERT RESPONSE TO ASSOC ARRAY
    $data = json_decode($response, true);

    if ($data === null) {
        return null;
    }

    return $data;
}


/////////////////////////////////////////////////
// === GET ISLAND FEATURES === //

function getIslandFeatures(string $key): ?array
{

    $url = 'https://www.yrgopelag.se/centralbank/islandFeatures';

    // PREPARE DATA TO SEND
    $data = ['user' => 'Maria', 'api_key' => $key];

    // CREATE STREAM CONTENT POST REQUEST
    // Tells file_get_content to act as POST client
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data),
            'ignore_errors' => true,
        ]
    ];
    $context = stream_context_create($options);

    // SEND REQUEST AND GET RESPONSE
    $response = file_get_contents($url, false, $context);

    // HANDLE RESPONSE
    if ($response === false) {
        return null;
    }

    // CONVERT RESPONSE TO ASSOC ARRAY
    $features = json_decode($response, true);

    if ($features === null) {
        return null;
    }

    return $features;
}


//////////////////////////////////////

// === PRINT FEATURES === //

function printFeatures(array $features, string $activity, string $title,): void
{ ?>
    <p class="subheading"><?= htmlspecialchars(trim($title)) ?></p>
    <div>
        <?php foreach ($features as $feature) :
            $name = htmlspecialchars(trim($feature['feature']));

            if ($feature['activity'] === $activity) : ?>
                <div class="feature-choice">
                    <input type="checkbox" name="features[]" value="<?= $feature['id'] ?>" id="<?= $name ?>">
                    <label for="<?= $name ?>"><?= ucfirst($name) ?></label>
                </div>
        <?php endif;
        endforeach; ?>
    </div> <?php
        }
