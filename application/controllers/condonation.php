<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Condonation extends CI_Controller {
	
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
			$this->load->model('Gradechart_model');
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
	function deflicit_mark()
	{
	  
	   $data['page_title']="Deflicit Mark List";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['batches'] = $this->Discipline_model->get_batches(); 
		$this->load->view('admin/deflicit/deflicit_mark',$data);
	}
	function deflicit_approval(){
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['batches'] = $this->Discipline_model->get_batches(); 
		 $data['page_title']="Deflicit Approval";
		$campus_id=$this->input->post('campus_id');
	   $program_id=$this->input->post('program_id');
	   $degree_id=$data['degree_id']=$this->input->post('degree_id');
	   $batch_id=$this->input->post('batch_id');
	   $semester_id=$this->input->post('semester_id');
	   $discipline_id=$this->input->post('discipline_id');

	   $course_input=$this->input->post('course_id');
           $course_id=$course_input;
	  
		   $courseArr = explode("-",$course_input);
		   $courseArr = explode("|",$courseArr[0]);
		  $data['course_count'] =  count($courseArr);
		 $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_deflicit_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id);
		 //if($degree_id=='1'){
			$this->load->view('admin/deflicit/deflicit_approval',$data);
		 //}
	}
	function save_deflicit(){
		 $campus_id=$this->input->post('campus_id');
	   $program_id=$this->input->post('program_id');
	   $degree_id=$this->input->post('degree_id');
	   $batch_id=$this->input->post('batch_id');
	   $semester_id=$this->input->post('semester_id');
	   $discipline_id=$this->input->post('discipline_id');

	   $course_input=$this->input->post('course_id');
	   $deflicit_range=$this->input->post('deflicit_range');
	   $thoery=$this->input->post('thoery');
	   $practical=$this->input->post('practical');
	   
	  $msg=0;
		foreach($thoery as $student_id=>$mark){
			//$this->db->where(array('student_id'=>$student_id,'course_id'=>$course_input));
			//$this->db->delete('students_ug_deflicit_marks');
			if(trim($mark)<=trim($deflicit_range) && $practical[$student_id] == ''){
				$result = $this->db->select('theory_external1,theory_external2')->from('students_ug_marks')->where(array('student_id'=>$student_id,'batch_id'=>$batch_id,'course_id'=>$course_input,'semester_id'=>$semester_id,'degree_id'=>$degree_id,'program_id'=>$program_id,'campus_id'=>$campus_id))->get()->result_array();
				//p($result);
				//if(count($result) == 0){
					
					$this->db->query("INSERT INTO students_ug_deflicit_marks (campus_id,program_id,degree_id,batch_id,semester_id,discipline_id,student_id,course_id,highest_marks,second_highest_marks,smallest_marks,date_of_start,theory_internal1,theory_internal2,theory_internal3,theory_internal,theory_paper1,theory_paper2,theory_paper3,theory_paper4,sum_internal_practical,practical_internal,theory_external1,theory_external2,theory_external3,theory_external4,practical_external,external_sum,marks_sum,ncc_status) SELECT campus_id,program_id,degree_id,batch_id,semester_id,discipline_id,student_id,course_id,highest_marks,second_highest_marks,smallest_marks,date_of_start,theory_internal1,theory_internal2,theory_internal3,theory_internal,theory_paper1,theory_paper2,theory_paper3,theory_paper4,sum_internal_practical,practical_internal,theory_external1,theory_external2,theory_external3,theory_external4,practical_external,external_sum,marks_sum,ncc_status FROM students_ug_marks WHERE student_id = '$student_id' AND program_id = '$program_id' AND campus_id = '$campus_id' AND batch_id = '$batch_id' AND semester_id = '$semester_id' AND degree_id = '$degree_id' AND course_id = '$course_input'");
					$insert_id = $this->db->insert_id(); 
				//}
				$this->db->where(array('student_id'=>$student_id,'batch_id'=>$batch_id,'course_id'=>$course_input,'semester_id'=>$semester_id,'degree_id'=>$degree_id,'program_id'=>$program_id,'campus_id'=>$campus_id));
				$data1['deflicit_mark'] = $mark;
				$data1['deflicit_range'] = $deflicit_range;
				$deflicit_mark = $mark*5;
				$this->db->update('students_ug_deflicit_marks',$data1);
				if($result[0]['theory_external1'] < $result[0]['theory_external2']){
					$data['theory_external1'] = $result[0]['theory_external1']+$deflicit_mark;
				}elseif($result[0]['theory_external1'] = $result[0]['theory_external1']){
					$divide_two = $deflicit_mark/2;
					$data['theory_external1'] = $result[0]['theory_external1']+$divide_two;
					$data['theory_external2'] = $result[0]['theory_external2']+$divide_two;
				}else{
					$data['theory_external2'] = $result[0]['theory_external2']+$deflicit_mark;
				}
				//p($data);exit;
				$this->db->where(array('student_id'=>$student_id,'course_id'=>$course_input,'semester_id'=>$semester_id,'degree_id'=>$degree_id,'batch_id'=>$batch_id,'program_id'=>$program_id,'campus_id'=>$campus_id));
				$this->db->update('students_ug_marks',$data);
				$msg=1;
			}
			
		} 
		echo $msg;
	}
	function show_approval_deflicit(){
		
		if(!empty($this->input->post('failed_list')))
		  { 
	   $campus_id=$this->input->post('campus_id');
	   $program_id=$this->input->post('program_id');
	   $degree_id=$data['degree_id']=$this->input->post('degree_id');
	   $batch_id=$this->input->post('batch_id');
	   $semester_id=$this->input->post('semester_id');
	   $discipline_id=$this->input->post('discipline_id');

	   $course_input=$this->input->post('course_id');
           $course_id=$course_input;
		  // p($_POST); exit;
	       //$course_id=$courseid[0]; 
	       //$course_credit=$courseid[1]; 	  
		   $courseArr = explode("-",$course_input);
		   $courseArr = explode("|",$courseArr[0]);
		  $data['course_count'] =  count($courseArr);
	      if($degree_id=='1'){
			  
		   $data['numeralCodes'] =  array("I","II","III","IV","V","VI","VII","VIII","IX");
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id);
		    $subject_name=$data['subject_wise_list'][0]->course_title;
			$data['display'] = 'fail_list';
			$data['title'] = "Failed Student's Report";
		   //load the view and saved it into $html variable
		   if($this->input->post('downloadpdf') == 'true'){
				$html = $this->load->view('admin/deflicit/subject_wise_pass_fail_list_bvsc.php',$data, true);
				$pdfFilePath = "student_subject_".$subject_name.".pdf";
				//load mPDF library
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->AddPage('L');
			   //generate the PDF from the given html
				$this->m_pdf->pdf->WriteHTML($html);
			   //download it.
				$this->m_pdf->pdf->Output($pdfFilePath, "I");
				exit;
		   }else{
			   echo  $this->load->view('admin/deflicit/subject_wise_pass_fail_list_bvsc.php',$data,true);exit;
		   }
		  }	
          if($degree_id!='1'){
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id);
			$data['display'] = 'fail_list';
			$data['title'] = "Failed Student's Report";
			//p($data['subject_wise_list']); exit;
		    $subject_name=$data['subject_wise_list'][0]->course_title;
		    //load the view and saved it into $html variable
			if($this->input->post('downloadpdf') == 'true'){
			$html = $this->load->view('admin/deflicit/subject_wise_pass_fail_list_btech.php',$data, true);
			$pdfFilePath = "student_subject.pdf";
	        //load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','10','10','15','15');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	       //download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
			}else{
				echo  $this->load->view('admin/deflicit/subject_wise_pass_fail_list_btech.php',$data,true);exit;
			}
		  }			  
		 }
	}
	function show_deflicit(){
		
		if(!empty($this->input->post('failed_list')))
		  { 
	   $campus_id=$this->input->post('campus_id');
	   $program_id=$this->input->post('program_id');
	   $degree_id=$data['degree_id']=$this->input->post('degree_id');
	   $batch_id=$this->input->post('batch_id');
	   $semester_id=$this->input->post('semester_id');
	   $discipline_id=$this->input->post('discipline_id');

	   $course_input=$this->input->post('course_id');
           $course_id=$course_input;
		  // p($_POST); exit;
	       //$course_id=$courseid[0]; 
	       //$course_credit=$courseid[1]; 	  
		   $courseArr = explode("-",$course_input);
		   $courseArr = explode("|",$courseArr[0]);
		  $data['course_count'] =  count($courseArr);
	      if($degree_id=='1'){
			  
		   $data['numeralCodes'] =  array("I","II","III","IV","V","VI","VII","VIII","IX");
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id,'',1);
			//p($data['subject_wise_list']);exit;
		    $subject_name=$data['subject_wise_list'][0]->course_title;
			$data['display'] = 'fail_list';
			$data['title'] = "Failed Student's Report";
		   //load the view and saved it into $html variable
		   if($this->input->post('downloadpdf') == 'true'){
				$html = $this->load->view('admin/deflicit/subject_wise_pass_fail_list_bvsc.php',$data, true);
				$pdfFilePath = "student_subject_".$subject_name.".pdf";
				//load mPDF library
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->AddPage('L');
			   //generate the PDF from the given html
				$this->m_pdf->pdf->WriteHTML($html);
			   //download it.
				$this->m_pdf->pdf->Output($pdfFilePath, "I");
				exit;
		   }else{
			   echo  $this->load->view('admin/deflicit/subject_wise_pass_fail_list_bvsc.php',$data,true);exit;
		   }
		  }	
          if($degree_id!='1'){
		    $data['subject_wise_list'] = $this->Gradechart_model->get_subject_wise_pass_fail_list($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$course_id,'',1);
			$data['display'] = 'fail_list';
			$data['title'] = "Failed Student's Report";
			//p($data['subject_wise_list']); exit;
		    $subject_name=$data['subject_wise_list'][0]->course_title;
		    //load the view and saved it into $html variable
			if($this->input->post('downloadpdf') == 'true'){
			$html = $this->load->view('admin/deflicit/subject_wise_pass_fail_list_btech.php',$data, true);
			$pdfFilePath = "student_subject.pdf";
	        //load mPDF library
			$this->load->library('m_pdf');
			$this->m_pdf->pdf->mPDF('utf-8','A4','','','10','10','15','15');
	       //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	       //download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
            exit;
			}else{
				echo  $this->load->view('admin/deflicit/subject_wise_pass_fail_list_btech.php',$data,true);exit;
			}
		  }			  
		 }
	}
}