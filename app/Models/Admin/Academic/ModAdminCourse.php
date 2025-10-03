<?php namespace App\Models\Admin\Academic;

use CodeIgniter\Model;

class ModAdminCourse extends Model
{
    protected $table = 'skjacth_academic.tb_send_plan'; // ตารางหลัก
    protected $DBpersonnel; // สำหรับเชื่อมต่อกับฐานข้อมูล personnel

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // เชื่อมต่อฐานข้อมูล academic
        $this->DBpersonnel = \Config\Database::connect('personnel'); // เชื่อมต่อฐานข้อมูล personnel
    }

        // เมธอดสำหรับดึงข้อมูลแผนการสอนสำหรับ DataTables
        public function getPlansForDatatables($start, $length, $searchValue, $orderColumnName, $orderDir, $term, $year)
        {
            log_message('debug', 'ModAdminCourse: Entering getPlansForDatatables.');
            log_message('debug', 'ModAdminCourse: Params - start: ' . $start . ', length: ' . $length . ', searchValue: ' . $searchValue . ', term: ' . $term . ', year: ' . $year);

            $builder = $this->db->table('skjacth_academic.tb_send_plan');
            $builder->select('
                MAX(skjacth_personnel.tb_personnel.pers_id) as pers_id,
                MAX(skjacth_personnel.tb_personnel.pers_prefix) as pers_prefix,
                MAX(skjacth_personnel.tb_personnel.pers_firstname) as pers_firstname,
                MAX(skjacth_personnel.tb_personnel.pers_lastname) as pers_lastname,
                MAX(skjacth_personnel.tb_personnel.pers_learning) as pers_learning,
                MAX(skjacth_academic.tb_send_plan.seplan_namesubject) as seplan_namesubject,
                skjacth_academic.tb_send_plan.seplan_coursecode, 
                MAX(skjacth_academic.tb_send_plan.seplan_typesubject) as seplan_typesubject,
                MAX(skjacth_academic.tb_send_plan.seplan_year) as seplan_year,
                MAX(skjacth_academic.tb_send_plan.seplan_term) as seplan_term,
                MAX(skjacth_academic.tb_send_plan.seplan_gradelevel) as seplan_gradelevel,
                skjacth_academic.tb_send_plan.seplan_usersend, 
                MAX(skjacth_academic.tb_send_plan.seplan_status1) as seplan_status1,
                MAX(skjacth_academic.tb_send_plan.seplan_status2) as seplan_status2,
                MAX(skjacth_academic.tb_send_plan.seplan_sendcomment) as seplan_sendcomment
            ');
            $builder->join('skjacth_personnel.tb_personnel', 'skjacth_academic.tb_send_plan.seplan_usersend = skjacth_personnel.tb_personnel.pers_id', 'LEFT');

            // กรองตามปีและภาคเรียน
            $builder->where('seplan_year', $year);
            $builder->where('seplan_term', $term);

            // กรองตาม searchValue (ค้นหาทั่วโลก)
            if (!empty($searchValue)) {
                $builder->groupStart();
                $builder->like('seplan_coursecode', $searchValue);
                $builder->orLike('seplan_namesubject', $searchValue);
                $builder->orLike('seplan_gradelevel', $searchValue);
                $builder->orLike('seplan_typesubject', $searchValue);
                $builder->orLike('skjacth_personnel.tb_personnel.pers_firstname', $searchValue);
                $builder->orLike('skjacth_personnel.tb_personnel.pers_lastname', $searchValue);
                $builder->groupEnd();
            }

            // Group By
            $builder->groupBy('skjacth_academic.tb_send_plan.seplan_coursecode, skjacth_academic.tb_send_plan.seplan_usersend');

            // เรียงลำดับ
            if (!empty($orderColumnName)) {
                // ต้องแมปชื่อคอลัมน์ DataTables กับชื่อคอลัมน์จริงในฐานข้อมูล
                $dbColumnName = $this->mapDatatablesColumnToDbColumn($orderColumnName);
                if ($dbColumnName) {
                    $builder->orderBy($dbColumnName, $orderDir);
                }
            }

            // แบ่งหน้า
            $builder->limit($length, $start);

            $sql = $builder->getCompiledSelect();
            log_message('debug', 'ModAdminCourse: getPlansForDatatables SQL: ' . $sql);

            $results = $builder->get()->getResultArray();
            log_message('debug', 'ModAdminCourse: getPlansForDatatables Raw Results: ' . json_encode($results));

            // จัดรูปแบบข้อมูลให้ตรงกับที่ DataTables คาดหวัง
            $formattedData = [];
            foreach ($results as $row) {
                $formattedData[] = [
                    'seplan_year_term'      => $row['seplan_term'] . '/' . $row['seplan_year'],
                    'seplan_coursecode'     => $row['seplan_coursecode'],
                    'seplan_namesubject'    => $row['seplan_namesubject'],
                    'seplan_gradelevel'     => 'ม.' . $row['seplan_gradelevel'],
                    'seplan_typesubject'    => $row['seplan_typesubject'],
                    'teacher_fullname'      => $row['pers_prefix'] . $row['pers_firstname'] . ' ' . $row['pers_lastname'],
                    'seplan_coursecode_raw' => $row['seplan_coursecode'],
                    'seplan_year_raw'       => $row['seplan_year'],
                    'seplan_term_raw'       => $row['seplan_term'],
                    'seplan_namesubject_raw' => $row['seplan_namesubject'],
                ];
            }
            log_message('debug', 'ModAdminCourse: getPlansForDatatables Formatted Data: ' . json_encode($formattedData));

            return $formattedData;
        }
    
        // เมธอดสำหรับดึงจำนวนเรคคอร์ดทั้งหมด (ไม่กรอง)
        public function getTotalPlans()
        {
            $builder = $this->db->table('skjacth_academic.tb_send_plan');
            $builder->select('COUNT(DISTINCT CONCAT(seplan_coursecode, "-", seplan_usersend)) as total_count'); // Count unique teacher-subject assignments
            $row = $builder->get()->getRow();
            return $row->total_count;
        }
    
        // เมธอดสำหรับดึงจำนวนเรคคอร์ดที่กรองแล้ว
        public function getFilteredPlansCount($searchValue, $term, $year)
        {
            $builder = $this->db->table('skjacth_academic.tb_send_plan');
            $builder->join('skjacth_personnel.tb_personnel', 'skjacth_academic.tb_send_plan.seplan_usersend = skjacth_personnel.tb_personnel.pers_id', 'LEFT');
    
            // กรองตามปีและภาคเรียน
            $builder->where('seplan_year', $year);
            $builder->where('seplan_term', $term);
    
            // กรองตาม searchValue (ค้นหาทั่วโลก)
            if (!empty($searchValue)) {
                $builder->groupStart();
                $builder->like('seplan_coursecode', $searchValue);
                $builder->orLike('seplan_namesubject', $searchValue);
                $builder->orLike('seplan_gradelevel', $searchValue);
                $builder->orLike('seplan_typesubject', $searchValue);
                $builder->orLike('skjacth_personnel.tb_personnel.pers_firstname', $searchValue);
                $builder->orLike('skjacth_personnel.tb_personnel.pers_lastname', $searchValue);
                $builder->groupEnd();
            }
            
            $builder->select('COUNT(DISTINCT CONCAT(seplan_coursecode, "-", seplan_usersend)) as filtered_count');
            $row = $builder->get()->getRow();
            return $row->filtered_count;
        }
    // เมธอดช่วยในการแมปชื่อคอลัมน์ DataTables กับชื่อคอลัมน์ในฐานข้อมูล
    private function mapDatatablesColumnToDbColumn($dtColumnName)
    {
        switch ($dtColumnName) {
            case 'seplan_year_term': return 'seplan_year'; // หรือ seplan_term
            case 'seplan_coursecode': return 'seplan_coursecode';
            case 'seplan_namesubject': return 'seplan_namesubject';
            case 'seplan_gradelevel': return 'seplan_gradelevel';
            case 'seplan_typesubject': return 'seplan_typesubject';
            case 'teacher_fullname': return 'skjacth_personnel.tb_personnel.pers_firstname'; // หรือ pers_lastname
            default: return null;
        }
    }
}
