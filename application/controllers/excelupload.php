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
			 if($degree_id == '')
				 $degree_id = $this->input->post('degree_idd');
			 if($degree_id == 1)
			 {
			 $campus_id = $this->input->post('campus_id');
			 $program_id = $this->input->post('program_id');
			 $batch_id = $this->input->post('batch_id');
			 $semester_id = $this->input->post('semester_id');
			 $course_id = $this->input->post('course_id');
			 $discipline_id = $this->input->post('discipline_id');
			 $mark_type = $this->input->post('marks_type');
			 $date_of_start = $this->input->post('date_of_start');
			 }
			 if($degree_id != 1)
			 {
			 $campus_id = $this->input->post('campus_idd');
			 $program_id = $this->input->post('program_idd');
			 $batch_id = $this->input->post('batch_idd');
			 $semester_id = $this->input->post('semester_idd');
			 $course_id = $this->input->post('course_idd');
			 $discipline_id = $this->input->post('discipline_idd');
			 $mark_type = $this->input->post('marks_typee');
			 $date_of_start = $this->input->post('date_of_startt');
			 }
			 $campuses = $this->Excel_model->get_campus_by_id($campus_id);
			 $programs = $this->Excel_model->get_program_by_id($program_id);
			 $degrees = $this->Excel_model->get_degree_by_id($degree_id);
			 $batches = $this->Excel_model->get_batch_by_id($batch_id);
			 $semesters = $this->Excel_model->get_semester_by_id($semester_id);
			 $disciplines = $this->Excel_model->get_discipline_by_id($discipline_id);
			 $courses = $this->Excel_model->get_course_by_id($course_id);
			 $dos = $this->Generate_model->get_date_by_degree($degree_id); 
			// echo $dos[1]->id;
			 for($j=0;$j<count($dos);$j++)
			 {
				 if($dos[$j]->id == $date_of_start)
				 {
					 $dateofstart = $dos[$j]->start_date;
					 break;
					 } 
			 }
			// print_r($dos);exit;
			 $credits = $this->Marks_model->get_course_credit_points($course_id);
			// print_r($credits[0]->practicle_credit);//exit;
			 $data['students']=$this->Marks_model->get_ug_students_by_ids($campus_id,$program_id,$degree_id,$batch_id); 
			// p($data['students']); exit;
			if($degree_id==1){
            //$finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Student Name','INTERNAL FIRST(10)',' INTERNAL SECOND(10)',' INTERNAL THIRD(10)','PRACTICAL PAPER-I(60)','PRACTICAL PAPER-II(60)','EXTERNAL PAPER-I(100)','EXTERNAL PAPER-II(100)');
            $finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Date of Start','Student Name');
			if($credits[0]->theory_credit != '0' && ($mark_type == '1'|| $mark_type == '3'))
				$theoryarr = array('Internal theory first(40)','Internal theory second(40)','Internal theory third(40)');
			if($credits[0]->practicle_credit != '0' && $mark_type == '1' || $mark_type == '3')
				$practicalarr = array('Practical Paper I(60)','Practical Paper II(60)');
			if($mark_type == '2' || $mark_type == '3')
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
            $objPHPExcel->getActiveSheet()->setCellValue($cols[6].$newvar, $courses->course_title);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $dateofstart);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->first_name.' '.$value->last_name);
            
			
            }
          }

        $filename  = $courses->course_title.'_'.'bvsc_marks_upload.xls';
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

			  // $finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Student Name','INTERNAL THEORY(30)','INTERNAL PRACTICAL(20)','EXTERNAL THEORY(50)');
			   $finalExcelArr = array('College','Program','Degree','Batch','Semester',' Discipline','Course','Date of Start','Student Name');
			if($credits[0]->theory_credit != '0' && ($mark_type == '1' || $mark_type == '3'))
				$theoryarr = array('INTERNAL THEORY(30)');
			if($credits[0]->practicle_credit != '0' && ($mark_type == '1' || $mark_type == '3'))
				$practicalarr = array('INTERNAL PRACTICAL(20)');
			if($mark_type == '2' || $mark_type == '3')
				$external = array('EXTERNAL THEORY(50)');
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
            $objPHPExcel->getActiveSheet()->setCellValue($cols[6].$newvar, $courses->course_title);
			$objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $dateofstart);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->first_name.' '.$value->last_name);
            
			
            }
          }

			$filename  = $courses->course_title.'_'.'btech_marks_upload.xls';
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
			 $courses = $this->Excel_model->get_course_by_name($rowsold[1][6]);
			// $dateofstart = $this->Excel_model->get_course_by_name($rowsold[1][6]);
			  $dos = $this->Generate_model->get_date_by_degree($degrees->id); 
			// echo $dos[1]->id;
			 for($j=0;$j<count($dos);$j++)
			 {
				 if($dos[$j]->start_date == $rowsold[1][7])
				 {
					 $dateofstart = $dos[$j]->id;
					 break;
					 } 
			 }
			 
			 $internal_practical1='';
			 $internal_practical2='';
			 $get_internal_practical1='';
			 $get_internal_practical2='';
			 $sum_get_internal_practicals='';
			 $sum_get_internal_practical='';
		     $m =0;
			 $register_date_time=date('Y-m-d H:i:s');
			 if($degrees->id==1){
		     //foreach($rowsold as $firstrow){
				for($i=1;$i<=count($rowsold);$i++)
				{				
					$firstrow = $rowsold[$i];
					if($firstrow[9] != '')
					{						
				 if($rowsold[0][9] == 'Internal theory first(40)')
				 {
						$internal_marks1=$firstrow[9];
					    $internal_marks2=$firstrow[10];
					    $internal_marks3=$firstrow[11];	 
				 }
				 else
				 {
						$internal_marks1='';
					    $internal_marks2='';
					    $internal_marks3='';
				 }
				 if($rowsold[0][9] == 'External Paper I(100)')
				 {
						$theory_external1=$firstrow[9];
					    $theory_external2=$firstrow[10];
					   
				 }
				 else
				 {
					 if($rowsold[0][14] == 'External Paper I(100)')
					{
						$theory_external1=$firstrow[14];
					    $theory_external2=$firstrow[15];
					   
					}
					else
					{
						$theory_external1='';
					    $theory_external2='';
					}
				 }
				  if($rowsold[0][12] == 'Practical Paper I(60)')
				 {
						$internal_practical1=$firstrow[12];
						$internal_practical2=$firstrow[13]; 
				 }
				 else
				 {
						$internal_practical1='';
						$internal_practical2=''; 
				 }
					   
						/*$internal_practical1=$firstrow[11];
						$internal_practical2=$firstrow[12];
						$theory_external_marks1=$firstrow[13];
						$theory_external_marks2=$firstrow[14];
						
						$get_internal_practical1=$internal_practical1/3;
						$get_internal_practical2=$internal_practical2/3;
						
						$sum_get_internal_practicals=$get_internal_practical1+$get_internal_practical2;
						$sum_get_internal_practical = number_format($sum_get_internal_practicals, 2);
						
						$theory_external1=$theory_external_marks1/5;
						$theory_external2=$theory_external_marks2/5;
						
						$external_sum=$theory_external1+$theory_external2;
						$total_external = number_format($external_sum, 2);
			 
			            $sum1=$internal_marks1+$internal_marks2;
						$sum2=$internal_marks2+$internal_marks3;
						$sum3=$internal_marks1+$internal_marks3;
						if($sum1>=$sum2 && $sum1>=$sum3)
						{
							$largesum=$sum1;
						}
						if($sum2>=$sum1 && $sum2>=$sum3)
						{
							$largesum=$sum2;
						}
						if($sum3>=$sum1 && $sum3>=$sum2)
						{
							$largesum=$sum3;
						}
						//p($largesum); exit;
						$theory_marks=$largesum;*/
			 $stud = explode(' ',$firstrow[8]);
			// print_r($stud);
			 $students = $this->Excel_model->get_student_by_name($stud[0]);
			// p($students); 
			//for update work
		    $check_student = $this->Excel_model->get_student_already_uploaded($campuses->id,$programs->id,$degrees->id,$batches->id,$semesters->id,$disciplines->id,$courses->id,$students->id);
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
				'course_id'     =>($courses->id) ? $courses->id : '',
				'student_id'    =>($students->id) ? $students->id : '',
				'theory_internal1'    =>($internal_marks1) ? $internal_marks1 : '',
				'theory_internal2'    =>($internal_marks2) ? $internal_marks2 : '',
				'theory_internal3'    =>($internal_marks3) ? $internal_marks3 : '',
				//'theory_internal'    =>($largesum) ? $largesum : '',
				'date_of_start' => ($firstrow[7]) ? $firstrow[7] : '',
				'theory_external1'    =>($theory_external1) ? $theory_external1 : '',
				'theory_external2'    =>($theory_external2) ? $theory_external2 : '',
				'theory_paper1'    =>($internal_practical1) ? $internal_practical1 : '',
				'theory_paper2'    =>($internal_practical2) ? $internal_practical2 : '',
				//'sum_internal_practical'    =>($sum_get_internal_practical) ? $sum_get_internal_practical : '',
				//'theory_external'    =>($firstrow[13]) ? $firstrow[13] : '',
				//'practical_external'    =>($firstrow[14]) ? $firstrow[14] : '',
				//'external_sum'    =>($total_external) ? $total_external : '',
				'created_on'    =>($register_date_time) ? $register_date_time : '',
				
				

				);
				//p($update_ug_marks); exit;
				$savedata = $this->Excel_model->update_ug_marks_excel($update_ug_marks);
				
			}
			else
			{
			  //echo "helo";//exit;
				$save_ug_marks           = array(
				'campus_id'     =>($campuses->id) ?  $campuses->id:'',
				'program_id'     =>($programs->id) ? $programs->id : '',
				'degree_id'     =>($degrees->id) ? $degrees->id : '',
				'batch_id'     =>($batches->id) ? $batches->id : '',
				'semester_id'     =>($semesters->id) ? $semesters->id : '',
				'discipline_id'     =>($disciplines->id) ? $disciplines->id : '',
				'course_id'     =>($courses->id) ? $courses->id : '',
				'student_id'    =>($students->id) ? $students->id : '',
				'theory_internal1'    =>($internal_marks1) ? $internal_marks1 : '',
				'theory_internal2'    =>($internal_marks2) ? $internal_marks2 : '',
				'theory_internal3'    =>($internal_marks3) ? $internal_marks3 : '',
				//'theory_internal'    =>($largesum) ? $largesum : '',
				'theory_paper1'    =>($internal_practical1) ? $internal_practical1 : '',
				'theory_paper2'    =>($internal_practical2) ? $internal_practical2 : '',
				'theory_external1'    =>($theory_external1) ? $theory_external1 : '',
				'theory_external2'    =>($theory_external2) ? $theory_external2 : '',
				//'sum_internal_practical'    =>($sum_get_internal_practical) ? $sum_get_internal_practical : '',
				//'theory_external'    =>($firstrow[13]) ? $firstrow[13] : '',
				//'practical_external'    =>($firstrow[14]) ? $firstrow[14] : '',
				//'external_sum'    =>($total_external) ? $total_external : '',
				'date_of_start' => ($firstrow[7]) ? $firstrow[7] : '',
				'created_on'    =>($register_date_time) ? $register_date_time : '',
				);
				//p($save_ug_marks); exit;
				$savedata = $this->Excel_model->save_ug_marks_excel($save_ug_marks);
				
			}
			$m++;
					}
         } //exit;
	   }//bvsc end
	   if($degrees->id!=1)
	   {
		$n=0;
		
		//foreach($rowsold as $firstrow){
			for($i=1;$i<=count($rowsold);$i++)
				{				
					$firstrow = $rowsold[$i];
					$theory_external1 = '';
					$practical_internal='';
					$theory_internal='';
					if($firstrow[9] != '')
					{						
				 if($rowsold[0][9] == 'INTERNAL THEORY(30)')
				 {
						$theory_internal=$firstrow[9];
				 }
				if($rowsold[0][9] == 'EXTERNAL THEORY(50)')
				{
						$theory_external1 = $firstrow[9];
				}
						
				if($rowsold[0][9] == 'INTERNAL PRACTICAL(20)')
				 {
						$practical_internal=$firstrow[9];  
				 }
				 
				 if($rowsold[0][10] == 'INTERNAL PRACTICAL(20)')
				 {
						$practical_internal=$firstrow[10];  
				 }
				 if($rowsold[0][10] == 'EXTERNAL THEORY(50)')
				{
						$theory_external1 = $firstrow[10];
				}
						
				if($rowsold[0][11] == 'EXTERNAL THEORY(50)')
				{
						$theory_external1 = $firstrow[11];
				}
							
				 
					   
				//p($campuses->id);
				// echo "helo"; exit;
				$students = $this->Excel_model->get_student_by_name($firstrow[8]);
				//p($students->id); exit;
				$check_students = $this->Excel_model->get_student_already_uploaded($campuses->id,$programs->id,$degrees->id,$batches->id,$semesters->id,$disciplines->id,$courses->id,$students->id);
				//p($check_students); exit;
			/*	$theory_internal    = $firstrow[8];
				$practical_internal = $firstrow[9];
				$theory_external    = $firstrow[10];
				$internal_external_sum = $theory_internal+$practical_internal+$theory_external;*/
							
						if(!empty($check_students))
						{
						   // echo "hiii"; exit;
							$update_btech_marks_excel =array(
							'campus_id'     =>($campuses->id) ? $campuses->id:'',
							'program_id'     =>($programs->id) ? $programs->id : '',
							'degree_id'     =>($degrees->id) ? $degrees->id : '',
							'batch_id'     =>($batches->id) ? $batches->id : '',
							'semester_id'     =>($semesters->id) ? $semesters->id : '',
							'discipline_id'     =>($disciplines->id) ? $disciplines->id : '',
							'course_id'     =>($courses->id) ? $courses->id : '',
							'student_id'    =>($students->id) ? $students->id : '',
							'theory_internal'    =>($theory_internal) ? $theory_internal : '',
							'practical_internal'    =>($practical_internal) ? $practical_internal : '',
							//'marks_sum'    =>($internal_external_sum) ? $internal_external_sum : '',
							'theory_external1'    =>($theory_external1) ? $theory_external1 : '',
							'created_on'    =>($register_date_time) ? $register_date_time : ''
							);
							//p($update_btech_marks_excel); exit;
						   $savedata = $this->Excel_model->update_ug_marks_excel($update_btech_marks_excel);
					   }
					   else
					   {
						   // echo "hello"; exit;
						    $save_btech_marks_excel =array(
							'campus_id'     =>($campuses->id) ? $campuses->id:'',
							'program_id'     =>($programs->id) ? $programs->id : '',
							'degree_id'     =>($degrees->id) ? $degrees->id : '',
							'batch_id'     =>($batches->id) ? $batches->id : '',
							'semester_id'     =>($semesters->id) ? $semesters->id : '',
							'discipline_id'     =>($disciplines->id) ? $disciplines->id : '',
							'course_id'     =>($courses->id) ? $courses->id : '',
							'student_id'    =>($students->id) ? $students->id : '',
							'theory_internal'    =>($theory_internal) ? $theory_internal : '',
							'practical_internal'    =>($practical_internal) ? $practical_internal : '',
							//'marks_sum'    =>($internal_external_sum) ? $internal_external_sum : '',
							'theory_external1'    =>($theory_external1) ? $theory_external1 : '',
							'created_on'    =>($register_date_time) ? $register_date_time : ''
							);
						//	p($save_btech_marks_excel); exit;
						   $savedata = $this->Excel_model->save_ug_marks_excel($save_btech_marks_excel);
					   }
		      $n++;	
					}
         }  
	   } //btech
	   
	   
        }
	    $this->session->set_flashdata('message', 'Excel uploaded successfully.');
        redirect(base_url().'excelupload/uploadUgMarksExcel');
    }

}
?>