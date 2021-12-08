<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_nre_crew extends CI_Model
{

    function getCrewNotForRehire($params = array())
    {
        $this->db->select("
        c.applicant_code,
        c.crew_code,
        c.date_available,
        c.status,
        c.monitor_code,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        ap.position_code,
        ac.description city_name,
        apr.description province_name,
        ap.position_name,
        av.vsl_name,
        av.vsl_code,
        cp.contract_duration");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("crew_poea cp", "cp.crew_monitor = c.monitor_code", "LEFT");

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
            $this->db->where('c.position', $params['search']['rank_search']);
            $this->db->group_end();
        }

        $this->db->where("c.status", 6);
        $this->db->order_by("c.date_created", "DESC");

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function get_nre_count()
    {
        $this->db->select("COUNT(crew_code) as total_count");
        $this->db->from("crews");
        $this->db->where("status", 6);
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function get_nre_report($date, $toc_filter = array())
    {
        $agency = 'Alphera';

        $this->db->select("
            ap.position_name,
            COUNT(c.id) as nre_count,
            aws.description
        ");

        $this->db->from("crews c");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("ac_warning_letter acw", "c.crew_code = acw.crew_code", "LEFT");
        $this->db->join("a_warning_status aws", "acw.reason = aws.id", "LEFT");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");

        $this->db->where(array('YEAR(c.date_created)' => $date, 'c.status' => 6, 'acw.remarks' => 1));
        $this->db->like('LOWER(acsr.agency)', strtolower($agency));

        if (!empty($toc_filter['search']['rank_filter'])) {
            $this->db->where('c.position', $toc_filter['search']['rank_filter']);
            $this->db->group_by('c.position');
        }else{
            $this->db->group_by('acw.reason');
        }

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function get_nh_nre_report($date, $toc_filter = array())
    {
        $agency = 'Alphera';

        $this->db->select("
            ap.position_name,
            COUNT(c.id) as nre_count,
            aws.description
        ");

        $this->db->from("crews c");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("ac_warning_letter acw", "c.crew_code = acw.crew_code", "LEFT");
        $this->db->join("a_warning_status aws", "acw.reason = aws.id", "LEFT");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");

        $this->db->where(array('YEAR(c.date_created)' => $date, 'c.status' => 6, 'acw.remarks' => 1));
        $this->db->not_like('LOWER(acsr.agency)', strtolower($agency));

        if (!empty($toc_filter['search']['rank_filter'])) {
            $this->db->where('c.position', $toc_filter['search']['rank_filter']);
            $this->db->group_by('c.position');
        }else{
            $this->db->group_by('acw.reason');
        }

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}

/* End of file M_nre_crew.php */
