<script src="/assets/scripts/script.js"></script>
<footer>
    <nav>
        <a href="/">Home</a>
        <a href="/#our-rooms">Our rooms</a>
        <a href="/#get-transfercode">Booking</a>
        <a href="/#our-features">Our features</a>
        <?php if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] === false) { ?>
            <a href="/app/users/login.php">Admin login</a>
        <?php } else { ?>
            <a href="/app/admin.php">Admin dashboard</a>
        <?php } ?>
    </nav>
    <img src="/assets/images/sjoboda_logo_bohuslangrey.svg" alt="Sjöboda logo">

    <div>
        <p>Follow us!</p>
        <div>
            <img src="/assets/images/logo-facebook.svg" alt="Facebook logo">
            <img src="/assets/images/logo-instagram.svg" alt="Instagram logo">
        </div>
    </div>
</footer>

</body>

</html>