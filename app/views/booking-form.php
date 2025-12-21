<form action="app/posts/booking-form.php" method="post" id="booking-form">

    <label for="offer">Beginning of year offer!</label>
    <input type="checkbox" name="offer" id="offer">

    <label for="text">Your name</label>
    <input type="text" name="name" placeholder="Type your name">

    <label for="text">Transfer code</label>
    <input type="text" name="transfer_code" placeholder="Type your transfer code">

    <label for="checkIn">Chose arrival date</label>
    <input type="date" name="checkIn" min="2026-01-01" max="2026-01-31">

    <label for="checkOut">Chose departure date</label>
    <input type="date" name="checkOut" min="2026-01-01" max="2026-01-31">

    <label for="room_type">Chose type of room</label>
    <select name="room_type" id="room_type" required>
        <option value="">Choose room</option>
        <option value="1">Budget</option>
        <option value="2">Standard</option>
        <option value="3">Luxury</option>
    </select>

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