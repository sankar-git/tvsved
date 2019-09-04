<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Batch extends CI_Controller {
	
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
		  $this->load->model('Master_model');
		  $sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }

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
	function listBatch()
	{
		$data['page_title']="Batch List";
		$data['batch_list']=$this->Discipline_model->batch_list();
		//print_r($data['batch_list']); exit;
		$this->load->view('admin/batch_list_view',$data);
	}
	function listSection()
	{
		$data['page_title']="Section List";
		$data['section_list']=$this->Discipline_model->section_list();
		//print_r($data['batch_list']); exit;
		$this->load->view('admin/section_list_view',$data);
	}
    function addBatch()
	{
		$data['page_title']="Add Batch";
		$data['syllabus'] = $this->Discipline_model->get_syllabus_year(); 
		$this->load->view('admin/batch_add_view',$data);
	}
	function addSection()
	{
		$data['page_title']="Add Section";
		$this->load->view('admin/section_add_view',$data);
	}
    function saveSection()
    {
        $save['section_code']=$this->input->post('section_code');
        $save['section_name']=$this->input->post('section_name');
        $data= $this->Master_model->save_section($save);
        if(!empty($data))
        {
            $this->session->set_flashdata('message', 'Section added successfully');
        }
        else
        {
            $this->session->set_flashdata('message', 'Section not added');
        }
        redirect('batch/listSection');

    }
	function saveBatch()
	{
		
		$syllabus_year_id = $this->input->post('syllabus_year_id');
		$batch_start_year = $this->input->post('batch_start_year');
		$batch_name = $this->input->post('batch_name');
		$save['syllabus_id']=$syllabus_year_id;
		$save['batch_start_year']= $batch_start_year;
		$save['batch_name']= $batch_name;
		
		$data= $this->Master_model->save_batches($save);
		if(!empty($data))
		{
			$this->session->set_flashdata('message', 'Batch added successfully');
		}
		else
		{
			$this->session->set_flashdata('message', 'Batch not added');
		}
	    redirect('batch/listBatch');
		
	}
    function editSection($id)
    {
        $data['page_title']="Update Section";
        $data['section_row'] = $this->Discipline_model->get_section_by_id($id);
        $data['section_id'] = $id;
        //p($data['batch_row']); exit;
        $this->load->view('admin/section_add_view',$data);
    }
    function updateSection($id)
    {
        $save['section_code']=$this->input->post('section_code');
        $save['section_name']=$this->input->post('section_name');
        $data= $this->Master_model->update_section($id,$save);
        $this->session->set_flashdata('message', 'Section updated successfully');
        redirect('batch/listSection');
    }
	function editBatch($id)
	{
		$data['page_title']="Update Batch";
		$data['syllabus'] = $this->Discipline_model->get_syllabus_year();
		$data['batch_row'] = $this->Discipline_model->get_batch_by_id($id); 
		//p($data['batch_row']); exit;
		$this->load->view('admin/batch_edit_view',$data);
	}
	
	function updateBatch($id)
	{
		//echo $id; exit;
		$syllabus_year_id = $this->input->post('syllabus_year_id');
		$batch_start_year = $this->input->post('batch_start_year');
		$batch_name = $this->input->post('batch_name');
		
		$save['syllabus_id']=$syllabus_year_id;
		$save['batch_start_year']= $batch_start_year;
		$save['batch_name']= $batch_name;
		//p($save); exit;
		$data= $this->Master_model->update_batch($id,$save);
		$this->session->set_flashdata('message', 'Batch Updated Successfully');
	    redirect('batch/listBatch');
	}
    function sectionStatus($id,$dststus)
    {
        $status = $dststus;
        $this->Master_model->section_status($id,$status);
        $this->session->set_flashdata('message', 'Section status updated successfully');
        redirect('batch/listSection');
    }
	function batchStatus($id,$dststus)
	{
		 $status = $dststus;
         $this->Master_model->batch_status($id,$status); 
		 $this->session->set_flashdata('message', 'Batch status updated successfully');
	     redirect('batch/listBatch');
	}
	
}
?>