<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model');
    }

    public function index(): void
    {
        $search = $this->input->get('search', TRUE);
        $members = $this->Member_model->get_all($search ?: '');
        foreach ($members as &$m) {
            $m->active = $this->Member_model->active_issues($m->id);
        }
        $data = array('members' => $members, 'search' => $search);
        $this->view('members/index', $data);
    }

    public function create(): void
    {
        $data = array('member' => NULL);
        $this->_form($data);
    }

    public function edit(?int $id = NULL): void
    {
        $member = $this->Member_model->get($id);
        if (!$member) {
            show_404();
        }
        $data = array('member' => $member);
        $this->_form($data);
    }

    private function _form(array $data): void
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'valid_email');

            if ($this->form_validation->run()) {
                $id = $this->input->post('id');
                $fields = array(
                    'name'            => $this->input->post('name', TRUE),
                    'email'           => $this->input->post('email', TRUE),
                    'phone'           => $this->input->post('phone', TRUE),
                    'address'         => $this->input->post('address', TRUE),
                    'membership_date' => $this->input->post('membership_date', TRUE) ?: NULL,
                    'status'          => $this->input->post('status', TRUE) ?: 'active',
                );

                if ($id) {
                    $this->Member_model->update($id, $fields);
                    $this->flash('success', 'Member updated successfully.');
                } else {
                    $fields['created_at'] = date('Y-m-d H:i:s');
                    $this->Member_model->insert($fields);
                    $this->flash('success', 'Member added successfully.');
                }
                redirect('members');
            }
        }

        $this->view('members/form', $data);
    }

    public function delete(?int $id = NULL): void
    {
        if ($this->Member_model->active_issues($id) > 0) {
            $this->flash('danger', 'Cannot delete a member with books still issued.');
        } else {
            $this->Member_model->delete($id);
            $this->flash('success', 'Member deleted successfully.');
        }
        redirect('members');
    }
}
