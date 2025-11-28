<?php
// backend/database.php
$db_file = __DIR__ . '/portfolio.db';

try {
    $pdo = new PDO("sqlite:" . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 1. Tables
    $pdo->exec("CREATE TABLE IF NOT EXISTS profile (id INTEGER PRIMARY KEY, intro_title TEXT, intro_body TEXT, bio_text TEXT, residence TEXT, experience TEXT, email TEXT, image_url TEXT)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS services (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, icon TEXT)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT, message TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");

    // 2. Default Row 1
    $check = $pdo->query("SELECT COUNT(*) FROM profile WHERE id=1")->fetchColumn();
    if ($check == 0) {
        $pdo->exec("INSERT INTO profile (id, intro_title, intro_body, bio_text, residence, experience, email, image_url) VALUES (1, 'H', 'ello.', 'Bio...', 'USA', '5 Years', 'alex@dev.com', '')");
    }
} catch (PDOException $e) {
    echo "DB Error: " . $e->getMessage();
    exit();
}
?>