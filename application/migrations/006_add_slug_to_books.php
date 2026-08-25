<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_slug_to_books extends CI_Migration
{
    public function up(): void
    {
        $this->dbforge->add_column('books', array(
            'slug' => array(
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
            ),
        ));

        // Unique index on slug (SQLite allows multiple NULLs, so the index is safe).
        $this->db->query('CREATE UNIQUE INDEX uq_books_slug ON books (slug)');

        // Backfill existing books with generated unique slugs.
        $this->load->model('Book_model');
        $books = $this->db->order_by('id', 'ASC')->get('books')->result();
        foreach ($books as $book) {
            $slug = $this->Book_model->generate_unique_slug($book->title, $book->author, $book->year, $book->id);
            $this->db->update('books', array('slug' => $slug), array('id' => $book->id));
        }
    }

    public function down(): void
    {
        // SQLite 3.35+ supports DROP COLUMN; older versions will fail gracefully.
        $this->dbforge->drop_column('books', 'slug');
    }
}
