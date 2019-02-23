<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reactivate extends CI_Controller {
	
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
			$this->load->model('Generate_model');
			$this->load->library('excel');
			$sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }
		
	}
	function viewProcess(){
		    $data['page_title']="Process Details";
			$this->load->view('admin/profile/student_page_view',$data);  
		
	}
	function updateAttendance()
	{
		    $data['page_title']="Re-Activate Attendance";
			$this->load->view('admin/profile/student_page_view',$data); 
	}
	

}
?>