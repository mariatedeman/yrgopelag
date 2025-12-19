<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

$database = new PDO('sqlite:' . __DIR__ . '/database/yrgopelag.db');
$statement = $database->prepare(
    'SELECT bookings.checkin, bookings.checkout, rooms.name AS room_name, guests.name, 
    bookings.is_paid, bookings.total_cost FROM bookings

    INNER JOIN guests ON guests.id = bookings.guest_id
    INNER JOIN rooms ON rooms.id = bookings.room_id
    LEFT JOIN bookings_features ON bookings.id = bookings_features.feature_id
    LEFT JOIN features ON features.id = bookings_features.feature_id

    GROUP BY bookings.id'
);

$statement->execute();
$bookings = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
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
            <td><?= $booking['room_name'] ?>
            </td>
            <td><?= $booking['name'] ?></td>
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

<form action="/app/posts/update-price.php" method="POST">
    <label for="select-room">Select room</label>
    <select name="select-room" id="select-room">
        <option value="1">Budget</option>
        <option value="2">Standard</option>
        <option value="3">Luxury</option>
    </select>
    <label for="room-price">Type in new price</label>
    <input type="number" name="room-price">
    <button type="submit">Update room</button>
</form>

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
    <button type="submit">Update feature</button>
</form>

<!-- # ISLAND INFO
#   {
#     "id": 212,
#     "islandName": "Lyckholmen",
#     "hotelName": "Sjöboda B&amp;amp;B",
#     "url": "https://made-by-met.se/yrgopelag/",
#     "stars": 2,
#     "owner": 19,
#     "hotel_specific_name": "coastal experiences"
#   }, -->