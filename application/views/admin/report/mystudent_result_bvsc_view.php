<?php //p($dummy_number_report[0]['degree_name']); exit;?>

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
                                            <h5 align="center" style=" font-size:15px; margin-top:-10px;" >REPORT CARD</h5>
                                            <p align="center" style=" font-size:15px; margin-top:-20px;" >MVSC in Veterianary and Animal Husbandary Extension</p>
                                            <p align="center" style=" font-size:15px; margin-top:-15px;" ><?php echo $myresult['semester_name']?></p>
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
                    <td style="text-align:left;"><div><b>Name :&nbsp;&nbsp;</b><?php echo $myresult['first_name'].' '.$myresult['last_name'];?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                   <!-- <td style="text-align:right;"><div><b>Month & Year of Exam:&nbsp;&nbsp;</b><?php echo $myresult['month_year'];?></div></td>-->
                </tr>
                <tr>
                    <td><div><b>ID No. &nbsp;:</b>&nbsp;&nbsp;<?php echo $myresult['user_unique_id']; ?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b>Batch :</b>&nbsp;&nbsp;<?php echo $myresult['batch_name'];?></div></td>
                </tr>
                <tr>
                    <td><div><b>College &nbsp;:</b>&nbsp;&nbsp;<?php echo $myresult['campus_name']; ?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b>Semester :</b>&nbsp;&nbsp;II</div></td>
                </tr>
            </table>


            <br /><br />
            <table class="table" width="100%" style="border:solid 1px black;">
                <tr>
                    <th rowspan="1">Course No</th>
                    <th rowspan="1">Name of Course</th>
                    <th rowspan="1">Credit Hours</th>
                    <!--<th colspan="2" scope="colgroup">THEORY</th>
                    <th colspan="2" scope="colgroup">PRACTICAl</th>-->
                    <th rowspan="1">Grade Points</th>
                    <th rowspan="1">Credit Points</th>
                    <th rowspan="1">Result</th>
                </tr>
                <!--<tr>
                    <th scope="col">INT.(Max. 20)</th>
                    <th scope="col">EXT.(Max. 20)</th>
                    <th scope="col">INT.(Max. 20)</th>
                    <th scope="col">EXT.(Max. 20)</th>
                </tr>-->
				<?php 
					$sumcreditpoint='';
					$credithours='';
					$averagegradepoint='';
					$sumtotal='';
					$total_theory_credit='';
					$total_practical_credit='';
					$subject_credit_points='';
					$sum_subjects_credit_point='';
					$resultStatus=array();
					$i=0; foreach($myresult['subjectList'] as $student_course){
						array_push($resultStatus,$student_course['passfail_status']);
						//p($student_course); 
						$total_theory_credit=$total_theory_credit+$student_course['theory_credit'];
						$total_practical_credit=$total_practical_credit+$student_course['practicle_credit'];
						$subject_credit_points = $student_course['gradeval']*$student_course['theory_practical_credit'];
						$sum_subjects_credit_point=$sum_subjects_credit_point+$subject_credit_points;
						//p($student_course['result_status']); exit;
						$sumtotal=$sumtotal+$student_course['marks_sum'];
						//p($sumtotal);
						 $overallpercent=($sumtotal/1200)*100;
						// p($overallpercent); 
						$student_marks_percentage = round($overallpercent,2);
						//p($student_marks_percentage);
						
						$sumcreditpoints = $sumcreditpoint+$student_course['creditval'];
						$sumcreditpoint = number_format($sumcreditpoints,2);
						//p($sumcreditpoint); 
						$credithours = $credithours+$student_course['credithour'];
						$averagegrade=$sumcreditpoint/$credithours;
						$averagegradepoint = number_format($averagegrade,2);
						$prevsubtotal='';
						$prevsubcreditpoints='';
						$prevsubtotalcredit='';
						$prevsubgradepointavg='';
						foreach($student_val['prevSemesterList'][0] as $prev_semdata){
						
						$prevsubtotal= $prevsubtotal+$prev_semdata->total_marks;
						$prevsubcreditpoints= $prevsubcreditpoints+$prev_semdata->total_credit_points;
						$prevsubtotalcredit=$prevsubtotalcredit+$prev_semdata->total_credits;
						$prevsubgradepointavg=$prevsubgradepointavg+$prev_semdata->total_grade_point_average;
						//p($prevsubcreditpoints); 
						} // exit;
						
						$overallTotalCredit='';
						$overallTotalCreditHours='';
						$overallAverageCredit='';
						$overallAverageCredit='';
						$overallTotalCredit = $sumcreditpoint+$prevsubcreditpoints;
						//p($overallTotalCredit); exit;
						$overallTotalCreditHours = $credithours+$prevsubtotalcredit;
						//p($overallTotalCreditHours); 
						$overallAverageCredits=$overallTotalCredit/$overallTotalCreditHours;
						$overallAverageCredit=number_format($overallAverageCredits,2);
						?>
				
                <tr>
                    <td style="border-bottom:solid 1px #fff !important;"><?php echo $student_course['course_code'];?></td>
                    <td style="border-bottom:solid 1px #fff !important;"><?php echo $student_course['course_title'];?></td>
                    <td style="border-bottom:solid 1px #fff !important;"><?php echo $student_course['theory_credit'].'+'.$student_course['practicle_credit'];?></td>
                    <td style="border-bottom:solid 1px #fff !important;"><?php echo $student_course['gradeval'];?></td>
                    <td style="border-bottom:solid 1px #fff !important;"><?php echo $student_course['creditval'];?></td>
                    <td style="border-bottom:solid 1px #fff !important;"><?php echo $student_course['passfail_status'];?></td>

                </tr>
				
				
				
				<?php $i++;}    //exit; ?>
               
                <tr>

                    <td colspan="2"><div style="border-top:solid 1px black !important;">* Non-Credit Courses&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</div></td>
                    <td><div style="border-top:solid 1px black !important;"><?php echo $credithours.'('.$total_theory_credit.'+'.$total_practical_credit.')';?></div></td>
                    <td><div style="border-top:solid 1px black !important;">-</div></td>
                    <td><div style="border-top:solid 1px black !important;"><?php echo $sumcreditpoint;?></div></td>
                    <td><div style="border-top:solid 1px black !important;"></div> </td>
                </tr>
            </table>

            <table width="100%">
                <tr>
                    <td>
                        <div>
                            <table class="table font" width="100%">
                                <tr>
                                    <th colspan="2">
                                        CURRENT SEMESTER
                                    </th>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td><?php if(!empty($sumcreditpoint)) {echo $sumcreditpoint;} else {echo 'N/A';	}?></td>
                                </tr>
                                <tr>
                                    <td>Credit Hours</td>
                                    <td><?php if(!empty($credithours)){echo $credithours;}else{echo 'N/A';}?></td>
                                </tr>
                                <tr>
                                    <td>Grade Point Average</td>
                                    <td><?php if(!empty($averagegradepoint)){ echo $averagegradepoint;}else{echo 'N/A';} ?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    
                </tr>
            </table>
			
			
                <br />
                <h4>Note :</h4>
                <div style="font-size:10px; font-weight:bold;">
                    <p><b>*</b> An aggregate of 50% marks each in theory and practical separately to pass in a subject/paper is required.</p>
                    <p><b>*</b> INT - Internal, EXT - External, % - Percentage, NA - Not Applicable, A - Absent, R - Result with No of attempts, P - Pass, F - Fail</p>
                    <p><b>*</b> Medium of Instruction : English</p>
                </div>
                <br />
                <h4>RESULT :<?php if(in_array('F',$resultStatus)) {echo 'FAIL';} else{ echo 'PASS';}?></h4>
			
        </div>
    </div>
 
</body>




</html>
