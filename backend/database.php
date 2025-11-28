<?php
// backend/database.php

$db_file = __DIR__ . '/portfolio.db';

try {
    $pdo = new PDO("sqlite:" . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Create Profile Table (For Bio, Intro, Image)
    $pdo->exec("CREATE TABLE IF NOT EXISTS profile (
        id INTEGER PRIMARY KEY,
        intro_title TEXT,
        intro_body TEXT,
        bio_text TEXT,
        residence TEXT,
        experience TEXT,
        email TEXT,
        image_url TEXT
    )");

    // 2. Create Services Table (For Capabilities Cards)
    $pdo->exec("CREATE TABLE IF NOT EXISTS services (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT,
        icon TEXT
    )");

    // 3. Seed Default Data (So page isn't empty)
    $check = $pdo->query("SELECT COUNT(*) FROM profile");
    if ($check->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO profile (id, intro_title, intro_body, bio_text, residence, experience, email, image_url) 
        VALUES (1, 'H', 'ello, I am Alex.', 'My journey started...', 'Silicon Valley, CA', '5+ Years', 'alex@dev.com', '')");
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>