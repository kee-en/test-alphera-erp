<?php
defined('BASEPATH') or exit('No direct script access allowed');

class All_crew extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->perPage = 30;

        if ($this->session->userdata('url') != 'all-crew') {
            $this->unset_crew_search();
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

        $data = [];
        $conditions = [];

        $this->session->set_userdata('url', 'all-crew');

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['status_search'] = $this->session->userdata('status_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        if ($conditions) {
            $total_crew = count($this->all_crew->getAllCrew($conditions));
        } else {
            $total_crew = count($this->all_crew->getAllCrew());
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url('all-crew');
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
            $data['crew'] = $this->all_crew->getAllCrew($conditions);
        } else {
            $data['crew'] = $this->all_crew->getAllCrew();
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
        $data['title_tag'] = "All Crew | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/crew_filter');
        $this->load->view('modal/crew/contracts/v_contracts');
        $this->load->view('modal/crew/medical/v_medical');
        $this->load->view('modal/crew/v_e_crew_info');
        $this->load->view('modal/crew/v_e_pre_joining_visa');
        $this->load->view('modal/crew/contracts/a_poea_contract');
        $this->load->view('modal/crew/contracts/a_mlc_contract');
        $this->load->view('modal/crew/medical/a_medical');
        $this->load->view('modal/crew/medical/e_medical');
        $this->load->view('modal/crew/a_flight_details');
        $this->load->view('modal/global_vessel_history');
        $this->load->view('modal/crew/warning_letter_reason');
        $this->load->view('modal/crew/promotion_checklist');
        $this->load->view('modal/crew/e_position_promotion');
        $this->load->view('modal/crew/contracts/e_mlc_contract');
        $this->load->view('modal/crew/contracts/e_poea_contract');
        $this->load->view('modal/crew/a_warning_letter');
        $this->load->view('modal/crew/e_position_vessel');
        $this->load->view('modal/crew/contracts/promotion_mlc_contract');
        $this->load->view('modal/crew/contracts/promotion_poea_contract');
        $this->load->view('modal/crew/v_prejoining_visa');
        $this->load->view('crew/crew_list/all_crew');
        $this->load->view('modal/crew/slip/manage_routing_slip');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function all_crew_search()
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

    public function unset_crew_search()
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

    public function save_edit_crew_information()
    {
        $e_crew_info_form = $this->validations->rules['e_crew_info_form'];
        $this->form_validation->set_rules($e_crew_info_form);

        $name_val = "";
        $birth_val = "";
        $number_val = "";

        // if ($this->input->post('e_no_of_children') != "none") {

        //     $loop = intval($this->input->post('e_no_of_children'));
        //     $name_val = $this->validate_child_name($loop, $this->input->post('r_full_name'));
        //     $birth_val = $this->validate_child_birthday($loop, $this->input->post('r_birth_date'));
        //     $number_val = $this->validate_child_number($loop, $this->input->post('r_mobile_no'));
        // }

        // foreach ($name_val as $key) {
        //     $this->form_validation->set_rules('r_full_name', 'Child Name',array('required',
        //                 function($key)
        //                 {
        //                     if (!empty($key)) {
        //                         return false;
        //                     }else{
        //                         return true;
        //                     }
        //                 }
        //         )
        //     );
        // }
        // foreach ($birth_val as $key) {
        //     $this->form_validation->set_rules('r_birth_date', 'Child Birthday',array('required',
        //                 function($key)
        //                 {
        //                     if (!empty($key)) {
        //                         return false;
        //                     }else{
        //                         return true;
        //                     }
        //                 }
        //         )
        //     );
        // }
        // foreach ($number_val as $key) {
        //     $this->form_validation->set_rules('r_mobile_no', 'Child Number',array('required',
        //                 function($key)
        //                 {
        //                     if (!empty($key)) {
        //                         return false;
        //                     }else{
        //                         return true;
        //                     }
        //                 }
        //         )
        //     );
        // }

        if ($this->input->post('e_source_location') == 1) {
            $this->form_validation->set_rules('s_recommended_name', 'Recommended By', 'trim|required');
        }

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_first_name'  => form_error('e_first_name'),
                'e_last_name'   => form_error('e_last_name'),
                'e_birth_date'  => form_error('e_birth_date'),
                'e_birth_place' => form_error('e_birth_place'),
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
                // 'r_full_name'   => form_error('r_full_name'),
                // 'r_birth_date'  => form_error('r_birth_date'),
                // 'r_mobile_no'   => form_error('r_mobile_no'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $crew_code = $this->input->post('e_crew_code');

            $result = $this->all_crew->saveEditCrewInformation($crew_code);

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

    public function get_all_crew()
    {

        $result = $this->all_crew->getAllCrew();

        $data = [];

        foreach ($result as $key) {
            $data[] = [
                'id' => $key['crew_code'],
                'text' => $key['full_name']
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    function validate_child_name($loop, $name)
    {
        $name_val = [];
        for ($k = 0; $k < $loop; $k++) {
            if (array_key_exists($k, $name)) {
                if (empty($name[$k])) {
                    $name_vald = $k;
                    array_push($name_val, $name_vald);
                }
            }
        }
        return $name_val;
    }

    function validate_child_birthday($loop, $birthday)
    {
        $birth_val = [];
        for ($k = 0; $k < $loop; $k++) {
            if (array_key_exists($k, $birthday)) {
                if (empty($birthday[$k])) {
                    $child_birth_vald = $k;
                    array_push($birth_val, $child_birth_vald);
                }
            }
        }
        return $birth_val;
    }

    function validate_child_number($loop, $number)
    {
        $num_val = [];
        for ($k = 0; $k < $loop; $k++) {
            if (array_key_exists($k, $number)) {
                if (empty($number[$k])) {
                    $child_num_vald = $k;
                    array_push($num_val, $child_num_vald);
                }
            }
        }
        return $num_val;
    }
}
