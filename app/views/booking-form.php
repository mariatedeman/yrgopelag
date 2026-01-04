<?php

declare(strict_types=1);

// 1. Definiera dina kategorier (Rubrik => Kategori-nyckel)
$featureCategories = [
    'Coastal Experiences' => 'hotel-specific',
    'Water' => 'water',
    'Wheels' => 'wheels',
    'Games' => 'games'
];

// 2. Förbered datan: Hämta alla features och spara dem i en ny array
$allAvailableFeatures = [];
foreach ($featureCategories as $title => $category) {
    $foundFeatures = getFeaturesByCategory($features, $category, $database);
    if (!empty($foundFeatures)) {
        $allAvailableFeatures[$title] = $foundFeatures;
    }
}
?>

<form action="<?= URL_ROOT ?>/app/posts/booking-form.php" method="post" id="booking-form">
    <div class="offer-container">
        <p class="subheading">January offer</p>
        <p>Free seafood cruise with livemusic when you book our Premium Sea View Suite!</p>
        <label for="offer" class="subheading">Book offer</label>
        <input type="checkbox" name="offer" id="offer">
    </div>

    <span>
        <div>
            <label for="name">Your name</label>
            <input type="text" name="name" id="name" placeholder="Type your name">

            <label for="transfer_code">Transfer code</label>
            <input type="text" name="transfer_code" id="transfer_code" placeholder="Type your transfer code">
        </div>
        <div>
            <label for="checkIn">Arrival date</label>
            <input type="date" name="checkIn" id="checkIn" min="2026-01-01" max="2026-01-31">

            <label for="checkOut">Departure date</label>
            <input type="date" name="checkOut" id="checkOut" min="2026-01-01" max="2026-01-31">
        </div>
        <div>
            <label for="room_type">Room type</label>
            <select name="room_type" id="room_type" required>
                <option value="">Choose room</option>
                <option data-price="<?= htmlspecialchars((string)(int)$roomInfo[0]['price'], ENT_QUOTES, 'UTF-8') ?>" value="1">Budget</option>
                <option data-price="<?= htmlspecialchars((string)(int)$roomInfo[1]['price'], ENT_QUOTES, 'UTF-8') ?>" value="2">Standard</option>
                <option data-price="<?= htmlspecialchars((string)(int)$roomInfo[2]['price'], ENT_QUOTES, 'UTF-8') ?>" value="3">Luxury</option>
            </select>
        </div>
    </span>

    <div class="features-wrapper">
        <?php if (empty($allAvailableFeatures)) : ?>
            <p class="error">Could not load features. Refresh the page and try again.</p>
        <?php else : ?>

            <h3>In mood for something extra?</h3>
            <section class="features-container">

                <?php foreach ($allAvailableFeatures as $title => $items) : ?>
                    <section>
                        <p class="subheading"><?= htmlspecialchars($title) ?></p>
                        <?php foreach ($items as $feature) :
                            $featureId = (int)$feature['id'];
                            $featureName = htmlspecialchars(trim($feature['name']), ENT_QUOTES, 'UTF-8');
                            $featurePrice = (int)$feature['price'];
                        ?>
                            <div class="feature-choice">
                                <input type="checkbox"
                                    class="feature-checkbox"
                                    name="features[]"
                                    value="<?= $featureId ?>"
                                    id="feature-<?= $featureId ?>"
                                    data-price="<?= $featurePrice ?>">

                                <label for="feature-<?= $featureId ?>">
                                    <?= ucfirst($featureName) . ", " . $featurePrice . ":-" ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </section>
                <?php endforeach; ?>

            </section>
        <?php endif; ?>

        <div class="total-cost">
            <h3>Total cost:</h3>
            <div>
                <h3 id="total_cost">0</h3>
                <h3>:-</h3>
            </div>
        </div>
        <button type="submit">Make reservation</button>
    </div>
</form>