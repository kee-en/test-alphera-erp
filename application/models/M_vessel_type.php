<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_vessel_type extends CI_Model
{

    function addVesselType()
    {
        $data = [
            'tv_code' => $this->input->post('vessel_code'),
            'tv_name' => $this->input->post('vessel_name')
        ];

        $this->db->insert('a_type_of_vessel', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveEditVesselType($id)
    {
        $data = [
            'tv_code' => $this->input->post('e_vessel_code'),
            'tv_name' => $this->input->post('e_vessel_name')
        ];

        $this->db->where('id', $id)->update('a_type_of_vessel', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function removeVesselType($id)
    {
        $this->db->where('id', $id)->set('status', 0)->update('a_type_of_vessel');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/* End of file M_vessel_type.php */
