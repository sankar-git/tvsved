<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class payment_lib{
		
		function paid_permonth($userid,$month,$year,$class_id,$role_id)
		{
			$CI=& get_instance();
			$where='paid_year = '.$year.' and paid_month = '.$month.' and user_id = '.$userid.' and role_id = '.$role_id.' and class_id = '.$class_id;
			$paid=$CI->common_model->selectColmnWhere('payment','min(due) as due,sum(paid) as paid',$where);	
			return $paid;
		}
		
		function paid_latepayment($lateamount,$year,$month)
		{
			$CI=& get_instance();						
			$where='paid_year = '.$year.' and paid_month = '.$month.' and latefine = '.$lateamount;
			$paid=$CI->common_model->selectWhere('payment',$where);	
			return $paid;
		}		
		
		function late_payment($userid,$month,$year,$class_id,$role_id)
		{
			$CI=& get_instance();
			$where='paid_year = '.$year.' and paid_month = '.$month.' and user_id = '.$userid.' and role_id = '.$role_id.' and class_id = '.$class_id.' order by id asc';
			$paid=$CI->common_model->selectWhere('payment',$where);	
			return $paid;
		}
		
		function yearlylate_payment($userid,$month,$lastmonth,$year,$class_id,$role_id)
		{
			$CI=& get_instance();
			$count=0;
			$paylist=array();			
			$yearly_paid=0;			
			while($month<=$lastmonth)
			{
				$paylist[$count]['latefine']=0;
				$paylist[$count]['yearly_latefine']=0;
				$paylist[$count]['month']=$month;
				$paylist[$count]['fullmonth']=date('F', mktime(0, 0, 0, $month, 1));						
				$paid_permonth=$this->late_payment($userid,$month,$year,$class_id,$role_id);
				if(isset($paid_permonth[0]))
				{
					if($paid_permonth[0]->latefine!='')
					{
						$paylist[$count]['latefine']=$paid_permonth[0]->latefine;
					}					
					$yearly_paid+=$paylist[$count]['latefine'];
				}
				$paylist[$count]['yearly_latefine']=$yearly_paid;				
				$month++;
				$count++;
			}
			return $paylist;			
		}
		
		
		function latepayment($month,$year)
		{
			$CI=& get_instance();
			 $crnt_month=(int)date("m",strtotime(date("Y-m-d")));
			$crnt_date=(int)date("d",strtotime(date("Y-m-d")));
			$crnt_year=(int)date("Y",strtotime(date("Y-m-d")));			
			$fine_amount=0;
			$enddate=0;
			$process='';
			$days=0;
			$fine=$CI->common_model->selectWhere('latepayment','');
			if(isset($fine[0]->end_date)>0)
			{
				$enddate=$fine[0]->end_date;
			}		
			if($year <= $crnt_year)
			{
				if($month < $crnt_month)
				{
					if(isset($fine[0]->amount)>0)
					{
						 $fine_amount=$fine[0]->amount;
						  $process=$fine[0]->process;
					}
					//echo $month;					
					for($i=$month;$i<$crnt_month;$i++)
					{ 
						  $number1 = cal_days_in_month(CAL_GREGORIAN, $i, $year);
						  $month_days=$number1-$enddate;
						$days=$days+$month_days;
					}
				}
				
				if($month == $crnt_month)
				{
					if($enddate < $crnt_date)
					{
						if(isset($fine[0]->amount)>0)
						{
							 $fine_amount=$fine[0]->amount;
							 $process=$fine[0]->process;
							 $month_days=$crnt_date-$enddate;
							$days=$days+$month_days;
						}
					}
				}
				
				if($process=='perday')
				{
					if($enddate!=0)
					{
						$fine_amount=$fine_amount * $days;
					}
				}
			}
			return $fine_amount;
		}
		
		
		function session_charge($userid,$month,$year,$class_id)
		{
			$CI=& get_instance();
			$yearly_paid=0;			
				
				$whereconcession='user_id = '.$userid.' and class_id = '.$class_id;
				if($year!='')
				{
					//$whereconcession.=' and MONTH(created_date) = '.$month;
					$whereconcession.=' and YEAR(created_date) = '.$year ;
				}
				$concession=$CI->common_model->selectWhere('session_charge',$whereconcession);	
					
				if(isset($concession[0]))
				{
					if($concession[0]->session_charge!='')
					{										
						$yearly_paid=$concession[0]->session_charge;
					}
				}
				
				if($yearly_paid==0)
				{
					$concession=$CI->common_model->selectWhere('sessioncharge','(class_id = '.$class_id.' OR class_id = 0)');
					if(isset($concession[0]))
					{
						if($concession[0]->amount!='')
						{										
							$yearly_paid=$concession[0]->amount;
						}
					}
				}
			if($month==1)
			{	
				return $yearly_paid;
			}else{
				return 0;
			}
		}
		
		function security_deposit($userid,$month,$year,$class_id)
		{
			$CI=& get_instance();
			$yearly_paid=0;			
				$whereconcession='user_id = '.$userid.' and class_id = '.$class_id;
				/*
				if($year!='')
								{
									$whereconcession.=' and MONTH(created_date) = '.$month;
									$whereconcession.=' and YEAR(created_date) = '.$year ;
								}
				*/
								$concession=$CI->common_model->selectWhere('security_deposit',$whereconcession);	
					
				if(isset($concession[0]))
				{
					if($concession[0]->deposit!='')
					{										
						$yearly_paid=$concession[0]->deposit;
					}
				}
			if($month==1)
			{	
				return $yearly_paid;
			}else{
				return 0;
			}
		}
		
		
		function yearly_paid($userid,$month,$lastmonth,$year,$class_id,$role_id)
		{
			$CI=& get_instance();
			$count=0;
			$paylist=array();			
			$yearly_paid=0;			
			while($month<=$lastmonth)
			{
				$paylist[$count]['paid']=0;
				$paylist[$count]['yearly_paid']=0;
				$paylist[$count]['month']=$month;
				$paylist[$count]['fullmonth']=date('F', mktime(0, 0, 0, $month, 1));
						
				$paid_permonth=$this->paid_permonth($userid,$month,$year,$class_id,$role_id);
				if(isset($paid_permonth[0]))
				{
					if($paid_permonth[0]->paid!='')
					{
						$paylist[$count]['paid']=$paid_permonth[0]->paid;
					}					
					$yearly_paid+=$paylist[$count]['paid'];
				}
				$paylist[$count]['yearly_paid']=$yearly_paid;				
				$month++;
				$count++;
			}
			return $paylist;			
		}
		
		function yearly_concession($userid,$month,$lastmonth,$year)
		{
			$CI=& get_instance();
			$yearly_paid=0;			
			while($month<=$lastmonth)
			{
				$whereconcession='user_id = '.$userid.' and ( MONTH(effective_month) = '.$month.' OR MONTH(effective_month) < '.$month.' )';
				$whereconcession.=' and ( MONTH(endmonth) = '.$month.' OR MONTH(endmonth) > '.$month.' )';
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.') order by id DESC' ;
				$concession=$CI->common_model->selectColmnWhere('concession_user','sum(amount) as amount',$whereconcession);					
				if(isset($concession[0]))
				{
					if($concession[0]->amount!='')
					{										
						$yearly_paid+=$concession[0]->amount;
					}
				}				
				
				/*
				$whereconcession='( MONTH(start_date) = '.$month.' OR MONTH(start_date) < '.$month.' )';
								$whereconcession.=' and ( MONTH(end_date) = '.$month.' OR MONTH(end_date) > '.$month.' )';
								$whereconcession.=' and ( YEAR(start_date) = '.$year.' OR YEAR(start_date) < '.$year.')' ;
								$whereconcession.=' and ( YEAR(end_date) = '.$year.' OR YEAR(end_date) > '.$year.') and concession_status = "all"' ;
								$data_all=$CI->common_model->selectWhere('concession',$whereconcession);									
								if(count($data_all)>0)
								{
									foreach($data_all as $rowall)
									{
										$yearly_paid+=$rowall->concession_amount;
														
									}					
								}			
								
								$whereconcession='( MONTH(start_date) = '.$month.' OR MONTH(start_date) < '.$month.' )';
								$whereconcession.=' and ( MONTH(end_date) = '.$month.' OR MONTH(end_date) > '.$month.' )';
								$whereconcession.=' and ( YEAR(start_date) = '.$year.' OR YEAR(start_date) < '.$year.')' ;
								$whereconcession.=' and ( YEAR(end_date) = '.$year.' OR YEAR(end_date) > '.$year.') and concession_status = "student"' ;
								$data_st=$CI->common_model->selectWhere('concession',$whereconcession);									
								if(count($data_st)>0)
								{
									foreach($data_st as $rowst)
									{
										$yearly_paid+=$rowst->concession_amount;						
									}					
								}		
								
						*/
						$month++;
			}
			return $yearly_paid;			
		}
		
		function yearly_charges($userid,$month,$lastmonth,$year)
		{
			$CI=& get_instance();
			$yearly_paid=0;			
			while($month<=$lastmonth)
			{
				$whereconcession='user_id = '.$userid.' and ( MONTH(effective_month) = '.$month.' OR MONTH(effective_month) < '.$month.' )';
				$whereconcession.=' and ( MONTH(endmonth) = '.$month.' OR MONTH(endmonth) > '.$month.' )';
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.') order by id DESC' ;
				$concession=$CI->common_model->selectColmnWhere('specialfees_user','sum(amount) as amount',$whereconcession);
				if(isset($concession[0]))
				{
					if($concession[0]->amount!='')
					{										
						$yearly_paid+=$concession[0]->amount;
					}
				}
				
				$whereconcession='( MONTH(start_date) = '.$month.' OR MONTH(start_date) < '.$month.' )';
				$whereconcession.=' and ( MONTH(end_date) = '.$month.' OR MONTH(end_date) > '.$month.' )';
				$whereconcession.=' and ( YEAR(start_date) = '.$year.' OR YEAR(start_date) < '.$year.')' ;
				$whereconcession.=' and ( YEAR(end_date) = '.$year.' OR YEAR(end_date) > '.$year.') and sp_status = "all"' ;
				$data_all=$CI->common_model->selectWhere('specialfees',$whereconcession);									
				if(count($data_all)>0)
				{
					foreach($data_all as $rowall)
					{
						$yearly_paid+=$rowall->specialamount;										
					}					
				}				
				
				$whereconcession='( MONTH(start_date) = '.$month.' OR MONTH(start_date) < '.$month.' )';
				$whereconcession.=' and ( MONTH(end_date) = '.$month.' OR MONTH(end_date) > '.$month.' )';
				$whereconcession.=' and ( YEAR(start_date) = '.$year.' OR YEAR(start_date) < '.$year.')' ;
				$whereconcession.=' and ( YEAR(end_date) = '.$year.' OR YEAR(end_date) > '.$year.') and sp_status = "student"' ;
				$data_st=$CI->common_model->selectWhere('specialfees',$whereconcession);									
				if(count($data_st)>0)
				{
					foreach($data_st as $rowst)
					{
						$yearly_paid+=$rowst->specialamount;
					}					
				}	
				
				$month++;
			}
			return $yearly_paid;			
		}
		
		
		
		public function concession_per_user($userid,$month,$year,$condata)
		{
			$CI=& get_instance();
			$charge_data=array();
			$count=0;
			$amount=0;
				$whereconcession='user_id = '.$userid.' and ( MONTH(effective_month) = '.$month.' OR MONTH(effective_month) < '.$month.' )';
				$whereconcession.=' and ( MONTH(endmonth) = '.$month.' OR MONTH(endmonth) > '.$month.' )';
				$whereconcession.=' and ( YEAR(endmonth) = '.$year.' OR YEAR(endmonth) > '.$year.')' ;
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.') order by id DESC' ;
				//echo $whereconcession;
				$data_conce=$CI->common_model->selectWhere('concession_user',$whereconcession);
												
				if(count($data_conce)>0)
				{
					foreach($data_conce as $row)
					{
						$amount+=$row->amount;
						$charge_data[$count]['chrg_name']=$CI->common_model->single_value('concession','concession_type','id = '.$row->concession_id);
						$charge_data[$count]['chrg_amount']=$row->amount;
						$count++;
					}									
				}
				
				/*
				$whereconcession='( MONTH(start_date) = '.$month.' OR MONTH(start_date) < '.$month.' )';
								$whereconcession.=' and ( MONTH(end_date) = '.$month.' OR MONTH(end_date) > '.$month.' )';
								$whereconcession.=' and ( YEAR(start_date) = '.$year.' OR YEAR(start_date) < '.$year.')' ;
								$whereconcession.=' and ( YEAR(end_date) = '.$year.' OR YEAR(end_date) > '.$year.') and concession_status = "all"' ;
								$data_all=$CI->common_model->selectWhere('concession',$whereconcession);									
								if(count($data_all)>0)
								{
									foreach($data_all as $rowall)
									{
										$amount+=$rowall->concession_amount;
										$charge_data[$count]['chrg_name']=$CI->common_model->single_value('concession','concession_type','id = '.$rowall->id);
										$charge_data[$count]['chrg_amount']=$rowall->concession_amount;
										$count++;					
									}					
								}
								
								
								$whereconcession='( MONTH(start_date) = '.$month.' OR MONTH(start_date) < '.$month.' )';
								$whereconcession.=' and ( MONTH(end_date) = '.$month.' OR MONTH(end_date) > '.$month.' )';
								$whereconcession.=' and ( YEAR(start_date) = '.$year.' OR YEAR(start_date) < '.$year.')' ;
								$whereconcession.=' and ( YEAR(end_date) = '.$year.' OR YEAR(end_date) > '.$year.') and concession_status = "student"' ;
								$data_st=$CI->common_model->selectWhere('concession',$whereconcession);									
								if(count($data_st)>0)
								{
									foreach($data_st as $rowst)
									{
										$amount+=$rowst->concession_amount;
										$charge_data[$count]['chrg_name']=$CI->common_model->single_value('concession','concession_type','id = '.$rowst->id);
										$charge_data[$count]['chrg_amount']=$rowst->concession_amount;
										$count++;
										}
								}*/
								
				if($condata=='')
				{
					return 	$amount;
				}else{					
					return $charge_data;
				}
		}
		
		public function charge_per_user($userid,$month,$year,$chargedata)
		{
			$CI=& get_instance();
			$charge_data=array();
			$count=0;
			$amount=0;
				$whereconcession='user_id = '.$userid.' and ( MONTH(effective_month) = '.$month.' OR MONTH(effective_month) < '.$month.' )';
				$whereconcession.=' and ( MONTH(endmonth) = '.$month.' OR MONTH(endmonth) > '.$month.' )';
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.') order by id DESC' ;
				$data_conce=$CI->common_model->selectWhere('specialfees_user',$whereconcession);									
				if(count($data_conce)>0)
				{
					foreach($data_conce as $row)
					{
						$amount+=$row->amount;						
						$charge_data[$count]['chrg_name']=$CI->common_model->single_value('specialfees','specialfees','id = '.$row->specialfees_id);
						$charge_data[$count]['chrg_amount']=$row->amount;
						$count++;
					}									
				}				
				
				$whereconcession='( MONTH(start_date) = '.$month.' OR MONTH(start_date) < '.$month.' )';
				$whereconcession.=' and ( MONTH(end_date) = '.$month.' OR MONTH(end_date) > '.$month.' )';
				$whereconcession.=' and ( YEAR(start_date) = '.$year.' OR YEAR(start_date) < '.$year.')' ;
				$whereconcession.=' and ( YEAR(end_date) = '.$year.' OR YEAR(end_date) > '.$year.') and sp_status = "all"' ;
				$data_all=$CI->common_model->selectWhere('specialfees',$whereconcession);									
				if(count($data_all)>0)
				{
					foreach($data_all as $rowall)
					{
						$amount+=$rowall->specialamount;
						$charge_data[$count]['chrg_name']=$CI->common_model->single_value('specialfees','specialfees','id = '.$rowall->id);
						$charge_data[$count]['chrg_amount']=$rowall->specialamount;
						$count++;				
					}					
				}				
				
				$whereconcession='( MONTH(start_date) = '.$month.' OR MONTH(start_date) < '.$month.' )';
				$whereconcession.=' and ( MONTH(end_date) = '.$month.' OR MONTH(end_date) > '.$month.' )';
				$whereconcession.=' and ( YEAR(start_date) = '.$year.' OR YEAR(start_date) < '.$year.')' ;
				$whereconcession.=' and ( YEAR(end_date) = '.$year.' OR YEAR(end_date) > '.$year.') and sp_status = "student"' ;
				$data_st=$CI->common_model->selectWhere('specialfees',$whereconcession);									
				if(count($data_st)>0)
				{
					foreach($data_st as $rowst)
					{
						$amount+=$rowst->specialamount;
						$charge_data[$count]['chrg_name']=$CI->common_model->single_value('specialfees','specialfees','id = '.$rowst->id);
						$charge_data[$count]['chrg_amount']=$rowst->specialamount;
						$count++;
					}					
				}
				
				if($chargedata=='')
				{
					return 	$amount;
				}else{
					
					return $charge_data;
				}
		}
		
		function studentlist($userid,$month,$year,$class_id)
		{
			$CI=& get_instance();
			$where='';
			if($userid!='')
			{
				$where.=' and user_id = '.$userid;
			}			
			$column=" Select total as class_fees,fees_user_class.user_id,student.registration_no,first_name,middle_name,last_name from fees_user_class";
			$wherecls=" where status= 'active' and fees_user_class.class_id = ".$class_id." and year(fees_user_class.updated_date) = ".$year.$where;
			
			$innerjoin=' inner join student on fees_user_class.user_id=student.id';
			$innerjoin.=' inner join fees on fees_user_class.class_id=fees.class_id';
			$data['user']=$CI->common_model->sql_string($column.$innerjoin.$wherecls);
			//echo $CI->db->last_query(); echo "<pre>"; print_r($data['user']);exit;
			return $data['user'];
		}
		
		function paymentlist($userid,$month,$lastmonth,$year,$class_id)
		{
			$CI=& get_instance();
			$role_id=2;
			$data['user']=$this->studentlist($userid,$month,$year,$class_id);
			//echo $CI->db->last_query();
		    //echo "<pre>"; print_r($data['user']); exit;	
		
			$table= '<table border="1">';
			$table.= '<caption>'.$year.' Class-'.$class_id.' </caption>';
			$table.= '<tr>';
				$table.= '<th>Registration No</th>';						
				$table.= '<th>Name</th>';
				$table.= '<th>Class Fees</th>';
				$table.= '<th>Concession</th>';
				$table.= '<th>Charge</th>';
				$table.= '<th>Session Charge</th>';
				$table.= '<th>Medical Charge</th>';
				$table.= '<th>Security Deposit</th>';
				$table.= '<th>Late Fine</th>';	
				$table.= '<th>Total Fees</th>';			
				$table.= '<th>Paid</th>';
				$table.= '<th>Due</th>';
				$table.= '<th>Payable</th>';				
			$table.= '</tr>';
		
		if(count($data['user'])>0)
		{
			foreach($data['user'] as $row)
			{
				$row->name='';
				$row->name=$row->first_name;
				if($row->middle_name!='')
				{
					$row->name.=' '.$row->middle_name;
				}
				$row->name.=' '.$row->last_name;			
				$row->due=0;
				$row->paid=0;
				$row->yearly_paid=0;
				$row->month=$month;
				$row->full_month=date('F', mktime(0, 0, 0, $month, 1));	
				$row->specialfees=0;
				$row->concession=0;
				$row->totfees=0;
				$row->nowdue=0;
				$row->payment_status='unpaid';
				$row->latefine=0;
				$latepaid=$this->late_payment($row->user_id,$month,$year,$class_id,$role_id);
				if(isset($latepaid[0]->latefine))
				{
					$row->latefine=$latepaid[0]->latefine;
				}
				$totfees=0;			
			
				$row->session_charge=$this->session_charge($row->user_id,$month,$year,$class_id);				
				$row->security_deposit=$this->security_deposit($row->user_id,$month,$year,$class_id);				
				$paid_permonth=$this->paid_permonth($row->user_id,$month,$year,$class_id,$role_id);
				foreach($paid_permonth as $rowy)
				{
					$row->paid=$rowy->paid;					
				}				
				$row->concession=$this->concession_per_user($row->user_id,$month,$year,'');
				$row->specialfees=$this->charge_per_user($row->user_id,$month,$year,'');
				$row->medical_crg_paid='';
				$row->medical_crg=$CI->common_model->single_value('tblcharge','charge_amount','user_id = '.$row->user_id.' and paid_month = '.$month.' and paid_year = '.$year); 
				$row->medical_crg_name=$CI->common_model->single_value('tblcharge','charge_name','user_id = '.$row->user_id.' and paid_month = '.$month.' and paid_year = '.$year); 
				if($row->medical_crg=='')
				{
					$row->medical_crg=0;
					$row->medical_crg_paid='';
				}else{
					$row->medical_crg_paid='paid';
				}
				
				$totfees=($row->class_fees + $row->specialfees + $row->session_charge + $row->security_deposit +$row->medical_crg) - $row->concession ;
				$row->totfees=$totfees;
				$row->due=($totfees +$row->latefine)-$row->paid;
				$row->nowdue=number_format(($row->due),2);
				if($row->due==0)
				{
					$row->payment_status='paid';
				}
				
				$table.= '<tr>';
				$table.= '<th>'.$row->registration_no.'</th>';						
				$table.= '<th>'.$row->name.'</th>';
				$table.= '<th>'.number_format(($row->class_fees),2).'</th>';
				$table.= '<th>'.$row->concession.'</th>';
				$table.= '<th>'.$row->specialfees.'</th>';
				$table.= '<th>'.$row->session_charge.'</th>';
				$table.= '<th>'.$row->medical_crg.'</th>';
				$table.= '<th>'.$row->security_deposit.'</th>';
				$table.= '<th>'.$row->latefine.'</th>';	
				$table.= '<th>'.number_format(($totfees + $row->latefine),2).'</th>';
							
				$table.= '<th>'.$row->paid.'</th>';
				$table.= '<th>'.number_format(($row->due),2).'</th>';
				$table.= '<th>'.$row->nowdue.'</th>';
				$table.= '</tr>';
			}
		}
		
		$table.= '</table>';	
		if(file_exists('./uploads/report/paymentlist.xls'))
		{
			unlink('./uploads/report/paymentlist.xls');
		}
			$fp = fopen('./uploads/report/paymentlist.xls', "w");
			fwrite($fp, $table);
			fclose($fp);
		
		//echo "<pre>"; print_r($data['user']);exit;	
			return $data['user'];
					
		}
		
		function user_paymentlist($name,$registration,$userid,$month,$lastmonth,$year,$class_id,$role_id,$class_fees)
		{
			$CI=& get_instance();
			$data['user']=array();
			$count=0;
			$paylist=array();				
			while($month<=$lastmonth)
			{				
				$paylist[$count]['paid']=0;
				$paylist[$count]['paid_month']=$month;				
				$paylist[$count]['full_month']=date('F', mktime(0, 0, 0, $month, 1));
				$paylist[$count]['paid_year']=$year;
				$paylist[$count]['status']='unpaid';
				$paylist[$count]['month_status']='unpaid';
				$paylist[$count]['due_reason']='';
				$paylist[$count]['due']=0;
				$paylist[$count]['invoice_no']='';
				$paylist[$count]['payment_date']='0000-00-00';
				
				$paylist[$count]['session_charge']=$this->session_charge($userid,$month,$year,$class_id);				
				$paylist[$count]['security_deposit']=$this->security_deposit($userid,$month,$year,$class_id);
				$paylist[$count]['latefine']=0;
				$latepaid=$this->late_payment($userid,$month,$year,$class_id,$role_id);
				if(isset($latepaid[0]->latefine))
				{
					$paylist[$count]['latefine']=$latepaid[0]->latefine;
				}
				$concession=$this->concession_per_user($userid,$month,$year,'');
				$specialfees=$this->charge_per_user($userid,$month,$year,'');
			$paylist[$count]['medical_crg_paid']='';
		 $paylist[$count]['medical_crg']=$CI->common_model->single_value('tblcharge','charge_amount','user_id = '.$userid.' and paid_month = '.$month.' and paid_year = '.$year); 
		$paylist[$count]['medical_crg_name']=$CI->common_model->single_value('tblcharge','charge_name','user_id = '.$userid.' and paid_month = '.$month.' and paid_year = '.$year); 
				if($paylist[$count]['medical_crg']=='')
				{
					$paylist[$count]['medical_crg']=0;	
					$paylist[$count]['medical_crg_paid']='';
				}else{
					$paylist[$count]['medical_crg_paid']='paid';
				}
				$totfees=($class_fees + $specialfees + $paylist[$count]['session_charge'] + $paylist[$count]['security_deposit'] ) - $concession;
				$paid=0;
				$paylist[$count]['concession']=$concession;
				$paylist[$count]['specialfees']=$specialfees;
				$paylist[$count]['totfees']=$totfees;
				$paylist[$count]['payable']=($totfees +$paylist[$count]['latefine'] +$paylist[$count]['medical_crg'])- $paid;	
				$paylist[$count]['btnpay']='unpaid'	;	
							
				$where='paid_year = '.$year.' and paid_month = '.$month.' and user_id = '.$userid.' and role_id = '.$role_id.' and class_id = '.$class_id;
				$payment=$CI->common_model->selectWhere('payment',$where);
				$rowcount=$count;	
				$pay_count=1;				
				foreach($payment as $row)
				{
					$paylist[$rowcount]['session_charge']=$paylist[$count]['session_charge'];
					$paylist[$rowcount]['security_deposit']=$paylist[$count]['security_deposit'];
					$paylist[$rowcount]['latefine']=$paylist[$count]['latefine'];
					$paylist[$rowcount]['medical_crg']=$paylist[$count]['medical_crg'];
					$paylist[$rowcount]['medical_crg_name']=$paylist[$count]['medical_crg_name'];
					
					$paylist[$rowcount]['medical_crg_paid']=$paylist[$count]['medical_crg_paid'];
					$paylist[$rowcount]['concession']=$concession;
					$paylist[$rowcount]['specialfees']=$specialfees;
					$paylist[$rowcount]['totfees']=$totfees;
					$paid+=$row->paid;
					$paylist[$rowcount]['paid']=$row->paid;
					$paylist[$rowcount]['paid_month']=$month;
					$paylist[$rowcount]['full_month']=date('F', mktime(0, 0, 0, $row->paid_month, 1));
					$paylist[$rowcount]['paid_year']=$year;
					$paylist[$rowcount]['status']=$row->status;
					$paylist[$rowcount]['month_status']=$row->month_status;
					$paylist[$rowcount]['due_reason']=$row->due_reason;
					$paylist[$rowcount]['due']=$row->due;
					$paylist[$rowcount]['invoice_no']=$row->invoice_no;
					$paylist[$rowcount]['payment_date']=$row->payment_date;						
					$paylist[$rowcount]['payable']=($totfees + $paylist[$count]['latefine'] + $paylist[$count]['medical_crg'])-$paid;					
					
					if(count($payment)==$pay_count)
					{
						$paylist[$rowcount]['btnpay']=$row->status;
					}else{
						$paylist[$rowcount]['btnpay']='due';
					}
					$pay_count++;					
					
					$count=$rowcount;
					$rowcount++;										
				}				
				$count++;			
				$month++;									
			}
			
		$table= '<table border="1">';
		$table.= '<caption>'.$year.' Class-'.$class_id.$name.'('.$registration.') </caption>';
					$table.= '<tr>';
						$table.= '<th>Month </th>';						
						$table.= '<th>Year</th>';
						$table.= '<th>Class Fees</th>';
						$table.= '<th>Concession</th>';
						$table.= '<th>Special Charge</th>';
						$table.= '<th>Medical Charge</th>';
						$table.= '<th>Session Charge</th>';
						$table.= '<th>Security Deposit</th>';
						$table.= '<th>Late Fine</th>';						
						$table.= '<th>Total Fees</th>';						
						$table.= '<th>Paid</th>';
						$table.= '<th>Due</th>';
						$table.= '<th>Payable</th>';
						$table.= '<th>Status</th>';
					$table.= '</tr>';
					
									
		foreach($paylist as $rows)
		{					
			$table.= '<tr>';
				$table.= '<td>'.$rows['full_month'].'</td>';						
				$table.= '<td>'.$rows['paid_year'].'</td>';
				$table.= '<td>'.number_format(($class_fees),2).'</td>';
				$table.= '<td>'.number_format(($rows['concession']),2).'</td>';
				$table.= '<td>'.number_format(($rows['specialfees']),2).'</td>';
				$table.= '<td>'.number_format(($rows['medical_crg']),2).'</td>';
				$table.= '<td>'.number_format(($rows['session_charge']),2).'</td>';
				$table.= '<td>'.number_format(($rows['security_deposit']),2).'</td>';
				$table.= '<td>'.number_format(($rows['latefine']),2).'</td>';
				$table.= '<td>'.number_format(($rows['totfees']+$rows['latefine']),2).'</td>';
				$table.= '<td>'.number_format(($rows['paid']),2).'</td>';
				$table.= '<td>'.number_format(($rows['due']),2).'</td>';
				$table.= '<td>'.number_format(($rows['payable']),2).'</td>';
				$table.= '<td>'.$rows['month_status'].'</td>';
				$table.= '</tr>';
		}
		$table.= '</table>';	
		if(file_exists('./uploads/report/user_paymentlist.xls'))
		{
			unlink('./uploads/report/user_paymentlist.xls');
		}
			$fp = fopen('./uploads/report/user_paymentlist.xls', "a");
			fwrite($fp, $table);
			fclose($fp);
		
			//echo "<pre>"; print_r($paylist);exit;
			return $paylist;					
		}
		
		function yearlydue($class_id,$year,$month,$lastmonth)
		{
			$CI=& get_instance();
			$data['user']=$this->studentlist('','',$year,$class_id);
			if(count($data['user'])>0)
			{
				foreach($data['user'] as $row)
				{
					$row->name='';
					$row->name=$row->first_name;
					if($row->middle_name!='')
					{
						$row->name.=' '.$row->middle_name;
					}
					$row->name.=' '.$row->last_name;	
					
					$row->session_charge=$this->session_charge($row->user_id,1,$year,$class_id);
					$row->security_deposit=$this->security_deposit($row->user_id,$month,$year,$class_id);
												
					$row->concession=$this->yearly_concession($row->user_id,$month,$lastmonth,$year);
					$row->charges=$this->yearly_charges($row->user_id,$month,$lastmonth,$year);
					$paid=$this->yearly_paid($row->user_id,$month,$lastmonth,$year,$class_id,2);
					$row->paid=0;
					$numrow=count($paid) - 1;
					if(isset($paid[$numrow]['yearly_paid']))
					{
						$row->paid=$paid[$numrow]['yearly_paid'];
					}
					
					$medical_crg=0;
					
					$classfees=0;
					$x=$month;
					while($x<=$lastmonth)
					{
						$classfees+=$row->class_fees;
					$medical_crg+=$CI->common_model->single_value('tblcharge','charge_amount','user_id = '.$row->user_id.' and paid_month = '.$x.' and paid_year = '.$year);
						$x++;
					}
					
					$row->medical_crg=$medical_crg;
					$row->yearly_classfees=$classfees;					
					$row->yearly_fees=(($classfees + $row->charges + $row->session_charge + $row->security_deposit+$row->medical_crg) - $row->concession);
					$row->latefine=0;
					$latepaid=$this->yearlylate_payment($row->user_id,$month,$lastmonth,$year,$class_id,2);
					if(isset($latepaid[0]['latefine']))
					{
						$row->latefine=$latepaid[0]['latefine'];
					}
					$row->yearlydue=($row->yearly_fees + $row->latefine) - $row->paid;
				}				
				
			}
			//echo "<pre>";print_r($data['user']);exit;
			return $data['user'];
		}
		
		
		function export($table)
		{ 
			$fp = fopen('./uploads/report/excel_.xls', "a");
			fwrite($fp, $table);
			fclose($fp);
		}
		function yearlydue_per_user($user_id,$class_id,$year,$month,$lastmonth)
		{
			$CI=& get_instance();
			$data['user']=$this->student_by_id($user_id,$year,$class_id);
			if(count($data['user'])>0)
			{
				foreach($data['user'] as $row)
				{
					$row->name='';
					$row->name=$row->first_name;
					if($row->middle_name!='')
					{
						$row->name.=' '.$row->middle_name;
					}
					$row->name.=' '.$row->last_name;	
					
					$row->session_charge=$this->session_charge($row->user_id,1,$year,$class_id);
					$row->security_deposit=$this->security_deposit($row->user_id,$month,$year,$class_id);
												
					$row->concession=$this->yearly_concession($row->user_id,$month,$lastmonth,$year);
					$row->charges=$this->yearly_charges($row->user_id,$month,$lastmonth,$year);
					$paid=$this->yearly_paid($row->user_id,$month,$lastmonth,$year,$class_id,2);
					$row->paid=0;
					$numrow=count($paid) - 1;
					if(isset($paid[$numrow]['yearly_paid']))
					{
						$row->paid=$paid[$numrow]['yearly_paid'];
					}
					
					$medical_crg=0;
					
					$classfees=0;
					$x=$month;
					while($x<=$lastmonth)
					{
						$classfees+=$row->class_fees;
					$medical_crg+=$CI->common_model->single_value('tblcharge','charge_amount','user_id = '.$row->user_id.' and paid_month = '.$x.' and paid_year = '.$year);
						$x++;
					}
					
					$row->medical_crg=$medical_crg;
					$row->yearly_classfees=$classfees;					
					$row->yearly_fees=(($classfees + $row->charges + $row->session_charge + $row->security_deposit+$row->medical_crg) - $row->concession);
					$row->latefine=0;
					$latepaid=$this->yearlylate_payment($row->user_id,$month,$lastmonth,$year,$class_id,2);
					if(isset($latepaid[0]['latefine']))
					{
						$row->latefine=$latepaid[0]['latefine'];
					}
					$row->yearlydue=($row->yearly_fees + $row->latefine) - $row->paid;
				}				
				
			}
			//echo "<pre>";print_r($data['user']);exit;
			return $data['user'];
		}
		function student_by_id($user_id,$year,$class_id){
			$CI=& get_instance();
			$where='';
			if($user_id!='')
			{
				$where.=' and student.id = '.$user_id;
			}			
			$column=" Select total as class_fees,fees_user_class.user_id,student.registration_no,first_name,middle_name,last_name from fees_user_class";
			$wherecls=" where status= 'active' and fees_user_class.class_id = ".$class_id." and year(fees_user_class.updated_date) = ".$year.$where;
			$innerjoin=' inner join student on fees_user_class.user_id=student.id';
			$innerjoin.=' inner join fees on fees_user_class.class_id=fees.class_id';
			$data['user']=$CI->common_model->sql_string($column.$innerjoin.$wherecls);
			//echo $CI->db->last_query(); echo "<pre>"; print_r($data['user']);exit;
			return $data['user'];
		}
		
		
		
	}
?>