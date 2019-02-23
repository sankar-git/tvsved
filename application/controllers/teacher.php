<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Discipline extends CI_Controller {
	
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
		 
		 
		 $this->load->model('Discipline_model');

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
    function addTeacher()
	{
		$data['page_title']="Add Teacher";
		$this->load->view('admin/discipline_add_view',$data);
	}
    function saveDiscipline()
	{   
		$register_date_time=date('Y-m-d H:i:s');
		$discipline_code = $this->input->post('discipline_code');
		$discipline_name = $this->input->post('discipline_name');
		$save['discipline_code']=$discipline_code;
		$save['discipline_name']=$discipline_name;
		$save['created_on']=     $register_date_time;
		
		$data= $this->Discipline_model->save_discipline($save);
		$this->session->set_flashdata('message', 'Discipline added successfully');
	    redirect('discipline/viewDiscipline');
		
		
	}
	function viewDiscipline()
	{
		$data['page_title']="Discipline List";
		$data['discipline_list']=$this->Discipline_model->discipline_list();
		$this->load->view('admin/discipline_list_view',$data);
	}
	function editDiscipline($id)
	{
	    $data['page_title']="Update Discipline";
		$data['discipline_row']=$this->Discipline_model->get_discipline_by_id($id);
		$this->load->view('admin/discipline_edit_view',$data);
	}
	function updateDiscipline($id)
	{ 
	  $discipline_code=$this->input->post('discipline_code');
	  $discipline_name=$this->input->post('discipline_name');
	  $save['discipline_code']=$discipline_code;
	  $save['discipline_name']=$discipline_name;
	  $this->Discipline_model->update_discipline($id,$save);
	    $this->session->set_flashdata('message', 'Discipline updated successfully');
	    redirect('discipline/viewDiscipline');
	}
	function deleteDiscipline($id)
	{    
	     if($id)
		 {
			$this->Discipline_model->delete_discipline($id); 
		 }
		 $this->session->set_flashdata('message', 'Discipline deleted successfully');
	     redirect('discipline/viewDiscipline'); 
	}
	function disciplineStatus($id,$dststus)
	{     
	    $status = $dststus;
         $this->Discipline_model->status_discipline($id,$status); 
		 $this->session->set_flashdata('message', 'Discipline status updated successfully');
	     redirect('discipline/viewDiscipline'); 
	}
	function addCourse()
	{   
		$data['page_title']="Add Course";
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		//print_r($data['discipline']); exit;
		$this->load->view('admin/course_add_view',$data);
	}
	function saveCourse()
	{
		$register_date_time=date('Y-m-d H:i:s');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$discipline_id = $this->input->post('discipline_id');
		$course_group_id = $this->input->post('course_group_id');
		$syllabus_year = $this->input->post('syllabus_year');
		$semester_id = $this->input->post('semester_id');
		$course_code = $this->input->post('course_code');
		$course_title = $this->input->post('course_title');
		$theory_credit = $this->input->post('theory_credit');
		$practicle_credit = $this->input->post('practicle_credit');
		
		$save['program_id']=$program_id;
		$save['degree_id']=$degree_id;
		
		$save['discipline_id']=$discipline_id;
		$save['course_group_id']=$course_group_id;
		$save['syllabus_id']=$syllabus_year;
		$save['semester_id']=$semester_id;
		$save['course_code']=$course_code;
		$save['course_title']=$course_title;
		$save['theory_credit']=$theory_credit;
		$save['practicle_credit']=$practicle_credit;
		$save['created_on']=     $register_date_time;
		
		$data= $this->Discipline_model->save_course($save);
		$this->session->set_flashdata('message', 'Course added successfully');
	    redirect('discipline/viewCourse');
		
	}
	function viewCourse()
	{
		$data['page_title']="Course List";
		$data['course_list']=$this->Discipline_model->course_list();
		//echo "<pre>";
		//print_r($data['course_list']);
		//echo "</pre>"; exit;
		$this->load->view('admin/course_list_view',$data);
	}
	function deleteCourse($id)
	{
		 if($id)
		 {
			$this->Discipline_model->delete_course($id); 
		 }
		 $this->session->set_flashdata('message', 'Discipline deleted successfully');
	     redirect('discipline/viewDiscipline'); 
	}
	function courseStatus($id,$status)
	{
		 $this->Discipline_model->status_course($id,$status); 
		 $this->session->set_flashdata('message', 'Course status updated successfully');
	     redirect('discipline/viewCourse'); 
	}
}
?>