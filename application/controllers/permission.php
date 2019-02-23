<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permission extends CI_Controller {
	
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
			$this->load->helper('email');
			
			
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
				if($this->user_role!=1)
				{
					$this->load->library('permission_lib');
					$this->permission_lib->permit($this->user_id,$this->user_role);
				}
			}
			else
			{
				redirect('authenticate', 'refresh');
			}
	}
	
	public function index1()
	{
		echo "hello"; exit;
		$data['roles']=$this->common_model->selectAll('role');
		$data['pages']=$this->common_model->SelectData('','','tblpage','','','','page_name','ASC');
		$data['title']="Admin Permission";
		$this->load->view('admin/helper/header');
		$this->load->view('admin/permission_view',$data);
		$this->load->view('admin/template/admin_footer');
	}
	
	function permission_role_user(){
		$role_id = trim($this->input->post('id'));				
		$user_list=$this->common_model->get_user_list_view($role_id);	
		//echo "<pre>";print_r($edit_user);exit;
		
		echo json_encode(array("user_list" => $user_list)) ;
	}
	function add_permission()
	 {	
		 $user_id = $this->input->post('subadmin');
		  
		 $permission_page = $this->input->post('permission_page');
		//print_r($permission_page); exit;	 	
		 $role_id=$this->common_model->single_value('user','role_id','id = '.$user_id); 
		  
		$this->common_model->delete_data('permission','user_id',$user_id );
			 
		 for($i=0;$i<count($permission_page);$i++){
				$permission=$permission_page[$i];
				$data=array(
				    'role_id'=>$role_id,
					'user_id'=>$user_id,
					'page_id'=>$permission
					
					);
					//echo "<pre>";print_r($data);exit();
				$this->common_model->insert_data($data,'permission');
			}
		redirect('permission','refresh');
	 }
	 
	 function permitted_pages_view()
	 {
		$userid=$this->input->post('userid'); 
		$roleid=$this->input->post('roleid');
		$permited_page=$this->common_model->getPermitedPages($userid,$roleid);
		echo json_encode(array("permited_page" => $permited_page)) ;
	 }
	function addPermission()
	{
		echo "Hello"; exit;
	}
	
	
	
	
	
}
	?>