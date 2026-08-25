<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends App_Controller
{
    public function index(): void
    {
        $this->load->model(array('Book_model', 'Category_model', 'Member_model', 'Issue_model'));

        list($total_copies, $available_copies) = $this->Book_model->sum_copies();
        $total_books   = $this->Book_model->count();
        $total_issues  = $this->Issue_model->count();
        $issued        = $this->Issue_model->count_active();
        $returned      = $this->Issue_model->count(array('status' => 'returned'));
        $overdue       = $this->Issue_model->count_overdue();
        $monthly       = $this->Issue_model->count_by_month();
        $monthly_data  = $monthly['data'];

        $data = array(
            'total_books'        => $total_books,
            'total_copies'       => $total_copies,
            'available_copies'   => $available_copies,
            'total_members'      => $this->Member_model->count(),
            'total_categories'   => $this->Category_model->count(),
            'total_issues'       => $total_issues,
            'issued'             => $issued,
            'returned'           => $returned,
            'overdue'            => $overdue,
            'issued_this_month'  => end($monthly_data),
            'availability_pct'   => $total_copies > 0 ? (int) round($available_copies / $total_copies * 100) : 0,
            'monthly_labels'     => $monthly['labels'],
            'monthly_data'       => $monthly_data,
            'category_stats'     => $this->Book_model->count_by_category(),
            'recent_issues'      => array_slice($this->Issue_model->get_history(), 0, 6),
        );

        view('dashboard/index', $data);
    }
}
