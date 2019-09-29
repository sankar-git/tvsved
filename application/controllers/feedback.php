<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Feedback extends CI_Controller {
	
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
			$this->load->model('Attendance_model');
			
			$this->load->library('excel');
			$sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }
		
	}
	function add($id='')
	{
		    $sessdata= $this->session->userdata('sms');
			
		    if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		    }
		    $data['page_title']="Add FeedBack";
			$data['campuses'] = $this->Discipline_model->get_campus();
			$data['degrees'] = $this->Discipline_model->get_degree();
            $data['semesters'] = $this->Generate_model->get_semester(); 
            $data['batches'] = $this->Discipline_model->get_batches(); 			
            $data['feedbacks'] = $this->Attendance_model->get_feedbacks(); 
			if($id>0)
				$data['feedbacks_result'] = $this->Attendance_model->get_feedbacks_id($id); 			
			$this->load->view('admin/feedback/addfeedback',$data);  
	}
	
	
	function view($id='')
	{
		    $sessdata= $this->session->userdata('sms');
			
		    if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		    }
		    $data['page_title']="Add FeedBack";
			$data['campuses'] = $this->Discipline_model->get_campus();
			$data['degrees'] = $this->Discipline_model->get_degree();
            $data['semesters'] = $this->Generate_model->get_semester(); 
            $data['batches'] = $this->Discipline_model->get_batches(); 			
            $data['feedbacks'] = $this->Attendance_model->get_feedbacks(); 
			if($id>0)
				$data['feedbacks_result'] = $this->Attendance_model->get_feedbacks_id($id); 			
			$this->load->view('admin/feedback/viewfeedback',$data);  
	}
	
	
	function chart($degree_id='',$semester_id='',$batch_id='',$teacher_id='',$question=''){
		 $sessdata= $this->session->userdata('sms');
			
		    if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		    }
			 $data['degree_id']=$degree_id;
			 $data['semester_id']=$semester_id;
			 $data['batch_id']=$batch_id;			 
			 $data['teacher_id']=$teacher_id;
			 $data['question']=$question;
		    $data['page_title']="FeedBack Chart";
			//$data['degrees'] = $this->Discipline_model->get_degree();
           // $data['semesters'] = $this->Generate_model->get_semester(); 
           // $data['batches'] = $this->Discipline_model->get_batches(); 
			$data['teachers'] = $this->Discipline_model->get_teacher();	
			$data['campuses'] = $this->Discipline_model->get_campus();
        $data['batches'] = $this->Discipline_model->get_batches();
//p($data['teachers']);			
            if($degree_id>0 && $semester_id>0 && $batch_id>0  && $teacher_id>0  &&$question>0){
				$result = $this->Attendance_model->feedback_result($degree_id,$semester_id,$batch_id,$teacher_id,$question);
				$data['result'][0][]='Rating';
					$data['result'][0][]='Count';
				foreach($result as $key=>$res){
					
					$data['result'][$key+1][]=$res->rate.' Star';
					$data['result'][$key+1][]=$res->counts;
				}
				
			}
			
			$data['managelist']="1";
			
			$this->load->view('admin/feedback/feedback_chart',$data); 
		
	}
	function getQuestions(){
		$res = $this->Attendance_model->get_questions($_POST['degree_id'],$_POST['semester_id'],$_POST['batch_id']); 
		foreach($res as $val){
			echo "<option value='$val->id'>$val->question</option>";
		}
		
	}
	function results()
	{
	
		    $sessdata= $this->session->userdata('sms');
			
		    if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		    }
		    $data['page_title']="FeedBack Result";
			
			$data['result'] = $this->Attendance_model->feedback_result_list();
			
			$data['managelist']="1";
			
			$this->load->view('admin/feedback/feedback_result',$data);  
	}
	function feedbackStatus($id,$status){
		$id = $this->Attendance_model->changefeedback($id,$status);
		 $this->session->set_flashdata('message', 'Successfully Changed');
		redirect('feedback/add', 'refresh');
	}
	function save(){
		$sessdata= $this->session->userdata('sms');
		$data = $_POST;
		$data['created_by'] = $sessdata[0]->id;
		$id = $this->Attendance_model->save_feedback($data);
		 $this->session->set_flashdata('message', 'Successfully Saved');
		redirect('feedback/add', 'refresh');
	}
}