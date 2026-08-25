<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_notifications extends CI_Migration
{
    public function up(): void
    {
        $this->dbforge->add_field(array(
            'id'         => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'user_id'    => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE),
            'type'       => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => FALSE),
            'title'      => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
            'message'    => array('type' => 'TEXT', 'null' => FALSE),
            'link'       => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
            'reference'  => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE),
            'is_read'    => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
            'created_at' => array('type' => 'DATETIME', 'null' => FALSE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('notifications', TRUE);

        // One notification per (user, reference) so sweeps never duplicate.
        $this->db->query('CREATE UNIQUE INDEX uq_notifications_user_reference ON notifications (user_id, reference)');
    }

    public function down(): void
    {
        $this->dbforge->drop_table('notifications', TRUE);
    }
}
