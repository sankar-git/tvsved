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

<>
<body>
	<p align="center">
	     <h5 align="center">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY </h5>
         <h6 align="center"><?php echo $aggregate_marks[0]->discipline_code;?> - DEGREE SUBJECT WISE MARK REPORT</h6>
		
	</p>
    <div style="padding:0px; width:100%; font-family:Arial, Helvetica, sans-serif; ">
        <div class="pdf_container">
			<table class="sub-detail-tbl" style="width:100%;padding:20px 0px; margin:0px; border-collapse: collapse; margin:20px 0px;Lline-height:1.5">
				<tr>
                    <td align="left" width="25%" style="vertical-align:top;font-weight:bold;">College &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
					<td align="left" width="25%" style="vertical-align:top;font-weight:bold;margin-left:1px;"><?php echo $aggregate_marks[0]->campus_code;?></td>					
					<td align="right" width="25%" style="vertical-align:top;font-weight:bold;">Batch &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
					<td align="left"width="25%" style="vertical-align:top;font-weight:bold;"><?php echo $aggregate_marks[0]->batch_name;?></td>                
                   
                </tr>
                <tr>
                    <td align="left"  style="vertical-align:top;font-weight:bold;">Subject ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
					<td align="left"  style="vertical-align:top;font-weight:bold;"><?php if(empty($aggregate_marks[0]->course_subject_name)) echo $aggregate_marks[0]->course_code; else echo $aggregate_marks[0]->course_subject_name;?></td>
                    <td align="right"  style="vertical-align:top;font-weight:bold;"></td>
					<td align="left" style="vertical-align:top;font-weight:bold;">&nbsp;</td>
                    
                </tr>
				<tr>
                    <td align="left"  style="vertical-align:top;font-weight:bold;">Subject Name &nbsp;:</td>
					<td align="left"  style="vertical-align:top;font-weight:bold;"><?php if(empty($aggregate_marks[0]->course_subject_title)) echo $aggregate_marks[0]->course_title.'('.$aggregate_marks[0]->theory_credit.' + '.$aggregate_marks[0]->practicle_credit.')'; else echo $aggregate_marks[0]->course_subject_title;?></td>
                    <td align="right" style="vertical-align:top;font-weight:bold;"><?php if($degree_id == 1){?>Annual Board<?php }else{?>Semester<?php }?>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
					<td align="left" style="vertical-align:top;font-weight:bold;"><?php echo $aggregate_marks[0]->semester_name;?></td>
                    
                </tr>
             </table> 

        <div class="table_holder">
		<?php if($degree_id == 1){?>
            <table id="table" width="100%;" class="student_table">
                <tr>
					<th rowspan="3">S.No.</th>
                    <th rowspan="3">ID No.</th>
                    <th rowspan="3">NAME</th>
                    <th rowspan="2">INTERNAL</th>
                    <th colspan="<?php echo $course_count;?>">THEORY</th>
                    <th rowspan="2">TOTAL</th>
                    <th rowspan="2">PRACTICAL</th>
                    <th rowspan="3">RESULT</th>
                </tr>
                <tr>
				<?php for($j=0;$j<$course_count;$j++){?>
                    <th>PAPER-<?php echo $numeralCodes[$j];?></th>
				<?php } ?>
                </tr>
				 <tr>
				 <?php for($j=0;$j<$course_count;$j++){?>
                    <th>(20)</th>
                   <?php } ?>
                    <th>(20)</th>
                    <th>(60)</th>
                    <th>(40)</th>
                </tr>
                <?php $i=0;foreach($aggregate_marks as $subject_wise_val){ $i++;
				
				 $numbers = array( $subject_wise_val->theory_internal1,$subject_wise_val->theory_internal2,$subject_wise_val->theory_internal3); 
				  rsort($numbers);
					  $theory_internal_total = $numbers[0]/4 + $numbers[1]/4;
					  $theory_externals=$subject_wise_val->theory_external/5;
					  $practical_externals=$subject_wise_val->practical_external/5;
					  $theory_marks_40=$theory_externals+$practical_externals;
					  $paper1_20=$subject_wise_val->theory_paper1/3;
					  $paper1_20s=number_format($paper1_20,2);
					  $paper2_20=$subject_wise_val->theory_paper2/3;
					  $paper2_20s=number_format($paper2_20,2);
					  $paper_20=$paper1_20s+$paper2_20s;
				?> 
                <tr>
					<td align="center"><?php echo $i;?></td>
                    <td><?php echo $subject_wise_val->user_unique_id;?></td>
                    <td align="left"> <?php echo ucfirst($subject_wise_val->first_name).' '.ucfirst($subject_wise_val->last_name);?></td>
                    <td  align="center" style="border-right:1px solid black; padding:5px;"><?php  echo round_two_digit($theory_internal_total);?></td>
                    <?php $theory_marks_40=0; for($j=1;$j<=$course_count;$j++){ $var = "theory_external".$j; $theory_marks_40+=$subject_wise_val->{$var}/5;?>
                    
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->{$var}/5);?></td>
					<?php }?>
                    <td  align="center"  style="padding:5px; margin:0px;font-weight:bold"><?php if($course_count == 1) $theory_marks_40=$theory_marks_40*2;  elseif($course_count > 2) $theory_marks_40=$theory_marks_40*2/$course_count;  echo round_two_digit($theory_internal_total+$theory_marks_40);?></td>
					<?php $paper_20=0; for($j=1;$j<=$course_count;$j++){ $var = "theory_paper".$j; $paper_20+=$subject_wise_val->{$var}/3; }?>
					
                    <td  align="center"  style="padding:5px; margin:0px;font-weight:bold"><?php $paper_20=($paper_20*2)/$course_count; echo round_two_digit($paper_20);?></td>
                    <td  align="center"  style="padding:5px; margin:0px;font-weight:bold"><?php if(($theory_internal_total+$theory_marks_40) >=30 && $paper_20>=20 && ($theory_internal_total+$theory_marks_40+$paper_20)>=50) echo "PASS"; else echo "FAIL";?></td>
                               

                </tr>
                
                <?php } ?>
            </table>

		<?php }else{ ?>
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
		<?php } ?>
        </div>












        </div>




    
</body>




</html>