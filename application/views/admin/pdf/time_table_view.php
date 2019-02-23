<?php $this->load->view('admin/pdf/time_table_header',$time_table);?>   
<style>
        #table {
            border: 1px solid;
            border-collapse: collapse;
        }

		#table th {
			border: 1px solid;
			border-collapse: collapse;
			height:50px;
		}
		#table td {
			border: 1px solid;
			border-collapse: collapse;
			height:50px;
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
		 .table {
            border-collapse: collapse;
            padding: 0px !important;
        }

            .table th {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 0px 0px 0px 0px !important;
                font-size: 12px;
            }

                .table th td {
                    border-collapse: collapse;
                    padding: 0px 0px 0px 0px !important;
                }

            .table tr td {
				
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 11px;
                padding: 0px 0px 0px 0px !important;
            }

        
    </style>
<table id="table" width="100%">
			<tr>
				<th align="center">DATE</th>
				<th align="center">DAY</th>
				<th align="center">TIME</th>
				<th align="center">SUBJECT</th>
			</tr>
<?php  foreach($time_table as $key=>$table){?>
		<tr>
				<td align="center"><?php echo $table->exam_date;?></td>
				<td align="center"><?php echo date('l', strtotime($table->exam_date));?></td>
				<td align="center"><?php echo $table->slot_name;?></td>
				<td align="center"><?php echo $table->course_title;?></td>
			</tr>
            
           
      
	<?php } ?></table>  </div>
    </div>	
	
	<br/>
	<div >&nbsp;</div>
	<br/>
	<table width="100%">
                <tr>
                    <td align="left" style="width:30%; font-size:12px; font-weight:bold;text-transform: uppercase;"><div>&nbsp;</div></td>
                    <td align="center" style="width:35%; font-size:12px; font-weight:bold;text-transform: uppercase;"><div>&nbsp;</div></td>
                    <td align="center" style="width:35%; font-size:12px; font-weight:bold;"><div>Controller of Examinations i/c /<br/>TNAUVAS, Chennai - 600 051</div></td>
                </tr>

            </table>
</body>
</html>