<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class ConAcademicResult extends BaseController
{
    protected $title = "ผลการเรียน";

    public function __construct()
    {
        // CI3 session check equivalent
        if (empty(session()->get('fullname')) || session()->get('status') === 'admin') {
            return redirect()->to(base_url('Login'));
        }
    }


    public function score(){      
        $data['title'] = "ผลการเรียน";
        $data['scoreYear'] = $this->db->table('tb_register')
                                    ->select([
                                        'tb_register.RegisterClass',
                                        'tb_register.RegisterYear',
                                        'tb_register.StudentID'
                                    ])
                                    ->where('StudentID',session()->get('login_id'))
                                    ->groupBy('tb_register.RegisterYear')
                                    ->orderBy('tb_register.RegisterClass asc')
                                    ->orderBy('tb_register.RegisterYear asc')
                                    ->get()->getResult();
         //echo '<pre>';print_r($data['scoreYear']); exit();
        $data['scoreStudent'] = $this->db->table('tb_register')
                                        ->select([
                                            'tb_register.StudentID',
                                            'tb_register.SubjectCode',
                                            'tb_register.Score100',
                                            'tb_register.Grade',
                                            'tb_register.RegisterYear',
                                            'tb_register.RegisterClass',
                                            'tb_subjects.SubjectName',
                                            'tb_subjects.SubjectUnit',
                                            'tb_subjects.SubjectYear',
                                            'tb_subjects.SubjectType',
                                            'tb_subjects.FirstGroup'
                                        ])
                                    ->join('tb_subjects', 'tb_register.SubjectCode = tb_subjects.SubjectCode')
                                    ->where('StudentID',session()->get('login_id'))
                                    ->orderBy('tb_subjects.FirstGroup asc')
                                    ->orderBy('tb_subjects.SubjectCode asc')
                                    ->get()->getResult();
      
    $data['CheckOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
    return view('user/PageAcademicResult', $data);

        // delete_cookie('username_cookie'); 
		// delete_cookie('password_cookie'); 
        // $this->session->sess_destroy();
        
    }
}
