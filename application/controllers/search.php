<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class search extends CI_Controller {

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

        if ($this->session->userdata('schoolbolpur_admin')) {
            $session_data = $this->session->userdata('schoolbolpur_admin');
            if (isset($session_data[0])) {
                $session_data = $session_data[0];
                $this->user_name = $session_data->username;
                $this->user_fullname = $session_data->first_name . ' ' . $session_data->last_name;
                $this->user_role = $session_data->role_id;
                $this->user_email = $session_data->email;
                $this->user_id = $session_data->id;
            }
        } else {
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
        $data=$this->common_model->search_field('tbl_student');
        foreach($data as $row)
        {
            $where[]=$row->first_name ;
            $where[]=$row->roll_no ;
            $where[]=$row->reg_no ;
        }

        $data['where']=$where;
        @$data['academic_year']=$this->common_model->selectAll('academic_year');
        @$data['course']=$this->common_model->selectAll('tbl_course');
        $data['title']="Search";
        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/search_view',$data);
        $this->load->view('admin/template/admin_footer');
    }

    function add_course_model($id)
    {
        @$data['s'] = $this->common_model->course($id);
        $this->load->view('admin/adv_subject_course_ajax',$data);
    }

    function add_class($id)
    {
        $data['class_detail'] = @$this->common_model->getAllClasses();
        $this->load->view('admin/adv_search_class_view',$data);
    }

    function add_class_course($id)
    {
        @$ac_year = $_REQUEST['acc_value'];
        @$data_tax	=	$this->common_model->common($table_name='tbl_course',$field=array('course_reg_fee'), $where=array(),
            $where_or=array(),
            $like=array(
                'academin_year'=>$ac_year,
                'replace_course'=>$id
            ),
            $like_or=array(),$order=array());
        @$tax=$data_tax[0]->course_reg_fee;
        echo json_encode(array("amount" =>$tax));

        @$data['s'] = $this->common_model->add_class_model($id,$ac_year);
        $this->load->view('admin/adv_search_student_course_class_ajax',$data);
    }

    function add_subject($id)
    {
        @$acc_year = $_REQUEST['acc_value'];
        @$course_value = $_REQUEST['course_value'];

        @$data['s'] = $this->common_model->add_subject_model($id,$acc_year,$course_value);
        $this->load->view('admin/add_subject_multiple',$data);
    }
    /*function add_subject($id)
    {
        $data['sub_detail'] = @$this->common_model->selectsubject('tbl_subject','subject_name','academic_year',$id);

        $this->load->view('admin/add_subject_multiple',$data);
    }*/
    function add_batch($id)
    {
        @$acc_year = $_REQUEST['acc_value'];
        @$course_value = $_REQUEST['course_value'];
        @$data['s'] = $this->common_model->add_batch_model($id,$acc_year,$course_value);
        
        $this->load->view('admin/add_multiple_batch',$data);
    }
    
    

    function result()
    {
        $acc_year   =   $this->input->post('search_acc_year');
        $course     =   $this->input->post('search_course');
        $class      =   $this->input->post('search_class');
        $sub        =   $this->input->post('search_subject');
        $batch      =   $this->input->post('search_batch');
        if($sub != "")
        {
            $imp_sub    =   implode(',',$sub);
            $exp_sub    =   explode(',',$imp_sub );
        }

        if($batch != "")
        {
            $imp_batch  =   implode(',',$batch);
            $exp_batch  =   explode(',',$imp_batch);
        }

        $data   =   array(
            'sub'   =>  $sub,
            'batch' =>  $batch,
        );

        if($sub == "" && $batch == "")
        {
            $data['search'] =   $this->common_model->common($table_name='tbl_add_course_to_student',$field=array(), $where=array('academic_year'=>$acc_year,'course_name'=>$course,'class_name'=>$class),$where_or=array(),$like=array(),$like_or=array(),$order=array());
        }

        else if($batch == "")
        {
            $st_details =   $this->common_model->common($table_name='tbl_add_course_to_student',$field=array(), $where=array('academic_year'=>$acc_year,'course_name'=>$course,'class_name'=>$class),$where_or=array(),$like=array(),$like_or=array(),$order=array());
            for($i=0;$i<count($st_details);$i++)
            {
                $student_id =   $st_details[$i]->student_id;
                $add_course_id  =   $st_details[$i]->add_course_id;
                for($j=0;$j<count(array_filter($exp_sub));$j++)
                {
                    $st_sub_details[] =   $this->common_model->common($table_name='tbl_add_course_subject_to_student',$field=array(), $where=array('add_course_id'=>$add_course_id,'student_id'=>$student_id,'subject_name'=>$exp_sub[$j],'sub_status'=>'active'),$where_or=array(),$like=array(),$like_or=array(),$order=array());
                }
            }
            $data['search'] = $st_sub_details;
        }

        else
        {
            $st_details =   $this->common_model->common($table_name='tbl_add_course_to_student',$field=array(), $where=array('academic_year'=>$acc_year,'course_name'=>$course,'class_name'=>$class),$where_or=array(),$like=array(),$like_or=array(),$order=array());
            for($i=0;$i<count($st_details);$i++)
            {
                $student_id =   $st_details[$i]->student_id;
                $add_course_id  =   $st_details[$i]->add_course_id;
                for($j=0;$j<count(array_filter($exp_batch));$j++)
                {
                    if($sub != "")
                    {
                        for($k=0;$k<count(array_filter($exp_sub));$k++)
                        {
                            $st_sub_details[] =   $this->common_model->common($table_name='tbl_add_course_subject_to_student',$field=array(), $where=array('add_course_id'=>$add_course_id,'student_id'=>$student_id,'subject_name'=>$exp_sub[$k],'batch_name'=>$exp_batch[$j],'sub_status'=>'active'),$where_or=array(),$like=array(),$like_or=array(),$order=array());
                            //echo "<pre>".$this->db->last_query();echo "</pre>";
                        }
                    }
                    else
                    {
                        $st_sub_details[] =   $this->common_model->common($table_name='tbl_add_course_subject_to_student',$field=array(), $where=array('add_course_id'=>$add_course_id,'student_id'=>$student_id,'batch_name'=>$exp_batch[$j]),$where_or=array(),$like=array(),$like_or=array(),$order=array());
                        //echo "<pre>".$this->db->last_query();echo "</pre>";
                    }

                }
            }
            $data['search'] = $st_sub_details;
            //echo "<pre>";
            //print_r($data['search']);
           // echo "</pre>";
        }
        $data['title']="Search Result";

        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/search_result',@$data);
        $this->load->view('admin/template/admin_footer');




    }

    
}


?>