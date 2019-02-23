<?php //p($dummy_number_report[0]['degree_name']); exit;?>

<!DOCTYPE html>
<html>
<head>
    
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
                font-size: 11px;
                padding: 0px 0px 0px 0px !important;
            }
    </style>
</head> 
<body>

    <div style="padding:20px 20px 20px 20px; width:852px; font-family:Arial, Helvetica, sans-serif;">
        <div id="dummy">
            <table>
                <tr>
                    <td><div><span class="logo"><img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:15px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td>
                                       
                                            <p align="center" style=" font-size:16px; font-weight:bold;"><?php echo $aggregate_marks[0]['degree_name'];?></p>
                                            <p align="center" style="margin-left:30px; font-size:16px; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AGGRIGATE MARKS</p>
                                       
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table>
			<hr/><br/><br/>

			<?php $i=0;foreach($aggregate_marks as $key=>$student_marks){ 
			if($i%2==0){?>
			
			
			<table width="100%" style="font-size:12px;">
                    <tr>
                        <td><b>Batch :</b><?php echo $student_marks['batch_name'];?></td>
                        <td align="right"><b>Semester&nbsp;&nbsp; :</b> <?php echo $student_marks['semester_name'];?></td>

                    </tr>
                    <tr>
                        <td>
                        
                            <b>Institute : </b><?php echo $student_marks['campus_name']; ?></td>
                         
                       
                    </tr>
                   
                </table>
			<?php } ?>
            <br/>
			<table border="1" cellspacing="0">
			<tr>
			   <th colspan="12" align="left">ID: <?php echo $student_marks['user_unique_id']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name: <?php echo $student_marks['first_name']; ?></th>
			</tr>
			<tr>
			    <th>Course</th>
			    <th>CR HRS</th>
				<th>T-INT(20)</th> 
				<th>P-INT(40)</th> 
				<th>T-AGGR.</th>
				<th>T-EXT(40)</th>
				<th>SUB-AGGR(20)</th>
				<th>GP</th>
				<th>CP</th>
				<th>RESULT</th>
				
			</tr>
			<?php 
			$total_cp='';
			$total_gp='';
			foreach($student_marks['subjectList'] as $subject_data){
				//p($subject_data); exit;
				     $total_cp = $total_cp+$subject_data['creditval'];
					 $total_gp = $total_gp+$subject_data['gradeval'];
					// p($total_cp); 
				?>
			<tr>
			<td><?php if($subject_data['course_code']==''){ echo 'N/A';} else{ echo $subject_data['course_code'];}?></td>
			<td><?php echo $subject_data['theory_credit'].'+'.$subject_data['practicle_credit'];?></td>
			<td><?php if($subject_data['theory_internal']==''){echo 'N/A';}else{echo $subject_data['theory_internal'];}?></td>
			<td><?php if($subject_data['sum_internal_practical']==''){echo 'N/A';}else{echo $subject_data['sum_internal_practical'];}?></td>
			<td><?php if($subject_data['internal_sum']==''){echo 'N/A';}else{echo $subject_data['internal_sum'];}?></td>
			<td><?php if($subject_data['external_sum']==''){echo 'N/A';}else{echo $subject_data['external_sum'];}?></td>
			<td><?php if($subject_data['percentval']==''){echo 'N/A';}else{echo $subject_data['percentval'];}?></td>
			<td><?php if($subject_data['gradeval']==''){echo 'N/A';}else{echo $subject_data['gradeval'];}?></td>
			<td><?php if($subject_data['creditval']==''){echo 'N/A';}else{echo $subject_data['creditval'];}?></td>
			<td><?php if($subject_data['passfail_status']==''){echo 'N/A';}else{echo $subject_data['passfail_status'];}?></td>
			</tr>
			<?php } 	?>
			
			<tr>
			<td colspan="8" align="right">
			Total CP </td>
			
			<td colspan="2" align="center"><p><?php echo $total_cp;?><p></td>
			
			</tr>
			<tr>
			<td colspan="8" align="right">
			GPA</td>
			
			<td colspan="2" align="center"><p><?php echo $total_gp;?><p></td>
			
			</tr>
			</table>
			<br/>
			
<?php  $i++; if($i-1%2==1) echo "<pagebreak>";  }  ?>


            
             
        </div>
    </div>

</body> 
</html>
