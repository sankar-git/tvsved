<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download_excel extends CI_Controller {

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
		$sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }

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
        $data['rs'] = $this->db->get('tbl_student');//$this->common_model->selectAll('tbl_student');
        $this->load->view('admin/studentlist', $data);
    }
    public function excel()
    {
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('STUDENT_LIST');
        //set cell A1 content with some text

        $this->excel->getActiveSheet()->setCellValue('A1', 'REG NO');
        $this->excel->getActiveSheet()->setCellValue('B1', 'ROLL NO');
        $this->excel->getActiveSheet()->setCellValue('C1', 'FIRST NAME');
        $this->excel->getActiveSheet()->setCellValue('D1', 'LAST NAME');
        $this->excel->getActiveSheet()->setCellValue('E1', 'STUDENT EMAIL');
        $this->excel->getActiveSheet()->setCellValue('F1', 'STUDENT PHONE NO');
        $this->excel->getActiveSheet()->setCellValue('G1', 'GENDER');
        $this->excel->getActiveSheet()->setCellValue('H1', 'STREAM');
        $this->excel->getActiveSheet()->setCellValue('I1', 'CATEGORY');
        $this->excel->getActiveSheet()->setCellValue('J1', 'DOB');
        $this->excel->getActiveSheet()->setCellValue('K1', 'ENROLLMENT DATE');
        $this->excel->getActiveSheet()->setCellValue('L1', 'ADDMISSION CLASS');
        $this->excel->getActiveSheet()->setCellValue('M1', 'STUDYING');
        $this->excel->getActiveSheet()->setCellValue('N1', 'SCHOOL NAME');
        $this->excel->getActiveSheet()->setCellValue('O1', 'BOARD');
        $this->excel->getActiveSheet()->setCellValue('P1', 'TOTAL MARKS');
        $this->excel->getActiveSheet()->setCellValue('Q1', 'CHE MARKS');
        $this->excel->getActiveSheet()->setCellValue('R1', 'MATH MARKS');
        $this->excel->getActiveSheet()->setCellValue('S1', 'BIO MARKS');
        $this->excel->getActiveSheet()->setCellValue('T1', 'PHY MARKS');
        $this->excel->getActiveSheet()->setCellValue('U1', 'SCIENCE MARKS');

        $this->excel->getActiveSheet()->setCellValue('V1', 'FATHER NAME');
        $this->excel->getActiveSheet()->setCellValue('W1', 'MOTHER NAME');
        $this->excel->getActiveSheet()->setCellValue('X1', 'FATHER MOBILE NO');
        $this->excel->getActiveSheet()->setCellValue('Y1', 'MOTHER MOBILE NO');

        for($col = ord('A'); $col <= ord('C'); $col++){
            //set column dimension
            $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

            $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        //retrive student table data
        $this->db->select('reg_no, roll_no, first_name,last_name,student_email,student_phone_no,gender,stream,category,dob,enrollment_date,addmission_class,studying,school_name,board,total_marks,che_marks,math_marks,bio_marks,phy_marks,science_marks,father_name,mother_name,guardian_mobile_no,guardian_phone_no');
        
        $rs = $this->db->get('tbl_student');
        $exceldata="";
        $count = 0;
        foreach ($rs->result_array() as $row){
            $exceldata[] = $row;
            }


        //Fill data
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');

        //$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //$this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $filename='STUDENT_LIST.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */