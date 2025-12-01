<?php
// blog_handler.php (PDO Version - Fixes "undefined method" error)

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Standard headers for API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Set absolute path to database file
$db_file = __DIR__ . '/portfolio.db';

try {
    // --- CONNECT USING PDO ---
    // This is the robust, standard way to connect that avoids the previous error.
    $pdo = new PDO("sqlite:" . $db_file);
    // Set error mode to exception so we can catch problems
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if not exists
    $query = "CREATE TABLE IF NOT EXISTS blogs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        date TEXT,
        category TEXT,
        excerpt TEXT,
        content TEXT,
        external_link TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($query);

    $action = isset($_GET['action']) ? $_GET['action'] : '';

    switch ($action) {
        case 'fetch_all':
            // PDO query and fetchAll is much cleaner
            $stmt = $pdo->query("SELECT * FROM blogs ORDER BY date DESC");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($data);
            break;

        case 'add_blog':
            // Read raw POST data
            $raw_input = file_get_contents("php://input");
            $input = json_decode($raw_input, true);
            
            if ($input === null && json_last_error() !== JSON_ERROR_NONE) {
                 throw new Exception('Invalid JSON input');
            }

            if (!empty($input['title'])) {
                // Use prepared statements with named parameters for security
                $sql = "INSERT INTO blogs (title, date, category, excerpt, content, external_link) VALUES (:title, :date, :category, :excerpt, :content, :external_link)";
                $stmt = $pdo->prepare($sql);
                
                // Use provided date or current date if empty
                $dateVal = !empty($input['date']) ? $input['date'] : date('Y-m-d');
                
                // Execute with data array
                $stmt->execute([
                    ':title' => $input['title'],
                    ':date' => $dateVal,
                    ':category' => isset($input['category']) ? $input['category'] : '',
                    ':excerpt' => isset($input['excerpt']) ? $input['excerpt'] : '',
                    ':content' => isset($input['content']) ? $input['content'] : '',
                    ':external_link' => isset($input['external_link']) ? $input['external_link'] : ''
                ]);
                
                echo json_encode(['status' => 'success', 'message' => 'Blog post added successfully']);
            } else {
                throw new Exception('Title is required');
            }
            break;

        case 'delete_blog':
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $sql = "DELETE FROM blogs WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $id]);
                echo json_encode(['status' => 'success', 'message' => 'Blog post deleted successfully']);
            } else {
                 throw new Exception('No ID provided');
            }
            break;

        default:
            // Just a check to see if the file loads without action
            echo json_encode(['status' => 'ready', 'message' => 'Blog API is ready (PDO)']);
            break;
    }
    
    // PDO connection closes automatically when script ends

} catch (PDOException $e) {
    // Catch database-specific errors and return as JSON
    http_response_code(500);
    // Log the detailed error to the server error log for debugging
    error_log("Database Error: " . $e->getMessage());
    // Send a generic message to the frontend
    echo json_encode(['status' => 'error', 'message' => 'A database error occurred. Check server logs.']);
} catch (Exception $e) {
    // Catch other general errors
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>