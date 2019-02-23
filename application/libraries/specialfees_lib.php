<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class specialfees_lib{
		
		
		public function specialfees_user_arr($user_id,$month,$year)
		{
			$CI=& get_instance();
			$data_conce=array();
				$whereconcession='user_id = '.$user_id.' and ( MONTH(effective_month) = '.$month.' OR MONTH(effective_month) > '.$month.' )';
				$whereconcession.=' and ( MONTH(endmonth) = '.$month.' OR MONTH(endmonth) < '.$month.' )';
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.') order by id DESC' ;
				$data_conce=$CI->common_model->selectWhere('specialfees_user',$whereconcession);					
				if(count($data_conce)>0)
				{
					return 	$data_conce;					
				}
				return 	$data_conce;
		}
		
		public function specialfees_enabled_amount($user_id,$month,$year)
		{
			$CI=& get_instance();
			$amount=0;
				$whereconcession='user_id = '.$user_id.' and ( MONTH(effective_month) = '.$month.' OR MONTH(effective_month) < '.$month.' )';
				$whereconcession.=' and ( MONTH(endmonth) = '.$month.' OR MONTH(endmonth) > '.$month.' )';
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.') order by id DESC' ;
				$data_conce=$CI->common_model->selectWhere('specialfees_user',$whereconcession);					
				if(count($data_conce)>0)
				{
					return 	$amount=$data_conce[0]->amount;					
				}
				return 	$amount;
		}
		
		public function specialfees_enabled_id($user_id,$month,$year)
		{
			$CI=& get_instance();
			$id=0;
				$whereconcession='user_id = '.$user_id.' and ( MONTH(effective_month) = '.$month.' OR MONTH(effective_month) < '.$month.' )';
				$whereconcession.=' and ( MONTH(endmonth) = '.$month.' OR MONTH(endmonth) > '.$month.' )';
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.') order by id DESC' ;
				$data_conce=$CI->common_model->selectWhere('specialfees_user',$whereconcession);					
				if(count($data_conce)>0)
				{
					return 	$id=$data_conce[0]->id;					
				}
				return 	$id;
		}
		
		function _status($effective_date,$id,$special_userid)
		{
			$enable='Disabled';
			if( (int)date("Y",strtotime($effective_date)) == (int)date("Y",strtotime(date("Y-m-d"))) )
			{
				if( (int)date("m",strtotime($effective_date)) == (int)date("m",strtotime(date("Y-m-d"))) )
				{					
					if($id==$special_userid)
					{
						$enable='Enabled';
					}else{
						$enable='Disabled';
					}					
									
				}
				
				if( (int)date("m",strtotime($effective_date)) < (int)date("m",strtotime(date("Y-m-d"))) )
				{
					$enable='Not Working With It.';
				}
				
				if( (int)date("m",strtotime($effective_date)) > (int)date("m",strtotime(date("Y-m-d"))) )
				{
					$enable='New';
				}
			}
			return $enable;
		}
		
	}
?>