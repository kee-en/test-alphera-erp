<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_evaluation_sheet_form extends CI_Model
{

    function saveEditEvaluationSheetForm($id)
    {

        $tob_period = $this->input->post("tob_period");
        $sks_skr = $this->input->post("sks_skr");
        $skor_standard = $this->input->post("skor_standard");
        $age_standard = $this->input->post("age_standard");
        $min_age = $this->input->post("min_age");


        $data_evaluation = [
            "min_age" => strtoupper($min_age),
            "tob_period" => strtoupper($tob_period),
            "sks_skr" => stripslashes(strtoupper($sks_skr)),
            "skor_standard" => strtoupper($skor_standard),
            "age_standard" => strtoupper($age_standard),
        ];


        $data = [
            'additional_point' => strtoupper(json_encode($this->input->post('additional_point'))),
            'subtract_point' => strtoupper(json_encode($this->input->post('subtract_point'))),
            "evaluations" => json_encode($data_evaluation),
        ];

        $this->db->where('id', $id)->update('a_position', $data);

        return true;
    }

    public function get_evaluation_count()
    {
        $agency = 'Alphera';

        $this->db->select("
            c.crew_code,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.id position_id,
            ap.position_code,
            ap.position_name,
            cg.grade
        ");

        $this->db->from("crews c");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("crew_grade cg", "cg.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");

        $this->db->where('c.status !=', 0);
        
        $this->db->group_start();
        $this->db->like('LOWER(acsr.agency)', strtolower($agency));
        $this->db->group_end();

        $this->db->order_by('c.date_created', 'DESC');
        $this->db->group_by('c.position');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function get_evaluation_count_ncrew()
    {
        $agency = 'Alphera';

        $this->db->select("
            c.crew_code,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.id position_id,
            ap.position_code,
            ap.position_name,
            cg.grade
        ");

        $this->db->from("crews c");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("crew_grade cg", "cg.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");

        $this->db->where('c.status !=', 0);
        
        $this->db->group_start();
        $this->db->like('LOWER(acsr.agency)', strtolower($agency));
        $this->db->group_end();

        $this->db->order_by('c.date_created', 'DESC');
        $this->db->group_by('c.position');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}

/* End of file M_evaluation_sheet_form.php */
