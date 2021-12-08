<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_flight_monitoring extends CI_Model
{

    function addFlightInformation()
    {
        $flight_code = $this->global->generateID("FLT");

        $data = [
            'flight_code'   => $flight_code,
            'vessel_id' => $this->input->post('flight_vessel'),
            'flight_number' => $this->input->post('f_flight_number'),
            'departure_datetime'    => date('Y-m-d H:i', strtotime($this->input->post('f_departure_date') . " " . $this->input->post('f_departure_time'))),
            'departure_country' => $this->input->post('f_departure_country'),
            'destination_datetime' => date('Y-m-d H:i', strtotime($this->input->post('f_destination_date') . " " . $this->input->post('f_destination_time'))),
            'destination_country' => $this->input->post('f_destination_country'),
            'airfare'   => $this->input->post('f_airfare'),
            'airline'   => $this->input->post('f_airline'),
            'option'    => !empty($this->input->post('f_option_date')) && !is_null($this->input->post('f_option_date')) ?  date('Y-m-d', strtotime($this->input->post('f_option_date'))) : "",
            'date_created'  => date('Y-m-d H:i:s')
        ];

        $this->db->insert('crew_flight', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function removeFlightInformation($id)
    {
        $this->db->where('id', $id)->set('status', 0)->update('crew_flight');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function Filterflights($params = array())
    {
        $this->db->select("
            cf.*,
            c.crew_code,
            c.flight_code,
            av.vsl_name,
            ap.position_name,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.birth_date,
            cmp.insigner,
            cmp.remarks,
            aclc.number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("crew_flight cf", "cf.flight_code = c.flight_code");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("ac_licenses_endorsement_book_id aclc", "aclc.crew_code = c.crew_code", "LEFT");

        if (!empty($params[0]['position']) && $params[0]['position'] != "all") {
            $this->db->where('c.position', $params[0]['position']);
        }
        if (!empty($params[0]['vessel']) && $params[0]['vessel'] != "all") {
            $this->db->where('c.vessel_assign', $params[0]['vessel']);
        }
        if (!empty($params[0]['depart_from']) && !empty($params[0]['depart_to'])) {
            $this->db->where('cf.departure_datetime >=', $params[0]['depart_from']);
            $this->db->where('cf.departure_datetime <=', $params[0]['depart_to']);
        }

        $this->db->where('c.status !=', 0);
        $this->db->order_by("cf.date_created", "DESC");

        $query = $this->db->get();

        return (($query->num_rows() > 0) ? $query->result_array() : []);
    }
}

/* End of file M_flight_monitoring.php */
