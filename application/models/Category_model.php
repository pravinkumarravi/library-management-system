<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends App_Model
{
    protected $table = 'categories';

    /**
     * @return array<int, object>
     */
    public function get_all(): array
    {
        $this->db->order_by('name', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function count_books(int|string $id): int
    {
        return $this->db->where('category_id', $id)->count_all_results('books');
    }
}
