<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Process extends CI_Controller {
	
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
			$this->load->model('fees_model');
			$this->load->library('image_lib');
			$this->load->model('common_model');
			$this->load->model('newsession_model');
			$this->load->helper('email');
			$this->load->model('newsession_model');
			$this->load->model('user_model');
			$this->load->model('type_model');
			$this->load->model('Master_model');
			$this->load->model('Discipline_model');
			$this->load->library('permission_lib');
			$this->load->model('Result_model');
			$this->load->model('Process_model');
			$this->load->model('Attendance_model');
			$this->load->model('Generate_model');
			$this->load->model('Payment_model');
			$this->load->library('excel');
         $this->load->model('Marks_model');
			
		   $sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }
		
	}
	function sendToPayment()
	{
		//p($_POST); exit;
		$user_id=$this->input->post('user_id');
		$role_id=$this->input->post('role_id');
		$amount=$this->input->post('amount');
		$send['user_id']=$user_id;
		$send['role_id']=$role_id;
		$send['amount']=$amount;
		$return = $this->sendToUrl($send);
		
	}
	function sendToUrl($data)
	{
		p($data); exit;
		
		//$url = ‘http://203.114.240.77/paynetz/epi/fts';    // test bed URL
		/*$port = 80;
		$atom_prod_id = “TEST”;
		
				// code to generate token
		$param = “&login=”.$userid.”&pass=”.$password.”&ttype=NBFundTransfer&prodid=”.$atom_prod_id.”&amt=”.$amount.”&txncurr=INR&txnscamt=0&clientcode=”.$clientcode.”&txnid=”.$invoiceid.”&date=”.$today.”&custacc=12345″;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_PORT , $port);
		curl_setopt($ch, CURLOPT_SSLVERSION,3);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		$returnData = curl_exec($ch);

		// Check if any error occured
		if(curl_errno($ch))
		{
			echo ‘Curl error: ‘ . curl_error($ch);
		}
		curl_close($ch);

		$xmlObj = new SimpleXMLElement($returnData);
		$final_url = $xmlObj->MERCHANT->RESPONSE->url;
		// eof code to generate token
		// code to generate form action
		$param = “”;
		$param .= “&ttype=NBFundTransfer”;
		$param .= “&tempTxnId=”.$xmlObj->MERCHANT->RESPONSE->param[1];
		$param .= “&token=”.$xmlObj->MERCHANT->RESPONSE->param[2];
		$param .= “&txnStage=1″;
		$url = $url.”?”.$param;
		
	   return '1' ;*/ 
	}
	function viewProcess(){
		
		    $data['page_title']="Payments";
			$sessdata= $this->session->userdata('sms');
			if(!empty($sessdata)){
				$data['payments']=$this->Payment_model->get_mypayment_details($sessdata[0]->id);
				//p($data['payments']); exit;
				$sessdata= $this->session->userdata('sms');
				if($sessdata[0]->role_id == 5){
					$id = $sessdata[0]->parents_student_id;
					$role_id = 1;
				}else{
					$id = $sessdata[0]->id;
					$role_id = $sessdata[0]->role_id;
				}
				$data['user_row'] = $this->type_model->get_user_by_id($id,$role_id);
				if($sessdata[0]->role_id == 5){
					$degree_id = $data['user_row']->degree_id;
					$batch_id = $data['user_row']->batch_id;
				}else{
					$degree_id = $sessdata[0]->degree_id;
					$batch_id = $sessdata[0]->batch_id;
				}
				//p($data['user_row']); exit;
				$data['programs'] = $this->Discipline_model->get_program(); 
				$data['syllabus_years'] = $this->Discipline_model->get_syllabus_year();
				$data['semesters']=array();
			if(isset($data['user_row']->program_id))
				$data['semesters']= $this->Master_model->student_semester_list($data['user_row']->program_id,$data['user_row']->degree_id,$id);
			//p($data['semesters']); exit;
				$my_feedback= $this->Master_model->my_feedback($id);//echo $this->db->last_query();
				$my_feedbackArr=[];$my_feedbackstr='';
				foreach($my_feedback as $val){
					$my_feedbackstr.=$val['feedback_id'].',';
				}
				$my_feedbackstr = rtrim($my_feedbackstr,",");
				if($degree_id>0 && $batch_id>0){
					$data['get_feedbacks']= $this->Master_model->student_feedback($degree_id,$batch_id,$my_feedbackstr);
					
				}
				//echo $this->db->last_query();
				//p($data['get_feedbacks']);exit;
			}
			else{
				redirect('authenticate', 'refresh');
			}
			
			$this->load->view('admin/profile/student_page_view',$data);  
		
	}
	function myPaymentDetails(){
		
		    $data['page_title']="My Payment Details";
			$sessdata= $this->session->userdata('sms');
			if(!empty($sessdata)){
				$data['payments']=$this->Payment_model->get_mypayment_details($sessdata[0]->id);
				//p($data['payments']); exit;
				$sessdata= $this->session->userdata('sms');
				if($sessdata[0]->role_id == 5){
					$id = $sessdata[0]->parents_student_id;
					$role_id = 1;
				}else{
					$id = $sessdata[0]->id;
					$role_id = $sessdata[0]->role_id;
				}
				$data['user_row'] = $this->type_model->get_user_by_id($id,$role_id);
				if($sessdata[0]->role_id == 5){
					$degree_id = $data['user_row']->degree_id;
					$batch_id = $data['user_row']->batch_id;
				}else{
					$degree_id = $sessdata[0]->degree_id;
					$batch_id = $sessdata[0]->batch_id;
				}
				//p($data['user_row']); exit;
				$data['programs'] = $this->Discipline_model->get_program(); 
				$data['syllabus_years'] = $this->Discipline_model->get_syllabus_year();
				$data['semesters']=array();
			if(isset($data['user_row']->program_id))
				$data['semesters']= $this->Master_model->student_semester_list($data['user_row']->program_id,$data['user_row']->degree_id,$id);
			//p($data['semesters']); exit;
				$my_feedback= $this->Master_model->my_feedback($id);//echo $this->db->last_query();
				$my_feedbackArr=[];$my_feedbackstr='';
				foreach($my_feedback as $val){
					$my_feedbackstr.=$val['feedback_id'].',';
				}
				$my_feedbackstr = rtrim($my_feedbackstr,",");
				if($degree_id>0 && $batch_id>0){
					$data['get_feedbacks']= $this->Master_model->student_feedback($degree_id,$batch_id,$my_feedbackstr);
					
				}
				//echo $this->db->last_query();
				//p($data['get_feedbacks']);exit;
			}
			else{
				redirect('authenticate', 'refresh');
			}
			
			$this->load->view('admin/profile/my_payment_details',$data);  
		
	}
	function feedbackForm(){
		
		//print_r($_POST);
		    $data['page_title']="Feedback";
			$sessdata= $this->session->userdata('sms');
			$data['campuses'] = $this->Discipline_model->get_campus();
			$data['degrees'] = $this->Discipline_model->get_degree();
            $data['semesters'] = $this->Generate_model->get_semester(); 
            $data['batches'] = $this->Discipline_model->get_batches(); 
			
			//print_r($data['feedbacks']);
			if(!empty($sessdata)){
				
				$data['payments']=$this->Payment_model->get_mypayment_details($sessdata[0]->id);
				//p($data['payments']); exit;
				$sessdata= $this->session->userdata('sms');
				//$data['feedbacks'] = $this->Attendance_model->get_feedbacks(); 
				if(isset($_POST) && count($_POST) != '0')
				{
					$checkfeedback = $this->Attendance_model->get_feedbacks_entered();
					if(count($checkfeedback) == '0')
						$data['feedbacks'] = $this->Attendance_model->get_feedbacks_list(); 
					//print_r($data['feedbacks']);
				}
				if($sessdata[0]->role_id == 5){
					$id = $sessdata[0]->parents_student_id;
					$role_id = 1;
				}else{
					$id = $sessdata[0]->id;
					$role_id = $sessdata[0]->role_id;
				}
				$data['user_row'] = $this->type_model->get_user_by_id($id,$role_id);
				if($sessdata[0]->role_id == 5){
					$degree_id = $data['user_row']->degree_id;
					$batch_id = $data['user_row']->batch_id;
				}else{
					$degree_id = $sessdata[0]->degree_id;
					$batch_id = $sessdata[0]->batch_id;
				}
				//p($data['user_row']); exit;
				$data['programs'] = $this->Discipline_model->get_program(); 
				$data['syllabus_years'] = $this->Discipline_model->get_syllabus_year();
				$data['semesters']=array();
			if(isset($data['user_row']->program_id))
				$data['semesters']= $this->Master_model->student_semester_list($data['user_row']->program_id,$data['user_row']->degree_id,$id);
			//p($data['semesters']); exit;
				$my_feedback= $this->Master_model->my_feedback($id);//echo $this->db->last_query();
				$my_feedbackArr=[];$my_feedbackstr='';
				foreach($my_feedback as $val){
					$my_feedbackstr.=$val['feedback_id'].',';
				}
				$my_feedbackstr = rtrim($my_feedbackstr,",");
				if($degree_id>0 && $batch_id>0){
					//$data['get_feedbacks']= $this->Master_model->student_feedback($degree_id,$batch_id,$my_feedbackstr);
					//$data['feedbacks'] = $this->Attendance_model->get_feedbacks_list(); 
					
				}
				//echo $this->db->last_query();
				//p($data['get_feedbacks']);exit;
			}
			else{
				redirect('authenticate', 'refresh');
			}
			//print_r($data);
			$this->load->view('admin/profile/feedback',$data);  
		
	}
	function feedbackForm1(){
		
		//p($_POST);
		    $data['page_title']="Feedback";
			$sessdata= $this->session->userdata('sms');
			$data['campuses'] = $this->Discipline_model->get_campus();
			$data['degrees'] = $this->Discipline_model->get_degree();
            $data['semesters'] = $this->Generate_model->get_semester(); 
            $data['batches'] = $this->Discipline_model->get_batches(); 
			if(!empty($sessdata)){
				
				$sessdata= $this->session->userdata('sms');
				if($_POST != '')
				{
					$data['feedbacks'] = $this->Attendance_model->get_feedbacks_list(); 
					print_r($data['feedbacks']);
				}
				
				//$data['user_row'] = $this->type_model->get_user_by_id($id,$role_id);
				
				//p($data['user_row']); exit;
				//$data['programs'] = $this->Discipline_model->get_program(); 
				//$data['syllabus_years'] = $this->Discipline_model->get_syllabus_year();
				//$data['semesters']=array();
			
			
				//$my_feedback= $this->Master_model->my_feedback($id);//echo $this->db->last_query();
				//$data['get_feedbacks']= $this->Master_model->student_feedback($degree_id,$batch_id,$my_feedbackstr);
					
				//}
				//echo $this->db->last_query();
				//p($data['get_feedbacks']);exit;
			}
			else{
				redirect('authenticate', 'refresh');
			}
			
			$this->load->view('admin/profile/feedback',$data);  
		
	}
	function getfeeamount(){
		$name = $this->input->get('name');
		$type = $this->input->get('type');
		$result= $this->Master_model->getfeeamount($name,$type);
		
		echo isset($result[0]['fee_amount'])?$result[0]['fee_amount']:'';
	}
	function downloadReeipt()
	{
		if($this->input->post('submit')){
		$transaction_id = $this->input->post('transaction_id');
		$data['paymentRecord'] = $this->Payment_model->get_transaction_history($transaction_id);
			//echo "btech"; exit;
		$html=$this->load->view('admin/payment/transaction_history_view',$data, true);
		$pdfFilePath = "transaction_history.pdf";
        //load mPDF library
		$this->load->library('m_pdf');
        //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);
       //download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		exit;
		}
	}
	function sendFeedback()
	{
		//p($_POST); exit;
		$register_date_time=date('Y-m-d H:i:s');
		//echo "hello"; exit;
		$sessdata= $this->session->userdata('sms');
		//p($sessdata); exit;
	    $id = $sessdata[0]->id;
		$role_id = $sessdata[0]->role_id;
		//$campus_id = $sessdata[0]->campus_id;
		$sender_campus = $_POST['sender_campus'];
		$sender_program = $_POST['sender_program'];
		$sender_degree = $_POST['sender_degree'];
		$sender_batch = $_POST['sender_batch'];
		$sender_semester = $_POST['sender_semester'];
		$sender_discipline = $_POST['sender_discipline'];
		$sender_teacher = $_POST['sender_teacher'];
		
		$rate_value=$this->input->post('rate_value');
		$feedback_message=$this->input->post('feedback_message');
		$feedback_id=$this->input->post('feedback_id');
		for($i=0;$i<count($_POST['question']);$i++)
		{
			$ques = $_POST['question'][$i];
			$rate_val = $_POST['star'.$ques.''];
		$save['rate']=$rate_val;
		//$save['message']=$feedback_message;
		$save['message']=''	;
		$save['sender_id']=$id;
		$save['sender_type']=$role_id;
		$save['sender_campus']=$sender_campus;
		$save['sender_degree']=$sender_degree;
		$save['sender_program']=$sender_program;
		$save['sender_batch']=$sender_batch;
		$save['sender_semester']=$sender_semester;
		$save['sender_discipline']=$sender_discipline;
		$save['sender_teacher']=$sender_teacher;
		$save['created_on']=$register_date_time;
		$save['feedback_id']=$ques;
		//p($save);
		$data = $this->Process_model->save_process($save);
		//echo $this->db->last_query();
		}//exit;
		if(!empty($data)){ echo 1; redirect('process/feedbackForm', 'refresh');}else{echo 0;}
		
		
	}
	function  getstudentCourse()
	{
		//p($_POST) ; exit;
		$student_id     = $this->input->post('user_id');
		$user_role      = $this->input->post('user_role');
		$campus_id      = $this->input->post('campus_id');
		$program_id     = $this->input->post('program_id');
		$degree_id      = $this->input->post('degree_id');
	    $semester_id    = $this->input->post('semester_id');
		$batch_id       = $this->input->post('batch_id');
		$data['courses']=$this->Process_model->get_student_assign_course($campus_id,$program_id,$degree_id,$semester_id,$batch_id);
		//p($data['courses']); exit;
		 $str = '';
         foreach($data['courses'] as $k=>$v){
          $str .= "<option value=".$v->id.">".$v->course_title."</option>";
         }
		echo $str;
	}
	function getStudentAttendance()
	{
		//p($_POST); exit;
		$student_id=$this->input->post('user_id');
		$batch_id=$this->input->post('batch_id');
		$user_role=$this->input->post('user_role');
		$campus_id=$this->input->post('campus_id');
		$degree_id=$this->input->post('degree_id');
		$view_type=$this->input->post('view_type');
		$program_id=$this->input->post('program_id');
		$semester_id=$this->input->post('semester_id');
		$course_id=$this->input->post('course_id');
		
		$attendList= $this->Process_model->get_student_attendance_by_course_id($student_id,$campus_id,$program_id,$degree_id,$semester_id,$batch_id,$course_id);
		//p($attendList); exit;
		$i=0;
		$trdata='';
		$attendanceStatus='';
		foreach($attendList as $attandanceVal)
		{
			$i++;	
			$attendDate = strtotime($attandanceVal->attendance_date);
			$date   = date('d-m-Y',$attendDate);
			$status = $attandanceVal->attendance_status;
			if($status==1)
			{
				$attendanceStatus='Present';
			}
			else{
				$attendanceStatus='Absent';
			}
			$trdata.='<tr>
							<td><input type="hidden"  value="'.$i.'">'.$i.'</td>
							<td><label style="width:100px;">'.$date.'</label></td>
							<td><label style="width:100px;">'.$attendanceStatus.'</label></td>
					 </tr>';
		}
		echo $trdata;
		
		
	}
	function duplicateCertificate()
	{
		echo "hello"; exit;
	}
	function viewReport()
	{ //echo "hello"; exit;
		$sessdata= $this->session->userdata('sms');
		if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		}
		    $data['page_title']="My Reports Section";
			if($sessdata[0]->role_id == 5){
			$id = $sessdata[0]->parents_student_id;
			$role_id = 1;
			}else{
			$id = $sessdata[0]->id;
			$role_id = $sessdata[0]->role_id;
			}
				$data['user_row'] = $this->type_model->get_user_by_id($id,$role_id);
				//p($data['user_row']); exit;
				$data['programs'] = $this->Discipline_model->get_program(); 
				if(count($data['user_row'])>0)
			$data['semesters']= $this->Master_model->student_semester_list($data['user_row']->program_id,$data['user_row']->degree_id,$id);
			
		//print_r($data['programs']); exit;
		if($this->input->post('marksheet')){
			//p($_POST); exit;
        $student_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('user_role');
        $campus_id  = $this->input->post('campus_id');
		$batch_id  = $this->input->post('batch_id');
		$semester_id = $this->input->post('semester_id');
		$program_id  = $this->input->post('program_id');
		$degree_id  = $this->input->post('degree_id');
		//p($student_id); exit;
		
		$semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
		$degreeName = $this->Result_model->get_degree_name($degree_id); //getting degree name 
		$batchName = $this->Result_model->get_batch_name($batch_id); //getting batch name 
	   //print_r($semesterRow); exit;
		
		 $allData = array();
			         $studentRow = $this->type_model->get_user_row_by_id($student_id);
					 //p($studentRow); exit;
					 $subjectList = $this->Process_model->get_student_course_marks($student_id,$semester_id);
					// p($subjectList); exit;
				// p($subjectList); exit;
					 $list['first_name']  =$studentRow->first_name;
					 $list['last_name']  =$studentRow->last_name;
					 $list['user_unique_id']  =$studentRow->user_unique_id;
					// $list['user_image']  =$studentRow->user_image;
					 $list['batch_name']  =$batchName->batch_name;
				     $list['campus_name']  =$studentRow->campus_name;
					// $list['campus_code']  =$studentRow->campus_code;
				    $list['degree_name']  =$degreeName->degree_name;
				    $list['semester_name'] =$semesterRow->semester_name;
					 //$list['month_year']  =$monthYrr;
					
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
							   $courseRec['student_id']   = $subjectVal->student_id;
							   $courseRec['campus_id']   = $subjectVal->campus_id;
							   $courseRec['program_id']   = $subjectVal->program_id;
							   $courseRec['degree_id']   = $subjectVal->degree_id;
							   $courseRec['semester_id']   = $subjectVal->semester_id;
							   $courseRec['batch_id']   = $subjectVal->batch_id;
							   $courseRec['course_id']   = $subjectVal->course_id;
							   $courseRec['course_code']   = $subjectVal->course_code;
							   $courseRec['course_title']   = $subjectVal->course_title;
							   $courseRec['theory_credit']   = $subjectVal->theory_credit;
							   $courseRec['practicle_credit']   = $subjectVal->practicle_credit;
							   $courseRec['theory_internal1']   = $subjectVal->theory_internal1;
							   $courseRec['theory_internal2']   = $subjectVal->theory_internal2;
							   $courseRec['theory_internal3']   = $subjectVal->theory_internal3;
							   $courseRec['theory_internal']   = $subjectVal->theory_internal;
							   $courseRec['theory_paper1']   = $subjectVal->theory_paper1;
							   $courseRec['theory_paper2']   = $subjectVal->theory_paper2;
							   $courseRec['sum_internal_practical']   = $subjectVal->sum_internal_practical;
							   $courseRec['practical_internal']   = $subjectVal->practical_internal;
							   $courseRec['theory_external']   = $subjectVal->theory_external;
							   $courseRec['practical_external']   = $subjectVal->practical_external;
							   $courseRec['marks_sum']   = $subjectVal->marks_sum;
							   $courseRec['sum_internal']   = $subjectVal->sum_internal;
							   $courseRec['pass_condition1']   = $subjectVal->pass_condition1;
							   $courseRec['pass_condition2']   = $subjectVal->pass_condition2;
							   $courseRec['external_sum']   = $subjectVal->external_sum;
							   $courseRec['ncc_status']   = $subjectVal->ncc_status;
							   $courseRec['course_group_id']   = $subjectVal->course_group_id;
							   $courseRec['passfail_status']   = $subjectVal->passfail_status;
							   $courseRec['percentval']   = $subjectVal->percentval;
							   $courseRec['gradeval']   = $subjectVal->gradeval;
							   $courseRec['creditval']   = $subjectVal->creditval;
							   $courseRec['credithour']   = $subjectVal->credithour;
							   $courseRec['dstatus']   = $subjectVal->dstatus;
							   $dataList[]=$courseRec;
						} 
					$list['subjectList'] = $dataList;
				$data['myresult']=$list;
			//p($data['myresult']); exit;


		//load the view and saved it into $html variable
		if($degree_id=='1')
		{
				//echo "bvsc"; exit;
		   $html=$this->load->view('admin/report/mystudent_result_bvsc_view',$data, true);
		}
		if($degree_id!='1')
		{
			//echo "btech"; exit;
		   $html=$this->load->view('admin/report/mystudent_result_btech_view',$data, true);
		}
		// print_r($html); exit;
		//this the the PDF filename that user will get to download
		$pdfFilePath = "student_result.pdf";

		//load mPDF library
		$this->load->library('m_pdf');

		//generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);

		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");
		exit;
				
	}
	//*******************download marksheet start*****************************************//
		if($this->input->post('download_marksheet')){
			//p($_POST); exit;
        $student_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('user_role');
        $campus_id  = $this->input->post('campus_id');
		$batch_id  = $this->input->post('batch_id');
		$semester_id = $this->input->post('semester_id');
		$program_id  = $this->input->post('program_id');
		$degree_id  = $this->input->post('degree_id');
		//p($student_id); exit;
		
		$semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
		$degreeName = $this->Result_model->get_degree_name($degree_id); //getting degree name 
		$batchName = $this->Result_model->get_batch_name($batch_id); //getting batch name 
	   //print_r($semesterRow); exit;
		
		 $allData = array();
			         $studentRow = $this->type_model->get_user_row_by_id($student_id);
					 //p($studentRow); exit;
					 $subjectList = $this->Process_model->get_student_course_marks($student_id,$semester_id);
					//p($subjectList); exit;
				// p($subjectList); exit;
					 $list['first_name']  =$studentRow->first_name;
					 $list['last_name']  =$studentRow->last_name;
					 $list['user_unique_id']  =$studentRow->user_unique_id;
					// $list['user_image']  =$studentRow->user_image;
					 $list['batch_name']  =$batchName->batch_name;
				     $list['campus_name']  =$studentRow->campus_name;
					// $list['campus_code']  =$studentRow->campus_code;
				    $list['degree_name']  =$degreeName->degree_name;
				    $list['semester_name'] =$semesterRow->semester_name;
					 //$list['month_year']  =$monthYrr;
					
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
							   $courseRec['student_id']   = $subjectVal->student_id;
							   $courseRec['campus_id']   = $subjectVal->campus_id;
							   $courseRec['program_id']   = $subjectVal->program_id;
							   $courseRec['degree_id']   = $subjectVal->degree_id;
							   $courseRec['semester_id']   = $subjectVal->semester_id;
							   $courseRec['batch_id']   = $subjectVal->batch_id;
							   $courseRec['course_id']   = $subjectVal->course_id;
							   $courseRec['course_code']   = $subjectVal->course_code;
							   $courseRec['course_title']   = $subjectVal->course_title;
							   $courseRec['theory_credit']   = $subjectVal->theory_credit;
							   $courseRec['practicle_credit']   = $subjectVal->practicle_credit;
							   $courseRec['theory_internal1']   = $subjectVal->theory_internal1;
							   $courseRec['theory_internal2']   = $subjectVal->theory_internal2;
							   $courseRec['theory_internal3']   = $subjectVal->theory_internal3;
							   $courseRec['theory_internal']   = $subjectVal->theory_internal;
							   $courseRec['theory_paper1']   = $subjectVal->theory_paper1;
							   $courseRec['theory_paper2']   = $subjectVal->theory_paper2;
							   $courseRec['sum_internal_practical']   = $subjectVal->sum_internal_practical;
							   $courseRec['practical_internal']   = $subjectVal->practical_internal;
							   $courseRec['theory_external']   = $subjectVal->theory_external;
							   $courseRec['practical_external']   = $subjectVal->practical_external;
							   $courseRec['marks_sum']   = $subjectVal->marks_sum;
							   $courseRec['sum_internal']   = $subjectVal->sum_internal;
							   $courseRec['pass_condition1']   = $subjectVal->pass_condition1;
							   $courseRec['pass_condition2']   = $subjectVal->pass_condition2;
							   $courseRec['external_sum']   = $subjectVal->external_sum;
							   $courseRec['ncc_status']   = $subjectVal->ncc_status;
							   $courseRec['course_group_id']   = $subjectVal->course_group_id;
							   $courseRec['passfail_status']   = $subjectVal->passfail_status;
							   $courseRec['percentval']   = $subjectVal->percentval;
							   $courseRec['gradeval']   = $subjectVal->gradeval;
							   $courseRec['creditval']   = $subjectVal->creditval;
							   $courseRec['credithour']   = $subjectVal->credithour;
							   $courseRec['dstatus']   = $subjectVal->dstatus;
							   $dataList[]=$courseRec;
						} 
					$list['subjectList'] = $dataList;
				$data['myresult']=$list;
			//p($data['myresult']); exit;


		//load the view and saved it into $html variable
		if($degree_id=='1')
		{
				//echo "bvsc"; exit;
		   $html=$this->load->view('admin/report/mystudent_result_bvsc_view',$data, true);
		}
		if($degree_id!='1')
		{
			//echo "btech"; exit;
		   $html=$this->load->view('admin/report/mystudent_result_btech_view',$data, true);
		}
		// print_r($html); exit;
		//this the the PDF filename that user will get to download
		$pdfFilePath = "student_result.pdf";

		//load mPDF library
		$this->load->library('m_pdf');

		//generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);

		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		exit;
				
	}
	//*******************download marksheet*****************************************//
	
	//*************************Generate Hall Ticket*********************************//
		
		 if(!empty($this->input->post('hallticket')))
		 {  
	           
	           // $data['campuses'] = $this->Discipline_model->get_campus(); 
	            $student_id=$this->input->post('user_id');
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				$date_of_closure=$this->input->post('date_of_closure');
				//print_r($date_of_closure); exit;
				 //$batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				// print_r($batchYear->date_of_closure); exit;
				// $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				// $yrdata= strtotime($batch_year);
               //  $monthYrr= date('F-Y',$yrdata);				 
			//	print_r($monthYrr); exit;
				
				 $allData = array();
				     $semesterRow = $this->Result_model->get_semester_name($semester_id); 
					 $students = $this->Generate_model->get_studedent_data($student_id);
					// p($students); exit;
					 foreach($students as $stuData)
					 {
						$subjectList = $this->Generate_model->get_student_assigned_subjects($student_id,$semester_id);
						// p($subjectList); 
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_name']  =$stuData->degree_name;
						     //$list['month_year']  =$monthYrr;
						     $list['semester_name']  =$semesterRow->semester_name;
						    //p($list); exit;
								 $dataList =array();
								 foreach($subjectList as $subjectVal)
								 {    
							           $CourseArr['course_id']   = $subjectVal->id;
									   $CourseArr['course_code']   = $subjectVal->course_code;
									   $CourseArr['course_title']   = $subjectVal->course_title;
									   $dataList[] = $CourseArr;
								 }
								// p($dataList); exit;
						    $list['subjectList'] = $dataList;
						    $allData[] = $list;  
					 }  
				     $data['hall_tickets']=$allData;
				
			//p( $data['hall_tickets']); exit;
			
			
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/pdf/myhall_ticket_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "hall_ticket.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	        $this->m_pdf->pdf->Output($pdfFilePath, "I");
		
            exit;			
		 }
		 //*************************Generate Hall Ticket End*********************************//
		 
		 
	//*************************Generate Hall Ticket Download  Start*********************************//
		
		 if(!empty($this->input->post('hall_ticket_download')))
		 {  
	         // $data['campuses'] = $this->Discipline_model->get_campus(); 
	            $student_id=$this->input->post('user_id');
	            $campus_id=$this->input->post('campus_id');
				$program_id=$this->input->post('program_id');
				$degree_id=$this->input->post('degree_id');
				$semester_id=$this->input->post('semester_id');
				$batch_id=$this->input->post('batch_id');
				$date_of_start=$this->input->post('date_of_start');
				$date_of_closure=$this->input->post('date_of_closure');
				//print_r($date_of_closure); exit;
				 //$batchYear = $this->Generate_model->get_batch_and_year_name($date_of_closure); //getting batch and year
				// print_r($batchYear->date_of_closure); exit;
				// $batch_year=$batchYear->date_of_closure;
				 //print_r($batch_year); exit;
				// $yrdata= strtotime($batch_year);
               //  $monthYrr= date('F-Y',$yrdata);				 
			//	print_r($monthYrr); exit;
				
				 $allData = array();
				     $semesterRow = $this->Result_model->get_semester_name($semester_id); 
					 $students = $this->Generate_model->get_studedent_data($student_id);
					// p($students); exit;
					 foreach($students as $stuData)
					 {
						$subjectList = $this->Generate_model->get_student_assigned_subjects($student_id,$semester_id);
						// p($subjectList); 
						     $list['first_name']  =$stuData->first_name;
						     $list['last_name']  =$stuData->last_name;
						     $list['user_unique_id']  =$stuData->user_unique_id;
						     $list['user_image']  =$stuData->user_image;
						     $list['batch_name']  =$stuData->batch_name;
						     $list['campus_name']  =$stuData->campus_name;
						     $list['campus_code']  =$stuData->campus_code;
						     $list['degree_name']  =$stuData->degree_name;
						     //$list['month_year']  =$monthYrr;
						     $list['semester_name']  =$semesterRow->semester_name;
						    //p($list); exit;
								 $dataList =array();
								 foreach($subjectList as $subjectVal)
								 {    
							           $CourseArr['course_id']   = $subjectVal->id;
									   $CourseArr['course_code']   = $subjectVal->course_code;
									   $CourseArr['course_title']   = $subjectVal->course_title;
									   $dataList[] = $CourseArr;
								 }
								// p($dataList); exit;
						    $list['subjectList'] = $dataList;
						    $allData[] = $list;  
					 }  
				     $data['hall_tickets']=$allData;
				
			//p( $data['hall_tickets']); exit;
			
			
			//load the view and saved it into $html variable
			$html=$this->load->view('admin/pdf/myhall_ticket_view', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "hall_ticket.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	        $this->m_pdf->pdf->Output($pdfFilePath, "D");
		
            exit;			
		 }
		 //*************************Generate Hall Ticket Download End*********************************//
		 //echo "hello"; exit;
		 $data['managelist']="0";
			$this->load->view('admin/profile/report_view',$data); 
	}
	function viewMarks()
	{ //echo "hello"; exit;
		$sessdata= $this->session->userdata('sms');
		if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		}
		$data['page_title']="View Marks";
		if($sessdata[0]->role_id == 5){
		    $id = $sessdata[0]->parents_student_id;
		$role_id = 1;
		}else{
		    $id = $sessdata[0]->id;
		    $role_id = $sessdata[0]->role_id;
		}
			$data['user_row'] = $this->type_model->get_user_by_id($id,$role_id);
			//p($data['user_row']); exit;
			$data['programs'] = $this->Discipline_model->get_program(); 
			if(count($data['user_row'])>0)
		$data['semesters']= $this->Master_model->student_semester_list($data['user_row']->program_id,$data['user_row']->degree_id,$id);
		$data['managelist']="0";
		$this->load->view('admin/profile/view_marks',$data);
	}
	function viewMarkSheet()
	{ //echo "hello"; exit;
		$sessdata= $this->session->userdata('sms');
		if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		}
		$data['page_title']="View Mark Sheet";
		if($sessdata[0]->role_id == 5){
		$id = $sessdata[0]->parents_student_id;
		$role_id = 1;
		}else{
		$id = $sessdata[0]->id;
		$role_id = $sessdata[0]->role_id;
		}
			$data['user_row'] = $this->type_model->get_user_by_id($id,$role_id);
			//p($data['user_row']); exit;
			$data['programs'] = $this->Discipline_model->get_program(); 
			if(count($data['user_row'])>0)
		$data['semesters']= $this->Master_model->student_semester_list($data['user_row']->program_id,$data['user_row']->degree_id,$id);
		$data['managelist']="0";
		$this->load->view('admin/profile/view_mark_sheet',$data);
	}
	function viewHallTicket()
	{ //echo "hello"; exit;
		$sessdata= $this->session->userdata('sms');
		if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		}
		$data['page_title']="Hall Ticket";
		if($sessdata[0]->role_id == 5){
		$id = $sessdata[0]->parents_student_id;
		$role_id = 1;
		}else{
		$id = $sessdata[0]->id;
		$role_id = $sessdata[0]->role_id;
		}
			$data['user_row'] = $this->type_model->get_user_by_id($id,$role_id);
			//p($data['user_row']); exit;
			$data['programs'] = $this->Discipline_model->get_program(); 
			if(count($data['user_row'])>0)
		$data['semesters']= $this->Master_model->student_semester_list($data['user_row']->program_id,$data['user_row']->degree_id,$id);
		$data['managelist']="0";
		$this->load->view('admin/profile/view_hall_ticket',$data);
	}
	function viewAttendance()
	{ //echo "hello"; exit;
		$sessdata= $this->session->userdata('sms');
		if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		}
		$data['page_title']="View Attendance";
		if($sessdata[0]->role_id == 5){
		$id = $sessdata[0]->parents_student_id;
		$role_id = 1;
		}else{
		$id = $sessdata[0]->id;
		$role_id = $sessdata[0]->role_id;
		}
			$data['user_row'] = $this->type_model->get_user_by_id($id,$role_id);
			//p($data['user_row']); exit;
			//$data['programs'] = $this->Discipline_model->get_program(); 
			//if(count($data['user_row'])>0)
		//$data['semesters']= $this->Master_model->student_semester_list($data['user_row']->program_id,$data['user_row']->degree_id,$id);
		//echo $this->db->last_query();exit;
		$data['managelist']="0";
		$this->load->view('admin/profile/view_attendance',$data);
	}
	function getMarks()
	{
		//p($_POST); exit;
		$campus_id = $this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$semester_id=$this->input->post('semester_id');
		$batch_id=$this->input->post('batch_id');
		$user_id=$this->input->post('user_id');
		$marks_type=$this->input->post('marks_type');
		$exam_type=$this->input->post('exam_type');

        $send['campus_id']=$campus_id;
        $send['program_id']=$program_id;
        $send['degree_id']=$degree_id;
        $send['batch_id']=$batch_id;
        $send['semester_id']=$semester_id;
       // $send['discipline_id']=$discipline_id;
        $send['student_id']=$user_id;
        $send['exam_type']=$exam_type;
        $send['publish_marks']=1;
		$studentList= $this->Marks_model->get_student_assigned_marks($send);
		//p($studentList); exit;
		$trdata='';
		$i=0;
		if(count($studentList)>0) {
            foreach ($studentList as $students) {
                $courseArr = get_course_name($degree_id,$students->course_id);//p($courseArr);exit;
                if ($degree_id == '1') {
                    $i++;
                    $checked = 'checked';
                    $readonly = 'readonly';
                    $disabled = 'disabled';
                    if($courseArr[0]['coure_group_id'] == 22){
                        $ncc_status='';
                        if($students->ncc_status == 1)
                            $ncc_status = "Satisfactory";
                        elseif($students->ncc_status == 0)
                            $ncc_status = "Not Satisfactory";
                        $trdata .= '<tr>
								<td  class="text-center"><input type="hidden"  value="' . $i . '">' . $i . ' 
								<input type="hidden" name="student_id[]" value="' . $students->id . '"></td>
							 
							  <td  class="text-center">' . $courseArr[0]['course_subject_title'] . '</td>
							  <td colspan="7"  class="text-center">' . $ncc_status . '</td></tr>';
                    }else {
                        $trdata .= '<tr>
								<td  class="text-center"><input type="hidden"  value="' . $i . '">' . $i . ' 
								<input type="hidden" name="student_id[]" value="' . $students->id . '"></td>
							 
							  <td  class="text-center">' . $courseArr[0]['course_subject_title'] . '</td>
							  <td  class="text-center">' . $students->theory_internal1 . '</td>
							  <td class="text-center">' . $students->theory_internal2 . '</td>
							  <td class="text-center">' . $students->theory_internal3 . '</td>
							 
							  <td class="text-center">' . $students->theory_paper1 . '</td>
							   <td class="text-center">' . $students->theory_paper2 . '</td>
							 
							  <td class="text-center">' . $students->theory_external1 . '</td>
							   <td class="text-center">' . $students->theory_external2 . '</td>
							 
							  
						</tr>';
                    }
                }
                if ($degree_id != '1') {
                    $i++;
                    $checked = 'checked';
                    $readonly = 'readonly';
                    $disabled = 'disabled';
                    $trdata .= '<tr>
				           <td><input type="hidden"  value="' . $i . '">' . $i . '  
						   <input type="hidden" name="student_id[]" value="' . $students->id . '"></td>
						 
						  <td>' . $courseArr[0]['course_title'] . '</td>
						  <td><label style="width:60px;">' . $students->theory_internal . '</label></td>
						  <td><label style="width:60px;">' . $students->practical_internal . '</label></td>
						  <td><label style="width:60px;">' . $students->theory_external . '</label></td>
					      </tr>';
                }
            }
        }else{
            $trdata .= '<tr><td style="text-align: center;" colspan="9">Results not published</td></tr>';
        }
		echo $trdata;
	}
	function myStudentResult()
	{
		$student_id  = $this->input->post('student_id');
		$batch_id  = $this->input->post('batch_id');
		$role_id  = $this->input->post('role_id');
		$semester_id = $this->input->post('semester_id');
		$program_id  = $this->input->post('program_id');
		$degree_id  = $this->input->post('degree_id');
		//p($student_id); exit;
		
		$semesterRow = $this->Result_model->get_semester_name($semester_id); //getting semester name 
		$degreeName = $this->Result_model->get_degree_name($degree_id); //getting degree name 
		$batchName = $this->Result_model->get_batch_name($batch_id); //getting batch name 
	   //print_r($semesterRow); exit;
		
		 $allData = array();
			         $studentRow = $this->type_model->get_user_row_by_id($student_id);
					// p($studentRow); exit;
					 $subjectList = $this->Result_model->get_student_all_course_data($student_id);
					// p($subjectList); exit;
				// p($subjectList); exit;
					 $list['first_name']  =$studentRow->first_name;
					 $list['last_name']  =$studentRow->last_name;
					 $list['user_unique_id']  =$studentRow->user_unique_id;
					// $list['user_image']  =$studentRow->user_image;
					 $list['batch_name']  =$batchName->batch_name;
				     $list['campus_name']  =$studentRow->campus_name;
					// $list['campus_code']  =$studentRow->campus_code;
				    $list['degree_name']  =$degreeName->degree_name;
				    $list['semester_name'] =$semesterRow->semester_name;
					 //$list['month_year']  =$monthYrr;
					
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
								
							   $total_marks = $data['theory_internal']+$data['practical_internal']+$data['theory_external']+$data['practical_external'];
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
						// p($dataList); exit;
					$list['subjectList'] = $dataList;
					//$allData[] = $list;  
			 
			 $data['myresult']=$list;
			//p($data['myresult']); exit;


		//load the view and saved it into $html variable
		$html=$this->load->view('admin/report/mystudent_result_view',$data, true);
		// print_r($html); exit;
		//this the the PDF filename that user will get to download
		$pdfFilePath = "student_result.pdf";

		//load mPDF library
		$this->load->library('m_pdf');

		//generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);

		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "I");
		exit;			
		
		
	}
	function userProfile()
	{      $sessdata= $this->session->userdata('sms');
	     //  p($sessdata); exit;
	       $id = $sessdata[0]->id;
		   $role_id = $sessdata[0]->role_id;
		   if($id=='')
		   {
			 redirect('authenticate', 'refresh');
		   }
		   else
		   {
		    // print_r($id); exit;
		   $data['roles']=$this->type_model->get_role();
		   $data['countries']=$this->type_model->get_country();
		   $data['states']=$this->type_model->get_state();
		   $data['batches']=$this->Discipline_model->get_batches();
		   $data['campuses']=$this->Discipline_model->get_campus();
		   $data['degrees']=$this->Discipline_model->get_degree();
		   $data['countries']=$this->type_model->get_country();
		   $data['states']=$this->type_model->get_state();
		   $data['students']=$this->type_model->get_students();
		  // $data['student_parent']=$this->type_model->get_students_relates_parent($id,$role_id);
		   
		  // p($data['students']); exit;
		   $data['user_row'] = $this->type_model->get_user_by_id($id,$role_id);
		   //p($data['user_row']); exit;
		   if($role_id=='1')
		   {
			$data['page_title']="My Profile";
		    $this->load->view('admin/profile_student_view',$data); //student edit view
		   }
		    if($role_id=='2')
		   {
			$data['page_title']="Teacher Profile";
			$data['disciplines'] = $this->Discipline_model->get_discipline(); 
			$data['campuses']=$this->type_model->get_campus();
		    $this->load->view('admin/profile_teacher_view',$data);
		   }
		   if($role_id=='3')
		   {
			$data['page_title']="My Profile";
			$this->load->view('admin/profile_view13',$data);  //user edit view
		   }
		   if($role_id=='0')
		   {
			$data['page_title']="Super Admin";
			$this->load->view('admin/profile_admin_view',$data);  //user edit view
		   }
		    if($role_id=='5')
		   {
			$data['page_title']="Parent Profile";
			$data['programs'] = $this->Discipline_model->get_program();
			$data['semesters'] = $this->Discipline_model->get_semester();
			$this->load->view('admin/profile_parent_view',$data);  //user edit view
		   }
		
		
		 }
	}
	function updateProfile()
	{   
	    $register_date_time=date('Y-m-d H:i:s');
		$sessdata= $this->session->userdata('sms');
	    $id = $sessdata[0]->id;
		$role_id = $this->input->post('role_id');
		//p($role_id); exit;
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$contact_number = $this->input->post('contact_number');
		$roll = $this->input->post('roll');
		$gender = $this->input->post('gender');
		$batch_id = $this->input->post('batch_id');
		$campus_id = $this->input->post('campus_id');
		$degree_id = $this->input->post('degree_id');
		$type_id = $this->input->post('type_id');
		$religion = $this->input->post('religion');
		$nationality = $this->input->post('nationality');
		$zip_code = $this->input->post('zip_code');
		$country = $this->input->post('country');
		$state = $this->input->post('state');
		$dob = $this->input->post('dob');
		if($role_id=='0')
		{   
	        $save['created_on'] = $register_date_time;
			$save['first_name']=$first_name;
			$save['last_name']=$last_name;
			$save['email']=$email;
			$save['contact_number']=$contact_number;
			$save['gender']=$gender;
			$save['dob']=$dob;
			$save['roll'] =$role_id;
			$save['user_id']=$id;
			//p($save); exit;
			$last_id = $this->type_model->save_update_request($save);
		}
		else{
			$save['first_name']=$first_name;
			$save['last_name']=$last_name;
			$save['email']=$email;
			$save['contact_number']=$contact_number;
			$save['roll']=$roll;
			$save['gender']=$gender;
			$save['batch']=$batch_id;
			$save['campus']=$campus_id;
			$save['degree']=$degree_id;
			$save['course_type']=$type_id;
			$save['religion']=$religion;
			$save['nationality']=$nationality;
			$save['zip_code']=$zip_code;
			$save['country']=$country;
			$save['state']=$state;
			$save['user_id']=$id;
			$save['created_on']=$register_date_time;
			
			$last_id = $this->type_model->save_update_request($save);
		}
		//print_r($last_id); exit;
		$this->session->set_flashdata('message', 'Update Request Send Successfully');
	    redirect('profile/userProfile');
	}
	function listRequest()
	{
		$data['page_title']='User Update Request';
		$data['userRequests']=$this->type_model->get_update_request();
		//p($data['listUserList']); exit;
		$this->load->view('admin/user_update_request_view',$data);
		
	}
	
	function approveUser($requestId)
	{
		//echo $requestId; exit;
		$register_date_time=date('Y-m-d H:i:s');
		$reqData=$this->type_model->get_request_row($requestId);
	//p($reqData); exit;
		$updateCommon['first_name']=$reqData->first_name;
		$updateCommon['last_name']=$reqData->last_name;
		$updateCommon['email']=$reqData->email;
		$updateCommon['contact_number']=$reqData->contact_number;
		$updateCommon['gender']=$reqData->gender;
		$updateCommon['id']=$reqData->user_id;
		$updateCommon['updated_on']=$register_date_time;
		//p($updateCommon); exit;
		$updateDetails['batch_id']=$reqData->batch;
		$updateDetails['campus_id']=$reqData->campus;
		$updateDetails['degree_id']=$reqData->degree;
		$updateDetails['roll']=$reqData->roll;
		$updateDetails['course_type']=$reqData->course_type;
		$updateDetails['religion']=$reqData->religion;
		$updateDetails['nationality']=$reqData->nationality;
		$updateDetails['zip_code']=$reqData->zip_code;
		$updateDetails['country_id']=$reqData->country;
		$updateDetails['state_id']=$reqData->state;
		$updateDetails['user_id']=$reqData->user_id;
		
		//p($updateDetails); exit;
		$updatecommon=$this->type_model->update_user_request_common($updateCommon);
		$updatedetail=$this->type_model->update_user_request_detail($updateDetails);
		//print_r($updatedetail);exit;
		if($updatedetail=='1')
		{
		   $this->type_model->update_user_request_delete($reqData->id);
		}
		
		$this->session->set_flashdata('message', 'User Request Updated Successfully');
	    redirect('profile/listRequest');
		
	}
	
	function updateTeacherProfile()
	{
		//p($_POST); exit;
	  	$user_id = $this->input->post('user_id');
	  	$role_id = $this->input->post('role_id');
	  	$name = $this->input->post('name');
		$teacherName = explode(' ',$name);
		//p($teacherName); exit;
		$first_name = $teacherName[0];
		$last_name = $teacherName[1];
	  	$contact_number = $this->input->post('contact_number');
	  	$gender = $this->input->post('gender');
	  	$dob = $this->input->post('dob');
	  	$employee_id = $this->input->post('employee_id');
	  	$qualification = $this->input->post('qualification');
	  	$doj = $this->input->post('doj');
	  	$designation = $this->input->post('designation');
	  	$department = $this->input->post('department');
	  	$campus = $this->input->post('campus');
	  	$discipline_id = $this->input->post('discipline_id');
	  	
		
		$save['id'] = $user_id;
		$save['role_id'] = $role_id;
		$save['first_name'] = $first_name;
		$save['last_name'] = $last_name;
		$save['contact_number'] = $contact_number;
		$save['gender'] = $gender;
		$save['dob'] = $dob;
		
		$saveT['employee_id'] = $employee_id;
		$saveT['qualification'] = $qualification;
		$saveT['date_of_joining'] = $doj;
		$saveT['designation'] = $designation;
		$saveT['department'] = $department;
		$saveT['campus'] = $campus;
		$saveT['department'] = $discipline_id;
		
		$this->type_model->update_teacher_profile($save);
		$this->type_model->update_details_teacher_profile($saveT);
		$this->session->set_flashdata('message', 'Teacher Profile Updated Successfully');
		redirect('profile/userProfile');
		
	}

}
?>