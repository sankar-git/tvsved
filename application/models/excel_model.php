<?php
Class Excel_model extends CI_Model
{	
     function get_campus_by_id($campus_id)
	 {
		$this->db->select('c.campus_name');
		$this->db->from('campuses as c');
        $this->db->where(array('c.id'=>$campus_id));
		$result	= $this->db->get()->row();
		return $result;
	 }
     function get_program_by_id($program_id)
	 {
		$this->db->select('p.program_name');
		$this->db->from('programs as p');
        $this->db->where(array('p.id'=>$program_id));
		$result	= $this->db->get()->row();
		return $result; 
	 }	
     function get_degree_by_id($degree_id)
	 {
		$this->db->select('d.degree_name');
		$this->db->from('degrees as d');
        $this->db->where(array('d.id'=>$degree_id));
		$result	= $this->db->get()->row();
		return $result; 
	 }	 	 
	 function get_batch_by_id($batch_id)
	 {
		$this->db->select('b.batch_name');
		$this->db->from('batches as b');
        $this->db->where(array('b.id'=>$batch_id));
		$result	= $this->db->get()->row();
		return $result; 
	 }
	  function get_semester_by_id($semester_id)
	 {
		$this->db->select('s.semester_name');
		$this->db->from('semesters as s');
        $this->db->where(array('s.id'=>$semester_id));
		$result	= $this->db->get()->row();
		return $result; 
	 }
	 function get_discipline_by_id($discipline_id)
	 {
		$this->db->select('d.discipline_name');
		$this->db->from('disciplines as d');
        $this->db->where(array('d.id'=>$discipline_id));
		$result	= $this->db->get()->row();
		return $result; 
	 }
	 function get_course_by_id($course_id)
	 {
		$this->db->select('c.course_title');
		$this->db->from('courses as c');
        $this->db->where(array('c.id'=>$course_id));
		$result	= $this->db->get()->row();
		return $result; 
	 }
	 function get_campus_by_name($campus_name)
	 {
		$this->db->select('c.id');
		$this->db->from('campuses as c');
        $this->db->where(array('c.campus_name'=>$campus_name));
		$result	= $this->db->get()->row();
		return $result; 
	 }
	  function get_program_by_name($program_name)
	 {
		 //p($program_name); exit;
		$this->db->select('p.id');
		$this->db->from('programs as p');
        $this->db->where(array('p.program_name'=>$program_name));
		$result	= $this->db->get()->row();
		return $result; 
	 }
	  function get_degree_by_name($degree_name)
	 {
		$this->db->select('d.id');
		$this->db->from('degrees as d');
        $this->db->where(array('d.degree_name'=>$degree_name));
		$result	= $this->db->get()->row();
		return $result; 
	 }
	  function get_batch_by_name($batch_name)
	 {
		$this->db->select('b.id');
		$this->db->from('batches as b');
        $this->db->where(array('b.batch_name'=>$batch_name));
		$result	= $this->db->get()->row();
		return $result; 
	 }
	  function get_semester_by_name($semester_name)
	 {
		$this->db->select('s.id');
		$this->db->from('semesters as s');
        $this->db->where(array('s.semester_name'=>$semester_name));
		$result	= $this->db->get()->row();
		return $result; 
	 }
	  function get_discipline_by_name($discipline_name)
	 {
		$this->db->select('d.id');
		$this->db->from('disciplines as d');
        $this->db->where(array('d.discipline_name'=>$discipline_name));
		$result	= $this->db->get()->row();
		return $result; 
	 }
	  function get_course_by_name($course_name)
	 {
		$this->db->select('c.id');
		$this->db->from('courses as c');
        $this->db->where(array('c.course_title'=>$course_name));
		$result	= $this->db->get()->row();
		return $result; 
	 }
	 function get_date_of_start($dates,$degree_id)
	 {
		$this->db->select('c.id');
		$this->db->from('courses as c');
        $this->db->where(array('c.course_title'=>$course_name));
		$result	= $this->db->get()->row();
		return $result; 
	 }
	 
	  function get_student_by_name($student_name)
	 {
		$this->db->select('u.id');
		$this->db->from('users as u');
        $this->db->where(array('u.first_name'=>$student_name));
		$result	= $this->db->get()->row();
		//echo $this->db->last_query();
		return $result; 
	 }
	 function save_ug_marks_excel($data)
	 {
		    $this->db->insert('students_ug_marks',$data);
			$insert_id = $this->db->insert_id(); 
			return $insert_id;
	 }
	 function get_student_already_uploaded($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id,$student_id)
	 {
		$this->db->select('ug.student_id');
		$this->db->from('students_ug_marks as ug');
        $this->db->where(array('ug.campus_id'=>$campus_id,'ug.program_id'=>$program_id,'ug.degree_id'=>$degree_id,'ug.batch_id'=>$batch_id,'ug.semester_id'=>$semester_id,'ug.discipline_id'=>$discipline_id,'ug.course_id'=>$course_id,'ug.student_id'=>$student_id));
		$result	= $this->db->get()->row();
		return $result;  
		 
	 }
	 function update_ug_marks_excel($data)
	 {
		// p($data); exit;
		 $campus_id=$data['campus_id'];
		 $program_id=$data['program_id'];
		 $degree_id=$data['degree_id'];
		 $batch_id=$data['batch_id'];
		 $semester_id=$data['semester_id'];
		 $discipline_id=$data['discipline_id'];
		 $course_id=$data['course_id'];
		 $student_id=$data['student_id'];
		 
		$this->db->where(array('campus_id'=>$campus_id,'program_id'=>$program_id,'degree_id'=>$degree_id,'batch_id'=>$batch_id,'semester_id'=>$semester_id,'discipline_id'=>$discipline_id,'course_id'=>$course_id,'student_id'=>$student_id));
		$this->db->update('students_ug_marks',$data);
	 }
	 
} //end class