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
}
