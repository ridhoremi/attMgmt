<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Shift extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_shift' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'jam_masuk' => [
                'type' => 'TIME',
            ],
            'jam_keluar' => [
                'type' => 'TIME',
            ],
            'machine_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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

        // // Foreign key ke tabel mesin (kalau sudah ada)
        // $this->forge->addForeignKey('machine_id', 'mesin', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('shift');
    }

    public function down()
    {
        $this->forge->dropTable('shift');
    }
}
