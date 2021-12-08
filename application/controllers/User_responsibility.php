<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_responsibility extends CI_Controller
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
                "title_tag" => "User Responsibility | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('users/user_responsibility');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function get_user_group_table()
    {
        $user_group = $this->global->getAllUserGroup();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($user_group as $key) {

            $data[] = [
                $count,
                $key['code'],
                $key['description'],
            ];

            $count++;
        }

        $result = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $data
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
