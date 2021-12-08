<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_audit_trail extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_audit_trail_count(){
        $query = $this->db->get("user_login_history");
        return $query->num_rows();
    }

    function get_audit_trail_records($limit, $start){

        $query = $this->db->select("
            ulh.user_code,
            ulh.address,
            ulh.operating_system,
            ulh.browser,
            ulh.date,
            ulh.status,
            ua.full_name")
            ->from("user_login_history ulh")
            ->join("user_account ua", "ulh.user_code = ua.user_code")
            ->limit($limit, $start)
            ->get();

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
}