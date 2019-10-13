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
								<p align="center" style=" font-size:13px; font-weight:bold;"><!-- <?php echo strtoupper($semester_name);?>&nbsp; --><?php echo $campus_name;?></p>
									<p align="center" style=" font-size:13px; font-weight:bold;"><!-- <?php echo strtoupper($semester_name);?>&nbsp; --><?php echo $degree_code;?></p>
								  
								   <!-- <p align="center" style=" font-size:13px; font-weight:bold;">FIRST ANNUAL BOARD B.V.Sc & A.H EXAMINATION</p>-->
									<br/>
									  <p align="center" style=" font-size:13px; font-weight:bold;">STUDENT REGISTRATION CARD</p>
									<!-- <p style=" font-size:13px; font-weight:bold;"><?php echo $semester_name;?></p> -->
								
							</td>
						</tr>
					</table>
                        
                    </td>
                </tr>
            </table>
            <br />
            <table style="font-size:11px;"  width="100%">
                <tr style="height:30px;">
                    <td width="50%" style="font-weight:bold;height:30px;">Name of the Student&nbsp;:&nbsp;<?php echo $first_name.' '.$last_name;?></td>
                     <td width="21%" align="left" style="font-weight:bold;">I.D. No.&nbsp;:&nbsp;<?php echo $user_unique_id;?></td>
                    <td width="29%" align="left" style="font-weight:bold;">Date of Registration&nbsp;:&nbsp;<?php if(!empty($date_of_registration)){ echo $date_of_registration; }else{echo " - ";}?></td>
                </tr>
                <tr>
					<td width="50%" style="font-weight:bold;"><?php if($degree_id == 1){?>Professional Year<?php }else{ ?> Semester <?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php  echo $semester_code; ?></td>
                    <td width="21%" align="left" style="font-weight:bold;">Batch&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php  echo "A / B / C / D";?></td>
                    <td width="29%" align="left" style="font-weight:bold;">Year of Admission&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php  echo $batch_name;?></td>
                </tr>
            </table>
