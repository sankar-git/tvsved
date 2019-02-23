<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Generatenazim extends CI_Controller {
	
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
		 
		 
		  $this->load->model('Discipline_model');
		  $this->load->model('Master_model');
		  $this->load->model('Generate_model');
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
	function generateRegistrationCard()
	{    
	
	     	//print_r($_POST); exit;
	   
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$semester_id=$this->input->post('semester_id');
		$batch_id=$this->input->post('batch_id');
		$date_of_start=$this->input->post('date_of_start');
		$date_of_closure=$this->input->post('date_of_closure');
		$student_id=$this->input->post('student_id');
		
	    $send['campus_id']=$campus_id;
	    $send['program_id']=$program_id;
	    $send['degree_id']=$degree_id;
	    $send['batch_id']=$batch_id;
	
	     if(!empty($this->input->post('get_print')))
		 {  
		     	
	       
	        $data['campuses'] = $this->Discipline_model->get_campus(); 
	         
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
        	
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
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
				$date_of_closure=$this->input->post('date_of_closure');
				//print_r($date_of_closure); exit;
				 $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				// print_r($batchYear->date_of_closure); exit;
				 $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				 $yrdata= strtotime($batch_year);
                 $monthYrr= date('M-Y', $yrdata);
				 //print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Generate_model->get_studedent_data($student_id);
					// p($students); exit;
					ob_start();
					 foreach($students as $stuData)
					 {
						$subjectList = $this->Generate_model->get_student_assigned_subjects($stuData->user_id);
						// p($subjectList); 
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['degree_name']  =$stuData->degree_name;
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
				     $data['hall_tickets']=$allData;
				
				
			
			  ini_set('memory_limit', '256M'); 
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/pdf/hall_ticket_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "output_pdf_name.pdf";
	       
			//load mPDF library
			$this->load->library('m_pdf');
	        
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
		    ob_end_clean(); 
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
			//ob_start();
			
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
				$date_of_closure=$this->input->post('date_of_closure');
				//print_r($date_of_closure); exit;
				 $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				// print_r($batchYear->date_of_closure); exit;
				 $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				 $yrdata= strtotime($batch_year);
                 $monthYrr= date('M-Y', $yrdata);
				 //print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Generate_model->get_studedent_data($student_id);
					// p($students); exit;
					 foreach($students as $stuData)
					 {
						
						$subjectList = $this->Generate_model->get_student_assigned_subjects($stuData->user_id);
						// p($subjectList); 
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['degree_name']  =$stuData->degree_name;
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
				     $data['hall_tickets']=$allData;
				
				
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/pdf/hall_ticket_with_date_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "output_pdf_name.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
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
                 $monthYrr= date('M-Y', $yrdata);
				 //print_r($monthYrr); exit;
				
				
				$student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Generate_model->get_student_dummy_number($student_id,$semester_id);
					//p($students); exit;
					 foreach($students as $stuData)
					 {
						
						$subjectList = $this->Generate_model->get_student_assigned_subjects($stuData->user_id);
						// p($subjectList); 
						     
						     $list['student_unique_id']  =$stuData->user_unique_id;
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['degree_name']  =$stuData->degree_name;
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
				
				
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/pdf/dummy_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "output_pdf_name.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
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
                 $monthYrr= date('M-Y', $yrdata);
				 //print_r($monthYrr); exit;
				
				
				$student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Generate_model->get_student_dummy_number($student_id,$semester_id);
					//p($students); exit;
					 foreach($students as $stuData)
					 {
						
						$subjectList = $this->Generate_model->get_student_assigned_subjects($stuData->user_id);
						// p($subjectList); 
						     
						     $list['student_unique_id']  =$stuData->user_unique_id;
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['degree_name']  =$stuData->degree_name;
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
			$pdfFilePath = "output_pdf_name.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
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
			$pdfFilePath = "output_pdf_name.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
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
						
						$subjectList = $this->Generate_model->get_student_assigned_subjects($stuData->user_id);
						// p($subjectList); 
						     
						     $list['student_unique_id']  =$stuData->user_unique_id;
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
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
									   $data['course_code']   = $subjectVal->course_code;
									   $data['course_title']   = $subjectVal->course_title;
									   $data['theory_credit']   = $subjectVal->theory_credit;
									   $data['practical_credit']   = $subjectVal->practicle_credit;
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
			$pdfFilePath = "output_pdf_name.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
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
		$data['degrees']=$this->Generate_model->get_degree_by_program_id($program_id); 
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
	
	
	function getBatchbyDOS()
	{
		$degree_id = $this->input->post('degree_id');
		$data['dos']=$this->Generate_model->get_date_by_degree($degree_id); 
		 $str = '';
         foreach($data['dos'] as $k=>$v){   
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
		$batch_id=$this->input->post('batch_id');
		$date_of_start=$this->input->post('date_of_start');
		$date_of_closure=$this->input->post('date_of_closure');
		
	    $send['campus_id']=$campus_id;
	    $send['program_id']=$program_id;
	    $send['degree_id']=$degree_id;
	    $send['batch_id']=$batch_id;
	    $studentList= $this->Generate_model->get_student_list_for_registration($send);
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
						<td>'.$students->user_id.'</td>
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