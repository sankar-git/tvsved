<?php
   
   //print_r($session_data); exit;
    function menuAccess($id,$r_id)
	{
		   // $CI=& get_instance();						
			//$access=$CI->type_model->permit_page_access_by_user_id($id,$r_id);	
			//return $access;		
	}
	function p($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
    }
	function dd($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die();
	}
	function round_two_digit($str){
		return number_format((float)$str, 2, '.', '');
	}
	if (!function_exists('fun_global')) {
      function fun_global($params = null) {
        $ci = &get_instance();
        $ci->load->model('Master_model');
        $result = $ci->Master_model->get_assigned_menu($params);
        return $result;
    }

  }
  function get_student_marks($student_id,$semester_id,$course_id,$batch_id=''){
	  $ci = &get_instance();
        $ci->load->model('gradechart_model');
		$result = $ci->gradechart_model->get_student_marks($student_id,$semester_id,$course_id,$batch_id);
		//echo $ci->db->last_query();
        return $result; 
  }
function get_teacher_name($userid){
    $ci = &get_instance();
    $ci->db->select('group_concat(first_name) as name',true);
    $ci->db->from('users');
    $ci->db->where_in('id',explode(",",$userid));
    return $ci->db->get()->result_array();
}
  function get_course_name($degree_id,$course_id){
      $ci = &get_instance();
        if($degree_id == 1){
            $course_arr = explode("|",$course_id);
            $courseArr = explode("-",$course_arr[1]);
            $courseid = $courseArr;
        }else{
            $courseid = $course_id;
        }
      $ci->db->select('c.id as courseid, group_concat(distinct c.course_title) as course_title,
      group_concat(distinct c.course_code) as course_code,c.theory_credit,c.practicle_credit,course_subject_id,
      csg.course_subject_name,csg.course_subject_title,csg.id as coure_group_id',true);
      $ci->db->from('courses as c');
      $ci->db->join('course_subject_groups csg','csg.id=c.course_subject_id','LEFT');
      $ci->db->where_in('c.id',$courseid);
      if($degree_id == 1)
          $ci->db->group_by('course_subject_id');
      return $ci->db->get()->result_array();
  }
  function fun_global_admin($userType='')
  { 
	    $ci = &get_instance();
        $ci->load->model('Master_model');
        $result = $ci->Master_model->get_admin_menu($userType);
        return $result; 
  }
function fun_left_submenu($id)
{
	    $ci = &get_instance();
        $ci->load->model('Master_model');
        $result = $ci->Master_model->get_admin_submenu_of_mainmenu($id);
        return $result; 
}
function aciveMenu($url)
{
	return $url;
}
function insert_sms_log($data){
	$ci = &get_instance();
	$sessdata= $ci->session->userdata('sms');
	if(count($sessdata)>0)
		$data['user_id']  = $sessdata[0]->id;
	$ci->db->insert('sms_delivery',$data);
}
function send_sms($message,$phone)
    {
		$message = urlencode($message); 
		$msgSentUrl = "http://bulksms.justclicksky.com/sendSMS?username=vedang&message=$message&sendername=YKUMBH&smstype=TRANS&numbers=$phone&apikey=78351e33-ba59-4c67-9a13-7b6d35837e49";
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $msgSentUrl,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		$responseArr = json_decode($response);
		//print_r($responseArr);exit;
		///echo $responseArr['responseCode'];
		//echo $responseArr['msgid'];exit;
		curl_close($curl);
		if(empty($response))
			$responce = $err;
		$data['phone'] = $phone;
		$data['message'] = $message;
		$data['responseCode'] = $responseArr[0]->responseCode;
		$data['msgid'] = $responseArr[1]->msgid;
		$data['response'] = $response;
		insert_sms_log($data);

        return true;
    }
?>