<?php //p($registered_students); exit;?>

<!DOCTYPE html>
<html>
<head>
    <title>REG Students</title>
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
                                    <td align="center">
                                            <p align="center" style=" font-size:14px;"><?php echo $registered_students[0]->degree_code;?></p>
											
                                            <p align="center" style=" font-size:14px; padding:10px 0px 0px 0px;">
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</p>
                                    </td>
									
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table>

            <hr />
            <table width="100%" style="font-size:12px;">
                <tr>
                    <td width="10%"><b>College</b></td>
					<td width="40%"> : <?php echo $registered_students[0]->campus_name;?></td>
                    <td width="10%"><b>Subject</b></td>
					<td width="40%"> : <?php echo $registered_students[0]->course_title;?></td>
                </tr>
                <tr>
                   <td><b >Batch</b></td>
				   <td> : <?php echo $registered_students[0]->batch_name;?></td>
                    <td><b>Semester</b></td>
					<td> : <?php echo $registered_students[0]->semester_name;?></td>
                </tr>
            </table>


            <br /><br />
            <table id="table" width="100%">
                <tr style="">
                    <th style="width:70px;">S.No</th>
                   
                    <th style="width:250px; font-size:14px; font-weight:bold;">Name</th>
					 <th style="width:150px; font-size:14px; font-weight:bold;">Student Id</th>
                    <th>Registered /<p>Not Registered</p></th>
                </tr>
				<?php $i=0; foreach($registered_students as $reg_students){
                  // print_r($dummydata); 
				$i++;?>
                <tr>
                    <td align="center" style=" font-size:14px;"> <p align="center" style=" font-size:14px;"><?php echo $i;?></p></td>
					<td style=" font-size:14px; padding-left:20px;"><p align="center" style=" font-size:14px;"><?php echo $reg_students->first_name.' '.$reg_students->last_name;?></p></td>
                    <td align="center" style=" font-size:14px;"><p align="center" style=" font-size:14px;"><?php echo $reg_students->user_unique_id;?></p></br></td>
                    <td style ="font-size:12px;  padding-left:20px;"><p align="center" style=" font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "Registered";?> </p></td>
                </tr> 
			<?php } //exit; ?>
            </table>
</div>
    </div>
</body>




</html>
