<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warning_letter_report extends CI_Controller
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
        $this->load->view('reports/warning_letter_report');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_warning_letter_report()
    {
        $data = [];
        $filters = [];

        $filters['search']['reasons'] = $this->input->post('acwl_reason');
        $filters['search']['crew-type'] = $this->input->post('acwl_crew_type');
        
        for ($i = 0; $i <= 6; $i++) {
            $date = date('Y', strtotime('-'.$i.' year'));
            $result = $this->gen_crew_report->get_warning_letter_report($date, $filters);
            $data['show_result'.$i] = $result;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}