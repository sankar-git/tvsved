<html>
<head>
    <title>Class Grade</title>
    <style>
        .table {
             
            border-collapse: collapse;
            padding:0px !important;
        }

            .table th {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 0px 0px 0px 0px !important;
                font-size: 13px;
            }

                .table th td {
                     
                    border-collapse: collapse;
                    padding: 0px 0px 0px 0px !important;
                }

            .table tr td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 13px;
                padding: 0px 0px 0px 0px !important;
            }


        .header{
            width:100%;
            padding:0px;
            margin:0px;
            border-bottom:1px solid #000;
        }

        .pdf_container{
            width:100%;
            display:block;
            padding:0px;
            margin:0px;
        }
        .sub-detail-tbl tr td{
          padding:5px 0px;

        }
        
        .student_table,
        .student_sub_table{
            width:100%;
            padding:0px;
            margin:0px;
            border-collapse: collapse;
            font-size:14px;
        }


        .student_table td,
        .student_table th{
            padding:5px;
            border: 1px solid black;
          }  


          .student_sub_table td,
          .student_sub_table th{
            padding:0px;
            border:none;
          }
    </style>
</head>


<body>
    <table>
                <tr>
                    <td><div><span class="logo"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:16px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr><br />
                                <tr>
                                    <td align="center">
                                            <p align="center" style=" font-size:14px;"><b><?php echo $aggregate_marks[0]->degree_code;?></b></p><br />
                                            <p align="center" style=" font-size:14px; padding:10px 0px 0px 0px;"><b>
                                            SUBJECT WISE MARK REPORT</b>
                                            </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
            <hr />
    <div style="padding:0px; width:100%; font-family:Arial, Helvetica, sans-serif; ">
        <div class="pdf_container">
            <table width="100%" style="font-size:12px;">
                <tr>
                    <td><b>College</b></td>
                    <td> : <?php echo $aggregate_marks[0]->campus_name;?></td>
                    <td><b>Batch</b></td>
                    <td> : <?php echo $aggregate_marks[0]->batch_name;?></td>
                </tr>
                <tr>
                    <td><b>Examination</b></td>
                    <td > : <?php echo $aggregate_marks[0]->semester_name.'-'."Annual";?></td>
                    <td><b>Month & Year</b></td>
                    <td> : <?php if(!empty($month) && !empty($year)){echo $month.' '.$year;}else{echo "Select Month & Year";}?></td>
                </tr>
                <tr>
                   <td><b>Subject</b></td>
                   <td> : <?php $sub = explode(" ", $aggregate_marks[0]->course_title);
                            $sub_nam = $sub[0].' '.$sub[1];
                            echo $sub_nam;?></td>
                    <td><b>Credit Hours</b></td>
                    <td> : <?php echo $aggregate_marks[0]->theory_credit.'+'.$aggregate_marks[0]->practicle_credit;?></td>
                </tr>
            </table>
        <div class="table_holder">
		<?php if($degree_id == 1){?>
            <table id="table" width="100%;" class="student_table">
                <tr>
					<th rowspan="3">S.No.</th>
                    <th rowspan="3">ID No.</th>
                    <th rowspan="3">NAME</th>
                    <th colspan="4">MARKS OBTAINED</th>
                    
                    
                    <th rowspan="3" align="center">TOTAL<br />(100)</th>
                    <th rowspan="3">RESULT</th>
                </tr>
                <tr>
                    <th colspan="2">INTERNAL ASSESSMENT</th>
                    <th colspan="2">ANNUAL EXAM</th>
				
                </tr>
                <tr>
                    <th rowspan="1" align="center">First<br />(10)</th>
                    <th rowspan="1" align="center">Second<br />(10)</th>
                    <th rowspan="1" align="center">Theory<br />(40)</th>
                    <th rowspan="1" align="center">Practical<br />(40)</th>
                </tr>
                <?php $i=0;foreach($aggregate_marks as $subject_wise_val){ $i++;
                    // $inter1 = $subject_wise_val->theory_internal1/4;
                    // $inter2 = $subject_wise_val->theory_internal2/4;
                    // $inter3 = $subject_wise_val->theory_internal3/4;

				
				 $numbers = array( $subject_wise_val->theory_internal1,$subject_wise_val->theory_internal2,$subject_wise_val->theory_internal3); 
				  rsort($numbers);
                  // $array = array(50,250,30,250,40,70,10,50); // 250  2-times
$max=$max2=0;
for ($k = 0; $k < count($numbers); $k++) {
if ($numbers[$k] > $max) {
    $max2 = $max;
    $max = $numbers[$k];
} else if (($numbers[$k] > $max2) && ($numbers[$k] != $max)) {
    $max2 = $numbers[$k];
}
}
// echo "Highest Value is : " . $max . "<br/>"; //output : 250
// echo "Second highest value is : " . $max2 . "<br/>";//output : 70
                if($subject_wise_val->theory_credit > 0 && $subject_wise_val->practicle_credit > 0) {
                    $internal_sum = number_format($subject_wise_val->theory_internal1 + $subject_wise_val->practical_internal,2);
                }
                elseif($subject_wise_val->theory_credit > 0 ) {
                    $internal_sum = $subject_wise_val->theory_internal1;
                }
                elseif($subject_wise_val->practicle_credit > 0 ){
                    $internal_sum = $subject_wise_val->practical_internal;
                    $internal_sum = $internal_sum+$subject_wise_val->assignment_mark;
                }
                $data['theory_external']    = $subject_wise_val->theory_external1;
                $external_marks   =   $data['theory_external'];
                $total_subject_marks=$internal_sum + $external_marks;
                $data['total_subject_marks']       =$total_subject_marks;
					  // $theory_internal_total = $numbers[0]/4 + $numbers[1]/4;


					//   $theory_externals=$subject_wise_val->theory_external/5;
					//   $practical_externals=$subject_wise_val->practical_external/5;
					//   $theory_marks_40=$theory_externals+$practical_externals;
					//   $paper1_20=$subject_wise_val->theory_paper1/3;
					//   $paper1_20s=number_format($paper1_20,2);
					//   $paper2_20=$subject_wise_val->theory_paper2/3;
					//   $paper2_20s=number_format($paper2_20,2);
					//   $paper_20=$paper1_20s+$paper2_20s;
				?> 
                <tr>
					<td align="center"><?php echo $i;?></td>
                    <td><?php echo $subject_wise_val->user_unique_id;?></td>
                    <td align="left"> <?php echo ucfirst($subject_wise_val->first_name).' '.ucfirst($subject_wise_val->last_name);?></td>

            <td style="text-align:center"><?php if($internal_sum==''){echo 'N/A';}else{echo $internal_sum/4;}?></td>
            <td style="text-align:center"><?php if($external_marks==''){echo 'N/A';}else{echo '-';}?></td>
            <td style="text-align:center"><?php if($external_marks==''){echo 'N/A';}else{echo $external_marks;}?></td>
            <td style="text-align:center"><?php if($subject_wise_val->total_subject_marks==''){echo 'N/A';}else{echo $subject_wise_val->total_subject_marks;}?></td>
            
                    <!-- <td  align="center" style="border-right:1px solid black; padding:5px;"><?php echo $max/2;?></td><td  align="center" style="border-right:1px solid black; padding:5px;"><?php echo $max2/2;?></td> -->
                    <!-- <?php $theory_marks_40=0; for($j=1;$j<=$course_count;$j++){ $var = "theory_external".$j; $theory_marks_40+=$subject_wise_val->{$var}/5;?>
                    
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->{$var}/5);?></td>
					<?php }?> -->
                    <!-- <td  align="center"  style="padding:5px; margin:0px;font-weight:bold"><?php if($course_count == 1) $theory_marks_40=$theory_marks_40*2;  elseif($course_count > 2) $theory_marks_40=$theory_marks_40*2/$course_count;  echo round_two_digit($theory_internal_total+$theory_marks_40);?></td>
					<?php $paper_20=0; for($j=1;$j<=$course_count;$j++){ $var = "theory_paper".$j; $paper_20+=$subject_wise_val->{$var}/3; }?>
					
                    <td  align="center"  style="padding:5px; margin:0px;font-weight:bold"><?php $paper_20=($paper_20*2)/$course_count; echo round_two_digit($paper_20);?></td> -->
                    <td  align="center"  style="padding:5px; margin:0px;font-weight:bold"><?php if(($theory_internal_total+$theory_marks_40) >=30 && $paper_20>=20 && ($theory_internal_total+$theory_marks_40+$paper_20)>=50) echo "PASS"; else echo "FAIL";?></td>
                               

                </tr>
                
                <?php } ?>
            </table>

		<?php }elseif($program_id == 1){ ?>
            <table class="table" width="100%" style="border:solid 1px black;">
                <tr>
				    <th rowspan="3" style="text-align:center">S.No.</th>
                    <th rowspan="3" style="text-align:center">I.D.No.</th>
                    <th rowspan="3">STUDENT NAME</th> 
                    <th <?php if($aggregate_marks[0]->practicle_credit >0 && $aggregate_marks[0]->theory_credit >0){?> colspan="3" <?php } else{?>colspan="2"<?php }?> >INTERNAL</th>
                    <!--<th rowspan="3" scope="colgroup">TOTAL<br/>INTERNAL<br/><?php if($aggregate_marks[0]->practicle_credit >0 && $aggregate_marks[0]->theory_credit >0){?>(30+20)<?php }else{?>(50)<?php }?> </th>-->
                    <th colspan="1" scope="colgroup">EXTERNAL</th>
                    <th rowspan="3" scope="colgroup">TOTAL<br/>%<br/>(Max.100)</th>
                    <!--<th rowspan="3">GRADE<br/>POINT<br/>(Max.10)</th> -->
                    <th rowspan="3">RESULT</th>
                   
                </tr>
                <tr>
					<?php if($aggregate_marks[0]->theory_credit > 0){ ?>
                    <th scope="col">THEORY</th>
					<?php } ?>
					<th scope="col">ASSIGNMENT</th>
					<?php if($aggregate_marks[0]->practicle_credit > 0){ ?>
                    <th scope="col">PRACTICAL</th>
                    <?php } ?>
                    <th scope="col">THEORY</th>
                    
                    
                </tr>
                <tr>
					 <?php if($aggregate_marks[0]->practicle_credit == 0){?>
                    <th scope="col">(Max.40)</th>
                    <th scope="col">(Max.10)</th>
					<?php }else if($aggregate_marks[0]->theory_credit == 0){?>
					<th scope="col">(Max.10)</th>
					<th scope="col">(Max.40)</th>
					<?php }else{ ?>
                    <th scope="col">(Max.30)</th>
                    <th scope="col">(Max.5)</th>
                    <th scope="col">(Max.15)</th>
					<?php } ?>
                    
                    <th scope="col">(Max.50)</th>
                    
                </tr>
                
				<?php 
				$i=0;
				$total_internal_sum='';
				$subject_total_sum='';
				$percent_subject='';
				$subject_sum_percent100='';
				$subject_sum_percent10='';
				foreach($aggregate_marks as $subject_wise_val){$i++;
				       //$total_internal_sum = number_format($subject_wise_val->theory_internal1+$subject_wise_val->practical_internal,2);
						if($aggregate_marks[0]->theory_credit > 0 && $aggregate_marks[0]->practicle_credit > 0) 
							$total_internal_sum = number_format($subject_wise_val->theory_internal1 + $subject_wise_val->practical_internal,2);
						elseif($aggregate_marks[0]->theory_credit > 0 ) 
							$total_internal_sum = $subject_wise_val->theory_internal1;
						elseif($aggregate_marks[0]->practicle_credit > 0 )
							$total_internal_sum = $subject_wise_val->practical_internal;
							
					   $subject_total_sum = $total_internal_sum+$subject_wise_val->assignment_mark+$subject_wise_val->theory_external1;
					   $percent_subject = $subject_total_sum*100/100;
					   $subject_sum_percent100=number_format($percent_subject,2);
					   $subject_sum_percent10= number_format($subject_total_sum/10,2);
					  // p($subject_sum_percent); exit;
					  if($total_internal_sum>=25 && $subject_wise_val->theory_external1>=25)
						  $passfail_status = 'PASS';
					  else
						  $passfail_status = 'FAIL';
					  if($display == 'fail_list'){
						  if($passfail_status == 'PASS')
							  continue;
					  }
				?>
				 <tr>
                    <td style="text-align:center"><?php echo $i;?></td>
					<td style="text-align:center"><?php echo $subject_wise_val->user_unique_id;?></td>
                    <td nowrap  style="padding-left:1px;"><?php echo $subject_wise_val->first_name;?></td>
					<?php if($aggregate_marks[0]->theory_credit > 0){ ?>
                    <td align="center"><?php echo ($subject_wise_val->theory_internal1>0)?number_format($subject_wise_val->theory_internal1,2):number_format(0,2);?></td>
					<?php } ?>
					 <td align="center"><?php echo ($subject_wise_val->assignment_mark>0)?number_format($subject_wise_val->assignment_mark,2):number_format(0,2);?></td>
					<?php if($aggregate_marks[0]->practicle_credit > 0){ ?>
                    <td align="center"><?php echo ($subject_wise_val->practical_internal>0)?number_format($subject_wise_val->practical_internal,2):number_format(0,2);?></td>
					<?php } ?>
                    <!--<td align="center"><?php echo $total_internal_sum;?></td>-->
                    <td align="center"><?php echo ($subject_wise_val->theory_external1>0)?number_format($subject_wise_val->theory_external1,2):number_format(0,2);?></td>
                    <td align="center"><?php echo $subject_sum_percent100;?></td>
                    <!--<td align="center"><?php echo $subject_sum_percent10;?></td>-->
                    <td align="center"><?php echo $passfail_status;?></td>
                   
                </tr>
                <?php } ?>
            </table>
		<?php }else{?>
			 <table class="table" width="100%" style="border:solid 1px black;">
                <tr>
				    <th>S.No.</th>
                    <th>I.D.No.</th>
                    <th>STUDENT NAME</th> 
                    <th>INTERNAL<br/>MARK<br/>(Max.20)</th>
                    <th>TERM<br/>PAPER<br/>(Max.10)</th>
					<th>EXTERNAL<br/>THEORY<br/>(Max.70)</th>
					<th>THEORY<br/>TOTAL<br/>(%)</th>
                    <th>PARCTICAL<br/>MARK<br/><?php if($aggregate_marks[0]->theory_credit > 0) {?>(Max.50)<?php }elseif($aggregate_marks[0]->practicle_credit > 0){ ?>(Max.100)<?php }?></th>
					<th >GRADE<br/>POINT<br/>(Max.10)</th> 
                    <th>RESULT</th>
                   <?php if(!empty($this->input->post('blank'))) {?><th>DEFICIT</th><?php } ?>
				   
                </tr>
               
                
				<?php 
				$i=0;
				$total_internal_sum='';
				$subject_total_sum='';
				$percent_subject='';
				$subject_sum_percent100='';
				$subject_sum_percent10='';
				foreach($aggregate_marks as $subject_wise_val){$i++;
				       //$total_internal_sum = number_format($subject_wise_val->theory_internal1+$subject_wise_val->practical_internal,2);
						if($aggregate_marks[0]->theory_credit > 0 && $aggregate_marks[0]->practicle_credit > 0) {
							$total_internal_sum = $subject_wise_val->theory_internal1 + $subject_wise_val->theory_external1 + $subject_wise_val->assignment_mark;
							$practical = $subject_wise_val->practical_internal*2;
							if($total_internal_sum>=60 && $practical>=60)
								$passfail_status = 'PASS';
							else
								$passfail_status = 'FAIL';
							$subject_sum_percent10= number_format((($total_internal_sum+$subject_wise_val->practical_internal)/150)*10,2);
						}elseif($aggregate_marks[0]->theory_credit > 0 ) {
							$total_internal_sum = $subject_wise_val->theory_internal1+ $subject_wise_val->assignment_mark+ $subject_wise_val->theory_external1;
							if($total_internal_sum>=60)
								$passfail_status = 'PASS';
							else
								$passfail_status = 'FAIL';
							$subject_sum_percent10= number_format($total_internal_sum/10,2);
						}elseif($aggregate_marks[0]->practicle_credit > 0 ){
							$total_internal_sum = '-';
							$practical = $subject_wise_val->practical_internal*2;
							if($practical>=60)
								$passfail_status = 'PASS';
							else
								$passfail_status = 'FAIL';
							$subject_sum_percent10= number_format($subject_wise_val->practical_internal/10,2);
						}
			
						$total_internal_sum = number_format($total_internal_sum,2);
					  
					  if($display == 'fail_list'){
						  if($passfail_status == 'PASS')
							  continue;
					  }
				?>
				 <tr>
                    <td><?php echo $i;?></td>
					<td><?php echo $subject_wise_val->user_unique_id;?></td>
                    <td nowrap><?php echo $subject_wise_val->first_name.' '.$subject_wise_val->last_name;?></td>
                    <td align="center">
						<?php if($aggregate_marks[0]->theory_credit > 0){ echo ($subject_wise_val->theory_internal1>0)?number_format($subject_wise_val->theory_internal1,2):number_format(0,2); }else echo '-';?>
					</td>
					<td align="center">
						<?php if($aggregate_marks[0]->theory_credit > 0){  echo round_two_digit($subject_wise_val->assignment_mark);}else echo '-';?>
					</td>
					
                    <td align="center">
						<?php if($aggregate_marks[0]->theory_credit > 0){  echo ($subject_wise_val->theory_external1>0)?number_format($subject_wise_val->theory_external1,2):number_format(0,2);}else echo '-';?>
					</td>
                    <td align="center">
						<?php echo $total_internal_sum;?>
					</td>
                    <?php if($aggregate_marks[0]->practicle_credit > 0){ ?>
						<td align="center"><?php echo ($subject_wise_val->practical_internal>0)?number_format($subject_wise_val->practical_internal,2):number_format(0,2);?></td>
					<?php }else{ ?>
						<td align="center">-</td>
					<?php } ?>
                    <td align="center"><?php echo $subject_sum_percent10;?></td>
                    <td align="center"><?php echo $passfail_status;?></td>
                   <?php if(!empty($this->input->post('blank'))) {?>
						<th>
							<?php if($aggregate_marks[0]->practicle_credit > 0 && $aggregate_marks[0]->theory_credit > 0){ 
								if($total_internal_sum<60) echo "Theory: ". number_format((60-$total_internal_sum),2)."<br>";
								if($practical<60) echo "Practical: ". number_format((60-$practical)/2,2);
							}
							?>
						</th>
					<?php } ?>
                </tr>
                <?php } ?>
            </table>
		<?php } ?>
        </div>












        </div>




    
</body>




</html>