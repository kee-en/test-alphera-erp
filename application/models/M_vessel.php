<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_vessel extends CI_Model
{
    function addVessel()
    {
        $data = [
            'vsl_code' => $this->input->post('vsl_code'),
            'vsl_name' => $this->input->post('vsl_name'),
            'vsl_type' => $this->input->post('type_of_vessel'),
            'vsl_engine' => $this->input->post('type_of_engine'),
            'acquisition_status' => $this->input->post('type_of_engine'),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('a_vessels', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveEditVessel($id)
    {
        $data = [
            'vsl_code' => $this->input->post('e_vsl_code'),
            'vsl_name' => $this->input->post('e_vsl_name'),
            'vsl_type' => $this->input->post('e_type_of_vessel'),
            'vsl_engine' => $this->input->post('e_type_of_engine'),
            'acquisition_status' => $this->input->post('type_acquisition_status'),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $id)->update('a_vessels', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        } 
    }

    function removeVessel($id, $vsl_status)
    {
        $update_data = [
            'status' => $vsl_status,
            'date_created' => date('Y-m-d H:i:s')
        ];

        $vessel_data = $this->db->select('*')->from('a_vessels')->where('id', $id)->get()->result_row();
        $db_archive = $this->load->database('archive', TRUE);

        $this->db->where('id', $id)->update('a_vessels', $update_data);
        $db_archive->insert('arc_vessel', $vessel_data);
        
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_vessels_report($params = array())
    {   
        $year = date('Y');

        $this->db->select("
            COUNT(v.id) as vessel_count
        ");

        $this->db->from("a_vessels v");
        $this->db->join("a_type_of_vessel vt", "vt.id = v.vsl_type", "LEFT");

        if (!empty($params['search']['filter_type'])) { 
            $this->db->where('v.acquisition_status', $params['search']['filter_type']);
        }
        if (!empty($params['search']['vsl_type'])) {
            $this->db->where('v.vsl_type', $params['search']['vsl_type']);
        }

        if (!empty($params['search']['vsl_reduction_type'])) {
            $this->db->where('v.status', $params['search']['vsl_reduction_type']);
        }

        $this->db->where('YEAR(v.date_created)', $year);
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function get_compara_vessels_report($params = array())
    {   
        $year = date('Y');
        $c_year = date('Y',strtotime(''.$year.' -1 year'));

        $this->db->select("
            COUNT(v.id) as comp_vessel_count
        ");

        $this->db->from("a_vessels v");
        $this->db->join("a_type_of_vessel vt", "vt.id = v.vsl_type", "LEFT");

        if (!empty($params['search']['filter_type'])) { 
            $this->db->where('v.acquisition_status', $params['search']['filter_type']);
        }
        if (!empty($params['search']['vsl_type'])) {
            $this->db->where('vt.id', $params['search']['vsl_type']);
        }

        if (!empty($params['search']['vsl_reduction_type'])) {
            $this->db->where('v.status', $params['search']['vsl_reduction_type']);
        }

        $this->db->where('YEAR(v.date_created)', $c_year);
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }
}

/* End of file M_vessel.php */
