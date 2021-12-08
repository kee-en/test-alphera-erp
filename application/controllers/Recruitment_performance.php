<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recruitment_performance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }
    }

    public function index()
    {
        $data = [
            'applied'=> $this->applicant_passed->get_count_per_rank(),
            'passed' => $this->applicant_passed->get_total_passed_per_rank(),
            'failed' => $this->applicant_failed->get_rank_failed_count(),
            'all_applicants' => $this->applicant_failed->get_all_applicants_performance(),
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Crew Management Plan (Summary) | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/recruitment_performance');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    // echo '<pre>';
    // print_r($data['recruitment']);
    // echo '</pre>';
}