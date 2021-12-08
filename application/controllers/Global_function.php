<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Global_function extends CI_Controller
{
    public function update_applicant_status()
    {
        $applicant_code = $this->input->post('applicant_code');
        $status = $this->input->post('status');

        $result = $this->global->updateApplicantStatus($applicant_code, $status);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Success',
                'text' => 'Updated Successfully!',
                'status' => $status
            ];
        } else if ($result === 'add_nat') {
            $data = [
                'type' => 'error',
                'title' => 'Please, Add NAT result to proceed with action!'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Oops, something went wrong!'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function update_crew_status()
    {
        $monitor_code = $this->input->post('monitor_code');
        $status = $this->input->post('status');

        if ($status === "4") {
            $cmp = $this->global->getCMP($monitor_code);
            $date = date('Y-m-d');

            if (strtotime($cmp['disembark']) > strtotime($date)) {

                $data = ['type' => 'early_disembark', 'cmp_code' => $cmp['cmp_code']];
            } else {
                $result = $this->global->updateCrewStatus($monitor_code, $status);

                if ($result === true) {
                    $data = [
                        'type' => 'success',
                        'title' => 'Successfully Update.'
                    ];
                } else {
                    $data = [
                        'type' => 'error',
                        'title' => 'Something went wrong.'
                    ];
                }
            }
        } else {
            $result = $this->global->updateCrewStatus($monitor_code, $status);

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Successfully Update.'
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Something went wrong.'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function applicant_not_qualified()
    {
        $applicant_code = $this->input->post('r_app_code');
        $reason = $this->input->post('r_add_remark');

        $result = $this->global->applicantNotQualified($applicant_code, $reason);

        if ($result === true) {
            $result = $this->global->updateApplicantStatus($applicant_code, 8);

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Update Successfully!'
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Oops, something went wrong!'
                ];
            }
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Oops, something went wrong!'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_training_certificate()
    {
        $id = $this->input->post('id');

        $result = $this->global->getTrainingCertificate($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_license()
    {
        $id = $this->input->post('id');

        $result = $this->global->getLicenseById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_all_position()
    {
        $result = $this->global->getAllPosition();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_position_by_position()
    {
        $first_position = $this->input->post('first_position');

        $result = $this->global->getPositionByPosition($first_position);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_all_suffix()
    {
        $result = $this->global->getAllSuffix();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_all_civil_status()
    {
        $result = $this->global->getAllCivilStatus();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_all_department()
    {
        $result = $this->global->getAllDeparment();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_all_religion()
    {
        $result = $this->global->getAllReligion();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_all_nationality()
    {
        $result = $this->global->getAllNationality();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_all_province()
    {
        $result = $this->global->getAllProvince();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_all_city()
    {
        $result = $this->global->getAllCity();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_cities()
    {
        $province = $this->input->post('province');

        $result = $this->global->getCities($province);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_all_source()
    {
        $result = $this->global->getAllSource();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_all_contracts()
    {
        $result = $this->global->getAllContracts();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_all_certificates()
    {
        $result = $this->global->getAllTrainingCertificates();
        $row = "";
        if ($result) {
            foreach ($result as $key) {
                $row .= '<div class="col-lg-6">';
                $row .= '<div class="form-group">';
                $row .= '<div class="checkbox checkbox-alphera">';
                $row .= '<input type="checkbox" name="req_position[]" id="req_position' . $key['id'] . '" value="' . $key['id'] . '">';
                $row .= '<label for="req_position' . $key['id'] . '"> ' . $key['cert_name'] . ' (' . $key['cert_code'] . ') </label>';
                $row .= '</div>';
                $row .= '</div>';
                $row .= '</div>';
            }
        }
        $this->output->set_output($row);
    }

    public function get_all_licenses_docs()
    {
        $result = $this->global->getAllLicensesDocs();
        $row = "";
        if ($result) {
            foreach ($result as $key) {
                $row .= '<div class="col-lg-6">';
                $row .= '<div class="form-group">';
                $row .= '<div class="checkbox checkbox-alphera">';
                $row .= '<input type="checkbox" class="licenses_position" name="licenses_position[]" id="licenses_position' . $key['id'] . '" value="' . $key['id'] . '">';
                $row .= '<label for="licenses_position' . $key['id'] . '"> ' . $key['license_name'] . ' (' . $key['license_code'] . ') </label>';
                $row .= '</div>';
                $row .= '</div>';
                $row .= '</div>';
            }
        }
        $this->output->set_output($row);
    }

    public function get_all_certificates_position()
    {
        $id = $this->input->post('position_list');
        $result = $this->global->getPosition($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }


    public function get_training_certificates()
    {
        $first_position  = $this->input->post('first_position');
        $second_position = $this->input->post('second_position');

        $first_training  = $this->global->getPosition($first_position);
        $second_training = $this->global->getPosition($second_position);

        if ($first_training) {
            $first_training  = json_decode($first_training['position_requirements']);
        }

        if ($second_training) {
            $second_training = json_decode($second_training['position_requirements']);
        }
        if (!empty($second_position)) {
            $trainings = array_unique(array_merge($first_training, $second_training), SORT_REGULAR);
        } else {
            $trainings = $first_training;
        }

        $row = null;

        if (!empty($trainings)) {
            foreach ($trainings as $key) {

                $training = $this->global->getTrainingCertificate($key);

                $row .= "<div class=\"col-md-12\">";
                $row .= "<div class=\"row\">";

                $row .= '<div class="col-md-2">';
                $row .= '<div class="form-group">';
                $row .= '<label class="mb-0 mt-2" id="certificate_name">' . $training['cert_name'] . '</label>';
                $row .= '<input type="hidden" id="t_id_' . $training['id'] . '" name="t_id[]" value="' . $training['id'] . '">';
                $row .= '</div>';
                $row .= '</div>';

                $row .= '<div class="col-md-2">';
                $row .= '<div class="form-group">';
                $row .= '<input type="text" class="form-control" id="t_number_' . $training['id'] . '" name="t_number[]" placeholder="NUMBER">';
                $row .= '</div>';
                $row .= '</div>';

                $row .= '<div class="col-md-2">';
                $row .= '<div class="form-group">';
                $row .= '<input type="date" class="form-control" id="t_date_issued_' . $training['id'] . '" name="t_date_issued[]" placeholder="DATE ISSUED">';
                $row .= '</div>';
                $row .= '</div>';

                $row .= '<div class="col-md-2">';
                $row .= '<div class="form-group">';
                $row .= '<input type="date" class="form-control" id="t_date_expired_' . $training['id'] . '" name="t_date_expired[]" placeholder="EXPIRY DATE">';
                $row .= '</div>';
                $row .= '</div>';

                $row .= '<div class="col-md-2">';
                $row .= '<div class="form-group">';
                $row .= '<input type="text" class="form-control" id="t_issued_by_' . $training['id'] . '" name="t_issued_by[]" placeholder="ISSUED BY" onkeypress="return isAlphabet(event)">';
                $row .= '</div>';
                $row .= '</div>';

                $row .= '<div class="col-md-2">';
                if ($training['with_cop'] == 1) {
                    $row .= '<div class="form-group">';
                    $row .= '<input type="text" class="form-control" id="t_cop_number_' . $training['id'] . '" name="t_cop_number[]" placeholder="COP NUMBER">';
                    $row .= '</div>';
                } else {
                    $row .= '<div class="form-group">';
                    $row .= '<input type="text" class="form-control" id="t_cop_number_' . $training['id'] . '" name="t_cop_number[]" style="display:none;">';
                    $row .= '</div>';
                }
                $row .= '</div>';
                $row .= '</div>';
                $row .= '</div>';
            }
        } else {
            $row .= "
                <div class=\"col-md-12\">
                    <center>
                        <em class=\"text-muted font-20\">Please select first your desire <span class=\"text-underline\">Rank</span> to display your training certification requirements.</em>
                    </center>
                </div>";
        }

        $this->output
            ->set_output($row);
    }

    public function get_all_licenses()
    {
        $licenses = $this->global->getAllLicenses();

        $row = null;
        foreach ($licenses as $key) {
            $row .= '<div class="col-md-1"></div>';

            $row .= '<div class="col-md-3">';
            $row .= '<div class="form-group">';
            $row .= '<label class="mb-0 mt-2" id="license_name_' . $key['id'] . '">' . $key['license_name'] . '</label>';
            $row .= '<input type="hidden" id="lebi_' . $key['id'] . '" name="lebi[]" value="' . $key['id'] . '">';
            $row .= '</div>';
            $row .= '</div>';

            $row .= '<div class="col-md-2">';
            $row .= '<div class="form-group">';
            $row .= '<input type="text" class="form-control" id="l_grade_' . $key['id'] . '" name="l_grade[]" placeholder="GRADE">';
            $row .= '</div>';
            $row .= '</div>';

            $row .= '<div class="col-md-2">';
            $row .= '<div class="form-group">';
            $row .= '<input type="text" class="form-control" id="l_number_' . $key['id'] . '" name="l_number[]" placeholder="NUMBER">';
            $row .= '</div>';
            $row .= '</div>';

            $row .= '<div class="col-md-2">';
            $row .= '<div class="form-group">';
            $row .= '<input type="date" class="form-control" id="l_date_issued_' . $key['id'] . '" name="l_date_issued[]" placeholder="DATE ISSUED">';
            $row .= '</div>';
            $row .= '</div>';

            $row .= '<div class="col-md-2">';
            $row .= '<div class="form-group">';
            $row .= '<input type="date" class="form-control" id="l_expiry_date_' . $key['id'] . '" name="l_expiry_date[]" placeholder="EXPIRY DATE">';
            $row .= '</div>';
            $row .= '</div>';
        }

        $this->output
            ->set_output($row);
    }

    public function get_position()
    {
        $id = $this->input->post('id');

        $result = $this->global->getPositionById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_interview_form()
    {
        $id = $this->input->post('id');

        $result = $this->global->getInterviewFormPointsById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_general_interview_form()
    {
        $general = $this->global->getGeneralInterview();

        $general_form = null;
        $count = 0;

        foreach ($general as $key) {
            $general_form .= '<tr>';
            $general_form .= '<td id="text-alignment" class="text-center">' . $key["pti_description"] . '</td>';
            $general_form .= '<td><input type="number" id="score_general_' . $count . '" name="score_general[]" value="0" class="form-control text-center font-weight-medium" readonly="" min="5" max="10"></td>';
            $general_form .= '<td>';
            $general_form .= '<div class="row text-center">';
            $general_form .= '<div class="col-md-3">';
            $general_form .= '<div class="radio radio-alphera"><input type="radio" name="radio_' . $count . '" id="radio_one_' . $count . '" value="10" onchange="computeGeneralInterview()" ><label for="radio_one_' . $count . '"></label></div>';
            $general_form .= '</div>';
            $general_form .= '<div class="col-md-3">';
            $general_form .= '<div class="radio radio-alphera"><input type="radio" name="radio_' . $count . '" id="radio_two_' . $count . '" value="8.5" onchange="computeGeneralInterview()"><label for="radio_two_' . $count . '"></label></div>';
            $general_form .= '</div>';
            $general_form .= '<div class="col-md-3">';
            $general_form .= '<div class="radio radio-alphera"><input type="radio" name="radio_' . $count . '" id="radio_three_' . $count . '" value="7" onchange="computeGeneralInterview()"><label for="radio_three_' . $count . '"></label></div>';
            $general_form .= '</div>';
            $general_form .= '<div class="col-md-3">';
            $general_form .= '<div class="radio radio-alphera"><input type="radio" name="radio_' . $count . '" id="radio_four_' . $count . '" value="5" onchange="computeGeneralInterview()"><label for="radio_four_' . $count . '"></label></div>';
            $general_form .= '</div>';
            $general_form .= '</div>';
            $general_form .= '</td>';
            $general_form .= '<td><input type="text" id="remarks_general_' . $count . '" name="remarks_general[]" class="form-control"></td>';
            $general_form .= '</tr>';

            $count++;
        }

        $this->output
            ->set_content_type('application/html')
            ->set_output($general_form);
    }

    public function get_technical_interview_form()
    {
        $code = $this->input->post('code');

        $applicant = $this->global->getApplicants($code);
        $position_tech = $this->global->getPosition($applicant['approved_position']);
        $tech_forms = json_decode($position_tech['interview_form']);

        $table = null;
        $count = 0;

        if ($tech_forms) {
            foreach ($tech_forms as $key) {
                $tech = $this->global->getTechnicalInterview($key);
                $table .= '<tr>';
                $table .= '<td id="text-alignment" class="text-center">' . $tech['pti_description'] . '</td>';
                $table .= '<td><input type="number" id="score_technical_' . $count . '" name="t_score_technical[]" class="form-control text-center font-weight-medium" readonly="" min="5" max="10" value="0"></td>';
                $table .= '<td>';
                $table .= '<div class="row text-center">';
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

    public function get_evaluation_value()
    {
        $id = $this->input->post('id');

        $data = $this->global->getEvaluationValueById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_all_type_vessels()
    {
        $result = $this->global->getAllVesselType();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_all_vessels()
    {
        $result = $this->global->getAllVessel();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_vessel()
    {
        $id = $this->input->post('id');

        $data = $this->global->getVesselById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_vessel_type()
    {
        $id = $this->input->post('id');

        $data = $this->global->getVesselTypeById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_vessel_type_by_vessel()
    {
        $id = $this->input->post('id');

        $data = $this->global->getVesselTypeByVesselId($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_vessel_engine()
    {
        $id = $this->input->post('id');

        $data = $this->global->getEngineTypeById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_account_details()
    {
        if ($this->input->post('user_code')) {
            $user_code = $this->input->post('user_code');
        } else {
            $user_code = $this->session->userdata('user_code');
            $user_code = $this->global->ecdc('dc', $user_code);
        }

        $info = $this->global->getAccountDetails($user_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($info));
    }

    public function get_user_group()
    {
        $id = $this->input->post('id');

        $data = $this->global->getUserGroupById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_all_usertype()
    {
        $data = $this->global->getAllUserGroup();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_sea_service()
    {
        $room = $this->input->post('room');

        $positions = $this->global->getAllPosition();

        $row = '<div class="form-row mt-3 removeclass' . $room . '" data-service-form-num="' . $room . '">';
        $row .= '<div class="form-group col-lg-3">';
        $row .= '<input type="text" class="form-control" id="s_vessel_name_' . $room . '" name="s_vessel_name[]" value="" placeholder="Name of Vessel">';
        $row .= '</div>';
        $row .= '<div class="form-group col-lg-2">';
        $row .= '<input type="text" class="form-control" id="s_flag_' . $room . '" name="s_flag[]" value="" placeholder="Flag">';
        $row .= '</div>';
        $row .= '<div class="form-group col-lg-2">';
        $row .= '<input type="text" class="form-control" id="s_salary_' . $room . '" name="s_salary[]" value="" placeholder="Salary (USD)">';
        $row .= '</div>';
        $row .= '<div class="form-group col-lg-2">';
        $row .= '<select class="custom-select" id="s_rank_' . $room . '" name="s_rank[]">';
        $row .= '<option value="">Select Position</option>';

        foreach ($positions as $key) {
            $row .= '<option value="' . $key['id'] . '">' . $key['position_code'] . ' - ' . $key['position_name'] . '</option>';
        }

        $row .= '</select>';
        $row .= '</div>';
        $row .= '<div class="form-group col-lg-3">';
        $row .= '<input type="text" class="form-control" id="s_vsl_engn_' . $room . '" name="s_vsl_engn[]" placeholder="Type of VSL/Eng.">';
        $row .= '</div>';
        $row .= '<div class="form-group col-lg-3">';
        $row .= '<input type="text" class="form-control" id="s_grt_power' . $room . '" name="s_grt_power[]" value="" placeholder="GRT / HPower">';
        $row .= '</div>';
        $row .= '<div class="form-group col-lg-2">';
        // $row .= '<input type="date" class="form-control" id="s_embarked' . $room . '" name="s_embarked[]" onkeyup="totalservice(' . $room . ')">';
        $row .= '<input type="date" class="form-control" id="s_embarked' . $room . '" name="s_embarked[]" onkeyup="totalservice(this)">';
        $row .= '</div>';
        $row .= '<div class="form-group col-lg-2">';
        // $row .= '<input type="date" class="form-control" id="s_disembarked' . $room . '" name="s_disembarked[]" onkeyup="totalservice(' . $room . ')">';
        $row .= '<input type="date" class="form-control" id="s_disembarked' . $room . '" name="s_disembarked[]" onkeyup="totalservice(this)">';
        $row .= '</div>';
        $row .= '<div class="form-group col-lg-2">';
        $row .= '<input type="text" class="form-control" id="s_total_service' . $room . '" name="s_total_service[]" placeholder="Total Service" readonly>';
        $row .= '</div>';
        $row .= '<div class="form-group col-lg-3">';
        $row .= '<input type="text" class="form-control" id="s_agency' . $room . '" name="s_agency[]" value="" placeholder="Agency">';
        $row .= '</div>';
        $row .= '<div class="form-group col-lg-12">';
        $row .= '<div class="input-group">';
        $row .= '<textarea class="form-control" id="s_remarks' . $room . '" name="s_remarks[]" rows="3" placeholder="Remarks">';
        $row .= '</textarea>';
        $row .= '</div>';
        $row .= '</div>';
        $row .= '<div class="clear"></div>';
        $row .= '<div class="col-lg-6">';
        $row .= '<div class="input-group-btn">';
        $row .= '<button id="r_sea_service_btn' . $room . '" class="btn btn-danger" style="float: left !important" type="button" onclick="remove_sea_service_record(\'' . $room . '\');"><i class="fe-minus"></i> </button>';
        $row .= '</div>';
        $row .= '</div>';
        $row .= '<div class="col-lg-6">';
        $row .= '<div class="input-group-btn">';
        $row .= '<button class="btn btn-primary" type="button" onclick="addSeaServiceForm(this);" id="add_service' . $room . '" style="float: right !important" > <i class="fe-plus"></i> </button>';
        $row .= '</div>';
        $row .= '</div>';
        $row .= '</div>';

        $this->output
            ->set_output($row);
    }

    public function get_sea_services()
    {
        $form_count = $this->input->post('form_count');

        $positions = $this->global->getAllPosition();

        $form = "";
        for ($i = 1; $i <= $form_count; $i++) {
            $form .= '<div class="form-row mt-3 removeclass' . $i . '" data-service-form-num="' . $i . '">';
            $form .= '<div class="form-group col-lg-3">';
            $form .= '<input type="text" class="form-control" id="s_vessel_name_' . $i . '" name="s_vessel_name[]" value="" placeholder="Name of Vessel">';
            $form .= '</div>';
            $form .= '<div class="form-group col-lg-2">';
            $form .= '<input type="text" class="form-control" id="s_flag_' . $i . '" name="s_flag[]" value="" placeholder="Flag">';
            $form .= '</div>';
            $form .= '<div class="form-group col-lg-2">';
            $form .= '<input type="text" class="form-control" id="s_salary_' . $i . '" name="s_salary[]" value="" placeholder="Salary (USD)">';
            $form .= '</div>';
            $form .= '<div class="form-group col-lg-2">';
            $form .= '<select class="custom-select" id="s_rank_' . $i . '" name="s_rank[]">';
            $form .= '<option value="">Select Position</option>';

            foreach ($positions as $key) {
                $form .= '<option value="' . $key['id'] . '">' . $key['position_code'] . ' - ' . $key['position_name'] . '</option>';
            }

            $form .= '</select>';
            $form .= '</div>';
            $form .= '<div class="form-group col-lg-3">';
            $form .= '<input type="text" class="form-control" id="s_vsl_engn_' . $i . '" name="s_vsl_engn[]" placeholder="Type of VSL/Eng.">';
            $form .= '</div>';
            $form .= '<div class="form-group col-lg-3">';
            $form .= '<input type="text" class="form-control" id="s_grt_power' . $i . '" name="s_grt_power[]" value="" placeholder="GRT / HPower">';
            $form .= '</div>';
            $form .= '<div class="form-group col-lg-2">';
            // $form .= '<input type="date" class="form-control" id="s_embarked' . $i . '" name="s_embarked[]" onkeyup="totalservice(' . $i . ')">';
            $form .= '<input type="date" class="form-control" id="s_embarked' . $i . '" name="s_embarked[]" onkeyup="totalservice(this)">';
            $form .= '</div>';
            $form .= '<div class="form-group col-lg-2">';
            // $form .= '<input type="date" class="form-control" id="s_disembarked' . $i . '" name="s_disembarked[]" onkeyup="totalservice(' . $i . ')">';
            $form .= '<input type="date" class="form-control" id="s_disembarked' . $i . '" name="s_disembarked[]" onkeyup="totalservice(this)">';
            $form .= '</div>';
            $form .= '<div class="form-group col-lg-2">';
            $form .= '<input type="text" class="form-control" id="s_total_service' . $i . '" name="s_total_service[]" placeholder="Total Service" readonly>';
            $form .= '</div>';
            $form .= '<div class="form-group col-lg-3">';
            $form .= '<input type="text" class="form-control" id="s_agency' . $i . '" name="s_agency[]" value="" placeholder="Agency">';
            $form .= '</div>';
            $form .= '<div class="form-group col-lg-12">';
            $form .= '<div class="input-group">';
            $form .= '<textarea class="form-control" id="s_remarks' . $i . '" name="s_remarks[]" rows="3" placeholder="Remarks">';
            $form .= '</textarea>';
            $form .= '</div>';
            $form .= '</div>';
            $form .= '<div class="clear"></div>';
            $form .= '<div class="col-lg-6">';
            $form .= '<div class="input-group-btn">';
            $form .= '<button id="r_sea_service_btn' . $i . '" class="btn btn-danger" style="float: left !important" type="button" onclick="remove_sea_service_record(\'' . $i . '\');"><i class="fe-minus"></i> </button>';
            $form .= '</div>';
            $form .= '</div>';
            $form .= '<div class="col-lg-6">';
            $form .= '<div class="input-group-btn">';
            $form .= '<button class="btn btn-primary" type="button" onclick="addSeaServiceForm(this);" id="add_service' . $i . '" style="float: right !important" > <i class="fe-plus"></i> </button>';
            $form .= '</div>';
            $form .= '</div>';
            $form .= '</div>';
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($form));
    }

    public function get_module()
    {
        $id = $this->input->post('id');

        $data = $this->global->getModuleById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_sub_module()
    {
        $id = $this->input->post('id');

        $data = $this->global->getSubModuleById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_node()
    {
        $id = $this->input->post('id');

        $data = $this->global->getNodeById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_applicant_information()
    {
        $code = $this->input->post('code');
        $data = $this->global->getApplicantInformation($code);

        $data['nationality_description'] = $this->get_nationality_details($data['nationality'])['description'];
        $data['photo_path'] = $this->applicant_registered->getApplicantPhoto($this->global->ecdc('ec', $data['applicant_code']));

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function cmp_crew_details()
    {
        $code = $this->input->post('code');
        $data = $this->all_crew->get_crew_by_cmpcode($code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_civil_status()
    {
        $id = $this->input->post('civil_status');

        $result = $this->global->getCivilStatus($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_religion()
    {
        $id = $this->input->post('religion');

        $result = $this->global->getReligion($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_city()
    {
        $id = $this->input->post('city');

        $result = $this->global->getCity($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_province()
    {
        $id = $this->input->post('province');

        $result = $this->global->getProvince($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_working_gears()
    {
        $code = $this->input->post('code');

        $data = $this->global->getWorkingGears($code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_educational_attainment()
    {
        $code = $this->input->post('code');

        $data = $this->global->getEducationalAttainment($code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_next_of_kin()
    {
        $code = $this->input->post('code');

        $data = $this->global->getNextOfKin($code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_licenses()
    {
        $code = $this->input->post('code');

        $data = $this->global->getLicenses($code);


        // $value = [
        // //     'applicant_code' => $data['applicant_code'],
        // //     'crew_code'      => $data['crew_code'],
        // //     'date_created'   => $data['date_created'],
        // //     'cop_certificates'  => $data['cop_certificates']
        // // ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_certificates()
    {
        $code = $this->input->post('code');

        $data = $this->global->getCertificates($code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_warning_statuses()
    {
        $data = $this->global->getWarningStatus();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_sea_service_record()
    {
        $code = $this->input->post('code');

        $data = [];

        if (!empty($code)) {
            $data = $this->global->getSeaServiceRecord($code);

            if (is_null($data)) {
                $cmp_code = $code;
                $crew_code = $this->all_crew->get_crewcode_cmp($cmp_code);

                if ($crew_code) {
                    $data = $this->global->getSeaServiceRecord($crew_code['crew_code']);
                }
            }


            if ($data) {
                $vessel = !is_null($data['name_of_vessel']) ? json_decode($data['name_of_vessel']) : "";
                $flag = !is_null($data['flag']) ? json_decode($data['flag']) : "";
                $salary = !is_null($data['salary']) ? json_decode($data['salary']) : "";
                $type_vessel = !is_null($data['type_of_vsl_eng']) ? json_decode($data['type_of_vsl_eng']) : "";
                $grt_power = !is_null($data['grt_power']) ? json_decode($data['grt_power']) : "";
                $embarked = !is_null($data['embarked']) ? json_decode($data['embarked']) : "";
                $disembarked = !is_null($data['disembarked']) ? json_decode($data['disembarked']) : "";
                $agency = !is_null($data['agency']) ? json_decode($data['agency']) : "";
                $remarks = !is_null($data['remarks']) ? json_decode($data['remarks']) : "";
                $rank = !is_null($data['rank']) ? json_decode($data['rank']) : "";


                $array_of_services = [];

                if (!is_null($vessel)) {
                    for ($i = 0; $i < count($vessel); $i++) {

                        $position = !empty($this->global->getPosition($rank[$i])['position_name']) ? $this->global->getPosition($rank[$i])['position_name'] : "-";
                        if (!empty($vessel[$i])) {
                            $array_of_service = [
                                "vessel" => $vessel[$i],
                                "flag" => $flag[$i],
                                "salary" => $salary[$i],
                                "position" => $position,
                                "rank" => $rank[$i],
                                "type_vessel" => $type_vessel[$i],
                                "grt_power" => $grt_power[$i],
                                "embarked" => $embarked[$i],
                                "disembarked" => $disembarked[$i],
                                "agency" => $agency[$i],
                                "remarks" => $remarks[$i],
                            ];
                            array_push($array_of_services, $array_of_service);
                        }
                    }

                    if (!empty($array_of_services)) {
                        $new_years_of_services = array_column($array_of_services, "disembarked");
                        array_multisort($new_years_of_services, SORT_ASC, $array_of_services);

                        $data['array_of_sea_services'] = $array_of_services;
                    }
                }
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_offsigner_sea_service_record()
    {
        $code = $this->input->post('code');
        $crew_code = $this->global->getCrew($code);
        $data = $this->global->getSeaServiceRecord($crew_code['crew_code']);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_evaluation_sheet()
    {
        $code = $this->input->post('code');

        $data = $this->global->getEvaluationSheet($code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_general_interviews()
    {
        $code = $this->input->post('code');

        $data = $this->global->getGeneralInterviews($code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_technical_interview()
    {
        $code = $this->input->post('code');

        $data = $this->global->getTechnicalInterviews($code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_employed_crew()
    {
        $code = $this->input->post('code');

        $data = $this->global->getEmployedCrew($code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_applicants()
    {
        $applicant_code = $this->input->post('applicant_code');

        $data = $this->global->getApplicants($applicant_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_crew_details()
    {
        $monitor_code = $this->input->post('monitor_code');

        $data = $this->global->getCrew($monitor_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function getSeaserviceTotal()
    {
        $applicant_code = $this->input->post('applicant_code');
        $history = $this->global->getListSeaServiceRecord($applicant_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($history));
    }

    public function get_list_licenses()
    {
        $code = $this->input->post('code');

        $licenses = $this->global->getListLicenses($code);
        $list = null;

        if ($licenses) {

            $license_name = json_decode($licenses['lebi']);
            $grade = json_decode($licenses['grade']);
            $number = json_decode($licenses['number']);
            $date_issued = json_decode($licenses['date_issued']);
            $expiry_date = json_decode($licenses['expiry_date']);

            for ($i = 0; $i < count($license_name); $i++) {

                if (empty($expiry_date[$i])) {
                    $color = 'rgb(255,255,255);';
                } else {
                    $contract_duration = date('Y-m-d', strtotime($expiry_date[$i]));
                    $current_date = strtotime(date('Y-m-d'));
                    $diff = strtotime($contract_duration) - $current_date;
                    $date_diff = round($diff / (60 * 60 * 24));

                    if ($date_diff > 90) {
                        // WHITE
                        $color = 'rgb(255,255,255);';
                    } elseif ($date_diff >= 60 && $date_diff <= 90) {
                        // YELLOW
                        $color = 'rgb(255,229,171);';
                    } elseif ($date_diff >= 31 && $date_diff <= 60) {
                        // ORANGE
                        $color = 'rgb(255,215,141);';
                    } elseif ($date_diff <= 30 && $date_diff >= 1) {
                        // RED
                        $color = 'rgb(255,58,0,0.25)';
                    } else if ($date_diff <= 0) {
                        $color = 'rgba(240,100,59,.50);';
                    }
                }
                $new_exp = "";
                if (!empty($expiry_date[$i]) && !empty($date_issued[$i]) || !empty($expiry_date[$i]) && empty($date_issued[$i])) {
                    $new_exp = date('M j, Y', strtotime($expiry_date[$i]));
                } else if (empty($expiry_date[$i]) && !empty($date_issued[$i])) {
                    $new_exp = "<span class=\"text-danger\">INC</span>";
                } else {
                    $new_exp = "N/A";
                }

                $new_date_issued = "";
                if (!empty($expiry_date[$i]) && !empty($date_issued[$i]) || empty($expiry_date[$i]) && !empty($date_issued[$i])) {
                    $new_date_issued = date('M j, Y', strtotime($date_issued[$i]));
                } else if (!empty($expiry_date[$i]) && empty($date_issued[$i])) {
                    $new_date_issued = "<span class=\"text-danger\">INC</span>";
                } else {
                    $new_date_issued = "N/A";
                }


                $list .= '<li class="list-group-item" style="background:' . $color . ';">';
                $list .= '<div class="row text-center">';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="mt-1 mb-0 font-16">' . $this->global->getLicenseById($license_name[$i])['license_name'] . '</h4>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16">' . (!$grade[$i] ? ' - ' : $grade[$i]) . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Grade</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16">' . (!$number[$i] ? ' - ' : $number[$i]) . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Number</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16">' . $new_date_issued . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Date Issued</p>';
                $list .= '</div>';
                $list .= '</div> ';
                $list .= '<div class="col-md-2"> ';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16">' . $new_exp  . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Expiration Date</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2"> ';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16">' . $this->global->getStatusLicensesCertificates($expiry_date[$i]) . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Status</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '</li>';
            }
        } else {

            $licenses = $this->global->getAllLicenses();

            $list = null;
            foreach ($licenses as $key) {

                $list .= '<li class="list-group-item">';
                $list .= '<div class="row text-center">';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="mt-1 mb-0 font-16">' . $key['license_name'] . '</h4>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16 text-danger"> N/A </h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Grade</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16 text-danger"> N/A </h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Number</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16 text-danger"> N/A </h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Date Issued</p>';
                $list .= '</div>';
                $list .= '</div> ';
                $list .= '<div class="col-md-2"> ';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16 text-danger"> N/A </h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Expiration Date</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2"> ';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16 text-danger"> N/A </h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Status</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '</li>';
            }
        }
        $this->output
            ->set_output($list);
    }

    public function get_list_certificates()
    {
        $code = $this->input->post('code');

        $certificates = $this->global->getListCertificates($code);
        $list = null;

        if ($certificates) {
            $cert_name = json_decode($certificates['certificates']);
            $numbers = json_decode($certificates['number']);
            $date_issued = json_decode($certificates['date_issued']);
            $date_expired = json_decode($certificates['expiration_date']);
            $issued_by = json_decode($certificates['issued_by']);
            $cop_number = json_decode($certificates['with_cop_number']);

            if ($numbers) {
                for ($i = 0; $i < count($numbers); $i++) {

                    if (empty($date_expired[$i])) {
                        $color = 'rgb(255,255,255);';
                    } else {
                        $contract_duration = date('Y-m-d', strtotime($date_expired[$i]));
                        $current_date = strtotime(date('Y-m-d'));
                        $diff = strtotime($contract_duration) - $current_date;
                        $date_diff = round($diff / (60 * 60 * 24));

                        if ($date_diff > 90) {
                            // WHITE
                            $color = 'rgb(255,255,255);';
                        } elseif ($date_diff >= 60 && $date_diff <= 90) {
                            // YELLOW
                            $color = 'rgb(255,229,171);';
                        } elseif ($date_diff >= 31 && $date_diff <= 60) {
                            // ORANGE
                            $color = 'rgb(255,215,141);';
                        } elseif ($date_diff <= 30 && $date_diff >= 1) {
                            // RED
                            $color = 'rgb(255,58,0,0.25)';
                        } else if ($date_diff <= 0) {
                            $color = 'rgba(240,100,59,.50);';
                        }
                    }
                    $new_exp = "";
                    if (!empty($date_expired[$i]) && !empty($date_issued[$i]) || !empty($date_expired[$i]) && empty($date_issued[$i])) {
                        $new_exp = date('M j, Y', strtotime($date_expired[$i]));
                    } else if (empty($date_expired[$i]) && !empty($date_issued[$i])) {
                        $new_exp = "<span class=\"text-danger\">INC</span>";
                    } else {
                        $new_exp = "N/A";
                    }

                    $new_date_issued = "";
                    if (!empty($expiry_date[$i]) && !empty($date_issued[$i]) || empty($expiry_date[$i]) && !empty($date_issued[$i])) {
                        $new_date_issued = date('M j, Y', strtotime($date_issued[$i]));
                    } else if (!empty($expiry_date[$i]) && empty($date_issued[$i])) {
                        $new_date_issued = "<span class=\"text-danger\">INC</span>";
                    } else {
                        $new_date_issued = "N/A";
                    }


                    $list .= '<li class="list-group-item" style="background:' . $color . ';">';
                    $list .= '<div class="row text-center">';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="mt-1 mb-0 font-16">' . $this->global->getTrainingCertificate($cert_name[$i])['cert_name'] . '</h4>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16">' . (!$numbers[$i] ? ' - ' : $numbers[$i]) . '</h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Number</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-1">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16">' . $new_date_issued . '</h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Date Issued</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16">' . $new_exp . '</h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Expiration Date</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-1">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16">' . (!$issued_by[$i] ? ' - ' : $issued_by[$i]) . '</h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Issued By</p>';
                    $list .= '</div>';
                    $list .= '</div> ';
                    $list .= '<div class="col-md-2"> ';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16">' . (!$cop_number[$i] ? ' - ' : $cop_number[$i]) . '</h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">COP Number</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2"> ';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16">' . $this->global->getStatusLicensesCertificates($date_expired[$i]) . '</h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Status</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '</li>';
                }
            } else {
                $result = $this->global->getAllTrainingCertificates();
                foreach ($result as $key) {
                    $list .= '<li class="list-group-item" style="background-color:rgba(240,100,59,.25);">';
                    $list .= '<div class="row text-center">';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="mt-1 mb-0 font-16">' . $key['cert_name'] . '</h4>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16"> - </h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Number</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16"> - </h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Date Issued</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16"> - </h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Expiration Date</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16"> - </h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Issued By</p>';
                    $list .= '</div>';
                    $list .= '</div> ';
                    $list .= '<div class="col-md-2"> ';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16"> - </h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">COP Number</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2"> ';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16"> - </h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Status</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '</li>';
                }
            }
        } else {

            $applicant_data =  $this->global->getApplicants($code);

            $first_training  = $this->global->getPosition($applicant_data['position_first']);
            $second_training = $this->global->getPosition($applicant_data['position_second']);

            $first_training  = json_decode($first_training['position_requirements']);
            if ($second_training) {
                $second_training = json_decode($second_training['position_requirements']);
            }
            if (!empty($second_position)) {
                $trainings = array_unique(array_merge($first_training, $second_training), SORT_REGULAR);
            } else {
                $trainings = $first_training;
            }
            foreach ($trainings as $key) {

                $training = $this->global->getTrainingCertificate($key);

                $list .= '<li class="list-group-item">';
                $list .= '<div class="row text-center">';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="mt-1 mb-0 font-16">' . $training['cert_name'] . '</h4>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14 text-danger">N/A</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Number</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-1">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14 text-danger">N/A</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Date Issued</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14 text-danger">N/A</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Expiration Date</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14 text-danger">N/A</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Issued By</p>';
                $list .= '</div>';
                $list .= '</div> ';
                $list .= '<div class="col-md-2"> ';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14 text-danger">N/A</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">COP Number</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-1"> ';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14 text-danger">N/A</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Status</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '</li>';
            }
        }
        $this->output
            ->set_output($list);
    }

    public function get_list_sea_service_record()
    {
        $applicant_code = $this->input->post('applicant_code');

        $history = $this->global->getListSeaServiceRecord($applicant_code);

        $table = null;

        if ($history) {
            $vessel = json_decode($history['name_of_vessel']);
            $flag = json_decode($history['flag']);
            $salary = json_decode($history['salary']);
            $type_vessel = json_decode($history['type_of_vsl_eng']);
            $grt_power = json_decode($history['grt_power']);
            $embarked = json_decode($history['embarked']);
            $disembarked = json_decode($history['disembarked']);
            $total_service = json_decode($history['total_service']);
            $agency = json_decode($history['agency']);
            $remarks = json_decode($history['remarks']);
            $rank = json_decode($history['rank']);

            $count = 1;

            $array_of_services = [];

            for ($i = 0; $i < count($vessel); $i++) {

                $position = !empty($this->global->getPosition($rank[$i])['position_name']) ? $this->global->getPosition($rank[$i])['position_name'] : "-";

                if (empty($vessel[$i])) {
                    $table .= '<tr><td colspan="12">No data available in table</td></tr>';
                } else {
                    $array_of_service = [
                        "vessel" => $vessel[$i],
                        "flag" => $flag[$i],
                        "salary" => $salary[$i],
                        "position" => $position,
                        "type_vessel" => $type_vessel[$i],
                        "grt_power" => $grt_power[$i],
                        "embarked" => $embarked[$i],
                        "disembarked" => $disembarked[$i],
                        "agency" => $agency[$i],
                        "remarks" => $remarks[$i],
                    ];

                    array_push($array_of_services, $array_of_service);
                }

                $count++;
            }

            if (!empty($array_of_services)) {
                $new_years_of_services = array_column($array_of_services, "disembarked");
                array_multisort($new_years_of_services, SORT_ASC, $array_of_services);

                $table = $array_of_services;
            }
        } else {
            $table .= '<tr><td colspan="12">No data available in table</td></tr>';
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($table));
    }

    public function get_list_flights()
    {

        $monitor_code = $this->input->post('monitor_code');
        $flight_details = $this->global->getAllFlights();

        if ($monitor_code) {
            $crew_flight = $this->db->where('monitor_code', $monitor_code)->get('crews')->row_array()['flight_code'];
        }

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($flight_details as $key) {
            $checked = ($crew_flight == $key['flight_code']) ? "checked" : "";

            $select = '<input type="radio" id="afdm_id_' . $key['flight_code'] . '" value="' . $key['flight_code'] . '" name="afdm_id" onclick="addCrewFlight(\'' . $key['flight_code'] . '\', \'' . $monitor_code . '\')" ' . $checked  . '><label for="afdm_id_' . $key['flight_code'] . '"></label>';

            $data[] = [
                $select,
                $this->global->getVesselById($key['vessel_id'])['vsl_name'],
                $key['departure_country'],
                date('M j, Y h:i A', strtotime($key['departure_datetime'])),
                $key['destination_country'],
                date('M j, Y h:i A', strtotime($key['destination_datetime'])),
                $key['airline'],
                $key['airfare'],
                !empty($key['option']) ? date('F j, Y', strtotime($key['option'])) : "-",
            ];

            $count++;
        }

        $result = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $data
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_crew_list_flights()
    {
        $monitor_code = $this->input->post('monitor_code');
        $crew_code = $this->input->post('crew_code');
        $flight_details = $this->global->getCrewFlights($crew_code);


        if ($monitor_code) {
            $return_flight = $this->db->where('monitor_code', $monitor_code)->get('crews')->row_array();
            $crew_flight = !empty($return_flight) ? $return_flight['crew_code'] : "";
        }

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        if (!empty($flight_details)) {
            foreach ($flight_details as $key) {

                $bg = ($crew_flight == $key['flight_code']) ? "bg-warning text-white" : "";
                $data[] = [
                    "<span class=\"{$bg}\">{$count}</span>",
                    $this->global->getVesselById($key['vessel_id'])['vsl_name'],
                    $key['departure_country'],
                    date('M j, Y h:i A', strtotime($key['departure_datetime'])),
                    $key['destination_country'],
                    date('M j, Y h:i A', strtotime($key['destination_datetime'])),
                    $key['airline'],
                    $key['airfare'],
                    !empty($key['option']) ? date('F j, Y', strtotime($key['option'])) : "-",
                ];

                $count++;
            }
        }


        $result = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $data
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_nationality()
    {

        $id = $this->input->post('nationality');

        $result = $this->global->getNationalityById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_nationality_details($id)
    {

        $result = $this->global->getNationalityById($id);

        return $result;
    }

    public function get_crew_information()
    {
        $crew_code = $this->input->post('code');

        $result = $this->global->getCrew($crew_code);
        $result['insigner'] = !empty($this->global->getCMP($result['monitor_code'])['insigner']) ? $this->global->getCMP($result['monitor_code'])['insigner'] : "";

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_general_interview()
    {
        $data = $this->global->getGeneralInterview();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_interview_sheet()
    {
        $code = $this->input->post('code');

        $data = $this->global->getInterviewSheet($code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_total_sea_service()
    {
        $embark = $_POST['s_embarked'];
        $disembark = $_POST['s_disembarked'];

        foreach ($embark as $key => $date) {
            $data = [
                'embarked' => $date,
                'disembarked' => $disembark[$key]
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_failed_reason()
    {
        $applicant_code = $this->input->post('applicant_code');

        $result = $this->applicant_failed->getFailedRemark($applicant_code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function get_applicant_photo()
    {
        $applicant_code = $this->input->post('code');
        $result = $this->global->get_applicant_photo($applicant_code);
        $url = file_exists($result) ? $result : base_url() . "assets/images/avatar-placeholder.png";

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($url));
    }

    public function get_user_responsibility_list()
    {
        $module = $this->global->getAllModule();

        $nav = null;
        $countRow = 1;

        foreach ($module as $m) {

            if ($countRow == 1) {
                $nav .= '<div class="col-md-6"><fieldset>';
            }

            $nav .= '<div class="form-group">';
            $nav .= '<div class="checkbox checkbox-alphera mb-1">';
            $nav .= '<input type="checkbox" name="e_module[]" id="e_module_' . $m['id'] . '" value="' . $m['id'] . '">';
            $nav .= '<label for="e_module_' . $m['id'] . '" style="font-weight: 500;">' . htmlentities($m['description'], ENT_QUOTES, 'UTF-8') . '</label>';
            $nav .= '</div>';


            $sub_module =  $this->global->getAllSubModules($m['id']);

            foreach ($sub_module as $sm) {
                $nav .= '<div class="pt-1 pl-4">';
                $nav .= '<div class="checkbox checkbox-alphera mb-1">';
                $nav .= '<input type="checkbox" name="e_submodule_' . $m['id'] . '[]" id="e_submodule_' . $sm['id'] . '" value="' . $sm['id'] . '">';
                $nav .= '<label for="e_submodule_' . $sm['id'] . '">' . htmlentities($sm['description'], ENT_QUOTES, 'UTF-8') . '</label>';
                $nav .= '</div>';
                $nav .= '</div>';

                $nodes = $this->global->getAllNodes($sm['id']);

                foreach ($nodes as $n) {
                    $nav .= '<div class="pt-1 pl-8">';
                    $nav .= '<div class="checkbox checkbox-alphera mb-1">';
                    $nav .= '<input type="checkbox" name="e_node_' . $sm['id'] . '[]" id="e_node_' . $n['id'] . '" value="' . $n['id'] . '">';
                    $nav .= '<label for="e_node_' . $n['id'] . '">' . htmlentities($n['description'], ENT_QUOTES, 'UTF-8') . '</label>';
                    $nav .= '</div>';
                    $nav .= '</div>';
                }
            }

            $nav .= '</div>';

            if ($countRow == 5) {
                $nav .= '</fieldset></div>';
                $countRow = 0;
            }

            $countRow++;
        }

        echo $nav;
    }

    public function get_crew_position()
    {
        $crew_code = $this->input->post('crew_code');
        $crew_info = $this->global->getCrewInformation($crew_code);
        $position = $this->global->getPosition($crew_info['position']);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($position['position_name']));
    }

    public function get_list_positions()
    {
        $crew_code = $this->input->get('crew_code');
        $crew_info = $this->global->getCrewPositions($crew_code);


        $data['first_position'] = $crew_info['position_first'] ? $crew_info['position_first'] : "";
        $data['second_position'] = $crew_info['position_second'] ? $crew_info['position_second'] : "";

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_list_licenses_cmp()
    {
        $code = $this->input->post('code');
        $crew_code = $this->input->post('crew_code');
        if (!empty($code)) {
            $crew = $this->all_crew->get_crewcode_cmp($code);
            $crew_code = $crew['crew_code'];
        }
        $licenses = $this->global->getListLicenses($crew_code);
        $list = null;

        if ($licenses) {

            $license_name = json_decode($licenses['lebi']);
            $grade = json_decode($licenses['grade']);
            $number = json_decode($licenses['number']);
            $date_issued = json_decode($licenses['date_issued']);
            $expiry_date = json_decode($licenses['expiry_date']);

            for ($i = 0; $i < count($license_name); $i++) {

                if (empty($expiry_date[$i])) {
                    $color = 'rgb(255,255,255);';
                } else {
                    $contract_duration = date('Y-m-d', strtotime($expiry_date[$i]));
                    $current_date = strtotime(date('Y-m-d'));
                    $diff = strtotime($contract_duration) - $current_date;
                    $date_diff = round($diff / (60 * 60 * 24));

                    if ($date_diff > 90) {
                        // WHITE
                        $color = 'rgb(255,255,255);';
                    } elseif ($date_diff >= 60 && $date_diff <= 90) {
                        // YELLOW
                        $color = 'rgb(255,229,171);';
                    } elseif ($date_diff >= 31 && $date_diff <= 60) {
                        // ORANGE
                        $color = 'rgb(255,215,141);';
                    } elseif ($date_diff <= 30 && $date_diff >= 1) {
                        // RED
                        $color = 'rgb(255,58,0,0.25)';
                    } else if ($date_diff <= 0) {
                        $color = 'rgba(240,100,59,.50);';
                    }
                }
                $new_exp = "";
                if (!empty($expiry_date[$i]) && !empty($date_issued[$i]) || !empty($expiry_date[$i]) && empty($date_issued[$i])) {
                    $new_exp = date('M j, Y', strtotime($expiry_date[$i]));
                } else if (empty($expiry_date[$i]) && !empty($date_issued[$i])) {
                    $new_exp = "<span class=\"text-danger\">INC</span>";
                } else {
                    $new_exp = "N/A";
                }

                $new_date_issued = "";
                if (!empty($expiry_date[$i]) && !empty($date_issued[$i]) || empty($expiry_date[$i]) && !empty($date_issued[$i])) {
                    $new_date_issued = date('M j, Y', strtotime($date_issued[$i]));
                } else if (!empty($expiry_date[$i]) && empty($date_issued[$i])) {
                    $new_date_issued = "<span class=\"text-danger\">INC</span>";
                } else {
                    $new_date_issued = "N/A";
                }


                $list .= '<li class="list-group-item" style="background:' . $color . ';">';
                $list .= '<div class="row text-center">';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="mt-1 mb-0 font-16">' . $this->global->getLicenseById($license_name[$i])['license_name'] . '</h4>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16">' . (!$grade[$i] ? ' - ' : $grade[$i]) . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Grade</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16">' . (!$number[$i] ? ' - ' : $number[$i]) . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Number</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16">' . $new_date_issued . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Date Issued</p>';
                $list .= '</div>';
                $list .= '</div> ';
                $list .= '<div class="col-md-2"> ';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16">' . $new_exp  . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Expiration Date</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2"> ';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16">' . $this->global->getStatusLicensesCertificates($expiry_date[$i]) . '</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Status</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '</li>';
            }
        } else {

            $licenses = $this->global->getAllLicenses();

            $list = null;
            foreach ($licenses as $key) {

                $list .= '<li class="list-group-item">';
                $list .= '<div class="row text-center">';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="mt-1 mb-0 font-16">' . $key['license_name'] . '</h4>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16 text-danger"> N/A </h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Grade</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16 text-danger"> N/A </h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Number</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16 text-danger"> N/A </h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Date Issued</p>';
                $list .= '</div>';
                $list .= '</div> ';
                $list .= '<div class="col-md-2"> ';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16 text-danger"> N/A </h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Expiration Date</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2"> ';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-16 text-danger"> N/A </h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Status</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '</li>';
            }
        }

        $this->output
            ->set_output($list);
    }

    public function get_list_certificates_cmp()
    {
        $code = $this->input->post('code');
        $crew_code = $this->input->post('crew_code');
        if (!empty($code)) {
            $crew = $this->all_crew->get_crewcode_cmp($code);
            $crew_code = $crew['crew_code'];
        }
        $certificates = $this->global->getListCertificates($crew_code);
        $list = null;
        if ($certificates) {
            $cert_name = json_decode($certificates['certificates']);
            $numbers = json_decode($certificates['number']);
            $date_issued = json_decode($certificates['date_issued']);
            $date_expired = json_decode($certificates['expiration_date']);
            $issued_by = json_decode($certificates['issued_by']);
            $cop_number = json_decode($certificates['with_cop_number']);

            if (!empty($numbers)) {
                for ($i = 0; $i < count($numbers); $i++) {

                    if (empty($date_expired[$i])) {
                        $color = 'rgb(255,255,255);';
                    } else {
                        $contract_duration = date('Y-m-d', strtotime($date_expired[$i]));
                        $current_date = strtotime(date('Y-m-d'));
                        $diff = strtotime($contract_duration) - $current_date;
                        $date_diff = round($diff / (60 * 60 * 24));

                        if ($date_diff > 90) {
                            // WHITE
                            $color = 'rgb(255,255,255);';
                        } elseif ($date_diff >= 60 && $date_diff <= 90) {
                            // YELLOW
                            $color = 'rgb(255,229,171);';
                        } elseif ($date_diff >= 31 && $date_diff <= 60) {
                            // ORANGE
                            $color = 'rgb(255,215,141);';
                        } elseif ($date_diff <= 30 && $date_diff >= 1) {
                            // RED
                            $color = 'rgb(255,58,0,0.25)';
                        } else if ($date_diff <= 0) {
                            $color = 'rgba(240,100,59,.50);';
                        }
                    }
                    $new_exp = "";
                    if (!empty($date_expired[$i]) && !empty($date_issued[$i]) || !empty($date_expired[$i]) && empty($date_issued[$i])) {
                        $new_exp = date('M j, Y', strtotime($date_expired[$i]));
                    } else if (empty($date_expired[$i]) && !empty($date_issued[$i])) {
                        $new_exp = "<span class=\"text-danger\">INC</span>";
                    } else {
                        $new_exp = "N/A";
                    }

                    $new_date_issued = "";
                    if (!empty($expiry_date[$i]) && !empty($date_issued[$i]) || empty($expiry_date[$i]) && !empty($date_issued[$i])) {
                        $new_date_issued = date('M j, Y', strtotime($date_issued[$i]));
                    } else if (!empty($expiry_date[$i]) && empty($date_issued[$i])) {
                        $new_date_issued = "<span class=\"text-danger\">INC</span>";
                    } else {
                        $new_date_issued = "N/A";
                    }


                    $list .= '<li class="list-group-item" style="background:' . $color . ';">';
                    $list .= '<div class="row text-center">';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="mt-1 mb-0 font-16">' . $this->global->getTrainingCertificate($cert_name[$i])['cert_name'] . '</h4>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16">' . (!$numbers[$i] ? ' - ' : $numbers[$i]) . '</h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Number</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-1">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16">' . $new_date_issued . '</h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Date Issued</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16">' . $new_exp . '</h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Expiration Date</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-1">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16">' . (!$issued_by[$i] ? ' - ' : $issued_by[$i]) . '</h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Issued By</p>';
                    $list .= '</div>';
                    $list .= '</div> ';
                    $list .= '<div class="col-md-2"> ';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16">' . (!$cop_number[$i] ? ' - ' : $cop_number[$i]) . '</h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">COP Number</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2"> ';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16">' . $this->global->getStatusLicensesCertificates($date_expired[$i]) . '</h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Status</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '</li>';
                }
            } else {
                $result = $this->global->getAllTrainingCertificates();
                foreach ($result as $key) {
                    $list .= '<li class="list-group-item" style="background-color:rgba(240,100,59,.25);">';
                    $list .= '<div class="row text-center">';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="mt-1 mb-0 font-16">' . $key['cert_name'] . '</h4>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16"> - </h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Number</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16"> - </h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Date Issued</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16"> - </h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Expiration Date</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2">';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16"> - </h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Issued By</p>';
                    $list .= '</div>';
                    $list .= '</div> ';
                    $list .= '<div class="col-md-2"> ';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16"> - </h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">COP Number</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '<div class="col-md-2"> ';
                    $list .= '<div class="m-0">';
                    $list .= '<h4 class="m-0 font-16"> - </h4>';
                    $list .= '<p class="mb-0 text-muted text-truncate">Status</p>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '</div>';
                    $list .= '</li>';
                }
            }
        } else {

            $applicant_data =  $this->global->getApplicants($code);

            $first_training  = $this->global->getPosition($applicant_data['position_first']);
            $second_training = $this->global->getPosition($applicant_data['position_second']);

            $first_training  = json_decode($first_training['position_requirements']);
            if ($second_training) {
                $second_training = json_decode($second_training['position_requirements']);
            }
            if (!empty($second_position)) {
                $trainings = array_unique(array_merge($first_training, $second_training), SORT_REGULAR);
            } else {
                $trainings = $first_training;
            }
            foreach ($trainings as $key) {

                $training = $this->global->getTrainingCertificate($key);

                $list .= '<li class="list-group-item">';
                $list .= '<div class="row text-center">';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="mt-1 mb-0 font-16">' . $training['cert_name'] . '</h4>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14 text-danger">N/A</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Number</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-1">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14 text-danger">N/A</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Date Issued</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14 text-danger">N/A</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Expiration Date</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-2">';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14 text-danger">N/A</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Issued By</p>';
                $list .= '</div>';
                $list .= '</div> ';
                $list .= '<div class="col-md-2"> ';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14 text-danger">N/A</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">COP Number</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '<div class="col-md-1"> ';
                $list .= '<div class="m-0">';
                $list .= '<h4 class="m-0 font-14 text-danger">N/A</h4>';
                $list .= '<p class="mb-0 text-muted text-truncate">Status</p>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '</div>';
                $list .= '</li>';
            }
        }

        $this->output
            ->set_output($list);
    }

    public function get_crew_name_cmpcode()
    {
        $cmp_code = $this->input->post('cmp_code');
        $result = $this->all_crew->get_crew_by_cmpcode($cmp_code);

        $data = ['name' => $result['first_name'] . ' ' . $result['middle_name'] . ' ' . $result['last_name']];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_crew_name_mntrcode()
    {
        $mntr_code = $this->input->post('mntr_code');
        $result = $this->global->getCrewNameByMonitorCode($mntr_code);

        $data = ['fullname' => !empty($result) ? $result['full_name'] : ""];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_crew_name_crwcode()
    {
        $crew_code = $this->input->post('code');
        $result = $this->global->getCrewNameByCrewCode($crew_code);

        $data = ['fullname' => !empty($result) ? $result['full_name'] : ""];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function cmp_crew_contract_table()
    {
        $data = [];
        $conditions = [];
        $cmp_code = $this->input->post('code');
        $crew_code = $this->all_crew->get_crewcode_cmp($cmp_code);
        $conditions['crew_code'] = $crew_code['crew_code'];
        $count = 1;
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length =  intval($this->input->post('length'));

        if ($conditions) {
            $total_crew = $this->contracts->getCrewContractTable($conditions);
        }

        if ($total_crew) {
            foreach ($total_crew as $row) {
                $action = '<div class="btn-group" role="group" aria-label="">
                <button type="button" class="btn btn-outline-primary btn-xs"><i class="mdi mdi-download font-16"></i></button>
                <button type="button" class="btn btn-outline-primary btn-xs"><i class="mdi mdi-delete font-16" onclick="removeContract(\'' . $row['contract_code'] . '\')"></i></button>
            </div>';

                $data[] = array(
                    'count' => $count++,
                    'contract_type' => 'POEA Contract',
                    'contract_duration' => date('M j, Y', strtotime($row['contract_duration'])),
                    'issued_by' => $this->global->getAccountDetails($row['issued_by'])['full_name'],
                    'date_created' => date('M j, Y', strtotime($row['date_created'])),
                    'action' => $action
                );
            }
            $count++;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        );

        echo json_encode($result);
    }

    public function cmp_crew_mlc_table()
    {
        $data = [];
        $conditions = [];
        $cmp_code = $this->input->post('code');
        $crew_code = $this->all_crew->get_crewcode_cmp($cmp_code);

        $count = 1;
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length =  intval($this->input->post('length'));
        $conditions['crew_code'] = $crew_code['crew_code'];

        if ($conditions) {
            $total_crew = $this->contracts->getMLCTable($conditions);
        }

        if ($total_crew) {
            foreach ($total_crew as $row) {
                $action = '<button type="button" class="btn btn-outline-primary btn-xs">Download</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removeMlcContract(\'' . $row['monitor_code'] . '\')">Remove</button>';
                if ($row['mlc_type'] == 1) {
                    $mlc_type = "KOREAN FLAG";
                } else if ($row['mlc_type'] == 2) {
                    $mlc_type = "PANAMA FLAG";
                } else {
                    $mlc_type = "MARSHALL FLAG";
                }

                $data[] = array(
                    'count' => $count++,
                    'contract_type' => 'MLC Contract',
                    'mlc_type' => $mlc_type,
                    'issued_by' => $this->global->getAccountDetails($row['issued_by'])['full_name'],
                    'date_created' => date('M j, Y h:m A', strtotime($row['date_created'])),
                    'action' => $action
                );
            }
            $count++;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        );

        echo json_encode($result);
    }

    public function get_cmp_medical_records_table()
    {
        $data = [];
        $conditions = [];
        $cmp_code = $this->input->post('code');
        $crew_code = $this->all_crew->get_crewcode_cmp($cmp_code);
        $conditions['crew_code'] = $crew_code['crew_code'];
        $conditions['medical_code'] = "";
        $count = 1;
        $position = "";

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length =  intval($this->input->post('length'));

        $crew_data = $this->global->getCrewInformation($crew_code['crew_code']);
        if ($crew_data) {
            $position = $this->global->getPosition($crew_data['position']);
        }

        if ($conditions) {
            $crew = $this->medical->get_crew_medical_table($conditions);
        }

        if ($crew) {
            foreach ($crew as $row) {
                $action = '<div class="btn-group" role="group" aria-label="">
                <button type="button" class="btn btn-outline-primary btn-xs" onclick="editMedical(\'' . $row['medical_code'] . '\',\'' . $row['crew_code'] . '\')"><i class="mdi mdi-pencil font-16"></i></button>
                <button type="button" class="btn btn-outline-danger btn-xs"><i class="mdi mdi-delete font-16" onclick="removeMedical(\'' . $row['id'] . '\')"></i></button>
            </div>';

                // $bmi = ($row['medical_weight'] / $row['medical_height'] / $row['medical_height']) * 10000;
                $data[] = array(
                    $count++,
                    date('M j, Y', strtotime($row['date_med_exam'])),
                    date('M j, Y', strtotime($row['medical_expiry_date'])),
                    !$position ? "" : htmlentities($position['position_name'], ENT_QUOTES, 'UTF-8'),
                    number_format($row['medical_bmi'], 2),
                    htmlentities($row['remarks'], ENT_QUOTES, 'UTF-8'),
                    (($row['date_updated'] === NULL) ? date('M j, Y h:m A', strtotime($row['date_created'])) : date('M j, Y h:m A', strtotime($row['date_updated']))),
                    htmlentities((($row['medical_status'] === "2") ? "Fit For Sea Duty" : "Pending"), ENT_QUOTES, 'UTF-8'),
                    $action
                );
            }
            $count++;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        );

        echo json_encode($result);
    }

    public function get_vessel_history()
    {
        $code = $this->input->post('code');

        $crew_sea_service = $this->global->getListSeaServiceRecord($code);

        $history = "";

        if (!is_null($crew_sea_service)) {
            $history = $crew_sea_service;
        } else {
            $cmp_code = $code;
            $crew_code = $this->all_crew->get_crewcode_cmp($cmp_code);

            if ($crew_code) {
                $history = $this->global->getListSeaServiceRecord($crew_code['crew_code']);
            }
        }

        $table = null;

        if ($history) {
            $vessel = json_decode($history['name_of_vessel']);
            $flag = json_decode($history['flag']);
            $salary = json_decode($history['salary']);
            $type_vessel = json_decode($history['type_of_vsl_eng']);
            $grt_power = json_decode($history['grt_power']);
            $embarked = json_decode($history['embarked']);
            $disembarked = json_decode($history['disembarked']);
            $total_service = json_decode($history['total_service']);
            $agency = json_decode($history['agency']);
            $remarks = json_decode($history['remarks']);
            $rank = json_decode($history['rank']);
            // var_dump($rank);
            $count = 1;

            $array_of_services = [];

            if (!is_null($vessel)) {
                for ($i = 0; $i < count($vessel); $i++) {

                    $position = !empty($this->global->getPosition($rank[$i])['position_name']) ? $this->global->getPosition($rank[$i])['position_name'] : "-";

                    if (empty($vessel[$i])) {
                        $table .= '<tr><td class="text-center" colspan="12">No data available in table</td></tr>';
                    } else {

                        $array_of_service = [
                            "vessel" => $vessel[$i],
                            "flag" => $flag[$i],
                            "salary" => $salary[$i],
                            "position" => $position,
                            "type_vessel" => $type_vessel[$i],
                            "grt_power" => $grt_power[$i],
                            "embarked" => $embarked[$i],
                            "disembarked" => $disembarked[$i],
                            "agency" => $agency[$i],
                            "remarks" => $remarks[$i],
                        ];

                        array_push($array_of_services, $array_of_service);
                    }

                    $count++;
                }

                if (!empty($array_of_services)) {
                    $new_years_of_services = array_column($array_of_services, "disembarked");
                    array_multisort($new_years_of_services, SORT_ASC, $array_of_services);

                    $table = $array_of_services;

                    // foreach ($array_of_services as $key => $arr_of_service) {

                    //     $vessel = $arr_of_service["vessel"] ? $arr_of_service["vessel"] : "-";
                    //     $flag = $arr_of_service["flag"] ? $arr_of_service["flag"] : "-";
                    //     $salary = $arr_of_service["salary"] ? $arr_of_service["salary"] : "-";
                    //     $position = $arr_of_service["position"] ? $arr_of_service["position"] : "-";
                    //     $type_vessel = $arr_of_service["type_vessel"] ? $arr_of_service["type_vessel"] : "-";
                    //     $grt_power = $arr_of_service["grt_power"] ? $arr_of_service["grt_power"] : "-";
                    //     $embarked = $arr_of_service["embarked"] ? $arr_of_service["embarked"] : "-";
                    //     $disembarked = $arr_of_service["disembarked"] ? $arr_of_service["disembarked"] : "-";
                    //     $total_service = $arr_of_service["total_service"] ? $arr_of_service["total_service"] : "-";
                    //     $agency = $arr_of_service["agency"] ? $arr_of_service["agency"] : "-";
                    //     $remarks = $arr_of_service["remarks"] ? $arr_of_service["remarks"] : "-";

                    //     $key++;
                    //     $table .= "
                    //     <tr>
                    //         <td>{$key}</td>
                    //         <td>{$vessel}</td>
                    //         <td>{$flag}</td>
                    //         <td>{$salary}</td>
                    //         <td class=\"font-weight-medium\">{$position}</td>
                    //         <td>{$type_vessel}</td>
                    //         <td>{$grt_power}</td>
                    //         <td>{$embarked}</td>
                    //         <td>{$disembarked}</td>
                    //         <td></td>
                    //         <td>{$agency}</td>
                    //         <td>{$remarks}</td>
                    //     </tr>
                    // ";
                    // }
                }
            } else {
                $table .= '<tr><td class="text-center" colspan="12">No data available in table</td></tr>';
            }
        } else {
            $table .= '<tr><td class="text-center" colspan="12">No data available in table</td></tr>';
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($table));
    }

    public function get_offsigner_vessel_history()
    {
        $code = $this->input->post('code');
        $cmp_code = $code;
        $crew_code = $this->global->getCrew($cmp_code);
        $history = $this->global->getListSeaServiceRecord($crew_code['crew_code']);

        $table = null;

        if ($history) {
            $vessel = json_decode($history['name_of_vessel']);
            $flag = json_decode($history['flag']);
            $salary = json_decode($history['salary']);
            $type_vessel = json_decode($history['type_of_vsl_eng']);
            $grt_power = json_decode($history['grt_power']);
            $embarked = json_decode($history['embarked']);
            $disembarked = json_decode($history['disembarked']);
            $total_service = json_decode($history['total_service']);
            $agency = json_decode($history['agency']);
            $remarks = json_decode($history['remarks']);
            $rank = json_decode($history['rank']);
            // var_dump($rank);
            $count = 1;

            for ($i = 0; $i < count($vessel); $i++) {

                if (empty($vessel[$i])) {
                    $table .= '<tr><td class="text-center" colspan="12">No data available in table</td></tr>';
                } else {
                    $table .= '<tr>';
                    $table .= '<td>' . $count . '</td>';
                    $table .= '<td>' . (!$vessel[$i] ? ' - ' : $vessel[$i]) . '</td>';
                    $table .= '<td>' . (!$flag[$i] ? ' - ' : $flag[$i]) . '</td>';
                    $table .= '<td>' . (!$salary[$i] ? ' - ' : $salary[$i]) . '</td>';
                    $table .= '<td class="font-weight-medium">' . ((!empty($rank)) ? $this->global->getPosition($rank[$i])['position_name'] : "") . '</td>';
                    $table .= '<td>' . (!$type_vessel[$i] ? ' - ' : $type_vessel[$i]) . '</td>';
                    $table .= '<td>' . (!$grt_power[$i] ? ' - ' : $grt_power[$i]) . '</td>';
                    $table .= '<td>' . (!$embarked[$i] ? ' - ' : date('M j, Y', strtotime($embarked[$i]))) . '</td>';
                    $table .= '<td>' . (!$disembarked[$i] ? ' - ' : date('M j, Y', strtotime($disembarked[$i]))) . '</td>';
                    $table .= '<td>' . (!$total_service[$i] ? ' - ' : $total_service[$i]) . '</td>';
                    $table .= '<td>' . (!$agency[$i] ? ' - ' : $agency[$i]) . '</td>';
                    $table .= '<td>' . (!$remarks[$i] ? ' - ' : $remarks[$i]) . '</td>';
                    $table .= '</tr>';
                }

                $count++;
            }
        } else {
            $table .= '<tr><td class="text-center" colspan="12">No data available in table</td></tr>';
        }

        $this->output
            ->set_output($table);
    }

    public function get_cmp_sea_service_record()
    {
        $code = $this->input->post('code');

        $crew_sea_service = $this->global->getSeaServiceRecord($code);
        if ($crew_sea_service) {
            $data = $crew_sea_service;
        } else {
            $cmp_code = $code;
            $crew_code = $this->all_crew->get_crewcode_cmp($cmp_code);
            $data = $this->global->getSeaServiceRecord($crew_code['crew_code']);
        }


        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_applicant_type()
    {
        $code = $this->input->post('code');

        $applicant_type = $this->global->getApplicants($code);

        if ($applicant_type) {
            $data = $applicant_type;
        } else {
            $data = NULL;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_crew_disembark()
    {
        $monitor_code = $this->input->post('monitor_code');

        $crew_cmp = $this->global->getCMP($monitor_code);

        $cmp_code = $crew_cmp['cmp_code'];
        $crew = $this->all_crew->get_crewcode_cmp($cmp_code);

        if ($crew_cmp) {
            $data = $crew_cmp;
        } else {
            $data = NULL;
        }

        if (!empty($crew)) {
            $crew_code = $crew['crew_code'];
            $check_contract = $this->contracts->getCrewContract($crew_code);
            $data['check_if_contract_ends'] = !empty($check_contract) ? FALSE : TRUE; // IF FALSE DI PA TAPOS CONTRACT ELSE TAPOS NA
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function update_sea_service()
    {
        $result = $this->global->update_crew_sea_service();
        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Update Successfully!',
                'text' => 'Your Sea Service Record was successfully updated.'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Error!',
                'text' => 'Please check your input data.'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function check_crew_on_vacation()
    {
        $on_vacation = $this->ex_crew->get_all_on_vacation();
        $onemonth = 0;
        foreach ($on_vacation as $key) {
            //Auto 6months TOC
            $additionalsxty = date('Y-m-d', strtotime("+6 months", strtotime($key['date_updated'])));
            $current_date = date('Y-m-d');

            if ($additionalsxty <= $current_date) {
                $dept = $this->global->getDepartmentById($key['type_of_department']);
                $crew_code = $key['crew_code'];
                $monitor_code = $key['monitor_code'];

                $toc_data = [
                    'crew_code' => $key['crew_code'],
                    'position' => $key['position'],
                    'vessel_assign' => $key['vessel_assign'],
                    'department' => $dept['department_code'],
                    'issued_by' => $this->session->userdata('user_code'),
                    'remarks' => "automatic TOC due to 6 months on vacation.",
                    'date_created' => date('Y-m-d'),
                    'status'    => 1
                ];

                $result = $this->withdrawal_crew->automatic_toc_crew($toc_data);
                if ($result === true) {
                    $update_crew_status = $this->global->updateCrewStatus($monitor_code, 8);
                }
            }
            //1month notif dashboard
            $date_now = date_create(date('Y-m-d'));
            $date_updated = date_create($key['date_updated']);
            $interval =  date_diff($date_now, $date_updated);
            if ($interval->d > 0 && $interval->d <= 30) {
                $onemonth++;
            }
        }

        $data = ['one_month' => $onemonth];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }


    public function get_licenses_by_positions()
    {
        $return_get_licenses = $this->global->getLicensesByPositions();

        $licenses_form = "";
        if ($return_get_licenses) {
            foreach ($return_get_licenses as $licenses) {
                $licenses_form .=
                    "
                        <div class=\"col-md-12\">
                            <div class=\"row\">

                                <div class=\"col-md-1\"></div>

                                <div class=\"col-md-3\">
                                    <div class=\"form-group\">
                                        <label class=\"mb-0 mt-2\" id=\"license_name_{$licenses['id']}\">{$licenses['license_name']}</label>
                                        <input type=\"hidden\" id=\"lebi_{$licenses['id']}\" name=\"lebi[]\" value=\"{$licenses['id']}\"/>
                                    </div>
                                </div>

                                <div class=\"col-md-2\">
                                    <div class=\"form_group\">
                                        <input type=\"text\" class=\"form-control\" id=\"l_grade_{$licenses['id']}\" name=\"l_grade[]\" placeholder=\"GRADE\"/>
                                    </div>
                                </div>

                                <div class=\"col-md-2\">
                                    <div class=\"form_group\">
                                        <input type=\"text\" class=\"form-control\" id=\"l_number_{$licenses['id']}\" name=\"l_number[]\" placeholder=\"NUMBER\"/>
                                    </div>
                                </div>

                                <div class=\"col-md-2\">
                                    <div class=\"form_group\">
                                        <input type=\"date\" class=\"form-control\" id=\"l_date_issued_{$licenses['id']}\" name=\"l_date_issued[]\" placeholder=\"DATE ISSUED\"/>
                                    </div>
                                </div>

                                <div class=\"col-md-2\">
                                    <div class=\"form_group\">
                                        <input type=\"date\" class=\"form-control\" id=\"l_expiry_date_{$licenses['id']}\" name=\"l_expiry_date[]\" placeholder=\"EXPIRY DATE\"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
            }
        } else {
            $licenses_form .=
                "
                    <div class=\"col-md-12\">
                        <center>
                            <em class=\"text-muted font-20\">Please select first your desire <span class=\"text-underline\">\"Rank\"</span> to display your training certification requirements.</em>
                        </center>
                    </div>
                ";
        }

        $data['licenses_form'] = $licenses_form;

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }


    public function check_technical_form()
    {
        $applicant_code = $this->input->get('applicant_code');

        $return_check_tech_form = $this->global->checkTechForm($applicant_code);

        $data['check_tech_form'] = !is_null($return_check_tech_form['interview_form']) && !empty($return_check_tech_form['interview_form']) ? 1 : 0;

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }


    public function get_crew_offsigner()
    {
        $insginer_mnt_code = $this->input->get("monitor_code");

        $offsigner_data = $this->crew_management->getOffSignerNoInSigner($insginer_mnt_code);

        $data = [];

        foreach ($offsigner_data as $offsigner) {

            $data[] = [
                'id' => $offsigner['monitor_code'],
                'text' => $offsigner['full_name']
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_toc_reasons()
    {
        $result = $this->global->get_toc_reasons();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}

/* End of file Global_function.php */
