<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contracts extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->perPage = 30;

        if ($this->session->userdata('url') != 'contracts') {
            $this->contract_search_reset();
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

        $this->session->set_userdata('url', 'contracts');

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        if ($conditions) {
            $total_crew = count($this->contracts->getContractCrew($conditions));
        } else {
            $total_crew = count($this->contracts->getContractCrew());
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url('contracts');
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
            $data['crew'] = $this->contracts->getContractCrew($conditions);
        } else {
            $data['crew'] = $this->contracts->getContractCrew();
        }

        if ($conditions['start'] === 0) {
            $start_count = 1;
        } else {
            $start_count = $conditions['start'];
        }

        $end_count = ($conditions['start'] + count($data['crew']));

        $data['showing_entries'] = 'Showing ' . $start_count . ' to ' . $end_count . ' of ' . $config['total_rows'] . ' entries';

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
        $data['title_tag'] = "Contracts | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/crew_filter');
        $this->load->view('modal/crew/v_e_crew_info');
        $this->load->view('modal/crew/v_e_pre_joining_visa');
        $this->load->view('modal/crew/v_off_signer_info');
        $this->load->view('modal/crew/contracts/v_contracts');
        $this->load->view('modal/crew/contracts/a_poea_contract');
        $this->load->view('modal/crew/contracts/a_mlc_contract');
        $this->load->view('modal/global_vessel_history');
        $this->load->view('modal/crew/warning_letter_reason');
        $this->load->view('modal/crew/contracts/e_poea_contract');
        $this->load->view('modal/crew/contracts/e_mlc_contract');
        $this->load->view('modal/crew/e_position_vessel');
        $this->load->view('modal/crew/slip/manage_routing_slip');
        $this->load->view('crew/crew_monitoring/contracts');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function contract_crew_search()
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

    function contract_search_reset()
    {
        $this->session->unset_userdata('cmp_name_search');
        $this->session->unset_userdata('vessel_search');
        $this->session->unset_userdata('rank_search');
        $this->session->unset_userdata('contract_search');
        $this->session->unset_userdata('flight_search');
        $this->session->unset_userdata('month_search_to');
        $this->session->unset_userdata('month_search_from');
    }

    public function search_crew_by_id()
    {
        $crew_code = $this->input->post('crew_code');

        $data = $this->contracts->getCrewContractById($crew_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_crew_contract()
    {
        $crew_code = $this->input->post('crew_code');
        $crew = $this->contracts->getCrewContract($crew_code);
        if (!empty($crew)) {
            foreach ($crew as $row) {
                $issued_by = $this->global->getAccountDetails($row['issued_by']);

                $list  = (($row['date_created'] === $row['contract_duration'] || $row['contract_duration'] <= date('Y-m-d')) ? "<li class='list-group-item' style='background: #ffe7e7;'> " : "<li class='list-group-item' >");
                $list  .= '<div class="row text-center">';
                $list  .= '<div class="col-md-3">';
                $list  .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14"> ' . $row['request_type'] . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Contract</p>';
                $list  .= '</div>';
                $list  .= '</div>';
                $list  .= '<div class="col-md-2">';
                $list  .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14" id="issued_by">' . $issued_by['full_name'] . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Issued By</p>';
                $list  .= '</div>';
                $list  .= '</div>';
                $list  .= '<div class="col-md-2">';
                $list  .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14">' . date('M j, Y', strtotime($row['date_created'])) . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Date Issued</p>';
                $list  .= '</div>';
                $list  .= '</div>';
                $list  .= '<div class="col-md-2">';
                $list  .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14">' . date('M j, Y', strtotime($row['contract_duration'])) . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Contract Expiration</p>';
                $list  .= '</div>';
                $list  .= '</div>';
                $list  .= '<div class="col-md-1">';
                $list  .= '<div class="m-0">';
                $list .= (($row['date_created'] === $row['contract_duration'] || $row['contract_duration'] <= date('Y-m-d')) ? "<h4 class='m-0 font-14 text-danger'>EXPIRED</h4>" : "<h4 class='m-0 font-14 text-success'>VALID</h4>");
                $list .= '<p class="mb-0 text-muted text-truncate">Status</p>';
                $list  .= '</div>';
                $list  .= '</div>';
                $list .= '<div class="col-md-1">';
                $list .= '<div class="m-0">';
                $list .= '<a href="javascript:void(0);"  onclick="downloadCrewContract()" class="btn btn-secondary btn-sm">Download</a>';
                $list .= '<input type="hidden" name="c_crew_code" id="c_crew_code" value="' . $row['crew_code'] . '">';
                $list  .= '</div>';
                $list  .= '</div>';
                $list  .= '</div>';
                $list  .= '</li>';
            }
        } else {
            $list = '<tr><td class="text-center" colspan="8">No data available in table</td></tr>';
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($list));
    }

    public function create_poea_contract()
    {
        $poea_contract_form_rules = $this->validations->rules['poea_contract_form'];
        $this->form_validation->set_rules($poea_contract_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'c_sirb_no'                 => form_error('c_sirb_no'),
                'c_src_no'                  => form_error('c_src_no'),
                'c_name_of_agent'           => form_error('c_name_of_agent'),
                'c_name_of_principal'       => form_error('c_name_of_principal'),
                'c_address_of_principal'    => form_error('c_address_of_principal'),
                'c_duration_contract'       => form_error('c_duration_contract'),
                'c_position'                => form_error('c_position'),
                'c_monthly_salary'          => form_error('c_monthly_salary'),
                'c_year_built'              => form_error('c_year_built'),
                'c_flag'                    => form_error('c_flag'),
                'c_vessel_type'             => form_error('c_vessel_type'),
                'c_classification_society'  => form_error('c_classification_society'),
                'c_hours_of_work'           => form_error('c_hours_of_work'),
                'c_vessel_name'             => form_error('c_vessel_name'),
                'c_imo_number'              => form_error('c_imo_number'),
                'c_gross_tonnage'           => form_error('c_gross_tonnage'),
                'c_overtime'                => form_error('c_overtime'),
                'c_vacation_leave_with_pay' => form_error('c_vacation_leave_with_pay'),
                'c_others'                  => form_error('c_others'),
                'c_total_salary'            => form_error('c_total_salary'),
                'c_point_of_hire'           => form_error('c_point_of_hire'),
                'c_collective_agreement'    => form_error('c_collective_agreement'),
                'type'                      => 'warning',
                'title'                     => 'Please complete all the required fields.'
            ];
        } else {
            $result = $this->contracts->addPOEAContract();

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
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function create_mlc_contract()
    {
        $mlc_contract_form_rules = $this->validations->rules['mlc_contract_form'];
        $this->form_validation->set_rules($mlc_contract_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'c_mlc_contract'            => form_error('c_mlc_contract'),
                'mlc_farer_passport'        => form_error('mlc_farer_passport'),
                'mlc_farer_book'            => form_error('mlc_farer_book'),
                'mlc_farer_license'         => form_error('mlc_farer_license'),
                'mlc_farer_sex'             => form_error('mlc_farer_sex'),
                'mlc_sign_place'            => form_error('mlc_sign_place'),
                'mlc_sign_date'             => form_error('mlc_sign_date'),
                'mlc_bw'                    => form_error('mlc_bw'),
                'mlc_ot'                    => form_error('mlc_ot'),
                'mlc_pl'                    => form_error('mlc_pl'),
                'mlc_sa'                    => form_error('mlc_sa'),
                'mlc_rb'                    => form_error('mlc_rb'),
                'mlc_mts'                   => form_error('mlc_mts'),
                'mlc_fksu'                  => form_error('mlc_fksu'),
                'mlc_mt'                    => form_error('mlc_mt'),
                'mlc_employment_period_from'     => form_error('mlc_employment_period_from'),
                'mlc_employment_period_to'     => form_error('mlc_employment_period_to'),
                'mlc_shipowner_vessel'      => form_error('mlc_shipowner_vessel'),
                'mlc_vp_alphera'            => form_error('mlc_vp_alphera'),
                'type'                      => 'warning',
                'title'                     => 'Please complete all the required fields.'
            ];
        } else {
            $result = $this->contracts->addMLCContract();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Added MLC Contract Successfully!'
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

    public function view_template($crew_code)
    {
        $data['crew_data'] = $this->contracts->getCrewContractById($crew_code);
        $this->load->view('include/header');
        $this->load->view('pdf/contract_template', $data);
        $this->load->view('include/script');
    }

    public function contract_table()
    {
        $data = [];
        $conditions = [];
        $conditions['crew_code'] = $this->input->post('crew_code');
        $count = 1;
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length =  intval($this->input->post('length'));

        if ($conditions) {
            $total_crew = $this->contracts->getCrewContractTable($conditions);
        }

        if ($total_crew) {
            foreach ($total_crew as $row) {

                $action = '
                    <div class="btn-group" role="group" aria-label="">
                        <button type="button" class="btn btn-outline-primary btn-xs" onclick="printContract(\'' . $row['contract_code'] . '\')">
                            <i class="mdi mdi-download font-16"></i>
                        </button>';
                if ($row['status'] == "1") {
                    $action .= "
                        <button type=\"button\" class=\"btn btn-outline-primary btn-xs\" onclick=\"updatePOEAv2('{$row['crew_code']}')\"><i class=\"mdi mdi-pencil font-16\"></i></button>
                        <button type=\"button\" class=\"btn btn-outline-primary btn-xs\">
                            <i class=\"mdi mdi-delete font-16\" onclick=\"removeContract('{$row['contract_code']}','{$row['crew_monitor']}' ,'{$row['crew_code']}')\">
                            </i>
                        </button>";
                } else {
                    $action .= "
                        <button type=\"button\" class=\"btn btn-outline-primary btn-xs\" onclick=\"viewPOEAv2('{$row['crew_code']}', '{$row['contract_code']}')\">
                            <i class=\"mdi mdi-eye font-16\"></i>
                        </button>
                    ";
                }

                $action .= "</div>";

                $data[] = array(
                    $count++,
                    'POEA Contract',
                    date('M j, Y', strtotime($row['contract_duration'])),
                    $this->global->getAccountDetails($row['issued_by'])['full_name'],
                    date('M j, Y h:m A', strtotime($row['date_created'])),
                    $this->global->getContractStatus($row['status']),
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

    public function mlc_table()
    {
        $data = [];
        $conditions = [];
        $count = 1;
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length =  intval($this->input->post('length'));
        $conditions['crew_code'] = $this->input->post('crew_code');

        if ($conditions) {
            $total_crew = $this->contracts->getMLCTable($conditions);
        }

        if ($total_crew) {
            foreach ($total_crew as $row) {
                $action = '
                    <div class="btn-group" role="group" aria-label="">
                        <button type="button" class="btn btn-outline-primary btn-xs">
                            <i class="mdi mdi-download font-16" onclick="printContractMlc(\'' . $row['monitor_code'] . '\',\'' . $row['mlc_type'] . '\')"></i>
                        </button>';

                if ($row['status'] == "1") {
                    $action .= "
                        <button type=\"button\" class=\"btn btn-outline-primary btn-xs\" onclick=\"updateMLCv2('{$row['crew_code']}')\"><i class=\"mdi mdi-pencil font-16\"></i></button>
                        <button type=\"button\" class=\"btn btn-outline-primary btn-xs\" onclick=\"removeMlcContract('{$row['monitor_code']}')\">
                            <i class=\"mdi mdi-delete font-16\"></i>
                        </button>";
                } else {
                    $action .= "
                        <button type=\"button\" class=\"btn btn-outline-primary btn-xs\" onclick=\"viewMLCv2('{$row['crew_code']}')\">
                            <i class=\"mdi mdi-eye font-16\"></i>
                        </button>";
                }

                $action .= "</div>";

                if ($row['mlc_type'] === 1) {
                    $mlc_type = "KOREAN FLAG";
                } else if ($row['mlc_type'] === 2) {
                    $mlc_type = "PANAMA FLAG";
                } else {
                    $mlc_type = "MARSHALL FLAG";
                }

                $data[] = array(
                    $count++,
                    'MLC Contract',
                    $mlc_type,
                    $this->global->getAccountDetails($row['issued_by'])['full_name'],
                    date('M j, Y h:m A', strtotime($row['date_created'])),
                    $this->global->getContractStatus($row['status']),
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

    public function remove_poea_contract()
    {
        $contract_code = $this->input->post('contract_code');
        $monitor_code = $this->input->post('monitor_code');
        $crew_code = $this->input->post('crew_code');

        $result = $this->contracts->remove_poe_contract($contract_code);
        if ($result === true) {

            $return_update_cm_plan = $this->contracts->updateDisemContDateCMPlan($monitor_code);

            if ($return_update_cm_plan) {
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

    public function remove_mlc_contract()
    {
        $mlc_code = $this->input->post('mlc_code');

        $result = $this->contracts->remove_mlc_contract($mlc_code);
        if ($result === true) {
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
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_mlc_details()
    {
        $crew_code = $this->input->post('code');
        $crew = $this->global->getCrewInformation($crew_code);

        $result = $this->contracts->getCrewMlcByMonCode($crew['monitor_code']);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_poea_details()
    {
        $crew_code = $this->input->post('code');

        $result = $this->contracts->getCrewContract($crew_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
    public function get_view_poea_details()
    {
        $crew_code = $this->input->post('code');
        $contract_code = $this->input->post('contract_code');

        $result = $this->contracts->getViewCrewContracts($crew_code, $contract_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function update_mlc_promotion()
    {
        $edit_mlc_contract_form_rules = $this->validations->rules['edit_mlc_contract_form'];
        $this->form_validation->set_rules($edit_mlc_contract_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'edit_mlc_sign_place'        => form_error('edit_mlc_sign_place'),
                'edit_mlc_sign_date'         => form_error('edit_mlc_sign_date'),
                'edit_mlc_bw'               => form_error('edit_mlc_bw'),
                'edit_mlc_ot'               => form_error('edit_mlc_ot'),
                'edit_mlc_pl'               => form_error('edit_mlc_pl'),
                'edit_mlc_sa'               => form_error('edit_mlc_sa'),
                'edit_mlc_rb'               => form_error('edit_mlc_rb'),
                'edit_mlc_mts'              => form_error('edit_mlc_mts'),
                'edit_mlc_fksu'             => form_error('edit_mlc_fksu'),
                'edit_mlc_mt'               => form_error('edit_mlc_mt'),
                'edit_mlc_employment_period_from'   => form_error('edit_mlc_employment_period_from'),
                'edit_mlc_employment_period_to'     => form_error('edit_mlc_employment_period_to'),
                'type'                      => 'warning',
                'title'                     => 'Please complete all the required fields.'
            ];
        } else {
            $result = $this->contracts->addMLCContractPromotion();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Update MLC Contract!',
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Update MLC Contract!',
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function update_poea_promotion()
    {
        $edit_poea_contract_form_rules = $this->validations->rules['edit_poea_contract_form'];
        $this->form_validation->set_rules($edit_poea_contract_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_sirb_no'                 => form_error('e_sirb_no'),
                'e_src_no'                  => form_error('e_src_no'),
                'e_name_of_agent'           => form_error('e_name_of_agent'),
                'e_name_of_principal'       => form_error('e_name_of_principal'),
                'e_address_of_principal'    => form_error('e_address_of_principal'),
                'e_duration_contract'       => form_error('e_duration_contract'),
                'e_position'                => form_error('e_position'),
                'e_monthly_salary'          => form_error('e_monthly_salary'),
                'e_year_built'              => form_error('e_year_built'),
                'e_flag'                    => form_error('e_flag'),
                'e_vessel_type'             => form_error('e_vessel_type'),
                'e_classification_society'  => form_error('e_classification_society'),
                'e_hours_of_work'           => form_error('e_hours_of_work'),
                'e_vessel_name'             => form_error('e_vessel_name'),
                'e_imo_number'              => form_error('e_imo_number'),
                'e_gross_tonnage'           => form_error('e_gross_tonnage'),
                'e_overtime'                => form_error('e_overtime'),
                'e_vacation_leave_with_pay' => form_error('e_vacation_leave_with_pay'),
                'e_others'                  => form_error('e_others'),
                'e_total_salary'            => form_error('e_total_salary'),
                'e_point_of_hire'           => form_error('e_point_of_hire'),
                'e_collective_agreement'    => form_error('e_collective_agreement'),
                'type'                      => 'warning',
                'title'                     => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->contracts->update_poea_promotion();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Update POEA Contract!',
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Update POEA Contract!',
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
