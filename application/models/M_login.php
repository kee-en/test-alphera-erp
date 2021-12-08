<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{

    function authUser()
    {
        $email = $this->input->post('email_address');
        $password = $this->input->post('password');

        $user = $this->db->where('username', $email)->get('user_account');

        if ($user->num_rows() > 0) {
            $user = $user->row_array();
            $password = $user['email_address'] . $password;

            if (password_verify($password, $user['password'])) {
                $user_photo = $this->global->getUserPhoto($user['user_code']);

                $session_data = [
                    'user_code' => $this->global->ecdc('ec', $user['user_code']),
                    'full_name' => $user['full_name'],
                    'email_address' => $user['email_address'],
                    'user_photo' => $user_photo,
                    'user_type'  => $user['user_type_id']
                ];

                $this->session->set_userdata($session_data);

                $this->updateLastLogin($user['user_code']);
                $this->loginHistory('login', $user['user_code']);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function updateLastLogin($user_code)
    {
        $this->db->where('user_code', $user_code)->set('last_login', date('Y-m-d H:i:s'))->update('user_account');
    }

    function loginHistory($status, $user_code)
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->is_robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->is_mobile();
        } else {
            $agent = "Unidentified User Agent.";
        }

        $history = [
            'user_code' => $user_code,
            'address' => $ip_address,
            'operating_system' => $this->agent->platform(),
            'browser' => $agent,
            'date' => date('Y-m-d H:i:s'),
            'status' => $status
        ];

        $this->db->insert('user_login_history', $history);
    }
}

/* End of file M_login.php */
