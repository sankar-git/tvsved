<?php
Class Generate_model extends CI_Model
{	
	function get_program_by_campus($id)
	{
		$this->db->select('programs.*');
        $this->db->from('campus_map_degree_and_programs as cmd');
        $this->db->join('programs','programs.id = cmd.program_id','INNER');
        $this->db->where(array('cmd.campus_id' => $id));
        $this->db->group_by('cmd.program_id'); 
       
        $result	= $this->db->get()->result();
		return $result;
		
	}
	
	function get_degree_by_program_id($id,$campus_id)
    {
		$this->db->select('d.*');
		 $this->db->from('campus_map_degree_and_programs as cmd');
		$this->db->join('degrees d','d.id = cmd.degree_id','INNER');
		$this->db->where(array('cmd.program_id'=>$id,'cmd.campus_id'=>$campus_id));
		$result=$this->db->get()->result();//echo $this->db->last_query();exit;
		return $result;
	}
	
	function get_semester()
	{
		$this->db->select('*');
		$this->db->from('semesters');
		$this->db->where('status', 1);
		$result = $this->db->get()->result();
		return $result;
		
	}
	
	function get_batch_by_degree($degree_id)
	{
		$this->db->select('batches.id,batches.syllabus_id,batches.batch_start_year,
		                   batches.batch_name');
        $this->db->from('batches');
        $this->db->join('tbl_course_assignment as ca','batches.id = ca.batch_id','LEFT');
       // $this->db->where(array('ca.degree_id' => $degree_id));
        $this->db->group_by('batches.batch_name');
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_semester_by_degree($degree_id)
	{
		$this->db->select('s.id,s.semester_name');
        $this->db->from('semesters as s');
        $this->db->join('degree_map_semester m','s.id = m.semester_id','INNER');
        $this->db->where(array('m.degree_id' => $degree_id));
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_date_by_degree($degree_id)
	{
		//print_r($degree_id); exit;
		$this->db->select('ca.id,ca.date_of_closure,ca.start_date');
        $this->db->from('batches');
        $this->db->join('tbl_course_assignment as ca','batches.id = ca.batch_id','LEFT');
        $this->db->group_by('ca.date_of_closure,ca.start_date');
        
        $result	= $this->db->get()->result();
		return $result;
	}
	
    
	function get_student_list_for_registration($data)
	{
		$cid = $data['campus_id'];
		$pid = $data['program_id'];
		$did = $data['degree_id'];
		$bid = $data['batch_id'];
		$semester_id = $data['semester_id'];
		$this->db->select('u.*,umap.*,b.batch_name');
		$this->db->from('users u');
		$this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
		$this->db->join('student_assigned_courses sac','sac.student_id = u.id','INNER');
		$this->db->join('batches b','b.id = umap.batch_id','INNER');
	    $this->db->where(array('umap.campus_id'=>$cid,'umap.degree_id'=>$did,'umap.batch_id'=>$bid,'umap.semester_id'=>$semester_id,'u.role_id'=>1));
	    $this->db->group_by('sac.student_id');
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_studedent_data($student_id)
	{
		$this->db->select('u.*,umap.user_id,b.batch_name,b.batch_start_year,c.campus_name,c.campus_code,d.degree_name,d.degree_code,umap.parent_name,umap.mother_name');
		$this->db->from('users u');
		$this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
		$this->db->join('batches b','b.id = umap.batch_id','INNER');
		$this->db->join('campuses c','c.id = umap.campus_id','left');
		$this->db->join('degrees d','d.id = umap.degree_id','left');
	    $this->db->where_in('u.id',$student_id);
		//echo $this->db->last_query(); die;
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_student_dummy_number($student_id,$semester_id)
	{
		$this->db->select('u.*,s.semester_name,umap.user_id,b.batch_name,c.campus_name,c.campus_code,d.degree_name,d.degree_code,dd.dummy_value,dd.exam_month');
		$this->db->from('users u');
		$this->db->from('semesters s');
		$this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
		$this->db->join('batches b','b.id = umap.batch_id','INNER');
		$this->db->join('campuses c','c.id = umap.campus_id','left');
		$this->db->join('degrees d','d.id = umap.degree_id','left');
		$this->db->join('tbl_dummy dd','dd.student_id = u.id','inner');
		
	    $this->db->where_in('u.id',$student_id);
	    $this->db->where('s.id',$semester_id);
	    $this->db->group_by('u.id',$student_id);
		//echo $this->db->last_query(); die;
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_student_assigned_subjects($stuId,$semester_id)
	{
		$this->db->select('c.*');
		$this->db->from('courses c');
		$this->db->join('student_assigned_courses sac','sac.course_id = c.id','INNER');
		//$this->db->where('sac.student_id',$stuId);
		$this->db->where(array('sac.student_id'=>$stuId,'sac.semester_id'=>$semester_id));
		$this->db->order_by("sac.course_id", "asc");
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_batch_and_year_name($batch_id)
	{
		$this->db->select('c.date_of_closure');
		$this->db->from('tbl_course_assignment c');
	    $this->db->where('c.id',$batch_id);
        $result	= $this->db->get()->row();
		return $result;
	}
	function get_program_name_by_program_id($program_id)
	{
		$this->db->select('p.program_name');
		$this->db->from('programs p');
	    $this->db->where('p.id',$program_id);
        $result	= $this->db->get()->row();
		return $result;
	}
	function get_students_for_dummy($campus_id,$batch_id,$degree_id)
	{
		$this->db->select('u.*');
		$this->db->from('users u');
		$this->db->join('user_map_student_details ums','ums.user_id=u.id','INNER');
	    $this->db->where(array('ums.campus_id'=>$campus_id,'ums.batch_id'=>$batch_id,'ums.degree_id'=>$degree_id));
        $result	= $this->db->get()->result();
		return $result;
	}
	function save_dummy_number_for_students($data)
	{
		    //print_r($data); exit;
			$this->db->insert('tbl_dummy',$data);
			$insert_id = $this->db->insert_id();
	}
	function checking_dummy_number_already_exists($data)
	{
		
		$exam_month = $data['exam_month'];
		$college_id = $data['college_id'];
		$batch_id = $data['batch_id'];
		$degree_id = $data['degree_id'];
		
		$this->db->select('d.*');
		$this->db->from('tbl_dummy d');
		$this->db->where(array('d.college_id'=>$college_id,'d.batch_id'=>$batch_id,'d.degree_id'=>$degree_id,'d.exam_month'=>$exam_month));
        $result	= $this->db->get()->result();
		return $result;
	}
	function check_already_inserted_dummy_row($campus_id,$batch_id,$degree_id,$student_id,$month_name)
	{
		$this->db->select('d.*');
		$this->db->from('tbl_dummy d');
		$this->db->where(array('d.college_id'=>$campus_id,'d.batch_id'=>$batch_id,'d.degree_id'=>$degree_id,'d.student_id'=>$student_id,'d.exam_month'=>$month_name));
        $result	= count($this->db->get()->row());
		return $result;
	}
	
	function get_student_assign_course_list_old($data)
	{
		//print_r($data); exit;
		$campus_id = $data['campus_id'];
		$program_id = $data['program_id'];
		$degree_id = $data['degree_id'];
		$batch_id = $data['batch_id'];
		
		$this->db->select('c.*');
		$this->db->from('courses c');
		$this->db->join('student_assigned_courses sac','sac.course_id = c.id','INNER');
		$this->db->where(array('sac.campus_id'=>$campus_id,'sac.program_id'=>$program_id,'sac.batch_id'=>$batch_id,'sac.degree_id'=>$degree_id));
	    $this->db->group_by('sac.course_id');
		//echo $this->db->last_query(); die;
        $result	= $this->db->get()->result();
		return $result;
		
		
	}
	
	function get_student_assign_course_list($data)
	{
		//print_r($data); exit;
		$campus_id = $data['campus_id'];
		$program_id = $data['program_id'];
		$degree_id = $data['degree_id'];
		$batch_id = $data['batch_id'];
		
		$this->db->select('c.*,ce.exam_date');
		$this->db->from('courses c');
		$this->db->join('student_assigned_courses sac','sac.course_id = c.id','INNER');
		$this->db->join('course_exam_date ce','ce.course_id = c.id','LEFT');
		$this->db->where(array('sac.campus_id'=>$campus_id,'sac.program_id'=>$program_id,'sac.batch_id'=>$batch_id,'sac.degree_id'=>$degree_id));
	    $this->db->group_by('sac.course_id');
		//echo $this->db->last_query(); die;
        $result	= $this->db->get()->result();
		return $result;
		
		
	}
	function get_assign_course_list($data)
	{
		//print_r($data); exit;
		$campus_id = $data['campus_id'];
		$program_id = $data['program_id'];
		$degree_id = $data['degree_id'];
		$batch_id = $data['batch_id'];
		$semester_id = $data['semester_id'];
		
		$this->db->select('c.*,ce.exam_date');
		$this->db->from('courses c');
		$this->db->join('tbl_course_assignment sac','sac.course_id = c.id','INNER');
		$this->db->join('course_exam_date ce','ce.course_id = c.id','LEFT');
		$this->db->where(array('sac.campus_id'=>$campus_id,'sac.program_id'=>$program_id,'sac.batch_id'=>$batch_id,'sac.degree_id'=>$degree_id,'sac.semester_id'=>$semester_id));
	    $this->db->group_by('sac.course_id');
		//echo $this->db->last_query();
        $result	= $this->db->get()->result();
		return $result;
		
		
	}
	
	function save_course_exam_date($datas)
	{
		//print_r($datas); exit;
			$this->db->insert('course_exam_date',$datas);
			$insert_id = $this->db->insert_id();
			if($insert_id)
			{
				return true;
			}
			else
			{
				return false;
			}
	}
	function delete_old_exam_date($campus_id,$program_id,$degree_id,$batch_id
	)
	{
		if( !empty($campus_id) ){
			 $this->db->where(array('campus_id'=>$campus_id,'program_id'=>$program_id,'degree_id'=>$degree_id,'batch_id'=>$batch_id));
             $this->db->delete('course_exam_date');	
	 
		}
	}
	
	function get_student_assigned_subjects_with_date($stuId,$semester_id='')
	{
		$this->db->select('c.*,ce.exam_date');
		$this->db->from('courses c');
		$this->db->join('student_assigned_courses sac','sac.course_id = c.id','INNER');
		$this->db->join('course_exam_date ce','ce.course_id = sac.course_id','LEFT');
		$this->db->where('sac.student_id',$stuId);
		if($semester_id>0)
			$this->db->where(array('sac.semester_id'=>$semester_id));
		$this->db->order_by("sac.course_id", "asc");
        $result	= $this->db->get()->result();
		return $result;
	}
	
	
} //end class