<script src="<?= URL_ROOT; ?>/assets/scripts/script.js"></script>
<footer>
    <nav>
        <a href="<?= URL_ROOT; ?>/">Home</a>
        <a href="<?= URL_ROOT; ?>/#our-rooms">Our rooms</a>
        <a href="<?= URL_ROOT; ?>/#get-transfercode">Booking</a>
        <a href="<?= URL_ROOT; ?>/#our-features">Our features</a>
        <?php if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] === false) { ?>
            <a href="<?= URL_ROOT; ?>/app/users/login.php">Admin login</a>
        <?php } else { ?>
            <a href="<?= URL_ROOT; ?>/app/admin.php">Admin dashboard</a>
        <?php } ?>
    </nav>
    <a href="<?= URL_ROOT; ?>"><img src="<?= URL_ROOT; ?>/assets/images/sjoboda_logo_bohuslangrey.svg" alt="Sjöboda logo"></a>

    <div>
        <p>Follow us!</p>
        <div>
            <img src="<?= URL_ROOT; ?>/assets/images/logo-facebook.svg" alt="Facebook logo">
            <img src="<?= URL_ROOT; ?>/assets/images/logo-instagram.svg" alt="Instagram logo">
        </div>
    </div>
</footer>

</body>

</html>