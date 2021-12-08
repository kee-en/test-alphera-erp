<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user_group extends CI_Model
{

    function addUserGroup()
    {
        $data = [
            'code' => $this->input->post('code'),
            'description' => $this->input->post('description'),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('user_type', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function saveEditUserGroup($id)
    {
        $data = [
            'code' => $this->input->post('e_code'),
            'description' => $this->input->post('e_description')
        ];

        $this->db->where('id', $id)->update('user_type', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function removeUserGroup($id)
    {
        $this->db->where('id', $id)->set('status', 0)->update('user_type');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addUserUserType()
    {
        $user_code = $this->global->generateID('USR');
        $email = $this->input->post('email_address');
        $pass = $email . $this->input->post('password');

        $options = [
            'cost' => 10
        ];

        $pass = password_hash($pass, PASSWORD_BCRYPT, $options);

        $data = [
            'user_code' => $user_code,
            'created_by' => $this->session->userdata('user_code'),
            'user_type_id' => $this->input->post('user_type'),
            'full_name' => $this->input->post('full_name'),
            'username' => $this->input->post('username'),
            'email_address' => $email,
            'phone_number' => $this->input->post('phone_number'),
            'password' => $pass,
            'created_date' => date('Y-m-d H:i:s'),
            'status' => 1
        ];

        $this->db->trans_begin();

        $this->db->insert('user_account', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }


    function updateUserUserType()
    {
        $user_code = $this->input->post('e_user_code');
        $data = [
            'user_type_id' => $this->input->post('e_user_type')
        ];

        $this->db->where('user_code', $user_code)->update('user_account', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function updateUserUserPassword()
    {
        $user_code = $this->input->post('p_user_code');
        $email = $this->input->post('p_email_address');
        $pass = $email . $this->input->post('p_password');

        $options = [
            'cost' => 10
        ];

        $pass = password_hash($pass, PASSWORD_BCRYPT, $options);

        $data = [
            'password' => $pass,
            'last_changed_pass' => date('Y-m-d H:i:s')
        ];

        $this->db->where('user_code', $user_code)->update('user_account', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function deactivateUserAccount()
    {
        $user_code_hash = $this->input->post('code');
        $user_code = $this->global->ecdc('dc',$user_code_hash);

        $data = [
            'status' => 0
        ];

        $this->db->where('user_code', $user_code)->update('user_account', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    
}

/* End of file M_user_group.php */
