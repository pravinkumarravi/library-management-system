<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * One-time installer: creates the database tables (idempotent) and
 * seeds an administrator plus a little sample data so the app is
 * usable immediately. Visit /install once, then delete this file.
 */
class Install extends CI_Controller
{
    public function index(): void
    {
        $this->load->dbforge();
        $this->create_tables();
        $this->seed();

        echo '<h1>Installation complete</h1>'
            . '<p>Default login &mdash; <strong>admin</strong> / <strong>admin123</strong></p>'
            . '<p><a href="' . base_url('auth/login') . '">Go to login &raquo;</a></p>';
    }

    private function create_tables(): void
    {
        $this->dbforge->add_field(array(
            'id'          => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name'        => array('type' => 'VARCHAR', 'constraint' => 120, 'null' => FALSE),
            'description' => array('type' => 'TEXT', 'null' => TRUE),
            'created_at'  => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('categories', TRUE);

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
        $this->dbforge->create_table('books', TRUE);

        $this->dbforge->add_field(array(
            'id'              => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name'            => array('type' => 'VARCHAR', 'constraint' => 160, 'null' => FALSE),
            'email'           => array('type' => 'VARCHAR', 'constraint' => 160, 'null' => TRUE),
            'phone'           => array('type' => 'VARCHAR', 'constraint' => 40, 'null' => TRUE),
            'address'         => array('type' => 'TEXT', 'null' => TRUE),
            'membership_date' => array('type' => 'DATE', 'null' => TRUE),
            'status'          => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => "'active'"),
            'created_at'      => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('members', TRUE);

        $this->dbforge->add_field(array(
            'id'         => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'book_id'    => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE),
            'member_id'  => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE),
            'issue_date' => array('type' => 'DATE', 'null' => TRUE),
            'due_date'   => array('type' => 'DATE', 'null' => TRUE),
            'return_date'=> array('type' => 'DATE', 'null' => TRUE),
            'status'     => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => "'issued'"),
            'fine'       => array('type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('issues', TRUE);

        $this->dbforge->add_field(array(
            'id'         => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'username'   => array('type' => 'VARCHAR', 'constraint' => 80, 'null' => FALSE),
            'password'   => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE),
            'name'       => array('type' => 'VARCHAR', 'constraint' => 160, 'null' => TRUE),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users', TRUE);
    }

    private function seed(): void
    {
        $this->load->model('User_model');

        if (!$this->User_model->get_by_username('admin')) {
            $this->User_model->insert(array(
                'username'   => 'admin',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'name'       => 'Administrator',
                'created_at' => date('Y-m-d H:i:s'),
            ));
        }

        if ($this->db->count_all('categories') === 0) {
            $cats = array(
                array('name' => 'Fiction',    'description' => 'Novels and short stories'),
                array('name' => 'Science',    'description' => 'Physics, Chemistry and Biology'),
                array('name' => 'Computers',  'description' => 'Programming and Information Technology'),
                array('name' => 'History',    'description' => 'Historical texts and biographies'),
            );
            foreach ($cats as &$c) {
                $c['created_at'] = date('Y-m-d H:i:s');
            }
            $this->db->insert_batch('categories', $cats);
        }

        if ($this->db->count_all('books') === 0) {
            $books = array(
                array('title' => 'The Pragmatic Programmer', 'author' => 'Andrew Hunt',        'isbn' => '9780201616224', 'publisher' => 'Addison-Wesley', 'year' => 1999, 'category_id' => 3, 'total_copies' => 5, 'available_copies' => 5),
                array('title' => 'Clean Code',               'author' => 'Robert C. Martin',   'isbn' => '9780132350884', 'publisher' => 'Prentice Hall', 'year' => 2008, 'category_id' => 3, 'total_copies' => 4, 'available_copies' => 4),
                array('title' => 'A Brief History of Time',  'author' => 'Stephen Hawking',    'isbn' => '9780553380163', 'publisher' => 'Bantam',        'year' => 1988, 'category_id' => 2, 'total_copies' => 3, 'available_copies' => 3),
                array('title' => 'The Alchemist',            'author' => 'Paulo Coelho',       'isbn' => '9780061122415', 'publisher' => 'HarperOne',     'year' => 1988, 'category_id' => 1, 'total_copies' => 6, 'available_copies' => 6),
            );
            foreach ($books as &$b) {
                $b['created_at'] = date('Y-m-d H:i:s');
            }
            $this->db->insert_batch('books', $books);
        }

        if ($this->db->count_all('members') === 0) {
            $members = array(
                array('name' => 'John Doe',    'email' => 'john@example.com',  'phone' => '9876543210', 'address' => '123 Main St',  'membership_date' => date('Y-m-d'), 'status' => 'active'),
                array('name' => 'Jane Smith',  'email' => 'jane@example.com',  'phone' => '9876501234', 'address' => '456 Oak Ave',  'membership_date' => date('Y-m-d'), 'status' => 'active'),
            );
            foreach ($members as &$m) {
                $m['created_at'] = date('Y-m-d H:i:s');
            }
            $this->db->insert_batch('members', $members);
        }
    }
}
