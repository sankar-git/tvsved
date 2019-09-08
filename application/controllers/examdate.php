<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Examdate extends CI_Controller {
	
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
	   	 $this->load->library('m_pdf');
		 
		 
		  $this->load->model('Discipline_model');
		  $this->load->model('Master_model');
		  $this->load->model('Generate_model');
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
	function addExamDate()
	{    
	
	     	//print_r($_POST); exit;
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$semester_id=$this->input->post('semester_id');
		$batch_id=$this->input->post('batch_id');
		$date_of_start=$this->input->post('date_of_start');
		$date_of_closure=$this->input->post('date_of_closure');
		$student_id=$this->input->post('student_id');
		$data['page_title']="Schedule Exam Date";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['semesters'] = $this->Generate_model->get_semester(); 
		$this->load->view('admin/add_exam_course_view',$data);
		
		
	}
	
	//ajax function for generate registration card
	
	function getProgramByCampus()
	{   
	    $campus_id = $this->input->post('campus_id');
		
		 $data['programs'] = $this->Generate_model->get_program_by_campus($campus_id);
		// print_r($data['programs']); exit;
         $str = '';
         foreach($data['programs'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->program_name."</option>";
           }
		   
           echo $str;		
	}
	
	function getDegreebyProgram()
	{
		$program_id = $this->input->post('program_id');
		$data['degrees']=$this->Generate_model->get_degree_by_program_id($program_id); 
		 $str = '';
         foreach($data['degrees'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->degree_name."</option>";
           }
		   
           echo $str;
         
	}
	function getBatchbyDegree()
	{
		$degree_id = $this->input->post('degree_id');
		$data['batches']=$this->Generate_model->get_batch_by_degree($degree_id); 
		//print_r($data['batches']); exit;
		 $str = '';
         foreach($data['batches'] as $k=>$v){   
            $str .= "<option value=".$v->id.">".$v->batch_name."</option>";
           }
		   
           echo $str;
	}
	
	
	function getBatchbyDOS()
	{
		$degree_id = $this->input->post('degree_id');
		$data['dos']=$this->Generate_model->get_date_by_degree($degree_id); 
		 $str = '';
         foreach($data['dos'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->start_date."</option>";
           }
		   
           echo $str;
	}
	
	
	function getBatchbyDOC()
	{
		$degree_id = $this->input->post('degree_id');
		$data['doc']=$this->Generate_model->get_date_by_degree($degree_id); 
		//print_r($data['doc']); exit;
		 $str = '';
         foreach($data['doc'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->date_of_closure."</option>";
           }
		   
           echo $str;
	}
	
	
	function getCourseList()
	{
		    
			//print_r($_POST); exit;
		$campus_id=$this->input->post('campus_id');
		$program_id=$this->input->post('program_id');
		$degree_id=$this->input->post('degree_id');
		$semester_id=$this->input->post('semester_id');
		$batch_id=$this->input->post('batch_id');
		$date_of_start=$this->input->post('date_of_start');
		$date_of_closure=$this->input->post('date_of_closure');
		
	    $send['campus_id']=$campus_id;
	    $send['program_id']=$program_id;
	    $send['degree_id']=$degree_id;
	    $send['batch_id']=$batch_id;
	    $send['semester_id']=$semester_id;
		//print_r($send); exit;
	    //$courseList= $this->Generate_model->get_student_assign_course_list($send);
	    $courseList= $this->Generate_model->get_assign_course_list($send);
		//echo $this->db->last_query();exit;
	   // print_r($courseList); exit;
	  
	  $trdata='';
			$i=0;
			foreach($courseList as $courses)
			{
				
				$i++;
				if(!empty($courses->exam_date)){
					$checked = 'checked';
				}
				else{
					$checked = '';
				}
				$checked = 'checked';
				$trdata.='<tr>
				      <td><input type="checkbox" class="checkbox"  id="select_all" name="course_id[]" value="'.$courses->id.'" '.$checked.'></td>
						<td>'.$i.'</td>
						<td>'.$courses->course_code.'</td>
						<td>'.$courses->course_title.'</td>
						<td><input type="text"  class="exam_dates" id="exam_date" name="exam_date[]"  value="'.$courses->exam_date.'"></td>
						
					</tr>';
			}
			echo $trdata;
	
		
	}
	
	function saveExamDate()
	{

		$campus_id =$this->input->post('campus_id');
		$program_id =$this->input->post('program_id');
		$degree_id =$this->input->post('degree_id');
		$batch_id=$this->input->post('batch_id');
		$course_ids=$this->input->post('course_id');
		$semester_id=$this->input->post('semester_id');
		$exam_type=$this->input->post('exam_type');
		$examination=$this->input->post('examination');
		$exam_dates=$this->input->post('exam_date');
		//print_r($exam_dates); exit;
		     //$this->Generate_model->delete_old_exam_date($campus_id,$program_id,$degree_id,$batch_id,$exam_type);
			for($i=0;$i<count($course_ids);$i++){
						$exam_date=$exam_dates[$i];
						$course_id=$course_ids[$i];
						$data=array(
							'campus_id'=>$campus_id,
							'program_id'=>$program_id,
							'degree_id'=>$degree_id,
							'batch_id'=>$batch_id,
							'course_id'=>$course_id,
							'semester_id'=>$semester_id,
							'exam_type'=>$exam_type,
							'examination'=>$examination,
							'exam_date'=>$exam_date

						
						);
						//p($data); exit;
						$save = $this->Generate_model->save_course_exam_date($data); 
						//print_r($save);
						if(!empty($save))
						{
							$return =1;
						}
						else{
							$return =0;
						}
						
						
						
				}
		echo $return;
		
	}
	function getPrint()
	{
		
		//print_r($student_id); exit;
		$data = [];
        //load the view and saved it into $html variable
        $html=$this->load->view('admin/print_pdf', $data, true);
        // print_r($html); exit;
        //this the the PDF filename that user will get to download
        $pdfFilePath = "output_pdf_name.pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");   
       
	}
	function downloadPdf()
	{
		//print_r($student_id); exit;
		$data = [];
        //load the view and saved it into $html variable
        $html=$this->load->view('admin/print_pdf', $data, true);
        // print_r($html); exit;
        //this the the PDF filename that user will get to download
        $pdfFilePath = "output_pdf_name.pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		return true; exit;
	}
	
	
}
?>