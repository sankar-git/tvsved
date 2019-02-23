<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Semester extends CI_Controller {
	
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
	function listSemester()
	{
		$data['page_title']="Semester List";
		$data['semester_list']=$this->Master_model->semester_list();
		$this->load->view('admin/semester_list_view',$data);
	}
    function addSemester()
	{
		$data['page_title']="Add Semester";
		$this->load->view('admin/semester_add_view',$data);
	}
	function saveSemester()
	{
		$register_date_time=date('Y-m-d H:i:s');
		$semester_code = $this->input->post('semester_code');
		$semester_name = $this->input->post('semester_name');
		
		$save['semester_code']=$semester_code;
		$save['semester_name']=$semester_name;
		$save['created_on']=     $register_date_time;
		
		$data= $this->Master_model->save_semester($save);
		$this->session->set_flashdata('message', 'Semester added successfully');
	    redirect('semester/listSemester');
		
	}
    
	function editSemester($id)
	{
		$data['page_title']="Update Semester";
		$data['semester_row']=$this->Master_model->get_semester_by_id($id);
		//print_r($data['semester_row']); exit;
		$this->load->view('admin/semester_edit_view',$data);
	}
	
	function updateSemester($id)
	{ 
	  $register_date_time=date('Y-m-d H:i:s');
	  $semester_code=$this->input->post('semester_code');
	  $semester_name=$this->input->post('semester_name');
	 
	  $save['semester_code']=$semester_code;
	  $save['semester_name']=$semester_name;
	  $save['updated_on']=$register_date_time;
	  $this->Master_model->update_semester($id,$save);//update semester
	  $this->session->set_flashdata('message', 'Program updated successfully');
	  redirect('semester/listSemester');
	}
	function deleteSemester($id)
	{    
	     if($id)
		 {
			$this->Master_model->delete_semester($id); 
		 }
		 $this->session->set_flashdata('message', 'Semester deleted successfully');
	     redirect('semester/listSemester'); 
	}
	function semesterStatus($id,$dststus)
	{     
	    $status = $dststus;
         $this->Master_model->status_semester($id,$status); 
		 $this->session->set_flashdata('message', 'Semester status updated successfully');
	     redirect('semester/listSemester'); 
	}
	 //----------------  Download Semester Excel ----------------------------//
      function downloadSemester()
	  {
		$data['semester_list']=$this->Master_model->semester_list();
		if(!empty($this->input->post('semesterExcel')))
          {
           
           $finalExcelArr = array('Semester Code','Semester Name');
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

            foreach ($data['semester_list'] as $key => $value) {
             //dd($value); 
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $value->semester_code);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $value->semester_name);
          
          
           
            }
          }

          $filename='Semester.xls';
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          ob_start();  
          $objWriter->save('php://output');

         
          }
      //----------------  End Download Semester Excel ------------------------// 
	  }
	
	
	
}
?>