<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Document extends Migration
{
    public function up()
    {
        // Documents table
        $this->forge->addField(
            [
                'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'from_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
                'to_id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
                'document_title'    => ['type' => 'varchar', 'constraint' => 100],
                'document_filename' => ['type' => 'varchar', 'constraint' => 100],
                'signed'            => ['type' => 'tinyint', 'constraint' => 1],
                'qrcode_hash'       => ['type' => 'varchar', 'constraint' => 2048],
                'rsa_encrypt'       => ['type' => 'varchar', 'constraint' => 2048],
                'created_at'        => ['type' => 'datetime'],
                'updated_at'        => ['type' => 'datetime']
            ]
        );
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('from_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('to_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('documents');
    }

    public function down()
    {
        //
        $this->forge->dropTable('documents');
    }
}
