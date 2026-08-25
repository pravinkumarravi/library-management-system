<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_categories extends CI_Migration
{
    public function up(): void
    {
        $this->dbforge->add_field(array(
            'id'          => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name'        => array('type' => 'VARCHAR', 'constraint' => 120, 'null' => FALSE),
            'description' => array('type' => 'TEXT', 'null' => TRUE),
            'created_at'  => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('categories', TRUE);
    }

    public function down(): void
    {
        $this->dbforge->drop_table('categories');
    }
}
