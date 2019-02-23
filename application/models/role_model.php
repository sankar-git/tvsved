<?php
Class Role_model extends CI_Model
{	
	function get_role_list()
	{
		$this->db->select('*');
		$this->db->from('role as r');
		$result=$this->db->get()->result();
		return $result;
	}
	function get_role_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('role as r');
		$this->db->where(array('r.id'=>$id));
		$result=$this->db->get()->row();
		return $result;
	}
	function save_role($data)
	{
		$this->db->insert('role',$data);
		$insert_id=$this->db->insert_id();
		return $insert_id;
	}
	function update_role($id,$data)
	{
	    if( !empty($id) )
		{
			$this->db->where('id',$id);
			$this->db->update('role',$data);
			return true;			
		}
	}
	
	function role_status($id,$dstatus)
	{
		
		if($dstatus==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update role set role.`status`=$save where role.id=$id;");
		return true;			
		}
	}
	
	
	
	
} //end class