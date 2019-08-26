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
            height: 35px;
        }
    </style>
</head>


<body>
<?php $count=0; $tot_non_credit_hrs=0; foreach($aggregate_marks['semester_1'] as $student_id=>$student_marks){
?>
<div style="width:100%; font-family:Arial, Helvetica, sans-serif;">
    <div id="dummy">
        <table style="padding-top:0px;">
            <tr>
                <td width="11%" style="text-align:left;vertical-align: top;"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></td>
                <td width="76%" style="">
                        <table>
                            <tr><td align="center"><div><div style=" font-weight:bold; font-size:18px;"><p>TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>

                            <tr>
                                <td align="center">
                                    <div>
                                        <h5 align="center" style=" font-size:18px; margin-top:10px;">TRANSCRIPT</h5>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div>
                                        <h5 align="center" style=" font-size:18px; margin-top:10px;"><?php echo strtoupper($student_marks['degree_name']);?><br/>(<?php echo $student_marks['degree_code'];?>) DEGREE COURSE</h5>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div>&nbsp;</div>
                                </td>
                            </tr>
                        </table>
                </td>
                <td width="13%"  style="border:1px solid #000;text-align:left;vertical-align: top;"><?php if(!empty($student_marks['user_image']) && file_exists('uploads/user_images/student/'.$student_marks['user_image']) ){?><img height="125"  border="0" src="uploads/user_images/student/<?php echo $student_marks['user_image'];?>" /><?php } ?></td>
            </tr>
        </table>
        <table class="sub-detail-tbl" style="width:100%;padding:2px 0px; margin:0px; border-collapse: collapse; Lline-height:1.5">
            <tr>
                <td align="left"  colspan="6" style="vertical-align:top;">Name of the College:&nbsp;<?php echo $student_marks['campus_name']; ?></td>
            </tr>
            <tr>
                <td align="left" width="7%" style="vertical-align:top;">Name</td>
                <td align="left" colspan="2" width="35%" style="vertical-align:top;margin-left:1px;">&nbsp;:&nbsp;<?php echo $student_marks['first_name'].' '.$student_marks['last_name'];?></td>
                <td align="left" width="18%" style="vertical-align:top;">Father's Name</td>
                <td align="left" colspan="2" width="25%" style="vertical-align:top;">&nbsp;:&nbsp;<?php echo $student_marks['father_name'];?></td>

            </tr>
            <tr>
                <td align="left" width="7%" style="vertical-align:top;">ID No.</td>
                <td align="left" colspan="2" width="25%" style="vertical-align:top;">&nbsp;:&nbsp;<?php echo $student_marks['user_unique_id'];?></td>
                <td align="left" width="18%" style="vertical-align:top;">Mother's Name</td>
                <td align="left" colspan="2" width="25%" style="vertical-align:top;">&nbsp;:&nbsp;<?php echo $student_marks['mother_name'];?></td>

            </tr>
            <tr>
                <td align="left" width="25%" style="vertical-align:top;">Admitted In:</td>
                <td align="left" width="7%%" style="vertical-align:top;">&nbsp;</td>
                <td align="left" width="25%" style="vertical-align:top;">Completed In:</td>
                <td align="left" width="7%" style="vertical-align:top;">&nbsp;</td>
                <td align="left" width="30%"  style="vertical-align:top;">Last Institution Attended:</td>
                <td align="left" width="7%" style="vertical-align:top;">&nbsp;</td>

            </tr>

        </table>

        <div style="margin-top:20px;padding:0px;width:100%">
            <table class="table" width="100%;" style="height:100%;border:solid 1px black;padding-top:5px;">
                <thead>
                <tr>
                    <th rowspan="3">SI.No</th>
                    <th rowspan="3">Subject</th>
                    <th rowspan="3" >Credit Hours</th>
                    <th colspan="4"  scope="colgroup">Marks Obtained</th>
                    <th rowspan="3" >Total<br/>(100)</th>
                    <th rowspan="3" >Grade Point<br/>(10)</th>
                    <th rowspan="3" >Credit Points</th>
                    <!-- <th rowspan="3">Result</th>-->
                </tr>
                <tr>
                    <th colspan="2" scope="colgroup">Internal Assessment</th>
                    <th colspan="2" scope="colgroup">Annual Examination</th>
                </tr>
                <tr>
                    <th scope="col" >First <br />(10)</th>
                    <th scope="col">Second <br />(10)</th>
                    <th scope="col">Theory <br />(40)</th>
                    <th scope="col" >Practical<br />(40)</th>
                </tr>
                </thead><tbody>
                <?php foreach($aggregate_marks as $semester=>$student_res){  $student_marks=$aggregate_marks[$semester][$student_id]; ?>
                <tr>
                    <td colspan="10" style="text-align:center"><?php echo $student_marks['semester_name']; ?></td>
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
                $resultStatus='PASS';
                $external_sum='';
                $count_subject=0;
                $i=0;  foreach($student_marks['subjectList'] as $subject_data){ $i++;
                    if($subject_data['passfail_status'] == 'FAIL' || $subject_data['passfail_status'] =='Not Satisfactory')
                        $resultStatus='FAIL';
                    $sum_subjects_credit_point+=$subject_data['creditval'];$count_subject++;
                    $external_sum+=$subject_data['external_sum'];
                    $credithours+=$subject_data['theory_credit']+$subject_data['practicle_credit'];

                    ?>

                    <tr>
                        <td><?php echo $i;?></td>
                        <td ><?php if($subject_data['course_title']==''){ echo '';} else{ echo $subject_data['course_title'];}?></td>
                        <td style="text-align:center"><?php echo $subject_data['theory_credit'].'+'.$subject_data['practicle_credit']; if($subject_data['course_group_id'] == 22){ $tot_non_credit_hrs+=$subject_data['theory_credit']+$subject_data['practicle_credit']; echo "(Non-<br/>Credit)";} ?></td>
                        <?php if($subject_data['course_group_id'] == 22){ ?>
                            <td colspan="7" style="text-align:center"><?php echo $subject_data['passfail_status'];?></td>
                        <?php }else{ ?>
                            <td style="text-align:center"><?php if($subject_data['first_internal']==''){echo '';}else{echo $subject_data['first_internal'];}?></td>
                            <td style="text-align:center"><?php if($subject_data['second_internal']==''){echo '';}else{echo $subject_data['second_internal'];}?></td>
                            <td style="text-align:center"><?php if($subject_data['sum_theory']==''){echo '';}else{echo $subject_data['sum_theory'];}?></td>
                            <td style="text-align:center"><?php if($subject_data['sum_practical']==''){echo '';}else{echo $subject_data['sum_practical'];}?></td>
                            <td style="text-align:center"><?php if($subject_data['sum_total']==''){echo '';}else{echo $subject_data['sum_total'];}?></td>
                            <td style="text-align:center"><?php if($subject_data['gradeval']==''){echo '';}else{echo $subject_data['gradeval'];}?></td>
                            <td style="text-align:center"><?php if($subject_data['creditval']==''){echo '';}else{echo $subject_data['creditval'];}?></td>
                            <!--<td style="text-align:center"><?php echo $subject_data['passfail_status'];?></td>-->
                        <?php } ?>
                    </tr>

                <?php } } ?>
                </tbody>
            </table>
        </div>
        <table width="100%" style="padding:0px;margin-left:0px;margin-top:5px;margin-bottom:5px;font-size:12px;text-align:left;" >
            <tr>
                <td style="height:30px;">Grand Total of Credit Hours: <?php if(!empty($student_marks['overall']['credithours'])){echo $student_marks['overall']['credithours'];}else{echo 'N/A';}?></td><td>&nbsp;</td>
                <td>Grand Total of Credit Points: <?php if(!empty($student_marks['overall']['sum_subjects_credit_point'])) {echo $student_marks['overall']['sum_subjects_credit_point'];} else {echo 'N/A';	}?></td><td>&nbsp;</td>
            </tr>
            <tr>
                <td style="height:30px;">Non-Credit Hours: <?php echo $tot_non_credit_hrs;?></td><td>&nbsp;</td>
            </tr>
            <tr>
                <td style="height:30px;">Overall Grade Point Average(OGPA): <?php if(!empty($student_marks['overall']['sum_subjects_credit_point'])){ echo round($student_marks['overall']['sum_subjects_credit_point']/$student_marks['overall']['credithours'],3);}else{echo 'N/A';} ?></td><td>&nbsp;</td>
                <td>Percentage of Marks:</td><td>&nbsp;</td>
            </tr>
            <tr>
                <td style="height:30px;"><strong>RESULT:&nbsp;<?php if($resultStatus == 'FAIL') {echo 'FAIL';} else{ echo 'PASS';}?></strong></td><td>&nbsp;</td>
                <td><strong>CONDUCT</strong></td><td>&nbsp;</td>
            </tr>
            <tr>
                <td style="height:30px;">
                    <p>*&nbsp;&nbsp;&nbsp;&nbsp;Cleared with compartment</p>
                    <p>**&nbsp;&nbsp;&nbsp;Unsuccessful in the Professional Year</p>
                    <p>***&nbsp;&nbsp;Internship extended or repeated</p>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td  style="height:30px;" width="33%" >DATE:</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
            </tr>
            <tr>
                <td  style="height:30px;" width="33%" >&nbsp;</td>
                <td>CONTROLLER OF EXAMINATIONS</td>
                <td>REGISTRAR</td>
            </tr>
        </table>
    </div>
</div>
<?php if($count+1<count($aggregate_marks['semester_1'])){?>
<pagebreak>
    <?php } $count++;}  ?>
</body>




</html>
