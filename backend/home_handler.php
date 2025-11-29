<?php
include 'database.php';
header("Content-Type: application/json");
ini_set('display_errors', 0); error_reporting(E_ALL);

$action = $_GET['action'] ?? '';

try {
    if ($action === 'fetch') {
        $data = $pdo->query("SELECT * FROM home WHERE id=1")->fetch(PDO::FETCH_ASSOC);
        echo json_encode($data);
        exit();
    }

    if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $img = $_POST['existing_image'];
        if (!empty($_FILES['avatar_image']['name'])) {
            $target = __DIR__ . "/../images/" . time() . "_" . basename($_FILES['avatar_image']['name']);
            if (move_uploaded_file($_FILES['avatar_image']['tmp_name'], $target)) {
                $img = "../images/" . basename($target);
            }
        }
        
        $sql = "UPDATE home SET volume_label=?, main_title=?, subtitle=?, role_text=?, avatar_url=? WHERE id=1";
        $pdo->prepare($sql)->execute([$_POST['volume_label'], $_POST['main_title'], $_POST['subtitle'], $_POST['role_text'], $img]);
        echo json_encode(["status" => "success"]);
        exit();
    }
} catch (Exception $e) { echo json_encode(["status" => "error", "message" => $e->getMessage()]); }
?>