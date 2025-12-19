<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

$database = new PDO('sqlite:' . __DIR__ . '/database/yrgopelag.db');
$statement = $database->prepare(
    'SELECT bookings.checkin, bookings.checkout, rooms.name AS room_name, guests.name, 
    bookings.is_paid,

    -- CALCULATE PRICE / NIGHT
    ((rooms.price * (julianday(bookings.checkout) - julianday(bookings.checkin))
    -- ADD FEATURES OR 0 OR NONE EXIST
    + IFNULL(SUM(features.price), 0))) AS total_cost 
    
    FROM bookings

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