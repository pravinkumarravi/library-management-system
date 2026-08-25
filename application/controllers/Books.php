<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Book_model', 'Category_model', 'Issue_model'));
    }

    public function index(): void
    {
        $search = $this->input->get('search', TRUE);
        $data = array(
            'books'   => $this->Book_model->get_all($search ?: ''),
            'search'  => $search,
        );
        $this->view('books/index', $data);
    }

    public function create(): void
    {
        $data = array(
            'categories' => $this->Category_model->get_all(),
            'book'       => NULL,
        );
        $this->_form($data);
    }

    public function edit(?int $id = NULL): void
    {
        $book = $this->Book_model->get($id);
        if (!$book) {
            show_404();
        }
        $data = array(
            'categories' => $this->Category_model->get_all(),
            'book'       => $book,
        );
        $this->_form($data);
    }

    /**
     * Book details page (/books/<slug>) with who has taken this book.
     */
    public function show(string $slug): void
    {
        $book = $this->Book_model->find(array('slug' => $slug));
        if (!$book) {
            show_404();
        }
        $category = $book->category_id ? $this->Category_model->get($book->category_id) : null;
        $data = array(
            'book'     => $book,
            'category' => $category ? $category->name : null,
            'taken_by' => $this->Issue_model->get_by_book($book->id),
        );
        $this->view('books/view', $data);
    }

    private function _form(array $data): void
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('author', 'Author', 'required');
            $this->form_validation->set_rules('total_copies', 'Total Copies', 'required|integer|greater_than[0]');

            if ($this->form_validation->run()) {
                $id    = $this->input->post('id');
                $total = (int) $this->input->post('total_copies');

                $fields = array(
                    'title'           => $this->input->post('title', TRUE),
                    'author'          => $this->input->post('author', TRUE),
                    'isbn'            => $this->input->post('isbn', TRUE),
                    'publisher'       => $this->input->post('publisher', TRUE),
                    'year'            => (int) $this->input->post('year') ?: NULL,
                    'category_id'     => (int) $this->input->post('category_id') ?: NULL,
                    'total_copies'    => $total,
                );

                $fields['slug'] = $this->Book_model->generate_unique_slug(
                    $fields['title'],
                    $fields['author'],
                    $fields['year'],
                    $id // null on create; current id on edit so its own slug is ignored
                );

                if ($id) {
                    $existing   = $this->Book_model->get($id);
                    $diff       = $total - (int) $existing->total_copies;
                    $available  = (int) $existing->available_copies + $diff;
                    if ($available < 0) {
                        $available = 0;
                    }
                    $fields['available_copies'] = $available;
                    $this->Book_model->update($id, $fields);
                    $this->flash('success', 'Book updated successfully.');
                } else {
                    $fields['available_copies'] = $total;
                    $fields['created_at']        = date('Y-m-d H:i:s');
                    $this->Book_model->insert($fields);
                    $this->flash('success', 'Book added successfully.');
                }
                redirect('books');
            }
        }

        $this->view('books/form', $data);
    }

    public function delete(?int $id = NULL): void
    {
        $this->Book_model->delete($id);
        $this->flash('success', 'Book deleted successfully.');
        redirect('books');
    }
}
