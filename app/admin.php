<?php

declare(strict_types=1);
require __DIR__ . "/autoload.php";
require dirname(__DIR__) . "/includes/header.php";

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: ' . URL_ROOT . "/app/views/login.php");
    exit;
}

$islandInfo = $islandInfo ?? 'N/A';
?>

<section>
    <div class="admin-hero-img">
        <h2>Welcome <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></h2>
        <p>Hotel administration dashboard</p>
        <a href="./posts/logout.php" class="button">Log out</a>
    </div>
</section>

<section class="admin-info-container">
    <!--- PRINT LIST OF HOTEL INFO -->
    <section class="info-wrapper hotel-info">
        <p><strong>Island name: </strong><?= htmlspecialchars($islandName, ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Hotel name: </strong><?= htmlspecialchars($hotelName, ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Stars: </strong><?= htmlspecialchars((string)($islandInfo['island']['stars'] ?? 'N/A'), ENT_QUOTES, 'UTF-8') ?></p>
    </section>

    <!-- PRINT LIST OF AVAILABLE FEATURES -->
    <section class="info-wrapper features-info">

        <?php
        $filteredFeatures[] = $hotelSpecificFeatures = getFeaturesByCategory($features, 'hotel-specific', $database);
        $filteredFeatures[] = $waterFeatures = getFeaturesByCategory($features, 'water', $database);
        $filteredFeatures[] = $wheelsFeatures = getFeaturesByCategory($features, 'wheels', $database);
        $filteredFeatures[] = $gamesFeatures = getFeaturesByCategory($features, 'games', $database);
        ?>

        <h4>Available features</h4>
        <section class="features-list">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Price category</th>
                </tr>
                <?php foreach ($filteredFeatures as $feature) :
                    foreach ($feature as $feature_info) : ?>
                        <tr>
                            <td><?= htmlspecialchars(ucfirst($feature_info['name']), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars(ucfirst($feature_info['activity_category']), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string)(int)$feature_info['price'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars(ucfirst($feature_info['price_category']), ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                <?php endforeach;
                endforeach ?>
            </table>
        </section>
    </section>


    <?php
    $bookings = [];
    // --- FETCH INFO FROM DATABASE TO PRESENT IN TABLE
    try {
        $statement = $database->prepare('SELECT bookings.id, bookings.checkin, bookings.checkout, rooms.room_category AS room_category, guests.name, bookings.is_paid, bookings.total_cost FROM bookings

        INNER JOIN guests ON guests.id = bookings.guest_id
        INNER JOIN rooms ON rooms.id = bookings.room_id
        LEFT JOIN bookings_features ON bookings.id = bookings_features.booking_id
        LEFT JOIN features ON features.id = bookings_features.feature_id
    
        GROUP BY bookings.id');

        $statement->execute();
        $bookings = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
    } ?>

    <!-- LIST OF BOOKINGS -->
    <section class="info-wrapper bookings">
        <h4>Bookings january 2026</h4>
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
                    <td><?= htmlspecialchars($booking['checkin'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($booking['checkout'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars(ucfirst($booking['room_category']), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td><?= htmlspecialchars(ucfirst($booking['name']), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars((string)(int)$booking['total_cost'], ENT_QUOTES, 'UTF-8') ?></td>
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
        <h4>Update room price</h4>
        <form action="./posts/update-price.php" method="POST">
            <div>
                <label for="select-room">Select room</label>
                <select name="select-room" id="select-room">
                    <option value="1">Budget</option>
                    <option value="2">Standard</option>
                    <option value="3">Luxury</option>
                </select>
            </div>
            <div>
                <label for="room-price">Type in new price</label>
                <input type="number" name="room-price" id="room-price">
            </div>
            <button type="submit">Update</button>
        </form>
    </section>

    <section class="info-wrapper update-feature-price">
        <h4>Update feature price</h4>
        <form action="./posts/update-price.php" method="POST">
            <div>
                <label for="select-feature">Select feature category</label>
                <select name="select-feature" id="select-feature">
                    <option value="Economy">Economy</option>
                    <option value="Basic">Basic</option>
                    <option value="Premium">Premium</option>
                    <option value="Superior">Superior</option>
                </select>
            </div>
            <div>
                <label for="feature-price">Type in new price</label>
                <input type="number" name="feature-price" id="feature-price">
            </div>
            <button type="submit">Update</button>
        </form>
    </section>
</section>

<?php require dirname(__DIR__) . "/includes/footer.php";
