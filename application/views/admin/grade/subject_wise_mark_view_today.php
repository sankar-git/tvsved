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
    <div style="padding:10px 10px 10px 10px; width:852px; font-family:Arial, Helvetica, sans-serif;">
        <div id="dummy">
			         
            <table id="table" width="100%">
                <tr style="">
                    <th rowspan="3" style="padding:2px;">S.No.</th>
                    <th rowspan="3" style="padding:2px;">Dummy No</th>
                    <th rowspan="3" style="padding:2px;">ID No</th>
                    <th colspan="3" scope="colgroup" style="padding:2px;">Internal Assessment</th>
                    <th colspan="2" scope="colgroup" style="padding:2px;">Theory</th>
                    <th colspan="2" scope="colgroup" style="padding:2px;">Practical</th>
                </tr>
				<tr>
                    <th scope="col" style="padding:2px;">First</th>
                    <th scope="col"  style="padding:2px;">Second</th>
					<th scope="col"  style="padding:2px;">Third</th>
                    <th scope="col"  style="padding:2px;">Paper-I</th>
                    <th scope="col"  style="padding:2px;">Paper-II</th> 
                    <th scope="col"  style="padding:2px;">Paper-I</th>
                    <th scope="col"  style="padding:2px;">Paper-II</th> 
                </tr>
				 <tr>
                    <th scope="col"  style="padding:2px;">(10)</th>
                    <th scope="col" style="padding:2px;">(10)</th>
					<th scope="col" style="padding:2px;">(10)</th>
                    <th scope="col"  style="padding:2px;">(100)</th>
                    <th scope="col"  style="padding:2px;">(100)</th>
                    <th scope="col"  style="padding:2px;">(60)</th>
                    <th scope="col"  style="padding:2px;">(60)</th>
                </tr>

				
				<?php $i=0; foreach($students_attendance as $reg_students){ //print_r($reg_students);exit;
                  
				$i++;?>
                <tr>
                    <td align="center" style="font-size:12px;"><?php echo $i;?></td>
				
                    <td align="center" style="font-size:14px;"><?php echo $reg_students->dummy_value;?></td>
					<td align="center"  style=" font-size:14px; "><?php echo $reg_students->user_unique_id;?></td>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
                    <td style ="font-size:12px;"><p align="center" style=" font-size:14px;"></p></td>
                </tr> 
			<?php } //exit; ?>
            </table>
</div>
    </div>
</body>




</html>
