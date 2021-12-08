<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transfer_company extends CI_Controller
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
            $total_crew = count($this->withdrawal_crew->getTransferCompanyCrew($conditions));
        } else {
            $total_crew = count($this->withdrawal_crew->getTransferCompanyCrew());
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url('withdrawal');
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
            $data['crew'] = $this->withdrawal_crew->getTransferCompanyCrew($conditions);
        } else {
            $data['crew'] = $this->withdrawal_crew->getTransferCompanyCrew();
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
        $data['title_tag'] = "Withdrawal (TOC) | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/crew/e_position_vessel');
        $this->load->view('modal/crew/remove_crew_toc');
        $this->load->view('crew/withdrawal');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function crew_toc()
    {
        $crew_withdrawal_application_rules = $this->validations->rules['crew_withdrawal_application'];
        $this->form_validation->set_rules($crew_withdrawal_application_rules);
        
        if ($this->input->post('w_crew_name') === 0) {
            $this->form_validation->set_rules('w_crew_name', 'Crew Name', 'required');
        }

        if ($this->form_validation->run() === FALSE) {

            $data = [
                'w_crew_name'  => form_error('w_crew_name'),
                'w_rank' => form_error('w_rank'),
                'w_department' => form_error('w_department'),
                'w_vessel'  => form_error('w_vessel'),
                'w_remarks'   => form_error('w_remarks'),
            ];

        }else{
            $result = $this->withdrawal_crew->save_crew_toc();

            if ($result === true) {
                $data = [
                    'type'  => 'success',
                    'title' => 'Sucess!',
                    'text'  => 'Crew was marked as transfered to another company.'
                ];
            } else {
                $data = [
                    'type'  => 'error',
                    'title' => 'Oops, something went wrong!',
                    'text'  => 'Opss, something went wrong when transfering crew data.'
                ];
            }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_toc_report()
    {
        $toc_filter = [];
        $data = [];
        $toc_filter['search']['rank_filter'] = $this->session->userdata('rank_filter');
        
        for ($i = 0; $i <= 5; $i++) {
            $date = date('Y', strtotime('-'.$i.' year'));
            $result = $this->withdrawal_crew->get_toc_report($date, $toc_filter);
            $newhire = $this->withdrawal_crew->get_newhire_toc_report($date, $toc_filter);
            $data['show_result'.$i] = $result;
            $data['nh_show_result'.$i] = $newhire;
        }

        $data['author'] = "Alphera Marine Services, Inc.";
        $data['title_tag'] = "TOC Report | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/toc_report');
        $this->load->view('include/footer');
        $this->load->view('include/script');

    }

    public function set_toc_filter()
    {
        $rank_search = $this->input->post('toc_rank_filter');
        $rank_search = strip_tags($rank_search);

        if (!empty($rank_search)) {
            $this->session->set_userdata('rank_filter', $rank_search);
        } else {
            $this->session->unset_userdata('rank_filter');
        }
    }

    public function reset_toc_filter()
    {
        $this->session->unset_userdata('rank_filter');
    }
}
