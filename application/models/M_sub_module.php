<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_sub_module extends CI_Model
{

    function addSubModule()
    {
        $data = [
            'form_module_id' => $this->input->post('module'),
            'description' => $this->input->post('sub_module'),
            'url' => $this->input->post('sub_module_url'),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('form_sub_module', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveEditSubModule($id)
    {
        $data = [
            'form_module_id' => $this->input->post('e_module'),
            'description' => $this->input->post('e_sub_module'),
            'url' => $this->input->post('e_sub_module_url')
        ];

        $this->db->where('id', $id)->update('form_sub_module', $data);

        return true;
    }

    function removeSubModule($id)
    {
        $this->db->where('id', $id)->set('active', 0)->update('form_sub_module');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
