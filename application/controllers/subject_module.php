<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class subject_module extends CI_Controller {

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

        $url='';
        $search='';
        $search='';
        $str='';
        $and='&';

        @$page=$this->input->get('page');
        if($page>0)
        {
            $str.='page='.$page;
            $data['page']=$page;
            $data['page_str']='page='.$page;
        }
        else
        {
            $page = 1;
            $str.='page='.$page;
            $data['page']=$page;
            $data['page_str']='page='.$page;


        }


        $per_page=$this->input->get('per_page');
        if($per_page>0)
        {
            if(trim($str))
            {
                //$str.=$and.'per_page='.$per_page;
                $data['per_page']=$per_page;
                $data['per_page_str']='&per_page='.$per_page;

            }
            else
            {
                //$str.='per_page='.$per_page;
                $data['per_page']=$per_page;
                $data['per_page_str']='&per_page='.$per_page;
            }
        }
        else
        {
            $per_page =100;
            if(trim($str))
            {

                // $str.=$and.'per_page='.$per_page;
                $data['per_page']=$per_page;
                $data['per_page_str']='&per_page='.$per_page;

            }
            else
            {
                // $str.=$and.'per_page='.$per_page;
                $data['per_page']=$per_page;
                $data['per_page_str']='&per_page='.$per_page;
            }

        }

        $cur_page = $page;
        $page -= 1;
        $per_page =  $per_page;
        $previous_btn = true;
        $next_btn = true;
        $first_btn = true;
        $last_btn = true;
        $start = $page * $per_page;
        $str1='';

        @$data['class_details']= $this->common_model->get_where_class_status();
        //@$data['sub'] = $this->common_model->selectsubject('tbl_subject');


        // $data['payment_details']=$this->common_model->add_course_data('tbl_add_course_to_student_payment_details','payment_status','pending');
        $data['sub']= @$this->common_model->common($table_name='tbl_subject',$field=array(),$where=array(),$where_or=array(),$like=array(),$like_or_array=array(),$order=array(),$start=$start,$end=$per_page,$where_in_array=array());
        $data['payment_det_count']= @$this->common_model->common($table_name='tbl_subject',$field=array(),$where=array(),$where_or=array(),$like=array(),$like_or_array=array(),$order=array(),$start='',$end='',$where_in_array=array());
        $count=count($data['payment_det_count']);
        $data['count']=$count;
        $show_data=count($data['sub']);

        if(count($count)>0)
        {

            /* --------------------------------------------- */
            $no_of_paginations = ceil($count / $per_page);
            /* ---------------Calculating the starting and endign values for the loop----------------------------------- */
            $msg='';
            if ($cur_page >= 7)
            {
                $start_loop = $cur_page - 3;
                if ($no_of_paginations > $cur_page + 3)
                    $end_loop = $cur_page + 3;
                else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6)
                {
                    $start_loop = $no_of_paginations - 6;
                    $end_loop = $no_of_paginations;
                }
                else
                {
                    $end_loop = $no_of_paginations;
                }
            }
            else
            {
                $start_loop = 1;
                if ($no_of_paginations > 7)
                    $end_loop = 7;
                else
                    $end_loop = $no_of_paginations;
            }
            /* ----------------------------------------------------------------------------------------------------------- */
            $msg .= "<div class='pagination1'><ul>";

            // FOR ENABLING THE FIRST BUTTON
            if ($first_btn && $cur_page > 1)
            {
                $msg .= "<a href='$url?page=1&per_page=$per_page$str1'><li p='1' class='active'  onclick='page_func(1)'>First</li>";
            }
            else if ($first_btn)
            {
                $msg .= "<li class='inactive'>First</li>";
            }

            // FOR ENABLING THE PREVIOUS BUTTON
            if ($previous_btn && $cur_page > 1)
            {
                $pre = $cur_page - 1;
                $msg .= "<a href='$url?page=$pre&per_page=$per_page$str1'><li p='$pre' class='active'  onclick='page_func($pre)'>Previous</li></a>";
            }
            else if ($previous_btn)
            {
                $msg .= "<li class='inactive'>Previous</li>";
            }
            for ($i = $start_loop; $i <= $end_loop; $i++)
            {

                if ($cur_page == $i)
                    $msg .= "<a href='$url?page=$i&per_page=$per_page$str1'><li p='$i' style='color:#fff;background-color:#2BB34B;' class='active'  onclick='page_func($i)'>{$i}</li></a>";
                else
                    $msg .= "<a href='$url?page=$i&per_page=$per_page$str1'><li p='$i' class='active'  onclick='page_func($i)'>{$i}</li></a>";
            }

            // TO ENABLE THE NEXT BUTTON
            if ($next_btn && $cur_page < $no_of_paginations)
            {
                $nex = $cur_page + 1;
                $msg .= "<a href='$url?page=$nex&per_page=$per_page$str1'><li p='$nex' class='active' onclick='page_func($nex)'>Next</li></a>";
            }
            else if ($next_btn)
            {
                $msg .= "<li class='inactive'>Next</li>";
            }

            // TO ENABLE THE END BUTTON
            if ($last_btn && $cur_page < $no_of_paginations)
            {
                $msg .= "<a href='$url?page=$no_of_paginations&per_page=$per_page$str1'><li p='$no_of_paginations' class='active'  onclick='page_func($no_of_paginations)'>Last</li></a>";
            }
            else if ($last_btn)
            {
                $msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
            }
            /*$goto = "";
            $total_string = "<span class='total' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b></span>";
            $total_string.= "<span class='total'>Showing ".$count ." of ".$show_data ." entries-<b></span>";
            $msg = $msg . "</ul>" . $goto . $total_string . "</div>";  // Content for pagination*/
            $data['msg']=$msg;


        }


        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/subject_view',$data);
        $this->load->view('admin/template/admin_footer');
    }

    function add_course_model($id)
    {
        @$data['s'] = $this->common_model->course($id);
        $this->load->view('admin/add_subject_course_ajax',$data);

    }

    function add_course_fee($id)
    {

        $acc_value = $_REQUEST['acc_value'];
        @$data_tax=$this->common_model->common($table_name='tbl_course',$field=array('course_reg_fee'), $where=array(), $where_or=array(),$like=array('academin_year'=>$acc_value,'course_id'=>$id),$like_or=array(),$order=array());
        @$tax=$data_tax[0]->course_reg_fee;
        echo json_encode(array("amount" =>$tax));

    }
    function add_course_vat($id)
    {
        $acc_value = $_REQUEST['acc_value'];
        @$data_tax=$this->common_model->common($table_name='tbl_course',$field=array('vat'), $where=array(), $where_or=array(),$like=array('academin_year'=>$acc_value,'course_id'=>$id),$like_or=array(),$order=array());
        @$tax=$data_tax[0]->vat;
        echo json_encode(array("amount" =>$tax));
    }
    function add_course_vat_amt($id)
    {
        $acc_value = $_REQUEST['acc_value'];
        @$data_tax=$this->common_model->common($table_name='tbl_course',$field=array('vat_amt'), $where=array(), $where_or=array(),$like=array('academin_year'=>$acc_value,'course_id'=>$id),$like_or=array(),$order=array());
        @$tax=$data_tax[0]->vat_amt;
        echo json_encode(array("amount" =>$tax));
    }

    function add_course_tot_amt($id)
    {
        $acc_value = $_REQUEST['acc_value'];
        @$data_tax=$this->common_model->common($table_name='tbl_course',$field=array('total_amt'), $where=array(), $where_or=array(),$like=array('academin_year'=>$acc_value,'course_id'=>$id),$like_or=array(),$order=array());
        @$tax=$data_tax[0]->total_amt;
        echo json_encode(array("amount" =>$tax));
    }

    function add_vat($id)
    {

        $acc_value = $_REQUEST['acc_value'];
        @$data_tax=$this->common_model->common($table_name='academic_year',$field=array('service_tax'), $where=array(), $where_or=array(),$like=array('academic_year'=>$acc_value),$like_or=array(),$order=array());
        @$tax=$data_tax[0]->service_tax;
        echo json_encode(array("amount" =>$tax));

    }

    function add_class($id)
    {
        $acc_value = $_REQUEST['acc_value'];
        @$data['s'] = $this->common_model->add_class_model($id,$acc_value);

        $this->load->view('admin/add_subject_class_ajax',$data);
    }

    function edit_class($id)
    {
        @$data['s'] = $this->common_model->add_class_model($id);
        $this->load->view('admin/add_subject_edit_class_ajax',$data);
    }

    function add_sub($id)
    {
        @$data['s'] = $this->common_model->add_subject_edit_model($id);
        $this->load->view('admin/edit_subject_ajax_view',$data);
    }

    function add_subject_view()
    {
        @$data['Classes']= $this->common_model->getAllClasses();
        @$data['sub']=$this->common_model->selectAll('tbl_batch');
        @$data['course']=$this->common_model->selectAll('tbl_course');
        @$data['academic_year']=$this->common_model->selectAll('academic_year');
        @$data['payment'] = $this->common_model->selectsub('tbl_payment_head');
        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/add_subject_view',$data);
        $this->load->view('admin/template/admin_footer');
    }

    function add_subject()
    {
        if($this->user_role!=1)
        {
            $this->load->library('permission_lib');
            $this->permission_lib->permit($this->user_id,$this->user_role);
        }

        $ac_year=trim($this->input->post('add_ac_year'));

        $course=trim($this->input->post('add_course'));
        $course_fee=$this->input->post('course_amt');
        $course_vat=$this->input->post('course_vat');
        $course_vat_amt =$this->input->post('course_vat_amt');
        $course_tot_amt = $this->input->post('course_tot_amt');


        $class = $this->input->post('add_sub_class');

        $subject = $this->input->post('add_subject');
        $new_sub = str_replace(' ', '', $subject);

        $data=array(
            'academic_year'             =>  $ac_year,
            'course_name_by_subject'    =>  $course,
            'class_name'                =>  $class,
            'subject_name'              =>  $subject,
            'rep_sub_name'              =>  $new_sub,            
            'course_fee'                =>  $course_fee,
            'course_vat'                =>  $course_vat,
            'course_vat_amt'            =>  $course_vat_amt,
            'course_tot_amt'            =>  $course_tot_amt,
            'status'                    =>  'active'

        );
       /* echo "<pre>";
        print_r($data);
        echo "</pre>";
exit;*/
       $this->common_model->insert_data($data,'tbl_subject');
        $subject_id =$this->db->insert_id();



        $payment_head = $this->input->post('payment_head');
        $p_head = implode(",",$payment_head);
        $new_payment_head = explode(",",$p_head);


        $payment_head_amount = $this->input->post('amount');
        $p_head_amt= implode(",",$payment_head_amount);
        $new_payment_amount = explode(",",$p_head_amt);

        $vat = $this->input->post('vat');
        $vat_amt = $this->input->post('vat_amt');
        $total_amt = $this->input->post('total_amount');

        $payment_head_from_date = $this->input->post('frm_dt');
        $payment_head_to_date = $this->input->post('to_dt');
        $payment_head_des = $this->input->post('describ');
        $p_head_dec = implode(",",$payment_head_des);
        $new_payment_head_des = explode(",",$p_head_dec);




        for($j=0;$j<count(array_filter($new_payment_amount));$j++)
        {
            $data=array(
                'payment_head'=>$payment_head[$j],
                'payment_head_amt'=>$payment_head_amount[$j],
                'payment_head_vat'=>$vat[$j],
                'payment_head_vat_amt'=>$vat_amt[$j],
                'payment_head_total_amt'=>$total_amt[$j],
                'payment_head_frm_dt'=>$payment_head_from_date[$j],
                'payment_head_to_dt'=>$payment_head_to_date[$j]/*date('Y-m-d',strtotime($new_payment_head_to_date))*/,
                'payment_head_des'=>$new_payment_head_des[$j],
                'subject_id'=>$subject_id
            );
          $this->common_model->insert_data($data,'tbl_subject_patment_head_detail');
           /* echo "<pre>";
            print_r($data);
            echo "</pre>";*/
        }
        //exit;
        redirect('subject_module','refresh');
    }

    function edit_subject()
    {
        if($this->user_role!=1)
        {
            $this->load->library('permission_lib');
            $this->permission_lib->permit($this->user_id,$this->user_role);
        }

        $id=$this->input->post('subject_id');

        $ac_year=trim($this->input->post('add_ac_year'));

        $course=trim($this->input->post('add_course'));
        $course_fee=$this->input->post('course_amt');
        $course_vat=$this->input->post('course_vat');
        $course_vat_amt =$this->input->post('course_vat_amt');
        $course_tot_amt = $this->input->post('course_tot_amt');

        $class = $this->input->post('add_sub_class');

        $subject = $this->input->post('add_subject');
        $new_sub = str_replace(' ', '', $subject);



        $data=array(
            'academic_year'             =>  $ac_year,
            'course_name_by_subject'    =>  $course,
            'class_name'                =>  $class,
            'subject_name'              =>  $subject,
            'rep_sub_name'              =>  $new_sub,

            'course_fee'                =>  $course_fee,
            'course_vat'                =>  $course_vat,
            'course_vat_amt'            =>  $course_vat_amt,
            'course_tot_amt'            =>  $course_tot_amt,
            'status'                    =>  'active'
        );
       /* echo "<pre>";
        print_r($data);
        echo "</pre>";*/


        $this->common_model->update_data($data,'tbl_subject','subject_id',$id);


        $payment_head = $this->input->post('payment_head');
        $payment_head_amount = $this->input->post('amount');
        $vat = $this->input->post('vat');
        $vat_amt = $this->input->post('vat_amt');
        $total_amt = $this->input->post('total_amount');

        $p_head = implode(",",$payment_head);
        $new_payment_head = explode(",",$p_head);

        $p_head_amt= implode(",",$payment_head_amount);
        $new_payment_amount = explode(",",$p_head_amt);
        $payment_head_from_date = $this->input->post('frm_dt');
        $payment_head_to_date = $this->input->post('to_dt');
        $payment_head_des = $this->input->post('describ');
        $p_head_dec = implode(",",$payment_head_des);
        $new_payment_head_des = explode(",",$p_head_dec);



        $subject_id =$this->db->insert_id();

        $this->common_model->delete_data('tbl_subject_patment_head_detail','subject_id',$id);

        for($j=0;$j<count(array_filter($new_payment_amount));$j++)
        {
            $data=array(

                'payment_head'=>$payment_head[$j],
                'payment_head_amt'=>$payment_head_amount[$j],
                'payment_head_vat'=>$vat[$j],
                'payment_head_vat_amt'=>$vat_amt[$j],
                'payment_head_total_amt'=>$total_amt[$j],
                'payment_head_frm_dt'=>$payment_head_from_date[$j],
                'payment_head_to_dt'=>$payment_head_to_date[$j]/*date('Y-m-d',strtotime($new_payment_head_to_date))*/,
                'payment_head_des'=>$new_payment_head_des[$j],
                'subject_id'=>$id
            );
            /* echo "<pre>";
             print_r($data);
             echo "</pre>";*/

            $this->common_model->insert_data($data,'tbl_subject_patment_head_detail');

            /*echo "<pre>";
            print_r($data);
            echo "</pre>";*/
        }
        /*exit;*/


        redirect('subject_module','refresh');
    }

    function subject_edit($id)
    {
        $data['edit_sub']       =   $this->common_model->selectOne('tbl_subject','subject_id',$id);
        $acc_year               =   $data['edit_sub'][0]->academic_year;
        $course_by              =   $data['edit_sub'][0]->course_name_by_subject;
        $sub_name               =   $data['edit_sub'][0]->subject_name;
        $data['Classes']        =   $this->common_model->getAllClasses_edit_subject_view($course_by);
        $data['sub']            =   $this->common_model->selectAll('tbl_batch');
        $data['course']         =   $this->common_model->course_edit_subject($acc_year);
        $data['academic_year']  =   $this->common_model->selectAll('academic_year');
        @$data['sub']           =   $this->common_model->add_subject_edit_view_model($course_by);
        $data['payment_head']   =   $this->common_model->selectOne('tbl_subject_patment_head_detail','subject_id',$id);
        $data['payment']        =   $this->common_model->selectsub('tbl_payment_head');

        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/edit_subject_view',$data);
        $this->load->view('admin/template/admin_footer');
    }


    function edit_fees()
    {
        $id=trim($this->input->post('id'));
        $edit_fees=$this->common_model->selectOne('tbl_subject','subject_id',$id);
        echo json_encode(array("edit_fees" => $edit_fees)) ;
    }

    function delete_subject()
    {
        if($this->user_role!=1)
        {
            $this->load->library('permission_lib');
            $this->permission_lib->permit($this->user_id,$this->user_role);
        }

        $id=trim($this->input->post('deleteid'));
        $this->common_model->delete_data('tbl_subject','subject_id',$id);
        $this->common_model->delete_data('tbl_subject_patment_head_detail','subject_id',$id);
        redirect('subject_module','refresh');
    }


    //------------    Active Inactive ----------------------------------

    function sub_admin_active_inactive()
    {
        $value=$this->input->post('value');
        $id=$this->input->post('id');
        $data_sub_admin_active_inactive=array(
            'status'=>$value
        );
        $this->db->where('subject_id', $id);
        $this->db->update('tbl_subject',$data_sub_admin_active_inactive);
    }

    function sub_admin_active_more_than_one_id()
    {
        $sub_admin_id_all=$this->input->post('sub_admin_id');
        $sub_admin_id_array=explode(",",$sub_admin_id_all);
        for($i=0;$i<count($sub_admin_id_array);$i++)
        {
            $sub_admin_id=trim($sub_admin_id_array[$i]);
            $data_sub_admin_active_inactive=array(
                'status'=>'active'
            );
            $this->db->where('subject_id', $sub_admin_id);
            $this->db->update('tbl_subject',$data_sub_admin_active_inactive);
        }

    }

    function sub_admin_in_active_more_than_one_id()
    {
        $sub_admin_id_all       =   $this->input->post('sub_admin_id');
        $sub_admin_id_array     =   explode(",",$sub_admin_id_all);
        for($i=0;$i<count($sub_admin_id_array);$i++)
        {
            $sub_admin_id                   =   trim($sub_admin_id_array[$i]);
            $data_sub_admin_active_inactive =   array(
                'status'=>'inactive'
            );
            $this->db->where('subject_id', $sub_admin_id);
            $this->db->update('tbl_subject',$data_sub_admin_active_inactive);
        }
    }

    //------------ End Active Inactive ----------------------------------
}
?>