<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class attendance extends CI_Controller
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

        /*if ($this->session->userdata('schoolbolpur_admin')) {
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
        }*/
    }

    public function index()
    {
        if($this->user_role!=1)
        {
            $this->load->library('permission_lib');
            $this->permission_lib->permit($this->user_id,$this->user_role);
        }
        @$data['test_detail']=$this->common_model->search_field('tbl_attendance');

        @$data['academic_year']=$this->common_model->selectAll('academic_year');
        @$data['course']=$this->common_model->selectAll('tbl_course');

        //@$student_data = $this->common_model->common($table_name='tbl_add_course_to_student',$field=array(''), $where=array('academic_year'=>$acc_year,'course_name'=>$course_id,'class_name'=>$class), $where_or=array(),$like=array(),$like_or=array(),$order=array());
        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/attendance_view',$data);
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

    public function add_attendance()
    {

        @$acc_year      =   $this->input->post('search_acc_year');
        @$course        =   $this->input->post('search_course');
        @$class         =   $this->input->post('search_class');
        @$sub           =   $this->input->post('add_subject');

        @$batch         =   $this->input->post('search_batch');
        @$string        =   str_replace(' ', '', $batch);
        @$emp_batch     =   implode(",",$string);
        @$exp_batch     =   explode(",", $emp_batch);
        @$att_date     =   $this->input->post('cls_date');
        $datetime       =   date("Y-m-d H:i:s");


        $this->form_validation->set_rules('cls_date', 'Date', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            @$student_data_class_wise =   $this->common_model->common($table_name='tbl_add_course_to_student',$field=array(), $where=array('academic_year'=>$acc_year,'course_name'=>$course,'class_name'=>$class),$where_or=array(),$like=array(),$like_or=array(),$order=array());
            $data = array(
                'acc_year'      =>  $acc_year,
                'course_name'   =>  $course,
                'sub'           =>  $sub,
                'class'         =>  $class,
                'batch'         =>  $emp_batch,
                'cls_date'      =>  date('Y-m-d',strtotime($att_date)),
                'time'          =>  $datetime,
            );
            $this->common_model->insert_data($data,'tbl_attendance');
            $att_id =   $this->db->insert_id();
            if($sub == 0 && $batch == "")
            {
                for($k=0;$k<count($student_data_class_wise);$k++)
                {
                    $student_id =   $student_data_class_wise[$k]->student_id;
                    $data = array(
                        'st_id'         =>  $student_id,
                        'st_attendance' =>  'a',
                        'att_id'          =>  $att_id,
                        );
                    $this->common_model->insert_data($data,'tbl_attendance_student_list');
                }
            }
            else if($batch == "")
            {
                for($i=0;$i<count($student_data_class_wise);$i++)
                {
                    $student_id =   $student_data_class_wise[$i]->student_id;
                    $add_course_id  =   $student_data_class_wise[$i]->add_course_id;
                    //for($j=0;$j<count(array_filter($sub));$j++)
                   // {
                        $st_sub_details[] =   $this->common_model->common($table_name='tbl_add_course_subject_to_student',$field=array(), $where=array('add_course_id'=>$add_course_id,'student_id'=>$student_id,'subject_name'=>$sub),$where_or=array(),$like=array(),$like_or=array(),$order=array());
                    //}
                }//end for

                for($k=0;$k<count($st_sub_details);$k++)
                {
                    if(!empty( $st_sub_details[$k][0]))
                    {
                        $student_id    =   $st_sub_details[$k][0]->student_id;
                        $student_roll_class_wise = $this->common_model->common($table_name='tbl_student',$field=array(''), $where=array('student_id'=>$student_id), $where_or=array(),$like=array(),$like_or=array(),$order=array());
                        $st_roll_no    =   $student_roll_class_wise[0]->roll_no;
                        $data = array(
                            'st_id'         =>  $student_id,
                            'st_attendance' =>  'a',
                            'att_id'          =>  $att_id,
                        );
                        $this->common_model->insert_data($data,'tbl_attendance_student_list');
                    }//end if
                }//end for
            }//end else
            else
            {
                for($i=0;$i<count($student_data_class_wise);$i++)
                {
                    $student_id =   $student_data_class_wise[$i]->student_id;
                    $student_roll_class_wise = $this->common_model->common($table_name='tbl_student',$field=array(''), $where=array('student_id'=>$student_id), $where_or=array(),$like=array(),$like_or=array(),$order=array());
                    $st_roll_no    =   $student_roll_class_wise[0]->roll_no;
                    $add_course_id  =   $student_data_class_wise[$i]->add_course_id;
                    for($j=0;$j<count(array_filter($exp_batch));$j++)
                    {
                        if($sub != 0)
                        {
                            $st_sub_details =   $this->common_model->common($table_name='tbl_add_course_subject_to_student',$field=array(), $where=array('add_course_id'=>$add_course_id,'student_id'=>$student_id,'subject_name'=>$sub,'batch_name'=>$exp_batch[$j]),$where_or=array(),$like=array(),$like_or=array(),$order=array());
                            if(!empty($st_sub_details))
                            {
                                $data = array(
                                    'st_id'         =>  $student_id,
                                    'st_attendance' =>  'a',
                                    'att_id'          =>  $att_id,
                                );
                                $this->common_model->insert_data($data,'tbl_attendance_student_list');
                            }
                        }
                        else
                        {
                            $st_sub_details =   $this->common_model->common($table_name='tbl_add_course_subject_to_student',$field=array(), $where=array('add_course_id'=>$add_course_id,'student_id'=>$student_id,'batch_name'=>$exp_batch[$j]),$where_or=array(),$like=array(),$like_or=array(),$order=array());
                            if(!empty($st_sub_details))
                            {
                                $data = array(
                                    'st_id'         =>  $student_id,
                                    'st_attendance' =>  'a',
                                    'att_id'          =>  $att_id,
                                );
                                $this->common_model->insert_data($data,'tbl_attendance_student_list');

                            }
                        }
                    }
                }
            }//end else
            /* for($i=0;$i<count($student_data_class_wise);$i++)
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
                         //echo $this->db->last_query();
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
             }*/

            redirect('attendance');
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
        $test_id        =   $this->input->post('test_id');
        $p1_name        =   $this->input->post('paper1_name');
        $p2_name        =   $this->input->post('paper2_name');
        $p3_name        =   $this->input->post('paper3_name');
        $p4_name        =   $this->input->post('paper4_name');
        $p5_name        =   $this->input->post('paper5_name');
        $p1_tot_marks   =   $this->input->post('p1_tot_marks');
        $p2_tot_marks   =   $this->input->post('p2_tot_marks');
        $p3_tot_marks   =   $this->input->post('p3_tot_marks');
        $p4_tot_marks   =   $this->input->post('p4_tot_marks');
        $p5_tot_marks   =   $this->input->post('p5_tot_marks');
        $test_name      =   $this->input->post('test_name');
        //$acc_year       =   $this->input->post('acc_year');
        ///$course         =   $this->input->post('test_course');
        //$class          =   $this->input->post('test_class');
        // $sub            =   $this->input->post('test_subject');
        // $emp_sub        =   implode(",",$sub);
        // $exp_sub        =   explode(',',$emp_sub);
        //$batch          =   $this->input->post('test_batch');
        //$emp_batch      =   implode(",",$batch);
        //$exp_batch      =   explode(',',$emp_batch);

        $data = array(
            'test_name'=>$test_name,
        );
        $this->common_model->update_data($data,'tbl_add_test','test_id',$test_id);
        @$test_data=   $this->common_model->common($table_name='tbl_test_result',$field=array(''), $where=array('test_id'=>$test_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());

        for($i=0;$i<count(array_filter($test_data));$i++)
        {
            $marks_id   =   $test_data[$i]->marks_id;
            $data = array(
                'total_marks_1'=>$p1_tot_marks,
                'total_marks_2'=>$p2_tot_marks,
                'total_marks_3'=>$p3_tot_marks,
                'total_marks_4'=>$p4_tot_marks,
                'total_marks_5'=>$p5_tot_marks,
                'papre1_name'=>$p1_name,
                'papre2_name'=>$p2_name,
                'papre3_name'=>$p3_name,
                'papre4_name'=>$p4_name,
                'papre5_name'=>$p5_name,

            );

            $this->common_model->update_data($data,'tbl_test_result','marks_id',$marks_id);
        }




        $this->session->set_flashdata('update_message','Test Successfully Updated');


        redirect('result');

    }

    public function view_test_student_list($id)
    {
        $test_id =   $id;
        $data['test_detail']  = $this->common_model->common($table_name='tbl_attendance_student_list',$field=array(''), $where=array('att_id'=>$test_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());

        //$data['test_detail']    = $this->common_model->common($table_name='tbl_test_result',$field=array(''), $where=array('test_id'=>$test_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());


        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/student_list_attendance_wise',$data);
        $this->load->view('admin/template/admin_footer');

    }

    public function add_marks_view($id)
    {
        @$test_id           =   $this->input->post('test_id');

        @$st_test_detail    =   $this->common_model->common($table_name='tbl_add_test',$field=array(''), $where=array('test_id'=>$test_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());

        @$st_test_result_detail    =   $this->common_model->common($table_name='tbl_test_result',$field=array(''), $where=array('test_id'=>$test_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());
        // echo "<pre>";
        // print_r($st_test_result_detail);
        //echo "</pre>";
        @$t_id              =   $st_test_detail[0]->test_id;
        @$sub_id            =   $st_test_detail[0]->sub;
        @$exp_sub_id        =   explode(',',$sub_id);
        @$student_id        =   $this->input->post('student_id');
        @$st_test_marks_detail    =   $this->common_model->common($table_name='tbl_test_result',$field=array(''), $where=array('test_id'=>$test_id,'student_id'=>$student_id),$where_or=array(),$like=array(),$like_or=array(),$order=array());
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
            'p1_tot_marks'      =>  $st_test_result_detail[0]->total_marks_1,
            'p2_tot_marks'      =>  $st_test_result_detail[0]->total_marks_2,
            'p3_tot_marks'      =>  $st_test_result_detail[0]->total_marks_3,
            'p4_tot_marks'      =>  $st_test_result_detail[0]->total_marks_4,
            'p5_tot_marks'      =>  $st_test_result_detail[0]->total_marks_5,
            'p1_st_marks'      =>  $st_test_marks_detail[0]->student_marks_1,
            'p2_st_marks'      =>  $st_test_marks_detail[0]->student_marks_2,
            'p3_st_marks'      =>  $st_test_marks_detail[0]->student_marks_3,
            'p4_st_marks'      =>  $st_test_marks_detail[0]->student_marks_4,
            'p5_st_marks'      =>  $st_test_marks_detail[0]->student_marks_5,
            'per_marks_1'      =>  $st_test_marks_detail[0]->per_marks_1,
            'per_marks_2'      =>  $st_test_marks_detail[0]->per_marks_2,
            'per_marks_3'      =>  $st_test_marks_detail[0]->per_marks_3,
            'per_marks_4'      =>  $st_test_marks_detail[0]->per_marks_4,
            'per_marks_5'      =>  $st_test_marks_detail[0]->per_marks_5,
            'ne_marks_1'      =>  $st_test_marks_detail[0]->ne_paper1,
            'ne_marks_2'      =>  $st_test_marks_detail[0]->ne_paper2,
            'ne_marks_3'      =>  $st_test_marks_detail[0]->ne_paper3,
            'ne_marks_4'      =>  $st_test_marks_detail[0]->ne_paper4,
            'ne_marks_5'      =>  $st_test_marks_detail[0]->ne_paper5,

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
        //$subject            =   $this->input->post('subject');
        //$imp_subject        =   implode(',', $subject);
        //$batch              =   $this->input->post('batch');
        //$imp_batch          =   implode(',',$batch);
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
        $ne_marks_p1        =   $this->input->post('ne_marks_p1');
        $ne_marks_p2        =   $this->input->post('ne_marks_p2');
        $ne_marks_p3        =   $this->input->post('ne_marks_p3');
        $ne_marks_p4        =   $this->input->post('ne_marks_p4');
        $ne_marks_p5        =   $this->input->post('ne_marks_p5');
        //$class              =   $this->input->post('class');
        //$acc_year           =   $this->input->post('acc_year');
        //$course_name        =   $this->input->post('course_name');

        if($total_marks_p1 != "" &&$st_marks_p1 != "" && $per_marks_p1 != "")
        {
            $data   =   array(
                'total_marks_1'     =>  $total_marks_p1,
                'student_marks_1'   =>  $st_marks_p1,
                'per_marks_1'       =>  $per_marks_p1,
                'ne_paper1'         =>  $ne_marks_p1,
                'att_p1'            =>  'p'
            );
            $this->common_model->update_img_data($data,'tbl_test_result','student_id',$student_id,'test_id',$test_id);
        }
        if($total_marks_p2 != "" &&$st_marks_p2 != "" && $per_marks_p2 != "")
        {
            $data   =   array(
                'total_marks_2'     =>  $total_marks_p2,
                'student_marks_2'   =>  $st_marks_p2,
                'per_marks_2'       =>  $per_marks_p2,
                'ne_paper2'         =>  $ne_marks_p2,
                'att_p2'            =>  'p'
            );

            $this->common_model->update_img_data($data,'tbl_test_result','student_id',$student_id,'test_id',$test_id);
        }
        if($total_marks_p3 != "" &&$st_marks_p3 != "" && $per_marks_p3 != "")
        {
            $data   =   array(
                'total_marks_3'     =>  $total_marks_p3,
                'student_marks_3'   =>  $st_marks_p3,
                'per_marks_3'       =>  $per_marks_p3,
                'ne_paper3'         =>  $ne_marks_p3,
                'att_p3'            =>  'p'

            );
            //print_r($data);
            $this->common_model->update_img_data($data,'tbl_test_result','student_id',$student_id,'test_id',$test_id);
        }
        if($total_marks_p4 != "" &&$st_marks_p4 != "" && $per_marks_p4 != "")
        {
            $data   =   array(
                'total_marks_4'     =>  $total_marks_p4,
                'student_marks_4'   =>  $st_marks_p4,
                'per_marks_4'       =>  $per_marks_p4,
                'ne_paper4'         =>  $ne_marks_p4,
                'att_p4'            =>  'p'
            );

            $this->common_model->update_img_data($data,'tbl_test_result','student_id',$student_id,'test_id',$test_id);
        }
        if($total_marks_p5 != "" &&$st_marks_p5 != "" && $per_marks_p5 != "")
        {
            $data   =   array(

                'total_marks_5'     =>  $total_marks_p5,
                'student_marks_5'   =>  $st_marks_p5,
                'per_marks_5'       =>  $per_marks_p5,
                'ne_paper5'         =>  $ne_marks_p5,
                'att_p5'            =>  'p'
            );
            $this->common_model->update_img_data($data,'tbl_test_result','student_id',$student_id,'test_id',$test_id);
        }
        redirect('result/view_test_student_list/'.$test_id);
    }

    public function delete_data($id)
    {
        $this->common_model->delete_data('tbl_add_test','test_id',$id);
        $this->common_model->delete_data('test_wise_student_list','test_id',$id);
        $this->common_model->delete_data('tbl_test_result','test_id',$id);
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
                    'st_attendance'=>'p',
                );
                $this->common_model->update_img_data($data,'tbl_attendance_student_list','st_id',$st_id[$j],'att_id',$test_id);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'st_attendance'=>'p',
                );
                $this->common_model->update_img_data($data,'tbl_attendance_student_list','st_id',$st_id[$j],'att_id',$test_id);
            }
        }
        redirect('attendance/view_test_student_list/'.$test_id);
    }

    public function a1()
    {
        $test_id    =   $this->input->post('test_id');
        $all_id     =   $this->input->post('chk');
        $imp_all_id =   implode(',',$all_id );
        $st_id      =   explode(',',$imp_all_id );
        if(in_array('on',$st_id))
        {
            array_splice($st_id, 0,1);
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'st_attendance'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_attendance_student_list','st_id',$st_id[$j],'att_id',$test_id);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'st_attendance'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_attendance_student_list','st_id',$st_id[$j],'att_id',$test_id);
            }
        }
        redirect('attendance/view_test_student_list/'.$test_id);
    }

    public function send_sms()
    {
        $sms_api_detail= @$this->common_model->common($table_name='sms_api',$field=array(),$where=array('status'=>'on'),$where_or=array(),$like=array(),$like_or_array=array(),$order=array(),$start='0',$end='1',$where_in_array=array());
        $api_link1	=	$sms_api_detail[0]->before;
        $api_link2	=	$sms_api_detail[0]->after;

        $all_id     =   $this->input->post('chk');
        $test_id    =   $this->input->post('test_id');
        $test_detail= @$this->common_model->common($table_name='tbl_attendance',$field=array(),$where=array('attendance_id'=>$test_id),$where_or=array(),$like=array(),$like_or_array=array(),$order=array(),$start='',$end='',$where_in_array=array());
        $sub_id =   $test_detail[0]->sub;
        $sub_detail= @$this->common_model->common($table_name='tbl_subject',$field=array(),$where=array('subject_id'=>$sub_id),$where_or=array(),$like=array(),$like_or_array=array(),$order=array(),$start='',$end='',$where_in_array=array());

        $imp_all_id =   implode(',',$all_id );
        $st_id      =   explode(',',$imp_all_id );
        if(in_array('on',$st_id))
        {
            array_splice($st_id, 0,1);
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'st_attendance'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_attendance_student_list','st_id',$st_id[$j],'att_id',$test_id);
                $student_detail= @$this->common_model->common($table_name='tbl_student',$field=array(),$where=array('student_id'=>$st_id[$j]),$where_or=array(),$like=array(),$like_or_array=array(),$order=array(),$start='',$end='',$where_in_array=array());



                $st_mobile_no   =   $student_detail[$j]->student_phone_no;
                $p_mobile_no   =   $student_detail[$j]->guardian_mobile_no;

                $bb =   $st_mobile_no.",".$p_mobile_no;

                $sms_text = "Dear ".$student_detail[$j]->first_name." ".date('d-m-Y').'You Are Absent in'.$sub_detail[0]->subject_name." Class";
                $message = urlencode($sms_text);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api_link1.$bb.$api_link2.$message);

                //curl_setopt($ch, CURLOPT_URL, "http://premium.ssas.co.in/composeapi/?userid=ParthaInst&pwd=Pi$@325&route=2&senderid=PARTHA&destination=".$bb."&message=".$message);
                curl_setopt($ch, CURLOPT_HEADER, 0);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For HTTPS

                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // For HTTPS


                $result = curl_exec($ch);
                if ($result === FALSE)
                {
                    die('Curl failed: ' . curl_error($ch));
                }
                curl_close($ch);
            }
        }
        else
        {
            for($j=0;$j<count($st_id);$j++)
            {
                $data=array(
                    'st_attendance'=>'a',
                );
                $this->common_model->update_img_data($data,'tbl_attendance_student_list','st_id',$st_id[$j],'att_id',$test_id);
                $student_detail= @$this->common_model->common($table_name='tbl_student',$field=array(),$where=array('student_id'=>$st_id[$j]),$where_or=array(),$like=array(),$like_or_array=array(),$order=array(),$start='',$end='',$where_in_array=array());
                $st_mobile_no   =   $student_detail[$j]->student_phone_no;
                $p_mobile_no   =   $student_detail[$j]->guardian_mobile_no;

                $bb =   $st_mobile_no.",".$p_mobile_no;

                $sms_text = "Dear ".$student_detail[$j]->first_name." ".date('d-m-Y').'You Are Absent in'.$sub_detail[0]->subject_name." Class";
                $message = urlencode($sms_text);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api_link1.$bb.$api_link2.$message);

                //curl_setopt($ch, CURLOPT_URL, "http://premium.ssas.co.in/composeapi/?userid=ParthaInst&pwd=Pi$@325&route=2&senderid=PARTHA&destination=".$bb."&message=".$message);
                curl_setopt($ch, CURLOPT_HEADER, 0);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For HTTPS

                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // For HTTPS


                echo $result = curl_exec($ch);
                if ($result === FALSE)
                {
                    die('Curl failed: ' . curl_error($ch));
                }
                curl_close($ch);
            }
        }
        //exit;
        redirect('attendance/view_test_student_list/'.$test_id);
    }


    public function result_excel_upload()
    {
        $test_id    =   $this->input->post('test_id');
        $result     =   $this->input->post('excelfile');


        //............Excel File Upload..............................

        $new_name = str_replace(".","",microtime());
        $config['upload_path'] ='resultexcel';
        $config['allowed_types'] = 'csv,xlsx';
        $config['file_name']=$new_name;
        $this->load->library('upload', $config);
        //==========end:resize body_part image======================
        $field_name = "excelfile";

        if($this->upload->do_upload($field_name))
        {
            $file_info = $this->upload->data();
            $original_image_file_name = $file_info['raw_name'].$file_info['file_ext'];
            $file_size=$file_info['file_size'];
            $this->image_lib->clear();

            $csv_file ='resultexcel/'.$file_info['raw_name'].$file_info['file_ext'];
            $this->load->library('csvreader');
            $result =   $this->csvreader->parse_file($csv_file);
            $data['csvData'] =  $result;

            foreach($data['csvData'] as $f){
                foreach($f as $fieldna=>$fieldvalue){
                    $registration[]=$fieldna;
                }
                break;
            }



            if($registration[0]!=='registration_no' && $registration[1]!=='firstname' && $registration[2]!=='lastname')
            {
                $this->session->set_flashdata('error_message',"The first column name of the sheet should be 'Registration_no'. Please follow the sample sheet. ");
                redirect("addstudent","refresh");
            }else{

                foreach($data['csvData'] as $field)
                {

                    $feesnotmatch_str='';
                    $match_regisno_str='';
                    $notAdd_record_msg='';

                    $match_regisno_str.='<br>Please check registration no- '.$field['registration_no'];

                    if($field['status']==''){ $status='active';  } else {$status= $field['status'] ;}
                    if($field['blood_group']==''){$bloodGroup='unknown'; } else {$bloodGroup=$field['blood_group'];}
                    if($field['gender']==''){$gender='female' ;} else{$gender=$field['gender']; }
                    if($field['role_id']==''){$role_id='2' ;}else{$role_id=$field['role_id']; }
                    $currentdate = date('Y-m-d H:i:s');
                    if($field['datetime']=='')
                    {
                        $registrDate=$currentdate;
                    }
                    else{
                        $registrDate=$field['datetime'];
                    }
                    $username=(substr($field['firstname'],0,2).substr($field['lastname'],0,2));     //username is unique.
                    $class_id='';
                    $generalfees=0.0;
                    if($field['class']=='')
                    {
                        $notAdd_record_msg.="<br>Class Should Not Be Empty. Please check registration no- ".$field['registration_no'];
                        $field['class']=0;
                    }else{
                        $class_id=$this->common_model->single_value('tblclass','id','name = "'.$field['class'].'"');
                        if($class_id=='')
                        {
                            $notAdd_record_msg.="<br>This Class is not exists in database. Please check registration no- ".$field['registration_no'];
                            $field['class']=0;
                        }else{
                            $generalfees=$this->common_model->single_value('fees','total','class_id = '.$class_id);
                        }
                    }

                    if($field['totalfees']=='')
                    {
                        $notAdd_record_msg.="<br>Total Fess Should Not Be Empty. Please check registration no- ".$field['registration_no'];
                        $field['totalfees']=0;
                    }
                    //else{
                    /*if($generalfees != $field['totalfees'])
                    {
                        $feesnotmatch_str.='<br>Total Fees from excel sheet is not matched with Fees which has been set by administrator.';
                        $generalfees=$field['totalfees'];
                    }*/
                    //}

                    //--------------------------------Concession / Special Amount---------------
                    $concession_id=0;
                    $concessionuser_id=0;
                    if($field['concession_amount'] !='')
                    {
                        $concession_id=$this->common_model->single_value('concession','id','concession_amount = '.$field['concession_amount']);
                        if($concession_id=='')
                        {
                            $feesnotmatch_str.='<br>Concession Amount is not matched with the aoumnt which has been set by Administrator.';
                            $concession_id=0;
                        }
                    }else{
                        $field['concession_amount']=0;
                    }

                    $specialfees_id=0;
                    $specialuser_id=0;
                    if($field['special_fees'] !='')
                    {
                        $specialfees_id=$this->common_model->single_value('specialfees','id','specialamount = '.$field['special_fees']);
                        if($specialfees_id=='')
                        {
                            $feesnotmatch_str.='<br>Special Fees is not matched with the aoumnt which has been set by Administrator.';
                            $specialfees_id=0;
                        }

                    }else{
                        $field['special_fees']=0;
                    }

                    if($field['final_fees']=='')
                    {
                        $field['final_fees']=$field['totalfees'];
                    }else{
                        if($field['final_fees'] != $field['totalfees'])
                        {
                            $final=( $field['totalfees'] + $field['special_fees'] ) - $field['concession_amount'];
                            if($field['final_fees']!=$final)
                            {
                                $feesnotmatch_str.='<br>Please check concession amount and special fees.Calculation is not matched.';
                            }
                        }
                    }

                    $data = array(
                        'username' => $username,
                        'registration_no'=>$field['registration_no'],
                        'first_name'=>  $field['firstname'],
                        'last_name' => $field['lastname'],
                        'middle_name' => $field['middle_name'],
                        'email'=> $field['email'],
                        'phone'=> $field['phonenumber'],
                        'address' => $field['address'],
                        'status'=>$status,
                        'country_name' => $field['country_name'],
                        'state' => $field['state'],
                        'city' => $field['city'],
                        'city_dist'=>$field['district'],
                        'religion' => $field['religion'],
                        'blood_group' => $bloodGroup,
                        'mother_tongue' => $field['mother_tongue'],
                        'postal_code' => $field['postal_code'],
                        'mobile' => $field['mobile'],
                        'gender' => $gender,
                        'date_of_birth' => date('Y-m-d',strtotime($field['date_of_birth'])),
                        'birth_place' => $field['birth_place'],
                        'role_id' =>$role_id,
                        'lastlogon_datetime' =>date('Y-m-d',strtotime($field['datetime'])),
                        //'generalfees'=>$generalfees,
                        'class_id'=>$class_id,
                        'fees'=>$generalfees,//$field['final_fees'],
                        'registration_date'=>date('Y-m-d',strtotime($registrDate)),
                        'promotion_date'=>date('Y-m-d',strtotime($registrDate))

                    );

                    $id='';
                    $table='student';
                    if($field['registration_no']!='' && $class_id!='' && $generalfees!=0 )
                    {
                        $exist_registration=$this->common_model->selectOne($table,'registration_no',$field['registration_no']);
                        if(count($exist_registration)==0)
                        {
                            $this->common_model->insert_data($data,$table);
                            $id=$this->db->insert_id();         //$id=autoincrement no
                        }

                        $registration_no='';
                        if($id!='' && $username!='')
                        {
                            if($role_id==2)
                            {
                                $username='S'.$username.$id;    //Student==2
                                if($field['registration_no']==''){
                                    $registration_no='02'.$id; }else{$registration_no=$field['registration_no'];   }
                            }

                            $data=array('username'=>$username,'registration_no'=>$registration_no);
                            $this->common_model->update_data($data,'student','id',$id);

                            //----------------f e e s user c l a s s-------------------------
                            $data_fees_user_class = array(
                                'user_id' =>$id,
                                'class_id'=>$class_id,
                                //'totfees'=>($generalfees + trim($field['special_fees'])) - trim($field['concession_amount']),
                                'updated_date'=>date('Y-m-d H:i:s'),
                                'created_date'=>date('Y-m-d H:i:s')
                            );
                            $this->common_model->insert_data($data_fees_user_class,'fees_user_class');

                            $session_charge=0;
                            $session=$this->common_model->selectWhere('sessioncharge','(class = '.$class_id.' OR class = 0)');
                            if(isset($session[0]->amount))
                            {
                                if($session[0]->amount!='')
                                {
                                    $session_charge=$session[0]->amount;
                                }
                            }

                            $session_charge_arr = array(
                                'user_id' =>$id,
                                'class_id'=> $class_id,
                                'session_charge'=>$session_charge,
                                'created_date'=>date('Y-m-d H:i:s')
                            );
                            $this->common_model->insert_data($session_charge_arr,'session_charge');

                            //------------------S T A R T -------concession /special Amount-----------------
                            $concessionuser_id=0;
                            $specialuser_id=0;
                            if($concession_id !=0)
                            {
                                $data_concession = array(
                                    'user_id' =>$id,
                                    'concession_id'=>$concession_id,
                                    'amount'=>$field['concession_amount'],
                                    'effective_month'=>date('Y-m-d H:i:s'),
                                    'endmonth'=>date('Y-m-d H:i:s'),
                                    'created_date'=>date('Y-m-d H:i:s')
                                );
                                $this->common_model->insert_data($data_concession,'concession_user');
                                $concessionuser_id=$this->common_model->max_id('concession_user','id');
                            }
                            if($specialfees_id!=0)
                            {
                                $data_specialfees = array(
                                    'user_id' =>$id,
                                    'specialfees_id'=>$specialfees_id,
                                    'amount'=>$field['special_fees'],
                                    'effective_month'=>date('Y-m-d H:i:s'),
                                    'endmonth'=>date('Y-m-d H:i:s'),
                                    'created_date'=>date('Y-m-d H:i:s')
                                );
                                $this->common_model->insert_data($data_specialfees,'specialfees_user');
                                $specialuser_id=$this->common_model->max_id('specialfees_user','id');
                            }


                            //-------------------------E N D ------concession /special Amount-----------------

                        }

                        if($feesnotmatch_str!='' || $notAdd_record_msg!="")
                        {
                            $data_errormsg=array(
                                'user_id'=>$field['registration_no'],
                                'error_msg'=>$match_regisno_str.$feesnotmatch_str.$notAdd_record_msg,
                                'created_date'=>date('Y-m-d H:i:s')
                            );
                            $this->common_model->insert_data($data_errormsg,'student_registration_error');
                        }
                    }
                }
                $this->session->set_flashdata("insert_message","The file has been Uploaded Successfully.");
            }// end of end condition
        }

    }








}


?>