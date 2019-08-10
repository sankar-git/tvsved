    <link rel="icon" href="<?php echo base_url();?>assets/admin/dist/img/logo.jpg" type="image/gif" sizes="16x16">
    <style>
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


    <div style=" font-family:sans-serif;">
        <div id="dummy">
            <table width="100%">
                <tr>
                    <td width="15%"><img height="100" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></td>
                    <td width="85%">
                        
					<table width="100%">
						<tr><td><p style=" font-size:16px; font-weight:bold;">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></td></tr>
						<tr>
							<td align="center">
								
									<p align="center" style=" font-size:13px; font-weight:bold;"><!-- <?php echo strtoupper($semester_name);?>&nbsp; --><?php echo $degree_code;?></p>
								  
								   <!-- <p align="center" style=" font-size:13px; font-weight:bold;">FIRST ANNUAL BOARD B.V.Sc & A.H EXAMINATION</p>-->
									<br/>
									  <p align="center" style=" font-size:13px; font-weight:bold;">HALL TICKET</p>
									<!-- <p style=" font-size:13px; font-weight:bold;"><?php echo $semester_name;  ?></p> -->
								
							</td>
						</tr>
					</table>
                        
                    </td>
                </tr>
            </table><hr>
            <br />
            <table style="font-size:13px;"  width="100%">
                <tr>
                    <td width="15%" style="font-weight:bold;">College </td>
                    <td>: <?php echo $campus_name;?></td> 
                    
                    <td align="right" style="font-weight:bold;">Batch </td>
                    <td>: <?php echo $batch_name;?></td>
                </tr>
                <tr>
					<td width="15%" style="font-weight:bold;">Examination </td>
                    <td>: <?php echo $semester_name; if($exam_type == 1) echo "-Annual";  if($exam_type == 2) echo "-Cap";?></td> 
                    <td align="right" style="font-weight:bold;">Month & Year </td>
                    <td>: <?php  echo $month_year;?></td>
                </tr>
            </table>
