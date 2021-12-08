<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_approval extends CI_Model
{
    public function getApprovals($params = array())
    {
        $this->db->select("
            acp.*,
            c.crew_code,
            c.date_available,
            c.status as crew_status,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            ac.description city_name,
            apr.description province_name
        ");
        $this->db->from("ac_approvals acp");
        $this->db->join("crews c", "acp.crew_code = c.crew_code");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");

        $this->db->group_by('acp.approval_code');

        if (!empty($params['status'])) {
            if ($params['status'] == 'approved') {
                $this->db->group_start();
                $this->db->where("acp.status", 1);
                $this->db->group_end();
            } else if ($params['status'] == 'pending') {
                $this->db->group_start();
                $this->db->where("acp.status", 2);
                $this->db->group_end();
            } else if ($params['status'] == 'reject') {
                $this->db->group_start();
                $this->db->where("acp.status", 0);
                $this->db->group_end();
            }
        } else {
            $this->db->group_start();
            $this->db->where("acp.status", 2);
            $this->db->group_end();
        }


        $this->db->order_by("acp.date_created", "DESC");
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function get_approval_details($approval_code)
    {
        $this->db->select("
            acp.*,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.birth_date,
            ap.position_name,
            av.vsl_name,
        ");

        $this->db->from("ac_approvals acp");
        $this->db->join("ac_personal_info acpi", "acp.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("crews c", "acp.crew_code = c.crew_code");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");

        $this->db->where('acp.approval_code', $approval_code);
        $this->db->group_by('acp.approval_code');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    function approve_medical_request()
    {
        $approval_code = $this->input->post('is_approval_code');
        $p_approval = $this->db->where('approval_code', $approval_code)->get('ac_approvals')->row_array();
        $medical = $this->db->where('crew_code', $p_approval['crew_code'])->get('crew_medical')->row_array();
        $db_archive = $this->load->database('archive', TRUE);

        $approval_details = json_decode($p_approval['decision'], true);
        $approvers = json_decode($p_approval['approvers'], true);
        $decision_remarks = json_decode($p_approval['decision_remarks'], true);
        $arc_approval_data = [];
        $arc_medical = [];

        $details = json_decode($p_approval['details'], true);
        $pending_med_code = $details['medical_code'];
        $details["medical_status"] = "3";

        if (!empty($approval_details)) {
            if ($approval_details['decision_1'] == 1 && $approval_details['decision_2'] == 1) {

                $decision = [
                    'decision_1' => $approval_details['decision_1'] != NULL ? $approval_details['decision_1'] : 1,
                    'decision_2' => $approval_details['decision_2'] != NULL ? $approval_details['decision_2'] : 1,
                    'decision_3' => 1
                ];

                $d_remarks = [
                    'remarks_1' => $decision_remarks['remarks_1'] != NULL ? $decision_remarks['remarks_1'] : "approved",
                    'remarks_2' => $decision_remarks['remarks_2'] != NULL ? $decision_remarks['remarks_2'] : "approved",
                    'remarks_3' => "approved"
                ];

                $approvers = [
                    'approver_1'    => $approvers['approver_1'] != NULL ? $approvers['approver_1'] : $this->global->ecdc('dc', $this->session->userdata('user_code')),
                    'approver_2'    => $approvers['approver_2'] != NULL ? $approvers['approver_2'] : $this->global->ecdc('dc', $this->session->userdata('user_code')),
                    'approver_3'    => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                ];

                $approval_data = [
                    'decision'          => json_encode($decision),
                    'decision_remarks'  => json_encode($d_remarks),
                    'approvers'         => json_encode($approvers),
                    'details'           => json_encode($details),
                    'status'            => 1,
                ];

                $medical_data = [
                    'medical_status'    => 3,
                    'status'            => 1
                ];

                $arc_approval_data = [
                    'approval_code' => $approval_code,
                    'crew_code'     => $p_approval['crew_code'],
                    'department'    => $p_approval['department'],
                    'request_type'  => $p_approval['request_type'],
                    'request_by'    => $this->session->userdata('user_code'),
                    'details'       => $p_approval['details'],
                    'decision'          => json_encode($decision),
                    'decision_remarks'  => json_encode($d_remarks),
                    'approvers'         => json_encode($approvers),
                    'remarks'       => $p_approval['remarks'],
                    'date_created'  => date('Y-m-d H:i:s'),
                    'status'        => 1
                ];

                $arc_medical = [
                    'medical_code'       => $medical['medical_code'],
                    'date_med_exam'      => $medical['date_med_exam'],
                    'medical_expiry_date'     => $medical['medical_expiry_date'],
                    'remarks'            => $medical['remarks'],
                    'medical_status'     => 3,
                    'medical_height'     => $medical['medical_height'],
                    'medical_weight'     => $medical['medical_weight'],
                    'medical_bmi'        => $medical['medical_bmi'],
                    'approved_by'   => $medical['approved_by'],
                    'date_created'  => date('Y-m-d H:i:s'),
                    'status'        => 1
                ];
            } else if ($approval_details['decision_1'] === 1) {

                $decision = [
                    'decision_1' => $approval_details['decision_1'] != NULL ? $approval_details['decision_1'] : 1,
                    'decision_2' => 1
                ];

                $d_remarks = [
                    'remarks_1' => $decision_remarks['remarks_1'] != NULL ? $decision_remarks['remarks_1'] : "approved",
                    'remarks_2' => "approved"
                ];

                $approvers = [
                    'approver_1'    => $approvers['approver_1'] != NULL ? $approvers['approver_1'] : $this->global->ecdc('dc', $this->session->userdata('user_code')),
                    'approver_2'    => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                ];

                $approval_data = [
                    'decision'          => json_encode($decision),
                    'decision_remarks'  => json_encode($d_remarks),
                    'approvers'         => json_encode($approvers),
                ];
            }
        } else {
            $decision = [
                'decision_1' => 1,
                'decision_2' => "",
                'decision_3' => "",
            ];

            $d_remarks = [
                'remarks_1' => "approved",
                'remarks_2' => "",
                'remarks_3' => "",
            ];

            $approvers = [
                'approver_1' => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                'approver_2' => "",
                'approver_3' => "",
            ];

            $approval_data = [
                'decision'          => json_encode($decision),
                'decision_remarks'  => json_encode($d_remarks),
                'approvers'         => json_encode($approvers),
            ];
        }

        // $this->db->trans_strict(true);
        // $this->db->trans_begin();

        $this->db->where('approval_code', $approval_code)->update('ac_approvals', $approval_data);

        if ($this->db->affected_rows() > 0) {

            if (!empty($medical_data)) {
                $this->db->where(array('crew_code' => $p_approval['crew_code'], "medical_code" => $pending_med_code))->update('crew_medical', $medical_data);
            }
            if (!empty($arc_approval_data)) {
                $db_archive->insert('arc_approvals', $arc_approval_data);
            }
            if (!empty($arc_medical)) {
                $db_archive->insert('arc_crew_medical', $arc_medical);
            }

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function reject_medical_request($approval_code, $crew_code)
    {
        $medical = $this->db->where('crew_code', $crew_code)->get('crew_medical')->row_array();
        $p_approval = $this->db->where('approval_code', $approval_code)->get('ac_approvals')->row_array();

        $approval_details = json_decode($p_approval['decision'], true);
        $approvers = json_decode($p_approval['approvers'], true);
        $decision_remarks = json_decode($p_approval['decision_remarks'], true);

        $details = json_decode($p_approval['details'], true);
        $pending_med_code = $details['medical_code'];
        $details["medical_status"] = "0";


        if (!$approval_details) {
            $decision = [
                'decision_1' =>  0,
                'decision_2' =>  0,
                'decision_3' =>  0,
            ];

            $d_remarks = [
                'remarks_1' => "reject",
                'remarks_2' => "reject",
                'remarks_3' => "reject",
            ];

            $approvers = [
                'approver_1'    => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                'approver_2'    => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                'approver_3'    => $this->global->ecdc('dc', $this->session->userdata('user_code')),
            ];
        } else {
            if ($approval_details['decision_1'] === 0) {

                $decision = [
                    'decision_1' => $approval_details['decision_1'] != NULL ? $approval_details['decision_1'] : 0,
                    'decision_2' => 0,
                    'decision_3' =>  0,
                ];

                $d_remarks = [
                    'remarks_1' => $decision_remarks['remarks_1'] != NULL ? $decision_remarks['remarks_1'] : "reject",
                    'remarks_2' => "reject",
                    'remarks_3' => "reject",
                ];

                $approvers = [
                    'approver_1'    => $approvers['approver_1'] != NULL ? $approvers['approver_1'] : $this->global->ecdc('dc', $this->session->userdata('user_code')),
                    'approver_2'    => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                    'approver_3'    => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                ];
            } else if ($approval_details['decision_1'] === 0 && $approval_details['decision_2'] === 0) {
                $decision = [
                    'decision_1' =>  $approval_details['decision_1'] != NULL ? $approval_details['decision_1'] : 0,
                    'decision_2' =>  $approval_details['decision_2'] != NULL ? $approval_details['decision_2'] : 0,
                    'decision_3' =>  0,
                ];

                $d_remarks = [
                    'remarks_1' => $decision_remarks['remarks_1'] != NULL ? $decision_remarks['remarks_1'] : "reject",
                    'remarks_2' => $decision_remarks['remarks_2'] != NULL ? $decision_remarks['remarks_2'] : "reject",
                    'remarks_3' => "reject",
                ];

                $approvers = [
                    'approver_1'    => $approvers['approver_1'] != NULL ? $approvers['approver_1'] : $this->global->ecdc('dc', $this->session->userdata('user_code')),
                    'approver_2'    => $approvers['approver_2'] != NULL ? $approvers['approver_2'] : $this->global->ecdc('dc', $this->session->userdata('user_code')),
                    'approver_3'    => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                ];
            } else {
                $decision = [
                    'decision_1' =>  $approval_details['decision_1'] != NULL ? $approval_details['decision_1'] : 0,
                    'decision_2' =>  $approval_details['decision_2'] != NULL ? $approval_details['decision_2'] : 0,
                    'decision_3' =>  0,
                ];

                $d_remarks = [
                    'remarks_1' => $decision_remarks['remarks_1'] != NULL ? $decision_remarks['remarks_1'] : "reject",
                    'remarks_2' => $decision_remarks['remarks_2'] != NULL ? $decision_remarks['remarks_2'] : "reject",
                    'remarks_3' => "reject",
                ];

                $approvers = [
                    'approver_1'    => $approvers['approver_1'] != NULL ? $approvers['approver_1'] : $this->global->ecdc('dc', $this->session->userdata('user_code')),
                    'approver_2'    => $approvers['approver_2'] != NULL ? $approvers['approver_2'] : $this->global->ecdc('dc', $this->session->userdata('user_code')),
                    'approver_3'    => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                ];
            }
        }

        $arc_medical = [
            'medical_code'       => $medical['medical_code'],
            'date_med_exam'      => $medical['date_med_exam'],
            'medical_expiry_date'     => $medical['medical_expiry_date'],
            'remarks'            => $medical['remarks'],
            'medical_status'     => $medical['medical_status'],
            'medical_height'     => $medical['medical_height'],
            'medical_weight'     => $medical['medical_weight'],
            'medical_bmi'           => $medical['medical_bmi'],
            'approved_by'   => $medical['approved_by'],
            'date_created'  => date('Y-m-d H:i:s'),
            'status'        => 2
        ];

        $arc_approval_data = [
            'approval_code' => $approval_code,
            'crew_code'     => $p_approval['crew_code'],
            'department'    => $p_approval['department'],
            'request_type'  => $p_approval['request_type'],
            'request_by'    => $this->session->userdata('user_code'),
            'details'       => $p_approval['details'],
            'decision'          => json_encode($decision),
            'decision_remarks'  => json_encode($d_remarks),
            'approvers'         => json_encode($approvers),
            'remarks'       => $p_approval['remarks'],
            'date_created'  => date('Y-m-d H:i:s'),
            'status'        => 0
        ];

        $approval_data = [
            'decision'          => json_encode($decision),
            'decision_remarks'  => json_encode($d_remarks),
            'approvers'         => json_encode($approvers),
            'details'           => json_encode($details),
            'status' => 0
        ];

        $medical_data = [
            'medical_status' => 4,
            'status' => 4
        ];


        $db_archive = $this->load->database('archive', TRUE);

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->where('approval_code', $approval_code)->update('ac_approvals', $approval_data);
        $this->db->where(array('crew_code' => $p_approval['crew_code'], "medical_code" => $pending_med_code))->update('crew_medical', $medical_data);

        $db_archive->insert('arc_approvals', $arc_approval_data);
        $db_archive->insert('arc_crew_medical', $arc_medical);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function approve_toc_request($approval_code, $crew_code, $request_type)
    {
        $data = $this->db->where('approval_code', $approval_code)->get('ac_approvals')->row_array();
        $details = json_decode($data['details'], true);
        $db_archive = $this->load->database('archive', TRUE);

        if ($request_type === "un_toc") {

            if ($details['toc_status'] === "1") {

                $arc_approval_data = [
                    'approval_code' => $approval_code,
                    'crew_code'     => $crew_code,
                    'department'    => $data['department'],
                    'request_type'  => $data['department'],
                    'request_by'    => $this->session->userdata('user_code'),
                    'remarks'       => $data['remarks'],
                    'date_created'  => date('Y-m-d H:i:s'),
                    'status'        => 1
                ];

                $this->db->trans_strict(true);
                $this->db->trans_begin();

                $this->db->where('approval_code', $approval_code)->set('status', 1)->update('ac_approvals');
                $this->db->where('crew_code', $crew_code)->set('status', 0)->update('ac_withdrawal');
                $this->db->where('crew_code', $crew_code)->set('status', 2)->update('applicants');
                $db_archive->insert('arc_approvals', $arc_approval_data);

                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return true;
                }
            } else {

                $arc_approval_data = [
                    'approval_code' => $approval_code,
                    'crew_code'     => $crew_code,
                    'department'    => $data['department'],
                    'request_type'  => $data['department'],
                    'request_by'    => $this->session->userdata('user_code'),
                    'remarks'       => $data['remarks'],
                    'date_created'  => date('Y-m-d H:i:s'),
                    'status'        => 1
                ];

                $this->db->trans_strict(true);
                $this->db->trans_begin();

                $this->db->where('approval_code', $approval_code)->set('status', 1)->update('ac_approvals');
                $this->db->where('crew_code', $crew_code)->set('status', 0)->update('ac_withdrawal');
                $this->db->where('crew_code', $crew_code)->set('status', $details['toc_status'])->update('crews');
                $db_archive->insert('arc_approvals', $arc_approval_data);

                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return true;
                }
            }
        } else {

            $db_archive = $this->load->database('archive', TRUE);

            $toc_data = $this->db->where(array('crew_code' => $crew_code, 'status' => 2))->get('ac_withdrawal')->row_array();

            $toc_data = [
                'status'    => 1
            ];
            $approval_data = [
                'status'    => 1
            ];
            $arc_approval_data = [
                'approval_code' => $approval_code,
                'crew_code'     => $crew_code,
                'department'    => $data['department'],
                'request_type'  => $data['department'],
                'request_by'    => $this->session->userdata('user_code'),
                'remarks'       => $data['remarks'],
                'date_created'  => date('Y-m-d H:i:s'),
                'status'        => 1
            ];

            $this->db->trans_strict(true);
            $this->db->trans_begin();

            $this->db->where('crew_code', $crew_code)->update('ac_withdrawal', $approval_data);
            $this->db->where('approval_code', $approval_code)->update('ac_approvals', $approval_data);
            $this->db->where('crew_code', $crew_code)->set('status', 0)->update('crews');
            $this->db->where('crew_code', $crew_code)->set('status', 10)->update('applicants');
            $db_archive->insert('arc_withdrawal', $toc_data);
            $db_archive->insert('arc_approvals', $arc_approval_data);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
    }

    function reject_untoc_request($approval_code, $crew_code, $request_type)
    {
        $data = $this->db->where('approval_code', $approval_code)->get('ac_approvals')->row_array();
        $db_archive = $this->load->database('archive', TRUE);

        if ($request_type === "un_toc") {

            $approval_data = [
                'status' => 0
            ];

            $arc_approval_data = [
                'approval_code' => $approval_code,
                'crew_code'     => $crew_code,
                'department'    => $data['department'],
                'request_type'  => $data['department'],
                'request_by'    => $this->session->userdata('user_code'),
                'remarks'       => $data['remarks'],
                'date_created'  => date('Y-m-d H:i:s'),
                'status'        => 0
            ];

            $this->db->trans_strict(true);
            $this->db->trans_begin();

            $this->db->where('approval_code', $approval_code)->update('ac_approvals', $approval_data);
            $db_archive->insert('arc_approvals', $arc_approval_data);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } else {

            $db_archive = $this->load->database('archive', TRUE);

            $arc_toc_data = $this->db->select('crew_code, position, vessel_assign,department,issued_by,remarks,date_created,status')->where(array('crew_code' => $crew_code, 'status' => 2))->get('ac_withdrawal')->row_array();

            $approval_data = ['status' => 0];
            $toc_data = ['status' => 0];
            $arc_approval_data = [
                'approval_code' => $approval_code,
                'crew_code'     => $crew_code,
                'department'    => $data['department'],
                'request_type'  => $data['department'],
                'request_by'    => $this->session->userdata('user_code'),
                'remarks'       => $data['remarks'],
                'date_created'  => date('Y-m-d H:i:s'),
                'status'        => 0
            ];

            $this->db->trans_strict(true);
            $this->db->trans_begin();

            $this->db->where('approval_code', $approval_code)->update('ac_approvals', $approval_data);
            $this->db->where('crew_code', $crew_code)->update('ac_withdrawal', $toc_data);
            $db_archive->insert('arc_withdrawal', $arc_toc_data);
            $db_archive->insert('arc_approvals', $arc_approval_data);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
    }


    public function approve_promotion()
    {
        $crew_code = $this->input->post('crew_code');
        $approval_code = $this->input->post('approval_code');
        $crew = $this->global->getCrew($crew_code);
        $crew_cmp = $this->global->getCMP($crew['monitor_code']);
        $promotion_data = $this->promotions->get_promotion_details($crew_code);

        $mlc = json_decode($promotion_data['new_mlc_contract'], true);
        $poea = json_decode($promotion_data['new_poea_contract'], true);

        $mlc_contract = $this->contracts->getCrewMlcById($crew_code);
        $poea_contract = $this->contracts->getCrewContractById($crew_code);

        if ($crew['status'] == 3 || $crew['status'] == 4) {

            $crews = [
                'position' => $promotion_data['position'],
                'vessel_assign' => $promotion_data['vessel'],
            ];

            $cm_plan = [
                'disembark' => $poea['contract_duration'],
                'position'  => $promotion_data['position'],
                'vessel_code'   => $promotion_data['vessel'],
            ];

            $arc_cmp = [
                'cmp_code'  => $crew_cmp['cmp_code'],
                'offsigner' => $crew['monitor_code'],
                'insigner'  => $crew_cmp['insigner'],
                'position'  => $promotion_data['position'],
                'vessel_code'   => $promotion_data['vessel'],
                'embark'     =>  $crew_cmp ? $crew_cmp['embark'] : null,
                'disembark'  => $poea['contract_duration'],
                'months_onboard'    => $crew_cmp ? $crew_cmp['months_onboard'] : null,
                'line_up'    => $crew_cmp ? $crew_cmp['line_up'] : null,
                'x_port'     => $crew_cmp ? $crew_cmp['x_port'] : null,
                'date_x'     => $crew_cmp ? $crew_cmp['date_x'] : null,
                'sign_on'    => $crew_cmp ? $crew_cmp['sign_on'] : null,
                'remarks'    => $crew_cmp ? $crew_cmp['remarks'] : null,
                'status'          => 3,
                'date_created'    => date('Y-m-d h:i:s')
            ];

            $promotion = ['status' => 1];
        } else {

            $promotion = ['status' => 1];

            $crews = [
                'position' => $promotion_data['position'],
                'vessel_assign' => $promotion_data['vessel'],
            ];
        }


        $arc_promotion = [
            'monitor_code'  => $crew['monitor_code'],
            'crew_code'     => $crew_code,
            'position'      => $promotion_data['position'],
            'vessel'        => $promotion_data['vessel'],
            'promoted_by'   => $this->global->ecdc('dc', $this->session->userdata('user_code')),
            'date_created'  => date('Y-m-d h:i:s'),
            'status'        => 1
        ];


        $db_archive = $this->load->database('archive', TRUE);

        $this->db->trans_begin();

        if ($crew['status'] == 3 || $crew['status'] == 4) {
            $this->db->where('cmp_code', $crew_cmp['cmp_code'])->update('cm_plan', $cm_plan);
            $db_archive->insert('arc_cm_plan', $arc_cmp);
        }

        if (!empty($poea_contract)) {
            $this->db->where('crew_code', $crew_code)->update('crew_poea', $poea);
        } else {
            $this->db->insert('crew_poea', $poea);
        }

        if (!empty($mlc_contract)) {
            $this->db->where('crew_code', $crew_code)->update('crew_mlc', $mlc);
        } else {
            $this->db->insert('crew_mlc', $mlc);
        }

        $this->db->where('crew_code', $crew_code)->update('crews', $crews);
        $this->db->where(array('monitor_code' => $crew['monitor_code'], 'crew_code' => $crew_code))->set('status', 1)->update('ac_promoted_crew_onboard');
        $this->db->where('approval_code', $approval_code)->set('status', 1)->update('ac_approvals');
        $this->db->where('crew_code', $crew_code)->update('ac_promoted_crew_onboard', $promotion);
        $db_archive->insert('arc_promotions', $arc_promotion);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function reject_promotion()
    {
        $approval_code = $this->input->post('approval_code');
        $data = $this->db->where('approval_code', $approval_code)->get('ac_approvals')->row_array();

        $arc_approval_data = [
            'approval_code' => $approval_code,
            'crew_code'     => $data['crew_code'],
            'department'    => $data['department'],
            'request_type'  => $data['department'],
            'request_by'    => $this->session->userdata('user_code'),
            'remarks'       => $data['remarks'],
            'date_created'  => date('Y-m-d H:i:s'),
            'status'        => 0
        ];

        $db_archive = $this->load->database('archive', TRUE);

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->where('approval_code', $approval_code)->set('status', 3)->update('ac_approvals');
        $db_archive->insert('arc_approvals', $arc_approval_data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function crew_lineup_for_approval()
    {
        $approval_code = $this->global->generateID("APR");
        $condition['search']['vessel'] = $this->input->post('vsl');
        $condition['search']['joining_port'] = $this->input->post('jp');
        $condition['search']['embark_date'] = $this->input->post('date');

        $lineup = $this->crew_management->generate_crew_lineup($condition);

        foreach ($lineup as $key) {
            $crew_code = $key['crew_code'];

        }

        $approval_data = [
            'vessel'    => $this->input->post('vsl'),
            'joining_port'  => $this->input->post('jp'),
            'embark_date'   => $this->input->post('date')
        ];

        $clineup_approve = [
            'approval_code' => $approval_code,
            'crew_code'     => $crew_code,
            'department'    => "documentation",
            'request_type'  => "crew_lineup_approval",
            'request_by'    => $this->session->userdata('user_code'),
            'details'       => json_encode($approval_data),
            'remarks'       => 'Crew lineup for approval to be transferred to GA.',
            'date_created'  => date('Y-m-d H:i:s'),
            'status'        => 2
        ];

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->insert('ac_approvals', $clineup_approve);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function view_crewlineup_approval($approval_code)
    {
        $condition = [];
        $lineup_approval = $this->db->where('approval_code', $approval_code)->get('ac_approvals')->row_array();

        $details = json_decode($lineup_approval['details'], true);

        $condition['search']['vessel'] = $details['vessel'];
        $condition['search']['joining_port'] = $details['joining_port'];
        $condition['search']['embark_date'] = $details['embark_date'];

        $lineup = $this->crew_management->generate_crew_lineup($condition);

        return $lineup;
    }

    public function approve_crew_lineup($approval_code)
    {
        $this->db->where('approval_code', $approval_code)->set('status', 1)->update('ac_approvals');

        if ($this->db->affected_rows() > 0) {

            $condition = [];
            $lineup_approval = $this->db->where('approval_code', $approval_code)->get('ac_approvals')->row_array();

            $details = json_decode($lineup_approval['details'], true);

            $condition['search']['vessel'] = $details['vessel'];
            $condition['search']['joining_port'] = $details['joining_port'];
            $condition['search']['embark_date'] = $details['embark_date'];
            $lineup = $this->crew_management->generate_crew_lineup($condition);
            $result = $this->crew_management->transfer_lineup_to_ga($lineup);

            if ($result === true) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function reject_crew_lineup($approval_code)
    {
        $this->db->where('approval_code', $approval_code)->set('status', 3)->update('ac_approvals');
        if ($this->db->affected_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
}
