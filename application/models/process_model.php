<?php
Class Process_model extends CI_Model
{	
    function save_process($data)
	{ 
	        //p($data);exit;
		    $this->db->insert('feedbacks',$data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
	}
	function get_student_assign_course($campus_id,$program_id,$degree_id,$semester_id,$batch_id)
	{
		$this->db->select('c.id,c.course_code,course_title,c.course_group_id');
		$this->db->from('courses c');
        $this->db->join('tbl_course_assignment  ca','c.id = ca.course_id','INNER');
		$this->db->where(array('ca.batch_id'=>$batch_id,'c.program_id'=>$program_id,'c.semester_id'=>$semester_id,'c.degree_id'=>$degree_id));
		$result	= $this->db->get()->result();
		return $result;
		
		
	}
	function get_student_attendance_by_course_id($student_id,$campus_id,$program_id,$degree_id,$semester_id,$batch_id,$course_id)
	{
		$this->db->select('a.*');
		$this->db->from('attendance a');
        $this->db->where(array('a.student_id'=>$student_id,'a.campus_id'=>$campus_id,'a.program_id'=>$program_id,'a.degree_id'=>$degree_id,'a.semester_id'=>$semester_id,'a.batch_id'=>$batch_id,'a.course_id'=>$course_id));
		$result	= $this->db->get()->result();
		return $result;
	}
	function get_student_marks($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$user_id)
	{
		$this->db->select('ug.*,c.course_code,c.course_title,u.user_unique_id');
		$this->db->from('students_ug_marks as ug');
		$this->db->join('users as u','u.id=ug.student_id','INNER');
		$this->db->join('courses as c','c.id=ug.course_id','INNER');
		$this->db->where(array('ug.campus_id'=>$campus_id,'ug.program_id'=>$program_id,'ug.degree_id'=>$degree_id,'ug.semester_id'=>$semester_id,'ug.batch_id'=>$batch_id,'ug.student_id'=>$user_id,'ug.publish_status'=>1));
		$result=$this->db->get()->result();
		return $result;
	}
	function get_student_marksheet($student_id)
	{
		$this->db->select('r.*');
		$this->db->from('results as r');
		$this->db->join('users as u','u.id=ug.student_id','INNER');
		$this->db->where(array('ug.campus_id'=>$campus_id,'ug.program_id'=>$program_id,'ug.degree_id'=>$degree_id,'ug.semester_id'=>$semester_id,'ug.batch_id'=>$batch_id,'ug.student_id'=>$user_id,));
		$result=$this->db->get()->result();
		return $result;
	}
	function get_student_course_marks($student_id,$semester_id)
	{
		$this->db->select('r.*,c.course_code,c.course_title');
		$this->db->from('results as r');
		$this->db->join('courses as c','c.id=r.course_id','INNER');
		$this->db->where(array('r.student_id'=>$student_id,'r.semester_id'=>$semester_id));
		$result=$this->db->get()->result();
		return $result;
	}
	
      function get_assigned_menu($empid)
	{
		$this->db->select('*');
        $this->db->from('tblassignrole');
        $this->db->where(array('emp_id' => $empid));
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_admin_menu()
	{
		$this->db->select('*');
        $this->db->from('tbladminmenu');
        $this->db->where(array('parentid' =>0,'r_status'=>'Active'));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_admin_submenu_of_mainmenu($id)
	{
		
		
		$this->db->select('*');
        $this->db->from('tbladminmenu');
        $this->db->where(array('parentid' =>$id,'r_status'=>'Active'));
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
	function degree_list()
	{
		$this->db->select('degrees.id,degrees.degree_code,degrees.degree_name,degrees.status,degrees.created_on,disciplines.discipline_name,programs.program_name');
		$this->db->from('degrees');
        $this->db->join('disciplines','disciplines.id = degrees.discipline_id','INNER');
		 $this->db->join('programs','programs.id = degrees.program_id','INNER');
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
	function get_degree_by_program_id($id)
    {
		$this->db->select('*');
		$this->db->from('degrees');
		$this->db->where(array('program_id'=>$id));
		$result=$this->db->get()->result();
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
		//$this->db->group_by('programs.program_name');
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_semester_by_degree_id($id)
	{
		$this->db->select('s.*');
        $this->db->from('semesters as s');
        $this->db->join('tbl_course_assignment as ca','ca.semester_id = s.id','INNER');
        $this->db->where(array('ca.degree_id' => $id));
		$this->db->group_by('s.semester_name');
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_batch_by_degree_id($id)
    {
		$this->db->select('b.*');
        $this->db->from('batches as b');
        $this->db->join('tbl_course_assignment as ca','ca.batch_id = b.id','LEFT');
        $this->db->where(array('ca.degree_id' => $id));
		//$this->db->group_by('b.batch_name');
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
		$this->db->select('ca.id as caid,ca.program_id as program_id,ca.degree_id as degree_id,ca.semester_id as semester_id,ca.previous_semester_id as previous_semester_id,ca.semester_id as semester_id,ca.syllabus_year_id as syllabus_year_id,ca.batch_id as batch_id,ca.created_on as created_on,ca.updated_on as updated_on,ca.status as status,p.id,p.program_name,d.id,d.degree_name,s.id,s.semester_name,ss.id,ss.semester_name as previous_semester,sy.id,sy.syllabus_year,b.id,b.batch_name');
		$this->db->from('tbl_course_assignment as ca');
        $this->db->join('programs as p','p.id = ca.program_id','INNER');
        $this->db->join('degrees as d','d.id = ca.degree_id','INNER');
        $this->db->join('semesters as s','s.id = ca.semester_id','INNER');
        $this->db->join('semesters as ss','ss.id = ca.previous_semester_id','INNER');
        $this->db->join('syllabus_years as sy','sy.id = ca.syllabus_year_id','INNER');
        $this->db->join('batches as b','b.id = ca.batch_id','INNER');
		
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
		$this->db->where(array('ums.campus_id'=>$campus_id,'ums.batch_id'=>$batch_id,'ums.degree_id'=>$degree_id));
        $result	= $this->db->get()->result();
		return $result;
	}
	function save_student_course_list($data)
	{       
	      
				 $this->db->insert('student_assigned_courses',$data);
			     $insert_id = $this->db->insert_id();
		
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
	function get_course_by_discipline($discipline_id)
	{
		$this->db->select('c.*');
		$this->db->from('courses c');
        $this->db->where(array('c.discipline_id'=>$discipline_id));
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
		$course_id = $data['course_id'];
		
		$this->db->select('u.*,umap.*');
		$this->db->from('users u');
		$this->db->from('tbl_course_assignment sac');
		$this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
		
        $this->db->where(array('sac.course_id'=>$course_id));
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
	
	function check_already_inserted_courses_row($course_id,$program_id,$degree_id,$semester_id,$previous_semester_id,$syllabus_year,$batch_id)
	{
		$this->db->select('c.*');
		$this->db->from('tbl_course_assignment c');
		$this->db->where(array('c.course_id'=>$course_id,'c.program_id'=>$program_id,'c.degree_id'=>$degree_id,'c.semester_id'=>$semester_id,'c.previous_semester_id'=>$previous_semester_id,'c.syllabus_year_id'=>$syllabus_year,'c.batch_id'=>$batch_id));
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
	
	
	
} //end class