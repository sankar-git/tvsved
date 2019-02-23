<?php //p($dummy_number_report[0]['degree_name']); exit;?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title;?></title>
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
                font-size: 16px;
            }
    </style>
</head>


<body>
<?php if(!isset($_POST['downloadpdf'])){?>
	<form name="genpdf" id="genpdf" action="" method="post">
	<?php foreach($_POST as $key=>$val){?>
		<input type="hidden" name="<?php echo $key;?>" value="<?php echo $val;?>" />
	<?php } ?>
	<input type="hidden" name="downloadpdf" value="true" />
	</form>
	<?php } ?>
    <div style="padding:0px; width:100%; font-family:Arial, Helvetica, sans-serif; ">
	
	     <h4 align="center" style=" font-size:18px;">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY <BR />
           <p align="center" style=" font-size:16px;"><?php echo $subject_wise_list[0]->discipline_code.'. ('.strtoupper($subject_wise_list[0]->discipline_name).')';?></p>
                                            <p align="center" style=" font-size:16px;"><?php echo strtoupper($subject_wise_list[0]->semester_name);?> FINAL EXAMINATION</p>
			<?php if(!isset($_POST['downloadpdf'])){?>
                <h5 align="center"><a href="javascript:;" onclick="document.genpdf.submit();">Download PDF</a></h5>
			<?php } ?>		 
	  
        <!--<div id="dummy">
            <table>
                <tr>
                    <td><div><span class="logo"><img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><p style="margin-left:30px; font-weight:bold; font-size:20px;">TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></td></tr>
                                <tr>
                                    <td>
                                       
                                            <p align="center" style=" font-size:18px;"><?php echo $subject_wise_list[0]->discipline_code.'. ('.strtoupper($subject_wise_list[0]->discipline_name).')';?></p>
                                            <p align="center" style=" font-size:18px;"><?php echo strtoupper($subject_wise_list[0]->semester_name);?> FINAL EXAMINATION</p>
                                        
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table>-->

            <hr />
            <table width="100%" style="font-size:16px;">
			
                <tr>
                    <td width="50%"><b>College :</b>&nbsp;&nbsp;<?php echo $subject_wise_list[0]->campus_code;?></td>
                   
                   <td><b>Month & Year of  Exam :</b>&nbsp;&nbsp;<?php  echo $month.' '.$year; ?><?php  //echo $subject_wise_list[0]->batch_name; ?></td>
                </tr>
                <tr>
                    <td><b>Subject Code :</b>&nbsp;&nbsp;<?php  echo $subject_wise_list[0]->course_code; ?> (<?php echo $subject_wise_list[0]->theory_credit;?>+<?php echo $subject_wise_list[0]->practicle_credit;?>)</td>
                    <td><b>Batch :</b>&nbsp;&nbsp;<?php  echo $subject_wise_list[0]->batch_name; ?></td>
                 </tr> 
				 <tr>
                    <td><b>Subject :</b>&nbsp;&nbsp;<?php  echo $subject_wise_list[0]->course_title; ?></td>
                    <td>
                        
                    </td>
                   
                
                </tr>
               
            </table>


            <br />
            <table class="table" width="100%" style="border:solid 1px black;">
                <tr>
				    <th rowspan="3">S.No.</th>
                    <th rowspan="3">I.D.No.</th>
                    <th rowspan="3">STUDENT NAME</th> 
                    <th <?php if($subject_wise_list[0]->practicle_credit >0 && $subject_wise_list[0]->theory_credit >0){?> colspan="3" <?php }else{ ?> colspan="2" <?php }?> >INTERNAL</th>
                    <th rowspan="3" scope="colgroup">TOTAL<br/>INTERNAL<br/><?php if($subject_wise_list[0]->practicle_credit >0 && $subject_wise_list[0]->theory_credit >0){?>(30+5+15)<?php }else if($subject_wise_list[0]->theory_credit >0) { ?>(40+10)<?php }else{?>(10+40)<?php }?> </th>
                    <th colspan="1" scope="colgroup">EXTERNAL</th>
                    <th rowspan="3" scope="colgroup">TOTAL<br/>%<br/>(Max.100)</th>
                    <th rowspan="3">GRADE<br/>POINT<br/>(Max.10)</th> 
                    <th rowspan="3">RESULT</th>
                   
                </tr>
                <tr>
				<?php if($subject_wise_list[0]->theory_credit > 0){ ?>
                    <th scope="col">THEORY</th>
					<?php } ?>
					<th scope="col">ASSIGNMENT</th>
					<?php if($subject_wise_list[0]->practicle_credit > 0){ ?>
                    <th scope="col">PRACTICAL</th>
                    <?php } ?>
					
                    <th scope="col">THEORY</th>
                </tr>
                <tr>
					<?php if($subject_wise_list[0]->practicle_credit == 0){?>
                    <th scope="col">(Max.40)</th>
                    <th scope="col">(Max.10)</th>
					<?php }else if($subject_wise_list[0]->theory_credit == 0){?>
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
				foreach($subject_wise_list as $subject_wise_val){$i++;
				       //$total_internal_sum = number_format($subject_wise_val->theory_internal1+$subject_wise_val->practical_internal,2);
						if($subject_wise_list[0]->theory_credit > 0 && $subject_wise_list[0]->practicle_credit > 0) 
							$total_internal_sum = number_format($subject_wise_val->theory_internal1 + $subject_wise_val->practical_internal + $subject_wise_val->assignment_mark,2);
						elseif($subject_wise_list[0]->theory_credit > 0 ) 
							$total_internal_sum = $subject_wise_val->theory_internal1+ $subject_wise_val->assignment_mark;
						elseif($subject_wise_list[0]->practicle_credit > 0 )
							$total_internal_sum = $subject_wise_val->practical_internal+ $subject_wise_val->assignment_mark;
							
					   $subject_total_sum = $total_internal_sum+$subject_wise_val->theory_external1;
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
                    <td><?php echo $i;?></td>
					<td><?php echo $subject_wise_val->user_unique_id;?></td>
                    <td nowrap><?php echo $subject_wise_val->first_name;?></td>
					<?php if($subject_wise_list[0]->theory_credit > 0){ ?>
                    <td align="center"><?php echo ($subject_wise_val->theory_internal1>0)?number_format($subject_wise_val->theory_internal1,2):number_format(0,2);?></td>
					<?php } ?>
					<td align="center"><?php echo round_two_digit($subject_wise_val->assignment_mark);?></td>
					<?php if($subject_wise_list[0]->practicle_credit > 0){ ?>
                    <td align="center"><?php echo ($subject_wise_val->practical_internal>0)?number_format($subject_wise_val->practical_internal,2):number_format(0,2);?></td>
					<?php } ?>
                    
                    <td align="center"><?php echo $total_internal_sum;?></td>
                    <td align="center"><?php echo ($subject_wise_val->theory_external1>0)?number_format($subject_wise_val->theory_external1,2):number_format(0,2);?></td>
                    <td align="center"><?php echo $subject_sum_percent100;?></td>
                    <td align="center"><?php echo $subject_sum_percent10;?></td>
                    <td align="center"><?php echo $passfail_status;?></td>
                   
                </tr>
                <?php } ?>
            </table>
           <!-- <table width="100%">
                <tr>
                    <td>
                        <div>
                            <table class="table" width="100%">
                                <tr style="border:solid 1px;">
                                    <th colspan="2">
                                        CURRENT SEMESTER
                                    </th>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div>
                            <table class="table" width="100%">
                                <tr style="border:solid 1px;">
                                    <th colspan="2">
                                        UPTO LAST SEMESTER
                                    </th>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div>
                            <table class="table" width="100%">
                                <tr style="border:solid 1px;">
                                    <th colspan="2">
                                        OVER ALL GRADE POINT AVERAGE
                                    </th>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>

                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>-->
        </div>
    </div>
</body>




</html>
