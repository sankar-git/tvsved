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
                                            <p align="center" style=" font-size:15px;"><?php echo $subject_wise_list[0]->degree_name;?></p>
                                            <p align="center" style=" font-size:15px;"><?php echo $subject_wise_list[0]->semester_name;?></p>
                                            <p align="center" style=" font-size:15px;">Failed List</p>
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
                    <td><div><b>College :</b>&nbsp;&nbsp;<?php echo $subject_wise_list[0]->campus_name;?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                      <td><div><b>Batch :</b>&nbsp;&nbsp;<?php  echo $subject_wise_list[0]->batch_name; ?></div></td>
                </tr>
                <tr>
                    <td><div><b>Subject Code :  &nbsp;:</b>&nbsp;&nbsp;<?php  echo $subject_wise_list[0]->course_code; ?> (<?php echo $subject_wise_list[0]->theory_credit;?>+<?php echo $subject_wise_list[0]->practicle_credit;?>)</div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                  
                    <td><div><b>Subject :  &nbsp;:</b>&nbsp;&nbsp;<?php  echo $subject_wise_list[0]->course_title; ?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b></b>&nbsp;&nbsp;</div></td>
                
                </tr>
               
            </table>


            <br /><br /> 
            <table class="table" width="100%" style="border:solid 1px black;">
                <tr>
				    <th rowspan="3">S.No.</th>
                    <th rowspan="3">I.D.No.</th>
                    <th rowspan="3">STUDENT NAME</th> 
                    <th colspan="2" scope="colgroup">INTERNAL</th>
                    <th colspan="1" scope="colgroup">TOTAL</th>
                    <th colspan="1" scope="colgroup">EXTERNAL</th>
                    <th colspan="1" scope="colgroup">TOTAL</th>
                    <th colspan="1">GRADE POINT</th> 
                    <th rowspan="3">RESULT</th>
                   
                </tr>
                <tr>
                    <th scope="col">THEORY</th>
                    <th scope="col">PRACTICAL</th>
                    <th scope="col">INTERNAL</th>
                    <th scope="col">THEORY</th>
                    <th scope="col">%</th>
                    <th scope="col"> </th>
                </tr>
                <tr>
                    <th scope="col">(MAX.30)</th>
                    <th scope="col">(MAX.20)</th>
                    <th scope="col">(30+20)</th>
                    <th scope="col">(MAX.50)</th>
                    <th scope="col">(MAX.100)</th>
                    <th scope="col">(MAX.10)</th>
                </tr>
                <!--<tr>
				    <td>VAN-I</td>
                    <td>VAN-I</td>
                    <td>VAN-II</td>
                    <td>VPY-I</td>
                    <td>THEORY</td>
                    <td>VPY-II</td>
                    <td>LPM-I</td>
                    <td>LPM-II</td>
                    <td>LPM-II</td>
                    <td>PASS</td>
                    <td>LPM-II</td>
                    <td>PASS</td>
                </tr>-->
				<?php 
				$i=0;
				$total_internal_sum='';
				$subject_total_sum='';
				$percent_subject='';
				$subject_sum_percent100='';
				$subject_sum_percent10='';
				foreach($subject_wise_list as $subject_wise_val){$i++;
				       $total_internal_sum = $subject_wise_val->theory_internal+$subject_wise_val->practical_internal;
					   $subject_total_sum = $total_internal_sum+$subject_wise_val->theory_external;
					   $percent_subject = $subject_total_sum*100/100;
					   $subject_sum_percent100=number_format($percent_subject,2);
					   $subject_sum_percent10= $subject_total_sum/10;
					  // p($subject_sum_percent); exit;
				?>
				 <tr>
                    <td><?php echo $i;?></td>
					<td><?php echo $subject_wise_val->user_unique_id;?></td>
                    <td><?php echo $subject_wise_val->first_name;?></td>
                    <td><?php echo $subject_wise_val->theory_internal;?></td>
                    <td><?php echo $subject_wise_val->practical_internal;?></td>
                    <td><?php echo $total_internal_sum;?></td>
                    <td><?php echo $subject_wise_val->theory_external;?></td>
                    <td><?php echo $subject_sum_percent100;?></td>
                    <td><?php echo $subject_sum_percent10;?></td>
                    <td><?php echo $subject_wise_val->passfail_status;?></td>
                   
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
