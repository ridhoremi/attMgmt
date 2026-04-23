<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Checkinout extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'machine_id' => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => '5',
            ],
            'checktime' => [
                'type' => 'DATETIME',
                'null' => true,
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('checkinout');
    }

    public function down()
    {
        $this->forge->dropTable('checkinout');
    }
}
