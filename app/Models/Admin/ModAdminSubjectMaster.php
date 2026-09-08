<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ModAdminSubjectMaster extends Model
{
    protected $table = 'tb_subjects_master';
    protected $primaryKey = 'master_id';

    protected $allowedFields = [
        'subject_code',
        'subject_name',
        'subject_unit',
        'subject_hour',
        'subject_type',
        'first_group',
        'second_group',
        'subject_class'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * ดึงรายการวิชากลางทั้งหมด พร้อมตัวกรอง (ถ้ามี)
     */
    public function getMasterSubjects($filters = [])
    {
        $builder = $this->builder();

        if (!empty($filters['first_group'])) {
            $builder->where('first_group', $filters['first_group']);
        }

        if (!empty($filters['subject_class'])) {
            $builder->where('subject_class', $filters['subject_class']);
        }

        if (!empty($filters['subject_type'])) {
            $builder->where('subject_type', $filters['subject_type']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('subject_code', $filters['search'])
                ->orLike('subject_name', $filters['search'])
                ->groupEnd();
        }

        return $builder->orderBy('subject_class', 'ASC')
                       ->orderBy('subject_code', 'ASC')
                       ->get()
                       ->getResult();
    }

    /**
     * สรุปสถิติสำหรับหน้า Dashboard/Overview
     */
    public function getStatistics()
    {
        $db = \Config\Database::connect();
        $total = $db->table($this->table)->countAllResults();
        
        $basic = $db->table($this->table)
            ->groupStart()
                ->like('subject_type', 'พื้นฐาน')
                ->orLike('subject_type', '1/')
            ->groupEnd()
            ->countAllResults();

        $advanced = $db->table($this->table)
            ->groupStart()
                ->like('subject_type', 'เพิ่มเติม')
                ->orLike('subject_type', '2/')
            ->groupEnd()
            ->countAllResults();

        $groups = $db->table($this->table)
            ->select('first_group')
            ->distinct()
            ->where('first_group IS NOT NULL')
            ->where('first_group !=', '')
            ->countAllResults();

        return [
            'total'    => $total,
            'basic'    => $basic,
            'advanced' => $advanced,
            'groups'   => $groups
        ];
    }

    /**
     * ดึงรายชื่อกลุ่มสาระและระดับชั้นที่มีในระบบ เพื่อนำไปทำ Filter Dropdown
     */
    public function getFilterOptions()
    {
        $db = \Config\Database::connect();
        
        $firstGroups = $db->table($this->table)
            ->select('first_group')
            ->distinct()
            ->where('first_group IS NOT NULL')
            ->where('first_group !=', '')
            ->orderBy('first_group', 'ASC')
            ->get()
            ->getResultArray();

        $classes = $db->table($this->table)
            ->select('subject_class')
            ->distinct()
            ->where('subject_class IS NOT NULL')
            ->where('subject_class !=', '')
            ->orderBy('subject_class', 'ASC')
            ->get()
            ->getResultArray();

        return [
            'first_groups' => array_column($firstGroups, 'first_group'),
            'classes'      => array_column($classes, 'subject_class')
        ];
    }

    /**
     * นำเข้าข้อมูลแบบกลุ่ม (Sync / Bulk Insert or Update)
     */
    public function syncBatch($subjects)
    {
        if (empty($subjects) || !is_array($subjects)) {
            return 0;
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $insertedCount = 0;
        $updatedCount  = 0;

        foreach ($subjects as $row) {
            $code  = trim($row['subject_code'] ?? '');
            $class = trim($row['subject_class'] ?? '');

            if (empty($code)) {
                continue;
            }

            // ตรวจสอบว่ามีวิชานี้ในระดับชั้นนี้แล้วหรือไม่
            $existing = $this->where('subject_code', $code)
                             ->where('subject_class', $class)
                             ->first();

            $data = [
                'subject_code'  => $code,
                'subject_name'  => trim($row['subject_name'] ?? ''),
                'subject_unit'  => trim($row['subject_unit'] ?? ''),
                'subject_hour'  => !empty($row['subject_hour']) ? (int)$row['subject_hour'] : 0,
                'subject_type'  => trim($row['subject_type'] ?? ''),
                'first_group'   => trim($row['first_group'] ?? ''),
                'second_group'  => trim($row['second_group'] ?? ''),
                'subject_class' => $class,
            ];

            if ($existing) {
                $this->update($existing['master_id'], $data);
                $updatedCount++;
            } else {
                $this->insert($data);
                $insertedCount++;
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return false;
        }

        return [
            'inserted' => $insertedCount,
            'updated'  => $updatedCount,
            'total'    => $insertedCount + $updatedCount
        ];
    }
}
