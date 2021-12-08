<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_backup_db extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function archiveDatabase($db_name){

        $db_archive = $this->load->database('archive', TRUE);

        $user_code = $this->session->userdata('user_code');
        $user_code = $this->global->ecdc('dc', $user_code);

        $data = [
            'usercode' => $user_code,
            'file_name' => $db_name,
            'file_type' => "SQL",
            'date_created' => date('Y-m-d H:i:s'),
        ];

        $db_archive->insert('db_archive', $data);
        return ($this->db->affected_rows() != 1) ? true : false;
    }

    function get_archived_count(){
        $db_archive = $this->load->database('archive', TRUE);
        $query = $db_archive->get("db_archive");
        return $query->num_rows();
    }

    function get_current_page_records($limit, $start){

        $db_archive = $this->load->database('archive', TRUE);
        $db_archive->limit($limit, $start);
        $query = $db_archive->get("db_archive");

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    function deleteArchivedDB($id){
        $db_archive = $this->load->database('archive', TRUE);
        $db_archive->where('id', $id)->delete('db_archive');
        if ($db_archive->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function archive_evaluation_sheet($data)
    {
        $db_archive = $this->load->database('archive', TRUE);

        $arc_data = [
            'applicant_code' => $data['applicant_code'],
            'crew_code' => $data['crew_code'],
            'total_board' => $data['total_board'],
            'same_ship' => $data['same_ship'],
            'short_board' => $data['short_board'],
            'mixed_crew' => $data['mixed_crew'],
            'interview' => $data['interview'],
            'details' => $data['details'],
            'scores' => $data['scores'],
            'additional_detail' => $data['additional_detail'],
            'additional_score' => $data['additional_score'],
            'substract_detail' => $data['substract_detail'],
            'substract_score' => $data['substract_score'],
            'final_evaluation' => $data['final_evaluation'],
            'assessed_by' => $data['assessed_by'],
            'date_created' => date('Y-m-d H:i:s'),
            'status' => 1,
        ];
        $db_archive->insert('arc_evaluation_sheet', $arc_data);
    }

    function archive_shipboard_application($applicant_code)
    {
        $db_archive = $this->load->database('archive', TRUE);

        $applicant = $this->db->select('applicant_code,crew_code,type_applicant,position_first,position_second,approved_position,nat_result,assign_vessel,
        source,recommend_by,remark,assessed_by,second_assessed_by,date_available,status')->where('applicant_code', $applicant_code)->get('applicants')->row_array();
        $info = $this->db->select('applicant_code,crew_code,first_name,middle_name,last_name,suffix,birth_date,birth_place,email_address,telephone_number,mobile_number,
        civil_status,street_address,barangay,city,region,country,zip_code,provincial,religion,nationality,height,weight,sss_no,tin_number,philhealth_no,pag_ibig_no,
        status')->where('applicant_code', $applicant_code)->get('ac_personal_info')->row_array();
        $kin = $this->db->select('applicant_code,crew_code,spouse_name,occupation,no_of_children,name_of_children,birthday_of_children,contact_of_children,
        father_name,mother_name,address,status')->where('applicant_code', $applicant_code)->get('ac_next_of_kin')->row_array();
        $education = $this->db->select('applicant_code,crew_code,course,school,school_address,inclusive_years,status')->where('applicant_code', $applicant_code)->get('ac_educational_attainment')->row_array();
        $gears = $this->db->select('applicant_code,crew_code,cover_all,winter_jacket,shoes,winter_boots,status')->where('applicant_code', $applicant_code)->get('ac_working_gears')->row_array();
        $licenses = $this->db->select('applicant_code,crew_code,lebi,grade,number,date_issued,expiry_date,cop_certificates,status')->where('applicant_code', $applicant_code)->get('ac_licenses_endorsement_book_id')->row_array();
        $certificates = $this->db->select('applicant_code,crew_code,certificates,number,date_issued,issued_by,with_cop_number,status')->where('applicant_code', $applicant_code)->get('ac_training_certificates')->row_array();
        $sea_service= $this->db->select('applicant_code,crew_code,name_of_vessel,flag,salary,`rank`,type_of_vsl_eng,grt_power,embarked,disembarked,
        total_service,agency,remarks,status')->where('applicant_code', $applicant_code)->get('ac_sea_service_record')->row_array();

        $applicant['date_created'] = date('Y-m-d H:i:s');
        $info['date_created'] = date('Y-m-d H:i:s');
        $kin['date_created'] = date('Y-m-d H:i:s');
        $education['date_created'] = date('Y-m-d H:i:s');
        $gears['date_created'] = date('Y-m-d H:i:s');
        $licenses['date_created'] = date('Y-m-d H:i:s');
        $certificates['date_created'] = date('Y-m-d H:i:s');
        $sea_service['date_created'] = date('Y-m-d H:i:s');

        $db_archive->insert('arc_applicants', $applicant);
        $db_archive->insert('arc_personal_info', $info);
        $db_archive->insert('arc_next_of_kin', $kin);
        $db_archive->insert('arc_educational_attainment', $education);
        $db_archive->insert('arc_working_gears', $gears);
        $db_archive->insert('arc_licenses_endorsement_book_id', $licenses);
        $db_archive->insert('arc_training_certificates', $certificates);
        $db_archive->insert('arc_sea_service_record', $sea_service);
    }

    function archive_general_interview($general_interview)
    {
        $db_archive = $this->load->database('archive', TRUE);

        $general_interview_data = [
            'applicant_code' => $general_interview['applicant_code'],
            'scores' => $general_interview['scores'],
            'total_score' => $general_interview['total_score'],
            'final_result' => $general_interview['final_result'],
            'remarks' => $general_interview['remarks'],
            'final_remark' => $general_interview['final_remark'],
            'assessed_by' => $general_interview['assessed_by'],
            'date_created' => date('Y-m-d H:i:s')
        ];

        $db_archive->insert('arc_interview_general', $general_interview_data);
    }
    function archive_technical_interview($technical_interview)
    {
        $db_archive = $this->load->database('archive', TRUE);

        $tech_interview = [
            'applicant_code' => $technical_interview['applicant_code'],
            'scores' => $technical_interview['scores'],
            'total_score' => $technical_interview['total_score'],
            'final_result' => $technical_interview['final_result'],
            'remarks' => $technical_interview['remarks'],
            'final_remark' => $technical_interview['final_remark'],
            'assessed_by' => $technical_interview['assessed_by'],
            'date_created' => date('Y-m-d H:i:s')
        ];

        $db_archive->insert('arc_interview_technical', $tech_interview);
    }
    function archive_newly_employed($new_employed_crew)
    {
        $db_archive = $this->load->database('archive', TRUE);

        $employed_crew = [
            'applicant_code' => $new_employed_crew['applicant_code'],
            'check_point' => $new_employed_crew['check_point'],
            'service_record_ttl' => $new_employed_crew['service_record_ttl'],
            'service_record_rank' => $new_employed_crew['service_record_rank'],
            'previous_manning_company' => $new_employed_crew['previous_manning_company'],
            'reputation' => $new_employed_crew['reputation'],
            'transfer' =>   $new_employed_crew['transfer'],
            'carrier' => $new_employed_crew['carrier'],
            'experience_with_korean_crew' => $new_employed_crew['experience_with_korean_crew'],
            'history_of_past_injuries' => $new_employed_crew['history_of_past_injuries'],
            'history_of_past_diseases' => $new_employed_crew['history_of_past_diseases'],
            'leave_of_absence' => $new_employed_crew['leave_of_absence'],
            'short_contract' => $new_employed_crew['short_contract'],
            'appearance' => $new_employed_crew['appearance'],
            'first_interview_result' => $new_employed_crew['first_interview_result'],
            'second_interview_result' => $new_employed_crew['second_interview_result'],
            'assessed_by' => $new_employed_crew['assessed_by'],
            'date_created' => date('Y-m-d H:i:s')
        ];

        $db_archive->insert('arc_form_newly_employed_crew', $employed_crew);
    }
    function archive_interview_sheet($interview_sheet)
    {
        $db_archive = $this->load->database('archive', TRUE);

        $interview_sheet_data = [
            'applicant_code' => $interview_sheet['applicant_code'],
            'req_no_crew' => $interview_sheet['req_no_crew'],
            'present_no_crew' => $interview_sheet['present_no_crew'],
            'excess_shortage' => $interview_sheet['excess_shortage'],
            'chinese_name' => $interview_sheet['chinese_name'],
            'korean_name' => $interview_sheet['korean_name'],
            'kind_coc' => $interview_sheet['kind_coc'],
            // 'position_last_vessel' => $this->input->post(),
            'exp_analysis_vt' => $interview_sheet['exp_analysis_vt'],
            'age_limit' => $interview_sheet['age_limit'],
            'license_certification' => $interview_sheet['license_certification'],
            'physical_exam' => $interview_sheet['physical_exam'],
            'ability_eng' => $interview_sheet['ability_eng'],
            'assess_prev_company' => $interview_sheet['assess_prev_company'],
            'seniority' => $interview_sheet['seniority'],
            'date_created' => date('Y-m-d H:i:s')
        ];

        $db_archive->insert('arc_interview_sheet', $interview_sheet_data);
    }
    
    function backup_reports($type, $action_by)
    {
        $db_archive = $this->load->database('archive', TRUE);

        $report_logs = [
            'report_type' => $type,
            'action_by'   => $this->global->ecdc('dc', $action_by),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $db_archive->insert('report_logs', $report_logs);
    }

    function get_cmp_report_logs($type)
    {
        $db_archive = $this->load->database('archive', TRUE);
        return $db_archive->select('*')->from('report_logs')->like('report_type', $type)->get()->result_array();
    }
}