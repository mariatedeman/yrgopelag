<?php

declare(strict_types=1);

require dirname(__DIR__) . "/posts/booking-form.php" ?>

<form action="booking-form.php" method="post">
    <label for="text">Your name</label>
    <input type="text" name="name" placeholder="Type your name">

    <label for="text">Transfer code</label>
    <input type="text" name="transfer_code" placeholder="Type your transfer code">

    <label for="checkIn">Chose arrival date</label>
    <input type="date" name="checkIn" min="2026-01-01" max="2026-01-31">

    <label for="checkOut">Chose departure date</label>
    <input type="date" name="checkOut" min="2026-01-01" max="2026-01-31">

    <label for=" room_type">Chose type of room</label>
    <select name="room_type" id="">
        <option value="1">Budget</option>
        <option value="2">Standard</option>
        <option value="3">Luxury</option>
    </select>

    <button type="submit">Make reservation</button>
</form>