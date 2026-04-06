<?php
require 'vendor/autoload.php';
$app = require 'app/Config/Paths.php';
$config = new \Config\Database();
$db = \Config\Database::connect();
$query = $db->query("SELECT StudentClass FROM tb_students WHERE StudentStatus = '1/ปกติ' LIMIT 5");
$rows = $query->getResult();
echo "StudentClass samples:\n";
foreach ($rows as $row) {
    echo "- " . $row->StudentClass . "\n";
}
