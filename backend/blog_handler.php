<?php
include 'database.php';
header("Content-Type: application/json");
ini_set('display_errors', 0); error_reporting(E_ALL);

$action = $_GET['action'] ?? '';

try {
    if ($action === 'fetch_all') {
        echo json_encode($pdo->query("SELECT * FROM blog ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC));
        exit();
    }

    if ($action === 'add') {
        $d = json_decode(file_get_contents("php://input"), true);
        $sql = "INSERT INTO blog (title, date, category, excerpt) VALUES (?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$d['title'], $d['date'], $d['category'], $d['excerpt']]);
        echo json_encode(["status" => "success"]);
        exit();
    }

    if ($action === 'delete') {
        $pdo->prepare("DELETE FROM blog WHERE id=?")->execute([$_GET['id']]);
        echo json_encode(["status" => "success"]);
        exit();
    }
} catch (Exception $e) { echo json_encode(["status" => "error", "message" => $e->getMessage()]); }
?>