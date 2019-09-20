<?php
Class Result_model extends CI_Model
{	
	
	function get_student_assigned_subjects($stuId)
	{
		$this->db->select('c.*');
		$this->db->from('courses c');
		$this->db->join('student_assigned_courses sac','sac.course_id = c.id','INNER');
		 $this->db->where('sac.student_id',$stuId);
		 $this->db->order_by("sac.student_id", "asc");
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_student_marks_by_id($student_id,$semester_id='',$exam_type='',$publish_marks='')
	{
		$this->db->select('discipline_id,program_id,degree_id,campus_id,batch_id,semester_id,r.course_id,r.theory_internal1,r.theory_internal2,r.theory_internal3,r.theory_internal,r.theory_paper1,
		                   r.theory_paper2,r.theory_paper3,r.theory_paper4,r.sum_internal_practical,r.practical_internal,r.theory_external1,r.theory_external2,r.theory_external3,r.theory_external4,r.practical_external,
						   r.marks_sum,r.external_sum,assignment_mark,student_id,ncc_status,r.exam_type');
		$this->db->from('students_ug_marks as r');
		$this->db->where('r.student_id',$student_id);
		if(!empty($semester_id))
			$this->db->where('r.semester_id',$semester_id);
		if(!empty($exam_type))
			$this->db->where('r.exam_type',$exam_type);
		if(!empty($publish_marks))
			$this->db->where('r.publish_marks',$publish_marks);
		//elseif(isset($_POST['exam_type']))
			//$this->db->where('r.exam_type',$_POST['exam_type']);
		
		$this->db->order_by('student_id,exam_type');
		$resultArr=$this->db->get()->result_array();echo $this->db->last_query();echo "<br/>";
		$final_array=array();
		foreach($resultArr as $key=>$result_val){
			if($result_val['program_id'] == 1 && $result_val['degree_id'] == 1){
				$course_arr = explode("|",$result_val['course_id']);
				$courseArr = explode("-",$course_arr[1]);
				$courseid = $courseArr;
			}else{
				$courseid = $result_val['course_id'];
			}
			$this->db->select('c.id as courseid,
						 group_concat(distinct c.course_title) as course_title,group_concat(distinct c.course_code) as course_code,c.theory_credit,c.practicle_credit,cp.campus_code,cp.campus_name,
						   b.batch_name,s.semester_name,d.degree_name,csg.course_subject_name,csg.course_subject_title,csg.id as coure_group_id,dis.discipline_name,dis.discipline_code,u.first_name,u.last_name,u.user_unique_id,student_id',true);
			$this->db->from('courses as c','c.id=r.course_id');
			$this->db->join('student_assigned_courses as sa',"sa.course_id=c.id");
			$this->db->join('disciplines as dis','dis.id=c.discipline_id');
			$this->db->join('users u','u.id=sa.student_id');
			$this->db->join('campuses cp','cp.id=sa.campus_id');
			$this->db->join('batches b','b.id=sa.batch_id');
			$this->db->join('semesters s','s.id=c.semester_id');
			$this->db->join('course_subject_groups csg','csg.id=c.course_subject_id','LEFT');
			$this->db->join('degrees d','d.id=c.degree_id');
			$this->db->where_in('sa.course_id',$courseid);
			$this->db->where('sa.student_id',$result_val['student_id']);
			$this->db->where(array('sa.campus_id'=>$result_val['campus_id'],'sa.program_id'=>$result_val['program_id'],'sa.degree_id'=>$result_val['degree_id'],'sa.batch_id'=>$result_val['batch_id'],'sa.semester_id'=>$result_val['semester_id']));
			if($result_val['program_id'] == 1 && $result_val['degree_id'] == 1)
				$this->db->group_by('c.course_subject_id');
			$courseresult=$this->db->get()->result_array();
			$final_array[] = (object) array_merge($courseresult[0], $result_val);		
		}
		return $final_array;
	}
	
	function get_student_marks_by_id_change($student_id,$semester_id)
	{
		$this->db->select('um.theory_internal,um.practical_internal,um.theory_external,um.practical_external,
		                   um.marks_sum,um.student_id,um.course_id,c.id,c.course_code,c.course_title,
						   c.theory_credit,c.practicle_credit,psm.total_marks,psm.total_credit_points,
						   psm.total_credits,psm.total_grade_point_average'); 
		$this->db->from('students_ug_marks um');
		$this->db->join('courses as c','c.id=um.course_id','INNER');
		$this->db->join('previous_semester_marks as psm','psm.student_id=um.student_id','LEFT');
		$this->db->where('um.student_id',$student_id);
		$this->db->where('psm.semester_id <=',$semester_id); 
		$this->db->order_by("um.course_id", "asc");
        $result	= $this->db->get()->result_array();
		return $result;
	}
	function get_previous_semester_data($student_id,$semester_id)
	{
		$this->db->select('psm.total_marks,psm.total_marks,psm.total_credit_points,
						   psm.total_credits,psm.total_grade_point_average,psm.semester_id'); 
		$this->db->from('previous_semester_marks as psm');
		
		$this->db->where('psm.student_id',$student_id);
		$this->db->where('psm.semester_id !=',$semester_id); 
		$this->db->order_by("psm.student_id", "asc");
        $result	= $this->db->get()->result();
		//echo $this->db->last_query();exit;
		return $result;
	}
	function get_student_all_course_data($student_id)
	{
		$this->db->select('um.course_id,c.course_code,c.course_title,c.theory_credit,
		                   c.practicle_credit,um.marks_sum,um.theory_internal,um.practical_internal,
						   um.theory_external,um.practical_external,u.id,u.user_unique_id,
						   u.first_name,u.last_name'); 
		$this->db->from('students_ug_marks um');
		$this->db->join('users as u','u.id=um.student_id','INNER');
		$this->db->join('courses as c','c.id=um.course_id','INNER');
		$this->db->where('um.student_id',$student_id);
		$this->db->order_by("um.course_id", "asc");
        $result	= $this->db->get()->result();
		return $result;
	}
	
	function get_result_data($student_id)
	{
		$this->db->select('u.*,umap.user_id,b.batch_name,c.campus_name,c.campus_code,d.degree_name,d.degree_code,umap.parent_name,umap.mother_name');
		$this->db->from('users u');
		$this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
		$this->db->join('batches b','b.id = umap.batch_id','INNER');
		$this->db->join('campuses c','c.id = umap.campus_id','left');
		$this->db->join('degrees d','d.id = umap.degree_id','left');
		$this->db->where_in('u.id',$student_id);
        $result	= $this->db->get()->result();//echo $this->db->last_query(); die;
		return $result;
	}
	function get_student_result_data($student_id)
	{
		$this->db->select('u.*,umap.user_id,b.batch_name,c.campus_name,c.campus_code,d.degree_name,program_name,umap.parent_name,umap.mother_name,discipline_name');
		$this->db->from('users u');
		$this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
		$this->db->join('batches b','b.id = umap.batch_id','INNER');
		$this->db->join('campuses c','c.id = umap.campus_id','left');
		$this->db->join('degrees d','d.id = umap.degree_id','left');
		$this->db->join('programs e','e.id = d.program_id','left');
		$this->db->join('disciplines f','f.id = d.discipline_id','left');
		$this->db->where('u.id',$student_id);
		
        $result	= $this->db->get()->result();//echo $this->db->last_query(); die;
		return $result;
	}
	function get_student_semester_data($student_id)
	{
		$this->db->select('sum.semester_id');
		$this->db->from('students_ug_marks sum');
		
		$this->db->where('sum.student_id',$student_id);
		$this->db->group_by('sum.semester_id');
		//echo $this->db->last_query(); die;
        $result	= $this->db->get()->result();
		return $result;
	}
	function get_student_marks_by_id_and_semester_id($student_id,$semester_id)
	{
		$this->db->select('um.theory_internal1,um.theory_external2,um.theory_internal3,um.theory_internal2,um.theory_internal1,um.theory_internal,um.assignment_mark,um.theory_paper1,um.theory_paper2,um.sum_internal_practical,
		                   um.external_sum,um.practical_internal,um.theory_external1,um.practical_external,
		                   um.marks_sum,um.student_id,um.course_id,um.semester_id,um.ncc_status,c.id,c.course_code,c.course_title,
						   c.theory_credit,c.practicle_credit,csg.course_subject_name,csg.course_subject_title,csg.id as course_group_id'); 
		$this->db->from('students_ug_marks um');
		$this->db->join('courses as c','c.id=um.course_id','INNER');
		$this->db->join('course_subject_groups csg','csg.id=c.course_subject_id','LEFT');
		$this->db->where(array('um.student_id'=>$student_id,'um.semester_id'=>$semester_id));
		$this->db->order_by("um.course_id", "asc");
        $result	= $this->db->get()->result();
		return $result;
	}
	
	
	function get_semester_name($semester_id)
	{
		$this->db->select('s.semester_code,s.semester_name');
		$this->db->from('semesters s');
		$this->db->where('s.id',$semester_id);
		$result = $this->db->get()->row();
		return $result;
	}
	function save_student_previous_semsester_marks($data)
	{
		//p($data); exit;
		$this->db->insert('previous_semester_marks',$data);
		//$insert_id = $this->db->insert_id();
	}
	function update_student_previous_semsester_marks($data)
	{
		//p($data); exit;
		$campus_id = $data['campus_id'];
		$program_id = $data['program_id'];
		$degree_id = $data['degree_id'];
		$semester_id = $data['semester_id'];
		$batch_id = $data['batch_id'];
		$student_id = $data['student_id'];
		
		$this->db->where(array('campus_id'=>$campus_id,'program_id'=>$program_id,'degree_id'=>$degree_id,'semester_id'=>$semester_id,'batch_id'=>$batch_id,'student_id'=>$student_id));
		$this->db->update('previous_semester_marks',$data);
		}
		
		function update_student_previous_result_marks($data)
	    {
		//p($data); exit;
		$campus_id = $data['campus_id'];
		$program_id = $data['program_id'];
		$degree_id = $data['degree_id'];
		$semester_id = $data['semester_id'];
		$batch_id = $data['batch_id'];
		$student_id = $data['student_id'];
		$course_id = $data['course_id'];
		$this->db->where(array('campus_id'=>$campus_id,'program_id'=>$program_id,'degree_id'=>$degree_id,'semester_id'=>$semester_id,'batch_id'=>$batch_id,'student_id'=>$student_id,'course_id'=>$course_id));
		$this->db->update('results',$data);
		}
	function get_previous_save_semster_marks($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$student_id)
	{
		$this->db->select('psm.*');
        $this->db->from('previous_semester_marks as psm');
        $this->db->where(array('campus_id' =>$campus_id,'program_id'=>$program_id,'degree_id' =>$degree_id,'semester_id'=>$semester_id,'batch_id' =>$batch_id,'student_id'=>$student_id));
        $result	= $this->db->get()->row();
		return $result;
	}
	
	function get_previous_results_subjects_marks($campus_id,$program_id,$degree_id,$semester_id,$batch_id,$student_id,$course_id)
	{
		$this->db->select('r.id');
        $this->db->from('results as r');
        $this->db->where(array('campus_id' =>$campus_id,'program_id'=>$program_id,'degree_id' =>$degree_id,'semester_id'=>$semester_id,'batch_id' =>$batch_id,'student_id'=>$student_id,'course_id'=>$course_id));
        $result	= $this->db->get()->row();
		return $result;
	}
	function save_student_previous_result_marks($data)
	{
		//p($data); exit;
		$this->db->insert('results',$data);
		//$insert_id = $this->db->insert_id();
	}
	function get_batch_name($batch_id)
	{
		$this->db->select('batch_name');
		$this->db->from('batches');
		$this->db->where(array('id'=>$batch_id));
		$result=$this->db->get()->row();
		return $result;
	}
	function get_degree_name($degree_id)
	{
		$this->db->select('degree_name');
		$this->db->from('degrees');
		$this->db->where(array('id'=>$degree_id));
		$result=$this->db->get()->row();
		return $result;
	}
	
	function get_student_pass_fail_list($student_id,$semester_id)
	{
		//p($semester_id); exit;
		$this->db->select('r.*');
		$this->db->from('results as r');
		$this->db->where_in('r.student_id',$student_id);
		$this->db->where(array('r.semester_id'=>$semester_id,'r.passfail_status	'=>'FAIL'));
		$this->db->group_by('r.student_id',$student_id);
		$result=$this->db->get()->result();
		return $result;
	}
	function get_student_info($student_id)
	{
		$this->db->select('u.*,umap.user_id,b.batch_name,c.campus_name,c.campus_code,d.degree_name');
		$this->db->from('users u');
		$this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
		$this->db->join('batches b','b.id = umap.batch_id','INNER');
		$this->db->join('campuses c','c.id = umap.campus_id','left');
		$this->db->join('degrees d','d.id = umap.degree_id','left');
		$this->db->where('u.id',$student_id);
		//echo $this->db->last_query(); die;
        $result	= $this->db->get()->row();
		return $result;
	}
	function get_deflicit_students($student_id,$semester_id,$degree_id)
	{
		//p($semester_id); exit;
		$this->db->select('r.*,c.course_code,cp.campus_code,cp.campus_name,d.degree_name,
		s.semester_name,u.first_name,u.last_name,u.user_unique_id,b.batch_name');
		$this->db->from('results as r');
		$this->db->join('courses as c','c.id=r.course_id','INNER');
		$this->db->join('campuses as cp','cp.id=r.campus_id','INNER');
		$this->db->join('degrees as d','d.id=r.degree_id','INNER');
		$this->db->join('semesters as s','s.id=r.semester_id','INNER');
		$this->db->join('users as u','u.id=r.student_id','INNER');
		$this->db->join('batches as b','b.id=r.batch_id','INNER');
		$this->db->where_in('r.student_id',$student_id);
		$this->db->where(array('r.dstatus'=>'1','r.passfail_status	'=>'FAIL','r.degree_id'=>$degree_id));
		$this->db->group_by('r.student_id',$student_id);
		$result=$this->db->get()->result();
		return $result;
	}
	function get_deflicit_fail_list($student_id,$semester_id)
	{
		//p($semester_id); exit;
		$this->db->select('r.*,c.course_code');
		$this->db->from('results as r');
		$this->db->join('courses as c','c.id=r.course_id','INNER');
		$this->db->where_in('r.student_id',$student_id);
		
		$this->db->where(array('r.dstatus'=>'1','r.passfail_status	'=>'FAIL'));
		$result=$this->db->get()->result();
		return $result;
	}
	function get_deflicit_fail_list_btech($student_id,$semester_id)
	{
		//p($semester_id); exit;
		$this->db->select('r.*,c.course_code');
		$this->db->from('results as r');
		$this->db->join('courses as c','c.id=r.course_id','INNER');
		$this->db->where_in('r.student_id',$student_id);
		
		$this->db->where(array('r.dstatus'=>'1','r.passfail_status	'=>'FAIL'));
		$result=$this->db->get()->result();
		return $result;
	}
    function get_student_data($student_id)
    {
        $this->db->select('u.*,umap.user_id,b.batch_name,b.batch_start_year,c.campus_name,c.campus_code,d.degree_name,d.degree_code,umap.parent_name,umap.mother_name');
        $this->db->from('users u');
        $this->db->join('user_map_student_details umap','umap.user_id = u.id','INNER');
        $this->db->join('batches b','b.id = umap.batch_id','INNER');
        $this->db->join('campuses c','c.id = umap.campus_id','left');
        $this->db->join('degrees d','d.id = umap.degree_id','left');
        $this->db->where_in('u.id',$student_id);
        //echo $this->db->last_query(); die;
        $this->db->order_by('umap.batch_id','desc');
        $this->db->order_by("u.user_unique_id", "asc");
        $result	= $this->db->get()->result();
        return $result;
    }
    function get_bvsc_semester_marks($student_id,$semester_id,$exam_type='',$publish_marks=''){
        $subjectList = $this->get_student_marks_by_id($student_id,$semester_id,$exam_type,$publish_marks);
        $dataList =array();
        $overallReport =array();
        $sum_subjects_credit_point=0;
        $credithours=0;
        $gradeval=0;
        $count_subject=0;
        $list['subjectList'] = array();
        $list['overallReport'] = array();
        if(count($subjectList)>0) {
            foreach ($subjectList as $subjectVal) {
               // p( $subjectVal);
                $data['course_id'] = $subjectVal->courseid;
                $data['courseid'] = $subjectVal->course_id;
                if (empty($subjectVal->course_subject_name))
                    $course_code = $subjectVal->course_code;
                else
                    $course_code = $subjectVal->course_subject_name;

                if (empty($subjectVal->course_subject_title))
                    $course_title = $subjectVal->course_title;
                else
                    $course_title = $subjectVal->course_subject_title;
                $course_group_id = $subjectVal->coure_group_id;
                $data['course_group_id'] = $course_group_id;
                $data['course_code'] = $course_code;
                $data['course_title'] = $course_title;
                $data['theory_credit'] = $subjectVal->theory_credit;
                $data['practicle_credit'] = $subjectVal->practicle_credit;
                $data['theory_practical_credit'] = $data['theory_credit'] + $data['practicle_credit'];
                if ($course_group_id == 22) {

                    $data['course_code'] = $subjectVal->course_code;
                    $data['course_title'] = $subjectVal->course_title;
                    $data['first_internal'] = '';
                    $data['second_internal'] = '';
                    $data['sum_theory'] = '';
                    $data['sum_practical'] = '';
                    $data['gradeval'] = '';
                    $data['creditval'] = '';
                    $data['sum_total'] = '';
                    $data['theory_internal'] = '';
                } else {
                    $numbers = array($subjectVal->theory_internal1, $subjectVal->theory_internal2, $subjectVal->theory_internal3);
                    rsort($numbers);
                    $data['first_internal'] = round_two_digit($numbers[0] / 4);
                    $data['second_internal'] = round_two_digit($numbers[1] / 4);
                    $data['theory_internal'] = round_two_digit($data['first_internal'] + $data['second_internal']);
                    $theory_marks_40 = 0;
                    $course_id = $subjectVal->course_id;
                    $courseArr = explode("-", $course_id);
                    $courseArr = explode("|", $courseArr[0]);
                    $course_count = count($courseArr);
                    $data['sum_theory'] = round_two_digit(($subjectVal->theory_external1 / 5) + ($subjectVal->theory_external2 / 5));
                    $data['sum_practical'] = round_two_digit(($subjectVal->theory_paper1 / 3) + ($subjectVal->theory_paper2 / 3));
                    $data['sum_total'] = round_two_digit($data['first_internal'] + $data['second_internal'] + $data['sum_theory'] + $data['sum_practical']);
                    $data['gradeval'] = number_format(($data['first_internal'] + $data['second_internal'] + $data['sum_theory'] + $data['sum_practical']) / 10, 3);
                    $data['creditval'] = number_format($data['gradeval'] * $data['theory_practical_credit'], 3);
                }
                $passfail_status = 'Fail';
                if ($data['first_internal'] + $data['second_internal'] + $data['sum_theory'] >= 30 && $data['sum_practical'] >= 20) {
                    $passfail_status = 'Pass';
                } elseif ($subjectVal->ncc_status == 1 and $course_group_id == 22) {
                    $passfail_status = 'Satisfactory';
                } elseif ($course_group_id == 22) {
                    $passfail_status = 'Not Satisfactory';
                }
                $data['passfail_status'] = $passfail_status;
                if ($course_group_id != 22) {
                    $count_subject++;
                    $overallReport['sum_subjects_credit_point'] = $sum_subjects_credit_point += $data['creditval'];
                    $overallReport['credithours'] = $credithours += $subjectVal->theory_credit + $subjectVal->practicle_credit;
                    $overallReport['gradeval_avergage'] = $gradeval += $data['gradeval'];
                    $overallReport['count_subject'] = $count_subject;
                }
                $dataList[$data['courseid']] = $data;
                //echo $count_subject;
            }
            //p($subjectVal);exit;
            $list['subjectList'] = $dataList;
            $list['overallReport'] = $overallReport;
            //p($list);exit;
        }
        return 	$list;
    }
	function get_student_results($campus_id,$program_id,$batch_id,$degree_id,$semester_id,$student_id,$month,$year,$exam_type='',$section='',$publish_marks=''){
        $semesterRow = $this->get_semester_name($semester_id);
        $students = $this->get_student_data($student_id);
        foreach($students as $stuData)
        {
            $list['overall']=array();
            $list=$this->get_bvsc_semester_marks($stuData->user_id,$semester_id,$exam_type,$publish_marks);
            //p($list);exit;
            $list['first_name']  =$stuData->first_name;
            $list['father_name']  =$stuData->parent_name;
            $list['mother_name']  =$stuData->mother_name;
            $list['last_name']  =$stuData->last_name;
            $list['user_unique_id']  =$stuData->user_unique_id;
            $list['user_image']  =$stuData->user_image;
            $list['batch_name']  =$stuData->batch_name;
            $list['batch_start_year']  =$stuData->batch_start_year;
            $list['campus_name']  =$stuData->campus_name;
            $list['campus_code']  =$stuData->campus_code;
            $list['degree_code']  =$stuData->degree_code;
            $list['degree_name']  =$stuData->degree_name;
            $list['semester_name'] =$semesterRow->semester_name;
            $list['month_year']  =$month.' '.$year;


            if($semester_id == 1){
                $list['previous'] = array();
                if($section == 'reportcard'){
                    $overallData=$this->get_bvsc_semester_marks($stuData->user_id,$semester_id);
                    $list['overall']['sum_subjects_credit_point'] = $overallData['overallReport']['sum_subjects_credit_point'];
                    $list['overall']['credithours'] = $overallData['overallReport']['credithours'];
                    $list['overall']['gradeval_avergage'] = $overallData['overallReport']['gradeval_avergage'];
                    $list['overall']['count_subject'] = $overallData['overallReport']['count_subject'];
                }else {
                    $list['overall']['sum_subjects_credit_point'] = $list['overallReport']['sum_subjects_credit_point'];
                    $list['overall']['credithours'] = $list['overallReport']['credithours'];
                    $list['overall']['gradeval_avergage'] = $list['overallReport']['gradeval_avergage'];
                    $list['overall']['count_subject'] = $list['overallReport']['count_subject'];
                }
            }else{
                if($semester_id == 4){
                    $prevlist1=$this->get_bvsc_semester_marks($stuData->user_id,1);
                    $list['previous']=$prevlist1;
                   // p($prevlist1);
                    //p($list);
                    if(count($prevlist1)>0){
                        $list['overall']['sum_subjects_credit_point'] = $prevlist1['overallReport']['sum_subjects_credit_point']+@$list['overallReport']['sum_subjects_credit_point'];
                        $list['overall']['credithours'] = $prevlist1['overallReport']['credithours']+@$list['overallReport']['credithours'];
                        $list['overall']['gradeval_avergage'] = $prevlist1['overallReport']['gradeval_avergage']+@$list['overallReport']['gradeval_avergage'];
                        $list['overall']['count_subject'] = $prevlist1['overallReport']['count_subject']+@$list['overallReport']['count_subject'];
                    }
                }elseif($semester_id == 5){
                    $prevlist1=$this->get_bvsc_semester_marks($stuData->user_id,1);
                    $prevlist2=$this->get_bvsc_semester_marks($stuData->user_id,4);
                    $list['previous'] = $prevlist2;
                    $list['overall']['sum_subjects_credit_point'] = $prevlist1['overallReport']['sum_subjects_credit_point']+@$prevlist2['overallReport']['sum_subjects_credit_point']+@$list['overallReport']['sum_subjects_credit_point'];
                    $list['overall']['credithours'] = $prevlist1['overallReport']['credithours']+@$prevlist2['overallReport']['credithours']+@$list['overallReport']['credithours'];
                    $list['overall']['gradeval_avergage'] = $prevlist1['overallReport']['gradeval_avergage']+@$prevlist2['overallReport']['gradeval_avergage']+@$list['overallReport']['gradeval_avergage'];
                    $list['overall']['count_subject'] = $prevlist1['overallReport']['count_subject']+@$prevlist2['overallReport']['count_subject']+@$list['overallReport']['count_subject'];
                }elseif($semester_id == 6){
                    $prevlist1=$this->get_bvsc_semester_marks($stuData->user_id,1);
                    $prevlist2=$this->get_bvsc_semester_marks($stuData->user_id,4);
                    $prevlist3=$this->get_bvsc_semester_marks($stuData->user_id,5);
                    $list['previous'] = $prevlist3;
                    $list['overall']['sum_subjects_credit_point'] = $prevlist1['overallReport']['sum_subjects_credit_point']+@$prevlist2['overallReport']['sum_subjects_credit_point']+@$prevlist3['overallReport']['sum_subjects_credit_point']+@$list['overallReport']['sum_subjects_credit_point'];
                    $list['overall']['credithours'] = $prevlist1['overallReport']['credithours']+@$prevlist2['overallReport']['credithours']+@$prevlist3['overallReport']['credithours']+@$list['overallReport']['credithours'];
                    $list['overall']['gradeval_avergage'] = $prevlist1['overallReport']['gradeval_avergage']+@$prevlist2['overallReport']['gradeval_avergage']+@$prevlist3['overallReport']['gradeval_avergage']+@$list['overallReport']['gradeval_avergage'];
                    $list['overall']['count_subject'] = $prevlist1['overallReport']['count_subject']+@$prevlist2['overallReport']['count_subject']+@$prevlist3['overallReport']['count_subject']+@$list['overallReport']['count_subject'];
                }
            }
            $allData[$stuData->user_id] = $list;
            //p($allData);exit;
        } //exit;
        return $allData;
        $data['aggregate_marks']=$allData;
        return $data;
    }

	
} //end class