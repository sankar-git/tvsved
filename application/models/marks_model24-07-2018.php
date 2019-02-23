<?php
Class Marks_model extends CI_Model
{	
     function get_program_by_campus($campus_id)
	 {
		$this->db->select('p.id,p.program_name');
		$this->db->from('campus_map_degree_and_programs cdp');
        $this->db->join('programs  p','p.id = cdp.program_id','INNER');
		$this->db->where(array('cdp.campus_id'=>$campus_id));
		
	    $this->db->group_by('cdp.program_id');
        $result	= $this->db->get()->result();
		return $result;
	 }	 
	 
	 function get_course_by_ids($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id)
	 {
		$this->db->select('c.id,c.course_code,course_title');
		$this->db->from('courses c');
        $this->db->join('tbl_course_assignment  ca','c.id = ca.course_id','INNER');
		$this->db->where(array('c.discipline_id'=>$discipline_id,'c.program_id'=>$program_id,'c.semester_id'=>$semester_id,'c.degree_id'=>$degree_id));
		$result	= $this->db->get()->result();
		return $result;
	 }
	 
	 function get_student_assigned_marks($data)
	 {
		 $campus_id=$data['campus_id'];
		 $program_id=$data['program_id'];
		 $degree_id=$data['degree_id'];
		 $batch_id=$data['batch_id'];
		 $semester_id=$data['semester_id'];
		 $discipline_id=$data['discipline_id'];
		 $course_id=$data['course_id'];
		 
		$this->db->select('u.*,ug.theory_internal,ug.practical_internal,ug.theory_external,ug.practical_external,ug.course_id');
		$this->db->from('student_assigned_courses c');
        $this->db->join('users  u','u.id = c.student_id','INNER');
        $this->db->join('students_ug_marks  ug','c.student_id = ug.student_id','INNER');
		$this->db->where(array('c.campus_id'=>$campus_id,'c.program_id'=>$program_id,'c.semester_id'=>$semester_id,'c.degree_id'=>$degree_id,'c.batch_id'=>$batch_id,'ug.course_id'=>$course_id));
		$this->db->group_by('c.student_id');
		$result	= $this->db->get()->result();
		if($result)
		{
			return $result; 
		}
		
		
	 }
	 
	 function get_student_assigned_marks_course_where_not_inserted($data)
	 {
		 //alert($data); exit;
		$campus_id=$data['campus_id'];
		 $program_id=$data['program_id'];
		 $degree_id=$data['degree_id'];
		 $batch_id=$data['batch_id'];
		 $semester_id=$data['semester_id'];
		 $discipline_id=$data['discipline_id'];
		 $course_id=$data['course_id'];
		 
		$this->db->select('u.*,ug.theory_internal,ug.practical_internal,ug.theory_external,ug.practical_external,ug.course_id');
		$this->db->from('student_assigned_courses c');
        $this->db->join('users  u','u.id = c.student_id','INNER');
        $this->db->join('students_ug_marks  ug','c.student_id = ug.student_id','LEFT');
		
		$this->db->where(array('c.campus_id'=>$campus_id,'c.program_id'=>$program_id,'c.semester_id'=>$semester_id,'c.degree_id'=>$degree_id,'c.batch_id'=>$batch_id,'c.course_id'=>$course_id));
		$this->db->group_by('c.student_id');
		$result	= $this->db->get()->result();
		if($result)
		{
			return $result; 
		}
		 
	 }
	 
	 function save_ug_marks($data)
	 {
		 //print_r($data); exit;
		    $this->db->insert('students_ug_marks',$data);
			$insert_id = $this->db->insert_id(); 
			return $insert_id;
	 }
	 function update_ug_marks($data)
	 {
		// print_r($data); exit;
		 $theory_internal = $data['theory_internal'];
		 $practical_internal = $data['practical_internal'];
		// print_r($theory_internal); exit;
		 if( !empty($theory_internal) )
		{
			$this->db->where(array('theory_internal'=>$theory_internal,'practical_internal'=>$practical_internal));
			$this->db->update('students_ug_marks',$data);
			return true;			
		} 
		
	 }
	 function delete_ug_marks($student_id,$course_id)
	 {
		 $this->db->where(array('student_id'=>$student_id,'course_id'=>$course_id));
		 $this->db->delete('students_ug_marks');
	 }
	 
	 function get_ug_students_by_ids($campus_id,$program_id,$degree_id,$batch_id)
	 {
		$this->db->select('u.*');
		$this->db->from('users u');
        $this->db->join('user_map_student_details  umap','u.id = umap.user_id','INNER');
        $this->db->where(array('umap.campus_id'=>$campus_id,'umap.degree_id'=>$degree_id,'umap.batch_id'=>$batch_id));
		$result	= $this->db->get()->result();
		return $result; 
	 }
	 
	 function get_student_assigned_courses($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$student_id)
	 {
		$this->db->select('c.id,c.course_code,c.course_title,c.theory_credit,c.practicle_credit,spm.internal_theory,spm.term_paper,spm.internal_practical,spm.external_theory');
		$this->db->from('courses c');
        $this->db->join('student_assigned_courses  sac','sac.course_id = c.id','INNER');
        $this->db->join('students_pg_marks  spm','spm.course_id = c.id','LEFT');
        $this->db->where(array('sac.campus_id'=>$campus_id,'sac.degree_id'=>$degree_id,'sac.batch_id'=>$batch_id,'sac.semester_id'=>$semester_id,'sac.student_id'=>$student_id,));
		$result	= $this->db->get()->result();
		return $result; 
	 }
	 function save_pg_marks($data)
	 {
		    $this->db->insert('students_pg_marks',$data);
			$insert_id = $this->db->insert_id(); 
			return $insert_id;
	 }
	 
	  function update_pg_marks($data)
	  {
		// print_r($data); exit;
		 $internal_theory = $data['internal_theory'];
		 $term_paper = $data['term_paper'];
		 $internal_practical = $data['internal_practical'];
		// print_r($theory_internal); exit;
		 if( !empty($internal_theory) )
		{
			$this->db->where(array('internal_theory'=>$internal_theory,'term_paper'=>$term_paper,'internal_practical'=>$internal_practical));
			$this->db->update('students_pg_marks',$data);
			return true;			
		} 
		
	 }
	 
	 function get_student_alerady_uploaded_marks($student_id,$semester_id,$batch_id,$program_id)
	 {
		 $this->db->select('spm.*');
		 $this->db->from('students_pg_marks spm');
         $this->db->where(array('spm.student_id'=>$student_id,'spm.semester_id'=>$semester_id,'spm.batch_id'=>$batch_id,'spm.program_id'=>$program_id));
		 $result	= $this->db->get()->result();
		 return $result; 
	 }
	 
	 function update_pg_internal_marks($data)
	 {
		 //print_r($data); exit;
		 $campus_id = $data['campus_id'];
		 $program_id = $data['program_id'];
		 $degree_id = $data['degree_id'];
		 $batch_id = $data['batch_id'];
		 $semester_id = $data['semester_id'];
		 $student_id = $data['student_id'];
		 $course_id = $data['course_id'];
		// print_r($theory_internal); exit;
		 if(!empty($course_id || $student_id) )
		{
			$this->db->where(array('campus_id'=>$campus_id,'program_id'=>$program_id,'degree_id'=>$degree_id,'batch_id'=>$batch_id,'semester_id'=>$semester_id,'student_id'=>$student_id,'course_id'=>$course_id));
			$this->db->update('students_pg_marks',$data);
			return true;			
		} 
		
		 
	 }
	
	
} //end class