<?php
// 1. ตั้งค่า CORS Headers
header("Access-Control-Allow-Origin: *"); // หรือระบุโดเมนของคุณเพื่อความปลอดภัย
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// 2. จัดการกับ Preflight Request (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json');

$response = [];

try {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (isset($data['files']) && is_array($data['files']) && isset($data['path'])) {
        // ***IMPORTANT***: Set your base upload directory (must match upload.php)
        $baseDir = '/var/www/html/uploads/';
        $subDir = trim($data['path'], '/');
        $targetDir = $baseDir . $subDir;

        $deletedFiles = [];
        $failedFiles = [];

        foreach ($data['files'] as $filename) {
            // Security check to prevent directory traversal
            if (strpos($filename, '..') !== false || strpos($filename, '/') !== false) {
                $failedFiles[] = $filename;
                continue;
            }

            $filePath = $targetDir . '/' . $filename;

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    $deletedFiles[] = $filename;
                } else {
                    $failedFiles[] = $filename;
                }
            }
        }

        $response = [
            'status' => 'success',
            'deleted' => $deletedFiles,
            'failed' => $failedFiles
        ];
        http_response_code(200);

    } else {
        throw new Exception('Invalid request data.');
    }

} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
    http_response_code(400);
}

echo json_encode($response);
