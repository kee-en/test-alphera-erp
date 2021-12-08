<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_disembark extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    function getCrewDisembark2($params = array())
    {
        $this->db->select("
            c.crew_code,
            c.monitor_code,
            c.date_available,
            cc.contract_duration,
            c.status,
            c.date_updated,
            c.date_created,
            cm.insigner,
            cm.disembark,
            cm.embark,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            av.vsl_code,
            ac.description city_name,
            apr.description province_name,
            acdrs.details
        ");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("crew_poea cc", "c.crew_code = cc.crew_code", "LEFT");
        $this->db->join("cm_plan cm", "c.monitor_code = cm.offsigner", "LEFT");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("ac_disembark_routing_slip acdrs", "acdrs.monitoring_code = c.monitor_code", "LEFT");

        if (!empty($params['search']['contract_search'])) {
            if ($params['search']['contract_search'] === "+30 days") {
                $NewDate = Date('Y-m-d', strtotime($params['search']['contract_search']));
                $this->db->join("crew_poea cp", "cp.crew_code = c.crew_code", "LEFT");
                $this->db->where('cp.contract_duration <=', $NewDate);
            } else if ($params['search']['contract_search'] === "+60 days") {
                $NewDate = Date('Y-m-d', strtotime($params['search']['contract_search']));
                $LimitDate = Date('Y-m-d', strtotime("+89 days"));
                $this->db->join("crew_poea cp", "cp.crew_code = c.crew_code", "LEFT");
                $this->db->where('cp.contract_duration >=', $NewDate);
                $this->db->where('cp.contract_duration <=', $LimitDate);
            } else if ($params['search']['contract_search'] === "+90 days" || $params['search']['contract_search'] === "+100 days") {
                $NewDate = Date('Y-m-d', strtotime($params['search']['contract_search']));
                $this->db->join("crew_poea cp", "cp.crew_code = c.crew_code", "LEFT");
                $this->db->where('cp.contract_duration >=', $NewDate);
            }
        }

        if (!empty($params['search']['name_search'])) {
            $this->db->group_start();
            $this->db->like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.middle_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->group_end();
        }
        // if (!empty($params['search']['name_search'])) {
        //     $this->db->group_start();
        //     $this->db->or_like('acpi.middle_name', $params['search']['name_search']);
        //     $this->db->group_end();
        // }
        // if (!empty($params['search']['name_search'])) {
        //     $this->db->group_start();
        //     $this->db->or_like('acpi.last_name', $params['search']['name_search']);
        //     $this->db->group_end();
        // }

        if (!empty($params['search']['vessel_search'])) {
            $this->db->group_start();
            $this->db->like('c.vessel_assign', $params['search']['vessel_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['rank_search'])) {
            $this->db->group_start();
            $this->db->like('c.position', $params['search']['rank_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['flight_search'])) {
            if ($params['search']['flight_search'] === "1") {
                $this->db->where('c.flight_code !=', NULL);
            } else if ($params['search']['flight_search'] === "0") {
                $this->db->where('c.flight_code !=', NULL);
            }
        }

        if (!empty($params['search']['month_search_from']) && !empty($params['search']['month_search_to'])) {
            $this->db->where('cmp.embark >=', $params['search']['month_search_from']);
            $this->db->where('cmp.embark <=', $params['search']['month_search_to']);
        }

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->where("c.status", 4);
        $this->db->order_by("c.date_updated", "DESC");

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function getCrewDisembark($params = array())
    {
        $this->db->select("
            c.crew_code,
            c.monitor_code,
            c.date_available,
            c.status,
            cm.insigner,
            cm.offsigner,
            cm.embark,
            cm.disembark,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            ap.position_code,
            ap.position_name,
            av.vsl_name,
            av.vsl_code,
            ac.description city_name,
            apr.description province_name,
            acdrs.details
        ");

        $this->db->from("crews c");
        $this->db->join("cm_plan cm", "c.monitor_code = cm.offsigner", "LEFT");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("ac_disembark_routing_slip acdrs", "acdrs.monitoring_code = c.monitor_code", "LEFT");

        // if (!empty($params['search']['contract_search'])) {
        //     $this->db->group_start();
        //     $NewDate = Date('Y-m-d', strtotime($params['search']['contract_search']));
        //     $this->db->where('cm.disembark >=', $NewDate);
        //     $this->db->group_end();
        // }

        if (!empty($params['search']['contract_search'])) {
            $this->db->group_start();

            $NewDate = Date('Y-m-d', strtotime($params['search']['contract_search']));
            $this->db->join("crew_poea cp", "cp.crew_code = c.crew_code", "LEFT");

            if ($params['search']['contract_search'] === "+30 days") {
                // LESS THAN 30 DAYS
                $this->db->where('cp.contract_duration <=', $NewDate);
            } else if ($params['search']['contract_search'] === "+60 days") {
                // LESS THAN 60 DAYS
                $this->db->where('cp.contract_duration <=', $NewDate);
            } else if ($params['search']['contract_search'] === "+90 days") {
                // LESS THAN 90 DAYS
                $this->db->where('cp.contract_duration <=', $NewDate);
            } else {
                // 90 ABOVE
                $this->db->where('cp.contract_duration >=', $NewDate);
            }
            $this->db->group_end();
        }



        if (!empty($params['search']['name_search'])) {
            $this->db->group_start();
            $this->db->like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.middle_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.last_name, acpi.first_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->group_end();
        }

        if (!empty($params['search']['vessel_search'])) {
            $this->db->group_start();
            $this->db->where('c.vessel_assign', $params['search']['vessel_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['rank_search'])) {
            $this->db->group_start();
            $this->db->where('c.position', $params['search']['rank_search']);
            $this->db->group_end();
        }


        if (!empty($params['search']['month_search_from']) && !empty($params['search']['month_search_to'])) {
            $this->db->group_start();
            $this->db->where('cm.embark >=', $params['search']['month_search_from']);
            $this->db->where('cm.embark <=', $params['search']['month_search_to']);
            $this->db->group_end();
        }


        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->where("c.status", 4);
        $this->db->order_by("cm.disembark", "DESC");
        // $this->db->order_by("c.date_created", "DESC");

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }
}

/* End of file M_disembark.php */
