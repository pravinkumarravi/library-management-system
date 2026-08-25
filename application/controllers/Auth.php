<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login(): void
    {
        if ($this->session->userdata('user')) {
            redirect('dashboard');
        }

        $data = array('error' => NULL);

        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run()) {
                $user = $this->User_model->verify(
                    $this->input->post('username', TRUE),
                    $this->input->post('password')
                );

                if ($user) {
                    $this->session->set_userdata('user', array(
                        'id'       => $user->id,
                        'username' => $user->username,
                        'name'     => $user->name,
                    ));
                    redirect('dashboard');
                }

                $data['error'] = 'Invalid username or password.';
            }
        }

        echo $this->blade->view('auth/login', $data);
    }

    public function logout(): void
    {
        $this->session->unset_userdata('user');
        redirect('auth/login');
    }
}
