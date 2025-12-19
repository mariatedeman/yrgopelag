<?php

declare(strict_types=1);
require dirname(__DIR__) . "/autoload.php";

session_unset();
session_destroy();

header('Location: /');
exit;
