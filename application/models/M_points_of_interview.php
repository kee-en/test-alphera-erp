<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_points_of_interview extends CI_Model
{
    function addPointsInterviewForm()
    {
        $data = [
            'pti_description' => $this->input->post('points_of_interview'),
            'general_form' => $this->input->post('general_form'),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('points_to_interview', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveEditPointsInterview($id)
    {
        $data = [
            'pti_description' => $this->input->post('e_points_of_interview'),
            'general_form' => $this->input->post('e_general_form')
        ];

        $this->db->where('id', $id)->update('points_to_interview', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function removeInterviewForm($id)
    {
        $this->db->where('id', $id)->set('status', 0)->update('points_to_interview');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updatePositionPoints()
    {
        $id = $this->input->post('position_list');
        $check_position_cert = $this->db->where('id', $id)->get('a_position');

        $position_data = [
            'interview_form' => json_encode($this->input->post('points_interview'))
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
}

/* End of file M_points_of_interview.php */
