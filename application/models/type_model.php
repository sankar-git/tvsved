<?php
Class Type_model extends CI_Model
{	
	function check_user($username)
	{
		$result = $this->db->where(['username'=>$username])->from("users")->count_all_results();
		return $result;
	}
	function isuser($user_unique_id,$application_no='')
	{
		$this->db->select('id')->from("users");
		if(!empty($user_unique_id))
			$this->db->where(['user_unique_id'=>$user_unique_id]);
		else if(!empty($application_no))
			$this->db->where(['application_no'=>$application_no]);
		$result = $this->db->get()->row();
		return $result;
	}
	function get_user_details($username)
	{
		$result = $this->db->where(['username'=>$username])->from("users")->get()->result_array();
		return $result;
	}
	function save_user($data)
	{
		    $this->db->insert('users',$data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
	}
	function save_user_details($data,$type)
	{       
	        if($type=='1' || $type=='6')
			{
				$this->db->insert('user_map_student_details',$data);
				$parent_id = $this->db->insert_id();
				return $parent_id; 
				
			}else
			{
				$this->db->insert('user_map_teacher_details',$data);
				$insert_id = $this->db->insert_id();
				return $insert_id; 
			}
	}
	
	
	function save_user_school_details($data)
	{       
				$this->db->insert('student_school_details',$data);
				$insert_id = $this->db->insert_id();
				return $insert_id;		
	}
	function update_user_school_detail($data)
	{       
		$id = $data['student_id'];
		$this->db->where('student_id',$id);
		$this->db->update('student_school_details',$data);
		return true;
	}
	function save_user_education_details($data)
	{       
				$this->db->insert('student_education_details',$data);
				$insert_id = $this->db->insert_id();
				return $insert_id;		
	}
	function update_user_education_detail($data)
	{       
		$id = $data['student_id'];
		$this->db->where('student_id',$id);
		$this->db->update('student_education_details',$data);
		return true;
	}
	function save_user_transaction_details($data)
	{       
				$this->db->insert('student_transaction_details',$data);
				$insert_id = $this->db->insert_id();
				return $insert_id;		
	}
	function update_user_transaction_detail($data)
	{       
		$id = $data['student_id'];
		$this->db->where('student_id',$id);
		$this->db->update('student_transaction_details',$data);
		return true;	
	}
	function get_user_data($email)
	{
		$this->db->select('u.*');
		$this->db->from('users as u');
		$this->db->where(array('u.email'=>$email,'u.status'=>1));
		$result=$this->db->get()->row();
		return $result;
	}
	function update_password_by_email($data,$email)
	{
		if( !empty($email))
		{
		$this->db->where('email',$email);
		$this->db->update('users',$data);
		return true;			
		}
	}
	function get_degree_name($d_id)
	{
		$this->db->select('degrees.degree_name');
        $this->db->from('degrees');
		$this->db->where('id', $d_id);
        $result	= $this->db->get()->row();
		return $result;
	}
	function get_batch_name($batch_id)
	{
		$this->db->select('batches.batch_name');
        $this->db->from('batches');
		$this->db->where('id', $batch_id);
        $result	= $this->db->get()->row();
		return $result;
	}
	function add_unique_id_of_student($id,$data)
	{
		
		if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('users',$data);
		return true;			
		}
	}
	function list_user($role_type='')
	{
	    if($role_type == 'admin') {
            $ignore = array(1, 2,5,6);
            $this->db->select('users.*,role.role_name')->from('users')->join('role', 'users.role_id=role.id', 'left')->order_by('first_name', 'ASC')->where_not_in('role_id', $ignore);
        }else if($role_type == 'student') {
            $this->db->select('u.*,role.role_name')->from('users u')->join('user_map_student_details as s','s.user_id = u.id','LEFT')->join('role', 'u.role_id=role.id', 'left')->where('u.role_id', 1);
            if(isset($_POST['campus_id']) && $_POST['campus_id'] != '' && $_POST['campus_id'] != '0')
                $this->db->where('s.campus_id', $_POST['campus_id']);
           // if(isset($_POST['program_id']) && $_POST['program_id'] != '' && $_POST['program_id'] != '0')
               // $this->db->where('s.program_id', $_POST['program_id']);
            if(isset($_POST['degree_id']) && $_POST['degree_id'] != '' && $_POST['degree_id'] != '0')
                $this->db->where('s.degree_id', $_POST['degree_id']);
            if(isset($_POST['batch_id']) && $_POST['batch_id'] != '' && $_POST['batch_id'] != '0')
                $this->db->where('s.batch_id', $_POST['batch_id']);
        }else if($role_type == 'alumini') {
            $this->db->select('u.*,role.role_name')->from('users u')->join('user_map_student_details as s','s.user_id = u.id','LEFT')->join('role', 'u.role_id=role.id', 'left')->where('u.role_id', 6);
            if(isset($_POST['campus_id']) && $_POST['campus_id'] != '' && $_POST['campus_id'] != '0')
                $this->db->where('s.campus_id', $_POST['campus_id']);
           // if(isset($_POST['program_id']) && $_POST['program_id'] != '' && $_POST['program_id'] != '0')
               // $this->db->where('s.program_id', $_POST['program_id']);
            if(isset($_POST['degree_id']) && $_POST['degree_id'] != '' && $_POST['degree_id'] != '0')
                $this->db->where('s.degree_id', $_POST['degree_id']);
            if(isset($_POST['batch_id']) && $_POST['batch_id'] != '' && $_POST['batch_id'] != '0')
                $this->db->where('s.batch_id', $_POST['batch_id']);
        }else if($role_type == 'teacher') {
            $this->db->select('u.*,role.role_name')->from('users u')->join('user_map_teacher_details as s','s.user_id = u.id','LEFT')->join('role', 'u.role_id=role.id', 'left')->where('u.role_id', 2);
            if(isset($_POST['campus_id']) && $_POST['campus_id'] != '' && $_POST['campus_id'] != '0')
                $this->db->where('s.campus', $_POST['campus_id']);
        }else if($role_type == 'parent') {
            $this->db->select("u.*,role.role_name")->from('users u')->join('user_map_student_details as s','s.user_id = u.id','LEFT')->join('role', 'u.role_id=role.id', 'left')->where('u.role_id', 5);
            if(isset($_POST['campus_id']) && $_POST['campus_id'] != '' && $_POST['campus_id'] != '0')
                $this->db->where('s.campus_id', $_POST['campus_id']);

        }else{
	        return false;
        }

        return $this->db->get()->result();//method chaining

	}
	function registerStudent()
	{
		//$ignore = array(1, 2);
		return $this->db->order_by('first_name', 'ASC')->get('students')->result();//method chaining
	}
	
	function list_student()
	{
		//print_r($_POST);
		$this->db->select('*,u.id as uid');
        $this->db->from('users u');
		$this->db->join('user_map_student_details as s','s.user_id = u.id','LEFT');
		$this->db->where('u.role_id', 1);
		if(isset($_POST['campus_id']) && $_POST['campus_id'] != '' && $_POST['campus_id'] != '0')
			$this->db->where('s.campus_id', $_POST['campus_id']);
		//if(isset($_POST['program_id']) && $_POST['program_id'] != '' && $_POST['program_id'] != '0')
			//$this->db->where('s.program_id', $_POST['program_id']);
		if(isset($_POST['degree_id']) && $_POST['degree_id'] != '' && $_POST['degree_id'] != '0')
			$this->db->where('s.degree_id', $_POST['degree_id']);
		if(isset($_POST['batch_id']) && $_POST['batch_id'] != '' && $_POST['batch_id'] != '0')
			$this->db->where('s.batch_id', $_POST['batch_id']);
		//if(isset($_POST['semester_id']) && $_POST['semester_id'] != '' && $_POST['semester_id'] != '0')
			//$this->db->where('s.semester_id', $_POST['semester_id']);
		//if(isset($_POST['discipline_id']) && $_POST['discipline_id'] != '' && $_POST['discipline_id'] != '0')
			//$this->db->where('s.course_id', $_POST['discipline_id']);
		$this->db->order_by('first_name', 'ASC');
        $result	= $this->db->get()->result();
		//echo $this->db->last_query();//exit;
		return $result;
		//return $this->db->order_by('first_name', 'ASC')->where('role_id', '1')->get('users')->result();//method chaining
	}
	
	function list_teacher()
	{
		//print_r($_POST);
		$this->db->select('*,u.id as uid');
        $this->db->from('users u');
		$this->db->join('user_map_teacher_details as t','t.user_id = u.id','LEFT');
		$this->db->where('u.role_id', 2);
		if(isset($_POST['campus_id']) && $_POST['campus_id'] != '' && $_POST['campus_id'] != '0')
			$this->db->where('t.campus', $_POST['campus_id']);
		/*if($_POST['program_id'] != '' && $_POST['program_id'] != '0')
			$this->db->where('s.program_id', $_POST['program_id']);
		if($_POST['degree_id'] != '' && $_POST['degree_id'] != '0')
			$this->db->where('s.degree_id', $_POST['degree_id']);
		if($_POST['batch_id'] != '' && $_POST['batch_id'] != '0')
			$this->db->where('s.batch_id', $_POST['batch_id']);
		if($_POST['semester_id'] != '' && $_POST['semester_id'] != '0')
			$this->db->where('s.semester_id', $_POST['semester_id']);*/
		if(isset($_POST['discipline_id']) && $_POST['discipline_id'] != '' && $_POST['discipline_id'] != '0')
			$this->db->where('t.discipline', $_POST['discipline_id']);
		$this->db->order_by('first_name', 'ASC');
        $result	= $this->db->get()->result();
	//	echo $this->db->last_query();//exit;
		return $result;
		//return $this->db->order_by('first_name', 'ASC')->where('role_id', '1')->get('users')->result();//method chaining
	}
	function list_user1()
	{
		$this->db->select('*');
        $this->db->from('users');
		$this->db->where('name !=', $name);
        $result	= $this->db->get()->result();
		return $result;
		
		
	}
    function get_role()
	{
		$this->db->select('*');
        $this->db->from('role');
		$this->db->where('status', 1);
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_user_by_role($role_id)
	{

        if($role_id == 1) {
            $this->db->select('u.id,u.first_name,u.last_name,u.user_unique_id')->from('users u')->join('user_map_student_details as s','s.user_id = u.id','LEFT');
            if(isset($_POST['campus_id']) && $_POST['campus_id'] != '' && $_POST['campus_id'] != '0')
                $this->db->where('s.campus_id', $_POST['campus_id']);
            // if(isset($_POST['program_id']) && $_POST['program_id'] != '' && $_POST['program_id'] != '0')
            // $this->db->where('s.program_id', $_POST['program_id']);
            if(isset($_POST['degree_id']) && $_POST['degree_id'] != '' && $_POST['degree_id'] != '0')
                $this->db->where('s.degree_id', $_POST['degree_id']);
            if(isset($_POST['batch_id']) && $_POST['batch_id'] != '' && $_POST['batch_id'] != '0')
                $this->db->where('s.batch_id', $_POST['batch_id']);
            $this->db->order_by('user_unique_id','ASC');
        }else if($role_id == 6) {
            $this->db->select('u.id,u.first_name,u.last_name,u.user_unique_id')->from('users u')->join('user_map_student_details as s','s.user_id = u.id','LEFT');
            if(isset($_POST['campus_id']) && $_POST['campus_id'] != '' && $_POST['campus_id'] != '0')
                $this->db->where('s.campus_id', $_POST['campus_id']);
            // if(isset($_POST['program_id']) && $_POST['program_id'] != '' && $_POST['program_id'] != '0')
            // $this->db->where('s.program_id', $_POST['program_id']);
            if(isset($_POST['degree_id']) && $_POST['degree_id'] != '' && $_POST['degree_id'] != '0')
                $this->db->where('s.degree_id', $_POST['degree_id']);
            if(isset($_POST['batch_id']) && $_POST['batch_id'] != '' && $_POST['batch_id'] != '0')
                $this->db->where('s.batch_id', $_POST['batch_id']);
            $this->db->order_by('user_unique_id','ASC');
        }else if($role_id == 2) {
            $this->db->select('u.id,u.first_name,u.last_name,u.user_unique_id')->from('users u')->join('user_map_teacher_details as s','s.user_id = u.id','LEFT')->order_by('first_name', 'ASC');
            if(isset($_POST['campus_id']) && $_POST['campus_id'] != '' && $_POST['campus_id'] != '0')
                $this->db->where('s.campus', $_POST['campus_id']);
        }else if($role_id == 5) {
            $this->db->select("u.id,u.first_name,u.last_name,u.user_unique_id")->from('users u')->join('user_map_student_details as s','s.user_id = u.id','LEFT');
            if(isset($_POST['campus_id']) && $_POST['campus_id'] != '' && $_POST['campus_id'] != '0')
                $this->db->where('s.campus_id', $_POST['campus_id']);
            $this->db->order_by('user_unique_id','ASC');
        }else{
                $this->db->select('u.id,u.first_name,u.last_name,u.user_unique_id')->from('users u')->join('role', 'u.role_id=role.id', 'left')->order_by('first_name', 'ASC');
        }
        $this->db->where(array('u.role_id' =>$role_id,'u.status'=> 1));
        $result	= $this->db->get()->result();
	//echo	$this->db->last_query(); die;
		return $result;
	}
	function get_country()
	{
		$this->db->select('*');
        $this->db->from('country');
	    $result	= $this->db->get()->result();
		return $result;
	}
	function get_community()
	{
		$this->db->select('*');
        $this->db->from('community');
	    $result	= $this->db->get()->result();
		return $result;
	}
	function get_campus()
	{
		$this->db->select('*');
        $this->db->from('campuses');
		$this->db->where(array('status'=> 1));
	    $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_state()
	{
		$this->db->select('*');
        $this->db->from('state');
	    $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_city()
	{
		$this->db->select('*');
        $this->db->from('city');
	    $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_country_by_id($id)
	{
		$this->db->select('*');
        $this->db->from('state');
        $this->db->where(array('country_id' => $id));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_caste_by_id($id='')
	{
		$this->db->select('*');
        $this->db->from('caste');
		if($id>0)
			$this->db->where(array('community_id' => $id));
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_caste()
	{
		$this->db->select('*');
        $this->db->from('caste');
        //$this->db->where(array('community_id' => $id));
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_degree_by_campus_id($id)
	{
		$this->db->select('degrees.*');
        $this->db->from('campus_map_degree_and_programs as cmd');
        $this->db->join('degrees','degrees.id = cmd.degree_id','INNER');
        $this->db->where(array('cmd.campus_id' => $id));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_page()
	{
		$this->db->select('*');
        $this->db->from('tblpage');
	    $result	= $this->db->get()->result();
		return $result;
	}
	
	function save_permissions($data,$table)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	function getPermitedPages($userid)
	{
		$this -> db -> select('*');
		$this -> db -> from('permission');
		$this->db->where('user_id = '.$userid);
		$this->db->order_by('page_id','ASC');
		$query = $this -> db -> get();
		$permission = array();
		if($query -> num_rows()>0)
		{
			foreach($query->result() as $row)
			{
				$permission[] = array(
					'id'=>trim($row->permission_id),
					'user_id'=>trim($row->user_id),
					'page_id'=>trim($row->page_id)
				);
			}
		}
		return $permission;
	}
	function delete_data($table,$columname,$columnvalue)
	{
		$this->db->where($columname,$columnvalue);
		$this->db->delete($table);
		//echo $this->db->last_query();exit;
	}
    function get_menu_permission($userid)
	{
		
		 $this->db->select('pg.*');
		 $this->db->from('tblpage as pg');
		 $this->db->join('permission','permission.page_id = pg.page_id','INNER');
		 $this->db->where('permission.user_id', $userid);
		 
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_pending_user_by_id($id)
	{   
		$this->db->select('up.email,up.contact_number');
			$this->db->from('users as u');
			$this->db->join('tbl_user_pending_updates as up','up.user_id = u.id');
			$this->db->where(array('u.id' => $id));
			$result	= $this->db->get()->result_array();
			return $result;
	}
	function get_user_school_by_id($id)
	{   
		$this->db->select('*');
		$this->db->from('student_school_details as u');
		$this->db->where(array('u.student_id' => $id));
		$result	= $this->db->get()->result_array();
		return $result;
	}
	function get_user_education_by_id($id)
	{   
		$this->db->select('*');
		$this->db->from('student_education_details as u');
		$this->db->where(array('u.student_id' => $id));
		$result	= $this->db->get()->result_array();
		return $result;
	}
	function get_user_transaction_by_id($id)
	{   
		$this->db->select('*');
		$this->db->from('student_transaction_details as u');
		$this->db->where(array('u.student_id' => $id));
		$result	= $this->db->get()->result_array();
		return $result;
	}
	function get_user_by_id($id,$role_id)
	{   
	    if($role_id=='1' || $role_id=='6'){
			$this->db->select('u.*,umd.*,u.id as uid,u.role_id as urole_id,u.role_id as role_id,u.id as user_id,
			d.degree_code,d.degree_name,d.id,dis.discipline_code,dis.discipline_name,p.program_code,p.program_name,d.program_id,umd.semester_id');
			$this->db->from('users as u');
			$this->db->join('user_map_student_details as umd','umd.user_id = u.id','LEFT');
			$this->db->join('degrees d','d.id=umd.degree_id','LEFT');
			$this->db->join('disciplines dis','d.discipline_id=dis.id','LEFT');
			$this->db->join('programs p','p.id=d.program_id','LEFT');
			$this->db->where(array('u.id' => $id));
			$result	= $this->db->get()->row();//echo $this->db->last_query();exit;
			return $result;
		}else{
			$this->db->select('u.*,utd.address_line1,u.id as uid,u.role_id as urole_id,u.role_id as role_id,u.id as user_id,
			                   utd.address_line2,utd.address_line3,utd.address_line4,
							   utd.landline_number,utd.employee_id,utd.qualification,
							   utd.date_of_joining,utd.designation,utd.department,utd.campus,utd.discipline');
			$this->db->from('users as u');
			$this->db->join('user_map_teacher_details as utd','utd.user_id = u.id','LEFT');
			$this->db->where(array('u.id' => $id));
			$result	= $this->db->get()->row();
			return $result;
		}
		
	}
	function update_user_id($data,$user_id)
	{
		$this->db->where(array('id'=>$user_id));
		$this->db->update('users',$data);
		return true;
	}
	function permit_page_access_by_user_id($user_id,$role_id)
	{
		$this->db->select('*');
        $this->db->from('tblpage as tp');
		$this->db->join('permission as p','p.page_id = tp.page_id','INNER');
		//$this->db->join('users as u','u.id = tp.page_id','INNER');
        $this->db->where(array('p.user_id' => $user_id,'p.role_id' => $role_id));
        $result	= $this->db->get()->result();
		return $result;
	}
	function update_common_user_by_id($id,$data)
	{
		if( !empty($id) )
		{
			$this->db->where('id',$id);
			$this->db->update('users',$data);
			return $id;			
		}else{
			$this->db->insert('users',$data);
			return $this->db->insert_id();
		}
		
	}
	function update_teacher_details_by_id($id,$data)
	{
		//print_r($id);
		//print_r($data); exit;
		$this->db->select('id');
		  $this->db->from('user_map_teacher_details');
		  $this->db->where(array('user_id'=>$id));
		  $result=$this->db->get()->result();//echo $this->db->last_query();
		if( count($result)>0 )
		{
			$this->db->where('user_id',$id);
			$this->db->update('user_map_teacher_details',$data);
			return $id;			
		}else{
			$data['user_id'] = $id;
			$this->db->insert('user_map_teacher_details',$data);
			return $this->db->insert_id();
		}
		
	}
	function update_student_detail_by_id($id,$data)
	{
			$this->db->select('id');
		  $this->db->from('user_map_student_details');
		  $this->db->where(array('user_id'=>$id));
		  $result=$this->db->get()->result();
		if( count($result)>0 )
		{
			$this->db->where('user_id',$id);
			$this->db->update('user_map_student_details',$data);
			return $id;			
		}else{
			$data['user_id'] = $id;
			$this->db->insert('user_map_student_details',$data);
			return $this->db->insert_id();
		}
	}
	function student_status($id,$status)
    {
		
	    if($status==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update users set users.`status`=$save where users.id=$id;");
		return true;			
		}	
	}
	  function get_menu()
	  {
		  $this->db->select('*');
		  $this->db->from('tbladminmenu');
		  $this->db->where(array('r_status'=>'Active'));
		  $result=$this->db->get()->result();
		  return $result;
	  }
    function get_assigned_menu($user_id)
	{
		  $this->db->select('*');
		  $this->db->from('tblassignrole');
		  
		  $this->db->where_in('emp_id',$user_id);
		  $result=$this->db->get()->result();
		  return $result;
	}
	function save_user_menu($data)
	{
		$this->db->insert('tblassignrole',$data);
		return $this->db->insert_id();
	}
	function remove_assign_menu($emp_id,$sub_menu_id)
	{
		$this->db->where_in('emp_id',$emp_id);
		$this->db->where(array('sub_menu'=>$sub_menu_id));
		$this->db->delete('tblassignrole');
		//echo $this->db->last_query();exit;
	}
	function save_reset_password($username,$data)
	{
		if( !empty($username) )
		{
		$this->db->where('username',$username);
		$this->db->update('users',$data);
		return true;			
		}
	}
	
	function save_update_request($data,$userid='')
	{
		//p($data); 
		if(empty($userid)){
			$this->db->insert('tbl_user_pending_updates',$data);
			return $this->db->insert_id();
		}else{
			$this->db->where('user_id',$userid);
			$this->db->update('tbl_user_pending_updates',$data);
			return true;
		}
	}
	function get_update_request($where=array())
	{
		$this->db->select('*,TIMESTAMPDIFF(MINUTE, created_on, now()) as difference',true);
        $this->db->from('tbl_user_pending_updates');
		if(count($where)>0)
			$this->db->where($where);
	    $result	= $this->db->get()->result();
		return $result;
	}
	function get_request_row($reqId)
	{
		  $this->db->select('*');
		  $this->db->from('tbl_user_pending_updates');
		  $this->db->where(array('id'=>$reqId));
		  $result=$this->db->get()->row();
		  return $result;
	}
	function update_user_request_common($commonData)
	{
		//print_r($commonData); exit;
		$user_id = $commonData['id'];
		$this->db->where('id',$user_id);
		$this->db->update('users',$commonData);
		return true;			
		
	}
	function update_user_request_detail($detailData)
	{
        $this->db->select('id');
        $this->db->from('user_map_student_details');
        $this->db->where(array('user_id'=>$detailData['user_id']));
        $result=$this->db->get()->row();
        if(count($result)>0) {
            $id = $detailData['user_id'];
            $this->db->where('user_id', $id);
            $this->db->update('user_map_student_details', $detailData);
        }else{
            $this->db->insert('user_map_student_details',$detailData);
            $insert_id = $this->db->insert_id();
        }
		return true;			
		
	}
	function update_user_request_delete($id)
	{
		$this->db->where(array('id'=>$id));
		$this->db->delete('tbl_user_pending_updates');
		
	}
	function view_update_request($row_id)
	{
		$this->db->select('up.*,c.campus_code,c.campus_name,d.degree_name,b.batch_name');
		$this->db->from('tbl_user_pending_updates as up');
		$this->db->join('campuses as c','c.id=up.campus','INNER');
		$this->db->join('degrees as d','d.id=up.degree','INNER');
		$this->db->join('batches as b','b.id=up.batch','INNER');
		
		$this->db->where('up.id',$row_id);
		$result = $this->db->get()->result();
		return $result;
	}
	
	function get_campus_info($campusname)
	{
		$this->db->select('campuses.id');
        $this->db->from('campuses');
		$this->db->where('campus_name',$campusname);
	    $result	= $this->db->get()->row();
		return $result;
	}
	function insert_degree($data=array()){
		if(count($data)>0){
			$this->db->insert('degrees',$data);
			return $this->db->insert_id();
		}
	}
	function get_degree_info($degreename)
	{
		$this->db->select('degrees.id');
        $this->db->from('degrees');
		$this->db->where('degree_name',$degreename);
	    $result	= $this->db->get()->row();
		return $result;
	}
	
	function get_batch_info($batchname)
	{
		$this->db->select('batches.id');
        $this->db->from('batches');
		$this->db->where('batch_name',$batchname);
	    $result	= $this->db->get()->row();
		return $result;
	}
	
	function get_country_info($countryname)
	{
		$this->db->select('country.id');
        $this->db->from('country');
		$this->db->where('country_name',$countryname);
	    $result	= $this->db->get()->row();
		return $result;
	}
	
	function get_state_info($statename)
	{
		$this->db->select('state.id');
        $this->db->from('state');
		$this->db->where('state',$statename);
	    $result	= $this->db->get()->row();
		return $result;
	}
	
	function get_city_info($cityname)
	{
		$this->db->select('city.city_id');
        $this->db->from('city');
		$this->db->where('city',$cityname);
	    $result	= $this->db->get()->row();
		return $result;
	}
	
	function get_community_info($name)
	{
		$this->db->select('community.id');
        $this->db->from('community');
		$this->db->where('name',$name);
	    $result	= $this->db->get()->row();
		return $result;
	}
	
	function get_caste_info($name)
	{
		$this->db->select('caste.id');
        $this->db->from('caste');
		$this->db->where('name',$name);
	    $result	= $this->db->get()->row();
		return $result;
	}
	function get_semester_info($semestername)
	{
		$this->db->select('semesters.id');
        $this->db->from('semesters');
		$this->db->where('semester_name',$semestername);
	    $result	= $this->db->get()->row();
		return $result;
	}
	function insert_discipline($disciplinename)
	{
		$this->db->insert('disciplines',array('discipline_code'=>$disciplinename,'discipline_name'=>$disciplinename));
       
	}
	function get_discipline_info($disciplinename)
	{
		$this->db->select('disciplines.id');
        $this->db->from('disciplines');
		$this->db->where('discipline_name',$disciplinename);
	    $result	= $this->db->get()->row();
		return $result;
	}
	function get_group_info($group_name)
	{
		$this->db->select('course_groups.id');
        $this->db->from('course_groups');
		$this->db->where('course_group_name',$group_name);
	    $result	= $this->db->get()->row();
		//print_r($result);
		if(count($result)==0){
			$date = date('Y-m-d h:m:s');
			$this->db->insert('course_groups',array('course_group_code'=>$group_name,'course_group_name'=>$group_name,'status'=>1,'created_on'=>"$date"));
			return $this->db->insert_id();
		}else
			return $result->id;
	}
	function get_course_info($coursecode,$coursename)
	{
		$this->db->select('courses.id');
        $this->db->from('courses');
		$this->db->where(array('course_code'=>$coursecode,'course_title'=>$coursename));
	    $result	= $this->db->get()->row();
		return $result;
	}
	
	function get_student_info($firstname,$lastname)
	{
		//print_r($studentname); exit;
		$this->db->select('users.id');
        $this->db->from('users');
		$this->db->where(array('first_name'=>$firstname,'last_name'=>$lastname));
	    $result	= $this->db->get()->row();
		return $result;
	}
	
	function get_studentexcel_data1($data1)
	{
		$this->db->insert('users',$data1);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function get_studentexcel_data2($data2)
	{
		$this->db->insert('user_map_student_details',$data2);
		$insert_id = $this->db->insert_id();
		
	}
	
	function get_program_info($programname)
	{
		$this->db->select('programs.id');
        $this->db->from('programs');
		$this->db->where('program_name',$programname);
		$this->db->or_where('program_code',$programname);
	    $result	= $this->db->get()->row();
		return $result;
	}
	function save_ug_excel_marks($data)
	{
		$this->db->insert('students_ug_marks',$data);
		$insert_id = $this->db->insert_id();
	}
	function get_students()
	{
		$this->db->select('u.id ,u.first_name,u.last_name');
		$this->db->from('users as u');
		$this->db->where('u.role_id',1);
		$result = $this->db->get()->result();
		return $result;
	}
	function save_parent_login($data)
	{
		$this->db->select('u.id');
		$this->db->from('users as u');
		$this->db->where('u.username',$data['username']);
		$result = $this->db->get()->result();
		if(count($result)>0)
		{
			$id = $result[0]->id;
			$this->db->where('id',$id);
			$this->db->update('users',$data);
			return $id;			
		}else{
			$this->db->insert('users',$data);
			return $this->db->insert_id();
		}
		$this->db->insert('users',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function update_parent_login($data,$parent_id)
	{
		$this->db->where(array('id'=>$parent_id));
		$this->db->update('user_map_student_details',$data);
		return true;
	}
	function get_user_row_by_id($student_id)
	{
		$this->db->select('u.first_name,u.last_name,u.user_unique_id,c.campus_name,d.degree_name,b.batch_name');
		$this->db->from('users as u');
		$this->db->join('user_map_student_details as umd','umd.user_id = u.id','INNER');
		$this->db->join('campuses as c','c.id = umd.campus_id','INNER');
		$this->db->join('degrees as d','d.id = umd.degree_id','INNER');
		$this->db->join('batches as b','b.id = umd.batch_id','INNER');
		$result=$this->db->get()->row();
		return $result;
		
	}
	function update_teacher_profile($data)
	{   
	    $id = $data['id'];
		$this->db->where('id',$id);
		$this->db->update('users',$data);
		return true;
	}
	function update_details_teacher_profile($data)
	{
		$id = $data['id'];
		$this->db->where('id',$id);
		$this->db->update('user_map_teacher_details',$data);
		return true;
		
	}
	function get_matched_mobile_number($mobile_number)
	{
		$this->db->select('u.id,u.contact_number');
		$this->db->from('users as u');
		$this->db->where(array('contact_number'=>$mobile_number));
		$result = $this->db->get()->row();
		return $result;
	}
	function update_user_phone($id,$mobile)
	{
		
		if( !empty($id) ){
		$query = $this->db->query("update users set users.`contact_number`=$mobile where users.id=$id;");
		return 1;			
		}	
	}
	function update_user_email($email,$id)
	{// p($id); exit;
		if( !empty($id) ){
		$query = $this->db->query("update users set users.`email`=$email where users.id=$id;");
		return 1;			
		}
	}
	
	function isimage($useruniqueid)
	{
		$this->db->select('u.id');
		$this->db->from('users as u');
		$this->db->where(array('user_unique_id'=>$useruniqueid));
		$result = $this->db->get()->row();
		return $result;
	}
	function addimagepath($id,$imagepath)
	{
		if($imagepath != '')
		{
			$query = $this->db->query("update users set user_image= '".$imagepath."' where id=$id;");
		}
	}
	
	
	
} //end class