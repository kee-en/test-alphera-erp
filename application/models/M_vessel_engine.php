<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_vessel_engine extends CI_Model
{

    function addVesselEngine()
    {
        $data = [
            'engine_code' => $this->input->post('engine_code'),
            'engine_name' => $this->input->post('engine_name')
        ];

        $this->db->insert('a_type_of_engine', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveEditVesselEngine($id)
    {
        $data = [
            'engine_code' => $this->input->post('e_engine_code'),
            'engine_name' => $this->input->post('e_engine_name')
        ];

        $this->db->where('id', $id)->update('a_type_of_engine', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function removeVesselEngine($id)
    {
        $this->db->where('id', $id)->set('status', 0)->update('a_type_of_engine');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/* End of file M_vessel_engine.php */
