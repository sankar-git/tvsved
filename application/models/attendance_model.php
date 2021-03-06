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
	function get_time_table_from_to($campus_id,$program_id,$course_id,$degree_id,$semester_id,$day,$section){
		$this->db->select('from as start,to as end',true);
		$this->db->from('attendance_time_table');
		$this->db->where(array('campus_id' =>$campus_id,'program_id' =>$program_id,'section_id' =>$section,'degree_id' =>$degree_id,'day' =>$day,'semester_id'=>$semester_id,'course_id'=>$course_id));
		//$this->db->group_by('course_id,semester_id,degree_id,day');
		$result	= $this->db->get()->result_array();
		return $result;
	}
	function get_student_assign_by_course($receive)
	{
		
		$program_id     = $receive['program_id'];
		$campus_id     = $receive['campus_id'];
		$degree_id     = $receive['degree_id'];
		$batch_id      = $receive['batch_id'];
		$semester_id   = $receive['semester_id'];
		$course_id     = $receive['course_id'];
		$section_id     = $receive['section_id'];

		$this->db->select('ud.user_id,u.user_unique_id,u.first_name,u.last_name,sac.course_id');
        $this->db->from('users u');
        $this->db->join('user_map_student_details ud','ud.user_id=u.id','INNER');
        $this->db->join('student_assigned_courses sac','sac.student_id=u.id','INNER');
		$this->db->where(array('sac.campus_id' =>$campus_id,'sac.program_id' =>$program_id,'sac.degree_id' =>$degree_id,'sac.batch_id' =>$batch_id,'sac.semester_id'=>$semester_id));
        if($section_id>0)
            $this->db->where(array('ud.section_id' =>$section_id));
		if($degree_id == 1){
            $courseArr = explode("|",$receive['course_id']);
            $course_id_arr = explode("-",$courseArr[1]);
            $this->db->where_in('sac.course_id',$course_id_arr);
        }else{
            $this->db->where(array('sac.course_id' =>$course_id));
        }
		$this->db->order_by('u.user_unique_id');
		$this->db->group_by('u.user_unique_id');
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
            $this->db->select('id');
            $this->db->from('attendance_course_assigned_teacher');
            $this->db->where(array(
                'campus_id' =>$data['campus_id'],
                'program_id' =>$data['program_id'],
                'degree_id' =>$data['degree_id'],
                'batch_id' =>$data['batch_id'],
                'semester_id' =>$data['semester_id'],
                'discipline_id' =>$data['discipline_id'],
                'course_id' =>$data['course_id'],
                'teacher_id' =>$data['teacher_id'],
                'section_id' =>$data['section_id']) );
            $result	= $this->db->get()->result();
            if(count($result)>0){
             return true;
            }else {
                $this->db->insert('attendance_course_assigned_teacher', $data);
                $insert_id = $this->db->insert_id();
            }
		}
		return  true;
	}
	function deleteassigncourse($id){
		$this->db->where('id',$id);
		$this->db->delete('attendance_course_assigned_teacher');
	}
	function get_course_assigned_teacher_list(){
		$this->db->select("course_id,a.degree_id,a.id,b.campus_code,b.campus_name,c.program_code,c.program_name,d.degree_code,e.batch_name,f.semester_name,g.discipline_name,h.section_code,h.section_name,i.first_name,i.last_name");
		$this->db->from('attendance_course_assigned_teacher a');
		$this->db->join('campuses b','b.id=a.campus_id','LEFT');
		$this->db->join('programs c','c.id=a.program_id','LEFT');
		$this->db->join('degrees d','d.id=a.degree_id','LEFT');
		$this->db->join('batches e','e.id=a.batch_id','LEFT');
		$this->db->join('semesters f','f.id=a.semester_id','LEFT');
		$this->db->join('disciplines g','g.id=a.discipline_id','LEFT');
		$this->db->join('section h','h.id=a.section_id','LEFT');
		$this->db->join('users i','i.id=a.teacher_id','LEFT');
		return $this->db->get()->result();
	}
	function getScheduler($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$section_id,$show_teacher = false){
        if($degree_id == 1)
		    $this->db->select("DATE_FORMAT(now(), '%Y-%m-%d') as date,course_id as id,day as row, concat(`from`,':00') as start, concat(`to`,':00') as end,course_title as subject",false);
        else
            $this->db->select("DATE_FORMAT(now(), '%Y-%m-%d') as date,course_id as id,day as row, concat(`from`,':00') as start, concat(`to`,':00') as end",false);
		$this->db->from('attendance_time_table');
        if($degree_id == 1)
		    $this->db->join('courses','attendance_time_table.course_id=courses.id','LEFT');
        if($campus_id>0)
		    $this->db->where('attendance_time_table.campus_id',$campus_id);
        if($program_id>0)
            $this->db->where('attendance_time_table.program_id',$program_id);
        if($degree_id>0)
            $this->db->where('attendance_time_table.degree_id',$degree_id);
        if($batch_id>0)
		    $this->db->where('attendance_time_table.batch_id',$batch_id);
        if($semester_id>0)
		    $this->db->where('attendance_time_table.semester_id',$semester_id);
        if($discipline_id>0)
		    $this->db->where('attendance_time_table.discipline_id',$discipline_id);
        if($section_id>0)
		    $this->db->where('attendance_time_table.section_id',$section_id);
		$result = $this->db->get()->result();
		if($show_teacher==true){
			$this->db->select('course_id,teacher_id,b.first_name');
			$this->db->from('attendance_course_assigned_teacher as a');
			$this->db->join('users as b','a.teacher_id=b.id');
			if($campus_id>0)
				$this->db->where('a.campus_id',$campus_id);
			if($program_id>0)
				$this->db->where('a.program_id',$program_id);
			if($degree_id>0)
				$this->db->where('a.degree_id',$degree_id);
			if($batch_id>0)
				$this->db->where('a.batch_id',$batch_id);
			if($semester_id>0)
				$this->db->where('a.semester_id',$semester_id);
			if($discipline_id>0)
				$this->db->where('a.discipline_id',$discipline_id);
			if($section_id>0)
				$this->db->where('a.section_id',$section_id);
			$teacherresult = $this->db->get()->result();
			//p($teacherresult);exit;
		}
        if($degree_id == 1) {
            foreach ($result as $key=>$res) {
				$teacher_name = '';
				if($show_teacher==true){
					foreach($teacherresult  as $key1=>$resnew){
						if($resnew->course_id == $res->id)
							$teacher_name.= $resnew->first_name .',';
					}
					$teacher_name = rtrim($teacher_name,',');
				}
                $course_idArr = explode("|",$res->id);
                if($course_idArr[0] == 22) {
                    $this->db->select('GROUP_CONCAT(course_code) as course_subject_title');
                    $this->db->from('courses');
                    $this->db->where_in('id', explode("-",$course_idArr[1]));
                    $sub_res=$this->db->get()->result_array();
					$course_title = $sub_res[0]['course_subject_title'];
					if(!empty($teacher_name))
						$course_title = $course_title."<br/><span style='font-size:9px;color:#000'>($teacher_name)</span>";
                    $result[$key]->subject=$course_title;
                }else{
                    $this->db->select('course_subject_title');
                    $this->db->from('course_subject_groups');
                    $this->db->where('id', $course_idArr[0]);
                    $sub_res=$this->db->get()->result_array();
					$course_title = $sub_res[0]['course_subject_title'];
					if(!empty($teacher_name))
						$course_title = $course_title."<br/><span style='font-size:9px;color:#000'>($teacher_name)</span>";
                    $result[$key]->subject=$course_title;
                }

            }
        }
        return $result;

	}
	function save_attendance($data,$id)
	{
		if($data['degree_id']>0 && $data['semester_id']>0 ){
			$this->db->where('campus_id',$data['campus_id']);
			$this->db->where('program_id',$data['program_id']);
			$this->db->where('batch_id',$data['batch_id']);
			$this->db->where('section_id',$data['section_id']);
			$this->db->where('degree_id',$data['degree_id']);
			$this->db->where('discipline_id',$data['discipline_id']);
			$this->db->where('semester_id',$data['semester_id']);
			$this->db->delete('attendance_time_table');
			$json = json_decode($data['data'], TRUE);
			//p($json);exit;
			$result['campus_id'] = $data['campus_id'];
			$result['program_id'] = $data['program_id'];
			$result['batch_id'] = $data['batch_id'];
			$result['section_id'] = $data['section_id'];
			$result['degree_id'] = $data['degree_id'];
			$result['discipline_id'] = $data['discipline_id'];
				$result['semester_id'] = $data['semester_id'];
			foreach($json as $res){ //echo $res['start'];p($res);exit;
				$result['from'] = $res['start'];
				$result['to'] = $res['end'];
				$result['course_id'] = $res['id'];
				$result['day'] = $res['row'];
				$result['created_by'] = $id;
				//print_r($result);
                $this->db->set('created_on', 'NOW()', FALSE);
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
	function gettimeTable($degree_id,$semester_id,$day='-1',$section=''){

		$this->db->select('a.course_id, a.from, a.to,a.day');
		$this->db->from('attendance_time_table a');
		if($day!='' || $day === 0)
			$this->db->where('a.day',$day);
		$this->db->where('a.degree_id',$degree_id);
        if($semester_id>0)
		    $this->db->where('a.semester_id',$semester_id);
        if($section>0)
		    $this->db->where('a.section_id',$section);
		$this->db->order_by('a.day,a.from,a.to');
	//	print_r($this->db->last_query());   
		return $this->db->get()->result();
	}
	function get_holidays($data,$date=''){
		$this->db->select('id,name,startDate,endDate,color');
		$this->db->from('holiday_list');
		if(!empty($data['degree_id']))
		    $this->db->where_in('degree_id',$data['degree_id']);
		if(!empty($data['batch_id']))
		    $this->db->where_in('batch_id',$data['batch_id']);
		if(!empty($data['semester_id']))
		    $this->db->where_in('semester_id',$data['semester_id']);
		if(!empty($data['campus_id']))
		    $this->db->where('campus_id',$data['campus_id']);
		if(!empty($data['program_id']))
		    $this->db->where('program_id',$data['program_id']);
		if(!empty($date)){
			$this->db->where('startDate <=', $date);
			$this->db->where('endDate >=', $date);
		}
        $this->db->group_by('startDate,endDate');
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
        if(!empty($course_id))
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
	function save_holidays($degree_id,$result, $batch, $semester){
		$startDateArr = explode("/",$result['startDate']);
		$endDateArr = explode("/",$result['endDate']);
		$data['startDate'] = $startDateArr[2].'-'.$startDateArr[0].'-'.$startDateArr[1];
		$data['endDate'] = $endDateArr[2].'-'.$endDateArr[0].'-'.$endDateArr[1];
		$data['name'] = $result['name'];
		$data['color'] = isset($result['color'])?$result['color']:'';
		$data['degree_id'] = $degree_id;
		$data['semester_id'] = $semester;
		$data['batch_id'] = $batch;
		$data['campus_id'] = $result['campus_id'];
		$data['program_id'] = $result['program_id'];
		$this->db->select('id');
		$this->db->from('holiday_list');
		$this->db->where('startDate',$data['startDate']);
		$this->db->where('endDate',$data['endDate']);
		$this->db->where('degree_id',$data['degree_id']);
		$this->db->where('semester_id',$semester);
		$this->db->where('batch_id',$batch);
		$this->db->where('campus_id',$data['campus_id']);
		$this->db->where('program_id',$data['program_id']);
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
	function find_attendance_date($attendance_date,$degree_id,$semester_id,$batch_id,$course_id,$student_id,$period,$campus_id,$program_id,$discipline_id,$section_id)
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
	function feedback_result_list_csv($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$teacher_id){
		$this->db->select('campus_name,program_name,degree_name,semester_name,batch_name,question,u.first_name as student_name,t.first_name as teacher_name,rate,message');
		$this->db->from('feedbacks a');
		$this->db->join('manage_feedback f','a.feedback_id=f.id');
		$this->db->join('campuses c','c.id=a.sender_campus');
		$this->db->join('programs p','a.sender_program=p.id');
		$this->db->join('degrees d','f.degree_id=d.id');
		$this->db->join('semesters s','f.semester_id=s.id');
		$this->db->join('batches b','f.batch_id=b.id');
		$this->db->join('users u','a.sender_id=u.id');
		$this->db->join('users t','a.sender_teacher=t.id');
		$result	= $this->db->get()->result_array();
		return $result;
	}
	
	function feedback_result_list($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$teacher_id){
		$this->db->select('campus_name,program_name,question,rate,message,batch_name,semester_name,degree_name,u.first_name as student_name,t.first_name as teacher_name');
		$this->db->from('feedbacks a');
		$this->db->join('manage_feedback f','a.feedback_id=f.id');
		$this->db->join('campuses c','c.id=a.sender_campus');
		$this->db->join('programs p','a.sender_program=p.id');
		$this->db->join('degrees d','f.degree_id=d.id');
		$this->db->join('semesters s','f.semester_id=s.id');
		$this->db->join('batches b','f.batch_id=b.id');
		$this->db->join('users u','a.sender_id=u.id');
		$this->db->join('users t','a.sender_teacher=t.id');
		if($degree_id>0 && $semester_id>0 && $batch_id>0  && $teacher_id>0  && $campus_id>0  && $program_id>0)
			$this->db->where(array('a.sender_campus'=>$campus_id,'a.sender_program'=>$program_id,'a.sender_degree'=>$degree_id,'a.sender_semester'=>$semester_id,'a.sender_batch'=>$batch_id,'a.sender_teacher'=>$teacher_id));
		$result	= $this->db->get()->result_array();
		return $result;
	}
	
	function feedback_result($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$teacher_id){
		$this->db->select('a.rate,count(a.rate) counts');
		$this->db->from('feedbacks a');
		//$this->db->join('manage_feedback f','a.feedback_id=f.id');
		//$this->db->join('degrees d','f.degree_id=d.id');
		//$this->db->join('semesters s','f.semester_id=s.id');
		//$this->db->join('batches b','f.batch_id=b.id');
		//$this->db->join('users u','a.sender_id=u.id');
		if($degree_id>0 && $semester_id>0 && $batch_id>0  && $teacher_id>0  && $campus_id>0  && $program_id>0)
			$this->db->where(array('a.sender_campus'=>$campus_id,'a.sender_program'=>$program_id,'a.sender_degree'=>$degree_id,'a.sender_semester'=>$semester_id,'a.sender_batch'=>$batch_id,'a.sender_teacher'=>$teacher_id));
			$this->db->group_by('a.rate');
		$result	= $this->db->get()->result();
		//echo $this->db->last_query();exit;
		return $result;
	}
	function feedback_result_bar($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$teacher_id){
		$this->db->select('sum(a.rate)/count(a.rate) as average,sum(a.rate) as total,count(a.rate) as counts,b.question,b.id,c.first_name as teacher');
		$this->db->from('feedbacks a');
		$this->db->join('manage_feedback b','a.feedback_id=b.id');
		$this->db->join('users c','a.sender_teacher=c.id');
		if($degree_id>0 && $semester_id>0 && $batch_id>0  && $teacher_id>0  && $campus_id>0  && $program_id>0)
			$this->db->where(array('a.sender_campus'=>$campus_id,'a.sender_program'=>$program_id,'a.sender_degree'=>$degree_id,'a.sender_semester'=>$semester_id,'a.sender_batch'=>$batch_id,'a.sender_teacher'=>$teacher_id));
		$this->db->group_by('a.feedback_id');
		$result	= $this->db->get()->result();
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
	function publishAttendance($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$discipline_id,$student_id){
		$this->db->where(array('campus_id'=>$campus_id,'program_id'=>$program_id,'degree_id'=>$degree_id,'discipline_id'=>$discipline_id,'semester_id'=>$semester_id,'batch_id'=>$batch_id));
		$this->db->where_in('student_id',$student_id);
		$data['approve_status'] = 1;
		$this->db->update('attendance',$data);
	}
} //end class