<script src="/assets/scripts/script.js"></script>
<footer>
    <nav>
        <?php if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] === false) { ?>
            <a href="/app/views/login.php">Login</a>
        <?php } else { ?>
            <a href="/app/posts/logout.php">Log out</a>
        <?php } ?>
    </nav>
    <img src="/assets/images/sjoboda_logo_bohuslangrey.svg" alt="sjoboda-logo">
</footer>

</body>

</html>