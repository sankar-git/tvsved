<table>
    <tr>
        <td><div><span class="logo"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td><br />
        <td>
            <div>
                <table>
                    <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:16px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                    <tr>
                        <td align="center">
                                <p align="center" style=" font-size:14px;"><b><?php echo $students_attendance[0]->degree_code;?></b></p><br />
                                 <p align="center" style=" font-size:14px; padding:10px 0px 0px 0px;"><b>SUBJECT WISE MARK ENTRY REPORT</b>
								 </p>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
<hr />
<!-- <div align="center">
			   <p align="center" style="font-weight:bold; font-size:14px;">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p>
			   <p align="center" style=" font-size:14px; font-weight:bold;"><?php echo $students_attendance[0]->degree_code;?>&nbsp;SUBJECT WISE MARK ENTRY REPORT</p>
			</div> -->
			

            <table width="100%" style="font-size:14px;">
				<tr>
                    <td align="left" width="15%" style="vertical-align:top;font-weight:bold;">College</td>
					<td align="left" width="50%" style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->campus_name;?></td>					
					<td align="right" width="15%" style="vertical-align:top;font-weight:bold;">Batch</td>
					<td align="left" width="20%" style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->batch_name;?></td>                
                   
                </tr>
                <tr>
                    <td align="left" style="vertical-align:top;font-weight:bold;">Examination</td>
					<td align="left"  style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->semester_name.'-'; if($exam_type == 2) echo "Cap";else echo "Annual";?><!-- <?php if(empty($students_attendance[0]->course_subject_name)) echo $students_attendance[0]->course_code; else echo $students_attendance[0]->course_subject_name;?> (<?php echo $students_attendance[0]->theory_credit.'+'.$students_attendance[0]->practicle_credit;?>) --></td>
					
                    <td align="right"  style="vertical-align:top;font-weight:bold;">Month & Year</td>
					<td align="left"  style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $month.' '.$year;?></td>
                    
					
                </tr>
				<tr>
                    <td align="left"  style="vertical-align:top;font-weight:bold;">Subject</td>
					<td align="left"  style="vertical-align:top;">:&nbsp;&nbsp;<?php if(empty($students_attendance[0]->course_subject_title)) echo $students_attendance[0]->course_title.'('.$students_attendance[0]->theory_credit.' + '.$students_attendance[0]->practicle_credit.')'; else echo $students_attendance[0]->course_subject_title;?></td>
					
                    <td align="right"  style="vertical-align:top;font-weight:bold;">Credit Hours</td>
					<td align="left"  style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->theory_credit.'+'.$students_attendance[0]->practicle_credit;?></td>
					
                </tr>
				
            </table> 