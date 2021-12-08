<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Applicant_pending extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->perPage = 30;

        if ($this->session->userdata('url') != 'pending-applicants') {
            $this->unset_search_pending();
        }
    }

    public function index()
    {

        $data       = [];
        $conditions = [];
        $this->session->set_userdata('url', 'pending-applicants');

        $conditions['search']['name_search'] = $this->session->userdata('name_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        if ($conditions) {
            $totalApplicants = count($this->applicant_pending->getApplicantPending($conditions));
        } else {
            $totalApplicants = count($this->applicant_pending->getApplicantPending());
        }

        $config['base_url']         = base_url("pending-applicants");
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
            $data['post'] = $this->applicant_pending->getApplicantPending($conditions);
        } else {
            $data['post'] = $this->applicant_pending->getApplicantPending();
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
        $data['title_tag'] = "Pending Applicants | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/recruitment/v_shipboard_application');
        $this->load->view('modal/recruitment/not_qualified');
        $this->load->view('modal/recruitment/nat_result');
        $this->load->view('modal/global_vessel_history');
        $this->load->view('modal/recruitment_filter');
        $this->load->view('applicant/pending');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function search_pending()
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

    public function unset_search_pending()
    {
        $this->session->unset_userdata('rank_search');
        $this->session->unset_userdata('name_search');
        $this->session->unset_userdata('status_search');
        $this->session->unset_userdata('vessel_search');
        $this->session->unset_userdata('month_search_to');
        $this->session->unset_userdata('month_search_from');
    }

    public function add_nat_result()
    {
        $nat_result_form_rules = $this->validations->rules['nat_result_form'];
        $this->form_validation->set_rules($nat_result_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'n_aptitude_test_score'  => form_error('n_aptitude_test_score'),
            ];
        } else {
            $applicant_code = $this->input->post('n_app_code');

            $result = $this->applicant_pending->addNATResult($applicant_code);

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Saved Successfully!'
                ];
            } else if ($result === "with_assessor") {
                $data = [
                    'type' => 'error',
                    'title' => 'Oops, Applicant already had a assessor.'
                ];
            } else {
                $data = [
                    'type' => 'warning',
                    'title' => 'No changes have been made.'
                ];
            }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}