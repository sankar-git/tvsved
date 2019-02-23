<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Grade extends CI_Controller {
	
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
			$this->load->model('Gradechart_model');
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
	//======================================UG Marks Upload==================================================//
	
	function generateGradeChart()
	{
		   $campus_id=$this->input->post('campus_id');
	       $program_id=$this->input->post('program_id');
	       $degree_id=$this->input->post('degree_id');
	       $batch_id=$this->input->post('batch_id');
	       $semester_id=$this->input->post('semester_id');
	       $discipline_id=$this->input->post('discipline_id');
	       $course_id=$this->input->post('course_id');
		  //===========================Registered Students====================================// 
		  if(!empty($this->input->post('reg_students')))
		  {  
	      
	     //  print_r($course_id); exit;
		 
		  $data['registered_students'] = $this->Gradechart_model->get_registered_student($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id);
		  //p($data['registered_students']); exit;
		  //getting batch and year
	      
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/grade/registered_student_view',$data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "registered_students.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		  //===========================Registered Students End====================================// 
		  
		  
		 //====================Generate Class Start=====================================//
		  if(!empty($this->input->post('class_grade')))
		  {  
	     
	     //  print_r($course_id); exit;
		 
		  $data['aggregate_marks'] = $this->Gradechart_model->get_aggregate_marks($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id);
		// p($data['aggregate_marks']); exit;
		  //getting batch and year
	      
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/grade/class_grade_student_view',$data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "registered_students.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 
		//====================Generate Class End=====================================//

		 //====================Generate Blank Start=====================================//
		  if(!empty($this->input->post('blank')))
		  {  
	     
	     //  print_r($course_id); exit;
		 
		  $data['aggregate_marks'] = $this->Gradechart_model->get_aggregate_marks($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id);
		// p($data['aggregate_marks']); exit;
		  //getting batch and year
	      
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/grade/class_grade_student_blank_view.php',$data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "registered_students.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 
		//====================Generate Blank End=====================================//
		
		
		 //====================Generate Empty Start=====================================//
		  if(!empty($this->input->post('empty')))
		  {  
	     
	     //  print_r($course_id); exit;
		 
		  $data['aggregate_marks'] = $this->Gradechart_model->get_aggregate_marks($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id);
		// p($data['aggregate_marks']); exit;
		  //getting batch and year
	      
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/grade/class_grade_student_empty_view.php',$data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "registered_students.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 
		//====================Generate Empty End=====================================//
	    //====================Generate Attendance Start=====================================//
		  if(!empty($this->input->post('attendance')))
		  {  
	     //echo "hello"; exit;
	     
	     //  print_r($course_id); exit;
		 
		 // $data['students_attendance'] = $this->Gradechart_model->get_aggregate_marks($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id);
		  $data['students_attendance'] = $this->Gradechart_model->get_attandence_sheet($campus_id,$degree_id,$batch_id,$course_id);
	//p($data['students_attendance']); exit;
		  //getting batch and year
	      
			//load the view and saved it into $html variable
			$html = $this->load->view('admin/grade/class_student_attandance_view.php',$data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "student_attendance.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 
		//====================Generate Attendance End=====================================//
		 
		$data['page_title']="Generate Class Grade Chart";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['batches'] = $this->Discipline_model->get_batches(); 
		$data['semesters'] = $this->Discipline_model->get_semester(); 
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		
		$this->load->view('admin/grade/generate_class_grade_chart_view',$data);
		
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
		 
		//print_r($_POST); exit;
		
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
		$studentAssignCourses = $this->Marks_model->get_student_assigned_courses($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$student_id);
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