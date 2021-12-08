<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_ex_crew extends CI_Model
{

    function getExCrew($params = array())
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
        ad.department_name,
        acpi.height,
        acpi.weight,
        cp.contract_duration");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("a_type_of_department ad", "ap.type_of_department = ad.id", "LEFT");
        $this->db->join("crew_poea cp", "cp.crew_monitor = c.monitor_code", "LEFT");

        $this->db->where('c.status', "7");

        if (!empty($params['search']['name_search'])) {
            $this->db->group_start();
            $this->db->like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.middle_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.last_name, acpi.first_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->group_end();
            // $this->db->like('acpi.first_name', $params['search']['name_search']);
        }
        // if (!empty($params['search']['name_search'])) {
        //     $this->db->or_like('acpi.middle_name', $params['search']['name_search']);
        // }
        // if (!empty($params['search']['name_search'])) {
        //     $this->db->or_like('acpi.last_name', $params['search']['name_search']);
        // }

        if (!empty($params['search']['vessel_search'])) {
            $this->db->where('c.vessel_assign', $params['search']['vessel_search']);
        }

        if (!empty($params['search']['rank_search'])) {
            $this->db->like('c.position', $params['search']['rank_search']);
        }

        $this->db->group_by('c.crew_code');
        $this->db->order_by('c.date_created', "DESC");

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function getCrewByStatus($positon_id, $vessel_id)
    {
        $this->db->select("c.monitor_code, c.crew_code, c.date_available, c.status");
        $this->db->from("crews c");
        $this->db->where('c.vessel_assign', $vessel_id);
        $query = $this->db->get();
        $crewData = ($query->num_rows() > 0) ?  $query->result_array() : [];

        if (count($crewData) > 0) {
            $this->db->select("c.monitor_code, c.crew_code, CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name, c.date_available, c.status");
            $this->db->from("crews c");
            $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
            $this->db->where('c.position', $positon_id);
            $this->db->where('c.vessel_assign', $vessel_id);
            $this->db->where('c.status', '7');
            $this->db->or_where('c.status', '1');
            $query = $this->db->get();
            $crewOnSigner = ($query->num_rows() > 0) ?  $query->result_array() : [];
        } else {
            $this->db->select("c.monitor_code, c.crew_code, CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name, c.date_available, c.status");
            $this->db->from("crews c");
            $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
            $this->db->where('c.position', $positon_id);
            $this->db->where('c.status', '7');
            $this->db->or_where('c.status', '1');
            $query = $this->db->get();
            $crewOnSigner = ($query->num_rows() > 0) ?  $query->result_array() : [];
        }



        $option = '<select class="custom-select" id="on_signer_crew" name="on_signer_crew" style="font-weight: 500;letter-spacing: 0.5px;">';
        $option .= '<option value="">Select Crew On Signer</option>';
        $option .= '<optgroup label="Ex-Crew">';
        foreach ($crewOnSigner as $key) {
            if ($key['status'] === '7') {
                $option .= '<option value="' . $key['monitor_code'] . '">' . $key['full_name'] . " - " . date("F j,Y", strtotime($key['date_available'])) . '</option>';
            }
        }

        $option .= '</optgroup>';
        $option .= ' <optgroup label="New Crew">';

        foreach ($crewOnSigner as $key) {
            if ($key['status'] === '1') {
                $option .= '<option value="' . $key['monitor_code'] . '" >' . $key['full_name'] . " - " . date("F j,Y", strtotime($key['date_available'])) . '</option>';
            }
        }

        $option .= '</optgroup>';

        $option .= '</select>';
        foreach ($crewOnSigner as $key) {
            if ($key['status'] === '1') {
                $option .= '<input type="hidden" id="crew_code_hidden" name="crew_code_hidden" value="' . $key['crew_code'] . '">';
                $option .= '<input type="hidden" id="crew_name_hidden" name="crew_name_hidden" value="' . $key['full_name'] . '">';
            }
        }

        return $option;
    }

    public function get_ex_crew_details($crew_code)
    {
        $this->db->select("
        acpi.*,
        c.applicant_code,
        c.crew_code,
        c.date_available,
        c.vessel_assign,
        c.`position`,
        kin.name_of_children,
        kin.birthday_of_children,
        kin.contact_of_children,
        kin.spouse_name,
        kin.occupation,
        kin.no_of_children,
        kin.father_name,
        kin.mother_name,
        kin.address,
        ssr.embarked,
        ssr.disembarked,
        wg.cover_all,
        wg.winter_jacket,
        wg.shoes,
        wg.winter_boots,
        educ.course,
        educ.school,
        educ.inclusive_years,
        educ.school_address");
        $this->db->from("crews  c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_next_of_kin kin", "kin.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_sea_service_record ssr", "ssr.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_working_gears wg", "wg.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_educational_attainment educ", "educ.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_training_certificates tc", "tc.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_licenses_endorsement_book_id lic", "lic.crew_code = acpi.crew_code", "LEFT");

        $this->db->where("c.crew_code", $crew_code);
        $this->db->group_by('acpi.crew_code');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : FALSE;
    }

    public function get_all_on_vacation()
    {
        $this->db->select("c.*, ap.type_of_department");
        $this->db->from("crews c");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->group_by('c.crew_code');
        $this->db->order_by('c.date_created', "DESC");
        $this->db->where('c.status', "7");
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function get_on_vacation_count()
    {
        $this->db->select("COUNT(crew_code) as total_crew");
        $this->db->from("crews");
        $this->db->group_by('crew_code');
        $this->db->order_by('date_created', "DESC");
        $this->db->where('status', "7");
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function get_ex_crew_count()
    {
        $this->db->select('COUNT(crew_code) as total_count');
        $this->db->from('crew_history');
        $this->db->where('crew_status', 3);
        $this->db->group_by('crew_code');
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}

/* End of file M_new_crew.php */
