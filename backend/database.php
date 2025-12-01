<?php
// backend/database.php
$db_file = __DIR__ . '/portfolio.db';

try {
    $pdo = new PDO("sqlite:" . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Existing Tables
    $pdo->exec("CREATE TABLE IF NOT EXISTS profile (id INTEGER PRIMARY KEY, intro_title TEXT, intro_body TEXT, bio_text TEXT, residence TEXT, experience TEXT, email TEXT, image_url TEXT)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS services (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, icon TEXT)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT, message TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS home (id INTEGER PRIMARY KEY, volume_label TEXT, main_title TEXT, subtitle TEXT, role_text TEXT, avatar_url TEXT)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS projects (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, description TEXT, tags TEXT, image_url TEXT, repo_link TEXT, demo_link TEXT, content_html TEXT)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS blog (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, date TEXT, category TEXT, excerpt TEXT, content_html TEXT)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS education (id INTEGER PRIMARY KEY AUTOINCREMENT, institution TEXT, degree TEXT, year TEXT, details TEXT)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS experience (id INTEGER PRIMARY KEY AUTOINCREMENT, role TEXT, company TEXT, year TEXT, details TEXT)");

    // --- NEW SKILLS TABLE (This is the missing part) ---
    $pdo->exec("CREATE TABLE IF NOT EXISTS skills (
        id INTEGER PRIMARY KEY AUTOINCREMENT, 
        name TEXT, 
        category TEXT
    )");

    // Seed Default Profile if empty
    $check = $pdo->query("SELECT COUNT(*) FROM profile WHERE id=1")->fetchColumn();
    if ($check == 0) {
        $pdo->exec("INSERT INTO profile (id, intro_title, intro_body, bio_text, residence, experience, email, image_url) VALUES (1, 'H', 'ello.', 'Bio...', 'USA', '5 Years', 'alex@dev.com', '')");
    }

} catch (PDOException $e) {
    echo "DB Error: " . $e->getMessage();
    exit();
}
?>