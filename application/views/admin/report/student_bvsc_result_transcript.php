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
 
    <div style="padding:0px; width:100% font-family:Arial, Helvetica, sans-serif;">
        <div id="dummy">
            <table>
                <tr>
                    <td><div><span class="logo"><img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:18px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY, CHENNAI-600051</p></div></div></td></tr>
                                <tr>
                                    <td>
                                        <div>
                                           
                                            <h5 align="center" style=" font-size:14px; margin-top:-10px;" >TRANSCRIPT OF ACADEMIC RECORD FOR <?php echo strtoupper($result_data[0]['program_name']);?> PROGRAMME</h5>
                                        </div>
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table>

            <hr />
			<table class="table" width="100%" style="border:solid 1px black;">
				<tr>
					<td width="10%">Name</td><td colspan="3"><?php echo $result_data[0]['first_name'].' '.$result_data[0]['last_name'];?></td>
					<td  width="15%">Degree awarded</td><td colspan="2"><?php echo $result_data[0]['degree_name'];?></td>
				</tr>
				<tr>
					<td>ID Number</td><td width="15%"><?php echo $result_data[0]['user_unique_id'];?></td>
					<td width="8%">Sex</td><td width="10%"><?php echo ucfirst($result_data[0]['gender']);?></td>
					<td>Date of admisssion</td><td>&nbsp;</td><td rowspan="7">&nbsp;</td>
				</tr>
				<tr>
					<td>Date of Birth</td><td><?php echo $result_data[0]['dob'];?></td>
					<td>Place of birth</td><td>&nbsp;</td>
					<td>Date of completion</td><td width="20%">&nbsp;</td>
				</tr>
				<tr>
					<td>Name of the Parent/Guardian</td><td  colspan="2"><?php echo $result_data[0]['parent_name'];?></td><td>&nbsp;</td>
					
					<td>OGPA</td><td><?php  echo number_format($total_gradeval/$total_count,2);?></td>
				</tr>
				<tr>
					<td>College</td><td  colspan="2"><?php echo $result_data[0]['campus_code'];?></td><td>&nbsp;</td>
					
					<td>Details of previous examination passed</td><td>&nbsp;</td>
				</tr>
				<tr>
					<td>Faculty</td><td  colspan="2">&nbsp;</td><td>&nbsp;</td>
					
					<td>Univerity/College</td><td><?php echo $result_data[0]['campus_name'];?></td>
				</tr>
				<tr>
					<td>Discipline</td><td  colspan="2"><?php echo $result_data[0]['discipline_name'];?></td><td>&nbsp;</td>
					
					<td>Degree Earned</td><td><?php echo $result_data[0]['degree_name'];?></td>
				</tr>
				<tr>
					<td>Medium of Instruction</td><td  colspan="2">English</td><td>&nbsp;</td>
					
					<td>Month and year of passing</td><td><?php $month = isset($month)?$month:date('F');$year = isset($year)?$year:date('Y'); echo $month.' '.$year;?></td>
				</tr>
				
			</table>
            <!--<table style="font-size:14px;">
				<tr>
					<td style="font-weight:bold;width:15%;">Name</td>
					<td style="width:44%;">: <?php echo $result_data[0]['first_name'];?></td>
					<td style="font-weight:bold;">Month & Year of Exam</td>
					<td >: <?php $month = isset($month)?$month:date('F');$year = isset($year)?$year:date('Y'); echo $month.' '.$year;?></td>
				</tr>
				<tr>
					<td style="font-weight:bold">ID No.</td>
					<td>: <?php echo $result_data[0]['user_unique_id'];?></td>
					<td style="font-weight:bold">Batch</td>
					<td>: <?php echo $result_data[0]['batch_name'];?></td>
				</tr>
				<tr>
					<td style="font-weight:bold">College</td>
					<td>: <?php echo $result_data[0]['campus_name'];?></td>
					<td></td>
					<td></td>
				</tr>
				
               
            </table><br /><br />-->


            
			<div style="float:left;width:50%">
			 <table class="table" width="99%" style="border:solid 1px black;">
			  <tr>
                    <th rowspan="1" width="11%">Course No</th>
                    <th rowspan="1">Course Title</th>
                    <th rowspan="1" width="10%">Credit Hours</th>
                  
                    <th rowspan="1" width="10%">Grade Points</th>
                    <th rowspan="1" width="10%">Credit Points</th>
                    <!--<th rowspan="1">Result</th>-->
                </tr>
				
			
			  <?php $count=0; $flag=false; foreach($result_data as $student_val){ $count++;?>
                <?php	if($count >=19 && $flag == false){ $flag=true;
	              ?>
				  </table></div><div style="float:left;width:50%"><table class="table" width="100%" style="border:solid 1px black;">
			  <tr>
                    <th width="11%">Course No</th>
                    <th>Course Title</th>
                    <th width="10%">Credit Hours</th>
                  
                    <th width="10%">Grade Points</th>
                    <th width="10%">Credit Points</th>
                    <!--<th>Result</th>-->
                </tr>
					<?php } ?>
				
                <tr>
                    <td colspan="5"><b><?php echo $student_val['semester_name'];?></b></td>
                   
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
					$i=0; foreach($student_val['subjectList'] as $student_course){ $count++;
						//p($student_course); exit;
						array_push($resultStatus,$student_course['passfail_status']);
						$total_theory_credit= $total_theory_credit+$student_course['theory_credit'];
						$total_practical_credit= $total_practical_credit+$student_course['practicle_credit'];
						$sum_subjects_credit_point=$total_theory_credit+$total_practical_credit;
						$sumgradepoint = $sumgradepoint+$student_course['gradeval'];
						$sumcreditpoint = $sumcreditpoint+$student_course['creditval'];
						$subject_credit_points = $student_course['theory_credit'].'+'.$student_course['practicle_credit'];
						?>
						<?php	if($count >=19 && $flag == false){ $flag=true;
	              ?>
				  </table></div><div style="float:left;width:50%"><table class="table" width="100%" style="border:solid 1px black;">
			  <tr>
                    <th width="11%">Course No</th>
                    <th>Course Title</th>
                    <th width="10%">Credit Hours</th>
                  
                    <th width="10%">Grade Points</th>
                    <th width="10%">Credit Points</th>
                    <!--<th>Result</th>-->
                </tr>
					<?php } ?>
            
                <tr>
                    <td align="center" ><?php  echo $student_course['course_code'];?></td>
                    <td><?php  echo $student_course['course_title'];?></td>
                    <td align="center" ><?php  echo $subject_credit_points;?></td>
                    <td align="center" ><?php  echo $student_course['gradeval'];?></td>
                    <td align="center" ><?php  echo $student_course['creditval'];?></td>
                    <!--<td align="center" style="border-bottom:solid 1px #fff !important;"><?php echo $student_course['passfail_status'];?></td>-->

                </tr>
				<?php $i++;}

				
				//exit; ?>
				
               
              <!--  <tr>

                    <td colspan="2"><div style="border-top:solid 1px black !important;">* Non-Credit Courses&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</div></td>
                    <td align="center"><div style="border-top:solid 1px black !important;"><?php echo $sum_subjects_credit_point;?></div></td>
                    <td align="center"><div style="border-top:solid 1px black !important;"><?php echo $sumgradepoint;?></div></td>
                    <td align="center"><div style="border-top:solid 1px black !important;"><?php echo $sumcreditpoint;?></div></td>
                    <td>&nbsp;</td>
                </tr>-->
          
			  <?php } ?>
				<?php
				if(count($result_data) == 0)
					$row_count = 38;
				elseif($counter >=19)
					$row_count = 38;
				elseif($counter <19)
					$row_count = 38;
				for($j=1;$j<$row_count-$count;$j++){ $counter = $j+$count;
				if($counter >=19 && $flag == false){ $flag=true;
	              ?>
				  </table></div><div style="float:left;width:50%"><table class="table" width="100%" style="border:solid 1px black;">
			  <tr>
                    <th width="11%">Course No</th>
                    <th>Course Title</th>
                    <th width="10%">Credit Hours</th>
                  
                    <th width="10%">Grade Points</th>
                    <th width="10%">Credit Points</th>
                    <!--<th>Result</th>-->
                </tr>
				<?php }else{ ?>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				<?php } } ?>
			  
          	  </table>
        </div>
        </div>
    </div>
 
</body>




</html>
