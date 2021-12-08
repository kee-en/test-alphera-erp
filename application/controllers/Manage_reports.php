<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }
    }
    
    public function cmp_summary()
    {
        $data = [
                "cmp_logs" => $this->m_backup_db->get_cmp_report_logs("Crew Management Plan (Summary)"),
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Crew Management Plan (Summary) | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/cmp_summary');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function crew_daily_departure()
    {
        $data = [
                "cmp_logs" => $this->m_backup_db->get_cmp_report_logs("Crew Daily Departure"),
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Crew Daily Departure | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/crew_daily_departure');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function us_visa()
    {
        $data = [
                "us_logs" => $this->m_backup_db->get_cmp_report_logs("US VISA STATUS"),
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "US Visa Status | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/us_visa');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function prejoining_monitoring()
    {
        $data = [
                "prejoining_logs" => $this->m_backup_db->get_cmp_report_logs("Prejoining"),
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Prejoining Monitoring | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/prejoining_monitoring');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function on_off_signers()
    {
        $data = [
                "onoff_logs" => $this->m_backup_db->get_cmp_report_logs("ON_OFF Signer"),
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Manage Users | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/on_off_signers');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function panama_monitoring()
    {
        $data = [
                "panama_logs" => $this->m_backup_db->get_cmp_report_logs("PANAMA Monitoring"),
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Manage Users | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/panama_monitoring');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function marshall_monitoring()
    {
        $data = [
                "marshall_logs" => $this->m_backup_db->get_cmp_report_logs("MARSHALL Monitoring"),
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Manage Users | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/marshall_monitoring');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function medical_monitoring()
    {
        $data = [
                "medical_logs" => $this->m_backup_db->get_cmp_report_logs("MEDICAL MONITORING"),
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Manage Users | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/medical_monitoring');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }
}
