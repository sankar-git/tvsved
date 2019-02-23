<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class payment_head extends CI_Controller {

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
        $this->load->library('image_lib');
        $this->load->helper('email');
        $this->load->model('fees_model');
        $this->load->model('common_model');
        $this->load->helper('date_dropdown_helper');

        if($this->session->userdata('schoolbolpur_admin'))
        {
            $session_data = $this->session->userdata('schoolbolpur_admin');
            if(isset($session_data[0]))
            {
                $session_data=$session_data[0];
                $this->user_name = $session_data->username;
                $this->user_fullname = $session_data->first_name.' '. $session_data->last_name;
                $this->user_role = $session_data->role_id;
                $this->user_email =$session_data->email;
                $this->user_id = $session_data->id;
            }
        }
        else
        {
            redirect('authenticate', 'refresh');
        }
    }

    public function index()
    {
        if($this->user_role!=1)
        {
            $this->load->library('permission_lib');
            $this->permission_lib->permit($this->user_id,$this->user_role);
        }

        $data['class_details']= $this->common_model->get_where_class_status();
        $data['sub'] = $this->common_model->selectsub('tbl_payment_head');
        $data['title']="Add Payment Head";
        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/payment_head_view',$data);
        $this->load->view('admin/template/admin_footer');
    }


    function add_payment_head()
    {
        if($this->user_role!=1)
        {
            $this->load->library('permission_lib');
            $this->permission_lib->permit($this->user_id,$this->user_role);
        }

        $payment_head =trim($this->input->post('add_payment_head_name'));
        $payment_status = $this->input->post('add_payment_status');

        $data=array(
            'payment_head_name'=>$payment_head,

            'payment_head_status'=>$payment_status
        );
        //print_r($data);exit;


        $this->common_model->insert_data($data,'tbl_payment_head');
                /*echo "<pre>";
                print_r($data);
                echo "</pre>";*/

        redirect('payment_head','refresh');
    }




    function delete_subject()
    {
        if($this->user_role!=1)
        {
            $this->load->library('permission_lib');
            $this->permission_lib->permit($this->user_id,$this->user_role);
        }

        $id=trim($this->input->post('deleteid'));
        $this->common_model->delete_data('tbl_payment_head','payment_id',$id);
        redirect('payment_head','refresh');
    }


    //------------    Active Inactive ----------------------------------

    function sub_admin_active_inactive()
    {
        $value=$this->input->post('value');
        $id=$this->input->post('id');
        $data_sub_admin_active_inactive=array(
            'payment_head_status'=>$value
        );
        //echo $value;
        $this->db->where('payment_id', $id);
        $this->db->update('tbl_payment_head',$data_sub_admin_active_inactive);
    }



    function sub_admin_active_more_than_one_id()
    {
        $sub_admin_id_all=$this->input->post('sub_admin_id');
        $sub_admin_id_array=explode(",",$sub_admin_id_all);
        for($i=0;$i<count($sub_admin_id_array);$i++)
        {
            //echo $product_id_all;
            $sub_admin_id=trim($sub_admin_id_array[$i]);
            $data_sub_admin_active_inactive=array(
                'payment_head_status'=>'active'
            );
            //echo $value;
            $this->db->where('payment_id', $sub_admin_id);
            $this->db->update('tbl_payment_head',$data_sub_admin_active_inactive);
        }

        //$id=$this->input->post('id');

    }

    function sub_admin_in_active_more_than_one_id()
    {
        $sub_admin_id_all=$this->input->post('sub_admin_id');
        $sub_admin_id_array=explode(",",$sub_admin_id_all);
        for($i=0;$i<count($sub_admin_id_array);$i++)
        {
            //echo $product_id_all;
            $sub_admin_id=trim($sub_admin_id_array[$i]);
            $data_sub_admin_active_inactive=array(
                'payment_head_status'=>'inactive'
            );
            //echo $value;
            $this->db->where('payment_id', $sub_admin_id);
            $this->db->update('tbl_payment_head',$data_sub_admin_active_inactive);
        }

        //$id=$this->input->post('id');

    }

    //------------ End Active Inactive ----------------------------------


}
?>