<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller
{
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
			$this->load->library('image_lib');
		    $this->load->model('common_model');
			$this->load->library('salary_payment_lib');
			
	}

	public function index()
	{
		Echo "Welcome to FrontEnd";
	}

	public function login()
	{
		$this->load->view('front/template/header');
		$this->load->view('front/login_view');
		$this->load->view('front/template/footer');
	}

	public function city_ajax($id)
	{
		$data['s'] = $this->common_model->city($id);
		$this->load->view('front/cityajax',$data);
	}

	public function sign_up()
	{
		@$data['class']= $this->common_model->getAllClasses();
		@$data['state'] = $this->common_model->get_state();
		//print_r($data);
		$this->load->view('front/template/header');
		$this->load->view('front/sign_up',$data);
		$this->load->view('front/template/footer');
	}

	public function st_dashboard()
	{
		//echo $student_id = $this->input->post('sess_student_id');
		//print_r($data['st_detail']=$this->common_model->getAlldata('tbl_student','student_id',$student_id));
		$this->load->view('front/template/header');
		$this->load->view('front/student_dashboard');
		$this->load->view('front/template/footer');

	}

	public function st_chg_pwd()
	{
		
		$this->load->view('front/template/header');
		$this->load->view('front/student_change_password');
		$this->load->view('front/template/footer');

	}

	public function fee_structure()
	{
		echo $this->input->post('st_id');
		$this->load->view('front/template/header');
		$this->load->view('front/student_fee');
		$this->load->view('front/template/footer');

	}

	public function student_result()
	{
		$this->load->view('front/template/header');
		$this->load->view('front/student_result');
		$this->load->view('front/template/footer');
	}

	public function student_att()
	{
		$this->load->view('front/template/header');
		$this->load->view('front/student_att');
		$this->load->view('front/template/footer');
	}

	public function student_graph()
	{
		$data['st_id'] = $this->session->userdata('partha');
		$student_id = $data['st_id'][0]->student_id;
		$st_result_data = $this->common_model->edit_subject_payment_details_model('tbl_test_result','student_id',$student_id);


		$this->db->select('tbl_test_result.*,tbl_add_test.*');
		$this->db->from('tbl_test_result');
		$this->db->join('tbl_add_test','tbl_add_test.test_id = tbl_test_result.test_id','left');

		for($i=0;$i<count(array_filter($st_result_data));$i++)
		{
			$test_id	=	$st_result_data[$i]->test_id;
			$where = '(tbl_test_result.student_id='.$student_id.' and tbl_test_result.test_id = '.$test_id.')';
			$this->db->or_where($where);
			//$this->db->where('tbl_test_result.test_id',$test_id);
		}
		//$this->db->where('tbl_test_result.test_id','1');
		$query = $this->db->get();
//echo $this->db->last_query();
		$result=$query->result();
		//print_r($result);
		//exit;
		$data['sub'] = $result;

		@$test_list	=	$this->common_model->common($table_name='tbl_test_result',$field=array(), $where=array('student_id'=>$student_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());
		for($i=0;$i<count(array_filter($test_list));$i++)
		{
			$test_id	=	$test_list[$i]->test_id;
			$values []= $this->common_model->common($table_name='tbl_add_test',$field=array(), $where=array('test_id'=>$test_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());

		}
		foreach ($values as &$value) $value = $value[0];
		@$data['test_detail'] = $values;
		$this->load->view('front/template/header');
		$this->load->view('front/student_graph',$data);
		$this->load->view('front/template/footer');
	}

	public function change_profile_pic()
	{
		$this->load->view('front/template/header');
		$this->load->view('front/change_st_pro_pic');
		$this->load->view('front/template/footer');
	
	}

	public function my_account()
	{ 
		if($this->session->userdata('teacherbolpurschool'))
		{
			$this->load->library('year_month_lib');
			$data['year']=$this->year_month_lib->yeardropdown();
			$this->load->library('salary_payment_lib');
			$userid='';
			$role_id=3;
			$month=1;
			$lastmonth=12;
			$data['crnt_year']=(int)date('Y');
			if(isset($_POST['year']))
			{
				 $data['crnt_year']=$_POST['year'];
			}

			$data['fromdatabase']=$this->session->userdata('teacherbolpurschool');
			if(isset($data['fromdatabase'][0]->id))
			{
				$userid=$data['fromdatabase'][0]->id;
			}
			
			$data['name']='';
			$data['registration_no']='';
			$data['class_fees']=0;			
			$name=$this->salary_payment_lib->studentlist($userid,$month,$data['crnt_year']);				
			if(isset($name[0]))
			{
				$data['name']=$name[0]->first_name.' '.$name[0]->last_name;
				$data['registration_no']=$userid;
				$data['class_fees']=$name[0]->salary;
			}				
			$data['user_list']=$this->salary_payment_lib->user_paymentlist($data['name'],$userid,$month,$lastmonth,$data['crnt_year'],'',$role_id,$data['class_fees']);
			//echo "<pre>"; print_r($data['user_list']);exit;
			$this->load->view('front/template/header');
			$this->load->view('front/my_account_view',$data);
			$this->load->view('front/template/footer');
		}
		else
		{
			redirect('home/login', 'refresh');
		}
	
	}

	public function insert_student_data()
	{
		$first_name 						= 	$this->input->post('first_name');
		$last_name 							= 	$this->input->post('last_name');
		$email 								= 	$this->input->post('email');		
		$student_mobile_number 				= 	$this->input->post('student_mobile_number');		
		
		$stream 							= 	$this->input->post('stream');
		$gender 							= 	$this->input->post('gender');
		$category 							= 	$this->input->post('category');
		$dob 								= 	$this->input->post('dob');		
		$addmission_class 					= 	$this->input->post('addmission_class');

		$school_name 						= 	$this->input->post('school_name');
		$school_timing 						= 	$this->input->post('school_timing');
		$week_day 							=	$this->input->post('week_day');
		$board 								= 	$this->input->post('board');		
		$total_marks 						= 	$this->input->post('total_marks');
		$math_marks 						= 	$this->input->post('math_marks');
		$phy_marks 							= 	$this->input->post('phy_marks');
		$che_marks							= 	$this->input->post('che_marks');
		$bio_marks 							= 	$this->input->post('bio_marks');
		$science_marks 						= 	$this->input->post('science_marks');
		$school_address 					= 	$this->input->post('school_address');

		$father_name 						= 	$this->input->post('father_name');
		$father_occupation 					= 	$this->input->post('father_occupation');
		$mother_name 						= 	$this->input->post('mother_name');		
		$mother_occupation 					= 	$this->input->post('mother_occupation');
		$parent_number 						= 	$this->input->post('parent_number');
		$guardian_mobile_no 				= 	$this->input->post('guardian_mobile_no');
		
		$address1 							= 	$this->input->post('address1');
		$address2 							= 	$this->input->post('address2');
		$state_name 						= 	$this->input->post('state');
		$city 								= 	$this->input->post('city');
		$pincode 							= 	$this->input->post('pincode');
		$home_number 						= 	$this->input->post('home_number');
		$last_logon_time	 				= 	date('Y-m-d H:i:s');		
		
		
		$user_name							=	$first_name.substr($student_mobile_number,6);
		//$password 							=	rand(000AAAaaa,999ZZZzzz);
		$data = array(
						'username' 					=> 	$user_name,
						'password' 					=> 	$student_mobile_number, 
						'first_name' 				=>	$first_name,
						'last_name' 				=>	$last_name,
						'student_email' 			=>	$email,
						'student_phone_no' 			=> 	$student_mobile_number,
						'gender' 					=>	$gender,
						'stream'					=>	$stream,
						'category' 					=> 	$category,
						'dob' 						=>	date('Y-m-d',strtotime($dob)),
						'addmission_class' 			=>	$addmission_class,
						//'studying' => ,
						'school_name' 				=>	$school_name,
						'school_timing' 			=>	$school_timing,
						'school_weekoff_day	' 		=>	$week_day,
						'board' 					=> 	$board,
						'total_marks' 				=>	$total_marks,
						'che_marks' 				=>	$che_marks,
						'math_marks' 				=>	$math_marks,
						'bio_marks' 				=> 	$bio_marks,
						'phy_marks' 				=> 	$phy_marks,
						'science_marks' 			=>	$science_marks,
						'school_address' 			=>	$school_address,
						'father_name' 				=>	$father_name,
						'father_occupation' 		=>	$father_occupation,
						'mother_name' 				=>	$mother_name,
						'mother_occupation' 		=> 	$mother_occupation,
						'guardian_mobile_no' 		=> 	$guardian_mobile_no,
						'guardian_phone_no' 		=>	$parent_number,
						'address1' 					=> 	$address1,
						'address2' 					=>	$address2,
						'state' 					=>	$state_name,
						'city' 						=>	$city,
						'pincode' 					=>	$pincode,
						'landline_no' 				=> 	$home_number,
						'last_logon_time' 			=>	$last_logon_time ,
					  );
						//print_r($data);
						$this->common_model->insert_data($data,'tbl_student');
						$id = $this->db->insert_id();

			foreach($_FILES['profile_pic']['tmp_name'] as $key => $value )
			{

			$file_name[] = $key.$_FILES['profile_pic']['name'][$key];
   			$file=$key.$_FILES['profile_pic']['name'][$key]; 
  			$file_size =$_FILES['profile_pic']['size'][$key];
			$file_tmp =$_FILES['profile_pic']['tmp_name'][$key];
			$file_type=$_FILES['profile_pic']['type'][$key];
	 		$new_name1 = str_replace(".","",microtime());
			$new_name=str_replace(" ","_",$new_name1);
	 		$ext=substr(strrchr($file,'.'),1);
			if($ext=="jpeg" || $ext=="jpg" || $ext=="png" || $ext=="gif")
			{	 
				move_uploaded_file($file_tmp,"uploads/profile_image".$new_name.".".$ext);	
				if(($_FILES['profile_pic']['name'][$key]))	
				{		
					$original_image_file_name =$new_name.".".$ext;
					$jobseeker_id=$this->session->userdata('jobseeker_id');
					$doc_data=array(
										"student_id"=>$id,
										"img_name"=>$new_name.".".$ext,
										//"upload_date"=>date("Y-m-d"),
									);				
		  			$this->common_model->insert_data($doc_data,'student_profile_image');
				}		
				else
				{
					$this->session->set_flashdata("message","Field Is Missing !");
					//redirect('index.php/user_management/doctor_list');
				}
			}
			else
			{
				$this->session->set_flashdata("message","Only .jpeg, .jpg, .gif, .png File Supported !Field Is Missing !");
				//redirect('index.php/user_management/doctor_list');
			}
		}					

		




		foreach($_FILES['mark_sheet']['tmp_name'] as $key => $value )
		{

			$file_name[] = $key.$_FILES['mark_sheet']['name'][$key];
   			$file=$key.$_FILES['mark_sheet']['name'][$key]; 
  			$file_size =$_FILES['mark_sheet']['size'][$key];
			$file_tmp =$_FILES['mark_sheet']['tmp_name'][$key];
			$file_type=$_FILES['mark_sheet']['type'][$key];
	 		$new_name1 = str_replace(".","",microtime());
			$new_name=str_replace(" ","_",$new_name1);
	 		$ext=substr(strrchr($file,'.'),1);
			if($ext=="jpeg" || $ext=="jpg" || $ext=="png" || $ext=="gif")
			{	 
				move_uploaded_file($file_tmp,"uploads/".$new_name.".".$ext);	
				if(($_FILES['mark_sheet']['name'][$key]))	
				{		
					$original_image_file_name =$new_name.".".$ext;
					$jobseeker_id=$this->session->userdata('jobseeker_id');
					$doc_data=array(
										"student_id"=>$id,
										"marks_sheet_name"=>$new_name.".".$ext,
										//"upload_date"=>date("Y-m-d"),
									);				
		  			$this->common_model->insert_data($doc_data,'mark_sheet_image');
				}		
				else
				{
					$this->session->set_flashdata("message","Field Is Missing !");
					//redirect('index.php/user_management/doctor_list');
				}
			}
			else
			{
				$this->session->set_flashdata("message","Only .jpeg, .jpg, .gif, .png File Supported !Field Is Missing !");
				//redirect('index.php/user_management/doctor_list');
			}
		}

		redirect('home');
	}
	
	
	
	public function user_login()
	 {
		 $user_data = array(
				 'username'=> $this->input-> post('username'),
				 'password' => $this->input-> post('password'),
				 'studying' => 'studying'
					);
					
		$data_fromdatabase=$this->common_model->selectWhere('tbl_student', $user_data) ;
		if(count($data_fromdatabase)>0)
		{		//print_r($data_fromdatabase)	;
			$this->session->set_userdata('partha',$data_fromdatabase);
			//print_r($this->session->userdata('partha'));exit;

			redirect('home/st_dashboard','refresh');
		}
		else
		{
			redirect('home/login','refresh');
		}
	
 }


	public function student_change_password()
	{
		//$user_id = $this->session->userdata('session_user_id');
		//echo $user_id;	
		$user_id = $this->input->post('st_id');
		$oldPass = $this->input->post('old');
		$newPass = $this->input->post('pwd');
		$retypePass = $this->input->post('repwd');
		//$oldPass = $this->input->post("txtOldpass");
		//$newPass = $this->input->post("txtNewpass");
		//$retypePass = $this->input->post("txtRetypepass");
				
		$data = $this->common_model->selectOne('tbl_student','student_id',$user_id);
		$database_pass= $data[0]->password;
		$dpass=$database_pass;
		//echo $dpass;
		
		$new_Pass = array(
				'password'=>$newPass);
	
		if($dpass!=$oldPass)
		{
			 echo "Old Password Is Worng";
		}
		else
		{
			if($newPass=="")
			{
				echo "New Password Is Not Blank";
			}
			else if($oldPass==$newPass)
			{
				echo "Not Same Old Password";
			}			
			else if($newPass==$retypePass)
			{
				$this->common_model->update_data($new_Pass,'tbl_student','student_id',$user_id);	
				echo "Password Updated";
				$this->session->sess_destroy();
				echo "<script>window.open('home/login','_self')</script>";					
			}
			else
			{
				echo "Retype Password Not Matched";
			}
		}
	}
		
		
	

	function student_change_profile_pic()
{
	$student_id = $this->input->post('student_id');
	//echo $student_id;exit;
	foreach($_FILES['profile_pic']['tmp_name'] as $key => $value )
		{
			$file_name[] = $key.$_FILES['profile_pic']['name'][$key];
			$file=$key.$_FILES['profile_pic']['name'][$key];
			$file_size =$_FILES['profile_pic']['size'][$key];
			$file_tmp =$_FILES['profile_pic']['tmp_name'][$key];
			$file_type=$_FILES['profile_pic']['type'][$key];
			$new_name1 = str_replace(".","",microtime());
			$new_name=str_replace(" ","_",$new_name1);
			$ext=substr(strrchr($file,'.'),1);
			if($ext=="jpeg" || $ext=="jpg" || $ext=="png" || $ext=="gif")
			{
				move_uploaded_file($file_tmp,"uploads/profile_image/".$new_name.".".$ext);
				if(($_FILES['profile_pic']['name'][$key]))
				{
					$original_image_file_name =$new_name.".".$ext;
					$jobseeker_id=$this->session->userdata('jobseeker_id');
					$data=array(
						"student_id"=>$student_id,
						"img_name"=>$new_name.".".$ext,
						//"upload_date"=>date("Y-m-d"),
					);
					$this->common_model->update_data($data,'student_profile_image','student_id',$student_id);
					redirect('home/change_profile_pic');

				}
				else
				{
					$this->session->set_flashdata("message","Field Is Missing !");
					//redirect('index.php/user_management/doctor_list');
				}
			}
			else
			{
				$this->session->set_flashdata("message","Only .jpeg, .jpg, .gif, .png File Supported !Field Is Missing !");
				//redirect('index.php/user_management/doctor_list');
			}
		}
}

 
	function logout()
 {
	
	if($this->session->userdata('partha') )
	{
		$this->session->unset_userdata('partha');
		//$this->session->set_flashdata('logoutmsg','<span style="color:red">Successfully logged out.</span>');
		redirect('home/login', 'refresh');
	}else{
		//$this->session->set_flashdata('logoutmsg','<span style="color:red">Session is not cleared.</span>');
		redirect('home/login', 'refresh');
	}
	
 }
	
	function invoice_print()
	{
		$invoice=$this->uri->segment(3); 
		if($invoice!='')
		{
			$data=$this->invoicedata($invoice);
		
		$this->load->view('front/voucher',$data);
		}else{
			$data['path']= $this->session->userdata('inv_path');
			redirect($data['path']);
		}
	}
	
	function invoicedata($invoice)
	{
		$roleid='';	
			$data['invoice_data']=$this->common_model->selectWhere('payment','invoice_no = '.$invoice);
			foreach($data['invoice_data'] as $row)
			{
				$roleid=$row->role_id;								
			}
									
			if($roleid==3)
			{
				foreach($data['invoice_data'] as $row)
				{
					$row->salaryamount=0;
					$salary=$this->salary_payment_lib->studentlist($row->user_id,$row->paid_month,$row->paid_year);
					if(isset($salary[0]->salary))
					{
						$row->salaryamount=$salary[0]->salary;
						$row->name=$salary[0]->first_name;
						if($salary[0]->middle_name!='')
						{
							$row->name.=' '.$salary[0]->middle_name;
						}
						$row->name.=' '.$salary[0]->last_name;
						
					}
					$paid_permonth=$this->salary_payment_lib->paid_permonth($row->user_id,$row->paid_month,$row->paid_year,$row->role_id);
					foreach($paid_permonth as $rowy)
					{
						$row->paid=$rowy->paid;					
					}	
					
					$row->totconcession=$this->salary_payment_lib->concession_per_user($row->user_id,$row->paid_month,$row->paid_year,'');
					$row->totspecialfees=$this->salary_payment_lib->charge_per_user($row->user_id,$row->paid_month,$row->paid_year,'');
					
					$totfees=($row->salaryamount + $row->totspecialfees ) - $row->totconcession ;
					
					$row->totfees=$totfees;
					$row->due=$totfees-$row->paid;
					$row->nowdue=number_format(($row->due),2);
					$row->concession_arr=array();
					$row->specialfees_arr=array();
					$concession_arr=$this->salary_payment_lib->concession_per_user($row->user_id,$row->paid_month,$row->paid_year,'data');
					if(count($concession_arr)>0)
					{
						$row->concession_arr=$concession_arr;
					}
					$specialfees_arr=$this->salary_payment_lib->charge_per_user($row->user_id,$row->paid_month,$row->paid_year,'data');
					if(count($specialfees_arr)>0)
					{
						$row->specialfees_arr=$specialfees_arr;
					}
				}				
			}			
			return $data;
	}

	function edit_student_data()
	{
		$student_id							=	$this->input->post('student_id');
		//exit;

		$first_name 						= 	$this->input->post('first_name');
		$last_name 							= 	$this->input->post('last_name');
		$email 								= 	$this->input->post('email');
		$student_mobile_number 				= 	$this->input->post('student_mobile_number');

		$stream 							= 	$this->input->post('stream');
		$gender 							= 	$this->input->post('gender');
		$category 							= 	$this->input->post('category');
		$dob 								= 	$this->input->post('dob');
		$addmission_class 					= 	$this->input->post('addmission_class');

		$school_name 						= 	$this->input->post('school_name');
		$school_timing 						= 	$this->input->post('school_timing');
		$week_day 							=	$this->input->post('week_day');
		$board 								= 	$this->input->post('board');
		$total_marks 						= 	$this->input->post('total_marks');
		$math_marks 						= 	$this->input->post('math_marks');
		$phy_marks 							= 	$this->input->post('phy_marks');
		$che_marks							= 	$this->input->post('che_marks');
		$bio_marks 							= 	$this->input->post('bio_marks');
		$science_marks 						= 	$this->input->post('science_marks');
		$school_address 					= 	$this->input->post('school_address');

		$father_name 						= 	$this->input->post('father_name');
		$father_occupation 					= 	$this->input->post('father_occupation');
		$mother_name 						= 	$this->input->post('mother_name');
		$mother_occupation 					= 	$this->input->post('mother_occupation');
		$parent_number 						= 	$this->input->post('parent_number');
		$guardian_mobile_no 				= 	$this->input->post('guardian_mobile_no');

		$address1 							= 	$this->input->post('address1');
		$address2 							= 	$this->input->post('address2');
		$state_name 						= 	$this->input->post('state');
		$city 								= 	$this->input->post('city');
		$pincode 							= 	$this->input->post('pincode');
		$home_number 						= 	$this->input->post('home_number');

		$data = array(
			'first_name' 				=>	$first_name,
			'last_name' 				=>	$last_name,
			'student_email' 			=>	$email,
			'student_phone_no' 			=> 	$student_mobile_number,
			'gender' 					=>	$gender,
			'stream'					=>	$stream,
			'category' 					=> 	$category,
			'dob' 						=>	date('Y-m-d',strtotime($dob)),
			'addmission_class' 			=>	$addmission_class,
			'school_name' 				=>	$school_name,
			'school_timing' 			=>	$school_timing,
			'school_weekoff_day	' 		=>	$week_day,
			'board' 					=> 	$board,
			'total_marks' 				=>	$total_marks,
			'che_marks' 				=>	$che_marks,
			'math_marks' 				=>	$math_marks,
			'bio_marks' 				=> 	$bio_marks,
			'phy_marks' 				=> 	$phy_marks,
			'science_marks' 			=>	$science_marks,
			'school_address' 			=>	$school_address,
			'father_name' 				=>	$father_name,
			'father_occupation' 		=>	$father_occupation,
			'mother_name' 				=>	$mother_name,
			'mother_occupation' 		=> 	$mother_occupation,
			'guardian_mobile_no' 		=> 	$guardian_mobile_no,
			'guardian_phone_no' 		=>	$parent_number,
			'address1' 					=> 	$address1,
			'address2' 					=>	$address2,
			'state' 					=>	$state_name,
			'city' 						=>	$city,
			'pincode' 					=>	$pincode,
			'landline_no' 				=> 	$home_number,
			'studying' 					=>	'studying',

		);
		//print_r($data);
		$this->common_model->update_data($data,'tbl_student','student_id',$student_id);
		//echo $this->db->last_query();
		redirect('home/st_dashboard');

	}

	public function student_result_graph()
	{
		$id = $this->input->post('student_id');
		@$test_list	=	$this->common_model->common($table_name='tbl_test_result',$field=array(), $where=array('student_id'=>$id),$where_or=array(),$like=array(),$like_or=array(),$order=array());
		for($i=0;$i<count(array_filter($test_list));$i++)
		{
			$test_id	=	$test_list[$i]->test_id;
			$values []= $this->common_model->common($table_name='tbl_add_test',$field=array(), $where=array('test_id'=>$test_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());

		}
		foreach ($values as &$value) $value = $value[0];
		@$data['test_detail'] = $values;
		$data['st_id']	=	$id;

		$this->load->view('admin/template/admin_header');
		$this->load->view('admin/template/admin_leftmenu');
		$this->load->view('admin/graph_result_view',$data);
		$this->load->view('admin/template/admin_footer');
	}

	function view_result_perform()
	{
		$test_id    =  $this->input->post('test_name');
		if(!empty($test_id))
		{
			$imp_test   =   implode(',',$test_id );
			$exp_test   =   explode(',',$imp_test );
		}
		$st_marks   =   $this->input->post('student_marks');
		$student_id =   $this->input->post('student_id');

		$this->db->select('tbl_test_result.*,tbl_add_test.*');
		$this->db->from('tbl_test_result');
		$this->db->join('tbl_add_test','tbl_add_test.test_id = tbl_test_result.test_id','left');

		for ($j=0;$j<count(array_filter($exp_test));$j++)
		{
			$where = '(tbl_test_result.student_id='.$student_id.' and tbl_test_result.test_id = '.$exp_test[$j].')';
			$this->db->or_where($where);
		}
		$query = $this->db->get();
		$result=$query->result();
		$data   =   array(
			'st_marks'=>$st_marks,
		);
		$data['sub'] = $result;
		$this->load->view('front/template/header');
		$this->load->view('front/result_graph_view',$data);
		//$this->load->view('front/template/footer');



	}
	
		
	
	
	
}
	?>