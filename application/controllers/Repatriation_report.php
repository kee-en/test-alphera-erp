<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Repatriation_report extends CI_Controller
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
            'author' => "Alphera Marine Services, Inc.",
            'title_tag' => "Dashboard | Alphera Marine Services, Inc.",
            'meta_description' => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/repatriation_report');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function generate_crew_gen_report()
    {
        if ($this->input->post('gen_month_filter') != null) {
            $duration = $this->input->post('gen_month_filter');
        }else{
            $duration = $this->input->post('gen_year_filter');
        }
        $type = $this->input->post('gen_filter_type');
        $dur_type = $this->input->post('gen_filter_duration');
        $vsl_type = $this->input->post('gen_filter_vsl_type');
        $remarks = $this->input->post('gen_type_remarks');
        $data = "";
        $result = "";
        
        if ($type == 1) {
            $result = $this->gen_crew_report->total_crew_onboard($dur_type, $duration, $vsl_type);
            $comparative = $this->gen_crew_report->compara_total_crew_onboard($dur_type, $duration, $vsl_type);
        }else if($type == 2){
            $result = $this->gen_crew_report->total_crew_deployed($dur_type, $duration);
            $comparative = $this->gen_crew_report->compara_total_crew_deployed($dur_type, $duration);
        }else if($type == 3){
            $result = $this->gen_crew_report->total_new_hire_deployed($dur_type, $duration);
            $comparative = $this->gen_crew_report->compara_total_new_hire_deployed($dur_type, $duration);
        }else if($type == 4){
            $result = $this->gen_crew_report->total_ex_crew_deployed($dur_type, $duration);
            $comparative = $this->gen_crew_report->compara_total_ex_crew_deployed($dur_type, $duration);
        }else if($type == 5){
            $result = $this->gen_crew_report->total_crew_finished_contract($dur_type, $duration);
            $comparative = $this->gen_crew_report->compara_crew_finished_contract($dur_type, $duration);
        }else if($type == 6){
            $result = $this->gen_crew_report->total_crew_with_illness($dur_type, $duration);
            $comparative = $this->gen_crew_report->compara_crew_with_illness($dur_type, $duration);
        }else if($type == 7){
            $result = $this->gen_crew_report->total_crew_with_injury($dur_type, $duration);
            $comparative = $this->gen_crew_report->compara_crew_with_injury($dur_type, $duration);
        }else if($type == 8){
            $result = $this->gen_crew_report->total_crew_with_disciplinary($dur_type, $duration);
            $comparative = $this->gen_crew_report->compara_crew_with_disciplinary($dur_type, $duration);
        }else if($type == 9){
            $result = $this->gen_crew_report->total_crew_own_request($dur_type, $duration);
            $comparative = $this->gen_crew_report->compara_crew_own_request($dur_type, $duration);
        }else if($type == 10){
            $result = $this->gen_crew_report->total_crew_jumpship($dur_type, $duration);
            $comparative = $this->gen_crew_report->compara_crew_jumpship($dur_type, $duration);
        }else if($type == 11){
            $result = $this->gen_crew_report->total_crew_casualty_cases($dur_type, $duration, $remarks);
            $comparative = $this->gen_crew_report->compara_crew_casualty_cases($dur_type, $duration, $remarks);
        }else if($type == 12){
            $result = $this->gen_crew_report->total_crew_vessel_reduction($dur_type, $duration, $remarks);
            $comparative = $this->gen_crew_report->compara_crew_vessel_reduction($dur_type, $duration, $remarks);
        }

        if ($result) {
            $data = [
                'count' => $result,
                'comparative_count' => $comparative
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}