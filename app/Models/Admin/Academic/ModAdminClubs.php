<?php

namespace App\Models\Admin\Academic;

use CodeIgniter\Model;

class ModAdminClubs extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Gets the on/off status for all targets for a given academic year and term.
     * It ensures that rows for 'student', 'teacher', and 'system' exist.
     *
     * @param string $year The academic year.
     * @param string $term The academic term.
     * @return array An associative array of statuses (e.g., ['student' => 1, 'teacher' => 0, 'system' => 0]).
     */
    public function get_onoff_status(string $year, string $term): array
    {
        $targets = ['student', 'teacher', 'system'];

        $builder = $this->db->table('tb_club_onoff');
        $builder->where('c_onoff_year', $year);
        $builder->where('c_onoff_term', $term);
        $builder->whereIn('c_onoff_for', $targets);
        $query = $builder->get();
        $results = $query->getResult();

        $statuses = [];
        foreach ($results as $row) {
            $statuses[$row->c_onoff_for] = $row;
        }

        $missing_targets = array_diff($targets, array_keys($statuses));

        if (!empty($missing_targets)) {
            $insert_data = [];
            foreach ($missing_targets as $target) {
                $new_row_data = [
                    'c_onoff_year' => $year,
                    'c_onoff_term' => $term,
                    'c_onoff_for'  => $target,
                    'c_onoff_status' => 0,
                    'c_onoff_regisstart' => null,
                    'c_onoff_regisend' => null
                ];
                $insert_data[] = $new_row_data;
                // Create a standard object to return
                $statuses[$target] = (object)$new_row_data;
            }
            $this->db->table('tb_club_onoff')->insertBatch($insert_data);
        }

        $final_statuses = [];
        foreach ($targets as $target) {
            $final_statuses[$target] = $statuses[$target];
        }

        return $final_statuses;
    }

    public function update_onoff_dates(string $year, string $term, string $target, ?string $startDate, ?string $endDate): bool
    {
        $builder = $this->db->table('tb_club_onoff');
        $builder->where('c_onoff_year', $year);
        $builder->where('c_onoff_term', $term);
        $builder->where('c_onoff_for', $target);
        
        $data = [
            'c_onoff_regisstart' => $startDate,
            'c_onoff_regisend' => $endDate
        ];

        return $builder->update($data);
    }


    /**
     * Updates the on/off status for a specific target, year, and term.
     *
     * @param string $year The academic year.
     * @param string $term The academic term.
     * @param string $target The target ('student', 'teacher', or 'system').
     * @param int $status The new status (1 for on, 0 for off).
     * @return bool True on success, false on failure.
     */
    public function update_onoff_status(string $year, string $term, string $target, int $status): bool
    {
        $builder = $this->db->table('tb_club_onoff');
        $builder->where('c_onoff_year', $year);
        $builder->where('c_onoff_term', $term);
        $builder->where('c_onoff_for', $target);
        $existing = $builder->get()->getRow();

        $data = ['c_onoff_status' => $status];

        if ($existing) {
            // Record exists, update it.
            $builder = $this->db->table('tb_club_onoff'); // Re-initialize builder
            $builder->where('c_onoff_year', $year);
            $builder->where('c_onoff_term', $term);
            $builder->where('c_onoff_for', $target);
            return $builder->update($data);
        } else {
            // Record does not exist, insert it.
            $data['c_onoff_year'] = $year;
            $data['c_onoff_term'] = $term;
            $data['c_onoff_for'] = $target;
            return $this->db->table('tb_club_onoff')->insert($data);
        }

}
}
