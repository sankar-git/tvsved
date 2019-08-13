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
	
	function generateGradeChart()
	{
		   $campus_id=$this->input->post('campus_id');
	       $program_id=$this->input->post('program_id');
	       $degree_id=$this->input->post('degree_id');
	       $batch_id=$this->input->post('batch_id');
	       $semester_id=$this->input->post('semester_id');
	       $discipline_id=$this->input->post('discipline_id');
	       $course_input=$this->input->post('course_id');
	       $data['date_of_exam']=$this->input->post('date_of_exam');
	       $data['exam_type']=$exam_type=$this->input->post('exam_type');
		  // p($course_id); exit;
		  //===========================Subject Wise Mark====================================// 
		  if(!empty($this->input->post('subject_wise_mark')))
		  {  
	      
		   //$courseid=explode('-',$course_input);
		   //p($courseid); exit;
	       //$course_id=$courseid[0]; 
	      // $course_credit=$courseid[1]; 
	     //print_r($course_id); exit;
		 
		   $data['students_attendance'] = $this->Gradechart_model->get_attandence_sheet($campus_id,$degree_id,$batch_id,$course_input,$semester_id,$exam_type);
		   $data['campus_id'] = $campus_id=$this->input->post('campus_id');
		  // echo $this->db->last_query();exit;
		   $data['campus_id'] = $campus_id;
		   // $data['students_attendance'] = $students = $this->Generate_model->get_student_dummy_number($student_id,$semester_id);
			
					// $data['students_attendance']=$allData;
		   //echo $this->db->last_query();exit;
		 // p($data['students_attendance']); exit;
		  //getting batch and year
	      
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/grade/subject_wise_mark_view',$data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "registered_students.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','10','10','15','15'); 
			$this->m_pdf->pdf->setTitle('Subject Wise Mark Report');
			//$header=$this->load->view('admin/grade/subject_wise_header', $data, true);
			//$this->m_pdf->pdf->SetHTMLHeader($header);
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		  //===========================Registered Students====================================// 
		  if(!empty($this->input->post('reg_students')))
		  {  
			 /* if($degree_id=='1'){
				  $courseArr = explode("|",$course_input);
				$courseArr = explode("-",$courseArr[1]);
			  }*/
		   $course_id=$course_input;
		   
		   //p($courseid); exit;
	       //$course_id=$courseid[0]; 
	       //$course_credit=$courseid[1]; 
	     //  print_r($course_id); exit;
		  $data['date_of_exam']=$this->input->post('date_of_exam');
		  $data['registered_students'] = $this->Gradechart_model->get_registered_student($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id,$exam_type);
		 // p($data['registered_students']); exit;
		  //getting batch and year
	      
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/grade/registered_student_view',$data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "registered_students.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->setTitle('Student Registration');
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','15','15','15','15'); 
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
	          $course_id=$course_input;
		   //p($courseid); exit;
	       //$course_id=$courseid[0]; 
	      // $course_credit=$courseid[1]; 
	     //  print_r($course_id); exit;
		 
		  $data['aggregate_marks'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id);
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
	        $course_id=$course_input;
		   //p($courseid); exit;
	      // $course_id=$courseid[0]; 
	       //$course_credit=$courseid[1]; 
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
	        $course_id=$course_input;
		   //p($courseid); exit;
	       //$course_id=$courseid[0]; 
	      // $course_credit=$courseid[1]; 
	     //  print_r($course_id); exit;
		 
		  $data['aggregate_marks'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id);
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
			$this->m_pdf->pdf->setTitle('FINAL SUBJECT RESULT');
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 
		//====================Generate Empty End=====================================//
	    //====================Generate Attendance Start=====================================//
		  if(!empty($this->input->post('attendance')))
		  {  
	        $course_id=$course_input;
		   //p($courseid); exit;
	       //$course_id=$courseid[0]; 
	       //$course_credit=$courseid[1]; 
	     //echo "hello"; exit;
	     
	     //  print_r($course_id); exit;
		 
		 // $data['students_attendance'] = $this->Gradechart_model->get_aggregate_marks($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id);
		  $data['students_attendance'] = $this->Gradechart_model->get_attandence_sheet($campus_id,$degree_id,$batch_id,$course_id,$semester_id,$exam_type);
		  //echo $this->db->last_query();exit;
		//p($data['students_attendance']); exit;
		  //getting batch and year
	      
			//load the view and saved it into $html variable
			$html = $this->load->view('admin/grade/class_student_attandance_view.php',$data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "student_attendance.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->setTitle('Attendance Report');
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','15','15','15','15'); 
			//$header=$this->load->view('admin/grade/attendance_header', $data, true);
			//$this->m_pdf->pdf->SetHTMLHeader($header);
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	       //generate the PDF from the given html
			//$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 
		//====================Generate Attendance End=====================================//
		
		//====================Generate Pass Fail List Subject Wise Start=====================================//
		  if(!empty($this->input->post('pass_fail_list')))
		  {  
	        $course_id=$course_input;
		   //p($courseid); exit;
	      // $course_id=$courseid[0]; 
	       //$course_credit=$courseid[1]; 
	      if($degree_id=='1'){
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id);
			//echo $this->db->last_query();exit;
		    $subject_name=$data['subject_wise_list'][0]->course_title;
			$data['display'] = 'pass_fail_list';
			$data['title'] = 'Subject Wise Mark Report';
		   //load the view and saved it into $html variable
		   if($this->input->post('downloadpdf') == 'true'){
			$html = $this->load->view('admin/grade/subject_wise_pass_fail_list_bvsc.php',$data, true);
			$pdfFilePath = "student_subject_".$subject_name.".pdf";
	        //load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->AddPage('L');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	       //download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
		   }else{
			   echo  $this->load->view('admin/grade/subject_wise_pass_fail_list_bvsc.php',$data,true);exit;
		   }
		  }	
          if($degree_id!='1'){
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id);
		    $subject_name=$data['subject_wise_list'][0]->course_title;
		    //load the view and saved it into $html variable
			$html = $this->load->view('admin/grade/subject_wise_pass_fail_list_btech.php',$data, true);
			$pdfFilePath = "student_subject_".$subject_name.".pdf";
	        //load mPDF library
			$this->load->library('m_pdf');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	       //download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
		  }			  
		 }
		 
		//====================Generate Pass Fail List Subject Wise End=====================================//
		
		//====================Generate Fail List Subject Wise Start=====================================//
		  if(!empty($this->input->post('failed_list')))
		  { 
           $course_id=$course_input;
		  // p($_POST); exit;
	       //$course_id=$courseid[0]; 
	       //$course_credit=$courseid[1]; 	  
	      if($degree_id=='1'){
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id);
		    $subject_name=$data['subject_wise_list'][0]->course_title;
			$data['display'] = 'fail_list';
			$data['title'] = "Failed Student's Report";
		   //load the view and saved it into $html variable
		   if($this->input->post('downloadpdf') == 'true'){
				$html = $this->load->view('admin/grade/subject_wise_pass_fail_list_bvsc.php',$data, true);
				$pdfFilePath = "student_subject_".$subject_name.".pdf";
				//load mPDF library
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->AddPage('L');
			   //generate the PDF from the given html
				$this->m_pdf->pdf->WriteHTML($html);
			   //download it.
				$this->m_pdf->pdf->Output($pdfFilePath, "I");
				exit;
		   }else{
			   echo  $this->load->view('admin/grade/subject_wise_pass_fail_list_bvsc.php',$data,true);exit;
		   }
		  }	
          if($degree_id!='1'){
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id);
			//p($data['subject_wise_list']); exit;
		    $subject_name=$data['subject_wise_list'][0]->course_title;
		    //load the view and saved it into $html variable
			$html = $this->load->view('admin/grade/subject_wise_fail_list_btech.php',$data, true);
			$pdfFilePath = "student_subject.pdf";
	        //load mPDF library
			$this->load->library('m_pdf');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	       //download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
		  }			  
		 }
		 
		//====================Generate  Fail List Subject Wise End=====================================//
		
		
		 
		$data['page_title']="Course Wise Report";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['batches'] = $this->Discipline_model->get_batches(); 
		$data['semesters'] = $this->Discipline_model->get_semester(); 
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		
		$this->load->view('admin/grade/generate_class_grade_chart_view',$data);
		
	}
	function courseGroupWiseReport()
	{
		   $campus_id=$this->input->post('campus_id');
	       $program_id=$data['program_id']=$this->input->post('program_id');
	       $degree_id=$data['degree_id']=$this->input->post('degree_id');
	       $batch_id=$this->input->post('batch_id');
	       $data['semester_id']= $semester_id=$this->input->post('semester_id');
	       $discipline_id=$this->input->post('discipline_id');
	       $data['month']=$month=$this->input->post('month');
	       $data['year']=$year=$this->input->post('year');
	       $data['exam_type']=$exam_type=$this->input->post('exam_type');
	      $data['course_id']= $course_input=$this->input->post('course_id');
		  // p($course_id); exit;
		  //===========================Subject Wise Mark====================================// 
		  if(!empty($this->input->post('subject_wise_mark')))
		  {  
	      
		   //$courseid=explode('-',$course_input);
		   //p($courseid); exit;
	       //$course_id=$courseid[0]; 
	      // $course_credit=$courseid[1]; 
	     //print_r($course_id); exit;
		  	$data['month']=$month=$this->input->post('month');
	       $data['year']=$year=$this->input->post('year');
		  $data['course_count'] =  1;
		 /*if($degree_id == 1){
		   $courseArr = explode("|",$course_input);
		   $courseArr = explode("-",$courseArr[1]);
		   $course_input=$courseArr[0];
		  $data['course_count'] =  count($courseArr);
		 }*/
		   $data['numeralCodes'] =  array("I","II","III","IV","V","VI","VII","VIII","IX");
		   $data['students_attendance'] = $this->Gradechart_model->get_attandence_sheet($campus_id,$degree_id,$batch_id,$course_input,$semester_id,$exam_type);
		   //echo $this->db->last_query();exit;
		   $data['campus_id'] = $campus_id=$this->input->post('campus_id');
		  // echo $this->db->last_query();exit;
		   $data['campus_id'] = $campus_id;
		   // $data['students_attendance'] = $students = $this->Generate_model->get_student_dummy_number($student_id,$semester_id);
			
					// $data['students_attendance']=$allData;
		   //echo $this->db->last_query();exit;
		 // p($data['students_attendance']); exit;
		  //getting batch and year
	      
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/grade/subject_wise_mark_view',$data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "registered_students.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','10','10','15','15'); 
			$this->m_pdf->pdf->setTitle('Subject Wise Mark Report');
			//$header=$this->load->view('admin/grade/subject_wise_header', $data, true);
			//$this->m_pdf->pdf->SetHTMLHeader($header);
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		  //===========================Registered Students====================================// 
		 
		  //===========================Registered Students End====================================// 
		  
		  
		 //====================Generate Class Start=====================================//
		  if(!empty($this->input->post('class_grade')))
		  {  
	          $course_id=$course_input;
		   //p($courseid); exit;
	       //$course_id=$courseid[0]; 
	      // $course_credit=$courseid[1]; 
	     //  print_r($course_id); exit;
	          $data['month']=$month=$this->input->post('month');
	       $data['year']=$year=$this->input->post('year');
		 $courseArr = explode("-",$course_input);
		   $courseArr = explode("|",$courseArr[0]);
		  $data['course_count'] =  count($courseArr);
		   $data['numeralCodes'] =  array("I","II","III","IV","V","VI","VII","VIII","IX");
		  $data['aggregate_marks'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id,'',$exam_type);
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
			if($degree_id > 1){
				 $course_id=$course_input;
				 
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id);
		    $subject_name=$data['subject_wise_list'][0]->course_title;
			$data['display'] = 'pass_fail_list';
			$data['title'] = 'Subject Wise Mark Report';
			
		   //load the view and saved it into $html variable
		   if($this->input->post('downloadpdf') == 'true'){
		    //load the view and saved it into $html variable
			$html = $this->load->view('admin/grade/subject_wise_pass_fail_list_pg.php',$data, true);
			$pdfFilePath = "student_subject_".$subject_name.".pdf";
	        //load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','10','10','15','15');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	       //download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
			}else{
			   echo  $this->load->view('admin/grade/subject_wise_pass_fail_list_pg.php',$data,true);exit;
		   }
		  }	else{
	        $course_id=$course_input;
		  // p($_POST); exit;
	       //$course_id=$courseid[0]; 
	       //$course_credit=$courseid[1]; 	  
		   $courseArr = explode("-",$course_input);
		   $courseArr = explode("|",$courseArr[0]);
		  $data['course_count'] =  count($courseArr);
		   //p($courseid); exit;
	      // $course_id=$courseid[0]; 
	       //$course_credit=$courseid[1]; 
	     //  print_r($course_id); exit;
		 
		  $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id);
		 $courseGroup=array();
			$resultArray=array();
		 foreach($data['subject_wise_list'] as $subject_wise_val){
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
							  if(trim($theory_internal_total+$theory_marks_40) >=30 && $paper_20>=20 && trim($theory_internal_total+$theory_marks_40+$paper_20)>=50) 
								  $subject_wise_val->result = "PASS"; 
							  else 
								  $subject_wise_val->result =  "FAIL";
						  }
					$resultArray[$name][$subject_wise_val->course_subject_name][]=$subject_wise_val;
					//print_r($resultArray);exit;
				 }
		 }
		 if($degree_id=='1')
			ksort($courseGroupArr);
		 $data['result_marks'] =$resultArray;
		 $data['courseGroup'] =$courseGroupArr;
		  //echo $this->db->last_query();exit;
			//p($data['aggregate_marks']); exit;
		  //getting batch and year
	      
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/grade/class_grade_student_blank_view.php',$data, true);
			echo $html; exit;
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
		 }
		 
		//====================Generate Blank End=====================================//
		
		
		 //====================Generate Empty Start=====================================//
		  if(!empty($this->input->post('empty')))
		  {  
	        $course_id=$course_input;
		   //p($courseid); exit;
	       //$course_id=$courseid[0]; 
	      // $course_credit=$courseid[1]; 
	     //  print_r($course_id); exit;
		 
		  $data['aggregate_marks'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id);
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
			$this->m_pdf->pdf->setTitle('FINAL SUBJECT RESULT');
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 
		//====================Generate Empty End=====================================//
	    //====================Generate Attendance Start=====================================//
		 
		 
		//====================Generate Attendance End=====================================//
		
		//====================Generate Pass Fail List Subject Wise Start=====================================//
		  if(!empty($this->input->post('pass_fail_list')))
		  {  
	        $course_id=$course_input;
			
		   //p($courseid); exit;
	      // $course_id=$courseid[0]; 
	       //$course_credit=$courseid[1]; 
	      if($degree_id=='1'){
	      	$data['month']=$month=$this->input->post('month');
	       $data['year']=$year=$this->input->post('year');
			  $courseArr = explode("-",$course_input);
		   $courseArr = explode("|",$courseArr[0]);
		  $data['course_count'] =  count($courseArr);
		   $data['numeralCodes'] =  array("I","II","III","IV","V","VI","VII","VIII","IX");
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id,'',$exam_type);
			//echo $this->db->last_query();exit;
		    $subject_name=$data['subject_wise_list'][0]->course_title;
			$data['display'] = 'pass_fail_list';
			$data['title'] = 'Subject Wise Mark Report';
		   //load the view and saved it into $html variable
		   if($this->input->post('downloadpdf') == 'true'){
			$html = $this->load->view('admin/grade/subject_wise_pass_fail_list_bvsc.php',$data, true);
			$pdfFilePath = "student_subject_".$subject_name.".pdf";
	        //load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->AddPage('L');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	       //download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
		   }else{
			   echo  $this->load->view('admin/grade/subject_wise_pass_fail_list_bvsc.php',$data,true);exit;
		   }
		  }	
          if($degree_id!='1' && $program_id == 1){
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id,'',$exam_type);
		    $subject_name=$data['subject_wise_list'][0]->course_title;
			$data['display'] = 'pass_fail_list';
			$data['title'] = 'Subject Wise Mark Report';
			
		   //load the view and saved it into $html variable
		   if($this->input->post('downloadpdf') == 'true'){
		    //load the view and saved it into $html variable
			$html = $this->load->view('admin/grade/subject_wise_pass_fail_list_btech.php',$data, true);
			$pdfFilePath = "student_subject_".$subject_name.".pdf";
	        //load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','10','10','15','15');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	       //download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
			}else{
			   echo  $this->load->view('admin/grade/subject_wise_pass_fail_list_btech.php',$data,true);exit;
		   }
		  }
		if($program_id > 1){
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id,'',$exam_type);
		    $subject_name=$data['subject_wise_list'][0]->course_title;
			$data['display'] = 'pass_fail_list';
			$data['title'] = 'Subject Wise Mark Report';
			
		   //load the view and saved it into $html variable
		   if($this->input->post('downloadpdf') == 'true'){
		    //load the view and saved it into $html variable
			$html = $this->load->view('admin/grade/subject_wise_pass_fail_list_pg.php',$data, true);
			$pdfFilePath = "student_subject_".$subject_name.".pdf";
	        //load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','10','10','15','15');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	       //download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
			}else{
			   echo  $this->load->view('admin/grade/subject_wise_pass_fail_list_pg.php',$data,true);exit;
		   }
		  }		  
		 }
		 
		//====================Generate Pass Fail List Subject Wise End=====================================//
		
		//====================Generate Fail List Subject Wise Start=====================================//
		  if(!empty($this->input->post('failed_list')))
		  { 
           $course_id=$course_input;
		  // p($_POST); exit;
	       //$course_id=$courseid[0]; 
	       //$course_credit=$courseid[1]; 	  
		   $courseArr = explode("-",$course_input);
		   $courseArr = explode("|",$courseArr[0]);
		  $data['course_count'] =  count($courseArr);
	      if($degree_id=='1'){
			  
		   $data['numeralCodes'] =  array("I","II","III","IV","V","VI","VII","VIII","IX");
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id,'',$exam_type);
		//	p($data['subject_wise_list']);exit;
		    $subject_name=@$data['subject_wise_list'][0]->course_title;
			$data['display'] = 'fail_list';
			$data['title'] = "Failed Student's Report";
		   //load the view and saved it into $html variable
		   if($this->input->post('downloadpdf') == 'true'){
				$html = $this->load->view('admin/grade/subject_wise_pass_fail_list_bvsc.php',$data, true);
				$pdfFilePath = "student_subject_".$subject_name.".pdf";
				//load mPDF library
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->AddPage('L');
			   //generate the PDF from the given html
				$this->m_pdf->pdf->WriteHTML($html);
			   //download it.
				$this->m_pdf->pdf->Output($pdfFilePath, "I");
				exit;
		   }else{
			   echo  $this->load->view('admin/grade/subject_wise_pass_fail_list_bvsc.php',$data,true);exit;
		   }
		  }	
          if($degree_id!='1' && $program_id == 1){
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id,'',$exam_type);
			$data['display'] = 'fail_list';
			$data['title'] = "Failed Student's Report";
			//p($data['subject_wise_list']); exit;
		    $subject_name=$data['subject_wise_list'][0]->course_title;
		    //load the view and saved it into $html variable
			if($this->input->post('downloadpdf') == 'true'){
			$html = $this->load->view('admin/grade/subject_wise_pass_fail_list_btech.php',$data, true);
			$pdfFilePath = "student_subject.pdf";
	        //load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','10','10','15','15');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	       //download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
			}else{
				echo  $this->load->view('admin/grade/subject_wise_pass_fail_list_btech.php',$data,true);exit;
			}
		  }
		if($program_id > 1){
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id,'',$exam_type);
		    $subject_name=$data['subject_wise_list'][0]->course_title;
			$data['display'] = 'pass_fail_list';
			$data['title'] = 'Subject Wise Mark Report';
			
		   //load the view and saved it into $html variable
		   if($this->input->post('downloadpdf') == 'true'){
		    //load the view and saved it into $html variable
			$html = $this->load->view('admin/grade/subject_wise_pass_fail_list_pg.php',$data, true);
			$pdfFilePath = "student_subject_".$subject_name.".pdf";
	        //load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','10','10','15','15');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	       //download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
			}else{
			   echo  $this->load->view('admin/grade/subject_wise_pass_fail_list_pg.php',$data,true);exit;
		   }
		  }		  
		 }
		 
		//====================Generate  Fail List Subject Wise End=====================================//
		
		
		 
		$data['page_title']="Course Group Wise Report";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['batches'] = $this->Discipline_model->get_batches(); 
		$data['semesters'] = $this->Discipline_model->get_semester(); 
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		
		$this->load->view('admin/grade/course_group_wise_report',$data);
		
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