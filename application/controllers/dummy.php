<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dummy extends CI_Controller {
	
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
			$this->load->model('Generate_model');
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
					 $permit=$this->permission_lib->permit($this->user_id,$this->user_role);
					 
				}
				
			}
			else
			{
				redirect('authenticate', 'refresh');
			}*/
	}
	
	public function index()
	{
		
		echo "hello"; exit;
	}
	
	function generateDummy()
	{    
	     $data['page_title']="Generate Dummy Number";
		 $data['batches'] =  $this->Discipline_model->get_batch(); 
		 $data['campuses'] = $this->Discipline_model->get_campus();
		 $data['degrees'] =  $this->Discipline_model->get_degree();
		 if(!empty($this->input->post('dummy_number_generate')))
		 {
			$register_date_time=date('Y-m-d H:i:s');
			$campus_id=$this->input->post('campus_id'); 
			$program_id=$this->input->post('program_id'); 
			$semester_id=$this->input->post('semester_id'); 
			$batch_id=$this->input->post('batch_id'); 
			$degree_id=$this->input->post('degree_id'); 
			$range_from=$this->input->post('range_from'); 
			$range_to=$this->input->post('range_to'); 
			$month_name=$this->input->post('month_name'); 
			$exam_type=$this->input->post('exam_type'); 
			//get student list by college,batch and degree
			$data['students'] =  $this->Generate_model->get_students_for_dummy($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$exam_type);
			//p($data['students']); exit;
			$alreadyList=array();
			foreach($data['students'] as $students){
				    $checkdata=$this->checking_dummy_number($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$exam_type,$students->id);
					//print_r($checkdata); exit;
					if($checkdata==1)
					{
						//echo "hello"; exit;
					}
					else
					{
					  //echo "hell000o"; exit;
					$gen_rand=rand($range_from,$range_to);
				    $save['student_id'] =  $students->id;   
				    $save['exam_month'] =  $month_name;   
				    $save['college_id'] =  $campus_id;   
				    $save['batch_id'] =    $batch_id;   
				    $save['program_id'] =    $program_id;   
				    $save['semester_id'] =    $semester_id;
				    $save['exam_type'] =    $exam_type;   
				    $save['degree_id'] =   $degree_id;   
				    $save['dummy_value'] = $gen_rand;
				    $save['created_on'] =  $register_date_time;
					//print_r($save); 
					
					$this->Generate_model->save_dummy_number_for_students($save);
					}
			} //exit;
			$this->session->set_flashdata('message', 'Dummy number generated successfully.');
			redirect('dummy/generateDummy');	
		 }
         $this->load->view('admin/dummy_number_view',$data);
	}
	function checking_dummy_number($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$exam_type,$student_id)
	{
		$RowVal=$this->Generate_model->check_already_inserted_dummy_row($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$exam_type,$student_id);
		return $RowVal;
	}
	function addExamDate()
	{    
	     $data['page_title']="Add Exam Month";
		 $this->load->view('admin/exam_date_time_view',$data);
	}



}
?>