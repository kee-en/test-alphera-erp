<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Applicant_interview extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->perPage = 30;

        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        if ($this->session->userdata('url') != 'for-interview') {
            $this->unset_search_interview();
        }
    }

    public function checkDate($date)
    {
        if (date('Y-m-d', strtotime($date)) < date('Y-m-d') || date('Y-m-d', strtotime($date)) === date('Y-m-d')) {
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

    public function checkBirth($birth_date)
    {
        $date_valid =  date('Y-m-d', strtotime('-18 Years', strtotime(date('Y-m-d'))));
        $birth_date = date('Y-m-d', strtotime($birth_date));
        if ($birth_date > $date_valid) {
            $this->form_validation->set_message('checkBirth', 'You must be at least 18 years of age');
            return false;
        } else {
            return true;
        }
    }

    public function index()
    {
        $data       = [];
        $conditions = [];

        $this->session->set_userdata('url', 'for-interview');

        $conditions['search']['name_search'] = $this->session->userdata('name_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        if ($conditions) {
            $totalApplicants = count($this->applicant_interview->getApplicantInterview($conditions));
        } else {
            $totalApplicants = count($this->applicant_interview->getApplicantInterview());
        }

        $config['base_url']         = base_url("for-interview");
        $config['use_page_numbers'] = true;
        $config['total_rows']       = $totalApplicants;
        $config['per_page']         = $this->perPage;
        $config['uri_segment']      = 2;
        $config['num_links']        = 3;
        $config['full_tag_open']    = '<div class="pagination pagination-sm">';
        $config['full_tag_close']   = '</div>';
        $config['first_link']       = 'First';
        $config['first_tag_open']   = '<li class="page-item">';
        $config['first_tag_close']  = '</li>';
        $config['last_link']        = 'Last';
        $config['last_tag_open']    = '<li class="page-item">';
        $config['last_tag_close']   = '</li>';
        $config['next_link']        = 'Next';
        $config['next_tag_open']    = '<li class="page-item">';
        $config['next_tag_close']   = '</li>';
        $config['prev_link']        = 'Previous';
        $config['prev_tag_open']    = '<li class="page-item">';
        $config['prev_tag_close']   = '</li>';
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="page-item active"><a class="page-link" href="javascript: void(0);" tabindex="-1">';
        $config['cur_tag_close']    = '</a></li>';
        $config['attributes']       = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = $this->uri->segment($config['uri_segment']);

        $offset = !$page ? 0 : (($this->perPage * $page) - $this->perPage);

        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        if ($conditions) {
            $data['post'] = $this->applicant_interview->getApplicantInterview($conditions);
        } else {
            $data['post'] = $this->applicant_interview->getApplicantInterview();
        }

        if ($conditions['start'] === 0) {
            $start_count = 1;
        } else {
            $start_count = $conditions['start'];
        }

        $end_count = ($conditions['start'] + count($data['post']));

        $data['applicant_count'] = 'Showing ' . $start_count . ' to ' . $end_count . ' of ' . $config['total_rows'] . ' entries';

        $data['search']['name_search'] = $this->session->userdata('name_search');
        $data['search']['status_search'] = $this->session->userdata('status_search');
        $data['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $data['search']['rank_search'] = $this->session->userdata('rank_search');
        $data['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $data['search']['month_search_from'] = $this->session->userdata('month_search_from');

        $data['author'] = "Alphera Marine Services, Inc.";
        $data['title_tag'] = "For Interview | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/recruitment/v_shipboard_application');
        $this->load->view('modal/recruitment/interview/e_shipboard_application');
        $this->load->view('modal/recruitment/interview/evaluation_form');
        $this->load->view('modal/recruitment/interview/general_interview_form');
        $this->load->view('modal/recruitment/interview/technical_interview_form');
        $this->load->view('modal/recruitment/interview/employed_crew_form');
        $this->load->view('modal/recruitment/interview/interview_sheet');
        $this->load->view('modal/global_vessel_history');
        $this->load->view('modal/recruitment/nat_result');
        $this->load->view('modal/recruitment/print_type');
        $this->load->view('modal/recruitment_filter');
        $this->load->view('applicant/interview');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function search_interview()
    {
        $applicant_search = $this->input->post('rf_applicant_name');
        $applicant_search = strip_tags($applicant_search);

        $filter_search = $this->input->post('rf_application_status');
        $filter_search = strip_tags($filter_search);

        $vessel_search = $this->input->post('rf_vessel_name');
        $vessel_search = strip_tags($vessel_search);

        $rank_search = $this->input->post('rf_rank');
        $rank_search = strip_tags($rank_search);

        $month_search_to = $this->input->post('rf_date_availability_to');
        $month_search_to = strip_tags($month_search_to);

        $month_search_from = $this->input->post('rf_date_availability_from');
        $month_search_from = strip_tags($month_search_from);


        if (!empty($applicant_search)) {
            $this->session->set_userdata('name_search', $applicant_search);
        } else {
            $this->session->unset_userdata('name_search');
        }

        if (!empty($filter_search)) {
            $this->session->set_userdata('status_search', $filter_search);
        } else {
            $this->session->unset_userdata('status_search');
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

    public function unset_search_interview()
    {
        $this->session->unset_userdata('name_search');
        $this->session->unset_userdata('status_search');
        $this->session->unset_userdata('vessel_search');
        $this->session->unset_userdata('rank_search');
        $this->session->unset_userdata('month_search_to');
        $this->session->unset_userdata('month_search_from');
    }

    public function edit_shipboard_aplication()
    {
        $edit_shipboard_application_form = $this->validations->rules['edit_shipboard_application_form'];
        $this->form_validation->set_rules($edit_shipboard_application_form);

        if ($this->input->post('e_source_location') == 1) {
            $this->form_validation->set_rules('e_recommended_name', 'Recommended By', 'trim|required');
        }

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_first_position'  => form_error('e_first_position'),
                'e_source_location' => form_error('e_source_location'),
                'e_tentative_vessel' => form_error('e_tentative_vessel'),
                's_type_of_crew' => form_error('s_type_of_crew'),
                'e_first_name'  => form_error('e_first_name'),
                'e_last_name'   => form_error('e_last_name'),
                'e_birth_date'  => form_error('e_birth_date'),
                'e_birth_place' => form_error('e_birth_place'),
                'e_date_available'   => form_error('e_date_available'),
                'e_civil_status'     => form_error('e_civil_status'),
                'e_email_address'      => form_error('e_email_address'),
                'e_mobile_number' => form_error('e_mobile_number'),
                // 'e_religion'      => form_error('e_religion'),
                'e_nationality'   => form_error('e_nationality'),
                // 'e_sss_no' => form_error('e_sss_no'),
                // 'e_tin_no' => form_error('e_tin_no'),
                // 'e_philhealth_no' => form_error('e_philhealth_no'),
                // 'e_pag_ibig_no' => form_error('e_pag_ibig_no'),
                'e_height' => form_error('e_height'),
                'e_weight' => form_error('e_weight'),
                'e_bmi' => form_error('e_bmi'),
                'e_recommended_name' => form_error('e_recommended_name'),
                'e_home_address' => form_error('e_home_address'),
                'e_province' => form_error('e_province'),
                'e_city' => form_error('e_city'),
                'e_country' => form_error('e_country'),
                // 'e_father_name' => form_error('e_father_name'),
                // 'e_mother_name' => form_error('e_mother_name'),
                'e_kin_address' => form_error('e_kin_address'),
                'e_course' => form_error('e_course'),
                'e_school_name' => form_error('e_school_name'),
                'e_inclusive_years_to' => form_error('e_inclusive_years_to'),
                'e_inclusive_years_from' => form_error('e_inclusive_years_from'),
                // 'e_school_address' => form_error('e_school_address'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $img = $this->input->post('web_image');
            $photo_upload = $this->global->uploadPhoto($img);

            $result = $this->applicant_interview->saveEditShipboardApplication();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Your shipboard application was successfully updated.'
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Oops, something went wrong!'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function save_evaluation_form()
    {
        $result = $this->applicant_interview->saveEvaluationForm();

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Saved Successfully!'
            ];
        } else if ($result === "failed") {
            $data = [
                'type' => 'warning',
                'title' => 'Due to a failed score, applicant automatically not qualified!'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Oops, something went wrong!'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function save_general_interview()
    {
        $result = $this->applicant_interview->saveGeneralInterview();

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Saved Successfully!'
            ];
        } else if ($result === "failed") {
            $data = [
                'type' => 'warning',
                'title' => 'Due to a failed score, applicant automatically not qualified!'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Oops, something went wrong!'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function save_technical_interview()
    {

        $result = $this->applicant_interview->saveTechnicalInterview();

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Saved Successfully!'
            ];
        } else if ($result === "failed") {
            $data = [
                'type' => 'warning',
                'title' => 'Due to a failed score, applicant automatically not qualified!'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Oops, something went wrong!'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function save_employed_crew_form()
    {
        $result = $this->applicant_interview->saveEmployedCrewForm();

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

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function save_interview_sheet()
    {
        $result = $this->applicant_interview->saveInterviewSheet();

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Saved Successfully!'
            ];
        } else if ($result === "failed") {
            $data = [
                'type' => 'warning',
                'title' => 'Due to a failed score, applicant automatically not qualified!'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Oops, something went wrong!'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
