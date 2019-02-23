<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagination_model extends CI_model {
	
	public function __construct() {
       parent::__construct();
    }
	
	public function count_all_data()
	{	$this->db->select('*');
		return $this->db->get("tbl_student");
	}
	public function getall($limit, $start)
	{
		 $this->db->limit($limit, $start);
		$result = $this->db->get('tbl_student');
		
		return $result->result_array();
	}
	
	public function insert_multiple_image($data)
	{
		$this->db->insert('tbl_student',$data);
	}
}