<?php

declare(strict_types=1);
require __DIR__ . "/includes/header.php";



$accountInfo = getAccountInfo('Maria', $key);
var_dump($accountInfo);

if ($accountInfo) {
    echo "Nuvarande saldo: " . $accountInfo['credit'];
} else {
    echo "Vi kunde inte hämta ditt saldo.";
}

