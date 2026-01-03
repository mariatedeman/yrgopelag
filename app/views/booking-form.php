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
                <option data-price="<?= $roomInfo[0]['price'] ?>" value="1">Budget</option>
                <option data-price="<?= $roomInfo[1]['price'] ?>" value="2">Standard</option>
                <option data-price="<?= $roomInfo[2]['price'] ?>" value="3">Luxury</option>
            </select>
        </div>
    </span>

    <div class="features-wrapper">
        <?php
        $hotelSpecificFeatures = getFeaturesByCategory($features, 'hotel-specific', $database);
        $waterFeatures = getFeaturesByCategory($features, 'water', $database);
        $wheelsFeatures = getFeaturesByCategory($features, 'wheels', $database);
        $gamesFeatures = getFeaturesByCategory($features, 'games', $database);

        if (empty($hotelSpecificFeatures) && empty($waterFeatures) && empty($wheelsFeatures) && empty($gamesFeatures)) { ?>
            <p class="error">Could not load features. Refresh the page and try again.</p>
        <?php } else { ?>

            <h3>In mood for something extra?</h3>
            <section class="features-container">
                <section>
                    <p class="subheading">Coastal Experiences</p>
                    <?php foreach ($hotelSpecificFeatures as $feature) : ?>
                        <div class="feature-choice">
                            <input type="checkbox" class="feature-checkbox" name="features[]" value="<?= $feature['id'] ?>" id="<?= $feature['name'] ?>" data-price="<?= htmlspecialchars(trim(filter_var($feature['price'], FILTER_VALIDATE_INT))) ?>">
                            <label for="<?= $feature['name'] ?>"><?= ucfirst(htmlspecialchars(trim($feature['name']))) . ", " . htmlspecialchars(trim($feature['price'])) . ":-" ?></label>
                        </div>
                    <?php endforeach ?>
                </section>
                <section>
                    <p class="subheading">Water</p>
                    <?php foreach ($waterFeatures as $feature) : ?>
                        <div class="feature-choice">
                            <input type="checkbox" class="feature-checkbox" name="features[]" value="<?= $feature['id'] ?>" id="<?= $feature['name'] ?>" data-price="<?= htmlspecialchars(trim(filter_var($feature['price'], FILTER_VALIDATE_INT))) ?>">
                            <label for="<?= $feature['name'] ?>"><?= ucfirst(htmlspecialchars(trim($feature['name']))) . ", " . htmlspecialchars(trim($feature['price'])) . ":-" ?></label>
                        </div>
                    <?php endforeach ?>
                </section>
                <section>
                    <p class="subheading">Wheels</p>
                    <?php foreach ($wheelsFeatures as $feature) : ?>
                        <div class="feature-choice">
                            <input type="checkbox" class="feature-checkbox" name="features[]" value="<?= $feature['id'] ?>" id="<?= $feature['name'] ?>" data-price="<?= htmlspecialchars(trim(filter_var($feature['price'], FILTER_VALIDATE_INT))) ?>">
                            <label for="<?= $feature['name'] ?>"><?= ucfirst(htmlspecialchars(trim($feature['name']))) . ", " . htmlspecialchars(trim($feature['price'])) . ":-" ?></label>
                        </div>
                    <?php endforeach ?>
                </section>
                <section>
                    <p class="subheading">Games</p>
                    <?php foreach ($gamesFeatures as $feature) : ?>
                        <div class="feature-choice">
                            <input type="checkbox" class="feature-checkbox" name="features[]" value="<?= $feature['id'] ?>" id="<?= $feature['name'] ?>" data-price="<?= htmlspecialchars(trim(filter_var($feature['price'], FILTER_VALIDATE_INT))) ?>">
                            <label for="<?= $feature['name'] ?>"><?= ucfirst(htmlspecialchars(trim($feature['name']))) . ", " . htmlspecialchars(trim($feature['price'])) . ":-" ?></label>
                        </div>
                    <?php endforeach ?>
                </section>
            </section>
        <?php } ?>

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