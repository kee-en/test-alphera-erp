<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_crew_grade_report extends CI_Model
{
    public function get_crew_grade_report($params = array())
    {
        $agency = "Alphera";

        $this->db->select("
            COUNT(cg.crew_code) as grade_count,
            cg.grade
        ");
        $this->db->from("crew_grade cg");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = cg.crew_code", "LEFT");

        if (!empty($params['search']['rank'])) {
            $this->db->where('cg.position', $params['search']['rank']);
        }
        if (!empty($params['search']['reason'])) {
            $this->db->where('acwl.reason', $params['search']['reason']);
        }

        if (!empty($params['search']['crew_type'])) {
            if ($params['search']['crew_type'] == 1) {
                $this->db->like('LOWER(acsr.agency)', strtolower($agency));
            } else {
                $this->db->not_like('LOWER(acsr.agency)', strtolower($agency));
            }
        }

        if (!empty($params['search']['month_from'])) {
            $this->db->group_start();
            $this->db->where('cg.date_created >=', $params['search']['month_from']);
            $this->db->where('cg.date_created <=', $params['search']['month_from']);
            $this->db->group_end();
        }

        // $this->db->group_by('cg.grade');
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function get_crew_grade_report_compara($params = array())
    {
        $agency = "Alphera";

        $this->db->select("
            COUNT(cg.crew_code) as grade_count_compara,
            cg.grade
        ");
        $this->db->from("crew_grade cg");
        $this->db->join("ac_sea_service_record acsr", "acsr.crew_code = cg.crew_code", "LEFT");

        if (!empty($params['search']['rank'])) {
            $this->db->where('cg.position', $params['search']['rank']);
        }
        if (!empty($params['search']['reason'])) {
            $this->db->where('acwl.reason', $params['search']['reason']);
        }

        if (!empty($params['search']['crew_type'])) {
            if ($params['search']['crew_type'] == 1) {
                $this->db->like('LOWER(acsr.agency)', strtolower($agency));
            } else {
                $this->db->not_like('LOWER(acsr.agency)', strtolower($agency));
            }
        }

        if (!empty($params['search']['month_to'])) {
            $this->db->group_start();
            $this->db->where('cg.date_created >=', $params['search']['month_to']);
            $this->db->where('cg.date_created <=', $params['search']['month_to']);
            $this->db->group_end();
        }

        // $this->db->group_by('cg.grade');
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}