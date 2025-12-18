<?php

declare(strict_types=1);


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

function postReceipt(string $key, string $guestName, string $checkIn, string $checkOut, int $totalCost): ?array
{

    $url = 'https://www.yrgopelag.se/centralbank/receipt';

    $receiptInfo = [
        "user" => "Maria",
        "api_key" => $key,
        "island_id" => 212,
        "guest_name" => $guestName,
        "arrival_date" => $checkIn,
        "departure_date" => $checkOut,
        "features_used" => [],
        "star_rating" => 2
    ];

    // CREATE STREAM CONTEXT POST REQUEST
    // Tells file_get_contents to act as POST client
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($receiptInfo)
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