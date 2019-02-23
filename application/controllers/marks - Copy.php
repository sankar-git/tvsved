<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Marks extends CI_Controller {
	
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
			
			if($this->session->userdata('sms'))
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
			}
	}
	function marksUpload()
	{
		
		
		$data['page_title']="Upload UG Marks";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['batches'] = $this->Discipline_model->get_batches(); 
		$data['semesters'] = $this->Discipline_model->get_semester(); 
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		
		$this->load->view('admin/marks/marks_upload_add_view',$data);
		
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
		
		$studentList= $this->Marks_model->get_student_assigned_marks($send);
	    //p($studentList); exit;
	    if(!empty($studentList[0]->course_id)){
		$trdata='';
			$i=0;
			foreach($studentList as $students)
			{
				if($marks_type=='1')
				{
					
				$i++;
				$checked = 'checked';
				$trdata.='<tr>
				        <td><input type="hidden" name="student_id[]" value="'.$students->id.'">'.$students->id.'</td>
						<td>'.$students->first_name.' '.$students->last_name.'</td>
						  <td><input type="text" name="theory_internal[]" value="'.$students->theory_internal.'"></td>
						  <td><input type="text" name="practical_internal[]" value="'.$students->practical_internal.'"></td>
						
						
						
					</tr>';
				}
				if($marks_type=='2'){
					$i++;
				$checked = 'checked';
				$readonly='readonly';
				$trdata.='<tr>
				       
						 <td><input type="hidden" name="student_id[]" value="'.$students->id.'">'.$students->id.'</td>
						<td>'.$students->first_name.' '.$students->last_name.'</td>
						  <td><input type="text" name="theory_internal[]" value="'.$students->theory_internal.'" '.$readonly.'></td>
						  <td><input type="text" name="practical_internal[]" value="'.$students->practical_internal.'" '.$readonly.'></td>
						  <td><input type="text" name="theory_external[]" value="'.$students->theory_external.'"></td>
						  <td><input type="text" name="practical_external[]" value="'.$students->practical_external.'"></td>
						
						
						
					</tr>';
				}
			}
			echo $trdata; 
		}
		else
		{   $studentListNew= $this->Marks_model->get_student_assigned_marks_course_where_not_inserted($send);
	//p($studentListNew); exit;
			$trdata='';
			$i=0;
			
			foreach($studentListNew as $students)
			{
				if($marks_type=='1')
				{
					
				$i++;
				$checked = 'checked';
				$trdata.='<tr>
				        <td><input type="hidden" name="student_id[]" value="'.$students->id.'">'.$students->id.'</td>
						<td>'.$students->first_name.' '.$students->last_name.'</td>
						  <td><input type="text" name="theory_internal[]" value=""></td>
						  <td><input type="text" name="practical_internal[]" value=""></td>
						
						
						
					</tr>';
				}
				if($marks_type=='2'){
					$i++;
				$checked = 'checked';
				$readonly='readonly';
				if($course_id==$students->course_id)
				{
				$trdata.='<tr>
				       
						 <td><input type="hidden" name="student_id[]" value="'.$students->id.'">'.$students->id.'</td>
						<td>'.$students->first_name.' '.$students->last_name.'</td>
						  <td><input type="text" name="theory_internal[]" value="'.$students->theory_internal.'" '.$readonly.'></td>
						  <td><input type="text" name="practical_internal[]" value="'.$students->practical_internal.'" '.$readonly.'></td>
						  <td><input type="text" name="theory_external[]" value=""></td>
						  <td><input type="text" name="practical_external[]" value=""></td>
						
						
						
					</tr>';
				}
				else
				{
				$trdata.='<tr>
				       
						 <td><input type="hidden" name="student_id[]" value="'.$students->id.'">'.$students->id.'</td>
						<td>'.$students->first_name.' '.$students->last_name.'</td>
						  <td><input type="text" name="theory_internal[]" value="" '.$readonly.'></td>
						  <td><input type="text" name="practical_internal[]" value="" '.$readonly.'></td>
						  <td><input type="text" name="theory_external[]" value="" '.$readonly.'></td>
						  <td><input type="text" name="practical_external[]" value="" '.$readonly.'></td>
						
						
						
					</tr>';	
				}
				}
			}
			echo $trdata; 
		}	
			
			
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
		
		if($marks_type=='1'){
				for($i=0;$i<count($theory_internal);$i++){
						$theory_marks=$theory_internal[$i];
						$practical_marks=$practical_internal[$i];
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
							'created_on'=>$register_date_time
						
						);
						//p($data); 
						
						
						$save = $this->Marks_model->save_ug_marks($data); 
						//print_r($save);
						if(!empty($save))
						{
							$return =1;
						}
						else{
							$return =0;
						}
				}//exit; 
	}
	if($marks_type=='2'){
				for($i=0;$i<count($theory_internal);$i++){
						$theory_marks=$theory_internal[$i];
						$practical_marks=$practical_internal[$i];
						$theory_external_marks=$theory_external[$i];
						$practical_external_marks=$practical_external[$i];
						$student_id=$student_ids[$i];
						$data2=array(
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
						//p($data1); 
						$save = $this->Marks_model->update_ug_marks($data2); 
						//print_r($save);
						if(!empty($save))
						{
							$return =1;
						}
						else{
							$return =0;
						}
				}  
	}
		echo $return;  
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
	


}
?>