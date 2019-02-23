<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Discipline extends CI_Controller {
	
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
		 $this->load->helper('my_helper');
		 $this->load->helper('form');
		 $this->load->library('form_validation');
		 $this->load->library('email');
		 $this->load->model('fees_model');
		 $this->load->library('image_lib');
		 $this->load->helper('email');
		 $this->load->model('common_model');
		 $this->load->model('type_model');
		 $this->load->library('pagination');
		 $this->load->library('encrypt');
		 $this->load->library('dompdf_gen');
		 $this->load->library('excel');
		 
		 
		 $this->load->model('Discipline_model');
		 $this->load->model('Master_model');
		 $sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }
		
		 	/*if($this->session->userdata('sms'))
			{
				$session_data = $this->session->userdata('sms');
				if(isset($session_data[0]))
				{
					$session_data=$session_data[0];
					$this->user_name = $session_data->username;
					$this->user_fullname = $session_data->first_name.' '. $session_data->last_name;
					$this->user_role = $session_data->role_id;
					$this->user_email =$session_data->email;
					$this->user_id = $session_data->id;
				}
				if($this->user_role!=0)
				{
					$this->load->library('permission_lib');
					$this->permission_lib->permit($this->user_id,$this->user_role);
				}
			}
			else
			{
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
		$data['class']= $this->common_model->getAllClasses();
		@$data['state'] = $this->common_model->get_state();
		

		$data['roles']=$this->common_model->getAllRoles();
		
		$data['country']=$this->common_model->get_country();
		$data['city']=$this->common_model->get_city();
		$data['state']=$this->common_model->get_state();
		
		$data['max_id']				= 	$this->common_model->max_id('tbl_student','student_id');

		$this->load->view('admin/template/admin_header');
		$this->load->view('admin/template/admin_leftmenu');
		$this->load->view('admin/addstudent_view',$data);
		$this->load->view('admin/template/admin_footer');	
	}
    function addDiscipline()
	{
		$data['page_title']="Add Discipline";
		$this->load->view('admin/discipline_add_view',$data);
	}
    function saveDiscipline()
	{   
		$register_date_time=date('Y-m-d H:i:s');
		$discipline_code = $this->input->post('discipline_code');
		$discipline_name = $this->input->post('discipline_name');
		$save['discipline_code']=$discipline_code;
		$save['discipline_name']=$discipline_name;
		$save['type']=$this->input->post('type');
		$save['created_on']=     $register_date_time;
		
		$data= $this->Discipline_model->save_discipline($save);
		$this->session->set_flashdata('message', 'Discipline added successfully');
	    redirect('discipline/viewDiscipline');
		
		
	}
	function viewDiscipline()
	{
		$data['page_title']="Discipline List";
		$data['discipline_list']=$this->Discipline_model->discipline_list();
		$this->load->view('admin/discipline_list_view',$data);
	}
	function editDiscipline($id)
	{
	    $data['page_title']="Update Discipline";
		$data['discipline_row']=$this->Discipline_model->get_discipline_by_id($id);
		$this->load->view('admin/discipline_edit_view',$data);
	}
	function updateDiscipline($id)
	{ 
	  $discipline_code=$this->input->post('discipline_code');
	  $discipline_name=$this->input->post('discipline_name');
	  $save['discipline_code']=$discipline_code;
	  $save['discipline_name']=$discipline_name;
	  $save['type']=$this->input->post('type');
	  $this->Discipline_model->update_discipline($id,$save);
	    $this->session->set_flashdata('message', 'Discipline updated successfully');
	    redirect('discipline/viewDiscipline');
	}
	function deleteDiscipline($id)
	{    
	     if($id)
		 {
			$this->Discipline_model->delete_discipline($id); 
		 }
		 $this->session->set_flashdata('message', 'Discipline deleted successfully');
	     redirect('discipline/viewDiscipline'); 
	}
	function disciplineStatus($id,$dststus)
	{     
	    $status = $dststus;
         $this->Discipline_model->status_discipline($id,$status); 
		 $this->session->set_flashdata('message', 'Discipline status updated successfully');
	     redirect('discipline/viewDiscipline'); 
	}
	function addCourse()
	{   
		$data['page_title']="Add Course";
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['degrees'] = $this->Discipline_model->get_degree();
        $data['course_groups'] = $this->Discipline_model->get_course_group();
        $data['syllabus_years'] = $this->Discipline_model->get_syllabus_year();	
        $data['semesters'] = $this->Discipline_model->get_semester();		
		//print_r($data['course_groups']); exit;
		$this->load->view('admin/course_add_view',$data);
	}
	function saveCourse()
	{
		$register_date_time=date('Y-m-d H:i:s');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$discipline_id = $this->input->post('discipline_id');
		$course_group_id = $this->input->post('course_group_id');
		$syllabus_year = $this->input->post('syllabus_year');
		$semester_id = $this->input->post('semester_id');
		$course_code = $this->input->post('course_code');
		$course_title = $this->input->post('course_title');
		$theory_credit = $this->input->post('theory_credit');
		$practicle_credit = $this->input->post('practicle_credit');
		
		$save['program_id']=$program_id;
		$save['degree_id']=$degree_id;
		
		$save['discipline_id']=$discipline_id;
		$save['course_group_id']=$course_group_id;
		$save['syllabus_id']=$syllabus_year;
		$save['semester_id']=$semester_id;
		$save['course_code']=$course_code;
		$save['course_title']=$course_title;
		$save['theory_credit']=$theory_credit;
		$save['practicle_credit']=$practicle_credit;
		$save['created_on']=     $register_date_time;
		//print_r($save); exit;
		$data= $this->Discipline_model->save_course($save);
		$this->session->set_flashdata('message', 'Course added successfully');
	    redirect('discipline/viewCourse');
		
	}
	function viewCourse()
	{
		$data['page_title']="Course List";
		if(!empty($this->input->post('campus_id'))){
			$data['course_list']=$this->Discipline_model->course_list($this->input->post('program_id'),$this->input->post('degree_id'),$this->input->post('semester_id'));
		}else
			$data['course_list']=$this->Discipline_model->course_list();
		$data['campuses'] = $this->Discipline_model->get_campus(); 
		$data['batches'] = $this->Discipline_model->get_batches(); 
		//p($_POST);// exit;
		if(isset($_POST['downloadexcel']) && $_POST['downloadexcel'] == 'Download Excel')
		{
			$record['campus'] = $this->Discipline_model->get_campus(); 
		   $record['program'] = $this->Discipline_model->get_program(); 
		   $record['semester'] = $this->Discipline_model->get_semester(); 
		   $record['degrees'] = $this->Discipline_model->get_degree(); 
		   $record['discipline'] = $this->Discipline_model->get_discipline(); 
		  
	 
   //-----------Va Define-----------------------//
     $allArr               = array();
     $templevel            = 0;  
     $newkey               = 0;
     $grouparr[$templevel] = "";
  //-----------------------------------------------//

  
     //p($fuelProName); exit;
   //----------End Universal Products -----------//
     $allArr               = array();
     $templevel            = 0;  
     $newkey               = 0;
     $grouparr[$templevel] = "";
    // p($responce['segmentname']); exit;
    

	  //**************campuses dropdown********************************//
	
	  
	   foreach ($record['campus'] as $key => $value) {
          $campusid[]    = $value->id;
          $campusname[]  = $value->campus_name;
		 
       }//foreach
       $finalsegid   = implode($campusid, ',');
       $finalcampusname = implode($campusname, ',');
   
       //**************campuses dropdown End********************************//    
	   
	    //**************degree dropdown********************************//
	   foreach ($record['degrees'] as $key => $value) {
          $degreeid[]    = $value->id;
          $degreename[]  = $value->degree_name;
       }//foreach
       $finaldegreeid   = implode($degreeid, ',');
       $finaldegreename = implode($degreename, ',');
	   
      //**************degree dropdown End********************************//    
	   
	   //**************batch dropdown********************************//
	   foreach ($record['program'] as $key => $value) {
          $programid[]    = $value->id;
          $programname[]  = $value->program_name;
       }//foreach
       $finalprogramid   = implode($programid, ',');
       $finalprogramname = implode($programname, ',');
      //**************batch dropdown End********************************//   

       //**************batch dropdown********************************//
	   foreach ($record['semester'] as $key => $value) {
          $semesterid[]    = $value->id;
          $semestername[]  = $value->semester_name;
       }//foreach
       $finalsemesterid   = implode($semesterid, ',');
       $finalsemestername = implode($semestername, ',');
      //**************batch dropdown End********************************//   
	  
	   
				
	 //print_r($record['types']); exit;
	   foreach ($record['discipline'] as $key => $value) {
		  //print_r($key); exit;
          $disciplineid[]    = $value->id;
          $disciplinename[]  = $value->discipline_name;
       }//foreach
       $finaldisciplineid   = implode($disciplineid, ',');
       $finaldisciplinename = implode($disciplinename, ',');
      //**************monthofpassing dropdown End********************************//  
	  
	  
   
      //------------Define Index ---------//
       $featurevaluee1[]    = 'campusName';
       $featurevaluee1[]    = 'degreeName'; 
       $featurevaluee1[]    = 'programName'; 
       $featurevaluee1[]    = 'semesterName'; 
       $featurevaluee1[]    = 'disciplineName'; 
      
        
      $excelHeadArrqq1 = array_merge($featurevaluee1);
      $excelHeadArr1 = array_unique($excelHeadArrqq1);
      
      $oldfinalAttrData['campusName']       = $finalcampusname;
      $oldfinalAttrData2['campusName']      = $campusname;
	  
	  $oldfinalAttrData['degreeName']       = $finaldegreename;
      $oldfinalAttrData2['degreeName']      = $degreename;
	  
	 
	  $oldfinalAttrData['programName']       = $finalprogramname;
      $oldfinalAttrData2['programName']      = $programname;
	  
	  $oldfinalAttrData['semesterName']       = $finalsemestername;
      $oldfinalAttrData2['semesterName']      = $semestername;
	  
	  $oldfinalAttrData['disciplineName']       = $finaldisciplinename;
      $oldfinalAttrData2['disciplineName']      = $disciplinename;
     
      
       $finalAttrData  = array_merge($oldfinalAttrData);
       $finalAttrData2 = $oldfinalAttrData2;
       $attCount = array();
       foreach($finalAttrData as $k=>$v){
		//   print_r($v);
		//   echo "<pre>";
       $valueCount   = count(explode(",", $v));
       $attCount[$k] = $valueCount+1;

      } 
   // exit;

       $objPHPExcel   = new PHPExcel();
    //-------------------------------- First defult Sheet -------------------------------------------------//
    $objWorkSheet  = $objPHPExcel->createSheet();
    $objPHPExcel->setActiveSheetIndex(0);

    $finalExcelArr1 = array_merge($excelHeadArr1);
