<?php
class page_permission_model extends CI_Model 
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
	   
    }
    
	function all_permission_page_listing($user_id)
	{
		//echo $user_id;
	    $this->db->select('*');
		$this->db->from('tbl_admin_parent_page APP');
		//$this->db->join('tbl_admin_sub_page ASP','ASP.sub_page_id=APP.parent_page_id','left');
		$this->db->join('tbl_admin_user_page_permission AUPP','AUPP.page_id=APP.parent_page_id AND AUPP.admin_user_id='.$user_id.'','left');
		
		$query=$this->db->get();
		$result=$query->result();
		return $result;
		
	}
	function all_page_permission_listing_by_filter($allow_dis_allow_value)
	{
		//echo $allow_dis_allow_value;exit;
		$this->db->select('*');
		$this->db->from('tbl_admin_parent_page APP');
		$this->db->join('tbl_admin_user_page_permission AUPP','AUPP.page_id=APP.parent_page_id AND AUPP.admin_user_id=1','left');
		
		if($allow_dis_allow_value=='allow')
		{
			
			$this->db->where('AUPP.is_view','Y');
		}
		else
		{
			$this->db->where('AUPP.is_view','N');	
		}
		
		//print_r($result);
		$query=$this->db->get();
		$result=$query->result();
		return $result;
	}
	
	function user_permission_availability_check($user_id,$page_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_admin_user_page_permission');
		$this->db->where('admin_user_id',$user_id);
		$this->db->where('page_id',$page_id);		
		$query=$this->db->get();
		$result=$query->result();
		return $result;	
	}
}
?>