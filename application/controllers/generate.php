<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Generate extends CI_Controller {
	
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
	   	 $this->load->library('m_pdf');
		 $this->load->model('Gradechart_model');
		 
		  $this->load->model('Discipline_model');
		  $this->load->model('Master_model');
		  $this->load->model('Generate_model');
		  $this->load->model('Result_model');
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
	function arrear_hall_ticket(){
		$list['first_name']  ='Akash Pandi S';
		 $list['last_name']  ='';
		 $list['user_unique_id']  ='BTP 17002';
		 $list['user_image']  ='';
		 $list['batch_name']  ='2017-2018';
		 $list['campus_name']  ='CPPM, Hosur';
		 $list['campus_code']  ='CPPM, Hosur';
		 $list['degree_name']  ='B.Tech-PT';
		 $list['degree_code']  ='B.Tech-PT';
		 $list['month_year']  ='February 2019';
		 $list['semester_name']  ='FIRST SEMESTER';
		$dataList =array();
		$data['course_id']   = 1;
		   $data['course_code']   = 'PEG 112';
		   $data['course_title']   = 'Manufacturing Process';
		   $dataList[] = $data;
		   $data['course_id']   = 1;
		   $data['course_code']   = 'PEG 115';
		   $data['course_title']   = 'Principles of Civil Engineering';
		   $dataList[] = $data;
		   $data['course_id']   = 1;
		   $data['course_code']   = 'PEG 124';
		   $data['course_title']   = 'Thermodynamics';
		   $dataList[] = $data;
		$list['subjectList'] = $dataList;
		$allData[] = $list;  
		
		$list['first_name']  ='Azarudeen. A';
		 $list['user_unique_id']  ='BTP 17004';
		$dataList =array();
		$data['course_id']   = 1;
		   $data['course_code']   = 'PSE 111';
		   $data['course_title']   = 'Biochemistry';
		   $dataList[] = $data;
		   $data['course_id']   = 1;
		   $data['course_code']   = 'PEG 115';
		   $data['course_title']   = 'Principles of Civil Engineering';
		   $dataList[] = $data;
		   $list['subjectList'] = $dataList;
		$allData[] = $list;  
		
		
		$list['first_name']  ='Balu. M';
		 $list['user_unique_id']  ='BTP 17005';
		$dataList =array();
		$data['course_id']   = 1;
	   $data['course_code']   = 'PEG 112';
	   $data['course_title']   = 'Manufacturing Process';
	   $dataList[] = $data;
		$list['subjectList'] = $dataList;
		$allData[] = $list;  
  
  
		$list['first_name']  ='Jagannathan. N';
		$list['user_unique_id']  ='BTP 17010';
		$dataList =array();
		$data['course_id']   = 1;
	   $data['course_code']   = 'PEG 115';
	   $data['course_title']   = 'Principles of Civil Engineering';
	   $dataList[] = $data;
		$list['subjectList'] = $dataList;
		$allData[] = $list; 
		
		
		$list['first_name']  ='Jeevitha. S';
		$list['user_unique_id']  ='BTP 17OI1';
		$dataList =array();
		$data['course_id']   = 1;
	   $data['course_code']   = 'PEG 111';
	   $data['course_title']   = 'Biochemistry';
	   $dataList[] = $data;
	   $data['course_id']   = 1;
	   $data['course_code']   = 'PEG 112';
	   $data['course_title']   = 'Manufacturing Process';
	   $dataList[] = $data;
	   $data['course_id']   = 1;
	   $data['course_code']   = 'PEG 115';
	   $data['course_title']   = 'Principles of Civil Engineering';
	   $dataList[] = $data;
		$list['subjectList'] = $dataList;
		$allData[] = $list; 
		
		
		$list['first_name']  ='Magesh. S';
		$list['user_unique_id']  ='BTP 17015';
		$dataList =array();
		$data['course_id']   = 1;
	   $data['course_code']   = 'PEG 112';
	   $data['course_title']   = 'Manufacturing Process';
	   $dataList[] = $data;
	   $data['course_id']   = 1;
	   $data['course_code']   = 'PEG 123';
	   $data['course_title']   = 'Materials and Structural Engineering';
	   $dataList[] = $data;
		$list['subjectList'] = $dataList;
		$allData[] = $list; 
		
		$list['first_name']  ='Naveen Kumar. S';
		$list['user_unique_id']  ='BTP 17018';
		$dataList =array();
		$data['course_id']   = 1;
	   $data['course_code']   = 'PEG 112';
	   $data['course_title']   = 'Manufacturing Process';
	   $dataList[] = $data;
		$list['subjectList'] = $dataList;
		$allData[] = $list; 
		
		$list['first_name']  ='Pooja. T';
		$list['user_unique_id']  ='BTP 17022';
		$dataList =array();
		$data['course_id']   = 1;
	   $data['course_code']   = 'PEG 112';
	   $data['course_title']   = 'Manufacturing Process';
	   $dataList[] = $data;
		$list['subjectList'] = $dataList;
		$allData[] = $list; 
		
		$list['first_name']  ='Rabart. T';
		$list['user_unique_id']  ='BTP 17024';
		$dataList =array();
		$data['course_id']   = 1;
	   $data['course_code']   = 'PEG 112';
	   $data['course_title']   = 'Manufacturing Process';
	   $dataList[] = $data;
		$list['subjectList'] = $dataList;
		$allData[] = $list; 
		
		$list['first_name']  ='Sakthivel. S';
		$list['user_unique_id']  ='BTP 17025';
		$dataList =array();
		$data['course_id']   = 1;
	   $data['course_code']   = 'PEG 112';
	   $data['course_title']   = 'Manufacturing Process';
	   $dataList[] = $data;
	   $data['course_id']   = 1;
	   $data['course_code']   = 'PEG 115';
	   $data['course_title']   = 'Principles of Civil Engineerine';
	   $dataList[] = $data;
		$list['subjectList'] = $dataList;
		$allData[] = $list; 
		
		
		$list['first_name']  ='Santhoshini. S';
		$list['user_unique_id']  ='BTP 17026';
		$dataList =array();
		$data['course_id']   = 1;
	   $data['course_code']   = 'PEG 111';
	   $data['course_title']   = 'Biochemistry';
	   $dataList[] = $data;
	   $data['course_id']   = 1;
	   $data['course_code']   = 'PEG 112';
	   $data['course_title']   = 'Manufacturing Process';
	   $dataList[] = $data;
	   $data['course_id']   = 1;
	   $data['course_code']   = 'PEG 115';
	   $data['course_title']   = 'Principles of Civil Engineering';
	   $dataList[] = $data;
	   $data['course_id']   = 1;
	   $data['course_code']   = 'PEG 124';
	   $data['course_title']   = 'Thermodynamics';
	   $dataList[] = $data;
		$list['subjectList'] = $dataList;
		$allData[] = $list; 
		
		$list['first_name']  ='Vignesh. G';
		$list['user_unique_id']  ='BTP 17035';
		$dataList =array();
		$data['course_id']   = 1;
	   $data['course_code']   = 'PEG 111';
	   $data['course_title']   = 'Biochemistry';
	   $dataList[] = $data;
	   $data['course_id']   = 1;
	   $data['course_code']   = 'PEG 112';
	   $data['course_title']   = 'Manufacturing Process';
	   $dataList[] = $data;
		$list['subjectList'] = $dataList;
		$allData[] = $list; 
		
		
		$data['hall_tickets']=$allData;
		$html=$this->load->view('admin/pdf/hall_ticket_view', $data, true);
		// print_r($html); exit;
		//this the the PDF filename that user will get to download
		$pdfFilePath = "hall_ticket.pdf";
		//load mPDF library
		$this->load->library('m_pdf');
		$this->m_pdf->pdf->SetTitle('HallTicket');
	   //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->Output($pdfFilePath, "I");
		exit;			
	}
	function generateRegistrationCard()
	{    
	
	     	//print_r($_POST); exit;
	   
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$semester_id=$this->input->post('semester_id');
		$batch_id=$this->input->post('batch_id');
		$date_of_start=$this->input->post('date_of_start');
		//$date_of_closure=$this->input->post('date_of_closure');
		$student_id=$this->input->post('student_id');
		$data['exam_type']=$exam_type=$this->input->post('exam_type');
		$data['month']=$month=$this->input->post('month');
	       $data['year']=$year=$this->input->post('year');
	    $send['campus_id']=$campus_id;
	    $send['program_id']=$program_id;
	    $send['degree_id']=$degree_id;
	    $send['batch_id']=$batch_id;
	    $month=$this->input->post('month');
		$year=$this->input->post('year');
	     if(!empty($this->input->post('get_print')))
		 {  
		     	
	       
	        $data['campuses'] = $this->Discipline_model->get_campus(); 
	         
			 //print_r($student_id); exit;
			$data = [];
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/print_pdf', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "print.pdf";
         
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
        	
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
		   
            exit;			
		 }


		 if(!empty($this->input->post('reg_card')))
		 {  
	           
	           // $data['campuses'] = $this->Discipline_model->get_campus(); 
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				
				//print_r($date_of_closure); exit;
				// $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				// print_r($batchYear->date_of_closure); exit;
				 //$batch_year=$batchYear->date_of_closure;
				// print_r($batch_year); exit;
				 //$yrdata= strtotime($batch_year);
                 $monthYrr= $month.' '.$year;				 
			//	print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
				     $semesterRow = $this->Result_model->get_semester_name($semester_id); 
					 $students = $this->Generate_model->get_studedent_data($student_id);
					// p($students); exit;
					 foreach($students as $stuData)
					 {
						$subjectList = $this->Generate_model->get_student_assigned_subjects_bvsc($stuData->user_id,$semester_id,$exam_type);
						//echo $this->db->last_query();exit;
						// p($subjectList); 
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_name']  =$stuData->degree_name;
						     $list['degree_code']  =$stuData->degree_code;
						     $list['month_year']  =$monthYrr;
						     $list['semester_name']  =$semesterRow->semester_name;
						     $list['semester_code']  =$semesterRow->semester_code;
						     $list['created_on']  =$stuData->created_on;
						    //p($list); exit;
								 $dataList =array();
								 foreach($subjectList as $subjectVal)
								 {    
							        $data['course_id']   = $subjectVal->id;
									$data['course_code']   = $subjectVal->course_code;
									$data['theory_credit']   = $subjectVal->theory_credit;
									$data['practicle_credit']   = $subjectVal->practicle_credit;   
									   $dataList[] = $data;
								 }
								// p($dataList); exit;
						    $list['subjectList'] = $dataList;
						    $allData[] = $list;  
					 }  
				     $data['reg_cards']=$allData;
				
			//	p( $data['hall_tickets']); exit;
			
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/pdf/reg_card_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "registration_card.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->SetTitle('registrationCard');
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	        $this->m_pdf->pdf->Output($pdfFilePath, "I");
		
            exit;			
		 }
		 
		 //*************************Generate Hall Ticket*********************************//
		
		 if(!empty($this->input->post('hall_ticket')))
		 {  
	           
	           // $data['campuses'] = $this->Discipline_model->get_campus(); 
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				
				//print_r($date_of_closure); exit;
				// $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				// print_r($batchYear->date_of_closure); exit;
				 //$batch_year=$batchYear->date_of_closure;
				// print_r($batch_year); exit;
				 //$yrdata= strtotime($batch_year);
                 $monthYrr= $month.' '.$year;				 
			//	print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
				     $semesterRow = $this->Result_model->get_semester_name($semester_id); 
					 $students = $this->Generate_model->get_studedent_data($student_id);
					// p($students); exit;
					 foreach($students as $stuData)
					 {
						$subjectList = $this->Generate_model->get_student_assigned_subjects($stuData->user_id,$semester_id,$exam_type);
						//echo $this->db->last_query();exit;
						// p($subjectList); 
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_name']  =$stuData->degree_name;
						     $list['degree_code']  =$stuData->degree_code;
						     $list['month_year']  =$monthYrr;
						     $list['semester_name']  =$semesterRow->semester_name;
						    //p($list); exit;
								 $dataList =array();
								 foreach($subjectList as $subjectVal)
								 {    
							           $data['course_id']   = $subjectVal->id;
									   $data['course_code']   = $subjectVal->course_code;
									   $data['course_title']   = $subjectVal->course_title;
									  
									   $dataList[] = $data;
								 }
								// p($dataList); exit;
						    $list['subjectList'] = $dataList;
						    $allData[] = $list;  
					 }  
				     $data['hall_tickets']=$allData;
				
			//	p( $data['hall_tickets']); exit;
			
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/pdf/hall_ticket_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "hall_ticket.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->SetTitle('HallTicket');
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	        $this->m_pdf->pdf->Output($pdfFilePath, "I");
		
            exit;			
		 }
		 //*************************Generate Hall Ticket End*********************************//
		 
		 
		  //*************************Generate Hall with Date Ticket*********************************//
		 if(!empty($this->input->post('hall_ticket_with_date')))
		 {  
	 
	         // $data['campuses'] = $this->Discipline_model->get_campus(); 
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				//$date_of_closure=$this->input->post('date_of_closure');
				//print_r($date_of_closure); exit;
				 $semesterRow = $this->Result_model->get_semester_name($semester_id); 
				 //$batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				// print_r($batchYear->date_of_closure); exit;
				// $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				// $yrdata= strtotime($batch_year);
                 $monthYrr= $month.' '.$year;
				 //print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Generate_model->get_studedent_data($student_id);
					// p($students); exit;
					foreach($students as $stuData)
					 {
						
						$subjectList = $this->Generate_model->get_student_assigned_subjects($stuData->user_id,$semester_id,$exam_type);
						// p($subjectList); 
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
							 $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
							  $list['campus_code']  =$stuData->campus_code;
						     $list['degree_name']  =$stuData->degree_name;
							 $list['degree_code']  =$stuData->degree_code;
							 $list['user_image']  =$stuData->user_image;
						     $list['month_year']  =$monthYrr;
							 $list['semester_name']  =$semesterRow->semester_name;
						    
								 $dataList =array();
								 foreach($subjectList as $subjectVal)
								 {    
							           $data['course_id']   = $subjectVal->id;
									   $data['course_code']   = $subjectVal->course_code;
									   $data['course_title']   = $subjectVal->course_title;
									    $dateArr= $this->Generate_model->get_student_assigned_subjects_with_date($subjectVal->id);
									  // echo $this->db->last_query();print_r($dateArr);exit;
									   $data['exam_date']   = $dateArr[0]->exam_date;
									   $dataList[] = $data;
								 }
								// p($dataList); exit;
						    $list['subjectList'] = $dataList;
						    $allData[] = $list;  
					 }  
				     $data['hall_tickets']=$allData;
				
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/pdf/hall_ticket_with_date_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "hall_ticket_with_date.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->SetTitle('HallTicket with dates');
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 //*************************Generate Hall Ticket with date End*********************************//
		 
		 
		  //*************************Dummy Start*********************************//
		 if(!empty($this->input->post('dummy')))
		 {  
	 
	         
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				$date_of_closure=$this->input->post('date_of_closure');
				
				//print_r($date_of_closure); exit;
				 $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				// print_r($batchYear->date_of_closure); exit;
				 $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				 $yrdata= strtotime($batch_year);
                 $monthYrr= date('F Y', $yrdata);
				 //print_r($monthYrr); exit;
				
				
				$student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Generate_model->get_student_dummy_number($student_id,$semester_id);
					 
					//p($students); exit;
					 foreach($students as $stuData)
					 {
						
						$subjectList = $this->Generate_model->get_student_assigned_subjects($stuData->user_id,$semester_id,$exam_type);
						// p($subjectList); 
						     
						     $list['student_unique_id']  =$stuData->user_unique_id;
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_name']  =$stuData->degree_name;
						     $list['degree_code']  =$stuData->degree_code;
						     $list['semester_name']  =$stuData->semester_name;
							 $list['month_year']  =$monthYrr;
							 $list['dummy_value']  =$stuData->dummy_value;
							 $list['exam_month']  =$stuData->exam_month;
						    
								 $dataList =array();
								 foreach($subjectList as $subjectVal)
								 {    
							           $data['course_id']   = $subjectVal->id;
									   $data['course_code']   = $subjectVal->course_code;
									   $data['course_title']   = $subjectVal->course_title;
									   $dataList[] = $data;
								 }
								// p($dataList); exit;
						    $list['subjectList'] = $dataList;
						    $allData[] = $list;  
					 }  
				     $data['dummy_number_report']=$allData;
				
				
			//p($data['dummy_number_report']);exit;
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/pdf/dummy_view', $data, true);
			
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "dummy.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','15','15','15','15'); 
			//$header=$this->load->view('admin/pdf/dummy_header', $data, true);
			//$this->m_pdf->pdf->SetHTMLHeader($header);
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
			
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 //*************************Dummy End*********************************//
		 
		  //*************************Gally Start*********************************//
		 if(!empty($this->input->post('gally')))
		 {  
	 
	         
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				$date_of_closure=$this->input->post('date_of_closure');
				
				//print_r($date_of_closure); exit;
				 $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				// print_r($batchYear->date_of_closure); exit;
				 $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				 $yrdata= strtotime($batch_year);
                 $monthYrr= date('F Y', $yrdata);
				 //print_r($monthYrr); exit;
				
				
				$student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Generate_model->get_student_dummy_number($student_id,$semester_id);
					//p($students); exit;
					 foreach($students as $stuData)
					 {
						
						$subjectList = $this->Generate_model->get_student_assigned_subjects($stuData->user_id,$semester_id,$exam_type);
						// p($subjectList); 
						     
						     $list['student_unique_id']  =$stuData->user_unique_id;
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_name']  =$stuData->degree_name;
						     $list['degree_code']  =$stuData->degree_code;
						     $list['semester_name']  =$stuData->semester_name;
							 $list['month_year']  =$monthYrr;
						    
								 $dataList =array();
								 foreach($subjectList as $subjectVal)
								 {    
							           $data['course_id']   = $subjectVal->id;
									   $data['course_code']   = $subjectVal->course_code;
									   $data['course_title']   = $subjectVal->course_title;
									   $dataList[] = $data;
								 }
								// p($dataList); exit;
						    $list['subjectList'] = $dataList;
						    $allData[] = $list;  
					 }  
				     $data['dummy_number_report']=$allData;
				
				
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/pdf/gally_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "gally_view.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->setTitle('Gally Report');
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','15','15','15','15'); 
			//$header=$this->load->view('admin/pdf/gally_header', $data, true);
			//$this->m_pdf->pdf->SetHTMLHeader($header);
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 //*************************Gally End*********************************//
		 
		 
		 
		 
		 
		 
		 
		 //*************************Rules*********************************//
		 if(!empty($this->input->post('rules')))
		 {  
	 
	        $data['campuses'] = $this->Discipline_model->get_campus(); 
	         
			 //print_r($student_id); exit;
			
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/pdf/rules_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "rules.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->setTitle('Rules');
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
			
            exit;			
		 }
		  if(!empty($this->input->post('empty')))
		  {  
	        //$course_id=$course_input;
		   //p($courseid); exit;
	       //$course_id=$courseid[0]; 
	      // $course_credit=$courseid[1]; 
	     //  print_r($course_id); exit;
		 
		  $data['aggregate_marks'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,'',$student_id,$exam_type);
		  //echo $this->db->last_query();exit;
			$courseGroup=array();
			$resultArray=array();
		 foreach($data['aggregate_marks'] as $subject_wise_val){
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
				 $resultArray[$name][$subject_wise_val->course_code][]=$subject_wise_val;
				 //print_r($resultArray);exit;
			 }
			 
		  }//exit;
		   if($degree_id=='1')
			ksort($courseGroupArr);
		 $data['result_marks'] =$resultArray;
		 $data['courseGroup'] =$courseGroupArr;
		 
		  //echo $this->db->last_query();exit;
		 //p( $resultArray); 
		// p( $courseGroupArr); exit;
		  //getting batch and year
	      
			//load the view and saved it into $html variable;
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
		 
		 
		 if(!empty($this->input->post('moderation')))
		  {  
	        //$course_id=$course_input;
		   //p($courseid); exit;
	       //$course_id=$courseid[0]; 
	      // $course_credit=$courseid[1]; 
	     //  print_r($course_id); exit;
		 
		  $data['aggregate_marks'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,'',$student_id,$exam_type);
		  //echo $this->db->last_query();exit;
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
						$subject_wise_val->result = "P"; 
					else 
						$subject_wise_val->result =  "F";
				 $resultArray[$name][$subject_wise_val->course_code][]=$subject_wise_val;
				 //print_r($resultArray);exit;
			 }
			 
		  }
		   if($degree_id=='1')
			ksort($courseGroupArr);
		 $data['result_marks'] =$resultArray;
		 $data['courseGroup'] =$courseGroupArr;
		 
		  //echo $this->db->last_query();exit;
		 //p( $resultArray); 
		// p( $courseGroupArr); exit;
		  //getting batch and year
	      
			//load the view and saved it into $html variable;
			 $html=$this->load->view('admin/grade/class_grade_moderation_view.php',$data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "registered_students.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->setTitle('Moderation Mark');
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 
		 //*************************Rules End*********************************//
		 
		 //*************************Exam Appearance Start*********************************//
		 if(!empty($this->input->post('exam_appearence')))
		 {  
	 
	         
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				$date_of_closure=$this->input->post('date_of_closure');
				
				//print_r($date_of_closure); exit;
				 $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				// print_r($batchYear->date_of_closure); exit;
				 $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				 $yrdata= strtotime($batch_year);
                 $monthYrr= date('M-Y', $yrdata);
				 //print_r($monthYrr); exit;
				 $programData = $this->Generate_model->get_program_name_by_program_id($program_id); //getting program name from program id
				$program_name=$programData->program_name;
				$student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Generate_model->get_student_dummy_number($student_id,$semester_id);
					//p($students); exit;
					 foreach($students as $stuData)
					 {
						if($degree_id == 1){
							$subjectList = $this->Generate_model->get_student_assigned_subjects_bvsc($stuData->user_id,$semester_id,$exam_type);
						}else{
							$subjectList = $this->Generate_model->get_student_assigned_subjects($stuData->user_id,$semester_id,$exam_type);
						}
						// p($subjectList); 
						     
						     $list['student_unique_id']  =$stuData->user_unique_id;
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_code']  =$stuData->degree_code;
						     $list['degree_name']  =$stuData->degree_name;
						     $list['semester_name']  =$stuData->semester_name;
						     $list['gender']  =$stuData->gender;
						     $list['admission_year']  =date('Y',strtotime($stuData->created_on));
							 $list['month_year']  =$monthYrr;
							 $list['program_name']  =$program_name;
						    
								 $dataList =array();
								 foreach($subjectList as $subjectVal)
								 {    
							           $data['course_id']   = $subjectVal->id;
									   $data['course_subject_title']   = $subjectVal->course_subject_title;
									   $data['course_title']   = $subjectVal->course_title;
									   $data['theory_credit']   = $subjectVal->theory_credit;
									   $data['practical_credit']   = $subjectVal->practicle_credit;
									   $data['course_subject_id']   = $subjectVal->course_subject_id;
									   $dataList[] = $data;
								 }
								// p($dataList); exit;
						    $list['subjectList'] = $dataList;
						    $allData[] = $list;  
					 }  
				     $data['exam_appearance']=$allData;
				
				
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/pdf/exam_appearence_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "exam.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->setTitle('Exam Appearance');
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 //*************************Exam Appreance End*********************************//
		 
		 
		 
		 
		 
		 
		 
		 $data['page_title']="Generate Registration Card";
		 $data['campuses'] = $this->Discipline_model->get_campus(); 
		 $data['semesters'] = $this->Generate_model->get_semester(); 
		 $this->load->view('admin/generate_registration_card_view',$data);
		
		
	}
	
	//ajax function for generate registration card
	
	function getProgramByCampus()
	{   
	    $campus_id = $this->input->post('campus_id');
		
		 $data['programs'] = $this->Generate_model->get_program_by_campus($campus_id);
		// print_r($data['programs']); exit;
         $str = '';
         foreach($data['programs'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->program_name."</option>";
           }
		   
           echo $str;		
	}
	
	function getDegreebyProgram()
	{
		$program_id = $this->input->post('program_id');
		$campus_id = $this->input->post('campus_id');
		$data['degrees']=$this->Generate_model->get_degree_by_program_id($program_id,$campus_id); 
		 $str = '';
         foreach($data['degrees'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->degree_name."</option>";
           }
		   echo $str;
         
	}
	function getBatchbyDegree()
	{
		$degree_id = $this->input->post('degree_id');
		$data['batches']=$this->Generate_model->get_batch_by_degree($degree_id); 
		//print_r($data['batches']); exit;
		 $str = '';
         foreach($data['batches'] as $k=>$v){   
            $str .= "<option value=".$v->id.">".$v->batch_name."</option>";
           }
		   
           echo $str;
	}
	function getSemesterbyDegree()
	{
		$degree_id = $this->input->post('degree_id');
		$data['semester']=$this->Generate_model->get_semester_by_degree($degree_id); 
		//print_r($data['semester']); exit;
		 $str = '';
         foreach($data['semester'] as $k=>$v){   
            $str .= "<option value=".$v->id.">".$v->semester_name."</option>";
           }
		   
           echo $str;
	}
	
	
	function getBatchbyDOS()
	{
		$degree_id = $this->input->post('degree_id');
		$data['dos']=$this->Generate_model->get_date_by_degree($degree_id); 
		 $str = '';
         foreach($data['dos'] as $k=>$v){   
		 if(!empty($v->start_date))
          $str .= "<option value=".$v->id.">".$v->start_date."</option>";
           }
		   
           echo $str;
	}
	
	
	function getBatchbyDOC()
	{
		$degree_id = $this->input->post('degree_id');
		$data['doc']=$this->Generate_model->get_date_by_degree($degree_id); 
		//print_r($data['doc']); exit;
		 $str = '';
         foreach($data['doc'] as $k=>$v){   
				if(!empty($v->date_of_closure))
		 $str .= "<option value=".$v->id.">".$v->date_of_closure."</option>";
           }
		   
           echo $str;
	}
	
	
	function getStudentList()
	{
		    
			//print_r($_POST); exit;
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$semester_id=$this->input->post('semester_id');
		$exam_type=$this->input->post('exam_type');
		$batch_id=$this->input->post('batch_id');
		$date_of_start=$this->input->post('date_of_start');
		$date_of_closure=$this->input->post('date_of_closure');
		
	    $send['campus_id']=$campus_id;
	    $send['program_id']=$program_id;
	    $send['degree_id']=$degree_id;
	    $send['batch_id']=$batch_id;
	    $send['semester_id']=$semester_id;
	    $send['exam_type']=$exam_type;
	    $studentList= $this->Generate_model->get_student_list_for_registration($send);
		//echo $this->db->last_query();
	  //print_r($studentList); exit;
	
		$trdata='';
			$i=0;
			foreach($studentList as $students)
			{
				
				$i++;
				$checked = 'checked';
				$trdata.='<tr>
				      <td ><input type="checkbox" class="checkbox"  id="select_all" name="student_id[]" value="'.$students->user_id.'"></td>
						<td>'.$i.'</td>
						<td>'.$students->user_unique_id.'</td>
						<td>'.$students->batch_name.'</td>
						<td>'.$students->first_name.' '.$students->last_name.'</td>
						
						
						
						
					</tr>';
			}
			echo $trdata; 
	}
	function getPrint()
	{
		
		//print_r($student_id); exit;
		$data = [];
        //load the view and saved it into $html variable
        $html=$this->load->view('admin/print_pdf', $data, true);
        // print_r($html); exit;
        //this the the PDF filename that user will get to download
        $pdfFilePath = "output_pdf_name.pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");   
       
	}
	function downloadPdf()
	{
		//print_r($student_id); exit;
		$data = [];
        //load the view and saved it into $html variable
        $html=$this->load->view('admin/print_pdf', $data, true);
        // print_r($html); exit;
        //this the the PDF filename that user will get to download
        $pdfFilePath = "output_pdf_name.pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		return true; exit;
	}
	
	
}
?>