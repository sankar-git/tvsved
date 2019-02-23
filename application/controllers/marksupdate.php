<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Marksupdate extends CI_Controller {
	
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
			$this->load->model('user_model');
			$this->load->model('type_model');
			$this->load->model('Master_model');
			$this->load->model('Marks_model');
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
	function updateStudentMarks()
	{    $data['page_title']="Student Marks Lists";
	     $data['marks_list']=$this->Marks_model->get_student_ug_marks();
		// p($data['marks_list']); exit;
		 $this->load->view('admin/list_student_ug_marks',$data);
	}
	function editStudentMarks($id)
	{
		$data['page_title']="Update Student Marks";
		$data['user_marks_row']=$this->Marks_model->get_student_ug_marks_by_id($id);
		//p($data['user_marks_row']); exit;
		$this->load->view('admin/edit_student_ug_marks',$data);
	}
	function saveStudentMarks($id)
	{
		$internal_theory = $this->input->post('internal_theory');
		$internal_practical = $this->input->post('internal_practical');
		$external_theory = $this->input->post('external_theory');
		$external_practical = $this->input->post('external_practical');
		
		
		$save['id']=$id;
		$save['theory_internal']=$internal_theory;
		$save['practical_internal']=$internal_practical;
		$save['theory_external']=$external_theory;
		$save['practical_external']=$external_practical;
	    //p($save); exit;
		$save_status = $this->Marks_model->update_student_marks_by_id($save);
		//p($save_status); exit;
		if($save_status==1)
		{
		    $this->session->set_flashdata('message', 'User marks updated successfully');
			redirect('marksupdate/updateStudentMarks');
		}
		else
		{
		    $this->session->set_flashdata('message', 'User marks not updated successfully');
			redirect('marksupdate/updateStudentMarks');
		}
		
	}
	
	

	
	

}
?>