<?php

namespace App\Controllers\Api\V1;

use App\Models\Api\StudentModel;

class StudentApi extends BaseApiController
{
    protected $studentModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
    }

    /**
     * Search students or get by class
     * GET /api/v1/students
     */
    public function index()
    {
        if (!$this->validateApiKey()) {
            return $this->error('Unauthorized: Invalid API Key', 401);
        }

        $class = $this->request->getGet('class');
        $search = $this->request->getGet('q');
        $limit  = $this->request->getGet('limit') ?: 50;
        $offset = $this->request->getGet('offset') ?: 0;

        if ($search) {
            $data = $this->studentModel->searchStudents($search, (int)$limit);
        } elseif ($class) {
            $data = $this->studentModel->getStudentsByClass($class, (int)$limit, (int)$offset);
        } else {
            return $this->error('Please provide a class or search query (q)');
        }

        return $this->success($data, 'Student data retrieved successfully');
    }

    /**
     * Get student statistics by level and gender
     * GET /api/v1/students/stats
     */
    public function stats()
    {
        if (!$this->validateApiKey()) {
            return $this->error('Unauthorized: Invalid API Key', 401);
        }

        $data = $this->studentModel->getStudentStats();

        return $this->success($data, 'Student statistics retrieved successfully');
    }

    /**
     * Get graduation statistics by year and gender with percentages
     * GET /api/v1/students/graduation-stats
     */
    public function graduationStats()
    {
        if (!$this->validateApiKey()) {
            return $this->error('Unauthorized: Invalid API Key', 401);
        }

        $raw_data = $this->studentModel->getGraduationStats();
        
        $processed_data = array_map(function($item) {
            $total = (int)$item->total_count;
            $male = (int)$item->male_count;
            $female = (int)$item->female_count;

            return [
                'year' => $item->year,
                'male_count' => $male,
                'male_percent' => $total > 0 ? round(($male / $total) * 100, 2) : 0,
                'female_count' => $female,
                'female_percent' => $total > 0 ? round(($female / $total) * 100, 2) : 0,
                'total_count' => $total
            ];
        }, $raw_data);

        return $this->success($processed_data, 'Graduation statistics retrieved successfully');
    }

    /**
     * Get single student detail
     * GET /api/v1/students/(:any)
     */
    public function show($id = null)
    {
        if (!$this->validateApiKey()) {
            return $this->error('Unauthorized: Invalid API Key', 401);
        }

        $data = $this->studentModel->getStudentById($id);

        if (!$data) {
            return $this->error('Student not found', 404);
        }

        return $this->success($data, 'Student detail retrieved successfully');
    }

    /**
     * Get graduation destinations (education / career path statistics)
     * GET /api/v1/students/graduation-destinations
     */
    public function graduationDestinations()
    {
        if (!$this->validateApiKey()) {
            return $this->error('Unauthorized: Invalid API Key', 401);
        }

        $db = \Config\Database::connect('default');
        $DBpersonnel = \Config\Database::connect('personnel');

        $year = $this->request->getGet('year');

        // If no year specified, let's return a list of all years with summary stats for each year!
        if (empty($year)) {
            // Get all unique years of graduates
            $yearsList = $db->table('tb_students')
                ->select('YearFinish')
                ->where('YearFinish !=', '')
                ->where('YearFinish IS NOT NULL')
                ->groupBy('YearFinish')
                ->orderBy('YearFinish', 'DESC')
                ->get()->getResult();

            $summaryData = [];
            foreach ($yearsList as $y) {
                $keyYear = $y->YearFinish;
                
                // Query students who graduated in this year
                $students = $db->table('tb_students')
                    ->select('StudentIDNumber')
                    ->where('YearFinish', $keyYear)
                    ->get()->getResult();
                
                $studentIds = array_column($students, 'StudentIDNumber');
                $cleanedStudentIds = array_map(function($id) {
                    return str_replace('-', '', $id);
                }, $studentIds);

                $studyingCount = 0;
                $workingCount = 0;
                $otherCount = 0;

                if (!empty($cleanedStudentIds)) {
                    $personnelDataRaw = $DBpersonnel->table('tb_students')
                        ->select("stu_future_education, stu_career_interest")
                        ->whereIn("REPLACE(stu_iden, '-', '')", $cleanedStudentIds)
                        ->get()->getResult();
                    
                    foreach ($personnelDataRaw as $p) {
                        $edu = trim($p->stu_future_education);
                        $career = trim($p->stu_career_interest);
                        if (!empty($edu) && $edu !== '-') {
                            $studyingCount++;
                        } elseif (!empty($career) && $career !== '-') {
                            $workingCount++;
                        } else {
                            $otherCount++;
                        }
                    }
                }

                // Add students who had no records in personnel as 'other'
                $total = count($students);
                $foundRecordsCount = $studyingCount + $workingCount + $otherCount;
                if ($total > $foundRecordsCount) {
                    $otherCount += ($total - $foundRecordsCount);
                }

                $summaryData[] = [
                    'year_finish' => $keyYear,
                    'total_graduates' => $total,
                    'studying' => $studyingCount,
                    'working' => $workingCount,
                    'other' => $otherCount,
                    'studying_percent' => $total > 0 ? round(($studyingCount / $total) * 100, 1) : 0,
                    'working_percent' => $total > 0 ? round(($workingCount / $total) * 100, 1) : 0,
                    'other_percent' => $total > 0 ? round(($otherCount / $total) * 100, 1) : 0,
                ];
            }

            return $this->success($summaryData, 'Graduation destinations summary retrieved successfully');
        }

        // If a specific year is requested, return the detailed statistics of that year!
        $students = $db->table('tb_students')
            ->select('StudentID, StudentCode, StudentPrefix, StudentFirstName, StudentLastName, StudentClass, StudentIDNumber, YearFinish')
            ->where('YearFinish', $year)
            ->orderBy('StudentClass', 'ASC')
            ->orderBy('StudentNumber', 'ASC')
            ->get()->getResult();

        $studentIds = array_column($students, 'StudentIDNumber');
        $cleanedStudentIds = array_map(function($id) {
            return str_replace('-', '', $id);
        }, $studentIds);

        $personnelData = [];
        if (!empty($cleanedStudentIds)) {
            $personnelDataRaw = $DBpersonnel->table('tb_students')
                ->select("REPLACE(stu_iden, '-', '') as clean_iden, stu_future_education, stu_career_interest")
                ->whereIn("REPLACE(stu_iden, '-', '')", $cleanedStudentIds)
                ->get()->getResult();
            
            foreach ($personnelDataRaw as $p) {
                $personnelData[$p->clean_iden] = [
                    'future_education' => $p->stu_future_education,
                    'career_interest' => $p->stu_career_interest
                ];
            }
        }

        $data = [];
        $studyingCount = 0;
        $workingCount = 0;
        $otherCount = 0;

        foreach ($students as $index => $s) {
            $idenCleaned = str_replace('-', '', $s->StudentIDNumber);
            $edu = isset($personnelData[$idenCleaned]) ? $personnelData[$idenCleaned]['future_education'] : '';
            $career = isset($personnelData[$idenCleaned]) ? $personnelData[$idenCleaned]['career_interest'] : '';

            $edu = trim($edu);
            $career = trim($career);

            $status = 'ยังไม่ระบุ';
            if (!empty($edu) && $edu !== '-') {
                $status = 'ศึกษาต่อ';
                $studyingCount++;
            } elseif (!empty($career) && $career !== '-') {
                $status = 'ทำงาน';
                $workingCount++;
            } else {
                $otherCount++;
            }

            $data[] = [
                'index' => $index + 1,
                'student_code' => $s->StudentCode,
                'fullname' => $s->StudentPrefix . $s->StudentFirstName . ' ' . $s->StudentLastName,
                'class' => $s->StudentClass,
                'status' => $status,
                'future_education' => (!empty($edu) && $edu !== '-') ? $edu : '-',
                'career_interest' => (!empty($career) && $career !== '-') ? $career : '-',
                'destination' => $status === 'ศึกษาต่อ' ? $edu : ($status === 'ทำงาน' ? $career : '-'),
                'year_finish' => $s->YearFinish
            ];
        }

        $total = count($students);

        $responsePayload = [
            'year' => $year,
            'summary' => [
                'total' => $total,
                'studying' => $studyingCount,
                'working' => $workingCount,
                'other' => $otherCount,
                'studying_percent' => $total > 0 ? round(($studyingCount / $total) * 100, 1) : 0,
                'working_percent' => $total > 0 ? round(($workingCount / $total) * 100, 1) : 0,
                'other_percent' => $total > 0 ? round(($otherCount / $total) * 100, 1) : 0,
            ],
            'students' => $data
        ];

        return $this->success($responsePayload, "Graduation destinations detail for year {$year} retrieved successfully");
    }
}
