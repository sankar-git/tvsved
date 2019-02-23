<?php
class fees_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	
	//------------------------------------------------------------For all  pages----------------------------------------------
	
	function blockUnblock($data,$id,$column,$table){
		
		$this -> db -> where($column,$id );
		$this->db->update($table,$data);
		$str=$this->db->last_query();
	}
	
	function truncate_table($table){
		$sql="delete from ".$table;
		$query = $this->db->query($sql);
	}
	
	function delete_model($id,$table,$column){
		$this->db->where($column,$id);
		$this->db->delete($table);
	}
	
	function delete_other($table,$column,$columnvalu,$column1,$columnvalu1){
		$this->db->where($column,$columnvalu);
		$this->db->where($column1,$columnvalu1);
		$this->db->delete($table);
	}
	
	function update_data($id,$data,$table,$columnID){
	$this->db->where($columnID,$id);
	$this->db->update($table,$data);	
	}
	
	function insert_data($data,$table){
		
		$this->db->insert($table,$data);
	}
	//---------------------------------------------------------------------------------------------------------------------------------
    
	function select_all($table,$columnname1,$columnvalue1,$columnname,$columnvalue,$columnname2,$columnvalue2){
		if($columnname1=='' && $columnvalue1=='' && $columnname=='' && $columnvalue=='' && $columnname2=='' && $columnvalue2=='')
		{
			$this->db->select('*');
			$this->db->from($table);	
		}else if($columnname1!='' && $columnvalue1!='' && $columnname=='' && $columnvalue=='' && $columnname2=='' && $columnvalue2=='')
		{
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($columnname1,$columnvalue1);
		}else if($columnname1!='' && $columnvalue1!='' && $columnname!='' && $columnvalue!='' && $columnname2=='' && $columnvalue2=='')
		{
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($columnname1,$columnvalue1);
			$this->db->where($columnname,$columnvalue);
		}
		
		else{
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($columnname1,$columnvalue1);
			$this->db->where($columnname,$columnvalue);
			$this->db->where($columnname2,$columnvalue2);
		}
		$query=$this->db->get();
		$str=$this->db->last_query();
									//echo $str; echo "<pre>"; print_r($query->result());
		$list=array();
			if($query->num_rows>0)
			{
				return $query->result();
			}
			else{
				return $list;
			}
	}
	
	public function select_join($table1,$table2,$table1col,$table2col,$wherecol,$whereColValu,$whereString,$whereString1)
	{
		$this->db->select('*');
		$this->db->from($table1);
		if($table2!='' && $table1col!='' && $table2col!=''){
			$this->db->join($table2,$table1.".".$table1col."=".$table2.".".$table2col);
		}
		if($wherecol!='' && $whereColValu!='' ){
			$this->db->where($wherecol,$whereColValu);
		}
		if($whereString!=''){
			$this->db->where($whereString);
		}
		if($whereString1!=''){
			$this->db->where($whereString1);
		}
		$query=$this->db->get();
		$plan_array=array();
		if($query->num_rows > 0)
		{
			foreach($query->result() as $row)
			{
				$plan_array=$query->result();
			}
		}
		return $plan_array;
	}
	
	function select_student($table,$columnname1,$columnvalue1,$columnname,$columnvalue,$reg_month_name2,$reg_month_value2,$columnname3,$columnvalue3){
		
			$this->db->select('*')->from($table);
			//$this->db->from($table);
			$this->db->where($columnname1,$columnvalue1);
			$this->db->where($columnname,$columnvalue);
			$this->db->where($reg_month_name2.'<='.$reg_month_value2);
			$this->db->where($columnname3,$columnvalue3);
		
		$query=$this->db->get();
		$str=$this->db->last_query();
									
		$list=array();
			if($query->num_rows>0)
			{
				return $query->result();
			}
			else{
				return $list;
			}
	}
	/*function due_rupees($table,$id,$monthvalue,$yearvalue){
		$this->db->select('*')->from($table);
			//$this->db->from($table);
			//$this->db->where('user_id',$id);
			//$this->db->where('MONTH(due_date)'.'<='.$monthvalue);
			//$this->db->where('YEAR(due_date)'.'<='.$yearvalue);
		$query=$this->db->get();
		$str=$this->db->last_query();
									//echo $this->db->last_query(); //echo $str; echo "<pre>"; print_r($query->result());
		$list=array();
			if($query->num_rows>0)
			{
				return $query->result();
			}
			else{
				return $list;
			}
			
			
			
	}*/
	
	
}
?>