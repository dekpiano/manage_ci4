<?php

namespace App\Models\Admin\Academic;

use CodeIgniter\Model;

class ModAdminCharacteristics extends Model
{
    protected $returnType = 'object';
    protected $table = 'tb_register_onoff';
    protected $primaryKey = 'onoff_id';
    protected $allowedFields = ['onoff_name', 'onoff_status', 'onoff_year', 'onoff_detail', 'onoff_Level'];

    /**
     * Get settings by onoff_name
     *
     * @param string $name The name of the setting (e.g., 'DesirableCharacteristics')
     * @return object|null The setting object or null if not found
     */
    public function getSettings(string $name)
    {
        return $this->where('onoff_name', $name)->first();
    }

    /**
     * Update settings by onoff_name (Upsert)
     *
     * @param string $name The name of the setting
     * @param array $data The data to update
     * @return bool True on success, false on failure
     */
    public function updateSettings(string $name, array $data)
    {
        $existing = $this->where('onoff_name', $name)->first();
        if ($existing) {
            return $this->db->table($this->table)
                            ->where('onoff_name', $name)
                            ->set($data)
                            ->update();
        } else {
            $data['onoff_name'] = $name;
            return $this->db->table($this->table)
                            ->insert($data);
        }
    }

}

