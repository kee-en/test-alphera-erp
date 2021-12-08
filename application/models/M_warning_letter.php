<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_warning_letter extends CI_Model
{
    public function getCrewWarningLetter()
    {
        return $this->db->where('status !=', 0)->order_by('date_created', 'DESC')->get('ac_warning_letter')->result_array();
    }

    public function getCrewWarningLetterByCode($crew_code)
    {
        return $this->db->where(array('crew_code' => $crew_code, 'status !=' => 0))->get('ac_warning_letter')->row_array();
    }

    public function deleteCrewWarningLetter($id)
    {
        $this->db->where('id', $id)->set('status', 0)->update('ac_warning_letter');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getWarningLetterData($app_code)
    {
        return $this->db->where('applicant_code', $app_code)->get('ac_warning_letter')->row_array();
    }

    // public function getWarningLetterById($id)
    // {
    //     $query = $this->db->where('id', $id)->order_by('date_created', 'DESC')->get('ac_warning_letter');
    //     return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    // }

    public function saveCrewWarningLetter()
    {

        $app_code = $this->input->post('w_applicant_code');
        $user_code = $this->global->ecdc('dc', $this->session->userdata('user_code'));
        $data = [
            'applicant_code'    => $this->input->post('w_applicant_code'),
            'crew_code'     => $this->input->post('w_crew_name'),
            'crew_name'     => $this->input->post('w_cname'),
            'rank'          => $this->input->post('w_rank'),
            'department'    => $this->input->post('w_department'),
            'vessel'        => $this->input->post('w_vessel'),
            'remarks'       => $this->input->post('w_remarks'),
            'reason'       => $this->input->post('w_type_of_nre'),
            'additional_remarks'       => $this->input->post('w_additional_remarks'),
            'date_created'  => date('Y:m:d'),
            'issued_by'  => $user_code,
            'status'        => 1
        ];

        $query = $this->db->where('applicant_code', $app_code)->get('ac_warning_letter');
        if ($query->num_rows() > 0) {

            if ($this->input->post('w_remarks') === "2") {

                $crew_update_data = [
                    'status' => 4,
                    'date_updated' => date('Y-m-d H:i:s')
                ];

                $applicant_history = [
                    'applicant_code'  => $this->input->post('w_applicant_code'),
                    'applicant_status' => 4,
                    'issued_by' => $this->session->userdata('user_code') != null ? $this->session->userdata('user_code') : "",
                    'date_created'    => date("Y-m-d H:i:s"),
                ];

                $this->db->where('applicant_code', $this->input->post('w_applicant_code'))->update('crews', $crew_update_data);
                $this->db->insert('applicant_history', $applicant_history);

                if ($this->db->affected_rows() > 0) {
                    return 'early_disembark';
                } else {
                    return false;
                }
            } else {

                $this->db->insert('ac_warning_letter', $data);

                if ($this->db->affected_rows() > 0) {
                    return 'to_nre';
                } else {
                    return false;
                }
            }
        } else {

            if ($this->input->post('w_remarks') === "2") {

                $crew_update_data = [
                    'status' => 4,
                    'date_updated' => date('Y-m-d H:i:s')
                ];

                $applicant_history = [
                    'applicant_code'  => $this->input->post('w_applicant_code'),
                    'applicant_status' => 4,
                    'issued_by' => $this->session->userdata('user_code') != null ? $this->session->userdata('user_code') : "",
                    'date_created'    => date("Y-m-d H:i:s"),
                ];

                $this->db->trans_begin();

                $this->db->where('applicant_code', $this->input->post('w_applicant_code'))->update('crews', $crew_update_data);
                $this->db->insert('applicant_history', $applicant_history);
                $this->db->insert('ac_warning_letter', $data);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return 'early_disembark';
                }
            } else {
                $this->db->insert('ac_warning_letter', $data);

                if ($this->db->affected_rows() > 0) {
                    return "to_nre";
                } else {
                    return false;
                }
            }
        }
    }

    public function saveEarlyDisembarkCrewWarningLetter()
    {

        $app_code = $this->input->post('awl_applicant_code');
        $user_code = $this->global->ecdc('dc', $this->session->userdata('user_code'));
        $data = [
            'applicant_code'    => $this->input->post('awl_applicant_code'),
            'crew_code'     => $this->input->post('awl_crew_code'),
            'crew_name'     => $this->input->post('awl_crew_name'),
            'rank'          => $this->input->post('awlm_rank'),
            'department'    => $this->global->getDepartmentById($this->input->post('awlm_department'))['department_code'],
            'vessel'        => $this->input->post('awlm_vessel'),
            'remarks'       => $this->input->post('awlm_remarks'),
            'reason'       => $this->input->post('awlm_type_of_nre'),
            'additional_remarks'       => $this->input->post('awlm_additional_remarks'),
            'date_created'  => date('Y:m:d'),
            'issued_by'  => $user_code,
            'status'        => 1
        ];

        $query = $this->db->where(array('applicant_code' => $app_code, "status" => 1))->get('ac_warning_letter');

        if ($query->num_rows() > 0) {

            if ($this->input->post('awlm_remarks') != "1") {

                $crew_update_data = [
                    'status' => 4,
                    'date_updated' => date('Y-m-d H:i:s')
                ];

                $applicant_history = [
                    'applicant_code'  => $this->input->post('awl_applicant_code'),
                    'applicant_status' => 4,
                    'issued_by' => $this->session->userdata('user_code') != null ? $this->session->userdata('user_code') : "",
                    'date_created'    => date("Y-m-d H:i:s"),
                ];

                $update_crew_cmp = [
                    'status'    => 4,
                    'date_updated'  => date('Y-m-d H:i:s')
                ];

                $this->db->where('crew_code', $this->input->post('awl_crew_code'))->update('crews', $crew_update_data);
                $this->db->where('offsigner', $this->input->post('awl_monitor_code'))->update('cm_plan', $update_crew_cmp);
                $this->db->insert('applicant_history', $applicant_history);

                if ($this->db->affected_rows() > 0) {
                    return 'early_disembark';
                } else {
                    return false;
                }
            } else {
                $update_data = ['status' => 6, 'date_updated' => date('Y:m:d H:i:s')];
                $this->db->insert('ac_warning_letter', $data);
                $this->db->where('applicant_code', $app_code)->set($update_data)->update('crews');

                if ($this->db->affected_rows() > 0) {
                    return 'to_nre';
                } else {
                    return false;
                }
            }
        } else {

            if ($this->input->post('awlm_remarks') != "1") {

                $crew_update_data = [
                    'status' => 4,
                    'date_updated' => date('Y-m-d H:i:s')
                ];

                $applicant_history = [
                    'applicant_code'  => $this->input->post('awl_applicant_code'),
                    'applicant_status' => 4,
                    'issued_by' => $this->session->userdata('user_code') != null ? $this->session->userdata('user_code') : "",
                    'date_created'    => date("Y-m-d H:i:s"),
                ];

                $update_crew_cmp = [
                    'status'    => 4,
                    'date_updated'  => date('Y-m-d H:i:s')
                ];

                $this->db->trans_begin();

                $this->db->where('crew_code', $this->input->post('awl_crew_code'))->update('crews', $crew_update_data);
                $this->db->where('offsigner', $this->input->post('awl_monitor_code'))->update('cm_plan', $update_crew_cmp);
                $this->db->insert('applicant_history', $applicant_history);
                $this->db->insert('ac_warning_letter', $data);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return 'early_disembark';
                }
            } else {
                $update_data = ['status' => 6, 'date_updated' => date('Y:m:d H:i:s')];


                $this->db->trans_begin();

                $this->db->insert('ac_warning_letter', $data);
                $this->db->where('applicant_code', $app_code)->set($update_data)->update('crews');
                $this->db->insert('ac_warning_letter', $data);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return 'early_disembark';
                }
            }
        }
    }

    // public function updateCrewWarningLetter($id){
    //     $data = [
    //         'crew_name' => $this->input->post('e_crew_name'),
    //         'rank'      => $this->input->post('e_rank'),
    //         'department'    => $this->input->post('e_department'),
    //         'vessel'   => $this->input->post('e_vessel'),
    //         'remarks'  => $this->input->post('e_remarks'),
    //         'additional_remarks'    => $this->input->post('e_additional_remarks'),
    //         'date_created'  => date('Y:m:d')
    //     ];

    //     $this->db->where('id', $id)->set($data)->update('ac_warning_letter');

    // if ($this->db->affected_rows() > 0) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function get_total_illness_injury()
    {
        $this->db->select("
            COUNT(id) as total
        ");

        $this->db->from("ac_warning_letter");
        $this->db->where('reason', 3);
        $this->db->or_where('reason', 6);

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}
