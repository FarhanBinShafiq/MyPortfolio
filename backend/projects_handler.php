<?php
include 'database.php';
header("Content-Type: application/json");
ini_set('display_errors', 0); error_reporting(E_ALL);

$action = $_GET['action'] ?? '';

try {
    if ($action === 'fetch_all') {
        echo json_encode($pdo->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC));
        exit();
    }

    if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $img = '';
        if (!empty($_FILES['image']['name'])) {
            $target = __DIR__ . "/../images/" . time() . "_" . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            $img = "../images/" . basename($target);
        }
        $sql = "INSERT INTO projects (title, description, tags, image_url, repo_link, demo_link) VALUES (?, ?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$_POST['title'], $_POST['description'], $_POST['tags'], $img, $_POST['repo'], $_POST['demo']]);
        echo json_encode(["status" => "success"]);
        exit();
    }

    if ($action === 'delete') {
        $pdo->prepare("DELETE FROM projects WHERE id=?")->execute([$_GET['id']]);
        echo json_encode(["status" => "success"]);
        exit();
    }
} catch (Exception $e) { echo json_encode(["status" => "error", "message" => $e->getMessage()]); }
?>