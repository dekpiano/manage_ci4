<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class ConUser_Home extends BaseController
{
    protected $title = "แผงควบคุม";

    public function __construct()
    {
        // CI3 session check equivalent
        if (empty(session()->get('fullname')) || session()->get('status') === 'admin') {
            return redirect()->to(base_url('Login'));
        }
    }


    public function Home(){      
        
        $data['title'] = "หน้าแรก";
        $data['description'] = "หน้าแรก";  
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['banner'] = "";

    $data['CheckOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
    return view('user/PageHome', $data);

        // delete_cookie('username_cookie'); 
		// delete_cookie('password_cookie'); 
        // $this->session->sess_destroy();
        
    }
}
