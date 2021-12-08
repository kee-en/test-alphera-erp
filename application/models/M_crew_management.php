<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_crew_management extends CI_Model
{

    function getOffSignerCrew($params = array())
    {
        $this->db->select("
            c.applicant_code,
            cmp.cmp_code,
            cmp.offsigner,
            cmp.insigner,
            cmp.disembark,
            cmp.embark,
            cmp.sign_on,
            cmp.date_x,
            cmp.x_port,
            cmp.months_onboard,
            cmp.remarks,
            c.crew_code,
            c.monitor_code,
            cmp.status,
            c.embark_date,
            c.date_available,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.applicant_code,
            ap.id position_id,
            ap.position_code,
            ap.position_name,
            av.id vessel_id,
            av.vsl_name,
            av.vsl_code,
            ac.description city_name,
            apr.description province_name,
            cg.grade
        ");
        $this->db->from("cm_plan cmp");
        $this->db->join("crews c", "cmp.offsigner = c.monitor_code", "LEFT");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");

        $this->db->join("a_position ap", "cmp.position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "cmp.vessel_code = av.id", "LEFT");
        $this->db->join("a_city ac", "acpi.city = ac.id", "LEFT");
        $this->db->join("a_province apr", "acpi.region = apr.id", "LEFT");
        $this->db->join("crew_grade cg", "cg.crew_code = c.crew_code", "LEFT");

        $this->db->group_start();
        $this->db->or_where('cmp.status', 3);
        $this->db->group_end();

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
            // $this->db->group_start();
            // $this->db->like('acpi.first_name', trim($params['search']['name_search']));
            // $this->db->or_like('acpi.middle_name', trim($params['search']['name_search']));
            // $this->db->or_like('acpi.last_name', trim($params['search']['name_search']));
            // $this->db->group_end();
        }

        if (!empty($params['search']['vessel_search'])) {
            $this->db->group_start();
            $this->db->where('av.id', $params['search']['vessel_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['rank_search'])) {
            $this->db->group_start();
            $this->db->like('c.position', $params['search']['rank_search']);
            $this->db->group_end();
        }

        // if (!empty($params['search']['status_search'])) {
        //     $this->db->group_start();
        //     $this->db->like('c.status', $params['search']['status_search']);
        //     $this->db->group_end();
        // }

        if (!empty($params['search']['flight_search'])) {
            $this->db->group_start();
            if ($params['search']['flight_search'] === "1") {
                $this->db->where('c.flight_code !=', NULL);
            } else if ($params['search']['flight_search'] === "0") {
                $this->db->where('c.flight_code !=', NULL);
            }
            $this->db->group_end();
        }

        if (!empty($params['search']['month_search_from']) && !empty($params['search']['month_search_to'])) {
            $this->db->group_start();
            $this->db->where('cmp.embark >=', $params['search']['month_search_from']);
            $this->db->where('cmp.embark <=', $params['search']['month_search_to']);
            $this->db->group_end();
        }

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->order_by('cmp.date_created', 'DESC');
        $this->db->group_by('cmp.offsigner');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    function getOnSignerCrew($positon_id, $cmp_code, $monitor_code, $input_number)
    {
        $cm_plan = $this->db->where('cmp_code', $cmp_code)->get('cm_plan')->row_array();

        $this->db->select("c.monitor_code, c.crew_code, CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name, c.date_available, c.status");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->group_start();
        $this->db->where('c.status', 7);
        $this->db->or_where('c.status', 1);
        $this->db->group_end();

        $query = $this->db->get();
        $crewOnSigner = ($query->num_rows() > 0) ?  $query->result_array() : [];

        $selectOnsigner = null;
        $disable = null;
        if ($cm_plan['insigner']) {
            $this->db->select("c.monitor_code, c.crew_code, CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name, c.date_available, c.status");
            $this->db->from("crews c");
            $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");
            $this->db->where('c.monitor_code', $cm_plan['insigner']);
            $selectOnsigner = $this->db->get()->row_array();

            if ($selectOnsigner) {
                $disable = ($cm_plan['insigner'] === $selectOnsigner['monitor_code']) ? "disabled" : "";
            }
        }

        $option = '<select class="custom-select" id="on_signer_crew_' . $cmp_code . '_' . $input_number . '" name="on_signer_crew" onchange="selectOnSigner(\'' . $cmp_code . '\',\'' . $input_number . '\')" style="font-weight: 500;letter-spacing: 0.5px;" ' . $disable . '>';
        $option .= '<option value="">Select Crew On Signer</option>';
        $option .= '<optgroup label="Ex-Crew">';
        foreach ($crewOnSigner as $key) {
            if ($key['status'] === '7') {
                $option .= '<option value="' . $key['monitor_code'] . '">' . $key['full_name'] . " - " . (($key['date_available'] != NULL) ? date("F j,Y", strtotime($key['date_available'])) : "-") . '</option>';
            }
        }

        $option .= '</optgroup>';
        $option .= ' <optgroup label="New Crew">';

        foreach ($crewOnSigner as $key) {
            if ($key['status'] === '1') {

                $option .= '<option value="' . $key['monitor_code'] . '" >' . $key['full_name'] . " - " . (($key['date_available'] != NULL) ? date("F j,Y", strtotime($key['date_available'])) : "-") . '</option>';
            }
        }

        $option .= '</optgroup>';

        if ($selectOnsigner) {
            $selected = ($cm_plan['insigner'] === $selectOnsigner['monitor_code']) ? "selected" : "";
            $option .= '<option value="' . $selectOnsigner['monitor_code'] . '" ' . $selected . ' >' . $selectOnsigner['full_name'] . " - " . date("F j,Y", strtotime($selectOnsigner['date_available'])) . '</option>';
        }

        $option .= '</select>';

        return $option;
    }

    function selectOnSigner()
    {
        $cmp_code = $this->input->post('cmp_code');
        $os_monitor_code = $this->input->post('monitor_code');

        $crew = $this->db->where('monitor_code', $os_monitor_code)->get('crews')->row_array();
        $cm_plan = $this->db->where('cmp_code', $cmp_code)->get('cm_plan')->row_array();

        $crew_history = [
            'crew_code' => $crew['crew_code'],
            'monitor_code' => $crew['monitor_code'],
            'crew_status' => $crew['status'],
            'issued_by' => $this->global->ecdc('ec', $this->session->userdata('user_code')),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $crew_update_data = [
            'offsigner' => $cm_plan['offsigner'],
            'embark_date' => $cm_plan['disembark'],
            'status' => 2,
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->insert('crew_history', $crew_history);
        $this->db->where('cmp_code', $cmp_code)->set('insigner', $os_monitor_code)->update('cm_plan');
        $this->db->where('monitor_code', $os_monitor_code)->update('crews', $crew_update_data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function removeOnSigner($cmp_code)
    {
        $cmp = $this->db->where('cmp_code', $cmp_code)->get('cm_plan')->row_array();

        $onsigner_monitor = $cmp['insigner'];

        $os_last_status = $this->db->where('monitor_code', $onsigner_monitor)->order_by('id', "DESC")->limit(1)->get('crew_history')->row_array();

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->where('monitor_code', $onsigner_monitor)->set('offsigner', null)->set('status', $os_last_status['crew_status'])->update('crews');
        $this->db->where('cmp_code', $cmp_code)->set('insigner', null)->update('cm_plan');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_contract_validity($crew_code)
    {
        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];

        $contract = $this->contracts->getCrewContract($crew_code);
        $contract_validity = "";

        if ($contract) {
            foreach ($contract as $row) {
                $contract_duration = strtotime($row['contract_duration']);
                if (!empty($contract_duration)) {
                    $current_date = strtotime(date('Y-m-d'));

                    $diff = $contract_duration - $current_date;
                    $date_diff = round($diff / (60 * 60 * 24));

                    if ($date_diff >= 60) {
                        $contract_validity .= '<span class="m-0 font-15 text-truncate font-weight-medium"><a class="m-0 font-15  text-success" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">VALID</a></span>';
                    } else if ($date_diff >= 1 && $date_diff <= 60) {
                        $contract_validity .= '<span class="m-0 font-15 text-truncate font-weight-medium"><a class="m-0 font-15 text-warning" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')" style="color:#ffaf00 !important;">NEAR TO EXPIRE</a></span>';
                    } else if ($date_diff <= 0) {
                        $contract_validity .= '<span class="m-0 font-15 text-truncate font-weight-medium"><a class="m-0 font-15 text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">EXPIRED</a></span>';
                    }
                } else {
                    $contract_validity .= '<span class="m-0 font-15 font-weight-medium"><a class="m-0 font-15 text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">N/A</a></span>';
                }
            }
        } else {
            $contract_validity .= '<span class="m-0 font-15 font-weight-medium"><a class="m-0 font-15 text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">N/A</a></span>';
        }

        return $contract_validity;
    }

    public function get_contract_validity_table($crew_code)
    {
        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        $first_name = !empty($name['first_name']) ? $name['first_name'] : "";
        $middle_name = !empty($name['middle_name']) ? $name['middle_name'] : "";
        $last_name = !empty($name['last_name']) ? $name['last_name'] : "";
        $fullname = trim($first_name . ' ' . $middle_name . ' ' . $last_name);

        $contract = $this->contracts->getCrewContract($crew_code);
        $contract_validity = "";

        if ($contract) {
            foreach ($contract as $row) {
                if ($row['contract_duration']) {
                    $contract_duration = strtotime($row['contract_duration']);
                    $current_date = strtotime(date('Y-m-d'));

                    $diff = $contract_duration - $current_date;
                    $date_diff = round($diff / (60 * 60 * 24));

                    if ($date_diff > 90) {
                        $contract_validity .= '<td class="text-center">' . date('M j, Y', strtotime($row['contract_duration'])) . '</td>';
                    } else if ($date_diff >= 60 && $date_diff <= 90) {
                        $contract_validity .= '<td class="bg-success text-white text-center">' . date('M j, Y', strtotime($row['contract_duration'])) . '</td>';
                    } else if ($date_diff >= 31 && $date_diff <= 60) {
                        $contract_validity .= '<td class="bg-warning text-center" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">' . date('M j, Y', strtotime($row['contract_duration'])) . '</td>';
                    } else if ($date_diff <= 30 && $date_diff >= 1) {
                        $contract_validity .= '<td class="bg-danger text-white text-center" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">' . date('M j, Y', strtotime($row['contract_duration'])) . '</td>';
                    } else if ($date_diff <= 0) {
                        $contract_validity .= '<td class="bg-danger text-white text-center" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">' . date('M j, Y', strtotime($row['contract_duration'])) . '</td>';
                    }
                } else {
                    $contract_validity .= '<td class="text-center"><span class="badge badge-danger-outline"><a class="text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">N/A</a></span></td>';
                }
            }
        } else {
            $contract_validity .= '<td class="text-center"><span class="badge badge-danger-outline"><a class="text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">N/A</a></span></td>';
        }

        return $contract_validity;
    }

    public function get_contract_validity_card($crew_code)
    {
        $contract = $this->contracts->getCrewContract($crew_code);
        $card_color = "";

        if ($contract) {
            foreach ($contract as $row) {
                $contract_duration = strtotime($row['contract_duration']);
                $current_date = strtotime(date('Y-m-d'));

                $diff = $contract_duration - $current_date;
                $date_diff = round($diff / (60 * 60 * 24));

                if ($date_diff > 90) {
                    $card_color .= 'style="background-color:rgb(255,255,255);"';
                } else if ($date_diff >= 60 && $date_diff <= 90) {
                    $card_color .= 'style="background-color:rgba(35,179,151,.25);"';
                } else if ($date_diff >= 31 && $date_diff <= 60) {
                    $card_color .= 'style="background-color:rgba(248,204,107,.25);"';
                } else if ($date_diff <= 30 && $date_diff >= 1) {
                    $card_color .= 'style="background-color:rgba(240,100,59,.25);"';
                } else if ($date_diff <= 0) {
                    $card_color .= 'style="background-color:rgba(240,100,59,.25);"';
                }
            }
        } else {
            $card_color .= 'style="color:rgb(255,255,255);"';
        }

        return $card_color;
    }

    public function get_license_validity($crew_code)
    {
        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];
        $license = $this->global->getListLicenses($crew_code);
        $license_validity = "";

        if ($license) {
            $expiry_date = json_decode($license['expiry_date']);
            $date_issued = json_decode($license['date_issued']);

            $exp_count = [];

            if (count($expiry_date) < 1) {
                $license_validity .= '<h4 class="m-0 font-15 text-danger"><a class="text-danger" href="javascript:void(0)" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\',\'' . $fullname . '\')">N/A</a></h4>';
            } else {

                $near = 0;
                $exp = 0;
                $valid = 0;
                $inc = 0;
                $count_rec_w_exp = 0;
                $count = 0;
                if (!empty($expiry_date)) {
                    foreach ($expiry_date as $key => $expry) {
                        if (!empty($expry) && !empty($date_issued[$count])) {

                            $count_rec_w_exp++;

                            $date_exp = strtotime($expry);
                            $current_date = strtotime(date('Y-m-d'));

                            $diff = $date_exp - $current_date;
                            $date_diff = round($diff / (60 * 60 * 24));
                            if ($date_diff <= 30 && $date_diff >= 1) {

                                $near++;
                            } elseif ($date_diff < 1) {
                                $exp++;
                            } else if ($date_diff > 30) {
                                $valid++;
                            }
                        } else {
                            $inc++;
                        }
                        $count++;
                    }

                    $total_exp_inc = $near + $exp;

                    if ($total_exp_inc != 0 && $inc >= 0) {
                        if (!empty($near) && !empty($exp)) {
                            $license_validity .= "
                            <h4 class=\"m-0 font-15\">
                                <a class=\"m-0 font-15 text-danger\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningLicenses('{$crew_code}', '{$fullname}')\"><span style=\"color:#ffaf00 !important;\">NEAR</span>/EXP (+{$total_exp_inc})</a>
                            </h4>";
                        } elseif (!empty($near) && empty($exp)) {
                            $license_validity .= "
                            <h4 class=\"m-0 font-15\" >
                                <a class=\"m-0 font-15\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningLicenses('{$crew_code}', '{$fullname}')\"><span style=\"color:#ffaf00 !important;\">NEAR (+{$total_exp_inc})</span></a>
                            </h4>";
                        } elseif (empty($near) && !empty($exp)) {
                            $license_validity .= "
                            <h4 class=\"m-0 font-15\" >
                                <a class=\"m-0 font-15 text-danger\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningLicenses('{$crew_code}', '{$fullname}')\">EXPIRED (+{$total_exp_inc})</a>
                            </h4>";
                        }
                    } else {
                        if ($inc >= 1) {
                            $license_validity .= '<h4 class="m-0 font-15 text-danger"><a class="text-danger" href="javascript:void(0)" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\',\'' . $fullname . '\')">INC</a></h4>';
                        } else if ($valid == $count_rec_w_exp) {
                            $license_validity .= "
                            <h4 class=\"m-0 font-15\" >
                                <a class=\"m-0 font-15 text-success\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningLicenses('{$crew_code}', '{$fullname}')\">VALID</a>
                            </h4>";
                        }
                    }
                }
            }
        } else {
            $license_validity .= '<h4 class="m-0 font-15 text-danger"><a class="text-danger" href="javascript:void(0)" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\',\'' . $fullname . '\')">N/A</a></h4>';
        }
        return $license_validity;
    }

    public function get_certificates_validity($crew_code)
    {
        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];
        $certs = $this->global->getListCertificates($crew_code);
        $certs_validity = "";



        if ($certs) {
            $expiry_date = json_decode($certs['expiration_date']);
            $date_issued = json_decode($certs['date_issued']);

            $exp_count = [];

            if (count($expiry_date) < 1) {
                $certs_validity .= '<h4 class="m-0 font-15 text-danger"><a class="text-danger" href="javascript:void(0)" onclick="getViewEditPrejoiningCertificates(\'' . $crew_code . '\',\'' . $fullname . '\')">N/A</a></h4>';
            } else {

                $near = 0;
                $exp = 0;
                $valid = 0;
                $inc = 0;
                $count_rec_w_exp = 0;
                $count = 0;
                if (!empty($expiry_date)) {
                    foreach ($expiry_date as $key => $expry) {
                        if (!empty($expry) && !empty($date_issued[$count])) {

                            $count_rec_w_exp++;

                            $date_exp = strtotime($expry);
                            $current_date = strtotime(date('Y-m-d'));

                            $diff = $date_exp - $current_date;
                            $date_diff = round($diff / (60 * 60 * 24));
                            if ($date_diff <= 30 && $date_diff >= 1) {

                                $near++;
                            } elseif ($date_diff < 1) {
                                $exp++;
                            } else if ($date_diff > 30) {
                                $valid++;
                            }
                        } else {
                            $inc++;
                        }
                        $count++;
                    }

                    $total_exp_inc = $near + $exp;

                    if ($total_exp_inc != 0 && $inc >= 0) {
                        if (!empty($near) && !empty($exp)) {
                            $certs_validity .= "
                            <h4 class=\"m-0 font-15\">
                                <a class=\"m-0 font-15 text-danger\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningCertificates('{$crew_code}', '{$fullname}')\"><span style=\"color:#ffaf00 !important;\">NEAR</span>/EXP (+{$total_exp_inc})</a>
                            </h4>";
                        } elseif (!empty($near) && empty($exp)) {
                            $certs_validity .= "
                            <h4 class=\"m-0 font-15\" >
                                <a class=\"m-0 font-15\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningCertificates('{$crew_code}', '{$fullname}')\"><span style=\"color:#ffaf00 !important;\">NEAR (+{$total_exp_inc})</span></a>
                            </h4>";
                        } elseif (empty($near) && !empty($exp)) {
                            $certs_validity .= "
                            <h4 class=\"m-0 font-15\" >
                                <a class=\"m-0 font-15 text-danger\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningCertificates('{$crew_code}', '{$fullname}')\">EXPIRED (+{$total_exp_inc})</a>
                            </h4>";
                        }
                    } else {
                        if ($inc >= 1) {
                            $certs_validity .= '<h4 class="m-0 font-15 text-danger"><a class="text-danger" href="javascript:void(0)" onclick="getViewEditPrejoiningCertificates(\'' . $crew_code . '\',\'' . $fullname . '\')">INC</a></h4>';
                        } else if ($valid == $count_rec_w_exp) {
                            $certs_validity .= "
                            <h4 class=\"m-0 font-15\" >
                                <a class=\"m-0 font-15 text-success\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningCertificates('{$crew_code}', '{$fullname}')\">VALID</a>
                            </h4>";
                        }
                    }
                }
            }
        } else {
            $certs_validity .= '<h4 class="m-0 font-15 text-danger"><a class="text-danger" href="javascript:void(0)" onclick="getViewEditPrejoiningCertificates(\'' . $crew_code . '\',\'' . $fullname . '\')">N/A</a></h4>';
        }
        return $certs_validity;
    }

    public function get_license_validity_table($crew_code)
    {
        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        $first_name = !empty($name['first_name']) ? $name['first_name'] : "";
        $middle_name = !empty($name['middle_name']) ? $name['middle_name'] : "";
        $last_name = !empty($name['last_name']) ? $name['last_name'] : "";
        $fullname = trim($first_name . ' ' . $middle_name . ' ' . $last_name);
        $license = $this->global->getListLicenses($crew_code);
        $license_validity = "";

        if ($license) {
            $expiry_date = json_decode($license['expiry_date']);
            $date_issued = json_decode($license['date_issued']);

            $exp_count = [];

            if (count($expiry_date) < 1) {
                $license_validity .= '<span class="badge badge-danger-outline"><a class="text-danger" href="javascript:void(0)" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\',\'' . $fullname . '\')">NO LICENSES</a></span>';
            } else {

                $near = 0;
                $exp = 0;
                $valid = 0;
                $inc = 0;
                $count_rec_w_exp = 0;
                $count = 0;

                if (!empty($expiry_date)) {
                    foreach ($expiry_date as $key => $expry) {
                        if (!empty($expry) && !empty($date_issued[$count])) {

                            $count_rec_w_exp++;

                            $date_exp = strtotime($expry);
                            $current_date = strtotime(date('Y-m-d'));

                            $diff = $date_exp - $current_date;
                            $date_diff = round($diff / (60 * 60 * 24));
                            if ($date_diff <= 30 && $date_diff >= 1) {

                                $near++;
                            } elseif ($date_diff < 1) {
                                $exp++;
                            } else if ($date_diff > 30) {
                                $valid++;
                            }
                        } else {
                            $inc++;
                        }

                        $count++;
                    }
                }

                $total_exp_inc = $near + $exp;

                if ($total_exp_inc != 0 && $inc >= 0) {
                    if (!empty($near) && !empty($exp)) {
                        $license_validity .= "<span class=\"badge badge-danger-outline\"><a class=\"text-danger\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningLicenses('{$crew_code}', '{$fullname}')\"><span style=\"color:#ffaf00 !important;\">NEAR</span>/EXP (+{$total_exp_inc})</a></span>";
                    } elseif (!empty($near) && empty($exp)) {
                        $license_validity .= "<span class=\"badge badge-warning-outline\"><a class=\"text-warning\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningLicenses('{$crew_code}', '{$fullname}')\">NEAR (+{$total_exp_inc})</a></span>";
                    } elseif (empty($near) && !empty($exp)) {
                        $license_validity .= "<span class=\"badge badge-danger-outline\"><a class=\"text-danger\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningLicenses('{$crew_code}', '{$fullname}')\">EXPIRED (+{$total_exp_inc})</a></span>";
                    }
                } else {

                    if ($inc >= 1) {
                        $license_validity .= "<span class=\"badge badge-danger-outline\"><a class=\"text-danger\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningLicenses('{$crew_code}', '{$fullname}')\">INC</a></span>";
                    } else if ($valid == $count_rec_w_exp) {
                        $license_validity .= "<span class=\"badge badge-success-outline\"><a class=\"text-success\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningLicenses('{$crew_code}', '{$fullname}')\">VALID</a></span>";
                    }
                }
            }
        } else {
            $license_validity .= "<span class=\"badge badge-danger-outline\"><a class=\"text-danger\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningLicenses('{$crew_code}', '{$fullname}')\">NO LICENSES</a></span>";
        }
        return $license_validity;
    }

    public function license_validity_text($crew_code)
    {
        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];
        $license = $this->global->getListLicenses($crew_code);
        $license_validity = "";

        if ($license) {
            $expiry_date = json_decode($license['expiry_date']);
            $exp_count = [];

            if (!$expiry_date) {
                $license_validity .= 'NO LICENSES';
            } else {

                $exp_count =  array_map(function ($x) {
                    $date = date('Y-m-d', strtotime($x));
                    $date_exp = strtotime($date);
                    $curr_date = strtotime(date('Y-m-d'));
                    if ($date_exp > $curr_date) {
                        return 1;
                    } else {
                        return 0;
                    }
                }, $expiry_date);
            }
            if (empty(array_count_values($exp_count)[0])) {
                $license_validity .= 'VALID';
            } else {
                if (array_count_values($exp_count)[0] > 0) {
                    $license_validity .= 'EXPIRED';
                }
            }
        } else {
            $license_validity .= 'NO LICENSES';
        }
        return $license_validity;
    }

    public function validate_certificates($crew_code)
    {
        $certificates = $this->global->getCertificates($crew_code);
        $cerificate_validity = "";

        if (!$certificates) {
            $cerificate_validity .= '<h4 class="m-0 font-15 text-danger text-truncate" title="NOT AVAILABLE">N/A</h4>';
        } else {
            $cop_number = json_decode($certificates['number']);
            $cerificate_count = array_map(function ($x) {
                if ($x) {
                    return 1;
                } else {
                    return 0;
                }
            }, $cop_number);
            if (empty(array_count_values($cerificate_count)[0])) {
                $cerificate_validity = '<h4 class="m-0 font-15 text-success text-truncate" title="COMPLETED">COMPLETED</h4>';
            } else {
                if (array_count_values($cerificate_count)[0] > 0) {
                    $cerificate_validity = '<h4 class="m-0 font-15 text-warning text-truncate" title="INCOMPLETE">INCOMPLETE</h4>';
                }
            }
        }
        return $cerificate_validity;
    }

    public function validate_certificates_table($crew_code)
    {
        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        $first_name = !empty($name['first_name']) ? $name['first_name'] : "";
        $middle_name = !empty($name['middle_name']) ? $name['middle_name'] : "";
        $last_name = !empty($name['last_name']) ? $name['last_name'] : "";
        $fullname = trim($first_name . ' ' . $middle_name . ' ' . $last_name);

        $certificates = $this->global->getCertificates($crew_code);
        $cerificate_validity = "";

        if (empty($certificates)) {
            $cerificate_validity .= '<span class="badge badge-danger-outline"><a class="text-danger" href="javascript:void(0)" onclick="getViewEditPrejoining(\'' . $crew_code . '\',\'' . $fullname . '\')">NO CERTIFICATES</a></span>';
        } else {

            $expiry_date = json_decode($certificates['expiration_date']);
            $date_issued = json_decode($certificates['date_issued']);

            if (count($expiry_date) < 1) {
                $cerificate_validity .= '<span class="badge badge-danger-outline"><a class="text-danger" href="javascript:void(0)" onclick="getViewEditPrejoiningCertificates(\'' . $crew_code . '\',\'' . $fullname . '\')">NO CERTIFICATES</a></span>';
            } else {
                $near = 0;
                $exp = 0;
                $valid = 0;
                $inc = 0;
                $count_rec_w_exp = 0;
                $count = 0;

                if (!empty($expiry_date)) {
                    foreach ($expiry_date as $key => $expry) {
                        if (!empty($expry) && !empty($date_issued[$count])) {

                            $count_rec_w_exp++;

                            $date_exp = strtotime($expry);
                            $current_date = strtotime(date('Y-m-d'));

                            $diff = $date_exp - $current_date;
                            $date_diff = round($diff / (60 * 60 * 24));
                            if ($date_diff <= 30 && $date_diff >= 1) {

                                $near++;
                            } elseif ($date_diff < 1) {
                                $exp++;
                            } else if ($date_diff > 30) {
                                $valid++;
                            }
                        } else {
                            $inc++;
                        }
                        $count++;
                    }

                    $total_exp_inc = $near + $exp;
                }
            }

            if ($total_exp_inc != 0 && $inc >= 0) {
                if (!empty($near) && !empty($exp)) {
                    $cerificate_validity .= "<span class=\"badge badge-danger-outline\"><a class=\"text-danger\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningCertificates('{$crew_code}', '{$fullname}')\"><span style=\"color:#ffaf00 !important;\">NEAR</span>/EXP (+{$total_exp_inc})</a></span>";
                } elseif (!empty($near) && empty($exp)) {
                    $cerificate_validity .= "<span class=\"badge badge-warning-outline\"><a class=\"text-warning\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningCertificates('{$crew_code}', '{$fullname}')\">NEAR (+{$total_exp_inc})</a></span>";
                } elseif (empty($near) && !empty($exp)) {
                    $cerificate_validity .= "<span class=\"badge badge-danger-outline\"><a class=\"text-danger\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningCertificates('{$crew_code}', '{$fullname}')\">EXPIRED (+{$total_exp_inc})</a></span>";
                }
            } else {

                if ($inc >= 1) {
                    $cerificate_validity .= "<span class=\"badge badge-danger-outline\"><a class=\"text-danger\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningCertificates('{$crew_code}', '{$fullname}')\">INC</a></span>";
                } else if ($valid == $count_rec_w_exp) {
                    $cerificate_validity .= "<span class=\"badge badge-success-outline\"><a class=\"text-success\" href=\"javascript:void(0)\" onclick=\"getViewEditPrejoiningCertificates('{$crew_code}', '{$fullname}')\">VALID</a></span>";
                }
            }

            // $cop_number = json_decode($certificates['number']);
            // $cerificate_count = array_map(function ($x) {
            //     if ($x) {
            //         return 1;
            //     } else {
            //         return 0;
            //     }
            // }, $cop_number);
            // if (empty(array_count_values($cerificate_count)[0])) {
            //     $cerificate_validity = '<span class="badge badge-success-outline"><a class="text-success" href="javascript:void(0)" onclick="getViewEditPrejoining(\'' . $crew_code . '\',\'' . $fullname . '\')">COMPLETED</a></span>';
            // } else {
            //     if (array_count_values($cerificate_count)[0] > 0) {
            //         $cerificate_validity = '<span class="badge badge-warning-outline"><a class="text-warning" href="javascript:void(0)" onclick="getViewEditPrejoining(\'' . $crew_code . '\',\'' . $fullname . '\')">INCOMPLETE</a></span> ';
            //     }
            // }
        }
        return $cerificate_validity;
    }

    public function validate_passport($crew_code)
    {
        $passport = $this->global->getListLicenses($crew_code);
        $name = $this->global->getApplicantInformation($crew_code);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];

        $passport_validity = "";


        if ($passport) {
            $lebi = json_decode($passport['lebi']);
            $expiry_date = json_decode($passport['expiry_date']);

            for ($i = 0; $i < count($lebi); $i++) {
                if ($lebi[$i] === "6") {
                    $index = array_search($lebi[$i], $lebi);

                    if (empty($expiry_date[$index])) {
                        $passport_validity .= '<h4 class="m-0 font-15 text-danger" href="javascript:void(0)" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\', \'' . $fullname . '\')" style="cursor:pointer!important;">N/A</h4>';
                    } else {
                        $passport_date = date('Y-m-d', strtotime($expiry_date[$index]));
                        $pass_date = strtotime($passport_date);
                        $curr_date = strtotime(date('Y-m-d'));
                        if ($pass_date > $curr_date) {
                            $passport_validity .= '<h4 class="m-0 font-15 text-success" href="javascript:void(0)" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\', \'' . $fullname . '\')" style="cursor:pointer!important;">VALID</h4>';
                        } else {
                            $passport_validity .= '<h4 class="m-0 font-15"><a class="m-0 font-15 text-danger" href="javascript:void(0)" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\', \'' . $fullname . '\')" style="cursor:pointer!important;">EXPIRED</a></h4>';
                        }
                    }
                }
            }
        } else {
            $passport_validity .= '<h4 class="m-0 font-15 text-danger">N/A</h4>';
        }
        return $passport_validity;
    }

    public function validate_passport_table($crew_code)
    {
        $passport = $this->global->getListLicenses($crew_code);
        $name = $this->global->getApplicantInformation($crew_code);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];
        $passport_validity = "";

        if ($passport) {
            $lebi = json_decode($passport['lebi']);
            $expiry_date = json_decode($passport['expiry_date']);

            for ($i = 0; $i < count($lebi); $i++) {
                if ($lebi[$i] == "6") {
                    $index = array_search($lebi[$i], $lebi);

                    if (empty($expiry_date[$index])) {
                        $passport_validity .= '<span class="badge badge-danger-outline" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\', \'' . $fullname . '\')" style="cursor:pointer!important;">N/A</span>';
                    } else {
                        $passport_date = date('Y-m-d', strtotime($expiry_date[$index]));
                        $pass_date = strtotime($passport_date);
                        $curr_date = strtotime(date('Y-m-d'));
                        if ($pass_date > $curr_date) {
                            $passport_validity .= '<span class="badge badge-success-outline" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\', \'' . $fullname . '\')" style="cursor:pointer!important;">VALID</span>';
                        } else {
                            $passport_validity .= '<span class="badge badge-danger-outline"><a class="m-0 text-danger" href="javascript:void(0)" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\', \'' . $fullname . '\')" style="cursor:pointer!important;">EXPIRED</a></span>';
                        }
                    }
                }
            }
        } else {
            $passport_validity .= '<span class="badge badge-danger-outline" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\', \'' . $fullname . '\')" style="cursor:pointer!important;">N/A</span>';
        }
        return $passport_validity;
    }

    public function get_license_validity_card($crew_code)
    {
        $license = $this->global->getListLicenses($crew_code);
        $license_validity = "";

        if ($license) {

            $license_name = json_decode($license['lebi']);
            $grade = json_decode($license['grade']);
            $number = json_decode($license['number']);
            $date_issued = json_decode($license['date_issued']);
            $expiry_date = json_decode($license['expiry_date']);
            $exp_count = [];

            for ($i = 0; $i < count($license_name); $i++) {
                if (!$expiry_date) {
                    $license_validity .= 'style="background-color:#FFFFFF;"';
                }
            }
            if (count($exp_count) === 0) {
                $license_validity .= 'style="background-color:#FFFFFF;"';
            } else {
                $license_validity .= 'style="background-color:#FFE7E7;"';
            }
        }
        return $license_validity;
    }

    public function get_mlc_validity($crew_code)
    {
        $mlc = $this->contracts->getCrewMlcById($crew_code);
        $name = $this->global->getApplicantInformation($crew_code);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];

        $contract_validity = "";

        if ($mlc) {
            // foreach ($mlc as $row) {
            //     $contract_duration = strtotime($row['date_created']);
            //     $current_date = strtotime(date('Y-m-d'));

            //     $diff = $contract_duration - $current_date;

            //     $date_diff = round($diff / (60 * 60 * 24));

            //     if ($date_diff > 90) {
            //         $contract_validity .= '<h4 class="m-0 font-15 text">VALID</h4>';
            //     } else if ($date_diff >= 60 && $date_diff <= 90) {
            //         $contract_validity .= '<h4 class="m-0 font-15 text-success">VALID</h4>';
            //     } else if ($date_diff >= 31 && $date_diff <= 60) {
            //         $contract_validity .= '<h4 class="m-0 font-15 text"><a class="m-0 font-15 text-warning" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\')">NEAR TO EXPIRE</a></h4>';
            //     } else if ($date_diff <= 30 && $date_diff >= 1) {
            //         $contract_validity .= '<h4 class="m-0 font-15 text"><a class="m-0 font-15 text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\')">TO EXPIRE</a></h4>';
            //     } else if ($date_diff < 0){
            //         $contract_validity .= '<h4 class="m-0 font-15 text"><a class="m-0 font-15 text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\')">EXPIRED</a></h4>';
            //     }
            // }
            $contract_validity .= "<h4 class=\"m-0 font-15 text-success\"><a class=\"m-0 font-15 text-success\" href=\"javascript:void(0)\" onclick=\"viewCrewContracts('{$crew_code}', '{$fullname}')\">VALID</a></h4>";
        } else {
            $contract_validity .= "<h4 class=\"m-0 font-15\"><a class=\"m-0 font-15 text-danger\" href=\"javascript:void(0)\" onclick=\"viewCrewContracts('{$crew_code}', '{$fullname}')\">N/A</a></h4>";
        }

        return $contract_validity;
    }

    public function get_mlc_validity_table($crew_code)
    {
        $mlc = $this->contracts->getCrewMlcById($crew_code);

        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        $first_name = !empty($name['first_name']) ? $name['first_name'] : "";
        $middle_name = !empty($name['middle_name']) ? $name['middle_name'] : "";
        $last_name = !empty($name['last_name']) ? $name['last_name'] : "";
        $fullname = trim($first_name . ' ' . $middle_name . ' ' . $last_name);

        $contract_validity = "";

        if ($mlc) {
            // foreach ($mlc as $row) {
            //     $contract_duration = strtotime($row['date_created']);
            //     $current_date = strtotime(date('Y-m-d'));

            //     $diff = $contract_duration - $current_date;

            //     $date_diff = round($diff / (60 * 60 * 24));

            //     if ($date_diff > 90) {
            //         $contract_validity .= '<h4 class="m-0 font-15 text">VALID</h4>';
            //     } else if ($date_diff >= 60 && $date_diff <= 90) {
            //         $contract_validity .= '<h4 class="m-0 font-15 text-success">VALID</h4>';
            //     } else if ($date_diff >= 31 && $date_diff <= 60) {
            //         $contract_validity .= '<h4 class="m-0 font-15 text"><a class="m-0 font-15 text-warning" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\')">NEAR TO EXPIRE</a></h4>';
            //     } else if ($date_diff <= 30 && $date_diff >= 1) {
            //         $contract_validity .= '<h4 class="m-0 font-15 text"><a class="m-0 font-15 text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\')">TO EXPIRE</a></h4>';
            //     } else if ($date_diff < 0){
            //         $contract_validity .= '<h4 class="m-0 font-15 text"><a class="m-0 font-15 text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\')">EXPIRED</a></h4>';
            //     }
            // }
            $contract_validity .= "<span class=\"badge badge-success-outline\"><a class=\"m-0 text-success\" href=\"javascript:void(0)\" onclick=\"viewCrewContracts('{$crew_code}', '{$fullname}')\">VALID</a></span>";
        } else {
            $contract_validity .= '<span class="badge badge-danger-outline"><a class="text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">N/A</a></span>';
        }

        return $contract_validity;
    }

    public function getCMPdetails($cmp_code)
    {
        $this->db->select("
            cmp.cmp_code,
            cmp.disembark,
            cmp.x_port,
            cmp.line_up,
            cmp.months_onboard,
            cmp.date_x,
            cmp.sign_on,
            cmp.remarks,
            cmp.position,
            cmp.vessel_code,
            cmp.embark,
            cmp.offsigner,
            av.vsl_name,
            ap.position_name,
            ap.type_of_department,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            c.date_available,
            c.crew_code,
            c.applicant_code,
            c.crew_code
        ");
        $this->db->from("cm_plan cmp");
        $this->db->join("crews c", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "cmp.position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "cmp.vessel_code = av.id", "LEFT");
        $this->db->join("crew_poea cp", "cp.crew_code = c.crew_code", "LEFT");

        $this->db->where('cmp.cmp_code', $cmp_code);
        $this->db->group_by('cmp.cmp_code');
        $this->db->order_by("cmp.date_created", "DESC");

        $query = $this->db->get();

        return (($query->num_rows() > 0) ? $query->row_array() : []);
    }

    function update_cmp()
    {
        $cmp_code = $this->input->post('cmp_code');
        $crew_code = $this->input->post('crew_code');
        $data = [
            'disembark' => $this->input->post('c_disembark'),
            'line_up' => $this->input->post('c_line_up'),
            'months_onboard' => $this->input->post('c_onboard'),
            'x_port' => $this->input->post('c_x_port'),
            'date_x' => $this->input->post('c_x_date') === "" ? NULL : $this->input->post('c_x_date'),
            'remarks'   => $this->input->post('c_remarks'),
            'sign_on'   => $this->input->post('c_sign_on'),
            'date_updated' => date('Y-m-d H:i:s')
        ];

        $poea_data = ['contract_duration' => $this->input->post('c_end_contract')];

        $this->db->trans_strict(true);
        $this->db->trans_begin();

        $this->db->where('crew_code', $crew_code)->update('crew_poea', $poea_data);
        $this->db->where('cmp_code', $cmp_code)->update('cm_plan', $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function FilterCMP($params = array())
    {
        $this->db->select("
            cmp.*,
            av.vsl_name,
            ap.position_name,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            cp.contract_duration,
            c.date_available,
            c.crew_code
        ");
        $this->db->from("cm_plan cmp");
        $this->db->join("crews c", "cmp.offsigner = c.monitor_code");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");

        $this->db->join("a_position ap", "cmp.position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "cmp.vessel_code = av.id", "LEFT");
        $this->db->join("crew_poea cp", "cp.crew_code = c.crew_code", "LEFT");

        if (!empty($params['search']['position']) && $params['search']['position'] != "all") {
            $this->db->group_start();
            $this->db->where('cmp.position', $params['search']['position']);
            $this->db->group_end();
        }
        if (!empty($params['search']['vessel']) && $params['search']['vessel'] != "all") {
            $this->db->group_start();
            $this->db->where('cmp.vessel_code', $params['search']['vessel']);
            $this->db->group_end();
        }
        if (!empty($params['search']['sign_from']) && !empty($params['search']['sign_to'])) {
            $this->db->group_start();
            $this->db->where('cmp.embark >=', $params['search']['sign_from']);
            $this->db->where('cmp.embark <=', $params['search']['sign_to']);
            $this->db->group_end();
        }
        if (!empty($params['search']['contract_from']) && !empty($params['search']['contract_to'])) {
            $this->db->group_start();
            $this->db->where('cmp.embark >=', $params['search']['contract_from']);
            $this->db->where('cmp.embark <=', $params['search']['contract_to']);
            $this->db->group_end();
        }
        if (!empty($params['search']['signon_date']) && !empty($params['search']['signoff_date'])) {
            $this->db->group_start();
            $this->db->where('cmp.embark >=', $params['search']['signon_date']);
            $this->db->where('cmp.disembark <=', $params['search']['signoff_date']);
            $this->db->group_end();
        }

        $this->db->where('cmp.status !=', 0);
        $this->db->order_by("cmp.date_created", "DESC");

        $query = $this->db->get();

        return (($query->num_rows() > 0) ? $query->result_array() : []);
    }


    public function FilterPrejoining($params = array())
    {

        $this->db->select("
            cmp.*,
            av.vsl_name,
            av.vsl_code,
            ap.position_name,
            ap.position_code,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.mobile_number,
            c.date_available,
            c.crew_code,
        ");

        $this->db->from("cm_plan cmp");
        $this->db->join("crews c", "cmp.offsigner = c.monitor_code", "LEFT");
        $this->db->join("a_vessels av", "cmp.vessel_code = av.id", "LEFT");
        $this->db->join("a_position ap", "cmp.position = ap.id", "LEFT");
        $this->db->join("crew_flight cf", "cf.flight_code = c.flight_code", "LEFT");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");

        $this->db->where('cmp.status !=', 0);

        if (!empty($params['search']['name_search'])) {
            $this->db->group_start();
            $this->db->like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.middle_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.first_name, acpi.last_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->or_like("LOWER(CONCAT_WS(' ', acpi.last_name, acpi.first_name))", strtolower(trim($params['search']['name_search'])));
            $this->db->group_end();
            // $this->db->like('acpi.first_name', trim($params['search']['name_search']));
            // $this->db->or_like('acpi.middle_name', trim($params['search']['name_search']));
            // $this->db->or_like('acpi.last_name', trim($params['search']['name_search']));
        }

        if (!empty($params['search']['rank_search']) && $params['search']['rank_search'] != "all") {
            $this->db->group_start();
            $this->db->where('c.position', $params['search']['rank_search']);
            $this->db->group_end();
        }
        if (!empty($params['search']['vessel_search']) && $params['search']['vessel_search'] != "all") {
            $this->db->group_start();
            $this->db->where('c.vessel_assign', $params['search']['vessel_search']);
            $this->db->group_end();
        }

        if (!empty($params['search']['flight_search']) && $params['search']['vessel_search'] != "1") {
            $this->db->group_start();
            $this->db->where('c.flight_code !=', null);
            $this->db->group_end();
        } else {
            $this->db->group_start();
            $this->db->where('c.flight_code', null);
            $this->db->group_end();
        }

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


        $this->db->order_by("cmp.date_created", "DESC");

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();
        return (($query->num_rows() > 0) ? $query->result_array() : []);
    }

    public function FilterPrejoining2($params = array())
    {
        $this->db->select("
            cmp.*,
            av.vsl_name,
            av.vsl_code,
            ap.position_name,
            ap.position_code,
            CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
            acpi.mobile_number,
            cp.contract_duration,
            c.date_available,
            c.crew_code,
            cm.medical_status,
            aclc.expiry_date,
            actc.number,
            cmlc.date_created as mlc_created,
        ");
        $this->db->from("cm_plan cmp");
        $this->db->join("crews c", "cmp.offsigner = c.monitor_code", "LEFT");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code", "LEFT");

        $this->db->join("a_position ap", "cmp.position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "cmp.vessel_code = av.id", "LEFT");
        $this->db->join("crew_poea cp", "cp.crew_code = c.crew_code", "LEFT");
        $this->db->join("crew_mlc cmlc", "cmlc.crew_code = c.crew_code", "LEFT");
        $this->db->join("crew_medical cm", "cm.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_licenses_endorsement_book_id aclc", "aclc.crew_code = c.crew_code", "LEFT");
        $this->db->join("ac_training_certificates actc", "actc.crew_code = c.crew_code", "LEFT");

        if (!empty($params[0]['position']) && $params[0]['position'] != "all") {
            $this->db->group_start();
            $this->db->where('cmp.position', $params[0]['position']);
            $this->db->group_end();
        }
        if (!empty($params[0]['vessel']) && $params[0]['vessel'] != "all") {
            $this->db->group_start();
            $this->db->where('cmp.vessel_code', $params[0]['vessel']);
            $this->db->group_end();
        }
        if (!empty($params[0]['joining_date_from']) && !empty($params[0]['joining_date_to'])) {
            $this->db->group_start();
            $this->db->where('cmp.date_x >=', $params[0]['joining_date_from']);
            $this->db->where('cmp.date_x <=', $params[0]['joining_date_to']);
            $this->db->group_end();
        }
        // if(!empty($params[0]['contract_from']) &&!empty($params[0]['contract_to'])){
        //     $this->db->where('cmp.embark >=', $params[0]['contract_from']);
        //     $this->db->where('cmp.embark <=', $params[0]['contract_to']);
        // }
        // if(!empty($params[0]['signon_date']) && !empty($params[0]['signoff_date'])){
        //     $this->db->where('cmp.embark >=', $params[0]['signon_date']);
        //     $this->db->where('cmp.disembark <=', $params[0]['signoff_date']);
        // }
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        $this->db->where('cmp.status !=', 0);
        $this->db->order_by("cmp.date_created", "DESC");

        $query = $this->db->get();

        return (($query->num_rows() > 0) ? $query->result_array() : []);
    }

    function update_crew_pos_vessel()
    {
        $crew_code = $this->input->post('hid_code_pos_update');
        $position = $this->input->post('epvm_position');
        $vessel = $this->input->post('epvm_tentative_vessel');

        $crew_details = $this->global->getCrewInformation($crew_code);

        $app_data = [
            "position_first" => $position,
            "assign_vessel"  => $vessel
        ];

        $crew_data = [
            "position"  => $position,
            "vessel_assign" => $vessel
        ];

        $cmp_data = [
            "position"  => $position,
            "vessel_code"   => $vessel
        ];

        $arc_update = [
            'crew_code'     => $crew_code,
            'previous_details'   => json_encode($crew_details),
            'new_details'        => json_encode($crew_details),
            'date_created'  => date('Y-m-d h:i:s'),
            'status'        => 1
        ];


        $db_archive = $this->load->database('archive', TRUE);

        $this->db->trans_begin();

        $this->db->where('crew_code', $crew_code)->update('crews', $crew_data);
        $this->db->where('crew_code', $crew_code)->update('applicants', $app_data);

        if (!empty($crew_details['cmp_code'])) {
            $this->db->where('cmp_code', $crew_details['cmp_code'])->update('cm_plan', $cmp_data);
        }


        $db_archive->insert('arc_update_pos_vessel', $arc_update);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function validate_licenses_exp($crew_code, $license_code)
    {
        $licenses = $this->global->getListLicenses($crew_code);
        $name = $this->global->getApplicantInformation($crew_code);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];

        $license_validity = "";

        if ($licenses) {
            $lebi = json_decode($licenses['lebi']);
            $expiry_date = json_decode($licenses['expiry_date']);

            $license_index = 0;
            switch (strtoupper($license_code)) {
                case 'COC':
                    $license_index = 2;
                    break;
                case 'GOC':
                    $license_index = 5;
                    break;
                case 'PASSPORT':
                    $license_index = 6;
                    break;
                case 'YFEVER':
                    $license_index = 18;
                    break;
            }

            $data_index = array_search($license_index, $lebi);

            if (is_numeric($data_index)) {
                if (empty($expiry_date[$data_index])) {
                    $license_validity .= '<span class="badge badge-danger-outline" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\', \'' . $fullname . '\')" style="cursor:pointer!important;">N/A</span>';
                } else {
                    $passport_date = date('Y-m-d', strtotime($expiry_date[$data_index]));
                    $pass_date = strtotime($passport_date);
                    $curr_date = strtotime(date('Y-m-d'));
                    if ($pass_date > $curr_date) {
                        $license_validity .= '<span class="badge badge-success-outline" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\', \'' . $fullname . '\')" style="cursor:pointer!important;">VALID</span>';
                    } else {
                        $license_validity .= '<span class="badge badge-danger-outline"><a class="m-0 text-danger" href="javascript:void(0)" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\', \'' . $fullname . '\')" style="cursor:pointer!important;">EXPIRED</a></span>';
                    }
                }
            } else {
                $license_validity .= '<span class="badge badge-danger-outline" onclick="getViewEditPrejoiningLicenses(\'' . $crew_code . '\', \'' . $fullname . '\')" style="cursor:pointer!important;">N/A</span>';
            }
        }
        return $license_validity;
    }


    public function getOffSignerDetails($monitor_code)
    {
        return $this->db->where("offsigner", $monitor_code)->get("cm_plan")->row_array();
    }


    public function getOffSignerNoInSigner($monitor_code)
    {
        $this->db->select("
            crw.monitor_code,
            CONCAT_WS(' ', acpi.first_name, acpi.middle_name, acpi.last_name) as full_name,
        ");

        $this->db->from("cm_plan as cmp");
        $this->db->join("crews crw", "cmp.offsigner = crw.monitor_code", "LEFT");
        $this->db->join("ac_personal_info acpi", "crw.crew_code = acpi.crew_code", "LEFT");

        if (!empty($monitor_code)) {
            $this->db->where("cmp.offsigner !=", $monitor_code);
        }
        $this->db->where("cmp.insigner IS NULL");
        $this->db->where('cmp.status', 3);

        $this->db->order_by('cmp.date_created', 'DESC');
        $this->db->group_by('cmp.offsigner');


        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : [];
    }


    public function checkIfAssignAsOnSigner($insigner_mnt_code)
    {
        $is_assign_as_insigner_sql = $this->db->where("insigner", $insigner_mnt_code)->get("cm_plan")->num_rows();

        if ($is_assign_as_insigner_sql >= 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    public function validate_passport_report($crew_code)
    {
        $passport = $this->global->getListLicenses($crew_code);
        $name = $this->global->getApplicantInformation($crew_code);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];
        $passport_validity = "";

        if ($passport) {
            $lebi = json_decode($passport['lebi']);
            $expiry_date = json_decode($passport['expiry_date']);

            for ($i = 0; $i < count($lebi); $i++) {
                if ($lebi[$i] == "6") {
                    $index = array_search($lebi[$i], $lebi);

                    if (empty($expiry_date[$index])) {
                        $passport_validity .= 'N/A';
                    } else {
                        $passport_date = date('Y-m-d', strtotime($expiry_date[$index]));
                        $pass_date = strtotime($passport_date);
                        $curr_date = strtotime(date('Y-m-d'));
                        if ($pass_date > $curr_date) {
                            $passport_validity .= 'VALID';
                        } else {
                            $passport_validity .= 'EXPIRED';
                        }
                    }
                }
            }
        } else {
            $passport_validity .= 'N/A';
        }
        return $passport_validity;
    }

    public function get_license_validity_report($crew_code)
    {
        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        // $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];
        $license = $this->global->getListLicenses($crew_code);
        $license_validity = "";

        if ($license) {
            $expiry_date = json_decode($license['expiry_date']);
            $date_issued = json_decode($license['date_issued']);

            $exp_count = [];

            if (count($expiry_date) < 1) {
                $license_validity .= 'NO LICENSES';
            } else {

                $near = 0;
                $exp = 0;
                $valid = 0;
                $inc = 0;
                $count_rec_w_exp = 0;
                $count = 0;

                if (!empty($expiry_date)) {
                    foreach ($expiry_date as $key => $expry) {
                        if (!empty($expry) && !empty($date_issued[$count])) {

                            $count_rec_w_exp++;

                            $date_exp = strtotime($expry);
                            $current_date = strtotime(date('Y-m-d'));

                            $diff = $date_exp - $current_date;
                            $date_diff = round($diff / (60 * 60 * 24));
                            if ($date_diff <= 30 && $date_diff >= 1) {

                                $near++;
                            } elseif ($date_diff < 1) {
                                $exp++;
                            } else if ($date_diff > 30) {
                                $valid++;
                            }
                        } else {
                            $inc++;
                        }

                        $count++;
                    }
                }

                $total_exp_inc = $near + $exp;

                if ($total_exp_inc != 0 && $inc >= 0) {
                    if (!empty($near) && !empty($exp)) {
                        $license_validity .= "NEAR/EXPIRED";
                    } elseif (!empty($near) && empty($exp)) {
                        $license_validity .= "NEAR";
                    } elseif (empty($near) && !empty($exp)) {
                        $license_validity .= "EXPIRED";
                    }
                } else {

                    if ($inc >= 1) {
                        $license_validity .= "INC";
                    } else if ($valid == $count_rec_w_exp) {
                        $license_validity .= "VALID";
                    }
                }
            }
        } else {
            $license_validity .= "NO LICENSES";
        }
        return $license_validity;
    }

    public function validate_certificates_report($crew_code)
    {
        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        // $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];

        $certificates = $this->global->getCertificates($crew_code);
        $cerificate_validity = "";

        if (empty($certificates)) {
            $cerificate_validity .= 'NO CERTIFICATES';
        } else {

            $expiry_date = json_decode($certificates['expiration_date']);
            $date_issued = json_decode($certificates['date_issued']);

            if (count($expiry_date) < 1) {
                $cerificate_validity .= 'NO CERTIFICATES';
            } else {
                $near = 0;
                $exp = 0;
                $valid = 0;
                $inc = 0;
                $count_rec_w_exp = 0;
                $count = 0;

                if (!empty($expiry_date)) {
                    foreach ($expiry_date as $key => $expry) {
                        if (!empty($expry) && !empty($date_issued[$count])) {

                            $count_rec_w_exp++;

                            $date_exp = strtotime($expry);
                            $current_date = strtotime(date('Y-m-d'));

                            $diff = $date_exp - $current_date;
                            $date_diff = round($diff / (60 * 60 * 24));
                            if ($date_diff <= 30 && $date_diff >= 1) {

                                $near++;
                            } elseif ($date_diff < 1) {
                                $exp++;
                            } else if ($date_diff > 30) {
                                $valid++;
                            }
                        } else {
                            $inc++;
                        }
                        $count++;
                    }

                    $total_exp_inc = $near + $exp;
                }
            }

            if ($total_exp_inc != 0 && $inc >= 0) {
                if (!empty($near) && !empty($exp)) {
                    $cerificate_validity .= "NEAR/EXPIRED";
                } elseif (!empty($near) && empty($exp)) {
                    $cerificate_validity .= "NEAR";
                } elseif (empty($near) && !empty($exp)) {
                    $cerificate_validity .= "EXPIRED";
                }
            } else {

                if ($inc >= 1) {
                    $cerificate_validity .= "INC";
                } else if ($valid == $count_rec_w_exp) {
                    $cerificate_validity .= "VALID";
                }
            }

            // $cop_number = json_decode($certificates['number']);
            // $cerificate_count = array_map(function ($x) {
            //     if ($x) {
            //         return 1;
            //     } else {
            //         return 0;
            //     }
            // }, $cop_number);
            // if (empty(array_count_values($cerificate_count)[0])) {
            //     $cerificate_validity = '<span class="badge badge-success-outline"><a class="text-success" href="javascript:void(0)" onclick="getViewEditPrejoining(\'' . $crew_code . '\',\'' . $fullname . '\')">COMPLETED</a></span>';
            // } else {
            //     if (array_count_values($cerificate_count)[0] > 0) {
            //         $cerificate_validity = '<span class="badge badge-warning-outline"><a class="text-warning" href="javascript:void(0)" onclick="getViewEditPrejoining(\'' . $crew_code . '\',\'' . $fullname . '\')">INCOMPLETE</a></span> ';
            //     }
            // }
        }
        return $cerificate_validity;
    }

    public function get_contract_validity_report($crew_code)
    {
        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];

        $contract = $this->contracts->getCrewContract($crew_code);
        $contract_validity = "";

        if ($contract) {
            foreach ($contract as $row) {
                if ($row['contract_duration']) {
                    $contract_duration = strtotime($row['contract_duration']);
                    $current_date = strtotime(date('Y-m-d'));

                    $diff = $contract_duration - $current_date;
                    $date_diff = round($diff / (60 * 60 * 24));

                    if ($date_diff > 90) {
                        $contract_validity .= '<td class="text-center">' . date('M j, Y', strtotime($row['contract_duration'])) . '</td>';
                    } else if ($date_diff >= 60 && $date_diff <= 90) {
                        $contract_validity .= '<td class="bg-success text-white text-center">' . date('M j, Y', strtotime($row['contract_duration'])) . '</td>';
                    } else if ($date_diff >= 31 && $date_diff <= 60) {
                        $contract_validity .= '<td class="bg-warning text-center" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">' . date('M j, Y', strtotime($row['contract_duration'])) . '</td>';
                    } else if ($date_diff <= 30 && $date_diff >= 1) {
                        $contract_validity .= '<td class="bg-danger text-white text-center" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">' . date('M j, Y', strtotime($row['contract_duration'])) . '</td>';
                    } else if ($date_diff <= 0) {
                        $contract_validity .= '<td class="bg-danger text-white text-center" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">' . date('M j, Y', strtotime($row['contract_duration'])) . '</td>';
                    }
                } else {
                    $contract_validity .= '<td class="text-center"><span class="badge badge-danger-outline"><a class="text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">N/A</a></span></td>';
                }
            }
        } else {
            $contract_validity .= '<td class="text-center"><span class="badge badge-danger-outline"><a class="text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\',\'' . $fullname . '\')">N/A</a></span></td>';
        }

        return $contract_validity;
    }

    public function get_mlc_validity_report($crew_code)
    {
        $mlc = $this->contracts->getCrewMlcById($crew_code);

        $crew_details = $this->global->getCrew($crew_code);
        $name = $this->global->getApplicantInformation($crew_details['applicant_code']);
        // $fullname = $name['first_name'] . ' ' . $name['middle_name'] . ' ' . $name['last_name'];

        $contract_validity = "";

        if ($mlc) {
            // foreach ($mlc as $row) {
            //     $contract_duration = strtotime($row['date_created']);
            //     $current_date = strtotime(date('Y-m-d'));

            //     $diff = $contract_duration - $current_date;

            //     $date_diff = round($diff / (60 * 60 * 24));

            //     if ($date_diff > 90) {
            //         $contract_validity .= '<h4 class="m-0 font-15 text">VALID</h4>';
            //     } else if ($date_diff >= 60 && $date_diff <= 90) {
            //         $contract_validity .= '<h4 class="m-0 font-15 text-success">VALID</h4>';
            //     } else if ($date_diff >= 31 && $date_diff <= 60) {
            //         $contract_validity .= '<h4 class="m-0 font-15 text"><a class="m-0 font-15 text-warning" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\')">NEAR TO EXPIRE</a></h4>';
            //     } else if ($date_diff <= 30 && $date_diff >= 1) {
            //         $contract_validity .= '<h4 class="m-0 font-15 text"><a class="m-0 font-15 text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\')">TO EXPIRE</a></h4>';
            //     } else if ($date_diff < 0){
            //         $contract_validity .= '<h4 class="m-0 font-15 text"><a class="m-0 font-15 text-danger" href="javascript:void(0)" onclick="viewCrewContracts(\'' . $crew_code . '\')">EXPIRED</a></h4>';
            //     }
            // }
            $contract_validity .= "VALID";
        } else {
            $contract_validity .= 'N/A';
        }

        return $contract_validity;
    }

    public function generate_crew_lineup($params = array())
    {
        $this->db->select("
        c.crew_code,
        c.monitor_code,
        cm.x_port,
        cm.embark,
        cm.disembark,
        cm.status,
        CONCAT(acpi.first_name, ' ', acpi.middle_name, ' ', acpi.last_name) full_name,
        ap.position_name,
        av.vsl_name,
        c.flight_code");
        $this->db->from("crews c");
        $this->db->join("ac_personal_info acpi", "c.crew_code = acpi.crew_code");
        $this->db->join("cm_plan cm", "c.monitor_code = cm.offsigner", "LEFT");
        $this->db->join("a_position ap", "c.position = ap.id", "LEFT");
        $this->db->join("a_vessels av", "c.vessel_assign = av.id", "LEFT");
        $this->db->join("crew_flight cf", "c.flight_code = cf.flight_code", "LEFT");

        $this->db->where('cm.status', 3);

        if (!empty($params['search']['vessel'])) {
            $this->db->group_start();
            $this->db->where('c.vessel_assign', $params['search']['vessel']);
            $this->db->group_end();
        }

        if (!empty($params['search']['embark_date'])) {
            $this->db->group_start();
            $this->db->where('cm.embark', $params['search']['embark_date']);
            $this->db->group_end();
        }

        if (!empty($params['search']['joining_port'])) {
            $this->db->group_start();
            $this->db->like('LOWER(cm.x_port)', strtolower($params['search']['joining_port']));
            $this->db->group_end();
        }

        $this->db->order_by('cm.id', 'DESC');
        $this->db->group_by('c.crew_code');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
        
    }

    public function transfer_lineup_to_ga($params = array())
    {
        if ($params) {
            $db_payroll = $this->load->database('payroll', TRUE);

            foreach ($params as $key) {
                $crew_lineup_code = $this->global->generateID('CLNUP');

                $crew_lineup = [
                    'lineup_code'   => $crew_lineup_code,
                    'crew_code'     => $key['crew_code'],
                    'prepared_by'   => $this->global->ecdc('dc', $this->session->userdata('user_code')),
                    'crew_lineup_status'    => 1,
                    'date_created'  => date('Y-m-d H:i:s')
                ];

                $db_payroll->insert('crew_lineup', $crew_lineup);

                if ($key === end($params)) {
                    return true;
                }
            }
        }else{
            return false;
        }
    }
}

/* End of file M_crew_management.php */
