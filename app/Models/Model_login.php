<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_login extends Model
{
    protected $DBpersonnel;
    protected $DBacademic;
    protected $DBgeneral;

    public function __construct()
    {
        parent::__construct();
        $this->DBpersonnel = \Config\Database::connect('personnel');
        $this->DBacademic = \Config\Database::connect('default'); // Use default for academic if it's the primary DB
        $this->DBgeneral = \Config\Database::connect('general');
    }

    public function record_count_student($username,$password)
    {
        return $this->db->table('tb_students')
                        ->where('StudentCode',$username)
                        ->where('StudentIDNumber',$password)
                        ->countAllResults();
    }

    public function fetch_student_login($username,$password)
    {
        return $this->db->table('tb_students')
                        ->where('StudentCode',$username)
                        ->where('StudentIDNumber',$password)
                        ->get()->getRow();
    }

    public function record_count_teacher1($username,$password)
    {
        return $this->DBpersonnel->table('tb_personnel')
                                ->where('pers_username',$username)
                                ->where('pers_password',$password)
                                ->countAllResults();
    }

    public function fetch_teacher_login1($username,$password)
    {
        $query = $this->DBpersonnel->table('skjacth_personnel.tb_personnel')
                                ->select('
                                    skjacth_personnel.tb_personnel.pers_id,
                                    skjacth_personnel.tb_personnel.pers_prefix,
                                    skjacth_personnel.tb_personnel.pers_firstname,
                                    skjacth_personnel.tb_personnel.pers_lastname,
                                    skjacth_personnel.tb_personnel.pers_img,
                                    skjacth_personnel.tb_personnel.pers_groupleade,
                                    skjacth_personnel.tb_personnel.pers_learning,
                                    skjacth_general.tb_admin_rloes.admin_rloes_id AS general_rloes_id,
                                    skjacth_academic.tb_admin_rloes.admin_rloes_id AS academic_rloes_id,
                                    skjacth_general.tb_admin_rloes.admin_rloes_nanetype AS general_nanetype,
                                    skjacth_academic.tb_admin_rloes.admin_rloes_nanetype AS academic_nanetype,
                                    skjacth_academic.tb_admin_rloes.admin_rloes_status AS academic_status,
                                    skjacth_general.tb_admin_rloes.admin_rloes_status AS general_status,
                                    skjacth_personnel.tb_personnel.pers_changepassword
                                ')
                                ->join('skjacth_general.tb_admin_rloes','skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id','left')
                                ->join('skjacth_academic.tb_admin_rloes','skjacth_academic.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id','left')
                                ->where('pers_username',$username)
                                ->where('pers_password',$password)
                                ->get();

        if($query->getNumRows() > 0)
        {
            return $query->getRow();
        }
        else
        {
            return false;
        }
    }

    public function record_count_admin($username,$password)
    {
        return $this->DBpersonnel->table('tb_personnel')
                                ->where('pers_username',$username)
                                ->where('pers_password',$password)
                                ->countAllResults();
    }

    public function fetch_admin_login($username,$password)
    {
        return $this->DBpersonnel->table('tb_personnel')
                                ->where('pers_username',$username)
                                ->where('pers_password',$password)
                                ->get()->getRow();
    }

    public function check_login_teacher($email)
    {
        return $this->DBpersonnel->table('tb_personnel')
                                ->where('pers_username',$email)
                                ->countAllResults();
    }

    function fetch_teacher_login($id)
    {
        $query = $this->DBpersonnel->table('skjacth_personnel.tb_personnel')
                                ->select('
                                    skjacth_personnel.tb_personnel.pers_id,
                                    skjacth_personnel.tb_personnel.pers_prefix,
                                    skjacth_personnel.tb_personnel.pers_firstname,
                                    skjacth_personnel.tb_personnel.pers_lastname,
                                    skjacth_personnel.tb_personnel.pers_img,
                                    skjacth_personnel.tb_personnel.pers_groupleade,
                                    skjacth_personnel.tb_personnel.pers_learning,
                                    skjacth_general.tb_admin_rloes.admin_rloes_id AS general_rloes_id,
                                    skjacth_academic.tb_admin_rloes.admin_rloes_id AS academic_rloes_id,
                                    skjacth_general.tb_admin_rloes.admin_rloes_nanetype AS general_nanetype,
                                    skjacth_academic.tb_admin_rloes.admin_rloes_nanetype AS academic_nanetype,
                                    skjacth_academic.tb_admin_rloes.admin_rloes_status AS academic_status,
                                    skjacth_general.tb_admin_rloes.admin_rloes_status AS general_status
                                ')
                                ->join('skjacth_general.tb_admin_rloes','skjacth_general.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id','left')
                                ->join('skjacth_academic.tb_admin_rloes','skjacth_academic.tb_admin_rloes.admin_rloes_userid = skjacth_personnel.tb_personnel.pers_id','left')
                                ->where('pers_username', $id)
                                ->get();
                                
        if($query->getNumRows() > 0)
        {
            return $query->getRow();
        }
        else
        {
            return false;
        }
    }

    function Update_user_data($data, $id)
    {
        return $this->DBpersonnel->table('tb_personnel')
                                ->where('pers_username', $id)
                                ->update($data);
    }
}