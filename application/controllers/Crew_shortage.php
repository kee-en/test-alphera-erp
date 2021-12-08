<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crew_shortage extends CI_Controller
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
        $result = $this->global->getCrewShortage();

        $data['author'] = "Alphera Marine Services, Inc.";
        $data['title_tag'] = "Crew Shortage Report | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";
        $data['crew_data'] = $result;

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/crew_shortage');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }
}