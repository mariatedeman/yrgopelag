<?php

declare(strict_types=1);
require dirname(__DIR__) . "/autoload.php";

$features = $features[0];

printFeatures($features, 'hotel-specific', 'Coastal Experiences');
printFeatures($features, 'games', 'Games');
printFeatures($features, 'water', 'Water');
printFeatures($features, 'wheels', 'Wheels');
