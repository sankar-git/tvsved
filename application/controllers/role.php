<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Role extends CI_Controller {
	
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
		  $this->load->model('Generate_model');
		  $this->load->model('type_model');
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
	function assignrole()
	{
		$session_data = $this->session->userdata('sms');
        $loginid = $session_data[0]->id;
		$data['page_title']="Role Management";
		$data['roles']=$this->type_model->get_role();
		$data['mainmenu']=$this->type_model->get_menu();
		
		
		
		$this->load->view('admin/role/roll_assign_add_view',$data);
	}
	function saveMenu()
	{    
	     $session_data = $this->session->userdata('sms');
         $loginid = $session_data[0]->id;
		 $empid = $this->input->post('user_id');
		 $role_id = $this->input->post('role_id');
		 
		 if(!empty($this->input->post('menu')))
			{
			  foreach ($this->input->post('menu') as $key => $value) 
			  { 
				$menu=explode('#', $value);
				for($i=0;$i<count($empid);$i++)
				{
				$save = array( 'emp_id'=>$empid[$i],
									'main_menu'=>$menu[0],
									'sub_menu'=>$menu[1],
									'role_id'=>$role_id
									);
				//p($save);
				$data=$this->type_model->save_user_menu($save);
				}
				
			  } //exit;
			  $msg='Your information was successfully saved.';
			}
        else
        {
            $msg='Please atleast one menu checked!!';
        }
		
		$this->session->set_flashdata('message', 'Your Information successfully saved');
	    redirect('role/assignrole');
	}
	
	public function getassignmenu(){
	$empid = $this->input->post('user_id');
	//p($empid); exit;
	$vieww = $this->type_model->get_assigned_menu($empid);
	$mainmenu = $this->type_model->get_menu();


	$str = ''; 
	$ma='';
	$masu='';
	foreach ($vieww as $key => $v)   
	{ 
	$ma .=$v->main_menu.',';
	$masu .=$v->sub_menu.',';
	}
	$mainm=explode(',', trim($ma,','));
	$submenu=explode(',', trim($masu,','));

	foreach ($mainmenu as $key => $value) 
	{ 
	if($value->parentid==0)
	{
	if(in_array($value->id,$mainm))
	{
		$str .='<p><input type="checkbox" checked disabled>'.$value->menuname.' <i class="fa fa-check-square-o fo" aria-hidden="true"></i></p>'; 
	}
	else
	{
	   $str .='<p><input type="checkbox" disabled>'.$value->menuname.'</p>'; 
	}

	foreach ($mainmenu as $key => $val) 
	{ 
	  if($val->parentid==$value->id)
	  {
		if(in_array($val->id,$submenu))
		{
			$str .='<p style="margin-left:30px;"><input type="checkbox" id="'.$val->id.'" checked disabled>'.$val->menuname.' <i class="fa fa-check-square fo" aria-hidden="true" id="c'.$val->id.'"></i> <a href="javascript:void(0)" onclick="removemenu('.$val->id.')"><i class="fa fa-trash" aria-hidden="true" id="r'.$val->id.'"></i></a><span id="m'.$val->id.'"></span> </p>'; 
		}
		else
		{
			$str .='<p style="margin-left:30px;"><input type="checkbox" disabled>'.$val->menuname.'</p>';
		}
	  } 
	}
	} 
	} 
						  
	echo $str;
	} 
	
	 public function removeassignmenu(){
      $empid=$this->input->post('empid');
	  $menuid=$this->input->post('menuid');
	  //print_r($menuid); exit;
	  $this->type_model->remove_assign_menu($empid,$menuid);
	 echo 1;
 } 
	
	
}
?>