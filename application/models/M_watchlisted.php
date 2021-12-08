<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_watchlisted extends CI_Model
{
    public function SaveWatchListCrew()
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
            'certificates'  => $this->input->post('w_certificates'),
            'e_registration'    => $this->input->post('w_registration_no'),
            'remarks'       => $this->input->post('w_remarks'),
            'date_created'  => date('Y:m:d'),
            'issued_by'  => $user_code,
            'status'        => 1
        ];

        $this->db->insert('ac_watch_listed', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getWatchlistedCrew()
    {
        return $this->db->where('status !=', 0)->order_by('date_created', 'DESC')->get('ac_watch_listed')->result_array();
    }

    public function deleteWatchlistedCrew($id)
    {
        $this->db->where('id', $id)->set('status', 0)->update('ac_watch_listed');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getWatchlistReporting($params = array())
    {
        $this->db->select("
            acwl.*,
            CONCAT(acpi.first_name, ' ',acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            ac.description city_name,
            apr.description province_name
        ");
        $this->db->from("ac_watch_listed acwl");
        $this->db->join("ac_personal_info acpi", "acwl.crew_code = acpi.crew_code");
        $this->db->join("a_position ap", "acwl.rank = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "acwl.vessel = av.id", "LEFT");

        $this->db->where("acwl.status", "1");
        $this->db->order_by("acwl.date_created");

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}
