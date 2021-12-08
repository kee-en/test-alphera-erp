<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_routing_slip extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }


    public function get_prejoining_routing_slip($monitor_code)
    {
        $this->db->select("
        acrs.*,
        c.crew_code,
        c.monitor_code,
        c.date_created,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        appc.type_applicant,
        ap.position_code,
        ap.position_name,
        av.vsl_name,
        av.vsl_code,
        actc.date_created as actc_date,
        acis.date_created as acis_date");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");
        $this->db->join("applicants appc", "appc.crew_code = c.crew_code");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("ac_training_certificates actc", "actc.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_interview_sheet acis", "acis.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_routing_slip acrs", "acrs.crew_code = c.crew_code", "LEFT");

        $this->db->where("c.monitor_code", $monitor_code);
        $this->db->group_by('c.crew_code');
        $this->db->order_by("c.date_created", "DESC");

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    function save_routing_slip()
    {
        $monitoring_code = $this->input->post('mntr_code');
        $crew_code = $this->input->post('crw_code');

        $routing_data = $this->db->where(array('monitoring_code' => $monitoring_code, 'crew_code' => $crew_code))->get('ac_routing_slip');
        
            $dates = [$this->input->post('mrsm_date_0'),$this->input->post('mrsm_date_1'),$this->input->post('mrsm_date_2'),$this->input->post('mrsm_date_3'),$this->input->post('mrsm_date_4'),$this->input->post('mrsm_date_5'),$this->input->post('mrsm_date_6'),
            $this->input->post('mrsm_date_7'),$this->input->post('mrsm_date_8'),$this->input->post('mrsm_date_9'),$this->input->post('mrsm_date_10'),$this->input->post('mrsm_date_11'),$this->input->post('mrsm_date_12'),$this->input->post('mrsm_date_13'),$this->input->post('mrsm_date_14'),
            $this->input->post('mrsm_date_15'),$this->input->post('mrsm_date_16'),$this->input->post('mrsm_date_17'),$this->input->post('mrsm_date_18'),$this->input->post('mrsm_date_19'),$this->input->post('mrsm_date_20'),$this->input->post('mrsm_date_21')];
            
            $remarks = [$this->input->post('mrsm_remarks_1'),$this->input->post('mrsm_remarks_2'),$this->input->post('mrsm_remarks_3'),$this->input->post('mrsm_remarks_4'),$this->input->post('mrsm_remarks_5'),$this->input->post('mrsm_remarks_6'),$this->input->post('mrsm_remarks_7'),
            $this->input->post('mrsm_remarks_8'),$this->input->post('mrsm_remarks_9'),$this->input->post('mrsm_remarks_10'),$this->input->post('mrsm_remarks_11'),$this->input->post('mrsm_remarks_12'),$this->input->post('mrsm_remarks_13'),$this->input->post('mrsm_remarks_14'),$this->input->post('mrsm_remarks_15'),
            $this->input->post('mrsm_remarks_16'),$this->input->post('mrsm_remarks_17'),$this->input->post('mrsm_remarks_18'),$this->input->post('mrsm_remarks_19'),$this->input->post('mrsm_remarks_20'),$this->input->post('mrsm_remarks_21'),$this->input->post('mrsm_remarks_22')];

            $db_archive = $this->load->database('archive', TRUE);

            
        if ($routing_data->num_rows() > 0) {

            $routing_details = [
                $this->input->post('mrsm_cs_status_1'),
                $this->input->post('mrsm_cs_status_2'),
                $this->input->post('mrsm_cs_status_3'),
                $this->input->post('mrsm_cs_status_4'),
                $this->input->post('mrsm_cs_status_5'),
                $this->input->post('mrsm_cs_status_6'),
                $this->input->post('mrsm_cs_status_7'),
                $this->input->post('mrsm_cs_status_8'),
                $this->input->post('mrsm_cs_status_9'),
                $this->input->post('mrsm_cs_status_10'),
                $this->input->post('mrsm_cs_status_11'),
                $this->input->post('mrsm_cs_status_12'),
                $this->input->post('mrsm_cs_status_13'),
                $this->input->post('mrsm_cs_status_14'),
                $this->input->post('mrsm_cs_status_15'),
                $this->input->post('mrsm_cs_status_16'),
                $this->input->post('mrsm_cs_status_17'),
                $this->input->post('mrsm_cs_status_18'),
                $this->input->post('mrsm_cs_status_19'),
                $this->input->post('mrsm_cs_status_20'),
                $this->input->post('mrsm_cs_status_21'),
                $this->input->post('mrsm_cs_status_22'),
            ];

            $data = [
                'with_cba'  => $this->input->post('with_cba'),
                'routing_details'   => json_encode($routing_details),
                'dates'     => json_encode($dates),
                'remarks'   => json_encode($remarks),
                'date_created'  => date('Y-m-d')
            ];

            $this->db->trans_strict(true);
            $this->db->trans_begin();

            $this->db->where(array('monitoring_code' => $monitoring_code, 'crew_code' => $crew_code))->update('ac_routing_slip', $data);
            // $db_archive->insert('arc_routing_slip', $data);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }

        }else{
            $routing_details = [
                $this->input->post('mrsm_cs_status_1'),
                $this->input->post('mrsm_cs_status_2'),
                $this->input->post('mrsm_cs_status_3'),
                $this->input->post('mrsm_cs_status_4'),
                $this->input->post('mrsm_cs_status_5'),
                $this->input->post('mrsm_cs_status_6'),
                $this->input->post('mrsm_cs_status_7'),
                $this->input->post('mrsm_cs_status_8'),
                $this->input->post('mrsm_cs_status_9'),
                $this->input->post('mrsm_cs_status_10'),
                $this->input->post('mrsm_cs_status_11'),
                $this->input->post('mrsm_cs_status_12'),
                $this->input->post('mrsm_cs_status_13'),
                $this->input->post('mrsm_cs_status_14'),
                $this->input->post('mrsm_cs_status_15'),
                $this->input->post('mrsm_cs_status_16'),
                $this->input->post('mrsm_cs_status_17'),
                $this->input->post('mrsm_cs_status_18'),
                $this->input->post('mrsm_cs_status_19'),
                $this->input->post('mrsm_cs_status_20'),
                $this->input->post('mrsm_cs_status_21'),
                $this->input->post('mrsm_cs_status_22'),
            ];

            $data = [
                'monitoring_code'   => $monitoring_code,
                'crew_code' => $crew_code,
                'with_cba'  => $this->input->post('with_cba'),
                'routing_details'   => json_encode($routing_details),
                'dates'     => json_encode($dates),
                'remarks'   => json_encode($remarks),
                'date_created'  => date('Y-m-d'),
                'status'    => 1
            ];

            $this->db->trans_strict(true);
            $this->db->trans_begin();

            $this->db->insert('ac_routing_slip', $data);
            // $db_archive->insert('arc_routing_slip', $data);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
    }


    public function get_disembark_routing_slip($monitor_code)
    {
        $this->db->select("
        acdr.*,
        c.crew_code,
        c.monitor_code,
        c.date_created,
        cmp.disembark,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        appc.type_applicant,
        ap.position_code,
        ap.position_name,
        av.vsl_name,
        av.vsl_code,");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("applicants appc", "appc.crew_code = c.crew_code");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("ac_disembark_routing_slip acdr", "acdr.crew_code = c.crew_code", "LEFT");

        $this->db->where("c.monitor_code", $monitor_code);
        $this->db->group_by('c.crew_code');
        $this->db->order_by("c.date_created", "DESC");

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function save_disembark_routing_slip()
    {
        $monitoring_code = $this->input->post('mntr_code');
        $crew_code = $this->input->post('crw_code');

        $routing_data = $this->db->where(array('monitoring_code' => $monitoring_code, 'crew_code' => $crew_code))->get('ac_disembark_routing_slip');
            
            $remarks = [$this->input->post('drsm_remarks_1'),$this->input->post('drsm_remarks_2'),$this->input->post('drsm_remarks_3'),$this->input->post('drsm_remarks_4'),$this->input->post('drsm_remarks_5'),$this->input->post('drsm_remarks_6'),$this->input->post('drsm_remarks_7'),
            $this->input->post('drsm_remarks_8'),$this->input->post('drsm_remarks_9'),$this->input->post('drsm_remarks_10'),$this->input->post('drsm_remarks_11')];

            $db_archive = $this->load->database('archive', TRUE);

            
        if ($routing_data->num_rows() > 0) {

            $routing_details = [
                $this->input->post('drsm_cs_status_1'),
                $this->input->post('drsm_cs_status_2'),
                $this->input->post('drsm_cs_status_3'),
                $this->input->post('drsm_cs_status_4'),
                $this->input->post('drsm_cs_status_5'),
                $this->input->post('drsm_cs_status_6'),
                $this->input->post('drsm_cs_status_7'),
                $this->input->post('drsm_cs_status_8'),
                $this->input->post('drsm_cs_status_9'),
                $this->input->post('drsm_cs_status_10'),
                $this->input->post('drsm_cs_status_11')
            ];

            $data = [
                'details'   => json_encode($routing_details),
                'remarks'   => json_encode($remarks),
                'date_created'  => date('Y-m-d')
            ];

            $this->db->trans_strict(true);
            $this->db->trans_begin();

            $this->db->where(array('monitoring_code' => $monitoring_code, 'crew_code' => $crew_code))->update('ac_disembark_routing_slip', $data);
            $db_archive->insert('arc_disembark_routing_slip', $data);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }

        }else{
            $routing_details = [
                $this->input->post('drsm_cs_status_1'),
                $this->input->post('drsm_cs_status_2'),
                $this->input->post('drsm_cs_status_3'),
                $this->input->post('drsm_cs_status_4'),
                $this->input->post('drsm_cs_status_5'),
                $this->input->post('drsm_cs_status_6'),
                $this->input->post('drsm_cs_status_7'),
                $this->input->post('drsm_cs_status_8'),
                $this->input->post('drsm_cs_status_9'),
                $this->input->post('drsm_cs_status_10'),
                $this->input->post('drsm_cs_status_11')
            ];

            $data = [
                'monitoring_code'   => $monitoring_code,
                'crew_code' => $crew_code,
                'details'   => json_encode($routing_details),
                'remarks'   => json_encode($remarks),
                'date_created'  => date('Y-m-d'),
                'status'    => 1
            ];

            $this->db->trans_strict(true);
            $this->db->trans_begin();

            $this->db->insert('ac_disembark_routing_slip', $data);
            $db_archive->insert('arc_disembark_routing_slip', $data);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
    }
}