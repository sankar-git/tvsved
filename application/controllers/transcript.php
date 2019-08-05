<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transcript extends CI_Controller {
	
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
			$this->load->model('common_model');
			$this->load->model('user_model');
			$this->load->model('type_model');
			$this->load->model('Master_model');
			$this->load->model('Marks_model');
			$this->load->model('Discipline_model');
			$this->load->model('Generate_model');
			$this->load->model('Result_model');
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
					 $permit=$this->permission_lib->permit_new($this->user_id,$this->user_role);
					// p($permit); exit;
				}
				
			}
			else
			{
				redirect('authenticate', 'refresh');
			}*/
	}
	//======================================UG Marks Upload==================================================//
	
	function generateTranscript()
	{
		
		 //*************************Generate student Transcript*********************************//
		 if(!empty($this->input->post('transcript_result')))
		 {  
	        
	         //echo "hello"; exit;
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				//$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$student_id=$this->input->post('student_id'); //single input
				//p($student_id); exit;	
					 $allData = array();
					 $students = $this->Result_model->get_student_result_data($student_id); //get student semesters
					// p($students); exit;
					 $semesters = $this->Result_model->get_student_semester_data($student_id); //get student semesters
					// p($students); exit;
				if($degree_id!=''){
					//echo "hello"; exit;
					$datas['total_gradeval']=0;
					$datas['total_count']=0;
					foreach($semesters as $stuData)
					 {
						 //p($stuData->semester_id); exit;
					$subjectList = $this->Result_model->get_student_marks_by_id_and_semester_id($student_id,$stuData->semester_id);
					//p($subjectList); exit;
                   $semesterRow = $this->Result_model->get_semester_name($stuData->semester_id); //getting semester name 				
					//p($semesterRow); exit;	    
						     
						     $list['first_name']  =$students[0]->first_name;
						     $list['gender']  =$students[0]->gender;
						     $list['parent_name']  =$students[0]->parent_name;
						     $list['dob']  =$students[0]->dob;
						     $list['last_name']  =$students[0]->last_name;
						     $list['user_unique_id']  =$students[0]->user_unique_id;
						     $list['user_image']  =$students[0]->user_image;
						     $list['batch_name']  =$students[0]->batch_name;
						     $list['campus_name']  =$students[0]->campus_name;
						     $list['campus_code']  =$students[0]->campus_code;
						     $list['degree_name']  =$students[0]->degree_name;
						     $list['program_name']  =$students[0]->program_name;
						     $list['discipline_name']  =$students[0]->discipline_name;
						     $list['semester_id']  =$stuData->semester_id;
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
									   if($degree_id == 1 && $program_id == 1){
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
									 //  $data['practical_internal'] 				= $subjectVal->practical_internal1;
									   $data['theory_external']    				= $subjectVal->theory_external1;
									   $data['practical_external'] 				= $subjectVal->practical_external;
									   $data['marks_sum']          				= $subjectVal->marks_sum;
									   $data['external_sum']          			= round_two_digit(trim($theory_internal_total+$theory_marks_40+$paper_20));
									    $data['ncc_status']          			= $subjectVal->ncc_status;
									   $data['course_group_id']          			= $subjectVal->course_group_id;
									  // $sum_internal                            = $data['theory_internal1'] + $data['sum_internal_practical'];//100
									   
									   //p($data['external_sum']  ); exit;
									   //subjectwise status of pass or fail of btech result
									    $total_internal_external =  $data['internal_sum'] + $data['external_sum'];//total sum subject wise
										//p($total_internal_external); exit;
										// $sum_interna_passcondition30= $data['theory_internal1']+ $data['external_sum']; //internal 20+external  100
									    $sum_practical_pass_condition20=$data['sum_internal_practical'];//practical 60
										
										$data['total_internal_external'] = $total_internal_external;
									    $external_marks   =   $data['external_sum'];
										$ncc_status=$data['ncc_status'];
										$course_group_id=$data['course_group_id'];
										
									  if(trim($theory_internal_total+$theory_marks_40) >=30 && $paper_20>=20 && trim($theory_internal_total+$theory_marks_40+$paper_20)>=50){
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
									    $datas['total_gradeval']  = $datas['total_gradeval']+ $data['gradeval'];
									    $datas['total_count']=$datas['total_count']+1;
									   $data['credithour'] = $total_credits;
									  // $data['result_status'] = $result_status;
									   $data['passfail_status'] = $passfail_status;
									   }else{
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
												$datas['total_gradeval']  = $datas['total_gradeval']+ $data['gradeval'];
												$datas['total_count']=$datas['total_count']+1;
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
													 $datas['total_gradeval']  = $datas['total_gradeval']+ $data['gradeval'];
													$datas['total_count']=$datas['total_count']+1;
													  $data['passfail_status'] = $passfail_status;
											   }
									   }
									   $total_all_subject_sum = $total_all_subject_sum+$total_internal_external;
									   $sum_subject_credit_val = $sum_subject_credit_val+$data['creditval'];
									   $sum_total_credits = $sum_total_credits+$total_credits;
									   $grade_point_average = $sum_subject_credit_val/$sum_total_credits;
									   $gpa=number_format($grade_point_average,2);
									   if(!empty($gpa)){ $savegpa=$gpa;}
									   else{$savegpa='';}
									   $dataList[] = $data;
									  
								 }      
								 
						    $list['subjectList'] = $dataList;
							$allData[] = $list;  
							//p($allData);
					 } //exit;
				     $data['result_data']=$allData;
					 $data['total_gradeval']=$datas['total_gradeval'];
					$data['total_count']=$datas['total_count'];
					$data['month']=$this->input->post('month');
					$data['year']=$this->input->post('year');
					 //p($data); exit;
			
			  
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/report/student_bvsc_result_transcript', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "aggregate_marks.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->setTitle('Transcript Report');
			$this->m_pdf->pdf->mPDF('utf-8','A4-L','','','5','5','5','5'); 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
		  }	//end degrree condition
		  
		 }
		 //*************************Generate student Transcript End*********************************//
		
		
		$data['page_title']="Generate Student Transcript Result";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['batches'] = $this->Discipline_model->get_batches(); 
		$data['semesters'] = $this->Discipline_model->get_semester(); 
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		$this->load->view('admin/generate_student_transcript_result_view',$data);
		
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
           $str .= "<option value=".$v->id.'-'.$v->course_group_id.">".$v->course_code.'-'.$v->course_title."</option>";
           }
		   echo $str;
	}
	
	function getCourseByIdss()
	{
		//print_r($_POST); exit;
		$campus_id = $this->input->post('campus_idd');
		$program_id = $this->input->post('program_idd');
		$degree_id = $this->input->post('degree_idd');
		$batch_id = $this->input->post('batch_idd');
		$semester_id = $this->input->post('semester_idd');
		$discipline_id = $this->input->post('discipline_idd');
		
		$data['courses']=$this->Marks_model->get_course_by_ids($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id); 
		//print_r($data['programs']); exit;
		$str = '';
         foreach($data['courses'] as $k=>$v){ 
           $str .= "<option value=".$v->id.">".$v->course_code.'-'.$v->course_title."</option>";
           }
		   echo $str;
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
			$last_name='';
			if(trim($v->last_name)!='')
				$last_name = ' '.$v->last_name;
           $str .= "<option value=".$v->id.">".$v->first_name.$last_name.' ('.$v->user_unique_id.')'."</option>";
        }
		   echo $str;
	  }
	  
	  
	  
    //----------End Download Excel File ---------------------//
	
	

}
?>