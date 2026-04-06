<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddStatusChangeDatesToStudents extends Migration
{
    public function up()
    {
        $fields = [
            'StudentStatusDate' => [
                'type'       => 'DATE',
                'null'       => true,
                'after'      => 'StudentStatus',
            ],
            'StudentStatusYear' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
                'after'      => 'StudentStatusDate',
            ],
        ];
        $this->forge->addColumn('tb_students', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_students', ['StudentStatusDate', 'StudentStatusYear']);
    }
}
