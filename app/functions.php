<?php

declare(strict_types=1);


//////////////////////////////////////////////////


// GET ACCOUNT INFO
function getAccountInfo(string $user, string $apiKey): ?array
{
    $url = 'https://www.yrgopelag.se/centralbank/accountInfo';

    // PREPARE DATA TO SEND
    $userInfo = [
        'user' => $user,
        'api_key' => $apiKey
    ];
    $userInfoEncoded = json_encode($userInfo);

    // CREATE STREAM CONTEXT POST REQUEST
    // Tells file_get_contents to act as POST client
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => $userInfoEncoded
        ]
    ];
    $context = stream_context_create($options);

    // SEND REQUEST AND GET RESPONSE
    $response = file_get_contents($url, false, $context);

    // HANDLE RESPONSE
    if ($response === false) {
        echo "ERROR";
        return null;
    }

    // CONVERT RESPONSE TO ASSOC ARRAY
    $data = json_decode($response, true);

    if ($data === null) {
        echo "ERROR";
        return null;
    }

    return $data;
}


/////////////////////////////////////////////////