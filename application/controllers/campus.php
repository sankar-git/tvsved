<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Campus extends CI_Controller {
	
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
	function listCampus()
	{
		$data['page_title']="Campus List";
		$data['campus_list']=$this->Master_model->lis_campus();
		//print_r($data['campus_list']); exit;
		$this->load->view('admin/campus_list_view',$data);
	}
    function addCampus()
	{
		$data['page_title']="Add Campus";
		$this->load->view('admin/campus_add_view',$data);
	}
	function saveCampus()
	{
		$register_date_time=date('Y-m-d H:i:s');
		$campus_code = $this->input->post('campus_code');
		$campus_name = $this->input->post('campus_name');
		$campus_short_name = $this->input->post('campus_short_name');
		$address_line1 = $this->input->post('address_line1');
		$address_line2 = $this->input->post('address_line2');
		$address_line3 = $this->input->post('address_line3');
		$address_line4 = $this->input->post('address_line4');
		$landline_number = $this->input->post('landline_number');
		$mobile_number = $this->input->post('mobile_number');
		$fax_number = $this->input->post('fax_number');
		$email = $this->input->post('email');
		$login_id = $this->input->post('login_id');
		$password = $this->input->post('password');
		$dean_name = $this->input->post('dean_name');
		$dean_phone_number = $this->input->post('dean_phone_number');
		$dean_email = $this->input->post('dean_email');
		
		
		$save['campus_code']=$campus_code;
		$save['campus_name']=     $campus_name;
		$save['campus_short_name']= $campus_short_name;
		$save['address1']=     $address_line1;
		$save['address2']=     $address_line2;
		$save['address3']=     $address_line3;
		$save['address4']=     $address_line4;
		$save['landline_number']=     $landline_number;
		$save['mobile_number']=     $mobile_number;
		$save['fax_number']=     $fax_number;
		$save['email']=     $email;
		$save['login_id']=     $login_id;
		$save['password']=     $password;
		$save['dean_name']=     $dean_name;
		$save['dean_phone_number']=     $dean_phone_number;
		$save['dean_email']=     $dean_email;
		$save['created_on']=     $register_date_time;
		
		$data= $this->Master_model->save_campus($save);
		$this->session->set_flashdata('message', 'Campus added successfully');
	    redirect('campus/listCampus');
		
	}
    
	function editCourseGroup($id)
	{
		$data['page_title']="Update Course Group";
		$data['course_group_row']=$this->Master_model->get_course_group_by_id($id);
	   // print_r($data['course_group_row']); exit;
		$this->load->view('admin/course_group_edit_view',$data);
	}
	
	function updateCourseGroup($id)
	{ 
	    $register_date_time=date('Y-m-d H:i:s');
		$course_group_code = $this->input->post('course_group_code');
		$course_group_name = $this->input->post('course_group_name');
		
		$save['course_group_code']=$course_group_code;
		$save['course_group_name']=$course_group_name;
		$save['updated_on']=     $register_date_time;
	    $this->Master_model->update_course_group($id,$save);//update semester
	    $this->session->set_flashdata('message', 'Course group updated successfully');
	    redirect('course/listCourseGroup');
	}
	function deleteCourseGroup($id)
	{    
	     if($id)
		 {
			$this->Master_model->delete_course_group($id); 
		 }
		 $this->session->set_flashdata('message', 'Course group deleted successfully');
	     redirect('course/listCourseGroup'); 
	}
	function courseGroupStatus($id,$dststus)
	{     
	     $status = $dststus;
         $this->Master_model->status_course_group($id,$status); 
		 $this->session->set_flashdata('message', 'Course group status updated successfully');
	     redirect('course/listCourseGroup'); 
	}
	function getDegreebyProgram()
	{
		$program_id = $this->input->post('program_id');
		$data['degrees']=$this->Master_model->get_degree_by_program_id($program_id); 
		 $str = '';
         foreach($data['degrees'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->degree_name."</option>";
           }
		   
           echo $str;
         
	}
	function editCampus($id)
	{
		$data['page_title']="Update Campus";
		$data['campus_row']=$this->Master_model->edit_campus_by_id($id);
	    $this->load->view('admin/campus_edit_view',$data);
	}
	function updateCampus($id)
	{
		$register_date_time=date('Y-m-d H:i:s');
		$campus_code = $this->input->post('campus_code');
		$campus_name = $this->input->post('campus_name');
		$campus_short_name = $this->input->post('campus_short_name');
		$address_line1 = $this->input->post('address_line1');
		$address_line2 = $this->input->post('address_line2');
		$address_line3 = $this->input->post('address_line3');
		$address_line4 = $this->input->post('address_line4');
		$landline_number = $this->input->post('landline_number');
		$mobile_number = $this->input->post('mobile_number');
		$fax_number = $this->input->post('fax_number');
		$email = $this->input->post('email');
		$login_id = $this->input->post('login_id');
		$dean_name = $this->input->post('dean_name');
		$dean_phone_number = $this->input->post('dean_phone_number');
		$dean_email = $this->input->post('dean_email');
		
		
		$save['campus_code']=$campus_code;
		$save['campus_name']=     $campus_name;
		$save['campus_short_name']= $campus_short_name;
		$save['address1']=     $address_line1;
		$save['address2']=     $address_line2;
		$save['address3']=     $address_line3;
		$save['address4']=     $address_line4;
		$save['landline_number']=     $landline_number;
		$save['mobile_number']=     $mobile_number;
		$save['fax_number']=     $fax_number;
		$save['email']=     $email;
		$save['login_id']=     $login_id;
		$save['dean_name']=     $dean_name;
		$save['dean_phone_number']=     $dean_phone_number;
		$save['dean_email']=     $dean_email;
		$save['updated_on']=     $register_date_time;
		//print_r($save); exit;
		$data= $this->Master_model->update_campus($id,$save);
		$this->session->set_flashdata('message', 'Campus Updated Successfully');
	    redirect('campus/listCampus');
	}
	function deleteCampus($id)
	{
		 if($id)
		 {
			$this->Master_model->delete_campus($id); 
		 }
		 $this->session->set_flashdata('message', 'Campus deleted successfully');
	     redirect('campus/listCampus');
	}
	function detailCampus($id)
	{
		$data['page_title']="Campus Details";
		$data['campus_row']=$this->Master_model->edit_campus_by_id($id);
	    $this->load->view('admin/campus_detail_view',$data);
	}
	function campusStatus($id,$dststus)
	{
		 $status = $dststus;
         $this->Master_model->campus_status($id,$status); 
		 $this->session->set_flashdata('message', 'Campus status updated successfully');
	     redirect('campus/listCampus');
	}
	function campusAndDegreeList()
	{
	     $data['page_title']="Campus & Degree List";
		 $data['campus_and_degree_list']=$this->Master_model->list_campus_and_degree();
		//print_r($data['campus_list']); exit;
		 $this->load->view('admin/campus_and_degree_list_view',$data);
	}
	
	
	function campusAndDegreeAdd()
	{
	    $data['page_title']="Campus & Degree List";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['programs'] = $this->Discipline_model->get_program(); 
		
	    $this->load->view('admin/campus_and_degree_add_view',$data);
	}
	function campusAndDegreeEdit($id)
	{
	    $data['page_title']="Update Campus & Degree";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['degrees'] = $this->Discipline_model->get_degree(); 
		$data['campus_degree_row'] = $this->Master_model->campus_and_degree_edit_by_id($id); 
		
	    $this->load->view('admin/campus_and_degree_edit_view',$data);
	}
	function updateCampusDegree($id)
	{
		$register_date_time=date('Y-m-d H:i:s');
		$campus_id = $this->input->post('campus_id');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$save['campus_id']=$campus_id;
		$save['program_id']=$program_id;
		$save['degree_id']=$degree_id;
		$save['created_on']=$register_date_time;
	    $this->Master_model->update_campus_degree_program($id,$save); 
		$this->session->set_flashdata('message', 'campus and Degree added successfully');
	    redirect('campus/campusAndDegreeList');
		
	}
	function saveCampusDegree()
	{
		$register_date_time=date('Y-m-d H:i:s');
		$campus_id = $this->input->post('campus_id');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$save['campus_id']=$campus_id;
		$save['program_id']=$program_id;
		$save['degree_id']=$degree_id;
		$save['created_on']=$register_date_time;
	    $this->Master_model->save_campus_degree_program($save); 
		$this->session->set_flashdata('message', 'campus and Degree added successfully');
	    redirect('campus/campusAndDegreeList');
		
	}
	
  function deleteCampusDegree($id)
	{
		 if($id)
		 {
			$this->Master_model->delete_campus_degree($id); 
		 }
		 $this->session->set_flashdata('message', 'Campus Degree deleted successfully');
	     redirect('campus/campusAndDegreeList');
	}
	
	function detailCampusDegree($id)
	{
		$data['page_title']="Detail Campus & Degree";
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['degrees'] = $this->Discipline_model->get_degree(); 
		$data['campus_degree_row'] = $this->Master_model->campus_and_degree_edit_by_id($id); 
		
	    $this->load->view('admin/campus_and_degree_detail_view',$data);
	}
	
	function campusDegreeStatus($id,$status)
	{
		
         $this->Master_model->campus_degree_status($id,$status); 
		 $this->session->set_flashdata('message', 'Campus Degree status updated successfully');
	     redirect('campus/campusAndDegreeList');
	}
	   //----------------  Download Campus Excel ----------------------------//
      function downloadCampus()
	  {
		  $data['campuses'] = $this->Discipline_model->get_campus(); 
		  //print_r($data['campuses']); exit;
		if(!empty($this->input->post('campusExcel')))
          {
           
           $finalExcelArr = array('Campus Code','Campus Name','Campus Short Name','Address Line1','Address Line2','Address Line3','Address Line4','Landline No','Mobile No','Fax No','Email','Login Id','Dean Name','Dean Phone No','Dean Email');
           $objPHPExcel = new PHPExcel();
           $objPHPExcel->setActiveSheetIndex(0);
           $objPHPExcel->getActiveSheet()->setTitle('Campus Worksheet');
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

            foreach ($data['campuses'] as $key => $value) {
           // print_r($value) ; exit;
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $value->campus_code);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $value->campus_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[2].$newvar, $value->campus_short_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[3].$newvar, $value->address1);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[4].$newvar, $value->address2);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[5].$newvar, $value->address3);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[6].$newvar, $value->address4);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->landline_number);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->mobile_number);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[9].$newvar, $value->	fax_number);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[10].$newvar, $value->email);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[11].$newvar, $value->login_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[12].$newvar, $value->dean_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[13].$newvar, $value->dean_phone_number);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[14].$newvar, $value->dean_email);
          
           
            }
          }

          $filename='Campus.xls';
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          ob_start();  
          $objWriter->save('php://output');

         
          }
      //----------------  End Download Campus Excel ------------------------// 
	  }
	
	
	
	
}
?>