<table>
                <tr>
                    <td><div><span class="logo"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td><br />
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:16px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td align="center">
                                            <p align="center" style=" font-size:14px;"><b><?php echo $students_attendance[0]->degree_code;?><br />(To be filled in the Examination Centre)
                                            </b></p><br />
                                            <p align="center" style=" font-size:14px; padding:10px 0px 0px 0px;"><b>
											ATTENDANCE</b>
											</p>
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table><hr>
<!-- <div align="center">
			   <p align="center" style="font-weight:bold; font-size:16px;">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY<br />
			   <span align="center" style=" font-size:14px; padding-top:0px;"><?php echo $students_attendance[0]->semester_name;?>&nbsp;<?php echo $students_attendance[0]->degree_code;?>&nbsp;Degree Course</span><br />
			   <span align="center" style=" font-size:14px; padding-top:0px;">(To be filled in the Examination Center)</span><br /><br />
			   <span align="center" style=" font-size:14px; padding-top:0px;">Attendance of Candidates who are present for the Annual Board Examination</span></p>
			</div> -->
			

            <table width="100%"; style="font-size:13px;">
				<tr>
                    <td align="left" width="10%" style="vertical-align:top;font-weight:bold;">College</td>
					<td align="left" width="25%" style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->campus_name;?></td>					
					<td align="left" width="10%" style="vertical-align:top;font-weight:bold;">Batch</td>
					<td align="left" width="20%" style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->batch_name;?></td>                
                   
                </tr>
                <tr>
                	<td align="left" width="10%" style="vertical-align:top;font-weight:bold;">Examination</td>
					<td align="left" width="20%" style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->semester_name;  if($exam_type == 1) echo "-Annual"; if($exam_type == 2) echo "-Cap";?></td>
					 <td align="left" width="10%" style="vertical-align:top;font-weight:bold;">Subject</td>
					<td align="left" width="20%" style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->course_title;?></td>
                    
                    <!-- <td align="left" width="20%" style="vertical-align:top;font-weight:bold;">Session</td>
					<td align="left" width="20%" style="vertical-align:top;">:&nbsp;&nbsp;F.N / A.N</td> -->
                    
                </tr>
				<tr>
                    <td align="left" width="10%" style="vertical-align:top;font-weight:bold;">Date of Examination</td>
					<td align="left" width="20%" style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $date_of_exam;?></td>
					<td align="left" width="10%" style="vertical-align:top;font-weight:bold;">Session</td>
					<td align="left" width="20%" style="vertical-align:top;">:&nbsp;&nbsp;F.N / A.N</td>
                    <!-- <td align="left" width="10%" style="vertical-align:top;font-weight:bold;">Degree</td>
					<td align="left" width="20%" style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $students_attendance[0]->degree_code;?></td> -->
                    
                </tr>
				
            </table>      