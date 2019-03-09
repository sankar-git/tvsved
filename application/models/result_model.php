<?php
Class Result_model extends CI_Model
{	
	
	function get_student_assigned_subjects($stuId)
	{
		$this->db->select('c.*');
		$this->db->from('courses c');
		$this->db->join('student_assigned_courses sac','sac.course_id = c.id','INNER');
		 $this->db->where('sac.student_id',$stuId);
		 $this->db->order_by("sac.student_id", "asc");
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_student_marks_by_id($student_id,$semester_id='')
	{
		$this->db->select('um.assignment_mark,um.theory_internal1,um.highest_marks,um.second_highest_marks,um.smallest_marks,um.theory_internal2,um.theory_internal3,
		                   um.theory_internal,um.theory_paper1,um.theory_paper2,um.theory_paper3,um.theory_paper4,um.sum_internal_practical,
		                   um.external_sum,um.practical_internal,um.theory_external1,um.theory_external2,um.theory_external3,um.theory_external4,um.practical_external,
		                   um.marks_sum,um.student_id,um.course_id,um.ncc_status,c.id,c.course_code,c.course_title,
						   c.theory_credit,c.practicle_credit,c.course_group_id,um.semester_id,csg.course_subject_name,csg.course_subject_title'); 
		$this->db->from('students_ug_marks um');
		$this->db->join('courses as c','c.id=um.course_id','INNER');
		$this->db->join('course_subject_groups as csg','csg.id=c.course_subject_id','LEFT');
		//$this->db->where('um.student_id',$student_id);
		$this->db->where(array('um.student_id'=>$student_id));
		if($semester_id>0)
			$this->db->where(array('um.semester_id'=>$semester_id));
		$this->db->order_by("c.id,um.course_id", "asc");
        $result	= $this->db->get()->result();//echo $this->db->last_query();exit;
		return $result;
	}
	
	function get_student_marks_by_id_change($student_id,$semester_id)
	{
		$this->db->select('um.theory_internal,um.practical_internal,um.theory_external,um.practical_external,
		                   um.marks_sum,um.student_id,um.course_id,c.id,c.course_code,c.course_title,
						   c.theory_credit,c.practicle_credit,psm.total_marks,psm.total_credit_points,
						   psm.total_credits,psm.total_grade_point_average'); 
		$this->db->from('students_ug_marks um');
		$this->db->join('courses as c','c.id=um.course_id','INNER');
		$this->db->join('previous_semester_marks as psm','psm.student_id=um.student_id','LEFT');
		$this->db->where('um.student_id',$student_id);
		$this->db->where('psm.semester_id <=',$semester_id); 
		$this->db->order_by("um.course_id", "asc");
        $result	= $this->db->get()->result_array();
		return $result;
	}
	function get_previous_semester_data($student_id,$semester_id)
	{
		$this->db->select('psm.total_marks,psm.total_marks,psm.total_credit_points,
						   psm.total_credits,psm.total_grade_point_average,psm.semester_id'); 
		$this->db->from('previous_semester_marks as psm');
		
		$this->db->where('psm.student_id',$student_id);
		$this->db->where('psm.semester_id !=',$semester_id); 
		$this->db->order_by("psm.student_id", "asc");
        $result	= $this->db->get()->result();
		//echo $this->db->last_query();exit;
		return $result;
	}
	function get_student_all_course_data($student_id)
	{
		$this->db->select('um.course_id,c.course_code,c.course_title,c.theory_credit,
		                   c.practicle_credit,um.marks_sum,um.theory_internal,um.practical_internal,
						   um.theory_external,um.practical_external,u.id,u.user_unique_id,
						   u.first_name,u.last_name'); 
		$this->db->from('students_ug_marks um');
		$this->db->join('users as u','u.id=um.student_id','INNER');
		$this->db->join('courses as c','c.id=um.course_id','INNER');
		$this->db->where('um.student_id',$student_id);
		$this->db->order_by("um.course_id", "asc");
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_result_data($student_id)
	{
		$this->db->select('u.*,umap.user_id,b.batch_name,c.campus_name,c.campus_code,d.degree_name,d.degree_code,umap.parent_name,umap.mother_name');
		$this->db->from('users u');
		$this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
		$this->db->join('batches b','b.id = umap.batch_id','INNER');
		$this->db->join('campuses c','c.id = umap.campus_id','left');
		$this->db->join('degrees d','d.id = umap.degree_id','left');
		$this->db->where_in('u.id',$student_id);
        $result	= $this->db->get()->result();//echo $this->db->last_query(); die;
		return $result;
	}
	function get_student_result_data($student_id)
	{
		$this->db->select('u.*,umap.user_id,b.batch_name,c.campus_name,c.campus_code,d.degree_name,program_name,umap.parent_name,umap.mother_name,discipline_name');
		$this->db->from('users u');
		$this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
		$this->db->join('batches b','b.id = umap.batch_id','INNER');
		$this->db->join('campuses c','c.id = umap.campus_id','left');
		$this->db->join('degrees d','d.id = umap.degree_id','left');
		$this->db->join('programs e','e.id = d.program_id','left');
		$this->db->join('disciplines f','f.id = d.discipline_id','left');
		$this->db->where('u.id',$student_id);
		
        $result	= $this->db->get()->result();//echo $this->db->last_query(); die;
		return $result;
	}
	function get_student_semester_data($student_id)
	{
		$this->db->select('sum.semester_id');
		$this->db->from('students_ug_marks sum');
		
		$this->db->where('sum.student_id',$student_id);
		$this->db->group_by('sum.semester_id');
		//echo $this->db->last_query(); die;
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_student_marks_by_id_and_semester_id($student_id,$semester_id)
	{
		$this->db->select('um.theory_internal1,um.theory_external2,um.theory_internal3,um.theory_internal2,um.theory_internal1,um.theory_internal,um.assignment_mark,um.theory_paper1,um.theory_paper2,um.sum_internal_practical,
		                   um.external_sum,um.practical_internal,um.theory_external1,um.practical_external,
		                   um.marks_sum,um.student_id,um.course_id,um.semester_id,um.ncc_status,c.id,c.course_code,c.course_title,
						   c.theory_credit,c.practicle_credit,csg.course_subject_name,csg.course_subject_title,csg.id as course_group_id'); 
		$this->db->from('students_ug_marks um');
		$this->db->join('courses as c','c.id=um.course_id','INNER');
		$this->db->join('course_subject_groups csg','csg.id=c.course_subject_id','LEFT');
		$this->db->where(array('um.student_id'=>$student_id,'um.semester_id'=>$semester_id));
		$this->db->order_by("um.course_id", "asc");
        $result	= $this->db->get()->result();
		return $result;
	}
	
	
	function get_semester_name($semester_id)
	{
		$this->db->select('s.semester_name');
		$this->db->from('semesters s');
		$this->db->where('s.id',$semester_id);
		$result = $this->db->get()->row();
		return $result;
	}
	function save_student_previous_semsester_marks($data)
	{
		//p($data); exit;
		$this->db->insert('previous_semester_marks',$data);
		//$insert_id = $this->db->insert_id();
	}
	function update_student_previous_semsester_marks($data)
	{
		//p($data); exit;
		$campus_id = $data['campus_id'];
		$program_id = $data['program_id'];
		$degree_id = $data['degree_id'];
		$semester_id = $data['semester_id'];
		$batch_id = $data['batch_id'];
		$student_id = $data['student_id'];
		
		$this->db->where(array('campus_id'=>$campus_id,'program_id'=>$program_id,'degree_id'=>$degree_id,'semester_id'=>$semester_id,'batch_id'=>$batch_id,'student_id'=>$student_id));
		$this->db->update('previous_semester_marks',$data);
		}
		
		function update_student_previous_result_marks($data)
	    {
		//p($data); exit;
		$campus_id = $data['campus_id'];
		$program_id = $data['program_id'];
		$degree_id = $data['degree_id'];
		$semester_id = $data['semester_id'];
		$batch_id = $data['batch_id'];
		$student_id = $data['student_id'];
		$course_id = $data['course_id'];
		$this->db->where(array('campus_id'=>$campus_id,'program_id'=>$program_id,'degree_id'=>$degree_id,'semester_id'=>$semester_id,'batch_id'=>$batch_id,'student_id'=>$student_id,'course_id'=>$course_id));
		$this->db->update('results',$data);
		}
	function get_previous_save_semster_marks($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$student_id)
	{
		$this->db->select('psm.*');
        $this->db->from('previous_semester_marks as psm');
        $this->db->where(array('campus_id' =>$campus_id,'program_id'=>$program_id,'degree_id' =>$degree_id,'semester_id'=>$semester_id,'batch_id' =>$batch_id,'student_id'=>$student_id));
        $result	= $this->db->get()->row();
		return $result;
	}
	
	function get_previous_results_subjects_marks($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$student_id,$course_id)
	{
		$this->db->select('r.id');
        $this->db->from('results as r');
        $this->db->where(array('campus_id' =>$campus_id,'program_id'=>$program_id,'degree_id' =>$degree_id,'semester_id'=>$semester_id,'batch_id' =>$batch_id,'student_id'=>$student_id,'course_id'=>$course_id));
        $result	= $this->db->get()->row();
		return $result;
	}
	function save_student_previous_result_marks($data)
	{
		//p($data); exit;
		$this->db->insert('results',$data);
		//$insert_id = $this->db->insert_id();
	}
	function get_batch_name($batch_id)
	{
		$this->db->select('batch_name');
		$this->db->from('batches');
		$this->db->where(array('id'=>$batch_id));
		$result=$this->db->get()->row();
		return $result;
	}
	function get_degree_name($degree_id)
	{
		$this->db->select('degree_name');
		$this->db->from('degrees');
		$this->db->where(array('id'=>$degree_id));
		$result=$this->db->get()->row();
		return $result;
	}
	
	function get_student_pass_fail_list($student_id,$semester_id)
	{
		//p($semester_id); exit;
		$this->db->select('r.*');
		$this->db->from('results as r');
		$this->db->where_in('r.student_id',$student_id);
		$this->db->where(array('r.semester_id'=>$semester_id,'r.passfail_status	'=>'FAIL'));
		$this->db->group_by('r.student_id',$student_id);
		$result=$this->db->get()->result();
		return $result;
	}
	function get_student_info($student_id)
	{
		$this->db->select('u.*,umap.user_id,b.batch_name,c.campus_name,c.campus_code,d.degree_name');
		$this->db->from('users u');
		$this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
		$this->db->join('batches b','b.id = umap.batch_id','INNER');
		$this->db->join('campuses c','c.id = umap.campus_id','left');
		$this->db->join('degrees d','d.id = umap.degree_id','left');
		$this->db->where('u.id',$student_id);
		//echo $this->db->last_query(); die;
        $result	= $this->db->get()->row();
		return $result;
	}
	function get_deflicit_students($student_id,$semester_id,$degree_id)
	{
		//p($semester_id); exit;
		$this->db->select('r.*,c.course_code,cp.campus_code,cp.campus_name,d.degree_name,
		s.semester_name,u.first_name,u.last_name,u.user_unique_id,b.batch_name');
		$this->db->from('results as r');
		$this->db->join('courses as c','c.id=r.course_id','INNER');
		$this->db->join('campuses as cp','cp.id=r.campus_id','INNER');
		$this->db->join('degrees as d','d.id=r.degree_id','INNER');
		$this->db->join('semesters as s','s.id=r.semester_id','INNER');
		$this->db->join('users as u','u.id=r.student_id','INNER');
		$this->db->join('batches as b','b.id=r.batch_id','INNER');
		$this->db->where_in('r.student_id',$student_id);
		$this->db->where(array('r.dstatus'=>'1','r.passfail_status	'=>'FAIL','r.degree_id'=>$degree_id));
		$this->db->group_by('r.student_id',$student_id);
		$result=$this->db->get()->result();
		return $result;
	}
	function get_deflicit_fail_list($student_id,$semester_id)
	{
		//p($semester_id); exit;
		$this->db->select('r.*,c.course_code');
		$this->db->from('results as r');
		$this->db->join('courses as c','c.id=r.course_id','INNER');
		$this->db->where_in('r.student_id',$student_id);
		
		$this->db->where(array('r.dstatus'=>'1','r.passfail_status	'=>'FAIL'));
		$result=$this->db->get()->result();
		return $result;
	}
	
	function get_deflicit_fail_list_btech($student_id,$semester_id)
	{
		//p($semester_id); exit;
		$this->db->select('r.*,c.course_code');
		$this->db->from('results as r');
		$this->db->join('courses as c','c.id=r.course_id','INNER');
		$this->db->where_in('r.student_id',$student_id);
		
		$this->db->where(array('r.dstatus'=>'1','r.passfail_status	'=>'FAIL'));
		$result=$this->db->get()->result();
		return $result;
	}
	
	
	
} //end class