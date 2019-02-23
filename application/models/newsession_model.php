<?php
class newsession_model extends CI_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function update_data_where($data,$table,$whereclause){
		$this->db->where($whereclause);
		$this->db->update($table,$data);	
	}
	
	function max_registration_date()
	{
		$columnvalue='';
		$this -> db -> select('max(year(updated_date)) as updated_date')-> from('fees_user_class');
		$query = $this -> db -> get();
		if($query -> num_rows > 0  )
		 {			 
			foreach($query->result() as $row)
			{
				$columnvalue=$row->updated_date; 				
			}			
		 }				
		return $columnvalue;
	}
	
	function registration_date($user_id,$class_id)
	{
		$columnvalue='';
		$this -> db -> select('updated_date')-> from('fees_user_class')->where('user_id = '.$user_id.' and class_id = '.$class_id);
		$query = $this -> db -> get();
		if($query -> num_rows > 0  )
		 {			 
			foreach($query->result() as $row)
			{
				$columnvalue=$row->updated_date; 				
			}			
		 }				
		return $columnvalue;
	}
	
	function payment_($user_id,$reg_year,$currentyear,$class_id)
	{
		$this -> db -> select('*')-> from('payment');
		$where='user_id = '.$user_id.' and class_id = '.$class_id.' and paid_year between '.$reg_year.' and '.$currentyear;		
		if($where!='')
		{
			$this -> db ->where($where);
		}
		$query = $this -> db -> get();		
		if($query -> num_rows > 0  )
		 {			 
			return $query -> num_rows;
						
		 }				
		return 0;	
	}

	function newYearStart($user_id,$class_id,$currnt_date)
	{	
		$year_payment_status=0;	
		$reg_date=$this->registration_date($user_id,$class_id);
		$reg_year=date("Y",strtotime($reg_date));
		$currentyear=date("Y",strtotime($currnt_date));
	
		if($currentyear == $reg_year+1)
		{
			
		  $payment_stat=$this->payment_($user_id,$reg_year,$currentyear,$class_id);		
		 if($payment_stat!=0)
		 {
			$this -> db -> select('*')-> from('payment');
			$where='user_id = '.$user_id.' and class_id = '.$class_id.' and month_status = "unpaid" and paid_year between '.$reg_year.' and '.$currentyear;		
			if($where!='')
			{
				$this -> db ->where($where);
			}
			$query = $this -> db -> get();			
			if($query -> num_rows > 0)
			{
				return $year_payment_status;   //----------return--------
				
			}else{	
				$update_cls=$class_id+1;
				$where_fees_up='user_id = '.$user_id.' and class_id = '.$update_cls.' and year(updated_date) = '.$currentyear;
				$this -> db -> select('*')-> from('fees_user_class');
				if($where_fees_up!='')
				{
					$this -> db ->where($where_fees_up);
				}
				$query = $this -> db -> get(); 
				if($query -> num_rows == 0)
				{
					$data_up=array(
						'class_id'=>$update_cls,
						'updated_date'=>$currnt_date
					);		
						$this->update_data_where($data_up,'fees_user_class','user_id = '.$user_id);
					
					$data_student=array(
						'class_id'=>$update_cls,
						'promotion_date'=>$currnt_date
					);	
					$this->update_data_where($data_student,'student','id = '.$user_id);
									
					$session_charge=0;
					$session=$this->common_model->selectWhere('sessioncharge','(class_id = '.$update_cls.' OR class_id = 0)');
						if(isset($session[0]->amount))
						{
							if($session[0]->amount!='')
							{										
								$session_charge=$session[0]->amount;
							}
						}
		$sessionexists=$this->common_model->selectWhere('session_charge','user_id = '.$update_cls.' and class_id = '.$update_cls.' and Year(created_date) = '.date("Y",strtotime($currnt_date)) );
					if(count($sessionexists)==0)
					{
						$session_charge_arr = array(
							'class_id'=> $update_cls,
							'session_charge'=>$session_charge,
							'created_date'=>$currnt_date
						);
						$this->common_model->update_data($session_charge_arr,'session_charge','user_id',$user_id);
					}
						//if($insertid!='')
						//{
							$year_payment_status=1;
							return $year_payment_status;    //----------return--------							
						//}
					
				}else{
					
					return $year_payment_status;     //----------return--------
					
				}
			}
		 }
		}
			
		return $year_payment_status;
	}
	
	function insert_data($data,$table){		
		$this->db->insert($table,$data);
		return $this->db->insert_id();		
	}
	
	
	function db_backup($tablename)
	{
		$this -> db -> select('*')-> from($tablename);
		$query = $this -> db -> get();	
			if($query -> num_rows > 0)
			{
				return $result=$query->result();
			}
			
			
	}
	
	
	
	 
}
?>