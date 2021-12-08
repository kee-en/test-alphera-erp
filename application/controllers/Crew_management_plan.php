<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crew_management_plan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->perPage = 30;

        if ($this->session->userdata('url') != 'crew-management-plan') {
            $this->cmp_search_reset();
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

    public function index()
    {
        $data = [];
        $conditions = [];

        $this->session->set_userdata('url', 'crew-management-plan');

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');


        if ($conditions) {
            $total_crew = count($this->crew_management->getOffSignerCrew($conditions));
        } else {
            $total_crew = count($this->crew_management->getOffSignerCrew());
        }

        $config['base_url'] = base_url('crew-management-plan');
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
            $data['crew'] = $this->crew_management->getOffSignerCrew($conditions);
        } else {
            $data['crew'] = $this->crew_management->getOffSignerCrew();
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
        $data['title_tag'] = "Manage CM Plan | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";
        
        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('crew/cmp/cmp');
        $this->load->view('modal/crew/cmp/a_crew_management_plan');
        $this->load->view('modal/crew/contracts/v_contracts');
        $this->load->view('modal/crew/contracts/e_mlc_contract');
        $this->load->view('modal/crew/contracts/e_poea_contract');
        $this->load->view('modal/crew/medical/v_medical');
        $this->load->view('modal/crew/medical/e_medical');
        $this->load->view('modal/crew/v_prejoining_visa');
        $this->load->view('modal/crew/v_e_pre_joining_visa');
        $this->load->view('modal/crew/v_e_crew_info');
        $this->load->view('modal/crew/v_off_signer_info');
        $this->load->view('modal/global_vessel_history');
        $this->load->view('modal/crew/medical/cmp_medical');
        $this->load->view('modal/crew/warning_letter_reason');
        $this->load->view('modal/crew_filter');
        $this->load->view('modal/crew/e_position_vessel');
        $this->load->view('modal/crew/slip/manage_routing_slip');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function select_on_signer()
    {
        $result = $this->crew_management->selectOnSigner();

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
            ->set_content_type("application/json")
            ->set_output(json_encode($data));
    }

    public function remove_on_signer()
    {
        $cmp_code = $this->input->post('cmp_code');

        $result = $this->crew_management->removeOnSigner($cmp_code);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Removed Successfully!'
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

    public function cmp_search()
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
    function cmp_search_reset()
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

    function get_cmp_details()
    {
        $cmp_code = $this->input->post('code');
        $result = $this->crew_management->getCMPdetails($cmp_code);
        $get_poea = $this->contracts->getCrewPOEA($result['crew_code']);

        $result['contract_duration'] = !empty($get_poea) && !is_null($get_poea) ? $get_poea['contract_duration'] : "";

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    function update_cmp()
    {
        $edit_cmp_form_rules = $this->validations->rules['edit_cmp_form'];
        $this->form_validation->set_rules($edit_cmp_form_rules);

        if ($this->input->post('status') === "7") {
            $this->form_validation->set_rules('c_line_up', 'Line Up', 'trim|required|callback_validate_select');
        }

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'c_onboard'  => form_error('c_onboard'),
                'c_line_up' => form_error('c_line_up'),
                'c_sign_on' => form_error('c_sign_on'),
                'c_end_contract'  => form_error('c_end_contract'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->crew_management->update_cmp();
            if ($result === true) {
                $data = [
                    'type'  => 'success',
                    'title' => 'Updated Successfully!',
                    'text'  => 'Crew CM Plan was updated successfully.',
                ];
            } else {
                $data = [
                    'type'  => 'error',
                    'title' => 'Oops, something went wrong!',
                    'text'  => 'Please contact your system administrator.'
                ];
            }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function update_crew_pos_vessel()
    {
        $edit_position_vessel_rules = $this->validations->rules['edit_position_vessel'];
        $this->form_validation->set_rules($edit_position_vessel_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'epvm_tentative_vessel'      => form_error('epvm_tentative_vessel'),
                'epvm_position'              => form_error('epvm_position'),
                'type'                      => 'warning',
                'title'                     => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->crew_management->update_crew_pos_vessel();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Updated Successfully!',
                    'text'  => 'Your rank and vessel was successfully updated.'
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Error!',
                    'text'  => 'Failed to update your rank and position. Please check and try again.'
                ];
            }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
