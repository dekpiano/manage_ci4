<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAuditColumnsToStudents extends Migration
{
    public function up()
    {
        $fields = [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
        ];
        $this->forge->addColumn('tb_students', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_students', ['created_at', 'created_by', 'updated_at', 'updated_by']);
    }
}
