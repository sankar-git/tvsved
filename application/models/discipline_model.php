<?php
Class Discipline_model extends CI_Model
{	
	function save_discipline($data)
	{
		    $this->db->insert('disciplines',$data);
			$insert_id = $this->db->insert_id();
	}
	function discipline_list()
	{
		return $this->db->order_by('discipline_name', 'ASC')->get('disciplines')->result();
	}
	function get_discipline_by_id($id)
	{
		$this->db->select('*');
        $this->db->from('disciplines');
        $this->db->where(array('id' => $id));
        $result	= $this->db->get()->row();
		return $result;
	}
	function update_discipline($id,$save)
	{  
        if( !empty($id))
		{
			$this->db->where('id',$id);
			$this->db->update('disciplines',$save);
			return true;			
		}
	}
	function delete_discipline($id)
	{
		if( !empty($id) ){
			 $this->db->where('id', $id);
             $this->db->delete('disciplines');		
		}
	}
	function status_discipline($id,$dstatus)
	{
		
		if($dstatus==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update disciplines set disciplines.`status`=$save where disciplines.id=$id;");
		return true;			
		}
	}
	function get_discipline($id='')
	{
		$this->db->select('*');
        $this->db->from('disciplines');
		 $this->db->where('status', 1);
		 if(!empty($id))
			$this->db->where('id', $id);
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_batches()
	{
		$this->db->select('*');
        $this->db->from('batches');
		$this->db->where('status', 1);
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_section()
	{
		$this->db->select('*');
        $this->db->from('section');
		$this->db->where('status', 1);
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_program($id='')
	{
		$this->db->select('*');
        $this->db->from('programs');
		 $this->db->where('status', 1);
		  if(!empty($id))
			$this->db->where('id', $id);
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_batch()
	{
		$this->db->select('*');
        $this->db->from('batches');
		$this->db->where('status', 1);
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_campus($id='')
	{
		$this->db->select('*');
        $this->db->from('campuses');
		$this->db->where('status', 1);
		if(!empty($id))
			$this->db->where('id', $id);
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_course()
	{
		$this->db->select('*');
        $this->db->from('courses');
		$this->db->where('status', 1);
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_teacher($campus='')
	{
		$this->db->select('a.*');
        $this->db->from('users a');
		if(!empty($campus)){
			
			$this->db->join('user_map_teacher_details b','a.id=b.user_id');
			$this->db->where(array('b.campus' => $campus));
		}
		$this->db->where(array('a.role_id' => 2,'a.status' => 1));
        $result	= $this->db->get()->result();
		return $result;
	}
	function save_course($data)
	{
		    $this->db->insert('courses',$data);
			$insert_id = $this->db->insert_id();
	}
	
	function update_course($id,$save)
	{  
        if( !empty($id) )
		{
			$this->db->where('id',$id);
			$this->db->update('courses',$save);
			return true;			
		}
	}
	function course_list($program_id='',$degree_id='',$semester_id='')
	{
		$this->db->select('courses.id,courses.course_title,courses.course_code,courses.theory_credit,courses.practicle_credit,disciplines.discipline_name,	disciplines.discipline_code,courses.status,course_subject_name');
		$this->db->from('courses');
        $this->db->join('disciplines','disciplines.id = courses.discipline_id','INNER');
        $this->db->join('course_subject_groups','course_subject_groups.id = courses.course_subject_id','LEFT');
		if(!empty($program_id))
			$this->db->where('courses.program_id', $program_id);
		if(!empty($degree_id))
			$this->db->where('courses.degree_id', $degree_id);
		if(!empty($semester_id))
			$this->db->where('courses.semester_id', $semester_id);
        $result	= $this->db->get()->result();
		//echo $this->db->last_query();
		return $result;
	}
	function delete_course($id)
	{
		if(!empty($id) ){
			 $this->db->where('id', $id);
             $this->db->delete('courses');		
		}
	}
	function status_course($id,$status)
	{
	    if($status==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update courses set courses.`status`=$save where courses.id=$id;");
		return true;			
		}	
	}
	function get_course_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('courses');
		$this->db->where('id', $id);
        $result	= $this->db->get()->row();
		return $result;
	}
	function get_teacher_semester_by_degree($campus,$program_id,$degree_id,$teacher){
		$this->db->select('s.id,s.semester_name');
        $this->db->from('semesters as s');
		$this->db->join('attendance_course_assigned_teacher as c','s.id=c.semester_id');
       $this->db->where('c.campus_id', $campus);
		$this->db->where('c.program_id', $program_id);
		$this->db->where('c.degree_id', $degree_id);
		$this->db->where('c.teacher_id', $teacher);
		$this->db->group_by('s.semester_name');
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_teacher_course_by_ids($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$teacher_id){
		$this->db->select('c.id,c.course_code,course_title,c.course_group_id');
		$this->db->from('courses c');
        $this->db->join('attendance_course_assigned_teacher  ca','c.id = ca.course_id');
		$this->db->where(array('ca.campus_id'=>$campus_id,'ca.program_id'=>$program_id,'ca.semester_id'=>$semester_id,'ca.degree_id'=>$degree_id,'ca.batch_id'=>$batch_id,'ca.teacher_id'=>$teacher_id));
		$result	= $this->db->get()->result();
		return $result;
	}
	function get_teacher_program_by_campus($campus_id,$teacher)
	 {
		$this->db->select('p.id,p.program_name');
		$this->db->from('attendance_course_assigned_teacher c');
        $this->db->join('programs  p','p.id = c.program_id','INNER');
		$this->db->where(array('c.campus_id'=>$campus_id));
		$this->db->group_by('p.program_name');
		$this->db->where('c.teacher_id', $teacher);
        $result	= $this->db->get()->result();
		return $result;
	 }	 
	function get_teacher_batch_by_degree($campus,$program_id,$degree_id,$teacher){
		$this->db->select('s.id,s.batch_name');
        $this->db->from('batches as s');
		$this->db->join('attendance_course_assigned_teacher as c','s.id=c.batch_id');
       $this->db->where('c.campus_id', $campus);
		$this->db->where('c.program_id', $program_id);
		$this->db->where('c.degree_id', $degree_id);
		$this->db->where('c.teacher_id', $teacher);
		$this->db->group_by('s.batch_name');
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_teacher_degree($campus,$program_id,$teacher){
		$this->db->select('d.id,d.degree_name,d.degree_code');
		$this->db->from('degrees as d');
		$this->db->join('attendance_course_assigned_teacher as c','d.id=c.degree_id');
		$this->db->where('d.status', 1);
		$this->db->where('c.campus_id', $campus);
		$this->db->where('c.program_id', $program_id);
		$this->db->where('c.teacher_id', $teacher);
		$this->db->group_by('d.degree_name');
		$result	= $this->db->get()->result();
		return $result;
	}
	function get_degree($campus='')
	{
		if($campus>0){
			$this->db->select('d.id,d.degree_name,d.degree_code');
			$this->db->from('degrees as d');
			$this->db->join('campus_map_degree_and_programs as c','d.id=c.degree_id');
			$this->db->where('d.status', 1);
			$this->db->where('c.campus_id', $campus);
			$result	= $this->db->get()->result();
			return $result;
		}else{
			$this->db->select('d.id,d.degree_name,d.degree_code');
			$this->db->from('degrees as d');
			$this->db->where('status', 1);
			$result	= $this->db->get()->result();
			return $result;
		}
	}
	function get_course_group()
	{
		$this->db->select('cg.id,cg.course_group_code,cg.course_group_name');
        $this->db->from('course_groups as cg');
		$this->db->where('status', 1);
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_subject_group()
	{
		$this->db->select('id,course_subject_name');
        $this->db->from('course_subject_groups');
		//$this->db->where('status', 1);
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_syllabus_year()
	{
		$this->db->select('sy.id,sy.syllabus_year');
        $this->db->from('syllabus_years as sy');
		$this->db->where('status', 1);
		$this->db->group_by('syllabus_year');
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_semester()
	{
		$this->db->select('s.id,s.semester_name, s.semester_name as previous_semester_name');
        $this->db->from('semesters as s');
		$this->db->where('status', 1);
		 if(!empty($id))
			$this->db->where('id', $id);
        $result	= $this->db->get()->result();
		return $result;
	}
	function course_list_download()
	{
		$this->db->select('*');
		$this->db->from('courses');
        $this->db->join('disciplines as d','d.id = courses.discipline_id','left');
        $this->db->join('degrees as de','de.id = courses.degree_id','left');
        $this->db->join('course_groups','course_groups.id = courses.course_group_id','left');
        $this->db->join('syllabus_years','syllabus_years.id = courses.syllabus_id','left');
        $this->db->join('semesters','semesters.id = courses.semester_id','left');
        $this->db->join('programs','programs.id = courses.program_id','left');
        
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_students_excel($type)
	{
		$this->db->select('*');
		$this->db->from('users as u');
        $this->db->join('user_map_student_details as umap','umap.user_id = u.id','left');
		$this->db->where(array('u.role_id' => $type));
        if(isset($_POST['campus']) && $_POST['campus'] != '' && $_POST['campus'] != '0')
            $this->db->where('umap.campus_id', $_POST['campus']);
        if(isset($_POST['degree']) && $_POST['degree'] != '' && $_POST['degree'] != '0')
            $this->db->where('umap.degree_id', $_POST['degree']);
        if(isset($_POST['batch']) && $_POST['batch'] != '' && $_POST['batch'] != '0')
            $this->db->where('umap.batch_id', $_POST['batch']);
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_teacher_excel($type)
	{
		$this->db->select('*');
		$this->db->from('users as u');
        $this->db->join('user_map_teacher_details as umap','umap.user_id = u.id','left');
		$this->db->where(array('u.role_id' => $type));
        if(isset($_POST['campus']) && $_POST['campus'] != '' && $_POST['campus'] != '0')
            $this->db->where('umap.campus_id', $_POST['campus']);
        $result	= $this->db->get()->result();
		//echo $this->db->last_query(); die;
		return $result;
	}
	function get_users_excel($type)
	{
		$this->db->select('*');
		$this->db->from('users as u');
        $this->db->join('user_map_userdetail_details as umap','umap.user_id = u.id','left');
        $this->db->where_not_in('role_id', $type);

        if(isset($_POST['campus']) && $_POST['campus'] != '' && $_POST['campus'] != '0')
            $this->db->where('umap.campus_id', $_POST['campus']);
        $result	= $this->db->get()->result();
		//echo $this->db->last_query(); die;
		return $result;
	}
	
	function get_students()
	{   
		$this->db->select('u.id,u.first_name,u.last_name');
        $this->db->from('users as u');
		$this->db->where(array('u.role_id' => 1,'u.status' => 1));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_campus_by_id($campus_id)
	{
		$this->db->select('c.id,c.campus_name');
        $this->db->from('campuses as c');
		$this->db->where(array('c.id' => $campus_id));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_degree_by_id($degree_id)
	{
		$this->db->select('d.id,d.degree_name');
        $this->db->from('degrees as d');
		$this->db->where(array('d.id' => $degree_id));
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_program_by_id($program_id)
	{
		$this->db->select('p.id,p.program_name');
        $this->db->from('programs as p');
		$this->db->where(array('p.id' => $program_id));
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_students_by_cpd($campus_id,$program_id,$degree_id)
	{
		$this->db->select('u.id,u.first_name,u.last_name');
        $this->db->from('users as u');
        $this->db->join('student_assigned_courses as sac','sac.student_id = u.id');
		$this->db->where(array('sac.campus_id' => $campus_id,'sac.program_id' => $program_id,'sac.degree_id' => $degree_id));
		$this->db->group_by('u.id');
        $result	= $this->db->get()->result();
		return $result; 
	}
	
	function get_assign_course()
	{
		$this->db->select('c.id,c.course_title,c.course_code');
        $this->db->from('courses as c');
        $this->db->join('student_assigned_courses as sac','sac.course_id = c.id');
		$this->db->where(array('c.status' => 1));
		$this->db->group_by('c.id');
        $result	= $this->db->get()->result();
		return $result; 
	}
	function batch_list()
	{
		$this->db->select('b.id,b.batch_start_year,b.batch_name,b.status,sy.syllabus_year,sy.id as syllabus_year_id');
        $this->db->from('batches as b');
        $this->db->join('syllabus_years as sy','sy.id = b.syllabus_id','LEFT');
		$result	= $this->db->get()->result();
		return $result; 
	}
	function section_list()
	{
		$this->db->select('id,section_code,section_name,status');
        $this->db->from('section');
        //$this->db->where(array('status' => 1));
		$result	= $this->db->get()->result();
		return $result;
	}
	
	function get_batch_by_id($id)
	{
		$this->db->select('b.id,b.syllabus_id,b.batch_start_year,b.batch_name,b.status');
		$this->db->from('batches as b');
		$this->db->where('id',$id);
		$result=$this->db->get()->row();
		return $result;
		
	}
	function get_section_by_id($id)
	{
		$this->db->select('id,section_code,section_name,status');
		$this->db->from('section');
		$this->db->where('id',$id);
		$result=$this->db->get()->row();
		return $result;
	}
	
	
	
} //end class