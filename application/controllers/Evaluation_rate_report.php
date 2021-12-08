<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Evaluation_rate_report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->perPage = 30;
    }

    public function index()
    {
        $ex_crew = $this->evaluation_sheet_form->get_evaluation_count();
        $new_crew = $this->evaluation_sheet_form->get_evaluation_count_ncrew();

        $data['author'] = "Alphera Marine Services, Inc.";
        $data['title_tag'] = "Evaluation Rate Report | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";
        $data['ex_crew'] = $ex_crew;
        $data['new_crew'] = $new_crew;

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/evaluation_rate_report');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }
}