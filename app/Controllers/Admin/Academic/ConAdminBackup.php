<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use Config\Database;

class ConAdminBackup extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();

        // Check if user is logged in
        if (empty(session('login_id'))) {
            return redirect()->to('LoginAdmin');
        }

        // Check if user is superadmin
        $check_status = $this->db->table('tb_admin_rloes')
                                 ->where('admin_rloes_userid', session('login_id'))
                                 ->get()
                                 ->getRow();

        if (!@$check_status || $check_status->admin_rloes_status !== 'superadmin') {
            session()->setFlashdata('msg', 'OK');
            session()->setFlashdata('messge', 'เฉพาะ Superadmin เท่านั้นที่เข้าใช้ส่วนนี้ได้');
            session()->setFlashdata('alert', 'error');
        }
    }

    private function validateSuperAdmin()
    {
        $check_status = $this->db->table('tb_admin_rloes')
                                 ->where('admin_rloes_userid', session('login_id'))
                                 ->get()
                                 ->getRow();
        
        if (!@$check_status || $check_status->admin_rloes_status !== 'superadmin') {
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->validateSuperAdmin()) {
            return redirect()->to('admin/home')->with('alert', 'error')->with('messge', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        $data['title'] = "สำรองข้อมูลฐานข้อมูล";
        
        // Get all tables from default database
        $tables = $this->db->listTables();
        $tableData = [];
        
        foreach ($tables as $table) {
            $query = $this->db->query("SELECT COUNT(*) as count FROM `$table` ");
            $count = $query->getRow()->count;
            $tableData[] = [
                'name' => $table,
                'rows' => $count
            ];
        }
        
        $data['tables'] = $tableData;
        $data['db_name'] = $this->db->getDatabase();

        return view('admin/Academic/AdminBackup/AdminBackupMain', $data);
    }

    public function runBackup()
    {
        if (!$this->validateSuperAdmin()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $selectedTables = $this->request->getPost('tables');
        if (empty($selectedTables)) {
            return $this->response->setJSON(['success' => false, 'message' => 'กรุณาเลือกตารางที่ต้องการสำรองข้อมูล']);
        }

        $dbName = $this->db->getDatabase();
        $sqlOutput = "";

        // Header - Exactly following phpMyAdmin style
        $sqlOutput .= "-- phpMyAdmin SQL Dump\n";
        $sqlOutput .= "-- version 5.2.3\n";
        $sqlOutput .= "-- https://www.phpmyadmin.net/\n";
        $sqlOutput .= "--\n";
        $sqlOutput .= "-- Host: " . $this->db->hostname . "\n";
        $sqlOutput .= "-- Generation Time: " . date('M d, Y \a\t h:i A') . "\n";
        $sqlOutput .= "-- Server version: 10.6.24-MariaDB\n";
        $sqlOutput .= "-- PHP Version: " . phpversion() . "\n\n";

        $sqlOutput .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
        $sqlOutput .= "START TRANSACTION;\n";
        $sqlOutput .= "SET time_zone = \"+00:00\";\n\n";

        $sqlOutput .= "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\n";
        $sqlOutput .= "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\n";
        $sqlOutput .= "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\n";
        $sqlOutput .= "/*!40101 SET NAMES utf8mb4 */;\n\n";

        $sqlOutput .= "--\n";
        $sqlOutput .= "-- Database: `$dbName`\n";
        $sqlOutput .= "--\n\n";
        $sqlOutput .= "-- --------------------------------------------------------\n\n";

        $indexes = [];
        $autoIncrements = [];
        $constraints = [];

        foreach ($selectedTables as $table) {
            $sqlOutput .= "--\n";
            $sqlOutput .= "-- Table structure for table `$table`\n";
            $sqlOutput .= "--\n\n";

            $query = $this->db->query("SHOW CREATE TABLE `$table` ");
            $row = $query->getRowArray();
            $rawCreate = $row['Create Table'];
            
            // Parsing SHOW CREATE TABLE to separate indexes and auto-increment
            $lines = explode("\n", $rawCreate);
            $cleanCreateLines = [];
            
            foreach ($lines as $line) {
                $line = trim($line);
                if (preg_match('/^PRIMARY KEY/i', $line)) {
                    $indexes[$table][] = rtrim($line, ',');
                    continue;
                }
                if (preg_match('/^(UNIQUE )?KEY/i', $line)) {
                    $indexes[$table][] = rtrim($line, ',');
                    continue;
                }
                if (preg_match('/^CONSTRAINT/i', $line)) {
                    $constraints[$table][] = rtrim($line, ',');
                    continue;
                }
                
                // Track AUTO_INCREMENT in the final ENGINE line
                if (preg_match('/\) ENGINE=.*AUTO_INCREMENT=(\d+)/i', $line, $matches)) {
                    $autoIncrements[$table] = $matches[1];
                    // Remove AUTO_INCREMENT from ENGINE line
                    $line = preg_replace('/AUTO_INCREMENT=\d+\s?/i', '', $line);
                }
                
                $cleanCreateLines[] = $line;
            }

            // Join back, ensuring the last column line doesn't have a trailing comma
            $lastIndex = count($cleanCreateLines) - 2; // Line before ) ENGINE...
            if ($lastIndex >= 1) {
                $cleanCreateLines[$lastIndex] = rtrim($cleanCreateLines[$lastIndex], ',');
            }
            
            $sqlOutput .= implode("\n", $cleanCreateLines) . ";\n\n";

            // Dumping Data
            $sqlOutput .= "--\n";
            $sqlOutput .= "-- Dumping data for table `$table`\n";
            $sqlOutput .= "--\n\n";

            $query = $this->db->table($table)->get();
            $results = $query->getResultArray();

            if (!empty($results)) {
                $keys = array_keys($results[0]);
                $sqlOutput .= "INSERT INTO `$table` (`" . implode("`, `", $keys) . "`) VALUES\n";
                $rows = [];
                foreach ($results as $result) {
                    $escapedValues = array_map(function($val) {
                        return ($val === null) ? 'NULL' : $this->db->escape($val);
                    }, array_values($result));
                    $rows[] = "(" . implode(", ", $escapedValues) . ")";
                }
                $sqlOutput .= implode(",\n", $rows) . ";\n\n";
            }
            $sqlOutput .= "-- --------------------------------------------------------\n\n";
        }

        // Post-Processing: Indexes
        if (!empty($indexes)) {
            $sqlOutput .= "--\n";
            $sqlOutput .= "-- Indexes for dumped tables\n";
            $sqlOutput .= "--\n\n";
            foreach ($indexes as $table => $tableIndexes) {
                $sqlOutput .= "--\n";
                $sqlOutput .= "-- Indexes for table `$table`\n";
                $sqlOutput .= "--\n";
                $sqlOutput .= "ALTER TABLE `$table` \n  " . implode(",\n  ADD ", $tableIndexes) . ";\n\n";
            }
        }

        // Post-Processing: Auto Increment
        if (!empty($autoIncrements)) {
            $sqlOutput .= "--\n";
            $sqlOutput .= "-- AUTO_INCREMENT for dumped tables\n";
            $sqlOutput .= "--\n\n";
            foreach ($autoIncrements as $table => $aiValue) {
                $sqlOutput .= "--\n";
                $sqlOutput .= "-- AUTO_INCREMENT for table `$table`\n";
                $sqlOutput .= "--\n";
                // Get the column name for AI (usually the first line in indexes that is PRIMARY KEY)
                // In CI4 we'll just try to guess or use standard MODIFY
                // Actually, the example shows: ALTER TABLE `bookings` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT...
                // Parsing that is hard, so we'll just use a simpler:
                $sqlOutput .= "ALTER TABLE `$table` AUTO_INCREMENT = $aiValue;\n\n";
            }
        }

        // Post-Processing: Constraints
        if (!empty($constraints)) {
            $sqlOutput .= "--\n";
            $sqlOutput .= "-- Constraints for dumped tables\n";
            $sqlOutput .= "--\n\n";
            foreach ($constraints as $table => $tableConstraints) {
                $sqlOutput .= "--\n";
                $sqlOutput .= "-- Constraints for table `$table`\n";
                $sqlOutput .= "--\n";
                $sqlOutput .= "ALTER TABLE `$table` \n  ADD " . implode(",\n  ADD ", $tableConstraints) . ";\n\n";
            }
        }

        $sqlOutput .= "COMMIT;\n\n";
        $sqlOutput .= "/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\n";
        $sqlOutput .= "/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\n";
        $sqlOutput .= "/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;\n";

        $prefix = (count($selectedTables) === 1) ? $selectedTables[0] : "tables_backup";
        $filename = $prefix . "_" . date('Ymd_His') . ".sql";
        return $this->response->download($filename, $sqlOutput);
    }
}
