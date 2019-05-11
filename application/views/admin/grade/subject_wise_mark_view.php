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
<?php $this->load->view('admin/grade/subject_wise_header');?>
    <div style="padding:10px 10px 10px 10px; width:852px; font-family:Arial, Helvetica, sans-serif;">
        <div id="dummy">
			         
            <table id="table" width="100%">
                
				<?php if(in_array($degree,array(5,6))){?>
				<tr style=""> <th rowspan="3" style="padding:2px;">I.D.No.</th>
				<th rowspan="3" style="padding:2px;">Dummy No</th>
				 <th rowspan="3" style="padding:2px;">STUDENT NAME</th>
				 <th <?php if($students_attendance[0]->practicle_credit >0 && $students_attendance[0]->theory_credit >0){?> colspan="3" <?php }else{ ?> colspan="2" <?php }?> scope="colgroup" style="padding:2px;">INTERNAL</th>
                 <th  style="padding:2px;">EXTERNAL</th>
				</tr>
				<tr>
                    
					<?php if($students_attendance[0]->theory_credit > 0){ ?>
                    <th scope="col">THEORY</th>
					<?php } ?>
					<th scope="col">ASSIGNMENT</th>
					<?php if($students_attendance[0]->practicle_credit > 0){ ?>
                    <th scope="col">PRACTICAL</th>
                    <?php } ?>
					
					
					<th scope="col"  style="padding:2px;">THEORY</th>
				</tr>
				<tr>
                    <?php if($students_attendance[0]->practicle_credit == 0){?>
                    <th scope="col">(Max.40)</th>
                    <th scope="col">(Max.10)</th>
					<?php }else if($students_attendance[0]->theory_credit == 0){?>
					<th scope="col">(Max.10)</th>
					<th scope="col">(Max.40)</th>
					<?php }else{ ?>
                    <th scope="col">(Max.30)</th>
                    <th scope="col">(Max.5)</th>
                    <th scope="col">(Max.15)</th>
					<?php } ?>
					<th scope="col"  style="padding:2px;">(Max.50)</th>
				</tr>
				<?php }else{?>
				<tr style="">
                    <th rowspan="3" style="padding:2px;">S.No.</th>
                    <th rowspan="3" style="padding:2px;">Dummy No</th>
                    <th rowspan="3" style="padding:2px;">ID No</th>
                    <th colspan="3" scope="colgroup" style="padding:2px;">Internal Assessment</th>
                    <th colspan="<?php echo $course_count;?>" scope="colgroup" style="padding:2px;">Theory</th>
                    <th colspan="<?php echo $course_count;?>" scope="colgroup" style="padding:2px;">Practical</th>
                </tr>
				<tr>
                    <th scope="col" style="padding:2px;">First</th>
                    <th scope="col"  style="padding:2px;">Second</th>
					<th scope="col"  style="padding:2px;">Third</th>
					<?php for($i=0;$i<$course_count;$i++){?>
                    <th scope="col"  style="padding:2px;">Paper-<?php echo $numeralCodes[$i];?></th>
					<?php } ?>
                    <?php for($i=0;$i<$course_count;$i++){?>
                    <th scope="col"  style="padding:2px;">Paper-<?php echo $numeralCodes[$i];?></th>
					<?php } ?>
                </tr>
				 <tr>
                    <th scope="col"  style="padding:2px;">(10)</th>
                    <th scope="col" style="padding:2px;">(10)</th>
					<th scope="col" style="padding:2px;">(10)</th>
					<?php for($i=0;$i<$course_count;$i++){?>
                    <th scope="col"  style="padding:2px;">(100)</th>
					<?php } ?>
                   <?php for($i=0;$i<$course_count;$i++){?>
                    <th scope="col"  style="padding:2px;">(60)</th>
					<?php } ?>
                </tr>
				<?php } ?>
				
				<?php $i=0; foreach($students_attendance as $reg_students){ //print_r($reg_students);exit;
                  $mark = get_student_marks($reg_students->student_id,$semester_id,$course_id);//print_r($mark );exit;
				$i++;?>
                <tr>
				<?php if(in_array($campus_id,array(5,6))){?>
				
				<td align="center"  style=" font-size:14px; "><?php echo $reg_students->user_unique_id;?></td>
                    <td align="center" style="font-size:14px;"><?php echo $reg_students->dummy_value;?></td>
                    <td align="center" style="font-size:14px;"><?php echo $reg_students->first_name.' '.$reg_students->last_name;?></td>
					<td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
					<?php if($students_attendance[0]->practicle_credit >0 && $students_attendance[0]->theory_credit >0){?>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
					<?php }?>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
				<?php }else{?>
                    <td align="center" style="font-size:12px;"><?php echo $i;?></td>
				
                    <td align="center" style="font-size:14px;"><?php echo $reg_students->dummy_value;?></td>
					<td align="center"  style=" font-size:14px; "><?php echo $reg_students->user_unique_id;?></td>
					<?php if(in_array($degree,array(5,6))){?>
					 <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"><?php round_two_digit($mark[0]->theory_internal1/4,2);?></p></td>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
					<?php for($k=0;$k<$course_count;$k++){?>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
					<?php } ?>
					<?php for($j=0;$j<$course_count;$j++){?>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
					<?php }  ?>
					<?php }else{ ?>
                    <td style ="font-size:12px;" align="center"><p align="center" style=" font-size:14px;"><?php  if(isset($mark[0]->theory_internal1)) echo round_two_digit($mark[0]->theory_internal1/4,2);?></p></td>
                    <td style ="font-size:12px;" align="center"><p align="center" style=" font-size:14px;"><?php if(isset($mark[0]->theory_internal2)) echo round_two_digit($mark[0]->theory_internal2/4,2);?></p></td>
                    <td style ="font-size:12px;" align="center"><p align="center" style=" font-size:14px;"><?php if(isset($mark[0]->theory_internal3)) echo round_two_digit($mark[0]->theory_internal3/4,2);?></p></td>
					<?php for($k=0;$k<$course_count;$k++){ $var = 'theory_external'.($k+1);?>
                    <td style ="font-size:12px;" align="center"><p align="center" style=" font-size:14px;"><?php if(isset($mark[0]->{$var})) echo $mark[0]->{$var};?></p></td>
					<?php } ?>
					<?php for($j=0;$j<$course_count;$j++){ $var = 'theory_paper'.($j+1);?>
                    <td style ="font-size:12px;" align="center"><p align="center" style=" font-size:14px;"><?php if(isset($mark[0]->{$var})) echo$mark[0]->{$var};?></p></td>
					<?php } }  ?>
				<?php }?>
                </tr> 
			<?php } //exit; ?>
            </table>
</div>
    </div>
</body>




</html>
