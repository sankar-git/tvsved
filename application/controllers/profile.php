<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends CI_Controller {
	
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
			
			$this->load->model('newsession_model');
			$this->load->model('user_model');
			$this->load->model('type_model');
			$this->load->model('Master_model');
			$this->load->model('Discipline_model');
			$this->load->library('permission_lib');
			$this->load->model('Result_model');
			
			$this->load->library('excel');
		   $sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }
	}
	
	public function index()
	{
	    //echo "hello"; exit;
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
					 $subjectList = $this->Result_model->get_student_all_course_data(99);
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
	function updateOTP(){
		$sessdata= $this->session->userdata('sms');
	    $id = $sessdata[0]->id;
		$otp = $this->input->post('otp');
		$where = array('user_id'=>$id,'otp'=>$otp);
		$res=$this->type_model->get_update_request($where);
		if(count($res)>0){
			if($res[0]->difference > 15){
				$this->session->set_flashdata('message', 'Your OTP is expired. Please update again');
				redirect('profile/userProfile/1');
			}else{
				$register_date_time=date('Y-m-d H:i:s');
				$updateCommon['email']=$res[0]->email;
				$updateCommon['contact_number']=(isset($res[0]->contact_number)? $res[0]->contact_number:0);
				$updateCommon['updated_on']=$register_date_time;
				$updateCommon['id']=$res[0]->user_id;
				$updatecommon=$this->type_model->update_user_request_common($updateCommon);
				if($updatecommon)
				{
				   $this->type_model->update_user_request_delete($res[0]->id);
				}
				$this->session->set_flashdata('message', 'User Request Updated Successfully');
				redirect('profile/userProfile/');
			}
		}else{
			$this->session->set_flashdata('message', 'Please enter correct OTP.');
			redirect('profile/userProfile/1');
		}
		
	}
	function userProfile($otp=0)
	{      //$this->output->enable_profiler(TRUE);
	       $sessdata= $this->session->userdata('sms');
	       $id = $sessdata[0]->id;
		   $role_id = $sessdata[0]->role_id;
		   //print_r($sessdata); exit;
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
		   $data['disciplines'] = $this->Discipline_model->get_discipline(); 
		   $data['countries']=$this->type_model->get_country();
		   $data['states']=$this->type_model->get_state();
		  //$data['students']=$this->type_model->get_students();
		  // $data['student_parent']=$this->type_model->get_students_relates_parent($id,$role_id);
		   
		  // p($data['students']); exit;
		   $data['user_row'] = $this->type_model->get_user_by_id($id,$role_id);
		   $data['otp_flag'] = $otp;
		   //echo $this->db->last_query();
		   //p($data['user_row']); exit;
		   if($role_id=='1')
		   {
			$data['page_title']="My Profile";
			$user_pending_array = $this->type_model->get_pending_user_by_id($id);
			$data['email_pending'] =false;
			$data['mobile_pending'] =false;
			foreach($user_pending_array as $userval){
				if($data['user_row']->email !=$userval['email'])
					$data['email_pending'] =true;
				if($data['user_row']->contact_number !=$userval['contact_number'])
					$data['mobile_pending'] =true;
				
			}
		    $this->load->view('admin/profile_student_view',$data); //student edit view
		   }else
		   {
			$data['page_title']="My Profile";
			
			
			$user_pending_array = $this->type_model->get_pending_user_by_id($id);
			$data['email_pending'] =false;
			$data['mobile_pending'] =false;
			foreach($user_pending_array as $userval){
				if($data['user_row']->email !=$userval['email'])
					$data['email_pending'] =true;
				if($data['user_row']->contact_number !=$userval['contact_number'])
			$data['mobile_pending'] =true;
		}
		    $this->load->view('admin/profile_teacher_view',$data);
		   }
		   
		
		
		 }
	}
	function updateProfile()
	{  
      // p($_POST); exit;	
	    $register_date_time=date('Y-m-d H:i:s');
		$sessdata= $this->session->userdata('sms');
	    $id = $sessdata[0]->id;
		$role_id = $this->input->post('role_id');
		//p($sessdata); exit;
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
		$caste = $this->input->post('caste');
		$update_contact = @$this->input->post('update_contact');
		if($role_id=='0')
		{   
	        $save['created_on'] = $register_date_time;
			$save['first_name']=$first_name;
			$save['last_name']=$last_name;
			$save['email']=$email;
			$save['contact_number']=$contact_number;
			$save['gender']=$gender;
			$save['dob']=$dob;
			$save['caste'] =$caste;
			//$save['user_id']=$id;
			//p($save); exit;
			//$last_id = $this->type_model->save_update_request($save);
			$this->type_model->update_user_id($save,$id);
		}
		else{
			//echo "coming";exit;
			$save['first_name']=$sessdata[0]->first_name;
			$save['last_name']=$sessdata[0]->last_name;
			if($update_contact == 2)
				$save['email']=$email;
			else
				$save['email']=$sessdata[0]->email;
			if($update_contact == 1)
				$save['contact_number']=$contact_number;
			else
				$save['contact_number']=$sessdata[0]->contact_number;
			$save['roll']=$sessdata[0]->role_id;
			$save['gender']=$sessdata[0]->gender;
			$save['batch']=$sessdata[0]->batch_id;
			$save['campus']=$sessdata[0]->campus_id;
			$save['degree']=$sessdata[0]->degree_id;
			$save['course_type']=$sessdata[0]->course_type;
			//$save['religion']=$sessdata[0]->religion;
			//$save['nationality']=$sessdata[0]->nationality;
			//$save['zip_code']=$sessdata[0]->zip_code;
			//$save['country']=$sessdata[0]->country;
			//$save['state']=$sessdata[0]->state;
			$save['user_id']=$id;
			$save['created_on']=$register_date_time;
			$otp = strtoupper(substr(md5(uniqid()), 0, 4));
			$save['otp']=$otp;
			
			//p($sessdata); 
			//p($save); exit;
			$otp_send=false;
			$last_id = $this->type_model->save_update_request($save);
			if($role_id!='1'){
				$otp_send = $this->otp_msg($contact_number,$email,$otp);
			}
			
		}
		//print_r($last_id); exit;
		$this->session->set_flashdata('message', 'Update Request Send Successfully.');
		//echo "sdgsgsdg".$otp_send;exit;
		if($otp_send)
			redirect('profile/userProfile/1');
		else
			redirect('profile/userProfile');
	}
	function resendotp(){
		$sessdata= $this->session->userdata('sms');
		
	    $id = $sessdata[0]->id;
		$otp = strtoupper(substr(md5(uniqid()), 0, 4));
		$save['otp']=$otp;
		
		$pending_requestArr = $this->type_model->get_pending_request_row($id);//echo $this->db->last_query();exit;
		$last_id = $this->type_model->save_update_request($save,$id);//echo $this->db->last_query();exit;
		
		$this->otp_msg($pending_requestArr->contact_number,$pending_requestArr->email,$otp);
		$this->session->set_flashdata('message', 'OTP Request Send Successfully.');
		
		redirect('profile/userProfile/1');
	}
	function otp_msg($contact_number,$email,$otp){
		$flag = false;
		$sessdata= $this->session->userdata('sms');
		//print_r($sessdata);exit;
		if($sessdata[0]->contact_number!=$contact_number){
			$msg = 'Dear '.$sessdata[0]->first_name.",\n";
			$msg.= "Your One time password(OTP) number is ($otp). This OTP is valid for 15 minutes. Don't share it with anyone";
			send_sms($msg,$contact_number);
			$sessdata[0]->contact_number = $contact_number;
			$this->session->set_userdata('sms',$sessdata);
			$flag = true;
		}
		if($sessdata[0]->email!=$email){
			$msg = 'Dear '.$sessdata[0]->first_name.",\n";
			$msg.= "Your One time password(OTP) number is ($otp). This OTP is valid for 15 minutes. Don't share it with anyone";
			$this->load->config('email');
			$this->email->from($this->config->item('from_email'), $this->config->item('from_name'));
			@$this->email->to($email);
			@$this->email->subject('Email ID Verification');
			@$this->email->message($msg);
			@$result=$this->email->send();
			$sessdata[0]->email = $email;
			$this->session->set_userdata('sms',$sessdata);
			$flag = true;
		}
		return $flag;
			
	}
	
	function getNewEmail()
	{
		$session_data= $this->session->userdata('sms');
		$user_id=$session_data[0]->id;
		$email = $this->input->post('email');
		$emailErr='';
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
         $emailErr = "0"; 
        }
		else{
			//p('hello'); exit;
		  $data = $this->type_model->update_user_email($email,$user_id);
		  $emailErr = "1";
		}
		//p($emailErr); exit;
		echo $emailErr; exit;
		
	}
	function getContactNumber()
	{
		$mobile_number=$this->input->post('mobile_number');
		$otp=rand(0000,9999);
		//p($mobile_number); exit;
		$data=$this->type_model->get_matched_mobile_number($mobile_number);
		//p($data); exit
		$msgdata='';
		if(!empty($data)){
		$msgdata ="This number already exist";
		}
		else
		{
			$msgdata = $this->send_otp($mobile_number,$otp);
			$otpArr['otp']=$msgdata;
			$otpArr['mobile']=$mobile_number;
			$this->session->set_userdata('otpMsg',$otpArr);
		}
		echo $msgdata; exit;
	}
	function verifyMe()
	{
		$session_otp= $this->session->userdata('otpMsg');
		$session_data= $this->session->userdata('sms');
		$user_id=$session_data[0]->id;
		//p($session_otp); exit;
		$otpmsg = $session_otp['otp'];
		$mobile = $session_otp['mobile'];
		$verifyotp=$this->input->post('verifyotp');
		$data='';
		if($verifyotp==$otpmsg)
		{
			$data = $this->type_model->update_user_phone($user_id,$mobile);
		}
		else
		{
			$data=0;
		}
		echo $data;
		
	}
	 function send_otp($phone,$otp)
    {
	if(isset($otp) && isset($phone))
	{
		$urll = urlencode("Hi , ".$otp." is the One Time Password (OTP) to verify your Account Sign In "); 

		
		$msgSentUrl = "http://api.msg91.com/api/sendhttp.php?sender=onebus&route=4&mobiles=".$phone."&country=91&authkey=111566AKQz11XM8N5743ff3a&message=".$urll;
		
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => $msgSentUrl,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
	}
	
	return $otp; 
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
		$updateCommon['first_name']=$reqData->first_name;
		$updateCommon['last_name']=$reqData->last_name;
		$updateCommon['email']=$reqData->email;
		$updateCommon['contact_number']=(isset($reqData->contact_number)? $reqData->contact_number:0);
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
		//$updatedetail=$this->type_model->update_user_request_detail($updateDetails);
		//print_r($updatedetail);exit;
		//if($updatedetail=='1')
		//{
		   $this->type_model->update_user_request_delete($reqData->id);
		//}
		
		$this->session->set_flashdata('message', 'User Request Updated Successfully');
	    redirect('profile/listRequest');
		
	}
	function showUpdateRequest($row_id)
	{
		$data['page_title']='Update Request Details';
		$data['request_view']=$this->type_model->view_update_request($row_id);
		//p($data['request_view']); exit;
		$this->load->view('admin/view_user_update_request',$data);
	}
	function updateTeacherProfile()
	{
		//p($_POST); exit;
	  	$user_id = $this->input->post('user_id');
	  	$role_id = $this->input->post('role_id');
	  	$name = $this->input->post('first_name');
		$teacherName = explode(' ',$name);
		
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
	  	$email = $this->input->post('email');
	  	
		
		$save['id'] = $user_id;
		$save['role_id'] = $role_id;
		$save['first_name'] = $first_name;
		$save['last_name'] = $last_name;
		//$save['contact_number'] = $contact_number;
		$save['gender'] = $gender;
		$save['dob'] = $dob;
		$save['email'] = $email;
		
		//$saveO['id'] = $user_id;
		$saveO['user_id'] = $user_id;
		$saveO['roll'] = $role_id;
		$saveO['first_name'] = $first_name;
		$saveO['last_name'] = $last_name;
		$saveO['contact_number'] = $contact_number;
		$saveO['gender'] = $gender;
		$saveO['dob'] = $dob;
		$saveO['email'] = $email;
		
		$saveT['employee_id'] = $employee_id;
		$saveT['id'] = $employee_id;
		$saveT['qualification'] = $qualification;
		$saveT['date_of_joining'] = $doj;
		$saveT['designation'] = $designation;
		$saveT['department'] = $department;
		$saveT['campus'] = $campus;
		$saveT['department'] = $discipline_id;
		$otp = strtoupper(substr(md5(uniqid()), 0, 4));
		$saveO['otp']=$otp;
		$this->type_model->update_teacher_profile($save);
		$this->type_model->update_details_teacher_profile($saveT);
		
		$last_id = $this->type_model->save_update_request($saveO);
		$otp_flag = $this->otp_msg($contact_number,$email,$otp);
		//echo $otp_flag;
		$this->session->set_flashdata('message', 'Teacher Profile Updated Successfully');
		if($otp_flag)
			redirect('profile/userProfile/1');
		else
			redirect('profile/userProfile');
		
	}

}
?>