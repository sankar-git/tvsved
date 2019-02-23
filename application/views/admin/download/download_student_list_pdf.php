<?php //p($dummy_number_report); exit;?>

<!DOCTYPE html>
<html>
<body>
    <div >
       <table id="table" width="100%">
                <tr style="">
                    <th style="width:70px;">S.No</th>
                    <th style="width:150px; font-size:14px; font-weight:bold;">Student Unique Id</th>
                    <th style="width:150px; font-size:14px; font-weight:bold;">First Name</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Last Name</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Email</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Contact Number</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Gender</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">DOB</th>
                     <!--<th style="width:250px; font-size:14px; font-weight:bold;">Parent Name</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Mother Name</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Occupation</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Father Contact</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Alternate Contact</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Father Email</th>
                    <th style="width:250px; font-size:14px; font-weight:bold;">Religion</th>
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
				<?php $i=0; foreach($students as $studentObj){
                  // print_r($dummydata); 
				$i++;?>
                <tr>
                    <td align="center"><?php echo $i;?></td>
                    <td><?php echo $studentObj->user_unique_id;?></td>
                    <td><?php echo $studentObj->first_name;?></td>
                    <td><?php echo $studentObj->last_name;?></td>
                    <td><?php echo $studentObj->email;?></td>
                    <td><?php echo $studentObj->contact_number;?></td>
                    <td><?php echo $studentObj->gender;?></td>
                    <td><?php echo $studentObj->dob;?></td>
                    <!--  <td><?php echo $studentObj->parent_name;?></td>
                    <td><?php echo $studentObj->mother_name;?></td>
                    <td><?php echo $studentObj->occupation;?></td>
                    <td><?php echo $studentObj->father_contact;?></td>
                    <td><?php echo $studentObj->alternate_contact;?></td>
                    <td><?php echo $studentObj->father_email;?></td>
                    <td><?php echo $studentObj->religion;?></td>
                    <td><?php echo $studentObj->nationality;?></td>
                    <td><?php echo $studentObj->address;?></td>
                    <td><?php echo $studentObj->country_id;?></td>
                    <td><?php echo $studentObj->state_id;?></td>
                    <td><?php echo $studentObj->zip_code;?></td>
					
                  <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $studentObj->registration;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $studentObj->class_name;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $studentObj->section_id;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $studentObj->roll;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $studentObj->last_school;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $studentObj->last_std;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $studentObj->marks_obtained;?></td>
                    <td style=" font-size:14px; font-weight:bold; padding-left:20px;"><?php echo $studentObj->sports_id;?></td>-->
                   
                </tr> 
			<?php } //exit; ?>
            </table>
</div>
   
	
</body>




</html>

