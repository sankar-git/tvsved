<?php //p($exam_appearance);?>
<!DOCTYPE html>
<html>
<head>
   
    <style>
        #table {
            border: 1px solid black;
            border-collapse: collapse;
        }

            #table th {
                border: 1px solid black;
                border-collapse: collapse;
                height: 35px;
            }

                #table th td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }

            #table tr td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 12px;
            }
    </style>
</head>


<body>
<?php foreach($exam_appearance as $appearData){
	  
	?>
    <div style="font-family:ans-serif; " width="100%">
        <div id="dummy" width="100%">
            
			<table width="100%">
                <tr>
                    <td width="15%"><img height="100" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></td>
                    <td width="85%">
                        
					<table width="100%">
						<tr><td><p style=" font-size:16px; font-weight:bold;">TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></td></tr>
						<tr>
                                    <td align="center">
									<p align="center" style=" font-size:13px; font-weight:bold;"><?php echo $appearData['degree_name'];?></p>
                                       
                                    </td>
                                </tr>
								<tr>
                                    <td align="center">
                                         <p align="center" style=" font-size:13px;">
                                                APPLICATION FOR ADMISSION TO THE
                                                <b><?php echo $appearData['semester_name'];?> </b> EXAMINATION FOR <b><?php echo $appearData['batch_name'];?></b> TO BE HELD IN THE MONTH OF <b><?php  echo $month. ' '.$year;?> </b>
                                            </p>
                                    </td>
                                </tr>
					</table>
                        
                    </td>
                </tr>
            </table>
            <hr />
			<table width="100%" style="font-size:11px;">
				<tr>
					<td width="35%">1. Name : <b><?php  echo $appearData['first_name'].' '.$appearData['last_name'];?></td>
					<td width="65%" align="left">2. Sex: <b><?php  echo ucfirst($appearData['gender']);?></td>
				</tr>
				<tr>
					<td>3. I.D.No.: <b><?php  echo $appearData['student_unique_id'];?></td>
					<td align="left">4. Year of Admission:  <b><?php  echo $appearData['admission_year'];?></b></td>
				</tr>
				<tr>
					<td >5. College: <b><?php echo $appearData['campus_code'];?></b></td>
					<td align="left">6. Degree: <b><?php  echo $appearData['degree_name'];?></b></td>
				</tr>
				<tr>
					<td >7. Program: <b><?php echo $appearData['program_name'];?></b></td>
					<td align="left">8. Examination: <b><?php echo $appearData['semester_name'];?></b></td>
				</tr>
				<tr>
					<td width="100%" colspan="2">9. Details of Examination appearing for: <b><?php  echo $appearData['degree_name'];?></b></td>
				</tr>
			</table>

            <table id="table" width="100%" style="margin-top:5px;">
                <tr style="font-size:13px; font-weight:bold;">
                    <th style="width:70px;">S.No</th>
                    <th style="width:150px;">Course Code</th>
                    <th style="width:250px;">Course Title</th>
                    <th style="width:70px;">Credit Hours</th>
                    <th>Remarks</th>
                </tr>
                <?php 
				 $sum_theory=0;
				 $sum_practical=0;
				$i=0;foreach($appearData['subjectList'] as $courseData){$i++;
				             if($courseData['course_subject_id']!=22){
							  $sum_theory=$sum_theory+$courseData['theory_credit'];
							  $sum_practical=$sum_practical+$courseData['practical_credit'];
							  $sumTotal=$sum_theory+$sum_practical;
							 }
							 
							 //print_r($sumTotal.'('.$sum_theory.'+'.$sum_practical.')'); 
				
				?>
                <tr style=" font-size:12px; font-weight:bold;">
                    <td align="center"><?php echo $i;?></td>
                    <td align="center"><?php echo str_replace(",","<br/>",$courseData['course_code']);?></td>
                    <td style="padding-left:20px;"><?php echo str_replace(",","<br/>",$courseData['course_title']);?></td>
                    <td style="padding-left:20px;"><?php echo $courseData['theory_credit'].'+'.$courseData['practical_credit'];?></td>
                    <td style="padding-left:20px;">First Time</td>
                </tr>
				<?php } ?>
				
                <tr><td align="right" style="padding-right:80px;" colspan="5"><div>Total Credits Registered = <b><?php echo $sumTotal.'('.$sum_theory.'+'.$sum_practical.')'?></b></div></td></tr>
            </table>
			
            
            <div style="padding-left:10px;">
                <h6>I hereby declare that the particulars furnished by me in my application are correct.</h6>
            </div>
            <table width="100%" style="font-size:11px;">
                <tr>
                    <td><div style="padding-left:5px;">Station :</div></td>

                </tr>
                <tr>
                    <td><div style="padding-left:5px;">Date :</div></td>
                    <td align="right"><div style="padding-right:85px;">Signature of Candidate </div></td>
                </tr>
            </table>
            <br />
            
            <table width="100%" style="font-size:11px;">
                <tr>
                    <td><div style="padding-left:5px;">Details of Examination Fee remitted :</div></td>

                </tr>
                <tr>
                    <td><div style="padding-left:5px;">(i) Amount remitted (Late submission fees should be indicated separately) :</div></td>

                </tr>
                <tr>
                    <td><div style="padding-left:5px;">(ii) Date of remittance :</div></td>

                </tr>
                <tr>
                    <td><div style="padding-left:5px;">(iii) Receipt Number :</div></td>

                </tr>

            </table>
            
            <table width="100%" style="font-size:11px;">
                <tr>
                    <td align="right"><div style="padding-right:80px;">Signature of the Cashier</div></td>

                </tr>
            </table>
            
            <div>
                <h6 style="text-decoration:underline;text-align: center;">ENDORSEMENT OF THE DEAN</h6>
                <div>
                    <table style="font-size:11px;">
                        <tr>
                            <td colspan="3">
                                <div>
                                    1. The particulars furnished by the candidate in this application have been verified and found correct. The examination fee has been collected.
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div>
                                    2. Certified that his/her conduct has been satisfactory.
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div>
                                    3. The certificate of attendance and progress in respect of the applicant shall be sent at the end of the Academic year/semester(s) after the respective course work is over.
                                </div>
                            </td>
                        </tr>
                        
                        
                    </table>
                    <br /><br />
                    <table width="100%">
                        <tr style="font-size:12px; font-weight:bold;">
                            <td align="left"><div>Date :</div></td>
                            <td align="center"><div style="padding-left:250px;">Office Seal </div></td>
                            <td align="right"><div>Signature of the Dean/Head of Institution</div></td>
                        </tr>
                    </table>
                    
                    <h6 style="text-align: center; text-decoration:underline;">FOR USE IN THE UNIVERSITY OFFICE</h6>
                    <table width="100%">

                        <tr style="font-size:12px; font-weight:bold;">
                            <td align="left">
                                <div>
                                    Checked by
                                </div>
                            </td>
                            <td align="right">
                                <div>
                                    CONTROLLER OF EXAMINATIONS
                                </div>
                            </td>
                        </tr>

                    </table>
                    <hr style="border:solid 2px" />
                    <table width="100%">
                        <tr style="font-size:8px;">
                            <td>
                                <div style="font-size:8px;">
                                    Note&nbsp;:
                                </div>
                            </td>
                            <td colspan="2">
                                <div style="font-size:8px;">
                                    The hall ticket will be issued to the candidate only after the receipt of certificate of attendance and
                                    progress from the Dean/Head of the Institution, satisfying the conditions as laid down in the regulations.
                                </div>
                            </td>

                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div><pagebreak>
	<?php }  ?>
</body>




</html>
