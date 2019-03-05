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
                font-size: 12px;
				font-weight:bold;
            }

                .table th td {
                     
                    border-collapse: collapse;
					
                    padding: 0px 0px 0px 0px !important;
                }

            .table tr td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 12px;
				
                padding: 0px 0px 0px 0px !important;
				height:38px;
				text-align:center;
				
            }

        .pdf_container{
            width:100%;
            display:block;
            padding:0px;
            margin:0px;
        }

    </style>
</head>


<body>
    <div style="padding:10px 10px 10px 10px; width:852px; font-family:Arial, Helvetica, sans-serif;">
		<div align="center">
			   <p align="center" style="font-weight:bold; font-size:16px;">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY<br />
			   <span align="center" style=" font-size:14px; padding-top:0px;">AGGREGATE RESULT MARK REPORT</span><br />
			   <span align="center" style=" font-size:14px; padding-top:0px;"><?php echo $aggregate_marks[0]['semester_name']; ?> (<?php echo $aggregate_marks[0]['degree_code']; ?>)</span><br /><br />			  
		</div>
        <div class="pdf_container">
		<?php $i=0;foreach($aggregate_marks as $key=>$student_marks){ ?>
		<div align="center" style="border:1px solid;margin-bottom:75px;">
            <table >
                <tr>
                    
					<td align="left" width="200px" style="vertical-align:top;font-weight:bold;"><?php echo $student_marks['user_unique_id']; ?></td>
                    
					<td align="left" style="vertical-align:top;font-weight:bold;"><?php echo $student_marks['first_name'].' '.$student_marks['last_name']; ?></td>                    
                </tr>				
            </table> 
			
            <table class="table" width="100%" style="border:solid 1px black; ">
                <tr>
                    <th>COURSE</th>
                    <th>CR.HRS</th>
					
                    <th>INT - MARK</th>
                    <th>TP - MARK</th>
                    <th>THE - MARK</th>
                    <th>TOTAL</th>
                     <th>PRAC - MARK</th>
                     <th>TOTAL</th>
					<th>G.P</th>
                    <th>C.P</th>
                    <th>RESULT</th>
					<!--<th  style="font-weight:bold;padding:2px;">Cradit Points</th>-->
                </tr>
				
                
				<?php //print_r($aggregate_marks[0]);exit;
			$total_cp='';
			$total_gp='';
			$totalcount=0;
			foreach($student_marks['subjectList'] as $subject_data){
				//p($subject_data); exit;
					if($subject_data['passfail_status'] == 'P'){
						$totalcount++;
				     $total_cp = $total_cp+$subject_data['creditval'];
					 $total_gp = $total_gp+$subject_data['gradeval'];
					}
					// p($total_cp); 
				?>
				<tr>	
					
					<td><?php if($subject_data['course_code']==''){ echo '';} else{ echo $subject_data['course_code'];}?></td>
			<td><?php echo $subject_data['theory_credit'].'+'.$subject_data['practicle_credit'];?></td>
			<td><?php if($subject_data['theory_internal']==''){echo '0.00';}else{echo number_format($subject_data['theory_internal'],2);}?></td>
			<td><?php if($subject_data['assignment_mark']==''){echo '0.00';}else{echo number_format($subject_data['assignment_mark'],2);}?></td>
			<td><?php if($subject_data['theory_external']==''){echo '0.00';}else{echo number_format($subject_data['theory_external'],2);}?></td>
			<td><?php if($subject_data['theory_internal']==''){echo '0.00';}else{echo number_format($subject_data['theory_internal']+$subject_data['assignment_mark']+$subject_data['theory_external'],2);}?></td>
			<td><?php if($subject_data['practical_internal']==''){echo '0.00';}else{echo number_format($subject_data['practical_internal'],2);}?></td>
			<td><?php if($subject_data['internal_sum']==''){echo '0.00';}else{echo number_format($subject_data['total_subject_marks'],2);}?></td>
			
			
			
			<td><?php if($subject_data['gradeval']==''){echo '-';}else{echo $subject_data['gradeval'];}?></td>
			<td><?php if($subject_data['creditval']=='' || $subject_data['theory_credit']==0){echo '-';}else{echo $subject_data['creditval'];}?></td>
			<td><?php if($subject_data['passfail_status']==''){echo 'N/A';}else{echo $subject_data['passfail_status'];}?></td>			
				</tr>				
<?php } 	?>
			<tr>
				<td colspan="8" rowspan="2">&nbsp;</td>
				<td colspan="2">Total CP=</td>
				<td><?php echo number_format($total_cp,2);?></td>
			</tr>
			<tr>
				
				<td colspan="2">GPA=</td>
				<td><?php echo number_format($total_gp/$totalcount,2);?></td>
			</tr>
            </table>
			</div>
<?php  $i++; if($i-1%2==1) echo "<pagebreak>";  }  ?>

    </div>
</body>
</html>
