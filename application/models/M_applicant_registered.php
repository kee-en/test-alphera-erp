<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;
use \PhpOffice\PhpSpreadsheet\Writer\IWriter;
use \PhpOffice\PhpSpreadsheet\IOFactory;


class M_applicant_registered extends CI_Model
{

    function getApplicantRegistered($params = array())
    {
        $status = ['0', '1', '2', '3', '4', '5', '6'];

        $this->db->select("
        a.applicant_code,
        a.date_available,
        a.status,
        a.nat_result,
        a.crew_code,
        a.assessed_by,
        CONCAT(acpi.first_name, ' ',acpi.middle_name, ' ',acpi.last_name) full_name,
        acpi.email_address,
        acpi.weight,
        acpi.height,
        ap1.position_code position_one,
        ap2.position_code position_two,
        ap1.position_name position_name1,
        ap2.position_name position_name2,
        p.description province_name,
        c.description city_name,
        ua.full_name f_assessor_name");
        $this->db->from("applicants a");
        $this->db->join("ac_personal_info acpi", "a.applicant_code = acpi.applicant_code");
        $this->db->join("user_account ua", "a.assessed_by = ua.user_code", "LEFT");

        $this->db->join("a_position ap1", "a.position_first = ap1.id", "LEFT");
        $this->db->join("a_position ap2", "a.position_second = ap2.id", "LEFT");
        $this->db->join("a_province p", "acpi.region = p.id", "LEFT");
        $this->db->join("a_city c", "acpi.city = c.id", "LEFT");

        if (!empty($status)) {
            // $count = 0;

            // $this->db->group_start();
            // foreach ($status as $key) {
            //     if ($count === 0) {
            //         $this->db->where('a.status', $key);
            //     } else {
            //         $this->db->or_where('a.status', $key);
            //     }
            //     $count++;
            // }
            // $this->db->group_end();

            $this->db->where_in('a.status', $status);
        }

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

        if (!empty($params['search']['status_search'])) {
            $this->db->group_start();
            $this->db->where('a.status', $params['search']['status_search']);
            $this->db->group_end();
        }

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->order_by("a.date_created", "DESC");
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function getApplicantPhoto($hashed_applicant_code)
    {

        $applicant_code = $this->global->ecdc('dc', $hashed_applicant_code);

        $query = $this->db->select("file_name")->from("ac_files")->where(array("file_code" => 'APLPHOTO', "applicant_code" => $applicant_code))->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();

            if (file_exists("uploads/applicants/{$hashed_applicant_code}/{$result['file_name']}")) {
                return base_url("uploads/applicants/{$hashed_applicant_code}/{$result['file_name']}");
            } else {
                return base_url('assets/images/avatar-placeholder.png');
            }
        } else {
            return base_url('assets/images/avatar-placeholder.png');
        }
    }


    public function getApplicantPersonalData($applicant_code)
    {

        $this->db->select("
            acpi.*,
            app.position_first,
            app.position_second,
            app.date_available,
            acnok.spouse_name,
            acnok.occupation,
            acnok.no_of_children,
            acnok.father_name,
            acnok.mother_name,
            acnok.address as next_kin_address,
            aceat.course,
            aceat.school,
            aceat.school_address,
            aceat.inclusive_years,
            acwg.cover_all,
            acwg.winter_jacket,
            acwg.shoes,
            acwg.winter_boots,
            c.description as cty,
            p.description as prvince,
        ");

        $this->db->from("applicants app");
        $this->db->join("ac_personal_info acpi", "app.applicant_code = acpi.applicant_code");
        $this->db->join("ac_next_of_kin acnok", "app.applicant_code = acnok.applicant_code");
        $this->db->join("ac_educational_attainment aceat", "app.applicant_code = aceat.applicant_code");
        $this->db->join("ac_working_gears acwg", "app.applicant_code = acwg.applicant_code");
        $this->db->join("a_province p", "acpi.region = p.id", "LEFT");
        $this->db->join("a_city c", "acpi.city = c.id", "LEFT");


        $this->db->where("app.applicant_code", $applicant_code);


        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->row_array() : [];
    }

    public function get_total_newhire()
    {
        $this->db->select("
            COUNT(app.id) as rank_count,
            as.description
        ");

        $this->db->from("applicants app");
        $this->db->join("a_source as", "as.id = app.source");
        $this->db->where('app.type_applicant !=', 'OLD');   
        $this->db->group_by('app.source');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}

/* End of file M_applicant_registered.php */
