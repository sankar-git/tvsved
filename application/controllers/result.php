<?php
//ob_start();
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
	function consolidatedCertificate(){
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
		 //*************************Generate student detailed marks*********************************//
		 if(!empty($this->input->post('consolidated')))
		 {  
	        
	         //echo "hello"; exit;
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				//$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				//$date_of_start=$this->input->post('date_of_start');
				//$date_of_closure=$this->input->post('date_of_closure');
				//print_r($date_of_closure); exit;
				// $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				 //$semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
				// print_r($semesterRow); exit;
				 //$batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				 //$yrdata= strtotime($batch_year);
                // $monthYrr= date('M-Y', $yrdata);
				 //print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Result_model->get_result_data($student_id);
					 
				if($degree_id==1){
					//echo "hello"; exit;
					foreach($students as $stuData)
					 {
						$subjectList = $this->Result_model->get_student_marks_by_id($stuData->user_id);
						//echo $this->db->last_query();
						//p($subjectList); exit;
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_name']  =$stuData->degree_name;
						     $list['degree_code']  =$stuData->degree_code;
						     $list['parent_name']  =$stuData->parent_name;
						     $list['mother_name']  =$stuData->mother_name;
						     $list['month_year']  =$monthYrr;
						     $list['semester_name']  =$semesterRow->semester_name;
						    
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
								 $internal_sum='';
								 $external_marks='';
								 $sum_internal='';
								 $sum_external='';
								 $sum_theory_practical_credit='';
								 $total_internal_external='';
								 $final_statusss='';
								 
								 foreach($subjectList as $subjectVal)
								 {  
                                    
							           $data['course_id']               		= $subjectVal->id;
									   $data['course_code']        				= $subjectVal->course_code;
									   $data['course_title']       				= $subjectVal->course_title;
									   $data['theory_credit']      				= $subjectVal->theory_credit;
									   $data['practicle_credit']   				= $subjectVal->practicle_credit;
									   $data['highest_marks']   				= $subjectVal->highest_marks;
									   $data['second_highest_marks']   				= $subjectVal->second_highest_marks;
									  $sum_theory_practical_credit             = $data['theory_credit'] + $data['practicle_credit'];
									   $data['theory_practical_credit']    		= $sum_theory_practical_credit;
									   $data['theory_internal']    				= $subjectVal->theory_internal;
									   $data['sum_internal_practical']    		= $subjectVal->sum_internal_practical;
									   $data['practical_internal'] 				= $subjectVal->practical_internal;
									   $data['theory_external']    				= $subjectVal->theory_external;
									   $data['practical_external'] 				= $subjectVal->practical_external;
									   $data['marks_sum']          				= $subjectVal->marks_sum;
									   $data['external_sum']          			= $subjectVal->external_sum;
									    $data['ncc_status']          			= $subjectVal->ncc_status;
									   $data['course_group_id']          			= $subjectVal->course_group_id;
									   $sum_internal                            = $data['theory_internal'] + $data['sum_internal_practical'];//100
									   $data['internal_sum']       				= $sum_internal; 
									   //p($data['external_sum']  ); exit;
									   //subjectwise status of pass or fail of btech result
									    $total_internal_external =  $data['internal_sum'] + $data['external_sum'];//total sum subject wise
										//p($total_internal_external); exit;
										 $sum_interna_passcondition30= $data['theory_internal']+ $data['external_sum']; //internal 20+external  100
									    $sum_practical_pass_condition20=$data['sum_internal_practical'];//practical 60
										
										$data['total_internal_external'] = $total_internal_external;
									    $external_marks   =   $data['external_sum'];
										$ncc_status=$data['ncc_status'];
										$course_group_id=$data['course_group_id'];
										
									   if($sum_interna_passcondition30 >=30 && $sum_practical_pass_condition20 >=20){$passfail_status='P';}
										 elseif($ncc_status==1 and $course_group_id==2)
									   {
										  $passfail_status='P'; 
									   }
										else{$passfail_status='F';}
										//calculating percent,grade and credit points
									    $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									    $percentval = ($total_internal_external/100)*100;
									    $roundpercent = number_format($percentval,2);
									    $gradeval = $roundpercent/10;
									    $gradepercent = number_format($gradeval, 2);
										$creditpoint = $gradepercent*$total_credits;
										$creditval = number_format($creditpoint,2);
										
									   $data['percentval'] = $roundpercent;
									   $data['gradeval']   = $gradepercent;
									   $data['creditval']  = $creditval;
									   $data['credithour'] = $total_credits;
									   $data['result_status'] = $result_status;
									   $data['passfail_status'] = $passfail_status;
									   
									   $total_all_subject_sum = $total_all_subject_sum+$total_internal_external;
									   $sum_subject_credit_val = $sum_subject_credit_val+$data['creditval'];
									   $sum_total_credits = $sum_total_credits+$total_credits;
									   $grade_point_average = $sum_subject_credit_val/$sum_total_credits;
									   $gpa=number_format($grade_point_average,2);
									   if(!empty($gpa)){ $savegpa=$gpa;}
									   else{$savegpa='';}
									   //getting final loop
									   $dataList[] = $data;
									  
								 }      
								 
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
							//p($allData);
					 } //exit;
				     $data['detailed_marks']=$allData;
					 //p($data['detailed_marks']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/consolidated_marksheet', $data, true);
			 echo $html; exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "detailed_mark.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
		  }	//end degrree condition
		  if($degree_id!=1)
		  {
			  //echo "hello "; exit;
			foreach($students as $stuData)
					 {
						$subjectList = $this->Result_model->get_student_marks_by_id($stuData->user_id,$semester_id);
						
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
								 $internal_sum='';
								 $external_marks='';
								 $total_subject_marks='';
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
									   $data['internal_sum']       = $data['theory_internal']+$data['practical_internal'];    
									  // p($data); exit;
									   //subjectwise status of pass or fail of btech result
									    $internal_sum         =   $data['theory_internal']+$data['practical_internal'];
									    $external_marks       =   $data['theory_external'];
										$total_subject_marks  =   $internal_sum + $external_marks;
										$data['total_subject_marks'] = $total_subject_marks;
										if($internal_sum>=25 && $external_marks>=25){$passfail_status='P';}
										else{$passfail_status='F';}
									   //calculating percent,grade and credit points
									    $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									    $percentval=($total_subject_marks/100)*100;
										
									    $roundpercent = number_format($percentval, 2);
										$gradeval = $roundpercent/10;
									    $gradepercent = number_format($gradeval, 2);
									    $creditpoint = $gradepercent*$total_credits;
									    $creditval = number_format($creditpoint,2);
									    $data['percentval'] = $roundpercent;
									    $data['gradeval']   = $gradepercent;
									    $data['creditval']  = $creditval;
									    $data['credithour'] = $total_credits;
									   //$data['result_status'] = $result_status;
									    $data['passfail_status'] = $passfail_status;
									   //p($data); exit;
									   $total_all_subject_sum  = $total_all_subject_sum + $total_subject_marks;
									   $sum_subject_credit_val = $sum_subject_credit_val + $data['creditval'];
									   $sum_total_credits      = $sum_total_credits + $total_credits;
									   $grade_point_average    = $sum_subject_credit_val/$sum_total_credits;
									   $gpa                    = number_format($grade_point_average,2);
									   if(!empty($gpa))
									   {
										   $savegpa=$gpa;
									   }
									   else{
										  $savegpa=''; 
									   }
									   $dataList[] = $data;
								 }  //exit;     
								 
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
							//p($allData);
					 } //exit;
				     $data['aggregate_marks']=$allData;  
					//p($data['aggregate_marks']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/aggregate_marks_view', $data, true);
			
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "$html=$this->load->view('admin/report/aggregate_marks_view', $data, true);.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;  
		  }
	         
		 }
		$data['page_title']="Generate Consolidated Certificate";
		 $data['campuses'] = $this->Discipline_model->get_campus(); 
		 $data['semesters'] = $this->Generate_model->get_semester(); 
		 $this->load->view('admin/generate_consolidated_view',$data);
	}
	function generateResult()
	{    
	
	     	//print_r($_POST); exit;
	   
		$campus_id=$this->input->post('campus_id');
		$program_id=$data['program_id'] =$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$semester_id=$this->input->post('semester_id');
		$batch_id=$this->input->post('batch_id');
		$date_of_start=$this->input->post('date_of_start');
		$month=$data['month'] =$this->input->post('month');
		$year=$data['year'] =$this->input->post('year');
		$student_id=$this->input->post('student_id');
		
	    $send['campus_id']=$campus_id;
	    $send['program_id']=$program_id;
	    $send['degree_id']=$degree_id;
	    $send['batch_id']=$batch_id;
	  
	    if(!empty($this->input->post('report_card')))
		 {  
	          
	           
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				//p($semester_id); exit;
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				$date_of_closure=$this->input->post('date_of_closure');
				//$batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				$semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
				//p($semesterRow); exit;
				//$batch_year=$batchYear->date_of_closure;
				//$yrdata= strtotime($batch_year);
                $monthYrr= $month.' '.$year;
			    $student_id=$this->input->post('student_id'); //array input
				$allData = array();
				$students = $this->Generate_model->get_studedent_data($student_id);
					//p($students); exit;
					 if($degree_id!=1 || $program_id>1)
					 {
					 foreach($students as $stuData)
					 {
						$subjectList = $this->Result_model->get_student_marks_by_id($stuData->user_id,$semester_id);
						
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_code']  =$stuData->degree_code;
						     $list['degree_name']  =$stuData->degree_name;
							  $list['semester_name'] =$semesterRow->semester_name;
							 
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
								 $internal_sum='';
								 $external_marks='';
								 $total_subject_marks='';
								 foreach($subjectList as $subjectVal)
								 {  
                                       $data['course_id']          = $subjectVal->id;
									   if(empty($subjectVal->course_subject_name))
										   $course_code = $subjectVal->course_code;
									   else
										   $course_code = $subjectVal->course_subject_name;
									   
									   if(empty($subjectVal->course_subject_title))
										   $course_title = $subjectVal->course_title;
									   else
										   $course_title = $subjectVal->course_subject_title;
									   $data['course_code']        = $course_code;
									   $data['course_title']       = $course_title;
									   $data['theory_credit']      = $subjectVal->theory_credit;
									   $data['practicle_credit']   = $subjectVal->practicle_credit;
									   $data['theory_internal']    = $subjectVal->theory_internal1;
									   $data['practical_internal'] = $subjectVal->practical_internal;
									   $data['assignment_mark'] = $subjectVal->assignment_mark;
									   $data['theory_external']    = $subjectVal->theory_external1;
									   $data['practical_external'] = $subjectVal->practical_external;
									   $data['marks_sum']          = $subjectVal->marks_sum;
									  
									  if($subjectVal->theory_credit > 0 && $subjectVal->practicle_credit > 0) 
										$internal_sum = number_format($subjectVal->theory_internal1 + $subjectVal->practical_internal,2);
									elseif($subjectVal->theory_credit > 0 ) 
										$internal_sum = $subjectVal->theory_internal1;
									elseif($subjectVal->practicle_credit > 0 )
										$internal_sum = $subjectVal->practical_internal;
										$internal_sum = $internal_sum+$subjectVal->assignment_mark;
									   $data['internal_sum']       = $internal_sum;    
									   //p($subjectVal);exit;
									    //subjectwise status of pass or fail of btech result
									    //$internal_sum     =   $data['theory_internal']+$data['practical_internal']+$data['assignment_mark'];
									    $external_marks   =   $data['theory_external'];
										$total_subject_marks=$internal_sum + $external_marks;
										$data['total_subject_marks']       =$total_subject_marks;
										if($internal_sum>=25 && $external_marks>=25){ 
											if($program_id == 1)
												$passfail_status='PASS';
											else
												$passfail_status='P';
										}
										else{
											if($program_id == 1)
												$passfail_status='FAIL';
											else
												$passfail_status='F';
										}
										if($internal_sum <25 && $external_marks>=25)
										{
											$deflicit='1';
										}
										else{
											$deflicit='0';
										}
									   //calculating percent,grade and credit points
									   $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									   
									   $percentval=($total_subject_marks/100)*100;
									 // p($percentval); 
									 // $roundpercent=round($percentval,2);
									  $roundpercent = number_format($percentval, 2);
									 // p($roundpercent); exit;
									 
									  $gradeval = $roundpercent/10;
									  $gradepercent = number_format($gradeval, 2);
									  $creditpoint = $gradepercent*$total_credits;
									  $creditval = number_format($creditpoint,2);
									 // p($roundpercent);
									 // p($gradeval); 
									  // $data['sum_total'] = $internal_sum;
									   $data['percentval'] = $roundpercent;
									   $data['gradeval']   = $gradepercent;
									   $data['creditval']  = $creditval;
									   $data['credithour'] = $total_credits;
									   //$data['result_status'] = $result_status;
									   $data['passfail_status'] = $passfail_status;
									   //p($data); exit;
									   $total_all_subject_sum  = $total_all_subject_sum + $total_subject_marks;
									   $sum_subject_credit_val = $sum_subject_credit_val + $data['creditval'];
									   $sum_total_credits      = $sum_total_credits + $total_credits;
									   $grade_point_average    = $sum_subject_credit_val/$sum_total_credits;
									   $gpa                    = number_format($grade_point_average,2);
									   if(!empty($gpa))
									   {
										   $savegpa=$gpa;
									   }
									   else{
										  $savegpa=''; 
									   }
									   $dataList[] = $data;
									   
									   /*******save all result btech*************************************/
									   $result['student_id']=$stuData->user_id;
									   $result['campus_id']=$campus_id;
									   $result['program_id']=$program_id;
									   $result['degree_id']=$degree_id;
									   $result['semester_id']=$semester_id;
									   $result['batch_id']=$batch_id;
									   $result['course_id']=$subjectVal->id;
									   $result['theory_credit']=$subjectVal->theory_credit;
									   $result['practicle_credit']=$subjectVal->practicle_credit;
									   $result['theory_internal1']=$subjectVal->theory_internal1;
									   $result['assignment_mark']=$subjectVal->assignment_mark;
									   $result['theory_internal2']=$subjectVal->theory_internal2;
									   $result['theory_internal3']=$subjectVal->theory_internal3;
									   $result['theory_internal']=$subjectVal->theory_internal1;
									   $result['theory_paper1']=$subjectVal->theory_paper1;
									   $result['theory_paper2']=$subjectVal->theory_paper2;
									   $result['sum_internal_practical']=$internal_sum;
									   $result['practical_internal']=$subjectVal->practical_internal;
									   $result['theory_external1']=$subjectVal->theory_external1;
									   $result['practical_external']=$subjectVal->practical_external;
									   $result['marks_sum']=$subjectVal->marks_sum;
									   $result['external_sum']=$subjectVal->external_sum;
									   $result['pass_condition1']=$internal_sum;
									   $result['pass_condition2']=$external_marks;
									   $result['sum_internal']=$sum_internal;
									   $result['ncc_status']=$subjectVal->ncc_status;
									   $result['course_group_id']=$subjectVal->course_group_id;
									   $result['passfail_status']=$passfail_status;
									   $result['percentval']=$roundpercent;
									   $result['gradeval']= $gradepercent;
									   $result['creditval']=$creditval;
									   $result['credithour']=$total_credits;
									   $result['dstatus']=$deflicit;
									   //p($result); exit;
									    $resultData = $this->Result_model->get_previous_results_subjects_marks($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$stuData->user_id,$subjectVal->id);
									  
									   if(!empty($resultData))
									   {
										   //$this->Result_model->update_student_previous_result_marks($result); 
									   }
									   else
									   {
										  // $this->Result_model->save_student_previous_result_marks($result); 
									   }
									   //$prevSemesterMarks = $this->Result_model->get_previous_semester_data($stuData->user_id,$semester_id);
									   /*******save all result end*************************************/ 
									   
									   
									   
								 }  //exit; loop
								 
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
										   //$this->Result_model->update_student_previous_semsester_marks($insert); 
									   }
									   else
									   {
										 //  $this->Result_model->save_student_previous_semsester_marks($insert); 
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
									   $prevSemsList[] = $prevSemesterMarks;
						            // p($prevSemsList); 
									  
								// p($dataList); exit;
						    $list['prevSemesterList']   = $prevSemsList;
						 //p($list['prevSemesterList']);
						    $list['subjectList'] = $dataList;
						    $allData[] = $list;  
							
					 } //exit;
				     $data['aggregate_marks']=$allData;
				
				//p($data['result_data']);  exit; // btech result;
			
			
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/student_result_view', $data, true);
			//$html=$this->load->view('admin/report/student_result_view_new', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "student_result_view.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','10','10','10','10');
			$this->m_pdf->pdf->setTitle('Report Card');
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	        $this->m_pdf->pdf->Output($pdfFilePath, "I");
		
            exit;
			 }	// end b_tech condition	
			 
			 
			  if($degree_id=1  && $program_id==1) //bvsc
					 {
				
					//echo "hello"; exit;
					foreach($students as $stuData)
					 {
						$subjectList = $this->Result_model->get_student_marks_by_id($stuData->user_id,$semester_id);
						//echo $this->db->last_query();exit;
						
						     $list['first_name']  =$stuData->first_name;
						     $list['father_name']  =$stuData->parent_name;
						     $list['mother_name']  =$stuData->mother_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['batch_start_year']  =$stuData->batch_start_year;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_code']  =$stuData->degree_code;
						     $list['degree_name']  =$stuData->degree_name;
							  $list['semester_name'] =$semesterRow->semester_name;
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
								 $internal_sum='';
								 $external_marks='';
								 $sum_internal='';
								 $sum_external='';
								 $sum_theory_practical_credit='';
								 $total_internal_external='';
								 $final_statusss='';
								 
								 foreach($subjectList as $subjectVal)
								 {  
                                    //p($subjectVal);exit;
							           $data['course_id']               		= $subjectVal->id;
									   if(empty($subjectVal->course_subject_name))
										   $course_code = $subjectVal->course_code;
									   else
										   $course_code = $subjectVal->course_subject_name;
									   
									   if(empty($subjectVal->course_subject_title))
										   $course_title = $subjectVal->course_title;
									   else
										   $course_title = $subjectVal->course_subject_title;
									   $data['course_code']        				= $course_code;
									   $data['course_title']       				= $course_title;
									   $data['theory_credit']      				= $subjectVal->theory_credit;
									   $data['practicle_credit']   				= $subjectVal->practicle_credit;
									   $sum_theory_practical_credit             = $data['theory_credit'] + $data['practicle_credit'];
									   $data['theory_practical_credit']    		= $sum_theory_practical_credit;
									   $numbers = array( $subjectVal->theory_internal1,$subjectVal->theory_internal2,$subjectVal->theory_internal3); 
									   rsort($numbers);
									 //  print_r($numbers);exit;
									  $theory_internal_total = $numbers[0]/4 + $numbers[1]/4;
									   $data['first_internal']    				= $numbers[0]/4;
									   $data['second_internal']    				= $numbers[1]/4;
									   $data['theory_internal']    				= $theory_internal_total;
									   $theory_marks_40=0; 
									   $course_id = $subjectVal->course_id;
									    $courseArr = explode("-",$course_id);
									   $courseArr = explode("|",$courseArr[0]);
									  $course_count=  count($courseArr);
									   for($j=1;$j<=$course_count;$j++){ 
										$var = "theory_external".$j; 
										$theory_marks_40+=$subjectVal->{$var}/5;
									   }
									   if($course_count == 1) 
										   $theory_marks_40=$theory_marks_40*2;  
									   elseif($course_count > 2) 
										$theory_marks_40=$theory_marks_40*2/$course_count; 
									   
									   $data['sum_internal_practical']    		= round_two_digit($theory_marks_40);
									   $paper_20=0; 
									   for($j=1;$j<=$course_count;$j++){ 
										$var = "theory_paper".$j; 
										$paper_20+=$subjectVal->{$var}/3;
									   }
									   $paper_20=($paper_20*2)/$course_count;  
									   $data['internal_sum']       				= round_two_digit($paper_20); 
									   $data['practical_internal'] 				= $subjectVal->practical_internal;
									   $data['theory_external']    				= $subjectVal->theory_external;
									   $data['practical_external'] 				= $subjectVal->practical_external;
									   $data['marks_sum']          				= $subjectVal->marks_sum;
									   $data['external_sum']          			= round_two_digit($theory_internal_total+$theory_marks_40+$paper_20);
									    $data['ncc_status']          			= $subjectVal->ncc_status;
									   $data['course_group_id']          			= $subjectVal->course_group_id;
									   $sum_internal                            = $data['theory_internal'] + $data['sum_internal_practical'];//100
									   
									   //p($data['external_sum']  ); exit;
									   //subjectwise status of pass or fail of btech result
									    $total_internal_external =  $data['internal_sum'] + $data['external_sum'];//total sum subject wise
										//p($total_internal_external); exit;
										 $sum_interna_passcondition30= $data['theory_internal']+ $data['external_sum']; //internal 20+external  100
									    $sum_practical_pass_condition20=$data['sum_internal_practical'];//practical 60
										
										$data['total_internal_external'] = $total_internal_external;
									    $external_marks   =   $data['external_sum'];
										$ncc_status=$data['ncc_status'];
										$course_group_id=$data['course_group_id'];
										
									  if(($theory_internal_total+$theory_marks_40) >=30 && $paper_20>=20 && ($theory_internal_total+$theory_marks_40+$paper_20)>=50){
										   $passfail_status='Pass';
										}
										 elseif($ncc_status==1 and $course_group_id==2)
									   {
										  $passfail_status='Pass'; 
									   }
										else{$passfail_status='Fail';}
										//calculating percent,grade and credit points
									    $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									    $percentval = ($total_internal_external/100)*100;
									    $roundpercent = number_format($percentval,2);
									    $gradeval = $roundpercent/10;
									    $gradepercent = number_format($gradeval, 2);
										$creditpoint = $gradepercent*$total_credits;
										$creditval = number_format($creditpoint,2);
										
									   $data['percentval'] = $total_credits;
									   $data['gradeval']   = $data['external_sum']/10;
									   $data['creditval']  = number_format(($data['external_sum']/10)*$total_credits,2);
									   $data['credithour'] = $total_credits;
									   $data['result_status'] = $result_status;
									   $data['passfail_status'] = $passfail_status;
									   
									   $total_all_subject_sum = $total_all_subject_sum+$total_internal_external;
									   $sum_subject_credit_val = $sum_subject_credit_val+$data['creditval'];
									   $sum_total_credits = $sum_total_credits+$total_credits;
									   $grade_point_average = $sum_subject_credit_val/$sum_total_credits;
									   $gpa=number_format($grade_point_average,2);
									   if(!empty($gpa)){ $savegpa=$gpa;}
									   else{$savegpa='';}
									   //getting final loop
									   $dataList[] = $data;
									  
								 }      
								 
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
							//p($allData);
					 } //exit;
				     $data['aggregate_marks']=$allData;
					// p($data['aggregate_marks']); exit;
				//p($data['result_data']); 
				//exit;
			
			
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/student_bvsc_result_new', $data, true);
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
		}
		 //*************************Generate Result End*********************************//
		 
		  //*************************Subject Wise Pass Fail Result Start*********************************//
		 if(!empty($this->input->post('subject_wise_result')))
		 {  
	 
	         //echo "hello"; exit;
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				$date_of_closure=$this->input->post('date_of_closure');
				//print_r($date_of_closure); exit;
				// $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				 $semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
				// print_r($semesterRow); exit;
				// $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				 //$yrdata= strtotime($batch_year);
                 $monthYrr= $month.' '.$year;
				 //print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Result_model->get_result_data($student_id);
					// p($students); exit;
				if($degree_id==1){
					//echo "hello"; exit;
					foreach($students as $stuData)
					 {
						$subjectList = $this->Result_model->get_student_marks_by_id($stuData->user_id,$semester_id);
						
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_name']  =$stuData->degree_name;
						     $list['semester_name']  =$semesterRow->semester_name;
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
								 $internal_sum='';
								 $external_marks='';
								 $sum_internal='';
								 $sum_external='';
								 $sum_theory_practical_credit='';
								 $total_internal_external='';
								 $final_statusss='';
								 
								 foreach($subjectList as $subjectVal)
								 {  
                                    
							           $data['course_id']               		= $subjectVal->id;
									   $data['course_code']        				= $subjectVal->course_code;
									   $data['course_title']       				= $subjectVal->course_title;
									   $data['theory_credit']      				= $subjectVal->theory_credit;
									   $data['practicle_credit']   				= $subjectVal->practicle_credit;
									   $sum_theory_practical_credit             = $data['theory_credit'] + $data['practicle_credit'];
									   $data['theory_practical_credit']    		= $sum_theory_practical_credit;
									   $data['theory_internal']    				= $subjectVal->theory_internal;
									   $data['sum_internal_practical']    		= $subjectVal->sum_internal_practical;
									   $data['practical_internal'] 				= $subjectVal->practical_internal;
									   $data['theory_external']    				= $subjectVal->theory_external;
									   $data['practical_external'] 				= $subjectVal->practical_external;
									   $data['marks_sum']          				= $subjectVal->marks_sum;
									   $data['external_sum']          			= $subjectVal->external_sum;
									   $data['ncc_status']          			= $subjectVal->ncc_status;
									   $data['course_group_id']          			= $subjectVal->course_group_id;
									   $sum_internal                            = $data['theory_internal'] + $data['sum_internal_practical'];//100
									   $data['internal_sum']       				= $sum_internal; 
									   $sum_interna_passcondition30= $data['theory_internal']+ $data['external_sum']; //internal 20+external  100
									    $sum_practical_pass_condition20=$data['sum_internal_practical'];//practical 60
									   //p($sum_interna_passcondition1); exit;
									   //subjectwise status of pass or fail of btech result
									    $total_internal_external = $sum_internal + $data['external_sum'];//total sum subject wise 100
										//p($total_internal_external);
									    $external_marks   =   $data['external_sum'];
										$ncc_status=$data['ncc_status'];
										$course_group_id=$data['course_group_id'];
										
										if($sum_interna_passcondition30 >=30 && $sum_practical_pass_condition20 >=20){$passfail_status='P';}
										 elseif($ncc_status==1 and $course_group_id==2)
									   {
										  $passfail_status='P'; 
									   }
										else{$passfail_status='F';}
										//calculating percent,grade and credit points
									    $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									    $percentval = ($total_internal_external/100)*100;
									    $roundpercent = number_format($percentval,2);
									    $gradeval = $roundpercent/10;
									    $gradepercent = number_format($gradeval, 2);
										$creditpoint = $gradepercent*$total_credits;
										$creditval = number_format($creditpoint,2);
										
									   $data['percentval'] = $roundpercent;
									   $data['gradeval']   = $gradepercent;
									   $data['creditval']  = $creditval;
									   $data['credithour'] = $total_credits;
									   $data['result_status'] = $result_status;
									   $data['passfail_status'] = $passfail_status;
									   
									   $total_all_subject_sum = $total_all_subject_sum+$total_internal_external;
									   $sum_subject_credit_val = $sum_subject_credit_val+$data['creditval'];
									   $sum_total_credits = $sum_total_credits+$total_credits;
									   $grade_point_average = $sum_subject_credit_val/$sum_total_credits;
									   $gpa=number_format($grade_point_average,2);
									   if(!empty($gpa)){ $savegpa=$gpa;}
									   else{$savegpa='';}
									   //getting final loop
									   $dataList[] = $data;
									  
								 }      
								 
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
							//p($allData);
					 } //exit;
				     $data['pass_fail_list']=$allData;
					// p($data['pass_fail_list']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/subject_wise_pass_fail_result', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "subject_wise_pass_fail.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
		  }	//end degrree condition
		  if($degree_id!=1)
		  {
			  //echo "hello "; exit;
			foreach($students as $stuData)
					 {
						$subjectList = $this->Result_model->get_student_marks_by_id($stuData->user_id,$semester_id);
						
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
								 $internal_sum='';
								 $external_marks='';
								 $total_subject_marks='';
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
									   $data['internal_sum']       = $data['theory_internal']+$data['practical_internal'];    
									  // p($data); exit;
									   //subjectwise status of pass or fail of btech result
									    $internal_sum         =   $data['theory_internal']+$data['practical_internal'];
									    $external_marks       =   $data['theory_external'];
										$total_subject_marks  =   $internal_sum + $external_marks;
										if($internal_sum>=25 && $external_marks>=25){$passfail_status='P';}
										else{$passfail_status='F';}
									   //calculating percent,grade and credit points
									    $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									    $percentval=($total_subject_marks/100)*100;
										
									    $roundpercent = number_format($percentval, 2);
										$gradeval = $roundpercent/10;
									    $gradepercent = number_format($gradeval, 2);
									    $creditpoint = $gradepercent*$total_credits;
									    $creditval = number_format($creditpoint,2);
									    $data['percentval'] = $roundpercent;
									    $data['gradeval']   = $gradepercent;
									    $data['creditval']  = $creditval;
									    $data['credithour'] = $total_credits;
									   //$data['result_status'] = $result_status;
									    $data['passfail_status'] = $passfail_status;
									   //p($data); exit;
									   $total_all_subject_sum  = $total_all_subject_sum + $total_subject_marks;
									   $sum_subject_credit_val = $sum_subject_credit_val + $data['creditval'];
									   $sum_total_credits      = $sum_total_credits + $total_credits;
									   $grade_point_average    = $sum_subject_credit_val/$sum_total_credits;
									   $gpa                    = number_format($grade_point_average,2);
									   if(!empty($gpa))
									   {
										   $savegpa=$gpa;
									   }
									   else{
										  $savegpa=''; 
									   }
									   $dataList[] = $data;
								 }  //exit;     
								 
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
							//p($allData);
					 } //exit;
				     $data['pass_fail_list']=$allData;  
					//p($data['pass_fail_list']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/subject_wise_pass_fail_result', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "subject_wise_pass_fail.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;  
		  }
          		  
		 }
		 //*************************Subject Wise Pass Fail Result End*********************************//
		 
		 
		 
		 
		  //*************************Generate pass fail result list*********************************//
		 if(!empty($this->input->post('result_list')))
		 {  
	        //echo "hello"; exit;
	         // $data['campuses'] = $this->Discipline_model->get_campus(); 
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				$date_of_closure=$this->input->post('date_of_closure');
				//print_r($date_of_closure); exit;
				// $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				 $semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
				// print_r($semesterRow); exit;
				// $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				// $yrdata= strtotime($batch_year);
                 $monthYrr= $month.' '.$year;
				 //print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Result_model->get_result_data($student_id);
					// p($students); exit;
					 foreach($students as $stuData)
					 {
						     $subjectList = $this->Result_model->get_student_marks_by_id($stuData->user_id,$semester_id);
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
								 $internal_sum='';
								 $external_marks='';
								 $sum_internal='';
								 $sum_external='';
								 $sum_theory_practical_credit='';
								 $total_internal_external='';
								 $final_statusss='';
								 
								 foreach($subjectList as $subjectVal)
								 {  
                                    
							           $data['course_id']               		= $subjectVal->id;
									   $data['course_code']        				= $subjectVal->course_code;
									   $data['course_title']       				= $subjectVal->course_title;
									   $data['theory_credit']      				= $subjectVal->theory_credit;
									   $data['practicle_credit']   				= $subjectVal->practicle_credit;
									   $sum_theory_practical_credit             = $data['theory_credit'] + $data['practicle_credit'];
									   $data['theory_practical_credit']    		= $sum_theory_practical_credit;
									   $data['theory_internal']    				= $subjectVal->theory_internal;
									   $data['sum_internal_practical']    		= $subjectVal->sum_internal_practical;
									   $data['practical_internal'] 				= $subjectVal->practical_internal;
									   $data['theory_external']    				= $subjectVal->theory_external;
									   $data['practical_external'] 				= $subjectVal->practical_external;
									   $data['marks_sum']          				= $subjectVal->marks_sum;
									   $data['external_sum']          			= $subjectVal->external_sum;
									   $sum_internal                            = $data['theory_internal'] + $data['sum_internal_practical'];//100
									   $data['internal_sum']       				= $sum_internal; 
									  
									   //subjectwise status of pass or fail of btech result
									    $total_internal_external = $sum_internal + $data['external_sum'];//total sum subject wise
										//p($total_internal_external);
									    $external_marks   =   $data['external_sum'];
										 $sum_interna_passcondition30= $data['theory_internal']+ $data['external_sum']; //internal 20+external  100
									    $sum_practical_pass_condition20=$data['sum_internal_practical'];//practical 60
										if($sum_interna_passcondition30 >=30 && $sum_practical_pass_condition20 >=20){$passfail_status='P';}
										
										else{$passfail_status='F';}
										//calculating percent,grade and credit points
									    $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									    $percentval = ($total_internal_external/100)*100;
									    $roundpercent = number_format($percentval,2);
									    $gradeval = $roundpercent/10;
									    $gradepercent = number_format($gradeval, 2);
										$creditpoint = $gradepercent*$total_credits;
										$creditval = number_format($creditpoint,2);
										
									   $data['percentval'] = $roundpercent;
									   $data['gradeval']   = $gradepercent;
									   $data['creditval']  = $creditval;
									   $data['credithour'] = $total_credits;
									   $data['result_status'] = $result_status;
									   $data['passfail_status'] = $passfail_status;
									   
									   $total_all_subject_sum = $total_all_subject_sum+$total_internal_external;
									   $sum_subject_credit_val = $sum_subject_credit_val+$data['creditval'];
									   $sum_total_credits = $sum_total_credits+$total_credits;
									   $grade_point_average = $sum_subject_credit_val/$sum_total_credits;
									   $gpa=number_format($grade_point_average,2);
									   if(!empty($gpa)){ $savegpa=$gpa;}
									   else{$savegpa='';}
									   //getting final loop
									   $dataList[] = $data;
									  
								
								 } //exit;
							 //p($dataList); exit;
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
					 }  
				     $data['result_list']=$allData;
					//p($data['result_list']);
					//exit;
			
			  
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
	        
	         //echo "hello"; exit;
	            $campus_id=$this->input->post('campus_id');
				$program_id=$data['program_id']=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				$date_of_closure=$this->input->post('date_of_closure');
				//print_r($date_of_closure); exit;
				// $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				 $semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
				// print_r($semesterRow); exit;
				// $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				// $yrdata= strtotime($batch_year);
                 $monthYrr= $month.' '.$year;
				 //print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Result_model->get_result_data($student_id);
					// p($students); exit;
				if($degree_id==1 && $program_id==1){
					//echo "hello"; exit;
					foreach($students as $stuData)
					 {
						$subjectList = $this->Result_model->get_student_marks_by_id($stuData->user_id,$semester_id);
						//echo $this->db->last_query();exit;
						
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_code']  =$stuData->degree_code;
						     $list['degree_name']  =$stuData->degree_name;
							  $list['semester_name'] =$semesterRow->semester_name;
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
								 $internal_sum='';
								 $external_marks='';
								 $sum_internal='';
								 $sum_external='';
								 $sum_theory_practical_credit='';
								 $total_internal_external='';
								 $final_statusss='';
								 
								 foreach($subjectList as $subjectVal)
								 {  
                                    
							           $data['course_id']               		= $subjectVal->id;
									   if(empty($subjectVal->course_subject_name))
										   $course_code = $subjectVal->course_code;
									   else
										   $course_code = $subjectVal->course_subject_name;
									   
									   if(empty($subjectVal->course_subject_title))
										   $course_title = $subjectVal->course_title;
									   else
										   $course_title = $subjectVal->course_subject_title;
									   $data['course_code']        				= $course_code;
									   $data['course_title']       				= $course_title;
									   $data['theory_credit']      				= $subjectVal->theory_credit;
									   $data['practicle_credit']   				= $subjectVal->practicle_credit;
									   $sum_theory_practical_credit             = $data['theory_credit'] + $data['practicle_credit'];
									   $data['theory_practical_credit']    		= $sum_theory_practical_credit;
									   $numbers = array( $subjectVal->theory_internal1,$subjectVal->theory_internal2,$subjectVal->theory_internal3); 
									   rsort($numbers);
									  $theory_internal_total = $numbers[0]/4 + $numbers[1]/4;
									   $data['theory_internal']    				= $theory_internal_total;
									   $theory_marks_40=0; 
									   $course_id = $subjectVal->course_id;
									    $courseArr = explode("-",$course_id);
									   $courseArr = explode("|",$courseArr[0]);
									  $course_count=  count($courseArr);
									   for($j=1;$j<=$course_count;$j++){ 
										$var = "theory_external".$j; 
										$theory_marks_40+=$subjectVal->{$var}/5;
									   }
									   if($course_count == 1) 
										   $theory_marks_40=$theory_marks_40*2;  
									   elseif($course_count > 2) 
										$theory_marks_40=$theory_marks_40*2/$course_count; 
									   
									   $data['sum_internal_practical']    		= round_two_digit($theory_marks_40);
									   $paper_20=0; 
									   for($j=1;$j<=$course_count;$j++){ 
										$var = "theory_paper".$j; 
										$paper_20+=$subjectVal->{$var}/3;
									   }
									   $paper_20=($paper_20*2)/$course_count;  
									   $data['internal_sum']       				= round_two_digit($paper_20); 
									   $data['practical_internal'] 				= $subjectVal->practical_internal1;
									   $data['theory_external']    				= $subjectVal->theory_external1;
									   $data['practical_external'] 				= $subjectVal->practical_external;
									   $data['marks_sum']          				= $subjectVal->marks_sum;
									   $data['external_sum']          			= round_two_digit($theory_internal_total+$theory_marks_40+$paper_20);
									    $data['ncc_status']          			= $subjectVal->ncc_status;
									   $data['course_group_id']          			= $subjectVal->course_group_id;
									   $sum_internal                            = $data['theory_internal1'] + $data['sum_internal_practical'];//100
									   
									   //p($data['external_sum']  ); exit;
									   //subjectwise status of pass or fail of btech result
									    $total_internal_external =  $data['internal_sum'] + $data['external_sum'];//total sum subject wise
										//p($total_internal_external); exit;
										 $sum_interna_passcondition30= $data['theory_internal1']+ $data['external_sum']; //internal 20+external  100
									    $sum_practical_pass_condition20=$data['sum_internal_practical'];//practical 60
										
										$data['total_internal_external'] = $total_internal_external;
									    $external_marks   =   $data['external_sum'];
										$ncc_status=$data['ncc_status'];
										$course_group_id=$data['course_group_id'];
										
									  if(($theory_internal_total+$theory_marks_40) >=30 && $paper_20>=20 && ($theory_internal_total+$theory_marks_40+$paper_20)>=50){
										   $passfail_status='P';
										}
										 elseif($ncc_status==1 and $course_group_id==2)
									   {
										  $passfail_status='P'; 
									   }
										else{$passfail_status='F';}
										//calculating percent,grade and credit points
									    $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									    $percentval = ($total_internal_external/100)*100;
									    $roundpercent = number_format($percentval,2);
									    $gradeval = $roundpercent/10;
									    $gradepercent = number_format($gradeval, 2);
										$creditpoint = $gradepercent*$total_credits;
										$creditval = number_format($creditpoint,2);
										
									   $data['percentval'] = $total_credits;
									   $data['gradeval']   = number_format($data['external_sum']/10,2);
									   $data['creditval']  = number_format(($data['external_sum']/10)*$total_credits,2);
									   $data['credithour'] = $total_credits;
									   $data['result_status'] = $result_status;
									   $data['passfail_status'] = $passfail_status;
									   
									   $total_all_subject_sum = $total_all_subject_sum+$total_internal_external;
									   $sum_subject_credit_val = $sum_subject_credit_val+$data['creditval'];
									   $sum_total_credits = $sum_total_credits+$total_credits;
									   $grade_point_average = $sum_subject_credit_val/$sum_total_credits;
									   $gpa=number_format($grade_point_average,2);
									   if(!empty($gpa)){ $savegpa=$gpa;}
									   else{$savegpa='';}
									   //getting final loop
									   $dataList[] = $data;
									  
								 }      
								 
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
							//p($allData);
					 } //exit;
				     $data['aggregate_marks']=$allData;
					// p($data['aggregate_marks']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/aggregate_marks_bvsc_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "aggregate_marks.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->setTitle('AGGREGATE RESULT MARK REPORT');
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
		  }	//end degrree condition
		  if($degree_id!=1)
		  {
			  //echo "hello "; exit;
			foreach($students as $stuData)
					 {
						$subjectList = $this->Result_model->get_student_marks_by_id($stuData->user_id,$semester_id);
						
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_code']  =$stuData->degree_code;
						     $list['degree_name']  =$stuData->degree_name;
							  $list['semester_name'] =$semesterRow->semester_name;
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
								 $internal_sum='';
								 $external_marks='';
								 $total_subject_marks='';
								 foreach($subjectList as $subjectVal)
								 {  
                                    
							           $data['course_id']          = $subjectVal->id;
									   $data['course_code']        = $subjectVal->course_code;
									   $data['course_title']       = $subjectVal->course_title;
									   $data['theory_credit']      = $subjectVal->theory_credit;
									   $data['practicle_credit']   = $subjectVal->practicle_credit;
									   $data['theory_internal']    = $subjectVal->theory_internal1;
									   $data['practical_internal'] = $subjectVal->practical_internal;
									   $data['assignment_mark'] = $subjectVal->assignment_mark;
									   $data['theory_external']    = $subjectVal->theory_external1;
									   $data['practical_external'] = $subjectVal->practical_external;
									   $data['marks_sum']          = $subjectVal->marks_sum;
									  // $data['internal_sum']       = $data['theory_internal']+$data['practical_internal']+$data['assignment_mark'];    
									  // p($data); exit;
									   //subjectwise status of pass or fail of btech result
									   if($degree_id!=1 && $program_id == 1){
									   if($subjectVal->theory_credit > 0 && $subjectVal->practicle_credit > 0) 
										$internal_sum = number_format($subjectVal->theory_internal1 + $subjectVal->practical_internal,2);
									elseif($subjectVal->theory_credit > 0 ) 
										$internal_sum = $subjectVal->theory_internal1;
									elseif($subjectVal->practicle_credit > 0 )
										$internal_sum = $subjectVal->practical_internal;
										
										$internal_sum = $internal_sum+$subjectVal->assignment_mark; 
										$data['internal_sum']       = $internal_sum;
									   // $internal_sum         =   $data['theory_internal']+$data['practical_internal'];
									    $external_marks       =   $data['theory_external'];
										$total_subject_marks  =   $internal_sum + $external_marks;
										$data['total_subject_marks'] = $total_subject_marks;
										if($internal_sum>=25 && $external_marks>=25){$passfail_status='P';}
										else{$passfail_status='F';}
									   //calculating percent,grade and credit points
									    $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									    $percentval=($total_subject_marks/100)*100;
										
									    $roundpercent = number_format($percentval, 2);
										$gradeval = $roundpercent/10;
									    $gradepercent = number_format($gradeval, 2);
									    $creditpoint = $gradepercent*$total_credits;
									    $creditval = number_format($creditpoint,2);
									    $data['percentval'] = $roundpercent;
									    $data['gradeval']   = $gradepercent;
									    $data['creditval']  = $creditval;
									    $data['credithour'] = $total_credits;
									   //$data['result_status'] = $result_status;
									    $data['passfail_status'] = $passfail_status;
									   //p($data); exit;
									   $total_all_subject_sum  = $total_all_subject_sum + $total_subject_marks;
									   $sum_subject_credit_val = $sum_subject_credit_val + $data['creditval'];
									   $sum_total_credits      = $sum_total_credits + $total_credits;
									   $grade_point_average    = $sum_subject_credit_val/$sum_total_credits;
									   $gpa                    = number_format($grade_point_average,2);
									   }else{
										   if($data['theory_credit'] > 0 && $data['practicle_credit'] > 0) {
												$total_internal_sum = $subjectVal->theory_internal1 + $subjectVal->theory_external1 + $subjectVal->assignment_mark;
												$practical = $subjectVal->practical_internal*2;
												if($total_internal_sum>=60 && $practical>=60)
													$passfail_status = 'PASS';
												else
													$passfail_status = 'FAIL';
												$subject_sum_percent10= number_format((($total_internal_sum+$subjectVal->practical_internal)/150)*10,2);
												$total_subject_marks = number_format($total_internal_sum+$subjectVal->practical_internal,2) ;
											}elseif($data['theory_credit'] > 0 ) {
												$total_internal_sum = $subjectVal->theory_internal1+ $subjectVal->assignment_mark+ $subjectVal->theory_external1;
												if($total_internal_sum>=60)
													$passfail_status = 'PASS';
												else
													$passfail_status = 'FAIL';
												$subject_sum_percent10= number_format($total_internal_sum/10,2);
												$total_subject_marks = number_format($total_internal_sum,2) ;
											}elseif($data['practicle_credit']  > 0 ){
												$total_internal_sum = $subjectVal->practical_internal;
												$practical = $subjectVal->practical_internal*2;
												if($practical>=60)
													$passfail_status = 'PASS';
												else
													$passfail_status = 'FAIL';
												$subject_sum_percent10= number_format($subjectVal->practical_internal/10,2);
												$total_subject_marks = number_format($total_internal_sum,2) ;
											}
											$total_credits = $data['theory_credit'] + $data['practicle_credit'];
											//$data['marks_sum']       = $total_internal_sum;
											$data['total_subject_marks']       = $total_subject_marks;
											//$data['total_subject_marks'] = $total_internal_sum;
											$data['gradeval']   = $subject_sum_percent10;
											$creditpoint = $subject_sum_percent10*$total_credits;
											$creditval = number_format($creditpoint,2);
											 $data['creditval']  = $creditval;
											  $data['passfail_status'] = $passfail_status;
									   }
									   if(!empty($gpa))
									   {
										   $savegpa=$gpa;
									   }
									   else{
										  $savegpa=''; 
									   }
									   $dataList[] = $data;
								 }  //exit;     
								 
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
							//p($allData);
					 } //exit;
				     $data['aggregate_marks']=$allData;  
					//p($data['aggregate_marks']); exit;
			
			  
			//load the view and saved it into $html variable
			if($program_id == 1){
				$html=$this->load->view('admin/report/aggregate_marks_view', $data, true);
			}else{
				$html=$this->load->view('admin/report/aggregate_marks_pg_view', $data, true);
			}
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "aggregate_marks_view.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->setTitle('AGGREGATE RESULT MARK REPORT');
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;  
		  }
	         
		 }
		 //*************************Generate student aggrigate marks End*********************************//
		  
		  //*************************Generate student detailed marks*********************************//
		 if(!empty($this->input->post('detailed_marks')))
		 {  
	        
	         //echo "hello"; exit;
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				$date_of_closure=$this->input->post('date_of_closure');
				//print_r($date_of_closure); exit;
				// $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				 $semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
				// print_r($semesterRow); exit;
				// $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				 //$yrdata= strtotime($batch_year);
                 $monthYrr= $month.' '.$year;
				 //print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $students = $this->Result_model->get_result_data($student_id);
					// p($students); exit;
				if($degree_id==1){
					//echo "hello"; exit;
					foreach($students as $stuData)
					 {
						$subjectList = $this->Result_model->get_student_marks_by_id($stuData->user_id,$semester_id);
						
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['father_name']  =$stuData->parent_name;
						     $list['mother_name']  =$stuData->mother_name;
						     $list['degree_name']  =$stuData->degree_name;
						     $list['month_year']  =$monthYrr;
						     $list['semester_name']  =$semesterRow->semester_name;
						    
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
								 $internal_sum='';
								 $external_marks='';
								 $sum_internal='';
								 $sum_external='';
								 $sum_theory_practical_credit='';
								 $total_internal_external='';
								 $final_statusss='';
								 
								 foreach($subjectList as $subjectVal)
								 {  
                                    
							           $data['course_id']               		= $subjectVal->id;
									   $data['course_code']        				= $subjectVal->course_code;
									   $data['course_title']       				= $subjectVal->course_title;
									   $data['theory_credit']      				= $subjectVal->theory_credit;
									   $data['practicle_credit']   				= $subjectVal->practicle_credit;
									   $data['highest_marks']   				= $subjectVal->highest_marks;
									   $data['second_highest_marks']   				= $subjectVal->second_highest_marks;
									  $sum_theory_practical_credit             = $data['theory_credit'] + $data['practicle_credit'];
									   $data['theory_practical_credit']    		= $sum_theory_practical_credit;
									   $data['theory_internal']    				= $subjectVal->theory_internal;
									   $data['sum_internal_practical']    		= $subjectVal->sum_internal_practical;
									   $data['practical_internal'] 				= $subjectVal->practical_internal;
									   $data['theory_external']    				= $subjectVal->theory_external;
									   $data['practical_external'] 				= $subjectVal->practical_external;
									   $data['marks_sum']          				= $subjectVal->marks_sum;
									   $data['external_sum']          			= $subjectVal->external_sum;
									    $data['ncc_status']          			= $subjectVal->ncc_status;
									   $data['course_group_id']          			= $subjectVal->course_group_id;
									   $sum_internal                            = $data['theory_internal'] + $data['sum_internal_practical'];//100
									   $data['internal_sum']       				= $sum_internal; 
									   //p($data['external_sum']  ); exit;
									   //subjectwise status of pass or fail of btech result
									    $total_internal_external =  $data['internal_sum'] + $data['external_sum'];//total sum subject wise
										//p($total_internal_external); exit;
										 $sum_interna_passcondition30= $data['theory_internal']+ $data['external_sum']; //internal 20+external  100
									    $sum_practical_pass_condition20=$data['sum_internal_practical'];//practical 60
										
										$data['total_internal_external'] = $total_internal_external;
									    $external_marks   =   $data['external_sum'];
										$ncc_status=$data['ncc_status'];
										$course_group_id=$data['course_group_id'];
										
									   if($sum_interna_passcondition30 >=30 && $sum_practical_pass_condition20 >=20){$passfail_status='P';}
										 elseif($ncc_status==1 and $course_group_id==2)
									   {
										  $passfail_status='P'; 
									   }
										else{$passfail_status='F';}
										//calculating percent,grade and credit points
									    $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									    $percentval = ($total_internal_external/100)*100;
									    $roundpercent = number_format($percentval,2);
									    $gradeval = $roundpercent/10;
									    $gradepercent = number_format($gradeval, 2);
										$creditpoint = $gradepercent*$total_credits;
										$creditval = number_format($creditpoint,2);
										
									   $data['percentval'] = $roundpercent;
									   $data['gradeval']   = $gradepercent;
									   $data['creditval']  = $creditval;
									   $data['credithour'] = $total_credits;
									   $data['result_status'] = $result_status;
									   $data['passfail_status'] = $passfail_status;
									   
									   $total_all_subject_sum = $total_all_subject_sum+$total_internal_external;
									   $sum_subject_credit_val = $sum_subject_credit_val+$data['creditval'];
									   $sum_total_credits = $sum_total_credits+$total_credits;
									   $grade_point_average = $sum_subject_credit_val/$sum_total_credits;
									   $gpa=number_format($grade_point_average,2);
									   if(!empty($gpa)){ $savegpa=$gpa;}
									   else{$savegpa='';}
									   //getting final loop
									   $dataList[] = $data;
									  
								 }      
								 
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
							//p($allData);
					 } //exit;
				     $data['detailed_marks']=$allData;
					 //p($data['detailed_marks']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/detailed_result_student_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "detailed_mark.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
		  }	//end degrree condition
		  if($degree_id!=1)
		  {
			  //echo "hello "; exit;
			foreach($students as $stuData)
					 {
						$subjectList = $this->Result_model->get_student_marks_by_id($stuData->user_id,$semester_id);
						
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
								 $internal_sum='';
								 $external_marks='';
								 $total_subject_marks='';
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
									   $data['internal_sum']       = $data['theory_internal']+$data['practical_internal'];    
									  // p($data); exit;
									   //subjectwise status of pass or fail of btech result
									    $internal_sum         =   $data['theory_internal']+$data['practical_internal'];
									    $external_marks       =   $data['theory_external'];
										$total_subject_marks  =   $internal_sum + $external_marks;
										$data['total_subject_marks'] = $total_subject_marks;
										if($internal_sum>=25 && $external_marks>=25){$passfail_status='P';}
										else{$passfail_status='F';}
									   //calculating percent,grade and credit points
									    $total_credits = $data['theory_credit'] + $data['practicle_credit'];
									    $percentval=($total_subject_marks/100)*100;
										
									    $roundpercent = number_format($percentval, 2);
										$gradeval = $roundpercent/10;
									    $gradepercent = number_format($gradeval, 2);
									    $creditpoint = $gradepercent*$total_credits;
									    $creditval = number_format($creditpoint,2);
									    $data['percentval'] = $roundpercent;
									    $data['gradeval']   = $gradepercent;
									    $data['creditval']  = $creditval;
									    $data['credithour'] = $total_credits;
									   //$data['result_status'] = $result_status;
									    $data['passfail_status'] = $passfail_status;
									   //p($data); exit;
									   $total_all_subject_sum  = $total_all_subject_sum + $total_subject_marks;
									   $sum_subject_credit_val = $sum_subject_credit_val + $data['creditval'];
									   $sum_total_credits      = $sum_total_credits + $total_credits;
									   $grade_point_average    = $sum_subject_credit_val/$sum_total_credits;
									   $gpa                    = number_format($grade_point_average,2);
									   if(!empty($gpa))
									   {
										   $savegpa=$gpa;
									   }
									   else{
										  $savegpa=''; 
									   }
									   $dataList[] = $data;
								 }  //exit;     
								 
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
							//p($allData);
					 } //exit;
				     $data['aggregate_marks']=$allData;  
					//p($data['aggregate_marks']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/detailed_result_student_view', $data, true);
			
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "detailed_result_student_view.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;  
		  }
	         
		 }
		 //*************************Generate student detailed  marks End*********************************//
		 
		 
		 
		 //******************************Failed Student List*********************************************//
		 if(!empty($this->input->post('fail_student_list')))
		 {  
	 
	         //echo "hello"; exit;
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				$date_of_closure=$this->input->post('date_of_closure');
				//print_r($date_of_closure); exit;
				// $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				 $semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
				// print_r($semesterRow); exit;
				// $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				 //$yrdata= strtotime($batch_year);
                 $monthYrr= $month.' '.$year;
				 //print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					// $students = $this->Result_model->get_result_data($student_id);
					// p($students); exit;
				if($degree_id==1){
					//echo "hello"; exit;
					
						$resultList = $this->Result_model->get_student_pass_fail_list($student_id,$semester_id);
						//p($resultList);exit;
						    
								 foreach($resultList as $resultVal)
								 {  
								   //p($resultVal); exit;
								   $studentInfo = $this->Result_model->get_student_info($resultVal->student_id);
                                    //p($studentInfo); exit;
									$data['first_name']=$studentInfo->first_name;
									$data['last_name']=$studentInfo->last_name;
									$data['user_unique_id']=$studentInfo->user_unique_id;
									$data['batch_name']=$studentInfo->batch_name;
									$data['campus_name']=$studentInfo->campus_name;
									$data['campus_code']=$studentInfo->campus_code;
									$data['degree_name']=$studentInfo->degree_name;
									$data['semester_name']=$semesterRow->semester_name;
									$data['course_id']= $resultVal->course_id;
									$data['theory_credit']= $resultVal->theory_credit;
									$data['practicle_credit']= $resultVal->practicle_credit;
									$data['theory_internal1']= $resultVal->theory_internal1;
									$data['theory_internal2']= $resultVal->theory_internal2;
									$data['theory_internal3']= $resultVal->theory_internal3;
									$data['theory_internal']= $resultVal->theory_internal;
									$data['theory_paper1']= $resultVal->theory_paper1;
									$data['theory_paper2']= $resultVal->theory_paper2;
									$data['sum_internal_practical']= $resultVal->sum_internal_practical;
									$data['practical_internal']= $resultVal->practical_internal;
									$data['theory_external']= $resultVal->theory_external;
									$data['practical_external']= $resultVal->practical_external;
									$data['marks_sum']= $resultVal->marks_sum;
									$data['sum_internal']= $resultVal->sum_internal;
									$data['external_sum']= $resultVal->external_sum;
									$data['ncc_status']= $resultVal->ncc_status;
									$data['course_group_id']= $resultVal->course_group_id;
									$data['passfail_status']= $resultVal->passfail_status;
									$data['percentval']= $resultVal->percentval;
									$data['gradeval']= $resultVal->gradeval;
									$data['creditval']= $resultVal->creditval;
									$data['credithour']= $resultVal->credithour;
									
									$dataList[] = $data;  
								 }    
								 
						 $data['fail_student_list']=$dataList;;
					 //p($data['fail_student_list']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/fail_student_list_bvsc_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "student_fail_list.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
			$this->m_pdf->pdf->setTitle('Fail Student List');
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
		  }	//end degrree condition
		  if($degree_id!=1)
		  {
			 $resultList = $this->Result_model->get_student_pass_fail_list($student_id,$semester_id);
						//p($resultList);exit;
						    
								 foreach($resultList as $resultVal)
								 {  
								   //p($resultVal); exit;
								   $studentInfo = $this->Result_model->get_student_info($resultVal->student_id);
                                    //p($studentInfo); exit;
									$data['first_name']=$studentInfo->first_name;
									$data['last_name']=$studentInfo->last_name;
									$data['user_unique_id']=$studentInfo->user_unique_id;
									$data['batch_name']=$studentInfo->batch_name;
									$data['campus_name']=$studentInfo->campus_name;
									$data['campus_code']=$studentInfo->campus_code;
									$data['degree_name']=$studentInfo->degree_name;
									$data['course_id']= $resultVal->course_id;
									$data['theory_credit']= $resultVal->theory_credit;
									$data['practicle_credit']= $resultVal->practicle_credit;
									$data['theory_internal1']= $resultVal->theory_internal1;
									$data['theory_internal2']= $resultVal->theory_internal2;
									$data['theory_internal3']= $resultVal->theory_internal3;
									$data['theory_internal']= $resultVal->theory_internal;
									$data['theory_paper1']= $resultVal->theory_paper1;
									$data['theory_paper2']= $resultVal->theory_paper2;
									$data['sum_internal_practical']= $resultVal->sum_internal_practical;
									$data['practical_internal']= $resultVal->practical_internal;
									$data['theory_external']= $resultVal->theory_external;
									$data['practical_external']= $resultVal->practical_external;
									$data['marks_sum']= $resultVal->marks_sum;
									$data['sum_internal']= $resultVal->sum_internal;
									$data['external_sum']= $resultVal->external_sum;
									$data['ncc_status']= $resultVal->ncc_status;
									$data['course_group_id']= $resultVal->course_group_id;
									$data['passfail_status']= $resultVal->passfail_status;
									$data['percentval']= $resultVal->percentval;
									$data['gradeval']= $resultVal->gradeval;
									$data['creditval']= $resultVal->creditval;
									$data['credithour']= $resultVal->credithour;
									
									$dataList[] = $data;  
								 }    
								 
						 $data['fail_student_list']=$dataList;;
					 //p($data['fail_student_list']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/fail_student_list_btech_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "btech_fail_student.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;  
		  }
          		  
		 }
		 
		 //******************************Failed Student List End*********************************************//
		 
		  //******************************Deflicit Student List*********************************************//
		 if(!empty($this->input->post('deflicit')))
		 {  
	 
	         //echo "hello"; exit;
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				$date_of_closure=$this->input->post('date_of_closure');
				//print_r($date_of_closure); exit;
				// $batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				 $semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
				// print_r($semesterRow); exit;
				 //$batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				 //$yrdata= strtotime($batch_year);
                 $monthYrr=$month.' '.$year;
				 //print_r($monthYrr); exit;
				 $student_id=$this->input->post('student_id'); //array input
				 $allData = array();
					 $deflicitStudent = $this->Result_model->get_deflicit_students($student_id,$semester_id,$degree_id);
					//p($deflicitStudent); exit;
				if($degree_id==1){
					//echo "hello"; exit;
					$allData=array();
					$dataList=array();
					 foreach($deflicitStudent as $studentVal){
						 //p($studentVal->student_id); exit;
						$list['first_name']=$studentVal->first_name;
						$list['last_name']=$studentVal->last_name;
						$list['user_unique_id']=$studentVal->user_unique_id;
						$list['campus_code']=$studentVal->campus_code;
						$list['campus_name']=$studentVal->campus_name;
						$list['degree_name']=$studentVal->degree_name;
						$list['semester_name']=$studentVal->semester_name;
						$list['batch_name']=$studentVal->batch_name;
						//p($list);
					    $deflicitCourse = $this->Result_model->get_deflicit_fail_list($studentVal->student_id,$semester_id);
						// p($deflicitCourse);
						 foreach($deflicitCourse as $deflicitVal){
						 //p($deflicitVal);
							//$deflicitVal->
							$data['theory_credit']=$deflicitVal->theory_credit;
							$data['practicle_credit']=$deflicitVal->practicle_credit;
							$data['theory_internal1']=$deflicitVal->theory_internal1;
							$data['theory_internal2']=$deflicitVal->theory_internal2;
							$data['theory_internal2']=$deflicitVal->theory_internal2;
							$data['theory_internal3']=$deflicitVal->theory_internal3;
							$data['theory_internal']=$deflicitVal->theory_internal;
							$data['theory_paper1']=$deflicitVal->theory_paper1;
							$data['theory_paper2']=$deflicitVal->theory_paper2;
							$data['pass_condition1']=$deflicitVal->pass_condition1;
							$data['pass_condition2']=$deflicitVal->pass_condition2;
							$data['course_code']=$deflicitVal->course_code;
							$dataList[]=$data;
						} //exit;
						$list['failedSubject']=$dataList;
						$allData[] = $list;
					 } 
						
					$data['deflicit_student_list']=$allData;
					//p($data['deflicit_student_list']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/deflicit_student_list_bvsc_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "student_fail_list.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->setTitle('Deflicit List');
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
		  }	//end degrree condition
		  if($degree_id!=1)
		  {
			 //echo "hello"; exit;
					$allData=array();
					$dataList=array();
					 foreach($deflicitStudent as $studentVal){
						 //p($studentVal->student_id); exit;
						$list['first_name']=$studentVal->first_name;
						$list['last_name']=$studentVal->last_name;
						$list['user_unique_id']=$studentVal->user_unique_id;
						$list['campus_code']=$studentVal->campus_code;
						$list['campus_name']=$studentVal->campus_name;
						$list['degree_name']=$studentVal->degree_name;
						$list['semester_name']=$studentVal->semester_name;
						$list['batch_name']=$studentVal->batch_name;
						//p($list);
					    $deflicitCourse = $this->Result_model->get_deflicit_fail_list_btech($studentVal->student_id,$semester_id);
						// p($deflicitCourse);
						 foreach($deflicitCourse as $deflicitVal){
						 //p($deflicitVal);
							//$deflicitVal->
							$data['theory_credit']=$deflicitVal->theory_credit;
							$data['practicle_credit']=$deflicitVal->practicle_credit;
							$data['theory_internal1']=$deflicitVal->theory_internal1;
							$data['theory_internal2']=$deflicitVal->theory_internal2;
							$data['theory_internal2']=$deflicitVal->theory_internal2;
							$data['theory_internal3']=$deflicitVal->theory_internal3;
							$data['theory_internal']=$deflicitVal->theory_internal;
							$data['theory_paper1']=$deflicitVal->theory_paper1;
							$data['theory_paper2']=$deflicitVal->theory_paper2;
							$data['pass_condition1']=$deflicitVal->pass_condition1;
							$data['pass_condition2']=$deflicitVal->pass_condition2;
							$data['course_code']=$deflicitVal->course_code;
							$dataList[]=$data;
						} //exit;
						$list['failedSubject']=$dataList;
						$allData[] = $list;
					 } 
						
					$data['deflicit_student_list']=$allData;
					//p($data['deflicit_student_list']); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/deflicit_student_list_btech_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "btech_fail_student.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;  
		  }
          		  
		 }
		 
		 //******************************Deflicit Student List End*********************************************//
		 
		 
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
	    $send['semester_id']=$semester_id;
	    $studentList= $this->Generate_model->get_student_list_for_registration($send);
		//echo $this->db->last_query();exit;
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