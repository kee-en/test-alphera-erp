<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crew_grade_report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }
    }

    public function index()
    {
        $data = [
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Crew Grade Report | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/grade_report');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_crew_grade_report()
    {
        $filters = [];
        $compara_result = "";

        $filters['search']['rank'] = $this->input->post('grade_rank');
        $filters['search']['crew_type'] = $this->input->post('grade_crew_type');
        $filters['search']['month_to'] = $this->input->post('grade_month_to');
        $filters['search']['month_from'] = $this->input->post('grade_month_from');
        
        $result = $this->crew_grade_report->get_crew_grade_report($filters);

        if (!empty($filters['search']['month_to']) && !empty($filters['search']['month_from'])) {
            $compara_result = $this->crew_grade_report->get_crew_grade_report_compara($filters);
        }
        

        $data = [
            'main_count' => $result,
            'compara_count' => $compara_result
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}