<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_report extends CI_Model
{
    function getGeneralReport($params)
    {

        if ($params['search']['search_table'] === "warning_letter") {
            if (!empty($params['search']['search_filter'])) {
                $this->db->select("
                acwl.id,
                acwl.crew_code,
                acwl.applicant_code,
                acwl.date_created,
                acwl.issued_by,
                acwl.remarks,
                acwl.status,
                av.id vsl_id,
                ap.id rank,
                ad.id department,
                CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) crew_name,
                av.id vessel,
                ad.department_name");
                $this->db->from("c_" . $params['search']['search_table'] . " acwl");
                $this->db->join("ac_personal_info acpi", "acwl.applicant_code = acpi.applicant_code");
                $this->db->join("a_position ap", "acwl.rank = ap.id", "LEFT");
                $this->db->join("a_vessels av", "acwl.vessel = av.id", "LEFT");
                $this->db->join("a_type_of_department ad", "acwl.department = ad.id", "LEFT");

                if (!empty($params['search']['search_filter'])) {
                    $this->db->or_like("CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name)", $params['search']['search_filter']);
                    $this->db->or_like("ap.position_name", $params['search']['search_filter']);
                    $this->db->or_like("ad.department_name", $params['search']['search_filter']);
                    $this->db->or_like("av.vsl_name", $params['search']['search_filter']);
                }
                $this->db->order_by("acwl.date_created", "DESC");
                $query = $this->db->get();
                return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
            } else {
                return $this->db->order_by('date_created', 'DESC')->get('c_' . $params['search']['search_table'] . '')->result_array();
            }
        } else {

            if (!empty($params['search']['search_filter'])) {
                $this->db->select("
                acwl.id,
                acwl.crew_code,
                acwl.applicant_code,
                acwl.date_created,
                acwl.certificates,
                acwl.issued_by,
                acwl.status,
                ac.cert_name,
                acwl.e_registration,
                av.id vsl_id,
                ap.id rank,
                ad.id department,
                CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) crew_name,
                av.id vessel,
                ad.department_name");
                $this->db->from("c_" . $params['search']['search_table'] . " acwl");
                $this->db->join("ac_personal_info acpi", "acwl.applicant_code = acpi.applicant_code");
                $this->db->join("a_position ap", "acwl.rank = ap.id", "LEFT");
                $this->db->join("a_vessels av", "acwl.vessel = av.id", "LEFT");
                $this->db->join("a_type_of_department ad", "acwl.department = ad.id", "LEFT");
                $this->db->join("a_certificates ac", "acwl.certificates = ac.id", "LEFT");

                if (!empty($params['search']['search_filter'])) {
                    $this->db->or_like("CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name)", $params['search']['search_filter']);
                    $this->db->or_like("ap.position_name", $params['search']['search_filter']);
                    $this->db->or_like("ad.department_name", $params['search']['search_filter']);
                    $this->db->or_like("av.vsl_name", $params['search']['search_filter']);
                }

                $this->db->order_by("acwl.date_created", "DESC");

                $query = $this->db->get();

                return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
            } else {
                return $this->db->order_by('date_created', 'DESC')->get('c_' . $params['search']['search_table'] . '')->result_array();
            }
        }
    }
}
