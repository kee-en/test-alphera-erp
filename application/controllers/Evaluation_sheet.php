<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Evaluation_sheet extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        if (!$this->session->userdata('user_code')) {
            redirect(base_url(), 'refresh');
        }
    }

    public function index()
    {
        $data = [
                "position_list" => $this->global->getAllPosition(),
                "author" => "Alphera Marine Services, Inc.",
                "title_tag" => "Evaluation Sheet | Alphera Marine Services, Inc.",
                "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('settings/evaluation_sheet', $data);
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function save_edit_evaluation_sheet_form()
    {
        $id = $this->input->post('position_list');

        $result = $this->evaluation_sheet_form->saveEditEvaluationSheetForm($id);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Saved Successfully!'
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
}
