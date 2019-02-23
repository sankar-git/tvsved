<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class salary_payment_lib{
		
		function paid_permonth($userid,$month,$year,$role_id)
		{
			$CI=& get_instance();
			$where='paid_year = '.$year.' and paid_month = '.$month.' and user_id = '.$userid.' and role_id = '.$role_id;
			$paid=$CI->common_model->selectColmnWhere('payment','min(due) as due,sum(paid) as paid',$where);	
			return $paid;
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
						
				$paid_permonth=$this->paid_permonth($userid,$month,$year,$role_id);
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
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.')' ;
				$concession=$CI->common_model->selectColmnWhere('concession_teacher','sum(amount) as amount',$whereconcession);						
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
				$whereconcession.=' and ( YEAR(end_date) = '.$year.' OR YEAR(end_date) > '.$year.') and concession_status = "teacher"' ;
				$data_st=$CI->common_model->selectWhere('concession',$whereconcession);									
				if(count($data_st)>0)
				{
					foreach($data_st as $rowst)
					{
						$yearly_paid+=$rowst->concession_amount;
						
						}					
				}
				
				
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
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.')' ;
				$concession=$CI->common_model->selectColmnWhere('specialfees_teacher','sum(amount) as amount',$whereconcession);
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
				$whereconcession.=' and ( YEAR(end_date) = '.$year.' OR YEAR(end_date) > '.$year.') and sp_status = "teacher"' ;
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
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.')' ;
				$data_conce=$CI->common_model->selectWhere('concession_teacher',$whereconcession);									
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
				$whereconcession.=' and ( YEAR(end_date) = '.$year.' OR YEAR(end_date) > '.$year.') and concession_status = "teacher"' ;
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
					
				}
				
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
				$whereconcession.=' and ( YEAR(effective_month) = '.$year.' OR YEAR(effective_month) < '.$year.')' ;
				$data_conce=$CI->common_model->selectWhere('specialfees_teacher',$whereconcession);									
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
				$whereconcession.=' and ( YEAR(end_date) = '.$year.' OR YEAR(end_date) > '.$year.') and sp_status = "teacher"' ;
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
		
		function studentlist($userid,$month,$year)
		{
			$CI=& get_instance();
			$where='';
			if($userid!='')
			{
				$where.=' and user_id = '.$userid;
			}			
			$column=" Select salary_teacher.salary,salary_teacher.user_id,first_name,middle_name,last_name from salary_teacher";
			$wherecls=" where  status= 'active' and year(salary_teacher.updated_date) = ".$year.$where;
			$innerjoin=' inner join teacher on salary_teacher.user_id=teacher.id';
			$data['user']=$CI->common_model->sql_string($column.$innerjoin.$wherecls);
			return $data['user'];
		}
		
		function paymentlist($userid,$month,$lastmonth,$year)
		{
			$CI=& get_instance();
			$role_id=3;
			$data['user']=$this->studentlist($userid,$month,$year);
			
			$table= '<table border="1">';
		$table.= '<caption>Salary List-'.$year.'</caption>';
					$table.= '<tr>';
						$table.= '<th>Registration No</th>';						
						$table.= '<th>Name</th>';
						$table.= '<th>Class Fees</th>';
						$table.= '<th>Concession</th>';
						$table.= '<th>Charge</th>';
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
				$row->registration_no=$row->user_id;
				$row->class_fees=$row->salary;			
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
				$totfees=0;
			
				$paid_permonth=$this->paid_permonth($row->user_id,$month,$year,$role_id);
				foreach($paid_permonth as $rowy)
				{
					$row->paid=$rowy->paid;					
				}				
				$row->concession=$this->concession_per_user($row->user_id,$month,$year,'');
				$row->specialfees=$this->charge_per_user($row->user_id,$month,$year,'');
				$totfees=( $row->salary + $row->specialfees ) - $row->concession ;
				$row->totfees=$totfees;
				$row->due=$totfees-$row->paid;
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
				$table.= '<th>'.$totfees.'</th>';
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
		
	//	echo "<pre>"; print_r($data['user']);exit;	
			return $data['user'];
					
		}
		
		function user_paymentlist($name,$userid,$month,$lastmonth,$year,$class_id,$role_id,$class_fees)
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
				$paylist[$count]['totfees']=0;
				$paylist[$count]['payable']=0;
				
				$salary=$this->studentlist($userid,$month,$year);
				if(isset($salary[0]->salary))
				{
					$class_fees=$salary[0]->salary;
				}
				
				$concession=$this->concession_per_user($userid,$month,$year,'');
				 $specialfees=$this->charge_per_user($userid,$month,$year,'');
				 $totfees=($class_fees + $specialfees) - $concession;
				$paid=0;
				$paylist[$count]['session_charge']=0;
				$paylist[$count]['security_deposit']=0;
				$paylist[$count]['concession']=$concession;
				$paylist[$count]['specialfees']=$specialfees;
				$paylist[$count]['totfees']=$totfees;
				$paylist[$count]['payable']=$totfees - $paid;
				$paylist[$count]['btnpay']='unpaid'	;		
				
				$where='paid_year = '.$year.' and paid_month = '.$month.' and user_id = '.$userid.' and role_id = '.$role_id;
				$payment=$CI->common_model->selectWhere('payment',$where);
				$rowcount=$count;
				$pay_count=1;					
				foreach($payment as $row)
				{
					
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
					$paylist[$rowcount]['payable']=$totfees-$paid;					
					
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
		$table.= '<caption>Salary-'.$name.' '.$year.'</caption>';
					$table.= '<tr>';
						$table.= '<th>Month </th>';						
						$table.= '<th>Year</th>';
						$table.= '<th>Total</th>';
						$table.= '<th>Concession</th>';
						$table.= '<th>Charge</th>';
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
				$table.= '<td>'.number_format(($concession),2).'</td>';
				$table.= '<td>'.number_format(($specialfees),2).'</td>';
				$table.= '<td>'.$totfees.'</td>';
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
			return $paylist;					
		}
		
				
		function yearlydue($class_id,$year,$month,$lastmonth)
		{
			$CI=& get_instance();
			
			$data['user']=$this->studentlist('',$month,$year);
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
					$row->registration_no=$row->user_id;
					$row->concession=$this->yearly_concession($row->user_id,$month,$lastmonth,$year);
					$row->charges=$this->yearly_charges($row->user_id,$month,$lastmonth,$year);
					$paid=$this->yearly_paid($row->user_id,$month,$lastmonth,$year,'',3);
					$row->paid=0;
					$numrow=count($paid) - 1;
					if(isset($paid[$numrow]['yearly_paid']))
					{
						$row->paid=$paid[$numrow]['yearly_paid'];
					}
					
					$classfees=0;
					$x=$month;
					while($x<=$lastmonth)
					{
						$classfees+=$row->salary;
						$x++;
					}
					$row->yearly_classfees=$classfees;
					
					$row->yearly_fees=(($classfees + $row->charges) - $row->concession);
					$row->yearlydue=$row->yearly_fees - $row->paid;

				}
				
				
			}
			//echo "<pre>"; print_r($data['user']);exit;
			
			return $data['user'];
		}
		
		function concession($userid,$month,$year)
		{
			$CI=& get_instance();
			$whereconcession='';
			if($month!='' && $year!='')
			{
			$whereconcession='user_id = '.$userid.' and (Month(effective_month) = '.$month.' OR Month(effective_month) > '.$month.')';
				$whereconcession.=' and (Month(endmonth) = '.$month.' OR Month(endmonth) < '.$month.')';		
			$whereconcession.=' and Year(effective_month) = '.$year.' order by con_id DESC' ;
			}
		$data_conce=$CI->common_model->selectWhere('concession_teacher',$whereconcession);					
		//echo $CI->db->last_query();
			return $data_conce;	
		}
		
		function special($userid,$month,$year)
		{
			$CI=& get_instance();
			$where_special='';
			if($month!='' && $year!='')
			{
				$where_special='user_id = '.$userid.' and (Month(effective_month) = '.$month.' OR Month(effective_month) > '.$month.')';
				$where_special.=' and (Month(endmonth) = '.$month.' OR Month(endmonth) < '.$month.')';		
				$where_special.=' and Year(effective_month) = '.$year.' order by special_id DESC' ;
			}
		$data_spe=$CI->common_model->selectWhere('specialfees_teacher',$where_special);
		return $data_spe;
					
		}
		
		
	}
?>