<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends App_Model
{
    protected $table = 'users';

    public function get_by_username(string $username): ?object
    {
        return $this->db->get_where($this->table, array('username' => $username))->row();
    }

    public function verify(string $username, string $password): object|false
    {
        $user = $this->get_by_username($username);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return FALSE;
    }
}
