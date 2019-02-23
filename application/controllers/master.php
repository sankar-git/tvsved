<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master extends CI_Controller {
	
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
	function listclassroom()
	{
		$data['page_title']="View Class Room";
		$data['room_list']=$this->Master_model->class_room_list();
		//print_r($data['degree_list']); exit;
		$this->load->view('admin/classroom_list_view',$data);
	}
	function listexam_slot()
	{
		$data['page_title']="View Slot";
		$data['slot_list']=$this->Master_model->slot_list();
		//print_r($data['degree_list']); exit;
		$this->load->view('admin/slot_list_view',$data);
	}
	function addSlot()
	{
		$data['page_title']="Add Slot";
		$this->load->view('admin/slot_add_view',$data);
	}
	function editslot($id)
	{
		
	    $data['page_title']="Update Slot";
		$data['slot_row']=$this->Master_model->slot_list($id);
		//print_r($data['degree_row']); exit;
		$this->load->view('admin/slot_add_view',$data);
	}
	function deleteSlot($id)
	{    
	     if($id)
		 {
			$this->Master_model->delete_slot($id); 
		 }
		 $this->session->set_flashdata('message', 'Slot deleted successfully');
	     redirect('master/listexam_slot'); 
	}
	function saveSlot(){
		$register_date_time=date('Y-m-d H:i:s');
		$slot_name = $this->input->post('slot_name');
		$id = $this->input->post('id');
		
		
		$save['slot_name']=$slot_name;
		
		
		$save['created_on']=     $register_date_time;
		//print_r($save); exit;
		$data= $this->Master_model->save_slot($save,$id);
		if($id>0)
		$this->session->set_flashdata('message', 'Slot updated successfully');
		else
		$this->session->set_flashdata('message', 'Slot added successfully');
	    redirect('master/listexam_slot');
		
	}
    function addClassRoom()
	{
		$data['page_title']="Add Class Room";
		$data['campus_list']=$this->Master_model->lis_campus();
		$this->load->view('admin/class_room_add_view',$data);
	}
	function addDegree()
	{
		$data['page_title']="Add Degree";
		$data['discipline_list']=$this->Discipline_model->discipline_list();
		$data['programs'] = $this->Discipline_model->get_program(); 
		//print_r($data['programs']); exit;
		$this->load->view('admin/degree_add_view',$data);
	}
	
    function saveClassRoom(){
		$register_date_time=date('Y-m-d H:i:s');
		$room_name = $this->input->post('room_name');
		$campus_id = $this->input->post('campus_id');
		$id = $this->input->post('id');
		
		
		$save['room_name']=$room_name;
		$save['campus_id']=$campus_id;
		
		
		$save['created_on']=     $register_date_time;
		//print_r($save); exit;
		$data= $this->Master_model->save_classroom($save,$id);
		if($id>0)
		$this->session->set_flashdata('message', 'Class Room updated successfully');
		else
		$this->session->set_flashdata('message', 'Class Room added successfully');
	    redirect('master/listclassroom');
		
	}
	function saveDegree()
	{   
		$register_date_time=date('Y-m-d H:i:s');
		$degree_code = $this->input->post('degree_code');
		$degree_name = $this->input->post('degree_name');
		$discipline_id = $this->input->post('discipline_id');
		$program_id = $this->input->post('program_id');
		
		$save['degree_code']=$degree_code;
		$save['degree_name']=$degree_name;
		$save['discipline_id']= $discipline_id;
		$save['program_id']= $program_id;
		$save['created_on']=     $register_date_time;
		//print_r($save); exit;
		$data= $this->Master_model->save_degree($save);
		$this->session->set_flashdata('message', 'Degree added successfully');
	    redirect('master/listDegree');
		
		
	}
	function listDegree()
	{
		$data['page_title']="View Degree";
		$data['degree_list']=$this->Master_model->degree_list();
		//print_r($data['degree_list']); exit;
		$this->load->view('admin/degree_list_view',$data);
	}
	function editDegree($id)
	{
		
	    $data['page_title']="Update Degree";
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		//print_r($data['disciplines']); exit;
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['degree_row']=$this->Master_model->get_degree_by_id($id);
		//print_r($data['degree_row']); exit;
		$this->load->view('admin/degree_edit_view',$data);
	}
	function deleteClassRoom($id)
	{    
	     if($id)
		 {
			$this->Master_model->delete_class_room($id); 
		 }
		 $this->session->set_flashdata('message', 'Class Room deleted successfully');
	     redirect('master/listclassroom'); 
	}
	function editclassroom($id)
	{
		
	    $data['page_title']="Update Class Room";
		$data['campus_list']=$this->Master_model->lis_campus();
		$data['class_room_row']=$this->Master_model->class_room_list($id);
		//print_r($data['degree_row']); exit;
		$this->load->view('admin/class_room_add_view',$data);
	}
	function updateDegree($id)
	{ 
	  $register_date_time=date('Y-m-d H:i:s');
	  $degree_code=$this->input->post('degree_code');
	  $degree_name=$this->input->post('degree_name');
	  $discipline_id=$this->input->post('discipline_id');
	  $program_id=$this->input->post('program_id');
	  
	  $save['degree_code']=$degree_code;
	  $save['degree_name']=$degree_name;
	  $save['discipline_id']=$discipline_id;
	  $save['program_id']=$program_id;
	  $save['updated_on']=$register_date_time;
	  
	  $this->Master_model->update_degree($id,$save);
	  $this->session->set_flashdata('message', 'Degree updated successfully');
	  redirect('master/listDegree');
	}
	function deleteDegree($id)
	{    
	     if($id)
		 {
			$this->Master_model->delete_degree($id); 
		 }
		 $this->session->set_flashdata('message', 'Degree deleted successfully');
	     redirect('master/listDegree'); 
	}
	function degreeStatus($id,$dststus)
	{     
	     $status = $dststus;
		// print_r($status); exit;
         $this->Master_model->status_degree($id,$status); 
		 $this->session->set_flashdata('message', 'Degree status updated successfully');
	     redirect('master/listDegree'); 
	}
	
	//************************Syllabuus Year Section Start***********************************//
	  function listSyllabusYear()
	  {
		$data['page_title']="List Syllabus Year";
		$data['syllabus_list']=$this->Master_model->syllabus_year_list();
		//print_r($data['syllabus_list']); exit;
		$this->load->view('admin/syllabus_year_list_view',$data);
	  }
	  function addSyllabusYear()
	  {
		  $data['page_title']="Add Syllabus Year";
		
		  $data['programs'] = $this->Discipline_model->get_program(); 
		 
		$this->load->view('admin/syllabus_year_add_view',$data);  
	  }
	  
	  function saveSyllabusYear()
	  {
		  $register_date_time=date('Y-m-d H:i:s');
	      $syllabus_id=$this->input->post('syllabus_id');
	      $program_id=$this->input->post('program_id');
		  $save['syllabus_year']=$syllabus_id;
		  $save['program_id']=$program_id;
		  $save['created_on']=$register_date_time;
		  $this->Master_model->save_syllabus_year($save); 
		  $this->session->set_flashdata('message', 'Syllabus Year added successfully');
	      redirect('master/listSyllabusYear');
	  }
	  function editSyllabusYear($id)
	  {
		  
	    $data['page_title']="Update Syllabus Year";
		
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['syllabus_year_row']=$this->Master_model->get_syllabus_year_by_id($id);
		//print_r($data['syllabus_year_row']); exit;
		$this->load->view('admin/syllabus_year_edit_view',$data);
	  }
	  function updateSyllabusYear($id)
	  {
	  $register_date_time=date('Y-m-d H:i:s');
	  $syllabus_id=$this->input->post('syllabus_id');
	  $program_id=$this->input->post('program_id');
	  
	  
	  $save['syllabus_year']=$syllabus_id;
	  $save['program_id']=$program_id;
	  $save['updated_on']=$register_date_time;
	  
	  $this->Master_model->update_syllabus_year($id,$save);
	  $this->session->set_flashdata('message', 'Syllabus Year updated successfully');
	  redirect('master/listSyllabusYear');
	  }
	  function deleteSyllabusYear($id)
	  {
		 // print_r($id); exit;
		 if($id)
		 {
			$this->Master_model->delete_syllabus_year($id); 
		 }
		 $this->session->set_flashdata('message', 'Syllabus Year deleted successfully');
	     redirect('master/listSyllabusYear'); 
	  }
	  function syllabusYearStatus($id,$status)
	  {
		
         $this->Master_model->status_syllabus_year($id,$status); 
		 $this->session->set_flashdata('message', 'Syllabus year status updated successfully');
	     redirect('master/listSyllabusYear'); 
	  }
	//************************Syllabuus Year Section End***********************************//
	
	 //----------------  Download Discipline Excel ----------------------------//
      function downloadDegree()
	  {
		$data['degree_list']=$this->Master_model->degree_list();
		if(!empty($this->input->post('degreeExcel')))
          {
           
           $finalExcelArr = array('Degree Code','Degree Name','Discipline Name','Program Name');
           $objPHPExcel = new PHPExcel();
           $objPHPExcel->setActiveSheetIndex(0);
           $objPHPExcel->getActiveSheet()->setTitle('Discipline Worksheet');
           $cols= array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
            $j=2;
            
            //For freezing top heading row.
            $objPHPExcel->getActiveSheet()->freezePane('A2');

            //Set height for column head.
            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                        
           for($i=0;$i<count($finalExcelArr);$i++){
            
            //Set width for column head.
            $objPHPExcel->getActiveSheet()->getColumnDimension($cols[$i])->setAutoSize(true);

            //Set background color for heading column.
            $objPHPExcel->getActiveSheet()->getStyle($cols[$i].'1')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '71B8FF')
                    ),
                      'font'  => array(
                      'bold'  => false,
                      'size'  => 15,
                      )
                )
            );

            $objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'1', $finalExcelArr[$i]);

            foreach ($data['degree_list'] as $key => $value) {
             //dd($value); 
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $value->degree_code);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $value->degree_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[2].$newvar, $value->discipline_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[3].$newvar, $value->program_name);
          
           
            }
          }

          $filename='Discipline.xls';
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          ob_start();  
          $objWriter->save('php://output');

         
          }
      //----------------  End Download Discipline Excel ------------------------// 
	  }
	  
	   //----------------  Download Syllabus Excel ----------------------------//
      function downloadSyllabusYear()
	  {
		$data['syllabus_list']=$this->Master_model->syllabus_year_list();
		if(!empty($this->input->post('syllabusYearExcel')))
          {
           
           $finalExcelArr = array('Syllabus Year','Program Name');
           $objPHPExcel = new PHPExcel();
           $objPHPExcel->setActiveSheetIndex(0);
           $objPHPExcel->getActiveSheet()->setTitle('Discipline Worksheet');
           $cols= array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
            $j=2;
            
            //For freezing top heading row.
            $objPHPExcel->getActiveSheet()->freezePane('A2');

            //Set height for column head.
            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                        
           for($i=0;$i<count($finalExcelArr);$i++){
            
            //Set width for column head.
            $objPHPExcel->getActiveSheet()->getColumnDimension($cols[$i])->setAutoSize(true);

            //Set background color for heading column.
            $objPHPExcel->getActiveSheet()->getStyle($cols[$i].'1')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '71B8FF')
                    ),
                      'font'  => array(
                      'bold'  => false,
                      'size'  => 15,
                      )
                )
            );

            $objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'1', $finalExcelArr[$i]);

            foreach ($data['syllabus_list'] as $key => $value) {
             //dd($value); 
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $value->syllabus_year);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $value->program_name);
          
          
           
            }
          }

          $filename='Syllabus_year.xls';
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          ob_start();  
          $objWriter->save('php://output');

         
          }
      //----------------  End Download Discipline Excel ------------------------// 
	  }
	  
	  
	 
	 
	  
	
	
	
}
?>