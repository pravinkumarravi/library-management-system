<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_members extends CI_Migration
{
    public function up(): void
    {
        $this->dbforge->add_field(array(
            'id'              => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name'            => array('type' => 'VARCHAR', 'constraint' => 160, 'null' => FALSE),
            'email'           => array('type' => 'VARCHAR', 'constraint' => 160, 'null' => TRUE),
            'phone'           => array('type' => 'VARCHAR', 'constraint' => 40, 'null' => TRUE),
            'address'         => array('type' => 'TEXT', 'null' => TRUE),
            'membership_date' => array('type' => 'DATE', 'null' => TRUE),
            'status'          => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'),
            'created_at'      => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('members', TRUE);
    }

    public function down(): void
    {
        $this->dbforge->drop_table('members');
    }
}
