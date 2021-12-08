<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_applicant_reserved extends CI_Model
{
    function getApplicantReserved($params = array())
    {
        $this->db->select("
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        a.applicant_code,
        a.status,
        a.date_available,
        a.nat_result,
        acpi.height,
        acpi.weight,
        ap1.position_code position_one,
        ap2.position_code position_two,
        ap1.position_name position_name1,
        ap2.position_name position_name2,
        ap3.position_code approved_position,
        ap3.position_name approved_position_name,
        ac.description city_name,
        ap.description province_name,
        ua.full_name f_assessor_name");
        $this->db->from("applicants a");
        $this->db->join("ac_personal_info acpi", "a.applicant_code = acpi.applicant_code");

        $this->db->join("a_position ap1", "a.position_first = ap1.id", "LEFT");
        $this->db->join("a_position ap2", "a.position_second = ap2.id", "LEFT");
        $this->db->join("a_position ap3", "a.approved_position = ap3.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province ap", "acpi.region = ap.id", "LEFT");
        $this->db->join("user_account ua", "a.assessed_by = ua.user_code", "LEFT");

        $this->db->where("a.status", 7);

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
            $this->db->where('a.assign_vessel', $params['search']['vessel_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['rank_search'])) {
            $this->db->group_start();
            $this->db->where('a.position_first', $params['search']['rank_search']);
            $this->db->or_where('a.position_second', $params['search']['rank_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['month_search_from']) && !empty($params['search']['month_search_to'])) {
            $this->db->group_start();
            $this->db->where('a.date_available >=', $params['search']['month_search_from']);
            $this->db->where('a.date_available <=', $params['search']['month_search_to']);
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

    function revert_reserved_status()
    {
        $applicant_code = $this->input->post('applicant_code');

        $query = $this->db->select('applicant_status')->from('applicant_history')->where('applicant_code', $applicant_code)->order_by('id', 'desc')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}

/* End of file M_applicant_reserved.php */
