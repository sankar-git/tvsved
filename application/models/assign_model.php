<?php
Class Assign_model extends CI_Model
{	
    function  get_student_list_by_ids($data)
	{
		
		$campus_id = $data['campus_id'];
		$degree_id = $data['degree_id'];
		$batch_id =  $data['batch_id'];
		$course_id =  $data['course_id'];
		
		$this->db->select('ud.user_id,u.user_unique_id,u.first_name,u.last_name,sac.course_id');
        $this->db->from('users u');
        $this->db->join('user_map_student_details ud','ud.user_id=u.id','INNER');
        $this->db->join('student_assigned_courses sac','sac.student_id=u.id','LEFT');
		$this->db->where(array('ud.campus_id' =>$campus_id,'ud.degree_id' =>$degree_id,'ud.batch_id' =>$batch_id));
		//$this->db->group_by('sac.student_id');
		//$this->db->group_by('sac.student_id');
		//$this->db->order_by("sac.course_id", "asc");
        $result	= $this->db->get()->result();
		
		//echo $this->db->last_query();
		return $result;
		
	}
	
	function  get_student_list_by_assign_course($data)
	{
		
		$campus_id = $data['campus_id'];
		$degree_id = $data['degree_id'];
		$batch_id =  $data['batch_id'];
		$course_id =  $data['course_id'];
		
		$this->db->select('ud.user_id,u.user_unique_id,u.first_name,u.last_name');
        $this->db->from('users u');
        $this->db->join('user_map_student_details ud','ud.user_id=u.id','INNER');
        $this->db->where(array('ud.campus_id' =>$campus_id,'ud.degree_id' =>$degree_id,'ud.batch_id' =>$batch_id));
		$result	= $this->db->get()->result();
		
		//echo $this->db->last_query();
		return $result;
		
	}
	function get_student_checked_list($data)
	{   
	   // p($data); exit;
		$campus_id = $data['campus_id'];
		$degree_id = $data['degree_id'];
		$batch_id =  $data['batch_id'];
		$course_id =  $data['course_id'];
		//p($course_id); exit;
		$this->db->select('ud.user_id,u.user_unique_id,u.first_name,u.last_name');
        $this->db->from('users u');
        $this->db->join('user_map_student_details ud','ud.user_id=u.id','INNER');
		$this->db->join('student_assigned_courses sac','sac.student_id=u.id','INNER');
        $this->db->where(array('ud.campus_id' =>$campus_id,'ud.degree_id' =>$degree_id,'ud.batch_id' =>$batch_id,'sac.course_id' =>$course_id));
		$result	= $this->db->get()->result();
		//echo $this->db->last_query();
		return $result;
	}
	function get_course_by_cdb($data)
	{
		$degree_id = $data['degree_id'];
		$program_id = $data['program_id'];
		$batch_id = $data['batch_id'];
		$this->db->select('c.id,c.course_code,c.course_title');
        $this->db->from('courses c');
        $this->db->join('tbl_course_assignment ca','ca.course_id=c.id','INNER');
		$this->db->where(array('ca.degree_id' =>$degree_id,'ca.program_id' =>$program_id,'ca.batch_id' =>$batch_id));
		
        $result	= $this->db->get()->result();
		//echo $this->db->last_query();
		return $result;
	}
	function save_bulk_course_to_student($data)
	{
		
		 $this->db->insert('student_assigned_courses',$data);
		 $insert_id = $this->db->insert_id();
		 return  true;
	}
	function update_bulk_course_to_student($data)
	{
		$id = $data['id'];
		if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('student_assigned_courses',$data);
		return true;			
		}
	}
	function get_already_student_assigned_course($studentId,$course_id)
	{
		$this->db->select('sac.id');
		$this->db->from('student_assigned_courses sac');
		$this->db->where(array('sac.student_id'=>$studentId,'sac.course_id'=>$course_id));
		$result	= $this->db->get()->row();
		return $result;
	}
	function delete_bulk_course_to_students($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$course_id)
	{
		if( !empty($campus_id)){
			 $this->db->where(array('campus_id'=>$campus_id,'program_id'=>$program_id,'degree_id'=>$degree_id,'semester_id'=>$semester_id,'batch_id'=>$batch_id,'course_id'=>$course_id));
             $this->db->delete('student_assigned_courses');		
		}
	}
} //end class