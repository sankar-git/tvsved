<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {
	
	 private $user_name='';
	 private $user_fullname='';
	 private $user_role = 0;
	 private $user_email='';
	 public function __construct()
     {
             parent::__construct();
			$this->load->helper(array('form', 'url'));
			$this->load->database();
			$this->load->library('session');
			$this->load->library('encrypt');
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->library('email');
			//$this->load->model('category_model');
			$this->load->model('user_model');
			$this->load->model('item_model');
			$this->load->model('common_model');
			$this->load->model('user_model');
			
			
			if($user_data = $this->session->userdata('schoolbolpur_admin'))
			{
				$session_data = $this->session->userdata('schoolbolpur_admin');
				$this->user_name = $session_data['username'];
				$this->user_fullname = $session_data['first_name'].' '. $session_data['last_name'];
				$this->user_role = $session_data['role_id'];
				$this->user_email =$session_data['email'];
				if($session_data['role_id']==2)
				{
					redirect('authenticate/access_denied', 'refresh');
				}
			}
			else
			{
				redirect('authenticate', 'refresh');
			}
	}
	
	public function index()
	{	
		$data['class']=	$this->common_model->selectAll('tblclass');
		$data['section']=$this->common_model->selectAll('section');
		$data['department']=$this->common_model->selectAll('department');
		$data['roles']=$this->common_model->getAllRoles();
		$data['country']=$this->common_model->get_country();
		$data['city']=$this->common_model->get_city();
		$data['state']=$this->common_model->get_state();			
	}
	
	
	public function checkuseravailability()
	{
		$username = trim($this->input->post('username'));
		$bAvailibility = $this->user_model->checkuser_availability($username);
		echo json_encode(array("Available" => $bAvailibility )) ;
	}
	
	public function checkuseremailavailability()
	{
		$email = trim($this->input->post('email'));
		$bAvailibility = $this->common_model->checkuseremail_availability($email);
		echo json_encode(array("Available" => $bAvailibility )) ;	
	}
	
	
	
	
	
	
	
	
	
	
	
   
	 
	
	
}
?>