<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

$database = new PDO('sqlite:' . __DIR__ . '/database/yrgopelag.db');
$statement = $database->prepare('SELECT * from rooms_features
                                INNER JOIN rooms ON rooms.id = rooms_features.room_id
                                INNER JOIN features ON features.id = rooms_features.feature_id
                                INNER JOIN bookings ON bookings.room_id = rooms.id
                                INNER JOIN guests ON guests.id = bookings.guest_id');
$statement->execute();
$bookings = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
var_dump($bookings);
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
            <td>
                <?php if ($booking['room_id'] === 1) {
                    echo "Budget";
                } else if ($booking['room_id'] === 2) {
                    echo "Standard";
                } else if ($booking['room_id'] === 3) {
                    echo "Luxury";
                } ?>
            </td>
            <td><?= $booking['name'] ?></td>
            <td><?= $booking['price'] ?></td>
            <td>
                <?php if ($booking['is_paid']) {
                    echo "True";
                } ?>
            </td>
        </tr>

    <?php endforeach ?>
</table>

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