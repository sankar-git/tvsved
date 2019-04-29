<div align="center">
			   <p align="center" style="font-weight:bold; font-size:16px;">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY<br />
			   <span align="center" style=" font-size:14px; padding-top:0px;"><?php echo $students_attendance[0]->semester_name;?>&nbsp;<?php echo $students_attendance[0]->degree_code;?>&nbsp;Degree Course</span><br />
			   <span align="center" style=" font-size:14px; padding-top:0px;">(To be filled in the Examination Center)</span><br /><br />
			   <span align="center" style=" font-size:14px; padding-top:0px;">Attendance of Candidates who are present for the Annual Board Examination</span></p>
			</div>
			

            <table width="100%"; style="font-size:14px;">
				<tr>
                    <td align="left" width="20%" style="vertical-align:top;font-weight:bold;">Name Of College</td>
					<td align="left" width="20%" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->campus_code;?></td>					
					<td align="left" width="20%" style="vertical-align:top;font-weight:bold;">Year</td>
					<td align="left" width="20%" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->batch_name;?></td>                
                   
                </tr>
                <tr>
                    <td align="left" width="20%" style="vertical-align:top;font-weight:bold;">Date Of Examination</td>
					<td align="left" width="20%" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $date_of_exam;?></td>
                    <td align="left" width="20%" style="vertical-align:top;font-weight:bold;">Session</td>
					<td align="left" width="20%" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;F.N / A.N</td>
                    
                </tr>
				<tr>
                    <td align="left" width="25%" style="vertical-align:top;font-weight:bold;">Examination Subject</td>
					<td align="left" width="35%" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->course_title;?></td>
                    <td align="left" width="20%" style="vertical-align:top;font-weight:bold;">Degree</td>
					<td align="left" width="20%" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->degree_code;?></td>
                    
                </tr>
				
            </table>      