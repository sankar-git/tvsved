<?php //p($fail_student_list[0]['campus_name']); exit;?>

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
                    font-size:14px;
                }
    </style>
</head>


<body>
    <div style="padding:10px 10px 10px 10px; width:852px; font-family:Arial, Helvetica, sans-serif;">
        <div id="dummy">
		 <table  width="100%">
                <tr>
                    <td  width="15%"><img height="100" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></td>
                    <td width="85%">
                        
					<table width="100%">
                                <tr><td><p style=" font-size:16px; font-weight:bold;">TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></td></tr>
                                <tr>
                                    <td align="center">
									 <p align="center" style=" font-size:13px; font-weight:bold;"><?php echo $dummy_number_report[0]['degree_name'];?></p>
                                        <div style="align:center;">
										&nbsp; 
                                            <p align="center" style=" font-size:13px; font-weight:bold;">
											
											<?php 
                                             if(!empty($deflicit_student_list[0]['degree_name']))
											 {
											   echo $deflicit_student_list[0]['degree_name'];
											 }
											 else {
												 echo '';
											 }
											  ?>
											
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                         <p align="center" style=" font-size:13px;padding:10px 0px 0px 0px;">
										
										       <b>Deflicit List</b>
                                    </td>
                                </tr>

                            </table>
                        


                    </td>
                </tr>
            </table>
			


            <table width="100%" style="font-size:12px;">
                <tr>
                    <td width="33%" align="left" ><b>College :</b><?php 
					                         if(!empty($deflicit_student_list[0]['campus_name']))
											 { echo $deflicit_student_list[0]['campus_name'];}
										     else{
												 echo '';
											 }
										 ?></td>
                    <td align="left" ><b>Degree :</b><?php 
					if(!empty($deflicit_student_list[0]['degree_name']))
					{ 
					    echo $deflicit_student_list[0]['degree_name'];
					}
					else{
						echo '';
					}
					?></td>
                    
                </tr>
                <tr>
                   <td ><b>Batch :</b><?php echo $deflicit_student_list[0]['batch_name'];?></td>
                   
                    <td  ><b>Semester :</b><?php 
                     if($deflicit_student_list[0]['semester_name']){
					echo $deflicit_student_list[0]['semester_name'];
					 }
					 else{
						echo ''; 
					 }
					 ?></td>
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
                    <td align="center" style=" font-size:14px; font-weight:bold;"><?php echo $i;?></td>
                    <td align="center" style=" font-size:14px; font-weight:bold;"><?php echo $result_val['user_unique_id'];?></td>
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
