<?php

namespace App\Controllers\Admin\Academic;

use App\Controllers\BaseController;

class ConAdminRoomOnline extends BaseController
{
    protected $DBpersonnel;

    public function __construct()
    {
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->db = \Config\Database::connect(); // Initialize the default database connection

        helper(['url', 'form']);

        // CI3 session check equivalent
        if (empty(session()->get('fullname'))) {
            return redirect()->to(base_url('LogoutTeacher'));
        }

        $check_status_data = $this->db->table('tb_admin_rloes')->where('admin_rloes_userid', session()->get('login_id'))->get()->getRow();

        if (empty($check_status_data) || (! in_array($check_status_data->admin_rloes_status, ["admin", "manager", "superadmin"]))) {
            session()->setFlashdata(['msg' => 'OK', 'messge' => 'คุณไม่มีสิทธ์ในระบบจัดข้อมูลนี้ ติดต่อเจ้าหน้าที่คอม', 'alert' => 'error']);
            return redirect()->to(base_url('welcome'));
        }
    }

    public function RoomOnlineMain(){      
        $data['title']  = "หน้าหลักห้องเรียนออนไลน์";
        $data['SchoolYear'] = $this->db->table('tb_schoolyear')->get()->getRow();
        $data['selectedYear'] = get_selected_year();
        $data['selectedYearOnly'] = get_selected_year_only();
        $data['selectedTerm'] = get_selected_term_only();
        $data['checkOnOff'] = $this->db->table('tb_register_onoff')->select('*')->get()->getResult();
        $data['teacher'] = $this->DBpersonnel->table('tb_personnel')->select('pers_id,pers_img')->where('pers_id',session()->get('login_id'))->get()->getRow();
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
        $data['classroom'] = new \App\Libraries\Classroom();
        echo view('admin/Academic/AdminRoomOnline/AdminRoomOnlineMain.php', $data);     
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
        echo $result = $this->db->table('tb_room_online')->insert($insert); 
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
        echo $result = $this->db->table('tb_room_online')->where('roomon_id', $id)->update($update); 
    }

    function DeleteRoomOnline(){
        $id = $this->request->getPost('roomid');
        echo $result = $this->db->table('tb_room_online')->where('roomon_id', $id)->delete(); 
    }

    public function getRoomOnlineData()
    {
        $request = $this->request;

        // Base query
        $builder = $this->db->table('tb_room_online');
        $builder->select([
            'tb_room_online.roomon_id',
            'tb_room_online.roomon_year',
            'tb_room_online.roomon_term',
            'tb_room_online.roomon_coursecode',
            'tb_room_online.roomon_coursename',
            'tb_room_online.roomon_classlevel',
            'tb_room_online.roomon_linkroom',
            'tb_room_online.roomon_liveroom',
            'CONCAT(personnel.pers_firstname, " ", personnel.pers_lastname) as teacher_name'
        ]);
        $builder->join($this->DBpersonnel->database . '.tb_personnel as personnel', 'personnel.pers_id = tb_room_online.roomon_teachid', 'left');

        // Filter by year and term
        $yearFilter = $request->getPost('year');
        $termFilter = $request->getPost('term');

        if (!empty($yearFilter) && $yearFilter !== 'all') {
            $builder->where('tb_room_online.roomon_year', $yearFilter);
        } elseif ($yearFilter !== 'all') {
            $builder->where('tb_room_online.roomon_year', get_selected_year_only());
        }

        if (!empty($termFilter) && $termFilter !== 'all') {
            $builder->where('tb_room_online.roomon_term', $termFilter);
        } elseif ($termFilter !== 'all') {
            $builder->where('tb_room_online.roomon_term', get_selected_term_only());
        }

        // Total records
        $totalRecords = $builder->countAllResults(false); // false to not reset the query

        // Search
        $searchValue = $request->getPost('search')['value'];
        if (!empty($searchValue)) {
            $builder->groupStart();
            $builder->like('tb_room_online.roomon_coursecode', $searchValue);
            $builder->orLike('tb_room_online.roomon_coursename', $searchValue);
            $builder->orLike('CONCAT(personnel.pers_firstname, " ", personnel.pers_lastname)', $searchValue);
            $builder->orLike('tb_room_online.roomon_classlevel', $searchValue);
            $builder->groupEnd();
        }

        // Filtered records
        $filteredRecords = $builder->countAllResults(false);

        // Order
        $order = $request->getPost('order');
        if (!empty($order)) {
            $columnIdx = $order[0]['column'];
            $columnName = $request->getPost('columns')[$columnIdx]['data'];
            $dir = $order[0]['dir'];
            $builder->orderBy($columnName, $dir);
        }

        // Limit
        $length = $request->getPost('length');
        $start = $request->getPost('start');
        if ($length != -1) {
            $builder->limit($length, $start);
        }

        $data = $builder->get()->getResult();

        $output = [
            'draw' => intval($request->getPost('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return $this->response->setJSON($output);
    }
}
