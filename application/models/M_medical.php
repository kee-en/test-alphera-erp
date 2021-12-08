<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_medical extends CI_Model
{

    function getMedicalCrew($params = array())
    {
        $this->db->select("
            c.crew_code,
            c.date_available,
            c.status,
            c.offsigner,
            c.monitor_code,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.weight,
            acpi.height,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            av.vsl_code,
            ac.description city_name,
            apr.description province_name,
            ad.department_name,
            acpi.weight,
            acpi.height,
            cm.status as med_status
        ");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("a_type_of_department ad", "ap.type_of_department = ad.id", "LEFT");
        $this->db->join("crew_medical cm", "cm.crew_code = c.crew_code", "LEFT");
        $this->db->where("c.status", "2");

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

        if (!empty($params['search']['flight_search'])) {
            $this->db->group_start();
            if ($params['search']['flight_search'] === "1") {
                $this->db->where('c.flight_code !=', NULL);
            } else if ($params['search']['flight_search'] === "0") {
                $this->db->where('c.flight_code !=', NULL);
            }
            $this->db->group_end();
        }

        if (!empty($params['search']['month_search_from']) && !empty($params['search']['month_search_to'])) {
            $this->db->group_start();
            if ($params['search']['status_search'] === '3') {
                $this->db->where('cmp.embark >=', $params['search']['month_search_from']);
                $this->db->where('cmp.embark <=', $params['search']['month_search_to']);
            } else if ($params['search']['status_search'] === '4') {
                $this->db->where('cmp.disembark >=', $params['search']['month_search_from']);
                $this->db->where('cmp.disembark <=', $params['search']['month_search_to']);
            } else if ($params['search']['status_search'] === '7') {
                $this->db->where('c.date_available >=', $params['search']['month_search_from']);
                $this->db->where('c.date_available <=', $params['search']['month_search_to']);
            }
            $this->db->group_end();
        }


        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->group_by("c.crew_code");
        $this->db->order_by("c.date_created", "DESC");

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function saveMedicalRecordForm()
    {
        $medical_code = $this->global->generateID("MD");
        $approval_code = $this->global->generateID("APR");
        $med_approve = [];
        $data = [
            'medical_code'       => $medical_code,
            'crew_code'          => $this->input->post('m_crew_code'),
            'date_med_exam'      => date('Y-m-d', strtotime($this->input->post('m_date_med_exam'))),
            'medical_expiry_date'     => date('Y-m-d', strtotime($this->input->post('m_medical_expiry_date'))),
            'remarks'            => $this->input->post('m_add_remarks'),
            'medical_status'     => $this->input->post('m_status'),
            'medical_height'     => $this->input->post('m_height'),
            'medical_weight'     => $this->input->post('m_weight'),
            'medical_bmi'        => $this->input->post('m_bmi'),
            'date_created'       => date('Y-m-d H:i:s'),
            'date_medical_fit'   => (($this->input->post('m_status') == 2) ? date('Y-m-d') : NULL),
            'status'             => $this->input->post('m_status') == 2 ? 1 : 2
        ];

        $bmi = [
            'height'             => $this->input->post('m_height'),
            'weight'             => $this->input->post('m_weight'),
            'date_updated'       => date('Y-m-d h:i:s')
        ];

        $db_archive = $this->load->database('archive', TRUE);

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        if ($this->input->post('m_status') === "1") {

            $approval_data = [
                'medical_code'       => $medical_code,
                'date_med_exam'      => date('Y-m-d', strtotime($this->input->post('m_date_med_exam'))),
                'medical_expiry_date'     => date('Y-m-d', strtotime($this->input->post('m_medical_expiry_date'))),
                'remarks'            => $this->input->post('m_add_remarks'),
                'medical_status'     => $this->input->post('m_status'),
                'medical_height'     => $this->input->post('m_height'),
                'medical_weight'     => $this->input->post('m_weight'),
                'bmi'           => $this->input->post('m_bmi'),
                'waist_line'    => $this->input->post('m_waistline'),
                'cholosterol'   => $this->input->post('m_cholesterol'),
                'triglycerides' => $this->input->post('m_triglycerides'),
                'fbs'           => $this->input->post('m_fbs'),
                'sgpt'          => $this->input->post('m_sgpt'),
                'sgot'          => $this->input->post('m_sgot'),
                'ldl'           => $this->input->post('m_ldl'),
                'hdl'           => $this->input->post('m_hdl'),
                'bp'            => $this->input->post('m_bp'),
                'specific_ailment' => $this->input->post('m_specific_ailment'),
            ];

            $med_approve = [
                'approval_code' => $approval_code,
                'crew_code'     => $this->input->post('m_crew_code'),
                'medical_code'  => $medical_code,
                'department'    => "crew management",
                'request_type'  => "medical_approval",
                'request_by'    => $this->session->userdata('user_code'),
                'details'       => json_encode($approval_data),
                'remarks'       => $this->input->post('m_add_remarks'),
                'date_created'  => date('Y-m-d H:i:s'),
                'status'        => 2
            ];

            $this->db->insert('ac_approvals', $med_approve);
        }

        $this->db->insert('crew_medical', $data);
        $this->db->where('crew_code', $this->input->post('m_crew_code'))->update('ac_personal_info', $bmi);

        $db_archive->insert('arc_crew_medical', $data);
        if (!empty($med_approve)) {
            $db_archive->insert('arc_approvals', $med_approve);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function editMedicalRecordForm($medical_code, $crew_code)
    {

        $p_approval = $this->db->where(array('crew_code' => $crew_code, 'status' => 2))->get('ac_approvals');

        $medical = [
            'date_med_exam'      => date('Y-m-d', strtotime($this->input->post('e_m_date_med_exam'))),
            'medical_expiry_date'     => date('Y-m-d', strtotime($this->input->post('e_m_medical_expiry_date'))),
            'remarks'            => $this->input->post('e_m_add_remarks'),
            'medical_status'     => $this->input->post('e_m_status'),
            'medical_height'        => $this->input->post('e_m_height'),
            'medical_weight'        => $this->input->post('e_m_weight'),
            'medical_bmi'       => $this->input->post('e_m_bmi'),
            'date_updated'       => date('Y-m-d H:i:s'),
            'status'            => $this->input->post('e_m_status') === 2 ? 1 : 2
        ];

        $bmi = [
            'height'             => $this->input->post('e_m_height'),
            'weight'             => $this->input->post('e_m_weight'),
            'date_updated'       => date('Y-m-d h:i:s')
        ];

        $med_arc = [
            'medical_code'       => $medical_code,
            'crew_code'          => $crew_code,
            'date_med_exam'      => date('Y-m-d', strtotime($this->input->post('e_m_date_med_exam'))),
            'remarks'            => $this->input->post('e_m_add_remarks'),
            'medical_status'     => $this->input->post('e_m_status'),
            'medical_height'     => $this->input->post('e_m_height'),
            'medical_weight'     => $this->input->post('e_m_weight'),
            'medical_bmi'        => $this->input->post('e_m_bmi'),
            'date_created'       => date('Y-m-d H:i:s'),
            'date_medical_fit'   => date('Y-m-d'),
            'medical_expiry_date'     => date('Y-m-d', strtotime($this->input->post('e_m_medical_expiry_date')))
        ];

        $approval_code = $this->global->generateID("APR");

        $approval_data = [
            'date_med_exam'      => date('Y-m-d', strtotime($this->input->post('e_m_date_med_exam'))),
            'medical_expiry_date'     => date('Y-m-d', strtotime($this->input->post('e_m_medical_expiry_date'))),
            'remarks'            => $this->input->post('e_m_add_remarks'),
            'medical_status'     => $this->input->post('e_m_status'),
            'medical_height'        => $this->input->post('e_m_height'),
            'medical_weight'     => $this->input->post('e_m_weight'),
            'bmi'           => $this->input->post('e_m_bmi'),
            'waist_line'    => $this->input->post('e_m_waistline'),
            'cholosterol'   => $this->input->post('e_m_cholesterol'),
            'triglycerides' => $this->input->post('e_m_triglycerides'),
            'fbs'           => $this->input->post('e_m_fbs'),
            'sgpt'          => $this->input->post('e_m_sgpt'),
            'sgot'          => $this->input->post('e_m_sgot'),
            'ldl'           => $this->input->post('e_m_ldl'),
            'hdl'           => $this->input->post('e_m_hdl'),
            'bp'            => $this->input->post('e_m_bp'),
            'specific_ailment' => $this->input->post('e_m_specific_ailment'),
        ];

        $med_approve = [
            'approval_code' => $approval_code,
            'crew_code'     => $crew_code,
            'department'    => "crew management",
            'request_type'  => "medical_approval",
            'request_by'    => $this->session->userdata('user_code'),
            'details'       => json_encode($approval_data),
            'remarks'       => $this->input->post('e_m_add_remarks'),
            'date_created'  => date('Y-m-d H:i:s'),
            'status'        => 2
        ];


        $db_archive = $this->load->database('archive', TRUE);


        $this->db->trans_begin();

        if ($medical['medical_status'] === "2") {
            $this->db->where(array('crew_code' => $crew_code, 'medical_code' => $medical_code))->set('date_medical_fit', date('Y-m-d'))->update('crew_medical', $medical);
        } else {

            if ($p_approval->num_rows() > 0) {
                $data = $p_approval->row_array();
                $new_details = json_encode($approval_data);
                $this->db->where('approval_code', $data['approval_code'])->set('details', $new_details)->update('ac_approvals');

                $db_archive->insert('arc_approvals', $med_approve);
                $this->db->where(array('crew_code' => $crew_code, 'medical_code' => $medical_code))->update('crew_medical', $medical);
            } else {
                $this->db->insert('ac_approvals', $med_approve);

                $this->db->where(array('crew_code' => $crew_code, 'medical_code' => $medical_code))->update('crew_medical', $medical);
            }
        }

        $this->db->where('crew_code', $crew_code)->update('ac_personal_info', $bmi);

        $db_archive->insert('arc_crew_medical', $med_arc);
        $db_archive->insert('arc_approvals', $med_approve);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function removeMedicalRecord($id)
    {
        $this->db->where('id', $id)->set('status', 0)->update('crew_medical');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function removeAcApprovalData($medical_code)
    {
        $this->db->where('medical_code', $medical_code)->set('status', 3)->update('ac_approvals');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_medical_validity($crew_code)
    {
        $medical = $this->db->where(array('crew_code' => $crew_code, 'status !=' => 0))->order_by('date_created', 'DESC')->get('crew_medical')->row_array();


        $name = $this->global->getApplicantInformation($crew_code);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];


        $medical_validity = "";
        if ($medical) {
            if ($medical['status'] == "1") {

                $title = "";

                switch ($medical['medical_status']) {
                    case '2':
                        $title = "FIT FOR SEA DUTY";
                        break;
                    case '3':
                        $title =  "W/APPROVAL";
                        break;
                }

                $medical_validity = "<h4 class=\"m-0 font-15 text-success\" data-toggle=\"modal\" data-target=\"#v_medical_modal\"  onclick=\"getMedicalRecords('{$crew_code}', '{$fullname}')\" style=\"cursor:pointer!important;\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$title}\" data-original-title=\"{$title}\">VALID</h4>";
            } else if ($medical['status'] == "2") {
                $medical_validity = "<h4 class=\"m-0 font-15 text-warning\" data-toggle=\"modal\" data-target=\"#v_medical_modal\"  onclick=\"getMedicalRecords('{$crew_code}', '{$fullname}')\" style=\"cursor:pointer!important;\">PENDING</h4>";
            } else if ($medical['status'] == "3") {
                $medical_validity = "<h4 class=\"m-0 font-15 text-danger\" data-toggle=\"modal\" data-target=\"#v_medical_modal\"  onclick=\"getMedicalRecords('{$crew_code}', '{$fullname}')\" style=\"cursor:pointer!important;\">EXPIRED</h4>";
            } else if ($medical['status'] == "4") {
                $medical_validity = "<h4 class=\"m-0 font-15 text-danger\" data-toggle=\"modal\" data-target=\"#v_medical_modal\"  onclick=\"getMedicalRecords('{$crew_code}', '{$fullname}')\" style=\"cursor:pointer!important;\">REJECTED</h4>";
            }
        } else {
            $medical_validity = "<h4 class=\"m-0 font-15 text-danger\" data-toggle=\"modal\" data-target=\"#v_medical_modal\"  onclick=\"getMedicalRecords('{$crew_code}', '{$fullname}')\" style=\"cursor:pointer!important;\">N/A</h4>";
        }
        return $medical_validity;
    }

    public function get_medical_validity_table($crew_code)
    {
        $medical = $this->db->where(array('crew_code' => $crew_code, 'status !=' => 0))->order_by('date_created', 'DESC')->get('crew_medical')->row_array();
        $name = $this->global->getApplicantInformation($crew_code);
        $first_name = !empty($name['first_name']) ? $name['first_name'] : "";
        $middle_name = !empty($name['middle_name']) ? $name['middle_name'] : "";
        $last_name = !empty($name['last_name']) ? $name['last_name'] : "";
        $fullname = trim($first_name . ' ' . $middle_name . ' ' . $last_name);


        $medical_validity = "";
        if ($medical) {

            if ($medical['status'] == "1") {

                $title = "";

                switch ($medical['medical_status']) {
                    case '2':
                        $title = "FIT FOR SEA DUTY";
                        break;
                    case '3':
                        $title =  "W/APPROVAL";
                        break;
                }

                $medical_validity = "<span class=\"badge badge-success-outline\" data-toggle=\"modal\" data-target=\"#v_medical_modal\"  onclick=\"getMedicalRecords('{$crew_code}', '{$fullname}')\" style=\"cursor:pointer!important;\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$title}\" data-original-title=\"{$title}\">VALID</span>";
            } else if ($medical['status'] == "2") {
                $medical_validity = "<span class=\"badge badge-warning-outline\" data-toggle=\"modal\" data-target=\"#v_medical_modal\"  onclick=\"getMedicalRecords('{$crew_code}', '{$fullname}')\" style=\"cursor:pointer!important;\">PENDING</span>";
            } else if ($medical['status'] == "3") {
                $medical_validity = "<span class=\"badge badge-danger-outline\" data-toggle=\"modal\" data-target=\"#v_medical_modal\"  onclick=\"getMedicalRecords('{$crew_code}', '{$fullname}')\" style=\"cursor:pointer!important;\">EXPIRED</span>";
            } else if ($medical['status'] == "4") {
                $medical_validity = "<span class=\"badge badge-danger-outline\" data-toggle=\"modal\" data-target=\"#v_medical_modal\"  onclick=\"getMedicalRecords('{$crew_code}', '{$fullname}')\" style=\"cursor:pointer!important;\">REJECTED</span>";
            }
        } else {
            $medical_validity = "<span class=\"badge badge-danger-outline\" data-toggle=\"modal\" data-target=\"#v_medical_modal\" onclick=\"getMedicalRecords('{$crew_code}', '{$fullname}')\" style=\"cursor:pointer!important;\">N/A</span>";
        }
        return $medical_validity;
    }

    public function get_medical_validity_text($crew_code)
    {
        $medical = $this->db->where(array('crew_code' => $crew_code, 'status !=' => 0))->order_by('date_created', 'DESC')->get('crew_medical')->row_array();
        $medical_validity = "";
        if ($medical) {
            if ($medical['medical_status'] === "1") {
                $medical_validity = 'PENDING';
            } else if ($medical['medical_status'] === "3") {
                $medical_validity = 'WITH APPROVAL';
            } else {
                $medical_validity = 'VALID';
            }
        } else {
            $medical_validity = 'NOT AVAILABLE';
        }
        return $medical_validity;
    }

    public function get_crew_medical_table($crew_code)
    {
        $this->db->select("
            cm.*,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.birth_date,
            acpi.birth_place,
            ap.position_code,
            ap.position_name,
        ");
        $this->db->from("crew_medical cm");
        $this->db->join("crews c", "c.crew_code = cm.crew_code", "LEFT");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");

        $this->db->where(array("cm.crew_code" =>  $crew_code, "cm.status !=" => 0));
        $this->db->order_by("cm.date_created", "DESC");
        // $this->db->group_by("cm.crew_code");

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function get_crew_medical_by_code($medical_code, $crew_code)
    {
        $p_approval = $this->db->where(array('crew_code' => $crew_code, 'status' => 2))->get('ac_approvals');

        if ($p_approval->num_rows() > 0) {
            $this->db->select("
            cm.*,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.birth_date,
            acpi.birth_place,
            ap.position_code,
            ap.position_name,
            acp.details
            ");
            $this->db->from("crew_medical cm");
            $this->db->join("crews c", "c.crew_code = cm.crew_code", "LEFT");
            $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
            $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
            $this->db->join("ac_approvals acp", "c.crew_code = acp.crew_code", "LEFT");

            $this->db->where(array("cm.medical_code" => $medical_code, "cm.crew_code" =>  $crew_code, "cm.status !=" => 0, "acp.status" => 2));
            $this->db->group_by("cm.crew_code");
            $this->db->order_by("cm.date_created", "DESC");

            $query = $this->db->get();

            return ($query->num_rows() > 0) ? $query->result_array() : [];
        } else {
            $this->db->select("
            cm.*,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.birth_date,
            acpi.birth_place,
            ap.position_code,
            ap.position_name
            ");
            $this->db->from("crew_medical cm");
            $this->db->join("crews c", "c.crew_code = cm.crew_code", "LEFT");
            $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
            $this->db->join("a_position ap", "c.position = ap.id", "LEFT");

            $this->db->where(array("medical_code" => $medical_code, "cm.crew_code" =>  $crew_code, "cm.status !=" => 0));
            $this->db->group_by("cm.crew_code");
            $this->db->order_by("cm.date_created", "DESC");

            $query = $this->db->get();

            return ($query->num_rows() > 0) ? $query->result_array() : [];
        }
    }

    function getMedicalReport($params = array())
    {
        $this->db->select("
            c.crew_code,
            c.date_available,
            c.status,
            c.offsigner,
            c.monitor_code,
            c.embark_date,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            acpi.weight,
            acpi.height,
            crm.*
        ");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("crew_medical crm", "crm.crew_code = c.crew_code", "LEFT");

        $this->db->where("c.status", "2");
        $this->db->group_by("c.crew_code");
        $this->db->order_by("c.date_created", "DESC");


        if (!empty($params['search']['position']) && $params['search']['position'] != "all") {
            $this->db->group_start();
            $this->db->where('c.position', $params['search']['position']);
            $this->db->group_end();
        }
        if (!empty($params['search']['vessel']) && $params['search']['vessel'] != "all") {
            $this->db->group_start();
            $this->db->where('c.vessel_assign', $params['search']['vessel']);
            $this->db->group_end();
        }
        if (!empty($params['search']['m_date_from']) && !empty($params['search']['m_date_to'])) {
            $this->db->group_start();
            $this->db->where('crm.date_med_exam >=', $params['search']['m_date_from']);
            $this->db->where('crm.date_med_exam <=', $params['search']['m_date_to']);
            $this->db->group_end();
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function getMedicalReportGeneral($params = array())
    {
        $this->db->select("
            c.crew_code,
            c.date_available,
            c.status,
            c.offsigner,
            c.monitor_code,
            c.embark_date,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            acpi.weight,
            acpi.height,
            crm.*
        ");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("crew_medical crm", "crm.crew_code = c.crew_code", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");

        $this->db->where("c.status", "2");

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
            $this->db->like('c.vessel_assign', $params['search']['vessel_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['rank_search'])) {
            $this->db->group_start();
            $this->db->like('c.position', $params['search']['rank_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['flight_search'])) {
            $this->db->group_start();
            if ($params['search']['flight_search'] === "1") {
                $this->db->where('c.flight_code !=', NULL);
            } else if ($params['search']['flight_search'] === "0") {
                $this->db->where('c.flight_code !=', NULL);
            }
            $this->db->group_end();
        }

        if (!empty($params['search']['month_search_from']) && !empty($params['search']['month_search_to'])) {
            $this->db->group_start();
            if ($params['search']['status_search'] === '3') {
                $this->db->where('cmp.embark >=', $params['search']['month_search_from']);
                $this->db->where('cmp.embark <=', $params['search']['month_search_to']);
            } else if ($params['search']['status_search'] === '4') {
                $this->db->where('cmp.disembark >=', $params['search']['month_search_from']);
                $this->db->where('cmp.disembark <=', $params['search']['month_search_to']);
            } else if ($params['search']['status_search'] === '7') {
                $this->db->where('c.date_available >=', $params['search']['month_search_from']);
                $this->db->where('c.date_available <=', $params['search']['month_search_to']);
            }
            $this->db->group_end();
        }

        $this->db->group_start();
        $this->db->where_in("crm.status", ['1', '2']);
        $this->db->group_end();

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->group_by("c.crew_code");
        $this->db->order_by("c.date_created", "DESC");

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function get_nre_medical_count()
    {
        $this->db->select('COUNT(crew_code) as total_count');
        $this->db->from('ac_warning_letter');
        $this->db->like('remarks', 'Medical / Health Reason');
        return $this->db->get()->result_array();
    }

    public function get_all_medical()
    {
        $this->db->select('crew_code,date_med_exam');
        $this->db->from('crew_medical');
        $this->db->order_by("date_created", "DESC");
        return $this->db->get()->result_array();
    }

    public function get_medical_validity_report($crew_code)
    {
        $medical = $this->db->where(array('crew_code' => $crew_code, 'status !=' => 0))->order_by('date_created', 'DESC')->get('crew_medical')->row_array();
        $name = $this->global->getApplicantInformation($crew_code);
        // $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];


        $medical_validity = "";
        if ($medical) {

            if ($medical['status'] == "1") {

                $title = "";

                switch ($medical['medical_status']) {
                    case '2':
                        $title = "FIT FOR SEA DUTY";
                        break;
                    case '3':
                        $title =  "W/APPROVAL";
                        break;
                }

                $medical_validity = "VALID";
            } else if ($medical['status'] == "2") {
                $medical_validity = "PENDING";
            } else if ($medical['status'] == "3") {
                $medical_validity = "EXPIRED";
            } else if ($medical['status'] == "4") {
                $medical_validity = "REJECTED";
            }
        } else {
            $medical_validity = "N/A";
        }
        return $medical_validity;
    }

    public function medical_approval_report($date, $params = array())
    {
        $agency = 'Alphera';
        
        $this->db->select("
            COUNT(cm.id) as med_count,
            cm.remarks,
            ap.position_name,
            cm.date_created,
        ");

        $this->db->from("crews c");
        $this->db->join("crew_medical cm", "c.crew_code = cm.crew_code", "LEFT");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");

        if (!empty($params['search']['crew_type_search'])) {
            if ($params['search']['crew_type_search'] == 1) {
                $this->db->like('LOWER(acsr.agency)', strtolower($agency));
            } else {
                $this->db->not_like('LOWER(acsr.agency)', strtolower($agency));
            }
        }

        $this->db->where('YEAR(cm.date_created)', $date);
        $this->db->group_by('c.position');

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : []; 
    }

    public function joining_crew_expired_medical()
    {
        $expDate = Date('Y-m-d', strtotime('+60 days'));

        $this->db->select("
            COUNT(cm.id) as toc_count,
            cm.remarks,
            ap.position_name,
            cm.date_created,
            cm.crew_code,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        ");

        $this->db->from("crews c");
        $this->db->join("crew_medical cm", "c.crew_code = cm.crew_code", "LEFT");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");

        
        $this->db->where('c.status', 2);
        $this->db->where('cm.date_created <=',$expDate);

        $this->db->group_by('cm.medical_code');

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : []; 
    }

    public function joining_crew_re_medical()
    {
        $expDate = Date('Y-m-d', strtotime('+60 days'));

        $this->db->select("
            COUNT(cm.id) as toc_count,
            cm.remarks,
            ap.position_name,
            cm.date_created,
            cm.crew_code,
            cm.medical_status,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name
        ");

        $this->db->from("crews c");
        $this->db->join("crew_medical cm", "c.crew_code = cm.crew_code", "LEFT");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");

        
        $this->db->where('c.status', 2);
        $this->db->where('cm.date_created <=', $expDate);

        $this->db->group_by('cm.medical_code');

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : []; 
    }
}

/* End of file M_medical.php */
