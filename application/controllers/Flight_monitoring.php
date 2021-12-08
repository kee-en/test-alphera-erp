<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Flight_monitoring extends CI_Controller
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
            "author" => "Alphera Marine Services, Inc.",
            "title_tag" => "Flight Monitoring | Alphera Marine Services, Inc.",
            "meta_description" => "",
        ];

        $this->load->view('include/header', $data);
        $this->load->view('include/nav');
        $this->load->view('crew/flight_monitoring');
        $this->load->view('include/footer');
        $this->load->view('include/script');
    }

    public function flight_monitoring_table()
    {
        $flight = $this->global->getAllFlights();

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $count = 1;
        $data = [];

        foreach ($flight as $key) {

            $action = '<button type="button" class="btn btn-outline-danger btn-xs" onclick="removeFlightInfo(\'' . $key['id'] . '\')">Remove</button>';
            $count_crew = count($this->all_crew->NoOfCrewAssigned($key['flight_code']));
            $data[] = [
                ($count),
                (!$key['vessel_id'] ? "-" : $this->global->getVesselById($key['vessel_id'])['vsl_name']),
                (!$key['flight_number'] ? "-" : $key['flight_number']),
                (!$key['departure_country'] ? "-" : $key['departure_country']),
                (!$key['departure_datetime'] ? "-" : date('M j, Y h:m A', strtotime($key['departure_datetime']))),
                (!$key['destination_country'] ? "-" : $key['destination_country']),
                (!$key['destination_datetime'] ? "-" : date('M j, Y h:m A', strtotime($key['destination_datetime']))),
                (!$key['airfare'] ? "-" : $key['airfare']),
                (!$key['airline'] ? "-" : $key['airline']),
                (!$key['option'] ? "-" : date('M j, Y', strtotime($key['option']))),
                (!$count_crew ? $count_crew : $count_crew),
                $action
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

    public function save_flight_information()
    {
        $add_flight_information = $this->validations->rules['add_flight_information_form'];
        $this->form_validation->set_rules($add_flight_information);

        if ($this->form_validation->run() === false) {
            $data = [
                'flight_vessel'          => form_error('flight_vessel'),
                'f_flight_number'        => form_error('f_flight_number'),
                'f_departure_country'    => form_error('f_departure_country'),
                'f_departure_date'       => form_error('f_departure_date'),
                'f_departure_time'       => form_error('f_departure_time'),
                'f_destination_country'  => form_error('f_destination_country'),
                'f_destination_date'     => form_error('f_destination_date'),
                'f_destination_time'     => form_error('f_destination_time'),
                'f_airfare'              => form_error('f_airfare'),
                'f_airline'              => form_error('f_airline'),
                'type'                   => 'warning',
                'title'                  => 'Please complete all the required fields.'
            ];
        } else {
            $result = $this->flight_monitoring->addFlightInformation();

            if ($result === true) {
                $data = [
                    'type' => 'success',
                    'title' => 'Added Successfully!'
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

    public function remove_flight_information()
    {
        $id = $this->input->post('id');

        $result = $this->flight_monitoring->removeFlightInformation($id);

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
}
