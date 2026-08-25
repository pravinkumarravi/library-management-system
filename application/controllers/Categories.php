<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Category_model');
    }

    public function index(): void
    {
        $categories = $this->Category_model->get_all();
        foreach ($categories as &$c) {
            $c->book_count = $this->Category_model->count_books($c->id);
        }
        $data = array('categories' => $categories);
        view('categories/index', $data);
    }

    public function create(): void
    {
        $data = array('category' => NULL);
        $this->_form($data);
    }

    public function edit(?int $id = NULL): void
    {
        $category = $this->Category_model->get($id);
        if (!$category) {
            show_404();
        }
        $data = array('category' => $category);
        $this->_form($data);
    }

    private function _form(array $data): void
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required');

            if ($this->form_validation->run()) {
                $id = $this->input->post('id');
                $fields = array(
                    'name'        => $this->input->post('name', TRUE),
                    'description' => $this->input->post('description', TRUE),
                );

                if ($id) {
                    $this->Category_model->update($id, $fields);
                    flash('success', 'Category updated successfully.');
                } else {
                    $fields['created_at'] = date('Y-m-d H:i:s');
                    $this->Category_model->insert($fields);
                    flash('success', 'Category added successfully.');
                }
                redirect('categories');
            }
        }

        view('categories/form', $data);
    }

    public function delete(?int $id = NULL): void
    {
        if ($this->Category_model->count_books($id) > 0) {
            flash('danger', 'Cannot delete a category that still has books.');
        } else {
            $this->Category_model->delete($id);
            flash('success', 'Category deleted successfully.');
        }
        redirect('categories');
    }
}
