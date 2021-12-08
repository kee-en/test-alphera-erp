<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_restore_vessel extends CI_Model
{

    function restoreVessel($id)
    {
        $this->db->where('id', $id)->set('status', 1)->update('a_vessels');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function permanentlyDeleteVessel($id)
    {
        $this->db->where('id', $id)->delete('a_vessels');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }  
    }
}

/* End of file M_restore_vessel.php */
