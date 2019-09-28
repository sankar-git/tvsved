<?php
Class Payment_model extends CI_Model
{	
    function save_user_payment_info($data)
	{ 
	       // p($data);exit;
		    $this->db->insert('payments',$data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
	}
	function get_save_payment_data($trans_id)
	{
		$this->db->select('p.*');
		$this->db->from('payments as p');
		
		$this->db->where(array('p.transaction_id'=>$trans_id));
		$result=$this->db->get()->row();
		return $result;
	}
	function get_mypayment_details($userid)
	{
		$this->db->select('pr.*,p.program_name,s.semester_name,pay.semester_id,pay.payment_type');
		$this->db->from('payments_response as pr');
		$this->db->join('payments as pay','pay.transaction_id=pr.mer_txn','LEFT');
		$this->db->join('programs as p','pay.program_id=p.id','LEFT');
		$this->db->join('semesters as s','s.id=pay.semester_id','LEFT');
		$this->db->where(array('pr.user_id'=>$userid));
		$this->db->order_by("pr.id","desc");
		$result=$this->db->get()->result();
		return $result;
	}
	function get_transaction_history($tid){
		$this->db->select('p.*');
		$this->db->from('payments_response as p');
		$this->db->where(array('p.mer_txn'=>$tid));
		$result=$this->db->get()->row();
		return $result;
	}
	function get_response_data($ipg_txn_id){
		$this->db->select('id');
		$this->db->from('payments_response as p');
		$this->db->where('ipg_txn_id',$ipg_txn_id);
		$result=$this->db->get()->result();
		return $result;
	}
	function save_response($data)
	{
		$result=$this->get_response_data($data['ipg_txn_id']);
		if(count($result)>0){
		    return $result[0]->id;
		}else{
			$this->db->insert('payments_response',$data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}
	function get_save_payment_by_id($id,$transaction_id)
	{
		$this->db->select('p.*');
		$this->db->from('payments_response as p');
		$this->db->where(array('p.user_id'=>$id,'p.mer_txn'=>$transaction_id));
		$result=$this->db->get()->row();
		return $result;
	}
	function get_payment_history()
	{
		$this->db->select('p.*,u.first_name,u.last_name,u.user_unique_id,pay.payment_type,s.semester_name,pay.semester_id,pg.program_code,pg.program_name');
		$this->db->from('payments_response as p');
		$this->db->join('users as u','u.id=p.user_id');
		$this->db->join('payments as pay','p.mer_txn=pay.transaction_id','LEFT');
		$this->db->join('semesters as s','s.id=pay.semester_id','LEFT');
		$this->db->join('programs as pg','pg.id=pay.program_id','LEFT');
		$result=$this->db->get()->result();
		return $result;
	}
	function get_login_history()
	{
		$this->db->select('u.first_name,u.last_name,u.username,l.created_on,l.log_type,u.role_id,r.role_name,l.full_user_agent_string,l.ipaddress');
		$this->db->from('user_log as l');
		$this->db->join('users as u','u.id=l.user_id','LEFT');
		$this->db->join('role as r','r.id=u.role_id','LEFT');
		$result=$this->db->get()->result();
		return $result;
	}
	function get_sms_history()
	{
		$this->db->select('u.first_name,u.last_name,s.phone,message,sent_date,responseCode,s.user_id,u.username');
		$this->db->from('sms_delivery as s');
		$this->db->join('users as u','u.id=s.user_id','LEFT');
		
		$result=$this->db->get()->result();
		return $result;
	}
	function delete_payment_history_by_id($id)
	{   
	    $this->db->where('id',$id);
		$this->db->delete('payments_response');
		return true;
	}
	function get_student_details($userid,$program_id='',$semester_id=''){
		if($userid>0){
			$this->db->select("u.user_unique_id,CONCAT(u.first_name,' ',u.last_name) as name, u.contact_number,u.email,b.batch_name,c.campus_name,c.address1, d.degree_name,dis.discipline_name,p.program_name",false);
			if($semester_id>0){
				$this->db->select('semester_name');
				$this->db->from('users as u join semesters s');
			}else
				$this->db->from('users as u');
			$this->db->join('user_map_student_details umd','umd.user_id = u.id','left')
			->join('batches b','b.id=umd.batch_id','left')
			->join('campuses c','c.id=umd.campus_id','left')
			->join('degrees d','d.id=umd.degree_id','left')
			->join('disciplines dis','d.discipline_id=dis.id','left')
			->join('programs p','d.program_id=p.id','left');
			$this->db->where('u.id',$userid);
			if($program_id>0)
				$this->db->where('d.id',$program_id);
			if($semester_id>0){
				$this->db->where('s.id',$semester_id);
			}
			return $this->db->get()->result_array();
		}
	}
	
	
	
} //end class