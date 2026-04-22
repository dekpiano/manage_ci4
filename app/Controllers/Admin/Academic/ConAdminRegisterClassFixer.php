<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;

class ConAdminRegisterClassFixer extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        
        // Simple security check
        if (empty(session()->get('fullname'))) {
            header('Location: ' . base_url('LogoutTeacher'));
            exit();
        }
    }

    public function index()
    {
        $data['title'] = "Auditing RegisterClass (Room Selection)";
        
        // 1. Get list of academic years for filter
        $data['years'] = $this->db->table('tb_register')
                                  ->select('RegisterYear')
                                  ->groupBy('RegisterYear')
                                  ->orderBy('SUBSTRING_INDEX(RegisterYear, "/", -1) DESC, SUBSTRING_INDEX(RegisterYear, "/", 1) DESC', '', false)
                                  ->get()->getResult();

        // 2. Get all distinct rooms from the latest registration years (fixed rooms with /)
        $data['rooms'] = $this->db->table('tb_register')
                                  ->select('RegisterClass')
                                  ->where("RegisterClass LIKE '%/%'")
                                  ->groupBy('RegisterClass')
                                  ->orderBy('RegisterClass', 'ASC')
                                  ->get()->getResult();

        return view('admin/Academic/AdminRegisterClassFixer/Main', $data);
    }

    public function getAuditData()
    {
        $year = $this->request->getGet('year');
        $room = $this->request->getGet('room');
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        if (empty($year) || empty($room)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Missing year or room']);
        }

        // Extract level (e.g. "ม.1") from room (e.g. "ม.1/2")
        $level = explode('/', $room)[0];

        // 1. Show a selection of years for context
        $years_list_query = $this->db->query("
            SELECT DISTINCT RegisterYear
            FROM tb_register
            WHERE (RegisterYear LIKE '1/%' OR RegisterYear LIKE '2/%')
            ORDER BY SUBSTRING_INDEX(RegisterYear, '/', -1) DESC, SUBSTRING_INDEX(RegisterYear, '/', 1) DESC
            LIMIT 10
        ");
        $years = array_column($years_list_query->getResult(), 'RegisterYear');

        // 2. Find students who have any record in this year/room OR year/level
        $count_query = $this->db->query("
            SELECT COUNT(DISTINCT r.StudentID) as total
            FROM tb_register r
            WHERE r.RegisterYear = ? AND (r.RegisterClass = ? OR r.RegisterClass = ?)
        ", [$year, $room, $level]);
        $total_students = $count_query->getRow()->total;
        $total_pages = ceil($total_students / $limit);

        $students_query = $this->db->query("
            SELECT DISTINCT r.StudentID, s.StudentPrefix, s.StudentFirstName, s.StudentLastName, s.StudentCode
            FROM tb_register r
            JOIN tb_students s ON r.StudentID = s.StudentID
            WHERE r.RegisterYear = ? AND (r.RegisterClass = ? OR r.RegisterClass = ?)
            ORDER BY s.StudentCode ASC
            LIMIT ? OFFSET ?
        ", [$year, $room, $level, (int)$limit, (int)$offset]);
        $students = $students_query->getResult();

        $auditData = [];
        foreach ($students as $student) {
            $student_records = [];
            
            foreach ($years as $yr) {
                $record_query = $this->db->query("
                    SELECT DISTINCT RegisterClass
                    FROM tb_register
                    WHERE StudentID = ? AND RegisterYear = ?
                ", [$student->StudentID, $yr]);
                $record = $record_query->getRow();

                if ($record) {
                    $current_room = $record->RegisterClass;
                    $is_raw = (strpos($current_room, '/') === false);
                    
                    // Historical Analysis
                    $history_query = $this->db->query("
                        SELECT DISTINCT RegisterClass FROM (
                            SELECT RegisterClass, RegisterYear FROM tb_register WHERE StudentID = ?
                            UNION
                            SELECT RegisterClass, RegisterYear FROM tb_registeractivity WHERE StudentID = ?
                        ) as h WHERE RegisterClass LIKE ? AND RegisterClass LIKE '%/%'
                    ", [$student->StudentID, $student->StudentID, $level . '%']);
                    $history = array_column($history_query->getResult(), 'RegisterClass');
                    
                    if (empty($history)) {
                         $global_h = $this->db->query("
                            SELECT RegisterClass FROM (
                                SELECT RegisterClass, RegisterYear FROM tb_register WHERE StudentID = ?
                                UNION
                                SELECT RegisterClass, RegisterYear FROM tb_registeractivity WHERE StudentID = ?
                            ) as h WHERE RegisterClass LIKE '%/%'
                            ORDER BY SUBSTRING_INDEX(RegisterYear, '/', -1) DESC, SUBSTRING_INDEX(RegisterYear, '/', 1) DESC LIMIT 1
                         ", [$student->StudentID, $student->StudentID])->getRow();
                         if ($global_h) $history[] = $global_h->RegisterClass;
                    }
                    
                    $best_guess = $history[0] ?? $room;
                    $default_rooms = [];
                    for ($i = 1; $i <= 6; $i++) { $default_rooms[] = $level . '/' . $i; }
                    $options = array_values(array_unique(array_merge($history, $default_rooms, [$room])));
                    sort($options, SORT_NATURAL);

                    $student_records[$yr] = [
                        'Room' => $current_room,
                        'IsRaw' => $is_raw,
                        'BestGuess' => $best_guess,
                        'Options' => $options
                    ];
                } else {
                    $student_records[$yr] = null;
                }
            }

            $auditData[] = [
                'StudentID' => $student->StudentID,
                'StudentCode' => $student->StudentCode,
                'FullName' => $student->StudentPrefix . $student->StudentFirstName . ' ' . $student->StudentLastName,
                'History' => $student_records
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'years' => $years,
            'students' => $auditData,
            'current_page' => $page,
            'total_pages' => $total_pages,
            'total_students' => $total_students
        ]);
    }

    public function processFix()
    {
        $studentID = $this->request->getPost('student_id');
        $year = $this->request->getPost('year');
        $newRoom = $this->request->getPost('new_room');

        if (empty($studentID) || empty($year) || empty($newRoom)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Missing data']);
        }

        $this->db->table('tb_register')
                 ->where('StudentID', $studentID)
                 ->where('RegisterYear', $year)
                 ->update(['RegisterClass' => $newRoom]);

        $affectedRows = $this->db->affectedRows();

        return $this->response->setJSON(['status' => 'success', 'message' => "Updated $affectedRows records to $newRoom"]);
    }
}
