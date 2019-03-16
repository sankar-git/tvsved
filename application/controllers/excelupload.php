<?php
ob_start();
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Excelupload extends CI_Controller {
	
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
			$this->load->model('newsession_model');
			$this->load->helper('email');
			$this->load->model('newsession_model');
			$this->load->model('common_model');
			$this->load->model('user_model');
			$this->load->model('type_model');
			$this->load->model('Master_model');
			$this->load->model('Marks_model');
			$this->load->model('Discipline_model');
			$this->load->model('Generate_model');
			$this->load->library('permission_lib');
			$this->load->model('Excel_model');
			
			
			$this->load->library('excel');
			$sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }
			
			
	}
	//======================================UG Marks Upload Start==================================================//
	function uploadUgMarksExcel()
	{
		 $data['page_title']='Upload Marks Excel';
		 $data['campuses'] = $this->Discipline_model->get_campus();
		 $data['degrees'] = $this->Discipline_model->get_degree(); 
		 $data['programs'] = $this->Discipline_model->get_program(); 
		 $data['batches'] = $this->Discipline_model->get_batch(); 
         $data['semesters'] = $this->Discipline_model->get_semester(); 	
         $data['disciplines'] = $this->Discipline_model->get_discipline(); 		 
		 $this->load->view('admin/excel/add_ug_marks_bvsc_excel_view',$data);
	}
	//======================================UG Marks Upload End==================================================//
	
	
	function getCourseByIds()
	{
		//print_r($_POST); exit;
		$campus_id = $this->input->post('campus_id');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$batch_id = $this->input->post('batch_id');
		$semester_id = $this->input->post('semester_id');
		$discipline_id = $this->input->post('discipline_id');
		
		$data['courses']=$this->Marks_model->get_course_by_ids($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id); 
		//print_r($data['programs']); exit;
		$str = '';
         foreach($data['courses'] as $k=>$v){ 
           $str .= "<option value=".$v->id.">".$v->course_code.'-'.$v->course_title."</option>";
           }
		   echo $str;
	}
	//----------------  Download Discipline Excel ----------------------------//
      function downloadMarksFormat()
	  {  
		  if($this->input->post('downloadExcel'))
		  {
			 // echo "<pre>";
			 //p($_POST); //exit;
			 $theoryarr = array();
			 $practicalarr = array();
			 $external = array();
			 
			 $degree_id = $this->input->post('degree_id');
			// if($degree_id == '')
				// $degree_id = $this->input->post('degree_idd');
			
			 $campus_id = $this->input->post('campus_id');
			 $program_id = $this->input->post('program_id');
			 $batch_id = $this->input->post('batch_id');
			 $semester_id = $this->input->post('semester_id');
			 $course_id = $this->input->post('course_id');
			 $discipline_id = $this->input->post('discipline_id');
			 $mark_type = $this->input->post('marks_type');
			 $date_of_start = $this->input->post('date_of_start');
			
			 $campuses = $this->Excel_model->get_campus_by_id($campus_id);
			 $programs = $this->Excel_model->get_program_by_id($program_id);
			 $degrees = $this->Excel_model->get_degree_by_id($degree_id);
			 $batches = $this->Excel_model->get_batch_by_id($batch_id);
			 $semesters = $this->Excel_model->get_semester_by_id($semester_id);
			 $disciplines = $this->Excel_model->get_discipline_by_id($discipline_id);
			$pos = strpos($course_id, '|');
			 if ($pos === false) {
				$courses = $this->Excel_model->get_course_by_id($course_id);
				$course_title = $courses->course_title;
			 }else{
				 $course_Arr = explode("|",$course_id);
				 $course_group_id = $course_Arr[0];
				 $course_idArr = explode("-",$course_Arr[1]);
				// print_r( $course_idArr);
				 $courses_group = $this->Excel_model->get_course_group_by_id($course_id);
				 $courses1 = $this->Excel_model->get_course_by_id($course_idArr[0]);
				 $courses2 = $this->Excel_model->get_course_by_id($course_idArr[1]);
				$course_title = $courses_group->course_subject_title.' ('.$courses1->course_code.','.$courses2->course_code.')';
			 }
			 
			 /*$dos = $this->Generate_model->get_date_by_degree($degree_id); 
			// echo $dos[1]->id;
			 for($j=0;$j<count($dos);$j++)
			 {
				 if($dos[$j]->id == $date_of_start)
				 {
					 $dateofstart = $dos[$j]->start_date;
					 break;
					 } 
			 }*/
			// print_r($dos);exit;
			 $credits = $this->Marks_model->get_course_credit_points($course_id);
			// print_r($credits[0]->practicle_credit);//exit;
			 $data['students']=$this->Marks_model->get_ug_students_by_ids($campus_id,$program_id,$degree_id,$batch_id); 
			// p($data['students']); exit;
			if($degree_id==1 && $program_id == 1){
            //$finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Student Name','INTERNAL FIRST(10)',' INTERNAL SECOND(10)',' INTERNAL THIRD(10)','PRACTICAL PAPER-I(60)','PRACTICAL PAPER-II(60)','EXTERNAL PAPER-I(100)','EXTERNAL PAPER-II(100)');
            $finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Student ID','Student Name');
			//if($credits[0]->theory_credit != '0' && ($mark_type == '1'|| $mark_type == '3'))
				$theoryarr = array('Internal theory first(40)','Internal theory second(40)','Internal theory third(40)');
			//if($credits[0]->practicle_credit != '0' && $mark_type == '1' || $mark_type == '3')
				$practicalarr = array('Practical Paper I(60)','Practical Paper II(60)');
			//if($mark_type == '2' || $mark_type == '3')
				$external = array('External Paper I(100)','External Paper II(100)');
			$finalExcelArr = array_merge($finalExcelArr,$theoryarr,$practicalarr,$external);
			//p($finalExcelArr);exit;
           $objPHPExcel = new PHPExcel();
           $objPHPExcel->setActiveSheetIndex(0);
           $objPHPExcel->getActiveSheet()->setTitle('Student Worksheet');
           $cols= array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
            $j=2;
            
            //For freezing top heading row.
            $objPHPExcel->getActiveSheet()->freezePane('A2');

            //Set height for column head.
            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                        
           for($i=0;$i<count($finalExcelArr);$i++){
            
            //Set width for column head.
            $objPHPExcel->getActiveSheet()->getColumnDimension($cols[$i])->setAutoSize(true);

            //Set background color for heading column.
            $objPHPExcel->getActiveSheet()->getStyle($cols[$i].'1')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '71B8FF')
                    ),
                      'font'  => array(
                      'bold'  => false,
                      'size'  => 15,
                      )
                )
            );

            $objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'1', $finalExcelArr[$i]);

            foreach ($data['students'] as $key => $value) {
             
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $campuses->campus_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $programs->program_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[2].$newvar, $degrees->degree_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[3].$newvar, $batches->batch_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[4].$newvar, $semesters->semester_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[5].$newvar, $disciplines->discipline_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[6].$newvar, $course_title);
            //$objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $dateofstart);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->user_unique_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->first_name.' '.$value->last_name);
            
			
            }
          }

        $filename  = $course_title.'_'.'bvsc_marks_upload.xls';
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');
        exit;
          }
		 
		  if($degree_id!=1){
		//ini_set("display_errors","On");
		 // error_reporting(E_ALL);echo "coming";exit;
			  // $finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Student Name','INTERNAL THEORY(30)','INTERNAL PRACTICAL(20)','EXTERNAL THEORY(50)');
			   $finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Student ID','Student Name');
			   if($program_id == 1){
					if($credits[0]->theory_credit != '0' && $credits[0]->practicle_credit != '0')
						$theoryarr = array('Theory(30)','Assignment(5)','Practical(15)');
					else if($credits[0]->theory_credit != '0' )
						$theoryarr = array('Theory(40)','Assignment(10)');
					else if($credits[0]->practicle_credit != '0' )
						$theoryarr = array('Assignment(10)','Practical(40)');
					$external = array('External Theory(50)');
			   }else{
					$theoryarr = array('Internal Theory(20)','TermPaper(10)','Internal Practical(50/100)');
					$external = array('External Theory(70/100)');
			   }
			$finalExcelArr = array_merge($finalExcelArr,$theoryarr,$external);
			//p($finalExcelArr);exit;
			   $objPHPExcel = new PHPExcel();
			   $objPHPExcel->setActiveSheetIndex(0);
			   $objPHPExcel->getActiveSheet()->setTitle('Student Worksheet');
			   $cols= array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
				$j=2;
            
            //For freezing top heading row.
            $objPHPExcel->getActiveSheet()->freezePane('A2');

            //Set height for column head.
            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                        
           for($i=0;$i<count($finalExcelArr);$i++){
            
            //Set width for column head.
            $objPHPExcel->getActiveSheet()->getColumnDimension($cols[$i])->setAutoSize(true);

            //Set background color for heading column.
            $objPHPExcel->getActiveSheet()->getStyle($cols[$i].'1')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '71B8FF')
                    ),
                      'font'  => array(
                      'bold'  => false,
                      'size'  => 15,
                      )
                )
            );

            $objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'1', $finalExcelArr[$i]);

            foreach ($data['students'] as $key => $value) {
             
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $campuses->campus_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $programs->program_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[2].$newvar, $degrees->degree_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[3].$newvar, $batches->batch_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[4].$newvar, $semesters->semester_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[5].$newvar, $disciplines->discipline_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[6].$newvar, $course_title);
			//$objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $dateofstart);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->user_unique_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->first_name.' '.$value->last_name);
            
			
            }
          }

			$filename  = $course_title.'_'.'btech_marks_upload.xls';
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
			ob_end_clean();
			ob_start();
			$objWriter->save('php://output');
			exit;  
		  }
		  } 
 		
}
//----------End Download Excel File ---------------------//
	function excelUploadMarks()
	{
		
	  if($this->input->post('uploadExcel'))
	   {
		   //echo"hello"; exit;
		   
	    $fileName    = $_FILES['userfile']['tmp_name'];
		$objPHPExcel = PHPExcel_IOFactory::load($fileName);
		$maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();
		$rowsold     = $objPHPExcel->getActiveSheet()->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row']); 
		$rowsoldHeader     = $objPHPExcel->getActiveSheet()->toArray(); 
		$sheetName   = $objPHPExcel->getActiveSheet()->getTitle();
		$brandid              = explode('#', $sheetName);

       //  p($rowsold);exit;
            
			 
		     $campuses = $this->Excel_model->get_campus_by_name($rowsold[1][0]);
			 $programs = $this->Excel_model->get_program_by_name($rowsold[1][1]);
			 //p($programs); exit;
			 $degrees = $this->Excel_model->get_degree_by_name($rowsold[1][2]);
			 //p($degrees); exit;
			 $batches = $this->Excel_model->get_batch_by_name($rowsold[1][3]);
			 $semesters = $this->Excel_model->get_semester_by_name($rowsold[1][4]);
			 $disciplines = $this->Excel_model->get_discipline_by_name($rowsold[1][5]);
			$degree_id = $degrees->id;
			$program_id = $programs->id;
			 if($degree_id==1 && $program_id == 1){
				  $pos = strpos($rowsold[1][6], '|');
				if ($pos === false) {
					$courseGroupArr = explode(" (",$rowsold[1][6]);
					$courseArr = explode(",",str_replace(")","",$courseGroupArr[1]));
					$courses_group = $this->Excel_model->get_course_by_group(trim($courseGroupArr[0]));
					$courses1 = $this->Excel_model->get_course_by_code($courseArr[0],$courses_group->id);
					$courses2 = $this->Excel_model->get_course_by_code($courseArr[1],$courses_group->id);
					$course_id = $courses_group->id.'|'.$courses1->id.'-'.$courses2->id;
				}
				else{
				 $courses = $this->Excel_model->get_course_by_name($rowsold[1][6]);
				 $course_id =$courses->id;
				}
			 }else{
				 $courses = $this->Excel_model->get_course_by_name($rowsold[1][6]);
				 $course_id =$courses->id;
			 }
			 //echo $course_id;exit;
			// $dateofstart = $this->Excel_model->get_course_by_name($rowsold[1][6]);
			  $dos = $this->Generate_model->get_date_by_degree($degrees->id); 
			// echo $dos[1]->id;
			$dateofstart='';
			/* for($j=0;$j<count($dos);$j++)
			 {
				 if($dos[$j]->start_date == $rowsold[1][7])
				 {
					 $dateofstart = $dos[$j]->id;
					 break;
					 } 
			 }*/
			 
			 $internal_practical1='';
			 $internal_practical2='';
			 $get_internal_practical1='';
			 $get_internal_practical2='';
			 $sum_get_internal_practicals='';
			 $sum_get_internal_practical='';
		     $m =0;
			 $register_date_time=date('Y-m-d H:i:s');
			for($i=1;$i<=count($rowsold);$i++)
			{				
				$firstrow = $rowsold[$i];
				$assignment_mark='';
				if($firstrow[9] != '')
				{
					if($degree_id == 1 && $program_id==1){
						$internal_marks1=$firstrow[9];
						$internal_marks2=$firstrow[10];
						$internal_marks3=$firstrow[11];	 
						$internal_practical1=$firstrow[12];
						$internal_practical2=$firstrow[13]; 
						$theory_external1=$firstrow[14];
						$theory_external2=$firstrow[15];
					}elseif($degree_id != 1 && $program_id==1){
						if($credits[0]->theory_credit != '0' && $credits[0]->practicle_credit != '0'){
							$internal_marks1=$firstrow[9];
							$assignment_mark=$firstrow[10];
							$internal_practical1=$firstrow[11];
							$theory_external1=$firstrow[12];
						}else if($credits[0]->theory_credit != '0' ){
							$internal_marks1=$firstrow[9];
							$assignment_mark=$firstrow[10];
							$theory_external1=$firstrow[11];
						}else if($credits[0]->practicle_credit != '0' ){
							$assignment_mark=$firstrow[9];
							$internal_practical1=$firstrow[10];
							$theory_external1=$firstrow[11];
						}
					}elseif($degree_id != 1 && $program_id!=1){
						$internal_marks1=$firstrow[9];
						$assignment_mark=$firstrow[10];
						$internal_practical1=$firstrow[11];
						$theory_external1=$firstrow[12];
					}
					 $stud_id = $firstrow[7];
					 $stud = explode(' ',$firstrow[8]);
					 
					// print_r($stud);
					 $students = $this->Excel_model->get_student_by_id($stud_id);
					// p($students); 
					if(@$students->id<=0){
						$errormessage = $stud_id .' not exists in the database. Please check the excel sheet';
						$this->session->set_flashdata('errormessage', $errormessage);
						redirect(base_url().'excelupload/uploadUgMarksExcel');exit;
					}
					//for update work
					$check_student = $this->Excel_model->get_student_already_uploaded($campuses->id,$programs->id,$degrees->id,$batches->id,$semesters->id,$disciplines->id,$course_id,@$students->id);
					//p($check_student); exit;
					//echo "sfdsfs";
					if(!empty($check_student->student_id))
					{
						//echo "hii"; exit;
						
						$update_ug_marks           =array(
						'campus_id'     =>($campuses->id) ? $campuses->id:'',
						'program_id'     =>($programs->id) ? $programs->id : '',
						'degree_id'     =>($degrees->id) ? $degrees->id : '',
						'batch_id'     =>($batches->id) ? $batches->id : '',
						'semester_id'     =>($semesters->id) ? $semesters->id : '',
						'discipline_id'     =>($disciplines->id) ? $disciplines->id : '',
						'course_id'     =>($course_id) ? $course_id : '',
						'student_id'    =>($students->id) ? $students->id : '',
						'theory_internal1'    =>($internal_marks1) ? $internal_marks1 : '',
						'theory_internal2'    =>($internal_marks2) ? $internal_marks2 : '',
						'theory_internal3'    =>($internal_marks3) ? $internal_marks3 : '',
						//'theory_internal'    =>($largesum) ? $largesum : '',
						'date_of_start' => ($firstrow[7]) ? $firstrow[7] : '',
						'theory_external1'    =>($theory_external1) ? $theory_external1 : '',
						'theory_external2'    =>($theory_external2) ? $theory_external2 : '',
						'practical_internal'    =>($internal_practical1) ? $internal_practical1 : '',
						'practical_external'    =>($internal_practical2) ? $internal_practical2 : '',
						//'theory_paper1'    =>($internal_practical1) ? $internal_practical1 : '',
						//'theory_paper2'    =>($internal_practical2) ? $internal_practical2 : '',
						//'sum_internal_practical'    =>($sum_get_internal_practical) ? $sum_get_internal_practical : '',
						//'theory_external'    =>($firstrow[13]) ? $firstrow[13] : '',
						//'practical_external'    =>($firstrow[14]) ? $firstrow[14] : '',
						'assignment_mark'    =>($assignment_mark) ? $assignment_mark : '',
						'created_on'    =>($register_date_time) ? $register_date_time : '',
						
						

						);
						//p($update_ug_marks); exit;
						$savedata = $this->Excel_model->update_ug_marks_excel($update_ug_marks);
						
					}
					elseif($students->id>0)
					{
					  //echo "helo";//exit;
						$save_ug_marks           = array(
						'campus_id'     =>($campuses->id) ?  $campuses->id:'',
						'program_id'     =>($programs->id) ? $programs->id : '',
						'degree_id'     =>($degrees->id) ? $degrees->id : '',
						'batch_id'     =>($batches->id) ? $batches->id : '',
						'semester_id'     =>($semesters->id) ? $semesters->id : '',
						'discipline_id'     =>($disciplines->id) ? $disciplines->id : '',
						'course_id'     =>($course_id) ? $course_id : '',
						'student_id'    =>($students->id) ? $students->id : '',
						'theory_internal1'    =>($internal_marks1) ? $internal_marks1 : '',
						'theory_internal2'    =>($internal_marks2) ? $internal_marks2 : '',
						'theory_internal3'    =>($internal_marks3) ? $internal_marks3 : '',
						//'theory_internal'    =>($largesum) ? $largesum : '',
						'practical_internal'    =>($internal_practical1) ? $internal_practical1 : '',
						'practical_external'    =>($internal_practical2) ? $internal_practical2 : '',
						'theory_external1'    =>($theory_external1) ? $theory_external1 : '',
						'theory_external2'    =>($theory_external2) ? $theory_external2 : '',
						//'sum_internal_practical'    =>($sum_get_internal_practical) ? $sum_get_internal_practical : '',
						//'theory_external'    =>($firstrow[13]) ? $firstrow[13] : '',
						//'practical_external'    =>($firstrow[14]) ? $firstrow[14] : '',
						//'external_sum'    =>($total_external) ? $total_external : '',
						//'date_of_start' => ($firstrow[7]) ? $firstrow[7] : '',
						'assignment_mark'    =>($assignment_mark) ? $assignment_mark : '',
						'created_on'    =>($register_date_time) ? $register_date_time : '',
						);
						//p($save_ug_marks); exit;
						$savedata = $this->Excel_model->save_ug_marks_excel($save_ug_marks);
						
					}
					$m++;
				}
			}
        }
	    $this->session->set_flashdata('message', 'Excel uploaded successfully.');
        redirect(base_url().'excelupload/uploadUgMarksExcel');
    }

}
?>