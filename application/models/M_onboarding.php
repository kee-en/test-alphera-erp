<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_onboarding extends CI_Model
{

    function getOnboardingCrew($params = array())
    {
        $this->db->select("
            c.crew_code,
            c.monitor_code,
            c.applicant_code,
            c.date_available,
            c.status,
            c.flight_code,
            c.embark_date,
            c.flight_code,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            av.vsl_code,
            ac.description city_name,
            apr.description province_name,
            cp.contract_duration,
            acrs.routing_details
        ");

        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("crew_poea cp", "cp.crew_monitor = c.monitor_code", "LEFT");
        $this->db->join("ac_routing_slip acrs", "acrs.monitoring_code = c.monitor_code", "LEFT");

        $this->db->where("c.status", "2");
        $this->db->order_by("c.date_created", "DESC");
        $this->db->group_by("c.crew_code");

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
            // $this->db->group_start();
            // $this->db->like('acpi.first_name', $params['search']['name_search']);
            // $this->db->or_like('acpi.middle_name', $params['search']['name_search']);
            // $this->db->or_like('acpi.last_name', $params['search']['name_search']);
            // $this->db->group_end();
        }

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

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function addCrewCMPlan()
    {
        $monitor_code = $this->input->post("monitor_code");
        $crew_code = $this->input->post("crew_code");

        $crew = $this->db->where('monitor_code', $monitor_code)->get('crews')->row_array();
        $latest_contract = $this->db->where('crew_code', $crew_code)->order_by('date_created', 'DESC')->get('crew_poea')->row_array();

        if ($latest_contract != NULL && $crew['flight_code'] != NULL) {

            $crew_cmp = $this->db->where('offsigner', $monitor_code)->get('cm_plan');

            if ($crew_cmp->num_rows() > 0) {
                $crews_data = [
                    'status' => 3,
                    'date_updated' => date('Y-m-d H:i:s')
                ];

                $applicant_history = [
                    'applicant_code'  => $monitor_code,
                    'applicant_status' => 3,
                    'issued_by' => $this->session->userdata('user_code') != null ? $this->session->userdata('user_code') : "",
                    'date_created'    => date("Y-m-d H:i:s"),
                ];

                $data = [
                    'disembark' => $latest_contract['contract_duration'],
                    'status'    => 3,
                    'date_updated' => date("Y-m-d H:i:s")
                ];


                $this->db->trans_strict(true);
                $this->db->trans_begin();

                $this->db->where('offsigner', $monitor_code)->update('cm_plan', $data);
                $this->db->where('monitor_code', $monitor_code)->update('crews', $crews_data);
                $this->db->insert('applicant_history', $applicant_history);

                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return true;
                }
            } else {

                $crews_data = [
                    'status' => 3,
                    'date_updated' => date('Y-m-d H:i:s')
                ];

                $applicant_history = [
                    'applicant_code'  => $monitor_code,
                    'applicant_status' => 3,
                    'issued_by' => $this->session->userdata('user_code') != null ? $this->session->userdata('user_code') : "",
                    'date_created'    => date("Y-m-d H:i:s"),
                ];

                $data = [
                    'cmp_code' => $this->global->generateID("CMP"),
                    'offsigner' => $monitor_code,
                    'position' => $crew['position'],
                    'vessel_code' => $crew['vessel_assign'],
                    'embark' => $crew['embark_date'],
                    'disembark' => $latest_contract['contract_duration'],
                    'status' => 3,
                    'date_created' => date("Y-m-d H:i:s")
                ];


                $this->db->trans_strict(true);
                $this->db->trans_begin();

                $this->db->insert('cm_plan', $data);
                $this->db->where('monitor_code', $monitor_code)->update('crews', $crews_data);
                $this->db->insert('applicant_history', $applicant_history);

                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return true;
                }
            }
        } else {
            return "incomplete";
        }
    }

    function addCrewFlight($flight_code, $monitor_code)
    {
        $this->db->where('monitor_code', $monitor_code)->set('flight_code', $flight_code)->update('crews');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}

/* End of file M_onboarding.php */
