<?php
include 'database.php';
header("Content-Type: application/json");
ini_set('display_errors', 0); error_reporting(E_ALL);

$action = $_GET['action'] ?? '';

try {
    // --- EDUCATION ---
    if ($action === 'fetch_edu') {
        echo json_encode($pdo->query("SELECT * FROM education ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC));
        exit();
    }
    if ($action === 'add_edu') {
        $d = json_decode(file_get_contents("php://input"), true);
        $pdo->prepare("INSERT INTO education (institution, degree, year, details) VALUES (?, ?, ?, ?)")
            ->execute([$d['institution'], $d['degree'], $d['year'], $d['details']]);
        echo json_encode(["status" => "success"]);
        exit();
    }
    if ($action === 'delete_edu') {
        $pdo->prepare("DELETE FROM education WHERE id=?")->execute([$_GET['id']]);
        echo json_encode(["status" => "success"]);
        exit();
    }

    // --- EXPERIENCE ---
    if ($action === 'fetch_exp') {
        echo json_encode($pdo->query("SELECT * FROM experience ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC));
        exit();
    }
    if ($action === 'add_exp') {
        $d = json_decode(file_get_contents("php://input"), true);
        $pdo->prepare("INSERT INTO experience (role, company, year, details) VALUES (?, ?, ?, ?)")
            ->execute([$d['role'], $d['company'], $d['year'], $d['details']]);
        echo json_encode(["status" => "success"]);
        exit();
    }
    if ($action === 'delete_exp') {
        $pdo->prepare("DELETE FROM experience WHERE id=?")->execute([$_GET['id']]);
        echo json_encode(["status" => "success"]);
        exit();
    }

} catch (Exception $e) { echo json_encode(["status" => "error", "message" => $e->getMessage()]); }
?>