<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
	
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
			$this->load->model('fees_model');
			$this->load->library('image_lib');
			$this->load->model('common_model');
			$this->load->model('newsession_model');
			$this->load->helper('email');
			$this->load->model('newsession_model');
			$this->load->model('user_model');
			$this->load->model('type_model');
			$this->load->model('Master_model');
			$this->load->model('Discipline_model');
			$this->load->library('permission_lib');
			
			$this->load->library('excel');
			
			if($this->session->userdata('sms'))
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
			}
	}
	
	public function index()
	{
		
		echo "hello"; exit;
	}
	
	function dashboard(){
		
		 if ($this->session->userdata('sms')) {
			$this->load->view('admin/index');
		 }
		 else{
			redirect('authenticate', 'refresh'); 
		 }
	}
	function addUser()
	{
		   $data['title'] ='Add User';
		   $data['disciplines'] = $this->Discipline_model->get_discipline(); 
		   $data['batches'] = $this->Discipline_model->get_batch(); 
		   $data['campuses'] = $this->Discipline_model->get_campus(); 
		  // dd( $data['campuses']); 
		   $data['degrees'] = $this->Discipline_model->get_degree(); 
		   $data['roles']=$this->type_model->get_role();
		   $data['countries']=$this->type_model->get_country();
		   $data['states']=$this->type_model->get_state();
		   //print_r( $data['countries']); exit;
		   $this->load->view('admin/add_user_view',$data);
	}

	function listUser()
	{
		$data['page_title'] ='User List';
		$data['roles']=$this->type_model->get_role();
		$data['user_list']=$this->type_model->list_user();
		//print_r($data['user_list']); exit;
		$this->load->view('admin/user_list_view',$data);
	}
	function saveUser()
	{     
	        $register_date_time=date('Y-m-d H:i:s');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
		    $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
			$email = $this->input->post('email');
			$contact_number=$this->input->post('contact_number');
			$user_type = $this->input->post('user_type');
			$dob= $this->input->post('dob');
			$gender = $this->input->post('gender');
			$user_image = $_FILES['user_image']['name'];
			//user other details
			$batch_id=$this->input->post('batch_id');
			$campus_id=$this->input->post('campus_id');
			$degree_id=$this->input->post('degree_id');
			$course_type=$this->input->post('course_type');
            $parent_name=$this->input->post('parent_name');
			$mother_name=$this->input->post('mother_name');
			$occupation=$this->input->post('occupation');
            $father_contact=$this->input->post('father_contact');
			$alternate_contact=$this->input->post('alternate_contact');
			$father_email=$this->input->post('father_email');
			$religion=$this->input->post('religion');
			$nationality=$this->input->post('nationality');
			$address=$this->input->post('address');
			$country_id=$this->input->post('country_id');
			$state_id=$this->input->post('state_id');
			$zip_code=$this->input->post('zip_code');
			$parent_image=$_FILES['parent_image']['name'];
			//Academic Info
			$registration=$this->input->post('registration');
			$class_name=$this->input->post('class_name');
			$section_id=$this->input->post('section_id');
            $roll=$this->input->post('roll');
			$last_school=$this->input->post('last_school');
			$last_std=$this->input->post('last_std');
			$marks_obtained=$this->input->post('marks_obtained');
			$sports_id=$this->input->post('sports_id');
			
			//teacher details
			$address_line1=$this->input->post('address_line1');
			$address_line2=$this->input->post('address_line2');
			$address_line3=$this->input->post('address_line3');
            $address_line4=$this->input->post('address_line4');
			$landline_number=$this->input->post('landline_number');
			$employee_id=$this->input->post('employee_id');
			$qualification=$this->input->post('qualification');
			$date_of_joining=$this->input->post('date_of_joining');
			$designation=$this->input->post('designation');
			$department=$this->input->post('department');
			$campus=$this->input->post('campus');
			$discipline_id=$this->input->post('discipline_id');
			//user details
			$user_address_line1=$this->input->post('user_address_line1');
			$user_address_line2=$this->input->post('user_address_line2');
			$user_address_line3=$this->input->post('user_address_line3');
            $user_address_line4=$this->input->post('user_address_line4');
			$user_landline_number=$this->input->post('user_landline_number');
			
			
			$config['upload_path']          = './uploads/user_images/student';
			$config['allowed_types']        = 'gif|jpg|png|GIF|JPG|PNG|JPEG';
			$config['max_size']             = 6096;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			$config['encrypt_name']			= TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('user_image');
			$user_image = $this->upload->data();
			$user_file=$user_image['file_name'];
			
			$config['upload_path']          = './uploads/user_images/parent';
			$config['allowed_types']        = 'gif|jpg|png|GIF|JPG|PNG|JPEG';
			$config['max_size']             = 6096;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			$config['encrypt_name']			= TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('parent_image');
			$parent_image = $this->upload->data();
			$parent_file=$parent_image['file_name'];
			
			$save['username']=$username;
			$save['password']=$password;
			$save['first_name']=$first_name;
			$save['last_name']=$last_name;
			$save['email']=$email;
			$save['contact_number']=$contact_number;
			$save['role_id']=$user_type;
			$save['dob']=$dob;
			$save['gender']=$gender;
			$save['user_image']=$user_file;
			$save['created_on']=$register_date_time;
			//print_r($save); exit;
			$last_id=$this->type_model->save_user($save);
			       //updateing unique_id for student
				
				$degreeString=$this->type_model->get_degree_name($degree_id);//get degree name
				//print_r($degreeString->degree_name); exit;
				$explodeingString=$degreeString->degree_name;
				$degreeWord = explode(' ',$explodeingString);
				//print_r($degreeWord);
                if($degreeWord[0]!=''){			
					$firstChar=substr($degreeWord[0],0,1);
				}
				//print_r($firstChar); exit;
				if($degreeWord[2]!=''){
					$secondChar=substr($degreeWord[2],0,1);
				}
				if($degreeWord[3]!=''){
					$thirdChar=substr($degreeWord[3],0,1);
				}
				//get batch name
				$batch=$this->type_model->get_batch_name($batch_id);// get batch name
				//print_r($batch->batch_name); exit;
				$batch_year=$batch->batch_name;
				$batch_prefix=substr($batch_year,-2);
				$unique_id=$firstChar.''.$secondChar.''.$thirdChar.''.$batch_prefix.''.$last_id;
				//print_r($unique_id); exit;
				$unique['user_unique_id']=$unique_id;
			    $this->type_model->add_unique_id_of_student($last_id,$unique);
			
			
			// save common user details
			
			$registration=$this->input->post('registration');
			$class_name=$this->input->post('class_name');
			$section_id=$this->input->post('section_id');
            $roll=$this->input->post('roll');
			$last_school=$this->input->post('last_school');
			$last_std=$this->input->post('last_std');
			$marks_obtained=$this->input->post('marks_obtained');
			$sports_id=$this->input->post('sports_id');
			if($user_type=='1')
			{
			$saved['user_id']=$last_id;
			$saved['batch_id']=$batch_id;
			$saved['campus_id']=$campus_id;
			$saved['degree_id']=$degree_id;
			$saved['course_type']=$course_type;
			$saved['parent_name']=$parent_name;
			$saved['mother_name']=$mother_name;
			$saved['occupation']=$occupation;
			$saved['father_contact']=$father_contact;
			$saved['alternate_contact']=$alternate_contact;
			$saved['father_email']=$father_email;
			$saved['religion']=$religion;
			$saved['nationality']=$nationality;
			$saved['address']=$address;
			$saved['country_id']=$country_id;
			$saved['state_id']=$state_id;
			$saved['zip_code']=$zip_code;
			$saved['parent_image']=$parent_file;
			
			$saved['registration']=$registration;
			$saved['class_name']=$class_name;
			$saved['section_id']=$section_id;
			$saved['roll']=$roll;
			$saved['last_school']=$last_school;
			$saved['last_std']=$last_std;
			$saved['marks_obtained']=$marks_obtained;
			$saved['sports_id']=$sports_id;
			
			}
			if($user_type=='2')
			{
				$saved['user_id']=$last_id;
				$saved['address_line1']=$address_line1;
				$saved['address_line2']=$address_line2;
				$saved['address_line3']=$address_line3;
				$saved['address_line4']=$address_line4;
				$saved['landline_number']=$landline_number;
				$saved['employee_id']=$employee_id;
				$saved['qualification']=$qualification;
				$saved['date_of_joining']=$date_of_joining;
				$saved['designation']=$designation;
				$saved['department']=$department;
				$saved['campus']=$campus;
				$saved['discipline']=$discipline_id;
			
			}
			if($user_type=='3')
			{
				$saved['user_id']=$last_id;
				$saved['address_line1']=$user_address_line1;
				$saved['address_line2']=$user_address_line2;
				$saved['address_line3']=$user_address_line3;
				$saved['address_line4']=$user_address_line4;
				$saved['landline_number']=$user_landline_number;
			}
		    //print_r($saved);  exit;
			$id=$this->type_model->save_user_details($saved,$user_type);// save common user details
			$this->session->set_flashdata('message', 'User added successfully');
			redirect('admin/addUser');
	}
	//*********Ajax Function ************//
	
	function getUser()
	{
		$username=$this->input->post('username');
		 $data=$this->type_model->check_user($username);
		 echo $data; exit;
	}
	
