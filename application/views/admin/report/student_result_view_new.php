<?php //p($dummy_number_report[0]['degree_name']); exit;?>

<!DOCTYPE html>
<html>
<head>
    <title>HTML Table Colspan/Rowspan</title>
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

            .table tr td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 12px;
            }
			.title tr th {
				padding-top:15px;
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
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:18px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td>
                                        <div>
                                            <p align="center" style=" font-size:15px;">B.Tech in Food Tecnology</p>
                                            <p align="center" style=" font-size:15px;">SECOND SEMESTER FINAL EXAMINATION</p>
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
                    <td><div><b>College :</b>&nbsp;&nbsp;<?php echo $student_val['campus_name']; ?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b>Batch &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>&nbsp;<?php echo $student_val['batch_name'];?></div></td>
                </tr>
                <tr>
                    <td><div><b>I.D No. &nbsp;:</b>&nbsp;&nbsp;<?php echo $student_val['user_unique_id']; ?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b>Month & Year :</b>&nbsp;&nbsp;<?php echo $student_val['month_year'];?></div></td>
                </tr>
            </table>


            <br /><br /> 
            <table class="table title" width="100%" style="border:solid 1px black;">
                <tr>
                    <th rowspan="2" style="padding-top:20px;">COURSE NOs</th>
                    <th rowspan="2">COURSE TITLE</th>
                    <th rowspan="2">CREDIT HOURS</th>
                    <th colspan="2" scope="colgroup" style="">THEORY</th>
                    <th colspan="2" scope="colgroup">PRACTICAl</th>
                    <th rowspan="2">% MARKS</th>
                    <th rowspan="2">GRADE POINTS</th>
                    <th rowspan="2">CREDIT POINTS</th>
                    <th rowspan="2">RESULT</th>
                </tr>
                <tr>
                    <th scope="col" style="padding-top:10px;">INT.(Max. 20)</th>
                    <th scope="col">EXT.(Max. 100)</th>
                    <th scope="col">INT.(Max. 20)</th>
                    <th scope="col">EXT.(Max. 100)</th>
                </tr>
				
				<?php 
					$sumcreditpoint='';
					$credithours='';
					$averagegradepoint='';
					$sumtotal='';
					$i=0; foreach($student_val['subjectList'] as $student_course){
						//p($student_course['result_status']); exit;
						$sumtotal=$sumtotal+$student_course['marks_sum'];
						//p($sumtotal);
						 $overallpercent=($sumtotal/1200)*100;
						// p($overallpercent); 
						$student_marks_percentage = round($overallpercent,2);
						//p($student_marks_percentage);
						
						$sumcreditpoint = $sumcreditpoint+$student_course['creditval'];
						$credithours = $credithours+$student_course['credithour'];
						$averagegrade=$sumcreditpoint/$credithours;
						$averagegradepoint = number_format($averagegrade,2);
						
						
						//p($sumcreditpoint);
						?>
                <tr>
                    <td><?php echo $student_course['course_code'];?></td>
                    <td><?php echo $student_course['course_title'];?></td>
                    <td><?php echo $student_course['theory_credit'].'+'.$student_course['practicle_credit'];?></td>
                    <td><?php if(!empty($student_course['theory_internal'])) {echo $student_course['theory_internal'];}else{
													  echo 'N/A';}
												   ?></td>
                    <td><?php if(!empty($student_course['theory_external'])){ echo $student_course['theory_external'];} else{
												 echo 'N/A';}?></td>
                    <td> <?php if(!empty($student_course['practical_internal'])){echo $student_course['practical_internal'];} else {
												echo 'N/A'; } ?></td>
                    <td> <?php if(!empty($student_course['practical_external'])) { echo $student_course['practical_external'];}else{  echo 'N/A'; } ?></td>
                    <td><?php if(!empty($student_course['percentval'])){echo $student_course['percentval'];	}else{echo 'N/A';}?></td>
                    <td><?php if(!empty($student_course['gradeval'])){echo $student_course['gradeval'];} else {echo 'N/A'; } ?></td>
                    <td><?php if(!empty($student_course['creditval'])){echo $student_course['creditval'];} else {echo 'N/A'; } ?></td>
                    <td><?php echo $student_course['result_status'];?></td>
                </tr>
					<?php $i++;}   ?>

            </table>
            <table width="100%">
                <tr>
                    <td>
                        <div>
                              <table class="table" width="100%" >
                                <tr style="border:solid 1px;">
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
                                    <td><?php if(!empty($averagegradepoint)){echo $averagegradepoint;}else{echo 'N/A';} ?></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div>
                            <table class="table" width="100%">
                                    <tr style="border:solid 2px;">
                                        <th colspan="2">
                                            UPTO LAST SEMESTER
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Credit Points</td>
                                        <td><?php if(!empty($sumcreditpoint)){echo $sumcreditpoint;} else { echo 'N/A';}?></td>
                                    </tr>
                                    <tr>
                                        <td>Credit Hours</td>
                                         <td><?php if(!empty($credithours)){echo $credithours;} else { echo 'N/A';}?></td>
                                    </tr>
                                    <tr>
                                        <td>Grade Point Average</td>
                                       <td><?php if(!empty($averagegradepoint)){echo $averagegradepoint;}else{echo 'N/A';}?></td>
                                    </tr>
                                </table>
                        </div>
                    </td>
                    <td>
                        <div>
                            <table class="table" width="100%">
                                    <tr style="border:solid 2px;">
                                        <th colspan="2">
                                            OVER ALL GRADE POINT AVERAGE
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Credit Points</td>
										<td><?php if(!empty($sumcreditpoint)){echo $sumcreditpoint;}else{echo 'N/A';}?></td>
                                      

                                    </tr>
                                    <tr>
                                        <td>Credit Hours</td>
										 <td><?php if(!empty($credithours)){echo $credithours;}else{echo 'N/A';}?></td>
                                    </tr>
                                    <tr>
                                         <td>Grade Point Average</td>
									   <td><?php if(!empty($averagegradepoint)){echo $averagegradepoint;}else{echo 'N/A';}?></td>
                                    </tr>
                                </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<?php } ?>
	
</body>




</html>
