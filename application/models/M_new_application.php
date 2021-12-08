<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_new_application extends CI_Model
{
    public function saveNewApplicant()
    {
        $applicant_code = $this->global->generateID("APP");
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
                'applicant_code'  => $applicant_code,
                'file_code' => "APLPHOTO",
                'file_name' => $fileName,
                'date_created'    => date("Y-m-d H:i:s"),
                'status' => 1
            ];
            $this->db->insert('ac_files', $applicant_file);
        }



        $applicants = [
            'applicant_code'  => $applicant_code,
            'type_applicant'  => $this->input->post('r_type_crew'),
            'position_first'  => $this->input->post('s_first_position'),
            'position_second' => !$this->input->post('s_second_position') ? 0 : $this->input->post('s_second_position'),
            'date_available'  => date('Y-m-d', strtotime($this->input->post('s_date_available'))),
            'source'          => $this->input->post('s_source_location'),
            'recommend_by'    => $this->input->post('s_recommended_name'),
            'date_created'    => date('Y-m-d H:i:s'),
        ];

        $personal_info = [
            'applicant_code'   => $applicant_code,
            'first_name'       => strtoupper($this->input->post('s_first_name')),
            'middle_name'      => strtoupper($this->input->post('s_middle_name')),
            'last_name'        => strtoupper($this->input->post('s_last_name')),
            'suffix'           => strtoupper($this->input->post('s_suffix')),
            'birth_date'       => date('Y-m-d', strtotime($this->input->post('s_birth_date'))),
            'birth_place'      => $this->input->post('s_birth_place'),
            'civil_status'     => $this->input->post('s_civil_status'),
            'email_address'    => $this->input->post('s_email_address'),
            'telephone_number' => $this->input->post('s_telephone_number'),
            'mobile_number'    => $this->input->post('s_mobile_number'),
            'sss_no'           => $this->input->post('s_sss_no'),
            'tin_number'       => $this->input->post('s_tin_no'),
            'philhealth_no'    => $this->input->post('s_philhealth_no'),
            'pag_ibig_no'      => $this->input->post('s_pag_ibig_no'),
            'height'           => $this->input->post('s_height'),
            'weight'           => $this->input->post('s_weight'),
            'street_address'   => $this->input->post('s_home_address'),
            'barangay'         => $this->input->post('s_barangay'),
            'region'           => $this->input->post('s_province'),
            'city'             => $this->input->post('s_city'),
            'country'          => $this->input->post('s_country'),
            'zip_code'         => $this->input->post('s_zip_code'),
            'provincial'       => $this->input->post('s_provincial'),
            'religion'         => $this->input->post('s_religion'),
            'nationality'      => $this->input->post('s_nationality'),
            'date_created'     => date('Y-m-d H:i:s'),
        ];

        $next_kin = [
            'applicant_code'       => $applicant_code,
            'spouse_name'          => $this->input->post('s_spouse_name'),
            'occupation'           => $this->input->post('s_occupation'),
            'no_of_children'       => $this->input->post('s_no_of_children'),
            'name_of_children'     => json_encode($this->input->post('r_full_name')),
            'birthday_of_children' => json_encode($this->input->post('r_birth_date')),
            'contact_of_children'  => json_encode($this->input->post('r_mobile_no')),
            'father_name'          => $this->input->post('s_father_name'),
            'mother_name'          => $this->input->post('s_mother_name'),
            'address'              => $this->input->post('s_kin_address'),
            'date_created'         => date('Y-m-d H:i:s'),
        ];

        $inclusive_years = [$this->input->post('s_inclusive_years_from'), $this->input->post('s_inclusive_years_to')];
        $education = [
            'applicant_code'  => $applicant_code,
            'course'          => $this->input->post('s_course'),
            'school'          => $this->input->post('s_school_name'),
            'school_address'  => $this->input->post('s_school_address'),
            'inclusive_years' => json_encode($inclusive_years),
            'date_created'    => date('Y-m-d H:i:s'),
        ];

        $working_gears = [
            'applicant_code' => $applicant_code,
            'cover_all'      => $this->input->post('s_cover_all'),
            'winter_jacket'  => $this->input->post('s_winter_jacket'),
            'shoes'          => $this->input->post('s_shoes'),
            'winter_boots'   => $this->input->post('s_winter_boots'),
            'date_created'   => date('Y-m-d H:i:s'),
        ];

        $licenses = [
            'applicant_code'   => $applicant_code,
            'lebi'             => json_encode($this->input->post('lebi')),
            'grade'            => json_encode($this->input->post('l_grade')),
            'number'           => json_encode($this->input->post('l_number')),
            'date_issued'      => json_encode($this->input->post('l_date_issued')),
            'expiry_date'      => json_encode($this->input->post('l_expiry_date')),
            'date_created'     => date('Y-m-d H:i:s'),
        ];

        $trainings = [
            'applicant_code'  => $applicant_code,
            'certificates'    => json_encode($this->input->post('t_id')),
            'number'          => json_encode($this->input->post('t_number')),
            'date_issued'     => json_encode($this->input->post('t_date_issued')),
            'expiration_date' => json_encode($this->input->post('t_date_expired')),
            'issued_by'       => json_encode($this->input->post('t_issued_by')),
            'with_cop_number' => json_encode($this->input->post('t_cop_number')),
            'date_created'    => date("Y-m-d H:i:s"),
        ];

        $sea_service = [
            'applicant_code'  => $applicant_code,
            'name_of_vessel'  => json_encode($this->input->post('s_vessel_name')),
            'flag'            => json_encode($this->input->post('s_flag')),
            'salary'          => json_encode($this->input->post('s_salary')),
            'rank'            => json_encode($this->input->post('s_rank')),
            'type_of_vsl_eng' => json_encode($this->input->post('s_vsl_engn')),
            'grt_power'       => json_encode($this->input->post('s_grt_power')),
            'embarked'        => json_encode($this->input->post('s_embarked')),
            'disembarked'     => json_encode($this->input->post('s_disembarked')),
            // 'total_service'   => json_encode($this->input->post('s_total_service')),
            'agency'          => json_encode($this->input->post('s_agency')),
            'remarks'         => json_encode($this->input->post('s_remarks')),
            'date_created'    => date("Y-m-d H:i:s"),
        ];


        $applicant_history = [
            'applicant_code'  => $applicant_code,
            'applicant_status' => 0,
            'issued_by' => $this->session->userdata('user_code') != null ? $this->session->userdata('user_code') : "",
            'date_created'    => date("Y-m-d H:i:s"),
        ];

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->insert('applicants', $applicants);
        $this->db->insert('ac_personal_info', $personal_info);
        $this->db->insert('ac_next_of_kin', $next_kin);
        $this->db->insert('ac_educational_attainment', $education);
        $this->db->insert('ac_working_gears', $working_gears);
        $this->db->insert('ac_licenses_endorsement_book_id', $licenses);
        $this->db->insert('ac_training_certificates', $trainings);
        $this->db->insert('ac_sea_service_record', $sea_service);
        $this->db->insert('applicant_history', $applicant_history);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function save_applicant_photo()
    {
        $applicant_code = $this->input->post('e_applicant_code');
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
            $fileName = 'ApplicantPhoto_' . uniqid() . '.jpeg';

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
                'applicant_code'  => $applicant_code,
                'file_code' => "APLPHOTO",
                'file_name' => $fileName,
                'date_created'    => date("Y-m-d H:i:s"),
                'status' => 1
            ];
            $this->db->insert('ac_files', $applicant_file);

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return "mali";
        }
    }

    public function get_new_applicants()
    {
        $this->db->select('COUNT(ah.applicant_code) as total_count, aps.applicant_code');
        $this->db->from('applicant_history ah');
        $this->db->join('crews c', 'ah.applicant_code = c.applicant_code');
        $this->db->join('applicants aps', 'c.monitor_code = aps.applicant_code');
        $this->db->where('aps.type_applicant', 'NEW');
        $this->db->where('ah.applicant_status', 3);
        $this->db->group_by('applicant_code');
        return $this->db->get()->result_array();
    }
}

/* End of file M_new_application.php */
