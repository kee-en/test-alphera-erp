<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Medical extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->perPage = 30;

        if ($this->session->userdata('url') != 'medical') {
            $this->medical_search_reset();
        }
    }

    public function validate_select($select)
    {
        if (empty($select)) {
            $this->form_validation->set_message('validate_select', 'Please Select %s.');
            return false;
        } else {
            return true;
        }
    }

    public function index()
    {

        $data = [];
        $conditions = [];

        $this->session->set_userdata('url', 'medical');

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        if ($conditions) {
            $total_crew = count($this->medical->getMedicalCrew($conditions));
        } else {
            $total_crew = count($this->medical->getMedicalCrew());
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url('medical');
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
            $data['crew'] = $this->medical->getMedicalCrew($conditions);
        } else {
            $data['crew'] = $this->medical->getMedicalCrew();
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
            'contract_search' => $this->session->userdata('contract_search'),
            'flight_search' => $this->session->userdata('flight_search'),
            'month_search_to'   => $this->session->userdata('month_search_to'),
            'month_search_from'   => $this->session->userdata('month_search_from'),
        ];

        $data['author'] = "Alphera Marine Services, Inc.";
        $data['title_tag'] = "Medical | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/crew_filter');
        $this->load->view('modal/crew/v_e_crew_info');
        $this->load->view('modal/crew/v_e_pre_joining_visa');
        $this->load->view('modal/crew/v_off_signer_info');
        $this->load->view('modal/crew/medical/v_medical');
        $this->load->view('modal/crew/medical/a_medical');
        $this->load->view('modal/crew/medical/e_medical');
        $this->load->view('modal/global_vessel_history');
        $this->load->view('modal/crew/warning_letter_reason');
        $this->load->view('modal/crew/e_position_vessel');
        $this->load->view('modal/crew/slip/manage_routing_slip');
        $this->load->view('crew/crew_monitoring/medical');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function medical_crew_search()
    {
        $cmp_search = $this->input->post('cf_crew_name');
        $cmp_search = strip_tags($cmp_search);

        $vessel_search = $this->input->post('cf_vessel_name');
        $vessel_search = strip_tags($vessel_search);

        $rank_search = $this->input->post('cf_rank_position');
        $rank_search = strip_tags($rank_search);

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

    function medical_search_reset()
    {
        $this->session->unset_userdata('cmp_name_search');
        $this->session->unset_userdata('vessel_search');
        $this->session->unset_userdata('rank_search');
        $this->session->unset_userdata('contract_search');
        $this->session->unset_userdata('flight_search');
        $this->session->unset_userdata('month_search_to');
        $this->session->unset_userdata('month_search_from');
    }

    public function get_medical_records_table()
    {
        $crew_code = $this->input->post('crew_code');
        $data = [];
        $count = 1;
        $position = "";

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length =  intval($this->input->post('length'));

        $crew_data = $this->global->getCrewInformation($crew_code);
        if ($crew_data) {
            $position = $this->global->getPosition($crew_data['position']);
        }

        $crew = $this->medical->get_crew_medical_table($crew_code);

        $status = '';
        if (!empty($crew)) {
            foreach ($crew as $row) {

                if ($row['medical_status'] === "2") {
                    $status = "<span class=\"badge badge-success-outline font-14\">FIT FOR SEA DUTY</span>";
                } else if ($row['medical_status'] === "1") {
                    $status = "<span class=\"badge badge-warning-outline font-14\">PENDING</span>";
                } else if ($row['medical_status'] === "3") {
                    $status = "<span class=\"badge badge-primary-outline font-14\">W/APPROVAL</span>";
                } else {
                    $status = "<span class=\"badge badge-danger-outline font-14\">REJECTED</span>";
                }

                if ($row['medical_status'] === "2") {
                    $action = '<div class="btn-group" role="group" aria-label="">
                                <button type="button" class="btn btn-outline-danger btn-xs"><i class="mdi mdi-eye font-16" onclick="viewMedical(\'' . $row['medical_code'] . '\',\'' . $row['crew_code'] . '\')"></i></button>
                            </div>';
                } else if ($row['medical_status'] === "1") {
                    $action = '<div class="btn-group" role="group" aria-label="">
                                    <button type="button" class="btn btn-outline-primary btn-xs" onclick="editMedical(\'' . $row['medical_code'] . '\',\'' . $row['crew_code'] . '\')"><i class="mdi mdi-pencil font-16"></i></button>
                                    <button type="button" class="btn btn-outline-danger btn-xs"><i class="mdi mdi-delete font-16" onclick="removeMedical(\'' . $row['id'] . '\',\'' . $row['medical_code'] . '\',)"></i></button>
                                    <button type="button" class="btn btn-outline-danger btn-xs"><i class="mdi mdi-eye font-16" onclick="viewMedical(\'' . $row['medical_code'] . '\',\'' . $row['crew_code'] . '\')"></i></button>
                                </div>';
                } else {
                    $action = '<div class="btn-group" role="group" aria-label="">
                                    <button type="button" class="btn btn-outline-danger btn-xs"><i class="mdi mdi-eye font-16" onclick="viewMedical(\'' . $row['medical_code'] . '\',\'' . $row['crew_code'] . '\')"></i></button>
                                </div>';
                }

                // $bmi = ($row['medical_weight'] / $row['medical_height'] / $row['medical_height']) * 10000;
                $data[] = array(
                    $count++,
                    date('M j, Y', strtotime($row['date_med_exam'])),
                    date('M j, Y', strtotime($row['medical_expiry_date'])),
                    !$position ? "" : htmlentities($position['position_name'], ENT_QUOTES, 'UTF-8'),
                    number_format($row['medical_bmi'], 2),
                    $row['remarks'] ? htmlentities($row['remarks'], ENT_QUOTES, 'UTF-8') : "-",
                    (($row['date_updated'] === NULL) ? date('M j, Y h:m A', strtotime($row['date_created'])) : date('M j, Y h:m A', strtotime($row['date_updated']))),
                    $status,
                    $this->global->getMedicalStatus($row['status'], $row['medical_status']),
                    $action
                );
            }
            $count++;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        );

        echo json_encode($result);
    }

    public function get_medical_details()
    {
        $medical_code = $this->input->post('medical_code');
        $crew_code = $this->input->post('crew_code');
        $result = $this->medical->get_crew_medical_by_code($medical_code, $crew_code);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function save_medical_record_form()
    {
        $medical_record_rules = $this->validations->rules['medical_form'];
        $this->form_validation->set_rules($medical_record_rules);

        if ($this->form_validation->run() === false) {
            $data = [
                'm_date_med_exam'   => form_error('m_date_med_exam'),
                'm_medical_expiry_date'  => form_error('m_medical_expiry_date'),
                'm_status'          => form_error('m_status'),
                'm_height'          => form_error('m_height'),
                'm_weight'          => form_error('m_weight'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->medical->saveMedicalRecordForm();

            if ($result === true) {
                $data = [
                    'type'  => 'success',
                    'title' => 'Saved Successfully!'
                ];
            } else {
                $data = [
                    'type'  => 'error',
                    'title' => 'Oops, something went wrong!'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function edit_medical_record_form()
    {
        $edit_medical_record_rules = $this->validations->rules['edit_medical_form'];
        $this->form_validation->set_rules($edit_medical_record_rules);

        if ($this->form_validation->run() === false) {
            $data = [
                'e_m_date_med_exam'   => form_error('e_m_date_med_exam'),
                'e_m_medical_expiry_date'  => form_error('e_m_medical_expiry_date'),
                'e_m_status'          => form_error('e_m_status'),
                'e_m_height'          => form_error('e_m_height'),
                'e_m_weight'          => form_error('e_m_weight'),
                'type'                => 'warning',
                'title'               => 'Please complete all the required fields.'
            ];
        } else {

            $medical_code = $this->input->post('e_m_medical_code');
            $crew_code    = $this->input->post('e_m_crew_code');

            $result = $this->medical->editMedicalRecordForm($medical_code, $crew_code);

            if ($result === true) {
                $data = [
                    'type'  => 'success',
                    'title' => 'Update Successfully!'
                ];
            } else {
                $data = [
                    'type'  => 'error',
                    'title' => 'Oops, something went wrong!'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function remove_medical_record()
    {
        $id = $this->input->post('id');
        $medical_code = $this->input->post('medical_code');


        $result = $this->medical->removeMedicalRecord($id);

        if ($result === true) {
            $remove_ac_approval_data = $this->medical->removeAcApprovalData($medical_code);

            if ($remove_ac_approval_data) {
                $data = [
                    'type'  => 'success',
                    'title' => 'Removed Successfully!'
                ];
            } else {
                $data = [
                    'type'  => 'error',
                    'title' => 'Oops, something went wrong!'
                ];
            }
        } else {
            $data = [
                'type'  => 'error',
                'title' => 'Oops, something went wrong!'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function medical_approval_report()
    {
        $data = [];
        $filters = [];

        $filters['search']['crew_type_search'] = $this->session->userdata('mar_crew_type');
        $filters['search']['med_status_search'] = $this->session->userdata('mar_medical_search');

        if (!empty($filters['search']['med_status_search']) && $filters['search']['med_status_search'] == 1) {

            for ($i = 0; $i <= 5; $i++) {
                $date = date('Y', strtotime('-'.$i.' year'));
                $result = $this->medical->medical_approval_report($date, $filters);
                $data['medicals'.$i] = $result;
            }

        } else if(!empty($filters['search']['med_status_search']) && $filters['search']['med_status_search'] == 2){
           $data['joining_expired'] = $this->medical->joining_crew_expired_medical();
        }else if(!empty($filters['search']['med_status_search']) && $filters['search']['med_status_search'] == 3){
            $data['joining_remedical'] = $this->medical->joining_crew_re_medical();
        }

        $data['author'] = "Alphera Marine Services, Inc.";
        $data['title_tag'] = "Medical Approval Report | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";
        
        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('reports/medical_approval_report');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function set_mar_filter()
    {
        $mar_crew_search = $this->input->post('mar_crew_type');
        $mar_crew_search = strip_tags($mar_crew_search);

        $mar_medical_search = $this->input->post('mar_medical_status');
        $mar_medical_search = strip_tags($mar_medical_search);

        if (!empty($mar_crew_search)) {
            $this->session->set_userdata('mar_crew_search', $mar_crew_search);
        } else {
            $this->session->unset_userdata('mar_crew_search');
        }

        if (!empty($mar_medical_search)) {
            $this->session->set_userdata('mar_medical_search', $mar_medical_search);
        } else {
            $this->session->unset_userdata('mar_medical_search');
        }
    }

    public function unset_mar_filter()
    {
        $this->session->unset_userdata('mar_crew_search');
        $this->session->unset_userdata('mar_rank_search');
        $this->session->unset_userdata('mar_medical_search');
    }
    
}
