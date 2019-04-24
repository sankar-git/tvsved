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
		$this->db->select('c.id,c.course_code,course_title,c.course_group_id');
		$this->db->from('courses c');
        //$this->db->join('tbl_course_assignment  ca','c.id = ca.course_id','LEFT');
		if($program_id == 1)
			$this->db->where(array('c.discipline_id'=>$discipline_id,'c.program_id'=>$program_id,'c.semester_id'=>$semester_id,'c.degree_id'=>$degree_id));
		else
			$this->db->where(array('c.program_id'=>$program_id,'c.degree_id'=>$degree_id));
		//$this->db->group_by('c.id');
		$result	= $this->db->get()->result();
		return $result;
	 }
	 function get_student_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id){
		 $this->db->select("u.first_name,u.id,u.user_unique_id");
		$this->db->from('student_assigned_courses c');
        $this->db->join('users  u','u.id = c.student_id');
		$this->db->where(array('c.program_id'=>$program_id,'c.semester_id'=>$semester_id,'c.degree_id'=>$degree_id,'c.semester_id'=>$semester_id));
		$this->db->group_by('u.id');
		$this->db->group_by('u.first_name');
		$result	= $this->db->get()->result();//echo $this->db->last_query();exit;
		return $result;
		
	 }
	 function get_course_group_by_ids($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id)
	 { //echo "coming";
		 if($program_id == 1 && $degree_id==1){
			$this->db->select("case when `course_subject_name` IS NULL then c.id else concat(GROUP_CONCAT( distinct c.course_subject_id order by c.course_subject_id SEPARATOR '|'), '|', GROUP_CONCAT( DISTINCT c.id order by c.id SEPARATOR '-')) end as id,  case when `course_subject_name` IS NULL then course_title else course_subject_name end as course_title, `c`.`course_group_id`,c.course_subject_id,csg.course_subject_name,csg.course_subject_title,GROUP_CONCAT( DISTINCT  course_code order by course_code SEPARATOR ',') as course_code",false);
			$this->db->from('courses c');
			$this->db->join('student_assigned_courses ca','c.id = ca.course_id','LEFT');
			$this->db->join('course_subject_groups  csg','csg.id = c.course_subject_id','LEFT');
			$this->db->where(array('c.program_id'=>$program_id,'c.semester_id'=>$semester_id,'c.degree_id'=>$degree_id,'c.discipline_id'=>$discipline_id,'ca.batch_id'=>$batch_id));
			$this->db->group_by('c.course_subject_id');
		 }else{
			 $this->db->select("c.id , c.course_title, `c`.`course_group_id`,c.course_subject_id,c.course_code",false);
			 $this->db->from('courses c');
			 $this->db->where(array('c.degree_id'=>$degree_id));
			 if( !empty($program_id) )
				$this->db->where(array('c.program_id'=>$program_id));
			if($program_id == 1){
				if( !empty($semester_id) )
					$this->db->where(array('c.semester_id'=>$semester_id));
			}
			//$this->db->group_by('c.course_subject_id');
		 }
		 //
		$result	= $this->db->get()->result(); //echo $this->db->last_query();exit;
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
		 if(isset($data['course_id']) && $data['course_id']!='')
			$course_id=$data['course_id'];
		else{
			$student_id=$data['student_id'];
		  }
		$this->db->select('d.dummy_value,u.user_unique_id,u.id,u.first_name,ug.theory_internal1,ug.theory_internal2,ug.theory_internal3,ug.theory_paper1,ug.theory_paper2,ug.theory_paper3,ug.theory_paper4,ug.theory_internal,ug.practical_internal,ug.theory_external1,ug.theory_external2,ug.theory_external3,ug.theory_external4,ug.practical_external,ug.course_id,ug.ncc_status,assignment_mark');
		$this->db->from('student_assigned_courses c');
        $this->db->join('users  u','u.id = c.student_id','LEFT');
        $this->db->join('tbl_dummy  d','u.id = d.student_id','LEFT');
		if(isset($data['course_id']) && $data['course_id']!=''){
			$this->db->join('students_ug_marks ug',"c.student_id = ug.student_id AND ug.course_id ='$course_id'",'LEFT');
		}else{
			$this->db->join('students_ug_marks ug',"c.student_id = ug.student_id ",'LEFT');
		}
		$this->db->where(array('c.campus_id'=>$campus_id,'c.program_id'=>$program_id,'c.semester_id'=>$semester_id,'c.degree_id'=>$degree_id,'c.batch_id'=>$batch_id,'u.role_id'=>1));
		if(isset($data['course_id']) && $data['course_id']!=''){
			$this->db->group_by('c.student_id');
			$this->db->order_by('u.first_name');
		}else{
			
			$this->db->where(array('ug.student_id'=>$student_id));
			$this->db->group_by('ug.course_id');
			$this->db->order_by('ug.id');
			//
		}
		
		
		$result	= $this->db->get()->result();//echo $this->db->last_query();
		if($result)
		{
			return $result; 
		}
		
		
	 }
	 
	 
	 function get_student_assigned_marks_course_where_not_inserted($data)
	 {
		//p($data); exit;
		 
		 $campus_id     = $data['campus_id'];
		 $program_id    = $data['program_id'];
		 $degree_id     = $data['degree_id'];
		 $batch_id      = $data['batch_id'];
		 $semester_id   = $data['semester_id'];
		 $discipline_id = $data['discipline_id'];
		 $course_id     = $data['course_id'];
		 
		$this->db->select('u.*,ug.theory_internal1,ug.theory_internal2,ug.theory_internal3,ug.theory_paper1,ug.theory_paper2,ug.theory_internal,ug.practical_internal,ug.theory_external1,ug.theory_external2,ug.theory_external3,ug.theory_external4,ug.practical_external,ug.course_id,ug.ncc_status');
		$this->db->from('student_assigned_courses c');
        $this->db->join('users  u','u.id = c.student_id','INNER');
        $this->db->join('students_ug_marks  ug',"c.student_id = ug.student_id AND ug.course_id = '$course_id'",'LEFT');
		
		$this->db->where(array('c.campus_id'=>$campus_id,'c.program_id'=>$program_id,'c.semester_id'=>$semester_id,'c.degree_id'=>$degree_id,'c.batch_id'=>$batch_id,'u.role_id'=>1));
		$this->db->group_by('c.student_id');
		$result	= $this->db->get()->result();
		if($result)
		{
			return $result; 
		}
		 
	 }
	 function get_course_group($course_group_id,$program_id,$semester_id,$degree_id){
		$this->db->select("case when `course_subject_name` IS NULL then c.id else concat(GROUP_CONCAT( distinct c.course_subject_id order by c.course_subject_id SEPARATOR '|'), '|', GROUP_CONCAT( DISTINCT c.id order by c.id SEPARATOR '-')) end as id, case when `course_subject_name` IS NULL then course_title else course_subject_name end as course_title, `c`.`course_group_id`, c.course_subject_id, csg.course_subject_name, csg.course_subject_title, GROUP_CONCAT( DISTINCT course_code order by course_code SEPARATOR ', ') as course_code,theory_credit,practicle_credit",false);
		 $this->db->from('courses c');
		 $this->db->join('course_subject_groups csg','csg.id = c.course_subject_id','LEFT');
		 $this->db->where(array('c.course_subject_id'=>$course_group_id));
		 $this->db->where(array('c.program_id'=>$program_id,'c.semester_id'=>$semester_id,'c.degree_id'=>$degree_id));
		 return $this->db->get()->result(); 
	 }
	 function get_course_credit_points($courseid){
		$this->db->select('*');
		 $this->db->from('courses');
		 $this->db->where(array('id'=>$courseid));
		 return $this->db->get()->result(); 
	 }
	 function save_ug_marks_new($data)
	 {
		 $this->db->select('id');
		 $this->db->from('students_ug_marks');
		 $this->db->where(array('student_id'=>$data['student_id'],'course_id'=>$data['course_id'],'semester_id'=>$data['semester_id']));
		 $result = $this->db->get()->result();
		 if(count($result)>0){
			  $this->db->where(array('student_id'=>$data['student_id'],'course_id'=>$data['course_id'],'semester_id'=>$data['semester_id']));
			 $this->db->update('students_ug_marks',$data);
			 return $result[0]->id;
		 }else{
		    $this->db->insert('students_ug_marks',$data);
			$insert_id = $this->db->insert_id(); 
			return $insert_id;
		 }
	 }
	 function update_ug_marks($data)
	 {
		 $this->db->select('id');
		 $this->db->from('students_ug_marks');
		 $this->db->where(array('student_id'=>$data['student_id'],'course_id'=>$data['course_id']));
		 $result = $this->db->get()->result();
		 if(count($result)>0){
			 $this->db->where(array('student_id'=>$data['student_id'],'course_id'=>$data['course_id']));
			 $this->db->update('students_ug_marks',$data);
			 return $result[0]->id;
		 }else{
			$this->db->insert('students_ug_marks',$data);
			$insert_id = $this->db->insert_id(); 
			return $insert_id;
		 }
		 return true;			
	}
	function ug_marks_update($data)
	{
		 $student_id1 = $data['student_id'];
		 $course_id1 = $data['course_id'];
		 $theory_external = $data['theory_external'];
		 $practical_external = $data['practical_external'];
		 $external_sum = $data['external_sum'];
		 
		 $query = $this->db->query("update students_ug_marks set students_ug_marks.`theory_external`=$theory_external,students_ug_marks.`practical_external`=$practical_external,students_ug_marks.`external_sum`=$external_sum
		 where students_ug_marks.student_id=$student_id1 and       students_ug_marks.course_id=$course_id1;");
		//echo $this->db->last_query();
		 //return true;
		
	}
	
	 
	 
	 function update_marks_pg_new($data)
	 {
		 //print_r($data); exit;
		 $campus_id = $data['campus_id'];
		 $program_id = $data['program_id'];
		 $degree_id = $data['degree_id'];
		 $batch_id = $data['batch_id'];
		 $semester_id = $data['semester_id'];
		 $discipline_id = $data['discipline_id'];
		 $theory_internal = $data['theory_internal'];
		 $practical_internal = $data['practical_internal'];
		 $theory_external = $data['theory_external'];
		 $student_id = $data['student_id'];
		 $course_id = $data['course_id'];
		// print_r($theory_internal); exit;
		 if( !empty($theory_internal) )
		{
			$this->db->where(array('campus_id'=>$campus_id,'program_id'=>$program_id,'degree_id'=>$degree_id,'batch_id'=>$batch_id,'semester_id'=>$semester_id,'discipline_id'=>$discipline_id,'theory_internal'=>$theory_internal,'practical_internal'=>$practical_internal,'theory_external'=>$theory_external,'student_id'=>$student_id,'course_id'=>$course_id));
			$this->db->update('students_ug_marks',$data);
			return true;			
		} 
		
	 }
	 function delete_ug_marks($student_id,$course_id)
	 {
		//p($course_id); exit;
		 $this->db->where(array('student_id'=>$student_id,'course_id'=>$course_id));
		 $this->db->delete('students_ug_marks');
		 //echo $this->db->last_query(); exit;
	 }
	 function delete_ug_marks22($student_id,$course_id)
	 {
		// p($student_id); exit;
		 //$this->db->where_in($student_id,student_id);
		 $this->db->where_in('student_id',$student_id);
		 $this->db->where('course_id',$course_id);
		 $this->db->delete('students_ug_marks');
		 //echo $this->db->last_query(); exit;
	 }
	 function get_ug_students_by_ids($campus_id,$program_id,$degree_id,$batch_id)
	 {
		$this->db->select('d.dummy_value,u.*');
		$this->db->from('users u');
        $this->db->join('user_map_student_details  umap','u.id = umap.user_id','LEFT');
		$this->db->join('tbl_dummy  d','u.id = d.student_id','LEFT');
        $this->db->where(array('d.college_id'=>$campus_id,'d.degree_id'=>$degree_id,'d.batch_id'=>$batch_id));
		$this->db->order_by("u.first_name,u.last_name");
		$result	= $this->db->get()->result();
		return $result; 
	 }
	 
	 function get_student_assigned_courses($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$student_id)
	 {
		$this->db->select('c.id,c.course_code,c.course_title,c.theory_credit,c.practicle_credit,spm.theory_internal,spm.practical_internal,spm.theory_external,spm.practical_external');
		$this->db->from('courses c');
        $this->db->join('student_assigned_courses  sac','sac.course_id = c.id','INNER');
        $this->db->join('students_ug_marks  spm','spm.course_id = c.id','LEFT');
        $this->db->where(array('sac.campus_id'=>$campus_id,'sac.degree_id'=>$degree_id,'sac.batch_id'=>$batch_id,'sac.semester_id'=>$semester_id,'sac.student_id'=>$student_id));
		$result	= $this->db->get()->result();
		return $result; 
	 }
	 
	 function get_student_assigned_pg_courses($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$student_id)
	 {
		$this->db->select('c.id,c.course_code,c.course_title,c.theory_credit,c.practicle_credit,spm.internal_theory,spm.term_paper,spm.internal_practical,spm.external_theory');
		$this->db->from('courses c');
        $this->db->join('student_assigned_courses  sac','sac.course_id = c.id','INNER');
        $this->db->join('students_pg_marks  spm','spm.course_id = c.id','LEFT');
        $this->db->where(array('sac.campus_id'=>$campus_id,'sac.degree_id'=>$degree_id,'sac.batch_id'=>$batch_id,'sac.semester_id'=>$semester_id,'sac.student_id'=>$student_id));
		$result	= $this->db->get()->result();
		return $result; 
	 }
	 function save_pg_marks($data)
	 {
		    $this->db->insert('students_pg_marks1111',$data);
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
     function uploaded_marks_students_list($data)
	 {
		$campus_id = $data['campus_id'];
		$program_id = $data['program_id'];
		$degree_id = $data['degree_id'];
		$batch_id = $data['batch_id'];
		$semester_id = $data['semester_id'];
		$course_id = $data['course_id'];
		
		$this->db->select('sm.student_id,sm.course_id');
		$this->db->from('students_ug_marks sm');
		$this->db->where(array('sm.course_id'=>$course_id));
		$result	= $this->db->get()->result();
		return $result;
	 }
	  function get_inserted_course($course_id)
	 {
		$this->db->select('sm.course_id');
		$this->db->from('students_ug_marks sm');
        $this->db->where(array('sm.course_id'=>$course_id));
        $result	= $this->db->get()->row();
		return $result;
	 }
	  function get_students_of_assigned_course($data)
	 {
		 $campus_id = $data['campus_id'];
		 $program_id = $data['program_id'];
		 $degree_id = $data['degree_id'];
		 $batch_id = $data['batch_id'];
		 $semester_id = $data['semester_id'];
		 $discipline_id = $data['discipline_id'];
		 $course_id = $data['course_id'];
		 
		$this->db->select('u.id,u.user_unique_id,u.first_name,u.last_name,sm.theory_internal,sm.practical_internal,sm.theory_external,sm.practical_external');
		$this->db->from('users  u');
		$this->db->join('student_assigned_courses sac','sac.student_id = u.id','INNER');
		$this->db->join('students_ug_marks sm','sm.student_id = u.id','INNER');
		//$this->db->join('students_ug_marks smm','sm.course_id = sac.course_id','INNER');
		//$this->db->group_by('sm.student_id'); 
		$this->db->where(array('sac.course_id'=>$course_id,'sac.campus_id'=>$campus_id));
		
		$result	= $this->db->get()->result();
		return $result; 
		
		
		 
	 }
	 
	 
	 function bulk_get_students_of_assigned_course()
	 {
		 $campus_id = $data['campus_id'];
		 $program_id = $data['program_id'];
		 $degree_id = $data['degree_id'];
		 $batch_id = $data['batch_id'];
		 $semester_id = $data['semester_id'];
		 $discipline_id = $data['discipline_id'];
		 $course_id = $data['course_id'];
		 
		//$this->db->select('u.id,u.user_unique_id,u.first_name,u.last_name,sm.theory_internal,sm.practical_internal,sm.theory_external,sm.practical_external');
		//$this->db->from('users  u');
		//$this->db->join('student_assigned_courses sac','sac.student_id = u.id','INNER');
		//$this->db->join('students_ug_marks sm','sm.student_id = u.id','INNER');
		//$this->db->join('students_ug_marks smm','sm.course_id = sac.course_id','INNER');
		//$this->db->group_by('sm.student_id'); 
		//$this->db->where(array('sac.course_id'=>$course_id));
		
		//$result	= $this->db->get()->result();
		//return $result; 
		
		$query = $this->db->query("select u.*,sm.* from users as u left join student_assigned_courses as  sac on sac.student_id=u.id
                         left join students_ug_marks as sm on sm.student_id=u.id
                         where sac.course_id=$course_id and sac.campus_id=$campus_id
                         group by sac.student_id");
          return $query->result();
	 }
	 function bulk_assign_marks($data)
	 {
		 $campus_id = $data['campus_id'];
		 $program_id = $data['program_id'];
		 $degree_id = $data['degree_id'];
		 $batch_id = $data['batch_id'];
		 $semester_id = $data['semester_id'];
		 $discipline_id = $data['discipline_id'];
		 $course_id = $data['course_id'];
		 
		$this->db->select('u.id,u.user_unique_id,u.first_name,u.last_name,sm.theory_internal,sm.practical_internal,sm.theory_external,sm.practical_external');
		$this->db->from('users  u');
		$this->db->join('student_assigned_courses sac','sac.student_id = u.id','INNER');
		$this->db->join('students_ug_marks sm','sm.student_id = u.id','INNER');
		$this->db->where(array('sm.course_id'=>$course_id,'sm.campus_id'=>$campus_id,'sm.program_id'=>$program_id,'sm.batch_id'=>$batch_id,'sm.degree_id'=>$degree_id,'sm.semester_id'=>$semester_id));
		$this->db->group_by('sm.student_id');
		//echo $this->db->last_query();
		$result	= $this->db->get()->result();
		return $result; 
	 }

	 function get_students_of_not_assigned_course($data)
	 {
		// p($data); exit;
		 $campus_id =   $data['campus_id'];
		 $program_id =  $data['program_id'];
		 $degree_id  =  $data['degree_id'];
		 $semester_id = $data['semester_id'];
		 $batch_id  =   $data['batch_id'];
		 $course_id =   $data['course_id'];
		
		 $query = $this->db->query("select u.id,u.first_name,u.last_name,u.user_unique_id,sac.course_id,c.course_title,c.course_code from users as u inner join student_assigned_courses as sac on sac.student_id=u.id inner join  courses as c on c.id=sac.course_id
         where sac.course_id=$course_id and sac.campus_id=$campus_id and sac.program_id=$program_id and sac.degree_id=$degree_id and sac.semester_id=$semester_id and sac.batch_id=$batch_id");
		// echo $this->db->last_query();
         return $query->result();
		
	 }
	 
	  function save_marks($data)
	 {
		 //print_r($data); exit;
		    $student_id = $data['student_id'];
		    if(!empty($student_id))
			{
				$this->db->insert('students_ug_marks',$data);
				$insert_id = $this->db->insert_id(); 
				return $insert_id; 
			}
			
	 }
	 
	 function get_student_ug_marks()
	 {
		$this->db->select('ugm.id,ugm.theory_internal,ugm.practical_internal,ugm.theory_external,
		                   ugm.practical_external,u.user_unique_id,u.first_name,u.last_name,c.campus_code,
						   p.program_name,d.degree_name,ce.course_title'); 
		$this->db->from('students_ug_marks as ugm');
		$this->db->join('users as u','u.id=ugm.student_id','INNER');
		$this->db->join('campuses as c','c.id=ugm.campus_id','INNER');
		$this->db->join('programs as p','p.id=ugm.program_id','INNER');
		$this->db->join('degrees as d','d.id=ugm.degree_id','INNER');
		$this->db->join('courses as ce','ce.id=ugm.course_id','INNER');
		$result = $this->db->get()->result();
		return $result;
	 }
	 function get_student_ug_marks_by_id($id)
	 {
		$this->db->select('ugm.id,ugm.theory_internal,ugm.practical_internal,ugm.theory_external,
		                   ugm.practical_external,u.user_unique_id,u.first_name,u.last_name,c.campus_code,
						   p.program_name,d.degree_name,ce.course_title'); 
		$this->db->from('students_ug_marks as ugm');
		$this->db->join('users as u','u.id=ugm.student_id','INNER');
		$this->db->join('campuses as c','c.id=ugm.campus_id','INNER');
		$this->db->join('programs as p','p.id=ugm.program_id','INNER');
		$this->db->join('degrees as d','d.id=ugm.degree_id','INNER');
		$this->db->join('courses as ce','ce.id=ugm.course_id','INNER');
		$this->db->where(array('ugm.id'=>$id));
		$result = $this->db->get()->row();
		 return $result;
	 }
	 function update_student_marks_by_id($data)
	 {
		 $id = $data['id'];
		 if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('students_ug_marks',$data);
		return true;			
		}
	 }
	
	
	
} //end class