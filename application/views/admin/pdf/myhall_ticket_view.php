<html>
<head>
    <title>Hall Ticket</title>
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

</head>


<body>
<?php  foreach($hall_tickets as $halldata){?>
    <div style="padding:20px 20px 20px 20px; width:852px; font-family:sans-serif;">
        <div id="dummy">
            <table>
                <tr>
                    <td><div><span class="logo"><img height="100" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:14px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td align="center">
                                        <div>
                                            <p align="center" style=" font-size:13px; font-weight:bold;"><?php echo $halldata['degree_name'];?></p>
                                          
                                           <!-- <p align="center" style=" font-size:13px; font-weight:bold;">FIRST ANNUAL BOARD B.V.Sc & A.H EXAMINATION</p>-->
                                            <br/>
                                              <p align="center" style=" font-size:13px; font-weight:bold;">HALL TICKET</p>
											 <p style=" font-size:13px; font-weight:bold;"><?php echo $halldata['semester_name'];?></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <hr/>
            <table style="font-size:13px;">
                <tr>
                    <td><div><b>College :</b>&nbsp;&nbsp;<?php echo $halldata['campus_code'];?></div></td> 
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td align="right"><div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Batch :</b>&nbsp;<?php  echo $halldata['batch_name'];?></div></td>
                </tr>
               <!-- <tr>

                    <td align="right" colspan="3"><div><b>Month & Year :</b>&nbsp;&nbsp;<?php // echo $halldata['month_year'];?></div></td>
                </tr>-->
            </table>


            <br />
            <table id="table" width="100%" class="table">

                <tr>
                    <td align="center" style=" font-size:13px; font-weight:bold;" colspan="2">
                        <div>
                            <table width="100%" id="table2" class="tableLevelTwo">
                                <tr style="height:100px; border:none;">
                                    <td style="border:none;" align="center">
                                        <div>
                                            <!--<img src="<?php echo base_url('');?>assets/admin/dist/img/logo.jpg"  alt="loading..." height="50px"/>-->
                                            
                                    <?php if($halldata['user_image']){?>
									<img style="height:70px;width:70px;" src="<?php echo base_url('uploads/user_images/student/'. $halldata['user_image']);?>" alt="current"/>
									<?php } else {?>
									<img style="height:50px;width:50px;" src="<?php echo base_url('uploads/user_images/student/');?>/no_image.jpg" alt="current"/>
									<?php }?>
                                            
                                        </div>
                                    </td>
                                </tr>
                                <tr style="border:none;">
                                    <td >
                                        <div style="padding-left:20px;"><?php echo $halldata['user_unique_id'];?></div>
                                    </td>
                                </tr>
                                <tr style=" border:none;">
                                    <td style="font-size:9px; padding:0;">
                                        <div style=""><?php echo $halldata['first_name'].' '.$halldata['last_name']?></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td align="center" style=" font-size:14px; font-weight:bold;">
                        <div>
                            <table width="100%" id="table3" class="tableLevelTwo">
                                <tr>

                                    <!--<th style="width:100px; font-size:11px; font-weight:bold;">Date</th>-->
                                    <th style="width:250px; font-size:11px; font-weight:bold;">Subjects</th>

                                </tr>
                              <?php $i=0; foreach($halldata['subjectList'] as $subjects){?>
                                <tr style="border:none;">
                                    <!--<td align="center" style=" font-size:11px; font-weight:bold;">22-03-2017</td>-->
                                    <td align="left" style=" font-size:13px; border:none;">&nbsp;<?php echo $subjects['course_title'];?></td>
                                </tr>
								 <?php $i++;}?>
                           </table>
                        </div>
                    </td>
                </tr>
            </table>
            <br />
            <br />
            <table width="100%">
                <tr width="100%">
                    <td width="200px" align="left" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>Attested</div></td>
                    <td width="350px" align="center" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>Signature of the Dean</div></td>
                    <td width="250px" align="center" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>Signature of the Candidate</div></td>
                </tr>

            </table>
            <br />
            <br />
            <table width="100%">
                <tr width="100%">
                    <td width="200px" align="left" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>University Seal</div></td>
                    <td width="350px" align="center" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>Controller of Examinations</div></td>
                    <td width="250px" align="center" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>Registrar</div></td>
                </tr>
            </table>
        </div>
    </div>
	<?php }?>
</body>




</html>