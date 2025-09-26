<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;
use App\Models\Teacher\ModTeacherTeaching;

class ConAdminRoomOnline extends BaseController
{
    protected $modTeacherTeaching;
    protected $DBpersonnel;

    public function __construct()
    {
        $this->modTeacherTeaching = new ModTeacherTeaching();
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect(); // Initialize the default database connection

        helper(['url', 'form']);

        // CI3 session check equivalent
        if (empty(session()->get('fullname'))) {
            return redirect()->to(base_url('LoginAdmin'));
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    public function RoomOnlineMain(){      
        $data['title']  = "หน้าหลักห้องเรียนออนไลน์";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['teacher'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
        $data['RoomOnline'] =$this->db->table('tb_room_online')->get()->getResult();
        $data['NameTeacher'] = $this->DBpersonnel->table('tb_personnel')
        ->select('pers_id,pers_prefix,pers_firstname,pers_lastname,pers_position,pers_learning')
        ->where('pers_position !=','posi_001')
        ->where('pers_position !=','posi_002')
        ->where('pers_position !=','posi_007')
        ->where('pers_position !=','posi_008')
        ->where('pers_position !=','posi_009')
        ->where('pers_position !=','posi_010')        
        ->orderBy('pers_learning')
        ->get()->getResult();
        echo view('admin/layout/main', $data);
        echo view('admin/Academic/AdminRoomOnline/AdminRoomOnlineMain.php');     
    }

    function AddRoomOnline(){ 

        $roomonClasslevel = $this->request->getPost('roomon_classlevel');
        $array = array('roomon_coursecode'=> $this->request->getPost('roomon_coursecode'),           
            'roomon_classlevel'=> !empty($roomonClasslevel) ? implode("|",$roomonClasslevel) : '',    
            'roomon_teachid'=> $this->request->getPost('roomon_teachid'),
            'roomon_year' => $this->request->getPost('roomon_year'),
            'roomon_term' => $this->request->getPost('roomon_term')
        );
        $count = $this->db->table('tb_room_online')->where($array)->countAllResults();
        if($count == 0){
            $insert =  array('roomon_coursecode'=> $this->request->getPost('roomon_coursecode'),
            'roomon_coursename'=> $this->request->getPost('roomon_coursename'),
            'roomon_classlevel'=> !empty($roomonClasslevel) ? implode("|",$roomonClasslevel) : '',    
            'roomon_teachid'=> $this->request->getPost('roomon_teachid'),
            'roomon_linkroom' => $this->request->getPost('roomon_linkroom'),
            'roomon_liveroom' => $this->request->getPost('roomon_liveroom'),
            'roomon_note' => $this->request->getPost('roomon_note'),
            'roomon_year' => $this->request->getPost('roomon_year'),
            'roomon_term' => $this->request->getPost('roomon_term'),
            'roomon_datecreate' => date('Y-m-d H:i:s')
        );
        echo $result = $this->modTeacherTeaching->RoomOnlineInsert($insert); 
        }else{
            echo 2;
        }

        
    }

    function EditRoomOnline(){
        $edit = $this->db->table('tb_room_online')->where('roomon_id',$this->request->getPost('roomid'))->get()->getRow();
        echo json_encode($edit); 
    }

    function UpdateRoomOnline(){ 
        //echo $this->input->post('roomon_teachid'); exit();
      $roomonClasslevel = $this->request->getPost('roomon_classlevel');
      $update =  array('roomon_coursecode'=> $this->request->getPost('roomon_coursecode'),
            'roomon_coursename'=> $this->request->getPost('roomon_coursename'),
            'roomon_classlevel'=> !empty($roomonClasslevel) ? implode("|",$roomonClasslevel) : '', 
            'roomon_linkroom' => $this->request->getPost('roomon_linkroom'),
            'roomon_teachid' => $this->request->getPost('roomon_teachid'),
            'roomon_liveroom' => $this->request->getPost('roomon_liveroom'),
            'roomon_note' => $this->request->getPost('roomon_note'),
            'roomon_year' => $this->request->getPost('roomon_year'),
            'roomon_term' => $this->request->getPost('roomon_term')
        );
        $id = $this->request->getPost('roomon_id');
        echo $result = $this->modTeacherTeaching->RoomOnlineUpdate($update, $id); 
    }

    function DeleteRoomOnline(){
        $id = $this->request->getPost('roomid');
        echo $result = $this->modTeacherTeaching->RoomOnlineDelete($id); 
    }
}
