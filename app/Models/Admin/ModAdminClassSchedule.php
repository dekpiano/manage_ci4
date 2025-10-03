<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ModAdminClassSchedule extends Model
{
    protected $table = 'tb_class_schedule'; // Primary table for this model
    protected $primaryKey = 'schestu_id';

    protected $allowedFields = [
        'schestu_id',
        'schestu_name',
        'schestu_classname',
        'schestu_filename',
        'schestu_term',
        'schestu_year',
        'schestu_datetime',
        'schestu_user',
    ]; // Fields that can be mass-assigned

    public function class_schedule_insert($data)
    {
        try {
            $result = $this->insert($data);

            if ($result !== false) {
                return true; // Return true for success
            } else {
                // If insert returns false, but no exception was thrown,
                // it means the model itself failed to insert.
                // We can try to get the last query error if available.
                $dbError = $this->db->error();
                $errorMessage = 'Model Insert Failed. ';
                if ($dbError['code'] !== 0) {
                    $errorMessage .= 'DB Error: Code ' . $dbError['code'] . ' - ' . $dbError['message'];
                } else {
                    $errorMessage .= 'No specific DB error reported. Model errors: ' . print_r($this->errors(), true);
                }
                log_message('error', $errorMessage);
                return false; // Return false for failure
            }
        } catch (\Exception $e) {
            // Catch any exceptions thrown by the database driver during insert
            log_message('error', 'Database Insert Exception: ' . $e->getMessage());
            return false;
        }
    }

    public function class_schedule_update($data, $schestu_id)
    {
        return $this->where('schestu_id', $schestu_id)->update($data);
    }

    public function class_schedule_delete($id)
    {
        return $this->where('schestu_id', $id)->delete();
    }
}


