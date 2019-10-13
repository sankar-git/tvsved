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
	
	
	function export(){
		$sessdata= $this->session->userdata('sms');
		if(empty($sessdata)){
		redirect('authenticate', 'refresh');
		}
		 $data['campus_id']=$campus_id=$this->input->post('campus_id');
		 $data['program_id']=$program_id=$this->input->post('program_id');
		 $data['degree_id']=$degree_id=$this->input->post('degree_id');
		 $data['semester_id']=$semester_id=$this->input->post('semester_id');
		 $data['batch_id']=$batch_id=$this->input->post('batch_id');		 
		 $data['teacher_id']=$teacher_id=$this->input->post('teacher_id');
		if($campus_id>0 && $program_id>0 && $degree_id>0 && $semester_id>0 && $batch_id>0  && $teacher_id>0){
			$result = $this->Attendance_model->feedback_result_list_csv($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$teacher_id);
			 $header = array("Campus","Program","Degree","Semester","Batch","Question","Student","Teacher","Rating","Comments");
             header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"feedback_result".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');
			fputcsv($handle, $header);
            foreach ($result as $data) {
                fputcsv($handle, $data);
            }
                fclose($handle);
            exit;
		}
	}
	function chart(){
		 $sessdata= $this->session->userdata('sms');
			
		    if(empty($sessdata)){
			redirect('authenticate', 'refresh');
		    }
			if(isset($_POST['export_csv'])){
				$this->export();exit;
			}
			 $data['campus_id']=$campus_id=$this->input->post('campus_id');
			 $data['program_id']=$program_id=$this->input->post('program_id');
			 $data['degree_id']=$degree_id=$this->input->post('degree_id');
			 $data['semester_id']=$semester_id=$this->input->post('semester_id');
			 $data['batch_id']=$batch_id=$this->input->post('batch_id');		 
			 $data['teacher_id']=$teacher_id=$this->input->post('teacher_id');
			// $data['question']=$question;
		    $data['page_title']="FeedBack Chart";
			//$data['degrees'] = $this->Discipline_model->get_degree();
           // $data['semesters'] = $this->Generate_model->get_semester(); 
           // $data['batches'] = $this->Discipline_model->get_batches(); 
			$data['teachers'] = $this->Discipline_model->get_teacher();	
			$data['campuses'] = $this->Discipline_model->get_campus();
        $data['batches'] = $this->Discipline_model->get_batches();
//p($data['teachers']);			
            if($campus_id>0 && $program_id>0 && $degree_id>0 && $semester_id>0 && $batch_id>0  && $teacher_id>0){
				$result = $this->Attendance_model->feedback_result($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$teacher_id);
				$question = $this->Attendance_model->get_feedbacks();
				$result_bar = $this->Attendance_model->feedback_result_bar($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$teacher_id);
				$data['result'][0][]='Rating';
					$data['result'][0][]='Count';
				foreach($result as $key=>$res){
					$data['result'][$key+1][]=$res->rate.' Star';
					$data['result'][$key+1][]=$res->counts;
				}
				$data['bar_result'][0]=['Student'];
				foreach($question as $key=>$res){
					$data['bar_result'][0][]=$res['question'];
				}
				$data['bar_result'][1]=[@$result_bar[0]->teacher];
				$last_name='';
				foreach($result_bar as $key=>$res){
					$data['bar_result'][1][]=$res->average;
				}
				//echo "<pre>";print_r($data['bar_result']);exit;
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
			if(isset($_POST['export_csv'])){
				$this->export();exit;
			}
			$data['campus_id']=$campus_id=$this->input->post('campus_id');
			 $data['program_id']=$program_id=$this->input->post('program_id');
			 $data['degree_id']=$degree_id=$this->input->post('degree_id');
			 $data['semester_id']=$semester_id=$this->input->post('semester_id');
			 $data['batch_id']=$batch_id=$this->input->post('batch_id');		 
			 $data['teacher_id']=$teacher_id=$this->input->post('teacher_id');
		    $data['page_title']="FeedBack Result";
			$data['campuses'] = $this->Discipline_model->get_campus();
			$data['batches'] = $this->Discipline_model->get_batches();
			$data['result'] =array();
			if($campus_id>0)
				$data['result'] = $this->Attendance_model->feedback_result_list($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$teacher_id);
			
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