<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class MaintenanceFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $db = \Config\Database::connect();
        
        // Get current academic year
        $schoolYearData = $db->table('tb_schoolyear')->get()->getRow();
        if (!$schoolYearData) {
            return; // Cannot determine year, proceed as normal
        }
        $current_year = $schoolYearData->schyear_year;

        // Check for maintenance mode status
        $builder = $db->table('tb_club_onoff');
        $builder->where('c_onoff_year', $current_year);
        $builder->where('c_onoff_for', 'system');
        $maintenance_setting = $builder->get()->getRow();

        // If status is 1 (maintenance mode is ON)
        if ($maintenance_setting && $maintenance_setting->c_onoff_status == 1) {
            $session = session();
            $isAdmin = false;

            // Check if user is an admin based on session data
            if ($session->has('login_id')) {
                 $check_status_data = $db->table('tb_admin_rloes')
                                         ->where('admin_rloes_userid', $session->get('login_id'))
                                         ->get()->getRow();
                if ($check_status_data && in_array($check_status_data->admin_rloes_status, ["admin", "manager"])) {
                    $isAdmin = true;
                }
            }

            // Allow access for admins
            if ($isAdmin) {
                return;
            }

            // Allow access to login pages to prevent being locked out
            $allowed_paths = [
                'LoginAdmin',
                'LoginTeacher',
                'LoginMenager',
                'LoginMenager_callback',
                'Logout',
                'LogoutTeacher'
            ];
            $current_path = uri_string();
            if (in_array($current_path, $allowed_paths)) {
                return;
            }

            // For all other users, show the maintenance page
            // Set a 503 Service Unavailable header
            return response()
                ->setStatusCode(503)
                ->setBody(view('errors/html/maintenance'));
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
