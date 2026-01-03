<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sjoboda B&B</title>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.svg">

    <link rel="stylesheet" href="<?= URL_ROOT; ?>/assets/styles/library-components.css">
    <link rel="stylesheet" href="<?= URL_ROOT; ?>/assets/styles/forms.css">
    <link rel="stylesheet" href="<?= URL_ROOT; ?>/assets/styles/room-presentation.css">
    <link rel="stylesheet" href="<?= URL_ROOT; ?>/assets/styles/features-presentation.css">
    <link rel="stylesheet" href="<?= URL_ROOT; ?>/assets/styles/calender.css">
    <link rel="stylesheet" href="<?= URL_ROOT; ?>/assets/styles/offers.css">
    <link rel="stylesheet" href="<?= URL_ROOT; ?>/assets/styles/login-admin.css">
    <link rel="stylesheet" href="<?= URL_ROOT; ?>/assets/styles/messages.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=La+Belle+Aurore&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <header id="header">
        <a href="<?= URL_ROOT ?>"><img class="logo" src="<?= URL_ROOT; ?>/assets/images/sjoboda-logo-text-granitegrey.svg" alt="Sjöboda logo"></a>

        <section id="nav" class="overlay">
            <a href="javascript:void(0)" class="menu-close" onclick="closeNav()">&times;</a>

            <nav>
                <a href="./#back-to-top">Home</a>
                <p class="a subnavbtn" onclick="openSubMenu()">Our rooms</a>
                <div class="subnav-content">
                    <a href="./?room=1#our-rooms">Unique Waterfront Retreat</a>
                    <a href="./?room=2#our-rooms">Classic Sea Cabin</a>
                    <a href="./?room=3#our-rooms">Premium Sea View Suite</a>
                </div>

                <a href="./#get-transfercode">Booking</a>
                <a href="./#our-features">Our features</a>
            </nav>
            <span>
                <?php if (!isset($_SESSION['authenticated'])) { ?>
                    <a href="<?= URL_ROOT; ?>/app/users/login.php" class="a-small">Admin login</a>
                <?php } else { ?>
                    <a href="<?= URL_ROOT; ?>/app/admin.php" class="a-small">Admin dashboard</a>
                <?php } ?>
            </span>
        </section>

        <div onclick="openNav()">
            <img class="menu-icon" src="<?= URL_ROOT; ?>/assets/images/icon-menu.svg" alt="Icon for open menu">
        </div>
    </header>