<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function index()
    {
        $data = [
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Log In | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('auth/login');
        $this->load->view('include/script');
    }

    public function auth()
    {
        $result = $this->login->authUser();

        if ($result === true) {
            $data = [
                'type'  => 'success',
                'title' => 'Log In Success!',
                'text'  => 'You can now close this window and continue using the Alphera ERP Web System.'
            ];
        } else {
            $data = [
                'type'  => 'error',
                'title' => 'Sorry, we were not able to find a user with that username and password.'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function deAuth()
    {
        $this->session->sess_destroy();
        redirect(base_url('login'), 'refresh');
    }
}
