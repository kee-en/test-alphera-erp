<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_pre_joining extends CI_Model
{

    function getPreJoiningCrew($params = array())
    {
        $this->db->select("
            c.crew_code,
            c.date_available,
            c.status,
            c.offsigner,
            c.monitor_code,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.height,
            acpi.weight,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            av.vsl_code,
            ac.description city_name,
            apr.description province_name,
            ad.department_name,
            actc.certificates,
            aclc.expiry_date,
        ");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("a_type_of_department ad", "ap.type_of_department = ad.id", "LEFT");
        $this->db->join("ac_training_certificates actc", "actc.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_licenses_endorsement_book_id aclc", "aclc.crew_code = c.crew_code", "LEFT");

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
            if ($params['search']['flight_search'] === "1") {
                $this->db->where('c.flight_code !=', NULL);
            } else if ($params['search']['flight_search'] === "0") {
                $this->db->where('c.flight_code !=', NULL);
            }
        }

        if (!empty($params['search']['month_search_from']) && !empty($params['search']['month_search_to'])) {
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
        }

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->where("c.status", "2");
        $this->db->group_by('c.crew_code');
        $this->db->order_by("c.date_created", "DESC");
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function saveCrewLicenses()
    {
        $crew_code = $this->input->post('l_crew_code');

        $licenses = [
            'lebi' => json_encode($this->input->post('lebi')),
            'grade' => json_encode($this->input->post('l_grade')),
            'number' => json_encode($this->input->post('l_number')),
            'date_issued' => json_encode($this->input->post('l_date_issued')),
            'expiry_date' => json_encode($this->input->post('l_expiry_date')),
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $this->db->where('crew_code', $crew_code)->update('ac_licenses_endorsement_book_id', $licenses);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveCrewTrainings()
    {
        $crew_code = $this->input->post('t_crew_code');

        $trainings = [
            'certificates' => json_encode($this->input->post('t_id')),
            'number' => json_encode($this->input->post('t_number')),
            'date_issued' => json_encode($this->input->post('t_date_issued')),
            'expiration_date' => json_encode($this->input->post('t_date_expired')),
            'issued_by' => json_encode($this->input->post('t_issued_by')),
            'with_cop_number' => json_encode($this->input->post('t_cop_number')),
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $check_certs = $this->db->where('crew_code', $crew_code)->get('ac_training_certificates');

        if ($check_certs->num_rows() > 0) {
            $this->db->where('crew_code', $crew_code)->update('ac_training_certificates', $trainings);

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {

            $trainings_new = [
                'crew_code'     => $crew_code,
                'certificates' => json_encode($this->input->post('t_id')),
                'number' => json_encode($this->input->post('t_number')),
                'date_issued' => json_encode($this->input->post('t_date_issued')),
                'expiration_date' => json_encode($this->input->post('t_date_expired')),
                'issued_by' => json_encode($this->input->post('t_issued_by')),
                'with_cop_number' => json_encode($this->input->post('t_cop_number')),
                'date_updated' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('ac_training_certificates', $trainings_new);

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    function filterPrejoiningReport($params = array())
    {
        $this->db->select("
            cmp.*,
            av.vsl_name,
            ap.position_name,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.mobile_number,
            cp.contract_duration,
            c.date_available,
            c.crew_code,
            cm.medical_status,
            aclc.expiry_date,
            actc.number,
            cmlc.date_created as mlc_created,
        ");
        $this->db->from("cm_plan cmp");
        $this->db->join("crews c", "cmp.insigner = c.monitor_code");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "cmp.position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "cmp.vessel_code = av.id", "LEFT");
        $this->db->join("crew_poea cp", "cp.crew_code = c.crew_code", "LEFT");
        $this->db->join("crew_mlc cmlc", "cmlc.crew_code = c.crew_code", "LEFT");
        $this->db->join("crew_medical cm", "cm.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_licenses_endorsement_book_id aclc", "aclc.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_training_certificates actc", "actc.crew_code = c.crew_code", "LEFT");

        if (!empty($params['search']['contract_search'])) {
            if ($params['search']['contract_search'] === "+30 days") {
                $NewDate = Date('Y-m-d', strtotime($params['search']['contract_search']));
                $this->db->where('cp.contract_duration <=', $NewDate);
            } else if ($params['search']['contract_search'] === "+60 days") {
                $NewDate = Date('Y-m-d', strtotime($params['search']['contract_search']));
                $LimitDate = Date('Y-m-d', strtotime("+89 days"));
                $this->db->where('cp.contract_duration >=', $NewDate);
                $this->db->where('cp.contract_duration <=', $LimitDate);
            } else if ($params['search']['contract_search'] === "+90 days" || $params['search']['contract_search'] === "+100 days") {
                $NewDate = Date('Y-m-d', strtotime($params['search']['contract_search']));
                $this->db->where('cp.contract_duration >=', $NewDate);
            }
        }

        if (!empty($params['search']['name_search'])) {
            $this->db->like('acpi.first_name', $params['search']['name_search']);
        }
        if (!empty($params['search']['name_search'])) {
            $this->db->or_like('acpi.middle_name', $params['search']['name_search']);
        }
        if (!empty($params['search']['name_search'])) {
            $this->db->or_like('acpi.last_name', $params['search']['name_search']);
        }

        if (!empty($params['search']['vessel_search'])) {
            $this->db->like('c.vessel_assign', $params['search']['vessel_search']);
        }

        if (!empty($params['search']['rank_search'])) {
            $this->db->like('c.position', $params['search']['rank_search']);
        }

        if (!empty($params['search']['flight_search'])) {
            if ($params['search']['flight_search'] === "1") {
                $this->db->where('c.flight_code !=', NULL);
            } else if ($params['search']['flight_search'] === "0") {
                $this->db->where('c.flight_code !=', NULL);
            }
        }

        if (!empty($params['search']['month_search_from']) && !empty($params['search']['month_search_to'])) {
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
        }

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->where("c.status", "2");
        $this->db->group_by('c.crew_code');
        $this->db->order_by("c.date_created", "DESC");
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}

/* End of file M_pre_joining.php */
