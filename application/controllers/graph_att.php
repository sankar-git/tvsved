<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class graph_att extends CI_Controller {

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
        
        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/graph_view',$data);
        $this->load->view('admin/template/admin_footer');
    }











}
?>