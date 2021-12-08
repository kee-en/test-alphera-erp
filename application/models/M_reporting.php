<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_reporting extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    function gerCrewReporting($params = array())
    {
        $this->db->select("
            c.crew_code,
            c.monitor_code,
            c.date_available,
            cc.contract_duration,
            c.status,
            CONCAT(acpi.first_name, ' ',acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            av.vsl_code,
            ac.description city_name,
            apr.description province_name
        ");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");
        $this->db->join("crew_poea cc", "c.crew_code = cc.crew_code", "LEFT");

        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");


        if (!empty($params['search']['name_search'])) {
            $this->db->group_start();
            $this->db->like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.middle_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.last_name, acpi.first_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->group_end();
        }

        if (!empty($params['search']['vessel_search'])) {
            $this->db->where('c.assign_vessel', $params['search']['vessel_search']);
        }
        if (!empty($params['search']['rank_search'])) {
            $this->db->where('c.position', $params['search']['rank_search']);
        }

        $this->db->where("c.status", "5");
        $this->db->order_by("c.date_updated");

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function createOnVacationCrew()
    {
        $crew_code = $this->input->post('report_crew_code');

        $last_monitor = $this->db->where('crew_code', $crew_code)->order_by('id', 'DESC')->get('crews')->row_array();

        $vessel_history = $this->db->where('crew_code', $crew_code)->order_by('id', 'DESC')->get('ac_sea_service_record')->row_array();
        $poea_data = $this->db->where('crew_code', $crew_code)->order_by('id', 'DESC')->get('crew_poea')->row_array();

        $vessel = json_decode($vessel_history['name_of_vessel'], true);
        $vsl_name = $this->global->getVesselById($last_monitor['vessel_assign'])['vsl_name'];
        array_push($vessel, $vsl_name);

        $flag = json_decode($vessel_history['flag'], true);
        if (!empty($poea_data['flag'])) {
            array_push($flag, $poea_data['flag']);
        }

        $salary = json_decode($vessel_history['salary'], true);
        if (!empty($poea_data['total_salary'])) {
            array_push($salary, $poea_data['total_salary']);
        }

        $rank = json_decode($vessel_history['rank'], true);
        $pos_name = $this->global->getPositionById($last_monitor['position']);
        array_push($rank, $pos_name);

        $vsl_engine = json_decode($vessel_history['type_of_vsl_eng'], true);
        if (!empty($poea_data['vessel_type'])) {
            array_push($vsl_engine, $poea_data['vessel_type']);
        }

        $power = json_decode($vessel_history['grt_power'], true);
        if (!empty($poea_data['grt'])) {
            array_push($power, $poea_data['grt']);
        }

        $embark = json_decode($vessel_history['embarked'], true);
        array_push($embark, $last_monitor['embark_date']);

        $disembark = json_decode($vessel_history['disembarked'], true);
        if (!empty($poea_data['contract_duration'])) {
            array_push($disembark, $poea_data['contract_duration']);
        }

        // $sea_service = json_decode($vessel_history['total_service'], true);
        // array_push($sea_service, $this->input->post('r_sea_service'));

        $agency = json_decode($vessel_history['agency'], true);
        if (!empty($poea_data['agent_name'])) {
            array_push($agency, $poea_data['agent_name']);
        }

        $monitor_code = $this->global->generateID('MNT');

        $sea_service_record = [
            'applicant_code'  => $last_monitor['applicant_code'],
            'crew_code'       => $crew_code,
            'name_of_vessel'  => json_encode($vessel),
            'flag'            => json_encode($flag),
            'salary'          => json_encode($salary),
            'rank'            => json_encode($rank),
            'type_of_vsl_eng' => json_encode($vsl_engine),
            'grt_power'       => json_encode($power),
            'embarked'        => json_encode($embark),
            'disembarked'     => json_encode($disembark),
            // 'total_service'   => json_encode($sea_service),
            'agency'          => json_encode($agency),
            'date_created'    => date("Y-m-d H:i:s"),
        ];

        $new_monitor = [
            'position' => $this->input->post('r_position'),
            'vessel_assign' => $this->input->post('r_tentative_vessel'),
            'date_available' => date("Y-m-d", strtotime($this->input->post('r_date_availability'))),
            'flight_code' => NULL,
            'embark_date' => NULL,
            'status' => 7,
            'date_updated' =>  date("Y-m-d H:i:s"),
        ];

        $position_history = [
            'crew_code' => $last_monitor['crew_code'],
            'applicant_code' => $last_monitor['applicant_code'],
            'position'  => $last_monitor['position'],
            'vessel'    => $last_monitor['vessel_assign'],
            'availability_date' => $last_monitor['date_available'],
            'date_created' =>  date("Y-m-d")
        ];

        $crew_grade = [
            'monitor_code' => $last_monitor['monitor_code'],
            'crew_code' => $last_monitor['crew_code'],
            'position'  => $last_monitor['position'],
            'vessel'    => $last_monitor['vessel_assign'],
            'embark_date'   => $last_monitor['embark_date'],
            'disembarked_date'   => !empty($poea_data['contract_duration']) ? $poea_data['contract_duration'] : NULL,
            'grade'     => $this->input->post('r_crew_evaluation'),
            'date_created'  => date('Y-m-d H:s:i'),
            'status'    => 1
        ];

        $db_archive = $this->load->database('archive', TRUE);

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->where('monitor_code', $last_monitor['monitor_code'])->update('crews', $new_monitor);
        $this->db->where('offsigner', $last_monitor['monitor_code'])->set('status', 0)->update('cm_plan');
        $this->db->where('crew_code', $last_monitor['monitor_code'])->update('ac_sea_service_record', $sea_service_record);

        $this->db->insert('crew_grade', $crew_grade);
        $this->db->insert('last_position_history', $position_history);

        // $db_archive->insert('crews', $last_monitor);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
}

/* End of file M_reporting.php */
