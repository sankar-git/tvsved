<?php
class session_check_and_session_data extends CI_Model 
{

    
    function __construct()
    {
        //Call the Model constructor
        parent::__construct();
	   
    }
	function admin_session_data()
	{
		$session_user_id=$this->session->userdata('session_user_id');
		$response=$this->admin_details($session_user_id);
		return $response;
		
		
	}
	
	function session_check()
	{
		$session_user_id=$this->session->userdata('session_user_id');
		//echo $session_user_id;
		$response=$this->admin_details($session_user_id);
		$count=count($response);
		if($count>0)
		{
			return true;
		}
		else
		{
			redirect('index.php/login');
		}
		
	}
	
	function admin_details($id)
	{
		$this->db->select('*');
		$this->db->from('tbluser');
		
		$this->db->where('id',$id);
		//$this->db->where('role_id',1);
		$query=$this->db->get();
		$result=$query->result();
		return $result;
	}
	
	
	
	
}
?>