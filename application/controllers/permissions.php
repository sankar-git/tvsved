<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permissions extends CI_Controller {
	
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
		 
		 
		
		 $this->load->model('type_model');
		 

			if($this->session->userdata('sms'))
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
			}
	}

	public function index()
	{
	    echo "hello"; exit;
		$data['roles']=$this->common_model->selectAll('role');
		$data['pages']=$this->common_model->SelectData('','','tblpage','','','','page_name','ASC');
		$data['title']="Admin Permission";
		$this->load->view('admin/helper/header');
		$this->load->view('admin/permission_view',$data);
		$this->load->view('admin/template/admin_footer');
	}
    function addPermission()
	{
		$data['page_title']="Add Permission";
		$data['roles']=$this->type_model->get_role();
		$data['pages']=$this->type_model->get_page();
		//print_r($data['page_list']); exit;
		$this->load->view('admin/permission_add_view',$data);
	}
	function savePermissions()
	 {	
		 $role_id = $this->input->post('role_id');
		 $user_id = $this->input->post('user_id'); 
		 
		 $permission_page = $this->input->post('permission_page');
		 $this->type_model->delete_data('permission','user_id',$user_id ); //delete old permissions
			 
		 for($i=0;$i<count($permission_page);$i++){
				$permission=$permission_page[$i];
				$data=array(
				    'role_id'=>$role_id,
					'user_id'=>$user_id,
					'page_id'=>$permission
					
					);
					
				$this->type_model->save_permissions($data,'permission');
			}
		$this->session->set_flashdata('message', 'Permissions saved successfully');
		redirect('permissions/addPermission','refresh');
	 }
	
	function getUserByRole()
	{
		$role_id = $this->input->post('role_id');
		//print_r($role_id); exit;
		$data['roles']= $this->type_model->get_user_by_role($role_id);
		//echo  $data['roles']; exit;
		 $str = '';
         foreach($data['roles'] as $k=>$v){   
          $str .= "<option value=".$v->id.">".$v->first_name.' '.$v->last_name."</option>";
           }
           echo $str;
    }
	 function permitted_pages_view()
	 {
		$userid=$this->input->post('userid'); 
		//$roleid=$this->input->post('roleid');
		//print_r($userid); exit;
		$permited_page=$this->type_model->getPermitedPages($userid);
		//print_r($permited_page); exit;
		echo json_encode(array("permited_page" => $permited_page)) ;
	 }
}
?>