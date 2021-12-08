<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_all_crew extends CI_Model
{

    function getAllCrew($params = array())
    {
        $this->db->select("
        c.applicant_code,
        c.crew_code,
        c.status crew_status,
        c.monitor_code,
        cm.sign_on,
        cm.embark,
        cm.disembark,
        cm.cmp_code,
        MAX(c.date_available) date_available,
        MAX(c.status) status,
        c.date_created,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        ap.id pos_id,
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
        $this->db->join("cm_plan cm", "c.monitor_code = cm.offsigner", "LEFT");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("a_type_of_department ad", "ap.type_of_department = ad.id", "LEFT");
        $this->db->join("crew_poea cp", "cp.crew_monitor = c.monitor_code", "LEFT");

        $this->db->where('c.status !=', 0);

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
            // $this->db->like('acpi.first_name', trim($params['search']['name_search']));
            // $this->db->or_like('acpi.middle_name', trim($params['search']['name_search']));
            // $this->db->or_like('acpi.last_name', trim($params['search']['name_search']));
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

        if (!empty($params['search']['status_search'])) {
            $this->db->group_start();
            $this->db->like('c.status', $params['search']['status_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['flight_search'])) {
            $this->db->group_start();
            if ($params['search']['flight_search'] === "1") {
                $this->db->where('c.flight_code !=', NULL);
            } else if ($params['search']['flight_search'] === "0") {
                $this->db->where('c.flight_code !=', NULL);
            }
            $this->db->group_end();
        }


        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }


        $this->db->group_by('c.crew_code');
        $this->db->order_by('c.date_created', "DESC");

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function saveEditCrewInformation($crew_code)
    {
        $crew_info = $this->global->getCrewDet($crew_code);

        $applicant_code = $crew_info['applicant_code'];


        $applicant_code_hash = $this->global->ecdc('ec', $applicant_code);


        if ($this->input->post('web_image') != null) {
            $image = $_POST['web_image'];
            if (!file_exists(FCPATH . 'uploads/applicants/' . $applicant_code_hash)) {
                mkdir(FCPATH . 'uploads/applicants/' . $applicant_code_hash, 0777, true);
                chmod(FCPATH . 'uploads/applicants/' . $applicant_code_hash, 0777);
            }

            $folderPath = FCPATH . 'uploads/applicants/' . $applicant_code_hash . '/';

            $image_parts = explode(';base64,', $image);
            $image_type_aux = explode('image/', $image_parts[0]);

            $image_type = $image_type_aux[0];

            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'ApplicantPhoto_' . uniqid() . '.jpg';

            $file = $folderPath . $fileName;
            file_put_contents($file, $image_base64);

            chmod($file, 0777);

            $config_manip = [
                'image_library' => 'gd2',
                'source_image' =>  'uploads/applicants/' . $applicant_code_hash . '/' . $fileName,
                'new_image' => 'uploads/applicants/' . $applicant_code_hash . '/' . $fileName,
                'quality' => '100%',
                'width' => '300',
                'height' => '300',
                'maintain_ratio' => FALSE
            ];

            $this->load->library('image_lib', $config_manip);

            $this->image_lib->resize();
            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
            }

            $applicant_file = [
                'file_code' => "APLPHOTO",
                'file_name' => $fileName,
                'date_updated' => date("Y-m-d H:i:s"),
            ];

            $return = $this->checkAcFiles($applicant_code);

            if (empty($return) && is_null($return)) {
                $applicant_file = [
                    'applicant_code'  => $applicant_code,
                    'file_code' => "APLPHOTO",
                    'file_name' => $fileName,
                    'date_created'    => date("Y-m-d H:i:s"),
                    'status' => 1
                ];
                $this->db->insert('ac_files', $applicant_file);
            } else {
                $this->db->where('applicant_code', $applicant_code)->update('ac_files', $applicant_file);
            }
        }


        $personal_info = [
            'first_name' => strtoupper($this->input->post('e_first_name')),
            'middle_name' => strtoupper($this->input->post('e_middle_name')),
            'last_name' => strtoupper($this->input->post('e_last_name')),
            'suffix' => strtoupper($this->input->post('e_suffix')),
            'birth_date' => date("Y-m-d", strtotime($this->input->post('e_birth_date'))),
            'birth_place' => $this->input->post('e_birth_place'),
            'civil_status' => $this->input->post('e_civil_status'),
            'email_address' => $this->input->post('e_email_address'),
            'telephone_number' => $this->input->post('e_telephone_number'),
            'mobile_number' => $this->input->post('e_mobile_number'),
            'religion' => $this->input->post('e_religion'),
            'nationality' => $this->input->post('e_nationality'),
            'sss_no' => $this->input->post('e_sss_no'),
            'tin_number' => $this->input->post('e_tin_no'),
            'philhealth_no' => $this->input->post('e_philhealth_no'),
            'pag_ibig_no' => $this->input->post('e_pag_ibig_no'),
            'height' => $this->input->post('e_height'),
            'weight' => $this->input->post('e_weight'),
            'street_address' => $this->input->post('e_home_address'),
            'barangay' => $this->input->post('e_barangay'),
            'region' => $this->input->post('e_province'),
            'city' => $this->input->post('e_city'),
            'country' => $this->input->post('e_country'),
            'zip_code' => $this->input->post('e_zip_code'),
            'provincial' => $this->input->post('e_provincial'),
            'date_updated' => date('Y-m-d h:i:s')
        ];

        $next_of_kin = [
            'spouse_name' => $this->input->post('e_spouse_name'),
            'occupation' => $this->input->post('e_occupation'),
            'no_of_children' => $this->input->post('e_no_of_children'),
            'name_of_children' => json_encode($this->input->post('r_full_name')),
            'birthday_of_children' => json_encode($this->input->post('r_birth_date')),
            'contact_of_children' => json_encode($this->input->post('r_mobile_no')),
            'father_name' => $this->input->post('e_father_name'),
            'mother_name' => $this->input->post('e_mother_name'),
            'address' => $this->input->post('e_kin_address'),
            'date_updated' => date('Y-m-d h:i:s'),
        ];

        $inclusive_years = [$this->input->post('e_inclusive_years_from'), $this->input->post('e_inclusive_years_to')];

        $education_attainment = [
            'course' => $this->input->post('e_course'),
            'school' => $this->input->post('e_school_name'),
            'school_address' => $this->input->post('e_school_address'),
            'inclusive_years' => json_encode($inclusive_years),
            'date_updated' => date('Y-m-d h:i:s'),
        ];

        $working_gears = [
            'cover_all' => $this->input->post('e_cover_all'),
            'winter_jacket' => $this->input->post('e_winter_jacket'),
            'shoes' => $this->input->post('e_shoes'),
            'winter_boots' => $this->input->post('e_winter_boots'),
            'date_updated' => date('Y-m-d h:i:s'),
        ];

        $this->db->trans_strict(TRUE);
        $this->db->trans_begin();

        $this->db->where('crew_code', $crew_code)->update('ac_personal_info', $personal_info);
        $this->db->where('crew_code', $crew_code)->update('ac_next_of_kin', $next_of_kin);
        $this->db->where('crew_code', $crew_code)->update('ac_educational_attainment', $education_attainment);
        $this->db->where('crew_code', $crew_code)->update('ac_working_gears', $working_gears);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function searchCrewById($params)
    {
        $this->db->select("
            c.crew_code,
            c.applicant_code,
            c.date_available,
            c.status,
            c.vessel_assign,
            c.position,
            c.date_created,
            ap.type_of_department,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_code,
            ap.position_name,
            ap.id position_id,
            cm.medical_bmi,
            av.vsl_name,
            av.id vsl_id,
            av.vsl_code,
            ac.description city_name,
            apr.description province_name,
            ad.department_name
        ");

        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("crew_medical cm", "c.crew_code = cm.crew_code", "LEFT");
        $this->db->join("a_type_of_department ad", "ap.type_of_department = ad.id", "LEFT");

        $this->db->group_by('c.crew_code');
        $this->db->order_by("c.date_created", "DESC");

        if ($params) {
            $this->db->where('c.crew_code', $params);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function NoOfCrewAssigned($flight_code)
    {
        return $this->db->where('flight_code', $flight_code)->get('crews')->result_array();
    }

    public function get_crew_by_cmpcode($cmp_code)
    {
        $this->db->select("
        acpi.*,
        c.applicant_code,
        c.crew_code,
        c.date_available,
        c.vessel_assign,
        c.position,
        cmp.disembark,
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
        $this->db->from("cm_plan  cmp");
        $this->db->join("crews c", "cmp.insigner = c.monitor_code");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_next_of_kin kin", "kin.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_sea_service_record ssr", "ssr.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_working_gears wg", "wg.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_educational_attainment educ", "educ.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_training_certificates tc", "tc.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("ac_licenses_endorsement_book_id lic", "lic.crew_code = acpi.crew_code", "LEFT");

        $this->db->where("cmp.cmp_code", $cmp_code);
        $this->db->group_by('acpi.crew_code');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : FALSE;
    }

    public function get_crewcode_cmp($cmp_code)
    {
        $this->db->select("
        c.applicant_code,
        c.crew_code");
        $this->db->from("cm_plan  cmp");
        $this->db->join("crews c", "cmp.insigner = c.monitor_code OR cmp.offsigner = c.monitor_code");

        $this->db->where("cmp.cmp_code", $cmp_code);
        $this->db->group_by('c.crew_code');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : FALSE;
    }

    public function checkRequirements($crew_code)
    {
        $contract_poe = $this->db->where("crew_code", $crew_code)->where_in("status", ['1', '2'])->order_by("date_created DESC")->limit(1)->get('crew_poea')->row_array();
        $contract_mlc = $this->db->where("crew_code", $crew_code)->where_in("status", ['1', '2'])->order_by("date_created DESC")->limit(1)->get('crew_mlc')->row_array();
        $medical = $this->db->where('crew_code', $crew_code)->where(array("status !=" => 0, "medical_status !=" => 4))->get('crew_medical')->row_array();
        $flight_details = $this->db->where(array('crew_code' => $crew_code))->get('crews')->row_array();

        if (
            !empty($contract_poe) && !is_null($contract_poe) &&
            !empty($contract_mlc) && !is_null($contract_mlc) &&
            !empty($medical) && !is_null($medical) &&
            !is_null($flight_details['flight_code']) && !empty($flight_details['flight_code'])
        ) {
            return $data = ["type" => "complete"];
        } else {

            return $data = [
                "type"    => "incomplete",
                "poea"    => !empty($contract_poe) && !is_null($contract_poe) ? 0 : 1,
                "mlc"     => !empty($contract_mlc) && !is_null($contract_mlc) ? 0 : 1,
                "medical" => !empty($medical) && !is_null($medical) ? 0 : 1,
                "flight"  => !is_null($flight_details['flight_code']) && !empty($flight_details['flight_code']) ? 0 : 1
            ];
        }
    }

    public function checkAcFiles($applicant_code)
    {
        return $this->db->where('applicant_code', $applicant_code)->get('ac_files')->row_array();
    }
}

/* End of file M_all_crew.php */
