<?php //p($registered_students); exit;?>

<!DOCTYPE html>
<html>
<head>
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
					height: 31px;
                }
    </style>
</head>


<body>
    <div style="padding:10px 10px 10px 10px; width:100%; font-family:Arial, Helvetica, sans-serif;">
        <div id="dummy">
            <table>
                <tr>
                    <td><div><span class="logo"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:16px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr><br />
                                <tr>
                                    <td align="center">
                                            <p align="center" style=" font-size:14px;"><b><?php echo $registered_students[0]->degree_code;?></b></p><br />
                                            <p align="center" style=" font-size:14px; padding:10px 0px 0px 0px;"><b>
											STUDENT REGISTRATION</b>
											</p>
                                    </td>
									<!-- <td align="center">
                                            <p></p>                           
                                    </td> -->
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table>

            
            <table width="100%" style="font-size:12px;">
                <tr>
                    <td><b>College</b></td>
					<td> : <?php echo $registered_students[0]->campus_name;?></td>
                    <td><b>Batch</b></td>
                    <td> : <?php echo $registered_students[0]->batch_name;?></td>
                </tr>
                <tr>
                    <td><b>Examination</b></td>
                    <td > : <?php echo $registered_students[0]->semester_name; if($exam_type == 1) echo "-Annual"; if($exam_type == 2) echo "-CAP";?></td>
                    <td><b>Month & Year</b></td>
                    <td> : <?php if(!empty($date_of_exam)){ $doe = explode("-", $date_of_exam); $mon_nam = gregoriantojd($doe[1],$doe[0],$doe[2]);
                    echo jdmonthname($mon_nam,0).' '.$doe[2];}else{echo "Select Date of Exam";}?></td>
                </tr>
                <tr>
                   <td><b>Subject</b></td>
				   <td> : <?php echo $registered_students[0]->course_title;?></td>
                    <td><b>Credit Hours</b></td>
					<td> : <?php echo $registered_students[0]->theory_credit.'+'.$registered_students[0]->practicle_credit;?></td>
                </tr>
            </table>


            <br /><br />
            <table id="table" width="100%">
                <tr style="">
                    <th style="width:70px;">S.No</th>
                    <th style="width:150px; font-size:14px; font-weight:bold;">Student Id</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Name</th>
					 <th style="width:150px; font-size:14px; font-weight:bold;">Date of Registration</th>
                    <th>Remarks</th>
                </tr>
				<?php $i=0; foreach($registered_students as $reg_students){
                  // print_r($dummydata); 
				$i++;?>
                <tr>
                    <td align="center" style=" font-size:12px;"> <p align="center" style=" font-size:12px;"><?php echo $i;?></p></td>
                    <td align="center" style=" font-size:12px;"><p align="center" style=" font-size:12px;"><?php echo $reg_students->user_unique_id;?></p><br /></td>
					<td style=" font-size:12px; padding-left:20px;"><p align="center" style=" font-size:12px;"><?php echo $reg_students->first_name.' '.$reg_students->last_name;?></p></td>
                    <td align="center" style=" font-size:12px;"><p align="center" style=" font-size:12px;"><?php echo $date_of_exam;?></p></td>
                    <td style ="font-size:12px;padding-left:10px; padding-right:10px;text-align: center;"><p align="center" style=" font-size:12px;"><?php echo "Registered";?> </p></td>
                </tr> 
			<?php } //exit; ?>
            </table>
        </div><br /><br /><br /><br />
        <div>
            <table width="100%">
                        <tr style="font-size:12px; font-weight:bold;">
                            <td width="20%" align="center"><div>Signature Of<br />Course Teacher</div></td>
                            <td width="20%" align="center"><div>Signature Of<br />H.O.D </div></td>
                            <td width="20%" align="center"><div>Signature Of<br /> Dean </div></td>
                            <td width="20%" align="center"><div>Signature of<br />Registar</div></td>
                        </tr>
                    </table>
        </div>

    </div>
</body>




</html>
