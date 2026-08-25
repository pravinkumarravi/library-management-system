<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends App_Model
{
    protected $table = 'notifications';

    /**
     * Create a notification for a single user.
     */
    public function create_for_user(int|string $user_id, string $type, string $title, string $message, string $link = '', ?string $reference = null): int
    {
        return $this->insert(array(
            'user_id'    => $user_id,
            'type'       => $type,
            'title'      => $title,
            'message'    => $message,
            'link'       => $link,
            'reference'  => $reference,
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ));
    }

    /**
     * Broadcast an event notification to every user (multi-user ready).
     */
    public function broadcast(string $type, string $title, string $message, string $link = ''): void
    {
        $users = $this->db->select('id')->get('users')->result();
        foreach ($users as $user) {
            $this->create_for_user($user->id, $type, $title, $message, $link);
        }
    }

    /**
     * Broadcast once per (user, reference). Used for periodic/one-shot alerts.
     */
    public function broadcast_once(string $type, string $title, string $message, string $link = '', ?string $reference = null): void
    {
        $users = $this->db->select('id')->get('users')->result();
        foreach ($users as $user) {
            $this->create_once($user->id, $type, $title, $message, $link, $reference);
        }
    }

    /**
     * Create a notification for a user only if the (user, reference) pair is new.
     */
    public function create_once(int|string $user_id, string $type, string $title, string $message, string $link = '', ?string $reference = null): void
    {
        if ($reference !== null) {
            $exists = $this->db->where('user_id', $user_id)
                ->where('reference', $reference)
                ->count_all_results($this->table) > 0;
            if ($exists) {
                return;
            }
        }
        $this->create_for_user($user_id, $type, $title, $message, $link, $reference);
    }

    public function unread_count(int|string $user_id): int
    {
        return $this->db->where('user_id', $user_id)
            ->where('is_read', 0)
            ->count_all_results($this->table);
    }

    /**
     * @return array<int, object>
     */
    public function recent(int|string $user_id, int $limit = 5): array
    {
        return $this->db->where('user_id', $user_id)
            ->order_by('created_at', 'DESC')
            ->limit($limit)
            ->get($this->table)
            ->result();
    }

    /**
     * @return array<int, object>
     */
    public function all_for_user(int|string $user_id): array
    {
        return $this->db->where('user_id', $user_id)
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function mark_read(int|string $id, int|string $user_id): bool
    {
        return $this->db->update($this->table, array('is_read' => 1), array('id' => $id, 'user_id' => $user_id));
    }

    public function mark_all_read(int|string $user_id): bool
    {
        return $this->db->update($this->table, array('is_read' => 1), array('user_id' => $user_id, 'is_read' => 0));
    }

    /**
     * Daily sweep run on page load: notifies the librarian about overdue books
     * and books due within the next $due_soon_days days. Deduplicated via
     * the (user_id, reference) unique index.
     */
    public function sweep_due_and_overdue(int|string $user_id, int $due_soon_days = 3): void
    {
        $today  = date('Y-m-d');
        $cutoff = date('Y-m-d', strtotime("+{$due_soon_days} days"));

        // Books already past their due date.
        $this->db->select('issues.*, books.title AS book_title, members.name AS member_name');
        $this->db->from('issues');
        $this->db->join('books', 'books.id = issues.book_id', 'left');
        $this->db->join('members', 'members.id = issues.member_id', 'left');
        $this->db->where('issues.status', 'issued');
        $this->db->where('issues.due_date <', $today);
        foreach ($this->db->get()->result() as $row) {
            $this->create_once(
                $user_id,
                'overdue',
                'Book overdue',
                "{$row->book_title} overdue since {$row->due_date} — {$row->member_name}",
                'issues/overdue',
                'overdue:' . $row->id
            );
        }

        // Books due within the next few days (skip ones already flagged overdue).
        $this->db->select('issues.*, books.title AS book_title, members.name AS member_name');
        $this->db->from('issues');
        $this->db->join('books', 'books.id = issues.book_id', 'left');
        $this->db->join('members', 'members.id = issues.member_id', 'left');
        $this->db->where('issues.status', 'issued');
        $this->db->where('issues.due_date >=', $today);
        $this->db->where('issues.due_date <=', $cutoff);
        foreach ($this->db->get()->result() as $row) {
            $already_overdue = $this->db->where('user_id', $user_id)
                ->where('reference', 'overdue:' . $row->id)
                ->count_all_results($this->table) > 0;
            if ($already_overdue) {
                continue;
            }
            $this->create_once(
                $user_id,
                'due_soon',
                'Due soon',
                "{$row->book_title} due on {$row->due_date} — {$row->member_name}",
                'issues',
                'due:' . $row->id
            );
        }
    }
}
