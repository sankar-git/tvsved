<?php //p($result_list); exit;?>

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
    <div style=" width:852px; font-family:Arial, Helvetica, sans-serif;">
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
											
											<?php echo $result_list[0]['degree_name'];?></p>
											
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                         <p align="center" style=" font-size:14px;padding:10px 0px 0px 0px;">
										     <b>Result</b>
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
                    <td width="33%" align="left"><b>College: </b><?php 
											if(!empty($result_list[0]['campus_name'])){
											echo $result_list[0]['campus_name'];
											}else{echo '';}?></td>
                   <td ><b>Degree: </b><?php 
											if(!empty($result_list[0]['degree_name'])){
											echo $result_list[0]['degree_name'];
											}else{echo '';}?></td>
                    
                </tr>
                <tr>
                    <td  ><b>Batch: </b><?php 
											if(!empty($result_list[0]['batch_name'])){
											echo $result_list[0]['batch_name'];
											}else{echo '';}?></td>
                   
                    <td   ><b>Semester: </b><?php 
											if(!empty($result_list[0]['semester_name'])){
											echo $result_list[0]['semester_name'];
											}else{echo '';}?></td>
                </tr>
            </table>
           

            <br /><br />
            <table id="table" width="100%">
                <tr style="">
                    <th style="width:70px;">S.No</th>
                    <th style="width:150px; font-size:14px; ">Student Id</th>
                    <th style="width:250px; font-size:14px;">Name</th>
                    <th>Result</th>
                </tr>
				<?php $i=0; foreach($result_list as $result_val){
					
                //  p($result_val); 
				$i++;?>
                <tr>
                    <td align="center" style=" font-size:14px; "><?php echo $i;?></td>
                    <td align="center" style=" font-size:14px; "><?php echo $result_val['user_unique_id'];?></td>
                    <td align="center" style=" font-size:14px; "><?php echo $result_val['first_name'].' '.$result_val['last_name'];?></td>
					 <td style =" font-size:12px; ">
					<?php $grandSum='';
					$valueArr=array();
					foreach($result_val['subjectList'] as $subjectData)
					      {
							 //p($subjectData);
							 $grandSum=$grandSum+$subjectData['total_sum'];
							// p($subjectData['student_id']);
							// p($subjectData['course_id']);
							 //p($subjectData['course_code']);
							 //p($subjectData['results_status']);
						     //p($subjectData['total_sum']); 
							 //p($grandSum);
							  $grandpercent=($grandSum/1200)*100;
							 $roundGrandPercent= number_format($grandpercent,2);
							 
							 if($subjectData['passfail_status']=='P')
							 {
								 $values='Passed In   '.'-'.$subjectData['course_code'];
								// p($values);
								//array_push($valueArr,$values);
								echo '<p>'.$values.'</p>';
								
							 }
							  if($subjectData['passfail_status']=='F')
							 {
								 $values='Failed In   '.'-'.$subjectData['course_code'];
								echo '<p>'.$values.'</p>';
								//array_push($valueArr,$values);
								
							 }
							
					      }
					?>
				
					</td>
                </tr> 
			<?php } ?>
            </table>
</div>
    </div>
</body>




</html>
