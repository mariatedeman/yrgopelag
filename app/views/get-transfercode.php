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

<div class="transfercode-container">
    <div class="button">
        <button class="open-button">Open</button>
    </div>
    <div class="popup">
        <div class="popup-overlay">
            <div class="main-popup">
                <div class="popup-content">
                    <span class="close-button">&times;</span>
                    <p>Get transfer code</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos et, cupiditate voluptas natus, tempore voluptatum veritatis incidunt voluptates inventore consectetur placeat quod, reiciendis odit nisi itaque commodi unde? Sed, ullam.</p>
                </div>
            </div>
        </div>
    </div>
</div>