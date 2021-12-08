<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Existing_crew extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }
    }

    public function index()
    {
        $data = [
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Shipboard Employment Application (Existing Crew) | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('application/existing_application_form');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function checkDate($date)
    {
        if (date('Y-m-d', strtotime($date)) < date('Y-m-d') || date('Y-m-d', strtotime($date)) == date('Y-m-d')) {
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

    public function add_existing_crew()
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

        if ($this->form_validation->run() == FALSE) {
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
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->existing_crew->add_existing_crew();
            if ($result === false) {
                $data = [
                    'type'  => 'error',
                    'title' => 'Oops, something went wrong!',
                    'text'  => 'Please contact your system administrator.'
                ];
            } else {
                $data = [
                    'type'  => 'success',
                    'title' => 'Success',
                    'text'  => 'Give us a moment to review your application.',
                    'application_code' => $result['applicant_code'],
                    'crew_code' => $result['crew_code'],
                    'monitor_code'  => $result['monitor_code']
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }





    public function get_technical_interview_form()
    {
        $position = $this->input->post('position');
        $position_tech = $this->global->getPosition($position);
        $tech_forms = json_decode($position_tech['interview_form']);

        $table = null;
        $count = 0;

        if ($tech_forms) {
            foreach ($tech_forms as $key) {
                $tech = $this->global->getTechnicalInterview($key);
                $table .= '<tr>';
                $table .= '<td id="text-alignment" class="text-center">' . $tech['pti_description'] . '</td>';
                $table .= '<td><input type="number" id="score_technical_' . $count . '" name="t_score_technical[]" class="form-control text-center font-weight-medium" readonly="" min="5" max="10"></td>';
                $table .= '<td class="text-center">';
                $table .= '<div class="row">';
                $table .= '<div class="col-md-3">';
                $table .= '<div class="radio radio-alphera"><input type="radio" name="t_radio_' . $count . '" id="t_radio_one_' . $count . '" value="5" onchange="computeTechnicalInterview()"><label for="t_radio_one_' . $count . '"></label></div>';
                $table .= '</div>';
                $table .= '<div class="col-md-3">';
                $table .= '<div class="radio radio-alphera"><input type="radio" name="t_radio_' . $count . '" id="t_radio_two_' . $count . '" value="4" onchange="computeTechnicalInterview()"><label for="t_radio_two_' . $count . '"></label></div>';
                $table .= '</div>';
                $table .= '<div class="col-md-3">';
                $table .= '<div class="radio radio-alphera"><input type="radio" name="t_radio_' . $count . '" id="t_radio_three_' . $count . '" value="3" onchange="computeTechnicalInterview()"><label for="t_radio_three_' . $count . '"></label></div>';
                $table .= '</div>';
                $table .= '<div class="col-md-3">';
                $table .= '<div class="radio radio-alphera"><input type="radio" name="t_radio_' . $count . '" id="t_radio_four_' . $count . '" value="2" onchange="computeTechnicalInterview()"><label for="t_radio_four_' . $count . '"></label></div>';
                $table .= '</div>';
                $table .= '</div>';
                $table .= '</td>';
                $table .= '<td><input type="text" id="remarks_technical_' . $count . '" name="t_remarks_technical[]" class="form-control"></td>';
                $table .= '</tr>';

                $count++;
            }
        }

        $this->output
            ->set_content_type('application/html')
            ->set_output($table);
    }

    public function get_crew_list()
    {
        $position = $this->input->post('s_current_position');
        $status = $this->input->post('s_current_crew_status');
        $vessel = $this->input->post('s_current_vessel');

        $data = $this->ex_crew->getCrewByStatus($position, $vessel);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

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
}
