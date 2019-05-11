<div align="center">
			   <p align="center" style="font-weight:bold; font-size:14px;">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p>
			   <p align="center" style=" font-size:14px; font-weight:bold;"><?php echo $students_attendance[0]->degree_code;?>&nbsp;SUBJECT WISE MARK ENTRY REPORT</p>
			</div>
			

            <table width="100%" style="font-size:14px;">
				<tr>
                    <td align="left" width="15%" style="vertical-align:top;font-weight:bold;">College</td>
					<td align="left" width="50%" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->campus_code;?></td>					
					<td align="right" width="15%" style="vertical-align:top;font-weight:bold;">Batch</td>
					<td align="left" width="20%" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->batch_name;?></td>                
                   
                </tr>
                <tr>
                    <td align="left" style="vertical-align:top;font-weight:bold;">Subject ID</td>
					<td align="left"  style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php if(empty($students_attendance[0]->course_subject_name)) echo $students_attendance[0]->course_code; else echo $students_attendance[0]->course_subject_name;?> (<?php echo $students_attendance[0]->theory_credit.'+'.$students_attendance[0]->practicle_credit;?>)</td>
					
                    <td align="right"  style="vertical-align:top;font-weight:bold;">Exam</td>
					<td align="left"  style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php if(in_array($campus_id,array(1,2,3,4))){?>Annual Board <?php }else{ ?>Semester<?php }?></td>
                    
					
                </tr>
				<tr>
                    <td align="left"  style="vertical-align:top;font-weight:bold;">Subject Name</td>
					<td align="left"  style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php if(empty($students_attendance[0]->course_subject_title)) echo $students_attendance[0]->course_title.'('.$students_attendance[0]->theory_credit.' + '.$students_attendance[0]->practicle_credit.')'; else echo $students_attendance[0]->course_subject_title;?></td>
					<?php if(in_array($campus_id,array(1,2,3,4))){?>
                    <td align="right"  style="vertical-align:top;font-weight:bold;">Annual Board</td>
					<td align="left"  style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;First</td>
					<?php }else{ ?>
                     <td align="right" style="vertical-align:top;font-weight:bold;">Semester</td>
					<td align="left"  style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->semester_name;?></td>
					<?php } ?>
                </tr>
				
            </table> 