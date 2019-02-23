<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class result extends CI_Controller
{
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
        @$data['test_detail']=$this->common_model->search_field('tbl_add_test');
        @$data['academic_year']=$this->common_model->selectAll('academic_year');
        @$data['course']=$this->common_model->selectAll('tbl_course');

        @$student_data = $this->common_model->common($table_name='tbl_add_course_to_student',$field=array(''), $where=array('academic_year'=>$acc_year,'course_name'=>$course_id,'class_name'=>$class), $where_or=array(),$like=array(),$like_or=array(),$order=array());
        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/result_view',$data);
        $this->load->view('admin/template/admin_footer');
    }

    public function add_course_model($id)
    {
        @$data['s'] = $this->common_model->course($id);
        $this->load->view('admin/adv_subject_course_ajax',$data);
    }

    public function add_class($id)
    {
        $data['class_detail'] = @$this->common_model->getAllClasses();
        $this->load->view('admin/adv_search_class_view',$data);
    }

    public function add_class_course($id)
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

    public function add_subject($id)
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
    public function add_batch($id)
    {
        @$acc_year = $_REQUEST['acc_value'];
        @$course_value = $_REQUEST['course_value'];
        @$data['s'] = $this->common_model->add_batch_model($id,$acc_year,$course_value);

        $this->load->view('admin/add_multiple_batch',$data);
    }

    public function subject($id)
    {
        @$ac_year   =   $_REQUEST['acc_value'];
        @$course    =   $_REQUEST['course'];

        @$data['sub']	=   $this->common_model->common($table_name='tbl_subject',$field=array(''), $where=array('academic_year'=>$ac_year,'course_name_by_subject'=>$course,'class_name'=>$id),$where_or=array(),$like=array(),$like_or=array(),$order=array());
        $this->load->view('admin/test_subject',$data);
    }

    public function subject_ul($id)
    {
        @$ac_year   =   $_REQUEST['acc_value'];
        @$course    =   $_REQUEST['course'];

        @$data['sub']	=   $this->common_model->common($table_name='tbl_subject',$field=array(''), $where=array('academic_year'=>$ac_year,'course_name_by_subject'=>$course,'class_name'=>$id),$where_or=array(),$like=array(),$like_or=array(),$order=array());
        $this->load->view('admin/test_subject_ul',$data);
    }

    public function add_test()
    {
        @$test_name  =   $this->input->post('test_name');
        @$acc_year   =   $this->input->post('search_acc_year');
        @$course     =   $this->input->post('search_course');
        @$class      =   $this->input->post('search_class');

        @$sub        =   $this->input->post('search_subject');
        @$emp_sub    =   implode(",",$sub);
        @$exp_sub    =   explode(",", $emp_sub);

        @$batch      =   $this->input->post('search_batch');
        @$string     =   str_replace(' ', '', $batch);
        @$emp_batch  =   implode(",",$string);
        @$exp_batch  =   explode(",", $emp_batch);
        
        $this->form_validation->set_rules('test_name', 'Test', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            @$student_data_class_wise = $this->common_model->common($table_name='tbl_add_course_to_student',$field=array(''), $where=array('academic_year'=>$acc_year,'course_name'=>$course,'class_name'=>$class), $where_or=array(),$like=array(),$like_or=array(),$order=array());

            $data = array(
                'test_name' =>  $test_name,
                'acc_year'  =>  $acc_year,
                'course'    =>  $course,
                'class'     =>  $class,
                'sub'       =>  $emp_sub,
                'batch'     =>  $emp_batch
            );
            $this->common_model->insert_data($data,'tbl_add_test');
            $test_id    =   $this->db->insert_id();

            for($i=0;$i<count($student_data_class_wise);$i++)
            {
                $student_id =   $student_data_class_wise[$i]->student_id;
                $add_course_id  =   $student_data_class_wise[$i]->add_course_id;
                $coursr_id[]    =   $student_data_class_wise[$i]->add_course_id;
                $st_id[] =   $student_data_class_wise[$i]->student_id;
                if(empty($batch))
                {
                    for($j=0;$j<count($exp_sub);$j++)
                    {
                        $student_data_subject_wise  =   @$this->common_model->common($table_name='tbl_add_course_subject_to_student',$field=array(''), $where=array('student_id'=>$student_id,'add_course_id'=>$add_course_id,'subject_name'=>$exp_sub[$j]), $where_or=array(),$like=array(),$like_or=array(),$order=array());
                        echo $this->db->last_query();
                        $student_id_subject_wise  =   @$student_data_subject_wise[0]->student_id;
                        $student_subject_wise    =   @$student_data_subject_wise[0]->subject_name;

                        $data   =   array(
                            'st_id'    =>   $student_id_subject_wise,
                            'sub_id'    =>  $student_subject_wise,
                            'test_id'  =>   $test_id,
                        );
                        $this->common_model->insert_data($data,'test_wise_student_list');

                    }
                }
                else
                {
                    for($j=0;$j<count($exp_sub);$j++)
                    {
                        for($l=0;$l<count($exp_batch);$l++)
                        {
                            $student_data_subject_wise  =   @$this->common_model->common($table_name='tbl_add_course_subject_to_student',$field=array(''), $where=array('student_id'=>$student_id,'add_course_id'=>$add_course_id,'subject_name'=>$exp_sub[$j],'batch_name'=>$exp_batch[$l]), $where_or=array(),$like=array(),$like_or=array(),$order=array());
                           // echo $this->db->last_query();
                            $student_id_subject_wise  =   @$student_data_subject_wise[0]->student_id;
                            $student_subject_wise    =   @$student_data_subject_wise[0]->subject_name;

                            $data   =   array(
                                'st_id'    =>   $student_id_subject_wise,
                                'sub_id'    =>  $student_subject_wise,
                                'test_id'  =>   $test_id,
                            );
                            if(!array_search("", $data))
                            {
                                $this->common_model->insert_data($data,'test_wise_student_list');
                            }
                        }
                    }
                }
            }

            for($k=0;$k<count($student_data_class_wise);$k++)
            {
                $student_id =   $student_data_class_wise[$k]->student_id;
                @$student_roll_class_wise = $this->common_model->common($table_name='tbl_student',$field=array(''), $where=array('student_id'=>$student_id), $where_or=array(),$like=array(),$like_or=array(),$order=array());

                @$st_roll_no    =   $student_roll_class_wise[$k]->roll_no;
                $data = array(
                    'student_id'        =>  $student_id,
                    'student_roll'      =>  $st_roll_no,
                    'subject'           =>  $emp_sub,
                    'batch'             =>  $emp_batch,
                    'total_marks_1'     =>  '0',
                    'total_marks_2'     =>  '0',
                    'total_marks_3'     =>  '0',
                    'total_marks_4'     =>  '0',
                    'total_marks_5'     =>  '0',
                    'student_marks_1'   =>  '0',
                    'student_marks_2'   =>  '0',
                    'student_marks_3'   =>  '0',
                    'student_marks_4'   =>  '0',
                    'student_marks_5'   =>  '0',
                    'per_marks_1'       =>  '0',
                    'per_marks_2'       =>  '0',
                    'per_marks_3'       =>  '0',
                    'per_marks_4'       =>  '0',
                    'per_marks_5'       =>  '0',
                    'test_id'           =>  $test_id,
                    'class'             =>  $class,
                    'acc_year'          =>  $acc_year,
                    'course_name'       =>  $course,
                    'att_p1'            =>  'a',
                    'att_p2'            =>  'a',
                    'att_p3'            =>  'a',
                    'att_p4'            =>  'a',
                    'att_p5'            =>  'a',
                );
                $this->common_model->insert_data($data,'tbl_test_result');
            }

            redirect('result');
        }
    }

    public function edit_test($id)
    {
        $data['test_data']=$this->common_model->selectOne('tbl_add_test','test_id',$id);
        $cls = $data['test_data'][0]->class;
        $course = $data['test_data'][0]->course;
        $ac_year=$data['test_data'][0]->acc_year;
        $data['academic_year']=$this->common_model->selectAll('academic_year');
        @$data['cls']	=   $this->common_model->common($table_name='tbl_course',$field=array(''), $where=array('academin_year'=>$ac_year,'course_id'=>$course),$where_or=array(),$like=array(),$like_or=array(),$order=array());
        @$data['sub']	=   $this->common_model->common($table_name='tbl_subject',$field=array(''), $where=array('academic_year'=>$ac_year,'course_name_by_subject'=>$course,'class_name'=>$cls),$where_or=array(),$like=array(),$like_or=array(),$order=array());
 
        @$data['batch']	=   $this->common_model->common($table_name='tbl_batch',$field=array(''), $where=array('session'=>$ac_year,'course_name'=>$course,'batch_class_name'=>$cls),$where_or=array(),$like=array(),$like_or=array(),$order=array());
       /* echo "<pre>";
       print_r($data['batch']);*/
        @$data['s'] = $this->common_model->course($ac_year);
        @$data['s'] = $this->common_model->course($ac_year);
        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/edit_test',$data);
        $this->load->view('admin/template/admin_footer');

    }

    public function edit_test_data()
    {
        $test_id = $this->input->post('test_id');
        $test_name  =   $this->input->post('test_name');
        $acc_year   =   $this->input->post('acc_year');
        $course   =   $this->input->post('test_course');
        $class   =   $this->input->post('test_class');
        $sub   =   $this->input->post('test_subject');
        $imp_sub    =   implode(",",$sub);

        $batch   =   $this->input->post('test_batch');
        $imp_batch  =   implode(",",$batch);

        $data = array(
                'test_name'=>$test_name,
                'acc_year'=>$acc_year,
                'course'=>$course,
                'class'=>$class,
                'sub'=>$imp_sub,
                'batch'=>$imp_batch
        );
       // print_r($data);
        $this->common_model->update_data($data,'tbl_add_test','test_id',$test_id);
        $this->session->set_flashdata('update_message','Test Successfully Updated');


        redirect('result');

    }

    public function view_test_student_list($id)
    {
        $test_id =   $id;
        $test_data  = $this->common_model->common($table_name='tbl_add_test',$field=array(''), $where=array('test_id'=>$test_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());
        $acc_year   =   $test_data[0]->acc_year;
        $course     =   $test_data[0]->course;
        $class      =   $test_data[0]->class;
        $sub        =   $test_data[0]->sub;
        $batch      =   $test_data[0]->batch;
        $data['test_detail']    = $this->common_model->common($table_name='test_wise_student_list',$field=array(''), $where=array('test_id'=>$test_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());
        

        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/student_list_test_wise',$data);
        $this->load->view('admin/template/admin_footer');

    }

    public function add_marks_view($id)
    {
        @$test_id           =   $this->input->post('test_id');

        @$st_test_detail    =   $this->common_model->common($table_name='tbl_add_test',$field=array(''), $where=array('test_id'=>$test_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());
        //echo $this->db->last_query();
        //print_r($st_test_detail);
        @$t_id              =   $st_test_detail[0]->test_id;
        @$sub_id            =   $st_test_detail[0]->sub;
        @$exp_sub_id        =   explode(',',$sub_id);
        @$student_id        =   $this->input->post('student_id');
        @$st_detail         =   $this->common_model->common($table_name='tbl_student',$field=array(''), $where=array('student_id'=>$student_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());
        @$st_course         =   $this->common_model->common($table_name='tbl_add_course_to_student',$field=array(''), $where=array('student_id'=>$student_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());
        @$add_course_id     =   $st_course[0]->add_course_id;
        @$course_id         =   $st_course[0]->course_name;
        @$course_name       =   $this->common_model->common($table_name='tbl_course',$field=array(''), $where=array('course_id'=>$course_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());
        for($i=0;$i<count($exp_sub_id);$i++)
        {
            @$a[]            =   $this->common_model->common($table_name='tbl_add_course_subject_to_student',$field=array(''), $where=array('add_course_id'=>$add_course_id,'student_id'=>$student_id,'subject_name'=>$exp_sub_id[$i]),$where_or=array(),$like=array(),$like_or=array(),$order=array());
           // echo $this->db->last_query();
        }
        //echo "<pre>";
        //print_r($a);
        foreach ($a as $b)
        {
            if(!empty($b))
            {
                $c[]        =   $b[0]->subject_name;
                $batch[]    =   $b[0]->batch_name;
            }

        }
        //print_r($c);
        for($j=0;$j<count($c);$j++)
        {
            @$d[]            =   $this->common_model->common($table_name='tbl_subject',$field=array(''), $where=array('subject_id'=>$c[$j]),$where_or=array(),$like=array(),$like_or=array(),$order=array());

        }

       foreach ($d as $e)
        {
            if(!empty($e))
            {
                $f[] = $e[0]->subject_name;
            }

        }


        $data   =   array(
            'student_id'        =>  $st_detail[0]->student_id,
            'student_roll_no'   =>  $st_detail[0]->roll_no,
            'first_name'        =>  $st_detail[0]->first_name,
            'last_name'         =>  $st_detail[0]->last_name,
            'mob_no'            =>  $st_detail[0]->student_phone_no,
            'parents_no'        =>  $st_detail[0]->guardian_mobile_no,
            'reg_no'            =>  $st_detail[0]->reg_no,
            'course_id'         =>  $course_name[0]->course_name,
            'acc_year'          =>  $st_course[0]->academic_year,
            'class'             =>  $st_course[0]->class_name,
            'sub'               =>  $f,
            'batch'             =>  $batch,
            'test_id'           =>  $t_id,
        );

        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/add_test_marks',$data);
        $this->load->view('admin/template/admin_footer');
    }

    public function add_marks_to_student()
    {
        $student_id         =   $this->input->post('student_id');
        $student_roll_no    =   $this->input->post('student_roll_no');
        $subject            =   $this->input->post('subject');
        $imp_subject        =   implode(',', $subject);
        $batch              =   $this->input->post('batch');
        $imp_batch          =   implode(',',$batch);
        $test_id            =   $this->input->post('test_id');
        $total_marks_p1     =   $this->input->post('total_marks_p1');
        $total_marks_p2     =   $this->input->post('total_marks_p2');
        $total_marks_p3     =   $this->input->post('total_marks_p3');
        $total_marks_p4     =   $this->input->post('total_marks_p4');
        $total_marks_p5     =   $this->input->post('total_marks_p5');
        $st_marks_p1        =   $this->input->post('st_marks_p1');
        $st_marks_p2        =   $this->input->post('st_marks_p2');
        $st_marks_p3        =   $this->input->post('st_marks_p3');
        $st_marks_p4        =   $this->input->post('st_marks_p4');
        $st_marks_p5        =   $this->input->post('st_marks_p5');
        $per_marks_p1       =   $this->input->post('per_marks_p1');
        $per_marks_p2       =   $this->input->post('per_marks_p2');
        $per_marks_p3       =   $this->input->post('per_marks_p3');
        $per_marks_p4       =   $this->input->post('per_marks_p4');
        $per_marks_p5       =   $this->input->post('per_marks_p5');
        $class              =   $this->input->post('class');
        $acc_year           =   $this->input->post('acc_year');
        $course_name        =   $this->input->post('course_name');

        $data               =   array(
                                        'student_id'        =>  $student_id,
                                        'student_roll'      =>  $student_roll_no,
                                        'subject'           =>  $imp_subject,
                                        'batch'             =>  $imp_batch,
                                        'test_id'           =>  $test_id,
                                        'total_marks_1'     =>  $total_marks_p1,
                                        'total_marks_2'     =>  $total_marks_p2,
                                        'total_marks_3'     =>  $total_marks_p3,
                                        'total_marks_4'     =>  $total_marks_p4,
                                        'total_marks_5'     =>  $total_marks_p5,
                                        'student_marks_1'   =>  $st_marks_p1,
                                        'student_marks_2'   =>  $st_marks_p2,
                                        'student_marks_3'   =>  $st_marks_p3,
                                        'student_marks_4'   =>  $st_marks_p4,
                                        'student_marks_5'   =>  $st_marks_p5,
                                        'per_marks_1'       =>  $per_marks_p1,
                                        'per_marks_2'       =>  $per_marks_p2,
                                        'per_marks_3'       =>  $per_marks_p3,
                                        'per_marks_4'       =>  $per_marks_p4,
                                        'per_marks_5'       =>  $per_marks_p5,
                                        'class'             =>  $class,
                                        'acc_year'          =>  $acc_year,
                                        'course_name'       =>  $course_name,

                                    );
        //print_r($data);
        $this->common_model->insert_data($data,'tbl_test_result');
        redirect('result/view_test_student_list/'.$test_id);
    }

    public function delete_data($id)
    {
        $this->common_model->delete_data('tbl_add_test','test_id',$id);
        $this->common_model->delete_data('test_wise_student_list','test_id',$id);
        $this->common_model->delete_data('tbl_test_result','test_id',$id);
    }


    function sub_admin_active_inactive()
    {
        $value=$this->input->post('value');
        $id=$this->input->post('id');
        $data_sub_admin_active_inactive=array(
            'academic_status'=>$value
        );
        //echo $value;
        $this->db->where('academic_year_id', $id);
        $this->db->update('academic_year',$data_sub_admin_active_inactive);
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
                'academic_status'=>'active'
            );
            //echo $value;
            $this->db->where('academic_year_id', $sub_admin_id);
            $this->db->update('academic_year',$data_sub_admin_active_inactive);
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
                'academic_status'=>'inactive'
            );
            //echo $value;
            $this->db->where('academic_year_id', $sub_admin_id);
            $this->db->update('academic_year',$data_sub_admin_active_inactive);
        }

        //$id=$this->input->post('id');

    }

    public function p1()
    {
        $all_id     =   $this->input->post('chk');

        $test_id    =   $this->input->post('test_id');
        $imp_all_id =   implode(',',$all_id );
        $st_id      =   explode(',',$imp_all_id );
        if(in_array('on',$st_id))
        {
            array_splice($st_id, 0,1);
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p1'=>'p',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p1'=>'p',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        redirect('result/view_test_student_list/'.$test_id);
    }

    public function p2()
    {
        $all_id     =   $this->input->post('chk');
        $test_id    =   $this->input->post('test_id');
        $imp_all_id =   implode(',',$all_id );
        $st_id      =   explode(',',$imp_all_id );
        if(in_array('on',$st_id))
        {
            array_splice($st_id, 0,1);
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p2'=>'p',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p2'=>'p',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        redirect('result/view_test_student_list/'.$test_id);
    }

    public function p3()
    {
        $all_id     =   $this->input->post('chk');

        $test_id    =   $this->input->post('test_id');
        $imp_all_id =   implode(',',$all_id );
        $st_id      =   explode(',',$imp_all_id );
        if(in_array('on',$st_id))
        {
            array_splice($st_id, 0,1);
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p3'=>'p',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p3'=>'p',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        redirect('result/view_test_student_list/'.$test_id);
    }

    public function p4()
    {
        $all_id     =   $this->input->post('chk');

        $test_id    =   $this->input->post('test_id');
        $imp_all_id =   implode(',',$all_id );
        $st_id      =   explode(',',$imp_all_id );
        if(in_array('on',$st_id))
        {
            array_splice($st_id, 0,1);
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p4'=>'p',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p4'=>'p',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        redirect('result/view_test_student_list/'.$test_id);
    }

    public function p5()
    {
        $all_id     =   $this->input->post('chk');

        $test_id    =   $this->input->post('test_id');
        $imp_all_id =   implode(',',$all_id );
        $st_id      =   explode(',',$imp_all_id );
        if(in_array('on',$st_id))
        {
            array_splice($st_id, 0,1);
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p5'=>'p',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p5'=>'p',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        redirect('result/view_test_student_list/'.$test_id);
    }

    public function a1()
    {
        $all_id     =   $this->input->post('chk');
        $test_id    =   $this->input->post('test_id');
        $imp_all_id =   implode(',',$all_id );
        $st_id      =   explode(',',$imp_all_id );
        if(in_array('on',$st_id))
        {
            array_splice($st_id, 0,1);
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p1'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p1'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        redirect('result/view_test_student_list/'.$test_id);
    }

    public function a2()
    {
        $all_id     =   $this->input->post('chk');
        $test_id    =   $this->input->post('test_id');
        $imp_all_id =   implode(',',$all_id );
        $st_id      =   explode(',',$imp_all_id );
        if(in_array('on',$st_id))
        {
            array_splice($st_id, 0,1);
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p2'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p2'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        redirect('result/view_test_student_list/'.$test_id);
    }

    public function a3()
    {
        $all_id     =   $this->input->post('chk');

        $test_id    =   $this->input->post('test_id');
        $imp_all_id =   implode(',',$all_id );
        $st_id      =   explode(',',$imp_all_id );
        if(in_array('on',$st_id))
        {
            array_splice($st_id, 0,1);
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p3'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p3'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        redirect('result/view_test_student_list/'.$test_id);
    }

    public function a4()
    {
        $all_id     =   $this->input->post('chk');

        $test_id    =   $this->input->post('test_id');
        $imp_all_id =   implode(',',$all_id );
        $st_id      =   explode(',',$imp_all_id );
        if(in_array('on',$st_id))
        {
            array_splice($st_id, 0,1);
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p4'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p4'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        redirect('result/view_test_student_list/'.$test_id);
    }

    public function a5()
    {
        $all_id     =   $this->input->post('chk');

        $test_id    =   $this->input->post('test_id');
        $imp_all_id =   implode(',',$all_id );
        $st_id      =   explode(',',$imp_all_id );
        if(in_array('on',$st_id))
        {
            array_splice($st_id, 0,1);
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p5'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'att_p5'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_test_result','student_id',$st_id[$j],'test_id',$test_id);
            }
        }
        redirect('result/view_test_student_list/'.$test_id);
    }








}


?>