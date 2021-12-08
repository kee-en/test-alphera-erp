<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Withdrawal_crew extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->perPage = 30;
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

        if ($conditions) {
            $total_crew = count($this->withdrawal_crew->getWithdrawalCrew($conditions));
        } else {
            $total_crew = count($this->withdrawal_crew->getWithdrawalCrew());
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url('withdrawal-crew');
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
            $data['crew'] = $this->withdrawal_crew->getWithdrawalCrew($conditions);
        } else {
            $data['crew'] = $this->withdrawal_crew->getWithdrawalCrew();
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
        $data['title_tag'] = "Withdrawal Application | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/crew/contracts/v_contracts');
        $this->load->view('modal/crew/medical/v_medical');
        $this->load->view('modal/crew/v_prejoining_visa');
        $this->load->view('modal/crew/v_e_crew_info');
        $this->load->view('modal/crew/v_off_signer_info');
        $this->load->view('modal/global_vessel_history');
        $this->load->view('modal/crew/e_position_vessel');
        $this->load->view('crew/crew_list/withdrawal');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function un_withdrawal_crew()
    {
        $un_toc_form_rules = $this->validations->rules['un_toc_form'];
        $this->form_validation->set_rules($un_toc_form_rules);

        if ($this->form_validation->run() == FALSE) {

            $data = [
                'toc_status' => form_error('toc_status'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];

        }else{
        
            $result = $this->withdrawal_crew->UnWatchlistCrew();
            if ($result === true) {
                $data = [
                    'type'              => 'success',
                    'title'             => 'Remove crew TOC.',
                    'text'              => 'Successfully remove crew from TOC list, Please wait admin approval.'
                ];
            } else {
                $data = [
                    'type'              => 'error',
                    'title'             => 'Remove crew TOC.',
                    'text'              => 'Something went wrong when removing crew from TOC list.'
                ];
            }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
