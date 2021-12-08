<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_promotions extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    function get_crew_promotion($params = array())
    {
        $crew_status = [1, 2, 3, 4];

        $this->db->select("
            c.crew_code,
            c.monitor_code,
            c.position,
            c.date_available,
            cc.contract_duration,
            c.status,
            cm.insigner,
            cm.offsigner,
            cm.embark,
            cm.disembark,
            cm.sign_on,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            av.vsl_code,
            ac.description city_name,
            apr.description province_name,
            acpc.status as promotion_status,
            acpc.date_created as p_date
        ");

        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");
        $this->db->join("(SELECT * FROM crew_poea ORDER BY id DESC LIMIT 1) cc", "c.monitor_code = cc.crew_monitor", "LEFT");
        $this->db->join("cm_plan cm", "c.monitor_code = cm.offsigner", "LEFT");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("ac_promoted_crew_onboard acpc", "c.crew_code = acpc.crew_code", "LEFT");

        $this->db->group_start();
        if ($crew_status) {
            $count = 0;
            foreach ($crew_status as $key) {
                if ($count == 0) {
                    $this->db->where("c.status", $key);
                } else {
                    $this->db->or_where("c.status", $key);
                }
                $count++;
            }
        }
        $this->db->group_end();

        $this->db->order_by("c.date_created", "DESC");
        $this->db->group_by('c.crew_code');


        if (!empty($params['search']['contract_search'])) {
            $this->db->group_start();

            $NewDate = Date('Y-m-d', strtotime($params['search']['contract_search']));
            $this->db->join("crew_poea cp", "cp.crew_code = c.crew_code", "LEFT");

            if ($params['search']['contract_search'] === "+30 days") {
                // LESS THAN 30 DAYS
                $this->db->where('cp.contract_duration <=', $NewDate);
            } else if ($params['search']['contract_search'] === "+60 days") {
                // LESS THAN 60 DAYS
                $this->db->where('cp.contract_duration <=', $NewDate);
            } else if ($params['search']['contract_search'] === "+90 days") {
                // LESS THAN 90 DAYS
                $this->db->where('cp.contract_duration <=', $NewDate);
            } else {
                // 90 ABOVE
                $this->db->where('cp.contract_duration >=', $NewDate);
            }
            $this->db->group_end();
        }

        if (!empty($params['search']['name_search'])) {
            $this->db->group_start();
            $this->db->like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.middle_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.last_name, acpi.first_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->group_end();
        }
        // if (!empty($params['search']['name_search'])) {
        //     $this->db->group_start();
        //     $this->db->or_like('acpi.middle_name', $params['search']['name_search']);
        //     $this->db->group_end();
        // }
        // if (!empty($params['search']['name_search'])) {
        //     $this->db->group_start();
        //     $this->db->or_like('acpi.last_name', $params['search']['name_search']);
        //     $this->db->group_end();
        // }

        if (!empty($params['search']['vessel_search'])) {
            $this->db->group_start();
            $this->db->where('c.vessel_assign', $params['search']['vessel_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['rank_search'])) {
            $this->db->group_start();
            $this->db->like('c.position', $params['search']['rank_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['status_search'])) {
            $this->db->group_start();
            $this->db->like('c.status', $params['search']['status_search']);
            $this->db->group_end();
        }

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function get_promotion_details($crew_code)
    {
        return $this->db->where(array('crew_code' => $crew_code, 'status' => 0))->get('ac_promoted_crew_onboard')->row_array();
    }

    public function get_promotion_request_details($approval_code, $crew_code)
    {
        $this->db->select("
            aca.*,
            c.position,
            c.vessel_assign,
            c.date_created as crew_entry,
            aced.school,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            cg.grade
        ");

        $this->db->from("ac_approvals aca");
        $this->db->join("crews c", "c.crew_code = aca.crew_code");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_educational_attainment aced", "aced.crew_code = aca.crew_code", "LEFT");
        $this->db->join("crew_grade cg", "cg.crew_code = aca.crew_code", "LEFT");

        $this->db->where(array('aca.approval_code' => $approval_code, 'aca.crew_code' => $crew_code, 'aca.status' => 2));
        $this->db->group_by('aca.crew_code');

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function check_promotion_req($crew_code)
    {
        $promotion = $this->get_promotion_details($crew_code);
        if (!empty($promotion)) {
            if (!empty($promotion['new_poea_contract'])  && !empty($promotion['new_mlc_contract']) && $promotion['position'] != NULL) {
                $status = "completed";
            } else if (!empty($promotion['new_mlc_contract'])  && empty($promotion['new_poea_contract']) && $promotion['position'] === NULL) {
                $status = "with_mlc";
            } else if (!empty($promotion['new_poea_contract'])  && empty($promotion['new_mlc_contract']) && $promotion['position'] === NULL) {
                $status = "with_poea";
            } else if (empty($promotion['new_poea_contract'])  && empty($promotion['new_mlc_contract']) && $promotion['position'] != NULL) {
                $status = "with_pos_vess";
            } else if (empty($promotion['new_mlc_contract'])  && !empty($promotion['new_poea_contract']) && $promotion['position'] != NULL) {
                $status = "mlc";
            } else if (empty($promotion['new_poea_contract'])  && !empty($promotion['new_mlc_contract']) && $promotion['position'] != NULL) {
                $status = "poea";
            } else if (!empty($promotion['new_poea_contract'])  && !empty($promotion['new_mlc_contract']) && $promotion['position'] != NULL) {
                $status = "no_vessel_rank";
            } else {
                $status = "incomplete";
            }
        } else {
            $status = "incomplete";
        }

        return $status;
    }

    public function addMLCContractPromotion()
    {
        $crew_code = $this->input->post('promotion_crew_code');
        $monitor_code = $this->global->getCrew($crew_code)['monitor_code'];
        $promotion_data = $this->db->where(array('monitor_code' => $monitor_code, 'crew_code' => $crew_code))->get('ac_promoted_crew_onboard')->row_array();

        $wage = [
            $this->input->post('promotion_mlc_bw'), $this->input->post('promotion_mlc_ot'), $this->input->post('promotion_mlc_pl'), $this->input->post('promotion_mlc_sa'),
            $this->input->post('promotion_mlc_rb'), $this->input->post('promotion_mlc_mts'), $this->input->post('promotion_mlc_fksu'), $this->input->post('promotion_mlc_mt')
        ];
        $agreement_details = [$this->input->post('promotion_mlc_sign_place'), date('Y-m-d', strtotime($this->input->post('promotion_mlc_sign_date')))];
        $employment_period = [$this->input->post('promotion_mlc_employment_period_from'), $this->input->post('promotion_mlc_employment_period_to')];

        if (!empty($promotion_data)) {
            if ($promotion_data['new_poea_contract']) {
                $poea_details = json_decode($promotion_data['new_poea_contract'], true);
                if ($poea_details['promoted'] === 1 && $promotion_data['position'] != NULL) {

                    $data = [
                        'mlc_contract_code'         => $this->global->generateID("MLC"),
                        'monitor_code'              => $monitor_code,
                        'crew_code'                 => $crew_code,
                        'vessel_name'               => $this->input->post('promotion_mlc_vessel_name'),
                        'vessel_type'               => $this->input->post('promotion_mlc_vessel_type'),
                        'crew_name'                 => $this->input->post('promotion_mlc_farer_name'),
                        'duty'                      => $this->input->post('promotion_mlc_farer_duty'),
                        'birthdate'                 => $this->input->post('promotion_mlc_farer_birthdate'),
                        'nationality'               => $this->input->post('promotion_mlc_farer_nationality'),
                        'passport_no'               => $this->input->post('promotion_mlc_farer_passport'),
                        'mlc_type'                  => $this->input->post('promotion_edit_mlc_contract'),
                        'form_no'                   => $this->input->post('promotion_mlc_form_number'),
                        'revision_no'               => $this->input->post('promotion_mlc_revision_number'),
                        'gender'                    => $this->input->post('promotion_mlc_farer_sex'),
                        'seamans_book'              => $this->input->post('promotion_mlc_farer_book'),
                        'license_no'                => $this->input->post('promotion_mlc_farer_license'),
                        'shipowner_vessel'          => $this->input->post('promotion_mlc_shipowner_vessel'),
                        'name_of_vp'                => $this->input->post('promotion_mlc_vp_alphera'),
                        'date_created'              => date('Y-m-d H:i:s'),
                        'issued_by'                 => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                        'status'                    => 1,
                        'agreement_details'         => json_encode($agreement_details),
                        'wage'                      => json_encode($wage),
                        'employment_period'         => json_encode($employment_period),
                        'promoted'                  => 1,
                    ];

                    $ac_promoted_crew = ['new_mlc_contract' => json_encode($data)];

                    $approval_data = [
                        'approval_code' => $this->global->generateID("APR"),
                        'crew_code'     => $crew_code,
                        'department'    => "crew management",
                        'request_type'  => "promotion",
                        'request_by'    => $this->session->userdata('user_code'),
                        'details'       => json_encode($data),
                        'remarks'       => "Crew subject for promotion.",
                        'date_created'  => date('Y-m-d H:i:s'),
                        'status'        => 2
                    ];

                    $db_archive = $this->load->database('archive', TRUE);

                    $this->db->trans_begin();

                    $this->db->where(array('monitor_code' => $monitor_code, 'crew_code' => $crew_code))->update('ac_promoted_crew_onboard', $ac_promoted_crew);
                    $this->db->where(array('crew_code' => $crew_code))->set('status', 0)->update('crew_mlc');
                    $this->db->insert('ac_approvals', $approval_data);

                    $db_archive->insert('arc_approvals', $approval_data);

                    if ($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                        return false;
                    } else {
                        $this->db->trans_commit();
                        return 'for_approval';
                    }
                } else {

                    $data = [
                        'mlc_contract_code'         => $this->global->generateID("MLC"),
                        'monitor_code'              => $monitor_code,
                        'crew_code'                 => $crew_code,
                        'vessel_name'               => $this->input->post('promotion_mlc_vessel_name'),
                        'vessel_type'               => $this->input->post('promotion_mlc_vessel_type'),
                        'crew_name'                 => $this->input->post('promotion_mlc_farer_name'),
                        'duty'                      => $this->input->post('promotion_mlc_farer_duty'),
                        'birthdate'                 => $this->input->post('promotion_mlc_farer_birthdate'),
                        'nationality'               => $this->input->post('promotion_mlc_farer_nationality'),
                        'passport_no'               => $this->input->post('promotion_mlc_farer_passport'),
                        'mlc_type'                  => $this->input->post('promotion_edit_mlc_contract'),
                        'form_no'                   => $this->input->post('promotion_mlc_form_number'),
                        'revision_no'               => $this->input->post('promotion_mlc_revision_number'),
                        'gender'                    => $this->input->post('promotion_mlc_farer_sex'),
                        'seamans_book'              => $this->input->post('promotion_mlc_farer_book'),
                        'license_no'                => $this->input->post('promotion_mlc_farer_license'),
                        'shipowner_vessel'          => $this->input->post('promotion_mlc_shipowner_vessel'),
                        'name_of_vp'                => $this->input->post('promotion_mlc_vp_alphera'),
                        'date_created'              => date('Y-m-d H:i:s'),
                        'issued_by'                 => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                        'status'                    => 1,
                        'agreement_details'         => json_encode($agreement_details),
                        'wage'                      => json_encode($wage),
                        'employment_period'         => json_encode($employment_period),
                        'promoted'                  => 1,
                    ];

                    $ac_promoted_crew = ['new_mlc_contract' => json_encode($data)];

                    $this->db->trans_begin();

                    $this->db->where(array('crew_code' => $crew_code, 'status' => 1))->update('ac_promoted_crew_onboard', $ac_promoted_crew);

                    if ($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                        return false;
                    } else {
                        $this->db->trans_commit();
                        return true;
                    }
                }
            } else {

                $data = [
                    'mlc_contract_code'         => $this->global->generateID("MLC"),
                    'monitor_code'              => $monitor_code,
                    'crew_code'                 => $crew_code,
                    'vessel_name'               => $this->input->post('promotion_mlc_vessel_name'),
                    'vessel_type'               => $this->input->post('promotion_mlc_vessel_type'),
                    'crew_name'                 => $this->input->post('promotion_mlc_farer_name'),
                    'duty'                      => $this->input->post('promotion_mlc_farer_duty'),
                    'birthdate'                 => $this->input->post('promotion_mlc_farer_birthdate'),
                    'nationality'               => $this->input->post('promotion_mlc_farer_nationality'),
                    'passport_no'               => $this->input->post('promotion_mlc_farer_passport'),
                    'mlc_type'                  => $this->input->post('promotion_edit_mlc_contract'),
                    'form_no'                   => $this->input->post('promotion_mlc_form_number'),
                    'revision_no'               => $this->input->post('promotion_mlc_revision_number'),
                    'gender'                    => $this->input->post('promotion_mlc_farer_sex'),
                    'seamans_book'              => $this->input->post('promotion_mlc_farer_book'),
                    'license_no'                => $this->input->post('promotion_mlc_farer_license'),
                    'shipowner_vessel'          => $this->input->post('promotion_mlc_shipowner_vessel'),
                    'name_of_vp'                => $this->input->post('promotion_mlc_vp_alphera'),
                    'date_created'              => date('Y-m-d H:i:s'),
                    'issued_by'                 => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                    'status'                    => 1,
                    'agreement_details'         => json_encode($agreement_details),
                    'wage'                      => json_encode($wage),
                    'employment_period'         => json_encode($employment_period),
                    'promoted'                  => 1,
                ];

                $ac_promoted_crew = ['new_mlc_contract' => json_encode($data)];

                $this->db->trans_begin();

                $this->db->where(array('crew_code' => $crew_code, 'monitor_code' => $monitor_code))->update('ac_promoted_crew_onboard', $ac_promoted_crew);

                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return true;
                }
            }
        } else {
            return "add_pos_vsl";
        }
    }

    public function update_poea_promotion()
    {
        $crew_code = $this->input->post('promotion_hid_crew_code');
        $monitor_code = $this->global->getCrew($crew_code)['monitor_code'];
        $promotion_data = $this->db->where(array('monitor_code' => $monitor_code, 'crew_code' => $crew_code))->get('ac_promoted_crew_onboard')->row_array();

        if (!empty($promotion_data)) {
            if ($promotion_data['new_mlc_contract']) {
                $mlc_details = json_decode($promotion_data['new_mlc_contract'], true);
                if ($mlc_details['promoted'] === 1 && $promotion_data['position'] != NULL) {

                    $data = [
                        'contract_code'         => $this->global->generateID("CRT"),
                        'crew_code'             => $crew_code,
                        'crew_monitor'          => $monitor_code,
                        'sirb_no'               => $this->input->post('promotion_sirb_no'),
                        'src_no'                => $this->input->post('promotion_src_no'),
                        'license'               => $this->input->post('promotion_license_no'),
                        'agent_name'            => $this->input->post('promotion_name_of_agent'),
                        'ps_name'               => $this->input->post('promotion_name_of_principal'),
                        'ps_address'            => $this->input->post('promotion_address_of_principal'),
                        'vessel_name'           => $this->input->post('promotion_vessel_name'),
                        'imo_no'                => $this->input->post('promotion_imo_number'),
                        'grt'                   => $this->input->post('promotion_gross_tonnage'),
                        'year_build'            => date('Y-m-d', strtotime($this->input->post('promotion_year_built'))),
                        'flag'                  => $this->input->post('promotion_flag'),
                        'vessel_type'           => $this->input->post('promotion_vessel_type'),
                        'society_classification' => $this->input->post('promotion_classification_society'),
                        'contract_duration'     => date('Y-m-d', strtotime($this->input->post('promotion_duration_contract'))),
                        'position'              => $this->input->post('promotion_position'),
                        'monthly_salary'        => $this->input->post('promotion_monthly_salary'),
                        'work_hours'            => $this->input->post('promotion_hours_of_work'),
                        'ot'                    => $this->input->post('promotion_overtime'),
                        'vl_pay'                => $this->input->post('promotion_vacation_leave_with_pay'),
                        'others'                => $this->input->post('promotion_others'),
                        'total_salary'          => $this->input->post('promotion_total_salary'),
                        'hire_point'            => $this->input->post('promotion_point_of_hire'),
                        'collective_agreement'  => $this->input->post('promotion_collective_agreement'),
                        'date_updated'          => date('Y-m-d H:i:s'),
                        'promoted'              => 1
                    ];

                    $ac_promoted_crew = ['new_poea_contract' => json_encode($data)];

                    $approval_data = [
                        'approval_code' => $this->global->generateID("APR"),
                        'crew_code'     => $crew_code,
                        'department'    => "crew management",
                        'request_type'  => "promotion",
                        'request_by'    => $this->session->userdata('user_code'),
                        'details'       => json_encode($data),
                        'remarks'       => "Crew subject for promotion.",
                        'date_created'  => date('Y-m-d H:i:s'),
                        'status'        => 2
                    ];

                    $db_archive = $this->load->database('archive', TRUE);

                    $this->db->trans_begin();

                    $this->db->where(array('monitor_code' => $monitor_code, 'crew_code' => $crew_code))->update('ac_promoted_crew_onboard', $ac_promoted_crew);
                    $this->db->where(array('crew_code' => $crew_code))->set('status', 0)->update('crew_poea');
                    $this->db->insert('ac_approvals', $approval_data);

                    $db_archive->insert('arc_approvals', $approval_data);

                    if ($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                        return false;
                    } else {
                        $this->db->trans_commit();
                        return 'for_approval';
                    }
                } else {
                    $data = [
                        'contract_code'         => $this->global->generateID("CRT"),
                        'crew_code'             => $crew_code,
                        'crew_monitor'          => $monitor_code,
                        'sirb_no'               => $this->input->post('promotion_sirb_no'),
                        'src_no'                => $this->input->post('promotion_src_no'),
                        'license'               => $this->input->post('promotion_license_no'),
                        'agent_name'            => $this->input->post('promotion_name_of_agent'),
                        'ps_name'               => $this->input->post('promotion_name_of_principal'),
                        'ps_address'            => $this->input->post('promotion_address_of_principal'),
                        'vessel_name'           => $this->input->post('promotion_vessel_name'),
                        'imo_no'                => $this->input->post('promotion_imo_number'),
                        'grt'                   => $this->input->post('promotion_gross_tonnage'),
                        'year_build'            => date('Y-m-d', strtotime($this->input->post('promotion_year_built'))),
                        'flag'                  => $this->input->post('promotion_flag'),
                        'vessel_type'           => $this->input->post('promotion_vessel_type'),
                        'society_classification' => $this->input->post('promotion_classification_society'),
                        'contract_duration'     => date('Y-m-d', strtotime($this->input->post('promotion_duration_contract'))),
                        'position'              => $this->input->post('promotion_position'),
                        'monthly_salary'        => $this->input->post('promotion_monthly_salary'),
                        'work_hours'            => $this->input->post('promotion_hours_of_work'),
                        'ot'                    => $this->input->post('promotion_overtime'),
                        'vl_pay'                => $this->input->post('promotion_vacation_leave_with_pay'),
                        'others'                => $this->input->post('promotion_others'),
                        'total_salary'          => $this->input->post('promotion_total_salary'),
                        'hire_point'            => $this->input->post('promotion_point_of_hire'),
                        'collective_agreement'  => $this->input->post('promotion_collective_agreement'),
                        'date_updated'          => date('Y-m-d H:i:s'),
                        'promoted'              => 1
                    ];

                    $ac_promoted_crew = ['new_poea_contract' => json_encode($data)];

                    $this->db->trans_begin();

                    $this->db->where(array('monitor_code' => $monitor_code, 'crew_code' => $crew_code))->update('ac_promoted_crew_onboard', $ac_promoted_crew);

                    if ($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                        return false;
                    } else {
                        $this->db->trans_commit();
                        return true;
                    }
                }
            } else {
                $data = [
                    'contract_code'         => $this->global->generateID("CRT"),
                    'crew_code'             => $crew_code,
                    'crew_monitor'          => $monitor_code,
                    'sirb_no'               => $this->input->post('promotion_sirb_no'),
                    'src_no'                => $this->input->post('promotion_src_no'),
                    'license'               => $this->input->post('promotion_license_no'),
                    'agent_name'            => $this->input->post('promotion_name_of_agent'),
                    'ps_name'               => $this->input->post('promotion_name_of_principal'),
                    'ps_address'            => $this->input->post('promotion_address_of_principal'),
                    'vessel_name'           => $this->input->post('promotion_vessel_name'),
                    'imo_no'                => $this->input->post('promotion_imo_number'),
                    'grt'                   => $this->input->post('promotion_gross_tonnage'),
                    'year_build'            => date('Y-m-d', strtotime($this->input->post('promotion_year_built'))),
                    'flag'                  => $this->input->post('promotion_flag'),
                    'vessel_type'           => $this->input->post('promotion_vessel_type'),
                    'society_classification' => $this->input->post('promotion_classification_society'),
                    'contract_duration'     => date('Y-m-d', strtotime($this->input->post('promotion_duration_contract'))),
                    'position'              => $this->input->post('promotion_position'),
                    'monthly_salary'        => $this->input->post('promotion_monthly_salary'),
                    'work_hours'            => $this->input->post('promotion_hours_of_work'),
                    'ot'                    => $this->input->post('promotion_overtime'),
                    'vl_pay'                => $this->input->post('promotion_vacation_leave_with_pay'),
                    'others'                => $this->input->post('promotion_others'),
                    'total_salary'          => $this->input->post('promotion_total_salary'),
                    'hire_point'            => $this->input->post('promotion_point_of_hire'),
                    'collective_agreement'  => $this->input->post('promotion_collective_agreement'),
                    'date_updated'          => date('Y-m-d H:i:s'),
                    'promoted'              => 1
                ];

                $ac_promoted_crew = ['new_poea_contract' => json_encode($data)];

                $this->db->trans_begin();

                $this->db->where(array('monitor_code' => $monitor_code, 'crew_code' => $crew_code))->update('ac_promoted_crew_onboard', $ac_promoted_crew);

                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return true;
                }
            }
        } else {
            return "add_pos_vsl";
        }
    }

    public function promote_crew_onboard()
    {
        $crew_code = $this->input->post('hidden_crew_code');
        $crew_details = $this->global->getCrew($crew_code);

        $cmp_details = $this->global->getCMP($crew_details['monitor_code']);

        if ($this->input->post('epp_position') > $crew_details['position']) {
            $ac_promoted_crew = [
                'monitor_code'  => $crew_details['monitor_code'],
                'crew_code'     => $crew_code,
                'vessel'        => $this->input->post('epp_tentative_vessel'),
                'position'      => $this->input->post('epp_position'),
                'old_position'  => $crew_details['position'],
                'old_vessel'    => $crew_details['vessel_assign'],
                'date_embarked' => $crew_details['embark_date'] ? $crew_details['embark_date'] : null,
                'disembark_date' => $cmp_details ? $cmp_details['disembark'] : null,
                'date_created'  => date('Y-m-d h:i:s'),
                'status'        => 0
            ];

            $this->db->trans_begin();

            $this->db->insert('ac_promoted_crew_onboard', $ac_promoted_crew);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return "demote";
            }
        } else {

            $ac_promoted_crew = [
                'monitor_code'  => $crew_details['monitor_code'],
                'crew_code'     => $crew_code,
                'vessel'        => $this->input->post('epp_tentative_vessel'),
                'position'      => $this->input->post('epp_position'),
                'old_position'  => $crew_details['position'],
                'old_vessel'    => $crew_details['vessel_assign'],
                'date_embarked' => $crew_details['embark_date'] ? $crew_details['embark_date'] : null,
                'disembark_date' => $cmp_details ? $cmp_details['disembark'] : null,
                'date_created'  => date('Y-m-d h:i:s'),
                'status'        => 0
            ];

            $this->db->trans_begin();

            $this->db->insert('ac_promoted_crew_onboard', $ac_promoted_crew);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
    }

    public function check_promotion_qualifications($crew_code, $position)
    {
        if ($position == "1") {
            $sea_service = $this->global->getSeaServiceRecord($crew_code);
            $rank = json_decode($sea_service['rank'], true);
            $embarked = json_decode($sea_service['embarked'], true);
            $disembarked = json_decode($sea_service['disembarked'], true);

            foreach ($rank as $key => $value) {
                if ($value == 2) {
                    $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                    $duration = $interval->format('%y');
                } else {
                    $duration = 0;
                }
            }
            if ($duration >= 4) {
                return true;
            } else {
                return 'not_qualified';
            }
        } else if ($position == "2") {
            $sea_service = $this->global->getSeaServiceRecord($crew_code);
            $rank = json_decode($sea_service['rank'], true);
            $embarked = json_decode($sea_service['embarked'], true);
            $disembarked = json_decode($sea_service['disembarked'], true);

            foreach ($rank as $key => $value) {
                if ($value == 3) {
                    $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                    $duration = $interval->format('%y');
                } else {
                    $duration = 0;
                }
            }
            if ($duration >= 3) {
                return true;
            } else {
                return 'not_qualified';
            }
        } elseif ($position == "10") {
            $sea_service = $this->global->getSeaServiceRecord($crew_code);
            $rank = json_decode($sea_service['rank'], true);
            $embarked = json_decode($sea_service['embarked'], true);
            $disembarked = json_decode($sea_service['disembarked'], true);

            foreach ($rank as $key => $value) {
                if ($value == 11) {
                    $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                    $duration = $interval->format('%y');
                } else {
                    $duration = 0;
                }
            }
            if ($duration >= 4) {
                return true;
            } else {
                return 'not_qualified';
            }
        } elseif ($position == "11") {
            $sea_service = $this->global->getSeaServiceRecord($crew_code);
            $rank = json_decode($sea_service['rank'], true);
            $embarked = json_decode($sea_service['embarked'], true);
            $disembarked = json_decode($sea_service['disembarked'], true);

            foreach ($rank as $key => $value) {
                if ($value == 12) {
                    $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                    $duration = $interval->format('%y');
                } else {
                    $duration = 0;
                }
            }
            if ($duration >= 3) {
                return true;
            } else {
                return 'not_qualified';
            }
        } elseif ($position == "3") {
            $sea_service = $this->global->getSeaServiceRecord($crew_code);
            $rank = json_decode($sea_service['rank'], true);
            $embarked = json_decode($sea_service['embarked'], true);
            $disembarked = json_decode($sea_service['disembarked'], true);

            foreach ($rank as $key => $value) {
                if ($value == 4) {
                    $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                    $duration = $interval->format('%y');
                } else {
                    $duration = 0;
                }
            }
            if ($duration >= 2) {
                return true;
            } else {
                return 'not_qualified';
            }
        } elseif ($position == "12") {
            $sea_service = $this->global->getSeaServiceRecord($crew_code);
            $rank = json_decode($sea_service['rank'], true);
            $embarked = json_decode($sea_service['embarked'], true);
            $disembarked = json_decode($sea_service['disembarked'], true);

            foreach ($rank as $key => $value) {
                if ($value == 13) {
                    $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                    $duration = $interval->format('%y');
                } else {
                    $duration = 0;
                }
            }
            if ($duration >= 2) {
                return true;
            } else {
                return 'not_qualified';
            }
        } elseif ($position == "4" || $position == "13") {
            $quals = [1, 2, 3, 18];
            $certificates = $this->global->getCertificates($crew_code);
            $certs = json_decode($certificates['certificates'], true);
            foreach ($quals as $key) {
                if (in_array($key, $certs)) {
                    return true;
                } else {
                    return 'not_qualified';
                }
            }
        } elseif ($position == "6" || $position == "16") {
            $sea_service = $this->global->getSeaServiceRecord($crew_code);
            $embarked = json_decode($sea_service['embarked'], true);
            $disembarked = json_decode($sea_service['disembarked'], true);

            foreach ($embarked as $key => $value) {
                $interval =  date_diff(date_create($value), date_create($disembarked[$key]));
                $duration = $interval->format('%y');
            }
            if ($duration >= 5) {
                return true;
            } else {
                return 'not_qualified';
            }
        } elseif ($position == "21" || $position == "7" || $position == "17") {
            $sea_service = $this->global->getSeaServiceRecord($crew_code);
            $embarked = json_decode($sea_service['embarked'], true);
            $disembarked = json_decode($sea_service['disembarked'], true);

            foreach ($embarked as $key => $value) {
                $interval =  date_diff(date_create($value), date_create($disembarked[$key]));
                $duration = $interval->format('%y');
            }
            if ($duration >= 3) {
                return true;
            } else {
                return 'not_qualified';
            }
        } elseif ($position == "22") {
            $sea_service = $this->global->getSeaServiceRecord($crew_code);
            $embarked = json_decode($sea_service['embarked'], true);
            $disembarked = json_decode($sea_service['disembarked'], true);

            foreach ($embarked as $key => $value) {
                $interval =  date_diff(date_create($value), date_create($disembarked[$key]));
                $duration = $interval->format('%y');
            }
            if ($duration >= 2) {
                return true;
            } else {
                return 'not_qualified';
            }
        } elseif ($position == "8" || $position == "18" || $position == "23") {
            $sea_service = $this->global->getSeaServiceRecord($crew_code);
            $rank = json_decode($sea_service['rank'], true);
            $embarked = json_decode($sea_service['embarked'], true);
            $disembarked = json_decode($sea_service['disembarked'], true);

            foreach ($rank as $key => $value) {
                if ($value == 24) {
                    $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                    $duration = $interval->format('%m');
                } else {
                    $duration = 0;
                }
            }
            if ($duration >= 3) {
                return true;
            } else {
                return 'not_qualified';
            }
        }
    }

    public function get_promotion_list()
    {
        $data = [];
        $count = 0;
        $this->db->select("
            c.crew_code,
            c.position,
            ap.position_name,
        ");

        $this->db->from("crews c");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");

        $this->db->where('c.status', 3);
        $this->db->or_where('c.status', 7);
        $this->db->group_by('c.crew_code');

        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result_array() : [];
        if ($result) {
            foreach ($result as $row) {

                if ($row['position'] == "1") {
                    $sea_service = $this->global->getSeaServiceRecord($row['crew_code']);
                    $rank = json_decode($sea_service['rank'], true);
                    $embarked = json_decode($sea_service['embarked'], true);
                    $disembarked = json_decode($sea_service['disembarked'], true);
        
                    foreach ($rank as $key => $value) {
                        if ($value == 2) {
                            $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                            $duration = $interval->format('%y');
                        } else {
                            $duration = 0;
                        }
                    }
                    $data['position'] = $row['position_name'];
                    
                    if ($duration >= 4) {
                        $data[''.$row['position_name'].'_count'] = $count++;
                    } else {
                        $data[''.$row['position_name'].'_count'] = '0';
                    }
                } else if ($row['position'] == "2") {
                    $sea_service = $this->global->getSeaServiceRecord($row['crew_code']);
                    $rank = json_decode($sea_service['rank'], true);
                    $embarked = json_decode($sea_service['embarked'], true);
                    $disembarked = json_decode($sea_service['disembarked'], true);
        
                    foreach ($rank as $key => $value) {
                        if ($value == 3) {
                            $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                            $duration = $interval->format('%y');
                        } else {
                            $duration = 0;
                        }
                    }
                    if ($duration >= 3) {
                        $data[''.$row['position_name'].'_count'] = $count++;
                    } else {
                        $data[''.$row['position_name'].'_count'] = '0';
                    }
                } elseif ($row['position'] == "10") {
                    $sea_service = $this->global->getSeaServiceRecord($row['crew_code']);
                    $rank = json_decode($sea_service['rank'], true);
                    $embarked = json_decode($sea_service['embarked'], true);
                    $disembarked = json_decode($sea_service['disembarked'], true);
        
                    foreach ($rank as $key => $value) {
                        if ($value == 11) {
                            $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                            $duration = $interval->format('%y');
                        } else {
                            $duration = 0;
                        }
                    }
                    if ($duration >= 4) {
                        $data[''.$row['position_name'].'_count'] = $count++;
                    } else {
                        $data[''.$row['position_name'].'_count'] = '0';
                    }
                } elseif ($row['position'] == "11") {
                    $sea_service = $this->global->getSeaServiceRecord($row['crew_code']);
                    $rank = json_decode($sea_service['rank'], true);
                    $embarked = json_decode($sea_service['embarked'], true);
                    $disembarked = json_decode($sea_service['disembarked'], true);
        
                    foreach ($rank as $key => $value) {
                        if ($value == 12) {
                            $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                            $duration = $interval->format('%y');
                        } else {
                            $duration = 0;
                        }
                    }
                    if ($duration >= 3) {
                        $data[''.$row['position_name'].'_count'] = $count++;
                    } else {
                        $data[''.$row['position_name'].'_count'] = '0';
                    }
                } elseif ($row['position'] == "3") {
                    $sea_service = $this->global->getSeaServiceRecord($row['crew_code']);
                    $rank = json_decode($sea_service['rank'], true);
                    $embarked = json_decode($sea_service['embarked'], true);
                    $disembarked = json_decode($sea_service['disembarked'], true);
        
                    foreach ($rank as $key => $value) {
                        if ($value == 4) {
                            $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                            $duration = $interval->format('%y');
                        } else {
                            $duration = 0;
                        }
                    }
                    if ($duration >= 2) {
                        $data[''.$row['position_name'].'_count'] = $count++;
                    }else {
                        $data[''.$row['position_name'].'_count'] = '0';
                    }
                } elseif ($row['position'] == "12") {
                    $sea_service = $this->global->getSeaServiceRecord($row['crew_code']);
                    $rank = json_decode($sea_service['rank'], true);
                    $embarked = json_decode($sea_service['embarked'], true);
                    $disembarked = json_decode($sea_service['disembarked'], true);
        
                    foreach ($rank as $key => $value) {
                        if ($value == 13) {
                            $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                            $duration = $interval->format('%y');
                        } else {
                            $duration = 0;
                        }
                    }
                    if ($duration >= 2) {
                        $data[''.$row['position_name'].'_count'] = $count++;
                    } else {
                        $data[''.$row['position_name'].'_count'] = '0';
                    }
                } elseif ($row['position'] == "4" || $row['position'] == "13") {
                    $quals = [1, 2, 3, 18];
                    $certificates = $this->global->getCertificates($row['crew_code']);
                    $certs = json_decode($certificates['certificates'], true);
                    foreach ($quals as $key) {
                        if (in_array($key, $certs)) {
                            $data[''.$row['position_name'].'_count'] = $count++;
                        } else {
                            $data[''.$row['position_name'].'_count'] = '0';
                        }
                    }
                } elseif ($row['position'] == "6" || $row['position'] == "16") {
                    $sea_service = $this->global->getSeaServiceRecord($row['crew_code']);
                    $embarked = json_decode($sea_service['embarked'], true);
                    $disembarked = json_decode($sea_service['disembarked'], true);
        
                    foreach ($embarked as $key => $value) {
                        $interval =  date_diff(date_create($value), date_create($disembarked[$key]));
                        $duration = $interval->format('%y');
                    }
                    if ($duration >= 5) {
                        $data[''.$row['position_name'].'_count'] = $count++;
                    } else {
                        $data[''.$row['position_name'].'_count'] = '0';
                    }
                } elseif ($row['position'] == "21" || $row['position'] == "7" || $row['position'] == "17") {
                    $sea_service = $this->global->getSeaServiceRecord($row['crew_code']);
                    $embarked = json_decode($sea_service['embarked'], true);
                    $disembarked = json_decode($sea_service['disembarked'], true);
        
                    foreach ($embarked as $key => $value) {
                        $interval =  date_diff(date_create($value), date_create($disembarked[$key]));
                        $duration = $interval->format('%y');
                    }
                    if ($duration >= 3) {
                        $data[''.$row['position_name'].'_count'] = $count++;
                    }else {
                        $data[''.$row['position_name'].'_count'] = '0';
                    }
                } elseif ($row['position'] == "22") {
                    $sea_service = $this->global->getSeaServiceRecord($row['crew_code']);
                    $embarked = json_decode($sea_service['embarked'], true);
                    $disembarked = json_decode($sea_service['disembarked'], true);
        
                    foreach ($embarked as $key => $value) {
                        $interval =  date_diff(date_create($value), date_create($disembarked[$key]));
                        $duration = $interval->format('%y');
                    }
                    if ($duration >= 2) {
                        $data[''.$row['position_name'].'_count'] = $count++;
                    } else {
                        $data[''.$row['position_name'].'_count'] = '0';
                    }
                } elseif ($row['position'] == "8" || $row['position'] == "18" || $row['position'] == "23") {
                    $sea_service = $this->global->getSeaServiceRecord($row['crew_code']);
                    $rank = json_decode($sea_service['rank'], true);
                    $embarked = json_decode($sea_service['embarked'], true);
                    $disembarked = json_decode($sea_service['disembarked'], true);
        
                    foreach ($rank as $key => $value) {
                        if ($value == 24) {
                            $interval =  date_diff(date_create($embarked[$key]), date_create($disembarked[$key]));
                            $duration = $interval->format('%m');
                        } else {
                            $duration = 0;
                        }
                    }
                    if ($duration >= 3) {
                        $data[''.$row['position_name'].'_count'] = $count++;
                    }else {
                        $data[''.$row['position_name'].'_count'] = '0';
                    }
                }
            }
        }
        
        return $data;
    }

    public function get_position_promote()
    {
        $this->db->select("
            c.crew_code,
            c.position,
            ap.position_name,
        ");

        $this->db->from("crews c");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");

        $this->db->where('c.status', 3);
        $this->db->or_where('c.status', 7);
        $this->db->group_by('c.position');

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}
