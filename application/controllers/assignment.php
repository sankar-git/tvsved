<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assignment extends CI_Controller {
	
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
		 $this->load->model('pagination_model');
		 $this->load->library('encrypt');
		 $this->load->helper('url');
		 $this->load->helper('form');
		 $this->load->library('form_validation');
		 $this->load->library('email');
		 $this->load->model('fees_model');
		 $this->load->library('image_lib');
		 $this->load->helper('email');
		 $this->load->model('common_model');
		 $this->load->library('excel');
		 
		 
		 $this->load->model('Discipline_model');
		 $this->load->model('Master_model');
		 $this->load->model('Assign_model');
		 $sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }

			/*if($this->session->userdata('sms'))
			{
				$session_data = $this->session->userdata('sms');
				if(isset($session_data[0]))
				{
					$session_data=$session_data[0];
					$this->user_name = $session_data->username;
					$this->user_fullname = $session_data->first_name.' '. $session_data->last_name;
					$this->user_role = $session_data->role_id;
					$this->user_email =$session_data->email;
					$this->user_id = $session_data->id;
				}
				if($this->user_role!=0)
				{
					$this->load->library('permission_lib');
					$this->permission_lib->permit($this->user_id,$this->user_role);
				}
			}
			else
			{
				redirect('authenticate', 'refresh');
			}*/
	}

	public function index()
	{
	if($this->user_role!=1)
		{
			$this->load->library('permission_lib');
			$this->permission_lib->permit($this->user_id,$this->user_role);
		}
		$data['class']= $this->common_model->getAllClasses();
		@$data['state'] = $this->common_model->get_state();
		

		$data['roles']=$this->common_model->getAllRoles();
		
		$data['country']=$this->common_model->get_country();
		$data['city']=$this->common_model->get_city();
		$data['state']=$this->common_model->get_state();
		
		$data['max_id']				= 	$this->common_model->max_id('tbl_student','student_id');

		$this->load->view('admin/template/admin_header');
		$this->load->view('admin/template/admin_leftmenu');
		$this->load->view('admin/addstudent_view',$data);
		$this->load->view('admin/template/admin_footer');	
	}
	
   
	function saveCourseGroup()
	{
		$register_date_time=date('Y-m-d H:i:s');
		$course_group_code = $this->input->post('course_group_code');
		$course_group_name = $this->input->post('course_group_name');
		
		$save['course_group_code']=$course_group_code;
		$save['course_group_name']=$course_group_name;
		$save['created_on']=     $register_date_time;
		
		$data= $this->Master_model->save_course_group($save);
		$this->session->set_flashdata('message', 'Course group added successfully');
	    redirect('course/listCourseGroup');
		
	}
    
	
	
	
	
	function getDegreebyProgram()
	{
		$program_id = $this->input->post('program_id');
		$data['degrees']=$this->Master_model->get_degree_by_program_id($program_id); 
		 $str = '';
         foreach($data['degrees'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->degree_name."</option>";
           }
		   
           echo $str;
         
	}
	function getSyllabusYearbyProgram()
	{
		$program_id = $this->input->post('program_id');
		$data['syllabus_year']=$this->Master_model->get_syllabus_year_by_program_id($program_id); 
		 $str = '';
         foreach($data['syllabus_year'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->syllabus_year."</option>";
           }
		   
           echo $str;
	}
	function getProgramByCampusId()
	{
		$campus_id = $this->input->post('campus_id');
		$data['programs']=$this->Master_model->get_program_by_campus_id($campus_id); 
		 $str = '';
         foreach($data['programs'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->program_name."</option>";
           }
		   
           echo $str;
	}
	function getSemesterByDegree()
	{
		$degree_id = $this->input->post('degree_id');
		$data['semesters']=$this->Master_model->get_semester_by_degree_id($degree_id); 
		//print_r($data['semesters']); exit;
		 $str = '';
         foreach($data['semesters'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->semester_name."</option>";
           }
		   
           echo $str;
	}
	function getBatchByDegreeId()
	{
		$degree_id = $this->input->post('degree_id');
		$data['batches']=$this->Master_model->get_batch_by_degree_id($degree_id); 
		//print_r($data['batches']); exit;
		 $str = '';
         foreach($data['batches'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->batch_name."</option>";
           }
		   
           echo $str;
	}
	function getStudentByDegreeCampusBatch()
	{
		$batch_id = $this->input->post('batch_id');
		//dd($batch_id); 
		$data['students']=$this->Master_model->get_student_by_batch_id($batch_id); 
		//print_r($data['students']); exit;
		 $sid='00';
		 $str = '';
         foreach($data['students'] as $k=>$v){ 
           
          $str .= "<option value=".$v->id.">".$v->first_name.' '.$v->last_name.'('.$sid.''.$v->id.')'."</option>";
           }
		   
           echo $str;
	}
	
	function getStudentByDegreeCampusBatchAndSemester() //get student list for course assignment
	{
		//print_r($_POST);
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$batch_id=$this->input->post('batch_id');
		$semester_id=$this->input->post('semester_id');
		
		$send['campus_id']=$campus_id;
		$send['program_id']=$program_id;
		$send['degree_id']=$degree_id;
		$send['batch_id']=$batch_id;
		$send['semester_id']=$semester_id;
		$data['students']=$this->Master_model->get_student_by_degree_campus_batch_semester($send); //get student dropdown
		
		//print_r($data['students']); exit;
		 $sid='00';
		 $str = '';
         foreach($data['students'] as $k=>$v){ 
           
          $str .= "<option value=".$v->id.">".$v->first_name.' '.$v->last_name.'('.$sid.''.$v->id.')'."</option>";
           }
		   
           echo $str;
	}
	

	//========Student course assignment start===========//
	function studentCourseAssignment()
	{
		$data['page_title']="Bulk Approve Course To Student";
		$data['campuses'] = $this->Discipline_model->get_campus();
		$data['batches'] = $this->Discipline_model->get_batch();
		$data['disciplines'] = $this->Discipline_model->get_discipline();
		$data['courses'] = $this->Discipline_model->get_course();
		//p($data['courses']); exit;
	    $this->load->view('admin/student_bulk_course_assignment_view',$data);
		
	}
	
	
	function getSelectedCourse()
	{
		$data['page_title']="Student Course Assignment";
		$assign_type=$this->input->get('assign_type');
		
		$campus_id=$this->input->get('campus_id');
		$program_id=$this->input->get('program_id');
		$degree_id=$this->input->get('degree_id');
		$batch_id=$this->input->get('batch_id');
		$semester_id=$this->input->get('semester_id');
		$student_id=$this->input->get('student_id');
		$registered=$this->input->get('registered');
		$notregistered=$this->input->get('notregistered');
		$send['student_id']=$student_id;
		$send['campus_id']=$campus_id;
		$send['program_id']=$program_id;
		$send['degree_id']=$degree_id;
		$send['batch_id']=$batch_id;
		$send['semester_id']=$semester_id;
		$send['assign_type']=$assign_type;
		if($registered=='Registered')
		{
		 $data['assign_view'] = $this->Master_model->get_student_assigned_courses($send);
		 $this->load->view('admin/student_course_assignment_view',$data);
		}
	    if($notregistered=='Not_Registered'){
			//echo "hello"; exit;
			$data['course_list'] = $this->Master_model->get_student_course_list($send);
			//dd($data['course_list']);
		    $this->load->view('admin/student_course_assignment_view',$data);
		}
		if($this->input->get('assign'))
		{
			echo "hello";
		}
		
		
		
		
	}
	function saveStudentAssignedCourse()
	{
		$courseArr =array();
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$batch_id=$this->input->post('batch_id');
		$semester_id=$this->input->post('semester_id');
		$student_id=$this->input->post('student_id');
		$status_id=$this->input->post('status_id');
		$courses=$this->input->post('course_id');
		//$courseArr = $this->Master_model->get_student_assigned_course_ids($student_id);
		//dd($courseArr); 
		$this->Master_model->delete_student_course_list($student_id);
		 for($i=0;$i<count($courses);$i++){
				$course_id=$courses[$i];
				 $data=array(
				    'campus_id'=>$campus_id,
					'program_id'=>$program_id,
					'degree_id'=>$degree_id,
					'batch_id'=>$batch_id,
					'semester_id'=>$semester_id,
					'student_id'=>$student_id,
					'course_id'=>$course_id
					
					);
				//print_r($data);
				//
				$this->Master_model->save_student_course_list($data);
			} //exit;
		$this->session->set_flashdata('message', 'Courses Assigned  saved successfully');
		 redirect('course/assignCourseList');
	}
	
	function object_to_array($object) {
    return (array) $object;
}
	function get_selected_student_course_list()
	{
		//print_r($_POST); exit;
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$batch_id=$this->input->post('batch_id');
		$semester_id=$this->input->post('semester_id');
		$student_id=$this->input->post('student_id');
		$status_id=$this->input->post('status_id');
	    $send['campus_id']=$campus_id;
	    $send['program_id']=$program_id;
	    $send['degree_id']=$degree_id;
	    $send['batch_id']=$batch_id;
	    $send['semester_id']=$semester_id;
	    $send['student_id']=$student_id;
	    $send['status_id']=$status_id;
		if($status_id=='2')
		{
	    //$studentCourse= $this->Master_model->get_assigned_course_id_by_student($student_id);
		//dd($studentCourse); 
		$courselist= $this->Master_model->get_student_course_list($send);
		
		//print_r($courselist); exit;
		$trdata='';
			$i=0;
			     //$status= array();
				 $statusArr= $this->Master_model->get_assign_course_row($student_id);
			   // $array = json_decode(json_encode($statusArr), true);
				//print_r($array); exit;
				//$status = (array)$statusArr;
			//echo '<pre>';
			 //   print_r($statusArr); exit;
			 //  echo '</pre>';
			   $myArr=array();
			   foreach($statusArr as $value)
			   {
				   $c_id=$value->course_id;
				   array_push($myArr,$c_id);
				  // print_r($myArr);
				   
				 //  echo '<pre>';
			   // print_r($myArr);
			 //echo '</pre>';
			   } //exit;
			//$sttt=array('7','8','9','10','11');
				//print_r($sttt); exit;
			foreach($courselist as $courses)
			{
				
				 if(in_array($courses->id,$myArr))
				 {
					 $checked='checked';
				 }
				 else{
					$checked=''; 
				 }
				$i++;
				$trdata.='<tr>
				      <td><input type="checkbox" name="course_id[]" value="'.$courses->id.'" '.$checked.'></td>
						<td>'.$i.'</td>
						<td>'.$courses->course_code.'</td>
						<td>'.$courses->course_title.'</td>
						<td>'.$courses->theory_credit.'</td>
						<td>'.$courses->practicle_credit.'</td>
						
						
					</tr>';
			}
			echo $trdata; 
		}
		if($status_id=='1')
		{
		$student_courselist= $this->Master_model->get_student_registered_course_list($send);
		//print_r($courselist); exit;
		
		$trdata='';
			$i=0;
			foreach($student_courselist as $courses)
			{
				$i++;
				$checked = 'checked';
				$trdata.='<tr>
				        <td><input type="checkbox" name="course_id[]" value="'.$courses->id.'" '.$checked.'></td>
						<td>'.$i.'</td>
						<td>'.$courses->course_code.'</td>
						<td>'.$courses->course_title.'</td>
						<td>'.$courses->theory_credit.'</td>
						<td>'.$courses->practicle_credit.'</td>
						
						
						
					</tr>';
			}
			echo $trdata; 
		
		}
		
	}
	
	
	function saveStudentCourse()
	{
	    $courseArr =array();
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$batch_id=$this->input->post('batch_id');
		$semester_id=$this->input->post('semester_id');
		$student_id=$this->input->post('student_id');
		$status_id=$this->input->post('status_id');
		$courses=$this->input->post('course_id');
		//$courseArr = $this->Master_model->get_student_assigned_course_ids($student_id);
		//dd($courseArr); 
		if($status_id==1)
		{
		 $this->Master_model->delete_student_course_list($student_id);
		
		 for($i=0;$i<count($courses);$i++){
				$course_id=$courses[$i];
				 $data=array(
				    'campus_id'=>$campus_id,
					'program_id'=>$program_id,
					'degree_id'=>$degree_id,
					'batch_id'=>$batch_id,
					'semester_id'=>$semester_id,
					'student_id'=>$student_id,
					'course_id'=>$course_id
					
					);
				//print_r($data);
				//
				$this->Master_model->save_student_course_list($data);
			} //exit;
			}
			
			if($status_id==2)
			{     
          		$this->Master_model->delete_student_course_list($student_id);
		         
				 for($i=0;$i<count($courses);$i++){
					
					// $inserted_course_id = $this->Master_model->get_save_course_by_student($course_id);
				    
				  $course_id=$courses[$i];
				  $data=array(
				    'campus_id'=>$campus_id,
					'program_id'=>$program_id,
					'degree_id'=>$degree_id,
					'batch_id'=>$batch_id,
					'semester_id'=>$semester_id,
					'student_id'=>$student_id,
					'course_id'=>$course_id
					
					);
			//print_r($data);
				   $this->Master_model->save_student_course_list($data);
			     } 
			}
	}
	
	function get_courseby_discipline()
	{
		$discipline_id = $this->input->post('discipline_id');
		$data['courses']=$this->Master_model->get_course_by_discipline($discipline_id); 
		$str = '';
         foreach($data['courses'] as $k=>$v){ 
           
          $str .= "<option value=".$v->id.">".$v->course_title.'('.$v->course_code.')'."</option>";
           }
		   
           echo $str;
		
	}
	function getStudentListByCourse()
	{
		//print_r($_POST); exit;
		$ccampus_id=$this->input->post('ccampus_id');
		$pprogram_id=$this->input->post('pprogram_id');
		$ddegree_id=$this->input->post('ddegree_id');
		$bbatch_id=$this->input->post('bbatch_id');
		$ssemester_id=$this->input->post('ssemester_id');
		$discipline_id=$this->input->post('discipline_id');
		$course_id=$this->input->post('course_id');
	    $send['campus_id']=$ccampus_id;
	    $send['program_id']=$pprogram_id;
	    $send['degree_id']=$ddegree_id;
	    $send['batch_id']=$bbatch_id;
	    $send['semester_id']=$ssemester_id;
	    $send['discipline_id']=$discipline_id;
	    $send['course_id']=$course_id;
		
		$studentList= $this->Master_model->get_students_list_by_course($send);
	//print_r($studentList); exit;
	
		$trdata='';
			$i=0;
			foreach($studentList as $students)
			{
				if($students->course_type=='1')
				{
					$course_type='FT';
				}
				else{
					$course_type='PT';
				}
				$i++;
				$checked = 'checked';
				$trdata.='<tr>
				      <td><input type="checkbox" name="student_id[]" value="'.$students->user_id.'" '.$checked.'></td>
						<td>'.$i.'</td>
						<td>'.$students->user_id.' '.'('.$course_type.')'.'</td>
						<td>'.$students->first_name.' '.$students->last_name.'</td>
					  </tr>';
			}
			echo $trdata; 
		
	}
	
	//========Student course assignment end===========//
	//========Bulk Student course assignment Start===========//
	function assignedOrNot()
	{
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$batch_id=$this->input->post('batch_id');
		$semester_id=$this->input->post('semester_id');
		$discipline_id=$this->input->post('discipline_id');
		$course_id=$this->input->post('course_id');
		$assign_status=$this->input->post('assign_status');
		
		$send['campus_id']=$campus_id;
	    $send['program_id']=$program_id;
	    $send['degree_id']=$degree_id;
	    $send['batch_id']=$batch_id;
	    $send['semester_id']=$semester_id;
	    $send['discipline_id']=$discipline_id;
	    $send['course_id']=$course_id;
	    $send['assign_status']=$assign_status;
		
		
		//$studentList = $this->Assign_model->get_student_list_by_ids($send);
		if($assign_status==2)
		{
			$studentList = $this->Assign_model->get_student_checked_list($send);
		//p($studentLIst);exit;
		$trdata='';
			$i=0;
			foreach($studentList as $students)
			{
				$i++;
				$checked = 'checked';
				$trdata.='<tr>
				      <td ><input type="checkbox" class="checkbox"  id="select_all" name="student_id[]" value="'.$students->user_id.'" '.$checked.'></td>
						<td>'.$i.'</td>
						<td>'.$students->user_unique_id.'</td>
						<td>'.$students->first_name.' '.$students->last_name.'</td>
					  </tr>';
			}
			echo $trdata; 
		}
		else
		{
			//$studentList = $this->Assign_model->get_student_list_by_ids($send);
			$studentList = $this->Assign_model->get_student_list_by_assign_course($send);
		//p($studentLIst);exit;
		$trdata='';
			$i=0;
			foreach($studentList as $students)
			{
				$i++;
				//if($students->course_id==$course_id){$checked = 'checked';} else { $checked = '';}
				$trdata.='<tr>
				      <td ><input type="checkbox" class="checkbox"  id="select_all" name="student_id[]" value="'.$students->user_id.'" ></td>
						<td>'.$i.'</td>
						<td>'.$students->user_unique_id.'</td>
						<td>'.$students->first_name.' '.$students->last_name.'</td>
					  </tr>';
			}
			echo $trdata;
		}
	}
	function getStudentWithCourse()
	{
	    //p($_POST); exit;
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$batch_id=$this->input->post('batch_id');
		$semester_id=$this->input->post('semester_id');
		$discipline_id=$this->input->post('discipline_id');
		$course_id=$this->input->post('course_id');
		
	    $send['campus_id']=$campus_id;
	    $send['program_id']=$program_id;
	    $send['degree_id']=$degree_id;
	    $send['batch_id']=$batch_id;
	    $send['semester_id']=$semester_id;
	    $send['discipline_id']=$discipline_id;
	    $send['course_id']=$course_id;
		
		
		
			//$studentList = $this->Assign_model->get_student_list_by_ids($send);
			$studentList = $this->Assign_model->get_student_list_by_assign_course($send);
		//p($studentLIst);exit;
		$trdata='';
			$i=0;
			foreach($studentList as $students)
			{
				$i++;
				//if($students->course_id==$course_id){$checked = 'checked';} else { $checked = '';}
				$trdata.='<tr>
				      <td ><input type="checkbox" class="checkbox"  id="select_all" name="student_id[]" value="'.$students->user_id.'" ></td>
						<td>'.$i.'</td>
						<td>'.$students->user_unique_id.'</td>
						<td>'.$students->first_name.' '.$students->last_name.'</td>
					  </tr>';
			}
			echo $trdata; 
		
	}
	
	//========Bulk Student course assignment end===========//
	function getCourseByCDB()
	{
		$campus_id = $this->input->post('campus_id');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$semester_id = $this->input->post('semester_id');
		$batch_id = $this->input->post('batch_id');
		$save['campus_id']=$campus_id;
		$save['program_id']=$program_id;
		$save['degree_id']=$degree_id;
		$save['semester_id']=$semester_id;
		$save['batch_id']=$batch_id;
		$data['courses']=$this->Assign_model->get_course_by_cdb($save);
     //   print_r($data['courses']); exit;		
		$str = '';
         foreach($data['courses'] as $k=>$v){ 
           
          $str .= "<option value=".$v->id.">".$v->course_title.'('.$v->course_code.')'."</option>";
           }
		   
           echo $str;
	}
	
	function registerCourseToStudent()
	{
		//p($_POST); exit;
		$campus_id = $this->input->post('campus_id');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$semester_id = $this->input->post('semester_id');
		$batch_id = $this->input->post('batch_id');
		$course_id = $this->input->post('course_id');
		$student_id = $this->input->post('student_id');//array input
		$this->Assign_model->delete_bulk_course_to_students($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$course_id);//delete old data for update
		for($i=0;$i<count($student_id);$i++){
			$studentId=$student_id[$i];

				
				$dataArr=array(
					   'campus_id'=>$campus_id,
					   'program_id'=>$program_id,
					   'degree_id'=>$degree_id,
					   'semester_id'=>$semester_id,
					   'batch_id'=>$batch_id,
					   'course_id'=>$course_id,
					   'student_id'=>$studentId
				);
				 $saveBulk = $this->Assign_model->save_bulk_course_to_student($dataArr); 
				 if(!empty($saveBulk))
				 {
					 $return=1;
				 }
				 else{
					 $return=0;
				 }
		}
		echo $return;
	}
	
	
		 
	
}
?>