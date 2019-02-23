<?php
Class User_model extends CI_Model
{	
	function save_user($data)
	{
		    $this->db->insert('users',$data);
			$insert_id = $this->db->insert_id();
	}
	function list_user()
	{
		return $this->db->order_by('first_name', 'ASC')->get('users')->result();
	}
	function getUserList($id){
		if( !empty($id) ){
		$result = $this->db->get_where('user',['id'=>$id]);	
		}else{
		$result = $this->db->get('user');	
		}
		return $result->result();
	}
	
	function getfeaturedProvider(){
		$this->db->select('provider.provider_id, provider.provider_name, provider.provider_image, provider.provider_expertise')
			->from('provider')
			->limit('8');
			//->where('provider.id', $id);
			$result = $this->db->get();
			
		return $result->result();
	}
	
	function getUserBasicDetail($id=false){
		/* if( !empty($id) ){
			$result = $this->db->get_where('user',['id'=>$id]);	
		}else{
			$result = $this->db->get('user');	
		} */
		
		$this->db->select('user.id, user.username, user.user_image, user.created_time')
			->from('user')
			->where('user.id', $id);
			//$this->db->get();
			//echo $this->db->last_query();
			//die;
			return $this->db->get()->row();
	}
	
	function getAddress($id){
		if($id){
			$query  = $this->db->get_where('user_address',['user_id'=>$id]);
			///echo $this->db->last_query();
			return $query->result();
		}
	}
	function addAddress($id,$data){
		$data1['primary'] = 1;
		if(!empty($id)){
			$this->db->where('id',$id);
			$this->db->update('user_address',$data);
			
			if(!empty($data['primary'])){
				$this->primaryAddress($this->session->userdata('user_id'), $id, $data1);
			}
		}else{
			$this->db->insert('user_address',$data);
			$insert_id = $this->db->insert_id();
			
			if(!empty($data['primary'])){
				$this->primaryAddress($this->session->userdata('user_id'), $insert_id, $data1);
			}
			
		}
		//echo $this->db->last_query();
			if($this->db->affected_rows()>0 ){
				return 1;
			}else{
				return 0;
			}
	}
	function saveRequest($data){
		$this->db->insert('user_request',$data);
		return  $insert_id = $this->db->insert_id();
	}
	function updateRequest($rId, $data){
		$this->db->where('id', $rId);
		$this->db->limit(1);
		$this->db->update('user_request',$data);
		return true;
	}
	function getMyRequests($id){
		if($id){
			$this->db->select('user_request.*, category.category_name, tbl_subCat.category_name as subCat')
			->from('user_request')
			->where('user_request.user_id', $id);
			
			$this->db->join('category','category.category_id = user_request.cat_id');
			$this->db->join ('category tbl_subCat', 'tbl_subCat.category_id = user_request.scat_id' , 'left' );
			$this->db->order_by('id','DESC');
			//$this->db->get();
			//echo $this->db->last_query();
			//die;
			return $this->db->get()->result();
		}
	}
	
	function getAssignedRequests($id){
		if($id){
			$this->db->select('user_request.*, category.category_name, tbl_subCat.category_name as subCat')
			->from('user_request')
			->where('user_request.user_id', $id);
			
			$this->db->join('category','category.category_id = user_request.cat_id');
			$this->db->join ('category tbl_subCat', 'tbl_subCat.category_id = user_request.scat_id' , 'left' );
			$this->db->join ('provider', 'provider.provider_id = user_request.assigned_to');
			$this->db->where('user_request.assigned_to !=', '0');
			$this->db->order_by('id','DESC');
			//$this->db->get();
			//echo $this->db->last_query();
			//die;
			return $this->db->get()->result();
		}
	}
	
	function getRecentlyViewedProviders($userId){
		$this->db->select('provider.provider_id, provider_prof_views.date_time, provider.provider_name, provider.provider_image')
			->from('provider_prof_views')
			->where('provider_prof_views.view_by_user_id', $userId);
			
			$this->db->join('provider','provider.provider_id = provider_prof_views.provider_id');
			$this->db->order_by('provider_prof_views.id','DESC');
			$this->db->limit('10');
			//$this->db->get();
			//echo $this->db->last_query();
			//die;
			return $this->db->get()->result();
	}
	function getMyRequestMessages($rId){
		if($rId){
			
			$this->db->select('woc.*, provider.provider_name, provider.provider_image, count(woc.comment_id) ttl_comnt');
			$this->db->from('work_order_comments woc');
			$this->db->join('provider', 'provider.provider_id = woc.provider_id');
			$this->db->where('woc.user_request_id', $rId);
			$this->db->where('woc.created_by', 'Provider');
			//$this->db->where('woc.cmnt_read', '0');
			$this->db->group_by('woc.provider_id');
			$this->db->order_by('woc.comment_id', 'DESC');
			
			$result = $this->db->get();
			
			//echo $this->db->last_query();
			//die;
			
			//return $this->db->get()->row();
			return $result->result();
		}
	}
	
	function lastComment($rId, $providerId){
		if($rId){
			$sql="SELECT * FROM work_order_comments WHERE user_request_id = $rId AND provider_id = $providerId ORDER BY comment_id DESC LIMIT 1";
			$result = $this->db->query($sql);
			
			//echo $this->db->last_query();
			//die;
			
			return $result->row();
		}
	}
	
	function total_unread_comments($rId, $providerId){
		if($rId){
			
			//$sql="SELECT woc.*, provider.provider_name, provider.provider_image FROM work_order_comments woc INNER JOIN provider ON provider.provider_id = woc.provider_id WHERE woc.user_request_id = $rId AND woc.created_by = 'Provider' AND woc.comment_id IN(SELECT MAX(comment_id) FROM work_order_comments GROUP BY provider_id) GROUP BY woc.provider_id";
			$sql="Select COUNT(comment_id) ttlCmnt FROM work_order_comments WHERE cmnt_read = 0 AND user_request_id = $rId AND created_by = 'Provider' AND provider_id = $providerId GROUP BY provider_id";
			$result = $this->db->query($sql);
			
			//echo $this->db->last_query();
			//die;
			
			//return $this->db->get()->row();
			return $result->row();
		}
	}
	
	function getCommentsByProvider($woId=false, $provId=false){
		
		$this->db->select('woc.*, user.username, user.user_image, provider.provider_name, provider.provider_image');
        $this->db->from('work_order_comments woc');
		$this->db->join('user', 'user.id = woc.user_id');
		$this->db->join('provider', 'provider.provider_id = woc.provider_id');
		$this->db->where('woc.order_id', $woId);
		$this->db->where('woc.provider_id', $provId);
		$result = $this->db->get();
		
		//echo $this->db->last_query();
		//die;
		$array = array('order_id' => $woId, 'provider_id' => $provId, 'created_by' => 'Provider');
		$data1['cmnt_read'] = 1;
		$this->db->where($array);
		$this->db->update('work_order_comments',$data1);
		//echo $this->db->last_query();
		//die;
		
		return $result->result();
	}
	
	function close_request($userId=false, $requestId=false, $data){
		//$this->db->insert('work_orders',$data);
		$this->db->where('id', $requestId);
		$this->db->limit(1);
		$this->db->update('user_request',$data);
		return true;
		//echo $this->db->last_query();
		//die;
	}
	
	function assign_work($userId=false, $requestId=false, $data){
		//$this->db->insert('work_orders',$data);
		$this->db->where('id', $requestId);
		$this->db->limit(1);
		$this->db->update('user_request',$data);
		return true;
		//echo $this->db->last_query();
		//die;
	}
	
	function updateWorkOrderStatus($data, $wOrderId=false, $cmntId=false){
		//$this->db->insert('work_orders',$data);
		$this->db->where('comment_id',$cmntId);
		$this->db->limit('1');
		$this->db->update('work_order_comments', $data);
		
		if($this->db->affected_rows() >= 0){
			$this->db->where('id', $wOrderId);
			$this->db->limit('1');
			$this->db->update('work_orders', $data);	
			
			return true;
		}else{
			echo false;
		}
	}
	
	function getWorkOrderStauts($cmntId=false){
		//$this->db->insert('work_orders',$data);
		$this->db->select('*');
        $this->db->from('work_order_comments');
		$this->db->where('comment_id', $cmntId);
		$result = $this->db->get();
		//echo $this->db->last_query();
		//die;
		return $result->row();
	}
	
	function workOrder_action($userId=false, $workOrderId=false, $data){
		//$this->db->insert('work_orders',$data);
		$this->db->where('id', $workOrderId);
		$this->db->limit(1);
		$this->db->update('work_orders',$data);
		return true;
		//echo $this->db->last_query();
		//die;
	}
	
	function saveWorkOrder($data){
		$this->db->insert('work_orders',$data);
		
	}
	
	function addUser($id,$data)
    {
		if( !empty($id) ){
		$this->db->where('id',$id);
		$this->db->update('user',$data);	
		}else{
        $this->db->insert('user',$data);
		}
    }
	function activate_account($email, $data)
    {
		$this->db->where('user_email',$email);
		$this->db->limit('1');
		$this->db->update('user',$data);
		
		if($this->db->affected_rows() >= 0){
		  return true;
		}else{
		  echo false;
		}
    }
	function login($email, $password, $remember=false){
        $sql="SELECT * FROM user 
            WHERE user_email ='$email' AND login_password='".sha1($password)."' OR login_username ='$email' AND login_password='".sha1($password)."'";
        $result = $this->db->query($sql);
		//echo $this->db->last_query();
        return $result->row_array();
    }
	function primaryAddress($user_id, $id, $data)
    {
		$data1['primary'] = 0;
		$this->db->where('user_id',$user_id);
		$this->db->update('user_address', $data1);
		
		$this->db->where('id',$id);
		$this->db->limit('1');
		$this->db->update('user_address',$data);
		
		if($this->db->affected_rows() >= 0){
		  return true;
		}else{
		  echo false;
		}
    }
	
	function getRequestById($rid){
		if($rid){
			$query  = $this->db->get_where('user_request',['id'=>$rid]);
			//echo $this->db->last_query();
			//die;
			return $query->row();
		}
	}
}