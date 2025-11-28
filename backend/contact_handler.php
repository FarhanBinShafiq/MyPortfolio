<?php
// backend/contact_handler.php
include 'database.php';
header("Content-Type: application/json");

$action = $_GET['action'] ?? '';

if ($action === 'send_message') {
    $d = json_decode(file_get_contents("php://input"), true);
    if($d['name'] && $d['email']) {
        $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)")->execute([$d['name'], $d['email'], $d['message']]);
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Missing fields"]);
    }
    exit();
}

if ($action === 'fetch_messages') {
    $msgs = $pdo->query("SELECT * FROM messages ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($msgs);
    exit();
}

if ($action === 'delete_message') {
    $pdo->prepare("DELETE FROM messages WHERE id=?")->execute([$_GET['id']]);
    echo json_encode(["status" => "success"]);
    exit();
}
?>