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
   <?php  foreach($aggregate_marks as $key=>$student_marks){
     // p($student_val); 
	?>
    <div style="width:100%; font-family:Arial, Helvetica, sans-serif;">
        <div id="dummy">
            <table style="padding-top:0px;">
                <tr>
                    <td><div><span class="logo"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td align="center"><div><div style=" font-weight:bold; font-size:15px;"><p>TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td align="center">
                                        <div>
                                             <h5 align="center" style=" font-size:15px; margin-top:-10px;" >REPORT CARD</h5>
                                        </div>
                                    </td>
                                </tr>
								<tr>
                                    <td align="center">
                                        <div>
                                             <h5 align="center" style=" font-size:15px; margin-top:-10px;" ><?php echo strtoupper($student_marks['semester_name']);?> <?php echo $student_marks['degree_code'];?> DEGREE COURSE</h5>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>


                    </td>
                </tr>
            </table>
			<table class="sub-detail-tbl" style="width:100%;padding:2px 0px; margin:0px; border-collapse: collapse; Lline-height:1.5">
				<tr>
                    <td align="left" width="10%" style="vertical-align:top;font-weight:bold;">Name</td>
					<td align="left" width="35%" style="vertical-align:top;font-weight:bold;margin-left:1px;">&nbsp;:<?php echo $student_marks['first_name'].' '.$student_marks['last_name'];?></td>					
					<td align="right" width="25%" style="vertical-align:top;font-weight:bold;">Father's Name</td>
					<td align="left"width="25%" style="vertical-align:top;font-weight:bold;">&nbsp;:<?php echo $student_marks['father_name'];?></td>                
                   
                </tr>
                <tr>
                    <td align="left" width="25%" style="vertical-align:top;font-weight:bold;">ID No.</td>
					<td align="left" width="25%" style="vertical-align:top;font-weight:bold;">&nbsp;:<?php echo $student_marks['user_unique_id'];?></td>
                    <td align="right" width="25%" style="vertical-align:top;font-weight:bold;">Mother's Name</td>
					<td align="left" width="25%" style="vertical-align:top;font-weight:bold;">&nbsp;:<?php echo $student_marks['mother_name'];?></td>
                    
                </tr>
				<tr>
                    <td align="left" width="25%" style="vertical-align:top;font-weight:bold;">Batch</td>
					<td align="left" width="25%" style="vertical-align:top;font-weight:bold;">&nbsp;:<?php echo $student_marks['batch_name'];?></td>
                    <td align="right" width="25%" style="vertical-align:top;font-weight:bold;">Month & Year</td>
					<td align="left" width="25%" style="vertical-align:top;font-weight:bold;">&nbsp;:<?php echo $month. ' '.$year;?></td>
                    
                </tr>
				<tr>
                    <td align="left" width="25%" style="vertical-align:top;font-weight:bold;">College</td>
					<td align="left" colspan="2" width="25%" style="vertical-align:top;font-weight:bold;">&nbsp;:<?php echo $student_marks['campus_name']; ?></td>
                    
					<td align="left" width="25%" style="vertical-align:top;font-weight:bold;"></td>
                    
                </tr>
             </table> 

			<div style="height:350px;margin:0px;padding:0px;width:100%">
            <table class="table" width="100%;" style="height:100%;border:solid 1px black;padding-top:5px;">
                <tr>
                    <th rowspan="3">Course Code</th>
                    <th rowspan="3">Course Name</th>
                    <th rowspan="3">Credit Hours</th>
                    <th colspan="4" scope="colgroup">Marks Obtained</th>
                   <!-- <th colspan="2" scope="colgroup">PRACTICAl</th>-->
                    <th rowspan="3">Total<br/>(100)</th>
                    <th rowspan="3">Grade Point<br/>(100)</th>
                    <th rowspan="3">Credit Points</th>
					<th rowspan="3">Result</th>
					</tr>
                <tr>
                    <th colspan="2" scope="colgroup">Internal Assessment</th>
                    <th colspan="2" scope="colgroup">Annual Examination</th>
                </tr>
				<tr>
                    <th scope="col"  style="padding:2px;">First <br />(10)</th>
                    <th scope="col" style="padding:2px;">Second <br />(10)</th>
                    <th scope="col"  style="padding:2px;">Theory <br />(40)</th>
					<th scope="col"  style="padding:2px;">Practical<br />(40)</th>
				</tr>

				<?php 
					$sumcreditpoint='';
					$credithours='';
					$averagegradepoint='';
					$sumtotal='';
					$total_theory_credit='';
					$total_practical_credit='';
					$subject_credit_points='';
					$sum_subjects_credit_point='';
					$resultStatus='';
					$i=0; foreach($student_marks['subjectList'] as $subject_data){
						$resultStatus=$subject_data['passfail_status'];
						$sum_subjects_credit_point+=$subject_data['creditval'];
						$credithours+=$subject_data['theory_credit']+$subject_data['practicle_credit'];
					  
						?>
				
                <tr height="10px" style="border:bottom:none;">			    
						<td><?php if($subject_data['course_code']==''){ echo 'N/A';} else{ echo $subject_data['course_code'];}?></td>
						<td><?php if($subject_data['course_title']==''){ echo 'N/A';} else{ echo $subject_data['course_title'];}?></td>
			<td style="text-align:center"><?php echo $subject_data['theory_credit'].'+'.$subject_data['practicle_credit'];?></td>
			<td style="text-align:center"><?php if($subject_data['first_internal']==''){echo 'N/A';}else{echo $subject_data['first_internal'];}?></td>
			<td style="text-align:center"><?php if($subject_data['second_internal']==''){echo 'N/A';}else{echo $subject_data['second_internal'];}?></td>
			<td style="text-align:center"><?php if($subject_data['theory_internal']==''){echo 'N/A';}else{echo $subject_data['theory_internal'];}?></td>
			<td style="text-align:center"><?php if($subject_data['sum_internal_practical']==''){echo 'N/A';}else{echo $subject_data['sum_internal_practical'];}?></td>
			<td style="text-align:center"><?php if($subject_data['internal_sum']==''){echo 'N/A';}else{echo $subject_data['internal_sum'];}?></td>
			<td style="text-align:center"><?php if($subject_data['external_sum']==''){echo 'N/A';}else{echo $subject_data['external_sum'];}?></td>
			<td style="text-align:center"><?php if($subject_data['creditval']==''){echo 'N/A';}else{echo $subject_data['creditval'];}?></td>
			<td style="text-align:center"><?php echo $subject_data['passfail_status'];?></td>
			

                </tr>

				<?php $i++;} for($j=$i;$j<10;$j++){    //exit; ?>
                <tr style="border:bottom:none;" height="10px">	
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					</tr>
				<?php } ?>
            </table>
			</div>
            <table width="100%" class="table" >
                <tr>
                    <td width="33%">
                        
                            <table class="table font" width="100%">
                                <tr>
                                    <th colspan="2">
                                        CURRENT YEAR
                                    </th>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td align="center"><?php if(!empty($sum_subjects_credit_point)) {echo $sum_subjects_credit_point;} else {echo 'N/A';	}?></td>
                                </tr>
                                <tr>
                                    <td>Credit Hours</td>
                                    <td align="center"><?php if(!empty($credithours)){echo $credithours;}else{echo 'N/A';}?></td>
                                </tr>
                                <tr>
                                    <td>Grade Point Average</td>
                                    <td align="center"><?php if(!empty($sum_subjects_credit_point)){ echo $sum_subjects_credit_point;}else{echo 'N/A';} ?></td>
                                </tr>
                            </table>
                        
                    </td>
                    <td width="34%">
                        
                            <table class="table font" width="100%">
                                <tr>
                                    <th colspan="2">
                                        UPTO LASTYEAR
                                    </th>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td align="center"><?php if(!empty($sum_subjects_credit_point)){echo $sum_subjects_credit_point;} else { echo 'N/A';}?></td>
                                </tr>
                                <tr>
                                    <td>Credit Hours</td>
                                    <td align="center"><?php if(!empty($credithours)){echo $credithours;} else { echo 'N/A';}?></td>
                                </tr>
                                <tr>
                                    <td>Grade Point Average</td>
                                    <td align="center"><?php if(!empty($sum_subjects_credit_point)){echo $sum_subjects_credit_point;}else{echo 'N/A';}?></td>
                                </tr>
                            </table>
                       
                    </td>
                    <td width="33%">
                       
                            <table class="table font" width="100%">
                                <tr>
                                    <th colspan="2">
                                        OVERALL
                                    </th>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td align="center"><?php if(!empty($sum_subjects_credit_point)){echo $sum_subjects_credit_point;}else{echo 'N/A';}?></td>

                                </tr>
                                <tr>
                                    <td>Credit Hours</td>
                                    <td align="center"><?php if(!empty($credithours)){echo $credithours;}else{echo 'N/A';}?></td>
                                </tr>
                                <tr>
                                    <td>Grade Point Average</td>
                                    <td align="center"><?php if(!empty($sum_subjects_credit_point)){echo $sum_subjects_credit_point;}else{echo 'N/A';}?></td>
                                </tr>
                            </table>
                       
                    </td>
                </tr>
            </table>
                <p style="padding:0px;margin:0px;font-size:12px;">Note :</p>
                <p style="padding:0px;margin:0px;font-size:12px;"><img height="16" src="<?php echo base_url();?>assets/admin/dist/img/images.png" />&nbsp;An aggregate of 50% marks each in theory and practical separately to pass in a subject/paper is required.</p>
                 <p style="padding:0px;margin:0px;font-size:12px;"><img height="16" src="<?php echo base_url();?>assets/admin/dist/img/images.png" />&nbsp;The Credit point earned by the student shall be taken as zero if the  Grade Points is less than 5.00/ if the student scored less than 50% in theroy (or) practical.</p>
				<p style="padding:0px;margin:0px;font-size:12px;"><img height="16" src="<?php echo base_url();?>assets/admin/dist/img/images.png" />&nbsp;Medium of Instruction : English</p>
                 <p style="padding:0px;margin:0px;font-size:12px;"><img height="16" src="<?php echo base_url();?>assets/admin/dist/img/images.png" />&nbsp;A - Absent, NA - Not Applicable</p>
                 <p style="padding:0px;margin:0px;font-size:12px;"><img height="16" src="<?php echo base_url();?>assets/admin/dist/img/images.png" />&nbsp;For details of courses studied please see overleaf</p>
				<p style="padding:0px;margin:0px;font-size:12px;"><img height="16" src="<?php echo base_url();?>assets/admin/dist/img/images.png" />&nbsp;For the courses with theory alone, the maximum theory marks is 50</p>
				<p style="padding:0px;margin:0px;font-size:12px;"><img height="16" src="<?php echo base_url();?>assets/admin/dist/img/images.png" />&nbsp;For the courses with practical alone, the maximum practical marks is 50</p>
					
               
                <p >RESULT : <strong><?php if($resultStatus == 'F') {echo 'FAIL';} else{ echo 'PASS';}?></strong></p>
                <p >SEAL : </p>
               
				
			<table width="100%">
				<tr>
					<td width="33%" >
						DATE
					</td> 
					<td >
						CONTROLLER OF EXAMINATIONS
					</td> 
					<td >
						REGISTRAR
					</td>
				</tr>
			</table>
        </div>
    </div>
	<?php if($key+1<count($aggregate_marks)){?>
	<pagebreak>
	<?php } } ?>
</body>




</html>
