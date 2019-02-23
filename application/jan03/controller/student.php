<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Student extends CI_Controller {
	
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
			$this->load->model('fees_model');
			$this->load->library('image_lib');
			$this->load->model('common_model');
			$this->load->model('newsession_model');
			$this->load->helper('email');
			$this->load->model('newsession_model');
			$this->load->model('user_model');
			$this->load->model('type_model');
			$this->load->model('Master_model');
			$this->load->model('Discipline_model');
			$this->load->library('permission_lib');
			$this->load->library('excel');
			$sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }
			
			
			
			
	}
	
	//----------------  Download Discipline Excel ----------------------------//
      function downloadStudentFormat()
	  {  
	 // echo "hello"; exit;
	  if($this->input->post('downloadExcel'))
	  {
		  // echo "hello"; exit;
	       $record['campuses'] = $this->Discipline_model->get_campus(); 
		   $record['disciplines'] = $this->Discipline_model->get_discipline(); 
		   $record['batches'] = $this->Discipline_model->get_batch(); 
		   $record['degrees'] = $this->Discipline_model->get_degree(); 
		   $record['roles']=$this->type_model->get_role();
		   $record['countries']=$this->type_model->get_country();
		   $record['states']=$this->type_model->get_state();
		   $record['city']=$this->type_model->get_city();
		   $record['community']=$this->type_model->get_community();
		   $record['caste']=$this->type_model->get_caste();
		//   print_r($record['caste']);exit;
       //............. Add Model............... //
	 
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
	  $record['campuses']  =array(
				  '1'     =>'Madras Veterinary College, Chennai',
				  '2'     =>'Veterinary  College and Research Institute, Namakkal',
				  '3'     =>'Veterinary  College and Research Institute, Orathanadu',
				  '4'     =>'Veterinary  College and Research Institute, Tirunelveli',
				  '5'     =>'College  of Poultry Production Management, Hosur',
				  '6'     =>'College  of  Food and Diary Technology, Koduvalli'
				  );
	  
	   foreach ($record['campuses'] as $key => $value) {
         // $campusid[]    = $value->id;
          //$campusname[]  = $value->campus_name;
		   $campusid[]    = $key;
          $campusname[]  = $value;
       }//foreach
       $finalsegid   = implode($campusid, ',');
       $finalcampusname = implode($campusname, ',');
    //  print_r($finalcampusname);exit;
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
	   foreach ($record['batches'] as $key => $value) {
          $batchid[]    = $value->id;
          $batchname[]  = $value->batch_name;
       }//foreach
       $finalbatchid   = implode($batchid, ',');
       $finalbatchname = implode($batchname, ',');
      //**************batch dropdown End********************************//   

     //**************Type ********************************//
	     $record['types']  =array(
				  '1'     =>'Full Time',
				  '2'     =>'Part Time'
				  );
				  
	 //print_r($record['types']); exit;
	   foreach ($record['types'] as $key => $value) {
		  //print_r($key); exit;
          $typeid[]    = $key;
          $typename[]  = $value;
       }//foreach
       $finaltypeid   = implode($typeid, ',');
       $finaltypename = implode($typename, ',');
      //**************Type dropdown End********************************//   	  
      //**************Gender Dropdown ********************************//
	     $record['gender']  =array(
				  'male'     =>'Male',
				  'female'     =>'Female'
				  );
				  
	
	   foreach ($record['gender'] as $key => $value) {
		  //print_r($key); exit;
          $genderid[]    = $key;
          $gendername[]  = $value;
       }//foreach
       $finalgenderid   = implode($genderid, ',');
       $finalgendername = implode($gendername, ',');
      //**************Gender dropdown End********************************//   	
   
    //**************Religion Dropdown ********************************//
	     $record['religion']  =array(
				  '1'     =>'Muslim',
				  '2'     =>'Hindu',
				  '3'     =>'Christian'
				  );
				  
	
	   foreach ($record['religion'] as $key => $value) {
		  //print_r($key); exit;
          $religionid[]    = $key;
          $religionname[]  = $value;
       }//foreach
       $finalreligionid   = implode($religionid, ',');
       $finalreligionname = implode($religionname, ',');
      //**************Gender dropdown End********************************//   
   
      //**************Nationality Dropdown ********************************//
	     $record['nationality']  =array(
				  '1'     =>'Indian',
				  '2'     =>'Non-Indian'
				 );
				  
	
	   foreach ($record['nationality'] as $key => $value) {
		  //print_r($key); exit;
          $nationalityid[]    = $key;
          $nationalityname[]  = $value;
       }//foreach
       $finalnationalityid   = implode($nationalityid, ',');
       $finalnationalityname = implode($nationalityname, ',');
      //**************Gender dropdown End********************************// 
	  
      //**************Country Dropdown ********************************//
	    
	   foreach ($record['countries'] as $key => $value) {
		  //print_r($key); exit;
          $countryid[]    = $value->id;
          $countryname[]  = $value->country_name;
       }//foreach
       $finalcountryid  = implode($countryid, ',');
       $finalcountryname = implode($countryname, ',');
      //**************Country dropdown End********************************//  

       //**************State Dropdown ********************************//
	  
	   foreach ($record['states'] as $key => $value) {
		  //print_r($key); exit;
          $stateid[]    = $value->id;
          $statename[]  = $value->state;
       }//foreach
       $finalstateid = implode($stateid, ',');
       $finalstatename = implode($statename, ',');
      //**************State dropdown End********************************//   	  
   
    //**************City Dropdown ********************************//
	  	   
	   foreach ($record['city'] as $key => $value) {
		  //print_r($key); exit;
          $cityid[]    = $value->city_id;
          $cityname[]  = $value->city; 
         
		// $cityid[]    = $key;
        //  $cityname[]  = $value;
       }//foreach
	 //  print_r()
       $finalcityid = implode($cityid, ',');
	$finalcityname = implode($cityname, ',');
      //**************City dropdown End********************************//   

 //**************Communtity Dropdown ********************************//
	  	   
	   foreach ($record['community'] as $key => $value) {
		  //print_r($key); exit;
          $communityid[]    = $value->id;
          $communityname[]  = $value->name; 
         
		// $cityid[]    = $key;
        //  $cityname[]  = $value;
       }//foreach
	 //  print_r()
       $finalcommunityid = implode($communityid, ',');
	$finalcommunityname = implode($communityname, ',');
      //**************Communtity dropdown End********************************//   
	  
	   //**************Caste Dropdown ********************************//
	  	   
	   foreach ($record['caste'] as $key => $value) {
		  //print_r($key); exit;
          $casteid[]    = $value->id;
          $castename[]  = $value->name; 
         
		// $cityid[]    = $key;
        //  $cityname[]  = $value;
       }//foreach
	 //  print_r()
       $finalcasteid = implode($casteid, ',');
	$finalcastename = implode($castename, ',');
      //**************Caste dropdown End********************************//   
	  
	//  print_r($finalcastename);exit;
		

//**************Type ********************************//
	     $record['bloodgrp']  =array(
				  'A'     =>'A',
				  'A+'     =>'A+',
				  'AB-'     =>'AB-',
				  'B+'     =>'B+',
				  'B-'     =>'B-',
				  'AB+'     =>'AB+'
				  );
				  
	 //print_r($record['types']); exit;
	   foreach ($record['bloodgrp'] as $key => $value) {
		  //print_r($key); exit;
          $bloodgrpid[]    = $key;
          $bloodgrpname[]  = $value;
       }//foreach
       $finalbloodgrpid   = implode($bloodgrpid, ',');
       $finalbloodgrpname = implode($bloodgrpname, ',');
      //**************Type dropdown End********************************//  

//**************mothertongue ********************************//
	     $record['mothertongue']  =array(
				  'English'     =>'English',
				  'Tamil'     =>'Tamil',
				  'Telugu'     =>'Telugu',
				  'Malayalam'     =>'Malayalam',
				  'Hindi'     =>'Hindi',
				  'Kannada'     =>'Kannada'
				  );
				  
	 //print_r($record['types']); exit;
	   foreach ($record['mothertongue'] as $key => $value) {
		  //print_r($key); exit;
          $mothertongueid[]    = $key;
          $mothertonguename[]  = $value;
       }//foreach
       $finalmothertongueid   = implode($mothertongueid, ',');
       $finalmothertonguename = implode($mothertonguename, ',');
      //**************mothertongue dropdown End********************************//  	  
	  
	  //**************Resident Type ********************************//
	     $record['residenttype']  =array(
				  'Day Scholar'     =>'Day Scholar',
				  'Hosteller'     =>'Hosteller'
				  );
				  
	 //print_r($record['types']); exit;
	   foreach ($record['residenttype'] as $key => $value) {
		  //print_r($key); exit;
          $residenttypeid[]    = $key;
          $residenttypename[]  = $value;
       }//foreach
       $finalresidenttypeid   = implode($residenttypeid, ',');
       $finalresidenttypename = implode($residenttypename, ',');
      //**************residenttype dropdown End********************************//  	  
	  
	   //**************Local Country Dropdown ********************************//
	    
	   foreach ($record['countries'] as $key => $value) {
		  //print_r($key); exit;
          $localcountryid[]    = $value->id;
          $localcountryname[]  = $value->country_name;
       }//foreach
       $finallocalcountryid  = implode($localcountryid, ',');
       $finallocalcountryname = implode($localcountryname, ',');
      //**************Local Country dropdown End********************************//  

       //**************Local State Dropdown ********************************//
	  
	   foreach ($record['states'] as $key => $value) {
		  //print_r($key); exit;
          $localstateid[]    = $value->id;
          $localstatename[]  = $value->state;
       }//foreach
       $finallocalstateid = implode($localstateid, ',');
       $finallocalstatename = implode($localstatename, ',');
      //*************Local State dropdown End********************************//   	  
   
    //**************Local City Dropdown ********************************//
	  	   
	   foreach ($record['city'] as $key => $value) {
		  //print_r($key); exit;
          $localcityid[]    = $value->city_id;
          $localcityname[]  = $value->city; 
         
		// $cityid[]    = $key;
        //  $cityname[]  = $value;
       }//foreach
	 //  print_r()
       $finallocalcityid = implode($localcityid, ',');
	$finallocalcityname = implode($localcityname, ',');
      //**************Local City dropdown End********************************//   

	
	 //**************scholarship ********************************//
	     $record['scholarship']  =array(
				  'A'     =>'A',
				  'B'     =>'B'
				  );
				  
	 //print_r($record['types']); exit;
	   foreach ($record['scholarship'] as $key => $value) {
		  //print_r($key); exit;
          $scholarshipid[]    = $key;
          $scholarshipname[]  = $value;
       }//foreach
       $finalscholarshipid   = implode($scholarshipid, ',');
       $finalscholarshipname = implode($scholarshipname, ',');
      //**************scholarship dropdown End********************************//  
	  
	  //**************monthofpassing ********************************//
	     $record['monthofpassing']  =array(
				  'January'     =>'January',
				  'February'     =>'February',
				  'March'     =>'March',
				  'April'     =>'April',
				  'May'     =>'May',
				  'June'     =>'June',
				  'July'     =>'July',
				  'August'     =>'August',
				  'September'     =>'September',
				  'October'     =>'October',
				  'November'     =>'November',
				  'December'     =>'December'
				  );
				
	 //print_r($record['types']); exit;
	   foreach ($record['monthofpassing'] as $key => $value) {
		  //print_r($key); exit;
          $monthofpassingid[]    = $key;
          $monthofpassingname[]  = $value;
       }//foreach
       $finalmonthofpassingid   = implode($monthofpassingid, ',');
       $finalmonthofpassingname = implode($monthofpassingname, ',');
      //**************monthofpassing dropdown End********************************//  
	  
	   //**************monthofpassing ********************************//
	     $record['yearofpassing']  =array(
				  '2015'     =>'2015',
				  '2016'     =>'2016',
				  '2017'     =>'2017',
				  '2018'     =>'2018',
				  '2019'     =>'2019',
				  '2020'     =>'2020',
				  '2021'     =>'2021'
				  );
				
	 //print_r($record['types']); exit;
	   foreach ($record['yearofpassing'] as $key => $value) {
		  //print_r($key); exit;
          $yearofpassingid[]    = $key;
          $yearofpassingname[]  = $value;
       }//foreach
       $finalyearofpassingid   = implode($yearofpassingid, ',');
       $finalyearofpassingname = implode($yearofpassingname, ',');
      //**************monthofpassing dropdown End********************************//  
	  
	  //**************mediumofinstr ********************************//
	     $record['mediumofinstr']  =array(
				  'English'     =>'English',
				  'Tamil'     =>'Tamil',
				  'Telugu'     =>'Telugu',
				  'Hindi'     =>'Hindi'
				  );
				
	 //print_r($record['types']); exit;
	   foreach ($record['mediumofinstr'] as $key => $value) {
		  //print_r($key); exit;
          $mediumofinstrid[]    = $key;
          $mediumofinstrname[]  = $value;
       }//foreach
       $finalmediumofinstrid   = implode($mediumofinstrid, ',');
       $finalmediumofinstrname = implode($mediumofinstrname, ',');
      //**************mediumofinstr dropdown End********************************//  
	  
	  //**************modeofadmission ********************************//
	     $record['modeofadmission']  =array(
				  'N/A'     =>'N/A',
				  'General'     =>'General',
				  'Reserved'     =>'Reserved'
				  );
				
	 //print_r($record['types']); exit;
	   foreach ($record['modeofadmission'] as $key => $value) {
		  //print_r($key); exit;
          $modeofadmissionid[]    = $key;
          $modeofadmissionname[]  = $value;
       }//foreach
       $finalmodeofadmissionid   = implode($modeofadmissionid, ',');
       $finalmodeofadmissionname = implode($modeofadmissionname, ',');
      //**************modeofadmission dropdown End********************************//  
	  
	  //**************reserved ********************************//
	     $record['reserved']  =array(
				  'A'     =>'A',
				  'B'     =>'B'
				  );
				
	 //print_r($record['types']); exit;
	   foreach ($record['reserved'] as $key => $value) {
		  //print_r($key); exit;
          $reservedid[]    = $key;
          $reservedname[]  = $value;
       }//foreach
       $finalreservedid   = implode($reservedid, ',');
       $finalreservedname = implode($reservedname, ',');
      //**************reserved dropdown End********************************//  
	  
	  //**************quota ********************************//
	     $record['quota']  =array(
				   'A'     =>'A',
				  'B'     =>'B'
				  );
				
	 //print_r($record['types']); exit;
	   foreach ($record['quota'] as $key => $value) {
		  //print_r($key); exit;
          $quotaid[]    = $key;
          $quotaname[]  = $value;
       }//foreach
       $finalquotaid   = implode($quotaid, ',');
       $finalquotaname = implode($quotaname, ',');
      //**************quota dropdown End********************************//  
	  
	  //**************studentstatus ********************************//
	     $record['studentstatus']  =array(
				  'Active'     =>'Active',
				  'Dismissed'     =>'Dismissed',
				  'With held'     =>'With held',
				  'Discontinued'     =>'Discontinued'
				  );
				
	 //print_r($record['types']); exit;
	   foreach ($record['studentstatus'] as $key => $value) {
		  //print_r($key); exit;
          $studentstatusid[]    = $key;
          $studentstatusname[]  = $value;
       }//foreach
       $finalstudentstatusid   = implode($studentstatusid, ',');
       $finalstudentstatusname = implode($studentstatusname, ',');
      //**************studentstatus dropdown End********************************//  
	  
	  //**************persmission ********************************//
	     $record['permission']  =array(
				  'Yes'     =>'Yes',
				  'No'     =>'No'
				  );
				
	 //print_r($record['types']); exit;
	   foreach ($record['permission'] as $key => $value) {
		  //print_r($key); exit;
          $permissionid[]    = $key;
          $permissionname[]  = $value;
       }//foreach
       $finalpersmissionid   = implode($permissionid, ',');
       $finalpermissionname = implode($permissionname, ',');
      //**************persmission dropdown End********************************//  
	  
	  //**************internship ********************************//
	     $record['internship']  =array(
				  'A'     =>'A',
				  'B'     =>'B',
				  'C'     =>'C',
				  'D'     =>'D'
				  );
				
	 //print_r($record['types']); exit;
	   foreach ($record['internship'] as $key => $value) {
		  //print_r($key); exit;
          $internshipid[]    = $key;
          $internshipname[]  = $value;
       }//foreach
       $finalinternshipid   = implode($internshipid, ',');
       $finalinternshipname = implode($internshipname, ',');
      //**************internship dropdown End********************************//  
   
      //------------Define Index ---------//
       $featurevaluee1[]    = 'campusName';
       $featurevaluee1[]    = 'degreeName'; 
       $featurevaluee1[]    = 'batchName'; 
       $featurevaluee1[]    = 'Type'; 
       $featurevaluee1[]    = 'Gender'; 
       $featurevaluee1[]    = 'Religion'; 
       $featurevaluee1[]    = 'Nationality';  
       $featurevaluee1[]    = 'Country';  
       $featurevaluee1[]    = 'State';  
       $featurevaluee1[]    = 'City';  
       $featurevaluee1[]    = 'Community';  
       $featurevaluee1[]    = 'Caste';  
       $featurevaluee1[]    = 'Bloodgrp';  
       $featurevaluee1[]    = 'Mothertongue';  
       $featurevaluee1[]    = 'residenttype';  
	   $featurevaluee1[]    = 'LocalCountry';  
       $featurevaluee1[]    = 'LocalState';  
       $featurevaluee1[]    = 'LocalCity';
	   $featurevaluee1[]    = 'Monthofpassing';
	   $featurevaluee1[]    = 'YearofPassing';
	   $featurevaluee1[]    = 'Mediumofinstr';
	   $featurevaluee1[]    = 'Modeofadmission';
	    $featurevaluee1[]    = 'Reserved';
		$featurevaluee1[]    = 'Quota';
	   $featurevaluee1[]    = 'Studentstatus';
	   $featurevaluee1[]    = 'Permission';
	   $featurevaluee1[]    = 'Internship';
	   
	  
        
      $excelHeadArrqq1 = array_merge($featurevaluee1);
      $excelHeadArr1 = array_unique($excelHeadArrqq1);
      
      $oldfinalAttrData['campusName']       = $finalcampusname;
      $oldfinalAttrData2['campusName']      = $campusname;
	  
	  $oldfinalAttrData['degreeName']       = $finaldegreename;
      $oldfinalAttrData2['degreeName']      = $degreename;
	  
	  $oldfinalAttrData['batchName']       = $finalbatchname;
      $oldfinalAttrData2['batchName']      = $batchname;
	  
	  $oldfinalAttrData['Type']       = $finaltypename;
      $oldfinalAttrData2['Type']      = $typename;
	  
	  $oldfinalAttrData['Gender']       = $finalgendername;
      $oldfinalAttrData2['Gender']      = $gendername;
     
	  $oldfinalAttrData['Religion']       = $finalreligionname;
      $oldfinalAttrData2['Religion']      = $religionname;
	  
	  $oldfinalAttrData['Nationality']       = $finalnationalityname;
      $oldfinalAttrData2['Nationality']      = $nationalityname;
	  
	  $oldfinalAttrData['Country']       = $finalcountryname;
      $oldfinalAttrData2['Country']      = $countryname;
	  
	  $oldfinalAttrData['State']       = $finalstatename;
      $oldfinalAttrData2['State']      = $statename;
	  
	  $oldfinalAttrData['City']       = $finalcityname;
      $oldfinalAttrData2['City']      = $cityname;
	  
	  $oldfinalAttrData['Community']       = $finalcommunityname;
      $oldfinalAttrData2['Community']      = $communityname;
	  
	  $oldfinalAttrData['Caste']       = $finalcastename;
      $oldfinalAttrData2['Caste']      = $castename;
	  
	  $oldfinalAttrData['Bloodgrp']       = $finalbloodgrpname;
      $oldfinalAttrData2['Bloodgrp']      = $bloodgrpname;
	  
	  $oldfinalAttrData['Mothertongue']       = $finalmothertonguename;
      $oldfinalAttrData2['Mothertongue']      = $mothertonguename;
	  
	  $oldfinalAttrData['residenttype']       = $finalresidenttypename;
      $oldfinalAttrData2['residenttype']      = $residenttypename;
	  
	  $oldfinalAttrData['LocalCountry']       = $finallocalcountryname;
      $oldfinalAttrData2['LocalCountry']      = $localcountryname;
	  
	  $oldfinalAttrData['LocalState']       = $finallocalstatename;
      $oldfinalAttrData2['LocalState']      = $localstatename;
	  
	  $oldfinalAttrData['LocalCity']       = $finallocalcityname;
      $oldfinalAttrData2['LocalCity']      = $localcityname;
	  
	  $oldfinalAttrData['Monthofpassing']       = $finalmonthofpassingname;
      $oldfinalAttrData2['Monthofpassing']      = $monthofpassingname;
	  
	  $oldfinalAttrData['Yearofpassing']       = $finalyearofpassingname;
      $oldfinalAttrData2['Yearofpassing']      = $yearofpassingname;
	  
	  $oldfinalAttrData['Mediumofinstr']       = $finalmediumofinstrname;
      $oldfinalAttrData2['Mediumofinstr']      = $mediumofinstrname;
	  
	  $oldfinalAttrData['Modeofadmission']       = $finalmodeofadmissionname;
      $oldfinalAttrData2['Modeofadmission']      = $modeofadmissionname;
	  
	  $oldfinalAttrData['Reserved']       = $finalreservedname;
      $oldfinalAttrData2['Reserved']      = $reservedname;
	  
	  $oldfinalAttrData['Quota']       = $finalquotaname;
      $oldfinalAttrData2['Quota']      = $quotaname;
	  
	  $oldfinalAttrData['Studentstatus']       = $finalstudentstatusname;
      $oldfinalAttrData2['Studentstatus']      = $studentstatusname;
	  
	  $oldfinalAttrData['Permission']       = $finalpermissionname;
      $oldfinalAttrData2['Permission']      = $permissionname;
	  
	  $oldfinalAttrData['Internship']       = $finalinternshipname;
      $oldfinalAttrData2['Internship']      = $internshipname;
	  
	  
      
       $finalAttrData  = array_merge($oldfinalAttrData);
       $finalAttrData2 = $oldfinalAttrData2;
       $attCount = array();
       foreach($finalAttrData as $k=>$v){
		   //print_r($v);
       $valueCount   = count(explode(",", $v));
       $attCount[$k] = $valueCount+1;

      } 
    

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
			//echo $key;
			// if($key == 'City')$finalAttrData2['City'];
          foreach ($value as $k => $v) {
			 // echo $v.'<br>';
//echo '<br>'.$finalExcelArr1[$i].'<br>'.$cols[$i].$newvar.'-----------';
//echo $finalExcelArr1[$i].$v."<br>";
            if($key == $finalExcelArr1[$i]){
				
            $newvar = $j+$k;
			//echo '<br>'.$finalExcelArr1[$i].'<br>'.$cols[$i].$newvar.'-----------';
            $objPHPExcel->getActiveSheet()->setCellValueExplicit($cols[$i].$newvar, $v, PHPExcel_Cell_DataType::TYPE_STRING);
            }
        }
      }  
    }//exit;$featurevaluee1[]    = 'Community';  
      
     $objPHPExcel->getSheetByName('Worksheet')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $arrPart2 = array('campusName','degreeName','Batch','Type','Gender','Religion','Nationality','Country','State','City','Community','Caste','Blood Group','Mother Tongue','Resident Type','Local Country','Local State','Local City','Month of passing','Year of passing','Medium of instruction','Mode of admission','Reserved','Quota','Studentstatus','Permission','Internship','Local Address','Local Street','Annual Income','Local Zipcode','Guardian/Spouse Name','Unique Id','User Name','Password','First Name','Last Name','Email','Contact Number','User Image','DOB','Parent Name','Mother Name','Father Contact','Alternate Contact','Father Email','Address','Street','Zip','ParentPhoto','Registration','Class','Section','Roll',' Last School','Last STD','%Marks Obtained','Sports','Date of Admission','Date od Passing','Ward Counsellor','Extra Curricular Activies','Remark','Course Type');
          if(!empty($excelHeadArr)){
             $finalExcelArr = array_merge($arrPart2,$excelHeadArr);
         }else{
            $finalExcelArr = array_merge($arrPart2);
         }
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->setTitle('VendorProductWorksheet#'.$value->id.'');
      
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
			// print_r($finalAttrData['campusName']);exit;
            $objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'1', $finalExcelArr[$i]);

          for($k=2;$k <1000;$k++){
    //Set height for every single row.
    $objPHPExcel->getActiveSheet()->getRowDimension($k)->setRowHeight(20);

    //Create select box for segment.
   /* $objValidation22 = $objPHPExcel->getActiveSheet()->getCell('A2')->getDataValidation();
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
   $var = $objPHPExcel->getActiveSheet()->getCell('A'.$k)->setDataValidation($objValidation22);*/

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
    $objValidation24->setFormula1('Worksheet!$'.'C$2:$'.'C$'.($attCount['batchName']).'');
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
    $objValidation24->setFormula1('Worksheet!$'.'D$2:$'.'D$'.($attCount['Type']).'');
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
    $objValidation25->setFormula1('Worksheet!$'.'E$2:$'.'E$'.($attCount['Gender']).'');
    $objPHPExcel->getActiveSheet()->getCell('E'.$k)->setDataValidation($objValidation25);
	
	$objValidation26 = $objPHPExcel->getActiveSheet()->getCell('F2')->getDataValidation();
    $objValidation26->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation26->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation26->setAllowBlank(false);
    $objValidation26->setShowInputMessage(true);
    $objValidation26->setShowErrorMessage(true);
    $objValidation26->setShowDropDown(true);
    $objValidation26->setErrorTitle('Input error');
    $objValidation26->setError('Value is not in list.');
    $objValidation26->setPromptTitle('Pick from list');
    $objValidation26->setPrompt('Please pick a value from the drop-down list.');
    $objValidation26->setFormula1('Worksheet!$'.'F$2:$'.'F$'.($attCount['Religion']).'');
    $objPHPExcel->getActiveSheet()->getCell('F'.$k)->setDataValidation($objValidation26);
	
	
	$objValidation27 = $objPHPExcel->getActiveSheet()->getCell('G2')->getDataValidation();
    $objValidation27->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation27->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation27->setAllowBlank(false);
    $objValidation27->setShowInputMessage(true);
    $objValidation27->setShowErrorMessage(true);
    $objValidation27->setShowDropDown(true);
    $objValidation27->setErrorTitle('Input error');
    $objValidation27->setError('Value is not in list.');
    $objValidation27->setPromptTitle('Pick from list');
    $objValidation27->setPrompt('Please pick a value from the drop-down list.');
    $objValidation27->setFormula1('Worksheet!$'.'G$2:$'.'G$'.($attCount['Nationality']).'');
    $objPHPExcel->getActiveSheet()->getCell('G'.$k)->setDataValidation($objValidation27);
	
	
	$objValidation28 = $objPHPExcel->getActiveSheet()->getCell('H2')->getDataValidation();
    $objValidation28->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation28->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation28->setAllowBlank(false);
    $objValidation28->setShowInputMessage(true);
    $objValidation28->setShowErrorMessage(true);
    $objValidation28->setShowDropDown(true);
    $objValidation28->setErrorTitle('Input error');
    $objValidation28->setError('Value is not in list.');
    $objValidation28->setPromptTitle('Pick from list');
    $objValidation28->setPrompt('Please pick a value from the drop-down list.');
    $objValidation28->setFormula1('Worksheet!$'.'H$2:$'.'H$'.($attCount['Country']).'');
    $objPHPExcel->getActiveSheet()->getCell('H'.$k)->setDataValidation($objValidation28);
	
	
	$objValidation29 = $objPHPExcel->getActiveSheet()->getCell('I2')->getDataValidation();
    $objValidation29->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation29->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation29->setAllowBlank(false);
    $objValidation29->setShowInputMessage(true);
    $objValidation29->setShowErrorMessage(true);
    $objValidation29->setShowDropDown(true);
    $objValidation29->setErrorTitle('Input error');
    $objValidation29->setError('Value is not in list.');
    $objValidation29->setPromptTitle('Pick from list');
    $objValidation29->setPrompt('Please pick a value from the drop-down list.');
    $objValidation29->setFormula1('Worksheet!$'.'I$2:$'.'I$'.($attCount['State']).'');
    $objPHPExcel->getActiveSheet()->getCell('I'.$k)->setDataValidation($objValidation29);
	
	$objValidation30 = $objPHPExcel->getActiveSheet()->getCell('J2')->getDataValidation();
    $objValidation30->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation30->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation30->setAllowBlank(false);
    $objValidation30->setShowInputMessage(true);
    $objValidation30->setShowErrorMessage(true);
    $objValidation30->setShowDropDown(true);
    $objValidation30->setErrorTitle('Input error');
    $objValidation30->setError('Value is not in list.');
    $objValidation30->setPromptTitle('Pick from list');
    $objValidation30->setPrompt('Please pick a value from the drop-down list.');
    $objValidation30->setFormula1('Worksheet!$'.'J$2:$'.'J$'.($attCount['City']).'');
    $objPHPExcel->getActiveSheet()->getCell('J'.$k)->setDataValidation($objValidation30);
	
	$objValidation31 = $objPHPExcel->getActiveSheet()->getCell('K2')->getDataValidation();
    $objValidation31->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation31->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation31->setAllowBlank(false);
    $objValidation31->setShowInputMessage(true);
    $objValidation31->setShowErrorMessage(true);
    $objValidation31->setShowDropDown(true);
    $objValidation31->setErrorTitle('Input error');
    $objValidation31->setError('Value is not in list.');
    $objValidation31->setPromptTitle('Pick from list');
    $objValidation31->setPrompt('Please pick a value from the drop-down list.');
    $objValidation31->setFormula1('Worksheet!$'.'K$2:$'.'K$'.($attCount['Community']).'');
    $objPHPExcel->getActiveSheet()->getCell('K'.$k)->setDataValidation($objValidation31);
	
	$objValidation32 = $objPHPExcel->getActiveSheet()->getCell('L2')->getDataValidation();
    $objValidation32->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation32->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation32->setAllowBlank(false);
    $objValidation32->setShowInputMessage(true);
    $objValidation32->setShowErrorMessage(true);
    $objValidation32->setShowDropDown(true);
    $objValidation32->setErrorTitle('Input error');
    $objValidation32->setError('Value is not in list.');
    $objValidation32->setPromptTitle('Pick from list');
    $objValidation32->setPrompt('Please pick a value from the drop-down list.');
    $objValidation32->setFormula1('Worksheet!$'.'L$2:$'.'L$'.($attCount['Caste']).'');
    $objPHPExcel->getActiveSheet()->getCell('L'.$k)->setDataValidation($objValidation32);
	
	$objValidation33 = $objPHPExcel->getActiveSheet()->getCell('M2')->getDataValidation();
    $objValidation33->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation33->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation33->setAllowBlank(false);
    $objValidation33->setShowInputMessage(true);
    $objValidation33->setShowErrorMessage(true);
    $objValidation33->setShowDropDown(true);
    $objValidation33->setErrorTitle('Input error');
    $objValidation33->setError('Value is not in list.');
    $objValidation33->setPromptTitle('Pick from list');
    $objValidation33->setPrompt('Please pick a value from the drop-down list.');
    $objValidation33->setFormula1('Worksheet!$'.'M$2:$'.'M$'.($attCount['Bloodgrp']).'');
    $objPHPExcel->getActiveSheet()->getCell('M'.$k)->setDataValidation($objValidation33);
	
	$objValidation34 = $objPHPExcel->getActiveSheet()->getCell('N2')->getDataValidation();
    $objValidation34->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation34->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation34->setAllowBlank(false);
    $objValidation34->setShowInputMessage(true);
    $objValidation34->setShowErrorMessage(true);
    $objValidation34->setShowDropDown(true);
    $objValidation34->setErrorTitle('Input error');
    $objValidation34->setError('Value is not in list.');
    $objValidation34->setPromptTitle('Pick from list');
    $objValidation34->setPrompt('Please pick a value from the drop-down list.');
    $objValidation34->setFormula1('Worksheet!$'.'N$2:$'.'N$'.($attCount['Mothertongue']).'');
    $objPHPExcel->getActiveSheet()->getCell('N'.$k)->setDataValidation($objValidation34);
	
	$objValidation35 = $objPHPExcel->getActiveSheet()->getCell('O2')->getDataValidation();
    $objValidation35->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation35->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation35->setAllowBlank(false);
    $objValidation35->setShowInputMessage(true);
    $objValidation35->setShowErrorMessage(true);
    $objValidation35->setShowDropDown(true);
    $objValidation35->setErrorTitle('Input error');
    $objValidation35->setError('Value is not in list.');
    $objValidation35->setPromptTitle('Pick from list');
    $objValidation35->setPrompt('Please pick a value from the drop-down list.');
    $objValidation35->setFormula1('Worksheet!$'.'O$2:$'.'O$'.($attCount['residenttype']).'');
    $objPHPExcel->getActiveSheet()->getCell('O'.$k)->setDataValidation($objValidation35);
	
	$objValidation36 = $objPHPExcel->getActiveSheet()->getCell('P2')->getDataValidation();
    $objValidation36->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation36->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation36->setAllowBlank(false);
    $objValidation36->setShowInputMessage(true);
    $objValidation36->setShowErrorMessage(true);
    $objValidation36->setShowDropDown(true);
    $objValidation36->setErrorTitle('Input error');
    $objValidation36->setError('Value is not in list.');
    $objValidation36->setPromptTitle('Pick from list');
    $objValidation36->setPrompt('Please pick a value from the drop-down list.');
    $objValidation36->setFormula1('Worksheet!$'.'P$2:$'.'P$'.($attCount['LocalCountry']).'');
    $objPHPExcel->getActiveSheet()->getCell('P'.$k)->setDataValidation($objValidation36);
	
	$objValidation37 = $objPHPExcel->getActiveSheet()->getCell('Q2')->getDataValidation();
    $objValidation37->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation37->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation37->setAllowBlank(false);
    $objValidation37->setShowInputMessage(true);
    $objValidation37->setShowErrorMessage(true);
    $objValidation37->setShowDropDown(true);
    $objValidation37->setErrorTitle('Input error');
    $objValidation37->setError('Value is not in list.');
    $objValidation37->setPromptTitle('Pick from list');
    $objValidation37->setPrompt('Please pick a value from the drop-down list.');
    $objValidation37->setFormula1('Worksheet!$'.'Q$2:$'.'Q$'.($attCount['LocalState']).'');
    $objPHPExcel->getActiveSheet()->getCell('Q'.$k)->setDataValidation($objValidation37);
	
	$objValidation38 = $objPHPExcel->getActiveSheet()->getCell('R2')->getDataValidation();
    $objValidation38->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation38->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation38->setAllowBlank(false);
    $objValidation38->setShowInputMessage(true);
    $objValidation38->setShowErrorMessage(true);
    $objValidation38->setShowDropDown(true);
    $objValidation38->setErrorTitle('Input error');
    $objValidation38->setError('Value is not in list.');
    $objValidation38->setPromptTitle('Pick from list');
    $objValidation38->setPrompt('Please pick a value from the drop-down list.');
    $objValidation38->setFormula1('Worksheet!$'.'R$2:$'.'R$'.($attCount['LocalCity']).'');
    $objPHPExcel->getActiveSheet()->getCell('R'.$k)->setDataValidation($objValidation38);
	
	$objValidation39 = $objPHPExcel->getActiveSheet()->getCell('S2')->getDataValidation();
    $objValidation39->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation39->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation39->setAllowBlank(false);
    $objValidation39->setShowInputMessage(true);
    $objValidation39->setShowErrorMessage(true);
    $objValidation39->setShowDropDown(true);
    $objValidation39->setErrorTitle('Input error');
    $objValidation39->setError('Value is not in list.');
    $objValidation39->setPromptTitle('Pick from list');
    $objValidation39->setPrompt('Please pick a value from the drop-down list.');
    $objValidation39->setFormula1('Worksheet!$'.'S$2:$'.'S$'.($attCount['Monthofpassing']).'');
    $objPHPExcel->getActiveSheet()->getCell('S'.$k)->setDataValidation($objValidation39);
	
	$objValidation40 = $objPHPExcel->getActiveSheet()->getCell('T2')->getDataValidation();
    $objValidation40->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation40->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation40->setAllowBlank(false);
    $objValidation40->setShowInputMessage(true);
    $objValidation40->setShowErrorMessage(true);
    $objValidation40->setShowDropDown(true);
    $objValidation40->setErrorTitle('Input error');
    $objValidation40->setError('Value is not in list.');
    $objValidation40->setPromptTitle('Pick from list');
    $objValidation40->setPrompt('Please pick a value from the drop-down list.');
    $objValidation40->setFormula1('Worksheet!$'.'T$2:$'.'T$'.($attCount['Yearofpassing']).'');
    $objPHPExcel->getActiveSheet()->getCell('T'.$k)->setDataValidation($objValidation40);
	
	$objValidation41 = $objPHPExcel->getActiveSheet()->getCell('U2')->getDataValidation();
    $objValidation41->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation41->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation41->setAllowBlank(false);
    $objValidation41->setShowInputMessage(true);
    $objValidation41->setShowErrorMessage(true);
    $objValidation41->setShowDropDown(true);
    $objValidation41->setErrorTitle('Input error');
    $objValidation41->setError('Value is not in list.');
    $objValidation41->setPromptTitle('Pick from list');
    $objValidation41->setPrompt('Please pick a value from the drop-down list.');
    $objValidation41->setFormula1('Worksheet!$'.'U$2:$'.'U$'.($attCount['Mediumofinstr']).'');
    $objPHPExcel->getActiveSheet()->getCell('U'.$k)->setDataValidation($objValidation41);
	
	$objValidation42 = $objPHPExcel->getActiveSheet()->getCell('V2')->getDataValidation();
    $objValidation42->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation42->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation42->setAllowBlank(false);
    $objValidation42->setShowInputMessage(true);
    $objValidation42->setShowErrorMessage(true);
    $objValidation42->setShowDropDown(true);
    $objValidation42->setErrorTitle('Input error');
    $objValidation42->setError('Value is not in list.');
    $objValidation42->setPromptTitle('Pick from list');
    $objValidation42->setPrompt('Please pick a value from the drop-down list.');
    $objValidation42->setFormula1('Worksheet!$'.'V$2:$'.'V$'.($attCount['Modeofadmission']).'');
    $objPHPExcel->getActiveSheet()->getCell('V'.$k)->setDataValidation($objValidation42);
	
	$objValidation43 = $objPHPExcel->getActiveSheet()->getCell('W2')->getDataValidation();
    $objValidation43->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation43->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation43->setAllowBlank(false);
    $objValidation43->setShowInputMessage(true);
    $objValidation43->setShowErrorMessage(true);
    $objValidation43->setShowDropDown(true);
    $objValidation43->setErrorTitle('Input error');
    $objValidation43->setError('Value is not in list.');
    $objValidation43->setPromptTitle('Pick from list');
    $objValidation43->setPrompt('Please pick a value from the drop-down list.');
    $objValidation43->setFormula1('Worksheet!$'.'W$2:$'.'W$'.($attCount['Reserved']).'');
    $objPHPExcel->getActiveSheet()->getCell('W'.$k)->setDataValidation($objValidation43);
	
	$objValidation44 = $objPHPExcel->getActiveSheet()->getCell('X2')->getDataValidation();
    $objValidation44->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation44->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation44->setAllowBlank(false);
    $objValidation44->setShowInputMessage(true);
    $objValidation44->setShowErrorMessage(true);
    $objValidation44->setShowDropDown(true);
    $objValidation44->setErrorTitle('Input error');
    $objValidation44->setError('Value is not in list.');
    $objValidation44->setPromptTitle('Pick from list');
    $objValidation44->setPrompt('Please pick a value from the drop-down list.');
    $objValidation44->setFormula1('Worksheet!$'.'X$2:$'.'X$'.($attCount['Quota']).'');
    $objPHPExcel->getActiveSheet()->getCell('X'.$k)->setDataValidation($objValidation44);
	
	$objValidation45 = $objPHPExcel->getActiveSheet()->getCell('Y2')->getDataValidation();
    $objValidation45->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation45->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation45->setAllowBlank(false);
    $objValidation45->setShowInputMessage(true);
    $objValidation45->setShowErrorMessage(true);
    $objValidation45->setShowDropDown(true);
    $objValidation45->setErrorTitle('Input error');
    $objValidation45->setError('Value is not in list.');
    $objValidation45->setPromptTitle('Pick from list');
    $objValidation45->setPrompt('Please pick a value from the drop-down list.');
    $objValidation45->setFormula1('Worksheet!$'.'Y$2:$'.'Y$'.($attCount['Studentstatus']).'');
    $objPHPExcel->getActiveSheet()->getCell('Y'.$k)->setDataValidation($objValidation45);
	
	$objValidation46 = $objPHPExcel->getActiveSheet()->getCell('Z2')->getDataValidation();
    $objValidation46->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation46->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation46->setAllowBlank(false);
    $objValidation46->setShowInputMessage(true);
    $objValidation46->setShowErrorMessage(true);
    $objValidation46->setShowDropDown(true);
    $objValidation46->setErrorTitle('Input error');
    $objValidation46->setError('Value is not in list.');
    $objValidation46->setPromptTitle('Pick from list');
    $objValidation46->setPrompt('Please pick a value from the drop-down list.');
    $objValidation46->setFormula1('Worksheet!$'.'Z$2:$'.'Z$'.($attCount['Permission']).'');
    $objPHPExcel->getActiveSheet()->getCell('Z'.$k)->setDataValidation($objValidation46);
	
	$objValidation47 = $objPHPExcel->getActiveSheet()->getCell('AA2')->getDataValidation();
    $objValidation47->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
    $objValidation47->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
    $objValidation47->setAllowBlank(false);
    $objValidation47->setShowInputMessage(true);
    $objValidation47->setShowErrorMessage(true);
    $objValidation47->setShowDropDown(true);
    $objValidation47->setErrorTitle('Input error');
    $objValidation47->setError('Value is not in list.');
    $objValidation47->setPromptTitle('Pick from list');
    $objValidation47->setPrompt('Please pick a value from the drop-down list.');
    $objValidation47->setFormula1('Worksheet!$'.'AA$2:$'.'AA$'.($attCount['Internship']).'');
    $objPHPExcel->getActiveSheet()->getCell('AA'.$k)->setDataValidation($objValidation47);
	
	
  
  }//secfor
}

        $filename  = 'student_excel.xls';
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
       // ob_end_clean();
	//	ob_start();
	if (ob_get_contents()) ob_end_clean();
        $objWriter->save('php://output');
        exit;
 }
		
	   //----------Upload Student Excel ---------------------//	
	if($this->input->post('uploadStuExcel'))
	{
		//echo "<pre>";print_r($_FILES);
	   $fileName    = $_FILES['userfile']['tmp_name'];
	   $objPHPExcel = PHPExcel_IOFactory::load($fileName);
	   $maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();
	   $rowsold     = $objPHPExcel->getActiveSheet()->rangeToArray('A2:' . $maxCell['column'] . $maxCell['row']); 
	   $rowsoldHeader     = $objPHPExcel->getActiveSheet()->toArray(); 
	   $sheetName   = $objPHPExcel->getActiveSheet()->getTitle();
	 // p($rowsold); //exit;
	   	$m =0;
	  //--------Insret Data Form Excel File --------//
	  
	  
	  //foreach($rowsold as $firstrow){
		  for($m=0;$m<=count($rowsold);$m++){
		  // echo "<br>---------------------".$m."-------------------------<br>";
		   $firstrow = $rowsold[$m];
		   // p($firstrow[32]);
		//  echo "<br>---------------------".$m."-------------------------<br>";
		  //  p($rowsold[$m]); 
		    if(!empty($firstrow[32]))
			{
		    $campusLists=$this->type_model->get_campus_info($firstrow[0]);
		    $degreeLists=$this->type_model->get_degree_info($firstrow[1]);
		    $batchLists=$this->type_model->get_batch_info($firstrow[2]);
		    $countryLists=$this->type_model->get_country_info($firstrow[7]);
		    $stateLists=$this->type_model->get_state_info($firstrow[8]);
			$cityLists=$this->type_model->get_city_info($firstrow[9]);
			$communityLists=$this->type_model->get_community_info($firstrow[10]);
			$casteLists=$this->type_model->get_caste_info($firstrow[11]);
			$LcountryLists=$this->type_model->get_country_info($firstrow[15]);
		    $LstateLists=$this->type_model->get_state_info($firstrow[16]);
			$LcityLists=$this->type_model->get_city_info($firstrow[17]);
			//echo "dfasf";print_r($firstrow);
			if(count($campusLists) == 0)
				$campusListsid = '';
			else
				$campusListsid = $campusLists->id;
			if(count($degreeLists) == 0)
				$degreeListsid = '';
			else
				$degreeListsid = $degreeLists->id;
			if(count($batchLists) == 0)
				$batchListsid = '';
						else
				$batchListsid = $batchLists->id;
			if(count($countryLists) == 0)
				$countryListsid = '';
						else
				$countryListsid = $countryLists->id;
			if(count($stateLists) == 0)
				$stateListsid = '';
						else
				$stateListsid = $stateLists->id;
			
				
			//echo $firstrow[32];
			$dataArr1= array(
			                'role_id'=>'1',
			                'user_unique_id'=>$firstrow[32],
			                'username'=>$firstrow[33],
			                'password'=>$firstrow[34],
			                'first_name'=>$firstrow[35],
			                'last_name'=>$firstrow[36],
			                'user_image'=>$firstrow[39],
			                'contact_number'=>$firstrow[38],
			                'email'=>$firstrow[37],
			                'gender'=>$firstrow[4],
			                'dob'=>$firstrow[40],
							'permission_status'=>$firstrow[25]
			);
			//p($dataArr1); exit;
			 $insertid=$this->type_model->get_studentexcel_data1($dataArr1);
			$dataArr2= array(
			                /*'user_id'=>$insertid,*/
							'role_id'=>'1',
			                'parent_name'=>$firstrow[41],
			                'mother_name'=>$firstrow[42],
			                'father_contact'=>$firstrow[43],
			                'alternate_contact'=>$firstrow[44],
			                'father_email'=>$firstrow[45],
							//'father_password'=>$firstrow[21],
			                'religion'=>$firstrow[5],
			                'nationality'=>$firstrow[6],
			                'address'=>$firstrow[46],
			                'street'=>$firstrow[47],
			                'country_id'=>$countryListsid,
			                'state_id'=>$stateListsid,
			                'zip_code'=>$firstrow[48],
			                'parent_image'=>$firstrow[49],
			                'registration'=>$firstrow[50],
			                'class_name'=>$firstrow[51],
			                'section_id'=>$firstrow[52],
			                'roll'=>$firstrow[53],
			                'last_school'=>$firstrow[54],
			                'last_std'=>$firstrow[55],
			                'marks_obtained'=>$firstrow[56],
			                'sports_id'=>$firstrow[57],
			                'batch_id'=>$batchListsid,
			                'campus_id'=>$campusListsid,
			                'degree_id'=>$degreeListsid,
							'course_type'=>$firstrow[3],
							'blood_group'=>$firstrow[12],
							'mother_tongue'=>$firstrow[13],
							'resident_type'=>$firstrow[14],
							'annual_income'=>$firstrow[29],
							'guardian_name'=>$firstrow[31],
							'address_local'=>$firstrow[27],
							'street_local'=>$firstrow[28],
							'country_id_local'=>$firstrow[15],
							'state_id_local'=>$firstrow[16],
							'city_id_local'=>$firstrow[17],
							'zip_code_local'=>$firstrow[18],
							//'scholarship'=>$firstrow[51],
							'month_passing'=>$firstrow[18],
							'year_passing'=>$firstrow[19],
							'medium_instr'=>$firstrow[20],
							'mode_of_admission'=>$firstrow[21],
							'reserved'=>$firstrow[22],
							'quota'=>$firstrow[23],
							'student_status'=>$firstrow[24],
							'medical_permission'=>$firstrow[25],
							'doa'=>$firstrow[58],
							'dop'=>$firstrow[59],
							'internship_grade'=>$firstrow[26],
							'ward_counsellor'=>$firstrow[60],
							'extra_activites'=>$firstrow[61],
							'remark'=>$firstrow[62],
			);
			$stateLists=$this->type_model->get_studentexcel_data2($dataArr2);
		
	   }  //$m++;
	  
	  }//exit;
	  $this->session->set_flashdata('message', 'Student Excel uploaded  successfully');
	  redirect('admin/addStudentExcel');
	}
	
		
		
		
}

    //----------End Download Excel File ---------------------//
	
	
	
	function uploadExcedFormat()
	{
	   //echo "hello"; exit;
	   $fileName    = $_FILES['userfile']['tmp_name'];
	   print_r($fileName); exit;
	   $objPHPExcel = PHPExcel_IOFactory::load($fileName);
	   $maxCell = $objPHPExcel->getActiveSheet()->getHighestRowAndColumn();
	   $rowsold     = $objPHPExcel->getActiveSheet()->rangeToArray('A2:' . $maxCell['column'] . $maxCell['row']); 
	   $rowsoldHeader     = $objPHPExcel->getActiveSheet()->toArray(); 
	   $sheetName   = $objPHPExcel->getActiveSheet()->getTitle();

	  
		$m =0;
	  //--------Insret Data Form Excel File --------//
	  foreach($rowsold as $firstrow){
		  p($firstrow);
	 
		//$studentExcel           =array();
	
		 $m++;
	   }exit;
	   $responce['excelErr'] = 'Model type excel successfully uploaded.';
	}
	
	
	//==========++++++++++++++++++++++Upload Student Excel+++++++++++++++++++++++=========================//
	function addStudentExcel()
	{
		    $data['page_title']='Student Excel Upload';
			$this->load->view('admin/excel/student_upload_excel_view',$data);
	}
	
	function downloadStudentExcel()
	{
	      if(!empty($this->input->post('studentExcel')))
          {
			
           $finalExcelArr = array('First Name','Last Name','Email',' Contact No','Gender',' DOB','Parent Name','Mother Name',' Occupation',' Father Contact',' Alternate Contact','Father Email','Religion','Nationality','Address',' Country',' State',' Zip','Registration','Class','Section','Roll','Last School','Last STD',' Marks Obtained','Sports');
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
            
            $objPHPExcel->getActiveSheet()->setCellValue($cols[0].$newvar, $value->first_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[1].$newvar, $value->last_name);
			$objPHPExcel->getActiveSheet()->setCellValue($cols[2].$newvar, $value->email);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[3].$newvar, $value->contact_number);
			$objPHPExcel->getActiveSheet()->setCellValue($cols[4].$newvar, $value->gender);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[5].$newvar, $value->dob);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[6].$newvar, $value->parent_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[7].$newvar, $value->mother_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[8].$newvar, $value->occupation);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[9].$newvar, $value->father_contact);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[10].$newvar, $value->alternate_contact);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[11].$newvar, $value->father_email);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[12].$newvar, $value->religion);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[13].$newvar, $value->nationality);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[14].$newvar, $value->address);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[15].$newvar, $value->country_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[16].$newvar, $value->state_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[17].$newvar, $value->zip_code);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[18].$newvar, $value->registration);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[19].$newvar, $value->class_name);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[20].$newvar, $value->section_id);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[21].$newvar, $value->roll);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[22].$newvar, $value->last_school);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[23].$newvar, $value->last_std);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[24].$newvar, $value->marks_obtained);
            $objPHPExcel->getActiveSheet()->setCellValue($cols[25].$newvar, $value->sports_id);
          
            }
          }

          $filename='student_upload.xls';
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
          header('Cache-Control: max-age=0'); //no cache
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
          ob_end_clean();
          ob_start();  
          $objWriter->save('php://output');

         
          }	
	}
	
	//==========++++++++++++++++++++++Upload Student Excel End+++++++++++++++++++++++=========================//
	
	



}
?>