<?php
defined('BASEPATH') or exit('No direct script access allowed');

class For_reporting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->perPage = 30;
        if ($this->session->userdata('url') != 'for-reporting') {
            $this->reporting_search_reset();
        }
    }

    public function checkDate($date)
    {
        if (date('Y-m-d', strtotime($date)) < date('Y-m-d') || date('Y-m-d', strtotime($date)) == date('Y-m-d')) {
            $this->form_validation->set_message('checkDate', '%s cannot be in the current date or the past date.');
            return false;
        } else {
            // Your date is not in the past
            return true;
        }
    }

    public function validate_select($select)
    {
        if (empty($select)) {
            $this->form_validation->set_message('validate_select', 'The %s field is required.');
            return false;
        } else {
            return true;
        }
    }

    public function index()
    {
        $data = [];
        $conditions = [];

        $this->session->set_userdata('url', 'for-reporting');

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');

        if ($conditions) {
            $total_crews = count($this->reporting->gerCrewReporting($conditions));
        } else {
            $total_crews = count($this->reporting->gerCrewReporting());
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url('for-reporting');
        $config['use_page_numbers'] = true;
        $config['total_rows'] = $total_crews;
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
            $data['crew'] = $this->reporting->gerCrewReporting($conditions);
        } else {
            $data['crew'] = $this->reporting->gerCrewReporting();
        }

        if ($conditions['start'] == 0) {
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
        ];

        $data['author'] = "Alphera Marine Services, Inc.";
        $data['title_tag'] = "For Reporting | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/crew_filter');
        $this->load->view('modal/crew/v_off_signer_info');
        $this->load->view('modal/crew/v_e_pre_joining_visa');
        $this->load->view('modal/crew/v_prejoining_visa');
        $this->load->view('modal/crew/contracts/v_contracts');
        $this->load->view('modal/crew/medical/v_medical');
        $this->load->view('modal/crew/medical/e_medical');
        $this->load->view('modal/crew/a_reporting');
        $this->load->view('modal/crew/v_e_crew_info');
        $this->load->view('modal/crew/warning_letter_reason');
        $this->load->view('modal/crew/e_position_vessel');
        $this->load->view('crew/reporting');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function reporting_crew_search()
    {
        $cmp_search = $this->input->post('cf_crew_name');
        $cmp_search = strip_tags($cmp_search);

        $vessel_search = $this->input->post('cf_vessel_name');
        $vessel_search = strip_tags($vessel_search);

        $rank_search = $this->input->post('cf_rank_position');
        $rank_search = strip_tags($rank_search);


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

        if (!empty($rank_search)) {
            $this->session->set_userdata('rank_search', $rank_search);
        } else {
            $this->session->unset_userdata('rank_search');
        }
    }

    function reporting_search_reset()
    {
        $this->session->unset_userdata('cmp_name_search');
        $this->session->unset_userdata('vessel_search');
        $this->session->unset_userdata('rank_search');
    }

    public function create_on_vacation_crew()
    {
        $add_reporting_form_rules = $this->validations->rules['add_reporting_form'];
        $this->form_validation->set_rules($add_reporting_form_rules);

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'r_position' => form_error('r_position'),
                'r_crew_evaluation' => form_error('r_crew_evaluation'),
                'r_tentative_vessel' => form_error('r_tentative_vessel'),
                'r_date_availability'  => form_error('r_date_availability'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->reporting->createOnVacationCrew();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Saved Successfully!'
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Oops, something went wrong!'
                ];
            }
        }
        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($data));
    }
}
