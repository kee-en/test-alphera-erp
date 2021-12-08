<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Illness_injury_report extends CI_Controller
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
        $this->load->view('reports/illness_injury_rate');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_illness_injury_rate()
    {
        $filters = [];

        $filters['search']['reasons'] = $this->input->post('brk_reasons');
        $filters['search']['crew-type'] = $this->input->post('brk_crew_type');
        $filters['search']['month_from'] = $this->input->post('brk_month_from');
        $filters['search']['month_to'] = $this->input->post('brk_month_to');
        
        $result = $this->gen_crew_report->injury_illness_rate($filters);
        $total_ii_count = count($this->warning_letter->get_total_illness_injury());
        $total_embark = count($this->embark->getCrewEmbarked());
        
        $quotient = $total_ii_count / $total_embark;
        $difference = 100 - $quotient;
        $getTotalRate = $difference * 5;
        $output = number_format($getTotalRate/100,2);

        $data = [
            'total_rate' => intval($output),
            'filtered_result' => $result
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}