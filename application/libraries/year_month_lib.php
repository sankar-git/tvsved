<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class year_month_lib{
		
		
	function monthdropdown(){
		$months = array();
		$currentMonth = (int)date('m');
		$m=1;
		for($x = 1; $x <= 12; $x++) 
		{
			$month = date('F', mktime(0, 0, 0, $x, 1));
			if($x>=13)	{
			$months[$m] = $month;
			 $m++;
			}
			else{
			$months[$x] = $month;	
			}
		
		}return $months;
	}
	
	
	function yeardropdown(){
		$year=array();
		$curntYear=date("Y");
		$start=2011;
		$last=$curntYear+6;
		$count=0;
		for($i=$start; $i<=$last; $i++){
			$year[$count]=$i;
			$count++;
		}
		return $year;
	}
	
	function download_file()
	{
		$CI=& get_instance();
		$file=$CI->uri->segment(3);
		$file_name = './uploads/report/'.$file;
		$mime = 'application/force-download';
		header('Pragma: public');    
		header('Expires: 0');        
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Type: '.$mime);
		header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
		header('Content-Transfer-Encoding: binary');
		header('Connection: close');
		readfile($file_name);    
		exit();
	
	}
		
	}
?>