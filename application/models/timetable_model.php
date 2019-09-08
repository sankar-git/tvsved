<?php
Class Timetable_model extends CI_Model
{	

	function viewTimeTable11()
	{
		return $this->db->order_by('id', 'ASC')->get('time_tables')->result();
	}
	function allocateInvigilator($teacher_id='',$campus_id='',$program_id='',$degree_id='',$semester_id='',$batch_id='')
	{
		$this->db->select('hall_superindent,ced.exam_type,ced.examination,tt.id as ttid,tt.slots,tt.teacher_id,tt.room_id,cr.room_name,s.slot_name,tt.status,ced.id,d.discipline_name,c.campus_name,cc.course_title,ced.exam_date,deg.degree_name,sem.semester_name,bat.batch_name');
		$this->db->from('course_exam_date as ced');
        $this->db->join('time_tables as tt','ced.id = tt.exam_date_id','LEFT');
		$this->db->join('courses as cc','cc.id = ced.course_id','LEFT');
        $this->db->join('disciplines as d','d.id = cc.discipline_id','LEFT');
		$this->db->join('campuses as c','c.id = ced.campus_id','LEFT');
		$this->db->join('degrees as deg','deg.id = ced.degree_id','LEFT');
		$this->db->join('semesters as sem','sem.id = ced.semester_id','LEFT');
		$this->db->join('batches as bat','bat.id = ced.batch_id','LEFT');
		//$this->db->join('users as u','u.id = tt.teacher_id','LEFT');
		$this->db->join('class_room as cr','cr.id = tt.room_id','LEFT');
		$this->db->join('exam_slot as s','s.id = tt.slots','LEFT');
		if($teacher_id>0){
			$this->db->where_in('tt.teacher_id', $teacher_id);
		}
		if($campus_id>0){
			$this->db->where('ced.campus_id', $campus_id);
		}if($program_id>0){
			$this->db->where('ced.program_id', $program_id);
		}if($degree_id>0){
			$this->db->where('ced.degree_id', $degree_id);
		}if($semester_id>0){
			$this->db->where('ced.semester_id', $semester_id);
		}if($batch_id>0){
			$this->db->where('ced.batch_id', $batch_id);
		}
		$this->db->where("ced.exam_date!=","''",false);
        $result	= $this->db->get()->result();//echo $this->db->last_query();exit;
		return $result;
	}
	function viewTimeTable($teacher_id='',$campus_id='',$program_id='',$degree_id='',$semester_id='',$batch_id='')
	{
		$this->db->select('ced.exam_type,ced.examination,tt.*,d.discipline_name,bat.batch_name,deg.degree_name,deg.degree_code,c.campus_name,c.campus_code,cc.course_title,u.first_name,u.last_name,cr.room_name,s.slot_name,ced.exam_date');
		$this->db->from('course_exam_date as ced');
        $this->db->join('time_tables as tt','ced.id = tt.exam_date_id','LEFT');
		$this->db->join('courses as cc','cc.id = ced.course_id','LEFT');
        $this->db->join('disciplines as d','d.id = cc.discipline_id','LEFT');
		$this->db->join('campuses as c','c.id = ced.campus_id','LEFT');
		$this->db->join('degrees as deg','deg.id = ced.degree_id','LEFT');
		$this->db->join('batches as bat','bat.id = ced.batch_id','LEFT');
		$this->db->join('users as u','u.id = tt.teacher_id','LEFT');
		$this->db->join('class_room as cr','cr.id = tt.room_id','LEFT');
		$this->db->join('exam_slot as s','s.id = tt.slots','LEFT');
		if($teacher_id>0){
			$this->db->where('tt.teacher_id', $teacher_id);
		}
		if($campus_id>0){
			$this->db->where('ced.campus_id', $campus_id);
		}if($program_id>0){
			$this->db->where('ced.program_id', $program_id);
		}if($degree_id>0){
			$this->db->where('ced.degree_id', $degree_id);
		}if($semester_id>0){
			$this->db->where('ced.semester_id', $semester_id);
		}if($batch_id>0){
			$this->db->where('ced.batch_id', $batch_id);
		}
		$this->db->where("ced.exam_date!=","''",false);
        $result	= $this->db->get()->result();
		return $result;
	}
	function save_time_table($data)
	{
	    $this->db->insert('time_tables',$data);
		$insert_id = $this->db->insert_id();
	}
	function get_time_table_by_id($id)
	{
		$this->db->select('ced.*,tt.slots,tt.teacher_id,tt.room_id,tt.status,cc.discipline_id,tt.id as ttid,deg.degree_name,sem.semester_name,tt.hall_superindent');
		$this->db->from('course_exam_date as ced');
		$this->db->join('time_tables as tt','ced.id = tt.exam_date_id','LEFT');
		$this->db->join('courses as cc','cc.id = ced.course_id','LEFT');
		$this->db->join('disciplines as d','d.id = cc.discipline_id','LEFT');
		$this->db->join('degrees as deg','deg.id = ced.degree_id','LEFT');
		$this->db->join('semesters as sem','sem.id = ced.semester_id','LEFT');
        $this->db->where('ced.id', $id);
        $result	= $this->db->get()->row();//echo $this->db->last_query();exit;
		return $result;
	}
	function update_time_table($id,$save)
	{
		 
        if( !empty($id) )
		{
		$this->db->where('id',$id);
		$this->db->update('time_tables',$save);
		return true;			
		}
	}
	function delete_time_table($id)
	{
		if( !empty($id) ){
			 $this->db->where('id', $id);
             $this->db->delete('time_tables');		
		}
	}
	function status_time_table($id,$status)
	{
		if($status==0){$save=1;}
		else{$save=0;}
		if( !empty($id) ){
		$query = $this->db->query("update  time_tables set  time_tables.`status`=$save where  time_tables.id=$id;");
		return true;			
		}
	}
	function get_teacher_by_campus_and_discipline($campus,$discipline)
	{
		$this->db->select("u.id,concat(u.first_name,' ',u.last_name) as name",false);
		$this->db->from('users as u');
		$this->db->join('user_map_teacher_details as utd','utd.user_id=u.id','INNER');
		$this->db->where(array('utd.campus'=>$campus,'utd.discipline'=>$discipline));
		$this->db->order_by("u.first_name,u.last_name","asc");
		$result=$this->db->get()->result_array();
		return $result;
	}
	
	
	
	
	
	
	
	
} //end class