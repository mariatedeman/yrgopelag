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

// === GET TRANSFER CODE === //

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
            'timeout' => 2, // GIVE UP AFTER TWO SECONDS OF LOADING
        ],
    ];

    $context = stream_context_create($options);

    // RETRY-LOOP
    $attempts = 0;
    $maxAttempts = 3;

    while ($attempts < $maxAttempts) {
        // SEND REQUEST AND GET RESPONSE
        $response = file_get_contents($url, false, $context);

        if ($response !== false) {
            $transferCode = json_decode($response, true);

            // IF ERROR, TRYING AGAIN WONT HELP
            if (isset($transferCode['error'])) {
                $message = $transferCode['error'];
                return $transferCode;
            }

            // CONNECTION SUCCEEDED
            return $transferCode;
        }

        // IF NOT SUCCESSFULL, KEEP TRYING
        $attempts++;
        if ($attempts < $maxAttempts) {
            usleep(500000); // WAIT 0.5s BEFORE NEXT TRY
        }
    }

    // ALL ATTEMPTS FAILED
    return null;
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
        ],
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

    if (!isset($result['status']) || $result['status'] !== 'success') {
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
        ],
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

function postReceipt(string $key, string $guestName, string $checkIn, string $checkOut, int $totalCost, int $hotelStars, array $features, string &$message = ''): ?array
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
        ],
    ];
    $context = stream_context_create($options);

    // SEND REQUEST AND GET RESPONSE
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        $message = "Could not connect to central bank.";
        return null;
    }

    $result = json_decode($response, true);

    if (isset($result['error'])) {
        $message = $result['error'];
        return null;
    }

    return $result;
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
        ],
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
            'timeout' => 2, // GIVE UP AFTER TWO SECONDS OF LOADING
        ],
    ];
    $context = stream_context_create($options);

    // RETRY-LOOP
    $attempts = 0;
    $maxAttempts = 3;

    while ($attempts < $maxAttempts) {
        // SEND REQUEST AND GET RESPONSE
        $response = file_get_contents($url, false, $context);

        if ($response !== false) {
            return json_decode($response, true);
        }

        $attempts++;
        usleep(500000); // WAIT 0.5s BEFORE NEXT TRY
    }

    return null;
}


//////////////////////////////////////

// === PRINT FEATURES === //

function getFeaturesByCategory(?array $features, string $activity, PDO $database): array
{
    $features = $features ?? [];
    $filteredFeatures = [];

    $statement = $database->prepare('SELECT * FROM features WHERE id = :feature_id');

    foreach ($features as $feature) {
        if ($feature['activity'] == $activity) {
            $statement->bindValue(':feature_id', $feature['id']);
            $statement->execute();

            $featureData = $statement->fetch(PDO::FETCH_ASSOC);

            if ($featureData) {
                $filteredFeatures[] = [
                    'id' => $feature['id'],
                    'name' => htmlspecialchars(trim($feature['feature'])),
                    'activity_category' => $featureData['activity_category'],
                    'price' => $featureData['price'] ?? 0,
                    'price_category' => $featureData['price_category'],
                ];
            }
        }
    }

    // SORT BY PRICE
    usort($filteredFeatures, function ($a, $b) {
        return $a['price'] <=> $b['price'];
    });

    return $filteredFeatures;
}
