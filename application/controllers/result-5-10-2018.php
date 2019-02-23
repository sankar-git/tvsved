<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Result extends CI_Controller {
	
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
		  $this->load->model('Result_model');

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
	function generateResult()
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
	    
	    
		
		 if(!empty($this->input->post('report_card')))
		 {  
	           
	           
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				//p($program_id); exit;
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
                 $monthYrr= date('F-Y',$yrdata);
			//	print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Generate_model->get_studedent_data($student_id);
					//p($students); exit;
					 foreach($students as $stuData)
					 {
						$subjectList = $this->Result_model->get_student_marks_by_id($stuData->user_id);
						
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_name']  =$stuData->degree_name;
						     $list['month_year']  =$monthYrr;
						    
								 $dataList =array();
								 $prevSemsList=array();
								 $total_marks='';
								 $total_credits='';
								 $percentval='';
								 $gradeval='';
								 $gradepercent='';
								 $roundpercent='';
								 $creditpoint='';
								 $creditval='';
								 $total_all_subject_sum='';
								 $allpercent ='';
								 $total_theory_credit='';
								 $total_practical_credit='';
								 $total_credit_sum='';
								 $roundoverallpercent='';
								 $sum_subject_credit_val='';
								 $sum_total_credits ='';
								 $grade_point_average ='';
								 foreach($subjectList as $subjectVal)
								 {  
                                    
							           $data['course_id']          = $subjectVal->id;
									   $data['course_code']        = $subjectVal->course_code;
									   $data['course_title']       = $subjectVal->course_title;
									   $data['theory_credit']      = $subjectVal->theory_credit;
									   $data['practicle_credit']   = $subjectVal->practicle_credit;
									   $data['theory_internal']    = $subjectVal->theory_internal;
									   $data['practical_internal'] = $subjectVal->practical_internal;
									   $data['theory_external']    = $subjectVal->theory_external;
									   $data['practical_external'] = $subjectVal->practical_external;
									   $data['marks_sum']          = $subjectVal->marks_sum;
									 
									   
									   
									   //calculating percent,grade and credit points
									    
									   $total_marks = $data['theory_internal']+$data['practical_internal']+$data['theory_external']+$data['practical_external'];
									// p($total_marks); 
									   $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									   
									   $percentval=($total_marks/200)*100;
									 // p($percentval); 
									 // $roundpercent=round($percentval,2);
									  $roundpercent = number_format($percentval, 2);
									  //p($roundpercent); 
									  if($roundpercent >=50)
									  {
										 // echo "pass";
										  $result_status='PASS'; //subject wise pass fail
									  }
									  else
									  {
										 // echo "fail";
										 $result_status='FAIL';  //subject wise pass fail
									  }
									  
									  $gradeval = $roundpercent/10;
									  $gradepercent = number_format($gradeval, 2);
									  $creditpoint = $gradepercent*$total_credits;
									  $creditval = number_format($creditpoint,2);
									 // p($roundpercent);
									 // p($gradeval); 
									  // $data['sum_total'] = $total_marks;
									   $data['percentval'] = $roundpercent;
									   $data['gradeval']   = $gradepercent;
									   $data['creditval']  = $creditval;
									   $data['credithour'] = $total_credits;
									   $data['result_status'] = $result_status;
									   //p($data); exit;
									   $total_all_subject_sum = $total_all_subject_sum+$total_marks;
									   $sum_subject_credit_val = $sum_subject_credit_val+$data['creditval'];
									   $sum_total_credits = $sum_total_credits+$total_credits;
									   $grade_point_average = $sum_subject_credit_val/$sum_total_credits;
									   $gpa=number_format($grade_point_average,2);
									   if(!empty($gpa))
									   {
										   $savegpa=$gpa;
									   }
									   else{
										  $savegpa=''; 
									   }
									   $dataList[] = $data;
								 }  //exit;
								 
								       $insert['total_marks'] =$total_all_subject_sum;
								       $insert['total_credit_points'] =$sum_subject_credit_val;
									   $insert['total_credits'] =$sum_total_credits;
									   $insert['total_grade_point_average'] =$savegpa;
									   $insert['campus_id'] = $campus_id;
									   $insert['program_id'] = $program_id;
									   $insert['degree_id'] = $degree_id;
									   $insert['semester_id'] = $semester_id;
									   $insert['batch_id'] =  $batch_id;
									   $insert['student_id'] = $stuData->user_id;
									   //p($insert); exit;
									   $getData = $this->Result_model->get_previous_save_semster_marks($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$stuData->user_id);
									  
									   if(!empty($getData))
									   {
										   $this->Result_model->update_student_previous_semsester_marks($insert); 
									   }
									   else
									   {
										   $this->Result_model->save_student_previous_semsester_marks($insert); 
									   }
									   $prevSemesterMarks = $this->Result_model->get_previous_semester_data($stuData->user_id,$semester_id);
									   //p($prevSemesterMarks); 
									   //p(count($prevSemesterMarks));
									   //$prev=array();
									   $tempArr=array();
									   foreach($prevSemesterMarks as $stmarks)
									   {
										  
										  // p($stmarks->total_credits); 
										  $prev['total_marks'] = $stmarks->total_marks;
										  $prev['total_credit_points']=$stmarks->total_credit_points;
										  $prev['total_credits']=$stmarks->total_credits;
										  $prev['total_grade_point_average']= $stmarks->total_grade_point_average;
										  $tempArr[]=$prev;
									      //p($prev) ; 
									   }  //exit;
									   //$prevSemsList[]=$tempArr;
									   $prevSemsList[]=$prevSemesterMarks;
						            // p($prevSemsList); 
									  
								// p($dataList); exit;
						    $list['prevSemesterList']   = $prevSemsList;
						 //p($list['prevSemesterList']);
						    $list['subjectList'] = $dataList;
						    $allData[] = $list;  
							
					 } //exit;
				     $data['result_data']=$allData;
				
				//p($data['result_data']);  exit;
			
			
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/student_result_view', $data, true);
			//$html=$this->load->view('admin/report/student_result_view_new', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "student_result_view.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	        $this->m_pdf->pdf->Output($pdfFilePath, "I");
		
            exit;			
		 }
		 //*************************Generate Result End*********************************//
		 
		 
		  //*************************Generate pass fail result list*********************************//
		 if(!empty($this->input->post('result_list')))
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
				 $semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
				// print_r($semesterRow); exit;
				 $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				 $yrdata= strtotime($batch_year);
                 $monthYrr= date('M-Y', $yrdata);
				 //print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Result_model->get_result_data($student_id);
					// p($students); exit;
					 foreach($students as $stuData)
					 {
						     $subjectList = $this->Result_model->get_student_all_course_data($stuData->user_id);
						// p($subjectList); exit;
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_name']  =$stuData->degree_name;
						     $list['semester_name'] =$semesterRow->semester_name;
						     $list['month_year']  =$monthYrr;
						    
								 $dataList =array();
								 $total_marks='';
								 $total_credits='';
								 $percentval='';
								 $gradeval='';
								 $gradepercent='';
								 $roundpercent='';
								 $creditpoint='';
								 $creditval='';
								 $grand_sum='';
								 foreach($subjectList as $subjectVal)
								 {    
							           $data['student_id']   = $subjectVal->id;
									   $data['course_id']   = $subjectVal->course_id;
									   $data['course_code']   = $subjectVal->course_code;
									   $data['course_title']   = $subjectVal->course_title;
									   $data['theory_credit']   = $subjectVal->theory_credit;
									   $data['practicle_credit']   = $subjectVal->practicle_credit;
									   $data['theory_internal']   = $subjectVal->theory_internal;
									   $data['practical_internal']   = $subjectVal->practical_internal;
									   $data['theory_external']   = $subjectVal->theory_external;
									   $data['practical_external']   = $subjectVal->practical_external;
									   $data['total_sum']   = $subjectVal->marks_sum;
									  
									   //calculating percent,grade and credit points
									    
									   $total_marks=$data['theory_internal']+$data['practical_internal']+$data['theory_external']+$data['practical_external'];
									//  p($total_marks); 
									   $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									   
									   $percentval=($total_marks/200)*100;
									 // p($percentval); 
									 // $roundpercent=round($percentval,2);
									  $roundpercent= number_format($percentval, 2);
									  if($roundpercent >=50)
									  {
										  //echo "hiii"; exit;
										  $data['results_status']='Pass';
									  }
									  else
									  {
										 // echo  "hello"; exit;
										 $data['results_status']='Fail';  
									  }
									  $gradeval=$roundpercent/10;
									  $gradepercent=number_format($gradeval, 2);
									  $creditpoint= $gradepercent*$total_credits;
									  $creditval = number_format($creditpoint,2);
									 // p($roundpercent);
									 // p($gradeval); 
									   $data['percentval']=$roundpercent;
									   $data['gradeval']=$gradepercent;
									   $data['creditval']=$creditval;
									   $data['credithour']=$total_credits;
									  $dataList[] = $data;
								 } //exit;
							 //p($dataList); exit;
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
					 }  
				     $data['result_list']=$allData;
					// p($data['result_list']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/result_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "hall_ticket_with_date.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 //*************************Generate pass fail result list End*********************************//
		
			 
		  //*************************Generate student aggrigate marks*********************************//
		 if(!empty($this->input->post('aggregate_marks')))
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
				 $semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
				// print_r($semesterRow); exit;
				 $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				 $yrdata= strtotime($batch_year);
                 $monthYrr= date('M-Y', $yrdata);
				 //print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Result_model->get_result_data($student_id);
					// p($students); exit;
					 foreach($students as $stuData)
					 {
						$subjectList = $this->Result_model->get_student_all_course_data($stuData->user_id);
						// p($subjectList); exit;
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_name']  =$stuData->degree_name;
						     $list['semester_name'] =$semesterRow->semester_name;
						     $list['month_year']  =$monthYrr;
						    
								 $dataList =array();
								 $total_marks='';
								 $total_credits='';
								 $percentval='';
								 $gradeval='';
								 $gradepercent='';
								 $roundpercent='';
								 $creditpoint='';
								 $creditval='';
								 $grand_sum='';
								 $t_aggr='';
								 foreach($subjectList as $subjectVal)
								 {    
							           $data['student_id']   = $subjectVal->id;
									   $data['course_id']   = $subjectVal->course_id;
									   $data['course_code']   = $subjectVal->course_code;
									   $data['course_title']   = $subjectVal->course_title;
									   $data['theory_credit']   = $subjectVal->theory_credit;
									   $data['practicle_credit']   = $subjectVal->practicle_credit;
									   $data['theory_internal']   = $subjectVal->theory_internal;
									   $data['practical_internal']   = $subjectVal->practical_internal;
									   $data['theory_external']   = $subjectVal->theory_external;
									   $data['practical_external']   = $subjectVal->practical_external;
									   $data['total_sum']   = $subjectVal->marks_sum;
									   
									   //calculating percent,grade and credit points
									   $total_marks=$data['theory_internal']+$data['practical_internal']+$data['theory_external']+$data['practical_external'];
									   $total_credits = $data['theory_credit'] + $data['practicle_credit']; //calculating total credits
									   $t_aggr=$data['theory_internal']+$data['theory_external']; //calculating T-AGGRIGATE
									   $p_aggr=$data['practical_internal']+$data['practical_external']; //calculating P-AGGRIGATE
									   
									   $percentval=($total_marks/200)*100;
									   $roundpercent= number_format($percentval, 2);
									  if($roundpercent >=50)
									  {
										$data['results_status']='Pass';
									  }
									  else
									  {
										$data['results_status']='Fail';  
									  }
									  $gradeval=$roundpercent/10;
									  $gradepercent=number_format($gradeval, 2);
									  $creditpoint= $gradepercent*$total_credits;
									  $creditval = number_format($creditpoint,2);
									  $total_cp=$total_cp+$creditval;
									   $data['percentval']=$roundpercent;//subject aggrigate percentage
									   $data['gradeval']=$gradepercent;//subject grade percentage
									   $data['creditval']=$creditval; //credit percentage
									   $data['credithour']=$total_credits;
									   $data['t_aggrigate']=$t_aggr;
									   $data['p_aggrigate']=$p_aggr;
									   $data['total_cp']=$total_cp;
									   
									  $dataList[] = $data;
								 } //exit;
								// p($dataList); exit;
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
					 }  
				     $data['aggregate_marks']=$allData;
					// p($data['aggregate_marks']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/aggregate_marks_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "hall_ticket_with_date.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;			
		 }
		 //*************************Generate student aggrigate marks End*********************************//
		 
		 
		 $data['page_title']="Generate Student Result";
		 $data['campuses'] = $this->Discipline_model->get_campus(); 
		 $data['semesters'] = $this->Generate_model->get_semester(); 
		 $this->load->view('admin/generate_student_result_view',$data);
		
		
	}
	
	//ajax function for generate registration card
	
	function getProgramByCampus()
	{   
	    $campus_id = $this->input->post('campus_id');
		//p($campus_id); exit;
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