<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends App_Controller
{
    public function index(): void
    {
        $user = $this->session->userdata('user');
        $data = array(
            'notifications' => $this->Notification_model->all_for_user($user['id']),
        );
        $this->view('notifications/index', $data);
    }

    /**
     * Open a notification: mark it read, then follow its target link.
     */
    public function read(?int $id = NULL): void
    {
        $user         = $this->session->userdata('user');
        $notification = $this->Notification_model->get($id);
        if ($notification && $notification->user_id == $user['id']) {
            $this->Notification_model->mark_read($id, $user['id']);
            redirect($notification->link ?: 'notifications');
        }
        redirect('notifications');
    }

    public function mark_all_read(): void
    {
        $user = $this->session->userdata('user');
        $this->Notification_model->mark_all_read($user['id']);
        $this->flash('success', 'All notifications marked as read.');
        redirect('notifications');
    }
}
