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
            <table>
                <tr>
                    <td><div><span class="logo"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><p style="margin-left:30px; font-weight:bold; font-size:16px;">TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></td></tr>
                                <tr>
                                    <td align="center">
                                        <div style="align:center;">
										&nbsp; 
                                            <p align="center" style=" font-size:14px;  font-weight:bold;">
											<?php 
											if(!empty($pass_fail_list[0]['degree_name'])){
											echo $pass_fail_list[0]['degree_name'];
											}else{echo '';}?>
											</p>
											
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                         <p align="center" style=" font-size:14px;padding:10px 0px 0px 0px;">
										     <b>Subjectwise List</b>
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
                    <td width="33%" align="left" ><b>College :</b><?php 
					                         if(!empty($pass_fail_list[0]['campus_name']))
											 { echo $pass_fail_list[0]['campus_name'];}
										     else{
												 echo '';
											 }
										 ?></td>
                    <td align="left" ><b>Degree :</b><?php 
					if(!empty($pass_fail_list[0]['degree_name']))
					{ 
					    echo $pass_fail_list[0]['degree_name'];
					}
					else{
						echo '';
					}
					?></td>
                    
                </tr>
                <tr>
                   <td ><b>Batch :</b><?php echo $pass_fail_list[0]['batch_name'];?></td>
                   
                    <td  ><b>Semester :</b><?php 
                     if($pass_fail_list[0]['semester_name']){
					echo $pass_fail_list[0]['semester_name'];
					 }
					 else{
						echo ''; 
					 }
					 ?></td>
                </tr>
            </table>
            <br /><br /> 
			
            <table id="table" width="100%" >
                <tr>
                    <th rowspan="1">S.NO.</th>
                    <th rowspan="1">ID NO.</th>
                    <th rowspan="1">NAME</th>
					<?php foreach($pass_fail_list[0]['subjectList'] as $subjectVal){  ?>
                    <th rowspan="1" ><?php echo $subjectVal['course_code'];?></th>
                    <?php }?>
                    <th rowspan="1">RESULT</th>
                </tr>
              <?php $i=0;foreach($pass_fail_list as $student_val){
				 $i++;
                 ?>
                <tr>
				  
						
                    <td><?php echo $i;?></td>
					<td><?php echo $student_val['user_unique_id'];?></td>
					<td><?php echo $student_val['first_name'];?></td>
                   <?php $res_status='';
				         $resultStatus=array();
 				         foreach($student_val['subjectList'] as $subject_status){
					         array_push($resultStatus,$subject_status['passfail_status']);
							 //p($resultStatus);
							 
					   ?>
                    <td><?php echo $subject_status['passfail_status'];?></td>
				   <?php } ?>
                    <td><?php if(in_array('F',$resultStatus)) {echo 'FAIL';} else{ echo 'PASS';}?></td>
					
                </tr>
			  <?php }     ?>
				 
			</table>
           
        </div>
    </div>
 
</body>




</html>
