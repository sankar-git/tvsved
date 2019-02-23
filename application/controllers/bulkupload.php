<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bulkupload extends CI_Controller {
	
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
			$this->load->model('newsession_model');
			$this->load->helper('email');
			$this->load->model('newsession_model');
			$this->load->model('user_model');
			$this->load->model('type_model');
			$this->load->model('Master_model');
			$this->load->model('Marks_model');
			$this->load->model('Discipline_model');
			$this->load->model('Generate_model');
			$this->load->library('permission_lib');
			
			$this->load->library('excel');
			$sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }
			
			/*if($this->session->userdata('sms'))
			{
				$session_data = $this->session->userdata('sms');
				//print_r($session_data); exit;
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
					 $permit=$this->permission_lib->permit($this->user_id,$this->user_role);
					 
				}
				
			}
			else
			{
				redirect('authenticate', 'refresh');
			}*/
	}
	//======================================UG Marks Upload==================================================//
	
	function marksUpload()
	{
		
		
		$data['page_title']="Upload UG Marks";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['batches'] = $this->Discipline_model->get_batches(); 
		$data['semesters'] = $this->Discipline_model->get_semester(); 
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		$this->load->view('admin/marks/bulk_marks_upload_add_view',$data);
		
	}
	function getStudentAssignedMarks()
	{
		//print_r($_POST); exit;
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$batch_id=$this->input->post('batch_id');
		$semester_id=$this->input->post('semester_id');
		$discipline_id=$this->input->post('discipline_id');
		$course_id=$this->input->post('course_id');
		$marks_type=$this->input->post('marks_type');
		
	    $send['campus_id']=$campus_id;
	    $send['program_id']=$program_id;
	    $send['degree_id']=$degree_id;
	    $send['batch_id']=$batch_id;
	    $send['semester_id']=$semester_id;
	    $send['discipline_id']=$discipline_id;
	    $send['course_id']=$course_id;
		
		   $studentArr= $this->Marks_model->uploaded_marks_students_list($send);
			//p($studentArr); exit;
			 $courseRow= $this->Marks_model->get_inserted_course($course_id);
			//print_r($courseRow->course_id); exit;
			$myArr=array();
			if(!empty($courseRow->course_id))
			{
			if($course_id == $courseRow->course_id){
					
					foreach($studentArr as $studentVal)
					{
						$s_id = $studentVal->student_id;
						array_push($myArr,$s_id);
					}
					//p($myArr); exit;
			$studentList=$this->Marks_model->bulk_assign_marks($send);
			//print_r($studentList);  exit;
			$trdata='';
				$i=0;
				foreach($studentList as $students)
				{
					if(in_array($students->id,$myArr))
					 {
						 //echo "hello"; exit;
						 $checked='checked';
					 }
					 else{
						// echo "hii"; exit;
						$checked=''; 
					 }
					$i++;
					$trdata.='<tr>
							  <td ><input type="hidden" class="hidden"  id="student_id" name="student_id[]" value="'.$students->id.'" '.$checked.'>
							   '.$students->user_unique_id.'
							  </td>
							  <td>'.$students->first_name.' '.$students->last_name.'</td>
							  <td><input type="text" name="theory_internal[]" value="'.$students->theory_internal.'"></td>
							  <td><input type="text" name="practical_internal[]" value="'.$students->practical_internal.'"></td>
							  <td><input type="text" name="theory_external[]" value="'.$students->theory_external.'"></td>
							  <td><input type="text" name="practical_external[]" value="'.$students->practical_external.'"></td>
							
							
							
						</tr>';
					
				}
				echo $trdata; 
			}
			}
			else
			{
			$studentList=$this->Marks_model->get_students_of_not_assigned_course($send);
			$trdata='';
				$i=0;
				foreach($studentList as $students)
				{
					if(in_array($students->id,$myArr))
					 {
						 $checked='checked';
					 }
					 else{
					     $checked=''; 
					 }
					$i++;
					$trdata.='<tr>
							  <td ><input type="hidden" class="checkbox"  id="student_id" name="student_id[]" value="'.$students->id.'" '.$checked.'>
							   '.$students->user_unique_id.'
							  </td>
							  <td>'.$students->first_name.' '.$students->last_name.'</td>
							  <td><input type="text" name="theory_internal[]" value=""></td>
							  <td><input type="text" name="practical_internal[]" value=""></td>
							  <td><input type="text" name="theory_external[]" value=""></td>
							  <td><input type="text" name="practical_external[]" value=""></td>
							
							
							
						</tr>';
					
				}
				echo $trdata; 	
			}
			
			
			
	}
	function saveMarks()
	{
		//print_r($_POST); exit;
		$register_date_time=date('Y-m-d H:i:s');
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$batch_id=$this->input->post('batch_id');
		$semester_id=$this->input->post('semester_id');
		$discipline_id=$this->input->post('discipline_id');
		$course_id=$this->input->post('course_id');
		$marks_type=$this->input->post('marks_type');
		$student_ids=$this->input->post('student_id');
		
		$theory_internal=$this->input->post('theory_internal');
		$practical_internal=$this->input->post('practical_internal');
		$theory_external=$this->input->post('theory_external');
		$practical_external=$this->input->post('practical_external');
		
		//print_r($practical_external); exit;
		$return='';
		
				for($i=0;$i<count($student_ids);$i++){
						$theory_marks=$theory_internal[$i];
						$practical_marks=$practical_internal[$i];
						
						$theory_external_marks=$theory_external[$i];
						$practical_external_marks=$practical_external[$i];
						$student_id=$student_ids[$i];
						if(!empty($theory_marks)){$theory_inter=$theory_marks;} else {$theory_inter=00;}
						if(!empty($practical_marks)){$practical_inter=$practical_marks;} else {$practical_inter=00;}
						if(!empty($theory_external_marks)){$theory_extern=$theory_external_marks;} else {$theory_extern=00;}
						if(!empty($practical_external_marks)){$practical_extern=$practical_external_marks;} else {$practical_extern=00;}
						$marks_sum = $theory_inter+$practical_marks+$theory_external_marks+$practical_external_marks; //adding internal and external marks
						$this->Marks_model->delete_ug_marks($student_id,$course_id); //delete old and save new
						$data=array(
							'campus_id'=>$campus_id,
							'program_id'=>$program_id,
							'degree_id'=>$degree_id,
							'batch_id'=>$batch_id,
							'semester_id'=>$semester_id,
							'discipline_id'=>$discipline_id,
							'student_id'=>$student_id,
							'course_id'=>$course_id,
							'theory_internal'=>$theory_marks,
							'practical_internal'=>$practical_marks,
							'theory_external'=>$theory_external_marks,
							'practical_external'=>$practical_external_marks,
							'marks_sum'=>$marks_sum,
							'created_on'=>$register_date_time
						
						);
						//p($data); 
						$save = $this->Marks_model->save_marks($data); 
						
						if(!empty($save))
					   {
						   $return =1;
					   }
					   else{
							$return =0;
						}
	               } 
				echo $return;
                }
	
	
	
	
	
	function saveUGInternalMarks()
	{
		//print_r($_POST); exit;
		$register_date_time=date('Y-m-d H:i:s');
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$batch_id=$this->input->post('batch_id');
		$semester_id=$this->input->post('semester_id');
		$discipline_id=$this->input->post('discipline_id');
		$course_id=$this->input->post('course_id');
		$marks_type=$this->input->post('marks_type');
		$student_ids=$this->input->post('student_id');
		
		$theory_internal=$this->input->post('theory_internal');
		$practical_internal=$this->input->post('practical_internal');
		$theory_external=$this->input->post('theory_external');
		$practical_external=$this->input->post('practical_external');
		
		//print_r($practical_external); exit;
		$return='';
		
				for($i=0;$i<count($theory_internal);$i++){
						$theory_marks=$theory_internal[$i];
						$practical_marks=$practical_internal[$i];
						
						$theory_external_marks=$theory_external[$i];
						$practical_external_marks=$practical_external[$i];
						$student_id=$student_ids[$i];
						$this->Marks_model->delete_ug_marks($student_id,$course_id); //delete old and save new
						
						$data=array(
							'campus_id'=>$campus_id,
							'program_id'=>$program_id,
							'degree_id'=>$degree_id,
							'batch_id'=>$batch_id,
							'semester_id'=>$semester_id,
							'discipline_id'=>$discipline_id,
							'student_id'=>$student_id,
							'course_id'=>$course_id,
							'theory_internal'=>$theory_marks,
							'practical_internal'=>$practical_marks,
							'theory_external'=>$theory_external_marks,
							'practical_external'=>$practical_external_marks,
							'created_on'=>$register_date_time
						
						);
						p($data); exit;
						//$save = $this->Marks_model->save_ug_marks($data); 
						//if(!empty($save))
						//{
						  //  $return =1;
						//}
						//else{
							//$return =0;
						//}
	                } exit;
				//	echo $return;
                }
	
	//ajax function 
	function getProgramByCampus()
	{
		$campus_id = $this->input->post('campus_id');
		$data['programs']=$this->Marks_model->get_program_by_campus($campus_id); 
		//print_r($data['programs']); exit;
		$str = '';
         foreach($data['programs'] as $k=>$v){ 
           $str .= "<option value=".$v->id.">".$v->program_name."</option>";
           }
		   echo $str;
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
	//======================================UG Marks Upload End==================================================//
    //======================================PG Marks Upload Start==================================================//
	  function marksUploadPG()
	  {
		$data['page_title']="Upload PG Marks";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['batches'] = $this->Discipline_model->get_batches(); 
		$data['semesters'] = $this->Discipline_model->get_semester(); 
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		$this->load->view('admin/marks/marks_upload_pg_add_view',$data);
		
	  }
	  function getStudentList()
	  {
		$campus_id = $this->input->post('campus_id');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$batch_id = $this->input->post('batch_id');
		$semester_id = $this->input->post('semester_id');
		$data['students']=$this->Marks_model->get_ug_students_by_ids($campus_id,$program_id,$degree_id,$batch_id); 
		//print_r($data['students']); exit;
		$str = '';
        foreach($data['students'] as $k=>$v){ 
           $str .= "<option value=".$v->id.">".$v->first_name.'-'.$v->last_name."</option>";
        }
		   echo $str;
	  }
	  
	  
	  function getStudentAssignCourseList()
	  {
		 // p($_POST); exit;
		$campus_id = $this->input->post('campus_id');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$batch_id = $this->input->post('batch_id');
		$semester_id = $this->input->post('semester_id');
		$student_id = $this->input->post('student_id');
		$marks_type = $this->input->post('marks_type');
		//$studentAssignCourses = $this->Marks_model->get_student_assigned_courses($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$student_id);
		$studentAssignCourses = $this->Marks_model->get_student_assigned_pg_courses($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$student_id);
		//p($studentAssignCourses); exit;
		
		$trdata='';
	    $i=0;
			foreach($studentAssignCourses as $courses)
			{
				if($marks_type=='1')
				{
				$i++;
				$checked = 'checked';
				$trdata.='<tr>
				              <td><input type="hidden" name="course_id[]" value="'.$courses->id.'">'.$courses->course_code.'</td>
							 
							  <td>'.$courses->course_title.'</td>
							  <td>'.$courses->theory_credit.'+'.$courses->practicle_credit.'</td>
							  <td><input type="text" name="internal_theory[]" value="'.$courses->internal_theory.'"></td>
							  <td><input type="text" name="term_paper[]" value="'.$courses->term_paper.'"></td>
							  <td><input type="text" name="internal_practical[]" value="'.$courses->internal_practical.'"></td>
					     </tr>';
				}
				if($marks_type=='2'){
					//echo "hello"; exit;
					$i++;
				$checked = 'checked';
				$readonly='readonly';
				$trdata.='<tr>
							   <td><input type="hidden" name="internal_theory[]" value="'.$courses->internal_theory.'">
							   <input type="hidden" name="term_paper[]" value="'.$courses->term_paper.'">
							   <input type="hidden" name="internal_practical[]" value="'.$courses->internal_practical.'">
							   <input type="hidden" name="course_id[]" value="'.$courses->id.'">'.$courses->course_code.'</td>
							  <td>'.$courses->course_title.'</td>
							  <td>'.$courses->theory_credit.'+'.$courses->practicle_credit.'</td>
							  <td><input type="text" name="external_theory[]" value="'.$courses->external_theory.'"></td>
					     </tr>';
				}
			}
			echo $trdata; 
	 }
	

	
	

}
?>