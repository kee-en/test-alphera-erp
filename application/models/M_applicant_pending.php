<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_applicant_pending extends CI_Model
{

    public function getApplicantPending($params = array())
    {
        $this->db->select("
            a.applicant_code,
        	CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            a.date_available,
            a.status,
        	ap1.position_code position_first,
        	ap2.position_code position_second,
            ap1.position_name position_name1,
            ap2.position_name position_name2,
        	acpi.height,
        	acpi.weight,
        	a.nat_result,
        	ac.description city,
            ap.description province,
            ua.full_name f_assessor_name
        	");
        $this->db->from("applicants a");
        $this->db->join("ac_personal_info acpi", "a.applicant_code = acpi.applicant_code");

        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province ap", "acpi.region = ap.id", "LEFT");
        $this->db->join("a_position ap1", "a.position_first = ap1.id", "LEFT");
        $this->db->join("a_position ap2", "a.position_second = ap2.id", "LEFT");
        $this->db->join("user_account ua", "a.assessed_by = ua.user_code", "LEFT");

        $this->db->where('a.status', '1');

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
            $this->db->where('a.status', '1');
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

        //$this->db->where('a.nat_result', null);
        $this->db->order_by('a.date_updated', 'DESC');
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function addNATResult($applicant_code)
    {
        $nat = $this->input->post('n_aptitude_test_score');

        if ($nat < 50 || $nat < "50") {
            $this->db->where('applicant_code', $applicant_code)->set('nat_result', $nat)->update('applicants');
            $this->global->applicantNotQualified($applicant_code, "FAILED NAT EXAM");
            $update =  $this->global->updateApplicantStatus($applicant_code, 8);
            if ($update == true) {
                return true;
            } else if ($update == 'failed') {
                return "with_assessor";
            } else {
                return false;
            }
        } else {
            $this->db->where('applicant_code', $applicant_code)->set('nat_result', $nat)->update('applicants');
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
}

/* End of file M_applicant_pending.php */
/* Location: ./application/models/M_applicant_pending.php */
