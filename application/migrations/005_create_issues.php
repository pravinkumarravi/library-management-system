<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_issues extends CI_Migration
{
    public function up(): void
    {
        $this->dbforge->add_field(array(
            'id'          => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'book_id'     => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE),
            'member_id'   => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE),
            'issue_date'  => array('type' => 'DATE', 'null' => TRUE),
            'due_date'    => array('type' => 'DATE', 'null' => TRUE),
            'return_date' => array('type' => 'DATE', 'null' => TRUE),
            'status'      => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'issued'),
            'fine'        => array('type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00),
            'created_at'  => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('book_id');
        $this->dbforge->add_key('member_id');
        $this->dbforge->create_table('issues', TRUE);
    }

    public function down(): void
    {
        $this->dbforge->drop_table('issues');
    }
}
