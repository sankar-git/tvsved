<?php //p($dummy_number_report); exit;?>
<!DOCTYPE html>
<html>
<head>
    <title>Dummy Report</title>
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
<?php  $this->load->view('admin/pdf/dummy_header');?><br />
    <div style=" font-family:sans-serif;" width="100%">
        <div id="dummy" width="100%">
            

            <table id="table" width="100%">
                <tr style="">
                    <th style="width:70px;">SL.No.</th>
                    <th style="width:150px; font-size:14px; font-weight:bold;">STUDENT ID. & DUMMY NUMBER</th>
                    <th style="width:200px; font-size:14px; font-weight:bold;">NAME</th>
                    <th>SUBJECTS</th>
                </tr>
				<?php $i=$dummy_number_report[0]['index'] ; ?>
				<?php foreach($dummy_number_report as $dummydata){
                  // print_r($dummydata); 
				$i++;?>
                <tr>
                    <td align="center" style=" font-size:14px; font-weight:bold;vertical-align:top"><?php echo $i;?></td>
                    <td align="center" style=" font-size:14px; font-weight:bold;vertical-align:top"><?php echo $dummydata['student_unique_id'];?>
					 <br /><!-- <p><?php  echo "&";?></p><p> --><?php  echo $dummydata['dummy_value'];?></p>
					</td>
                    <td align="left" style="font-size:14px; font-weight:bold;vertical-align:top"><?php echo $dummydata['first_name'].' '.$dummydata['last_name'];?></td>
                    <td align="left" style =" font-size:10px;">
						<table style="border:none; width:100%;">
                       <?php  foreach($dummydata['subjectList'] as $key=>$subjects) {
							 //p($subjects);
							 
							// if($key%2==0){ $first=true;  ?>
							<tr><td style="border:none"><?php echo $subjects['course_title'];?></td>
							
					   <?php }  ?>
						</table>
                    </td>
                </tr> 
			<?php } //exit; ?>
            </table>
</div>
    </div>
	
	<!-- <select class="form-control" name="course_id" id="course_id"><option value="">--Select Courses--</option><option value="15">FSQ 121-Food Chemistry Macronutrients</option><option value="16">FSQ 121-Microbiology</option><option value="17">FPE 121-Food Thermodynamics</option><option value="18">FPE 122-Fluid Mechanics</option><option value="19">FPE 123-Post-harvest  engineering</option><option value="20">BEG 121-Computer Programming and data structures</option><option value="21">BEG 122-Basic Electronics Engineering</option><option value="22">BSH 121-Engineering  Mathematics-II</option></select>-->
	
</body>




</html>
