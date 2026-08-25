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

    public function __construct()
    {
        parent::__construct();

        if ($this->require_auth && !$this->session->userdata('user')) {
            redirect('auth/login');
        }
    }

    /**
     * Render a Blade template and send it to the browser.
     */
    protected function view(string $view, array $data = array()): void
    {
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
           