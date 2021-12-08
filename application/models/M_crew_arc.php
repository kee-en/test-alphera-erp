<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_crew_arc extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function FilterLicenses($params = array())
    {
        $db_archive = $this->load->database('archive', TRUE);
        $result = [];
        $db_archive->select("c.position, c.vessel_assign, c.crew_code, c.monitor_code, cmp.disembark");
        $db_archive->from("arc_crews c");
        $db_archive->join("arc_cm_plan cmp", "cmp.insigner = c.monitor_code");

        if(!empty($params['search']['position']) && $params['search']['position'] != "all"){
            $this->db->where('c.position', $params['search']['position']);
        }
        if(!empty($params['search']['vessel']) && $params['search']['vessel'] != "all"){
            $this->db->where('c.vessel_assign', $params['search']['vessel']);
        }
        if(!empty($params['search']['disembarked_from']) && !empty($params['search']['disembarked_to'])){
            $this->db->where('cmp.disembark >=', $params['search']['disembarked_from']);
            $this->db->where('cmp.disembark <=', $params['search']['disembarked_to']);
        }

        $db_archive->where('c.status !=', 0);
        $db_archive->group_by('c.crew_code');
        $crew = $db_archive->get()->result_array();

        foreach ($crew as $key) {
            array_push($result, $this->consolidate($key['crew_code']));
        }

        return json_encode($result);
    }

    function consolidate($crew){

        $db_archive = $this->load->database('archive', TRUE);

        $db_archive->select("position, vessel_assign, crew_code, monitor_code");
        $db_archive->from("arc_crews");
        $db_archive->where('crew_code', $crew);
        
        $db_archive->order_by("date_created", "DESC");
        return $db_archive->get()->result_array();
    }

    function getCrewArcCMP($monitor_code)
    {
        $db_archive = $this->load->database('archive', TRUE);
        return $db_archive->where('offsigner', $monitor_code)->get('arc_cm_plan')->row_array();
    }

    function getCrewArcLicense($crew_code)
    {
        $db_archive = $this->load->database('archive', TRUE);
        return $db_archive->where('crew_code', $crew_code)->get('arc_licenses_endorsement_book_id')->row_array();
    }

    public function get_last_vessel($monitor_code)
    {
        $db_archive = $this->load->database('archive', TRUE);
        $db_archive->select('vessel_code as last_vessel');
        $db_archive->from('arc_cm_plan');
        $db_archive->where('offsigner', $monitor_code);
        $db_archive->order_by('date_created', 'ASC');
        $db_archive->limit(1);
        return $db_archive->get()->row_array();
    }
}