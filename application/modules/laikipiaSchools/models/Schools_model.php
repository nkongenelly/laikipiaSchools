<?php
class Schools_model extends CI_Model 
{
    function fetchschools()
    {
        $this->db->select('school_name, latitude, longitude, about,logo');
        $this->db->from('laikipia_schools');
        $query = $this->db->get();
        $ans = $query->result();
        echo (json_encode($ans));

        return $query->result();
    }
}
?>