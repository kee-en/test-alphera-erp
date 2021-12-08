<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shipboard_application extends CI_Controller
{
    public function index()
    {
        $data = [
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Shipboard Employment Application | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('application/shipboard_application');
        $this->load->view('include/script');
    }

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

    public function save_shipboard_application()
    {
        $application_form_rules = $this->validations->rules['application_form'];
        $this->form_validation->set_rules($application_form_rules);

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
                's_nationality'   => form_error('s_nationality'),
                's_height' => form_error('s_height'),
                's_weight' => form_error('s_weight'),
                's_bmi' => form_error('s_bmi'),
                's_home_address' => form_error('s_home_address'),
                's_province' => form_error('s_province'),
                's_city' => form_error('s_city'),
                's_country' => form_error('s_country'),
                's_kin_address' => form_error('s_kin_address'),
                's_course' => form_error('s_course'),
                's_school_name' => form_error('s_school_name'),
                's_inclusive_years_to' => form_error('s_inclusive_years_to'),
                's_inclusive_years_from' => form_error('s_inclusive_years_from'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        }else {

            $result = $this->new_applicant->saveNewApplicant();

            if ($result === true) {
                $data = [
                    'type'  => 'success',
                    'title' => 'Added Successfully!',
                    'text'  => 'Give us a moment to review your application.',
                ];
            } else {
                $data = [
                    'type'  => 'error',
                    'title' => 'Oops, something went wrong!',
                    'text'  => 'Please contact your system administrator.'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function save_applicant_picture()
    {
        $result = $this->new_applicant->save_applicant_photo();

        if ($result === true) {
            $data = [
                'type'  => 'success',
                'title' => 'Uploaded Successfully!',
            ];
        } else {
            $data = [
                'type'  => 'error',
                'title' => 'Oops, something went wrong!',
            ];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function validate_child_name($loop, $name)
    {
        $name_val = [];
        for ($k = 0 ; $k < $loop; $k++){
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
        for ($k = 0 ; $k < $loop; $k++){
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
        for ($k = 0 ; $k < $loop; $k++){
            if (array_key_exists($k, $number)) {
                if (empty($number[$k])) {
                    $child_num_vald = $k;
                    array_push($num_val, $child_num_vald);
                }
            }
        }
        return $num_val;
    }
}
