<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ModAdminExtraSubject extends Model
{
    protected $table = 'tb_extra_subject'; // Assuming this is the primary table for this model's operations
    protected $primaryKey = 'extr-id';

    protected $allowedFields = []; // Placeholder, fill as needed when migrating ConStudentExtraSubject

}
