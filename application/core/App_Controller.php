<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base controller for the application.
 *
 * Provides shared rendering helpers and guards authenticated areas.
 * Controllers that need authentication extend this class; the Auth
 * controller extends CI_Controller directly to avoid a redirect loop.
 */
class App_Controller extends CI_Controller
{
    /** Whether the controller requires a logged-in user. */
    protected $require_auth = TRUE;

    /** Unread notification count for the header bell. */
    protected $unread_notifications = 0;

    /** Latest notifications for the header bell dropdown. */
    protected $recent_notifications = array();

    public function __construct()
    {
        parent::__construct();

        if ($this->require_auth && !$this->session->userdata('user')) {
            redirect('auth/login');
        }

        $this->load->model('Notification_model');
        $user = $this->session->userdata('user');
        if ($user) {
            $this->Notification_model->sweep_due_and_overdue($user['id']);
            $this->unread_notifications = $this->Notification_model->unread_count($user['id']);
            $this->recent_notifications = $this->Notification_model->recent($user['id']);
        }
    }

    /**
     * Render a Blade template and send it to the browser.
     */
    protected function view(string $view, array $data = array()): void
    {
        $data['unread_notifications'] = $this->unread_notifications;
        $data['recent_notifications'] = $this->recent_notifications;
        echo $this->blade->view($view, $data);
    }

    /**
     * Queue a flash message rendered by the layout.
     */
    protected function flash(string $type, string $text): void
    {
        $this->session->set_flashdata('message', array(
            'type' => $type,
            'text' => $text,
        ));
    }
}
           