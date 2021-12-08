<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_applicant_passed extends CI_Model
{

    function getApplicantPassed($params = array())
    {
        $this->db->select("
        a.applicant_code,
        a.nat_result,
        a.date_available,
        a.status,
        CONCAT(acpi.first_name, ' ',acpi.middle_name, ' ',acpi.last_name) full_name,
        acpi.height,
        acpi.weight,
        ap.position_code approved_position,
        ap.position_name approved_position_name,
        av.vsl_code vessel_code,
        ac.description city_name,
        p.description province_name,
        ua.full_name f_assessor_name");
        $this->db->from("applicants a");
        $this->db->join("ac_personal_info acpi", "a.applicant_code = acpi.applicant_code");

        $this->db->join("a_position ap", "a.approved_position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "a.assign_vessel = av.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province p", "acpi.region = p.id", "LEFT");
        $this->db->join("user_account ua", "a.assessed_by = ua.user_code", "LEFT");

        $this->db->where('a.status', 6);

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
            $this->db->like('a.assign_vessel', $params['search']['vessel_search']);
        }

        if (!empty($params['search']['rank_search'])) {
            $this->db->where('a.position_first', $params['search']['rank_search']);
            $this->db->or_where('a.position_second', $params['search']['rank_search']);
        }

        if (!empty($params['search']['month_search_from']) && !empty($params['search']['month_search_to'])) {
            $this->db->where('a.date_available >=', $params['search']['month_search_from']);
            $this->db->where('a.date_available <=', $params['search']['month_search_to']);
        }

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function moveCMPlan($applicant_code)
    {
        $applicant = $this->db->where('applicant_code', $applicant_code)->get('applicants')->row_array();
        $crew_code = $this->global->genrateCrewID('CRW');
        $monitor_code = $this->global->generateID('MNT');

        $crew = [
            'monitor_code' => $monitor_code,
            'crew_code' => $crew_code,
            'applicant_code' => $applicant['applicant_code'],
            'position' => $applicant['approved_position'],
            'vessel_assign' => $applicant['assign_vessel'],
            'date_available' => $applicant['date_available'],
            'status' => '1',
            'date_created' => date('Y-m-d H:i:s')
        ];

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->insert('crews', $crew);

        $this->db->where('applicant_code', $applicant_code)->set('status', "9")->set('crew_code', $crew_code)->update('applicants');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_personal_info');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_next_of_kin');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_educational_attainment');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_working_gears');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_licenses_endorsement_book_id');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_training_certificates');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_sea_service_record');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_files');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_evaluation_sheet');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_form_newly_employed_crew');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_interview_general');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_interview_sheet');
        $this->db->where('applicant_code', $applicant_code)->set('crew_code', $crew_code)->update('ac_interview_technical');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_total_passed()
    {
        $this->db->select("
            COUNT(app.id) as rank_count,
            as.description
        ");

        $this->db->from("applicants app");
        $this->db->join("a_source as", "as.id = app.source", "LEFT");
        $this->db->join("a_position ap", "app.approved_position = ap.id", "LEFT");
        $this->db->where(array('app.type_applicant !=' => 'OLD', 'app.status' => 6));
        $this->db->or_where(array('app.type_applicant !=' => 'OLD', 'app.status' => 9));   
        $this->db->group_by('app.source');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function get_count_per_rank()
    {
        $applicant = "OLD";
        $this->db->select("
            COUNT(app.id) as rank_count,
            ap.position_name,
            app.remark,
            app.status
        ");

        $this->db->from("applicants app");
        $this->db->join("a_position ap", "app.approved_position = ap.id", "LEFT");

        $this->db->group_start();
        $this->db->where('LOWER(app.type_applicant) !=', strtolower($applicant));
        $this->db->group_end();

        $this->db->group_by('app.approved_position');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function get_total_passed_per_rank()
    {
        $this->db->select("
            COUNT(app.id) as rank_count,
            ap.position_name,
        ");

        $this->db->from("applicants app");
        $this->db->join("a_position ap", "app.approved_position = ap.id", "LEFT");

        $this->db->where(array('app.type_applicant !=' => 'OLD', 'app.status' => 6));
        $this->db->or_where('app.status', 9);   
        $this->db->group_by('app.approved_position');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}

/* End of file M_applicant_passed.php */
