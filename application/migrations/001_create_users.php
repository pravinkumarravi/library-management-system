<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_users extends CI_Migration
{
    public function up(): void
    {
        $this->dbforge->add_field(array(
            'id'         => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'username'   => array('type' => 'VARCHAR', 'constraint' => 80, 'null' => FALSE),
            'password'   => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
            'name'       => array('type' => 'VARCHAR', 'constraint' => 160, 'null' => TRUE),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('username');
        $this->dbforge->create_table('users', TRUE);

        // Default administrator (password: admin123)
        if ($this->db->where('username', 'admin')->count_all_results('users') === 0) {
            $this->db->insert('users', array(
                'username'   => 'admin',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'name'       => 'Administrator',
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }
    }

    public function down(): void
    {
        $this->dbforge->drop_table('users');
    }
}
