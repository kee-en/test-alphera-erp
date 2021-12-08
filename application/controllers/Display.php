<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Display extends CI_Controller
{
    public function index()
    {
        $data = [
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Welcome to Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('index');
        $this->load->view('include/script');
    }
}
