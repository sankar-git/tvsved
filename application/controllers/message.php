<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Message extends CI_Controller {
	
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
		 $this->load->model('Message_model');
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
		
		$data['max_id']	= 	$this->common_model->max_id('tbl_student','student_id');

		$this->load->view('admin/template/admin_header');
		$this->load->view('admin/template/admin_leftmenu');
		$this->load->view('admin/addstudent_view',$data);
		$this->load->view('admin/template/admin_footer');	
	}
	function sendSms()
	{
		$data['page_title']="Send Message";
        $data['roles']     =     $this->Message_model->get_user_roles();
		$this->load->view('admin/message/add_message_view',$data);
	}
	function sendMessage()
	{
		//p($_POST); exit;
		$sessdata= $this->session->userdata('sms');
		$sender_by = $sessdata[0]->id;
		$first_name = $sessdata[0]->first_name;
		$last_name = $sessdata[0]->last_name;
		$sender_name=$first_name.' '.$last_name;
		$user_type =$this->input->post('user_type');
		$userlist = $this->input->post('userlist');
		//p($userlist); exit;
		$message  =   $this->input->post('message');
		//p($userlist); exit;
		foreach($userlist as $user_id){
			$userdetails=$this->Message_model->get_user_details($user_id);
			//p($userdetails); exit;
			$date= date('Y-m-d');
	        $time = date('H:i:s');
			$id=$userdetails['id'];
			$role_id=$userdetails['role_id'];
			$name=$userdetails['first_name'];
			$mobile_no=$userdetails['contact_number'];
			
			//p($mobile_no);
			send_sms($message,$mobile_no);
			
			$save['user_id']=$id;
			$save['name']=$name;
			$save['mobile']=$mobile_no;
			$save['send_to']=$role_id;
			$save['send_by']=$sender_by;
			$save['sender_name']=$sender_name;
			$save['message']=$message;
			$save['date']=$date;
			$save['time']=$time;
			//p($save); exit;
			$this->Message_model->save_send_message($save);
			
		} 
		$this->session->set_flashdata('message', 'Message send successfully');
	    redirect('message/sendSms');
    
	}
	
	
	function send_sms($sms,$phone)
    {
		$urll = urlencode($sms); 
		//$msgSentUrl = "http://api.msg91.com/api/sendhttp.php?sender=onebus&route=4&mobiles=".$phone."&country=91&authkey=111566AKQz11XM8N5743ff3a&message=".$urll;
		$msgSentUrl = "http://bulksms.justclicksky.com/sendSMS?username=vedang&message=XXXXXXXXXX&sendername=XYZ&smstype=TRANS&numbers=<mobile_numbers>&apikey=78351e33-ba59-4c67-9a13-7b6d35837e49";
		
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => $msgSentUrl,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
        return true;
    }
	function getUsers()
	{
 		$userType=$this->input->post('userType');
		//p($userType); exit;
		$roles=explode(',',$userType);
		//p($roles); exit;
		 $data['activeusers']=$this->Message_model->get_type_user($roles);// sending type roles 
         
		$otpGrpArr=array();
		$dataval='';
		foreach($roles as $role)
		{
			$dataVal=$this->Message_model->get_user_role_name($role);
		    //p($dataVal->role_name); exit;	
			array_push($otpGrpArr,$dataVal->id);
		}
		//p($otpGrpArr); exit;
		$str = '';
		$optname='';
		foreach($otpGrpArr as $row){
			if($row=='1'){$optname='Student';}
			if($row=='2'){$optname='Teacher';}
			if($row=='3'){$optname='User';}
			if($row=='4'){$optname='Subadmin';}
			if($row=='7'){$optname='Faculty Admin(HOD)';}
			if($row=='8'){$optname='Junior Admin';}
			$str .= '<optgroup label="'.$optname.'">';		
		foreach($data['activeusers'] as $k=>$v){ 
				    if($row==$v->role_id){
					$str .= '<option value="'.$v->id.'">"'.$v->first_name.'"</option>';
					}
					
			} 
		}
	  echo $str .= '</optgroup>';
	}
	function getUsersold()
	{
		$userType=$this->input->post('userType');
		//p($userType); exit;
		$data['activeusers']=$this->Message_model->get_active_user_list($userType);// sending userType as user Role
		//p($data['activeusers']); exit;
		 $str = '';
         foreach($data['activeusers'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->first_name."</option>";
         }
		echo $str;
	}
	
	function listMessages()
	{
		$data['page_title']="Sended Messages";
		$data['sended_message']=$this->Message_model->get_sended_message();
		$this->load->view('admin/message/sended_message_list',$data);
	}
	function deleteMessage($id)
	{
		$data=$this->Message_model->delete_message($id);
		if(!empty($data))
		{
			$this->session->set_flashdata('message', 'Message deleted successfully');
			redirect('message/listMessages');
		}
		else
		{
			$this->session->set_flashdata('message', 'Message not deleted successfully');
			redirect('message/listMessages');
		}
	}
	function feeAlert()
	{
		$data['page_title']="Send Message Alert";
		$data['campuses'] = $this->Discipline_model->get_campus();
        $this->load->view('admin/message/fee_due_message_view',$data);
	}
	function getUsersByCampus()
	{
		$campus_id = $this->input->post('campus_id');
		$data['activeusers']=$this->Message_model->get_users_by_campus_id($campus_id);// sending userType 
		//p($data['activeusers']); exit;
		$str = '';
        foreach($data['activeusers'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->first_name."</option>";
         }
		echo $str;
	}
	
	
	
}
?>