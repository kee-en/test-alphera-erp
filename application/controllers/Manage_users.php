<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }
    }

    public function index()
    {
        $data = [
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Manage Users | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('users/manage_users');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_all_users()
    {
        $users = $this->global->getAllUsers();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length =  intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($users as $row) {
            $user_type = $this->global->getUserGroupById($row['user_type_id']);

            $action = '<button type="button" onclick="change_user_access(\'' . $this->global->ecdc('ec', $row['user_code']) . '\')" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#change_user_access_modal">Change User Access</button>
                    <button type="button" onclick="change_user_password(\'' . $this->global->ecdc('ec', $row['user_code']) . '\')" class="btn btn-outline-primary btn-xs">Change Password</button>
                    <button type="button" onclick="deactivate_account(\'' . $this->global->ecdc('ec', $row['user_code']) . '\')" class="btn btn-outline-danger btn-xs">Deactivate Account</button>';

            $data[] = array(
                $count,
                (!$row['full_name'] ? ' - ' : $row['full_name']),
                (!$row['username'] ? ' - ' : $row['username']),
                (!$row['user_type_id'] ? ' - ' : $user_type['description']),
                (!$row['created_date'] ? ' - ' : date('F j, Y', strtotime($row['created_date']))),
                (!$row['last_login'] ? ' - ' : date('F j, Y', strtotime($row['last_login']))),
                $action
            );

            $count++;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $data
        );

        echo json_encode($result);
    }

    public function update_user_type()
    {
        $result = $this->user_group->updateUserUserType();

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Update Successfully!'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Oops, something went wrong!'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function update_user_password()
    {
        $update_user_password_form_rules = $this->validations->rules['update_user_password_form'];
        $this->form_validation->set_rules($update_user_password_form_rules);

        if ($this->form_validation->run() == FALSE) {
            $data = [
                'p_password'  => form_error('p_password'),
                'p_confirm_password'  => form_error('p_confirm_password'),
                'type'              => 'warning',
                'title'             => 'Please complete all the required fields.'
            ];
        } else {

            $result = $this->user_group->updateUserUserPassword();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Update Successfully!'
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'title' => 'Oops, something went wrong!'
                ];
            }
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function deactivate_user_account()
    {
        $result = $this->user_group->deactivateUserAccount();

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Account Deactivated Successfully!'
            ];
        } else {
            $data = [
                'type' => 'error',
                'title' => 'Oops, something went wrong!'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_user_details()
    {
        $code_hash = $this->input->post('code');
        $code = $this->global->ecdc('dc', $code_hash);
        $data = $this->global->getAccountDetails($code);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
