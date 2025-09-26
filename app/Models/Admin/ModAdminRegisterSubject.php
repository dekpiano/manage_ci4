<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ModAdminRegisterSubject extends Model
{
    protected $table = 'tb_register'; // Assuming this is the primary table for this model's operations
    protected $primaryKey = 'register_id';

    protected $allowedFields = []; // Placeholder, fill as needed when migrating ConTeacherCourse

}
