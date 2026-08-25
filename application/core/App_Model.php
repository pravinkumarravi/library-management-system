<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base model for the application.
 *
 * Provides reusable CRUD helpers driven by the $table (and optional
 * $primary_key) properties. Subclasses set $table and may add or
 * override methods as needed.
 */
class App_Model extends CI_Model
{
    /** @var string Database table for this model. Set in subclasses. */
    protected $table;

    /** @var string Primary key column name. */
    protected $primary_key = 'id';

    /**
     * Fetch a single row by primary key.
     */
    public function get(int|string $id): ?object
    {
        return $this->db->get_where($this->table, array($this->primary_key => $id))->row();
    }

    /**
     * Fetch rows matching the given where clause (optional).
     *
     * @return array<int, object>
     */
    public function get_where(array $where = array(), ?int $limit = null, int $offset = 0): array
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get($this->table)->result();
    }

    /**
     * Fetch the first row matching the given where clause.
     */
    public function find(array $where = array()): ?object
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        return $this->db->get($this->table)->row();
    }

    /**
     * Fetch all rows from the table.
     *
     * @return array<int, object>
     */
    public function get_all(): array
    {
        return $this->db->get($this->table)->result();
    }

    /**
     * Insert a new row and return the new primary key id.
     */
    public function insert(array $data): int
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update a row by primary key.
     */
    public function update(int|string $id, array $data): bool
    {
        return $this->db->update($this->table, $data, array($this->primary_key => $id));
    }

    /**
     * Update rows matching the given where clause.
     */
    public function update_where(array $where, array $data): bool
    {
        return $this->db->update($this->table, $data, $where);
    }

    /**
     * Delete a row by primary key.
     */
    public function delete(int|string $id): bool
    {
        return $this->db->delete($this->table, array($this->primary_key => $id));
    }

    /**
     * Delete rows matching the given where clause.
     */
    public function delete_where(array $where): bool
    {
        return $this->db->delete($this->table, $where);
    }

    /**
     * Count all rows (optionally filtered).
     */
    public function count(array $where = array()): int
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        return $this->db->count_all_results($this->table);
    }

    /**
     * Insert when $id is null, otherwise update. Returns the id.
     */
    public function save(array $data, int|string|null $id = null): int
    {
        if ($id) {
            $this->update($id, $data);
            return (int) $id;
        }
        return $this->insert($data);
    }
}
