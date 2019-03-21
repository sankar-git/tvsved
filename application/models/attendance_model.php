<?php
Class Attendance_model extends CI_Model
{	

    function get_course_by_pds($program_id,$degree_id,$semester_id)
	{
		$this->db->select('c.id,c.course_code,c.course_title');
		$this->db->from('courses as c');
		if($program_id>0)
		$this->db->where(array('c.program_id' =>$program_id));
		if($degree_id>0)
		$this->db->where(array('c.degree_id' =>$degree_id));
		if($semester_id>0)
		$this->db->where(array('c.semester_id' =>$semester_id));
		$result=$this->db->get()->result();
		return $result;
	}
	function get_student_existing_rec($course_id,$degree_id,$semester_id,$user_id,$attendance_period,$attendance_date){
		$this->db->select('attendance_status');
		$this->db->from('attendance');
		$this->db->where(array('degree_id' =>$degree_id,'student_id' =>$user_id,'attendance_date' =>$attendance_date,'attendance_period' =>$attendance_period,'semester_id'=>$semester_id,'course_id'=>$course_id));
		$result	= $this->db->get()->result();
		return $result;
		
	}
	function get_time_table_from_to($course_id,$degree_id,$semester_id,$day){
		$this->db->select('min(`from`) as start,max(`to`) as end',true);
		$this->db->from('attendance_time_table');
		$this->db->where(array('degree_id' =>$degree_id,'day' =>$day,'semester_id'=>$semester_id,'course_id'=>$course_id));
		$this->db->group_by('course_id,semester_id,degree_id,day');
		$result	= $this->db->get()->result();
		return $result;
	}
	function get_student_assign_by_course($receive)
	{
		
		$degree_id     = $receive['degree_id'];
		$batch_id      = $receive['batch_id'];
		$semester_id   = $receive['semester_id'];
		$course_id     = $receive['course_id'];
		
		$this->db->select('ud.user_id,u.user_unique_id,u.first_name,u.last_name,sac.course_id');
        $this->db->from('users u');
        $this->db->join('user_map_student_details ud','ud.user_id=u.id','INNER');
        $this->db->join('student_assigned_courses sac','sac.student_id=u.id','INNER');
		$this->db->where(array('sac.degree_id' =>$degree_id,'sac.batch_id' =>$batch_id,'sac.semester_id'=>$semester_id,'sac.course_id'=>$course_id));
		$this->db->order_by('u.first_name,u.last_name');
		$result	= $this->db->get()->result();
		return $result;
	}
	function save_student_attendance($data,$id='')
	{
		if($id>0){
			$this->db->where('id',$id);
			$this->db->update('attendance',$data);
		}else{
			$this->db->set('created_on', 'NOW()', FALSE);
			$this->db->insert('attendance',$data);
			$insert_id = $this->db->insert_id();
		}
		return  true;
	}
	function saveAssignCourse($data,$id='')
	{
		if($id>0){
			$this->db->where('id',$id);
			$this->db->update('attendance_course_assigned_teacher',$data);
		}else{
			
			$this->db->insert('attendance_course_assigned_teacher',$data);
			$insert_id = $this->db->insert_id();
		}
		return  true;
	}
	function deleteassigncourse($id){
		$this->db->where('id',$id);
		$this->db->delete('attendance_course_assigned_teacher');
	}
	function get_course_assigned_teacher_list(){
		$this->db->select("a.id,b.campus_code,b.campus_name,c.program_code,c.program_name,d.degree_code,e.batch_name,f.semester_name,g.discipline_name,h.course_code,h.course_title,i.first_name,i.last_name");
		$this->db->from('attendance_course_assigned_teacher a');
		$this->db->join('campuses b','b.id=a.campus_id','LEFT');
		$this->db->join('programs c','c.id=a.program_id','LEFT');
		$this->db->join('degrees d','d.id=a.degree_id','LEFT');
		$this->db->join('batches e','e.id=a.batch_id','LEFT');
		$this->db->join('semesters f','f.id=a.semester_id','LEFT');
		$this->db->join('disciplines g','g.id=a.discipline_id','LEFT');
		$this->db->join('courses h','h.id=a.course_id','LEFT');
		$this->db->join('users i','i.id=a.teacher_id','LEFT');
		return $this->db->get()->result();
	}
	function getScheduler($degree_id,$semester_id){
		$this->db->select("DATE_FORMAT(now(), '%Y-%m-%d') as date,course_id as id,day as row, concat(`from`,':00') as start, concat(`to`,':00') as end,course_title as subject",false);
		$this->db->from('attendance_time_table a');
		$this->db->join('courses c','a.course_id=c.id','LEF');
		$this->db->where('a.degree_id',$degree_id);
		$this->db->where('a.semester_id',$semester_id);
		return $this->db->get()->result();
	}
	function save_attendance($data,$id)
	{
		if($data['degree_id']>0 && $data['semester_id']>0 ){
			$this->db->where('degree_id',$data['degree_id']);
			$this->db->where('semester_id',$data['semester_id']);
			$this->db->delete('attendance_time_table');
			$json = json_decode($data['data'], TRUE);
			//p($json);exit;
			$result['degree_id'] = $data['degree_id'];
				$result['semester_id'] = $data['semester_id'];
			foreach($json as $res){ //echo $res['start'];p($res);exit;
				$result['from'] = $res['start'];
				$result['to'] = $res['end'];
				$result['course_id'] = $res['id'];
				$result['day'] = $res['row'];
				$result['created_by'] = $id;
				//print_r($result);
				$this->db->insert('attendance_time_table',$result);
				$insert_id = $this->db->insert_id();
			}
		}
		return  true;
	}
	function delete_holidays($degree_id,$id)
	{
		if(!empty($id) ){
			 $this->db->where(array('id'=>$id));
			 $this->db->where_in('degree_id',$degree_id);
             $this->db->delete('holiday_list');
		}
	}
	function gettimeTable($degree_id,$semester_id,$day='-1'){
		$this->db->select('`a`.`course_id`,`b`.`course_title`, `b`.`course_code`, `from`, `to`');
		$this->db->from('attendance_time_table a');
		$this->db->join('courses b','a.course_id=b.id');
		if($day>=0)
			$this->db->where('a.day',$day);
		$this->db->where('a.degree_id',$degree_id);
		$this->db->where('a.semester_id',$semester_id);
		$this->db->order_by('from,to');
	//	print_r($this->db->last_query());   
		return $this->db->get()->result();
	}
	function get_holidays($degree_id,$date=''){
		$this->db->select('id,name,startDate,endDate,color');
		$this->db->from('holiday_list');
		$this->db->where_in('degree_id',$degree_id);
		if(!empty($date)){
			$this->db->where('startDate <=', $date);
			$this->db->where('endDate >=', $date);
		}
		return $this->db->get()->result();
	}
	function get_student_attendance($degree_id,$semester_id,$course_id='',$batch_id=''){
		//return $this->db->query("select id,h.name,h.startDate,h.endDate, '#8B0000' as color from holiday_list h where h.degree_id=$degree_id union select a.id,case when attendance_status = 'P' then concat('Present - ',c.course_title) else concat('Absent - ',c.course_title) end as name,a.attendance_date as startDate,a.attendance_date as endDate,  case when attendance_status = 'P' then '#006400' else '#FF0000' end as color from attendance a left join courses c  on  a.course_id=c.id where a.student_id=$user_id")->result();
		$this->db->select('users.id,first_name,last_name,user_unique_id,`attendance_status`,course_id,`attendance_period`,attendance_date');
		$this->db->from('attendance');
		$this->db->join('users','users.id=attendance.student_id');
		$this->db->where('degree_id',$degree_id);
		$this->db->where('semester_id',$semester_id);
		if(!empty($course_id))
			$this->db->where('course_id', $course_id);
		if(!empty($batch_id))
			$this->db->where('batch_id', $batch_id);
		$this->db->group_by('users.id');
			
		//}
		return $this->db->get()->result();
		
	}
	function getmyattendance($degree_id,$semester_id,$user_id,$attendance_date='',$attendance_date_to='',$course_id='',$batch_id=''){
		//return $this->db->query("select id,h.name,h.startDate,h.endDate, '#8B0000' as color from holiday_list h where h.degree_id=$degree_id union select a.id,case when attendance_status = 'P' then concat('Present - ',c.course_title) else concat('Absent - ',c.course_title) end as name,a.attendance_date as startDate,a.attendance_date as endDate,  case when attendance_status = 'P' then '#006400' else '#FF0000' end as color from attendance a left join courses c  on  a.course_id=c.id where a.student_id=$user_id")->result();
		$this->db->select('`attendance_status`,course_id,`attendance_period`,attendance_date,users.gender,users.id');
		$this->db->from('attendance');
		$this->db->join('users','users.id=attendance.student_id','LEFT');
		$this->db->where('degree_id',$degree_id);
		$this->db->where('semester_id',$semester_id);
		//if(!empty($date)){
		if(!empty($attendance_date) && empty($attendance_date_to) )
			$this->db->where('attendance_date', $attendance_date);
		if(!empty($attendance_date) && !empty($attendance_date_to) ){
			$this->db->where("attendance_date >= '$attendance_date'");
			$this->db->where("attendance_date <= '$attendance_date_to'");
		}
		if(!empty($course_id))
			$this->db->where('course_id', $course_id);
		if(!empty($batch_id))
			$this->db->where('batch_id', $batch_id);
		$this->db->where_in('student_id', $user_id);
			$this->db->order_by('attendance_date,attendance_period');
		//}
		
		return $this->db->get()->result();
		
	}
	function save_holidays($degree_id,$result){
		$startDateArr = explode("/",$result['startDate']);
		$endDateArr = explode("/",$result['endDate']);
		$data['startDate'] = $startDateArr[2].'-'.$startDateArr[0].'-'.$startDateArr[1];
		$data['endDate'] = $endDateArr[2].'-'.$endDateArr[0].'-'.$endDateArr[1];
		$data['name'] = $result['name'];
		$data['color'] = isset($result['color'])?$result['color']:'';
		$data['degree_id'] = $degree_id;
		$this->db->select('id');
		$this->db->from('holiday_list');
		$this->db->where('startDate',$data['startDate']);
		$this->db->where('endDate',$data['endDate']);
		$this->db->where('degree_id',$data['degree_id']);
		$result =$this->db->get()->result();
		if(isset($result[0]->id) && $result[0]->id>0){
			$this->db->where('id',$result[0]->id);
			$this->db->update('holiday_list',$data);
		}else{
			$this->db->insert('holiday_list',$data);
			return $insert_id = $this->db->insert_id();
		}
		return true;
	}
	function find_attendance_date($attendance_date,$degree_id,$semester_id,$batch_id,$course_id,$student_id,$period)
	{ 
		$this->db->select('a.id');
		$this->db->from('attendance as a');
		$this->db->where('a.attendance_date',$attendance_date);
		$this->db->where(array('a.degree_id'=>$degree_id,'a.semester_id'=>$semester_id,'a.batch_id'=>$batch_id,'a.course_id'=>$course_id,'a.student_id'=>$student_id,'a.attendance_period'=>$period));
		//echo $this->db->last_query(); exit;
		$result = $this->db->get()->result();
		return $result;
		
	}
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
	function get_feedbacks_id($id){
		$this->db->select('*');
		$this->db->from('manage_feedback');
		$this->db->where(array('id'=>$id));
		$result	= $this->db->get()->row();
		
		return $result;
	}
	function get_questions($degree_id,$semester_id,$batch_id){
		$this->db->select('*');
		$this->db->from('manage_feedback');
		 $this->db->where(array('degree_id'=>$degree_id,'semester_id'=>$semester_id,'batch_id'=>$batch_id));
		$result	= $this->db->get()->result();
		//echo $this->db->last_query();
		return $result;
	}
	function get_feedbacks(){
		$this->db->select('f.id,f.question,f.status,f.created_on');//,d.degree_name,s.semester_name,b.batch_name
		$this->db->from('manage_feedback f');
	/*	$this->db->join('degrees d','f.degree_id=d.id');
		$this->db->join('semesters s','f.semester_id=s.id');
		$this->db->join('batches b','f.batch_id=b.id');*/
		$result	= $this->db->get()->result_array();
		return $result;
	}
	
	function get_feedbacks_list(){
		$this->db->select('f.id,f.question,f.status,f.created_on');//,d.degree_name,s.semester_name,b.batch_name
		$this->db->from('manage_feedback f');
	/*	$this->db->join('degrees d','f.degree_id=d.id');
		$this->db->join('semesters s','f.semester_id=s.id');
		$this->db->join('batches b','f.batch_id=b.id');*/
		$result	= $this->db->get()->result_array();
		//echo $this->db->last_query();
		return $result;
	}
	
	function get_feedbacks_entered(){
		$this->db->select('*');//,d.degree_name,s.semester_name,b.batch_name
		$this->db->from('feedbacks f');
		if(isset($_POST['campus_id']) && $_POST['campus_id'] != '' && $_POST['campus_id'] != '0')
			$this->db->where('f.sender_campus',$_POST['campus_id']);
		if(isset($_POST['program_id']) && $_POST['program_id'] != '' && $_POST['program_id'] != '0')
			$this->db->where('f.sender_program',$_POST['program_id']);
		if(isset($_POST['degree_id']) && $_POST['degree_id'] != '' && $_POST['degree_id'] != '0')
			$this->db->where('f.sender_degree',$_POST['degree_id']);
		if(isset($_POST['batch_id']) && $_POST['batch_id'] != '' && $_POST['batch_id'] != '0')
			$this->db->where('f.sender_batch',$_POST['batch_id']);
		if(isset($_POST['discipline_id']) && $_POST['discipline_id'] != '' && $_POST['discipline_id'] != '0')
			$this->db->where('f.sender_discipline',$_POST['discipline_id']);
		if(isset($_POST['semester_id']) && $_POST['semester_id'] != '' && $_POST['semester_id'] != '0')
			$this->db->where('f.sender_semester',$_POST['semester_id']);
		if(isset($_POST['teacher_id']) && $_POST['teacher_id'] != '' && $_POST['teacher_id'] != '0')
			$this->db->where('f.sender_teacher',$_POST['teacher_id']);
		
		$result	= $this->db->get()->result_array();
		return $result;
	}
	function feedback_result_list(){
		$this->db->select('*');
		$this->db->from('feedbacks a');
		$this->db->join('manage_feedback f','a.feedback_id=f.id');
		$this->db->join('degrees d','f.degree_id=d.id');
		$this->db->join('semesters s','f.semester_id=s.id');
		$this->db->join('batches b','f.batch_id=b.id');
		$this->db->join('users u','a.sender_id=u.id');
		$result	= $this->db->get()->result_array();
		return $result;
	}
	
	function feedback_result($degree_id='',$semester_id='',$batch_id='',$teacher_id='',$question=''){
		$this->db->select('a.rate,count(a.rate) counts');
		$this->db->from('feedbacks a');
		//$this->db->join('manage_feedback f','a.feedback_id=f.id');
		//$this->db->join('degrees d','f.degree_id=d.id');
		//$this->db->join('semesters s','f.semester_id=s.id');
		//$this->db->join('batches b','f.batch_id=b.id');
		//$this->db->join('users u','a.sender_id=u.id');
		if($degree_id>0 && $semester_id>0 && $batch_id>0  && $teacher_id>0  &&$question>0)
			$this->db->where(array('a.sender_degree'=>$degree_id,'a.sender_semester'=>$semester_id,'a.sender_batch'=>$batch_id,'a.sender_teacher'=>$teacher_id,'a.feedback_id'=>$question));
			$this->db->group_by('a.rate');
		$result	= $this->db->get()->result();
		//echo $this->db->last_query();
		return $result;
	}
	function changefeedback($id,$status){
		$this->db->where('id',$id);
		if($status == 'Y')
			$data['status']='N';
		else
			$data['status']='Y';
			$this->db->update('manage_feedback',$data);
	}
	function save_feedback($post){
		if(isset($post['degree_id']) && $post['degree_id'] != '')
			$data['degree_id']=$post['degree_id'];
		if(isset($post['batch_id']) && $post['batch_id'] != '')
			$data['batch_id']=$post['batch_id'];
		if(isset($post['semester_id']) && $post['semester_id'] != '')
			$data['semester_id']=$post['semester_id'];
		$data['question']=$post['question'];
		$data['created_by']=$post['created_by'];
		
		if($post['id']>0){
			$this->db->where('id',$post['id']);
			$this->db->update('manage_feedback',$data);
		}else{
			$this->db->set('created_on', 'NOW()', FALSE);
			$this->db->insert('manage_feedback',$data);
			return $insert_id = $this->db->insert_id();
		}
		
		return $insert_id = $this->db->insert_id();
	}
} //end class