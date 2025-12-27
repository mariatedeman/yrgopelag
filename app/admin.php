<?php

declare(strict_types=1);
require __DIR__ . "/autoload.php";
require dirname(__DIR__) . "/includes/header.php";

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: ' . __DIR__ . "/views/login.php");
}

?>

<section>
    <div class="admin-hero-img">
        <h2>Hotel administration</h2>
    </div>
</section>

<section class="admin-info-container">
    <!--- PRINT LIST OF HOTEL INFO -->
    <section class="info-wrapper hotel-info">
        <p><strong>Island name: </strong><?= ucfirst($islandInfo['island']['islandName']) ?></p>
        <p><strong>Hotel name: </strong><?= ucfirst($islandInfo['island']['hotelName']) ?></p>
        <p><strong> Stars: </strong><?= $islandInfo['island']['stars'] ?></p>
    </section>

    <!-- PRINT LIST OF AVAILABLE FEATURES -->
    <section class="info-wrapper features-info">

        <h4>Available features</h4>
        <section class="features-list">
            <div>
                <p class="subheading">Coastal Experiences</p>
                <?php foreach ($features as $feature) :
                    if ($feature['activity'] === 'hotel-specific') : ?>
                        <p><?= ucfirst($feature['feature']); ?></p>
                <?php endif;
                endforeach; ?>
            </div>

            <div>
                <p class="subheading">Water</p>

                <?php foreach ($features as $feature) :
                    if ($feature['activity'] === 'water') : ?>
                        <p><?= ucfirst($feature['feature']); ?></p>
                <?php endif;
                endforeach; ?>

            </div>

            <div>
                <p class="subheading">Wheels</p>

                <?php foreach ($features as $feature) : ?>
                    <?php if ($feature['activity'] === 'wheels') : ?>
                        <p><?= ucfirst($feature['feature']); ?></p>
                <?php endif;
                endforeach; ?>

            </div>

            <div>
                <p class="subheading">Games</p>

                <?php foreach ($features as $feature) : ?>
                    <?php if ($feature['activity'] === 'games') : ?>
                        <p><?= ucfirst($feature['feature']); ?></p>
                <?php endif;
                endforeach; ?>

            </div>
        </section>
    </section>

    <?php
    // --- FETCH INFO FROM DATABASE TO PRESENT IN TABLE
    $database = new PDO('sqlite:' . __DIR__ . '/database/yrgopelag.db');
    $statement = $database->prepare(
        'SELECT bookings.id, bookings.checkin, bookings.checkout, rooms.room_category AS room_category, guests.name, bookings.is_paid, bookings.total_cost FROM bookings

INNER JOIN guests ON guests.id = bookings.guest_id
INNER JOIN rooms ON rooms.id = bookings.room_id
LEFT JOIN bookings_features ON bookings.id = bookings_features.feature_id
LEFT JOIN features ON features.id = bookings_features.feature_id

GROUP BY bookings.id'
    );
    $statement->execute();
    $bookings = $statement->fetchAll(PDO::FETCH_ASSOC); ?>

    <!-- LIST OF BOOKINGS -->
    <section class="info-wrapper bookings">
        <table>
            <tr>
                <th>Arrival</th>
                <th>Departure</th>
                <th>Room</th>
                <th>Guest</th>
                <th>Cost</th>
                <th>Paid</th>
            </tr>
            <?php foreach ($bookings as $booking) : ?>
                <tr>
                    <td><?= $booking['checkin'] ?></td>
                    <td><?= $booking['checkout'] ?></td>
                    <td><?= ucfirst($booking['room_category']) ?>
                    </td>
                    <td><?= ucfirst($booking['name']) ?></td>
                    <td><?= $booking['total_cost'] ?></td>
                    <td>
                        <?php if ($booking['is_paid']) {
                            echo "True";
                        } else {
                            echo "False";
                        } ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </section>

    <!-- PRICE UPDATE FOR ROOMS AND FEATURES -->
    <section class="info-wrapper update-room-price">
        <form action="/app/posts/update-price.php" method="POST">
            <label for="select-room">Select room</label>
            <select name="select-room" id="select-room">
                <option value="1">Budget</option>
                <option value="2">Standard</option>
                <option value="3">Luxury</option>
            </select>
            <label for="room-price">Type in new price</label>
            <input type="number" name="room-price">
            <button type="submit">Update room price</button>
        </form>
    </section>

    <section class="info-wrapper update-feature-price">
        <form action="/app/posts/update-price.php" method="POST">
            <label for="select-feature">Select feature category</label>
            <select name="select-feature" id="select-feature">
                <option value="Economy">Economy</option>
                <option value="Basic">Basic</option>
                <option value="Premium">Premium</option>
                <option value="Superior">Superior</option>
            </select>
            <label for="feature-price">Type in new price</label>
            <input type="number" name="feature-price">
            <button type="submit">Update feature price</button>
        </form>
    </section>
</section>

<?php require dirname(__DIR__) . "/includes/footer.php";
