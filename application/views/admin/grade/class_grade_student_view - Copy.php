<html>
<head>
    <title>Class Grade</title>
    <style>
        .table {
             
            border-collapse: collapse;
            padding:0px !important;
        }

            .table th {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 0px 0px 0px 0px !important;
                font-size: 13px;
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
</head>

<>
<body>
    <div style="padding:10px 10px 10px 10px; width:852px; font-family:Arial, Helvetica, sans-serif;">
        <div id="dummy">
            <table>
                <tr>
                    <td><div><span class="logo"><img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:14px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td>
                                        <div>
                                            <p align="center" style=" font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;<?php echo $aggregate_marks[0]->degree_name;?></p>
                                            <p align="center" style=" font-size:14px;"><?php echo $aggregate_marks[0]->semester_name;?> SEMESTER FINAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EXAMINATION</p>
                                        </div>
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table>

            <hr />
            <table style="font-size:14px;">
                <tr>
                    <td><div><b>College &nbsp;&nbsp;&nbsp;:</b>&nbsp;&nbsp;<?php echo $aggregate_marks[0]->campus_name;?></div></td>
                    <td>
                        <div>
                            
                        </div>
                    </td>
                    <td><div><b>Month & Year :</b>&nbsp;&nbsp;MAR-2016</div></td>

                </tr>
                <tr>
                    <td><div><b>Subject Code&nbsp;:</b>&nbsp;&nbsp;<?php echo $aggregate_marks[0]->course_code;?> (<?php echo $aggregate_marks[0]->theory_credit ;?> + <?php echo $aggregate_marks[0]->practicle_credit ;?>)</div></td>

                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b>Batch &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>&nbsp;<?php echo $aggregate_marks[0]->batch_name;?></div></td>
                </tr>
                <tr>
                    <td><div><b>Subject &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>&nbsp;&nbsp;<?php echo $aggregate_marks[0]->course_title;?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b> </b>&nbsp;&nbsp; </div></td>
                </tr>
            </table>
            <br />
            <table id="table" width="100%" class="table">
                <tr>
                    <th>
                        <div>
                            ID No.
                        </div>
                    </th>
                    <th>
                        <div>
                            Name of the Student
                        </div>
                    </th>
                    <th>
                        <div>
                            <table width="100%" class="table">
                                <tr>
                                    <th colspan="2">
                                        <div>
                                            THEORY
                                        </div>
                                    </th>

                                </tr>
                                <tr>
                                    <th>
                                        <div>
                                            INT.
                                            (Max. 20)
                                        </div>
                                    </th>
                                    <th>
                                        <div>
                                            EXT.
                                            (Max. 80)
                                        </div>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </th>
                    <th>
                        <div>
                            <table width="100%" class="table">
                                <tr>
                                    <th colspan="2">
                                        <div>
                                            PRACTICAL
                                        </div>
                                    </th>

                                </tr>
                                <tr>
                                    <th>
                                        <div>
                                            INT.
                                            (Max. 20)
                                        </div>
                                    </th>
                                    <th>
                                        <div>
                                            EXT.
                                            (Max. 80)
                                        </div>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </th>
                </tr>
				
				<?php foreach($aggregate_marks as $marks){?>
                <tr>
                    <td>
                        <div>
                            <?php echo $marks->user_unique_id;?>
                        </div>
                    </td>
                    <td>
                        <div>
                          <?php echo ucfirst($marks->first_name).' '.ucfirst($marks->first_name);?>
                        </div>
                    </td>
                    <td>
                        <div>
                            <table width="100%" class="table">
                                <tr>
                                    <td>
                                        <div>
                                            <?php 
											if(empty($marks->theory_internal))
											{
												echo '00';
											}
											else
											{
											echo $marks->theory_internal;
											}
											?>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <?php 
											if(empty($marks->theory_external))
											{
												echo '00';
											}
											else
											{
											echo $marks->theory_external;
											}
											?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div>
                            <table width="100%" class="table">
                                <tr>
                                    <td >
                                        <div>
                                          <?php
										  if(empty($marks->practical_internal))
											{
												echo '00';
											}
											else
											{
										     echo $marks->practical_internal;
											}
											 ?>
                                        </div>
                                    </td>
                                    <td >
                                        <div>
                                          <?php
                                             if(empty($marks->practical_external))
											{
												echo '00';
											}
											else
											{
      										  echo $marks->practical_external;
											}
											?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>

                </tr>
				
				<?php } ?>
            </table>


            
             
        </div>
    </div>
</body>




</html>