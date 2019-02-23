<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class reports extends CI_Controller {
	
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
			$this->load->library('image_lib');
			$this->load->helper('email');
			$this->load->model('fees_model');
			$this->load->model('common_model'); 
			$this->load->library('salary_payment_lib');
			$this->load->library('year_month_lib');
			$this->load->library('payment_lib');
			$sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }
			
			
			/*if($this->session->userdata('schoolbolpur_admin'))
			{
				$session_data = $this->session->userdata('schoolbolpur_admin');
				if(isset($session_data[0]))
				{
					$session_data=$session_data[0];
					$this->user_name = $session_data->username;
					$this->user_fullname = $session_data->first_name.' '. $session_data->last_name;
					$this->user_role = $session_data->role_id;
					$this->user_email =$session_data->email;
					$this->user_id = $session_data->id;
				}	
			}
			else
			{
				redirect('authenticate', 'refresh');
			}*/
	}
	
	public function studentdue()
	{
		if($this->user_role!=1)
		{
			$this->load->library('permission_lib');
			$this->permission_lib->permit($this->user_id,$this->user_role);
		}
				
		$data['classlist']=$this->common_model->selectAll('tblclass');
		$data['yearlist']=$this->year_month_lib->yeardropdown();
		$data['monthlist']=$this->year_month_lib->monthdropdown();
		$data['class_id']=1;
		$data['year']=date("Y",strtotime(date("Y-m-d")));
		
		if(isset($_POST['class']))
		{
			$data['class_id']=$_POST['class'];
		}
		
		if(isset($_POST['year']))
		{
			$data['year']=$_POST['year'];
		}
		$due_class=array();
		$due_user=array();		
		$data['user']=$this->payment_lib->yearlydue($data['class_id'],$data['year'],1,12);
		//$data['user_det']=$this->payment_lib->yearlydue_per_user(2,1,2015,1,12);
		//echo "<pre>";print_r($data['user_det']);exit;
		$table= '<table border="1">';
		$table.= '<caption> Payment Due - '.$data['year'].' Class-'.$data['class_id'].'</caption>';
					$table.= '<tr>';
						$table.= '<th>Registration No</th>';
						$table.= '<th>Name </th>';
						$table.= '<th>Total Amount</th>';
						$table.= '<th>Total Paid</th>';
						$table.= '<th>Total Due</th>';
					$table.= '</tr>';
		if(count($data['user'])>0)
		{
			foreach($data['user'] as $row)
			{
				$table.= '<tr>';
				$table.='<td>'.$row->registration_no.'</td>';
				$table.='<td>'.$row->name.'</td>';
				$table.='<td>'.number_format(($row->yearly_fees),2).'</td>';
				$table.='<td>'.number_format(($row->paid),2).'</td>';
				$table.='<td>'.number_format(($row->yearlydue),2).'</td>';								
				$table.= '</tr>';					
			}
		}		
		$table.= '</table>';
		if(file_exists('./uploads/report/student_due.xls'))
		{
			unlink('./uploads/report/student_due.xls');
		}	
			$fp = fopen('./uploads/report/student_due.xls', "a");
			fwrite($fp, $table);
			fclose($fp);
		
		$this->load->view('admin/template/admin_header');
		$this->load->view('admin/template/admin_leftmenu');
		$this->load->view('admin/report_view',$data);
		$this->load->view('admin/template/admin_footer');		
	}
	
	public function salarydue()
	{
		if($this->user_role!=1)
		{
			$this->load->library('permission_lib');
			$this->permission_lib->permit($this->user_id,$this->user_role);
		}
				
		$data['classlist']=$this->common_model->selectAll('tblclass');
		$data['yearlist']=$this->year_month_lib->yeardropdown();
		$data['monthlist']=$this->year_month_lib->monthdropdown();
		$data['class_id']=0;
		$data['year']=date("Y",strtotime(date("Y-m-d")));
		
		if(isset($_POST['class']))
		{
			$data['class_id']=$_POST['class'];
		}
		
		if(isset($_POST['year']))
		{
			$data['year']=$_POST['year'];
		}
		$due_class=array();
		$due_user=array();
		
		$data['user']=$this->salary_payment_lib->yearlydue('',$data['year'],1,12);
		$table= '<table border="1">';
		$table.= '<caption> Salary Due - '.$data['year'].'</caption>';
					$table.= '<tr>';
						$table.= '<th>Registration No</th>';
						$table.= '<th>Name </th>';
						$table.= '<th>Total Amount</th>';
						$table.= '<th>Total Paid</th>';
						$table.= '<th>Total Due</th>';
					$table.= '</tr>';
		if(count($data['user'])>0)
		{
			foreach($data['user'] as $row)
			{
				$table.= '<tr>';
				$table.='<td>'.$row->registration_no.'</td>';
				$table.='<td>'.$row->name.'</td>';
				$table.='<td>'.number_format(($row->yearly_fees),2).'</td>';
				$table.='<td>'.number_format(($row->paid),2).'</td>';
				$table.='<td>'.number_format(($row->yearlydue),2).'</td>';								
				$table.= '</tr>';					
			}
		}		
		$table.= '</table>';
		if(file_exists('./uploads/report/salary_due.xls'))
		{
			unlink('./uploads/report/salary_due.xls');
		}	
			$fp = fopen('./uploads/report/salary_due.xls', "a");
			fwrite($fp, $table);
			fclose($fp);
		
		$this->load->view('admin/template/admin_header');
		$this->load->view('admin/template/admin_leftmenu');
		$this->load->view('admin/report_view',$data);
		$this->load->view('admin/template/admin_footer');		
	}
	
	
	
	function credit_debit()
	{
		if($this->user_role!=1)
		{
			$this->load->library('permission_lib');
			$this->permission_lib->permit($this->user_id,$this->user_role);
		}
				
		if(isset($_POST['year']))
		{
			$data['year']=$_POST['year'];
		}else{
			$data['year']=(int)(date('Y-m-d'));
		}
		
		if(isset($_POST['toyear']))
		{
			$data['toyear']=$_POST['toyear'];
		}else{
			$data['toyear']=(int)(date('Y',strtotime(date("Y-m-d"))));
		}
		
		if(isset($_POST['month']))
		{
			$data['month']=$_POST['month'];
		}else{
			$data['month']=(int)(date('m',strtotime(date("Y-m-d"))));
		}
		
		if(isset($_POST['tomonth']))
		{
			$data['tomonth']=$_POST['tomonth'];
		}else{
			 $data['tomonth']=(int)(date('m',strtotime(date("Y-m-d"))));
		}
		
		$data['yearlist']=$this->year_month_lib->yeardropdown();
		$data['monthlist']=$this->year_month_lib->monthdropdown();
		$where='year(created_date) between '.$data['year'].' and '.$data['toyear'];
		$where.=' and month(created_date) between '.$data['month'].' and '.$data['tomonth'].' order by month(created_date) DESC';
		$data['credit_debit']=$this->common_model->selectWhere('credit_debit',$where);
		
		$data['totalcredit_debit']=$this->common_model->selectColmnWhere('credit_debit','sum(credit) as totcredit,sum(debit) as totdebit,sum(profit) as totprofit',$where);
		
		$table= '<table border="1">';
					$table.= '<tr>';
					$table.= '<th>Credit</th>';
					$table.= '<th>Debit</th>';
					$table.= '<th>Profit</th>';
					$table.= '<th>Payment For The Month</th>';
					$table.= '<th>Collected Month</th>';						
					$table.= '</tr>';
		if(count($data['credit_debit'])>0)
		{
			foreach($data['credit_debit'] as $row)
			{
				$month=date("m",strtotime($row->created_date));
				
				$table.= '<tr>';
				$table.='<td>'.number_format(($row->credit),2).'</td>';
				$table.='<td>'.number_format(($row->debit),2).'</td>';
				$table.='<td>'.number_format(($row->profit),2).'</td>';	
				$table.='<td>'.date('F', mktime(0, 0, 0, $row->paid_month, 1)).'</td>';	
				$table.='<td>'.date('F', mktime(0, 0, 0, $month, 1)).'</td>';
				$table.= '</tr>';					
			}
		}
		
		if(isset($data['totalcredit_debit'][0]))
		{
			$table.= '<tr>';
			$table.= '<th>Total Credit</th>';
			$table.= '<th>Total Debit</th>';
			$table.= '<th>Total Profit</th>';
		$table.= '</tr>';
			
				$table.= '<tr>';
				$table.='<td>'.number_format(($data['totalcredit_debit'][0]->totcredit),2).'</td>';
				$table.='<td>'.number_format(($data['totalcredit_debit'][0]->totdebit),2).'</td>';
				$table.='<td>'.number_format(($data['totalcredit_debit'][0]->totprofit),2).'</td>';								
				$table.= '</tr>';
				
		}
		
		$table.= '</table>';
		if(file_exists('./uploads/report/credit_debit.xls'))
		{
			unlink('./uploads/report/credit_debit.xls');
		}	
		$fp = fopen('./uploads/report/credit_debit.xls', "a");
		fwrite($fp, $table);
		fclose($fp);
		
		$this->load->view('admin/template/admin_header');
		$this->load->view('admin/template/admin_leftmenu');
		$this->load->view('admin/credit_debit_report_view',$data);
		$this->load->view('admin/template/admin_footer');
	}
	
	function invoice_generate()
	{
		$invoice=$this->uri->segment(3); 
		if($invoice!='')
		{
			$data=$this->invoicedata($invoice);
		 $html=$this->load->view('admin/voucher',$data);
		
		header("Content-type: application/force-download;charset:UTF-8");
		header("Content-Disposition: attachment; filename=".ucwords('invoice').".doc");
		print "\n"; // Add a line, unless excel error..
		echo $html;
		
			
		}else{
			$data['path']= $this->session->userdata('inv_path');
			redirect($data['path']);
		}
	}
	
	function invoice_print()
	{
		$invoice=$this->uri->segment(3); 
		if($invoice!='')
		{
			$data=$this->invoicedata($invoice);
		 $html=$this->load->view('admin/voucher',$data);
		
		
		}else{
			$data['path']= $this->session->userdata('inv_path');
			redirect($data['path']);
		}
	}
	
	function invoicedata($invoice)
	{
		$roleid='';	
			$data['invoice_data']=$this->common_model->selectWhere('payment','invoice_no = '.$invoice);
			foreach($data['invoice_data'] as $row)
			{
				
				$roleid=$row->role_id;
				if($row->role_id==2)
				{					
					$row->name='';
					$user=$this->payment_lib->studentlist($row->user_id,$row->paid_month,$row->paid_year,$row->class_id);
					foreach($user as $rowuser)
					{					
						$row->name=$rowuser->first_name;
						if($rowuser->middle_name!='')
						{
							$row->name.=' '.$rowuser->middle_name;
						}
						$row->name.=' '.$rowuser->last_name;
						}
					$row->registration_no=$rowuser->registration_no;
					$row->classname='';
					if($row->class_id!='' || $row->class_id!=0)
					{
						$row->classname=$this->common_model->single_value('tblclass','name','id = '.$row->class_id);
					}
					$row->studentfees=$rowuser->class_fees;	
					$row->session_charge=$this->payment_lib->session_charge($row->user_id,$row->paid_month,$row->paid_year,$row->class_id);				
					$row->security_deposit=$this->payment_lib->security_deposit($row->user_id,$row->paid_month,$row->paid_year,$row->class_id);				
					$paid_permonth=$this->payment_lib->paid_permonth($row->user_id,$row->paid_month,$row->paid_year,$row->class_id,$row->role_id);
					foreach($paid_permonth as $rowy)
					{
						$row->paid=$rowy->paid;					
					}				
					$row->totconcession=$this->payment_lib->concession_per_user($row->user_id,$row->paid_month,$row->paid_year,'');
					$row->totspecialfees=$this->payment_lib->charge_per_user($row->user_id,$row->paid_month,$row->paid_year,'');
					$row->latefine=0;
				$latepaid=$this->payment_lib->late_payment($row->user_id,$row->paid_month,$row->paid_year,$row->class_id,2);
				if(isset($latepaid[0]->latefine))
				{
					$row->latefine=$latepaid[0]->latefine;
				}
				
			$row->medical_crg_paid='';
		$row->medical_crg=$this->common_model->single_value('tblcharge','charge_amount','user_id = '.$row->user_id.' and paid_month = '.$row->paid_month.' and paid_year = '.$row->paid_year); 
		$row->medical_crg_name=$this->common_model->single_value('tblcharge','charge_name','user_id = '.$row->user_id.' and paid_month = '.$row->paid_month.' and paid_year = '.$row->paid_year); 
				if($row->medical_crg=='')
				{
					$row->medical_crg=0;	
					$row->medical_crg_paid='';
				}else{
					$row->medical_crg_paid='paid';
				}
					
					
				 $totfees=( $row->studentfees + $row->totspecialfees + $row->session_charge + $row->security_deposit +$row->medical_crg + $row->latefine) - $row->totconcession ;
					$row->totfees=$totfees;
					$row->due=$totfees-$row->paid;
					$row->nowdue=number_format(($row->due),2);
					$row->concession_arr=array();
					$row->specialfees_arr=array();
					$concession_arr=$this->payment_lib->concession_per_user($row->user_id,$row->paid_month,$row->paid_year,'data');
					
					if(count($concession_arr)>0)
					{
						$row->concession_arr=$concession_arr;
					}
					$specialfees_arr=$this->payment_lib->charge_per_user($row->user_id,$row->paid_month,$row->paid_year,'data');
					
					if(count($specialfees_arr)>0)
					{
						$row->specialfees_arr=$specialfees_arr;
					}
										
				   }				
			}
									
			if($roleid==3)
			{
				foreach($data['invoice_data'] as $row)
				{
					$row->salaryamount=0;
					$salary=$this->salary_payment_lib->studentlist($row->user_id,$row->paid_month,$row->paid_year);
					if(isset($salary[0]->salary))
					{
						$row->salaryamount=$salary[0]->salary;
						$row->name=$salary[0]->first_name;
						if($salary[0]->middle_name!='')
						{
							$row->name.=' '.$salary[0]->middle_name;
						}
						$row->name.=' '.$salary[0]->last_name;
						
					}
					$paid_permonth=$this->salary_payment_lib->paid_permonth($row->user_id,$row->paid_month,$row->paid_year,$row->role_id);
					foreach($paid_permonth as $rowy)
					{
						$row->paid=$rowy->paid;					
					}	
					
					$row->totconcession=$this->salary_payment_lib->concession_per_user($row->user_id,$row->paid_month,$row->paid_year,'');
					$row->totspecialfees=$this->salary_payment_lib->charge_per_user($row->user_id,$row->paid_month,$row->paid_year,'');
					
					$totfees=($row->salaryamount + $row->totspecialfees ) - $row->totconcession ;
					
					$row->totfees=$totfees;
					$row->due=$totfees-$row->paid;
					$row->nowdue=number_format(($row->due),2);
					$row->concession_arr=array();
					$row->specialfees_arr=array();
					$concession_arr=$this->salary_payment_lib->concession_per_user($row->user_id,$row->paid_month,$row->paid_year,'data');
					if(count($concession_arr)>0)
					{
						$row->concession_arr=$concession_arr;
					}
					$specialfees_arr=$this->salary_payment_lib->charge_per_user($row->user_id,$row->paid_month,$row->paid_year,'data');
					if(count($specialfees_arr)>0)
					{
						$row->specialfees_arr=$specialfees_arr;
					}
				}				
			}			
			return $data;
	}
	
	
	
	
	
	
	
}
?>