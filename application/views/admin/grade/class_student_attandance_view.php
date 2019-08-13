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
<?php $this->load->view('admin/grade/attendance_header');?>
    <div style="padding:10px 10px 10px 10px; width:100%; font-family:Arial, Helvetica, sans-serif;">
        <div id="dummy">
			    
            <table id="table" width="100%">
                <tr style="">
                     <th style="width:70px;font-size:12px; font-weight:bold;">S.No.</th>
                     <th style="width:150px; font-size:12px; font-weight:bold;">STUDENT ID.</th>
					 <th style="width:220px; font-size:12px; font-weight:bold;">NAME OF THE STUDENT</th>
                     <th style="font-size:12px; font-weight:bold;">SIGNATURE OF THE STUDENT</p></th>
                </tr>
				<?php $i=0; foreach($students_attendance as $reg_students){
                  
				$i++;?>
                <tr>
                    <td align="center" style="font-size:12px;"> <p align="center" style=" font-size:12px;"><?php echo $i;?></p></td>
				
                    <td align="center" style="font-size:12px;"><p align="center" style=" font-size:12px;"><?php echo $reg_students->user_unique_id;?></p></br></td>
					<td style=" font-size:12px; padding-left:20px;"><p align="center" style=" font-size:12px;"><?php echo $reg_students->first_name.' '.$reg_students->last_name;?></p></td>
                    <td style =" font-size:12px;  padding-left:20px;"><p align="center" style=" font-size:12px;"></p></td>
                </tr> 
			<?php } //exit; ?>
            </table>
</div>
    </div>
</body>




</html>
