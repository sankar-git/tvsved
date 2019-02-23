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
   <?php foreach($result_data as $student_val){
     // p($student_val); 
	?>
    <div style="padding:20px 20px 20px 20px; width:852px; font-family:Arial, Helvetica, sans-serif; border:solid 1px;">
        <div id="dummy">
            <table>
                <tr>
                    <td><div><span class="logo"><img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:20px;"><p>TAMIL NADU  VETERINARY AND ANIMAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td>
                                        <div>
                                            <p align="center" style=" font-size:15px; margin-top:-20px;text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chennai-600051</p>
                                            <h5 align="center" style=" font-size:15px; margin-top:-10px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REPORT CARD</h5>
                                            <p align="center" style=" font-size:15px; margin-top:-20px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MVSC in Veterianary and Animal Husbandary Extension</p>
                                            <p align="center" style=" font-size:15px; margin-top:-15px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SECOND SEMESTER FINAL EXAMINATION</p>
                                        </div>
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table>

            <hr />

                <table style="width:100%;padding:0px; margin:0px; border:1px solid #103">
                    
                    <tr>
                        <td style="width:50%"> <b>Name :&nbsp;&nbsp;</b><?php echo $student_val['first_name'].' '.$student_val['last_name'];?></td>
                        <td style="width:50%; text-align:right;">
                            <table style="width:100%;padding:0px; margin:0px;">
                                <tr>
                                    <td style="width:60%;"><b>Month & Year of Exam:</b></td>
                                    <td style="width:40%;"><?php echo $student_val['month_year'];?></td>
                                </tr>
                            </table>
                            
                        </td>

                    </tr>
                    <tr>
                        
                        <td><b>ID No:&nbsp;&nbsp;</b><?php echo $student_val['user_unique_id'];?></td>
                        <td style="text-align:right">
                            <table style="width:100%;padding:0px; margin:0px;">
                                <tr>
                                    <td style="width:60%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Batch :</b></td>
                                    <td style="width:40%;"><?php echo $student_val['batch_name'];?></td>
                                </tr>
                            </table>
                         
                        </td>
                    </tr>
                    <tr>
                        <td>
                           <b> College &nbsp;:</b>&nbsp;&nbsp;<?php echo $student_val['campus_name']; ?>
                        </td>
                        <td style="text-align:right">
                            <table style="width:100%;padding:0px; margin:0px;">
                                <tr>
                                    <td style="width:55%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Semester :</b></td>
                                    <td style="width:40%;">II</td>
                                </tr>
                            </table>
                         
                        </td>
                    </tr>

                </table>

            <!-- <table style="font-size:14px;">
                <tr>
                    <td style="text-align:left;"><div><b>Name :&nbsp;&nbsp;</b><?php echo $student_val['first_name'].' '.$student_val['last_name'];?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td style="text-align:right;"><div><b>Month & Year of Exam:&nbsp;&nbsp;</b><?php echo $student_val['month_year'];?></div></td>
                </tr>
                <tr>
                    <td><div><b>ID No. &nbsp;:</b>&nbsp;&nbsp;<?php echo $student_val['user_unique_id']; ?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b>Batch :</b>&nbsp;&nbsp;<?php echo $student_val['batch_name'];?></div></td>
                </tr>
                <tr>
                    <td><div><b>College &nbsp;:</b>&nbsp;&nbsp;<?php echo $student_val['campus_name']; ?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b>Semester :</b>&nbsp;&nbsp;II</div></td>
                </tr>
            </table> -->


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
					$i=0; foreach($student_val['subjectList'] as $student_course){
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
                    <td style="border-bottom:solid 1px #fff !important;"><?php echo $subject_credit_points;?></td>
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
<br><br>
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
                    <td>
                        <div>
                            <table class="table font" width="100%">
                                <tr>
                                    <th colspan="2">
                                        UPTO LAST SEMESTER
                                    </th>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td><?php if(!empty($prevsubcreditpoints)){echo $prevsubcreditpoints;} else { echo 'N/A';}?></td>
                                </tr>
                                <tr>
                                    <td>Credit Hours</td>
                                    <td><?php if(!empty($prevsubtotalcredit)){echo $prevsubtotalcredit;} else { echo 'N/A';}?></td>
                                </tr>
                                <tr>
                                    <td>Grade Point Average</td>
                                    <td><?php if(!empty($prevsubgradepointavg)){echo $prevsubgradepointavg;}else{echo 'N/A';}?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div>
                            <table class="table font" width="100%">
                                <tr>
                                    <th colspan="2">
                                        OVER ALL GRADE POINT AVERAGE
                                    </th>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td><?php if(!empty($overallTotalCredit)){echo $overallTotalCredit;}else{echo 'N/A';}?></td>

                                </tr>
                                <tr>
                                    <td>Credit Hours</td>
                                    <td><?php if(!empty($overallTotalCreditHours)){echo $overallTotalCreditHours;}else{echo 'N/A';}?></td>
                                </tr>
                                <tr>
                                    <td>Grade Point Average</td>
                                    <td><?php if(!empty($overallAverageCredit)){echo $overallAverageCredit;}else{echo 'N/A';}?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
			
			
                <br />
                <h4>Note :</h4>
                <div style="font-size:14px; font-weight:bold;">
                    <p><b>*</b> An aggregate of 50% marks each in theory and practical separately to pass in a subject/paper is required.</p>
                    <p><b>*</b> INT - Internal, EXT - External, % - Percentage, NA - Not Applicable, A - Absent, R - Result with No of attempts, P - Pass, F - Fail</p>
                    <p><b>*</b> Medium of Instruction : English</p>
                </div>
                <br />
                <h4>RESULT :<?php if(in_array('F',$resultStatus)) {echo 'FAIL';} else{ echo 'PASS';}?></h4>
			
        </div>
    </div><br><br><br><br><br><br><br><br><br><br>
   <?php } ?>
</body>




</html>
