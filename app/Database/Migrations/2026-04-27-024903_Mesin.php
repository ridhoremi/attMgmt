<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mesin extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'machine_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'nama_mesin' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('machine_id', true);
        $this->forge->createTable('mesin');
    }

    public function down()
    {
        $this->forge->dropTable('mesin');
    }
}
