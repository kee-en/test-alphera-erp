<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_node extends CI_Model
{

    function addNode()
    {
        $data = [
            'form_sub_module_id' => $this->input->post('sub_module'),
            'description' => $this->input->post('node'),
            'url' => $this->input->post('node_url'),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('form_nodes', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveEditNode($id)
    {
        $data = [
            'form_sub_module_id' => $this->input->post('e_sub_module'),
            'description' => $this->input->post('e_node_name'),
            'url' => $this->input->post('e_node_url')
        ];

        $this->db->where('id', $id)->update('form_nodes', $data);

        return true;
    }

    function removeNode($id)
    {
        $this->db->where('id', $id)->set('active', 0)->update('form_nodes');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/* End of file M_user_group.php */
