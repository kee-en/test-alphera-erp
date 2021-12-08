<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_applicant_failed extends CI_Model
{

    function getApplicantFailed($params = array())
    {
        $this->db->select("
        a.applicant_code,
        a.nat_result,
        a.date_available,
        a.status,
        ap1.position_code position_one,
        ap2.position_code position_second,
        ap1.position_name position_name1,
        ap2.position_name position_name2,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        acpi.height,
        acpi.weight,
        ap.description province_name,
        ac.description city_name,
        ua.full_name f_assessor_name");
        $this->db->from("applicants a");
        $this->db->join("ac_personal_info acpi", "a.applicant_code = acpi.applicant_code");

        $this->db->join("a_position ap1", "a.position_first = ap1.id", "LEFT");
        $this->db->join("a_position ap2", "a.position_second = ap2.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province ap", "acpi.region = ap.id", "LEFT");
        $this->db->join("user_account ua", "a.assessed_by = ua.user_code", "LEFT");

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


        $this->db->where("a.status", 8);
        $this->db->order_by("a.date_created", "DESC");
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function getFailedRemark($applicant_code)
    {
        $query = $this->db->select('remark')->where('applicant_code', $applicant_code)->where('status', 8)->get('applicants');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function get_rank_failed_count()
    {
        $this->db->select("
            COUNT(app.id) as rank_count,
            ap.position_name,
            app.remark
        ");

        $this->db->from("applicants app");
        $this->db->join("a_position ap", "app.approved_position = ap.id");
        $this->db->where(array('app.type_applicant !=' => 'OLD', 'app.status' => 8));
        $this->db->group_by('app.approved_position');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function get_all_applicants_performance()
    {
        $this->db->select("
            app.remark,
            app.status,
            ap.position_name,
        ");

        $this->db->from("applicants app");
        $this->db->join("a_position ap", "app.approved_position = ap.id");

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}

/* End of file M_applicant_failed.php */
