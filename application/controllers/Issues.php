<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issues extends App_Controller
{
    const FINE_PER_DAY = 5;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Issue_model', 'Book_model', 'Member_model'));
    }

    public function index(): void
    {
        $data = array('issues' => $this->Issue_model->get_active());
        $this->view('issues/index', $data);
    }

    public function overdue(): void
    {
        $data = array('issues' => $this->Issue_model->get_overdue());
        $this->view('issues/overdue', $data);
    }

    public function history(): void
    {
        $data = array('issues' => $this->Issue_model->get_history());
        $this->view('issues/history', $data);
    }

    public function issue(): void
    {
        $active_ids = array();
        foreach ($this->Issue_model->get_active() as $row) {
            $active_ids[$row->member_id] = true;
        }

        $data = array(
            'members'         => $this->Member_model->get_all(),
            'books'           => $this->Book_model->get_all(),
            'busy_member_ids' => $active_ids,
        );

        if ($this->input->post()) {
            $this->form_validation->set_rules('book_id', 'Book', 'required');
            $this->form_validation->set_rules('member_id', 'Member', 'required');
            $this->form_validation->set_rules('due_date', 'Due Date', 'required');

            if ($this->form_validation->run()) {
                $book_id   = (int) $this->input->post('book_id');
                $member_id = (int) $this->input->post('member_id');
                $due_date  = $this->input->post('due_date', TRUE);

                if (!$this->Book_model->is_available($book_id)) {
                    $this->flash('danger', 'This book is not available for issue.');
                    redirect('issues/issue');
                }

                if ($this->Issue_model->has_active_issue($member_id)) {
                    $this->flash('danger', 'This member already has an unreturned book. Return the previous book before issuing a new one.');
                    redirect('issues/issue');
                }

                $this->Issue_model->issue(array(
                    'book_id'    => $book_id,
                    'member_id'  => $member_id,
                    'issue_date' => date('Y-m-d'),
                    'due_date'   => $due_date,
                    'status'     => 'issued',
                    'fine'       => 0.00,
                    'created_at' => date('Y-m-d H:i:s'),
                ));
                $this->Book_model->adjust_copies($book_id, -1);
                $this->flash('success', 'Book issued successfully.');
                redirect('issues');
            }
        }

        $this->view('issues/issue', $data);
    }

    public function return_book(?int $id = NULL): void
    {
        $issue = $this->Issue_model->get($id);
        if (!$issue || $issue->status !== 'issued') {
            show_404();
        }

        $due   = new DateTime($issue->due_date);
        $today = new DateTime(date('Y-m-d'));
        $fine  = 0;
        if ($today > $due) {
            $fine = $today->diff($due)->days * self::FINE_PER_DAY;
        }

        $this->Issue_model->return_book($id, array(
            'return_date' => date('Y-m-d'),
            'status'      => 'returned',
            'fine'        => $fine,
        ));
        $this->Book_model->adjust_copies($issue->book_id, 1);

        $note = $fine > 0 ? ' Fine collected: ' . money($fine) : '';
        $this->flash('success', 'Book returned successfully.' . $note);
        redirect('issues');
    }
}
