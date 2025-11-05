<?php

namespace App\Models\Admin\Academic;

use CodeIgniter\Model;

class ModAdminCheckPlan extends Model
{
    public function getLearningGroups()
    {
        $db_skj = \Config\Database::connect('skj');
        $builder = $db_skj->table('tb_learning');
        $builder->select('lear_id, lear_namethai');
        $builder->orderBy('lear_id', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getDistinctYearTerm()
    {
        $builder = $this->db->table('tb_send_plan');
        $builder->select('seplan_year, seplan_term');
        $builder->distinct();
        $builder->orderBy('seplan_year', 'DESC');
        $builder->orderBy('seplan_term', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getPlansByGroupId($groupId, $year, $term)
    {
        $builder = $this->db->table('tb_send_plan');
        $builder->select('
            tb_send_plan.seplan_id,
            tb_send_plan.seplan_createdate,
            tb_send_plan.seplan_status1,
            tb_send_plan.seplan_comment1,
            tb_send_plan.seplan_file,
            tb_send_plan.seplan_usersend,
            tb_send_plan.seplan_learning,
            p.pers_prefix, 
            p.pers_firstname, 
            p.pers_lastname, 
            p.pers_img,
            l.lear_namethai
        ');
        $builder->join('skjacth_personnel.tb_personnel as p', 'p.pers_id = tb_send_plan.seplan_usersend');
        $builder->join('skjacth_skj.tb_learning as l', 'l.lear_id = tb_send_plan.seplan_learning');
        $builder->where('tb_send_plan.seplan_learning', $groupId);
        $builder->where('tb_send_plan.seplan_year', $year);
        $builder->where('tb_send_plan.seplan_term', $term);
        $builder->where('p.pers_status','กำลังใช้งาน');
        $builder->where('p.pers_position >','posi_002');
        $builder->orderBy('tb_send_plan.seplan_createdate', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function updatePlan($planId, $data)
    {
        $builder = $this->db->table('tb_send_plan');
        $builder->where('seplan_id', $planId);
        return $builder->update($data);
    }

    public function getPlansByTeacherId($teacherId, $year, $term)
    {
        $builder = $this->db->table('tb_send_plan');
        $builder->select('
            tb_send_plan.seplan_namesubject,
            tb_send_plan.seplan_coursecode,
            tb_send_plan.seplan_year,
            tb_send_plan.seplan_term,
            tb_subjects.SubjectClass as seplan_class,
            tb_subjects.SubjectType as seplan_subject_type,

            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'แบบตรวจแผนการจัดการเรียนรู้\' THEN tb_send_plan.seplan_file END) AS check_plan_file,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'แบบตรวจแผนการจัดการเรียนรู้\' THEN tb_send_plan.seplan_id END) AS check_plan_file_id,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'แบบตรวจแผนการจัดการเรียนรู้\' THEN tb_send_plan.seplan_status1 END) AS check_plan_file_status1,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'แบบตรวจแผนการจัดการเรียนรู้\' THEN tb_send_plan.seplan_comment1 END) AS check_plan_file_comment1,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'แบบตรวจแผนการจัดการเรียนรู้\' THEN tb_send_plan.seplan_status2 END) AS check_plan_file_status2,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'แบบตรวจแผนการจัดการเรียนรู้\' THEN tb_send_plan.seplan_comment2 END) AS check_plan_file_comment2,

            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'บันทึกตรวจใช้แผน\' THEN tb_send_plan.seplan_file END) AS record_check_file,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'บันทึกตรวจใช้แผน\' THEN tb_send_plan.seplan_id END) AS record_check_file_id,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'บันทึกตรวจใช้แผน\' THEN tb_send_plan.seplan_status1 END) AS record_check_file_status1,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'บันทึกตรวจใช้แผน\' THEN tb_send_plan.seplan_comment1 END) AS record_check_file_comment1,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'บันทึกตรวจใช้แผน\' THEN tb_send_plan.seplan_status2 END) AS record_check_file_status2,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'บันทึกตรวจใช้แผน\' THEN tb_send_plan.seplan_comment2 END) AS record_check_file_comment2,

            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'แผนการสอนหน้าเดียว\' THEN tb_send_plan.seplan_file END) AS use_plan_file,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'แผนการสอนหน้าเดียว\' THEN tb_send_plan.seplan_id END) AS use_plan_file_id,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'แผนการสอนหน้าเดียว\' THEN tb_send_plan.seplan_status1 END) AS use_plan_file_status1,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'แผนการสอนหน้าเดียว\' THEN tb_send_plan.seplan_comment1 END) AS use_plan_file_comment1,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'แผนการสอนหน้าเดียว\' THEN tb_send_plan.seplan_status2 END) AS use_plan_file_status2,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'แผนการสอนหน้าเดียว\' THEN tb_send_plan.seplan_comment2 END) AS use_plan_file_comment2,

            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'โครงการสอน\' THEN tb_send_plan.seplan_file END) AS project_plan_file,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'โครงการสอน\' THEN tb_send_plan.seplan_id END) AS project_plan_file_id,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'โครงการสอน\' THEN tb_send_plan.seplan_status1 END) AS project_plan_file_status1,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'โครงการสอน\' THEN tb_send_plan.seplan_comment1 END) AS project_plan_file_comment1,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'โครงการสอน\' THEN tb_send_plan.seplan_status2 END) AS project_plan_file_status2,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'โครงการสอน\' THEN tb_send_plan.seplan_comment2 END) AS project_plan_file_comment2,

            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'บันทึกหลังสอน\' THEN tb_send_plan.seplan_file END) AS after_teach_note_file,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'บันทึกหลังสอน\' THEN tb_send_plan.seplan_id END) AS after_teach_note_file_id,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'บันทึกหลังสอน\' THEN tb_send_plan.seplan_status1 END) AS after_teach_note_file_status1,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'บันทึกหลังสอน\' THEN tb_send_plan.seplan_comment1 END) AS after_teach_note_file_comment1,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'บันทึกหลังสอน\' THEN tb_send_plan.seplan_status2 END) AS after_teach_note_file_status2,
            MAX(CASE WHEN tb_send_plan.seplan_typeplan = \'บันทึกหลังสอน\' THEN tb_send_plan.seplan_comment2 END) AS after_teach_note_file_comment2
        ');
        $builder->join('skjacth_academic.tb_subjects', 'tb_subjects.SubjectCode = tb_send_plan.seplan_coursecode');
        $builder->where('tb_send_plan.seplan_usersend', $teacherId);
        $builder->where('tb_send_plan.seplan_year', $year);
        $builder->where('tb_send_plan.seplan_term', $term);
        $builder->groupBy('tb_send_plan.seplan_coursecode, tb_send_plan.seplan_namesubject, tb_send_plan.seplan_year, tb_send_plan.seplan_term, tb_subjects.SubjectClass, tb_subjects.SubjectType');
        $builder->orderBy('tb_send_plan.seplan_coursecode', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
}
