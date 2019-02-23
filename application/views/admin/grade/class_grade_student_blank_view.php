<html>
<head>
    <title>Blank View</title>


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
				height:21px;
            }
        .pdf_container{
            width:100%;
            display:block;
            padding:0px;
            margin:0px;
        }
        .sub-detail-tbl tr td{
          padding:5px 0px;

        }
        
        .student_table,
        .student_sub_table{
            width:100%;
            padding:0px;
            margin:0px;
            border-collapse: collapse;
            font-size:14px;
        }


        .student_table td,
        .student_table th{
            padding:5px;
            border: 1px solid black;
          }  


          .student_sub_table td,
          .student_sub_table th{
            padding:0px;
            border:none;
          }   

</style>
</head>
<body>
		<p align="center">
	     <h5 align="center">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY </h5>
         <h6 align="center">B.V.Sc. & A.H. - DEGREE SUBJECT WISE MARK REPORT <BR />
		 LIST OF FAILED CANDIDATE(S) WITH MODERATION
		 </h6>		
		</p>
    <div style="padding:0px; width:1200px; font-family:Arial, Helvetica, sans-serif; ">
        <div class="pdf_container">
			<table class="sub-detail-tbl" style="width:100%;padding:20px 0px; margin:0px; border-collapse: collapse; margin:20px 0px;Lline-height:1.5">
				<tr>
                    <td align="left" width="80px" style="vertical-align:top;font-weight:bold;">College &nbsp;:&nbsp;</td>
					<td align="left" width="250px" style="vertical-align:top;font-weight:bold;margin-left:1px;"><?php echo $aggregate_marks[0]->campus_name;?></td>					
					<td align="right" width="240px" style="vertical-align:top;font-weight:bold;">Batch &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
					<td align="left"width="250px" style="vertical-align:top;font-weight:bold;"><?php echo $aggregate_marks[0]->batch_name;?></td>                
                   
                </tr>
                <tr>
                    <td align="left" width="80px" style="vertical-align:top;font-weight:bold;"></td>
					<td align="left" width="250px" style="vertical-align:top;font-weight:bold;"></td>
                    <td align="right" width="240px" style="vertical-align:top;font-weight:bold;">Exam&nbsp;&nbsp;:&nbsp;&nbsp;</td>
					<td align="left"width="250px" style="vertical-align:top;font-weight:bold;"></td>
                    
                </tr>
				<tr>
                    <td align="left" width="80px" style="vertical-align:top;font-weight:bold;">Subject &nbsp;:&nbsp;</td>
					<td align="left" width="250px" style="vertical-align:top;font-weight:bold;"><?php echo $aggregate_marks[0]->course_code;?></td>
                    <td align="right" width="240px" style="vertical-align:top;font-weight:bold;">Annual Board&nbsp;&nbsp;:&nbsp;&nbsp;</td>
					<td align="left"width="250px" style="vertical-align:top;font-weight:bold;">First</td>
                    
                </tr>
             </table>  


            <table class="table" width="852" style="border:solid 1px black; font-size:10px; ">
                <tr>
                    <th rowspan="3" style="font-weight:bold;">S.No.</th>
                    <th rowspan="3" style="font-weight:bold; width:70px;">ID No.</th>
                    <th rowspan="3" style="font-weight:bold;width:200px;">NAME</th>
                    <th colspan="5" scope="colgroup" style="font-weight:bold;">THEORY</th>
                    <th colspan="1" scope="colgroup" style="font-weight:bold;">TOTAL</th>
                    <th colspan="1" scope="colgroup" style="font-weight:bold;">TOTAL</th>
					<th rowspan="3" style="font-weight:bold;">RESULT</th>
					<th colspan="2" scope="colgroup" style="font-weight:bold;">DEFICIT MARK</th>
                </tr>
                <tr>
                    <th scope="col" style="padding:2px;">Paper-I</th>
                    <th scope="col"  style="padding:2px;">Paper-I</th>
					<th scope="col"  style="padding:2px;">Paper-II</th>
                    <th scope="col"  style="padding:2px;">Paper-II</th>
                    <th scope="col"  style="padding:2px;">TOTAL</th> 
                    <th scope="col"  style="padding:2px;">INTERNAL + THEORY</th>
                    <th scope="col"  style="padding:2px;">INTERNAL + THEORY + PRACTICAL</th> 
					<th scope="col" rowspan="2"  style="padding:2px;">THEORY</th>
                    <th scope="col" rowspan="2" style="padding:2px;">PRACTICAL</th> 
                </tr>
                <tr>
                    <th scope="col"  style="padding:2px;">(100)</th>
                    <th scope="col" style="padding:2px;">(20)</th>
					<th scope="col" style="padding:2px;">(100)</th>
                    <th scope="col"  style="padding:2px;">(20)</th>
                    <th scope="col"  style="padding:2px;">(40)</th>
                    <th scope="col"  style="padding:2px;">(60)</th>
                    <th scope="col"  style="padding:2px;">(100)</th>

                </tr>

				<tr>	
					
					<td  align="center" style="padding:2px;">01</td>
                    <td  align="center" style="padding:2px;"></td>
                    <td  align="left" style="padding:2px; vertical-align:bottom;">BVT17001</td>
                    <td  align="center" style="padding:2px;">-</td>
					<td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
					<td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
				</tr>				

            </table>    
             
        </div>

        </div>




    
</body>

</html>

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
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;<?php echo $aggregate_marks[0]->degree_name;?></p>
                                            <p align="center" style=" font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;<?php echo $aggregate_marks[0]->semester_name;?> SEMESTER FINAL EXAMINATION</p>
                                        </div>
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </td>
                </tr>
            </table>

            <hr />
            <table style="font-size:11px;">
                <tr>
                    <td><div><b>College &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b><?php echo $aggregate_marks[0]->campus_name;?></div></td>
                     
                    <td align="right"><div><b>Month & Year :</b>MAR-2016</div></td>

                </tr>
                <tr>
                    <td><div><b>Subject Code&nbsp;&nbsp;:</b><?php echo $aggregate_marks[0]->course_code;?> (<?php echo $aggregate_marks[0]->theory_credit ;?> + <?php echo $aggregate_marks[0]->practicle_credit ;?>)</div></td>
                    <td align="right"><div><b>Batch :</b>&nbsp;<?php echo $aggregate_marks[0]->batch_name;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
                </tr>
                <tr>
                    <td><div><b>Subject &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b><?php echo $aggregate_marks[0]->course_title;?></div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b> </b>&nbsp;&nbsp; </div></td>
                </tr>
            </table>
            <br/>
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
                                            <?php echo $marks->theory_internal;?>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                     &nbsp;&nbsp;&nbsp;&nbsp;
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
                                          <?php echo $marks->practical_internal;?>
                                        </div>
                                    </td>
                                    <td >
                                        <div>
                                       &nbsp;&nbsp;&nbsp;&nbsp;
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




</html> -->