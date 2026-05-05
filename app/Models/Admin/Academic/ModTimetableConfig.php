<?php

namespace App\Models\Admin\Academic;

use CodeIgniter\Model;

class ModTimetableConfig extends Model
{
    protected $DBGroup          = 'timetable';
    
    public function getDays()
    {
        return $this->db->table('tb_timetable_config_days')->get()->getResult();
    }

    public function updateDay($day_id, $data)
    {
        return $this->db->table('tb_timetable_config_days')->where('day_id', $day_id)->update($data);
    }

    public function getPeriods()
    {
        return $this->db->table('tb_timetable_config_periods')->orderBy('period_number', 'ASC')->get()->getResult();
    }

    public function savePeriod($data)
    {
        if (isset($data['period_id']) && !empty($data['period_id'])) {
            $id = $data['period_id'];
            unset($data['period_id']);
            return $this->db->table('tb_timetable_config_periods')->where('period_id', $id)->update($data);
        } else {
            return $this->db->table('tb_timetable_config_periods')->insert($data);
        }
    }

    public function deletePeriod($period_id)
    {
        return $this->db->table('tb_timetable_config_periods')->where('period_id', $period_id)->delete();
    }

    public function getMasterSlots($term, $year)
    {
        return $this->db->table('tb_timetable_config_master_slots')
            ->where('term', $term)
            ->where('year', $year)
            ->get()->getResult();
    }

    public function saveMasterSlot($data)
    {
        $exists = $this->db->table('tb_timetable_config_master_slots')
            ->where([
                'day' => $data['day'],
                'period' => $data['period'],
                'level_group' => $data['level_group'],
                'term' => $data['term'],
                'year' => $data['year']
            ])->get()->getRow();

        if ($exists) {
            if (empty($data['subject_name'])) {
                return $this->db->table('tb_timetable_config_master_slots')->where('master_id', $exists->master_id)->delete();
            }
            return $this->db->table('tb_timetable_config_master_slots')->where('master_id', $exists->master_id)->update(['subject_name' => $data['subject_name']]);
        } else {
            if (empty($data['subject_name'])) return true;
            return $this->db->table('tb_timetable_config_master_slots')->insert($data);
        }
    }
}
