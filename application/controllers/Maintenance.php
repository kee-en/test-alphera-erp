<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

	public function index()
	{
		$data = [
            'author' => "Alphera Marine Services, Inc.",
            'title_tag' => "Site Maintenance",
            'meta_description' => "",
        ];

        $this->load->view('include/header', $data);
		$this->load->view('maintenance');
		$this->load->view('include/script');
	}
}
