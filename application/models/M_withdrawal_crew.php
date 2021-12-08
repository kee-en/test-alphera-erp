<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_withdrawal_crew extends CI_Model
{

    function getWithdrawalCrew($params = array())
    {
        $this->db->select("
        acw.*,
        c.crew_code, 
        c.date_available, 
        c.status,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        ap.position_code,
        ap.position_name,
        av.vsl_name,
        ac.description city_name,
        apr.description province_name");
        $this->db->from("ac_withdrawal acw");
        $this->db->join("crews c", "acw.crew_code = c.crew_code");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");

        $this->db->where("c.status", 8);
        $this->db->order_by("c.date_created", "DESC");
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function getTransferCompanyCrew($params = array())
    {
        $this->db->select("
        acw.crew_code, 
        acw.status,
        acw.issued_by,
        acw.remarks,
        acw.date_created, 
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        ap.position_code,
        ap.position_name,
        av.vsl_name,
        ac.description city_name,
        apr.description province_name");
        $this->db->from("ac_withdrawal acw");
        $this->db->join("ac_personal_info acpi", "acw.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "acw.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "acw.vessel_assign = av.id", "LEFT");

        $this->db->where("acw.status !=", 0);

        $this->db->order_by("acw.date_created", "DESC");
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function getPendingCrewTransfer($params = array())
    {
        $this->db->select("
        acw.crew_code, 
        acw.status,
        acw.issued_by,
        acw.remarks,
        acw.date_created, 
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        ap.position_code,
        ap.position_name,
        av.vsl_name,
        ac.description city_name,
        apr.description province_name");
        $this->db->from("ac_withdrawal acw");
        $this->db->join("ac_personal_info acpi", "acw.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "acw.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "acw.vessel_assign = av.id", "LEFT");

        $this->db->where("acw.status", 2);

        $this->db->order_by("acw.date_created", "DESC");
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function save_crew_toc()
    {
        $approval_code = $this->global->generateID("APR");

        $toc_data = [
            'crew_code'     => $this->input->post('w_crew_code'),
            'position'      => $this->input->post('w_rank'),
            'vessel_assign' => $this->input->post('w_vessel'),
            'department'    => $this->input->post('w_department'),
            'issued_by'     => $this->session->userdata('user_code'),
            'remarks'       => $this->input->post('w_remarks'),
            'reason'        => $this->input->post('w_reasons'),
            'date_created'  => date('Y-m-d'),
            'status'        => 2
        ];

        $approval_data = [
            'approval_code' => $approval_code,
            'crew_code'     => $this->input->post('w_crew_code'),
            'department'    => 'crew management',
            'request_type'  => 'for_withdrawal',
            'request_by'    => $this->session->userdata('user_code'),
            'remarks'       => $this->input->post('w_remarks'),
            'reason'        => $this->input->post('w_reasons'),
            'date_created'  => date('Y-m-d H:i:s'),
            'status'        => 2
        ];

        $db_archive = $this->load->database('archive', TRUE);

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->insert('ac_withdrawal', $toc_data);
        $this->db->insert('ac_approvals', $approval_data);
        $db_archive->insert('arc_withdrawal', $toc_data);
        $db_archive->insert('arc_approvals', $approval_data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function UnWatchlistCrew()
    {
        $approval_code = $this->global->generateID("APR");
        $details = ['toc_status' => $this->input->post('toc_status')];
        
        $approval_toc = [
            'approval_code' => $approval_code,
            'crew_code'     => $this->input->post('crew_code'),
            'department'    => 'crew management',
            'request_type'  => 'un_toc',
            'details'       => json_encode($details),
            'request_by'    => $this->session->userdata('user_code'),
            'date_created'  => date('Y-m-d H:i:s'),
            'status'        => 2
        ];

        $db_archive = $this->load->database('archive', TRUE);

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->insert('ac_approvals', $approval_toc);
        $db_archive->insert('arc_approvals', $approval_toc);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function automatic_toc_crew($data)
    {
        $db_archive = $this->load->database('archive', TRUE);

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->insert('ac_withdrawal', $data);
        $db_archive->insert('arc_withdrawal', $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function get_toc_report($date, $toc_filter = array())
    {
        $agency = 'Alphera';

        $this->db->select("
            acw.remarks,
            ap.position_name,
            COUNT(acw.id) as toc_count
        ");

        $this->db->from("ac_withdrawal acw");
        $this->db->join("a_position ap", "acw.position = ap.id", "LEFT");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = acw.crew_code", "LEFT");
        $this->db->where('YEAR(acw.date_created)', $date);
        $this->db->like('LOWER(acsr.agency)', strtolower($agency));

        if (!empty($toc_filter['search']['rank_filter'])) {
            $this->db->where('acw.position', $toc_filter['search']['rank_filter']);
            $this->db->group_by('acw.position');
        }else{
            $this->db->group_by('acw.remarks');
        }

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function get_newhire_toc_report($date, $toc_filter = array())
    {
        $agency = 'Alphera';
        
        $this->db->select("
            acw.remarks,
            ap.position_name,
            COUNT(acw.id) as toc_count
        ");

        $this->db->from("ac_withdrawal acw");
        $this->db->join("a_position ap", "acw.position = ap.id", "LEFT");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = acw.crew_code", "LEFT");
        $this->db->where('YEAR(acw.date_created)', $date);
        $this->db->not_like('LOWER(acsr.agency)', strtolower($agency));

        if (!empty($toc_filter['search']['rank_filter'])) {
            $this->db->where('acw.position', $toc_filter['search']['rank_filter']);
            $this->db->group_by('acw.position');
        }else{
            $this->db->group_by('acw.remarks');
        }

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}

/* End of file M_withdrawal_crew.php */