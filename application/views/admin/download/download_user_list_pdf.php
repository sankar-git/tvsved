<?php //p($dummy_number_report); exit;?>

<!DOCTYPE html>
<html>
<body>
    <div >
       <table id="table" width="100%">
                <tr style="">
                    <th style="width:70px;">S.No</th>
                    
                    <th style="width:150px; font-size:14px; font-weight:bold;">First Name</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Last Name</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Email</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Contact Number</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Gender</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">DOB</th>
                     <th style="width:250px; font-size:14px; font-weight:bold;">Address Line1</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Address Line2</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Address Line3</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Address Line4</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Landline Number</th>
                    
                   <!-- <th style="width:250px; font-size:14px; font-weight:bold;">Religion</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Nationality</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Address</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Country</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">State</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Zip</th>
					
                   <th style="width:250px; font-size:14px; font-weight:bold;">Registration</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Class</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Section</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Roll</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Last School</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Last STD</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Marks Obtained</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Sports</th>-->
                    
                </tr>
				<?php $i=0; foreach($teachers as $teacherObj){
                  // print_r($dummydata); 
				$i++;?>
                <tr>
                    <td align="center"><?php echo $i;?></td>
                    <td><?php echo $teacherObj->user_unique_id;?></td>
                    <td><?php echo $teacherObj->first_name;?></td>
                    <td><?php echo $teacherObj->last_name;?></td>
                    <td><?php echo $teacherObj->email;?></td>
                    <td><?php echo $teacherObj->contact_number;?></td>
                    <td><?php echo $teacherObj->gender;?></td>
                    <td><?php echo $teacherObj->dob;?></td>
                    <td><?php echo $teacherObj->address_line1;?></td>
                    <td><?php echo $teacherObj->address_line2;?></td>
                    <td><?php echo $teacherObj->address_line3;?></td>
                    <td><?php echo $teacherObj->address_line4;?></td>
                    <td><?php echo $teacherObj->landline_number;?></td>
					
                   <!--  <td><?php echo $teacherObj->father_email;?></td>
                     <td><?php echo $teacherObj->religion;?></td>
                    <td><?php echo $teacherObj->nationality;?></td>
                    <td><?php echo $teacherObj->address;?></td>
                    <td><?php echo $teacherObj->country_id;?></td>
                    <td><?php echo $teacherObj->state_id;?></td>
                    <td><?php echo $teacherObj->zip_code;?></td>
					
                  <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $teacherObj->registration;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $teacherObj->class_name;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $teacherObj->section_id;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $teacherObj->roll;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $teacherObj->last_school;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $teacherObj->last_std;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $teacherObj->marks_obtained;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $teacherObj->sports_id;?></td>-->
                   
                </tr> 
			<?php } //exit; ?>
            </table>
</div>
   
	
</body>




</html>

