<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Embarked extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }

        $this->perPage = 30;

        if ($this->session->userdata('url') != 'crew-embarked') {
            $this->embarked_search_reset();
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

    public function index()
    {
        $data = [];
        $conditions = [];

        $this->session->set_userdata('url', 'crew-embarked');

        $conditions['search']['name_search'] = $this->session->userdata('cmp_name_search');
        $conditions['search']['vessel_search'] = $this->session->userdata('vessel_search');
        $conditions['search']['rank_search'] = $this->session->userdata('rank_search');
        $conditions['search']['contract_search'] = $this->session->userdata('contract_search');
        $conditions['search']['flight_search'] = $this->session->userdata('flight_search');
        $conditions['search']['month_search_to'] = $this->session->userdata('month_search_to');
        $conditions['search']['month_search_from'] = $this->session->userdata('month_search_from');

        if ($conditions) {
            $total_crews = count($this->embark->getCrewEmbarked($conditions));
        } else {
            $total_crews = count($this->embark->getCrewEmbarked());
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url('crew-embarked');
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
            $data['crew'] = $this->embark->getCrewEmbarked($conditions);
        } else {
            $data['crew'] = $this->embark->getCrewEmbarked();
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
        $data['title_tag'] = "Embarked | Alphera Marine Services, Inc.";
        $data['meta_description'] = "";

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('modal/crew_filter');
        $this->load->view('modal/crew/v_off_signer_info');
        $this->load->view('modal/crew/v_e_pre_joining_visa');
        $this->load->view('modal/crew/v_prejoining_visa');
        $this->load->view('modal/crew/v_e_crew_info');
        $this->load->view('modal/crew/contracts/v_contracts');
        $this->load->view('modal/crew/medical/v_medical');
        $this->load->view('modal/crew/medical/e_medical');
        $this->load->view('modal/crew/contracts/e_mlc_contract');
        $this->load->view('modal/crew/contracts/e_poea_contract');
        $this->load->view('modal/crew/a_warning_letter');
        $this->load->view('modal/crew/promotion_checklist');
        $this->load->view('modal/crew/e_position_promotion');
        $this->load->view('modal/crew/e_position_vessel');
        $this->load->view('modal/crew/a_assign_as_onsigner');
        $this->load->view('crew/embarked');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function embarked_crew_search()
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

    function embarked_search_reset()
    {
        $this->session->unset_userdata('cmp_name_search');
        $this->session->unset_userdata('vessel_search');
        $this->session->unset_userdata('rank_search');
        $this->session->unset_userdata('contract_search');
        $this->session->unset_userdata('flight_search');
        $this->session->unset_userdata('month_search_to');
        $this->session->unset_userdata('month_search_from');
    }

    public function check_promotion_details()
    {
        $crew_code = $this->input->post('code');
        $result = $this->promotions->check_promotion_req($crew_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function update_mlc_promotion()
    {
        $edit_mlc_contract_form_rules = $this->validations->rules['promotion_mlc_contract_form'];
        $this->form_validation->set_rules($edit_mlc_contract_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'promotion_mlc_sign_place'        => form_error('promotion_mlc_sign_place'),
                'promotion_mlc_sign_date'         => form_error('promotion_mlc_sign_date'),
                'promotion_mlc_bw'               => form_error('promotion_mlc_bw'),
                'promotion_mlc_ot'               => form_error('promotion_mlc_ot'),
                'promotion_mlc_pl'               => form_error('promotion_mlc_pl'),
                'promotion_mlc_sa'               => form_error('promotion_mlc_sa'),
                'promotion_mlc_rb'               => form_error('promotion_mlc_rb'),
                'promotion_mlc_mts'              => form_error('promotion_mlc_mts'),
                'promotion_mlc_fksu'             => form_error('promotion_mlc_fksu'),
                'promotion_mlc_mt'               => form_error('promotion_mlc_mt'),
                'promotion_mlc_employment_period_from'   => form_error('promotion_mlc_employment_period_from'),
                'promotion_mlc_employment_period_to'     => form_error('promotion_mlc_employment_period_to'),
                'type'                      => 'warning',
                'title'                     => 'Please complete all the required fields.'
            ];
        } else {
            $result = $this->promotions->addMLCContractPromotion();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Update MLC Contract!',
                    'text'  => 'Successfully update MLC contract for promotion.'
                ];
            } elseif ($result === "for_approval") {
                $data = [
                    'type' => 'success',
                    'title' => 'Update MLC Contract!',
                    'text'  => 'Success!, Crew promotion is now subject for approval.'
                ];
            } elseif ($result === "add_pos_vsl") {
                $data = [
                    'type' => 'warning',
                    'title' => 'Update MLC Contract!',
                    'text'  => 'Indicate new position and vessel before adding new MLC contract!'
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Update MLC Contract!',
                    'text'  => 'Failed to update MLC contract for promotion.'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function update_poea_promotion()
    {
        $edit_poea_contract_form_rules = $this->validations->rules['promotion_poea_contract_form'];
        $this->form_validation->set_rules($edit_poea_contract_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'promotion_sirb_no'                 => form_error('promotion_sirb_no'),
                'promotion_src_no'                  => form_error('promotion_src_no'),
                'promotion_name_of_agent'           => form_error('promotion_name_of_agent'),
                'promotion_name_of_principal'       => form_error('promotion_name_of_principal'),
                'promotion_address_of_principal'    => form_error('promotion_address_of_principal'),
                'promotion_duration_contract'       => form_error('promotion_duration_contract'),
                'promotion_position'                => form_error('promotion_position'),
                'promotion_monthly_salary'          => form_error('promotion_monthly_salary'),
                'promotion_year_built'              => form_error('promotion_year_built'),
                'promotion_flag'                    => form_error('promotion_flag'),
                'promotion_vessel_type'             => form_error('promotion_vessel_type'),
                'promotion_classification_society'  => form_error('promotion_classification_society'),
                'promotion_hours_of_work'           => form_error('promotion_hours_of_work'),
                'promotion_vessel_name'             => form_error('promotion_vessel_name'),
                'promotion_imo_number'              => form_error('promotion_imo_number'),
                'promotion_gross_tonnage'           => form_error('promotion_gross_tonnage'),
                'promotion_overtime'                => form_error('promotion_overtime'),
                'promotion_vacation_leave_with_pay' => form_error('promotion_vacation_leave_with_pay'),
                'promotion_others'                  => form_error('promotion_others'),
                'promotion_total_salary'            => form_error('promotion_total_salary'),
                'promotion_point_of_hire'           => form_error('promotion_point_of_hire'),
                'promotion_collective_agreement'    => form_error('promotion_collective_agreement'),
                'type'                      => 'warning',
                'title'                     => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->promotions->update_poea_promotion();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Update POEA Contract!',
                    'text'  => 'Successfully update POEA contract for promotion.'
                ];
            } elseif ($result === "for_approval") {
                $data = [
                    'type' => 'success',
                    'title' => 'Update POEA Contract!',
                    'text'  => 'Success!, Crew promotion is now subject for approval.'
                ];
            } elseif ($result === "add_pos_vsl") {
                $data = [
                    'type' => 'warning',
                    'title' => 'Update POEA Contract!',
                    'text'  => 'Indicate new position and vessel before adding new POEA contract!'
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Update POEA Contract!',
                    'text'  => 'Failed to update POEA contract for promotion.'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_crew_details_promotion()
    {
        $crew_code = $this->input->post('code');

        $result = $this->all_crew->searchCrewById($crew_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    // public function check_position_demote_promote()
    // {
    //     $crew_code = $this->input->post('hidden_crew_code');
    //     $crew_details = $this->global->getCrew($crew_code);

    //     if (condition) {
    //         # code...
    //     } else {
    //         # code...
    //     }

    // }

    public function promote_crew_onboard()
    {
        $edit_position_promotion_rules = $this->validations->rules['edit_position_promotion'];
        $this->form_validation->set_rules($edit_position_promotion_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'epp_tentative_vessel'      => form_error('epp_tentative_vessel'),
                'epp_position'              => form_error('epp_position'),
                'type'                      => 'warning',
                'title'                     => 'Please complete all the required fields.'
            ];
        } else {

            $crew_code = $this->input->post('hidden_crew_code');
            $position = $this->input->post('epp_position');

            $check = $this->promotions->check_promotion_qualifications($crew_code, $position);
            if ($check === true) {
                $result = $this->promotions->promote_crew_onboard();

                if ($result === true) {
                    $data = [
                        'type' => 'success',
                        'title' => 'Promote Crew!',
                        'text'  => 'Crew new position and vessel are up for promotion, 
                                    please complete other requirements to successfully promote this crew.'
                    ];
                } else if ($result === "demote") {
                    $data = [
                        'type' => 'success',
                        'title' => 'Demote Crew!',
                        'text'  => 'Crew new position and vessel are up for demotion, 
                                    please complete other requirements to successfully demote this crew.'
                    ];
                } else {
                    $data = [
                        'type' => 'error',
                        'title' => 'Promote Crew!',
                        'text'  => 'Something went wrong in crew promotion.'
                    ];
                }
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Promote Crew!',
                    'text'  => 'Crew is not qualified for promotion due to lack of required experience.'
                ];
            }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }


    public function crew_embarked_get_embark_disembark()
    {
        $offsigner_mnt_code = $this->input->post("offsigner_code");
        $onsigner_mnt_code = $this->input->post("onsigner_code");

        $get_offsigner_disembark = $this->embark->getOffSignerDisembark($offsigner_mnt_code);
        // $get_onsigner_disembark = $this->embark->getOnSignerDisembark($onsigner_mnt_code);


        $data = [
            "offsigner_disembark_date" => $get_offsigner_disembark['disembark'],
            // "onsigner_disembark_date" => $get_onsigner_disembark['disembark'],
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }


    public function crew_embarked_assign_offsigner()
    {
        $assign_as_on_signer_rules = $this->validations->rules['assign_as_on_signer'];
        $this->form_validation->set_rules($assign_as_on_signer_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'a_offsigner' => form_error('a_offsigner'),
                'a_embarked_date' => form_error('a_embarked_date'),
                'a_disembarked_date' => form_error('a_disembarked_date'),
                'type' => 'warning',
                'title' => 'Please complete all the required fields.'
            ];
        } else {
            $return = $this->embark->selectOnsignerForEmbark();

            if ($return === true) {
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


    public function validate_disembark_date()
    {
        $disembark_date = $this->input->post("a_disembarked_date");
        $embark_date = $this->input->post("a_embarked_date");

        if (date('Y-m-d', strtotime($disembark_date)) < date('Y-m-d', strtotime($embark_date)) || date('Y-m-d', strtotime($disembark_date)) < date('Y-m-d')) {
            $this->form_validation->set_message('validate_disembark_date', '%s cannot be in the past date or before embarked date.');
            return false;
        } else {
            // Your date is not in the past
            return true;
        }
    }
}
