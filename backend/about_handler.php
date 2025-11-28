<?php
// backend/about_handler.php
include 'database.php';
header("Content-Type: application/json");

// Mute warnings to prevent JSON errors
ini_set('display_errors', 0); 
error_reporting(E_ALL);

$action = $_GET['action'] ?? '';

try {
    // FETCH
    if ($action === 'fetch_about') {
        $profile = $pdo->query("SELECT * FROM profile WHERE id=1")->fetch(PDO::FETCH_ASSOC);
        $services = $pdo->query("SELECT * FROM services")->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["profile" => $profile, "services" => $services]);
        exit();
    }

    // UPDATE PROFILE
    if ($action === 'update_profile' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $image_url = $_POST['existing_image'] ?? '';

        // Image Upload Logic
        if (!empty($_FILES['profile_image']['name'])) {
            $target_dir = __DIR__ . "/../images/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            
            $filename = "profile_" . time() . ".jpg";
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_dir . $filename)) {
                // Relative path for the browser to find the image
                $image_url = "../images/" . $filename;
            }
        }

        $sql = "UPDATE profile SET intro_title=?, intro_body=?, bio_text=?, residence=?, experience=?, email=?, image_url=? WHERE id=1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['intro_title'], $_POST['intro_body'], $_POST['bio_text'], $_POST['residence'], $_POST['experience'], $_POST['email'], $image_url]);
        
        echo json_encode(["status" => "success"]);
        exit();
    }

    // ADD SERVICE
    if ($action === 'add_service') {
        $d = json_decode(file_get_contents("php://input"), true);
        $pdo->prepare("INSERT INTO services (title, icon) VALUES (?, ?)")->execute([$d['title'], $d['icon']]);
        echo json_encode(["status" => "success"]);
        exit();
    }

    // DELETE SERVICE
    if ($action === 'delete_service') {
        $pdo->prepare("DELETE FROM services WHERE id=?")->execute([$_GET['id']]);
        echo json_encode(["status" => "success"]);
        exit();
    }

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>