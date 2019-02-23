<?php
class sub_admin_mange_list_model extends CI_Model
{


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

    }

    function sub_admin_listing()
    {
        $this->db->select('*');
        $this->db->from('tbluser AU');
        $this->db->join('tblemail AE','AE.email_id=AU.id','left');
        $this->db->where('AU.role_id','2');
        $query=$this->db->get();
        $result=$query->result();
        return $result;
    }


    function sub_admin_listing_by_filter($active_inactive_value)
    {
        $this->db->select('*');
        $this->db->from('tbluser AU');
        $this->db->join('tblemail AE','AE.email_id=AU.id','left');
        if($active_inactive_value=='active')
        {

            $this->db->where('AU.status','active');
        }
        else
        {
            $this->db->where('AU.status','inactive');
        }
        $this->db->where('AU.role_id','2');
        $query=$this->db->get();
        $result=$query->result();
        return $result;
    }
}
?>