<?php
// backend/about_handler.php
include 'database.php';

// Allow Dashboard to access this
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

$action = isset($_GET['action']) ? $_GET['action'] : '';

// --- 1. GET ALL DATA (For Frontend & Dashboard) ---
if ($action === 'fetch_about') {
    // Get Profile
    $stmt = $pdo->query("SELECT * FROM profile WHERE id = 1");
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get Services
    $stmt = $pdo->query("SELECT * FROM services");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "profile" => $profile,
        "services" => $services
    ]);
    exit();
}

// --- 2. UPDATE PROFILE INFO ---
if ($action === 'update_profile' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $intro_title = $_POST['intro_title']; // The Big Letter
    $intro_body = $_POST['intro_body'];   // "ello, I am..."
    $bio_text = $_POST['bio_text'];
    $residence = $_POST['residence'];
    $experience = $_POST['experience'];
    $email = $_POST['email'];

    // Handle Image Upload
    $image_url = $_POST['existing_image']; // Keep old image by default

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $target_dir = __DIR__ . "/uploads/";
        if (!is_dir($target_dir))
            mkdir($target_dir);

        $filename = time() . "_" . basename($_FILES["profile_image"]["name"]);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            // Full URL to the image
            $image_url = "http://localhost:8000/backend/uploads/" . $filename;
        }
    }

    $sql = "UPDATE profile SET intro_title=?, intro_body=?, bio_text=?, residence=?, experience=?, email=?, image_url=? WHERE id=1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$intro_title, $intro_body, $bio_text, $residence, $experience, $email, $image_url]);

    echo json_encode(["status" => "success", "message" => "Profile updated"]);
    exit();
}

// --- 3. ADD SERVICE CARD ---
if ($action === 'add_service' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO services (title, icon) VALUES (?, ?)");
    $stmt->execute([$data['title'], $data['icon']]);
    echo json_encode(["status" => "success"]);
    exit();
}

// --- 4. DELETE SERVICE CARD ---
if ($action === 'delete_service') {
    $id = $_GET['id'];
    $pdo->prepare("DELETE FROM services WHERE id=?")->execute([$id]);
    echo json_encode(["status" => "deleted"]);
    exit();
}
?>