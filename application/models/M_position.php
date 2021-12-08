<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_position extends CI_Model
{

    function addPosition()
    {
        $data = [
            'position_code' => $this->input->post('position_code'),
            'position_name' => $this->input->post('position_name'),
            'type_of_department' => $this->input->post('department'),
            'nc_max_age' => $this->input->post('maximum_age_new'),
            'ec_max_age' => $this->input->post('maximum_age_ex'),
            'min_experience' => $this->input->post('minimum_exp'),
            'max_experience' => $this->input->post('maximum_exp'),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('a_position', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveEditPosition($id)
    {
        $data = [
            'position_code' => $this->input->post('e_position_code'),
            'position_name' => $this->input->post('e_position_name'),
            'type_of_department' => $this->input->post('e_department'),
            'nc_max_age' => $this->input->post('e_maximum_age_new'),
            'ec_max_age' => $this->input->post('e_maximum_age_ex'),
            'min_experience' => $this->input->post('e_minimum_exp'),
            'max_experience' => $this->input->post('e_maximum_exp'),
        ];

        $this->db->where('id', $id)->update('a_position', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function removePosition($id)
    {
        $this->db->where('id', $id)->set('status', 0)->update('a_position');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updatePosition()
    {
        $id = $this->input->post('position_list');
        $check_position_cert = $this->db->where('id', $id)->get('a_position');

        $position_data = [
            'position_requirements' => json_encode($this->input->post('req_position'))
        ];

        if ($check_position_cert->num_rows() > 0) {
            $position_data['date_updated'] = date('Y-m-d H:i:s');
            $this->db->where('id', $id)->update('a_position', $position_data);
        } else {
            return false;
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getPositionID($id)
    {
        return $this->db->select('position_name')->where(array('id' => $id, 'status' => 1))->order_by('date_created', 'DESC')->limit(1)->get('a_position')->row_array();
    }


    public function updateLicensesPerPosition()
    {
        $position_id = $this->input->post('position_list');
        $licenses_per_postion = json_encode($this->input->post("licenses_position"));

        $licenses_position_data = [
            'position_licenses' => $licenses_per_postion !== "null" ? $licenses_per_postion : NULL,
        ];

        $this->db->where('id', $position_id)->update("a_position", $licenses_position_data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function getSelectedLicensesPerPosition()
    {
        $position_id = $this->input->get('position_list');

        return $this->db->select("position_licenses")->where("id", $position_id)->get("a_position")->row_array();
    }
}

/* End of file M_position.php */
