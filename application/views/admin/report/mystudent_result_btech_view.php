<?php //$student_val['subjectList']; exit;?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Result</title>
    <style>
        .table {
            border-collapse: collapse;
            padding: 0px !important;
        }

            .table th {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 0px 5px 0px 5px !important;
                font-size: 12px;
				
            }

                .table th td {
                    border-collapse: collapse;
                    padding: 0px 0px 0px 0px !important;
                }

            .table tr td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 18px;
                padding: 5px 5px 5px 5px !important;
            }
            .tableLevelTwo {
            border-collapse: collapse;
            padding: 0px !important;
        }

            .tableLevelTwo th {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 0px 0px 0px 0px !important;
                font-size: 12px;
            }

                .tableLevelTwo th td {
                    border-collapse: collapse;
                    padding: 0px 0px 0px 0px !important;
                }

            .tableLevelTwo tr td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 11px;
                padding: 0px 0px 0px 0px !important;
            }
			.font tr td {
				font-size:12px;
			}
			.padding tr th{
				padding:8px 2px 8px 2px;
				
			}
			
    </style>
</head>

<body>

    <div style="padding:20px 20px 20px 20px; width:852px; font-family:Arial, Helvetica, sans-serif; border:solid 0px;">
        <div id="dummy">
            <table>
                <tr>
                    <td><div><span class="logo"><img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:18px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td>
                                        <div>
                                            <p align="center" style=" font-size:18px; font-weight:bold;">B.Tech in Diary Tecnology</p>
                                            <p align="center" style=" font-size:18px; font-weight:bold;"><?php echo $myresult['semester_name']?></p>
                                        </div>
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table>

            <hr />
            <div id="Divmain">
                <table style="font-size:14px;">
                    <tr>
                        <td><div><b>Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </b><?php echo $myresult['first_name'].' '.$myresult['last_name'];?></div></td>
                        <!--<td align="right"><div><b>Month & Year of Exam &nbsp;&nbsp; : </b> <?php echo $myresult['month_year'];?></div></td>-->

                    </tr>
                    <tr>
                        <td>
                         <div>
                            <b>ID. No.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </b><?php echo $myresult['user_unique_id']; ?>
						 </div>
						</td>
                         
                        <td align="right"><div><b>Batch &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>&nbsp;<?php echo $myresult['batch_name'];?></div></td>
                    </tr>
                    <tr>
                        <td><div><b>College &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </b><?php echo $myresult['campus_name']; ?></div></td>

                        <td><div><b>Semester &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b> <?php echo $myresult['semester_name']; ?></div></td>
                    </tr>
                </table>
                <br />
				
				<table class="table padding" width="100%" style="border:solid 1px black;">
                <tr>
                    <th rowspan="1">COURSE NO</th>
                    <th rowspan="1">COURSE TITLE</th>
                    <th rowspan="1">CREDIT HOURS</th>
                    <th rowspan="1" >INTERNAL(50)</th>
                    <th rowspan="1" >EXTERNAL(50)</th>
                    <th rowspan="1">% MARKS</th>
                    <th rowspan="1">GRADE POINTS</th>
                    <th rowspan="1">CREDIT POINTS</th>
                    <th rowspan="1">RESULT</th>
                </tr>
               
				
				<?php 
					$sumcreditpoint='';
					$credithours='';
					$averagegradepoint='';
					$sumtotal='';
					$i=0; foreach($myresult['subjectList'] as $student_course){
						//p($student_course['result_status']); exit;
						
						
						$sumtotal=$sumtotal+$student_course['marks_sum'];
						//p($sumtotal);
						 $overallpercent=($sumtotal/1200)*100;
						// p($overallpercent); 
						$student_marks_percentage = round($overallpercent,2);
						//p($student_marks_percentage);
						
						$sumcreditpoints = $sumcreditpoint+$student_course['creditval'];
						$sumcreditpoint = number_format($sumcreditpoints,2);
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
						//p($prevsubcreditpoints);  exit;
						$prevsubtotalcredit=$prevsubtotalcredit+$prev_semdata->total_credits;
						//p($prevsubtotalcredit); exit;
						$prevsubgradepointavgs = $prevsubcreditpoints/$prevsubtotalcredit;
						$prevsubgradepointavg = number_format($prevsubgradepointavgs,2);
						//p($prevsubcreditpoints);  exit;
						}  //exit;
						$overallTotalCredit='';
						$overallTotalCreditHours='';
						$overallAverageCredit='';
						$overallTotalCredit = $sumcreditpoint+$prevsubcreditpoints;
						//p($overallTotalCredit); exit;
						$overallTotalCreditHours = $credithours+$prevsubtotalcredit;
						//p($overallTotalCreditHours); 
						$overallAverageCredits = $overallTotalCredit/$overallTotalCreditHours;
						//p($overallAverageCredits); exit;
						$overallAverageCredit = number_format($overallAverageCredits,2);
						//p($overallAverageCredit); exit;
						
						
						?>
                <tr>
                    <td><?php echo $student_course['course_code'];?></td>
                    <td><?php echo $student_course['course_title'];?></td>
                    <td><?php echo $student_course['theory_credit'].'+'.$student_course['practicle_credit'];?></td>
                    <td><?php if(!empty($student_course['sum_internal_practical'])) {echo $student_course['sum_internal_practical'];}else{
													  echo 'N/A';}
												   ?></td>
                    <td><?php if(!empty($student_course['theory_external'])){ echo $student_course['theory_external'];} else{
												 echo 'N/A';}?></td>
                  
                    <td><?php if(!empty($student_course['percentval'])){echo $student_course['percentval'];	}else{ echo 'N/A';}?></td>
                    <td><?php if(!empty($student_course['gradeval'])){echo $student_course['gradeval'];} else {echo 'N/A'; } ?></td>
                    <td><?php if(!empty($student_course['creditval'])){echo $student_course['creditval'];} else {echo 'N/A'; } ?></td>
                    <td><?php echo $student_course['passfail_status'];?></td>
                </tr>
					<?php $i++;}    //exit; ?>

            </table>
				 <br />
                <table width="100%">
                    <tr>
                        <td>
                            <div>
                                <table class="table font" width="100%">
                                    <tr>
                                        <th colspan="2" height="30px;">
                                            CURRENT SEMESTER
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Credit Points</td>
                                        <td>
										   <?php if(!empty($sumcreditpoint)) {echo $sumcreditpoint;} else {echo 'N/A';	}?>
										</td>
                                    </tr>
                                    <tr>
                                        <td>Credit Hours</td>
                                        <td>
										    <?php if(!empty($credithours)){echo $credithours;}else{echo 'N/A';}?>
										</td>
                                    </tr>
                                    <tr>
                                        <td>Grade Point Average</td>
                                        <td>
										    <?php if(!empty($averagegradepoint)){ echo $averagegradepoint;}else{echo 'N/A';} ?>
										</td>
										
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
                <h4>RESULT : <?php if($student_marks_percentage >=50){echo "PASS";} else {echo "FAIL";}?></h4>
            </div>
        </div>
    </div>
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

</body>


</html>
