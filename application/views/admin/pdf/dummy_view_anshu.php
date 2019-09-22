<?php //p($dummy_number_report); exit;?>

<!DOCTYPE html>
<html>
<head>
    <title>HTML Table Colspan/Rowspan</title>
    <style>
        #table {
            border: 1px solid black;
            border-collapse: collapse;
        }

            #table th {
                border: 2px solid black;
                border-collapse: collapse;
                height:35px;
            }

                #table th td {
                    border: 2px solid black;
                    border-collapse: collapse;
                }
                #table tr td {
                    border: 2px solid black;
                    border-collapse: collapse;
                    font-size:12px;
                }
    </style>
</head>


<body>
    <div style="padding:20px 20px 20px 20px; width:852px; font-family:Arial, Helvetica, sans-serif; border:solid 1px;">
        <div id="dummy">
            <table>
                <tr>
                    <td><div><span class="logo"><img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td> <div style="margin-left:30px; font-weight:bold; font-size:16px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div> </td></tr>
                                <tr>
                                    <td>
                                        <div> 
											<p align="center" style=" font-size:15px;"><?php echo $dummy_number_report[0]['degree_name'];?></p>
                                            <p align="center" style=" font-size:15px;"><?php echo $dummy_number_report[0]['semester_name'];?> Semester Dummy Number Report</p>
                                        </div>
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table>


            <table style="font-size:14px;">
                <tr>
                    <td><div><b>College :</b>&nbsp;&nbsp; <?php echo $dummy_number_report[0]['campus_name'];?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b>Batch &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>&nbsp;<?php echo $dummy_number_report[0]['batch_name'];?></div></td>
                </tr>
                <tr>
                    <td><div><b>Degree &nbsp;:</b>&nbsp;&nbsp;<?php echo $dummy_number_report[0]['degree_name'];?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b>Month & Year :</b>&nbsp;&nbsp;MAR-2016</div></td>
                </tr>
            </table>


            <br/><br/>
            <table id="table" width="100%" style="border:solid 2px black;">
                <tr style="border:solid 2px;">
                    <th style="width:70px;">S.No</th>
                    <th style="width:150px; font-size:14px; font-weight:bold;">Student Id</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Name</th>
                    <th>Subjects</th>
                </tr>
                <?php $i=0; foreach($dummy_number_report as $dummydata){
                  // print_r($dummydata); 
				$i++;?>
                <tr>
				    <td align="center" style=" font-size:14px; font-weight:bold;"><?php echo $i;?></td>
                    <td align="center" style=" font-size:14px; font-weight:bold;"><?php echo $dummydata['student_unique_id'];?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $dummydata['first_name'].' '.$dummydata['last_name'];?></td>
                    <td style =" font-size:12px; font-weight:bold; padding-left:20px;">
                          <?php  foreach($dummydata['subjectList'] as $subjects) {
							 p($subjects);
							  ?>
							<p><?php echo $subjects['course_code'];?></p>
							
                         <?php } ?>
                    </td>
					
                </tr>
               <?php } exit; ?>
            </table>

        </div>
    </div>
</body>




</html>
