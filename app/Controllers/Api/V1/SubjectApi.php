<?php

namespace App\Controllers\Api\V1;

use App\Models\Api\SubjectModel;

class SubjectApi extends BaseApiController
{
    protected $subjectModel;

    public function __construct()
    {
        $this->subjectModel = new SubjectModel();
    }

    /**
     * Get subjects by year
     * GET /api/v1/subjects
     */
    public function index()
    {
        if (!$this->validateApiKey()) {
            return $this->error('Unauthorized: Invalid API Key', 401);
        }

        $year = $this->request->getGet('year');
        
        if (!$year) {
            return $this->error('Please provide a year');
        }

        $data = $this->subjectModel->getSubjectsByYear($year);

        return $this->success($data, 'Subject list retrieved successfully');
    }

    /**
     * Get single subject detail
     * GET /api/v1/subjects/(:any)
     */
    public function show($id = null)
    {
        if (!$this->validateApiKey()) {
            return $this->error('Unauthorized: Invalid API Key', 401);
        }

        $data = $this->subjectModel->getSubjectById($id);

        if (!$data) {
            return $this->error('Subject not found', 404);
        }

        return $this->success($data, 'Subject detail retrieved successfully');
    }
}
