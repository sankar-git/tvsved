<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transcript extends CI_Controller {
	
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
			$this->load->model('common_model');
			$this->load->model('user_model');
			$this->load->model('type_model');
			$this->load->model('Master_model');
			$this->load->model('Marks_model');
			$this->load->model('Discipline_model');
			$this->load->model('Generate_model');
			$this->load->model('Result_model');
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
					 $permit=$this->permission_lib->permit_new($this->user_id,$this->user_role);
					// p($permit); exit;
				}
				
			}
			else
			{
				redirect('authenticate', 'refresh');
			}*/
	}
	//======================================UG Marks Upload==================================================//
	
	function generateTranscript()
	{
		
		 //*************************Generate student Transcript*********************************//
		 if(!empty($this->input->post('transcript_result')))
		 {  
	        
            //echo "hello"; exit;
            $campus_id=$this->input->post('campus_id');
            $program_id=$this->input->post('program_id');
            $degree_id=$this->input->post('degree_id');
            //$semester_id=$this->input->post('semester_id');
            $batch_id=$this->input->post('batch_id');
            $student_id=$this->input->post('student_id'); //single input
            $month=$data['month'] =$this->input->post('month');
            $year=$data['year'] =$this->input->post('year');
            if($degree_id == 1) {
                $data['aggregate_marks']['semester_1'] = $this->Result_model->get_student_results($campus_id, $program_id, $batch_id, $degree_id, 1, $student_id, $month, $year);
                $data['aggregate_marks']['semester_2'] = $this->Result_model->get_student_results($campus_id, $program_id, $batch_id, $degree_id, 4, $student_id, $month, $year);
                $data['aggregate_marks']['semester_3'] = $this->Result_model->get_student_results($campus_id, $program_id, $batch_id, $degree_id, 5, $student_id, $month, $year);
                $data['aggregate_marks']['semester_4'] = $this->Result_model->get_student_results($campus_id, $program_id, $batch_id, $degree_id, 6, $student_id, $month, $year);
            }
            //p($data);exit;
            //$data['total_gradeval']=$datas['total_gradeval'];
            //$data['total_count']=$datas['total_count'];
			//load the view and saved it into $html variable
             $html = $this->load->view('admin/report/student_bvsc_result_transcript', $data, true);
            //if($program_id == 1) {
              //   $html = $this->load->view('admin/report/student_bvsc_result_transcript', $data, true);
             //}else{
               //  $html = $this->load->view('admin/report/student_pg_result_transcript', $data, true);
             //}
			//$html=$this->load->view('admin/report/student_btech_result_transcript', $data, true);
			// print_r($html); exit;
			//this the the PDF filename that user will get to download
			$pdfFilePath = "aggregate_marks.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->setTitle('Transcript Report');
			//$this->m_pdf->pdf->mPDF('utf-8','A4','','','5','5','5','5');
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
		  }	//end degrree condition
		  

		 //*************************Generate student Transcript End*********************************//
		
		
		$data['page_title']="Generate Student Transcript Result";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['batches'] = $this->Discipline_model->get_batches(); 
		$data['semesters'] = $this->Discipline_model->get_semester(); 
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		$this->load->view('admin/generate_student_transcript_result_view',$data);
		
	}
	
	//ajax function 
	function getProgramByCampus()
	{
		$campus_id = $this->input->post('campus_id');
		$data['programs']=$this->Marks_model->get_program_by_campus($campus_id); 
		//print_r($data['programs']); exit;
		$str = '';
         foreach($data['programs'] as $k=>$v){ 
           $str .= "<option value=".$v->id.">".$v->program_name."</option>";
           }
		   echo $str;
	}
	function getCourseByIds()
	{
		//print_r($_POST); exit;
		$campus_id = $this->input->post('campus_id');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$batch_id = $this->input->post('batch_id');
		$semester_id = $this->input->post('semester_id');
		$discipline_id = $this->input->post('discipline_id');
		
		$data['courses']=$this->Marks_model->get_course_by_ids($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id); 
		//print_r($data['programs']); exit;
		$str = '';
         foreach($data['courses'] as $k=>$v){ 
           $str .= "<option value=".$v->id.'-'.$v->course_group_id.">".$v->course_code.'-'.$v->course_title."</option>";
           }
		   echo $str;
	}
	
	function getCourseByIdss()
	{
		//print_r($_POST); exit;
		$campus_id = $this->input->post('campus_idd');
		$program_id = $this->input->post('program_idd');
		$degree_id = $this->input->post('degree_idd');
		$batch_id = $this->input->post('batch_idd');
		$semester_id = $this->input->post('semester_idd');
		$discipline_id = $this->input->post('discipline_idd');
		
		$data['courses']=$this->Marks_model->get_course_by_ids($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id); 
		//print_r($data['programs']); exit;
		$str = '';
         foreach($data['courses'] as $k=>$v){ 
           $str .= "<option value=".$v->id.">".$v->course_code.'-'.$v->course_title."</option>";
           }
		   echo $str;
	}
	
	  function getStudentList()
	  {
		$campus_id = $this->input->post('campus_id');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$batch_id = $this->input->post('batch_id');
		$semester_id = $this->input->post('semester_id');
		$data['students']=$this->Marks_model->get_ug_students_by_ids($campus_id,$program_id,$degree_id,$batch_id); 
		//print_r($data['students']); exit;
		$str = '';
        foreach($data['students'] as $k=>$v){ 
			$last_name='';
			if(trim($v->last_name)!='')
				$last_name = ' '.$v->last_name;
           $str .= "<option value=".$v->id.">".$v->first_name.$last_name.' ('.$v->user_unique_id.')'."</option>";
        }
		   echo $str;
	  }
	  
	  
	  
    //----------End Download Excel File ---------------------//
	
	

}
?>