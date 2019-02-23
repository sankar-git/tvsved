<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class concession_lib{
		
		
		public function concession_user_arr($user_id,$month,$year)
		{
			$CI=& get_instance();
			$data_conce=array();
				$whereconcession='user_id = '.$user_id.' and ( MONTH(effective_month) = '.$month.' OR MONTH(effective_month) > '.$month.' )';
				$whereconcession.=' and ( MONTH(endmonth) = '.$month.' OR MONTH(endmonth) < '.$month.' )';
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.') order by id DESC' ;
				$data_conce=$CI->common_model->selectWhere('concession_user',$whereconcession);					
				if(count($data_conce)>0)
				{
					return 	$data_conce;					
				}
				return 	$data_conce;
		}
		/*public function concession_check($date)
		{
			$CI=& get_instance();
			$amount=0;
				$whereconcession='user_id = '.$user_id.' and ( MONTH(effective_month) = '.$month.' OR MONTH(effective_month) < '.$month.' )';				
				$data_conce=$CI->common_model->selectWhere('concession',$whereconcession);					
				if(count($data_conce)>0)
				{
					return 	$amount=$data_conce[0]->amount;					
				}
				return 	$amount;
		}*/
		
		public function concession_enabled_amount($user_id,$month,$year)
		{
			$CI=& get_instance();
			$amount=0;
				$whereconcession='user_id = '.$user_id.' and ( MONTH(effective_month) = '.$month.' OR MONTH(effective_month) < '.$month.' )';
				$whereconcession.=' and ( MONTH(endmonth) = '.$month.' OR MONTH(endmonth) > '.$month.' )';
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.') order by id DESC' ;
				$data_conce=$CI->common_model->selectWhere('concession_user',$whereconcession);					
				if(count($data_conce)>0)
				{
					return 	$amount=$data_conce[0]->amount;					
				}
				return 	$amount;
		}
		
		public function concession_enabled_id($user_id,$month,$year)
		{
			$CI=& get_instance();
			$id=0;
				$whereconcession='user_id = '.$user_id.' and ( MONTH(effective_month) = '.$month.' OR MONTH(effective_month) < '.$month.' )';
				$whereconcession.=' and ( MONTH(endmonth) = '.$month.' OR MONTH(endmonth) > '.$month.' )';
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.') order by id DESC' ;
				$data_conce=$CI->common_model->selectWhere('concession_user',$whereconcession);					
				if(count($data_conce)>0)
				{
					return 	$id=$data_conce[0]->id;					
				}
				return 	$id;
		}
		
	}
?>