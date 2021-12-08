<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validations extends CI_Controller
{
    public function checkDate($date)
    {
        if (date('Y-m-d', strtotime($date)) < date('Y-m-d') || date('Y-m-d', strtotime($date)) === date('Y-m-d')) {
            $this->form_validation->set_message('checkDate', '%s cannot be in the current date or the past date.');
            return false;
        } else {
            // Your date is not in the past
            return true;
        }
    }

    public function validate_select($select)
    {
        if (empty($select)) {
            $this->form_validation->set_message('validate_select', 'The %s field is required.');
            return false;
        } else {
            return true;
        }
    }


    public function validate_disembark_date()
    {
        $disembark_date = $this->input->post("a_disembarked_date");
        $embark_date = $this->input->post("a_embarked_date");

        if (date('Y-m-d', strtotime($disembark_date)) < date('Y-m-d', strtotime($embark_date)) || date('Y-m-d', strtotime($disembark_date)) < date('Y-m-d')) {
            $this->form_validation->set_message('validate_disembark_date', '%s cannot be in the past date or before embarked date.');
            return false;
        } else {
            // Your date is not in the past
            return true;
        }
    }

    public function checkBirth($birth_date)
    {
        $date_valid =  date('Y-m-d', strtotime('-18 Years', strtotime(date('Y-m-d'))));
        $birth_date = date('Y-m-d', strtotime($birth_date));
        if ($birth_date > $date_valid) {
            $this->form_validation->set_message('checkBirth', 'You must be at least 18 years of age');
            return false;
        } else {
            return true;
        }
    }

    public function shipboard_application_validation()
    {
        $register_company_rules = $this->validations->rules['application_form'];
        $this->form_validation->set_rules($register_company_rules);

        if ($this->input->post('s_source_location') == 1) {
            $this->form_validation->set_rules('s_recommended_name', 'Recommended By', 'trim|required');
        }

        if ($this->form_validation->run() === FALSE) {

            $data = [
                's_first_position'  => form_error('s_first_position'),
                's_second_position' => form_error('s_second_position'),
                's_source_location' => form_error('s_source_location'),
                's_recommended_name' => form_error('s_recommended_name'),
                's_first_name'  => form_error('s_first_name'),
                's_last_name'   => form_error('s_last_name'),
                's_birth_date'  => form_error('s_birth_date'),
                's_birth_place' => form_error('s_birth_place'),
                's_date_available'   => form_error('s_date_available'),
                's_civil_status'     => form_error('s_civil_status'),
                's_email_address'      => form_error('s_email_address'),
                's_mobile_number' => form_error('s_mobile_number'),
                // 's_religion' => form_error('s_religion'),
                's_nationality' => form_error('s_nationality'),
                // 's_sss_no' => form_error('s_sss_no'),
                // 's_tin_no' => form_error('s_tin_no'),
                // 's_philhealth_no' => form_error('s_philhealth_no'),
                // 's_pag_ibig_no' => form_error('s_pag_ibig_no'),
                's_height' => form_error('s_height'),
                's_weight' => form_error('s_weight'),
                's_bmi' => form_error('s_bmi'),
                's_home_address' => form_error('s_home_address'),
                's_barangay' => form_error('s_barangay'),
                's_province' => form_error('s_province'),
                's_city' => form_error('s_city'),
                's_country' => form_error('s_country'),
                // 's_father_name' => form_error('s_father_name'),
                // 's_mother_name' => form_error('s_mother_name'),
                's_kin_address' => form_error('s_kin_address'),
                's_course' => form_error('s_course'),
                's_school_name' => form_error('s_school_name'),
                's_inclusive_years_to' => form_error('s_inclusive_years_to'),
                's_inclusive_years_from' => form_error('s_inclusive_years_from'),
                // 's_school_address' => form_error('s_school_address'),
                // 'r_full_name'  => form_error('r_full_name'),
                // 'r_birth_date'  => form_error('r_birth_date'),
                // 'r_mobile_no'  => form_error('r_mobile_no'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {
            $data = [
                's_first_position'  => NULL,
                's_second_position' => NULL,
                's_source_location' => NULL,
                's_recommended_name' => NULL,
                's_first_name'  => NULL,
                's_last_name'   => NULL,
                's_birth_date'  => NULL,
                's_birth_place' => NULL,
                's_date_available'   => NULL,
                's_civil_status'     => NULL,
                's_email_address'      => NULL,
                's_mobile_number' => NULL,
                's_nationality' => NULL,
                's_height' => NULL,
                's_weight' => NULL,
                's_bmi' => NULL,
                's_home_address' => NULL,
                's_barangay' => NULL,
                's_province' => NULL,
                's_city' => NULL,
                's_country' => NULL,
                's_kin_address' => NULL,
                's_course' => NULL,
                's_school_name' => NULL,
                's_inclusive_years_to' => NULL,
                's_inclusive_years_from' => NULL,
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function addd_existing_crew_validation()
    {

        if ($this->input->post('s_first_position')) {
            $this->form_validation->set_rules('e_tentative_vessel', 'Tentative Vessel', 'trim|required|callback_validate_select');
        }

        if ($this->form_validation->run() === FALSE) {

            $data = [
                'e_tentative_vessel'  => form_error('e_tentative_vessel'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];

            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    // DEVELOPER VALIDATION

    public function add_module_form_validation()
    {
        $add_module_form_validation = $this->validations->rules['add_module_form'];

        $this->form_validation->set_rules($add_module_form_validation);


        if ($this->form_validation->run() === FALSE) {
            $data = [
                'module_name' => form_error('module_name'),
                'url'         => form_error('url'),
                'icon'        => form_error('icon')
            ];
        } else {
            $data = [
                'module_name' => null,
                'url'         => null,
                'icon'        => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function edit_module_form_validation()
    {
        $edit_module_form_validation = $this->validations->rules['edit_module_form'];

        $this->form_validation->set_rules($edit_module_form_validation);


        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_module_name' => form_error('e_module_name'),
                'e_module_url'  => form_error('e_module_url'),
                'e_module_icon' => form_error('e_module_icon')
            ];
        } else {
            $data = [
                'e_module_name' => null,
                'e_module_url'  => null,
                'e_module_icon' => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_sub_module_form_validation()
    {
        $add_sub_module_form_validation = $this->validations->rules['add_sub_module_form'];

        $this->form_validation->set_rules($add_sub_module_form_validation);


        if ($this->form_validation->run() === FALSE) {
            $data = [
                'module'            => form_error('module'),
                'sub_module'        => form_error('sub_module'),
                'target_link'       => form_error('target_link'),
                'sub_module_url'    => form_error('sub_module_url')
            ];
        } else {
            $data = [
                'module'         => null,
                'sub_module'     => null,
                'target_link'    => null,
                'sub_module_url' => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function edit_sub_module_form_validation()
    {
        $edit_sub_module_form_validation = $this->validations->rules['edit_sub_module_form'];

        $this->form_validation->set_rules($edit_sub_module_form_validation);


        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_module'            => form_error('e_module'),
                'e_sub_module'        => form_error('e_sub_module'),
                'e_target_link'       => form_error('e_target_link'),
                'e_sub_module_url'    => form_error('e_sub_module_url')
            ];
        } else {
            $data = [
                'e_module'         => null,
                'e_sub_module'     => null,
                'e_target_link'    => null,
                'e_sub_module_url' => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_node_form_validation()
    {
        $add_node_form_validation = $this->validations->rules['add_node_form'];

        $this->form_validation->set_rules($add_node_form_validation);


        if ($this->form_validation->run() === FALSE) {
            $data = [
                'sub_module' => form_error('sub_module'),
                'node'       => form_error('node'),
                'node_url'   => form_error('node_url')
            ];
        } else {
            $data = [
                'sub_module' => null,
                'node'       => null,
                'node_url'   => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function edit_node_form_validation()
    {
        $edit_node_form_validation = $this->validations->rules['edit_node_form'];

        $this->form_validation->set_rules($edit_node_form_validation);


        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_sub_module' => form_error('e_sub_module'),
                'e_node_name'  => form_error('e_node_name'),
                'e_node_url'   => form_error('e_node_url')
            ];
        } else {
            $data = [
                'e_sub_module' => null,
                'e_node_name'  => null,
                'e_node_url'   => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_nat_score_validation()
    {
        $nat_result_form_rules = $this->validations->rules['nat_result_form'];

        $this->form_validation->set_rules($nat_result_form_rules);


        if ($this->form_validation->run() === FALSE) {
            $data = [
                'n_aptitude_test_score' => form_error('n_aptitude_test_score')
            ];
        } else {
            $data = [
                'n_aptitude_test_score' => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_training_certificate_validation()
    {
        $certificate_form_rules = $this->validations->rules['certificate_form'];
        $this->form_validation->set_rules($certificate_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'cert_code'  => form_error('cert_code'),
                'cert_name' => form_error('cert_name'),
            ];
        } else {
            $data = [
                'cert_code'  => null,
                'cert_name' => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function edit_training_certificate_validation()
    {
        $e_certificate_form_rules = $this->validations->rules['e_certificate_form'];
        $this->form_validation->set_rules($e_certificate_form_rules);


        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_cert_code'  => form_error('e_cert_code'),
                'e_cert_name' => form_error('e_cert_name'),
            ];
        } else {
            $data = [
                'e_cert_code'  => null,
                'e_cert_name' => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_licenses_validation()
    {
        $license_form_rules = $this->validations->rules['license_form'];
        $this->form_validation->set_rules($license_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'license_code'  => form_error('license_code'),
                'license_name' => form_error('license_name'),
            ];
        } else {
            $data = [
                'license_code'  => null,
                'license_name' => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function edit_licenses_validation()
    {
        $e_license_form_rules = $this->validations->rules['e_license_form'];
        $this->form_validation->set_rules($e_license_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_license_code'  => form_error('e_license_code'),
                'e_license_name' => form_error('e_license_name'),
            ];
        } else {
            $data = [
                'e_license_code'  => null,
                'e_license_name' => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_position_validation()
    {
        $position_form_rules = $this->validations->rules['position_form'];
        $this->form_validation->set_rules($position_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'position_code'  => form_error('position_code'),
                'position_name' => form_error('position_name'),
                'department' => form_error('department'),
                'maximum_age_new' => form_error('maximum_age_new'),
                'maximum_age_ex' => form_error('maximum_age_ex'),
                'minimum_exp' => form_error('minimum_exp'),
                'maximum_exp' => form_error('maximum_exp'),
            ];
        } else {
            $data = [
                'position_code'  => null,
                'position_name' => null,
                'department' => null,
                'maximum_age_new' => null,
                'maximum_age_ex' => null,
                'minimum_exp' => null,
                'maximum_exp' => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function edit_position_validation()
    {
        $e_position_form_rules = $this->validations->rules['e_position_form'];
        $this->form_validation->set_rules($e_position_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_position_code'  => form_error('e_position_code'),
                'e_position_name' => form_error('e_position_name'),
                'e_department' => form_error('e_department'),
                'e_maximum_age_new' => form_error('e_maximum_age_new'),
                'e_maximum_age_ex' => form_error('e_maximum_age_ex'),
                'e_minimum_exp' => form_error('e_minimum_exp'),
                'e_maximum_exp' => form_error('e_maximum_exp'),
            ];
        } else {
            $data = [
                'e_position_code'  => null,
                'e_position_name' => null,
                'e_department' => null,
                'e_maximum_age_new' => null,
                'e_maximum_age_ex' => null,
                'e_minimum_exp' => null,
                'e_maximum_exp' => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_interview_validation()
    {
        $interview_form_rules = $this->validations->rules['interview_form'];
        $this->form_validation->set_rules($interview_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'points_of_interview'  => form_error('points_of_interview')
            ];
        } else {
            $data = [
                'points_of_interview'  => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function edit_interview_validation()
    {
        $e_interview_form_rules = $this->validations->rules['e_interview_form'];
        $this->form_validation->set_rules($e_interview_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_points_of_interview'  => form_error('e_points_of_interview')
            ];
        } else {
            $data = [
                'e_points_of_interview'  => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function add_vessel_validation()
    {
        $add_vessel_form_rules = $this->validations->rules['add_vessel_form'];
        $this->form_validation->set_rules($add_vessel_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'vsl_code'  => form_error('vsl_code'),
                'vsl_name' => form_error('vsl_name'),
                'type_of_vessel' => form_error('type_of_vessel'),
                'type_of_engine' => form_error('type_of_engine')
            ];
        } else {
            $data = [
                'vsl_code'  => null,
                'vsl_name' => null,
                'type_of_vessel' => null,
                'type_of_engine' => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function edit_vessel_validation()
    {
        $add_vessel_form_rules = $this->validations->rules['add_vessel_form'];
        $this->form_validation->set_rules($add_vessel_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'vsl_code'  => form_error('vsl_code'),
                'vsl_name' => form_error('vsl_name'),
                'type_of_vessel' => form_error('type_of_vessel'),
                'type_of_engine' => form_error('type_of_engine')
            ];
        } else {
            $data = [
                'vsl_code'  => null,
                'vsl_name' => null,
                'type_of_vessel' => null,
                'type_of_engine' => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function add_vessel_type_validation()
    {
        $vessel_type_form_rules = $this->validations->rules['vessel_type_form'];
        $this->form_validation->set_rules($vessel_type_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'vessel_code'  => form_error('vessel_code'),
                'vessel_name' => form_error('vessel_name')
            ];
        } else {
            $data = [
                'vessel_code'  => null,
                'vessel_name' => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function edit_vessel_type_validation()
    {
        $e_vessel_type_form_rules = $this->validations->rules['e_vessel_type_form'];
        $this->form_validation->set_rules($e_vessel_type_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_vessel_code'  => form_error('e_vessel_code'),
                'e_vessel_name' => form_error('e_vessel_name')
            ];
        } else {
            $data = [
                'e_vessel_code'  => null,
                'e_vessel_name' => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function add_engine_type_validation()
    {
        $vessel_engine_form_rules = $this->validations->rules['vessel_engine_form'];
        $this->form_validation->set_rules($vessel_engine_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'engine_code'  => form_error('engine_code'),
                'engine_name' => form_error('engine_name')
            ];
        } else {
            $data = [
                'engine_code'  => null,
                'engine_name' => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function edit_engine_type_validation()
    {
        $e_vessel_engine_form_rules = $this->validations->rules['e_vessel_engine_form'];
        $this->form_validation->set_rules($e_vessel_engine_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_engine_code'  => form_error('e_engine_code'),
                'e_engine_name' => form_error('e_engine_name')
            ];
        } else {
            $data = [
                'e_engine_code'  => null,
                'e_engine_name' => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_user_type_validation()
    {
        $add_user_type_form_rules = $this->validations->rules['add_user_type_form'];
        $this->form_validation->set_rules($add_user_type_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'full_name'  => form_error('full_name'),
                'username'  => form_error('username'),
                'email_address'  => form_error('email_address'),
                'phone_number'  => form_error('phone_number'),
                'password'  => form_error('password'),
                'confirm_password'  => form_error('confirm_password'),
                'user_type'  => form_error('user_type'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {
            $data = [
                'full_name' => null,
                'username'  => null,
                'email_address' => null,
                'phone_number' => null,
                'password' => null,
                'confirm_password' => null,
                'user_type' => null,
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function update_user_password_validation()
    {
        $update_user_password_form_rules = $this->validations->rules['update_user_password_form'];
        $this->form_validation->set_rules($update_user_password_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'p_password'  => form_error('p_password'),
                'p_confirm_password'  => form_error('p_confirm_password'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $data = [
                'p_password' => null,
                'p_confirm_password' => null
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function update_position_certificates_validation()
    {

        $position_requirements_form_rules = $this->validations->rules['position_requirements_form'];
        $this->form_validation->set_rules($position_requirements_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'position_list'  => form_error('position_list'),
                'type' => 'warning',
                'title' => 'Please fill all the required fields.'
            ];
        } else {
            $data = [
                'position_list' => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function position_licenses_validation()
    {

        $position_licenses_form_rules = $this->validations->rules['position_licenses_form'];
        $this->form_validation->set_rules($position_licenses_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'position_list'  => form_error('position_list'),
                'type' => 'warning',
                'title' => 'Please fill all the required fields.'
            ];
        } else {
            $data = [
                'position_list' => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function update_position_points_validation()
    {

        $position_points_form_rules = $this->validations->rules['position_points_form'];
        $this->form_validation->set_rules($position_points_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'position_list'  => form_error('position_list'),
                'type' => 'warning',
                'title' => 'Please fill all the required fields.'
            ];
        } else {

            $data = [
                'position_list' => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function existing_shipboard_application_validation()
    {
        $existing_application_form_rules = $this->validations->rules['existing_application_form'];
        $this->form_validation->set_rules($existing_application_form_rules);

        if ($this->input->post('s_source_location') == "1") {
            $this->form_validation->set_rules('s_recommended_name', 'Recommended By', 'trim|required');
        }

        if ($this->input->post('s_current_crew_status') === "3" || $this->input->post('s_current_crew_status') === "4") {
            $this->form_validation->set_rules('s_embark_onsigner_date', 'Embark Date', 'trim|required');
            $this->form_validation->set_rules('s_disembark_onsigner_date', 'Disembark Date', 'trim|required');
        }

        // $name_val = "";
        // $birth_val = "";
        // $number_val = "";

        // if ($this->input->post('s_no_of_children') != "none") {
        //     $loop = intval($this->input->post('s_no_of_children'));
        //     $name_val = $this->validate_child_name($loop, $this->input->post('r_full_name'));
        //     $birth_val = $this->validate_child_birthday($loop, $this->input->post('r_birth_date'));
        //     $number_val = $this->validate_child_number($loop, $this->input->post('r_mobile_no'));
        // }

        // foreach ($name_val as $key) {
        //     $this->form_validation->set_rules('r_full_name', 'Child Name',array('required',
        //                 function($key)
        //                 {
        //                     if (!empty($key)) {
        //                         return false;
        //                     }else{
        //                         return true;
        //                     }
        //                 }
        //         )
        //     );
        // }
        // foreach ($birth_val as $key) {
        //     $this->form_validation->set_rules('r_birth_date', 'Child Birthday',array('required',
        //                 function($key)
        //                 {
        //                     if (!empty($key)) {
        //                         return false;
        //                     }else{
        //                         return true;
        //                     }
        //                 }
        //         )
        //     );
        // }
        // foreach ($number_val as $key) {
        //     $this->form_validation->set_rules('r_mobile_no', 'Child Number',array('required',
        //                 function($key)
        //                 {
        //                     if (!empty($key)) {
        //                         return false;
        //                     }else{
        //                         return true;
        //                     }
        //                 }
        //         )
        //     );
        // }

        $data = [];
        if ($this->form_validation->run() === FALSE) {

            $data = [
                's_current_position'  => form_error('s_current_position'),
                's_current_crew_status'  => form_error('s_current_crew_status'),
                's_source_location' => form_error('s_source_location'),
                's_current_vessel' => form_error('s_current_vessel'),
                's_type_crew' => form_error('s_type_crew'),
                's_first_name'  => form_error('s_first_name'),
                's_last_name'   => form_error('s_last_name'),
                's_birth_date'  => form_error('s_birth_date'),
                's_birth_place' => form_error('s_birth_place'),
                's_date_available'   => form_error('s_date_available'),
                's_civil_status'     => form_error('s_civil_status'),
                's_email_address'     => form_error('s_email_address'),
                's_mobile_number'     => form_error('s_mobile_number'),
                's_nationality'   => form_error('s_nationality'),
                's_embark_onsigner_date'   => form_error('s_embark_onsigner_date'),
                's_disembark_onsigner_date'   => form_error('s_disembark_onsigner_date'),
                // 's_sss_no' => form_error('s_sss_no'),
                's_height' => form_error('s_height'),
                's_weight' => form_error('s_weight'),
                's_bmi' => form_error('s_bmi'),
                's_recommended_name' => form_error('s_recommended_name'),
                's_home_address' => form_error('s_home_address'),
                's_province' => form_error('s_province'),
                's_city' => form_error('s_city'),
                's_country' => form_error('s_country'),
                's_kin_address' => form_error('s_kin_address'),
                's_course' => form_error('s_course'),
                's_school_name' => form_error('s_school_name'),
                's_inclusive_years_to' => form_error('s_inclusive_years_to'),
                's_inclusive_years_from' => form_error('s_inclusive_years_from'),
                // 'r_full_name'   => form_error('r_full_name'),
                // 'r_birth_date'  => form_error('r_birth_date'),
                // 'r_mobile_no'   => form_error('r_mobile_no')
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function add_poea_contract_validation()
    {
        $poea_contract_form_rules = $this->validations->rules['poea_contract_form'];
        $this->form_validation->set_rules($poea_contract_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'c_license_no'              => form_error('c_license_no'),
                'c_sirb_no'                 => form_error('c_sirb_no'),
                'c_src_no'                  => form_error('c_src_no'),
                'c_name_of_agent'           => form_error('c_name_of_agent'),
                'c_name_of_principal'       => form_error('c_name_of_principal'),
                'c_address_of_principal'    => form_error('c_address_of_principal'),
                'c_duration_contract'       => form_error('c_duration_contract'),
                'c_position'                => form_error('c_position'),
                'c_monthly_salary'          => form_error('c_monthly_salary'),
                'c_year_built'              => form_error('c_year_built'),
                'c_flag'                    => form_error('c_flag'),
                'c_vessel_type'             => form_error('c_vessel_type'),
                'c_classification_society'  => form_error('c_classification_society'),
                'c_hours_of_work'           => form_error('c_hours_of_work'),
                'c_vessel_name'             => form_error('c_vessel_name'),
                'c_imo_number'              => form_error('c_imo_number'),
                'c_gross_tonnage'           => form_error('c_gross_tonnage'),
                'c_overtime'                => form_error('c_overtime'),
                'c_vacation_leave_with_pay' => form_error('c_vacation_leave_with_pay'),
                'c_others'                  => form_error('c_others'),
                'c_total_salary'            => form_error('c_total_salary'),
                'c_point_of_hire'           => form_error('c_point_of_hire'),
                'c_collective_agreement'    => form_error('c_collective_agreement'),
                'type'                      => 'warning',
                'title'                     => 'Please complete all the required fields.'
            ];
        } else {

            $data = [
                'c_license_no'              => null,
                'c_sirb_no'                 => null,
                'c_src_no'                  => null,
                'c_name_of_agent'           => null,
                'c_name_of_principal'       => null,
                'c_address_of_principal'    => null,
                'c_duration_contract'       => null,
                'c_position'                => null,
                'c_monthly_salary'          => null,
                'c_year_built'              => null,
                'c_flag'                    => null,
                'c_vessel_type'             => null,
                'c_classification_society'  => null,
                'c_hours_of_work'           => null,
                'c_vessel_name'             => null,
                'c_imo_number'              => null,
                'c_gross_tonnage'           => null,
                'c_overtime'                => null,
                'c_vacation_leave_with_pay' => null,
                'c_others'                  => null,
                'c_total_salary'            => null,
                'c_point_of_hire'           => null,
                'c_collective_agreement'    => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_mlc_contract_validation()
    {
        $mlc_contract_form_rules = $this->validations->rules['mlc_contract_form'];
        $this->form_validation->set_rules($mlc_contract_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'c_mlc_contract'            => form_error('c_mlc_contract'),
                'mlc_farer_passport'        => form_error('mlc_farer_passport'),
                'mlc_farer_book'            => form_error('mlc_farer_book'),
                'mlc_farer_license'         => form_error('mlc_farer_license'),
                'mlc_farer_sex'             => form_error('mlc_farer_sex'),
                'mlc_sign_place'            => form_error('mlc_sign_place'),
                'mlc_sign_date'             => form_error('mlc_sign_date'),
                'mlc_bw'                    => form_error('mlc_bw'),
                'mlc_ot'                    => form_error('mlc_ot'),
                'mlc_pl'                    => form_error('mlc_pl'),
                'mlc_sa'                    => form_error('mlc_sa'),
                'mlc_rb'                    => form_error('mlc_rb'),
                'mlc_mts'                   => form_error('mlc_mts'),
                'mlc_fksu'                  => form_error('mlc_fksu'),
                'mlc_mt'                    => form_error('mlc_mt'),
                'mlc_employment_period_from'     => form_error('mlc_employment_period_from'),
                'mlc_employment_period_to'     => form_error('mlc_employment_period_to'),
                'mlc_shipowner_vessel'      => form_error('mlc_shipowner_vessel'),
                'mlc_vp_alphera'            => form_error('mlc_vp_alphera'),
                'type'                      => 'warning',
                'title'                     => 'Please complete all the required fields.'
            ];
        } else {

            $data = [
                'c_mlc_contract'            => null,
                'mlc_farer_passport'        => null,
                'mlc_farer_book'            => null,
                'mlc_farer_license'         => null,
                'mlc_farer_sex'             => null,
                'mlc_sign_place'            => null,
                'mlc_sign_date'             => null,
                'mlc_bw'                    => null,
                'mlc_ot'                    => null,
                'mlc_pl'                    => null,
                'mlc_sa'                    => null,
                'mlc_rb'                    => null,
                'mlc_mts'                   => null,
                'mlc_fksu'                  => null,
                'mlc_mt'                    => null,
                'mlc_employment_period_from'     => null,
                'mlc_employment_period_to'     => null,
                'mlc_shipowner_vessel'      => null,
                'mlc_vp_alphera'            => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_watchlisted_validation()
    {
        $add_watchlisted_form_rules = $this->validations->rules['add_watchlisted_form'];
        $this->form_validation->set_rules($add_watchlisted_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'w_crew_name'        => form_error('w_crew_name'),
                'w_rank'             => form_error('w_rank'),
                'w_department'       => form_error('w_department'),
                'w_vessel'           => form_error('w_vessel'),
                'w_certificates'     => form_error('w_certificates'),
                'w_registration_no'  => form_error('w_registration_no'),
                'type'               => 'warning',
                'title'              => 'Please complete all the required fields.'
            ];
        } else {

            $data = [
                'w_crew_name'        => null,
                'w_rank'             => null,
                'w_department'       => null,
                'w_vessel'           => null,
                'w_certificates'     => null,
                'w_registration_no'  => null
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_warning_letter_validation()
    {
        $add_warning_letter_form_rules = $this->validations->rules['add_warning_letter_form'];
        $this->form_validation->set_rules($add_warning_letter_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'w_crew_name'        => form_error('w_crew_name'),
                'w_rank'             => form_error('w_rank'),
                'w_department'       => form_error('w_department'),
                'w_vessel'           => form_error('w_vessel'),
                'w_remarks'          => form_error('w_remarks'),
                'type'               => 'warning',
                'title'              => 'Please complete all the required fields.'
            ];
        } else {

            $data = [
                'w_crew_name'        => null,
                'w_rank'             => null,
                'w_department'       => null,
                'w_vessel'           => null,
                'w_remarks'          => null,
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_early_disembark_warning_letter_validation()
    {
        $add_dis_warning_leter = $this->validations->rules['add_dis_warning_leter'];
        $this->form_validation->set_rules($add_dis_warning_leter);

        if ($this->form_validation->run() === false) {
            $data = [
                'awlm_rank'        => form_error('awlm_rank'),
                'awlm_vessel'       => form_error('awlm_vessel'),
                'awlm_remarks'           => form_error('awlm_remarks'),
                'awlm_type_of_nre'     => form_error('awlm_type_of_nre'),
                'awlm_department'             => form_error('awlm_department'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $data = [
                'awlm_rank'        => null,
                'awlm_vessel'             => null,
                'awlm_remarks'       => null,
                'awlm_type_of_nre'           => null,
                'awlm_department'          => null,
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_flight_information_validation()
    {
        $add_flight_information_form_rules = $this->validations->rules['add_flight_information_form'];
        $this->form_validation->set_rules($add_flight_information_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'flight_vessel'          => form_error('flight_vessel'),
                'f_flight_number'        => form_error('f_flight_number'),
                'f_departure_country'    => form_error('f_departure_country'),
                'f_departure_date'       => form_error('f_departure_date'),
                'f_departure_time'       => form_error('f_departure_time'),
                'f_destination_country'  => form_error('f_destination_country'),
                'f_destination_date'     => form_error('f_destination_date'),
                'f_destination_time'     => form_error('f_destination_time'),
                'f_airfare'              => form_error('f_airfare'),
                'f_airline'              => form_error('f_airline'),
                'type'                   => 'warning',
                'title'                  => 'Please complete all the required fields.'
            ];
        } else {

            $data = [
                'flight_vessel'         => null,
                'f_flight_number'       => null,
                'f_departure_country'   => null,
                'f_departure_date'      => null,
                'f_departure_time'      => null,
                'f_destination_country' => null,
                'f_destination_date'    => null,
                'f_destination_time'    => null,
                'f_airfare'             => null,
                'f_airline'             => null,
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_medical_validation()
    {
        $add_medical_form_rules = $this->validations->rules['medical_form'];
        $this->form_validation->set_rules($add_medical_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'm_date_med_exam'   => form_error('m_date_med_exam'),
                'm_medical_expiry_date'  => form_error('m_medical_expiry_date'),
                'm_status'          => form_error('m_status'),
                'm_height'          => form_error('m_height'),
                'm_weight'          => form_error('m_weight'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $data = [
                'm_date_med_exam'     => null,
                'm_medical_expiry_date'    => null,
                'm_status'            => null,
                'm_height'            => null,
                'm_weight'            => null,
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function edit_medical_validation()
    {
        $edit_medical_form_rules = $this->validations->rules['edit_medical_form'];
        $this->form_validation->set_rules($edit_medical_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_m_date_med_exam'   => form_error('e_m_date_med_exam'),
                'e_m_medical_expiry_date'  => form_error('e_m_medical_expiry_date'),
                'e_m_status'          => form_error('e_m_status'),
                'e_m_height'          => form_error('e_m_height'),
                'e_m_weight'          => form_error('e_m_weight'),
                'type'                => 'warning',
                'title'               => 'Please complete all the required fields.'
            ];
        } else {

            $data = [
                'e_m_date_med_exam'     => null,
                'e_m_medical_expiry_date'    => null,
                'e_m_status'            => null,
                'e_m_height'            => null,
                'e_m_weight'            => null,
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function edit_shipboard_validation()
    {
        $edit_shipboard_application_form = $this->validations->rules['edit_shipboard_application_form'];
        $this->form_validation->set_rules($edit_shipboard_application_form);


        if ($this->input->post('e_source_location') == 1) {
            $this->form_validation->set_rules('s_recommended_name', 'Recommended By', 'trim|required');
        }

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_first_position'  => form_error('e_first_position'),
                'e_source_location' => form_error('e_source_location'),
                'e_tentative_vessel' => form_error('e_tentative_vessel'),
                's_type_of_crew' => form_error('s_type_of_crew'),
                'e_first_name'  => form_error('e_first_name'),
                'e_last_name'   => form_error('e_last_name'),
                'e_birth_date'  => form_error('e_birth_date'),
                'e_birth_place' => form_error('e_birth_place'),
                'e_date_available'   => form_error('e_date_available'),
                'e_civil_status'     => form_error('e_civil_status'),
                'e_email_address'      => form_error('e_email_address'),
                'e_mobile_number' => form_error('e_mobile_number'),
                // 'e_religion'      => form_error('e_religion'),
                'e_nationality'   => form_error('e_nationality'),
                // 'e_sss_no' => form_error('e_sss_no'),
                // 'e_tin_no' => form_error('e_tin_no'),
                // 'e_philhealth_no' => form_error('e_philhealth_no'),
                // 'e_pag_ibig_no' => form_error('e_pag_ibig_no'),
                'e_height' => form_error('e_height'),
                'e_weight' => form_error('e_weight'),
                'e_bmi' => form_error('e_bmi'),
                'e_recommended_name' => form_error('e_recommended_name'),
                'e_home_address' => form_error('e_home_address'),
                'e_province' => form_error('e_province'),
                'e_city' => form_error('e_city'),
                'e_country' => form_error('e_country'),
                // 'e_father_name' => form_error('e_father_name'),
                // 'e_mother_name' => form_error('e_mother_name'),
                'e_kin_address' => form_error('e_kin_address'),
                'e_course' => form_error('e_course'),
                'e_school_name' => form_error('e_school_name'),
                'e_inclusive_years_to' => form_error('e_inclusive_years_to'),
                'e_inclusive_years_from' => form_error('e_inclusive_years_from'),
                // 'e_school_address' => form_error('e_school_address'),
                // 'e_full_name'   => form_error('e_full_name_child'),
                // 'e_birth_date'  => form_error('e_birth_date_child'),
                // 'e_mobile_no'   => form_error('e_mobile_no_child'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {
            $data = [
                'e_first_position'  => null,
                'e_source_location' => null,
                'e_tentative_vessel' => null,
                'e_first_name'  => null,
                'e_last_name'   => null,
                'e_birth_date'  => null,
                'e_birth_place' => null,
                'e_date_available'   => null,
                'e_civil_status'     => null,
                'e_email_address'      => null,
                'e_mobile_number' => null,
                // 'e_religion'      => null,
                'e_nationality'   => null,
                // 'e_sse_no' => null,
                // 'e_tin_no' => null,
                // 'e_philhealth_no' => null,
                // 'e_pag_ibig_no' => null,
                'e_height' => null,
                'e_weight' => null,
                'e_bmi' => null,
                'e_recommended_name' => null,
                'e_home_address' => null,
                'e_province' => null,
                'e_city' => null,
                'e_country' => null,
                // 'e_father_name' => null,
                // 'e_mother_name' => null,
                'e_kin_address' => null,
                'e_course' => null,
                'e_school_name' => null,
                'e_inclusive_years_to' => null,
                'e_inclusive_years_from' => null,
                // 'e_school_address' => null
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function v_e_crew_info_validation()
    {

        $e_crew_info_form = $this->validations->rules['e_crew_info_form'];
        $this->form_validation->set_rules($e_crew_info_form);

        // $name_val = "";
        // $birth_val = "";
        // $number_val = "";

        // if ($this->input->post('e_no_of_children') != "none") {
        //     $loop = intval($this->input->post('e_no_of_children'));
        //     $name_val = $this->validate_child_name($loop, $this->input->post('r_full_name'));
        //     $birth_val = $this->validate_child_birthday($loop, $this->input->post('r_birth_date'));
        //     $number_val = $this->validate_child_number($loop, $this->input->post('r_mobile_no'));
        // }

        // foreach ($name_val as $key) {
        //     $this->form_validation->set_rules('r_full_name', 'Child Name',array('required',
        //                 function($key)
        //                 {
        //                     if (!empty($key)) {
        //                         return false;
        //                     }else{
        //                         return true;
        //                     }
        //                 }
        //         )
        //     );
        // }
        // foreach ($birth_val as $key) {
        //     $this->form_validation->set_rules('r_birth_date', 'Child Birthday',array('required',
        //                 function($key)
        //                 {
        //                     if (!empty($key)) {
        //                         return false;
        //                     }else{
        //                         return true;
        //                     }
        //                 }
        //         )
        //     );
        // }
        // foreach ($number_val as $key) {
        //     $this->form_validation->set_rules('r_mobile_no', 'Child Number',array('required',
        //                 function($key)
        //                 {
        //                     if (!empty($key)) {
        //                         return false;
        //                     }else{
        //                         return true;
        //                     }
        //                 }
        //         )
        //     );
        // }

        if ($this->input->post('e_source_location') == 1) {
            $this->form_validation->set_rules('e_recommended_name', 'Recommended By', 'trim|required');
        }

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_first_name'  => form_error('e_first_name'),
                'e_last_name'   => form_error('e_last_name'),
                'e_birth_date'  => form_error('e_birth_date'),
                'e_birth_place' => form_error('e_birth_place'),
                'e_civil_status'     => form_error('e_civil_status'),
                'e_email_address'      => form_error('e_email_address'),
                'e_mobile_number' => form_error('e_mobile_number'),
                // 'e_religion'      => form_error('e_religion'),
                'e_nationality'   => form_error('e_nationality'),
                // 'e_sse_no' => form_error('e_sss_no'),
                // 'e_tin_no' => form_error('e_tin_no'),
                // 'e_philhealth_no' => form_error('e_philhealth_no'),
                // 'e_pag_ibig_no' => form_error('e_pag_ibig_no'),
                'e_height' => form_error('e_height'),
                'e_weight' => form_error('e_weight'),
                'e_bmi' => form_error('e_bmi'),
                'e_recommended_name' => form_error('e_recommended_name'),
                'e_home_address' => form_error('e_home_address'),
                'e_province' => form_error('e_province'),
                'e_city' => form_error('e_city'),
                'e_country' => form_error('e_country'),
                // 'e_father_name' => form_error('e_father_name'),
                // 'e_mother_name' => form_error('e_mother_name'),
                'e_kin_address' => form_error('e_kin_address'),
                'e_course' => form_error('e_course'),
                'e_school_name' => form_error('e_school_name'),
                'e_inclusive_years_to' => form_error('e_inclusive_years_to'),
                'e_inclusive_years_from' => form_error('e_inclusive_years_from'),
                // 'e_school_address' => form_error('e_school_address'),
                // 'r_full_name'  => form_error('r_full_name'),
                // 'r_birth_date'  => form_error('r_birth_date'),
                // 'r_mobile_no'  => form_error('r_mobile_no'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {
            $data = [
                'e_first_position'  => null,
                'e_source_location' => null,
                'e_first_name'  => null,
                'e_last_name'   => null,
                'e_birth_date'  => null,
                'e_birth_place' => null,
                'e_date_available'   => null,
                'e_civil_status'     => null,
                'e_email_address'      => null,
                'e_mobile_number' => null,
                'e_religion'      => null,
                'e_nationality'   => null,
                'e_sse_no' => null,
                'e_tin_no' => null,
                'e_philhealth_no' => null,
                'e_pag_ibig_no' => null,
                'e_height' => null,
                'e_weight' => null,
                'e_bmi' => null,
                'e_recommended_name' => null,
                'e_home_address' => null,
                'e_province' => null,
                'e_city' => null,
                'e_country' => null,
                'e_father_name' => null,
                'e_mother_name' => null,
                'e_kin_address' => null,
                'e_course' => null,
                'e_school_name' => null,
                'e_inclusive_years_to' => null,
                'e_inclusive_years_from' => null,
                'e_school_address' => null,
                // 'r_full_name'  => null,
                // 'r_birth_date'  => null,
                // 'r_mobile_no'  => null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function add_toc_validation()
    {
        $crew_withdrawal_application_rules = $this->validations->rules['crew_withdrawal_application'];
        $this->form_validation->set_rules($crew_withdrawal_application_rules);

        if ($this->input->post('w_crew_name') === 0) {
            $this->form_validation->set_rules('w_crew_name', 'Crew Name', 'required');
        }

        if ($this->form_validation->run() === FALSE) {

            $data = [
                'w_crew_name'  => form_error('w_crew_name'),
                'w_rank' => form_error('w_rank'),
                'w_department' => form_error('w_department'),
                'w_vessel'  => form_error('w_vessel'),
                'w_remarks'   => form_error('w_remarks'),
            ];
        } else {
            $data = [
                'w_crew_name'  => null,
                'w_rank' => null,
                'w_department' => null,
                'w_vessel'  => null,
                'w_remarks'   => null,
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }


    //
    function validate_child_name($loop, $name)
    {
        $name_val = [];
        for ($k = 0; $k < $loop; $k++) {
            if (array_key_exists($k, $name)) {
                if (empty($name[$k])) {
                    $name_vald = $k;
                    array_push($name_val, $name_vald);
                }
            }
        }
        return $name_val;
    }

    function validate_child_birthday($loop, $birthday)
    {
        $birth_val = [];
        for ($k = 0; $k < $loop; $k++) {
            if (array_key_exists($k, $birthday)) {
                if (empty($birthday[$k])) {
                    $child_birth_vald = $k;
                    array_push($birth_val, $child_birth_vald);
                }
            }
        }
        return $birth_val;
    }

    function validate_child_number($loop, $number)
    {
        $num_val = [];
        for ($k = 0; $k < $loop; $k++) {
            if (array_key_exists($k, $number)) {
                if (empty($number[$k])) {
                    $child_num_vald = $k;
                    array_push($num_val, $child_num_vald);
                }
            }
        }
        return $num_val;
    }

    function assign_onsigner_validation()
    {
        $assign_as_on_signer_rules = $this->validations->rules['assign_as_on_signer'];
        $this->form_validation->set_rules($assign_as_on_signer_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'a_offsigner' => form_error('a_offsigner'),
                'a_embarked_date' => form_error('a_embarked_date'),
                'a_disembarked_date' => form_error('a_disembarked_date'),
                'type' => 'warning',
                'title' => 'Please complete all the required fields.'
            ];
        } else {
            $data = [
                'a_offsigner' => NULL,
                'a_embarked_date' => NULL,
                'a_disembarked_date' => NULL,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
