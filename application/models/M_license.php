<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_license extends CI_Model
{

    function addLicense()
    {
        $data = [
            'license_code' => $this->input->post('license_code'),
            'license_name' => $this->input->post('license_name'),
            'required' => $this->input->post('required'),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('a_licenses', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveEditLicense($id)
    {
        $data = [
            'license_code' => $this->input->post('e_license_code'),
            'license_name' => $this->input->post('e_license_name'),
            'required' => $this->input->post('e_required'),
        ];

        $this->db->where('id', $id)->update('a_licenses', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function removeLicense($id)
    {
        $this->db->where('id', $id)->set('status', 0)->update('a_licenses');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getPanamaReport($params = array())
    {
        $this->db->select("
            c.crew_code,
            c.date_available,
            c.status,
            c.offsigner,
            c.monitor_code,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_name,
            av.vsl_name,
            aceb.number,
            aceb.expiry_date
        ");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("ac_licenses_endorsement_book_id aceb", "aceb.crew_code = c.crew_code", "LEFT");

        $this->db->order_by("c.date_created", "DESC");

        if (!empty($params['search']['position']) && $params['search']['position'] != "all") {
            $this->db->where('c.position', $params['search']['position']);
        }
        if (!empty($params['search']['vessel']) && $params['search']['vessel'] != "all") {
            $this->db->where('c.vessel_assign', $params['search']['vessel']);
        }

        if(!empty($params['search']['joining_date_from']) && !empty($params['search']['joining_date_to'])){
            $this->db->where('c.embark_date >=', $params['search']['joining_date_from']);
            $this->db->where('c.embark_date <=', $params['search']['joining_date_to']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function getAllLicenses()
    {
        return $this->db->where('status', 1)->order_by('date_created', 'DESC')->get('ac_licenses_endorsement_book_id')->result_array();
    }
}

/* End of file M_license.php */
