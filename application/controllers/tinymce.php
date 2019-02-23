<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tinymce extends CI_Controller {
	
	 
	 public function __construct()
     {
		 	parent::__construct();
			$this->load->library('session');
			$this->load->library('encrypt');
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->library('image_lib');
			$this->load->helper('directory');
	}
	
	function int_divide($x, $y) {
		return ($x - ($x % $y)) / $y;
	}
	public function index()
	{
		$path = "./uploads/post_image/";
		$data['message'] = $this->session->flashdata('message');
		$map_files = directory_map($path, FALSE, TRUE);
		$number_of_image_per_row = 10;
		$number_of_row = $this->int_divide(count($map_files),$number_of_image_per_row);
		if(count($map_files)%$number_of_image_per_row>0)
			$number_of_row=$number_of_row+1;
		
		$image_row_list = array();
		for($count=0; $count<$number_of_row;$count++)
		{
			$image_list =array();
			$start_index = $count*$number_of_image_per_row;
			$end_index = $start_index + $number_of_image_per_row;
			if($end_index> count($map_files))
				$end_index= count($map_files);
				
			for($image_count = $start_index;$image_count< $end_index; $image_count++)
			{
				$map_file = $map_files[$image_count];
					$image_list[] = array(
						"file_name"=> "",
						"file_path" => base_url()."uploads/post_image/".$map_file
					);
			}
			
			$image_row_list[$count] = $image_list; 
		}
		
		$data['image_row_list'] = $image_row_list;
		$this->load->view('tinymce/imgmanager',$data);
	}
	
	public function upload_image()
	{
		$path = "./uploads/post_image";
		if(!is_dir($path)) 
		{
		  	mkdir($path,0755,TRUE);
		} 
		
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		$field_name = "product_file";
		$photo_size_info = array();	
		if($this->upload->do_upload($field_name)){
			$this->session->set_flashdata('message', 'uploaded successfully.');
			redirect('tinymce/index','refresh');
		}
		else{
			$this->session->set_flashdata('message', 'failed to upload.');
			redirect('tinymce/index','refresh');
		}
	}
	
}
?>