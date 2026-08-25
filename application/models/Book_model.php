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

    /**
     * Convert text into a URL-friendly slug.
     */
    public function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');
        return $text === '' ? 'book' : $text;
    }

    /**
     * Whether a slug already exists in the table (optionally excluding a book).
     */
    public function slug_exists(string $slug, int|string|null $exclude_id = null): bool
    {
        $this->db->where('slug', $slug);
        if ($exclude_id !== null) {
            $this->db->where('id !=', $exclude_id);
        }
        return (bool) $this->db->count_all_results($this->table);
    }

    /**
     * Generate a unique slug for a book.
     *
     * Tries, in order:
     *   1. book-name
     *   2. book-name-author
     *   3. book-name-author-year
     *   4. book-name-author-year-1, -2, ...
     *
     * @param int|string|null $exclude_id Book id to ignore (when editing).
     */
    public function generate_unique_slug(string $title, string $author = '', ?int $year = null, int|string|null $exclude_id = null): string
    {
        $base    = $this->slugify($title);
        $author  = $this->slugify($author);
        $year    = $year ? (int) $year : null;
        $candidates = array($base);

        if ($author !== '') {
            $candidates[] = $base . '-' . $author;
            if ($year) {
                $candidates[] = $base . '-' . $author . '-' . $year;
            }
        } elseif ($year) {
            $candidates[] = $base . '-' . $year;
        }

        foreach ($candidates as $candidate) {
            if (!$this->slug_exists($candidate, $exclude_id)) {
                return $candidate;
            }
        }

        $slug = end($candidates);
        $i    = 1;
        while ($this->slug_exists($slug . '-' . $i, $exclude_id)) {
            $i++;
        }
        return $slug . '-' . $i;
    }
}
