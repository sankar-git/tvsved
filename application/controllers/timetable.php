<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Timetable extends CI_Controller {
	
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
		 $this->load->model('generate_model');
		 $this->load->model('Master_model');
		 $this->load->model('Timetable_model');

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
				if($this->user_role!=0)
				{
					$this->load->library('permission_lib');
					$this->permission_lib->permit($this->user_id,$this->user_role);
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
	function allocateInvigilator()
	{
		$data['page_title']="Allocate Invigilator";
		$session_data = $this->session->userdata('sms');
		$data['role_id']=$session_data[0]->role_id;
		$data['campus_id'] = $this->input->post('campus_id');
		$data['program_id'] = $this->input->post('program_id');
		$data['degree_id'] = $this->input->post('degree_id');
		$data['semester_id'] = $this->input->post('semester_id');
		$data['batch_id'] = $this->input->post('batch_id');
		$data['campuses'] = $this->Discipline_model->get_campus();
		if($data['role_id'] == 2)
			$data['time_table']=$this->Timetable_model->allocateInvigilator($session_data[0]->id);
		else{
			if($data['campus_id']>0)
				$data['time_table']=$this->Timetable_model->allocateInvigilator('',$data['campus_id'],$data['program_id'],$data['degree_id'],$data['semester_id'],$data['batch_id']);
		}
		
		//print_r($data['time_table']); exit;
		$this->load->view('admin/allocate_invigilator',$data);
	}
	function viewTimeTable()
	{
		$data['page_title']="Exam Time Table";
		$session_data = $this->session->userdata('sms');
		$data['role_id']=$session_data[0]->role_id;
		$data['campus_id'] = $this->input->post('campus_id');
		$data['program_id'] = $this->input->post('program_id');
		$data['degree_id'] = $this->input->post('degree_id');
		$data['semester_id'] = $this->input->post('semester_id');
		$data['batch_id'] = $this->input->post('batch_id');
		$data['campuses'] = $this->Discipline_model->get_campus();

		
		if($this->input->post('view_time_table') == 'export_time_table'){
			$this->exportTimeTable();exit;
		}
		if($data['role_id'] == 2)
			$data['time_table']=$this->Timetable_model->viewTimeTable($session_data[0]->id);
		elseif($data['role_id'] == 1){
            $student_data = $this->generate_model->get_student_last_course_details($session_data[0]->id);//echo $this->db->last_query();exit;
			if(count($student_data)>0)
				$data['time_table']=$this->Timetable_model->viewTimeTable('',$student_data[0]['campus_id'],$student_data[0]['program_id'],$student_data[0]['degree_id'],$student_data[0]['semester_id'],$student_data[0]['batch_id'],$student_data[0]['exam_type']);
		}else{
            $data['time_table']=$this->Timetable_model->viewTimeTable('',$data['campus_id'],$data['program_id'],$data['degree_id'],$data['semester_id'],$data['batch_id']);
        }
		//echo $this->db->last_query();exit;
		//print_r($data['time_table']); exit;
		$this->load->view('admin/time_table_list_view',$data);
	}
	function exportTimeTable(){
		$this->load->model('Result_model');
		$data['campus_id'] = $this->input->post('campus_id');
		$data['program_id'] = $this->input->post('program_id');
		$data['degree_id'] = $this->input->post('degree_id');
		$data['semester_id'] = $this->input->post('semester_id');
		$data['batch_id'] = $this->input->post('batch_id');
		$semesterRow = $this->Result_model->get_semester_name($data['semester_id']); 
		 $data['semester_name']  =$semesterRow->semester_name;
		
		$data['time_table']=$time_table = $this->Timetable_model->viewTimeTable('',$data['campus_id'],$data['program_id'],$data['degree_id'],$data['semester_id'],$data['batch_id']);
		 $data['batch_name']  =$time_table[0]->batch_name;
		 $data['campus_name']  =$time_table[0]->campus_name;
		  $data['campus_code']  =$time_table[0]->campus_code;
		 $data['degree_name']  =$time_table[0]->degree_name;
		 $data['degree_code']  =$time_table[0]->degree_code;
		
		//load the view and saved it into $html variable
		$html=$this->load->view('admin/pdf/time_table_view', $data, true);
		// print_r($html); exit;
		//this the the PDF filename that user will get to download
		$pdfFilePath = "time_table.pdf";
 
		//load mPDF library
		$this->load->library('m_pdf');
		$this->m_pdf->pdf->SetTitle('Time Table');
	   //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
	
		exit;			

	}
	function addTimeTable()
	{
		$data['page_title']="Add Time Table";
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['degrees'] = $this->Discipline_model->get_degree();
		$data['campuses'] = $this->Discipline_model->get_campus();
		$data['courses'] = $this->Discipline_model->get_course();
		$data['teachers'] = $this->Discipline_model->get_teacher();
		//print_r($data['teachers']); exit;
		$this->load->view('admin/time_table_add_view',$data);
	}
    function saveTimeTable()
	{
		$register_date_time=date('Y-m-d H:i:s');
		$exam_date_id = $this->input->post('exam_date_id');
		$time_slot = $this->input->post('time_slot');
		$campus_id = $this->input->post('campus_id');
		$course_id = $this->input->post('course_id');
		$discipline_id = $this->input->post('discipline_id');
		$teacher_id = $this->input->post('teacher_id');
		$room_id = $this->input->post('room_id');
		
		$save['exam_date_id']=$exam_date_id;
		$save['slots']=$time_slot;
		$save['campus_id']=$campus_id;
		$save['course_id']=$course_id;
		$save['discipline_id']=$discipline_id;
		$save['teacher_id']=$teacher_id;
		$save['room_id']=$room_id;
		$save['created_on']=   $register_date_time;
		
		$data= $this->Timetable_model->save_time_table($save);
		$this->session->set_flashdata('message', 'Time Table added successfully');
	    redirect('timetable/allocateInvigilator');
	}
	function editTimeTable($id)
	{
		//echo $id; exit;
		$data['page_title']="Allocate Invigilator";
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['degrees'] = $this->Discipline_model->get_degree();
		$data['campuses'] = $this->Discipline_model->get_campus();
		$data['courses'] = $this->Discipline_model->get_course();
		$data['teachers'] = $this->Discipline_model->get_teacher();
		$data['slot_list']=$this->Master_model->slot_list();
		$data['room_list']=$this->Master_model->class_room_list();
		$data['time_table_row'] = $this->Timetable_model->get_time_table_by_id($id);
		//print_r($data['time_table_row']); exit;
		$this->load->view('admin/time_table_edit_view',$data);
	}
	function updateTimeTable($id)
	{
		$register_date_time=date('Y-m-d H:i:s');
		$exam_date_id = $this->input->post('exam_date_id');
		$ttid = $this->input->post('ttid');
		$time_slot = $this->input->post('time_slot');
		//$campus_id = $this->input->post('campus_id');
		$course_id = $this->input->post('course_id');
		$discipline_id = $this->input->post('discipline_id');
		$teacher_id = implode(",",$this->input->post('teacher_id'));
		$hall_superindent = implode(",",$this->input->post('hall_superindent'));
		$room_id = $this->input->post('room_id');
		//p($_POST);exit;
		$save['exam_date_id']=$exam_date_id;
		$save['slots']=$time_slot;
		//$save['campus_id']=$campus_id;
		//$save['course_id']=$course_id;
		//$save['discipline_id']=$discipline_id;
		$save['teacher_id']=$teacher_id;
		$save['hall_superindent']=$hall_superindent;
		$save['room_id']=$room_id;
		$save['created_on']=   $register_date_time;
		if($ttid>0){
			$data= $this->Timetable_model->update_time_table($ttid,$save);
		}else{
			$data= $this->Timetable_model->save_time_table($save);
		}
		$this->session->set_flashdata('message', 'Time Table updated successfully');
	    redirect('timetable/allocateInvigilator');
	}
	
	function detailTimeTable($id)
	{
		//echo $id; exit;
		$data['page_title']="View Time Table";
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['degrees'] = $this->Discipline_model->get_degree();
		$data['campuses'] = $this->Discipline_model->get_campus();
		$data['courses'] = $this->Discipline_model->get_course();
		$data['teachers'] = $this->Discipline_model->get_teacher();
		$data['time_table_row'] = $this->Timetable_model->get_time_table_by_id($id);
		//print_r($data['time_table_row']); exit;
		$this->load->view('admin/time_table_detail_view',$data);
	}
	function deleteTimeTable($id)
	{
		if($id)
		 {
			$this->Timetable_model->delete_time_table($id); 
		 }
		 $this->session->set_flashdata('message', 'Time-table deleted successfully');
	     redirect('timetable/viewTimeTable'); 
	}
	function statusTimetable($id,$status)
	{
		 $this->Timetable_model->status_time_table($id,$status); 
		 $this->session->set_flashdata('message', 'Time-Table status successfully changed');
	      redirect('timetable/viewTimeTable');
	}
	
    function getTeacherByCampusAndDiscipline()
	{
	  	$campus_id=$this->input->post('campus_id');
	  	$discipline_id=$this->input->post('discipline_id');
		$data=$this->Timetable_model->get_teacher_by_campus_and_discipline($campus_id,$discipline_id);
		echo json_encode($data);
		
	}
	
	
	
}
?>