//p($finalAttrData2);exit;
     $cols   = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        $j      = 2;
       
        for($i=0;$i<count($finalExcelArr1);$i++){
         $objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'1', $finalExcelArr1[$i]);
         foreach ($finalAttrData2 as $key => $value) {
          foreach ($value as $k => $v) {
            if($key == $finalExcelArr1[$i]){
            $newvar = $j+$k;
            $objPHPExcel->getActiveSheet()->setCellValueExplicit($cols[$i].$newvar, $v, PHPExcel_Cell_DataType::TYPE_STRING);
            }
        }
      }  
    }//exit;$featurevaluee1[]    = 'Community';  
      
     $objPHPExcel->getSheetByName('Worksheet')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $arrPart2 = array('Campus Name','Degree Name','Program Name','Semester Name','Discipline Name','Course Code','Course Title','Order Value','Theory Credit','Practicle Credit');
          if(!empty($excelHeadArr)){
             $finalExcelArr = array_merge($arrPart2,$excelHeadArr);
         }else{
            $finalExcelArr = array_merge($arrPart2);
         }
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->setTitle('CourseUpload#'.$value->id.'');
      
    $cols  = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ');
 
 //Set border style for active worksheet
 $styleArray = array(
      'borders' => array(
          'allborders' => array(
            'style'  => PHPExcel_Style_Border::BORDER_THIN
          )
      )
);
$objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($styleArray);

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
          for($k=2;$k <1000;$k++){
    //Set height for every single row.
    $objPHPExcel->getActiveSheet()->getRowDimension($k)->setRowHeight(20);

    //Create select box for segment.
    $objValidation22 = $objPHPExcel->getActiveSheet()->getCell('A2')->getDataValidation();
    $objValidation22->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation22->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation22->setAllowBlank(false);
    $objValidation22->setShowInputMessage(true);
    $objValidation22->setShowErrorMessage(true);
    $objValidation22->setShowDropDown(true);
    $objValidation22->setErrorTitle('Input error');
    $objValidation22->setError('Value is not in list.');
    $objValidation22->setPromptTitle('Pick from list');
    $objValidation22->setPrompt('Please pick a value from the drop-down list.');
    $objValidation22->setFormula1('Worksheet!$'.'A$2:$'.'A$'.($attCount['campusName']));
   $var = $objPHPExcel->getActiveSheet()->getCell('A'.$k)->setDataValidation($objValidation22);

   $objValidation23 = $objPHPExcel->getActiveSheet()->getCell('B2')->getDataValidation();
    $objValidation23->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation23->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation23->setAllowBlank(false);
    $objValidation23->setShowInputMessage(true);
    $objValidation23->setShowErrorMessage(true);
    $objValidation23->setShowDropDown(true);
    $objValidation23->setErrorTitle('Input error');
    $objValidation23->setError('Value is not in list.');
    $objValidation23->setPromptTitle('Pick from list');
    $objValidation23->setPrompt('Please pick a value from the drop-down list.');
    $objValidation23->setFormula1('Worksheet!$'.'B$2:$'.'B$'.($attCount['degreeName']));
    $objPHPExcel->getActiveSheet()->getCell('B'.$k)->setDataValidation($objValidation23);
   
    $objValidation24 = $objPHPExcel->getActiveSheet()->getCell('C2')->getDataValidation();
    $objValidation24->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation24->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation24->setAllowBlank(false);
    $objValidation24->setShowInputMessage(true);
    $objValidation24->setShowErrorMessage(true);
    $objValidation24->setShowDropDown(true);
    $objValidation24->setErrorTitle('Input error');
    $objValidation24->setError('Value is not in list.');
    $objValidation24->setPromptTitle('Pick from list');
    $objValidation24->setPrompt('Please pick a value from the drop-down list.');
    $objValidation24->setFormula1('Worksheet!$'.'C$2:$'.'C$'.($attCount['programName']).'');
    $objPHPExcel->getActiveSheet()->getCell('C'.$k)->setDataValidation($objValidation24);
	
	 $objValidation24 = $objPHPExcel->getActiveSheet()->getCell('D2')->getDataValidation();
    $objValidation24->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation24->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation24->setAllowBlank(false);
    $objValidation24->setShowInputMessage(true);
    $objValidation24->setShowErrorMessage(true);
    $objValidation24->setShowDropDown(true);
    $objValidation24->setErrorTitle('Input error');
    $objValidation24->setError('Value is not in list.');
    $objValidation24->setPromptTitle('Pick from list');
    $objValidation24->setPrompt('Please pick a value from the drop-down list.');
    $objValidation24->setFormula1('Worksheet!$'.'D$2:$'.'D$'.($attCount['semesterName']).'');
    $objPHPExcel->getActiveSheet()->getCell('D'.$k)->setDataValidation($objValidation24);
	
	
	$objValidation25 = $objPHPExcel->getActiveSheet()->getCell('E2')->getDataValidation();
    $objValidation25->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation25->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation25->setAllowBlank(false);
    $objValidation25->setShowInputMessage(true);
    $objValidation25->setShowErrorMessage(true);
    $objValidation25->setShowDropDown(true);
    $objValidation25->setErrorTitle('Input error');
    $objValidation25->setError('Value is not in list.');
    $objValidation25->setPromptTitle('Pick from list');
    $objValidation25->setPrompt('Please pick a value from the drop-down list.');
    $objValidation25->setFormula1('Worksheet!$'.'E$2:$'.'E$'.($attCount['disciplineName']).'');
    $objPHPExcel->getActiveSheet()->getCell('E'.$k)->setDataValidation($objValidation25);
	
  }//secfor
}

        $filename  = 'course_excel.xls';
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
       // ob_end_clean();
	//	ob_start();
	if (ob_get_contents()) ob_end_clean();
        $objWriter->save('php://output');
        //exit;
		}
		if(isset($_POST['uploadStuExcel']) && $_POST['uploadStuExcel'] == 'Upload' && isset($_FILES['userfile']))
		{
						
				   $fileName    = $_FILES['userfile']['tmp_name'];
				   $objPHPExcel = PHPExcel_IOFactory::load($fileName);
				   $maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();
				   $rowsold     = $objPHPExcel->getActiveSheet()->rangeToArray('A2:' . $maxCell['column'] . $maxCell['row']); 
				   $rowsoldHeader     = $objPHPExcel->getActiveSheet()->toArray(); 
				   $sheetName   = $objPHPExcel->getActiveSheet()->getTitle();
				 
					$m =0;
				  //--------Insret Data Form Excel File --------//
				  
				  
				
					  for($m=0;$m<count($rowsold);$m++){
					   $firstrow = $rowsold[$m];
					  
						if(!empty($firstrow[0]))
						{
							$campusLists=$this->type_model->get_campus_info($firstrow[0]);
							$degreeLists=$this->type_model->get_degree_info($firstrow[1]);
							$programLists=$this->type_model->get_program_info($firstrow[2]);
							$semesterLists=$this->type_model->get_semester_info($firstrow[3]);
							$disciplineLists=$this->type_model->get_discipline_info($firstrow[4]);
							$course_code=$firstrow[5];
							$course_title=$firstrow[6];
							$ordervalue=$firstrow[7];
							$theorycredit=$firstrow[8];
							$practiclecredit=$firstrow[9];
						   
							
							if(count($campusLists) == 0)
								$campusListsid = '';
							else
								$campusListsid = $campusLists->id;
							if(count($degreeLists) == 0)
								$degreeListsid = '';
							else
								$degreeListsid = $degreeLists->id;
							if(count($programLists) == 0)
								$programListsid = '';
										else
								$programListsid = $programLists->id;
							if(count($semesterLists) == 0)
								$semesterListsid = '';
										else
								$semesterListsid = $semesterLists->id;
							if(count($disciplineLists) == 0)
								$disciplineListsid = '';
										else
								$disciplineListsid = $disciplineLists->id;
							
							
							$dataArr1= array(
											'program_id'=>$programListsid,
											'degree_id'=>$degreeListsid,
											'semester_id'=>$semesterListsid,
											'discipline_id'=>$disciplineListsid,
											'course_code'=>$firstrow[5],
											'course_title'=>$firstrow[6],
											'order_value'=>$firstrow[7],
											'theory_credit'=>$firstrow[8],
											'practicle_credit'=>$firstrow[9]
										  
							);
							
							$courselist = $this->type_model->get_course_info($firstrow[5],$firstrow[6]);
							if(count($courselist) == '0')
								$insertid=$this->Discipline_model->save_course($dataArr1);
						
						
				   }  
				  
				  }
				  $this->session->set_flashdata('message', 'Course Excel uploaded  successfully');

					}
		
		$this->load->view('admin/course_list_view',$data);
	}
	function editCourse($id)
	{
		$data['page_title']="Update Course";
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['degrees'] = $this->Discipline_model->get_degree();
        $data['course_groups'] = $this->Discipline_model->get_course_group();
        $data['syllabus_years'] = $this->Discipline_model->get_syllabus_year();	
        $data['semesters'] = $this->Discipline_model->get_semester();
		
		$data['course_row']=$this->Discipline_model->get_course_by_id($id);
		//print_r($data['course_row']); exit;
		$this->load->view('admin/course_edit_view',$data);
	}
	function detailCourse($id)
	{
		$data['page_title']="View Course Details";
		$data['disciplines'] = $this->Discipline_model->get_discipline(); 
		$data['programs'] = $this->Discipline_model->get_program(); 
		$data['degrees'] = $this->Discipline_model->get_degree();
        $data['course_groups'] = $this->Discipline_model->get_course_group();
        $data['syllabus_years'] = $this->Discipline_model->get_syllabus_year();	
        $data['semesters'] = $this->Discipline_model->get_semester();
		
		$data['course_row']=$this->Discipline_model->get_course_by_id($id);
		//print_r($data['course_row']); exit;
		$this->load->view('admin/course_detail_view',$data);
	}
	function updateCourse($id)
	{
		$register_date_time=date('Y-m-d H:i:s');
		$program_id = $this->input->post('program_id');
		$degree_id = $this->input->post('degree_id');
		$discipline_id = $this->input->post('discipline_id');
		$course_group_id = $this->input->post('course_group_id');
		$syllabus_year = $this->input->post('syllabus_year');
		$semester_id = $this->input->post('semester_id');
		$course_code = $this->input->post('course_code');
		$course_title = $this->input->post('course_title');
		$theory_credit = $this->input->post('theory_credit');
		$practicle_credit = $this->input->post('practicle_credit');
		
		$save['program_id']=$program_id;
		$save['degree_id']=$degree_id;
		
		$save['discipline_id']=$discipline_id;
		$save['course_group_id']=$course_group_id;
		$save['syllabus_id']=$syllabus_year;
		$save['semester_id']=$semester_id;
		$save['course_code']=$course_code;
		$save['course_title']=$course_title;
		$save['theory_credit']=$theory_credit;
		$save['practicle_credit']=$practicle_credit;
		$save['created_on']=     $register_date_time;
		//print_r($save); exit;
		$data= $this->Discipline_model->update_course($id,$save);
		$this->session->set_flashdata('message', 'Course updated successfully');
	    redirect('discipline/viewCourse');
	}
	
	function deleteCourse($id)
	{
		 if($id)
		 {
			$this->Discipline_model->delete_course($id); 
		 }
		 $this->session->set_flashdata('message', 'Course deleted successfully');
	      redirect('discipline/viewCourse'); 
	}
	function courseStatus($id,$status)
	{
		 $this->Discipline_model->status_course($id,$status); 
		 $this->session->set_flashdata('message', 'Course status updated successfully');
	     redirect('discipline/viewCourse'); 
	}
	  //----------------  Download Discipline Excel ----------------------------//
      function downloadDiscipline()
	  {
		  $data['disciplines'] = $this->Discipline_model->get_discipline(); 
		if(!empty($this->input->post('disciplineExcel')))
          {
           
           $finalExcelArr = array('Discipline Code','Discipline Name');
           $objPHPExcel = new PHPExcel();
           $objPHPExcel->setActiveSheetIndex(0);
           $objPHPExcel->getActiveSheet()->setTitle('Discipline Worksheet');
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

            foreach ($data['disciplines'] as $key => $value) {
             
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $value->discipline_code);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $value->discipline_name);
          
           
            }
          }

          $filename='Discipline.xls';
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          ob_start();  
          $objWriter->save('php://output');

         
          }
      //----------------  End Download Discipline Excel ------------------------// 
	  }
	
	//----------------  Download Course Excel ----------------------------//
      function downloadCourse()
	  {
		  $data['course_list_excel']=$this->Discipline_model->course_list_download();
		// p($data['course_list_excel']); exit;
		if(!empty($this->input->post('courseExcel')))
          {
           
           $finalExcelArr = array('Program','Degree','Discipline','Course Group','Syllabus Year','Semester','Course Code','Course Title','Theory Credits','Practicle Credits');
           $objPHPExcel = new PHPExcel();
           $objPHPExcel->setActiveSheetIndex(0);
           $objPHPExcel->getActiveSheet()->setTitle('Discipline Worksheet');
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

            foreach ($data['course_list_excel'] as $key => $value) {
             
            $newvar = $j+$key;

            //Set height for all rows.
            $objPHPExcel->getActiveSheet()->getRowDimension($newvar)->setRowHeight(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $value->program_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $value->degree_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[2].$newvar, $value->discipline_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[3].$newvar, $value->course_group_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[4].$newvar, $value->syllabus_year);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[5].$newvar, $value->semester_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[6].$newvar, $value->course_code);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->course_title);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->theory_credit);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[9].$newvar, $value->practicle_credit);
          
           
            }
          }

          $filename='Course.xls';
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          ob_start();  
          $objWriter->save('php://output');

         
          }
      //----------------  End Download Course Excel ------------------------// 
	  }
	
	
	
}
?>