//  All ajax function here
	public function getState(){
		$countryid = $this->input->post('country_id');
		$data['states'] = $this->type_model->get_country_by_id($countryid);

		$str = '';
		foreach($data['states'] as $k=>$v){   
		$str .= "<option value=".$v->id.">".$v->state."</option>";
		}
		echo $str;
	}
	public function getDegree(){
		$campus_id = $this->input->post('campus_id');
		//print_r($campus_id); exit;
		$data['degrees'] = $this->type_model->get_degree_by_campus_id($campus_id);
        // dd($data['degrees']); exit;
		$str = '';
		foreach($data['degrees'] as $k=>$v){   
		$str .= "<option value=".$v->id.">".$v->degree_name."</option>";
		}
		echo $str;
	} 
		  
	//*********Ajax Function ends************//
	function userDetail($id)
	{
		$data['page_title'] ='User Detail';
		//$data['user_list']=$this->user_model->list_user();
		//print_r($data['user_list']); exit;
		$this->load->view('admin/user_detail_view',$data);
	}
	
	function editUser($id,$role_id)
	{     
           $data['page_title']="Update User";
	       $data['roles']=$this->type_model->get_role();
		   $data['countries']=$this->type_model->get_country();
		   $data['states']=$this->type_model->get_state();
		   
		   $data['user_row']=$this->type_model->get_user_by_id($id,$role_id);
		   
		  // print_r( $data['user_row']); exit;
		   if($role_id=='1')
		   {
		    $this->load->view('admin/edit_user_view',$data); //student edit view
		   }
		    if($role_id=='2')
		   {
			$data['disciplines'] = $this->Discipline_model->get_discipline(); 
			$data['campuses']=$this->type_model->get_campus();
		    $this->load->view('admin/edit_teacher_view',$data);
		   }
		   if($role_id=='3')
		   {
			   //print_r($data); exit;
		    $this->load->view('admin/user_edit_view',$data);  //user edit view
		   }
	}
	function deleteUser($id,$role)
	{
		 if($id)
		 {
			$this->Master_model->delete_user($id,$role); 
		 }
		 $this->session->set_flashdata('message', 'User deleted successfully');
	     redirect('admin/listUser'); 
	}
	function updateUser($id)
	{
		    $register_date_time=date('Y-m-d H:i:s');
			$first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
			$email = $this->input->post('email');
			$contact_number=$this->input->post('contact_number');
			$user_type = $this->input->post('user_type');
			$dob= $this->input->post('dob');
			$gender = $this->input->post('gender');
			$user_image=$_FILES['user_image']['name'];
			//print_r($_FILES); exit;
			$config['upload_path']          = './uploads/user_images/student';
			$config['allowed_types']        = 'gif|jpg|png|GIF|JPG|PNG|JPEG';
			$config['max_size']             = 6096;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			$config['encrypt_name']			= TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('user_image');
			$user_image = $this->upload->data();
			$user_file=$user_image['file_name'];
			//print_r($user_file); exit;
			//user other details
            $parent_name=$this->input->post('parent_name');
			$mother_name=$this->input->post('mother_name');
			$occupation=$this->input->post('occupation');
            $father_contact=$this->input->post('father_contact');
			$alternate_contact=$this->input->post('alternate_contact');
			$father_email=$this->input->post('father_email');
			$religion=$this->input->post('religion');
			$nationality=$this->input->post('nationality');
			$address=$this->input->post('address');
			$country_id=$this->input->post('country_id');
			$state_id=$this->input->post('state_id');
			$zip_code=$this->input->post('zip_code');
			$parent_image=$_FILES['parent_image']['name'];
			//Academic Info
			$registration=$this->input->post('registration');
			$class_name=$this->input->post('class_name');
			$section_id=$this->input->post('section_id');
            $roll=$this->input->post('roll');
			$last_school=$this->input->post('last_school');
			$last_std=$this->input->post('last_std');
			$marks_obtained=$this->input->post('marks_obtained');
			$sports_id=$this->input->post('sports_id');
			
			
			$config['upload_path']          = './uploads/user_images/parent';
			$config['allowed_types']        = 'gif|jpg|png|GIF|JPG|PNG|JPEG';
			$config['max_size']             = 6096;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			$config['encrypt_name']			= TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('parent_image');
			$parent_image = $this->upload->data();
			$parent_file=$parent_image['file_name'];
			
			
			if(empty($user_file))
			{
				$save_file=$this->input->post('user_old_image');
			}
			else{
				$save_file=$user_file;
			}
			
			if(empty($parent_file))
			{
				$save_parent_file=$this->input->post('parent_old_image');
			}
			else{
				$save_parent_file=$parent_file;
			}
			
			$save['first_name']= $first_name;
			$save['last_name']= $last_name;
			$save['email']= $email;
			$save['contact_number']= $contact_number;
			$save['dob']= $dob;
			$save['gender']= $gender;
			$save['user_image']= $save_file;
			//print_r($save); exit;
			$data = $this->type_model->update_common_user_by_id($id,$save);
			
			$saved['parent_name']=$parent_name;
			$saved['mother_name']=$mother_name;
			$saved['occupation']=$occupation;
			$saved['father_contact']=$father_contact;
			$saved['alternate_contact']=$alternate_contact;
			$saved['father_email']=$father_email;
			$saved['religion']=$religion;
			$saved['nationality']=$nationality;
			$saved['address']=$address;
			$saved['country_id']=$country_id;
			$saved['state_id']=$state_id;
			$saved['zip_code']=$zip_code;
			$saved['parent_image']=$save_parent_file;
			$saved['registration']=$registration;
			$saved['class_name']=$class_name;
			$saved['section_id']=$section_id;
			$saved['roll']=$roll;
			$saved['last_school']=$last_school;
			$saved['last_std']=$last_std;
			$saved['sports_id']=$sports_id;
			//print_r($saved); exit;
			$data = $this->type_model->update_student_detail_by_id($id,$saved);
			$this->session->set_flashdata('message', 'Teacher updated successfully');
	        redirect('admin/listUser'); 
			
	}
	function updateTeacher($id)
	{
		//print_r($id); exit;
		    $register_date_time=date('Y-m-d H:i:s');
			
		    $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
			$email = $this->input->post('email');
			$contact_number=$this->input->post('contact_number');
			$user_type = $this->input->post('user_type');
			$dob= $this->input->post('dob');
			$gender = $this->input->post('gender');
			$user_image = $_FILES['user_image']['name'];
			
			$address_line1=$this->input->post('address_line1');
			$address_line2=$this->input->post('address_line2');
			$address_line3=$this->input->post('address_line3');
            $address_line4=$this->input->post('address_line4');
			$landline_number=$this->input->post('landline_number');
			$employee_id=$this->input->post('employee_id');
			$qualification=$this->input->post('qualification');
			$date_of_joining=$this->input->post('date_of_joining');
			$designation=$this->input->post('designation');
			$department=$this->input->post('department');
			$campus=$this->input->post('campus');
			$discipline_id=$this->input->post('discipline_id');
			
			
			$config['upload_path']          = './uploads/user_images/student';
			$config['allowed_types']        = 'gif|jpg|png|GIF|JPG|PNG|JPEG';
			$config['max_size']             = 6096;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			$config['encrypt_name']			= TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('user_image');
			$user_image = $this->upload->data();
			$user_file=$user_image['file_name'];
			if(empty($user_file))
			{
				$save_file=$this->input->post('user_old_image');
			}
			else{
				$save_file=$user_file;
			}
			$save['first_name']= $first_name;
			$save['last_name']= $last_name;
			$save['email']= $email;
			$save['contact_number']= $contact_number;
			$save['dob']= $dob;
			$save['gender']= $gender;
			$save['user_image']= $save_file;
			
			$data = $this->type_model->update_common_user_by_id($id,$save);
			$saved['address_line1']= $address_line1;
			$saved['address_line2']= $address_line2;
			$saved['address_line3']= $address_line3;
			$saved['address_line4']= $address_line4;
			$saved['landline_number']= $landline_number;
			$saved['employee_id']= $employee_id;
			$saved['qualification']= $qualification;
			$saved['date_of_joining']= $date_of_joining;
			$saved['designation']= $designation;
			$saved['department']= $department;
			$saved['campus']= $campus;
			$saved['discipline']= $discipline_id;
			//print_r($saved); exit;
			$data = $this->type_model->update_teacher_details_by_id($id,$saved);
		    $this->session->set_flashdata('message', 'Teacher updated successfully');
	        redirect('admin/listUser'); 
	}
	
	function studentStatus($id,$status)
	{    
	     $this->type_model->student_status($id,$status); 
		 $this->session->set_flashdata('message', 'Student status updated successfully');
	     redirect('admin/listUser');
	}
	function userDetails($id,$role_id)
	{
		   $data['page_title']="User Details";
	       $data['roles']=$this->type_model->get_role();
		   $data['countries']=$this->type_model->get_country();
		   $data['states']=$this->type_model->get_state();
		   $data['user_row']=$this->type_model->get_user_by_id($id,$role_id);
		   if($role_id=='1')  // student
		   {
		    $this->load->view('admin/detail_user_view',$data);
		   }
		    if($role_id=='2')  //teacher
		   {
			$data['disciplines'] = $this->Discipline_model->get_discipline(); 
			$data['campuses']=$this->type_model->get_campus();
		    $this->load->view('admin/detail_teacher_view',$data);
		   }
		   if($role_id=='3') //user
		   {
		    $this->load->view('admin/edit_user_view',$data);
		   }
	}
	
	//----------------  Download Discipline Excel ----------------------------//
      function downloadUserExcel()
	  {  

	     // echo "hello"; exit;
	  
	        $user_type=$this->input->post('user_type');
             if($user_type=='1')
	        {
		  $data['students'] = $this->Discipline_model->get_students_excel($user_type); 
	     // dd($data['students']);
		  if(!empty($this->input->post('userExcel')))
          {
			
           $finalExcelArr = array('First Name','Last Name','Email',' Contact No','Gender',' DOB','Parent Name','Mother Name',' Occupation',' Father Contact',' Alternate Contact','Father Email','Religion','Nationality','Address',' Country',' State',' Zip','Registration','Class','Section','Roll','Last School','Last STD',' Marks Obtained','Sports');
           $objPHPExcel = new PHPExcel();
           $objPHPExcel->setActiveSheetIndex(0);
           $objPHPExcel->getActiveSheet()->setTitle('Student Worksheet');
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

            foreach ($data['students'] as $key => $value) {
             
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $value->first_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $value->last_name);
			$objPHPExcel->getActiveSheet()->setCellValue($cols[2].$newvar, $value->email);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[3].$newvar, $value->contact_number);
			$objPHPExcel->getActiveSheet()->setCellValue($cols[4].$newvar, $value->gender);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[5].$newvar, $value->dob);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[6].$newvar, $value->parent_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->mother_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->occupation);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[9].$newvar, $value->father_contact);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[10].$newvar, $value->alternate_contact);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[11].$newvar, $value->father_email);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[12].$newvar, $value->religion);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[13].$newvar, $value->nationality);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[14].$newvar, $value->address);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[15].$newvar, $value->country_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[16].$newvar, $value->state_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[17].$newvar, $value->zip_code);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[18].$newvar, $value->registration);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[19].$newvar, $value->class_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[20].$newvar, $value->section_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[21].$newvar, $value->roll);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[22].$newvar, $value->last_school);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[23].$newvar, $value->last_std);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[24].$newvar, $value->marks_obtained);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[25].$newvar, $value->sports_id);
          
            }
          }

          $filename='Students.xls';
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          ob_start();  
          $objWriter->save('php://output');

         
          }
     
      }	  //end user type
	      
	     if($user_type=='2')  // teacher section 
	     {
		  $data['teachers'] = $this->Discipline_model->get_teacher_excel($user_type); 
	      // dd($data['students']);
		  if(!empty($this->input->post('userExcel')))
          {
			
           $finalExcelArr = array('First Name','Last Name','Email',' Contact No','Gender',' DOB','Address Line1','Address Line2',' Address Line3',' Address Line4','Landline No','Employment Id','Qualification','Date of Join','Designation',' Department','Campus',' Discipline');
           $objPHPExcel = new PHPExcel();
           $objPHPExcel->setActiveSheetIndex(0);
           $objPHPExcel->getActiveSheet()->setTitle('Student Worksheet');
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

            foreach ($data['teachers'] as $key => $value) {
             
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $value->first_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $value->last_name);
			$objPHPExcel->getActiveSheet()->setCellValue($cols[2].$newvar, $value->email);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[3].$newvar, $value->contact_number);
			$objPHPExcel->getActiveSheet()->setCellValue($cols[4].$newvar, $value->gender);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[5].$newvar, $value->dob);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[6].$newvar, $value->address_line1);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->address_line2);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->address_line3);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[9].$newvar, $value->address_line4);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[10].$newvar, $value->landline_number);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[11].$newvar, $value->employee_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[12].$newvar, $value->qualification);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[13].$newvar, $value->date_of_joining);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[14].$newvar, $value->designation);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[15].$newvar, $value->department);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[16].$newvar, $value->campus);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[17].$newvar, $value->discipline);
		}
          }

          $filename='Teachers.xls';
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          ob_start();  
          $objWriter->save('php://output');

         
          }
     
      }	  //end user type
	  
         
	     if($user_type=='3')  // users section 
	     {
		  $data['users'] = $this->Discipline_model->get_users_excel($user_type); 
	      // dd($data['students']);
		  if(!empty($this->input->post('userExcel')))
          {
			
           $finalExcelArr = array('First Name','Last Name','Email',' Contact No','Gender',' DOB','Address Line1','Address Line2',' Address Line3',' Address Line4','Landline No');
           $objPHPExcel = new PHPExcel();
           $objPHPExcel->setActiveSheetIndex(0);
           $objPHPExcel->getActiveSheet()->setTitle('Student Worksheet');
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

            foreach ($data['users'] as $key => $value) {
             
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $value->first_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $value->last_name);
			$objPHPExcel->getActiveSheet()->setCellValue($cols[2].$newvar, $value->email);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[3].$newvar, $value->contact_number);
			$objPHPExcel->getActiveSheet()->setCellValue($cols[4].$newvar, $value->gender);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[5].$newvar, $value->dob);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[6].$newvar, $value->address_line1);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->address_line2);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->address_line3);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[9].$newvar, $value->address_line4);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[10].$newvar, $value->landline_number);
            
		}
          }

          $filename='Users.xls';
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          ob_start();  
          $objWriter->save('php://output');

         
          }
     
      }	  //end user type

	  
	  }
	//==========++++++++++++++++++++++Upload Student Excel+++++++++++++++++++++++=========================//
	function addStudentExcel()
	{
		    $data['page_title']='Student Excel Upload';
			$data['excelErr']='';
			$this->load->view('admin/excel/student_upload_excel_view',$data);
	}
	
	function downloadStudentExcel()
	{
	      if(!empty($this->input->post('studentExcel')))
          {
			
           $finalExcelArr = array('First Name','Last Name','Email',' Contact No','Gender',' DOB','Parent Name','Mother Name',' Occupation',' Father Contact',' Alternate Contact','Father Email','Religion','Nationality','Address',' Country',' State',' Zip','Registration','Class','Section','Roll','Last School','Last STD',' Marks Obtained','Sports');
           $objPHPExcel = new PHPExcel();
           $objPHPExcel->setActiveSheetIndex(0);
           $objPHPExcel->getActiveSheet()->setTitle('Student Worksheet');
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

            foreach ($data['students'] as $key => $value) {
             
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $value->first_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $value->last_name);
			$objPHPExcel->getActiveSheet()->setCellValue($cols[2].$newvar, $value->email);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[3].$newvar, $value->contact_number);
			$objPHPExcel->getActiveSheet()->setCellValue($cols[4].$newvar, $value->gender);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[5].$newvar, $value->dob);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[6].$newvar, $value->parent_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->mother_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->occupation);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[9].$newvar, $value->father_contact);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[10].$newvar, $value->alternate_contact);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[11].$newvar, $value->father_email);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[12].$newvar, $value->religion);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[13].$newvar, $value->nationality);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[14].$newvar, $value->address);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[15].$newvar, $value->country_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[16].$newvar, $value->state_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[17].$newvar, $value->zip_code);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[18].$newvar, $value->registration);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[19].$newvar, $value->class_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[20].$newvar, $value->section_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[21].$newvar, $value->roll);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[22].$newvar, $value->last_school);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[23].$newvar, $value->last_std);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[24].$newvar, $value->marks_obtained);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[25].$newvar, $value->sports_id);
          
            }
          }

          $filename='student_upload.xls';
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		  if (ob_get_contents()) ob_end_clean();
         // ob_end_clean();
          ob_start();  
          $objWriter->save('php://output');
        }	
	}
	
	//==========++++++++++++++++++++++Upload Student Excel End+++++++++++++++++++++++=========================//
	//==============----upload User Images-------------=======================================================//
	function addImages()
	{
	  $data['page_title']='Add User Bulk Images';
	  if($this->input->post('submit')){
      $event_file =$_FILES['userfile']['name']; 
      foreach ( $event_file as $key =>  $value) {
         $tmp_name = $_FILES["userfile"]["tmp_name"][$key];
        // $time=time();
         $name = basename($event_file[$key]);
                 move_uploaded_file( $tmp_name ,"uploads/user_images/".$name);
    }
   $this->session->set_flashdata('message', 'Your data sucessfully saved.');
   redirect(base_url().'admin/addImages');
  }
  $this->load->view('admin/add_bulk_user_images_view',$data);
	}
	//==============----upload User Images End-------------=======================================================//
	



}
?>