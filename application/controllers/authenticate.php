<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Authenticate extends CI_Controller {

 function __construct()
 {
	parent::__construct();
	//$this->load->helper(array('form', 'url'));
	$this->load->database();
	$this->load->library('session');
	$this->load->helper('form');
	$this->load->model('common_model');
	$this->load->helper('url');
	$this->load->library('form_validation');	
	$this->load->library('email');
	$this->load->model('type_model');

}

 function index()
 {  
    $data['page_title'] = 'Login';
    $this->load->view('admin/login_view_new',$data); 
  
 }
 function parentLogin()
 {
	$data['page_title'] = 'Parent Login';
    $this->load->view('admin/parent_login_view',$data); 
 }
 function deanLogin()
 {
	$data['page_title'] = 'Dean Login';
    $this->load->view('admin/dean_login_view',$data); 
 }
 function teacherLogin()
 {
	$data['page_title'] = 'Teacher Login';
    $this->load->view('admin/teacher_login_view',$data); 
 }
 function studentLogin()
 {
	$data['page_title'] = 'Student Login';
    $this->load->view('admin/student_login_view',$data); 
 }
 function studentAluminiLogin()
 {
	$data['page_title'] = 'Student Login';
    $this->load->view('admin/student_login_view',$data); 
 }
  function juniorAdmin()
 {
	$data['page_title'] = 'Junior Admin Login';
    $this->load->view('admin/junior_admin_login_view',$data); 
 } 
 function user_login()
 {
	 //echo "hello"; exit;
	 $username= $this->input-> post('username');
	 $password = $this->input-> post('password');
	 $user_data = array(
			 'username'=> $username,
	 		 'password' => $password
 				);
		//p($user_data)	; exit;	
	//$data_fromdatabase=$this->common_model->selectWhere('users', $user_data) ;
	$data_fromdatabase=$this->common_model->admin_login('users', $user_data) ;
	//echo "<pre>";p($data_fromdatabase);//exit();
	//count($data_fromdatabase); exit;
//	echo $this->db->last_query();//p($data_fromdatabase); exit;
	if(count($data_fromdatabase) >0)
	{
		//echo "hello"; exit;
		//$this->common_model->update_logondateTime($username);
		//echo "<pre>";print_r($data_fromdatabase); 
		//$data_fromdatabase['0]->
        if($data_fromdatabase[0]->role_id == 1 || $data_fromdatabase[0]->role_id == 6 || $data_fromdatabase[0]->role_id == 5)
            $data_fromdatabase = $this->common_model->do_student_login($user_data) ;
        else
            $data_fromdatabase = $this->common_model->do_teacher_login($user_data) ;
       // elseif($data_fromdatabase[0]->role_id == 3)
        //    $data_fromdatabase=$this->common_model->do_parent_login('user_map_student_details', $user_data) ;
       // elseif($data_fromdatabase[0]->role_id == 4)
         //   $data_fromdatabase=$this->common_model->do_junior_login($user_data) ; //junior admin
        //elseif(in_array($data_fromdatabase[0]->role_id,array(7,9,10,11,12)))
          //  $data_fromdatabase = $this->common_model->do_dean_login($user_data) ;
        //elseif($data_fromdatabase[0]->role_id == 8)
          //  $data_fromdatabase=$this->common_model->do_junior_login($user_data) ; //junior admin
			//echo $this->db->last_query();
		//echo "<pre>";print_r($data_fromdatabase); exit;
        $this->session->set_userdata('sms',$data_fromdatabase);
		//p($this->session->userdata('sms'));exit;
        $data['last_login_time']=date('Y-m-d H:i:s');
		$this->common_model->update_login_time($data_fromdatabase[0]->id,$data);
		$this->common_model->update_log($data_fromdatabase[0]->id,'login');
		///redirect('admin/dashboard','refresh');
		redirect('profile/userProfile');
	}else{
		$this->session->set_flashdata('message','<span style="color:red">Invalid Username or Password</span>');
		redirect('authenticate');
		redirect('authenticate','refresh');
	}
	
 }
 function junior_login()
 {
	// echo "hello"; exit;
	 $username= $this->input-> post('username');
	 $password = $this->input-> post('password');
	 $user_data = array(
			 'username'=> $username,
	 		 'password' => $password
 				);
	
	$data_fromdatabase=$this->common_model->do_junior_login($user_data) ; //junior admin
	if(count($data_fromdatabase) >0)
	{
	    $this->session->set_userdata('sms',$data_fromdatabase);
		$data['last_login_time']=date('Y-m-d H:i:s');
		$this->common_model->update_login_time($data_fromdatabase[0]->id,$data);
				redirect('admin/dashboard','refresh');
	}else{
		$this->session->set_flashdata('message','<span style="color:red">Invalid Username or Password</span>');
		redirect('authenticate');
		redirect('authenticate','refresh');
	}
 }
 function parent_login()
 {
	 $username= $this->input-> post('username');
	 $password = $this->input-> post('password');
	 $user_data = array(
			 'father_email'=> $username,
	 		 'father_password' => $password
 				);
				
	$data_fromdatabase=$this->common_model->do_parent_login('user_map_student_details', $user_data) ;
	//p($data_fromdatabase); exit;
	//echo "<pre>";count($data_fromdatabase);exit();
	//echo count($data_fromdatabase); exit;
	if(count($data_fromdatabase) >0)
	{
		//echo "hello"; exit;
		//$this->common_model->update_logondateTime($username);
		$this->session->set_userdata('sms',$data_fromdatabase);
		$data['last_login_time']=date('Y-m-d H:i:s');
		$this->common_model->update_login_time($data_fromdatabase[0]->id,$data);
				redirect('admin/dashboard','refresh');
	}else{
		$this->session->set_flashdata('message','<span style="color:red">Invalid Email-Id or Password</span>');
		redirect('authenticate');
		redirect('authenticate','refresh');
	}
	
 }
  function dean_login()
 {
	// echo "hello"; exit;
	 $username= $this->input-> post('username');
	 $password = $this->input-> post('password');
	 
	         $user_data = array(
			 'username'=> $username,
	 		 'password' => $password
 			);
				
	$data_fromdatabase = $this->common_model->do_dean_login($user_data) ;
	//p($data_fromdatabase); exit;
	//p($data_fromdatabase); exit;
	//echo "<pre>";count($data_fromdatabase);exit();
	//echo count($data_fromdatabase); exit;
	if(count($data_fromdatabase) >0)
	{
		//echo "hello"; exit;
		//$this->common_model->update_logondateTime($username);
		$this->session->set_userdata('sms',$data_fromdatabase);
		$data['last_login_time']=date('Y-m-d H:i:s');
		$this->common_model->update_login_time($data_fromdatabase[0]->id,$data);
				redirect('admin/dashboard','refresh');
	}else{
		$this->session->set_flashdata('message','<span style="color:red">Invalid Email-Id or Password</span>');
		redirect('authenticate');
		redirect('authenticate','refresh');
	}
	
 }
 function teacher_login()
 {
	 // echo "hello"; exit;
	 $username= $this->input-> post('username');
	 $password = $this->input-> post('password');
	 
	         $user_data = array(
			 'username'=> $username,
	 		 'password' => $password
 			);
				
	$data_fromdatabase = $this->common_model->do_teacher_login($user_data) ;
	//p($data_fromdatabase); exit;
	//p($data_fromdatabase); exit;
	//echo "<pre>";count($data_fromdatabase);exit();
	//echo count($data_fromdatabase); exit;
	if(count($data_fromdatabase) >0)
	{
		//echo "hello"; exit;
		//$this->common_model->update_logondateTime($username);
		$this->session->set_userdata('sms',$data_fromdatabase);
		$data['last_login_time']=date('Y-m-d H:i:s');
		$this->common_model->update_login_time($data_fromdatabase[0]->id,$data);
				redirect('admin/dashboard','refresh');
	}else{
		$this->session->set_flashdata('message','<span style="color:red">Invalid Email-Id or Password</span>');
		redirect('authenticate');
		redirect('authenticate','refresh');
	}
 }
 function student_login()
 {
	 // echo "hello"; exit;
	 $username= $this->input-> post('username');
	 $password = $this->input-> post('password');
	 
	         $user_data = array(
			 'username'=> $username,
	 		 'password' => $password
 			);
				
	$data_fromdatabase = $this->common_model->do_student_login($user_data) ;
	//p($data_fromdatabase); exit;
	//p($data_fromdatabase); exit;
	//echo "<pre>";count($data_fromdatabase);exit();
	//echo count($data_fromdatabase); exit;
	if(count($data_fromdatabase) >0)
	{
		//echo "hello"; exit;
		//$this->common_model->update_logondateTime($username);
		$this->session->set_userdata('sms',$data_fromdatabase);
		$data['last_login_time']=date('Y-m-d H:i:s');
		$this->common_model->update_login_time($data_fromdatabase[0]->id,$data);
				redirect('admin/dashboard','refresh');
	}else{
		$this->session->set_flashdata('message','<span style="color:red">Invalid Email-Id or Password</span>');
		redirect('authenticate');
		redirect('authenticate','refresh');
	} 
 }
 
 function logout()
 {
	 $sessdata= $this->session->userdata('sms');
	 //print_r($sessdata);exit;
	if(count($sessdata)>0)
	{
		$this->common_model->update_log($sessdata[0]->id,'logout');
		$this->session->unset_userdata('sms');
		$this->session->sess_destroy();
		$this->session->set_flashdata('logoutmsg','<span style="color:red">Successfully logged out.</span>');
	}else{
		$this->session->unset_userdata('sms');
		$this->session->sess_destroy();
		$this->session->set_flashdata('logoutmsg','<span style="color:red">"sms" session is not cleared.</span>');
	}
	redirect('authenticate');
 }
 
 function forgotPassword($flag='2')
 {
	 // $username= $this->input-> post('username');
	//  $password = $this->input-> post('password');
	$data['err_flag'] = $flag;
    $this->load->view('admin/forget_password_view',$data); 
	 
 }
 function forgotPasswordByEmail($flag='2')
 {
	 $data['err_flag'] = $flag;
	 $data['page_title'] = 'Forgot Password';
	$this->load->view('admin/forgot_password_email_view',$data); 
 }
 
 function getmobileNumber()
 {
	$mobile_number=$this->input->post('mobile');
	//print_r($mobile_number); exit;
	if(!empty($mobile_number))
	{
			$otp = $this->forgotPassOtp($mobile_number);
			$this->session->set_userdata('otp_session',$otp);
	}
 }
 function sendotpbyusernme(){
	 //print_r($_POST);
	 $username=$this->input->post('username');
	 $email=$this->input->post('email_id');
	 if(isset($_POST['username']))
	{
			$user_detail = $this->type_model->get_user_details($username);
			if(!empty($user_detail[0]['contact_number'])){
				$otp = $this->forgotPassOtp($user_detail[0]['contact_number']);
				$this->session->set_userdata('otp_session',$otp);
				$msg = substr($user_detail[0]['contact_number'],0,2);
				$msg .= "xxxxxxx";
				$msg .=substr($user_detail[0]['contact_number'],-2);
				$this->session->set_userdata('username',$username);
				$this->session->set_flashdata('successmsg','Your OTP has been sent to '.$msg);
				$flag=1;
			}else{
				$this->session->set_flashdata('wrongmsg','Mobile number is blank');
				$flag=2;
			}
	}elseif(isset($_POST['email_id']))
	{
			$this->sendPasswordInEmail();
	}else{
		$this->session->set_flashdata('wrongmsg',"Username doesn't exist. Please enter valid username");
		$flag=3;
	}
		redirect('authenticate/forgotPassword/'.$flag);
	exit;
 }
 function resetPassword(){
	 $username = $this->input->post('username');
	 $newpassword = $this->input->post('newpassword');
	 $confirmpassword = $this->input->post('confirmpassword');
	 if($newpassword == $confirmpassword){
		 $user_detail = $this->type_model->get_user_details($username);
		 if(count($user_detail)>0){
			$send['password']=$newpassword;
            $this->type_model->save_reset_password($username,$send);
			$this->session->set_flashdata('successmsg',"Your password has set successfully");
			redirect('authenticate');
		 }else{
			$data['username'] = $username;
			$this->session->set_flashdata('wrongmsg',"invalid details");
			$this->load->view('admin/reset_password',$data); 
		 }
	 }else{
		$data['username'] = $username;
		$this->session->set_flashdata('wrongmsg',"Password doesn't match with confirm password.");
		$this->load->view('admin/reset_password',$data); 
	 }
 }
 function sendPassword()
 {
	 $username = $this->input->post('username');
	 $enterOtp = $this->input->post('otp_number');
	// print_r($enterOtp); exit;
	
	 $sessionOtp=$this->session->userdata('otp_session');
	//print_r($sessionOtp); exit;
	 if($enterOtp==$sessionOtp)
	 {          
          // echo "hello"; exit;                
				 //$genpass=rand(00000,99999);
				 //$send['password']=$genpass;
                 //$this->type_model->save_reset_password($username,$send);
		 		 //$otp = $this->send_forgot_pass($mobile_number,$genpass);
                 //$this->session->set_flashdata('wrongmsg','password send to your mobile.');
		$data['username'] = $username;
		$this->load->view('admin/reset_password',$data); 
	 }
	 else
	 {
         $this->session->set_flashdata('wrongmsg','Your mobile number is not registered.');
		 redirect('authenticate/forgotPassword');
	 }
	 
 }
 function sendPasswordInEmail()
 {
	 //$mal_data['email_data'] = $this->common_model->selectAll('tblemail');
       // $admin_mail = $mal_data['email_data'][0]->from_email;


         $email=$this->input->post('email_id');
	     $data['otp'] = $otp=rand(000000,999999);
			//p( $data['password']); exit;
		 //$this->type_model->update_password_by_email($forgot,$email);
        @$data['admin_details_by_email_array']=$this->type_model->get_user_data($email);
        
        if(count($data['admin_details_by_email_array'])>0)
        {
			$this->session->set_userdata('otp_session',$otp);
			
				$msg = substr($email,0,3);
				$msg .= "xxxxxxx.";
				$msg .=substr($email,-3);
				$this->session->set_userdata('username',$data['admin_details_by_email_array']->username);
				$this->session->set_flashdata('successmsg','Your OTP has been sent to '.$msg);
				
         @$this->email->set_mailtype("html");
            @$html_email_user = $this->load->view('admin/email/forget_password_templet',$data, true);
          // echo "<pre>";print_r($html_email_user);exit;
            //@$this->email->from('anazimcse@gmail.com','admin');
            $this->load->config('email');
			$this->email->from($this->config->item('from_email'), $this->config->item('from_name'));
		
            @$this->email->to($email);
            @$this->email->subject('Forgot your password for TANUVAS. No worries!');
            @$this->email->message($html_email_user);
            @$result=$this->email->send();

           //echo $this->email->print_debugger();
            $this->session->set_flashdata('message','Your OTP has been sent in your mail.');
            //exit;
			$flag=1;
          redirect('authenticate/forgotPassword/'.$flag);
        }
        else
        {
            @$this->session->set_flashdata('message','Please Enter Your Valid Email');
            redirect('authenticate/forgotPasswordByEmail','refresh');
        }
		
 }
 
 function forgotPassOtp($phone)
 {
	//print_r($type); exit;
	$otp = mt_rand(1000,9999);
	
	if(isset($otp) && isset($phone))
	{
		$urll = "Hi,\n ".$otp." is the One Time Password (OTP) to verify your Account Sign In "; 
		send_sms($urll,$phone);
	}
	
	return $otp; 
}
 function send_forgot_pass($phone,$password)
{
	//print_r($type); exit;
	//$otp = mt_rand(1000,9999);
	
	if(isset($password) && isset($phone))
	{
		$urll = "Hi,\n ".$password." is the your new password.Thank You"; 

		send_sms($urll,$phone);
	}
	
	return $password; 
}
 	
	
	
}

?>