<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Watchlisted_reasons extends CI_Controller {

	public function index()
	{
        $data = [
				"author" => "Alphera Marine Services, Inc.",
				"title_tag" => "Watchlisted Reasons | Alphera Marine Services, Inc.",
				"meta_description" => "",
		];

		$this->load->view('include/header', $data);
		$this->load->view('include/nav');
		$this->load->view('settings/watchlisted_reasons');
		$this->load->view('include/footer');
		$this->load->view('include/script');
	}
}
