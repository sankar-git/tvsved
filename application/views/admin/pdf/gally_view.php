<?php //p($dummy_number_report[0]['degree_name']); exit;?>
<!DOCTYPE html>
<html>
<head>
    <title>Gally Report</title>
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

        .tableLevelTwo {
            border-collapse: collapse;
            padding: 0px !important;
        }

            .tableLevelTwo th {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 0px 0px 0px 0px !important;
                font-size: 12px;
            }

                .tableLevelTwo th td {
                    border-collapse: collapse;
                    padding: 0px 0px 0px 1px !important;
                }

            .tableLevelTwo tr td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 11px;
                padding: 0px 0px 0px 0px !important;
            }
    </style>
</head>


<body>
<?php $this->load->view('admin/pdf/gally_header');?><br /><br />
    <div style=" font-family:sans-serif;" width="100%">
        <div id="dummy" width="100%">
            
			
            <table id="table" width="100%">
                <tr>
                    <th style="width:70px;">SL.No.</th>
                    <th style="width:150px; font-size:14px; font-weight:bold;">STUDENT ID.</th>
                    <th style="width:200px; font-size:14px; font-weight:bold;">NAME</th>
                    <th>SUBJECTS</th>
                </tr>
				<?php $i=$dummy_number_report[0]['index'] ; ?>
				<?php foreach($dummy_number_report as $dummydata){
                  // print_r($dummydata); 
				$i++;?>
                <tr>
                    <td align="center" style=" font-size:14px; font-weight:bold;vertical-align:top"><?php echo $i;?></td>
                    <td align="center" style=" font-size:14px; font-weight:bold;vertical-align:top"><?php echo $dummydata['student_unique_id'];?></td>
                    <td align="left" style=" padding-left:1px;font-size:14px; font-weight:bold;vertical-align:top">&nbsp;&nbsp;<?php echo $dummydata['first_name'].' '.$dummydata['last_name'];?></td>
                    <td style =" font-size:8px; vertical-align:top">	
					<table style="border:none;">
                       <?php  foreach($dummydata['subjectList'] as $key=>$subjects) {
							 //p($subjects);
							 
							// if($key%2==0){ $first=true;  ?>
							<tr><td style="border:none"><?php echo $subjects['course_title'];?></td>
							</tr> <!-- style="border:none" -->
					   <?php  } ?>
						</table>
                    </td>
                </tr> 
			<?php } //exit; ?>
            </table>
</div>
    </div>
</body>




</html>
