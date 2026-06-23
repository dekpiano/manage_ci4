<?php
// Your CodeIgniter App's Domain. Replace '*' with this for better security.
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Auth-Token");

// --- IMPORTANT SECURITY CONFIGURATION ---
// You MUST set the same secret token that you defined in your CodeIgniter .env file.
$SECRET_TOKEN = 'Dekpiano2025!!'; // <-- PASTE THE TOKEN FROM YOUR .env FILE

// Base directory for all uploads. MUST end with a slash.
// Make sure this path is correct and writable on your server.
$BASE_UPLOAD_DIR = '/data/html/uploads/'; // <-- IMPORTANT: This is the absolute path on your remote server.

// --- END OF CONFIGURATION ---

// Handle Preflight Request (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Function to return a JSON error
function return_error($message, $http_code = 500) {
    http_response_code($http_code);
    echo json_encode(["status" => "error", "message" => $message]);
    exit();
}

// 1. Authenticate the request
$headers = getallheaders();
$token = '';
if (isset($headers['X-Auth-Token'])) {
    $token = $headers['X-Auth-Token'];
} elseif (isset($_SERVER['HTTP_X_AUTH_TOKEN'])) {
    $token = $_SERVER['HTTP_X_AUTH_TOKEN'];
}

if (empty($token) || !hash_equals($SECRET_TOKEN, $token)) {
    return_error("Authentication failed.", 403);
}

// 2. Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Check Content-Type to handle JSON body
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    
    $path = '';
    $files = [];

    if (strpos($contentType, 'application/json') !== false) {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        
        if (isset($decoded['path'])) {
            $path = $decoded['path'];
        }
        if (isset($decoded['files']) && is_array($decoded['files'])) {
            $files = $decoded['files'];
        }
    } else {
        if (isset($_POST['path'])) {
            $path = $_POST['path'];
        }
        if (isset($_POST['files']) && is_array($_POST['files'])) {
            $files = $_POST['files'];
        }
    }

    if (empty($path) || empty($files)) {
        return_error("Required parameters are missing (files or path).", 400);
    }

    // 3. Validate target directory
    $sub_path = trim($path, " /\\"); // Clean the path
    
    $current_base_dir = $BASE_UPLOAD_DIR; // Default base directory

    // Check if the path is for the 'admission' system
    if (substr($sub_path, 0, 10) === 'admission/') {
        // If it is, change the base directory to the root uploads folder
        $current_base_dir = '/data/html/uploads/';
    }

    // Security check: ensure path does not contain '..' and is not empty.
    if (strpos($sub_path, '..') !== false || $sub_path === '') {
        return_error("Invalid path specified.", 400);
    }
    
    // Use the determined base directory
    $target_dir = rtrim($current_base_dir, '/') . '/' . $sub_path;

    if (!file_exists($target_dir) || !is_dir($target_dir)) {
        return_error("Directory does not exist.", 404);
    }

    $deleted_files = [];
    $failed_files = [];

    foreach ($files as $file) {
        $filename = basename($file); // Security: extract only the file name
        if (empty($filename) || $filename === '.' || $filename === '..') {
            continue;
        }

        $filepath = $target_dir . '/' . $filename;

        if (file_exists($filepath) && is_file($filepath)) {
            if (unlink($filepath)) {
                $deleted_files[] = $filename;
            } else {
                $failed_files[] = $filename;
            }
        } else {
             // File might already be deleted or not found
             $failed_files[] = $filename . " (not found)";
        }
    }

    http_response_code(200);
    echo json_encode([
        "status" => "success", 
        "message" => "Delete operation completed",
        "deleted" => $deleted_files,
        "failed" => $failed_files
    ]);
    exit();
}

// Handle other request methods
return_error("Method Not Allowed. Use POST.", 405);
