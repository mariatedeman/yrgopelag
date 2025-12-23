<?php

declare(strict_types=1);
require dirname(__DIR__) . "/autoload.php";


if (isset($_POST['name'], $_POST['guest_api'], $_POST['amount'])) {
    $guestName = htmlspecialchars(trim($_POST['name']));
    $guestApi = htmlspecialchars(trim($_POST['guest_api']));
    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT);

    $error = "";
    $transferCode = getTransferCode($guestName, $guestApi, (int)$amount, $error);

    if ($error !== "") {
        $_SESSION['error'] = $error;
        header('Location: /');
        exit;
    }

    if ($transferCode) {
        $_SESSION['success'] = $transferCode['transferCode'];
        header('Location: /');
        exit;
    }

    if ($transferCode === null) {
        $_SESSION['error'] = "Could not connect to central bank. Please try again later.";
        header('Location: /');
        exit;
    }
}
