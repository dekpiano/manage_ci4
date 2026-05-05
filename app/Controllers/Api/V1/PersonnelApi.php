<?php

namespace App\Controllers\Api\V1;

use App\Models\Api\PersonnelModel;

class PersonnelApi extends BaseApiController
{
    protected $personnelModel;

    public function __construct()
    {
        $this->personnelModel = new PersonnelModel();
    }

    /**
     * Get list of personnel
     * GET /api/v1/personnel
     */
    public function index()
    {
        if (!$this->validateApiKey()) {
            return $this->error('Unauthorized: Invalid API Key', 401);
        }

        $limit  = $this->request->getGet('limit') ?: 100;
        $offset = $this->request->getGet('offset') ?: 0;

        $data = $this->personnelModel->getAllPersonnel((int)$limit, (int)$offset);

        return $this->success($data, 'Personnel list retrieved successfully');
    }

    /**
     * Get single personnel detail
     * GET /api/v1/personnel/(:any)
     */
    public function show($id = null)
    {
        if (!$this->validateApiKey()) {
            return $this->error('Unauthorized: Invalid API Key', 401);
        }

        $data = $this->personnelModel->getPersonnelById($id);

        if (!$data) {
            return $this->error('Personnel not found', 404);
        }

        return $this->success($data, 'Personnel detail retrieved successfully');
    }
}
