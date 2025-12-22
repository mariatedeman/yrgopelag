<form action="/app/posts/get-transfer-code.php" method="post" id="get-transfer-code">
    <label for="name"></label>
    <input type="text" name="name" id="name" placeholder="Your name">

    <label for="guest_api"></label>
    <input type="text" name="guest_api" id="guest_api" placeholder="Your api key">

    <label for="amount"></label>
    <input type="number" name="amount" id="amount" placeholder="0">

    <button type="submit">Fetch transfercode</button>
</form>

<?php if (isset($_SESSION['error'])) { ?>
    <p><?= htmlspecialchars($_SESSION['error']) ?></p>
<?php unset($_SESSION['error']);
} else if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
} ?>

<form action="app/posts/booking-form.php" method="post" id="booking-form">
    <div>
        <label for="offer">Beginning of year offer!</label>
        <input type="checkbox" name="offer" id="offer">
    </div>
    <span>

        <div>
            <label for="name">Your name</label>
            <input type="text" name="name" placeholder="Type your name">

            <label for="transfer_code">Transfer code</label>
            <input type="text" name="transfer_code" placeholder="Type your transfer code">
        </div>

        <div>
            <label for="checkIn">Arrival date</label>
            <input type="date" name="checkIn" min="2026-01-01" max="2026-01-31">

            <label for="checkOut">Departure date</label>
            <input type="date" name="checkOut" min="2026-01-01" max="2026-01-31">
        </div>
        <div>

            <label for="room_type">Room type</label>
            <select name="room_type" id="room_type" required>
                <option value="">Choose room</option>
                <option value="1">Budget</option>
                <option value="2">Standard</option>
                <option value="3">Luxury</option>
            </select>
        </div>
    </span>

    <div class="features-container">
        <div>
            <?php printFeatures($features, 'hotel-specific', 'Coastal Experiences'); ?>
        </div>
        <div>
            <?php printFeatures($features, 'games', 'Games'); ?>
        </div>
        <div>
            <?php printFeatures($features, 'water', 'Water'); ?>
        </div>
        <div>
            <?php printFeatures($features, 'wheels', 'Wheels'); ?>
        </div>
    </div>

    <button type="submit">Make reservation</button>
</form>