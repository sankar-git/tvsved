<?php //p($fail_student_list[0]['campus_name']); exit;?>

<!DOCTYPE html>
<html>
<head>
    <title>Result List</title>
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
                    font-size:14px;
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
                                        <div style="align:center;">
										&nbsp; 
                                            <p align="center" style=" font-size:14px; padding:5px 0px 0px 0px;">
											
											<?php 
											if(!empty($deflicit_student_list[0]['degree_name'])){
											echo $deflicit_student_list[0]['degree_name'];
											}else{echo '';}?></p>
											
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                         <p align="center" style=" font-size:14px;padding:10px 0px 0px 0px;">
										     <b>Deflicit List</b>
										 </p>
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table>

            <hr />
            <table>
                <tr>
                    <td align="left" style="width:400px;"><div style="font-size:14px;"><b>College :</b><?php 
											if(!empty($deflicit_student_list[0]['campus_code'])){
											echo $deflicit_student_list[0]['campus_code'];
											}else{echo '';}?></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                   
                    <td align="right" style="width:200px;"><div style="font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Batch :</b><?php 
											if(!empty($deflicit_student_list[0]['batch_name'])){
											echo $deflicit_student_list[0]['batch_name'];
											}else{echo '';}?></div></td>
                </tr>
                <tr>
                    <td align="left" style="width:400px;"><div style="font-size:14px;"><b>Degree :</b><?php 
											if(!empty($deflicit_student_list[0]['degree_name'])){
											echo $deflicit_student_list[0]['degree_name'];
											}else{echo '';}?></div></td>
                   
                    <td  align="right" style="width:200px;"><div style="font-size:14px;"><b>Semester :</b><?php 
											if(!empty($deflicit_student_list[0]['semester_name'])){
											echo $deflicit_student_list[0]['semester_name'];
											}else{echo '';}?></div></td>
                </tr>
            </table>


            <br /><br />
            <table id="table" width="100%">
                <tr style="">
                    <th style="width:70px;">S.No</th>
                    <th style="width:150px; font-size:14px; font-weight:bold;">Student Id</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Name</th>
                    <th>Result</th>
                </tr>
				<?php $i=0; foreach($deflicit_student_list as $result_val){
					
                 // p($result_val); 
				$i++;?>
                <tr>
                    <td align="center" style="font-size:14px; font-weight:bold;"><?php echo $i;?></td>
                    <td align="center" style="font-size:14px; font-weight:bold;"><?php echo $result_val['user_unique_id'];?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $result_val['first_name'].' '.$result_val['last_name'];?></td>
					
					 <td style =" font-size:12px; font-weight:bold; padding-left:20px;"><?php foreach($result_val['failedSubject'] as $failedSubject){
						//p($failedSubject); exit;
						?>
						<p><?php echo $failedSubject['course_code'].'('.$failedSubject['pass_condition1'].')';?></p>
						<?php } ?>
					</td>
					
                </tr> 
			<?php } ?>
            </table>
</div>
    </div>
</body>




</html>
