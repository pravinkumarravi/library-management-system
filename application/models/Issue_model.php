<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issue_model extends App_Model
{
    protected $table = 'issues';

    public function issue(array $data): int
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function return_book(int|string $id, array $data): bool
    {
        return $this->db->update($this->table, $data, array('id' => $id));
    }

    /**
     * @return array<int, object>
     */
    public function get_active(): array
    {
        $this->db->select('issues.*, books.title AS book_title, books.author AS book_author, members.name AS member_name, members.email AS member_email');
        $this->db->from('issues');
        $this->db->join('books', 'books.id = issues.book_id');
        $this->db->join('members', 'members.id = issues.member_id');
        $this->db->where('issues.status', 'issued');
        $this->db->order_by('issues.due_date', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * @return array<int, object>
     */
    public function get_overdue(?string $today = null): array
    {
        $today = $today ?: date('Y-m-d');
        $this->db->select('issues.*, books.title AS book_title, books.author AS book_author, members.name AS member_name, members.email AS member_email');
        $this->db->from('issues');
        $this->db->join('books', 'books.id = issues.book_id');
        $this->db->join('members', 'members.id = issues.member_id');
        $this->db->where('issues.status', 'issued');
        $this->db->where('issues.due_date <', $today);
        $this->db->order_by('issues.due_date', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * @return array<int, object>
     */
    public function get_history(): array
    {
        $this->db->select('issues.*, books.title AS book_title, books.author AS book_author, members.name AS member_name');
        $this->db->from('issues');
        $this->db->join('books', 'books.id = issues.book_id');
        $this->db->join('members', 'members.id = issues.member_id');
        $this->db->order_by('issues.issue_date', 'DESC');
        return $this->db->get()->result();
    }

    public function get(int|string $id): ?object
    {
        $this->db->select('issues.*, books.title AS book_title, books.author AS book_author, members.name AS member_name, members.email AS member_email');
        $this->db->from('issues');
        $this->db->join('books', 'books.id = issues.book_id');
        $this->db->join('members', 'members.id = issues.member_id');
        $this->db->where('issues.id', $id);
        return $this->db->get()->row();
    }

    public function count_active(): int
    {
        return $this->db->where('status', 'issued')->count_all_results($this->table);
    }

    /**
     * Whether a member currently has an unreturned book.
     */
    public function has_active_issue(int|string $member_id): bool
    {
        return (bool) $this->db->where('member_id', $member_id)
            ->where('status', 'issued')
            ->count_all_results($this->table);
    }

    public function count_overdue(?string $today = null): int
    {
        $today = $today ?: date('Y-m-d');
        return $this->db->where('status', 'issued')
            ->where('due_date <', $today)
            ->count_all_results($this->table);
    }

    /**
     * Issues per month for the last $months months (portable across DB drivers).
     *
     * @return array{labels: array<int, string>, data: array<int, int>}
     */
    public function count_by_month(int $months = 12): array
    {
        $this->db->select('issue_date');
        $this->db->from($this->table);
        $this->db->where('issue_date IS NOT NULL');
        $rows = $this->db->get()->result();

        $labels = array();
        $counts = array_fill(0, $months, 0);
        $now = time();

        for ($i = $months - 1; $i >= 0; $i--) {
            $labels[] = date('M', strtotime("-$i months"));
        }

        foreach ($rows as $row) {
            $ts = strtotime($row->issue_date);
            $diff = ((int) date('Y', $now) - (int) date('Y', $ts)) * 12
                + ((int) date('n', $now) - (int) date('n', $ts));
            if ($diff >= 0 && $diff < $months) {
                $counts[$months - 1 - $diff]++;
            }
        }

        return array('labels' => $labels, 'data' => $counts);
    }
}
