<?php
// Simple CLI bootstrap for CI4 to query unique study lines
define('FCPATH', __DIR__ . '/../../../public/');
require __DIR__ . '/../../../app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$db = \Config\Database::connect();
$query = $db->query("SELECT DISTINCT StudentStudyLine FROM tb_students WHERE StudentStudyLine IS NOT NULL AND StudentStudyLine != '' LIMIT 50");
$results = $query->getResultArray();

echo "UNIQUE StudentStudyLine in academic db:\n";
foreach ($results as $row) {
    echo "- " . $row['StudentStudyLine'] . "\n";
}

$dbAdmission = \Config\Database::connect('admission'); // Let's check if admission group exists, otherwise connect to default and show tables
$tables = $db->listTables();
echo "\nAvailable Tables in default db:\n";
print_r($tables);
