<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_general_crew_report extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function total_crew_onboard($dur_type, $duration, $vsl_type)
    {

        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime($duration));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");

        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("a_vessels v", "v.id = c.vessel_assign", "LEFT");
        $this->db->join("a_type_of_vessel vt", "vt.id = v.vsl_type", "LEFT");

                if ($dur_type == 1) {
                    if (!empty($vsl_type)) {
                        $this->db->where(array("vt.id" => $vsl_type, "MONTH(c.date_updated)" => $month, "YEAR(c.date_updated)" => $year, "c.status" => "2"));
                    }else{
                        $this->db->where(array("MONTH(c.date_updated)" => $month, "YEAR(c.date_updated)" => $year, "c.status" => "2"));
                    }
                } else {
                    if ($vsl_type != "") {
                        $this->db->where(array("vt.id" => $vsl_type, "YEAR(c.date_updated)" => $year, "c.status" => "2"));
                    }else{
                        $this->db->where(array("YEAR(c.date_updated)" => $year, "c.status" => "2"));
                    }
                }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function total_crew_deployed($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime($duration));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");

        if ($dur_type == 1) {
            $this->db->where(array("MONTH(cmp.embark)" => $month, "YEAR(cmp.embark)" => $year, "c.status" => "3"));
        } else {
            $this->db->where(array("YEAR(cmp.embark)" => $year, "c.status" => "3"));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function total_new_hire_deployed($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime($duration));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");

        if ($dur_type == 1) {
            $this->db->where(array("MONTH(cmp.embark)" => $month, "YEAR(cmp.embark)" => $year, "c.status" => "3"));
            $this->db->not_like('acsr.agency', 'ALPHERA');
        } else {
            $this->db->where(array("YEAR(cmp.embark)" => $year, "c.status" => "3"));
            $this->db->not_like('acsr.agency', 'ALPHERA');
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function total_ex_crew_deployed($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime($duration));
        $agency = 'Alphera';

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");

        if ($dur_type == "1") {
            $this->db->not_like('LOWER(acsr.agency)', strtolower($agency));
            $this->db->where(array('MONTH(cmp.embark)' => $month, 'YEAR(cmp.embark)' => $year, "c.status" => "3"));
        } else {
            $this->db->not_like('LOWER(acsr.agency)', strtolower($agency));
            $this->db->where(array('YEAR(cmp.embark)' => $year, "c.status" => "3"));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function total_crew_finished_contract($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime($duration));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "c.status" => "4", "acwl.crew_code != c.crew_code"));
        } else {
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "c.status" => "4", "acwl.crew_code != c.crew_code"));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function total_crew_with_illness($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime($duration));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "c.status" => "4", "acwl.reason ", 3));
        } else {
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "c.status" => "4", "acwl.reason ", 3));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function total_crew_with_injury($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime($duration));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "acwl.reason ", 6));
        } else {
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "acwl.reason ", 6));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function total_crew_with_disciplinary($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime($duration));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "acwl.reason ", 4));
        } else {
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "acwl.reason ", 4));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function total_crew_own_request($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime($duration));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "acwl.reason ", 5));
        } else {
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "acwl.reason ", 5));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function total_crew_jumpship($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime($duration));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "acwl.reason ", 9));
        } else {
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "acwl.reason ", 9));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function total_crew_casualty_cases($dur_type, $duration, $remarks)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime($duration));

        $this->db->select("
            COUNT(c.id) as crew_number,
            acwl.remarks
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->like('LOWER(acwl.remarks)', strtolower($remarks));
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "acwl.reason ", 11));
        } else {
            $this->db->like('LOWER(acwl.remarks)', strtolower($remarks));
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "acwl.reason ", 11));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function total_crew_vessel_reduction($dur_type, $duration, $remarks)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime($duration));

        $this->db->select("
            COUNT(c.id) as crew_number,
            acwl.remarks
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->like('LOWER(acwl.remarks)', strtolower($remarks));
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "acwl.reason ", 10));
        } else {
            $this->db->like('LOWER(acwl.remarks)', strtolower($remarks));
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "acwl.reason ", 10));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    //Comparative
    public function compara_total_crew_onboard($dur_type, $duration, $vsl_type)
    {

        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime(''.$duration.' -1 year'));
        $agency = 'Alphera';

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");
        $this->db->join("a_vessels v", "v.id = c.vessel_assign", "LEFT");
        $this->db->join("a_type_of_vessel vt", "vt.id = v.vsl_type", "LEFT");

        if ($dur_type == "1") {
            if (!empty($vsl_type)) {
                $this->db->where("vt.id", $vsl_type);
            }
            $this->db->like('LOWER(acsr.agency)', strtolower($agency));
            $this->db->where(array('MONTH(cmp.embark)' => $month, 'YEAR(cmp.embark)' => $year, "c.status" => "3"));
        } else {
            if (!empty($vsl_type)) {
                $this->db->where("vt.id", $vsl_type);
            }
            $this->db->like('LOWER(acsr.agency)', strtolower($agency));
            $this->db->where(array('YEAR(cmp.embark)' => $year, "c.status" => "3"));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function compara_total_crew_deployed($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime(''.$duration.' -1 year'));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");

        if ($dur_type == 1) {
            $this->db->where(array("MONTH(cmp.embark)" => $month, "YEAR(cmp.embark)" => $year, "c.status" => "3"));
        } else {
            $this->db->where(array("YEAR(cmp.embark)" => $year, "c.status" => "3"));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function compara_total_new_hire_deployed($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime(''.$duration.' -1 year'));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");

        if ($dur_type == 1) {
            $this->db->where(array("MONTH(cmp.embark)" => $month, "YEAR(cmp.embark)" => $year, "c.status" => "3"));
            $this->db->not_like('acsr.agency', 'ALPHERA');
        } else {
            $this->db->where(array("YEAR(cmp.embark)" => $year, "c.status" => "3"));
            $this->db->not_like('acsr.agency', 'ALPHERA');
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function compara_total_ex_crew_deployed($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime(''.$duration.' -1 year'));
        $agency = 'Alphera';

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");

        if ($dur_type == "1") {
            $this->db->not_like('LOWER(acsr.agency)', strtolower($agency));
            $this->db->where(array('MONTH(cmp.embark)' => $month, 'YEAR(cmp.embark)' => $year, "c.status" => "3"));
        } else {
            $this->db->not_like('LOWER(acsr.agency)', strtolower($agency));
            $this->db->where(array('YEAR(cmp.embark)' => $year, "c.status" => "3"));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function compara_crew_finished_contract($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime(''.$duration.' -1 year'));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "c.status" => "4", "acwl.crew_code != c.crew_code"));
        } else {
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "c.status" => "4", "acwl.crew_code != c.crew_code"));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function compara_crew_with_illness($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime(''.$duration.' -1 year'));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "c.status" => "4", "acwl.reason ", 3));
        } else {
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "c.status" => "4", "acwl.reason ", 3));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function compara_crew_with_injury($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime(''.$duration.' -1 year'));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "acwl.reason ", 6));
        } else {
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "acwl.reason ", 6));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function compara_crew_with_disciplinary($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime(''.$duration.' -1 year'));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "acwl.reason ", 4));
        } else {
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "acwl.reason ", 4));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function compara_crew_own_request($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime(''.$duration.' -1 year'));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "acwl.reason ", 5));
        } else {
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "acwl.reason ", 5));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function compara_crew_jumpship($dur_type, $duration)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime(''.$duration.' -1 year'));

        $this->db->select("
            COUNT(c.id) as crew_number
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "acwl.reason ", 9));
        } else {
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "acwl.reason ", 9));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function compara_crew_casualty_cases($dur_type, $duration, $remarks)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime(''.$duration.' -1 year'));

        $this->db->select("
            COUNT(c.id) as crew_number,
            acwl.reason
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->like('LOWER(acwl.remarks)', strtolower($remarks));
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "acwl.reason ", 11));
        } else {
            $this->db->like('LOWER(acwl.remarks)', strtolower($remarks));
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "acwl.reason ", 11));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }

    public function compara_crew_vessel_reduction($dur_type, $duration, $remarks)
    {
        $month = date('m',strtotime($duration));
        $year = date('Y',strtotime(''.$duration.' -1 year'));

        $this->db->select("
            COUNT(c.id) as crew_number,
            acwl.reason
        ");
        $this->db->from("crews c");
        $this->db->join("cm_plan cmp", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        
        if ($dur_type == "1") {
            $this->db->like('LOWER(acwl.remarks)', strtolower($remarks));
            $this->db->where(array('MONTH(cmp.disembark)' => $month, 'YEAR(cmp.disembark)' => $year, "acwl.reason ", 10));
        } else {
            $this->db->like('LOWER(acwl.remarks)', strtolower($remarks));
            $this->db->where(array('YEAR(cmp.disembark)' => $year, "acwl.reason ", 10));
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }


    // Illness Count
    public function injury_illness_rate($params = array())
    {
        $agency = "Alphera";

        $this->db->select("
            COUNT(c.id) as numbers,
            ap.position_name as rank
        ");
        $this->db->from("crews c");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("ac_warning_letter acwl", "acwl.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = c.crew_code", "LEFT");

        if (!empty($params['search']['reason'])) {
            $this->db->where('acwl.reason', $params['search']['reason']);
        }

        if (!empty($params['search']['crew-type'])) {
            if ($params['search']['crew-type'] == 1) {
                $this->db->like('LOWER(acsr.agency)', strtolower($agency));
            } else {
                $this->db->not_like('LOWER(acsr.agency)', strtolower($agency));
            }
        }

        if (!empty($params['search']['month_from']) && !empty($params['search']['month_to'])) {
            $this->db->group_start();
            $this->db->where('acwl.date_created >=', $params['search']['month_from']);
            $this->db->where('acwl.date_created <=', $params['search']['month_to']);
            $this->db->group_end();
        }

        $this->db->group_by('acwl.rank');
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    //Warning Letter Report
    public function get_warning_letter_report($date, $params = array())
    {
        $agency = "Alphera";

        $this->db->select("
            COUNT(acwl.applicant_code) as wl_count,
            ap.position_name as rank
        ");
        $this->db->from("ac_warning_letter acwl");
        $this->db->join("a_position ap", "acwl.rank = ap.id", "LEFT");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = acwl.crew_code", "LEFT");

        if (!empty($params['search']['reason'])) {
            $this->db->where('acwl.reason', $params['search']['reason']);
        }
        if (!empty($params['search']['crew-type'])) {
            if ($params['search']['crew-type'] == 1) {
                $this->db->like('LOWER(acsr.agency)', strtolower($agency));
            } else {
                $this->db->not_like('LOWER(acsr.agency)', strtolower($agency));
            }
        }

        $this->db->where('acwl.date_created', $date);

        $this->db->group_by('acwl.rank');
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : [];
    }
}