<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_new_crew extends CI_Model
{

    function getNewCrew($params = array())
    {
        $this->db->select("
        c.applicant_code,
        c.crew_code,
        c.monitor_code,
        MAX(c.date_available) date_available,
        MAX(c.status) status,
        c.date_created,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        ap.position_code,
        ap.position_name,
        av.vsl_name,
        av.vsl_code,
        ac.description city_name,
        apr.description province_name,
        acpi.height,
        acpi.weight,
        cp.contract_duration");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("crew_poea cp", "cp.crew_monitor = c.monitor_code", "LEFT");

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
            // $this->db->group_end();
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

        if (!empty($params['search']['status_search'])) {
            $this->db->group_start();
            $this->db->like('c.status', $params['search']['status_search']);
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

        $this->db->where("c.status", 1);
        $this->db->group_by('c.crew_code');
        $this->db->order_by("c.date_created", "DESC");

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}

/* End of file M_new_crew.php */
