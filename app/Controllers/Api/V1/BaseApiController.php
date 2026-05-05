<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class BaseApiController extends BaseController
{
    use ResponseTrait;

    /**
     * Common method to validate API Key
     */
    protected function validateApiKey()
    {
        $apiKey = $this->request->getHeaderLine('X-API-KEY');
        
        // Fallback to query parameter for easier browser testing
        if (empty($apiKey)) {
            $apiKey = $this->request->getGet('key');
        }

        // In production, this should be in .env or database
        $validKey = getenv('API_KEY') ?: 'skj_api_secret_2025'; 

        if (empty($apiKey) || $apiKey !== $validKey) {
            return false;
        }
        return true;
    }

    /**
     * Standard Success Response
     */
    protected function success($data = null, string $message = 'Success')
    {
        return $this->respond([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    /**
     * Standard Error Response
     */
    protected function error(string $message = 'Error', int $code = 400)
    {
        return $this->respond([
            'status' => false,
            'message' => $message
        ], $code);
    }
}
