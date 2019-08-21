<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Course extends CI_Controller {
	
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
		 $this->load->library('pagination');
		 $this->load->library('encrypt');
		 $this->load->library('dompdf_gen');
		 $this->load->library('excel');
		 
		 
		 $this->load->model('Discipline_model');
		 $this->load->model('Gradechart_model');
		  $this->load->model('Master_model');
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
	function listCourseGroup()
	{
		$data['page_title']="Course Group List";
		$data['course_group_list']=$this->Master_model->course_group_list();
		$this->load->view('admin/course_group_list_view',$data);
	}
    function addCourseGroup()
	{
		$data['page_title']="Add Course Group";
		$this->load->view('admin/course_group_add_view',$data);
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
    
	function editCourseGroup($id)
	{
		$data['page_title']="Update Course Group";
		$data['course_group_row']=$this->Master_model->get_course_group_by_id($id);
	   // print_r($data['course_group_row']); exit;
		$this->load->view('admin/course_group_edit_view',$data);
	}
	
	function updateCourseGroup($id)
	{ 
	    $register_date_time=date('Y-m-d H:i:s');
		$course_group_code = $this->input->post('course_group_code');
		$course_group_name = $this->input->post('course_group_name');
		
		$save['course_group_code']=$course_group_code;
		$save['course_group_name']=$course_group_name;
		$save['updated_on']=     $register_date_time;
	    $this->Master_model->update_course_group($id,$save);//update semester
	    $this->session->set_flashdata('message', 'Course group updated successfully');
	    redirect('course/listCourseGroup');
	}
	function deleteCourseGroup($id)
	{    
	     if($id)
		 {
			$this->Master_model->delete_course_group($id); 
		 }
		 $this->session->set_flashdata('message', 'Course group deleted successfully');
	     redirect('course/listCourseGroup'); 
	}
	function courseGroupStatus($id,$dststus)
	{     
	     $status = $dststus;
         $this->Master_model->status_course_group($id,$status); 
		 $this->session->set_flashdata('message', 'Course group status updated successfully');
	     redirect('course/listCourseGroup'); 
	}
	function listCourseSubjectGroup()
	{
		$data['page_title']="Course Subject Group List";
		$data['course_group_list']=$this->Master_model->course_subject_group_list();
		$this->load->view('admin/course_subject_group_list_view',$data);
	}
    function addCourseSubjectGroup()
	{
		$data['page_title']="Add Course Subject Group";
		$this->load->view('admin/course_subject_group_add_view',$data);
	}
	function saveCourseSubjectGroup()
	{
		$register_date_time=date('Y-m-d H:i:s');
		$course_subject_name = $this->input->post('course_subject_name');
		$course_subject_title = $this->input->post('course_subject_title');
		//$course_group_name = $this->input->post('course_group_name');
		
		$save['course_subject_name']=$course_subject_name;
		$save['course_subject_title']=$course_subject_title;
		//$save['course_group_name']=$course_group_name;
		$save['created_on']=     $register_date_time;
		
		$data= $this->Master_model->save_course_subject_group($save);
		$this->session->set_flashdata('message', 'Course Subject group added successfully');
	    redirect('course/listCourseSubjectGroup');
		
	}
    
	function editCourseSubjectGroup($id)
	{
		$data['page_title']="Update Course Subject Group";
		$data['course_group_row']=$this->Master_model->get_course_subject_group_by_id($id);
	   // print_r($data['course_group_row']); exit;
		$this->load->view('admin/course_subject_group_edit_view',$data);
	}
	
	function updateCourseSubjectGroup($id)
	{ 
	    $register_date_time=date('Y-m-d H:i:s');
		$course_subject_name = $this->input->post('course_subject_name');
		$course_subject_title = $this->input->post('course_subject_title');
		
		$save['course_subject_name']=$course_subject_name;
		$save['course_subject_title']=$course_subject_title;
		
		$save['updated_on']=     $register_date_time;
	    $this->Master_model->update_course_subject_group($id,$save);//update semester
	    $this->session->set_flashdata('message', 'Course Subject group updated successfully');
	    redirect('course/listCourseSubjectGroup');
	}
	function deleteCourseSubjectGroup($id)
	{    
	     if($id)
		 {
			$this->Master_model->delete_course_subject_group($id); 
		 }
		 $this->session->set_flashdata('message', 'Course Subject group deleted successfully');
	     redirect('course/listCourseSubjectGroup'); 
	}
	function courseSubjectGroupStatus($id,$dststus)
	{     
	     $status = $dststus;
         $this->Master_model->status_course_subject_group($id,$status); 
		 $this->session->set_flashdata('message', 'Course group status updated successfully');
	     redirect('course/listCourseSubjectGroup'); 
	}
	
	function getDegreebyProgram()
	{
		$program_id = $this->input->post('program_id');
		$campus_id = $this->input->post('campus_id');
		$data['degrees']=$this->Master_model->get_degree_by_program_id($program_id,$campus_id);// echo $this->db->last_query();
		 $str = '';
         foreach($data['degrees'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->degree_name."</option>";
           }
		   
           echo $str;
         
	}
	function getSyllabusYearbyProgram()
	{
		$program_id = $this->input->post('program_id');
		//p($program_id); exit;
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
	function getDisciplineByDegreeId()
	{
		$degree_id = $this->input->post('degree_id');
		$data['discipline']=$this->Master_model->get_discipline_by_degree_id($degree_id); 
		//print_r($data['semesters']); exit;
		 $str = '';
         foreach($data['discipline'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->discipline_name."</option>";
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
	function get_academic_students($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id,$student_id,$exam_type){
		
		$subject_wise_pass_fail_list = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id,$student_id,$exam_type);
		//print_r($subject_wise_pass_fail_list);exit;
		//echo $this->db->last_query();exit;
		  //echo $this->db->last_query();exit;
			$courseGroup=array();
			$courseGroupArr=array();
			$resultArray=array();
		 foreach($subject_wise_pass_fail_list as $subject_wise_val){
			 //if($subject_wise_val->student_id == 844){
			//	p($subject_wise_val);exit;
			 //}
			 if($degree_id=='1'){
				 if(!empty($subject_wise_val->course_subject_name)){
					 if(!in_array($subject_wise_val->course_subject_name, $courseGroup, true)){
							array_push($courseGroup, $subject_wise_val->course_subject_name);
							$courseGroupArr[$subject_wise_val->coure_group_id]=$subject_wise_val->course_subject_name;
						}
						$name = $subject_wise_val->first_name.' '.$subject_wise_val->last_name;
						
						$numbers = array( $subject_wise_val->theory_internal1,$subject_wise_val->theory_internal2,$subject_wise_val->theory_internal3); 
						rsort($numbers);
						//print_r($numbers);exit;
						 $theory_internal_total = $numbers[0]/4 + $numbers[1]/4;
						  $theory_externals=$subject_wise_val->theory_external1/5;
						  $practical_externals=$subject_wise_val->theory_external2/5;
						 $theory_marks_40=$theory_externals+$practical_externals;
						  $paper1_20=$subject_wise_val->theory_paper1/3;
						  $paper1_20s=number_format($paper1_20,2);
						  $paper2_20=$subject_wise_val->theory_paper2/3;
						  $paper2_20s=number_format($paper2_20,2);
						  $paper_20=$paper1_20s+$paper2_20s;
						  if($subject_wise_val->coure_group_id == 22){
							  if($subject_wise_val->ncc_status == 1)
								   $subject_wise_val->result = "SATISFACTORY"; 
							  else 
								  $subject_wise_val->result =  "NOT SATISFACTORY";
						  }else{
							  if(strtoupper(trim($subject_wise_val->theory_paper1)) == 'A' || strtoupper(trim($subject_wise_val->theory_paper2)) == 'A' || strtoupper(trim($subject_wise_val->theory_paper3)) == 'A' || strtoupper(trim($subject_wise_val->theory_paper4)) == 'A' || strtoupper(trim($subject_wise_val->theory_external1)) == 'A' || strtoupper(trim($subject_wise_val->theory_external2)) == 'A' || strtoupper(trim($subject_wise_val->theory_external3)) == 'A' || strtoupper(trim($subject_wise_val->theory_external4)) == 'A'){
								  $subject_wise_val->result = "ABSENT"; 
							  }else if(trim($theory_internal_total+$theory_marks_40) >=30 && $paper_20>=20 && trim($theory_internal_total+$theory_marks_40+$paper_20)>=50) 
								  $subject_wise_val->result = "PASS"; 
							  else 
								  $subject_wise_val->result =  "FAIL";
						  }
						  if($subject_wise_val->result =='ABSENT' || $subject_wise_val->result =='FAIL' || $subject_wise_val->result =='NOT SATISFACTORY')
							$resultArray[$name][$subject_wise_val->course_subject_name][]=$subject_wise_val;
					//print_r($resultArray);exit;
				 }
			 }else{
				 $name = $subject_wise_val->first_name.' '.$subject_wise_val->last_name;
				  if(!in_array($subject_wise_val->course_code, $courseGroup, true)){
							array_push($courseGroup, $subject_wise_val->course_code);
							$courseGroupArr[$subject_wise_val->course_code]=$subject_wise_val->course_code;
						}
				 if($subject_wise_val->theory_credit > 0 && $subject_wise_val->practicle_credit > 0) 
					$total_internal_sum = number_format($subject_wise_val->theory_internal1 + $subject_wise_val->practical_internal,2);
				elseif($subject_wise_val->theory_credit > 0 ) 
					$total_internal_sum = $subject_wise_val->theory_internal1;
				elseif($subject_wise_val->practicle_credit > 0 )
					$total_internal_sum = $subject_wise_val->practical_internal;
				$total_internal_sum = $total_internal_sum+$subject_wise_val->assignment_mark;
					if($total_internal_sum>=25 && $subject_wise_val->theory_external1>=25)
						$subject_wise_val->result = "PASS"; 
					else 
						$subject_wise_val->result =  "FAIL";
				if($subject_wise_val->result =='FAIL')
					$resultArray[$name][$subject_wise_val->course_code][]=$subject_wise_val;
				 //print_r($resultArray);exit;
			 }
			 
		  }//exit;
		 // p($resultArray);
		   if($degree_id=='1'){
			   if(count($courseGroupArr)>0)
					ksort($courseGroupArr);
		   }
		 $data['result_marks'] =$resultArray;
		 $data['courseGroup'] =$courseGroupArr;
		return $data;
	}
	
	function getStudentByDegreeCampusBatchAndSemester() //get student list for course assignment
	{
		//print_r($_POST);
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$batch_id=$this->input->post('batch_id');
		$semester_id=$this->input->post('semester_id');
		$exam_type=$this->input->post('exam_type');
		$include_academic_student=$this->input->post('include_academic_student');
		$academic_student=array();
		if($include_academic_student == 1){
			$acdemic_batch_id = $batch_id-1;
			if($acdemic_batch_id>0){
				$result_marks = $this->get_academic_students($campus_id,$program_id,$degree_id,$acdemic_batch_id,$semester_id,'','',1);
				foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
					foreach($courseGroupArr as $groupname=>$marksArr){
						foreach($marksArr as $key=>$marks){
							$result[$name][$groupname][] = @$marks->result;
						}
						$result[$name][$groupname] = array_unique($result[$name][$groupname]);
						if(count($result[$name])>=3){
							//$academic_student[$marksArr[0]->student_id]=$name.'('.$marksArr[0]->user_unique_id.')';
							$academic_student[$marksArr[0]->user_unique_id]['name']=$name;
							$academic_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
							//$result[$name][$groupname] = $marksArr;
						}
					}
					
				}
				$result_marks = $this->get_academic_students($campus_id,$program_id,$degree_id,$acdemic_batch_id,$semester_id,'','',2);
				foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
					foreach($courseGroupArr as $groupname=>$marksArr){
						foreach($marksArr as $key=>$marks){
							$result[$name][$groupname][] = @$marks->result;
						}
						$result[$name][$groupname] = array_unique($result[$name][$groupname]);
						if(count($result[$name])>=1){
							//$academic_student[$marksArr[0]->student_id]=$name.'('.$marksArr[0]->user_unique_id.')';
							$academic_student[$marksArr[0]->user_unique_id]['name']=$name;
							$academic_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
							//$result[$name][$groupname] = $marksArr;
						}
					}
					
				}
			}
		}
		$send['campus_id']=$campus_id;
		$send['program_id']=$program_id;
		$send['degree_id']=$degree_id;
		$send['batch_id']=$batch_id;
		$send['semester_id']=$semester_id;
		$data['students']=$this->Master_model->get_student_by_degree_campus_batch_semester($send); //get student dropdown
		
		$ssemester_id=$semester_id;
		
		 $sid='00';
		 $str = '';
		$prev_sem_student=array();
		if(in_array($ssemester_id,array(4,5,6))){
			$discontinue_res = $this->Gradechart_model->get_discontinue_students($campus_id,$program_id,$degree_id,$batch_id,1,1,'');
			foreach($discontinue_res as $key=>$stu_res){
				$prev_sem_student[$stu_res->user_unique_id]['name']=$stu_res->first_name;
				$prev_sem_student[$stu_res->user_unique_id]['student_id']=$stu_res->id;
			}
			if($ssemester_id == 4){
				$semester_id = 1;
			}elseif($ssemester_id == 5){
				$semester_id = 1;
				$result_marks = $this->get_academic_students($campus_id,$program_id,$degree_id,$batch_id,$semester_id,'','',1);
				foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
					foreach($courseGroupArr as $groupname=>$marksArr){
						foreach($marksArr as $key=>$marks){
							$result[$name][$groupname][] = @$marks->result;
						}
						$result[$name][$groupname] = array_unique($result[$name][$groupname]);
						if(count($result[$name])>=3){
							$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
							$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
						}
					}
				}
				$result_marks = $this->get_academic_students($campus_id,$program_id,$degree_id,$batch_id,$semester_id,'','',2);
				foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
					foreach($courseGroupArr as $groupname=>$marksArr){
						foreach($marksArr as $key=>$marks){
							$result[$name][$groupname][] = @$marks->result;
						}
						$result[$name][$groupname] = array_unique($result[$name][$groupname]);
						if(count($result[$name])>=1){
							$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
							$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
						}
					}
				}
				$semester_id = $ssemester_id-1;
			}else if($ssemester_id == 6){
				$semester_id = 1;
				$result_marks = $this->get_academic_students($campus_id,$program_id,$degree_id,$batch_id,$semester_id,'','',1);
				foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
					foreach($courseGroupArr as $groupname=>$marksArr){
						foreach($marksArr as $key=>$marks){
							$result[$name][$groupname][] = @$marks->result;
						}
						$result[$name][$groupname] = array_unique($result[$name][$groupname]);
						if(count($result[$name])>=3){
							$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
							$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
						}
					}
				}
				$result_marks = $this->get_academic_students($campus_id,$program_id,$degree_id,$batch_id,$semester_id,'','',2);
				foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
					foreach($courseGroupArr as $groupname=>$marksArr){
						foreach($marksArr as $key=>$marks){
							$result[$name][$groupname][] = @$marks->result;
						}
						$result[$name][$groupname] = array_unique($result[$name][$groupname]);
						if(count($result[$name])>=1){
							$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
							$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
						}
					}
				}
				$semester_id = 4;
				$result_marks = $this->get_academic_students($campus_id,$program_id,$degree_id,$batch_id,$semester_id,'','',1);
				foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
					foreach($courseGroupArr as $groupname=>$marksArr){
						foreach($marksArr as $key=>$marks){
							$result[$name][$groupname][] = @$marks->result;
						}
						$result[$name][$groupname] = array_unique($result[$name][$groupname]);
						if(count($result[$name])>=3){
							$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
							$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
						}
					}
				}
				$result_marks = $this->get_academic_students($campus_id,$program_id,$degree_id,$batch_id,$semester_id,'','',2);
				foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
					foreach($courseGroupArr as $groupname=>$marksArr){
						foreach($marksArr as $key=>$marks){
							$result[$name][$groupname][] = @$marks->result;
						}
						$result[$name][$groupname] = array_unique($result[$name][$groupname]);
						if(count($result[$name])>=1){
							$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
							$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
						}
					}
				}
				$semester_id = $ssemester_id-1;
			}
			
			$result_marks = $this->get_academic_students($campus_id,$program_id,$degree_id,$batch_id,$semester_id,'','',1);
			foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
				foreach($courseGroupArr as $groupname=>$marksArr){
					foreach($marksArr as $key=>$marks){
						$result[$name][$groupname][] = @$marks->result;
					}
					$result[$name][$groupname] = array_unique($result[$name][$groupname]);
					if(count($result[$name])>=3){
						$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
						$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
					}
				}
			}
			$result_marks = $this->get_academic_students($campus_id,$program_id,$degree_id,$batch_id,$semester_id,'','',2);
			foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
				foreach($courseGroupArr as $groupname=>$marksArr){
					foreach($marksArr as $key=>$marks){
						$result[$name][$groupname][] = @$marks->result;
					}
					$result[$name][$groupname] = array_unique($result[$name][$groupname]);
					if(count($result[$name])>=1){
						$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
						$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
					}
				}
			}
			//p($result_marks);exit;
		}
		//p($academic_student);exit;
		foreach($data['students'] as $k=>$v){ 
			$failed_flag = true;
			if(count($prev_sem_student)>0){
				if(isset($prev_sem_student[$v->user_unique_id]))
					$failed_flag = false;
			}
			if($failed_flag){
				$str .= "<option value=".$v->id.">".$v->first_name.' '.$v->last_name.'('.$v->user_unique_id.')'."</option>";
			}
		}
		   
		   $student_res = $this->Gradechart_model->get_discontinue_students($campus_id,$program_id,$degree_id,$acdemic_batch_id,$semester_id,$exam_type,'');
		foreach($student_res as $key=>$arrobj){
			$academic_student[$arrobj->user_unique_id]['name']=$arrobj->first_name;
			$academic_student[$arrobj->user_unique_id]['student_id']=$arrobj->id;
		}
		   if(count(@$academic_student)>0){
			   ksort($academic_student);
			   foreach($academic_student as $unique_id=>$val){ 
					$str .= "<option value=".$val['student_id'].">".$val['name'].'('.$unique_id.')'."</option>";
			   }
		   }
		   
           echo $str;
	}
	
	//========course assignment===========//
	function assignCourseList()
	{
		$data['page_title']="Assign Course List";
		$data['course_assign_list']=$this->Master_model->list_assign_course();
		//print_r($data['course_assign_list']); exit;
	    $this->load->view('admin/course_assign_list_view',$data);
	}
	//========course assignment===========//
	function studentCourseAssignmentList()
	{
		$data['page_title']="Student Course Assignment List";
		$data['campuses'] = $this->Discipline_model->get_campus();
		$data['course_assign_list']=array();
		if(!empty($this->input->post('campus_id'))){
			$data['campus_id']=$this->input->post('campus_id');
			$data['program_id']=$this->input->post('program_id');
			$data['degree_id']=$this->input->post('degree_id');
			$data['semester_id']=$this->input->post('semester_id');
			$data['batch_id']=$this->input->post('batch_id');
			if(!empty($this->input->post('exam_type')))
				$data['exam_type']=$this->input->post('exam_type');
			$data['course_assign_list']=$this->Master_model->get_student_assigned_course_list($data);
		}//else
			//$data['course_assign_list']=$this->Master_model->get_student_assigned_course_list();
		
		//print_r($data['course_assign_list']); exit;
		//echo $this->db->last_query();exit;
	    $this->load->view('admin/studentCourseAssignmentList',$data);
	}
	function deleteAssignCourse($id)
	{
		 if($id)
		 {
			$this->Master_model->delete_assign_course($id); 
		 }
		 $this->session->set_flashdata('message', 'Assign course deleted successfully');
	     redirect('course/assignCourseList');
	}
	function deleteStudentCourseAssignment($id)
	{
		 if($id)
		 {
			$this->Master_model->delete_student_assigned_course_list($id); 
		 }
		 $this->session->set_flashdata('message', 'Assigned courses deleted successfully');
	     redirect('course/studentCourseAssignmentList');
	}
	function assignCourseStatus($id,$status)
	{
		 $this->Master_model->assign_course_status($id,$status); 
		 $this->session->set_flashdata('message', 'Assign course status successfully changed');
	     redirect('course/assignCourseList');
	}
	function editAssigCourse($id)
	{
		$data['page_title']="Course Assignment";
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['semesters'] = $this->Discipline_model->get_semester();
		
		$data['batches'] = $this->Discipline_model->get_batch();
		$data['degrees'] = $this->Discipline_model->get_degree();
		$data['syllabus_years'] = $this->Discipline_model->get_syllabus_year();
		//print_r($data['syllabus_years']); exit;
	    $data['course_assign_row']=$this->Master_model->get_assign_course_by_id($id);
		//print_r( $data['course_assign_row']); exit;
	    $this->load->view('admin/course_assign_edit_view',$data);
		
	}
	function updateAssignDate($id)
	{
	
		$data['page_title']="Edit Assign Date";
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['semesters'] = $this->Discipline_model->get_semester();
		
		$data['batches'] = $this->Discipline_model->get_batch();
		$data['degrees'] = $this->Discipline_model->get_degree();
		$data['syllabus_years'] = $this->Discipline_model->get_syllabus_year();
		//print_r($data['syllabus_years']); exit;
	    $data['course_assign_row']=$this->Master_model->get_assign_course_by_id($id);
		//print_r( $data['course_assign_row']); exit;
	    $this->load->view('admin/course_assign_update_assign_date_view',$data);
		
	
	}
	function updateCourseDateAssign($id)
	{
		
		$batch_id = $this->input->post('batch_id');
		$start_date = $this->input->post('start_date');
		$date_of_closure = $this->input->post('date_of_closure');
		
	
		$save['start_date']=     $start_date;
		$save['date_of_closure']=     $date_of_closure;
		$this->Master_model->update_assign_date_course($id,$save);//update semester
	    $this->session->set_flashdata('message', 'Course assign updated successfully');
	    redirect('course/assignCourseList');
	}
	
	function viewAssigCourse($id)
	{
		$data['page_title']="View Course Assignment";
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['semesters'] = $this->Discipline_model->get_semester();
		
		$data['batches'] = $this->Discipline_model->get_batch();
		$data['degrees'] = $this->Discipline_model->get_degree();
		$data['syllabus_years'] = $this->Discipline_model->get_syllabus_year();
		//print_r($data['syllabus_years']); exit;
	    $data['course_assign_row']=$this->Master_model->get_assign_course_by_id($id);
		//print_r( $data['course_assign_row']); exit;
	    $this->load->view('admin/course_assign_detail_view',$data);
		
	}
	function updateAssignCourse($id)
	{
		//print_r($id); exit;
		$register_date_time=date('Y-m-d H:i:s');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$semester_id = $this->input->post('semester_id');
		$previous_semester_id = $this->input->post('previous_semester_id');
		$syllabus_year = $this->input->post('syllabus_year');
		$batch_id = $this->input->post('batch_id');
		
			
		$save['program_id']=$program_id;
		$save['degree_id']=$degree_id;
		$save['semester_id']=     $semester_id;
		$save['previous_semester_id']=     $previous_semester_id;
		$save['syllabus_year_id	']=     $syllabus_year;
		$save['batch_id']=     $batch_id;
		$save['created_on']=     $register_date_time;
		
	    $this->Master_model->update_assign_course($id,$save);//update semester
	    $this->session->set_flashdata('message', 'Course assign updated successfully');
	    redirect('course/assignCourseList');
	}
	
	function assignCourse()
	{
		$data['page_title']="Course Assignment";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['semesters'] = $this->Discipline_model->get_semester();
		$data['batches'] = $this->Discipline_model->get_batch();
	    $this->load->view('admin/course_assign_add_view',$data);
	}
	
	function getCourseList()
	{
		//p($_POST); exit;
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$semester_id = $this->input->post('semester_id');
		$previous_semester_id = $this->input->post('previous_semester_id');
		$syllabus_year = $this->input->post('syllabus_year');
		$batch_id = $this->input->post('batch_id');
		$courselist=$this->Master_model->get_course_list($program_id,$degree_id,$semester_id,$syllabus_year);
		//print_r($courselist);  exit;
		$trdata='';
		foreach($courselist as $courses)
			{
				
				$trdata.='<tr>
							<td><input type="checkbox" class="checkbox"  id="select_all" name="course_id[]" value="'.$courses->id.'"></td>
							<td>'.$courses->program_name.'</td>
							<td>'.$courses->degree_name.'</td>
							<td>'.$courses->discipline_name.'</td>
							<td>'.$courses->course_code.' - '.$courses->course_title.'</td>
					     </tr>';
			}
			echo $trdata; 
		
	}
	function saveAssignCourse()
	{
		$register_date_time=date('Y-m-d H:i:s');
		$campus_id = $this->input->post('campus_id');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$semester_id = $this->input->post('semester_id');
		$previous_semester_id = $this->input->post('previous_semester_id');
		$syllabus_year = $this->input->post('syllabus_year');
		$batch_id = $this->input->post('batch_id');
		$courses = $this->input->post('course_id');
		for($i=0;$i<count($courses);$i++){
				$course_id=$courses[$i];
				//checking already assigned
				$checkdata = $this->checking_assigned_courses($course_id,$program_id,$degree_id,$semester_id,$previous_semester_id,$syllabus_year,$batch_id,$campus_id);
				//print_r($checkdata); exit;
				
				if($checkdata==1)
				{
					
				}
				else
				{
				 $data=array(
				    'campus_id'=>$campus_id,
				    'program_id'=>$program_id,
					'degree_id'=>$degree_id,
					'semester_id'=>$semester_id,
					'previous_semester_id'=>$previous_semester_id,
					'syllabus_year_id'=>$syllabus_year,
					'batch_id'=>$batch_id,
					'created_on'=>$register_date_time,
					'course_id'=>$course_id
					
					);
				//p($data);
				//
				 $this->Master_model->save_assign_course($data);
				}
			} 
		  $this->session->set_flashdata('message', 'Course assigned  successfully');
	      redirect('course/assignCourseList');
	}
	
	function checking_assigned_courses($course_id,$program_id,$degree_id,$semester_id,$previous_semester_id,$syllabus_year,$batch_id,$campus_id)
	{
		$RowVal=$this->Master_model->check_already_inserted_courses_row($course_id,$program_id,$degree_id,$semester_id,$previous_semester_id,$syllabus_year,$batch_id,$campus_id);
		//echo $this->db->last_query();exit;
		return $RowVal;
	}
	
	//========course assignment end===========//
	
	//========Student course assignment start===========//
	function studentCourseAssignment()
	{
		$data['page_title']="Student Course Assignment";
		$data['campuses'] = $this->Discipline_model->get_campus();
		$data['batches'] = $this->Discipline_model->get_batch();
		$data['disciplines'] = $this->Discipline_model->get_discipline();
		
	    $this->load->view('admin/student_course_assignment_view',$data);
		
	}
	function getCapStudentList(){
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$semester_id=$this->input->post('semester_id');
		$batch_id=$this->input->post('batch_id');
		$student_id=$this->input->post('student_id');
		$exam_type=1;
		$data['aggregate_marks'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,'','',$exam_type);
		$courseGroup=array();
		$resultArray=array();
		 foreach($data['aggregate_marks'] as $subject_wise_val){
			// p($subject_wise_val);
			 if($degree_id=='1'){
				 if(!empty($subject_wise_val->course_subject_name) && $subject_wise_val->coure_group_id != 22){
					 if(!in_array($subject_wise_val->course_subject_name, $courseGroup, true)){
							array_push($courseGroup, $subject_wise_val->course_subject_name);
							$courseGroupArr[$subject_wise_val->coure_group_id]=$subject_wise_val->course_subject_name;
						}
						$name = $subject_wise_val->first_name.' '.$subject_wise_val->last_name;
						
						$numbers = array( $subject_wise_val->theory_internal1,$subject_wise_val->theory_internal2,$subject_wise_val->theory_internal3); 
						rsort($numbers);
						//print_r($numbers);exit;
						 $theory_internal_total = $numbers[0]/4 + $numbers[1]/4;
						  $theory_externals=$subject_wise_val->theory_external1/5;
						  $practical_externals=$subject_wise_val->theory_external2/5;
						 $theory_marks_40=$theory_externals+$practical_externals;
						  $paper1_20=$subject_wise_val->theory_paper1/3;
						  $paper1_20s=number_format($paper1_20,2);
						  $paper2_20=$subject_wise_val->theory_paper2/3;
						  $paper2_20s=number_format($paper2_20,2);
						  $paper_20=$paper1_20s+$paper2_20s;
						  if($subject_wise_val->coure_group_id == 22){
							  if($subject_wise_val->ncc_status == 1)
								   $subject_wise_val->result = "SATISFACTORY"; 
							  else 
								  $subject_wise_val->result =  "NOT SATISFACTORY";
						  }else{
							  if(trim($theory_internal_total+$theory_marks_40) >=30 && $paper_20>=20 && trim($theory_internal_total+$theory_marks_40+$paper_20)>=50) {
								  $subject_wise_val->result = "PASS"; 
								  $subject_wise_val->theory_diff='-';
								  $subject_wise_val->prac_diff='-';
							  }else {
								  $subject_wise_val->result =  "FAIL";
								  if(trim($theory_internal_total+$theory_marks_40)<30)
									$subject_wise_val->theory_diff = round_two_digit(30 - trim($theory_internal_total+$theory_marks_40),2);
								  else
									$subject_wise_val->theory_diff = '-';
								if($paper_20<20)
								  $subject_wise_val->prac_diff = round_two_digit(20 - $paper_20,2);
							  else
								$subject_wise_val->prac_diff ='-';
							  }
						  }
					if($subject_wise_val->result == 'FAIL')
						$resultArray[$name][$subject_wise_val->course_subject_name][]=$subject_wise_val;
				 }
			 }else{
				 $name = $subject_wise_val->first_name.' '.$subject_wise_val->last_name;
				  if(!in_array($subject_wise_val->course_code, $courseGroup, true)){
							array_push($courseGroup, $subject_wise_val->course_code);
							$courseGroupArr[$subject_wise_val->course_code]=$subject_wise_val->course_code;
						}
				 if($subject_wise_val->theory_credit > 0 && $subject_wise_val->practicle_credit > 0) 
					$total_internal_sum = number_format($subject_wise_val->theory_internal1 + $subject_wise_val->practical_internal,2);
				elseif($subject_wise_val->theory_credit > 0 ) 
					$total_internal_sum = $subject_wise_val->theory_internal1;
				elseif($subject_wise_val->practicle_credit > 0 )
					$total_internal_sum = $subject_wise_val->practical_internal;
				$total_internal_sum = $total_internal_sum+$subject_wise_val->assignment_mark;
					if($total_internal_sum>=25 && $subject_wise_val->theory_external1>=25)
						$subject_wise_val->result = "P"; 
					else 
						$subject_wise_val->result =  "F";
				 $resultArray[$name][$subject_wise_val->course_code][]=$subject_wise_val;
			 }
			 
		  }
		  if(count(@$courseGroupArr)>0){
		   if($degree_id=='1')
			ksort($courseGroupArr);
		  }
		 $data['result_marks'] =$resultArray;
		$data['courseGroup'] =@$courseGroupArr;
		// print_r($data['result_marks']);exit;
		 $courseCount = count(@$data['courseGroup']);
		 $html='<thead>
						<tr>
							<th rowspan="2" style="text-align:center;vertical-align:middle">S.No</th>
							<th rowspan="2" style="text-align:center;vertical-align:middle">Student Id</th>
							<th rowspan="2" style="vertical-align:middle">Student Name</th>
							<th colspan="'.$courseCount.'" style="text-align:center;vertical-align:middle">Courses</th>
						</tr>
						<tr>';
		if(count(@$data['courseGroup'])>0){
			foreach($data['courseGroup'] as $key=>$res){
				$html.='<th style="text-align:center">'.$res.'</th>';
			}
		}
		$html.='</tr></thead><tbody id="tr_list">';
		$counter=1;
		if(count(@$data['result_marks'])>0){
			foreach($data['result_marks'] as $key1=>$student){
				if(count($student)>2)
					continue;
				$course_id = array_values($student)[0][0]->course_id;
				$user_unique_id = array_values($student)[0][0]->user_unique_id;
				$first_name = array_values($student)[0][0]->first_name;
				$student_id = array_values($student)[0][0]->student_id;
				$html.='<tr>';
				$html.='<td style="text-align:center;vertical-align:middle">'.$counter.'</td>';
				$html.='<td style="text-align:center;vertical-align:middle">'.$user_unique_id.'</td>';
				$html.='<td style="vertical-align:middle">'.$first_name.'</td>';
				foreach($data['courseGroup'] as $key=>$res){
					if(isset($student[$res])){
						$html.= '<td style="text-align:center;vertical-align:middle"><input type="checkbox" name="course_id[]" value= "'.$student_id.','.$student[$res][0]->course_id.'" /></td>';
					}else{
						$html.='<td style="text-align:center;vertical-align:middle">-</td>';
					}
				}
				$html.='</tr>';
				$counter++;
			}
		}else{
			$html.='<tr><td colspan="4" style="text-align:center">No records found</td></tr>';
		}
		 echo $html.='</tbody>';
	}
	function studentCourseAssignmentCap()
	{
		$data['page_title']="Student Course Assignment CAP";
		$data['campuses'] = $this->Discipline_model->get_campus();
		$data['batches'] = $this->Discipline_model->get_batch();
		$data['disciplines'] = $this->Discipline_model->get_discipline();
		if(isset($_POST['save'])){
			$campus_id=$this->input->post('campus_id');
			$program_id=$this->input->post('program_id');
			$degree_id=$this->input->post('degree_id');
			$batch_id=$this->input->post('batch_id');
			$semester_id=$this->input->post('semester_id');
			
			$courses=$this->input->post('course_id');
			foreach($courses as $course){
				if($degree_id == 1){
					$coursesArr = explode(",",$course);
					$student_id=$coursesArr[0];
					$coursegroupArr = explode("|",$coursesArr[1]);
					$courseidArr = explode("-",$coursegroupArr[1]);
					for($i=0;$i<count($courseidArr);$i++){
						$course_id=$courseidArr[$i];
						 $data=array(
							'campus_id'=>$campus_id,
							'program_id'=>$program_id,
							'degree_id'=>$degree_id,
							'batch_id'=>$batch_id,
							'semester_id'=>$semester_id,
							'student_id'=>$student_id,
							'course_id'=>$course_id,
							'exam_type'=>2
							
							);
						$this->Master_model->save_student_course_list($data);
					}
				}else{
					$coursesArr = explode(",",$course);
					$student_id=$coursesArr[0];
					$course_id=$coursesArr[1];
						 $data=array(
							'campus_id'=>$campus_id,
							'program_id'=>$program_id,
							'degree_id'=>$degree_id,
							'batch_id'=>$batch_id,
							'semester_id'=>$semester_id,
							'student_id'=>$student_id,
							'course_id'=>$course_id,
							'exam_type'=>2
							
							);
						$this->Master_model->save_student_course_list($data);
				}
				
			}
			$this->session->set_flashdata('message', 'Course assigned  successfully');
		redirect('course/studentCourseAssignmentCap');			
		}
	    $this->load->view('admin/student_course_assignment_cap_view',$data);
		
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
		$this->Master_model->delete_student_course_list($student_id,$semester_id);
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
		//$academic_year=$this->input->post('academic_year');
		$semester_id=$this->input->post('semester_id');
		$student_id=$this->input->post('student_id');
		$status_id=$this->input->post('status_id');
		if(empty($status_id))
			$status_id =1;
		$assign_type=$this->input->post('assign_type');
		if($assign_type == 'course')
			$exam_type=$this->input->post('exam_type');
		else
			$exam_type=$this->input->post('examtype');
	    $send['campus_id']=$campus_id;
	    $send['program_id']=$program_id;
	    $send['degree_id']=$degree_id;
	    $send['batch_id']=$batch_id;
	    $send['semester_id']=$semester_id;
	    $send['student_id']=$student_id;
	    $send['status_id']=$status_id;
	    $send['exam_type']=$exam_type;
		if($status_id=='2')
		{
			if($program_id != 1)
				$send['semester_id']='';
	    //$studentCourse= $this->Master_model->get_assigned_course_id_by_student($student_id);
		//dd($studentCourse); 
		$courselist= $this->Master_model->get_student_course_list($send);
		
		//print_r($courselist); exit;
		$trdata='';
			$i=0;
			     //$status= array();
				 $statusArr= $this->Master_model->get_assign_course_row($student_id,$semester_id,$exam_type,$batch_id);
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
				//p($myArr); exit;
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
		//p($_POST);exit;
	    $courseArr =array();
		if($this->input->post('assign_type') == 'course'){
			$campus_id=$this->input->post('ccampus_id');
			$program_id=$this->input->post('pprogram_id');
			$degree_id=$this->input->post('ddegree_id');
			$batch_id=$this->input->post('bbatch_id');
			$semester_id=$this->input->post('ssemester_id');
			$exam_type=$this->input->post('exam_type');
		}else{
			$campus_id=$this->input->post('campus_id');
			$program_id=$this->input->post('program_id');
			$degree_id=$this->input->post('degree_id');
			$batch_id=$this->input->post('batch_id');
			$semester_id=$this->input->post('semester_id');
			$exam_type=$this->input->post('examtype');
		}
		
		$student_idArr=$this->input->post('student_id');
		$status_id=$this->input->post('status_id');
		$courses=$this->input->post('course_id');
		//$courseArr = $this->Master_model->get_student_assigned_course_ids($student_id);
		//echo is_array($student_idArr);
		//p($_POST); exit;
		if(is_array($student_idArr)){
		foreach($student_idArr as $key=>$studentid){
			//echo $studentid;exit;
			$this->Master_model->delete_student_course_list($student_id,$semester_id,$exam_type,$batch_id);
			if(is_array($courses) && count($courses)>0){
				for($i=0;$i<count($courses);$i++){
					$course_id=$courses[$i];
					 $data=array(
						'campus_id'=>$campus_id,
						'program_id'=>$program_id,
						'degree_id'=>$degree_id,
						'batch_id'=>$batch_id,
						'semester_id'=>$semester_id,
						'student_id'=>$studentid,
						'course_id'=>$course_id,
						'exam_type'=>$exam_type
						
						);
					//print_r($data);exit;
					//
					$this->Master_model->save_student_course_list($data);
				} //exit;
			}
		}
		}else{
			$this->Master_model->delete_student_course_list($student_idArr,$semester_id,$exam_type,$batch_id);//echo $this->db->last_query();
			if(is_array($courses) && count($courses)>0){
				for($i=0;$i<count($courses);$i++){
					$course_id=$courses[$i];
					 $data=array(
						'campus_id'=>$campus_id,
						'program_id'=>$program_id,
						'degree_id'=>$degree_id,
						'batch_id'=>$batch_id,
						'semester_id'=>$semester_id,
						'student_id'=>$student_idArr,
						'course_id'=>$course_id,
						'exam_type'=>$exam_type
						
						);
					//print_r($data);exit;
					//
					$this->Master_model->save_student_course_list($data);//echo $this->db->last_query();
				} //exit;
			}
		}
		
	}
	
	function get_courseby_discipline()
	{
		$discipline_id = $this->input->post('discipline_id');
		//$campus_id = $this->input->post('campus_id');
		$degree_id = $this->input->post('degree_id');
		//$batch_id = $this->input->post('batch_id');
		$semester_id = $this->input->post('semester_id');
		$program_id = $this->input->post('program_id');
		
		//dd($batch_id); 
		$data['courses']=$this->Master_model->get_course_by_discipline($discipline_id,$degree_id,$semester_id,$program_id); 
		//print_r($data['students']); exit;
		 
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
		//$bacademic_year=$this->input->post('bacademic_year');
		$ssemester_id=$this->input->post('ssemester_id');
		$discipline_id=$this->input->post('discipline_id');
		$course_id=$this->input->post('course_id');
		$exam_type=$this->input->post('exam_type');
	    $send['campus_id']=$ccampus_id;
	    $send['program_id']=$pprogram_id;
	    $send['degree_id']=$ddegree_id;
	    $send['batch_id']=$bbatch_id;
	    $send['semester_id']=$ssemester_id;
	    $send['discipline_id']=$discipline_id;
	    $send['course_id']=$course_id;
		
		$studentList= $this->Master_model->get_students_list_by_course($send);
		//echo $this->db->last_query();
	//print_r($studentList); exit;
	
		$trdata='';
			$i=0;
			$prev_sem_student=array();
			if(in_array($ssemester_id,array(4,5,6))){
				$discontinue_res = $this->Gradechart_model->get_discontinue_students($ccampus_id,$pprogram_id,$ddegree_id,$bbatch_id,1,1,'');
				foreach($discontinue_res as $key=>$stu_res){
					$prev_sem_student[$stu_res->user_unique_id]['name']=$stu_res->first_name;
					$prev_sem_student[$stu_res->user_unique_id]['student_id']=$stu_res->id;
				}
				//print_r($prev_sem_student);exit;
					if($ssemester_id == 4){
						$semester_id = 1;
					}elseif($ssemester_id == 5){
						$semester_id = 1;
						$result_marks = $this->get_academic_students($ccampus_id,$pprogram_id,$ddegree_id,$bbatch_id,$semester_id,'','',1);
						foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
							foreach($courseGroupArr as $groupname=>$marksArr){
								foreach($marksArr as $key=>$marks){
									$result[$name][$groupname][] = @$marks->result;
								}
								$result[$name][$groupname] = array_unique($result[$name][$groupname]);
								if(count($result[$name])>=3){
									$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
									$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
								}
							}
						}
						$result_marks = $this->get_academic_students($ccampus_id,$pprogram_id,$ddegree_id,$bbatch_id,$semester_id,'','',2);
						foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
							foreach($courseGroupArr as $groupname=>$marksArr){
								foreach($marksArr as $key=>$marks){
									$result[$name][$groupname][] = @$marks->result;
								}
								$result[$name][$groupname] = array_unique($result[$name][$groupname]);
								if(count($result[$name])>=1){
									$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
									$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
								}
							}
						}
						$semester_id = $ssemester_id-1;
					}else if($ssemester_id == 6){
						$semester_id = 1;
						$result_marks = $this->get_academic_students($ccampus_id,$pprogram_id,$ddegree_id,$bbatch_id,$semester_id,'','',1);
						foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
							foreach($courseGroupArr as $groupname=>$marksArr){
								foreach($marksArr as $key=>$marks){
									$result[$name][$groupname][] = @$marks->result;
								}
								$result[$name][$groupname] = array_unique($result[$name][$groupname]);
								if(count($result[$name])>=3){
									$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
									$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
								}
							}
						}
						$result_marks = $this->get_academic_students($ccampus_id,$pprogram_id,$ddegree_id,$bbatch_id,$semester_id,'','',2);
						foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
							foreach($courseGroupArr as $groupname=>$marksArr){
								foreach($marksArr as $key=>$marks){
									$result[$name][$groupname][] = @$marks->result;
								}
								$result[$name][$groupname] = array_unique($result[$name][$groupname]);
								if(count($result[$name])>=1){
									$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
									$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
								}
							}
						}
						$semester_id = 4;
						$result_marks = $this->get_academic_students($ccampus_id,$pprogram_id,$ddegree_id,$bbatch_id,$semester_id,'','',1);
						foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
							foreach($courseGroupArr as $groupname=>$marksArr){
								foreach($marksArr as $key=>$marks){
									$result[$name][$groupname][] = @$marks->result;
								}
								$result[$name][$groupname] = array_unique($result[$name][$groupname]);
								if(count($result[$name])>=3){
									$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
									$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
								}
							}
						}
						$result_marks = $this->get_academic_students($ccampus_id,$pprogram_id,$ddegree_id,$bbatch_id,$semester_id,'','',2);
						foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
							foreach($courseGroupArr as $groupname=>$marksArr){
								foreach($marksArr as $key=>$marks){
									$result[$name][$groupname][] = @$marks->result;
								}
								$result[$name][$groupname] = array_unique($result[$name][$groupname]);
								if(count($result[$name])>=1){
									$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
									$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
								}
							}
						}
						$semester_id = $ssemester_id-1;
					}
					
					$result_marks = $this->get_academic_students($ccampus_id,$pprogram_id,$ddegree_id,$bbatch_id,$semester_id,'','',1);
					foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
						foreach($courseGroupArr as $groupname=>$marksArr){
							foreach($marksArr as $key=>$marks){
								$result[$name][$groupname][] = @$marks->result;
							}
							$result[$name][$groupname] = array_unique($result[$name][$groupname]);
							if(count($result[$name])>=3){
								$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
								$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
							}
						}
					}
					//p($prev_sem_student);exit;
					$result_marks = $this->get_academic_students($ccampus_id,$pprogram_id,$ddegree_id,$bbatch_id,$semester_id,'','',2);
					foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
						foreach($courseGroupArr as $groupname=>$marksArr){
							foreach($marksArr as $key=>$marks){
								$result[$name][$groupname][] = @$marks->result;
							}
							$result[$name][$groupname] = array_unique($result[$name][$groupname]);
							if(count($result[$name])>=1){
								$prev_sem_student[$marksArr[0]->user_unique_id]['name']=$name;
								$prev_sem_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
							}
						}
					}
					//p($result_marks);exit;
				}
				
			foreach($studentList as $students)
			{
				$failed_flag = true;
				if(count($prev_sem_student)>0){
					if(isset($prev_sem_student[$students->user_unique_id]))
						$failed_flag = false;
				}
				if($failed_flag){
					$i++;
					$checked = 'checked';
					$trdata.='<tr>
						  <td><input type="checkbox" name="student_id[]" value="'.$students->user_id.'" '.$checked.'></td>
							<td>'.$i.'</td>
							<td>'.$students->user_unique_id.'</td>
							<td>'.$students->first_name.' '.$students->last_name.'</td>
						  </tr>';
				}
			}
			$include_academic_course=$this->input->post('include_academic_course');
			//$academic_student=array();
			if($include_academic_course == 1){
				$acdemic_batch_id = $bbatch_id-1;
				if($acdemic_batch_id>0){
					$result_marks = $this->get_academic_students($ccampus_id,$pprogram_id,$ddegree_id,$acdemic_batch_id,$ssemester_id,'','',1);
					foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
						foreach($courseGroupArr as $groupname=>$marksArr){
							foreach($marksArr as $key=>$marks){
								$result[$name][$groupname][] = @$marks->result;
							}
							$result[$name][$groupname] = array_unique($result[$name][$groupname]);
							if(count($result[$name])>=3){
								$academic_student[$marksArr[0]->user_unique_id]['name']=$name;
								$academic_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
							}
						}
					}
					$result_marks = $this->get_academic_students($ccampus_id,$pprogram_id,$ddegree_id,$acdemic_batch_id,$ssemester_id,'','',2);
					foreach($result_marks['result_marks'] as $name=>$courseGroupArr){
						foreach($courseGroupArr as $groupname=>$marksArr){
							foreach($marksArr as $key=>$marks){
								$result[$name][$groupname][] = @$marks->result;
							}
							$result[$name][$groupname] = array_unique($result[$name][$groupname]);
							if(count($result[$name])>=1){
								$academic_student[$marksArr[0]->user_unique_id]['name']=$name;
								$academic_student[$marksArr[0]->user_unique_id]['student_id']=$marksArr[0]->student_id;
							}
						}
					}
					$student_res = $this->Gradechart_model->get_discontinue_students($ccampus_id,$pprogram_id,$ddegree_id,$acdemic_batch_id,$ssemester_id,$exam_type,'');
					//p($student_res);exit;
					if(count(@$academic_student)>0){
						ksort($academic_student);
					   foreach($academic_student as $user_unique_id=>$arr){ 
							$i++;
							$checked = 'checked';
							$trdata.='<tr>
								  <td><input type="checkbox" name="student_id[]" value="'.$arr['student_id'].'" '.$checked.'></td>
									<td>'.$i.'</td>
									<td>'.$user_unique_id.'</td>
									<td>'.$arr['name'].'</td>
								  </tr>';
					   }
				   }
				   if(count(@$student_res)>0){
					   foreach($student_res as $key=>$arrobj){ 
							$i++;
							$checked = 'checked';
							$trdata.='<tr>
								  <td><input type="checkbox" name="student_id[]" value="'.$arrobj->id.'" '.$checked.'></td>
									<td>'.$i.'</td>
									<td>'.$arrobj->user_unique_id.'</td>
									<td>'.$arrobj->first_name.'</td>
								  </tr>';
					   }
					   
				   }
				}
			}
			
			echo $trdata; 
		
	}
	
	//========Student course assignment end===========//
	
	
	
		 //----------------  Download Semester Excel ----------------------------//
      function downloadCourse()
	  {
		$data['course_group_list']=$this->Master_model->course_group_list();
		if(!empty($this->input->post('courseGroupExcel')))
          {
           
           $finalExcelArr = array('Course Group Code','Course Group Name');
           $objPHPExcel = new PHPExcel();
           $objPHPExcel->setActiveSheetIndex(0);
           $objPHPExcel->getActiveSheet()->setTitle('Discipline Worksheet');
           $cols= array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
            $j=2;
            
            //For freezing top heading row.
            $objPHPExcel->getActiveSheet()->freezePane('A2');

            //Set height for column head.
            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                        
           for($i=0;$i<count($finalExcelArr);$i++){
            
            //Set width for column head.
            $objPHPExcel->getActiveSheet()->getColumnDimension($cols[$i])->setAutoSize(true);

            //Set background color for heading column.
            $objPHPExcel->getActiveSheet()->getStyle($cols[$i].'1')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '71B8FF')
                    ),
                      'font'  => array(
                      'bold'  => false,
                      'size'  => 15,
                      )
                )
            );

            $objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'1', $finalExcelArr[$i]);

            foreach ($data['course_group_list'] as $key => $value) {
            // dd($value); 
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $value->course_group_code);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $value->course_group_name);
          
          
           
            }
          }

          $filename='Course_group.xls';
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          ob_start();  
          $objWriter->save('php://output');

         
          }
      //----------------  End Download Semester Excel ------------------------// 
	  }
	
}
?>