<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vessel_report extends CI_Controller
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
            'title_tag' => "Vessels Report | Alphera Marine Services, Inc.",
            'meta_description' => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/vessel_report');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_vessel_report()
    {
        $filters = [];
        $filters['search']['vsl_type'] = $this->input->post('filter_vsl_type');
        $filters['search']['filter_type'] = $this->input->post('vsl_filter_type');
        $filters['search']['vsl_reduction_type'] = $this->input->post('filter_reduction_type');

        $result = $this->manage_vessel->get_vessels_report($filters);
        $compara_result = $this->manage_vessel->get_compara_vessels_report($filters);

        $data = [
            'vessel_count' => $result['vessel_count'],
            'comparative_count' => $compara_result['comp_vessel_count']
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}