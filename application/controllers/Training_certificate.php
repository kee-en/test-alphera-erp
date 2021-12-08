<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Training_certificate extends CI_Controller
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
            "title_tag" => "Training Certificate | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('settings/requirements/training_certificate');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function add_training_certificate()
    {
        $certificate_form_rules = $this->validations->rules['certificate_form'];
        $this->form_validation->set_rules($certificate_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'cert_code'  => form_error('cert_code'),
                'cert_name' => form_error('cert_name'),
            ];
        } else {
            $result = $this->training_certificate->addTrainingCertificate();

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
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_training_certificate_table()
    {
        $certificates = $this->global->getAllTrainingCertificates();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($certificates as $key) {

            $actions = '<button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#edit_certificate_modal" onclick="editTrainingcertificate(\'' . $key['id'] . '\')" data-backdrop="static" data-keyboard="false">Edit</button> <button type="button" class="btn btn-outline-danger btn-xs" onclick="removeTrainingCertificates(\'' . $key['id'] . '\')" >Remove</button>';

            $data[] = [
                $count,
                $key['cert_code'],
                $key['cert_name'],
                ($key['with_cop'] == 1 ? '<span class="badge badge-primary badge-status">W/COP</span>' : '<span class="badge badge-danger badge-status">W/O COP</span>'),
                ($key['required'] == 1 ? "YES" : "NO"),
                $actions
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

    function remove_training_certificates()
    {
        $id = $this->input->post('id');

        $result = $this->training_certificate->removeTrainingCertificate($id);

        if ($result === true) {
            $data = [
                'type' => 'success',
                'title' => 'Removed Successfully!'
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

    public function save_edit_training_certificate()
    {
        $e_certificate_form_rules = $this->validations->rules['e_certificate_form'];
        $this->form_validation->set_rules($e_certificate_form_rules);

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'e_cert_code'  => form_error('e_cert_code'),
                'e_cert_name' => form_error('e_cert_name'),
                'type' => 'warning',
                'title' => 'Please complete all the required fields.'
            ];
        } else {
            $result = $this->training_certificate->saveEditTrainingCertificate();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Update Successfully!'
                ];
            } else {
                $data = [
                    'type' => 'warning',
                    'title' => 'No changes had been made.'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
