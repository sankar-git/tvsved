<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class forgot_password extends CI_Controller {

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
        $this->load->view('front/template/header');
        $this->load->view('front/forget_password');
        $this->load->view('front/template/footer');
        //$this->load->view('admin/template/admin_footer');
    }

    public function forget_password_action()
    {
        $mal_data['email_data'] = $this->common_model->selectAll('tblemail');
        $admin_mail = $mal_data['email_data'][0]->from_email;


       $email=$this->input->post('student_email');
        @$data['admin_details_by_email_array']=$this->common_model->admin_details_by_email($email);
        //print_r($data['admin_details_by_email_array']);exit;
        if(count($data['admin_details_by_email_array'])>0)
        {

            @$this->email->set_mailtype("html");
            @$html_email_user = $this->load->view('front/forget_password_templet',$data, true);
            //echo "<pre>";print_r($html_email_user);exit;
            @$this->email->from('admin@parthaedu.com','admin');
            @$this->email->to($email);
            @$this->email->subject('Forgot your password for Partha Educational Insitituon. No worries!');
            @$this->email->message($html_email_user);
            @$result=$this->email->send();

           //echo $this->email->print_debugger();
            @$this->session->set_flashdata('message','Your password has been sent in your mail.');
            //exit;
           redirect('forgot_password','refresh');
        }
        else
        {
            @$this->session->set_flashdata('message','Please Enter Your Valid Email');
            redirect('forgot_password','refresh');
        }
    }
}