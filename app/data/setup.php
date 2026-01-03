<?php

declare(strict_types=1);

// === DATABASE SETUP === //

function setupDatabase(PDO $database): void
{

    // ACTIVATE FOREIGN KEYS
    $database->exec('PRAGMA foreign_keys = ON');

    createTables($database);
    addData($database);
}

// === CREATE TABLES === //

function createTables(PDO $database): void
{

    // SETTINGS
    $database->exec('CREATE TABLE IF NOT EXISTS settings (
        id INTEGER PRIMARY KEY,
        setting_name VARCHAR UNIQUE,
        setting_value INTEGER
    )');

    // GUESTS
    $database->exec('CREATE TABLE IF NOT EXISTS guests (
        id INTEGER PRIMARY KEY,
        name VARCHAR,
        total_nights INTEGER DEFAULT 0,
        loyal_discount_used BOOL DEFAULT false
    )');

    // ROOMS
    $database->exec('CREATE TABLE IF NOT EXISTS rooms (
        id INTEGER PRIMARY KEY,
        room_category VARCHAR,
        room_name VARCHAR,
        description VARCHAR,
        price INTEGER
    )');

    // BOOKINGS
    $database->exec('CREATE TABLE IF NOT EXISTS bookings (
        id INTEGER PRIMARY KEY,
        checkin DATE,
        checkout DATE,
        guest_id INTEGER,
        room_id INTEGER,
        total_cost INTEGER,
        is_paid BOOLEAN DEFAULT false,
        FOREIGN KEY (guest_id) REFERENCES guests(id),
        FOREIGN KEY (room_id) REFERENCES rooms(id)
    )');

    // FEATURES
    $database->exec('CREATE TABLE IF NOT EXISTS features (
        id INTEGER PRIMARY KEY,
        activity_category VARCHAR,
        price_category VARCHAR,
        feature_name VARCHAR,
        api_key VARCHAR,
        price INTEGER,
        feature_description VARCHAR
    )');

    // BOOKINGS_FEATURES
    $database->exec('CREATE TABLE IF NOT EXISTS bookings_features (
        booking_id INTEGER,
        feature_id INTEGER,
        FOREIGN KEY (booking_id) REFERENCES bookings(id),
        FOREIGN KEY (feature_id) REFERENCES features(id)
    )');

    // CREATE TRIGGER 
    $database->exec('DROP TRIGGER IF EXISTS update_total_nights_on_insert');

    $database->exec('CREATE TRIGGER update_total_nights_on_insert
        AFTER INSERT ON bookings
        BEGIN
        UPDATE guests
        SET total_nights = total_nights + (julianday(NEW.checkout) - julianday(NEW.checkin))
        WHERE id = NEW.guest_id;
        END');
}

// === ADD DATA TO TABLES === //

function addData(PDO $database): void
{

    // CHECK IF EMPTY, OTHERWISE ADD

    // SETTINGS
    $statement = $database->query("SELECT COUNT(*) FROM settings WHERE setting_name = 'cache_version'");
    if ((int)$statement->fetchColumn() === 0) {
        $database->exec("INSERT INTO settings (setting_name, setting_value) VALUES ('cache_version', 1)");
    }

    // ROOMS 
    $statement = $database->query("SELECT COUNT(*) FROM rooms");
    if ((int)$statement->fetchColumn() === 0) {
        $database->exec(
            <<<SQL
        INSERT INTO rooms (room_category, room_name, description, price)
        VALUES ('budget', 'Unique Waterfront Retreat',
                'Experience the most genuine West Coast immersion. Your charming, authentic traditional wooden boat (snipa) is uniquely moored on the dramatic, windy side of Lyckholmen island, offering an unparalleled connection to nature. Retreat to the cozy, rustic cabin and let the gentle lapping of the waves lull you to sleep. Note on Amenities: To preserve its vintage character, the onboard head (toilet) is not available for use. Guests are asked to make alternative arrangements.', 5),
            
                ('standard', 'Classic Sea Cabin Standard Room',
                'Experience the authentic coastal character combined with the convenience of modern living! Our Standard Room is situated within a row of iconic, classic sea cabins (sjöbodar). These charming unit have been thoughtfully and modestly refurbished, incorporating essential modern comforts such as a private WC and shower, ensuring a comfortable and atmospheric stay right by the water.', 7),
            
                ('luxury', 'Premium Sea View Suite',
                'Indulge in our most exclusive offering. Our Premium Sea View Suites are perfectly positioned on the island’s tranquil side guaranteeing serene conditions and spectacular views with the perfect ammount of sea breeze. This suite provide unrivalled waterfront luxury, featuring a private jetty and an invigorating outdoor jacuzzi. Enjoy the ultimate relaxation with direct access to the sea for private bathing, all just steps from your door. This is the pinnacle of coastal retreat.', 10);
SQL
        );
    }

    // FEATURES
    $statement = $database->query("SELECT COUNT(*) FROM features");
    if ((int)$statement->fetchColumn() === 0) {
        $database->exec(
            <<<SQL
        INSERT INTO features (activity_category, price_category, feature_name, api_key, price, feature_description)
        VALUES ('hotel-specific', 'Economy', 'crab fishing (mussels not included)', 'crab fishing (mussels not included)', 1, "Try your luck at the dock with our classic crab fishing activity, though you'll need to bring your own mussels for bait."),
            ('hotel-specific', 'Basic', 'shrimp feast', 'shrimp feast', 3, "Indulge in a fresh and local shrimp feast served right by the waterfront as the sun sets."),
            ('hotel-specific', 'Premium', 'seal safari', 'seal safari', 5, "Embark on an unforgettable boat journey to witness playful seals basking on the sun-warmed granite rocks."),
            ('hotel-specific', 'Superior', 'seafood cruise with live music', 'seafood cruise with live music', 7, "Enjoy a premium seafood buffet and live entertainment while cruising through the stunning island landscape."),
            ('Water', 'Economy', 'pool', 'pool', 1, "Take a refreshing dip in our beautifully integrated pool, offering a calm alternative to the open sea."),
            ('Water', 'Basic', 'scuba diving', 'scuba diving', 3, "Explore the hidden wonders beneath the surface with a guided scuba diving adventure in the clear Baltic waters."),
            ('Water', 'Premium', 'olympic pool', 'olympic pool', 5, "Train like a pro in our full-sized Olympic pool, designed for swimmers who want to maintain their workout routine."),
            ('Water', 'Superior', 'waterpark with fire and minibar', 'waterpark with fire and minibar', 7, "Experience the ultimate thrill in our unique waterpark, featuring dramatic fire displays and a convenient swim-up minibar."),
            ('Games', 'Economy', 'yahtzee', 'yahtzee', 1, "Unwind on the terrace with a classic game of Yahtzee, the perfect way to spend a slow archipelago afternoon."),
            ('Games', 'Basic', 'ping pong table', 'ping pong table', 3, "Challenge your friends to a fast-paced match at our outdoor ping pong table with a spectacular view of the bay."),
            ('Games', 'Premium', 'PS5', 'PS5', 5, "Relax in your suite with the latest gaming technology on our high-performance PlayStation 5 consoles."),
            ('Games', 'Superior', 'casino', 'casino', 7, "Test your luck and enjoy a sophisticated evening of games at our exclusive island casino."),
            ('Wheels', 'Economy', 'unicycle', 'unicycle', 1, "For those seeking a unique challenge, try balancing your way around the resort on one of our unicycles."),
            ('Wheels', 'Basic', 'bicycle', 'bicycle', 3, "Discover the island's scenic trails and hidden paths at your own pace with our complimentary bicycles."),
            ('Wheels', 'Premium', 'trike', 'trike', 5, "Enjoy a stable and comfortable ride through the coastal landscape on one of our stylish adult trikes."),
            ('Wheels', 'Superior', 'four-wheeled motorized beast', 'four-wheeled motorized beast', 7, "Conquer the rugged terrain and feel the power of the island with our robust four-wheeled motorized beasts.");
SQL
        );
    }
}
