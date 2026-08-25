<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book_model extends App_Model
{
    protected $table = 'books';

    /**
     * @return array<int, object>
     */
    public function get_all(string $search = ''): array
    {
        $this->db->select('books.*, categories.name AS category_name');
        $this->db->from('books');
        $this->db->join('categories', 'categories.id = books.category_id', 'left');

        if ($search !== '') {
            $this->db->group_start();
            $this->db->like('books.title', $search);
            $this->db->or_like('books.author', $search);
            $this->db->or_like('books.isbn', $search);
            $this->db->group_end();
        }

        $this->db->order_by('books.title', 'ASC');
        return $this->db->get()->result();
    }

    public function adjust_copies(int|string $id, int $delta): bool
    {
        $this->db->set('available_copies', "available_copies + {$delta}", FALSE);
        $this->db->where('id', $id);
        return $this->db->update($this->table);
    }

    public function is_available(int|string $id): bool
    {
        $book = $this->get($id);
        return $book && (int) $book->available_copies > 0;
    }

    /**
     * Total and available copy sums across all books.
     *
     * @return array{0: int, 1: int} [total_copies, available_copies]
     */
    public function sum_copies(): array
    {
        $this->db->select('COALESCE(SUM(total_copies), 0) AS total_copies, COALESCE(SUM(available_copies), 0) AS available_copies');
        $row = $this->db->get($this->table)->row();
        return array((int) $row->total_copies, (int) $row->available_copies);
    }

    /**
     * Number of books per category, most populated first.
     *
     * @return array<int, object>
     */
    public function count_by_category(int $limit = 6): array
    {
        $this->db->select('COALESCE(categories.name, "Uncategorized") AS name, COUNT(books.id) AS total');
        $this->db->from('books');
        $this->db->join('categories', 'categories.id = books.category_id', 'left');
        $this->db->group_by('books.category_id');
        $this->db->order_by('total', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
