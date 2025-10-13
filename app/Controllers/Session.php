<?php
namespace App\Controllers;

class Session extends BaseController
{
    public function check()
    {
        if (session()->get('fullname')) {
            return $this->response->setJSON(['status' => 'active']);
        } else {
            return $this->response->setJSON(['status' => 'expired']);
        }
    }
}
