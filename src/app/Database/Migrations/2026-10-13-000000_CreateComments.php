<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateComments extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('comments')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 254,
            ],
            'text' => [
                'type' => 'TEXT',
            ],
            'date' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('date');
        $this->forge->createTable('comments');
    }

    public function down()
    {
        if ($this->db->tableExists('comments')) {
            $this->forge->dropTable('comments');
        }
    }
}
