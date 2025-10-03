<?php
    // image_proxy.php

    // ตรวจสอบว่ามีพารามิเตอร์ url ส่งมาหรือไม่
    if (!isset($_GET['url'])) {
        http_response_code(400);
        die('Error: Image URL is required.');
    }

    $imageUrl = $_GET['url'];

    // --- SECURITY WARNING ---
    // การใช้ URL จาก query string โดยตรงอาจเป็นความเสี่ยงด้านความปลอดภัย
    // แนะนำให้ตรวจสอบ URL เพื่อให้แน่ใจว่ามาจากเซิร์ฟเวอร์ที่คุณเชื่อถือเท่านั้น
    // ตัวอย่าง: อนุญาตเฉพาะรูปภาพจาก 'your-image-server.com'
    /*
    if (!preg_match('/^http:\/\/your-image-server\.com\/.+/', $imageUrl)) {
        http_response_code(403);
        die('Error: Access to this resource is forbidden.');
    }
    */

    // ใช้ cURL เพื่อดึงข้อมูลรูปภาพ (แนะนำมากกว่า file_get_contents)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $imageUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // Timeout 10 วินาที
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // ติดตาม Redirects
    $imageData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    curl_close($ch);

    // ตรวจสอบว่าดึงข้อมูลสำเร็จหรือไม่
    if ($httpCode == 200 && $imageData) {
        // ส่ง header Content-Type ที่ถูกต้องของรูปภาพ
        header('Content-Type: ' . $contentType);
        // แสดงผลข้อมูลรูปภาพ
        echo $imageData;
    } else {
        // หากไม่สำเร็จ ให้ส่งสถานะผิดพลาดกลับไป
        http_response_code($httpCode > 0 ? $httpCode : 500);
        die('Error: Could not fetch the image. Status: ' . $httpCode);
    }
    ?>