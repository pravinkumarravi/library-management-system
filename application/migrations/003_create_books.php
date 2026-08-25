<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_books extends CI_Migration
{
    public function up(): void
    {
        $this->dbforge->add_field(array(
            'id'               => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'title'            => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
            'author'           => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
            'isbn'             => array('type' => 'VARCHAR', 'constraint' => 40, 'null' => TRUE),
            'publisher'        => array('type' => 'VARCHAR', 'constraint' => 160, 'null' => TRUE),
            'year'             => array('type' => 'INT', 'constraint' => 4, 'null' => TRUE),
            'category_id'      => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE),
            'total_copies'     => array('type' => 'INT', 'constraint' => 11, 'default' => 1),
            'available_copies' => array('type' => 'INT', 'constraint' => 11, 'default' => 1),
            'created_at'       => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('category_id');
        $this->dbforge->create_table('books', TRUE);
    }

    public function down(): void
    {
        $this->dbforge->drop_table('books');
    }
}
