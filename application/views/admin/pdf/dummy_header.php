<table  width="100%">
    <tr>
        <td><div><span class="logo"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
        <td><br />
            <div>
                <table>
                    <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:16px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                    <tr>
                        <td align="center">
                            <p align="center" style=" font-size:13px;"><b><?php echo $dummy_number_report[0]['degree_code'];?></b></p><br />
                            <p align="center" style=" font-size:13px; padding:10px 0px 0px 0px;">
                            <b>DUMMY NUMBER REPORT</b></p>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
                <!-- <tr>
                  
                     <td>   
					<table width="100%">
                                <tr><td align="center"><p style=" font-size:16px; font-weight:bold;">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></td></tr>
                                <br />
								<tr>
                                    <td align="center">
									<p align="center" style=" font-size:13px; font-weight:bold;"><?php echo $dummy_number_report[0]['degree_code'];?></p>
								
                                    </td>
                                </tr> <br />                              
                                <tr>
                                    <td align="center">
                                    <p align="center" style=" font-size:13px; font-weight:bold;"><?php echo 'Dummy Number Report';?></p>
                                
                                    </td>
                                </tr>
                            </table>
                        


                    </td>
                </tr> -->
            </table>
     
           <table width="100%" style="font-size:13px;padding:0px;" >

				<tr>
                    <td align="left" width="25px" style="vertical-align:top;font-weight:bold;">College</td>
					<td align="left" width="300px" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $dummy_number_report[0]['campus_name'];?></td>					
					<td align="right" width="200px" style="vertical-align:top;font-weight:bold;">Month & Year of Exam</td>
					<td align="right"width="70px" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php  echo $month.' '.$year;?></td>                
                   
                </tr>
                <tr>
                    <td align="left" width="25px" style="vertical-align:top;font-weight:bold;">Exam</td>
					<td align="left" width="300px" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $dummy_number_report[0]['semester_name']?><?php if($exam_type == 2) echo "-CAP"; else echo "-Annual";?></td>
                    <td align="right" width="200px" style="vertical-align:top;font-weight:bold;">Batch</td>
					<td align="right"width="70px" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $dummy_number_report[0]['batch_name'];?></td>
                    
                </tr>
            </table>