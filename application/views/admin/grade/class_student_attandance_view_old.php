<?php //p($registered_students); exit;?>

<!DOCTYPE html>
<html>
<head>
    <title>HTML Table Colspan/Rowspan</title>
    <style>
        #table {
            border: 1px solid;
            border-collapse: collapse;
        }

            #table th {
                border: 1px solid;
                border-collapse: collapse;
                height:35px;
            }

                #table th td {
                    border: 1px solid;
                    border-collapse: collapse;
                }
                #table tr td {
                    border: 1px solid;
                    border-collapse: collapse;
                    font-size:12px;
                }
    </style>
</head>


<body>
    <div style="padding:10px 10px 10px 10px; width:852px; font-family:Arial, Helvetica, sans-serif;">
        <div id="dummy">
            <table>
                <tr>
                    <td><div><span class="logo"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:16px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td>
									<div style="margin-left:150px;">
										   &nbsp;
                                            <p align="center" style=" font-size:14px;">
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											(To be filled in the Examination Center)</p>
									</div>
                                        <div style="margin-left:150px;">
										   &nbsp;
                                            <p align="center" style=" font-size:14px;">
											&nbsp;&nbsp;
											Attendance of Candidates who are present for the Annual Board Examination</p>
											
                                            <p align="center" style=" font-size:14px; padding:10px 0px 0px 0px;">
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</p>
                                        </div>
                                    </td>
									
                                </tr>

                            </table>
                        </div>
                  </td>
                </tr>
            </table>
          <hr />
            <table style="font-size:14px;">
                <tr>
                    <td><div style="font-size:11px;"><b style="font-size:13px;">Name Of College :</b>&nbsp;&nbsp;&nbsp; <?php echo $students_attendance[0]->campus_code;?></div></td>
                   <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><div style="font-size:11px;"><b style="font-size:13px;">Batch :</b>&nbsp;&nbsp;&nbsp; <?php echo $students_attendance[0]->batch_name;?></div></td>
                </tr>
                <tr>
                    <td><div style="font-size:11px;"><b style="font-size:13px;">Date Of Examination :</b>&nbsp;&nbsp;&nbsp;</div></td>
                   <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    <td><div style="font-size:11px;"><b style="font-size:13px;"></b>&nbsp;&nbsp;&nbsp; </div></td>
                </tr>
				 <tr>
                    <td><div style="font-size:11px;"><b style="font-size:13px;">Examination Subject:</b>&nbsp;&nbsp;&nbsp; <?php echo $students_attendance[0]->course_title;?></div></td>
                   <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    <td><div style="font-size:11px;"><b style="font-size:13px;">Session:</b>&nbsp;&nbsp;&nbsp; F.N / A.N</div></td>
                </tr>
				
            </table>


            <br /><br />
            <table id="table" width="100%">
                <tr style="">
                     <th style="width:70px;">S.No</th>
                     <th style="width:150px; font-size:14px; font-weight:bold;">Student Id</th>
					 <th style="width:250px; font-size:14px; font-weight:bold;">Name</th>
                     <th>Signature of the Student</p></th>
                </tr>
				<?php $i=0; foreach($students_attendance as $reg_students){
                  
				$i++;?>
                <tr>
                    <td align="center" style="font-size:14px;"> <p align="center" style=" font-size:14px;"><?php echo $i;?></p></td>
				
                    <td align="center" style="font-size:14px;"><p align="center" style=" font-size:14px;"><?php echo $reg_students->user_unique_id;?></p></br></td>
					<td style=" font-size:14px; padding-left:20px;"><p align="center" style=" font-size:14px;"><?php echo $reg_students->first_name.' '.$reg_students->last_name;?></p></td>
                    <td style =" font-size:12px;  padding-left:20px;"><p align="center" style=" font-size:14px;"></p></td>
                </tr> 
			<?php } //exit; ?>
            </table>
</div>
    </div>
</body>




</html>
