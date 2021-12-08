<?php
defined('BASEPATH') or exit('No direct script access allowed');

class New_crew extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->perPage = 30;

        if ($this->session->userdata('url') != 'new-crew') {
            $this->newcrew_search_reset();
        }
    }

    public function index()
    {

        $data = [];
        $conditions = [];
        $this->session->set_userdata('url', 'new-crew');

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        if ($conditions) {
            $total_crew = count($this->new_crew->getNewCrew($conditions));
        } else {
            $total_crew = count($this->new_crew->getNewCrew());
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url('new-crew');
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

        if ($conditions) {
            $data['crew'] = $this->new_crew->getNewCrew($conditions);
        } else {
            $data['crew'] = $this->new_crew->getNewCrew();
        }

        if ($conditions['start'] === 0) {
            $start_count = 1;
        } else {
            $start_count = $conditions['start'];
        }

        $end_count = ($conditions['start'] + count($data['crew']));

        $data['showing_entries'] = 'Showing ' . $start_count . ' to ' . $end_count . ' of ' . $config['total_rows'] . ' entries';
        $data['count_page'] = $page != 0 ? ($page * $this->perPage) - $this->perPage : 0;

        $data['search'] = [
            'name_search' => $this->session->userdata('cmp_name_search'),
            'vessel_search' => $this->session->userdata('vessel_search'),
            'rank_search' => $this->session->userdata('rank_search'),
            'status_search' => $this->session->userdata('status_search'),
            'contract_search' => $this->session->userdata('contract_search'),
            'flight_search' => $this->session->userdata('flight_search'),
            'month_search_to'   => $this->session->userdata('month_search_to'),
            'month_search_from'   => $this->session->userdata('month_search_from'),
        ];

        $data['author'] = "Alphera Marine Services, Inc.";
        $data['title_tag'] = "New Crew | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/crew_filter');
        $this->load->view('modal/crew/contracts/v_contracts');
        $this->load->view('modal/crew/medical/v_medical');
        $this->load->view('modal/crew/v_e_pre_joining_visa');
        $this->load->view('modal/crew/v_prejoining_visa');
        $this->load->view('modal/crew/v_e_crew_info');
        $this->load->view('modal/crew/v_off_signer_info');
        $this->load->view('modal/crew/contracts/a_poea_contract');
        $this->load->view('modal/crew/contracts/a_mlc_contract');
        $this->load->view('modal/crew/contracts/e_poea_contract');
        $this->load->view('modal/crew/contracts/e_mlc_contract');
        $this->load->view('modal/crew/medical/a_medical');
        $this->load->view('modal/crew/a_flight_details');
        $this->load->view('modal/crew/warning_letter_reason');
        $this->load->view('modal/global_vessel_history');
        $this->load->view('modal/crew/e_position_vessel');
        $this->load->view('crew/crew_list/new_crew');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function new_crew_search()
    {
        $cmp_search = $this->input->post('cf_crew_name');
        $cmp_search = strip_tags($cmp_search);

        $vessel_search = $this->input->post('cf_vessel_name');
        $vessel_search = strip_tags($vessel_search);

        $rank_search = $this->input->post('cf_rank_position');
        $rank_search = strip_tags($rank_search);

        $status_search = $this->input->post('cf_application_status');
        $status_search = strip_tags($status_search);

        $contract_search = $this->input->post('cf_contract_status');
        $contract_search = strip_tags($contract_search);

        $flight_search = $this->input->post('cf_flight_status');
        $flight_search = strip_tags($flight_search);

        $month_search_to = $this->input->post('cf_date_to');
        $month_search_to = strip_tags($month_search_to);

        $month_search_from = $this->input->post('cf_date_from');
        $month_search_from = strip_tags($month_search_from);


        if (!empty($cmp_search)) {
            $this->session->set_userdata('cmp_name_search', $cmp_search);
        } else {
            $this->session->unset_userdata('cmp_name_search');
        }

        if (!empty($vessel_search)) {
            $this->session->set_userdata('vessel_search', $vessel_search);
        } else {
            $this->session->unset_userdata('vessel_search');
        }

        if (!empty($status_search)) {
            $this->session->set_userdata('status_search', $status_search);
        } else {
            $this->session->unset_userdata('status_search');
        }

        if (!empty($rank_search)) {
            $this->session->set_userdata('rank_search', $rank_search);
        } else {
            $this->session->unset_userdata('rank_search');
        }

        if (!empty($contract_search)) {
            $this->session->set_userdata('contract_search', $contract_search);
        } else {
            $this->session->unset_userdata('contract_search');
        }

        if (!empty($flight_search)) {
            $this->session->set_userdata('flight_search', $flight_search);
        } else {
            $this->session->unset_userdata('flight_search');
        }

        if (!empty($month_search_to)) {
            $this->session->set_userdata('month_search_to', $month_search_to);
        } else {
            $this->session->unset_userdata('month_search_to');
        }
        if (!empty($month_search_from)) {
            $this->session->set_userdata('month_search_from', $month_search_from);
        } else {
            $this->session->unset_userdata('month_search_from');
        }
    }

    function newcrew_search_reset()
    {
        $this->session->unset_userdata('cmp_name_search');
        $this->session->unset_userdata('vessel_search');
        $this->session->unset_userdata('status_search');
        $this->session->unset_userdata('rank_search');
        $this->session->unset_userdata('contract_search');
        $this->session->unset_userdata('flight_search');
        $this->session->unset_userdata('month_search_to');
        $this->session->unset_userdata('month_search_from');
    }
}
