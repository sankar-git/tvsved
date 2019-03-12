<?php
Class Master_model extends CI_Model
{	
      function get_assigned_menu($empid)
	{
		$this->db->select('*');
        $this->db->from('tblassignrole');
        $this->db->where(array('emp_id' => $empid));
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_admin_menu($userType=1)
	{ 
		$this->db->select('*');
        $this->db->from('tbladminmenu');
        $this->db->where(array('parentid' =>0,'r_status'=>'Active'));
		$this->db->order_by('position','asc');
		if($userType == 0){
			 $this->db->where(array('is_admin' =>1));
		}
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_admin_submenu_of_mainmenu($id)
	{
		
		
		$this->db->select('*');
        $this->db->from('tbladminmenu');
        $this->db->where(array('parentid' =>$id,'r_status'=>'Active'));
		$this->db->order_by('position','asc');
        $result	= $this->db->get()->result();
		return $result;
	}

	function save_program($data)
	{
		    $this->db->insert('programs',$data);
			$insert_id = $this->db->insert_id();
	}
	function program_list()
	{
		return $this->db->order_by('program_name', 'ASC')->get('programs')->result();
	}
	
	function get_program_by_id($id)
	{
		$this->db->select('*');
        $this->db->from('programs');
        $this->db->where(array('id' => $id));
        $result	= $this->db->get()->row();
		return $result;
	}
	function update_program($id,$save)
	{  
        if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('programs',$save);
		return true;			
		}
	}
	function delete_program($id)
	{
		if( !empty($id) ){
			 $this->db->where('id', $id);
             $this->db->delete('programs');		
		}
	}function delete_class_room($id)
	{
		if( !empty($id) ){
			 $this->db->where('id', $id);
             $this->db->delete('class_room');		
		}
	}
	function delete_slot($id)
	{
		if( !empty($id) ){
			 $this->db->where('id', $id);
             $this->db->delete('exam_slot');		
		}
	}
	function status_program($id,$dstatus)
	{
		
		if($dstatus==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update programs set programs.`status`=$save where programs.id=$id;");
		return true;			
		}
	}
	function save_degree($data)
	{
		    $this->db->insert('degrees',$data);
			$insert_id = $this->db->insert_id();
	}
	function save_classroom($data,$id)
	{
		if($id>0){
			  $this->db->where('id',$id);
			  $this->db->update('class_room',$data);
		}else{
		    $this->db->insert('class_room',$data);
			$insert_id = $this->db->insert_id();
		}
	}
	function save_slot($data,$id)
	{
		if($id>0){
			  $this->db->where('id',$id);
			  $this->db->update('exam_slot',$data);
		}else{
		    $this->db->insert('exam_slot',$data);
			$insert_id = $this->db->insert_id();
		}
	}
	function degree_list()
	{
		$this->db->select('degrees.id,degrees.degree_code,degrees.degree_name,degrees.status,degrees.created_on,disciplines.discipline_name,programs.program_name');
		$this->db->from('degrees');
        $this->db->join('disciplines','disciplines.id = degrees.discipline_id','INNER');
		 $this->db->join('programs','programs.id = degrees.program_id','INNER');
        $result	= $this->db->get()->result();
		return $result;
	}
	function class_room_list($id='')
	{
		$this->db->select('cr.*,c.campus_name');
		$this->db->from('class_room cr');
        $this->db->join('campuses c','c.id=cr.campus_id','LEFT');
        
		if($id>0)
		 $this->db->where(array('cr.id' => $id));
		$result	= $this->db->get()->result();
		return $result;
	}
	function slot_list($id='')
	{
		$this->db->select('*');
		$this->db->from('exam_slot');        
		if($id>0)
		 $this->db->where(array('id' => $id));
		$result	= $this->db->get()->result();
		return $result;
	}
	function get_degree_by_id($id)
	{
		$this->db->select('d.id,d.degree_code,d.degree_name,d.status,d.created_on,disciplines.id as d_id, disciplines.discipline_name,programs.program_name,programs.id as p_id');
		$this->db->from('degrees as d');
        $this->db->join('disciplines','disciplines.id = d.discipline_id','INNER');
		$this->db->join('programs','programs.id = d.program_id','INNER');
        $this->db->where(array('d.id' => $id));
        $result	= $this->db->get()->row();
		return $result;
	}
	function status_degree($id,$dstatus)
	{
		if($dstatus==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update degrees set degrees.`status`=$save where degrees.id=$id;");
		return true;			
		}
	}
	function update_degree($id,$data)
	{
		if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('degrees',$data);
		return true;			
		}
	}
	function delete_degree($id)
	{
			if( !empty($id) ){
			 $this->db->where('id', $id);
             $this->db->delete('degrees');		
		}
	}
	function save_syllabus_year($data)
	{
		    $this->db->insert('syllabus_years',$data);
			$insert_id = $this->db->insert_id();
	}
	function syllabus_year_list()
	{
		$this->db->select('s.*,programs.id as p_id,programs.program_name');
		$this->db->from('syllabus_years as s');
        $this->db->join('programs','programs.id = s.program_id','INNER');
        
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_syllabus_year_by_id($id)
	{
		$this->db->select('s.*,programs.id as p_id,programs.program_name');
		$this->db->from('syllabus_years as s');
        $this->db->join('programs','programs.id = s.program_id','INNER');
        $this->db->where(array('s.id' => $id));
        $result	= $this->db->get()->row();
		return $result;
	}
	function update_syllabus_year($id,$data)
	{
		if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('syllabus_years',$data);
		return true;			
		}
	}
	function delete_syllabus_year($id)
	{
		if( !empty($id) ){
			 $this->db->where('id', $id);
             $this->db->delete('syllabus_years');		
		}
	}
	function status_syllabus_year($id,$status)
	{
		if($status==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update syllabus_years set syllabus_years.`status`=$save where syllabus_years.id=$id;");
		return true;			
		}
	}
	function save_semester($data)
	{
		    $this->db->insert('semesters',$data);
			$insert_id = $this->db->insert_id();
	}
	function semester_list()
	{
		$this->db->select('*');
		$this->db->from('semesters');
		$result = $this->db->get()->result();
		return $result;
		
	}
	function get_semester_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('semesters');
		$this->db->where('id',$id);
		$result = $this->db->get()->row();
		return $result;
		
	}
	function update_semester($id,$data)
	{
		if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('semesters',$data);
		return true;			
		}
	}
	function delete_semester($id)
	{
			if( !empty($id) ){
			 $this->db->where('id', $id);
             $this->db->delete('semesters');		
		}
	}
	function status_semester($id,$status)
	{
		if($status==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update semesters set semesters.`status`=$save where semesters.id=$id;");
		return true;			
		}
	}
	function course_group_list()
	{
		$this->db->select('*');
		$this->db->from('course_groups');
		$result=$this->db->get()->result();
		return $result;
		
	}
	function save_course_group($data)
	{
		    $this->db->insert('course_groups',$data);
			$insert_id = $this->db->insert_id();
	}
	function get_course_group_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('course_groups');
		$this->db->where(array('id'=>$id));
		$result=$this->db->get()->row();
		return $result;
		
	}
	function update_course_group($id,$data)
	{
		if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('course_groups',$data);
		return true;			
		}
	}
	function delete_course_group($id)
	{
		if( !empty($id) ){
			 $this->db->where('id', $id);
             $this->db->delete('course_groups');		
		}
	}
	function course_subject_group_list()
	{
		$this->db->select('*');
		$this->db->from('course_subject_groups');
		$result=$this->db->get()->result();
		return $result;
		
	}
	function save_course_subject_group($data)
	{
		    $this->db->insert('course_subject_groups',$data);
			$insert_id = $this->db->insert_id();
	}
	function get_course_subject_group_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('course_subject_groups');
		$this->db->where(array('id'=>$id));
		$result=$this->db->get()->row();
		return $result;
		
	}
	function update_course_subject_group($id,$data)
	{
		if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('course_subject_groups',$data);
		return true;			
		}
	}
	function status_course_subject_group($id,$status)
	{
		if($status==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update course_subject_groups set course_subject_groups.`status`=$save where course_subject_groups.id=$id;");
		return true;			
		}
	}
	function delete_course_subject_group($id)
	{
		if( !empty($id) ){
			 $this->db->where('id', $id);
             $this->db->delete('course_subject_groups');		
		}
	}
	function delete_campus_degree($id)
	{
		if( !empty($id) ){
			 $this->db->where('id', $id);
             $this->db->delete('campus_map_degree_and_programs');		
		}
	}
	function campus_degree_status($id,$status)
	{
		if($status==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update campus_map_degree_and_programs set campus_map_degree_and_programs.`status`=$save where campus_map_degree_and_programs.id=$id;");
		return true;			
		}
	}
	function status_course_group($id,$status)
	{
		if($status==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update course_groups set course_groups.`status`=$save where course_groups.id=$id;");
		return true;			
		}
	}
	function get_degree_by_program_id($id,$campus_id='')
    {
		if($id >1){
			$this->db->select('d.*');
			$this->db->from('degrees as d');
			$this->db->where(array('d.program_id'=>$id));
		}else{
			$this->db->select('d.*');
			$this->db->from('campus_map_degree_and_programs as cmd');
			$this->db->join('degrees d','d.id = cmd.degree_id','INNER');
			$this->db->where(array('cmd.program_id'=>$id));
			if($campus_id>0)
			$this->db->where(array('cmd.campus_id'=>$campus_id));
		}
		$this->db->order_by('degree_name');
		$result=$this->db->get()->result();//echo $this->db->last_query();exit;
		return $result;
	}
	function get_syllabus_year_by_program_id($id)
	{
		$this->db->select('*');
		$this->db->from('syllabus_years');
		$this->db->where(array('program_id'=>$id));
		$result=$this->db->get()->result();
		return $result;
	}
	function get_program_by_campus_id($id)
	{
		$this->db->select('programs.*');
        $this->db->from('campus_map_degree_and_programs as cmd');
        $this->db->join('programs','programs.id = cmd.program_id','INNER');
        $this->db->where(array('cmd.campus_id' => $id));
		$this->db->group_by('programs.program_name');
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_semester_by_degree_id($degree_id)
	{
		if($degree_id == 1){
			$this->db->select('s.id,s.semester_name');
			$this->db->from('semesters as s');
			$this->db->join('degree_map_semester m','s.id = m.semester_id','INNER');
			$this->db->where(array('m.degree_id' => $degree_id));
		}else{
			$this->db->select('s.id,s.semester_name');
			$this->db->from('semesters as s');
			$this->db->where_in('s.id' ,array(3,8,9,10));
		}
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_discipline_by_degree_id($degree_id)
	{
		$this->db->select('s.id,s.discipline_name');
        $this->db->from('disciplines as s');
        $this->db->join('degrees m','s.id = m.discipline_id','INNER');
        $this->db->where(array('m.id' => $degree_id));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_batch_by_degree_id($id)
    {
		$this->db->select('b.*');
        $this->db->from('batches as b');
        $this->db->join('tbl_course_assignment as ca','ca.batch_id = b.id','LEFT');
        //$this->db->where(array('ca.degree_id' => $id));
		$this->db->group_by('b.batch_name');
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_student_by_batch_id($id)
	{
	    
		$this->db->select('u.*');
        $this->db->from('users as u');
		$this->db->join('user_map_student_details as sm','sm.user_id = u.id','INNER');
        $this->db->where(array('sm.batch_id' => $id));
        $result	= $this->db->get()->result();
		return $result;
	}
	function delete_user($id,$role)
	{
		if($role=='1')
		{
			if( !empty($id) ){
				 $this->db->where('id', $id);
				 $this->db->delete('users');		
			}
			
			if( !empty($id) ){
				 $this->db->where('user_id', $id);
				 $this->db->delete('user_map_student_details');		
			}
		}
		if($role=='2')
		{
			if( !empty($id) ){
				 $this->db->where('id', $id);
				 $this->db->delete('users');		
			}
			
			if( !empty($id) ){
				 $this->db->where('user_id', $id);
				 $this->db->delete('user_map_student_details');		
			}
		}
		if($role=='3')
		{
			if( !empty($id) ){
				 $this->db->where('id', $id);
				 $this->db->delete('users');		
			}
			
			if( !empty($id) ){
				 $this->db->where('user_id', $id);
				 $this->db->delete('user_map_student_details');		
			}
		}
		
	}
	
	function save_campus($data)
	{
		 $this->db->insert('campuses',$data);
		 $insert_id = $this->db->insert_id();
	}
	function lis_campus()
	{
		$this->db->select('*');
		$this->db->from('campuses');
		$result=$this->db->get()->result();
		return $result;
	}
	function edit_campus_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('campuses');
		$this->db->where(array('id'=>$id));
		$result=$this->db->get()->row();
		return $result;
	}
	function update_campus($id,$data)
	{
		if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('campuses',$data);
		return true;			
		}
	}
	function delete_campus($id)
	{
		if( !empty($id) ){
				 $this->db->where('id', $id);
				 $this->db->delete('campuses');		
			}
	}
	function campus_status($id,$status)
	{
		if($status==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update campuses set campuses.`status`=$save where campuses.id=$id;");
		return true;			
		}
	}
	function save_assign_course($data)
	{
		    $this->db->insert('tbl_course_assignment',$data);
			$insert_id = $this->db->insert_id();
	}
	function list_assign_course()
	{
		$this->db->select('co.course_title,cam.campus_name,ca.id as caid,ca.program_id as program_id,ca.degree_id as degree_id,ca.semester_id as semester_id,ca.previous_semester_id as previous_semester_id,ca.semester_id as semester_id,ca.syllabus_year_id as syllabus_year_id,ca.batch_id as batch_id,ca.created_on as created_on,ca.updated_on as updated_on,ca.status as status,p.id,p.program_name,d.id,d.degree_name,s.id,s.semester_name,ss.id,ss.semester_name as previous_semester,sy.id,sy.syllabus_year,b.id,b.batch_name');
		$this->db->from('tbl_course_assignment as ca');
        $this->db->join('campuses as cam','cam.id = ca.campus_id','INNER');
        $this->db->join('programs as p','p.id = ca.program_id','INNER');
        $this->db->join('courses as co','co.id = ca.course_id','INNER');
        $this->db->join('degrees as d','d.id = ca.degree_id','INNER');
        $this->db->join('semesters as s','s.id = ca.semester_id','INNER');
        $this->db->join('semesters as ss','ss.id = ca.previous_semester_id','LEFT');
        $this->db->join('syllabus_years as sy','sy.id = ca.syllabus_year_id','INNER');
        $this->db->join('batches as b','b.id = ca.batch_id','INNER');
		$this->db->order_by('ca.campus_id,ca.program_id,ca.degree_id,ca.semester_id,ca.previous_semester_id,ca.syllabus_year_id,ca.batch_id,ca.course_id');
        $result	= $this->db->get()->result();
		//echo $this->db->last_query(); die;
		return $result;
	}
	function delete_assign_course($id)
	{
		    if( !empty($id) ){
				 $this->db->where('id', $id);
				 $this->db->delete('tbl_course_assignment');		
			}
	}
	function assign_course_status($id,$status)
	{
		if($status==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update  tbl_course_assignment set  tbl_course_assignment.`status`=$save where  tbl_course_assignment.id=$id;");
		return true;			
		}
	}
	function get_assign_course_by_id($id)
	{
		$this->db->select('ca.*');
		$this->db->from('tbl_course_assignment as ca');
		$this->db->where(array('id'=>$id));
        $result	= $this->db->get()->row();
		return $result;
	}
	function update_assign_course($id,$data)
	{
		if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('tbl_course_assignment',$data);
		return true;			
		}
	}
	function save_campus_degree_program($data)
	{
		 $this->db->insert('campus_map_degree_and_programs',$data);
		 $insert_id = $this->db->insert_id();
	}
	function list_campus_and_degree()
	{
		$this->db->select('ca.id as caid,ca.program_id as program_id,ca.status as status,p.program_name,d.degree_name,c.campus_name as campus_name');
		$this->db->from('campus_map_degree_and_programs as ca');
        $this->db->join('programs as p','p.id = ca.program_id','INNER');
        $this->db->join('degrees as d','d.id = ca.degree_id','INNER');
        $this->db->join('campuses as c','c.id = ca.campus_id','INNER');
        $result	= $this->db->get()->result();
		//echo $this->db->last_query(); die;
		return $result;
	}
	function campus_and_degree_edit_by_id($id)
	{
		$this->db->select('ca.id as caid,ca.program_id as program_id,ca.degree_id as degree_id,ca.status as status,p.program_name,d.degree_name,c.campus_name as campus_name');
		$this->db->from('campus_map_degree_and_programs as ca');
        $this->db->join('programs as p','p.id = ca.program_id','INNER');
        $this->db->join('degrees as d','d.id = ca.degree_id','INNER');
        $this->db->join('campuses as c','c.id = ca.campus_id','INNER');
		$this->db->where(array('ca.id'=>$id));
        $result	= $this->db->get()->row();
		//echo $this->db->last_query(); die;
		return $result;
	}
	function update_campus_degree_program($id,$data)
	{
		if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('campus_map_degree_and_programs',$data);
		return true;			
		}
	}
	function update_assign_date_course($id,$data)
	{
		if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('tbl_course_assignment',$data);
		return true;			
		}
	}
	function get_student_course_list($data)
	{
		//dd($data); 
		$pid = $data['program_id'];
		$did = $data['degree_id'];
		$sid = $data['semester_id'];
		
		$this->db->select('courses.id,courses.course_title,courses.course_code,courses.theory_credit,courses.practicle_credit,disciplines.discipline_name,	disciplines.discipline_code,courses.status');
		$this->db->from('courses');
        $this->db->join('disciplines','disciplines.id = courses.discipline_id','INNER');
		$this->db->where(array('courses.program_id'=>$pid,'courses.degree_id'=>$did,'courses.semester_id'=>$sid));
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_student_by_degree_campus_batch_semester($data)
	{
		$campus_id = $data['campus_id'];
		$program_id = $data['program_id'];
		$degree_id = $data['degree_id'];
		$batch_id = $data['batch_id'];
		$semester_id = $data['semester_id'];
		$this->db->select('*');
		$this->db->from('user_map_student_details ums');
        $this->db->join('users  u','u.id = ums.user_id','INNER');
		$this->db->where(array('ums.campus_id'=>$campus_id,'ums.batch_id'=>$batch_id,'ums.degree_id'=>$degree_id,'ums.semester_id'=>$semester_id));
        $result	= $this->db->get()->result();
		return $result;
	}
	function delete_student_assigned_course_list($id){
		 $this->db->where(array('id'=>$id));
				 $this->db->delete('student_assigned_courses');
	}
	function get_student_assigned_course_list($data=array()){
		
		$this->db->select('ca.id,courses.id,courses.course_title,courses.course_code,u.first_name,u.last_name,p.program_name,d.degree_name,c.campus_name,s.semester_name,b.batch_name');
		$this->db->from('student_assigned_courses ca');
		  $this->db->join('programs as p','p.id = ca.program_id','INNER');
        $this->db->join('degrees as d','d.id = ca.degree_id','INNER');
        $this->db->join('campuses as c','c.id = ca.campus_id','INNER');
        $this->db->join('semesters s','s.id = ca.semester_id','INNER');
        $this->db->join('batches b','b.id = ca.batch_id','INNER');
        $this->db->join('courses courses','courses.id = ca.course_id','INNER');
        $this->db->join('users u','u.id = ca.student_id','INNER');
		if(count($data)>0)
			$this->db->where(array('ca.campus_id'=>$data['campus_id'],'ca.batch_id'=>$data['batch_id'],'ca.program_id'=>$data['program_id'],'ca.degree_id'=>$data['degree_id'],'ca.semester_id'=>$data['semester_id']));
        $result	= $this->db->get()->result();
		return $result;
		
	}
	function save_student_course_list($data)
	{       
	    $this->db->select('id');
		$this->db->from('student_assigned_courses');
		$this->db->where(array('student_id'=>$data['student_id'],'semester_id'=>$data['semester_id'],'campus_id'=>$data['campus_id'],'degree_id'=>$data['degree_id'],'batch_id'=>$data['batch_id'],'course_id'=>$data['course_id']));
		$result	= $this->db->get()->result();
		//echo $this->db->last_query();exit;
		if(count($result)==0){
			 $this->db->insert('student_assigned_courses',$data);
			 $insert_id = $this->db->insert_id();
		}else{
			$this->db->where('id',$id);
			$this->db->update('student_assigned_courses',$data);
		}
			return true;
		
	}
	function delete_student_course_list($sid,$semester_id)
	{           
		         $this->db->where(array('student_id'=>$sid,'semester_id'=>$semester_id));
				 $this->db->delete('student_assigned_courses');
	}
	function get_assigned_course_id_by_student($sid)
	{
		$this->db->select('sac.*');
		$this->db->from('student_assigned_courses sac');
        $this->db->where(array('sac.student_id'=>$sid));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_student_registered_course_list($data)
	{
		$cid = $data['campus_id'];
		$pid = $data['program_id'];
		$did = $data['degree_id'];
		$bid = $data['batch_id'];
		$sid = $data['semester_id'];
		$stuid = $data['student_id'];
		
		$this->db->select('courses.id,courses.course_title,courses.course_code,courses.theory_credit,courses.practicle_credit,disciplines.discipline_name,	disciplines.discipline_code,courses.status');
		$this->db->from('courses');
        $this->db->join('disciplines','disciplines.id = courses.discipline_id','INNER');
        $this->db->join('student_assigned_courses sac','sac.course_id = courses.id','INNER');
		$this->db->where(array('sac.program_id'=>$pid,'sac.degree_id'=>$did,'sac.semester_id'=>$sid,'sac.batch_id'=>$bid,'sac.student_id'=>$stuid));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_student_assigned_course_ids($stu_id)
	{
		$this->db->select('sac.course_id');
		$this->db->from('student_assigned_courses as sac');
      
		$this->db->where(array('sac.student_id'=>$stu_id));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_course_by_discipline($discipline_id,$degree_id='',$semester_id='',$program_id='')
	{
		$this->db->select('c.*');
		$this->db->from('courses c');
		if($program_id>1){
			if( !empty($degree_id) )
				$this->db->where(array('c.degree_id'=>$degree_id));
			if( !empty($program_id) )
				$this->db->where(array('c.program_id'=>$program_id));
		}else{
			//$this->db->where(array('c.discipline_id'=>$discipline_id));
			
			if( !empty($degree_id) )
				$this->db->where(array('c.degree_id'=>$degree_id));
			//if( !empty($semester_id) )
				//$this->db->where(array('c.semester_id'=>$semester_id));
			if( !empty($program_id) )
				$this->db->where(array('c.program_id'=>$program_id));
			$this->db->_protect_identifiers = FALSE;
			$this->db->order_by("field(discipline_id, $discipline_id) desc");
			$this->db->_protect_identifiers = TRUE;
		}
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_student_list_by_course($data)
	{
		$cid = $data['campus_id'];
		$pid = $data['program_id'];
		$did = $data['degree_id'];
		$bid = $data['batch_id'];
		$sid = $data['semester_id'];
		$course_id = $data['course_id'];
		
		$this->db->select('u.*,umap.*');
		$this->db->from('users u');
		$this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
		$this->db->join('student_assigned_courses sac','sac.student_id = u.id','INNER');
        $this->db->where(array('sac.course_id'=>$course_id));
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_students_list_by_course($data)
	{
		$cid = $data['campus_id'];
		$pid = $data['program_id'];
		$did = $data['degree_id'];
		$bid = $data['batch_id'];
		$sid = $data['semester_id'];
		//$course_id = $data['course_id'];
		
		$this->db->select('u.*,umap.*');
		$this->db->from('users u');
		//$this->db->join('tbl_course_assignment sac','u.id=sac');
		$this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
		
        $this->db->where(array('umap.campus_id'=>$cid,'umap.degree_id'=>$did,'umap.batch_id'=>$bid));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_save_course_by_student($stu_id)
	{
		
		$this->db->select('c.*');
		$this->db->from('student_assigned_courses c');
        $this->db->where(array('c.course_id'=>$stu_id));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_assign_course_row($student_id)
	{
		$this->db->select('c.*');
		$this->db->from('student_assigned_courses c');
        $this->db->where(array('c.student_id'=>$student_id));
        $result	= $this->db->get()->result();
		
		return $result;
	}
	
	function get_course_list($program_id,$degree_id,$semester_id,$syllabus_year)
	{
		$this->db->select('c.id,c.course_code,c.course_title,p.program_name,d.degree_name,dis.discipline_name');
		$this->db->from('courses c');
		$this->db->join('programs p','c.program_id = p.id','INNER');
		$this->db->join('degrees d','c.degree_id = d.id','INNER');
		$this->db->join('disciplines  dis','c.discipline_id = dis.id','INNER');
        $this->db->where(array('c.program_id'=>$program_id,'c.degree_id'=>$degree_id,'c.semester_id'=>$semester_id,'c.syllabus_id'=>$syllabus_year));
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function check_already_inserted_courses_row($course_id,$program_id,$degree_id,$semester_id,$previous_semester_id,$syllabus_year,$batch_id,$campus_id)
	{
		$this->db->select('c.*');
		$this->db->from('tbl_course_assignment c');
		$this->db->where(array('c.campus_id'=>$campus_id,'c.course_id'=>$course_id,'c.program_id'=>$program_id,'c.degree_id'=>$degree_id,'c.semester_id'=>$semester_id,'c.previous_semester_id'=>$previous_semester_id,'c.syllabus_year_id'=>$syllabus_year,'c.batch_id'=>$batch_id));
        $result	= count($this->db->get()->row());
		return $result;
	}
	function save_batches($data)
	{
		$this->db->insert('batches',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function update_batch($id,$data)
	{
		if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('batches',$data);
		return true;			
		}
	}
	function batch_status($id,$status)
	{
		//p($status); exit;
		if($status==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update batches set batches.`status`=$save where batches.id=$id;");
		return true;			
		}
	}
	function student_semester_list($program_id,$degree_id,$student_id=''){
		$this->db->select('distinct s.semester_name,c.semester_id',false);
		$this->db->from('courses c');
		if($student_id>0){
			$this->db->join('student_assigned_courses a','a.course_id=c.id');
			$this->db->where('a.student_id',$student_id);
		}
		$this->db->join('semesters s','s.id=c.semester_id','LEFT');
		$this->db->where('c.degree_id',$degree_id);
		$this->db->where('c.program_id',$program_id);
		return $this->db->get()->result_array();
	}
	function getfeeamount($name,$type=''){
		if($type == 'Duplicate Certificate')
			$this->db->select('duplicate_amount as fee_amount');
		elseif($type == 'Exam Fees')
			$this->db->select('exam_fee as fee_amount');
		elseif($type == 'Re-Evaluation')
			$this->db->select('revaluation as fee_amount');
		else
			$this->db->select('fee_amount');
		$this->db->from('certificate_fee');
		$this->db->where('name',$name);
		return $this->db->get()->result_array();
	}
	
	function my_feedback($userid){
		$this->db->select('feedback_id');
		$this->db->from('feedbacks');
		$this->db->where('sender_id',$userid);
		$result	= $this->db->get()->result_array();
		return $result;
	}
	function student_feedback($degree_id,$batch_id,$my_feedbackArr){
		$this->db->select('f.id,f.question,f.status,f.created_on,d.degree_name,s.semester_name,b.batch_name');
		$this->db->from('manage_feedback f');
		$this->db->join('degrees d','f.degree_id=d.id');
		$this->db->join('semesters s','f.semester_id=s.id');
		$this->db->join('batches b','f.batch_id=b.id');
		if($degree_id>0 && $batch_id>0)
			$this->db->where(array('f.degree_id'=>$degree_id,'f.batch_id'=>$batch_id));
		$this->db->where_not_in('f.id',explode(",",$my_feedbackArr));
		$this->db->where('f.status','Y');
		
		$result	= $this->db->get()->result_array();
		return $result;
	}
	
	
} //end class