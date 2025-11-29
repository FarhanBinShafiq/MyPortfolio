<?php
// backend/database.php
$db_file = __DIR__ . '/portfolio.db';

try {
    $pdo = new PDO("sqlite:" . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 1. Profile Table (Existing)
    $pdo->exec("CREATE TABLE IF NOT EXISTS profile (id INTEGER PRIMARY KEY, intro_title TEXT, intro_body TEXT, bio_text TEXT, residence TEXT, experience TEXT, email TEXT, image_url TEXT)");
    
    // 2. Services Table (Existing)
    $pdo->exec("CREATE TABLE IF NOT EXISTS services (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, icon TEXT)");
    
    // 3. Messages Table (Existing)
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT, message TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");

    // 4. Home Page Table (NEW)
    $pdo->exec("CREATE TABLE IF NOT EXISTS home (id INTEGER PRIMARY KEY, volume_label TEXT, main_title TEXT, subtitle TEXT, role_text TEXT, avatar_url TEXT)");

    // 5. Projects Table (NEW)
    $pdo->exec("CREATE TABLE IF NOT EXISTS projects (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, description TEXT, tags TEXT, image_url TEXT, repo_link TEXT, demo_link TEXT, content_html TEXT)");

    // 6. Blog Table (NEW)
    $pdo->exec("CREATE TABLE IF NOT EXISTS blog (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, date TEXT, category TEXT, excerpt TEXT, content_html TEXT)");

    // 7. Education Table (NEW)
    $pdo->exec("CREATE TABLE IF NOT EXISTS education (id INTEGER PRIMARY KEY AUTOINCREMENT, institution TEXT, degree TEXT, year TEXT, details TEXT)");

    // 8. Experience Table (NEW)
    $pdo->exec("CREATE TABLE IF NOT EXISTS experience (id INTEGER PRIMARY KEY AUTOINCREMENT, role TEXT, company TEXT, year TEXT, details TEXT)");

    // --- SEED DEFAULT DATA ---
    
    // Profile
    $check = $pdo->query("SELECT COUNT(*) FROM profile WHERE id=1")->fetchColumn();
    if ($check == 0) {
        $pdo->exec("INSERT INTO profile (id, intro_title, intro_body, bio_text, residence, experience, email, image_url) VALUES (1, 'H', 'ello.', 'Bio...', 'USA', '5 Years', 'alex@dev.com', '')");
    }

    // Home
    $checkHome = $pdo->query("SELECT COUNT(*) FROM home WHERE id=1")->fetchColumn();
    if ($checkHome == 0) {
        $pdo->exec("INSERT INTO home (id, volume_label, main_title, subtitle, role_text, avatar_url) VALUES (1, 'VOLUME II', 'The<br>Engineer''s<br>Journal', 'Alex Developer', 'Full Stack Engineer', '')");
    }

} catch (PDOException $e) {
    echo "DB Error: " . $e->getMessage();
    exit();
}
?>