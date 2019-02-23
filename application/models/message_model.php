<?php
Class Message_model extends CI_Model
{	
	function get_type_user($roleid)
	{
		$this->db->select('u.id,u.role_id,u.first_name,u.last_name');
        $this->db->from('users as u');
		$this->db->where_in('u.role_id',$roleid);
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_user_role_name($role_id)
	{
		$this->db->select('r.id,r.role_name');
        $this->db->from('role as r');
		$this->db->where('r.id',$role_id);
        $result	= $this->db->get()->row();
		return $result;
	}
	function get_active_user_list($userType)
	{
		$this->db->select('u.id,u.first_name,u.last_name');
        $this->db->from('users as u');
		$this->db->where(array('u.role_id' => $userType,'status' => 1));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_user_roles()
	{
		$this->db->select('r.id,r.role_name');
		$this->db->from('role as r');
		$this->db->where(array('r.status' => 1));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_user_details($user_id)
	{
		$this->db->select('u.id,u.role_id,u.first_name,u.last_name,u.contact_number');
        $this->db->from('users as u');
		$this->db->where(array('u.id' => $user_id,'status' => 1));
        $result	= $this->db->get()->row_array();
		return $result;
	}
	function save_send_message($data)
	{
		    $this->db->insert('messages',$data);
			$insert_id = $this->db->insert_id();
	}
	function get_sended_message()
	{
		$this->db->select('m.*');
        $this->db->from('messages as m');
		$result	= $this->db->get()->result();
		return $result;
	}
	function delete_message($id)
	{
		if(!empty($id)){
			 $this->db->where(array('id'=>$id));
             $this->db->delete('messages');	
             return true;				 
		}
		
	}
	function get_users_by_campus_id($id)
	{   
	    
		$this->db->select('u.*');
		$this->db->from('users as u');
		$this->db->join('user_map_student_details as ud','ud.user_id=u.id','INNER');
		$this->db->where(array('ud.campus_id'=>$id));
		$result=$this->db->get()->result();
		return $result;
	}
	
	
	
} //end class