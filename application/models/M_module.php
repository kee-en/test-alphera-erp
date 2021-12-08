<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_module extends CI_Model
{

    function addModule()
    {
        $data = [
            'description' => $this->input->post('module_name'),
            'url' => $this->input->post('url'),
            'icon' => $this->input->post('icon'),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('form_module', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveEditModule($id)
    {
        $data = [
            'description' => $this->input->post('e_module_name'),
            'url' => $this->input->post('e_module_url'),
            'icon' => $this->input->post('e_module_icon'),
        ];

        $this->db->where('id', $id)->update('form_module', $data);

        return true;
    }


    function removeModule($id)
    {
        $this->db->where('id', $id)->set('active', 0)->update('form_module');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
