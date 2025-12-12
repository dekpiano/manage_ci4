<?php

/**
 * Year Helper Functions
 * 
 * Helper functions for managing selected academic year across the system.
 */

if (!function_exists('get_selected_year')) {
    /**
     * Get the selected academic year from session, or fall back to default school year
     *
     * @return string The selected academic year (e.g., "1/2568")
     */
    function get_selected_year(): string
    {
        // First, check if there's a year stored in session
        $sessionYear = session()->get('admin_selected_year');
        
        if (!empty($sessionYear)) {
            return $sessionYear;
        }
        
        // Fall back to the default school year from database
        $db = \Config\Database::connect();
        $schoolYear = $db->table('tb_schoolyear')->get()->getRow();
        
        return $schoolYear->schyear_year ?? '';
    }
}

if (!function_exists('set_selected_year')) {
    /**
     * Set the selected academic year in session
     *
     * @param string $year The academic year to set (e.g., "1/2568")
     * @return void
     */
    function set_selected_year(string $year): void
    {
        session()->set('admin_selected_year', $year);
    }
}

if (!function_exists('get_selected_year_data')) {
    /**
     * Get both the SchoolYear object and the selected year for use in views
     * Returns an array with 'SchoolYear' and 'selectedYear' keys
     *
     * @return array
     */
    function get_selected_year_data(): array
    {
        $db = \Config\Database::connect();
        $schoolYear = $db->table('tb_schoolyear')->get()->getRow();
        
        $sessionYear = session()->get('admin_selected_year');
        $selectedYear = $sessionYear ?: ($schoolYear->schyear_year ?? '');
        
        return [
            'SchoolYear' => $schoolYear,
            'selectedYear' => $selectedYear
        ];
    }
}
