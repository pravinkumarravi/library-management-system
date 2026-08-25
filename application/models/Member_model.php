<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends App_Model
{
    protected $table = 'members';

    /**
     * @return array<int, object>
     */
    public function get_all(string $search = ''): array
    {
        $this->db->from('members');

        if ($search !== '') {
            $this->db->group_start();
            $this->db->like('members.name', $search);
            $this->db->or_like('members.email', $search);
            $this->db->or_like('members.phone', $search);
            $this->db->group_end();
        }

        $this->db->order_by('members.name', 'ASC');
        return $this->db->get()->result();
    }

    public function active_issues(int|string $id): int
    {
        return $this->db->where('member_id', $id)
            ->where('status', 'issued')
            ->count_all_results('issues');
    }
}
