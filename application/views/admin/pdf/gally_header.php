<table  width="100%">
                <tr>
                  
                    <td>    
					<table width="100%">
                                <tr><td align="center"><p style=" font-size:16px; font-weight:bold;">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></td></tr>
                                <br />
								<tr>
                                    <td align="center">
									
									 <p align="center" style=" font-size:13px; font-weight:bold;"><?php echo $dummy_number_report[0]['semester_name'];?>&nbsp;<?php echo $dummy_number_report[0]['degree_code'];?>&nbsp;Degree Gally Report</p>
                                      
                                    </td>
                                </tr>
                             

                            </table>
                        


                    </td>
                </tr>
            </table>
			<br /><br />
  
			<table width="100%" style="font-size:13px;padding:0px;" >
                <tr>
                    <td align="left" width="25px" style="vertical-align:top;font-weight:bold;">Degree</td>
					<td align="left" width="200px" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $dummy_number_report[0]['degree_code'];?></td>					
					<td align="right" width="300px" style="vertical-align:top;font-weight:bold;">Month & Year of Exam</td>
					<td align="right"width="70px" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php  echo $month.' '.$year;?></td>                
                   
                </tr>
                <tr>
                    <td align="left" width="25px" style="vertical-align:top;font-weight:bold;">College </td>
					<td align="left" width="200px" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $dummy_number_report[0]['campus_code'];?></td>
                    <td align="right" width="300px" style="vertical-align:top;font-weight:bold;">Batch</td>
					<td align="right"width="70px" style="vertical-align:top;font-weight:bold;">:&nbsp;&nbsp;<?php echo $dummy_number_report[0]['batch_name'];?></td>
                    
                </tr>
            </table>