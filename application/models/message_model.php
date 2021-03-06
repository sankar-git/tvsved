<?php
Class Message_model extends CI_Model
{	
	function get_type_user($roleid,$campus_id='',$program_id='',$batch_id='',$degree_id='',$semester_id='',$discipline='')
	{
		$this->db->select('u.id,u.role_id,u.first_name,u.last_name');
        $this->db->from('users as u');
		if($roleid == 1 || $roleid == 6){
			$this->db->join('student_assigned_courses as ud','ud.student_id=u.id','INNER');
			$this->db->where(array('ud.campus_id'=>$campus_id,'ud.program_id'=>$program_id,'ud.degree_id'=>$degree_id,'ud.batch_id'=>$batch_id,'ud.semester_id'=>$semester_id));
			$this->db->group_by('u.id');
		}else{
			$this->db->join('user_map_teacher_details as ud','ud.user_id=u.id','INNER');
			$this->db->where(array('ud.campus'=>$campus_id));
			//if($discipline>0)
				//$this->db->where(array('ud.discipline'=>$discipline));
		}
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
	function get_department()
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