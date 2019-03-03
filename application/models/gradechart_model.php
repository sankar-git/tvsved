<?php
Class Gradechart_model extends CI_Model
{	
	function get_registered_student($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id)
	{
		$this->db->select('u.user_unique_id,u.first_name,u.last_name,u.user_unique_id,b.batch_name,c.course_title,cp.campus_name,d.degree_name,s.semester_name');
		$this->db->from('students_ug_marks sum');
		$this->db->join('users u','u.id = sum.student_id','INNER');
		$this->db->join('batches b','b.id = sum.batch_id','INNER');
		$this->db->join('courses c','c.id = sum.course_id','INNER');
		$this->db->join('campuses cp','cp.id = sum.campus_id','INNER');
		$this->db->join('degrees d','d.id = sum.degree_id','INNER');
		$this->db->join('semesters s','s.id = sum.semester_id','INNER');
		
			$this->db->where(array('sum.campus_id'=>$campus_id,'sum.program_id'=>$program_id,'sum.degree_id'=>$degree_id,'sum.batch_id'=>$batch_id,'sum.semester_id'=>$semester_id,'sum.course_id'=>$course_id));
		
	    // $this->db->group_by('u.id',$student_id);
		//echo $this->db->last_query(); die;
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_aggregate_marks($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id)
	{
		$this->db->select('c.course_code,c.theory_credit,c.practicle_credit,u.user_unique_id,u.first_name,u.last_name,u.user_unique_id,b.batch_name,
		c.course_title,cp.campus_name,d.degree_name,s.semester_name,sum.course_id,sum.theory_internal,sum.practical_internal,
		sum.theory_external,sum.practical_external');
		$this->db->from('students_ug_marks sum');
		$this->db->join('users u','u.id = sum.student_id','INNER');
		$this->db->join('batches b','b.id = sum.batch_id','INNER');
		$this->db->join('courses c','c.id = sum.course_id','INNER');
		$this->db->join('campuses cp','cp.id = sum.campus_id','INNER');
		$this->db->join('degrees d','d.id = sum.degree_id','INNER');
		$this->db->join('semesters s','s.id = sum.semester_id','INNER');
		$this->db->where(array('sum.campus_id'=>$campus_id,'sum.program_id'=>$program_id,'sum.degree_id'=>$degree_id,'sum.batch_id'=>$batch_id,'sum.semester_id'=>$semester_id,'sum.course_id'=>$course_id));
	   // $this->db->group_by('u.id',$student_id);
		//echo $this->db->last_query(); die;
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_attandence_sheet($campus_id,$degree_id,$batch_id,$course_id,$semester_id)
	{
	    	$this->db->select('u.first_name,u.last_name,u.user_unique_id,cp.campus_code,b.batch_name,c.course_title,c.course_code,du.dummy_value,d.degree_name,d.degree_code,sem.semester_name,csg.course_subject_name,csg.course_subject_title,c.theory_credit,c.practicle_credit');
	    	$this->db->from('users u');
	    	//$this->db->from('courses c');
	    	$this->db->join('user_map_student_details ud','ud.user_id = u.id','LEFT');
	    	$this->db->join('batches b','b.id = ud.batch_id','LEFT');
		    $this->db->join('campuses cp','cp.id = ud.campus_id','LEFT');
			$this->db->join('student_assigned_courses sa','sa.student_id = u.id','LEFT');
		    $this->db->join('courses c','c.id = sa.course_id','LEFT');
		    $this->db->join('semesters sem','sem.id = sa.semester_id','LEFT');
		    $this->db->join('degrees d','d.id = ud.degree_id','INNER');
		    $this->db->join('tbl_dummy du','du.student_id = u.id','LEFT');
		    $this->db->join('course_subject_groups csg','csg.id = c.course_subject_id','LEFT');
		    
		    
		    $this->db->where(array('sa.campus_id'=>$campus_id,'sa.degree_id'=>$degree_id,'sa.batch_id'=>$batch_id,'c.id'=>$course_id,'sa.semester_id'=>$semester_id));$this->db->group_by('u.id');
		    $result	= $this->db->get()->result();
			//echo $this->db->last_query();exit;
	    	return $result;
	    	
	}
	function get_subject_wise_pass_fail_deflicit_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id='')
	{
		
		$this->db->select('c.id as course_id,r.theory_internal1,r.theory_internal2,r.theory_internal3,r.theory_internal,r.theory_paper1,
		                   r.theory_paper2,r.theory_paper3,r.theory_paper4,r.sum_internal_practical,r.practical_internal,r.theory_external1,r.theory_external2,r.theory_external3,r.theory_external4,r.practical_external,
						   r.marks_sum,r.external_sum,
						  c.course_title,c.course_code,c.theory_credit,c.practicle_credit,cp.campus_code,cp.campus_name,
						   b.batch_name,s.semester_name,d.degree_name,u.first_name,u.last_name,u.user_unique_id,csg.course_subject_name,csg.course_subject_title,csg.id as coure_group_id,dis.discipline_name,dis.discipline_code,u.id as student_id');
		$this->db->from('students_ug_marks as r');
		$this->db->join('courses as c','c.id=r.course_id');
		$this->db->join('disciplines as dis','dis.id=c.discipline_id');
		$this->db->join('users u','u.id=r.student_id');
		$this->db->join('campuses cp','cp.id=r.campus_id');
		$this->db->join('batches b','b.id=r.batch_id');
		$this->db->join('semesters s','s.id=r.semester_id');
		$this->db->join('course_subject_groups csg','csg.id=c.course_subject_id','LEFT');
		$this->db->join('degrees d','d.id=r.degree_id');
		$this->db->where(array('r.campus_id'=>$campus_id,'r.program_id'=>$program_id,'r.degree_id'=>$degree_id,'r.batch_id'=>$batch_id,'r.semester_id'=>$semester_id));
		if($course_id>0)
			$this->db->where(array('r.course_id'=>$course_id));
		if($degree_id == 1){
			$this->db->group_by('c.id,u.id');
			$this->db->order_by('u.first_name,u.last_name,csg.id');
		}else
			$this->db->order_by('c.id,u.first_name,u.last_name');
		$result=$this->db->get()->result();
		return $result;
	}
	
	function get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id='')
	{
		
		$this->db->select('c.id as course_id,r.theory_internal1,r.theory_internal2,r.theory_internal3,r.theory_internal,r.theory_paper1,
		                   r.theory_paper2,r.theory_paper3,r.theory_paper4,r.sum_internal_practical,r.practical_internal,r.theory_external1,r.theory_external2,r.theory_external3,r.theory_external4,r.practical_external,
						   r.marks_sum,r.external_sum,
						  c.course_title,c.course_code,c.theory_credit,c.practicle_credit,cp.campus_code,cp.campus_name,
						   b.batch_name,s.semester_name,d.degree_name,u.first_name,u.last_name,u.user_unique_id,csg.course_subject_name,csg.course_subject_title,csg.id as coure_group_id,dis.discipline_name,dis.discipline_code,u.id as student_id,assignment_mark');
		$this->db->from('students_ug_marks as r');
		$this->db->join('courses as c','c.id=r.course_id');
		$this->db->join('disciplines as dis','dis.id=c.discipline_id');
		$this->db->join('users u','u.id=r.student_id');
		$this->db->join('campuses cp','cp.id=r.campus_id');
		$this->db->join('batches b','b.id=r.batch_id');
		$this->db->join('semesters s','s.id=r.semester_id');
		$this->db->join('course_subject_groups csg','csg.id=c.course_subject_id','LEFT');
		$this->db->join('degrees d','d.id=r.degree_id');
		$this->db->where(array('r.campus_id'=>$campus_id,'r.program_id'=>$program_id,'r.degree_id'=>$degree_id,'r.batch_id'=>$batch_id,'r.semester_id'=>$semester_id));
		if($course_id>0)
			$this->db->where(array('r.course_id'=>$course_id));
		if($degree_id == 1){
			$this->db->group_by('c.id,u.id');
			$this->db->order_by('u.first_name,u.last_name,csg.id');
		}else
			$this->db->order_by('c.id,u.first_name,u.last_name');
		$result=$this->db->get()->result();
		return $result;
	}
	function get_subject_wise_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id)
	{
		$this->db->select('r.theory_internal1,r.theory_internal2,r.theory_internal3,r.theory_internal,r.theory_paper1,
		                   r.theory_paper2,r.sum_internal_practical,r.practical_internal,r.theory_external,r.practical_external,
						   r.marks_sum,r.sum_internal,r.external_sum,r.passfail_status,r.percentval,r.gradeval,r.creditval,
						   r.credithour,c.course_title,c.course_code,c.theory_credit,c.practicle_credit,cp.campus_code,cp.campus_name,
						   b.batch_name,s.semester_name,d.degree_name,u.first_name,u.last_name,u.user_unique_id');
		$this->db->from('results as r');
		$this->db->join('courses as c','c.id=r.course_id');
		$this->db->join('users u','u.id=r.student_id');
		$this->db->join('campuses cp','cp.id=r.campus_id');
		$this->db->join('batches b','b.id=r.batch_id');
		$this->db->join('semesters s','s.id=r.semester_id');
		$this->db->join('degrees d','d.id=r.degree_id');
		$this->db->where(array('r.campus_id'=>$campus_id,'r.program_id'=>$program_id,'r.degree_id'=>$degree_id,'r.batch_id'=>$batch_id,'r.semester_id'=>$semester_id,'r.course_id'=>$course_id,'r.passfail_status'=>'FAIL'));
		$result=$this->db->get()->result();
		return $result;
	}
	
	
} //end class