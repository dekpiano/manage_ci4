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
     * Set the selected academic year in session and update tb_schoolyear
     *
     * @param string $year The academic year to set (e.g., "1/2568")
     * @return void
     */
    function set_selected_year(string $year): void
    {
        session()->set('admin_selected_year', $year);
        try {
            $db = \Config\Database::connect();
            $db->table('tb_schoolyear')->where('schyear_id', 1)->update(['schyear_year' => $year]);
        } catch (\Exception $e) {
            log_message('error', 'set_selected_year update tb_schoolyear failed: ' . $e->getMessage());
        }
    }
}

if (!function_exists('parse_selected_year')) {
    /**
     * Parse academic year into term and year (e.g., "1/2568" -> ['term' => '1', 'year' => '2568', 'full' => '1/2568'])
     *
     * @param string|null $yearStr
     * @return array
     */
    function parse_selected_year(?string $yearStr = null): array
    {
        $selected = $yearStr ?: get_selected_year();
        if (!empty($selected) && strpos($selected, '/') !== false) {
            $parts = explode('/', $selected);
            return [
                'term' => trim($parts[0]),
                'year' => trim($parts[1]),
                'full' => $selected
            ];
        }
        $currentYear = (string)(date('Y') + 543);
        return [
            'term' => '1',
            'year' => trim($selected ?: $currentYear),
            'full' => !empty($selected) ? "1/{$selected}" : "1/{$currentYear}"
        ];
    }
}

if (!function_exists('get_selected_year_only')) {
    /**
     * Get 4-digit Buddhist year only (e.g., "2568")
     *
     * @param string|null $yearStr
     * @return string
     */
    function get_selected_year_only(?string $yearStr = null): string
    {
        $parsed = parse_selected_year($yearStr);
        return $parsed['year'];
    }
}

if (!function_exists('get_selected_term_only')) {
    /**
     * Get semester/term only (e.g., "1" or "2")
     *
     * @param string|null $yearStr
     * @return string
     */
    function get_selected_term_only(?string $yearStr = null): string
    {
        $parsed = parse_selected_year($yearStr);
        return $parsed['term'];
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

if (!function_exists('thai_date_format')) {
    /**
     * Format date to Thai Buddhist Era (พ.ศ.)
     *
     * @param string|null $dateStr The date string (e.g. "2026-05-19")
     * @param string $format The format type ('short', 'medium', 'full')
     * @return string
     */
    function thai_date_format($dateStr, $format = 'medium'): string
    {
        if (empty($dateStr) || $dateStr === '0000-00-00' || $dateStr === '-') return '-';
        
        // Remove time if present
        $dateOnly = explode(' ', $dateStr)[0];
        
        // Check if it's already in a Thai-like format
        if (strpos($dateStr, 'พ.ศ.') !== false || strpos($dateStr, 'ม.ค.') !== false) {
            return $dateStr;
        }
        
        $timestamp = strtotime($dateOnly);
        if (!$timestamp) return $dateStr;
        
        $thai_months_short = [
            1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.', 5 => 'พ.ค.', 6 => 'มิ.ย.',
            7 => 'ก.ค.', 8 => 'ส.ค.', 9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
        ];
        
        $thai_months_full = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
            7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];
        
        $day = date('j', $timestamp);
        $month = date('n', $timestamp);
        $year = (int)date('Y', $timestamp);
        
        // Convert to Buddhist Era if not already done
        if ($year < 2400) {
            $year += 543;
        }
        
        if ($format === 'short') {
            return sprintf('%02d/%02d/%04d', $day, $month, $year);
        } elseif ($format === 'full') {
            return "วันที่ $day " . $thai_months_full[$month] . " พ.ศ. $year";
        }
        
        return "$day " . $thai_months_short[$month] . " " . $year;
    }
}

