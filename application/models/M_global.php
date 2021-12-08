<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_global extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function generateID($prefix)
    {
        $m = date('my');
        $db_payroll = $this->load->database('payroll', TRUE);

        if ($prefix === 'APP') {
            $last_id = $this->db->order_by('id', 'DESC')->limit(1)->get('applicants');
        } elseif ($prefix === 'USR') {
            $last_id = $this->db->order_by('id', 'DESC')->limit(1)->get('user_account');
        } elseif ($prefix === 'CRT') {
            $last_id = $this->db->order_by('id', 'DESC')->limit(1)->get('crew_poea');
        } elseif ($prefix === 'MLC') {
            $last_id = $this->db->order_by('id', 'DESC')->limit(1)->get('crew_mlc');
        } elseif ($prefix === 'MD') {
            $last_id = $this->db->order_by('id', 'DESC')->limit(1)->get('crew_medical');
        } elseif ($prefix === 'FLT') {
            $last_id = $this->db->order_by('id', 'DESC')->limit(1)->get('crew_flight');
        } elseif ($prefix === 'MNT') {
            $last_id = $this->db->order_by('id', 'DESC')->limit(1)->get('crews');
        } elseif ($prefix === 'CMP') {
            $last_id = $this->db->order_by('id', 'DESC')->limit(1)->get('cm_plan');
        } elseif ($prefix === 'APR') {
            $last_id = $this->db->order_by('id', 'DESC')->limit(1)->get('ac_approvals');
        }elseif ($prefix === 'CLNUP') {
            $last_id = $db_payroll->order_by('id', 'DESC')->limit(1)->get('crew_lineup');
        }

        if ($last_id->num_rows() === 0) {
            return $prefix . $m . '000001';
        } else {
            $last_id = $last_id->row()->id + 1;

            if (strlen($last_id) === 1) {
                return $last_id = $prefix . $m . '00000' . $last_id;
            } elseif (strlen($last_id) === 2) {
                return $last_id = $prefix . $m . '0000' . $last_id;
            } elseif (strlen($last_id) === 3) {
                return $last_id = $prefix . $m . '000' . $last_id;
            } elseif (strlen($last_id) === 4) {
                return $last_id = $prefix . $m . '00' . $last_id;
            } elseif (strlen($last_id) === 5) {
                return $last_id = $prefix . $m . '0' . $last_id;
            } else {
                return $last_id = $prefix . $m . $last_id;
            }
        }
    }

    public function genrateCrewID($prefix)
    {
        $m = date('my');
        if ($prefix === 'CRW') {
            $last_id = $this->db->group_by('crew_code')->count_all_results('crews');
        }

        if ($last_id === 0) {
            return $prefix . $m . '000001';
        } else {
            $last_id = $last_id + 1;

            if (strlen($last_id) === 1) {
                return $last_id = $prefix . $m . '00000' . $last_id;
            } elseif (strlen($last_id) === 2) {
                return $last_id = $prefix . $m . '0000' . $last_id;
            } elseif (strlen($last_id) === 3) {
                return $last_id = $prefix . $m . '000' . $last_id;
            } elseif (strlen($last_id) === 4) {
                return $last_id = $prefix . $m . '00' . $last_id;
            } elseif (strlen($last_id) === 5) {
                return $last_id = $prefix . $m . '0' . $last_id;
            } else {
                return $last_id = $prefix . $m . $last_id;
            }
        }
    }

    public function ecdc($action, $string)
    {
        $output         = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key     = 'This is my secret key';
        $secret_iv      = 'This is my secret iv';
        $key            = hash('sha256', $secret_key);
        $iv             = substr(hash('sha256', $secret_iv), 0, 16);
        if ($action === 'ec') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action === 'dc') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    public function getBMI($height = 0, $weight = 0)
    {
        $bmi = ($weight / $height / $height) * 10000;
        return number_format($bmi, 2);
    }

    public function getUserPhoto($user_code)
    {
        $user_photo = $this->db->where('user_code', $user_code)->get('user_files')->row_array();

        if ($user_photo) {
            $photo_path = 'uploads/users/' . $this->ecdc('ec', $user_code) . '/' . $user_photo['file_name'];

            if (file_exists(FCPATH . $photo_path)) {
                $photo = base_url($photo_path);
            } else {
                $photo = base_url('assets/images/avatar-placeholder.png');
            }
        } else {
            $photo = base_url('assets/images/avatar-placeholder.png');
        }

        return $photo;
    }

    function updateApplicantStatus($applicant_code, $status)
    {
        $user_code = $this->ecdc('dc', $this->session->userdata('user_code'));

        $data = [
            'status' => $status,
            'date_updated' => date('Y-m-d H:i:s'),
            'assessed_by' => $status === '7' || $status === '0' ? NULL : $user_code
        ];

        $applicant_history = [
            'applicant_code'  => $applicant_code,
            'applicant_status' => $status,
            'issued_by' => $this->session->userdata('user_code') != null ? $user_code : "",
            'date_created'    => date("Y-m-d H:i:s"),
        ];

        if ($status === '6') {
            $query = $this->db->select('nat_result')->where('applicant_code', $applicant_code)->get('applicants')->row_array();
            if ($query['nat_result']) {
                $this->db->where('applicant_code', $applicant_code)->update('applicants', $data);
                if ($this->db->affected_rows() > 0) {
                    $this->db->insert('applicant_history', $applicant_history);
                    return true;
                } else {
                    return false;
                }
            } else {
                return 'add_nat';
            }
        }
        $this->db->where('applicant_code', $applicant_code)->update('applicants', $data);

        if ($this->db->affected_rows() > 0) {
            $this->db->insert('applicant_history', $applicant_history);
            return true;
        } else {
            return false;
        }
    }

    function updateCrewStatus($monitor_code, $status)
    {
        $data = [
            'status' => $status,
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $applicant_history = [
            'applicant_code'  => $monitor_code,
            'applicant_status' => $status,
            'issued_by' => $this->session->userdata('user_code') != null ? $this->session->userdata('user_code') : "",
            'date_created'    => date("Y-m-d H:i:s"),
        ];

        $this->db->trans_begin();

        $this->db->where('monitor_code', $monitor_code)->update('crews', $data);
        if ($status === 4) {
            $this->db->where('monitor_code', $monitor_code)->set('status', 0)->update('crew_poea');
            $this->db->where('monitor_code', $monitor_code)->set('status', 0)->update('crew_mlc');
        } else if ($status === 5) {
            $this->db->where('offsigner', $monitor_code)->set('status', 5)->update('cm_plan');
        }
        $this->db->insert('applicant_history', $applicant_history);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function applicantNotQualified($applicant_code, $reason)
    {
        $data = [
            'remark' => $reason
        ];

        $this->db->where('applicant_code', $applicant_code)->update('applicants', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getApplicantStatus($status)
    {
        switch ($status) {
            case 0:
                $result = '<span class="text-warning font-15 font-weight-medium"><i class="mdi mdi-circle text-warning"></i> On Process</span>';
                break;

            case 1:
                $result = '<span class="text-purple font-15 font-weight-medium"><i class="mdi mdi-circle text-purple"></i> Pending (NAT Result)</span>';
                break;

            case 2:
                $result = '<span class="text-primary font-15 font-weight-medium"><i class="mdi mdi-circle text-primary"></i> Interview 1st Assessor</span>';
                break;

            case 3:
                $result = '<span class="text-info font-15 font-weight-medium"><i class="mdi mdi-circle text-info"></i> Interview 2nd Assessor</span>';
                break;

            case 4:
                $result = '<span class="text-primary font-15 font-weight-medium"><i class="mdi mdi-circle text-primary"></i> For Principal Approval</span>';
                break;

            case 5:
                $result = '<span class="text-success font-15 font-weight-medium"><i class="mdi mdi-circle text-success"></i> Principal Approved</span>';
                break;

            case 6:
                $result = '<span class="text-success font-15 font-weight-medium"><i class="mdi mdi-circle text-success"></i> Passed (Recruitment)</span>';
                break;

            case 7:
                $result = '<span class="text-pink font-15 font-weight-medium"><i class="mdi mdi-circle text-pink"></i> Reserved Applicant</span>';
                break;

            case 8:
                $result = '<span class="text-alphera font-15 font-weight-medium"><i class="mdi mdi-circle text-alphera"></i> Not Qualified</span>';
                break;

            case 9;
                $result = '<span class="text-success font-15 font-weight-medium"><i class="mdi mdi-circle text-success"></i> Added to CM Plan (Crew)</span>';
                break;
        }

        return $result;
    }

    function getApplicantStatusForReports($status)
    {
        switch ($status) {
            case 0:
                $result = 'On Process';
                break;

            case 1:
                $result = 'Pending (NAT Result)';
                break;

            case 2:
                $result = 'Interview 1st Assessor';
                break;

            case 3:
                $result = 'Technical Interview 2nd Assessor';
                break;

            case 4:
                $result = 'For Principal Approval';
                break;

            case 5:
                $result = 'Principal Approved';
                break;

            case 6:
                $result = 'Passed (Recruitment)';
                break;

            case 7:
                $result = 'Reserved Applicant';
                break;

            case 8:
                $result = 'Not Qualified';
                break;

            case 9;
                $result = 'Moved to CM Plan (as Crew)';
                break;
        }

        return $result;
    }

    function getCrewStatus($status)
    {
        switch ($status) {
            case 1:
                $result = '<span class="text-success font-15 font-weight-medium"><i class="mdi mdi-circle text-success"></i> New Crew</span>';
                break;

            case 2:
                $result = '<span class="text-warning font-15 font-weight-medium"><i class="mdi mdi-circle text-warning"></i> On Process / Onboarding</span>';
                break;

            case 3:
                $result = '<span class="text-success font-15 font-weight-medium"><i class="mdi mdi-circle text-success"></i> Embarked</span>';
                break;

            case 4:
                $result = '<span class="text-primary font-15 font-weight-medium"><i class="mdi mdi-circle text-primary"></i> Disembarked</span>';
                break;

            case 5:
                $result = '<span class="text-primary font-15 font-weight-medium"><i class="mdi mdi-circle text-primary"></i> For Reporting</span>';
                break;

            case 6:
                $result = '<span class="text-danger font-15 font-weight-medium"><i class="mdi mdi-circle text-danger"></i> Not For Rehire (NRE)</span>';
                break;

            case 7:
                $result = '<span class="text-purple font-15 font-weight-medium"><i class="mdi mdi-circle text-purple"></i> On Vacation (Ex-Crew)</span>';
                break;

            case 8:
                $result = '<span class="text-pink font-15 font-weight-medium"><i class="mdi mdi-circle text-pink"></i> Withdrawal Application</span>';
                break;
        }

        return $result;
    }

    function getCrewStatusBadge($status)
    {
        switch ($status) {
            case 1:
                $result = '<span class="badge badge-success-outline">NEW</span>';
                break;

            case 2:
                $result = '<span class="badge badge-warning-outline">ON PROCESS / ONBOARDING</span>';
                break;

            case 3:
                $result = '<span class="badge badge-success-outline">EMBARKED</span>';
                break;

            case 4:
                $result = '<span class="badge badge-primary-outline">DISEMBARKED</span>';
                break;

            case 5:
                $result = '<span class="badge badge-primary-outline">FOR REPORTING</span>';
                break;

            case 6:
                $result = '<span class="badge badge-danger-outline">NRE</span>';
                break;

            case 7:
                $result = '<span class="badge badge-purple-outline">ON VACATION (EX-CREW)</span>';
                break;

            case 8:
                $result = '<span class="badge badge-pink-outline">TOC</span>';
                break;
        }

        return $result;
    }
    function getCrewStatusReport($status)
    {
        $result = [];
        switch ($status) {
            case 1:
                $result['status'] = 'NEW';
                $result['style'] = 'color: green;';
                break;

            case 2:
                $result['status'] = 'ON PROCESS / ONBOARDING';
                $result['style'] = 'color: orange;';
                break;

            case 3:
                $result['status'] = 'EMBARKED';
                $result['style'] = 'color: green;';
                break;

            case 4:
                $result['status'] = 'DISEMBARKED';
                $result['style'] = '';
                break;

            case 5:
                $result['status'] = 'FOR REPORTING';
                $result['style'] = '';
                break;

            case 6:
                $result['status'] = 'NRE';
                $result['style'] = 'color: red;';
                break;

            case 7:
                $result['status'] = 'ON VACATION (EX-CREW)';
                $result['style'] = 'color: purple;';
                break;

            case 8:
                $result['status'] = 'TOC';
                $result['style'] = 'color: pink;';
                break;
        }

        return $result;
    }

    function getCrewStatusForReport($status)
    {
        switch ($status) {
            case 1:
                $result = 'New Crew';
                break;

            case 2:
                $result = 'On Process/Onboarding';
                break;

            case 3:
                $result = 'Embarked';
                break;

            case 4:
                $result = 'Disembarked';
                break;

            case 5:
                $result = 'Not For Rehire (NRE)';
                break;

            case 6:
                $result = 'Not For Rehire (NRE)';
                break;

            case 7:
                $result = 'On Vacation';
                break;

            case 8:
                $result = 'Withdrawal Application';
                break;
            default:
                $result = "";
        }

        return $result;
    }

    function getWatchlistStatus($status, $type)
    {
        if ($type === 'warningletter') {

            switch ($status) {
                case 1:
                    $result = 'Not For Rehire';
                    break;

                case 2:
                    $result = 'Early Disembarkation';
                    break;

                case 0:
                    $result = 'Removed';
                    break;
            }
        } else {

            switch ($status) {
                case 1:
                    $result = 'Not For Rehire';
                    break;

                case 2:
                    $result = 'Early Disembarkation';
                    break;

                case 0:
                    $result = 'Removed';
                    break;
            }
        }

        return $result;
    }

    function getVesselStatus($status)
    {
        switch ($status) {
            case 0:
                $result = '<span class="text-warning font-15 font-weight-medium"><i class="mdi mdi-circle text-warning"></i> Removed</span>';
                break;

            case 1:
                $result = '<span class="text-success font-15 font-weight-medium"><i class="mdi mdi-circle text-success"></i> Active</span>';
                break;

            case 2:
                $result = '<span class="text-primary font-15 font-weight-medium"><i class="mdi mdi-circle text-primary"></i> Laid up</span>';
                break;

            case 3:
                $result = '<span class="text-info font-15 font-weight-medium"><i class="mdi mdi-circle text-info"></i> Sold</span>';
                break;

            case 4:
                $result = '<span class="text-primary font-15 font-weight-medium"><i class="mdi mdi-circle text-primary"></i> Change management</span>';
                break;

            case 5:
                $result = '<span class="text-warning font-15 font-weight-medium"><i class="mdi mdi-circle text-warning"></i> Scrapped</span>';
                break;

            case 6:
                $result = '<span class="text-warning font-15 font-weight-medium"><i class="mdi mdi-circle text-warning"></i> Collision/Sunk</span>';
                break;
        }

        return $result;
    }

    function uploadPhoto($photo)
    {
        $applicant_code = $this->input->post('applicant_code');
        $hash_applicant_code = $this->global->ecdc('ec', $applicant_code);

        if (!file_exists(FCPATH . 'uploads/applicants/' . $hash_applicant_code)) {
            mkdir(FCPATH . 'uploads/applicants/' . $hash_applicant_code, 0777, true);
            chmod(FCPATH . 'uploads/applicants/' . $hash_applicant_code, 0777);
        }

        $folderPath = FCPATH . 'uploads/applicants/' . $hash_applicant_code . '/';

        $image_parts = explode(';base64,', $photo);
        $image_type_aux = explode('image/', $image_parts[0]);

        $image_type = $image_type_aux[0];

        $image_base64 = base64_decode($image_parts[0]);
        $fileName = 'ApplicantPhoto_' . uniqid() . '.jpeg';

        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        chmod($file, 0777);
    }

    // ADMIN USER
    public function getAccountDetails($user_code)
    {
        return $this->db->where('user_code', $user_code)->get('user_account')->row_array();
    }


    // APPLICANT
    function getApplicantInformation($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_personal_info')->row_array();
    }

    function getWorkingGears($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_working_gears')->row_array();
    }

    function getEducationalAttainment($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_educational_attainment')->row_array();
    }

    function getNextOfKin($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_next_of_kin')->row_array();
    }

    function getLicenses($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_licenses_endorsement_book_id')->row_array();
    }

    function getCertificates($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_training_certificates')->row_array();
    }

    function getSeaServiceRecord($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_sea_service_record')->row_array();
    }

    function getEvaluationSheet($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_evaluation_sheet')->row_array();
    }

    function getGeneralInterviews($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_interview_general')->row_array();
    }

    function getTechnicalInterviews($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_interview_technical')->row_array();
    }

    function getEmployedCrew($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_form_newly_employed_crew')->row_array();
    }

    function getApplicants($applicant_code)
    {
        return $this->db->where('applicant_code', $applicant_code)->or_where('crew_code', $applicant_code)->get('applicants')->row_array();
    }

    function get_toc_reasons()
    {
        return $this->db->where('status', 1)->get('toc_reasons')->row_array();
    }
    //crew

    function getCMP($mntr_code)
    {
        return $this->db->where('offsigner', $mntr_code)->get('cm_plan')->row_array();
    }

    function getCrew($monitor_code)
    {
        return $this->db->where('monitor_code', $monitor_code)->or_where('crew_code', $monitor_code)->get('crews')->row_array();
    }

    function get_applicant_photo($applicant_code)
    {
        $query = $this->db->select()->from('ac_files')->where('applicant_code', $applicant_code)->where('file_code', "APLPHOTO")->get();
        if ($query->num_rows() > 0) {
            $path = $query->row()->file_name;
            $hash_applicant_code = $this->global->ecdc('ec', $applicant_code);
            $path = base_url() . 'uploads/applicants/' . $hash_applicant_code . '/' . $path;

            return $path;
        } else {
            return false;
        }
    }

    // CREW

    function getCrewInformation($crew_code)
    {
        $this->db->select("
            c.*,
            cmp.embark,
            cmp.disembark,
            cmp.cmp_code
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "c.monitor_code = cmp.offsigner");
        $this->db->where('c.crew_code', $crew_code);
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    function getCrewNameByMonitorCode($monitor_code)
    {
        $this->db->select("
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name, c.position, c.vessel_assign, acpi.mobile_number,
            av.vsl_name,
            av.vsl_code,
            ap.position_name,
            ap.position_code,
        ");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");

        $this->db->where('c.monitor_code', $monitor_code);
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    function getCrewNameByCrewCode($crew_code)
    {
        $this->db->select("
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name
        ");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->where('c.crew_code', $crew_code);
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }


    //Training Certificates
    public function getAllTrainingCertificates()
    {
        return $this->db->where('status', 1)->order_by('id', 'ASC')->get('a_certificates')->result_array();
    }

    public function getAllLicensesDocs()
    {
        return $this->db->where('status', 1)->order_by('id', 'ASC')->get('a_licenses')->result_array();
    }

    public function getTrainingCertificate($id)
    {
        return $this->db->where('id', $id)->get('a_certificates')->row_array();
    }

    function getListCertificates($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_training_certificates')->row_array();
    }

    //Licenses
    public function getAllLicenses()
    {
        return $this->db->where('status', 1)->get('a_licenses')->result_array();
    }

    public function getLicenseById($id)
    {
        return $this->db->where('id', $id)->get('a_licenses')->row_array();
    }

    // Sea Service Record
    function getListSeaServiceRecord($code)
    {
        return $this->db->where('applicant_code', $code)->or_where('crew_code', $code)->get('ac_sea_service_record')->row_array();
    }

    function getListLicenses($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_licenses_endorsement_book_id')->row_array();
    }

    //Crew Shortage
    public function getCrewShortage()
    {
        $this->db->select("
            c.applicant_code,
            c.crew_code,
            c.status crew_status,
            ap.id pos_id,
            ap.position_code,
            ap.position_name
        ");
        $this->db->from("crews c");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");

        $this->db->where('c.status', 3);
        $this->db->or_where('c.status', 7);
        
        $this->db->group_by('c.position');
        $this->db->order_by('c.date_created', "DESC");

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function getCrewShortageByPos($pos_id)
    {
        return $this->db->where('position_code', $pos_id)->get('crew_shortage')->row_array();
    }

    // Position
    public function getAllPosition()
    {
        return $this->db->where('status', 1)->order_by('date_created', 'DESC')->get('a_position')->result_array();
    }

    public function getPositionByPosition($first_position)
    {
        $position_first = $this->db->where('id', $first_position)->get('a_position')->row_array();

        return $this->db->where(array('type_of_department' => $position_first['type_of_department'], 'status' => 1))->get('a_position')->result_array();
    }

    public function getPosition($position)
    {
        return $this->db->where('id', $position)->get('a_position')->row_array();
    }

    public function getPositionById($id)
    {
        return $this->db->where('id', $id)->get('a_position')->row_array();
    }

    // Deparment
    public function getAllDeparment()
    {
        return $this->db->where('status', 1)->get('a_type_of_department')->result_array();
    }

    public function getDepartmentById($id)
    {
        return $this->db->where('id', $id)->get('a_type_of_department')->row_array();
    }

    // Civil Status
    public function getAllCivilStatus()
    {
        return $this->db->where('status', 1)->get('a_civil_status')->result_array();
    }

    function getCivilStatus($id)
    {
        return $this->db->where('id', $id)->get('a_civil_status')->row_array();
    }

    // Region
    public function getAllReligion()
    {
        return $this->db->where('status', 1)->get('a_religion')->result_array();
    }

    function getReligion($id)
    {
        return $this->db->where('id', $id)->get('a_religion')->row_array();
    }

    // Nationality
    public function getAllNationality()
    {
        return $this->db->where('status', 1)->order_by('description', 'ASC')->get('a_nationality')->result_array();
    }

    public function getNationalityById($id)
    {
        return $this->db->where('id', $id)->get('a_nationality')->row_array();
    }

    // Province
    public function getAllProvince()
    {
        return $this->db->where('status', 1)->get('a_province')->result_array();
    }

    function getProvince($id)
    {
        return $this->db->where('id', $id)->get('a_province')->row_array();
    }

    // City
    public function getCities($province)
    {
        return $this->db->where('province_id', $province)->where('status', 1)->get('a_city')->result_array();
    }

    function getCity($id)
    {
        return $this->db->where('id', $id)->get('a_city')->row_array();
    }

    function getAllCity()
    {
        return $this->db->where('status', 1)->get('a_city')->result_array();
    }

    //Warning Letter
    public function getWarningStatus()
    {
        return $this->db->where('status', 1)->get('a_warning_status')->result_array();
    }

    // Points of Interview
    public function getAllInterviewFormPoints()
    {
        return $this->db->where('status', 1)->order_by('id', 'ASC')->get('points_to_interview')->result_array();
    }

    public function getInterviewFormPointsById($id)
    {
        return $this->db->where('id', $id)->get('points_to_interview')->row_array();
    }

    function getGeneralInterview()
    {
        return $this->db->where('general_form', 1)->where('status', 1)->get('points_to_interview')->result_array();
    }

    function getInterviewSheet($code)
    {
        return $this->db->where('crew_code', $code)->or_where('applicant_code', $code)->get('ac_interview_sheet')->row_array();
    }

    function getTechnicalInterview($id)
    {
        return $this->db->where('id', $id)->where('status', "1")->get('points_to_interview')->row_array();
    }

    // Evaluation Sheet
    public function getEvaluationValueById($id)
    {
        return $this->db->where('id', $id)->get('a_position')->row_array();
    }

    // Vessel
    public function getAllVessel()
    {
        return $this->db->where('status', 1)->order_by('id', 'ASC')->get('a_vessels')->result_array();
    }

    public function getVesselById($id)
    {
        return $this->db->where('id', $id)->get('a_vessels')->row_array();
    }

    public function getAllArchiveVessel()
    {
        return $this->db->where('status !=', 1)->get('a_vessels')->result_array();
    }

    public function getAllVesselType()
    {
        return $this->db->where('status', 1)->order_by('tv_name', 'ASC')->get('a_type_of_vessel')->result_array();
    }

    public function getVesselTypeById($id)
    {
        return $this->db->where('id', $id)->get('a_type_of_vessel')->row_array();
    }

    public function getVesselTypeByVesselId($id)
    {
        $this->db->select("
            atv.tv_name,
            atv.id
        ");
        $this->db->from("a_type_of_vessel atv");
        $this->db->join("a_vessels av", "atv.id = av.vsl_type");
        $this->db->where('av.id', $id);

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function getAllEngineType()
    {
        return $this->db->where('status', 1)->order_by('date_created', 'DESC')->get('a_type_of_engine')->result_array();
    }

    public function getEngineTypeById($id)
    {
        return $this->db->where('id', $id)->get('a_type_of_engine')->row_array();
    }

    // Users
    public function getAllUserGroup()
    {
        return $this->db->where('status', 1)->order_by('date_created', 'DESC')->get('user_type')->result_array();
    }

    public function getUserGroupById($id)
    {
        return $this->db->where('id', $id)->get('user_type')->row_array();
    }

    public function getAllUsers()
    {
        return $this->db->where('status', 1)->order_by('created_date', 'DESC')->get('user_account')->result_array();
    }


    // Module
    public function getAllModule()
    {
        return $this->db->where('active', 1)->order_by('date_created', 'DESC')->get('form_module')->result_array();
    }

    public function getModuleById($id)
    {
        return $this->db->where('id', $id)->get('form_module')->row_array();
    }

    // Sub Module
    public function getAllSubModule()
    {
        return $this->db->where('active', 1)->order_by('date_created', 'DESC')->get('form_sub_module')->result_array();
    }

    public function getSubModuleById($id)
    {
        return $this->db->where('id', $id)->get('form_sub_module')->row_array();
    }

    function getAllSubModules($id)
    {
        return $this->db->order_by('order_by', 'ASC')->where('form_module_id', $id)->where('active', 1)->get('form_sub_module')->result_array();
    }


    // Node
    public function getAllNode()
    {
        return $this->db->where('active', 1)->order_by('date_created', 'DESC')->get('form_nodes')->result_array();
    }

    public function getNodeById($id)
    {
        return $this->db->where('id', $id)->get('form_nodes')->row_array();
    }
    function getAllNodes($id)
    {
        return $this->db->order_by('order_by', 'ASC')->where('form_sub_module_id', $id)->where('active', 1)->get('form_nodes')->result_array();
    }

    // SOURCE 
    function getAllSource()
    {
        return $this->db->get('a_source')->result_array();
    }

    // Contracts
    function getAllContracts()
    {
        return $this->db->get('a_contracts')->result_array();
    }

    function getCrewContracts($monitor_code)
    {
        return $this->db->where(array('crew_monitor' => $monitor_code, 'status' => 1))->get('crew_poea')->row_array();
    }
    function getCrewMLCContract($monitor_code)
    {
        return $this->db->where(array('monitor_code' => $monitor_code, 'status' => 1))->get('crew_mlc')->row_array();
    }

    // CREW FLIGHT
    function getAllFlights()
    {
        return $this->db->where('status', 1)->order_by('date_created', 'DESC')->get('crew_flight')->result_array();
    }

    // MEDICAL RECORDS
    function getAllMedicalRecords($crew_code)
    {
        return $this->db->where('crew_code', $crew_code)->where('status', 1)->order_by('date_created', 'DESC')->get('crew_medical')->result_array();
    }

    function getMedicalById($medical_code)
    {
        return $this->db->where('medical_code', $medical_code)->get('crew_medical')->row_array();
    }

    //GET FORMS SCORE
    public function natResult($applicant_code)
    {
        $query = $this->db->select('nat_result')->where('applicant_code', $applicant_code)->get('applicants')->row_array();
        if ($query) {
            if ($query['nat_result'] != NULL) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function evaluationFormScore($applicant_code)
    {
        $query = $this->db->select('additional_detail,substract_detail,final_evaluation')->where('applicant_code', $applicant_code)->get('ac_evaluation_sheet')->row_array();
        if ($query) {
            if ($query['additional_detail'] != NULL && $query['substract_detail'] != NULL && $query['final_evaluation'] != NULL) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function generalFormScore($applicant_code)
    {
        $query = $this->db->select('total_score,final_result')->where('applicant_code', $applicant_code)->get('ac_interview_general')->row_array();
        if ($query) {
            if ($query['total_score'] != NULL && $query['final_result'] != NULL) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function technicalFormScore($applicant_code)
    {
        $query = $this->db->select('total_score,final_result')->where('applicant_code', $applicant_code)->get('ac_interview_technical')->row_array();
        if ($query) {
            if ($query['total_score'] != NULL && $query['final_result'] != NULL) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function employedCrewScore($applicant_code, $status)
    {
        if ($status === '2') {
            $query = $this->db->select('first_interview_result,second_interview_result')->where('applicant_code', $applicant_code)->get('ac_form_newly_employed_crew')->row_array();
            if ($query) {
                if ($query['first_interview_result'] != NULL) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            $query = $this->db->select('first_interview_result,second_interview_result')->where('applicant_code', $applicant_code)->get('ac_form_newly_employed_crew')->row_array();
            if ($query) {
                if ($query['second_interview_result'] != NULL) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
    public function interviewSheetScore($applicant_code, $status)
    {
        if ($status === '2') {
            $query = $this->db->select('first_decision')->where('applicant_code', $applicant_code)->get('ac_interview_sheet')->row_array();
            if ($query) {
                if ($query['first_decision'] != NULL) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            $query = $this->db->select('second_decision')->where('applicant_code', $applicant_code)->get('ac_interview_sheet')->row_array();
            if ($query) {
                if ($query['second_decision'] != NULL) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
    public function getAllFormScores($applicant_code)
    {
        $ec_score = $this->db->select('first_interview_result')->where('applicant_code', $applicant_code)->get('ac_form_newly_employed_crew')->row_array();
        $inter_view = $this->db->select('first_decision')->where('applicant_code', $applicant_code)->get('ac_interview_sheet')->row_array();

        if ($ec_score != NULL && $inter_view != NULL) {
            return true;
        } else {
            return false;
        }
    }

    public function interviewSheetFinalScore($applicant_code)
    {
        $query = $this->db->select('first_decision,second_decision,final_decision')->where('applicant_code', $applicant_code)->get('ac_interview_sheet')->row_array();
        if ($query) {
            if ($query['final_decision'] != NULL) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function validateSheetsScore($applicant_code, $status)
    {
        $eval_form = $this->global->evaluationFormScore($applicant_code);
        $gen_form = $this->global->generalFormScore($applicant_code);
        $emp_form = $this->global->employedCrewScore($applicant_code, $status);
        $interv_form = $this->global->interviewSheetScore($applicant_code, $status);

        $return_check_tech_form = $this->global->checkTechForm($applicant_code);
        $check_tech_form = !is_null($return_check_tech_form['interview_form']) && !empty($return_check_tech_form['interview_form']) ? TRUE : FALSE;

        $tech_form = true;
        if ($check_tech_form) {
            $tech_form = $this->global->technicalFormScore($applicant_code);
        }

        if ($eval_form === true && $gen_form === true && $tech_form === true && $emp_form === true && $interv_form === true) {
            return true;
        } else {
            return false;
        }
    }

    function GetAsessorFullName($user_code)
    {
        if ($user_code === null || $user_code === "") {
            return '-- -- --';
        } else {
            $query = $this->db->select("full_name as fullname")->from("user_account")->where("user_code", $user_code)->get();
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return false;
            }
        }
    }


    function GetCrewFullName($crew_code)
    {
        if ($crew_code === null || $crew_code === "") {
            return '-- -- --';
        } else {
            $query = $this->db->select("CONCAT(first_name, ' ', middle_name, ' ', last_name) full_name")->from("ac_personal_info")->where("crew_code", $crew_code)->get();
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return false;
            }
        }
    }

    function getAge($birth_date)
    {
        $today = date("Y-m-d");
        $diff = date_diff(date_create($birth_date), date_create($today));
        return $diff->format('%y');
    }

    function getDateDuration($embarked, $disembarked)
    {
        $diff = date_diff(date_create($embarked), date_create($disembarked));
        return $diff->format('%y');
    }

    function getDateDuration2($embarked, $disembarked)
    {
        $diff = date_diff(date_create($embarked[0]), date_create($disembarked[0]));
        return $diff->days;
    }

    function getStatusLicensesCertificates($expiry_date)
    {

        if (!empty($expiry_date)) {
            $current_date = strtotime(date('Y-m-d'));
            $diff = strtotime($expiry_date) - $current_date;
            $date_diff = round($diff / (60 * 60 * 24));

            if ($date_diff > 30) {
                $status = '<span class="text-success">VALID</span>';
            } else if ($date_diff <= 30 && $date_diff >= 1) {
                $status = '<span style="color:#ffaf00 !important;">NEAR EXPIRATION</span>';
            } else {
                $status = '<span class="text-danger"> EXPIRED </span>';
            }
        } else {
            $status = '<span> N/A </span>';
        }

        return $status;
    }

    public function getCrewWarningLetterCount($crew_code)
    {
        $result = $this->db->where(array('crew_code' => $crew_code, 'status' => 1))->get('ac_warning_letter')->result_array();

        if (count($result) > 0) {
            return '<span class="badge badge-danger" onclick="getWarningLetterDetails(\'' . $crew_code . '\')" style="cursor: pointer;background: none;border: 1px solid #f0643b;color: #f0643b;">Tagged with Warning Letter</span>';
        } else {
            return '';
        }
    }

    public function getCrewWatchlistStatus($crew_code)
    {
        $result = $this->db->where(array('crew_code' => $crew_code, 'status' => 1))->get('ac_watch_listed')->result_array();

        if (count($result) > 0) {
            return '<span class="badge badge-danger" style="cursor: pointer;background: none;border: 1px solid #f0643b;color: #f0643b;">Tagged as Watchlisted</span>';
        } else {
            return '';
        }
    }

    public function update_crew_sea_service()
    {
        $applicant_code = $this->input->post('vh_applicant_code');

        $data = $this->global->getSeaServiceRecord($applicant_code);

        if (is_null($data)) {
            $cmp_code = $applicant_code;
            $crew_data = $this->all_crew->get_crewcode_cmp($cmp_code);

            $applicant_code = $crew_data['applicant_code'];
        }

        $sea_service = [
            'name_of_vessel' => json_encode($this->input->post('s_vessel_name')),
            'flag' => json_encode($this->input->post('s_flag')),
            'salary' => json_encode($this->input->post('s_salary')),
            'rank' => json_encode($this->input->post('s_rank')),
            'type_of_vsl_eng' => json_encode($this->input->post('s_vsl_engn')),
            'grt_power' => json_encode($this->input->post('s_grt_power')),
            'embarked' => json_encode($this->input->post('s_embarked')),
            'disembarked' => json_encode($this->input->post('s_disembarked')),
            // 'total_service' => json_encode($this->input->post('s_total_service')),
            'agency' => json_encode($this->input->post('s_agency')),
            'remarks' => json_encode($this->input->post('s_remarks')),
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->where('applicant_code', $applicant_code)->update('ac_sea_service_record', $sea_service);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getBMIScore($height, $weight)
    {
        $height = str_replace(" ", "", $height);
        $weight = str_replace(" ", "", $weight);

        $bmi = round($weight / $height / $height * 10000, 2);
        $d_bmi = '';
        if ($bmi >= 20.0 && $bmi <= 24.9) {
            $d_bmi = '<span class="text-success font-15" title="Acceptable">' . $bmi . '</span>';
        } else if ($bmi >= 19.0 && $bmi <= 19.9) {
            $d_bmi = '<span class="text-warning font-15" title="Considerable subject to Health-Care Education">' . $bmi . '</span>';
        } else if ($bmi < 19.0) {
            $d_bmi = '<span class="text-muted font-15" title="Not Acceptable">' . $bmi . '</span>';
        } else if ($bmi >= 25 && $bmi <= 26.5) {
            $d_bmi = '<span class="text-warning font-15" title="Considerable subject to Health-Care Education">' . $bmi . '</span>';
        } else if ($bmi >= 26.6 && $bmi <= 28.0) {
            $d_bmi = '<span class="text-pink font-15" title="Considerable for Ex-Crew subject to special health-care education & memorandum for diet">' . $bmi . '</span>';
        } else if ($bmi >= 28.0) {
            $d_bmi = '<span class="text-muted font-15" title="Not Acceptable">' . $bmi . '</span>';
        }

        return '<h4 class="m-0 font-15">' . (!$bmi ? '-' : $d_bmi) . '</h4>';
    }


    public function getLicensesByPositions()
    {
        $first_position_id = $this->input->get('first_position');

        if (!empty($first_position_id)) {
            $second_position_id = $this->input->get('second_position');

            $get_license_first_position = $this->getLicenseByPosition($first_position_id);
            $license_first_position = json_decode($get_license_first_position['position_licenses']);

            $licenses = $license_first_position;

            if (!empty($second_position_id)) {
                $get_license_second_position = $this->getLicenseByPosition($second_position_id);
                $license_second_position = json_decode($get_license_second_position['position_licenses']);
                $licenses = array_unique(array_merge($license_first_position, $license_second_position), SORT_REGULAR);
            }

            $get_licenses = $this->getAllFilteredLicenses($licenses);
            return $get_licenses;
        }

        return FALSE;
    }

    public function getLicenseByPosition($id)
    {
        return $this->db->select("position_licenses")->where("id", $id)->get("a_position")->row_array();
    }


    public function getAllFilteredLicenses($licenses)
    {
        return $this->db->where_in("id", $licenses)->order_by("id", "ASC")->get('a_licenses')->result_array();
    }


    public function getCrewPositions($crew_code)
    {
        return $this->db->select('position_first,position_second')->where("crew_code", $crew_code)->get("applicants")->row_array();
    }


    public function checkTechForm($applicant_code)
    {

        $this->db->select('
            pos.interview_form
        ');

        $this->db->from("a_position pos");
        $this->db->join("applicants a", "a.position_first = pos.id", "LEFT");
        $this->db->where("a.applicant_code", $applicant_code);

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->row_array() : "";
    }

    public function getCrewDet($crew_code)
    {
        return $this->db->where_in("crew_code", $crew_code)->get('crews')->row_array();
    }


    public function getContractStatus($status)
    {
        $return_status = "";
        switch ($status) {
            case '1':
                $return_status = "<span class=\"badge badge-warning-outline font-14\">PENDING</span>";
                break;
            case '2':
                $return_status = "<span class=\"badge badge-purple-outline font-14\">ON-GOING</span>";
                break;
            case '3':
                $return_status = "<span class=\"badge badge-success-outline font-14\">FINISHED</span>";
                break;

            default:
                # code...
                break;
        }
        return $return_status;
    }

    public function getCrewFlights($crew_code)
    {
        $this->db->select("
            cf.*
        ");
        $this->db->from("crews c");
        $this->db->join("crew_flight cf", "c.flight_code = cf.flight_code");
        $this->db->where('c.crew_code', $crew_code);
        $this->db->where('cf.status', 1);
        $this->db->order_by('date_created', 'DESC');

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : [];
    }


    public function getMedicalStatus($status, $medical_status)
    {
        $doc_status = "";
        $title = $medical_status == "3" ? "W/APPROVAL" : "FIT FOR SEA DUTY";
        switch ($status) {
            case '1':
                $doc_status = "<span class=\"badge badge-success-outline font-14\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"{$title}\" data-original-title=\"{$title}\">VALID</span>";
                break;
            case '2':
                $doc_status = "<span class=\"badge badge-warning-outline font-14\">PENDING</span>";
                break;
            case '3':
                $doc_status = "<span class=\"badge badge-danger-outline font-14\">EXPIRED</span>";
                break;
            case '4':
                $doc_status = "<span class=\"badge badge-danger-outline font-14\">REJECTED</span>";
                break;
        }

        return $doc_status;
    }

    function textEllipsis($text, $length)
    {
        $new_text = $text;
        $new_text = strlen($new_text) <= $length ? $new_text : (substr($new_text, 0, $length - 2) . "...");
        return $new_text;
    }


    public function getTotalSeaService($date1, $date2)
    {
        $date1 = new DateTime($date1);
        $date2 = new DateTime($date2);
        $interval = $date1->diff($date2);

        $arr_sea_service = [
            "years" => $interval->y,
            "months" => $interval->m,
            "days" => $interval->d,
        ];

        return $arr_sea_service;
    }
}
