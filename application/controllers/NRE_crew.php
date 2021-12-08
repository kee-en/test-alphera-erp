<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NRE_crew extends CI_Controller
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

        $data = [];
        $conditions = [];

        $conditions['search']['name_search'] = $this->session->userdata('nre_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('nre_vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('nre_rank_search');

        if ($conditions) {
            $total_crew = count($this->nre_crew->getCrewNotForRehire($conditions));
        } else {
            $total_crew = count($this->nre_crew->getCrewNotForRehire());
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url('nre-crew');
        $config['use_page_numbers'] = true;
        $config['total_rows'] = $total_crew;
        $config['per_page'] = $this->perPage;
        $config['uri_segment'] = 2;
        $config['num_links'] = 3;
        $config['full_tag_open'] = '<div class="pagination pagination-sm">';
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript: void(0);" tabindex="-1">';
        $config['cur_tag_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = $this->uri->segment($config['uri_segment']);

        $offset = !$page ? 0 : (($this->perPage * $page) - $this->perPage);

        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        if (!empty($conditions)) {
            $data['crew'] = $this->nre_crew->getCrewNotForRehire($conditions);
        } else {
            $data['crew'] = $this->nre_crew->getCrewNotForRehire();
        }

        if ($conditions['start'] === 0) {
            $start_count = 1;
        } else {
            $start_count = $conditions['start'];
        }

        $end_count = ($conditions['start'] + count($data['crew']));

        $data['showing_entries'] = 'Showing ' . $start_count . ' to ' . $end_count . ' of ' . $config['total_rows'] . ' entries';
        $data['count_page'] = $page != 0 ? ($page * $this->perPage) - $this->perPage : 0;

        $data['author'] = "Alphera Marine Services, Inc.";
        $data['title_tag'] = "Not For Rehire Crew | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $data['search'] = [
            'name_search' => $this->session->userdata('nre_name_search'),
            'vessel_search' => $this->session->userdata('nre_vessel_search'),
            'rank_search' => $this->session->userdata('nre_rank_search'),
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/crew_filter');
        $this->load->view('modal/crew/contracts/v_contracts');
        $this->load->view('modal/crew/contracts/a_poea_contract');
        $this->load->view('modal/crew/contracts/a_mlc_contract');
        $this->load->view('modal/crew/contracts/e_poea_contract');
        $this->load->view('modal/crew/contracts/e_mlc_contract');
        $this->load->view('modal/crew/medical/v_medical');
        $this->load->view('modal/crew/medical/a_medical');
        $this->load->view('modal/crew/medical/e_medical');
        $this->load->view('modal/crew/v_prejoining_visa');
        $this->load->view('modal/crew/v_e_pre_joining_visa');
        $this->load->view('modal/crew/v_e_crew_info');
        $this->load->view('modal/crew/v_off_signer_info');
        $this->load->view('modal/global_vessel_history');
        $this->load->view('modal/crew/e_position_vessel');
        $this->load->view('crew/crew_list/nre_crew');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function nre_crew_search()
    {
        $cmp_search = $this->input->post('cf_crew_name');
        $cmp_search = strip_tags($cmp_search);

        $vessel_search = $this->input->post('cf_vessel_name');
        $vessel_search = strip_tags($vessel_search);

        $rank_search = $this->input->post('cf_rank_position');
        $rank_search = strip_tags($rank_search);


        if (!empty($cmp_search)) {
            $this->session->set_userdata('nre_name_search', $cmp_search);
        } else {
            $this->session->unset_userdata('nre_name_search');
        }

        if (!empty($vessel_search)) {
            $this->session->set_userdata('nre_vessel_search', $vessel_search);
        } else {
            $this->session->unset_userdata('nre_vessel_search');
        }

        if (!empty($rank_search)) {
            $this->session->set_userdata('nre_rank_search', $rank_search);
        } else {
            $this->session->unset_userdata('nre_rank_search');
        }
    }

    function nre_search_reset()
    {
        $this->session->unset_userdata('nre_name_search');
        $this->session->unset_userdata('nre_vessel_search');
        $this->session->unset_userdata('nre_rank_search');
    }

    public function get_nre_report()
    {
        $toc_filter = [];
        $data = [];
        $toc_filter['search']['rank_filter'] = $this->session->userdata('rank_filter');
        
        for ($i = 0; $i <= 5; $i++) {
            $date = date('Y', strtotime('-'.$i.' year'));
            $result = $this->nre_crew->get_nre_report($date, $toc_filter);
            $nh_result = $this->nre_crew->get_nh_nre_report($date, $toc_filter);
            $data['nre_result'.$i] = $result;
            $data['nh_nre_result'.$i] = $nh_result;
        }
        
        $data['author'] = "Alphera Marine Services, Inc.";
        $data['title_tag'] = "NRE Report | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/nre_report');
        $this->load->view('include/footer');
        $this->load->view('include/script');

    }

    public function set_nre_report_filter()
    {
        $rank_search = $this->input->post('nre_rank_filter');
        $rank_search = strip_tags($rank_search);

        if (!empty($rank_search)) {
            $this->session->set_userdata('rank_filter', $rank_search);
        } else {
            $this->session->unset_userdata('rank_filter');
        }
    }

    public function reset_nre_report_filter()
    {
        $this->session->unset_userdata('rank_filter');
    }
}
