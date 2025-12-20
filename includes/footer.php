<script src="/assets/scripts/script.js"></script>

<nav>
    <?php if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] === false) { ?>
        <a href="/app/views/login.php">Login</a>
    <?php } else { ?>
        <a href="/app/posts/logout.php">Log out</a>
    <?php } ?>
</nav>

</body>

</html>