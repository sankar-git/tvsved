<?php //p($result_data[0]); exit;?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Result</title>
    <style>
        .table {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .table th {
                border: 1px solid black;
                border-collapse: collapse;
                height: 35px;
            }

        .table th td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }
		.font tr td {
				font-size:12px;
			}

        .table tr td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 12px;
            }
    </style>
</head>


<body>
 
    <div style="padding:20px 20px 20px 20px; width:852px; font-family:Arial, Helvetica, sans-serif; border:solid 1px;">
        <div id="dummy">
            <table>
                <tr>
                    <td><div><span class="logo"><img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:20px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td>
                                        <div>
                                            <p align="center" style=" font-size:15px; margin-top:-20px;">Chennai-600051</p>
                                            <h5 align="center" style=" font-size:15px; margin-top:-10px;" >TRANSCRIPT</h5>
                                           <!-- <p align="center" style=" font-size:15px; margin-top:-20px;" >MVSC in Veterianary and Animal Husbandary Extension</p>-->
                                           
                                        </div>
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table>


            <table style="font-size:14px;">
                <tr>
                    <td style="text-align:left;"><div><b>Name :&nbsp;&nbsp;</b><?php echo $result_data[0]['first_name'];?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td style="text-align:right;"><div><b>Month & Year of Exam:&nbsp;&nbsp;</b><?php echo $result_data[0]['first_name'];?></div></td>
                </tr>
                <tr>
                    <td><div><b>ID No. &nbsp;:</b>&nbsp;&nbsp;<?php echo $result_data[0]['user_unique_id'];?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b>Batch :</b>&nbsp;&nbsp;<?php echo $result_data[0]['batch_name'];?></div></td>
                </tr>
                <tr>
                    <td><div><b>College &nbsp;:</b>&nbsp;&nbsp;<?php echo $result_data[0]['campus_name'];?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                   <!-- <td><div><b>Semester :</b>&nbsp;&nbsp;II</div></td>-->
                </tr>
            </table>


            <br /><br />
			
			 <table class="table" width="100%" style="border:solid 1px black;">
			  <tr>
                    <th rowspan="1">Course No</th>
                    <th rowspan="1">Name of Course</th>
                    <th rowspan="1">Credit Hours</th>
                  
                    <th rowspan="1">Grade Points</th>
                    <th rowspan="1">Credit Points</th>
                    <th rowspan="1">Result</th>
                </tr>
				
			 </table>
			  <?php foreach($result_data as $student_val){
                 //p($student_val); 
	              ?>
            <table class="table" width="100%" style="border:solid 1px black;">
                <tr>
                    <th colspan="6"><?php echo $student_val['semester_name'];?></th>
                   
                </tr>
                <!--<tr>
                    <th scope="col">INT.(Max. 20)</th>
                    <th scope="col">EXT.(Max. 20)</th>
                    <th scope="col">INT.(Max. 20)</th>
                    <th scope="col">EXT.(Max. 20)</th>
                </tr>-->
				<?php 
					$sumcreditpoint='';
					$sumgradepoint='';
					$credithours='';
					$averagegradepoint='';
					$sumtotal='';
					$total_theory_credit='';
					$total_practical_credit='';
					$subject_credit_points='';
					$sum_subjects_credit_point='';
					$resultStatus=array();
					$i=0; foreach($student_val['subjectList'] as $student_course){
						//p($student_course); exit;
						array_push($resultStatus,$student_course['passfail_status']);
						$total_theory_credit= $total_theory_credit+$student_course['theory_credit'];
						$total_practical_credit= $total_practical_credit+$student_course['practicle_credit'];
						$sum_subjects_credit_point=$total_theory_credit+$total_practical_credit;
						$sumgradepoint = $sumgradepoint+$student_course['gradeval'];
						$sumcreditpoint = $sumcreditpoint+$student_course['creditval'];
						$subject_credit_points = $student_course['theory_credit'].'+'.$student_course['practicle_credit'];
						?>
                <tr>
                    <td style="border-bottom:solid 1px #fff !important;"><?php  echo $student_course['course_code'];?></td>
                    <td style="border-bottom:solid 1px #fff !important;"><?php  echo $student_course['course_title'];?></td>
                    <td style="border-bottom:solid 1px #fff !important;"><?php  echo $subject_credit_points;?></td>
                    <td style="border-bottom:solid 1px #fff !important;"><?php  echo $student_course['gradeval'];?></td>
                    <td style="border-bottom:solid 1px #fff !important;"><?php  echo $student_course['creditval'];?></td>
                    <td style="border-bottom:solid 1px #fff !important;"><?php echo $student_course['passfail_status'];?></td>

                </tr>
				<?php $i++;}    //exit; ?>
				
               
                <tr>

                    <td colspan="2"><div style="border-top:solid 1px black !important;">* Non-Credit Courses&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</div></td>
                    <td><div style="border-top:solid 1px black !important;"><?php echo $sum_subjects_credit_point;?></div></td>
                    <td><div style="border-top:solid 1px black !important;"><?php echo $sumgradepoint;?></div></td>
                    <td><div style="border-top:solid 1px black !important;"><?php echo $sumcreditpoint;?></div></td>
                    <td><div style="border-top:solid 1px black !important;"></div> </td>
                </tr>
            </table>
			  <?php }?>
          	
        </div>
    </div>
 
</body>




</html>
