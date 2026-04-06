<?php

namespace App\Controllers;

class Welcome extends BaseController
{
    public function index()
    {
        $data['title'] = "หน้าแรก";
        $data['description'] = "หน้าแรก";  
        $data['full_url'] = current_url();
        $data['banner'] = "";

        return view('user/PageWelcomeAcademic', $data);
    }

    public function ClosePage()
    {
        return view('errors/ClosePage.php');
    }
}