<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pending_cheque extends CI_Controller
{

    private $user_name = '';
    private $user_fullname = '';
    private $user_role = 0;
    private $user_email = '';
    private $user_id = '';

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
        }
        else
        {
            redirect('authenticate', 'refresh');
        }
    }

    public function index()
    {
        if ($this->user_role != 1)
        {
            $this->load->library('permission_lib');
            $this->permission_lib->permit($this->user_id, $this->user_role);
        }

        $url = '';
        $search = '';
        $search = '';
        $str = '';
        $and = '&';

        @$page = $this->input->get('page');
        if ($page > 0)
        {
            $str .= 'page=' . $page;
            $data['page'] = $page;
            $data['page_str'] = 'page=' . $page;
        } else
        {
            $page = 1;
            $str .= 'page=' . $page;
            $data['page'] = $page;
            $data['page_str'] = 'page=' . $page;
        }

        $per_page = $this->input->get('per_page');
        if ($per_page > 0)
        {
            if (trim($str))
            {
                //$str.=$and.'per_page='.$per_page;
                $data['per_page'] = $per_page;
                $data['per_page_str'] = '&per_page=' . $per_page;
            }
            else
            {
                //$str.='per_page='.$per_page;
                $data['per_page'] = $per_page;
                $data['per_page_str'] = '&per_page=' . $per_page;
            }
        }
        else
        {
            $per_page = 100;
            if (trim($str))
            {

                // $str.=$and.'per_page='.$per_page;
                $data['per_page'] = $per_page;
                $data['per_page_str'] = '&per_page=' . $per_page;

            }
            else
            {
                // $str.=$and.'per_page='.$per_page;
                $data['per_page'] = $per_page;
                $data['per_page_str'] = '&per_page=' . $per_page;
            }
        }

        $cur_page = $page;
        $page -= 1;
        $per_page = $per_page;
        $previous_btn = true;
        $next_btn = true;
        $first_btn = true;
        $last_btn = true;
        $start = $page * $per_page;
        $str1 = '';

        $data['payment_details'] = $this->common_model->pending_check_limit('tbl_add_course_to_student_payment_details', 'check_status', '3', 'payment_status', 'pending',$start,$per_page);
        //echo $sql = $this->db->last_query();
        $data['payment_det_count'] = $this->common_model->common($table_name = 'tbl_add_course_to_student_payment_details', $field = array(), $where = array('check_status' => '3', 'payment_status' => 'pending'), $where_or = array(), $like = array(), $like_or_array = array(), $order = array(), $start = '', $end = '', $where_in_array = array());
        $count = count($data['payment_det_count']);
        $data['count'] = $count;
        $show_data = count($data['payment_details']);

        if (count($count) > 0)
        {
            /* --------------------------------------------- */
            $no_of_paginations = ceil($count / $per_page);
            /* ---------------Calculating the starting and endign values for the loop----------------------------------- */
            $msg = '';
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
            $data['msg'] = $msg;
        }
        // @$data['payment_details']=$this->common_model->add_course_data('tbl_add_course_to_student_payment_details','check_status','3');
        $data['title']="Pending Cheque";
        $this->load->view('admin/template/admin_header');
        $this->load->view('admin/template/admin_leftmenu');
        $this->load->view('admin/pending_cheque', $data);
        $this->load->view('admin/template/admin_footer');
        echo ob_get_clean();
        flush();
        ob_start();
    }

    function receive_payment_model($id)
    {
        @$payment_id = $id;
        @$st_id = explode('_', $payment_id);
        //print_r($st_id);exit;
        @$id = $this->common_model->max_id('tbl_add_course_to_student_payment_details', 'recepit_no');
        @$mal_data['email_data'] = $this->common_model->selectAll('tblemail');
        @$admin_mail = $mal_data['email_data'][0]->from_email;
        @$st_data['st_detail'] = $this->common_model->add_course_data('tbl_add_course_to_student_payment_details', 'payment_id', $id);
        @$rec_no = $st_data['st_detail'][0]->recepit_no;
        @$st_data['rec_detail'] = $this->common_model->add_course_data('tbl_add_course_to_student_payment_details', 'recepit_no', $rec_no);
        @$student_id = $st_data['st_detail'][0]->student_id;
        @$st_data['st_detail'] = $this->common_model->add_course_data('tbl_student', 'student_id', $student_id);
        @$student_email = $st_data['st_detail'][0]->student_email;
        @$payment_date = date('Y-m-d');

        for ($i = 0; $i < count(array_filter($st_id)); $i++)
        {
            if (strlen($id) == 1)
            {
                $rec_no = "111" . $id + 1;
            }
            else if (strlen($id) == 2)
            {
                $rec_no = "11" . $id + 1;
            }
            else if (strlen($id) == 3)
            {
                $rec_no = "1" . $id + 1;
            }
            else
            {
                $rec_no = $id + 1;
            }

            @$data['details'][] = $this->common_model->add_course_data('tbl_add_course_to_student_payment_details', 'payment_id', $st_id[$i]);
            @$rec_status = $data['details'][$i][0]->payment_status;

            $data = array(
                'payment_date' => $payment_date,
                'payment_status' => 'paid',
                'recepit_no' => $rec_no+$i,
                'check_status' => '1'
            );

            @$this->common_model->update_data($data, 'tbl_add_course_to_student_payment_details', 'ack_no', $st_id[$i]);
            $id+1;
            @$this->email->set_mailtype("html");
            @$html_subscriber_user = $this->load->view('admin/mail_template/check_clear', $st_data, true);
            //echo "<pre>";print_r($html_subscriber_user);exit;
            @$this->email->from('admin@parthaedu.com');
            @$this->email->to($student_email);
            @$this->email->subject('Payment Received');
            @$this->email->message($html_subscriber_user);
            @$result = $this->email->send();
            // echo $this->email->print_debugger();
        }
        // exit;
        redirect('pending_cheque');
    }

    public function excel()
    {
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Countries');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('B1', 'STUDENT ROLL NO');
        $this->excel->getActiveSheet()->setCellValue('C1', 'STUDENT REG NO');
        $this->excel->getActiveSheet()->setCellValue('D1', 'STUDENT FIRST NAME');
        $this->excel->getActiveSheet()->setCellValue('E1', 'STUDENT LAST NAME');
        $this->excel->getActiveSheet()->setCellValue('F1', 'RECEIVING DATE');
        $this->excel->getActiveSheet()->setCellValue('G1', 'CHEQUE NUMBER');
        $this->excel->getActiveSheet()->setCellValue('H1', 'BANK NAME');
        $this->excel->getActiveSheet()->setCellValue('I1', 'TOTAL AMT');
        $this->excel->getActiveSheet()->setCellValue('A1', 'ACK NO');

        $payment_details = $this->common_model->pending_check('tbl_add_course_to_student_payment_details', 'check_status', '3', 'payment_status', 'pending');
        $count = 2;
        foreach (@$payment_details as $pd)
        {
            @$student_id = $pd->student_id;
            @$payment_head_id = $pd->payment_head_name;
            @$course_id = $pd->course_id;
            @$student_details = $this->common_model->add_course_data('tbl_student', 'student_id', $student_id);
            @$payment_head_details = $this->common_model->add_course_data('tbl_payment_head', 'payment_id', $payment_head_id);
            @$std_course_id = $this->common_model->add_course_data('tbl_add_course_to_student', 'add_course_id', $course_id);
            @$course_name_id = $std_course_id[0]->course_name;
            @$course_details = $this->common_model->add_course_data('tbl_course', 'course_id', $course_name_id);
            @$subject_id = $pd->subject_id;
            @$sub_details = $this->common_model->add_course_data('tbl_subject', 'subject_id', $subject_id);
            @$rec_no = $pd->ack_no;
            @$pay_rec_details = $this->common_model->add_course_data('tbl_add_course_to_student_payment_details', 'recepit_no', $rec_no);
            @$payment_tot_amt = $this->common_model->payment_head_detail('tbl_add_course_to_student_payment_details', 'check_status', '3', 'ack_no', $rec_no);
            @$total_fees = 0;
            @$total_vat_amt = 0;
            @$total_amt = 0;
            foreach ($payment_tot_amt as $pending_payment_details)
            {
                if ($pending_payment_details->payment_head_name == 'Exam Fees')
                {
                    $payment_head_fee = $pending_payment_details->exam_fee;
                }
                else if ($pending_payment_details->payment_head_name == 'Reg Fees')
                {
                    $payment_head_fee = $pending_payment_details->course_reg_fee;
                }
                else if ($pending_payment_details->payment_head_name == "Discount" || $pending_payment_details->payment_head_name == "Add_fee")
                {
                    $payment_head_fee = $pending_payment_details->discount_fee;
                }
                else
                {
                    $payment_head_fee = $pending_payment_details->payment_head_amt;
                }

                if ($pending_payment_details->payment_head_name == 'Exam Fees')
                {
                    $vat_fee = $pending_payment_details->exam_vat_fee;
                }
                else if ($pending_payment_details->payment_head_name == 'Reg Fees')
                {
                    $vat_fee = $pending_payment_details->course_fee_vat_amt;
                }
                else if ($pending_payment_details->payment_head_name == "Discount" || $pending_payment_details->payment_head_name == "Add_fee")
                {
                    $vat_fee = $pending_payment_details->discount_vat_amt;
                }
                else
                {
                    $vat_fee = $pending_payment_details->payment_head_vat_amt;
                }

                if ($pending_payment_details->payment_head_name == 'Exam Fees')
                {
                    @$tot_fee = $pending_payment_details->exam_tot_amt;
                }
                else if ($pending_payment_details->payment_head_name == 'Reg Fees')
                {
                    @$tot_fee = $pending_payment_details->course_vat_tot_amt;
                }
                else if ($pending_payment_details->payment_head_name == "Discount" || $pending_payment_details->payment_head_name == "Add_fee")
                {
                    $tot_fee = $pending_payment_details->discount_tot_amt;
                }
                else
                {
                    @$tot_fee = $pending_payment_details->payment_head_tot_amt;
                }
                @$total_fees += $payment_head_fee;
                @$total_vat_amt += $vat_fee;
                @$total_amt += $tot_fee;
            }

            $ack_no = $pd->ack_no;
            $roll_no = $student_details[0]->roll_no;
            $reg_no = $student_details[0]->reg_no;
            $first_name = $student_details[0]->first_name;
            $last_name = $student_details[0]->last_name;
            $rec_date = $pd->payment_date;
            $cheque_no = $pd->check_no;
            $bank_name = $pd->bank_name;

            $this->excel->getActiveSheet()->setCellValue("A" . $count, $ack_no);
            $this->excel->getActiveSheet()->setCellValue("B" . $count, $roll_no);
            $this->excel->getActiveSheet()->setCellValue("C" . $count, $reg_no);
            $this->excel->getActiveSheet()->setCellValue("D" . $count, $first_name);
            $this->excel->getActiveSheet()->setCellValue("E" . $count, $last_name);
            $this->excel->getActiveSheet()->setCellValue("F" . $count, $rec_date);
            $this->excel->getActiveSheet()->setCellValue("G" . $count, $cheque_no);
            $this->excel->getActiveSheet()->setCellValue("H" . $count, $bank_name);
            $this->excel->getActiveSheet()->setCellValue("I" . $count, $total_amt);
            //$this->excel->getActiveSheet()->setCellValue("I" . $count, $father_mobile_no);
            //$this->excel->getActiveSheet()->setCellValue("J" . $count, $mother_mobile_no);
            $count++;
        }


        $filename = 'pendingcheque.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    function delete_cheque($id)
    {
        if ($this->user_role != 1)
        {
            $this->load->library('permission_lib');
            $this->permission_lib->permit($this->user_id, $this->user_role);
        }
         @$payment_id = $id;
        @$acck_no = explode('_', $payment_id);
        for($i=0;$i<count(array_filter($acck_no));$i++)
        {
            $this->db->where('ack_no',$acck_no[$i]);
            $this->db->delete('tbl_add_course_to_student_payment_details');
        }
        redirect('pending_cheque');
    }

    function bounced_cheque($id)
    {
        if ($this->user_role != 1)
        {
            $this->load->library('permission_lib');
            $this->permission_lib->permit($this->user_id, $this->user_role);
        }
        $payment_id = $id;
        @$acck_no = explode('_', $payment_id);
        for ($i = 0; $i < count(array_filter($acck_no)); $i++)
        {
            $data = array(
                'check_status' => '2',
                'payment_status'=>'pending'
            );
            @$this->common_model->update_data($data, 'tbl_add_course_to_student_payment_details', 'ack_no',$acck_no[$i]);
            //@$this->common_model->update_data($data, 'tbl_add_course_to_student_payment_details', 'check_no', $st_id[$i]);
        }

         //exit;
        redirect('pending_cheque');
    }

   


}
?>