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
			 $exam_type = $this->input->post('exam_type');
			
			 $campuses = $this->Excel_model->get_campus_by_id($campus_id);
			 $programs = $this->Excel_model->get_program_by_id($program_id);
			 $degrees = $this->Excel_model->get_degree_by_id($degree_id);
			 $batches = $this->Excel_model->get_batch_by_id($batch_id);
			 $semesters = $this->Excel_model->get_semester_by_id($semester_id);
			 $disciplines = $this->Excel_model->get_discipline_by_id($discipline_id);
			$pos = strpos($course_id, '|');
			$non_credit=false;
			 if ($pos === false) {
				$courses = $this->Excel_model->get_course_by_id($course_id);
				$course_title = $courses->course_title;
			 }else{
				 $course_Arr = explode("|",$course_id);
				 $course_group_id = $course_Arr[0];
				 $course_idArr = explode("-",$course_Arr[1]);
				 $courses_group = $this->Excel_model->get_course_group_by_id($course_group_id);
				 $courses1 = $this->Excel_model->get_course_by_id($course_idArr[0]);
				 $courses2 = $this->Excel_model->get_course_by_id($course_idArr[1]);
				 if(isset($course_idArr[2])){
					 $courses3 = $this->Excel_model->get_course_by_id($course_idArr[2]);
					 $course_title = $courses_group->course_subject_title.' ('.$courses1->course_code.','.$courses2->course_code.','.$courses3->course_code.')';
				 }else
				 	$course_title = $courses_group->course_subject_title.' ('.$courses1->course_code.','.$courses2->course_code.')';
				if(trim($courses_group->course_subject_title) == 'NON CREDIT'){
					$non_credit=true;
				}
			 }
			// p($courses_group);
			 //exit;
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
			 if($mark_type == 1)
				 $file_name= 'internal';
			 else
				 $file_name = 'external';
			 if($exam_type == 1)
				 $exam_type_str= 'Regular';
			 else
				 $exam_type_str = 'Cap';
			 
			// print_r($dos);exit;
			$pos = strpos($course_id, '|');
			 if ($pos !== false) {
				 $credits = $this->Marks_model->get_course_credit_points($course_idArr[0]);
			 }else
				$credits = $this->Marks_model->get_course_credit_points($course_id);
			// print_r($credits[0]->practicle_credit);//exit;
			 //$data['students']=$this->Marks_model->get_ug_students_by_ids($campus_id,$program_id,$degree_id,$batch_id,$exam_type); 
			  $send['campus_id']=$campus_id;
	    $send['program_id']=$program_id;
	    $send['degree_id']=$degree_id;
	    $send['batch_id']=$batch_id;
	    $send['semester_id']=$semester_id;
	    $send['discipline_id']=$discipline_id;
	    $send['exam_type']=$exam_type;
	    $send['marks_type']=$mark_type;
	    $send['course_id']=$course_id;
			  $data['students']=$studentList= $this->Marks_model->get_student_assigned_marks($send);
			  //echo $this->db->last_query();exit;
			if($mark_type == 1 && $exam_type == 2){
				$send['exam_type']=1;
				$data['regstudentsmarks']=$this->Marks_model->get_student_assigned_marks($send);
			}
			//p($data['students']); exit;
			if($degree_id==1 && $program_id == 1){
            //$finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Student Name','INTERNAL FIRST(10)',' INTERNAL SECOND(10)',' INTERNAL THIRD(10)','PRACTICAL PAPER-I(60)','PRACTICAL PAPER-II(60)','EXTERNAL PAPER-I(100)','EXTERNAL PAPER-II(100)');
			if($non_credit == true){
				$finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Student ID','Student Name');
			}elseif($mark_type == 1)
				$finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Student ID','Student Name');
			else
				$finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Student Dummy No');
			//if($credits[0]->theory_credit != '0' && ($mark_type == '1'|| $mark_type == '3'))
				
			//if($credits[0]->practicle_credit != '0' && $mark_type == '1' || $mark_type == '3')
				if($non_credit == true){
					$non_credit = array('Satisfactory/Not Satisifactory');
					$finalExcelArr = array_merge($finalExcelArr,$non_credit);
				}elseif($mark_type == 1){
					$theoryarr = array('Internal theory first(40)','Internal theory second(40)','Internal theory third(40)');
					$practicalarr = array('Practical Paper I(60)','Practical Paper II(60)');
					$finalExcelArr = array_merge($finalExcelArr,$theoryarr,$practicalarr);
				}elseif($mark_type == 2){
					$external = array('External Paper I(100)','External Paper II(100)');
					$finalExcelArr = array_merge($finalExcelArr,$external);
				}
				$exam_typeArr = array('Exam Type(Regular/Cap)');
			$finalExcelArr = array_merge($finalExcelArr,$exam_typeArr);
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
				if($non_credit == true){
					$objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->user_unique_id);
					$objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->first_name.' '.$value->last_name);
				}elseif($mark_type == 1){
					$objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->user_unique_id);
					$objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->first_name.' '.$value->last_name);
					if($exam_type == 2){
						foreach($data['regstudentsmarks'] as $key1=>$res){
							if($value->id == $res->id){
								$objPHPExcel->getActiveSheet()->setCellValue($cols[9].$newvar, $res->theory_internal1);
								$objPHPExcel->getActiveSheet()->setCellValue($cols[10].$newvar, $res->theory_internal2);
								$objPHPExcel->getActiveSheet()->setCellValue($cols[11].$newvar, $res->theory_internal3);
							}
						}
					}
				}else{
					$objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->dummy_value);
				}
				$objPHPExcel->getActiveSheet()->setCellValue($cols[count($finalExcelArr)-1].$newvar, $exam_type_str);
			
            }
          }

        $filename  = $course_title.'_'.$file_name.'_marks_upload.xls';
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
			  if($mark_type == 1)
				$finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Student ID','Student Name');
			  else
				  $finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Student Dummy No');
			   if($program_id == 1){
				  if($mark_type == 1){
					if($credits[0]->theory_credit != '0' && $credits[0]->practicle_credit != '0')
						$theoryarr = array('Internal Theory','Assignment','Practical');
					else if($credits[0]->theory_credit != '0' )
						$theoryarr = array('Internal Theory','Assignment');
					else if($credits[0]->practicle_credit != '0' )
						$theoryarr = array('Assignment','Practical');
					$finalExcelArr = array_merge($finalExcelArr,$theoryarr);
				  }
				  if($mark_type == 2){
					$external = array('External Theory');
					$finalExcelArr = array_merge($finalExcelArr,$external);
				  }
			   }else{
				    if($mark_type == 1){
						$theoryarr = array('Internal Theory','TermPaper','Internal Practical');
						$finalExcelArr = array_merge($finalExcelArr,$theoryarr);
					}
					if($mark_type == 2){
						$external = array('External Theory');
						$finalExcelArr = array_merge($finalExcelArr,$external);
					}
			   }
			$exam_typeArr = array('Exam Type(Regular/Cap)');
			$finalExcelArr = array_merge($finalExcelArr,$exam_typeArr);
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
			if($mark_type == 1){
				$objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->user_unique_id);
				$objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->first_name.' '.$value->last_name);
			}else{
				$objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->dummy_value);
				
			}
            $objPHPExcel->getActiveSheet()->setCellValue($cols[count($finalExcelArr)-1].$newvar, $exam_type_str);
			
            }
          }

			$filename  = $course_title.'_'.$file_name.'_marks_upload.xls';
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
            
			 
		    /* $campuses = $this->Excel_model->get_campus_by_name($rowsold[1][0]);
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
			 }*/
			 
			 //echo $course_id;exit;
			// $dateofstart = $this->Excel_model->get_course_by_name($rowsold[1][6]);
			 $campus_id = $this->input->post('campus_id_1');
			 $program_id = $this->input->post('program_id_1');
			 $batch_id = $this->input->post('batch_id_1');
			 $semester_id = $this->input->post('semester_id_1');
			 $course_id = $this->input->post('course_id_1');
			 $discipline_id = $this->input->post('discipline_id_1');
			 $mark_type = $this->input->post('marks_type_1');
			 $degree_id = $this->input->post('degree_id_1');
			 $exam_type = $this->input->post('exam_type_1');
			  //$dos = $this->Generate_model->get_date_by_degree($degree_id); 
			  $credits = $this->Marks_model->get_course_credit_points($course_id);
			  
			  $pos = strpos($course_id, '|');
			$non_credit=false;
			 if ($pos === false) {
				//$courses = $this->Excel_model->get_course_by_id($course_id);
				//$course_title = $courses->course_title;
			 }else{
				 $course_Arr = explode("|",$course_id);
				 $course_group_id = $course_Arr[0];
				 $course_idArr = explode("-",$course_Arr[1]);
				 $courses_group = $this->Excel_model->get_course_group_by_id($course_group_id);
				 if(trim($courses_group->course_subject_title) == 'NON CREDIT'){
					$non_credit=true;
				}
			 }
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
			 $internal_arr=array();
			 $external_arr=array();
			for($i=1;$i<=count($rowsold);$i++)
			{				
				$firstrow = @$rowsold[$i];
				//print_r($firstrow);exit;
				$assignment_mark='';
				if(($mark_type == 1 && $firstrow[9] != '') ||($non_credit == true && $firstrow[9] != '') || ($mark_type == 2 && $firstrow[8] != ''))
				{
					if($degree_id == 1 && $program_id==1){
						if($non_credit == true){
							if(strtolower(trim($firstrow[9])) == 'satisfactory' || strtolower(trim($firstrow[9])) == '1'){
								$ncc_status = 1;
							}else{
								$ncc_status = 0;
							}
							$internal_arr = array('ncc_status'=>$ncc_status);
						}else if($mark_type == 1){
							$internal_marks1=$firstrow[9];
							$internal_marks2=$firstrow[10];
							$internal_marks3=$firstrow[11];	 
							$internal_practical1=$firstrow[12];
							$internal_practical2=$firstrow[13]; 
							$internal_arr = array('theory_internal1'    =>($internal_marks1) ? $internal_marks1 : '',
											'theory_internal2'    =>($internal_marks2) ? $internal_marks2 : '',
											'theory_internal3'    =>($internal_marks3) ? $internal_marks3 : '',
											'theory_paper1'    =>($internal_practical1) ? $internal_practical1 : '',
											'theory_paper2'    =>($internal_practical2) ? $internal_practical2 : '');
						}else if($mark_type == 2){
							$theory_external1=$firstrow[8];
							$theory_external2=$firstrow[9];
							$external_arr = array('theory_external1'    =>($theory_external1) ? $theory_external1 : '',
											'theory_external2'    =>($theory_external2) ? $theory_external2 : '');
						}
						
					}elseif($degree_id != 1 && $program_id==1){
						if($credits[0]->theory_credit != '0' && $credits[0]->practicle_credit != '0'){
							if($mark_type == 1){
								$internal_marks1=$firstrow[9];
								$assignment_mark=$firstrow[10];
								$internal_practical1=$firstrow[11];
								$internal_arr = array('theory_internal1'    =>($internal_marks1) ? $internal_marks1 : '',
											'assignment_mark'    =>($assignment_mark) ? $assignment_mark : '',
											'practical_internal'    =>($internal_practical1) ? $internal_practical1 : '');
							}
							if($mark_type == 2){
								$theory_external1=$firstrow[8];
								$external_arr = array('theory_external1'    =>($theory_external1) ? $theory_external1 : '');
							}
						}else if($credits[0]->theory_credit != '0' ){
							if($mark_type == 1){
								$internal_marks1=$firstrow[9];
								$assignment_mark=$firstrow[10];
								$internal_arr = array('theory_internal1'    =>($internal_marks1) ? $internal_marks1 : '',
											'assignment_mark'    =>($assignment_mark) ? $assignment_mark : '');
							}
							if($mark_type == 2){
								$theory_external1=$firstrow[8];
								$external_arr = array('theory_external1'    =>($theory_external1) ? $theory_external1 : '');
							}
						}else if($credits[0]->practicle_credit != '0' ){
							if($mark_type == 1){
								$assignment_mark=$firstrow[9];
								$internal_practical1=$firstrow[10];
								$internal_arr = array('assignment_mark'    =>($assignment_mark) ? $assignment_mark : '',
											'practical_internal'    =>($internal_practical1) ? $internal_practical1 : '');
							}
							if($mark_type == 2){
								$theory_external1=$firstrow[8];
								$external_arr = array('theory_external1'    =>($theory_external1) ? $theory_external1 : '');
							}
						}
					}elseif($degree_id != 1 && $program_id!=1){
						if($mark_type == 1){
							$internal_marks1=$firstrow[9];
							$assignment_mark=$firstrow[10];
							$internal_practical1=$firstrow[11];
							$internal_arr = array('theory_internal1'    =>($internal_marks1) ? $internal_marks1 : '',
											'assignment_mark'    =>($assignment_mark) ? $assignment_mark : '',
											'practical_internal'    =>($internal_practical1) ? $internal_practical1 : '');
						}
						if($mark_type == 2){
							$theory_external1=$firstrow[8];
							$external_arr = array('theory_external1'    =>($theory_external1) ? $theory_external1 : '');
						}
					}
					if($non_credit == true){
					 $stud_id = $firstrow[7];
					 $stud = explode(' ',$firstrow[8]);
					 
					// print_r($stud);
					 $students = $this->Excel_model->get_student_by_id($stud_id);
					 $student_id = $students->id;
					}elseif($mark_type == 1){
					 $stud_id = $firstrow[7];
					 $stud = explode(' ',$firstrow[8]);
					 
					// print_r($stud);
					 $students = $this->Excel_model->get_student_by_id($stud_id);
					 $student_id = $students->id;
					}else{ 
						$stud_id = $firstrow[7];
						$students = $this->Excel_model->get_student_by_dummy_no($campus_id,$degree_id,$batch_id,$stud_id);
						$student_id = $students->student_id;
					}
					// p($students); 
					if($student_id<=0){
						$errormessage = $stud_id .' not exists in the database. Please check the excel sheet';
						$this->session->set_flashdata('errormessage', $errormessage);
						redirect(base_url().'excelupload/uploadUgMarksExcel');exit;
					}
					//for update work
					$check_student = $this->Excel_model->get_student_already_uploaded($campus_id,$program_id,$degree_id,$batch_id,$semester_id,$discipline_id,$course_id,$student_id,$exam_type);
					$common_array           =array(
						'campus_id'     =>($campus_id) ? $campus_id:'',
						'program_id'     =>($program_id) ? $program_id : '',
						'degree_id'     =>($degree_id) ? $degree_id : '',
						'batch_id'     =>($batch_id) ? $batch_id : '',
						'semester_id'     =>($semester_id) ? $semester_id : '',
						'discipline_id'     =>($discipline_id) ? $discipline_id : '',
						'course_id'     =>($course_id) ? $course_id : '',
						'student_id'    =>($student_id) ? $student_id : '',
						'exam_type'    =>($exam_type) ? $exam_type : '1',
						'created_on'    =>($register_date_time) ? $register_date_time : '');
					$final_array = array_merge($common_array,$internal_arr ,$external_arr);
					//p($final_array);exit;
					if(!empty($check_student->student_id))
					{
						$savedata = $this->Excel_model->update_ug_marks_excel($final_array);
					}
					elseif($student_id>0)
					{
						$savedata = $this->Excel_model->save_ug_marks_excel($final_array);
					}
					//echo $this->db->last_query();echo "<br/>";
					$m++;
				}else{
					//$this->session->set_flashdata('errormessage', 'Excel data not uploaded.');
					//redirect(base_url().'excelupload/uploadUgMarksExcel');
				}
			}
        }
		//exit;
	    $this->session->set_flashdata('message', 'Excel uploaded successfully.');
        redirect(base_url().'excelupload/uploadUgMarksExcel');
    }

}
?>