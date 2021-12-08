<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_applicant_interview extends CI_Model
{
    function getApplicantInterview($params = array())
    {
        $this->db->select("
            a.applicant_code,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            a.date_available,
            a.status,
            a.nat_result,
            a.assign_vessel,
            acpi.height,
            acpi.weight,
            ap1.position_code position_first,
            ap2.position_code position_second,
            ap1.position_name position_name1,
            ap2.position_name position_name2,
            ac.description city,
            ap.description province,
            aces.scores,
            aces.additional_score,
            aces.substract_score,
            aces.interview,
            ua.full_name f_assessor_name
        ");
        $this->db->from('applicants a');
        $this->db->join('ac_personal_info acpi', 'a.applicant_code = acpi.applicant_code');

        $this->db->join('a_city ac', 'acpi.city = ac.id', 'LEFT');
        $this->db->join('a_province ap', 'acpi.region = ap.id', 'LEFT');
        $this->db->join('a_position ap1', 'a.position_first = ap1.id', 'LEFT');
        $this->db->join('a_position ap2', 'a.position_second = ap2.id', 'LEFT');
        $this->db->join('ac_evaluation_sheet aces', 'a.applicant_code = aces.applicant_code', 'LEFT');
        $this->db->join("user_account ua", "a.assessed_by = ua.user_code", "LEFT");

        $this->db->where('a.status', "2");
        $this->db->or_where('a.status', "3");

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
            $this->db->where('a.status', '1');
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

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->order_by('a.date_created', 'DESC');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function getApplicantInterviewReport($params)
    {
        $this->db->select("
            a.applicant_code,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            a.date_available,
            a.status,
            a.date_available,
            a.nat_result,
            acpi.height,
            acpi.weight,
            acpi.nationality,
            acpi.birth_date,
            a.assign_vessel,
            ap1.position_code position_first,
            ap2.position_code position_second,
            ap1.position_name position_name1,
            ap2.position_name position_name2,
            ap3.position_name approved_position,
            ac.description city,
            acpi.civil_status,
            ap.description province,
            av.vsl_name,
            tv.tv_name,
            ais.*
        ");
        $this->db->from('applicants a');
        $this->db->join('ac_personal_info acpi', 'a.applicant_code = acpi.applicant_code');

        $this->db->join('a_city ac', 'acpi.city = ac.id', 'LEFT');
        $this->db->join('a_region ap', 'acpi.region = ap.id', 'LEFT');
        $this->db->join('a_position ap1', 'a.position_first = ap1.id', 'LEFT');
        $this->db->join('a_position ap2', 'a.position_second = ap2.id', 'LEFT');
        $this->db->join('a_position ap3', 'a.approved_position = ap3.id', 'LEFT');
        $this->db->join('a_vessels av', 'a.assign_vessel = av.id', 'LEFT');
        $this->db->join('a_type_of_vessel tv', 'av.vsl_code = tv.tv_code', 'LEFT');
        $this->db->join('ac_interview_sheet ais', 'a.applicant_code = ais.applicant_code', 'LEFT');

        if ($params) {
            $this->db->where('a.applicant_code', $params);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }



    function getEvaluationSheet($applicant_code)
    {
        return $this->db->where('applicant_code', $applicant_code)->get('ac_evaluation_sheet')->row_array();
    }

    function getInterviewGeneralValue($applicant_code)
    {
        return $this->db->where('applicant_code', $applicant_code)->get('ac_interview_general')->row_array();
    }

    function saveEditShipboardApplication()
    {
        $applicant_code = $this->input->post('e_applicant_code');
        $crew_code = $this->input->post('e_crew_code');
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

            $return = $this->all_crew->checkAcFiles($applicant_code);

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

        $applicants = [
            'type_applicant' => $this->input->post('s_type_of_crew'),
            'position_first' => $this->input->post('e_first_position'),
            'position_second' => !$this->input->post('e_second_position') ? 0 : $this->input->post('e_second_position'),
            'assign_vessel' => $this->input->post('e_tentative_vessel'),
            'date_available' => date('Y-m-d', strtotime($this->input->post('e_date_available'))),
            'source' => $this->input->post('e_source_location'),
            'recommend_by' => $this->input->post('e_recommended_name'),
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $personal_info = [
            'first_name' => strtoupper($this->input->post('e_first_name')),
            'middle_name' => strtoupper($this->input->post('e_middle_name')),
            'last_name' => strtoupper($this->input->post('e_last_name')),
            'suffix' => $this->input->post('e_suffix'),
            'birth_date' => date('Y-m-d', strtotime($this->input->post('e_birth_date'))),
            'birth_place' => $this->input->post('e_birth_place'),
            'civil_status' => $this->input->post('e_civil_status'),
            'email_address' => $this->input->post('e_email_address'),
            'telephone_number' => $this->input->post('e_telephone_number'),
            'mobile_number' => $this->input->post('e_mobile_number'),
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
            'religion' => $this->input->post('e_religion'),
            'nationality' => $this->input->post('e_nationality'),
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $next_kin = [
            'spouse_name' => $this->input->post('e_spouse_name'),
            'occupation' => $this->input->post('e_occupation'),
            'no_of_children' => $this->input->post('e_no_of_children'),
            'name_of_children' => json_encode($this->input->post('e_full_name_child')),
            'birthday_of_children' => json_encode($this->input->post('e_birth_date_child')),
            'contact_of_children' => json_encode($this->input->post('e_mobile_no_child')),
            'father_name' => $this->input->post('e_father_name'),
            'mother_name' => $this->input->post('e_mother_name'),
            'address' => $this->input->post('e_kin_address'),
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $inclusive_years = [$this->input->post('e_inclusive_years_from'), $this->input->post('e_inclusive_years_to')];

        $education = [
            'course' => $this->input->post('e_course'),
            'school' => $this->input->post('e_school_name'),
            'school_address' => $this->input->post('e_school_address'),
            'inclusive_years' => json_encode($inclusive_years),
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $working_gears = [
            'cover_all' => $this->input->post('e_cover_all'),
            'winter_jacket' => $this->input->post('e_winter_jacket'),
            'shoes' => $this->input->post('e_shoes'),
            'winter_boots' => $this->input->post('e_winter_boots'),
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $licenses = [
            'lebi' => json_encode($this->input->post('lebi')),
            'grade' => json_encode($this->input->post('l_grade')),
            'number' => json_encode($this->input->post('l_number')),
            'date_issued' => json_encode($this->input->post('l_date_issued')),
            'expiry_date' => json_encode($this->input->post('l_expiry_date')),
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $trainings = [
            'certificates' => json_encode($this->input->post('t_id')),
            'number' => json_encode($this->input->post('t_number')),
            'date_issued' => json_encode($this->input->post('t_date_issued')),
            'expiration_date' => json_encode($this->input->post('t_date_expired')),
            'issued_by' => json_encode($this->input->post('t_issued_by')),
            'with_cop_number' => json_encode($this->input->post('t_cop_number')),
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $sea_service = [
            'name_of_vessel' => json_encode($this->input->post('s_vessel_name')),
            'flag' => json_encode($this->input->post('s_flag')),
            'salary' => json_encode($this->input->post('s_salary')),
            'rank' => json_encode($this->input->post('s_rank')),
            'type_of_vsl_eng' => json_encode($this->input->post('s_vsl_engn')),
            'grt_power' => json_encode($this->input->post('s_grt_power')),
            'embarked' => json_encode($this->input->post('s_embarked')),
            'disembarked' => json_encode($this->input->post('s_disembarked')),
            'total_service' => json_encode($this->input->post('s_total_service')),
            'agency' => json_encode($this->input->post('s_agency')),
            'remarks' => json_encode($this->input->post('s_remarks')),
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $this->m_backup_db->archive_shipboard_application($applicant_code);

        // $this->m_backup_db->archive_shipboard_application($applicant_code);

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->where('crew_code', $crew_code)->or_where('applicant_code', $applicant_code)->update('applicants', $applicants);
        $this->db->where('crew_code', $crew_code)->or_where('applicant_code', $applicant_code)->update('ac_personal_info', $personal_info);
        $this->db->where('crew_code', $crew_code)->or_where('applicant_code', $applicant_code)->update('ac_next_of_kin', $next_kin);
        $this->db->where('crew_code', $crew_code)->or_where('applicant_code', $applicant_code)->update('ac_educational_attainment', $education);
        $this->db->where('crew_code', $crew_code)->or_where('applicant_code', $applicant_code)->update('ac_working_gears', $working_gears);
        $this->db->where('crew_code', $crew_code)->or_where('applicant_code', $applicant_code)->update('ac_licenses_endorsement_book_id', $licenses);
        $this->db->where('crew_code', $crew_code)->or_where('applicant_code', $applicant_code)->update('ac_training_certificates', $trainings);
        $this->db->where('crew_code', $crew_code)->or_where('applicant_code', $applicant_code)->update('ac_sea_service_record', $sea_service);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function saveEvaluationForm()
    {
        $applicant_code = $this->input->post('ef_applicant_code');
        $crew_code = $this->input->post('ef_crew_code');

        $applicant = [
            'approved_position' => $this->input->post('ef_rank')
        ];

        $evaluation = [
            'applicant_code' => $applicant_code,
            'crew_code' => $crew_code,
            'total_board' => $this->input->post('ef_total_board'),
            'same_ship' => $this->input->post('ef_same_ship'),
            'short_board' => $this->input->post('ef_short_board'),
            'mixed_crew' => $this->input->post('ef_mixed_crew'),
            'interview' => $this->input->post('ef_interview'),
            'details' => json_encode($this->input->post('detail')),
            'scores' => json_encode($this->input->post('score')),
            'additional_detail' => $this->input->post('additional_point_detail'),
            'additional_score' => $this->input->post('addtional_point_score'),
            'substract_detail' => $this->input->post('substract_point_detail'),
            'substract_score' => $this->input->post('substract_point_score'),
            'final_evaluation' => $this->input->post('eval_final'),
            'assessed_by' => $this->global->ecdc('dc', $this->session->userdata('user_code'))
        ];

        $evaluation_data = $this->db->where('applicant_code', $applicant_code)->get('ac_evaluation_sheet');

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        if ($evaluation_data->num_rows() > 0) {

            $evaluation['date_updated'] = date('Y-m-d H:i:s');
            $eval_data_row = $evaluation_data->row_array();
            $this->db->where('applicant_code', $applicant_code)->update('ac_evaluation_sheet', $evaluation);
            $this->m_backup_db->archive_evaluation_sheet($eval_data_row);
        } else {

            $evaluation = [
                'applicant_code' => $applicant_code,
                'crew_code' => $crew_code,
                'total_board' => $this->input->post('ef_total_board'),
                'same_ship' => $this->input->post('ef_same_ship'),
                'short_board' => $this->input->post('ef_short_board'),
                'mixed_crew' => $this->input->post('ef_mixed_crew'),
                'interview' => $this->input->post('ef_interview'),
                'details' => json_encode($this->input->post('detail')),
                'scores' => json_encode($this->input->post('score')),
                'additional_detail' => $this->input->post('additional_point_detail'),
                'additional_score' => $this->input->post('addtional_point_score'),
                'substract_detail' => $this->input->post('substract_point_detail'),
                'substract_score' => $this->input->post('substract_point_score'),
                'final_evaluation' => $this->input->post('eval_final'),
                'assessed_by' => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                'date_created'  => date('Y-m-d H:i:s')
            ];

            $this->m_backup_db->archive_evaluation_sheet($evaluation);
            $this->db->insert('ac_evaluation_sheet', $evaluation);
        }

        if ($this->input->post('eval_final') == "FAILED") {

            $this->db->where('applicant_code',  $applicant_code)->update('applicants', $applicant);
            $this->global->applicantNotQualified($applicant_code, "Evaluation Final Score Failed");
            $this->global->updateApplicantStatus($applicant_code, 8);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return "failed";
            }
        } else {

            $this->db->where('applicant_code',  $applicant_code)->update('applicants', $applicant);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
    }

    function saveGeneralInterview()
    {
        $applicant_code  = $this->input->post('gi_applicant_code');
        $crew_code = $this->input->post('gi_crew_code');

        $general_interview = [
            'applicant_code' => $applicant_code,
            'crew_code' => $crew_code,
            'scores' => json_encode($this->input->post('score_general')),
            'total_score' => $this->input->post('total_interview_general'),
            'final_result' => $this->input->post('final_interview_general'),
            'remarks' => json_encode($this->input->post('remarks_general')),
            'final_remark' => $this->input->post('final_remark_general'),
            'assessed_by' => $this->global->ecdc('dc', $this->session->userdata('user_code'))
        ];

        $check_general_interview = $this->checkInterviewGeneral($applicant_code, $crew_code);

        if ($this->input->post('final_interview_general') == "FAILED") {

            if ($check_general_interview->num_rows() > 0) {
                $general_interview['date_updated'] = date('Y-m-d H:i:s');
                $this->updateGeneralInterviewData($general_interview, $applicant_code, $crew_code);
                // $this->m_backup_db->archive_general_interview($check_general_interview->row_array());
            } else {
                $general_interview['date_created'] = date('Y-m-d H:i:s');
                $this->saveGeneralInterviewData($general_interview);
            }

            $this->global->applicantNotQualified($applicant_code, "Final Interview Final Score Failed");
            $update = $this->global->updateApplicantStatus($applicant_code, 8);
            if ($update == true) {
                return "failed";
            } else {
                return false;
            }
        } else {
            if ($check_general_interview->num_rows() > 0) {
                $general_interview['date_updated'] = date('Y-m-d H:i:s');
                return $this->updateGeneralInterviewData($general_interview, $applicant_code, $crew_code);
                // $this->m_backup_db->archive_general_interview($check_general_interview->row_array());
            } else {
                $general_interview['date_created'] = date('Y-m-d H:i:s');
                return $this->saveGeneralInterviewData($general_interview);
            }
        }
    }

    function saveTechnicalInterview()
    {
        $applicant_code = $this->input->post('ti_applicant_code');
        $crew_code = $this->input->post('ti_crew_code');

        $tech_interview = [
            'applicant_code' => $applicant_code,
            'crew_code' => $crew_code,
            'scores' => json_encode($this->input->post('t_score_technical')),
            'total_score' => $this->input->post('total_interview_technical'),
            'final_result' => $this->input->post('final_interview_technical'),
            'remarks' => json_encode($this->input->post('t_remarks_technical')),
            'final_remark' => $this->input->post('final_remark_technical'),
            'assessed_by' => $this->global->ecdc('dc', $this->session->userdata('user_code'))
        ];
        $check_technical_interview = $this->checkTechnicalInterview($applicant_code, $crew_code);

        if ($this->input->post('final_interview_technical') == "FAILED") {

            if ($check_technical_interview->num_rows() > 0) {
                $tech_interview['date_updated'] = date('Y-m-d H:i:s');
                $this->updateTechnicalInterviewData($tech_interview, $applicant_code, $crew_code);
                // $this->m_backup_db->archive_technical_interview($check_technical_interview->row_array());
            } else {
                $tech_interview['date_created'] = date('Y-m-d H:i:s');
                $this->saveTechnicalInterviewData($tech_interview);
            }
            $this->global->applicantNotQualified($applicant_code, "Technical Interview Final Score Failed");
            $update = $this->global->updateApplicantStatus($applicant_code, 8);
            if ($update == true) {
                return "failed";
            } else {
                return false;
            }
        } else {

            if ($check_technical_interview->num_rows() > 0) {
                $tech_interview['date_updated'] = date('Y-m-d H:i:s');
                return $this->updateTechnicalInterviewData($tech_interview, $applicant_code, $crew_code);
                // $this->m_backup_db->archive_technical_interview($check_technical_interview->row_array());
            } else {
                $tech_interview['date_created'] = date('Y-m-d H:i:s');

                return $this->saveTechnicalInterviewData($tech_interview);
            }
        }
    }

    function saveEmployedCrewForm()
    {
        $applicant_code = $this->input->post('ec_applicant_code');
        $crew_code = $this->input->post('ec_crew_code');

        $employed_crew = [
            'applicant_code' => $applicant_code,
            'crew_code' => $crew_code,
            'check_point' => $this->input->post('ec_check_point'),
            'service_record_ttl' => $this->input->post('ec_service_record_ttl'),
            'service_record_rank' => $this->input->post('ec_service_record_rank'),
            'previous_manning_company' => $this->input->post('ec_previous_manning_company'),
            'reputation' => $this->input->post('ec_reputation'),
            'transfer' => $this->input->post('ec_transfer'),
            'carrier' => $this->input->post('ec_carrier'),
            'experience_with_korean_crew' => $this->input->post('ec_exp_korean_crew'),
            'history_of_past_injuries' => $this->input->post('ec_past_injuries'),
            'history_of_past_diseases' => $this->input->post('ec_past_disease'),
            'leave_of_absence' => $this->input->post('ec_leave_of_absence'),
            'short_contract' => $this->input->post('ec_short_contract'),
            'appearance' => $this->input->post('ec_appearance'),
            'first_interview_result' => $this->input->post('ec_first_interview_result'),
            'second_interview_result' => $this->input->post('ec_second_interview_result'),
            'assessed_by' => $this->global->ecdc('dc', $this->session->userdata('user_code'))
        ];

        $check_employed_crew = $this->checkCrewForm($applicant_code, $crew_code);

        if ($check_employed_crew->num_rows() > 0) {
            $employed_crew['date_updated'] = date('Y-m-d H:i:s');
            return $this->updateCrewFormData($employed_crew, $applicant_code, $crew_code);
            // $this->m_backup_db->archive_newly_employed($check_employed_crew->row_array());
        } else {
            $employed_crew['date_created'] = date('Y-m-d H:i:s');
            return $this->saveCrewFormData($employed_crew);
        }
    }

    function saveInterviewSheet()
    {
        $applicant_code = $this->input->post('is_applicant_code');
        $crew_code = $this->input->post('is_crew_code');

        $interview_sheet = [
            'applicant_code' => $applicant_code,
            'crew_code' => $crew_code,
            'req_no_crew' => $this->input->post('is_required_no_of_crew'),
            'present_no_crew' => $this->input->post('is_present_no_of_crew'),
            'excess_shortage' => $this->input->post('is_crew_excess_or_shortage'),
            'chinese_name' => $this->input->post('is_applicant_name_one'),
            'korean_name' => $this->input->post('is_applicant_name_two'),
            'kind_coc' => $this->input->post('is_kind_of_coc'),
            // 'position_last_vessel' => $this->input->post(),
            'exp_analysis_vt' => $this->input->post('is_eavt'),
            'age_limit' => $this->input->post('is_age_limitation'),
            'license_certification' => $this->input->post('is_license_cert'),
            'physical_exam' => $this->input->post('is_physical_exam'),
            'ability_eng' => $this->input->post('is_ability_english'),
            'assess_prev_company' => $this->input->post('is_previous_company'),
            'seniority' => $this->input->post('is_related_seniority'),
        ];

        if ($this->input->post('is_first_decision_app')) {
            $interview_sheet['first_assessor'] = $this->global->ecdc('dc', $this->session->userdata('user_code'));
            $interview_sheet['first_decision'] = $this->input->post('is_first_decision_app');
            $interview_sheet['first_remarks'] = $this->input->post('is_first_remark');
        }

        if ($this->input->post('is_second_assessor_app')) {
            $interview_sheet['second_assessor'] = $this->global->ecdc('dc', $this->session->userdata('user_code'));
            $interview_sheet['second_decision'] = $this->input->post('is_second_assessor_app');
            $interview_sheet['second_remarks'] = $this->input->post('is_second_remark');
        }

        if ($this->input->post('is_final_assessor_app')) {
            $interview_sheet['final_assessor'] = $this->input->post('is_final_name_assessor');
            $interview_sheet['final_decision'] = $this->input->post('is_final_assessor_app');
            $interview_sheet['final_assessor_user'] = $this->global->ecdc('dc', $this->session->userdata('user_code'));
            $interview_sheet['final_remarks'] = $this->input->post('is_final_remark');
        }

        $check_interview_sheet = $this->checkIfHasIntSheet($applicant_code, $crew_code);

        if ($this->input->post('is_first_decision_app') == 2 || $this->input->post('is_second_assessor_app') == 2 || $this->input->post('is_final_assessor_app') == 2) {
            $this->global->applicantNotQualified($applicant_code, "Interview Sheet Had 1 Failed Score");
            $update = $this->global->updateApplicantStatus($applicant_code, 8);

            if ($check_interview_sheet->num_rows()) {
                $interview_sheet['date_update'] = date('Y-m-d H:i:s');
                $this->updateInterviewSheetData($interview_sheet, $applicant_code, $crew_code);
                // $this->m_backup_db->archive_interview_sheet($check_interview_sheet->row_array());
            } else {
                $interview_sheet['date_created'] = date('Y-m-d H:i:s');
                $return = $this->saveInterviewSheetData($interview_sheet);
            }

            if ($update == true) {
                return "failed";
            } else {
                return false;
            }
        } else {

            if ($check_interview_sheet->num_rows()) {
                $interview_sheet['date_update'] = date('Y-m-d H:i:s');
                $return_update = $this->updateInterviewSheetData($interview_sheet, $applicant_code, $crew_code);
                // $this->m_backup_db->archive_interview_sheet($check_interview_sheet->row_array());
                if ($return_update) {
                    if ($this->input->post('is_status') === "2" || $this->input->post('is_status') === "3") {
                        $score_crew = $this->global->interviewSheetScore($applicant_code, $this->input->post('is_status'));
                        if ($score_crew === true) {
                            $this->updateApplicantStatus($applicant_code, $crew_code, '3');
                        }
                    }
                    return true;
                } else {
                    return false;
                }
            } else {
                $interview_sheet['date_created'] = date('Y-m-d H:i:s');
                $return = $this->saveInterviewSheetData($interview_sheet);
                if ($return) {
                    if ($this->input->post('is_status') === "2" || $this->input->post('is_status') === "3") {
                        $score_crew = $this->global->interviewSheetScore($applicant_code, $this->input->post('is_status'));
                        if ($score_crew === true) {
                            $this->updateApplicantStatus($applicant_code, $crew_code, '3');
                        }
                    }
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    // GENERAL INTERVIEW
    function checkInterviewGeneral($applicant_code, $crew_code)
    {

        if (!empty($applicant_code)) {
            $this->db->where('applicant_code', $applicant_code);
        }
        if (!empty($crew_code)) {
            $this->db->where('crew_code', $crew_code);
        }


        return $this->db->get('ac_interview_general');
    }

    function saveGeneralInterviewData($general_interview_data)
    {
        $this->db->insert('ac_interview_general', $general_interview_data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updateGeneralInterviewData($general_interview_data, $applicant_code, $crew_code)
    {
        if (!empty($applicant_code)) {
            $this->db->where('applicant_code', $applicant_code);
        }
        if (!empty($crew_code)) {
            $this->db->where('crew_code', $crew_code);
        }

        $this->db->update('ac_interview_general', $general_interview_data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // END

    // EMPLOYEE CREW
    function checkCrewForm($applicant_code, $crew_code)
    {

        if (!empty($applicant_code)) {
            $this->db->where('applicant_code', $applicant_code);
        }
        if (!empty($crew_code)) {
            $this->db->where('crew_code', $crew_code);
        }


        return $this->db->get('ac_form_newly_employed_crew');
    }

    function saveCrewFormData($employed_crew_data)
    {
        $this->db->insert('ac_form_newly_employed_crew', $employed_crew_data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updateCrewFormData($general_interview_data, $applicant_code, $crew_code)
    {
        if (!empty($applicant_code)) {
            $this->db->where('applicant_code', $applicant_code);
        }
        if (!empty($crew_code)) {
            $this->db->where('crew_code', $crew_code);
        }

        $this->db->update('ac_form_newly_employed_crew', $general_interview_data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // END

    // INTERVIEW SHEET
    function checkIfHasIntSheet($applicant_code, $crew_code)
    {

        if (!empty($applicant_code)) {
            $this->db->where('applicant_code', $applicant_code);
        }
        if (!empty($crew_code)) {
            $this->db->where('crew_code', $crew_code);
        }


        return $this->db->get('ac_interview_sheet');
    }

    function saveInterviewSheetData($interview_sheet_data)
    {
        $this->db->insert('ac_interview_sheet', $interview_sheet_data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updateApplicantStatus($applicant_code, $crew_code, $status)
    {
        if (!empty($applicant_code)) {
            $this->db->where('applicant_code', $applicant_code);
        }
        if (!empty($crew_code)) {
            $this->db->where('crew_code', $crew_code);
        }

        $this->db->set("status", $status);
        $this->db->update('applicants');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updateInterviewSheetData($interview_sheet, $applicant_code, $crew_code)
    {
        if (!empty($applicant_code)) {
            $this->db->where('applicant_code', $applicant_code);
        }
        if (!empty($crew_code)) {
            $this->db->where('crew_code', $crew_code);
        }

        $this->db->update('ac_interview_sheet', $interview_sheet);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // END

    // TECHNICAL INTERVIEW

    function checkTechnicalInterview($applicant_code, $crew_code)
    {

        if (!empty($applicant_code)) {
            $this->db->where('applicant_code', $applicant_code);
        }
        if (!empty($crew_code)) {
            $this->db->where('crew_code', $crew_code);
        }


        return $this->db->get('ac_interview_technical');
    }

    function saveTechnicalInterviewData($tech_interview_data)
    {
        $this->db->insert('ac_interview_technical', $tech_interview_data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updateTechnicalInterviewData($interview_sheet, $applicant_code, $crew_code)
    {
        if (!empty($applicant_code)) {
            $this->db->where('applicant_code', $applicant_code);
        }
        if (!empty($crew_code)) {
            $this->db->where('crew_code', $crew_code);
        }

        $this->db->update('ac_interview_technical', $interview_sheet);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // END
}

/* End of file M_applicant_interview.php */
