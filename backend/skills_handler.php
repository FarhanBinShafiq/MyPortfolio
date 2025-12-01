<?php
// backend/skills_handler.php
include 'database.php';
header("Content-Type: application/json");
ini_set('display_errors', 0); error_reporting(E_ALL);

$action = $_GET['action'] ?? '';

try {
    // 1. Fetch All Skills
    if ($action === 'fetch_all') {
        echo json_encode($pdo->query("SELECT * FROM skills ORDER BY category, name")->fetchAll(PDO::FETCH_ASSOC));
        exit();
    }

    // 2. Add New Skill
    if ($action === 'add') {
        $d = json_decode(file_get_contents("php://input"), true);
        if(!empty($d['name'])) {
            $pdo->prepare("INSERT INTO skills (name, category) VALUES (?, ?)")
                ->execute([$d['name'], $d['category']]);
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Name required"]);
        }
        exit();
    }

    // 3. Delete Skill
    if ($action === 'delete') {
        $pdo->prepare("DELETE FROM skills WHERE id=?")->execute([$_GET['id']]);
        echo json_encode(["status" => "success"]);
        exit();
    }
} catch (Exception $e) { 
    echo json_encode(["status" => "error", "message" => $e->getMessage()]); 
}
?>