<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Attendance extends CI_Controller {
	
	 private $user_name='';
	 private $user_fullname='';
	 private $user_role = 0;
	 private $user_email='';
	 private $user_id='';
	 
	 public function __construct()
     {
             parent::__construct();
			$this->load->database();
			$this->load->library('session');
			$this->load->library('encrypt');
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->library('email');
			$this->load->model('fees_model');
			$this->load->library('image_lib');
			$this->load->model('common_model');
			$this->load->model('newsession_model');
			$this->load->helper('email');
			$this->load->model('newsession_model');
			$this->load->model('user_model');
			$this->load->model('type_model');
			$this->load->model('Master_model');
			$this->load->model('Discipline_model');
			$this->load->library('permission_lib');
			$this->load->model('Result_model');
			$this->load->model('Marks_model');
			$this->load->model('Process_model');
			$this->load->model('Generate_model');
			$this->load->model('Attendance_model');
			
			$this->load->library('excel');
			$sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }
		
	}
	function saveval(){
		$data = $_POST;
		$sessdata= $this->session->userdata('sms');
		$id = $this->Attendance_model->save_attendance($data,$sessdata[0]->id);
		echo $id;
	}
	function getScheduler(){
		$degree_id  = $this->input->post('degree_id');
		$semester_id  = $this->input->post('semester_id');
		$sessdata= $this->session->userdata('sms');
		$userid = $sessdata[0]->id;
		if($degree_id>0 && $semester_id>0)
				$schedulerList = $this->Attendance_model->getScheduler($degree_id,$semester_id);
		echo json_encode($schedulerList);
	}
	function getTeacherSemesterbyDegree(){
		 $sessdata= $this->session->userdata('sms');
		 $teacher_id = $sessdata[0]->id;
		$program_id = $this->input->post('program_id');
		$campus_id = $this->input->post('campus_id');
		$degree_id = $this->input->post('degree_id');
		$data['semester']=$this->Discipline_model->get_teacher_semester_by_degree($campus_id,$program_id,$degree_id,$teacher_id);
		//print_r($data['semester']); exit;
		 $str = '';
         foreach($data['semester'] as $k=>$v){   
            $str .= "<option value=".$v->id.">".$v->semester_name."</option>";
           }
		   
           echo $str;
	}
	function getTeacherProgramByCampus()
	{
		$campus_id = $this->input->post('campus_id');
		 $sessdata= $this->session->userdata('sms');
		 $teacher_id = $sessdata[0]->id;
		$data['programs']=$this->Discipline_model->get_teacher_program_by_campus($campus_id,$teacher_id); 
		//print_r($data['programs']); exit;
		$str = '';
         foreach($data['programs'] as $k=>$v){ 
           $str .= "<option value=".$v->id.">".$v->program_name."</option>";
           }
		   echo $str;
	}
	function getTeacherCourseByIds()
	{
		//print_r($_POST); exit;
		$campus_id = $this->input->post('campus_id');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$batch_id = $this->input->post('batch_id');
		$semester_id = $this->input->post('semester_id');
		$sessdata= $this->session->userdata('sms');
		 $teacher_id = $sessdata[0]->id;
		$data['courses']=$this->Discipline_model->get_teacher_course_by_ids($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$teacher_id); 
		//print_r($data['programs']); exit;
		$str = '';
         foreach($data['courses'] as $k=>$v){ 
           $str .= "<option value=".$v->id.">".$v->course_code.'-'.$v->course_title."</option>";
           }
		   echo $str;
	}
	function getTeacherBatchbyDegree(){
		 $sessdata= $this->session->userdata('sms');
		 $teacher_id = $sessdata[0]->id;
		$program_id = $this->input->post('program_id');
		$campus_id = $this->input->post('campus_id');
		$degree_id = $this->input->post('degree_id');
		$data['batch']=$this->Discipline_model->get_teacher_batch_by_degree($campus_id,$program_id,$degree_id,$teacher_id);
		//print_r($data['semester']); exit;
		 $str = '';
         foreach($data['batch'] as $k=>$v){   
            $str .= "<option value=".$v->id.">".$v->batch_name."</option>";
           }
		   
           echo $str;
	}
	function getTeacherDegreebyProgram(){
		 $sessdata= $this->session->userdata('sms');
		 $teacher_id = $sessdata[0]->id;
		$program_id = $this->input->post('program_id');
		$campus_id = $this->input->post('campus_id');
		$data['degrees']=$this->Discipline_model->get_teacher_degree($campus_id,$program_id,$teacher_id); 
		 $str = '';
         foreach($data['degrees'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->degree_name."</option>";
           }
		   
           echo $str;
	}
	function addAttendance()
	{
		
		    $sessdata= $this->session->userdata('sms');
			//print_r($sessdata);exit;
		    if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		    }
		    $data['page_title']="Add Attendance";
			//if($sessdata[0]->role_id==2){
				//$data['degrees'] = $this->Discipline_model->get_teacher_degree($sessdata[0]->campus,$userid);
			//}else
			//$data['degrees'] = $this->Discipline_model->get_degree();
            //$data['semesters'] = $this->Generate_model->get_semester(); 
           // $data['batches'] = $this->Discipline_model->get_batches(); 			
			$this->load->view('admin/attendance/add_attendance_view',$data);  
	}
	
	function studentwise_attendance(){
		$sessdata= $this->session->userdata('sms');
			
		if(empty($sessdata)){
		redirect('authenticate', 'refresh');
		}
		$data['page_title']="Student Wise Attendance Report";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		//$data['list'] =='';
		$data['batches'] = $this->Discipline_model->get_batches(); 	
		$this->load->view('admin/attendance/studentwise_attendance',$data); 
	}
	function assign_course_to_teacher(){
		$sessdata= $this->session->userdata('sms');
			
		if(empty($sessdata)){
		redirect('authenticate', 'refresh');
		}
		$data['page_title']="Assign Course to Teacher";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['list'] = $this->Attendance_model->get_course_assigned_teacher_list(); 
		
		//if($sessdata[0]->role_id==2){
			//$data['degrees'] = $this->Discipline_model->get_degree($sessdata[0]->campus);
		//}else
			//$data['degrees'] = $this->Discipline_model->get_degree();
		//$data['semesters'] = $this->Generate_model->get_semester(); 
		$data['batches'] = $this->Discipline_model->get_batches(); 			
		$this->load->view('admin/attendance/assign_course_to_teacher',$data); 
	}
	function getholidays(){
		$degree_id  = $this->input->post('degree_id');
		//if(is_array($degree_id)){
			//$degree_id = implode(",",$degree_id);
		//}
		//echo $degree_id;exit;
		//if($degree_id>0)
				$holidayList = $this->Attendance_model->get_holidays($degree_id);//echo $this->db->last_query();
		echo json_encode($holidayList);
	}
	function getStudentAttendance(){
		$degree_id  = $this->input->post('degree_id');
		$semester_id  = $this->input->post('semester_id');
		$student_id  = $this->input->post('student_id');
		$attendance_date  = $this->input->post('attendance_range');
		$attendance_dateArr = explode(" - ",$attendance_date);
		//print_r($attendance_dateArr);
		$attendance_date_fromArr = explode("-",$attendance_dateArr[0]);
		$attendance_date_toArr = explode("-",$attendance_dateArr[1]);
		$attendance_date_from=$attendance_date_fromArr[2].'-'.$attendance_date_fromArr[1].'-'.$attendance_date_fromArr[0];
		$attendance_date_to=$attendance_date_toArr[2].'-'.$attendance_date_toArr[1].'-'.$attendance_date_toArr[0];
		$attendanceList = $this->Attendance_model->getmyattendance($degree_id,$semester_id,$student_id,$attendance_date_from,$attendance_date_to);
		//echo $this->db->last_query();
		//echo "<pre>";
		//print_r($attendanceList);//exit;
		
		//define variables
		$dates[] = array();
		$presentval	= 0;
		$absentval	= 0;
		$presentvalmale	= 0;
		$absentvalmale	= 0;
		$presentvalfemale	= 0;
		$absentvalfemale	= 0;
		$user['male'] = array();
		$user['female'] = array();
		$n = 0;
		$nmale = 0;
		$nfemale = 0;
		$a =0;
		$totperiods = 8;
		$i=0;
		$m=0;
		$f=0;
		$presentpercent = 0;
		$absentpercent = 0;
		$presentpercentmale = 0;
		$absentpercentmale = 0;
		$presentpercentfemale = 0;
		$absentpercentfemale = 0;
		$nilpercent = 0;
		$nilpercentmale = 0;
		$nilpercentfemale = 0;
		$countstudent = count($student_id);
		
		//calculate attendance
		if($attendanceList != '')
		{
			foreach($attendanceList as $att){
				if (!in_array($att->attendance_date, $dates))
				{
					$dates[$i] = $att->attendance_date;
					$i++;
				}
				if($att->gender == 'male')
				{
					if (!in_array($att->id, $user['male']))
					{
						$user['male'][$m] = $att->id;
						$m++;
					}
					if($att->attendance_status == 'P')
						$presentvalmale++;
					else if($att->attendance_status == 'A')
						$absentvalmale++;
					else
					$nmale++;
					
				}
				if($att->gender == 'female')
				{
					if (!in_array($att->id, $user['female']))
					{
						$user['female'][$f] = $att->id;
						$f++;
					}
					if($att->attendance_status == 'P')
						$presentvalfemale++;
					else if($att->attendance_status == 'A')
						$absentvalfemale++;
					else
					$nfemale++;
				}
				
				//common
				if($att->attendance_status == 'P')
					$presentval++;
				else if($att->attendance_status == 'A')
					$absentval++;
				else
					$n++;
				
			}
			
			array_unique($dates);
			$dtecount = count($dates);
			
			$present = $presentval/8;
			$p = $present/($dtecount*$countstudent);
			$presentpercent = $p*100;
			
			$absent = $absentval/8;
			$a = $absent/($dtecount*$countstudent);
			$absentpercent = $a*100;
			
			$nilpercent = 100-($presentpercent+$absentpercent);
			
			if(count($student_id) > 1)
			{
				if(count($user['male']) > 0)
				{
					//male percent
					
					$presentmale = $presentvalmale/8;
					$pm = $presentmale/($dtecount*(count($user['male'])));
					$presentpercentmale = $pm*100;
					
					$absentmale = $absentvalmale/8;
					$am = $absentmale/($dtecount*(count($user['male'])));
					$absentpercentmale = $am*100;
					
					$nilpercentmale = 100-($presentpercentmale+$absentpercentmale);
				}
				
				if(count($user['female']) > 0)
				{
					$presentfemale = $presentvalfemale/8;
					$pf = $presentfemale/($dtecount*(count($user['female'])));
					$presentpercentfemale = $pf*100;
					
					$absentfemale = $absentvalfemale/8;
					$af = $absentfemale/($dtecount*(count($user['female'])));
					$absentpercentfemale = $af*100;
					$nilpercentfemale = 100-($presentpercentfemale+$absentpercentfemale);
				}
			
			}
			
		}
		
		//exit;
		
		if(count($attendanceList)>0 && count($student_id) <= '1'){
		$table='<table id="example" class="table table-bordered table-hover table-striped table-condensed"><tr  class="thead-light"><th>Date</th>';
		$tablebodyCon='';
		//$tablehead='';
		
		//echo "<pre>";print_r($attendanceList);
		
		
		
		
		for($i=1;$i<=8;$i++){
			$table.='<th style="text-align:center">'.$i.'</th>';
			
		}
		$table.='<th style="text-align:center">Overall</th>';
		$table.='</tr>';
		$dateArr='';
		
		foreach($attendanceList as $k=>$res1){
			$dateArr[$res1->attendance_date][]=$res1;
		}
		//print_r($dateArr);
		//for($i=1;$i<8;$i++){
			//$table.='<th style="text-align:center">'.$res->course_title.'</th>';
			
			$tablebody='';
			$prev_date='';
			
			$overAll['total'] = 0;
			$overAll['present'] = 0;
			$chartArr=[];
			foreach($dateArr as $date=>$res){
				$tablebody='<tr><td>'.$date.'</td>';
				
				$tot = count($res);
				
				$preCnt=0;
				$abCnt=0;
				foreach($res as $k=>$res1){
					if($res1->attendance_status == 'P'){
						$tablebody.='<td style="text-align:center;color:green">Present</td>';
						$preCnt++;
					}elseif($res1->attendance_status == 'A'){
						$tablebody.='<td style="text-align:center;color:red">Absent</td>';
						$abCnt++;
					}else
						$tablebody.='<td style="text-align:center;">N/A</td>';
				}
				$chartArr[$date]['present'] = $preCnt;
				$chartArr[$date]['absent'] = $abCnt;
				$overAll['total']+=$tot;
				$overAll['present']+=$preCnt;
				$tablebody.='<td style="text-align:center;">'.$preCnt.'/'.$tot.'</td>';
				$tablebodyCon.= $tablebody.'</tr>';
			}
			
		//}
		$table.='<tr>';
		$table.=$tablebodyCon;
		$table.='</tr>';
		$table.='<tr><td colspan="9"></td><td style="text-align:center;">'.$overAll['present'].'/'.$overAll['total'].'</td></tr>';
		
		$table.='</table>';
		$table.="<script>

google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMultSeries);

function drawMultSeries() {
      var data = google.visualization.arrayToDataTable([
        ['Date', 'Present', 'Absent'],";
		$datastr='';
		foreach($chartArr as $date=>$res){
			$datastr.="['$date', $res[present], $res[absent]],";
		}
        $datastr = rtrim($datastr,',');
     $table.=$datastr." ]);
	  

      var options = {
        title: 'Student Wise Attendance Report',
        chartArea: {width: '50%'},
        hAxis: {
          title: 'Attendance',
          minValue: 0
        },
        vAxis: {
          title: 'Date'
        }
      };

      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }

	</script>";
 $table.='<div id="chart_div"></div>';
 
		//echo $table;
		}else{
			if(count($student_id) <= '1')
				$table='<table id="example" class="table table-bordered table-hover table-striped table-condensed"><tr  class="thead-light"><th>No Data Found</th></tr></table>';
			else
				$table='';
		}
		
		$attendance['table'] = $table;
		$attendance['present'] = $presentpercent;
		$attendance['absent'] = $absentpercent;
		$attendance['presentmale'] = $presentpercentmale;
		$attendance['absentmale'] = $absentpercentmale;
		$attendance['presentfemale'] = $presentpercentfemale;
		$attendance['absentfemale'] = $absentpercentfemale;
		$attendance['nil'] = $nilpercent;
		$attendance['nilmale'] = $nilpercentmale;
		$attendance['nilfemale'] = $nilpercentfemale;
		//print_r($attendance);
		//echo $this->db->last_query();
		echo json_encode($attendance);
		
		//echo $this->db->last_query();
	}
	function getStudentByIds(){
		$degree_id  = $this->input->post('degree_id');
		$semester_id  = $this->input->post('semester_id');
		//$student_id  = $this->input->post('student_id');
		$batch_id  = $this->input->post('batch_id');
		$course_id  = $this->input->post('course_id');
		$attendanceList = $this->Attendance_model->get_student_attendance($degree_id,$semester_id,$course_id,$batch_id);
		$str = '';
         foreach($attendanceList as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->first_name.' '.$v->last_name."</option>";
           }
		   
           echo $str;
	}
	
	function attendanceRangeView(){
		$degree_id  = $this->input->post('degree_id');
		$semester_id  = $this->input->post('semester_id');
		$student_id  = $this->input->post('student_id');
		$attendance_date  = $this->input->post('attendance_date');
		$attendance_dateArr = explode(" - ",$attendance_date);
		//print_r($attendance_dateArr);
		$attendance_date_fromArr = explode("-",$attendance_dateArr[0]);
		$attendance_date_toArr = explode("-",$attendance_dateArr[1]);
		
		$period = new DatePeriod(
			new DateTime($attendance_dateArr[0]),
			new DateInterval('P1D'),
			new DateTime($attendance_dateArr[1])
		);
		//print_r($period);exit;
		$attendance_date_from=$attendance_date_fromArr[2].'-'.$attendance_date_fromArr[1].'-'.$attendance_date_fromArr[0];
		$attendance_date_to=$attendance_date_toArr[2].'-'.$attendance_date_toArr[1].'-'.$attendance_date_toArr[0];
		$dataChart='';
		$p = 0;
			$a = 0;
			//$attendance_date=$this->input->post('attendance_date');
			
			$sessdata= $this->session->userdata('sms');
			$userid = $sessdata[0]->id;
			//if($degree_id>0 && $student_id>0 && $attendance_date!=''){
			$attendanceList = $this->Attendance_model->getmyattendance($degree_id,$semester_id,$student_id,$attendance_date_from,$attendance_date_to);
			//echo $this->db->last_query();
			
			$attendanceArr='';
			foreach($attendanceList as $att){
				$attendanceArr[$att->attendance_date][] = $att;
			}
			$table='<table id="example" class="table table-bordered table-hover table-striped table-condensed">';
				$tablebodyCon='';
				
				$i=0;
				//print_r($period);exit;
			//foreach($attendanceArr as $date=>$resAtt){
				foreach ($period as $key => $value) {
					
					//$dateArr = explode("-",$attendance_date);
					//$attendance_date = $dateArr[2].'-'.$dateArr[1].'-'.$dateArr[0];
				
				//print_r($resAtt);exit;
				$date = $value->format('Y-m-d');
				$day =  date('N', strtotime($date))-1;
				$date_str =  date('d-m-Y', strtotime($date));
				$result=$this->Attendance_model->get_holidays($degree_id,$date);
				//echo $this->db->last_query();exit;
				if(count($result)==0){
					$timeTableList = $this->Attendance_model->gettimeTable($degree_id,$semester_id,$day);//echo $this->db->last_query();exit;
					
						//$tablehead='';
						if($i == 0){
							$table.='<tr  class="thead-light"><th>Date</th>';
							foreach($timeTableList as $res){
								$table.='<th style="text-align:center">'.$res->from.'</th>';
								
							}
							$table.='</tr>';
						}
						$table.='<tr  class="thead-light"><th style="vertical-align:middle" class="info" rowspan="2" nowrap>'.$date_str.'</th>';
						$p=0;
						$a=0;
						$na=0;
						$atten_row='';
						foreach($timeTableList as $res){
							$table.='<th style="text-align:center">'.$res->course_title.'</th>';
							$attendance_col='';
							$attendanceList = $this->Attendance_model->getmyattendance($degree_id,$semester_id,$student_id,$date);
							if(count($attendanceList)>0){
								foreach($attendanceList as $res1){
									$dataChart[$date_str]['na']=0;
									if($res->course_id == $res1->course_id && $res->from == $res1->attendance_period && $res1->attendance_status == 'P'){
										$attendance_col='<td style="text-align:center;color:green">Present</td>';
										$p++;
										$dataChart[$date_str]['pass']=$p;
									}elseif($res->course_id == $res1->course_id  && $res->from == $res1->attendance_period && $res1->attendance_status == 'A'){
										$attendance_col='<td style="text-align:center;color:red">Absent</td>';
										$a++;
										$dataChart[$date_str]['fail']=$a;
									}
								}
							}else{
								$dataChart[$date_str]['pass']=0;
								$dataChart[$date_str]['fail']=0;
							}
							if($attendance_col==''){
								$attendance_col='<td style="text-align:center;">N/I</td>';
								$na++;
								$dataChart[$date_str]['na']=$na;
							}
								
							$atten_row.=$attendance_col;
						}
						$i++;
						$table.='</tr>';
						$table.='<tr  class="thead-light">'.$atten_row;
						
					
						$table.='</tr>';
					}else{
						$table.='<tr  class="thead-light"><th style="vertical-align:middle" class="info"  nowrap>'.$date_str.'</th><th style="text-align:center;color:red"  colspan="8">'.$result[0]->name.'</th></tr>';
					}
				
			}
			$attendance['table'] = $table;
			$attendance['present'] = $p;
			$attendance['absent'] = $a;
			$attendance['datewise'] = $dataChart;
			//print($attendance);
			//echo $this->db->last_query();
			echo json_encode($attendance);
	}
	function getmyattendance(){
		$degree_id  = $this->input->post('degree_id');
		$semester_id  = $this->input->post('semester_id');
		$student_id  = $this->input->post('student_id');
		$attendance_date  = $this->input->post('attendance_date');
		$type  = $this->input->post('type');
		if($type == 'range'){
			$this->attendanceRangeView();
		}else{
			$p = 0;
			$a = 0;
			$na = 0;
			//$attendance_date=$this->input->post('attendance_date');
			$day =  date('N', strtotime($attendance_date))-1;
			$sessdata= $this->session->userdata('sms');
			$userid = $sessdata[0]->id;
			//if($degree_id>0 && $student_id>0 && $attendance_date!=''){
			$attendanceList = $this->Attendance_model->getmyattendance($degree_id,$semester_id,$student_id,$attendance_date);
			//echo $this->db->last_query();
			$timeTableList = $this->Attendance_model->gettimeTable($degree_id,$semester_id,$day);//echo $this->db->last_query();exit;
					//p($timeTableList);
					//p($attendanceList);exit;
			//}
			
			$table='<table id="example" class="table table-bordered table-hover table-striped table-condensed"><tr  class="thead-light">';
			$tablebodyCon='';
			//$tablehead='';
			foreach($timeTableList as $res){
				$table.='<th style="text-align:center">'.$res->from.'</th>';
				
			}
			$table.='</tr><tr  class="thead-light">';
			$atten_row='';
			foreach($timeTableList as $res){
				$table.='<th style="text-align:center">'.$res->course_title.'</th>';
				$attendance_col='';
				foreach($attendanceList as $res1){
					if($res->course_id == $res1->course_id && $res->from == $res1->attendance_period && $res1->attendance_status == 'P'){
						$attendance_col='<td style="text-align:center;color:green">Present</td>';
						$p++;
					}elseif($res->course_id == $res1->course_id  && $res->from == $res1->attendance_period && $res1->attendance_status == 'A'){
						$attendance_col='<td style="text-align:center;color:red">Absent</td>';
						$a++;
					}
				}
				if($attendance_col==''){
					$attendance_col='<td style="text-align:center;">N/I</td>';
					$na++;
				}
					
				$atten_row.=$attendance_col;
			}
			$table.='</tr><tr>'.$atten_row;
			
				
			
			$table.='</tr></table>';
			$attendance['table'] = $table;
			$attendance['present'] = $p;
			$attendance['absent'] = $a;
			$attendance['na'] = $na;
			//print($attendance);
			//echo $this->db->last_query();
			echo json_encode($attendance);
		}
	}
	function getSundays($y){
		for($m=1;$m<=12;$m++){
			$date = "$y-$m-01";
			$first_day = date('N',strtotime($date));
			$first_day = 7 - $first_day + 1;
			$last_day =  date('t',strtotime($date));
			$days = array();
			for($i=$first_day; $i<=$last_day; $i=$i+7 ){
				 $days[] = $i;
				$mon = sprintf("%02d",$m);
				$day = sprintf("%02d",$i);
				echo "(1,'Weekly Off','$y-$mon-$day','$y-$mon-$day'),<br>";
			}
		}
		return  $days;
	}
	function holidaylist(){
		//$days = $this->getSundays(2019);exit;
		 $sessdata= $this->session->userdata('sms');
        $data['campuses'] = $this->Discipline_model->get_campus();
        if(empty($sessdata)){
		redirect('authenticate', 'refresh');
		}
		if($sessdata[0]->role_id==2){
			$data['degrees'] = $this->Discipline_model->get_degree(@$sessdata[0]->campus);
		}else
			$data['degrees'] = $this->Discipline_model->get_degree();
		$data['page_title']="Holiday List";
		$data['managelist']="0";
		$this->load->view('admin/attendance/manageholidays',$data);  
	}
	function manage_timetable(){
		$sessdata= $this->session->userdata('sms');
			
		    if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		    }
		    $data['page_title']="Attendance Timetable";
			if($sessdata[0]->role_id==2){
				$data['degrees'] = $this->Discipline_model->get_degree($sessdata[0]->campus);
			}else
			$data['degrees'] = $this->Discipline_model->get_degree();
		$data['campuses'] = $this->Discipline_model->get_campus(); 
            $data['semesters'] = $this->Generate_model->get_semester(); 
            $data['batches'] = $this->Discipline_model->get_batches(); 			
			$this->load->view('admin/attendance/manage_timetable',$data);  
		
	}
	function manageholidays($degree='')
	{
	
		    $sessdata= $this->session->userdata('sms');
			
		    if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		    }
		    $data['page_title']="Manage Holiday";
            $data['campuses'] = $this->Discipline_model->get_campus();
			//$data['degrees'] = $this->Discipline_model->get_degree();
			$data['managelist']="1";
			
			$this->load->view('admin/attendance/manageholidays',$data);  
	}
	function saveholidays(){
		$data = $_POST;
		$degree_id  = $this->input->post('degree_id');
		if(is_array($degree_id)){
			//$degree_id = implode(",",$degree_id);
			foreach($degree_id as $key=>$val){
				$id = $this->Attendance_model->save_holidays($val,$data);
			}
		}else	
			$id = $this->Attendance_model->save_holidays($degree_id,$data);
		echo $id;
	}
	function deleteholiday($id){
		$degree_id  = $this->input->post('degree_id');
		if(is_array($degree_id)){
			$degree_id = implode(",",$degree_id);
		}
		$save = $this->Attendance_model->delete_holidays($degree_id,$id);
		return true;
	}
	function getCourseByPDS()
	{
		//echo "hello"; exit;
		$program_id = $this->input->post('program_id');
		$degree_id  = $this->input->post('degree_id');
		$semester_id  = $this->input->post('semester_id');
		$data['course']=$this->Attendance_model->get_course_by_pds($program_id,$degree_id,$semester_id); 
		//print_r($data['doc']); exit;
		 $str = '';
         foreach($data['course'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->course_title."</option>";
           }
		   
           echo $str;

	}
	function get_teacher()
	{
		//echo "hello"; exit;
		
		$campus_id  = $this->input->post('campus_id');
		$data['teacher']=$this->Discipline_model->get_teacher($campus_id); 
		//print_r($data['doc']); exit;
		 $str = '';
         foreach($data['teacher'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->first_name.' '.$v->last_name."</option>";
           }
		   
           echo $str;

	}
	
	function getStudentAssignByCourse()
	{
		
		$sessdata= $this->session->userdata('sms');
		$teacher_id = $sessdata[0]->id;
		$degree_id=$this->input->post('degree_id');
		$semester_id=$this->input->post('semester_id');
		$batch_id=$this->input->post('batch_id');
		$course_id=$this->input->post('course_id');
		$course_id=$this->input->post('course_id');
		$attendance_date=$this->input->post('attendance_date');
		$day =  date('N', strtotime($attendance_date))-1;
		$day_string =  date('l', strtotime($attendance_date));
		$trdata='';
		if($degree_id>0 && $semester_id>0 && $batch_id>0 && $course_id>0){
		
	    $send['degree_id']=$degree_id;
	    $send['semester_id']=$semester_id;
	    $send['batch_id']=$batch_id;
	    $send['course_id']=$course_id;
	    $List= $this->Attendance_model->get_time_table_from_to($course_id,$degree_id,$semester_id,$day);
		//echo $this->db->last_query();
	    $studentList= $this->Attendance_model->get_student_assign_by_course($send);
	   $dateArr = explode("-",$attendance_date);
			$attendance_date_sys= $dateArr[2].'-'.$dateArr[1].'-'.$dateArr[0];
	
		
			$i=0;
			if(isset($List[0]->start)){
			foreach($studentList as $students)
			{
				
				$i++;
				$checked = 'checked';
				
				$trdata.='<tr>
				      
						<td>'.$i.'</td>
						<td><input type="hidden"  name="student_id[]" value="'.$students->user_id.'">'.$students->user_unique_id.'</td>
						
						<td>'.$students->first_name.' '.$students->last_name.'</td>
						<td ><table width="100%" style=""><thead><tr>';
						for($k=$List[0]->start;$k<$List[0]->end;$k++){
							$trdata.='<th style="text-align:center;border:1px solid">'.$k.'</th>';
						}
						$trdata.='</tr></thead><tbody><tr >';
						for($j=$List[0]->start;$j<$List[0]->end;$j++){
							$existArr= $this->Attendance_model->get_student_existing_rec($course_id,$degree_id,$semester_id,$students->user_id,$j,$attendance_date_sys);
							//p($existArr);exit;
							if(isset($existArr[0]->attendance_status)){
								if($existArr[0]->attendance_status == 'A'){
									$absent_check = 'checked="checked"';
									$absent_label = ' btn-off active ';
									$present_label = ' btn-on ';
									$present_check = '';
								}else{
									$absent_check = '';
									$present_check = 'checked="checked"';
									
									$absent_label = ' btn-off ';
									$present_label = ' btn-on active  ';
								}
							}else{
								$absent_check = '';
								$present_check = 'checked="checked"';
								$absent_label = ' btn-off ';
									$present_label = ' btn-on active  ';
							}
						$trdata.='<td style="text-align:center;border:1px solid"><!--<input type="checkbox" class="checkbox" id="attendance" name="attendance['.$students->user_id.']"  value="1"/>-->
						 <div class="btn-group" id="status" data-toggle="buttons">
              <label class="btn btn-default '.$present_label.'">
              <input type="radio" value="1" class="attendance_on" name="attendance['.$students->user_id.']['.$j.']" '.$present_check.'>Present</label>
              <label class="btn btn-default '.$absent_label.'">
              <input type="radio" value="0" class="attendance_off" name="attendance['.$students->user_id.']['.$j.']" '.$absent_check.'>Absent</label>
            </div></td>';
						}
						
						$trdata.='</tr><tbody></table></td>
						
						
						
						
					</tr>';
				}
			}else
				$trdata.='<tr><td>There is no course assigned on '.$day_string.'</td></tr>';
			echo $trdata; 
		}else
			echo $trdata; 
	}
	function getCourseByIds()
	{
		//print_r($_POST); exit;
		$campus_id = $this->input->post('campus_id');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$batch_id = $this->input->post('batch_id');
		$semester_id = $this->input->post('semester_id');
		$discipline_id = $this->input->post('discipline_id');
		
		$data['courses']=$this->Marks_model->get_course_by_ids($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id); 
		//print_r($data['programs']); exit;
		$str = '';
         foreach($data['courses'] as $k=>$v){ 
           $str .= "<option value=".$v->id.">".$v->course_code.'-'.$v->course_title."</option>";
           }
		   echo $str;
	}
	function saveAssignCourse(){
		//echo "<pre>";print_r($_POST);exit;
		$degree_id=$this->input->post('degree_id');
		$program_id=$this->input->post('program_id');
		$semester_id=$this->input->post('semester_id');
		$batch_id=$this->input->post('batch_id');
		$discipline_id=$this->input->post('discipline_id');
		$course_id=$this->input->post('course_id');
		$campus_id=$this->input->post('campus_id');
		$teacher_id=$this->input->post('teacher_id');
		foreach($teacher_id as $teacher){
			foreach($course_id as $course){
				$attendanceArr = array(
					  'campus_id'=>$campus_id,
					  'program_id'=>$degree_id,
					  'degree_id'=>$semester_id,
					  'batch_id'=>$batch_id,
					  'semester_id'=>$semester_id,
					  'discipline_id'=>$discipline_id,
					  'course_id'=>$course,
					  'teacher_id'=>$teacher
				);
				$save = $this->Attendance_model->saveAssignCourse($attendanceArr);
			}
		}
		 $this->session->set_flashdata('message', 'Course assigned successfully');
	    redirect('attendance/assign_course_to_teacher');
	}
	function deleteassigncourse($id){
		
		$schedulerList = $this->Attendance_model->deleteassigncourse($id);
		$this->session->set_flashdata('message', 'deleted successfully');
	    redirect('attendance/assign_course_to_teacher');
	}
	function saveAttendance()
	{
		
		
		$sessdata= $this->session->userdata('sms');
		if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		}
		$register_date_time=date('Y-m-d H:i:s');
		
		$login_user_id=$this->input->post('login_user_id');
		$login_user_type=$this->input->post('login_user_type');
		
		$degree_id=$this->input->post('degree_id');
		$semester_id=$this->input->post('semester_id');
		$batch_id=$this->input->post('batch_id');
		$course_id=$this->input->post('course_id');
		$student_ids=$this->input->post('student_id');//array input
		$attendances=$this->input->post('attendance');//array input
		$return='';
		$attendance_date=$this->input->post('attendance_date');
		/*$attendance_type=$this->input->post('attendance_type');
		$attendance_range=$this->input->post('attendance_range');
		$attendance_periodic=$this->input->post('attendance_periodic');
		if($attendance_type == 2 || $attendance_type == 3){ 
			if($attendance_type == 2)
				$dataArr = explode("/",str_replace(" - ","/",$attendance_range));
			elseif($attendance_type == 3)
				$dataArr = explode("/",str_replace(" - ","/",$attendance_periodic));
				
			$beginArr = explode("-",$dataArr[0]);
			$endArr = explode("-",$dataArr[1]);
			$begin_date = $beginArr[2].'-'.$beginArr[1].'-'.$beginArr[0];
			$end_date = $endArr[2].'-'.$endArr[1].'-'.$endArr[0];
			$begin = new DateTime($begin_date  );
			$end = new DateTime($end_date);
			$end = $end->modify( '+1 day' ); 

			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval ,$end);
			//p($daterange);
			foreach($daterange as $date){
				$date_result_array[] = $date->format("Y-m-d");
			}
		}else{*/
			$dateArr = explode("-",$attendance_date);
			$attendance_date = $dateArr[2].'-'.$dateArr[1].'-'.$dateArr[0];
		//}
		
		
		//p($find_current_date); exit;
		//p(count($find_current_date)); exit;
		
			//echo "hello"; exit;
			//foreach($date_result_array as $key=>$attendance_date){
				$result=$this->Attendance_model->get_holidays($degree_id,$attendance_date);
					//echo $this->db->last_query();
					
					if(count($result)==0){
						//echo "coming";
						for($i=0,$j=1; $i<count($student_ids);$i++,$j++)
						{
							$student_id=$student_ids[$i];
							
								
								
								
								if(isset($attendances[$student_id])){
									foreach($attendances[$student_id] as $period=>$pass_fail){
										
										$result=$this->Attendance_model->find_attendance_date($attendance_date,$degree_id,$semester_id,$batch_id,$course_id,$student_id,$period);
										//p($attendances[$student_id]);
										//p($_POST);exit;
										if($pass_fail == 1)
											$attendance='P';
										else
											$attendance='A';
										$attendanceArr = array(
											  'student_id'=>$student_id,
											  'degree_id'=>$degree_id,
											  'semester_id'=>$semester_id,
											  'batch_id'=>$batch_id,
											  'course_id'=>$course_id,
											  'attendance_status'=>$attendance,
											  'attendance_date'=>$attendance_date,
											  'attendance_period'=>$period,
											  'login_user_id'=>$login_user_id
										);
										//p($attendanceArr);
									if(empty($result ) || count($result)==0)
									{
										$save = $this->Attendance_model->save_student_attendance($attendanceArr);
											
									}else{
										$save = $this->Attendance_model->save_student_attendance($attendanceArr,$result[0]->id);
									}
									//echo $this->db->last_query();
									}
								}
							}
							echo 1;
					}else{
						echo 'This date is marked in holiday list as a '.$result[0]->name;
					}
			//}
		
	}
	
	function viewProcess(){
			$sessdata= $this->session->userdata('sms');
			if(empty($sessdata)){
				redirect('authenticate', 'refresh');
			}
		    $data['page_title']="Process Details";
			$this->load->view('admin/profile/student_page_view',$data);  
		
	}
	function sendFeedback()
	{
		//p($_POST); exit;
		$register_date_time=date('Y-m-d H:i:s');
		//echo "hello"; exit;
		$sessdata= $this->session->userdata('sms');
		//p($sessdata); exit;
	    $id = $sessdata[0]->id;
		$role_id = $sessdata[0]->role_id;
		$campus_id = $sessdata[0]->campus_id;
		$feedback_subject=$this->input->post('feedback_subject');
		$feedback_message=$this->input->post('feedback_message');
		
		$save['subject']=$feedback_subject;
		$save['message']=$feedback_message;
		$save['sender_id']=$id;
		$save['sender_type']=$role_id;
		$save['sender_campus']=$campus_id;
		$save['created_on']=$register_date_time;
		//p($save); exit;
		$data = $this->Process_model->save_process($save);
		if(!empty($data)){ echo 1;}else{echo 0;}
		
		
	}
	

}
?>