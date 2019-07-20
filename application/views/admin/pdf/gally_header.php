<table>
                <tr>
                    <td><div><span class="logo"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td><br />
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:16px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td align="center">
                                            <p align="center" style=" font-size:13px;"><b><?php echo $dummy_number_report[0]['degree_code'];?></b></p><br />
                                            <p align="center" style=" font-size:13px; padding:10px 0px 0px 0px;"><b>
                                            GALLY REPORT</b>
                                            </p>
                                    </td>
                                    <!-- <td align="center">
                                            <p></p>                           
                                    </td> -->
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table><hr>
            <!-- <table  width="100%">
                <tr>
                  
                    <td>    
					<table width="100%">
                                <tr>
                                    <td><div><span class="logo"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                                    <td><p style=" font-size:16px; font-weight:bold;">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></td>
                                </tr>
								<tr>
                                    <td>
									
									 <p style=" font-size:13px; font-weight:bold;"><?php echo $dummy_number_report[0]['semester_name'];?>&nbsp;<?php echo $dummy_number_report[0]['degree_code'];?>&nbsp;Degree Gally Report</p>
                                      
                                    </td>
                                </tr>
                             

                            </table>
                        


                    </td>
                </tr>
            </table> -->
			<table width="100%" style="font-size:13px;padding:0px;" >
                <tr>
                    <td align="left" width="25px" style="vertical-align:top;font-weight:bold;">College</td>
					<td align="left" width="250px" style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $dummy_number_report[0]['campus_name'];?></td>	
                    <td align="right" width="300px" style="vertical-align:top;font-weight:bold;">Batch</td>
                    <td align="right"width="70px" style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $dummy_number_report[0]['batch_name'];?></td>
                </tr>
                <tr>
                    <td align="left" width="25px" style="vertical-align:top;font-weight:bold;">Examination </td>
					<td align="left" width="200px" style="vertical-align:top;">:&nbsp;&nbsp;<?php echo $dummy_number_report[0]['semester_name'].'-'.'Annual';?></td>
                    <td align="right" width="300px" style="vertical-align:top;font-weight:bold;">Month & Year<!--  of Exam --></td>
                    <td align="right"width="70px" style="vertical-align:top;">:&nbsp;&nbsp;<?php  echo $month.' '.$year;?></td> 
                    
                </tr>
            </table>