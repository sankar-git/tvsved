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


        .header{
            width:100%;
            padding:0px;
            margin:0px;
            border-bottom:1px solid #000;
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
<?php foreach($detailed_marks as $detailed_value){?>
    <div style="padding:0px; width:100%; font-family:Arial, Helvetica, sans-serif; ">

        <div class="header">
            <table style="padding:0px; margin:0px;border-collapse: collapse;">
                <tr>
                    <td >
                        <img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png" style="padding:10px 20px 10px 0px;">
                    </td>
                    <td style="text-align:center; line-height:1.5">
                        <h4>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</h4>
                        <h5>DETAILED MARK CERTIFICATE</h5>
                        <h5><?php echo $detailed_value['semester_name'];?>(B.V.Sc & A.H)</h5>
                    </td>
                </tr>
            </table>
            
        </div>
        <div class="pdf_container">
            <table class="sub-detail-tbl" style="width:100%;padding:20px 0px; margin:0px; border-collapse: collapse; margin:20px 0px;Lline-height:1.5">
                <tr>
                    <td>
                        <b>Name : </b> <?php echo $detailed_value['first_name'];?>
                    </td>
                    <td >
                        <b>Father Name:</b> <?php echo $detailed_value['father_name'];?>
                    </td>
                </tr>

                 <tr>
                    <td>
                        <b>I.D No : </b> <?php echo $detailed_value['user_unique_id'];?>
                    </td>
                    <td >
                        <b>Mother Name :</b> <?php echo $detailed_value['mother_name'];?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Batch : </b> <?php echo $detailed_value['batch_name'];?>
                    </td>
                    <td>
                       <b>Academic Year : </b> <?php echo $detailed_value['month_year'];?>
                    </td>
                </tr>
				<tr>
                    <td>
                        <b>College : </b> <?php echo $detailed_value['campus_name'];?>
                    </td>
                    <td style="text-align:right">&nbsp;
                      
                    </td>
                </tr>

             </table>   







        
           
          
            <table id="table" width="100%;" class="student_table">
				<thead>
                <tr>
                    <th rowspan="2">Subject</th>
                    <th rowspan="2">Credit Hours</th>
                     <th colspan="2">Internal Assessment</th>
					 <th colspan="2">Annual Examination</th>
					 <th rowspan="2">Total(100)</th>
					 <th rowspan="2">Grade Point</th>
					 <th rowspan="2">Credit Points</th>
                </tr>
				<tr>
                    <th>First(10)</th>
                    <th>Second(10)</th>
					<th>Theory(40)</th>
                    <th>Practical(40)</th>
				</tr>
                </thead>
				<tbody>
                <?php foreach($detailed_value['subjectList'] as $subject_value){
					
					
					
					?>
                <tr>
                    <td>
                      
                          <?php echo $subject_value['course_title'];?>
                     
                    </td>
                    <td align="center">
                      
                           <?php echo $subject_value['theory_credit'].'+'.$subject_value['practicle_credit'];?>
                        
                    </td>
                    <td align="center" >
                                       <?php echo $subject_value['highest_marks'];?>
                                    </td>
                                    <td align="center">
                                      
                                       <?php echo $subject_value['second_highest_marks'];?>
                                       
                                    </td>
                    <td  align="center" >
                                       <?php  echo $subject_value['sum_internal_practical'];?>
                                    </td>
                                    <td  align="center">
                                      <?php  echo $subject_value['external_sum'];?>
                                    </td>
					<td align="center"> <?php  echo $subject_value['total_internal_external'];?></td>
					<td  align="center"><?php  echo $subject_value['gradeval'];?></td>
					<td align="center"><?php  echo $subject_value['creditval'];?></td>
				</tr>
                
                <?php } ?>
				</tbody>
            </table>
			<br><br>
			<table width="100%">
                <tr>
                    <td align="left" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>Date Of Issue</div></td>
                    <td align="right" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>CONTROLLER Of EXAMINATIONS</div></td>
                    <td align="right" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>REGISTRAR</div></td>
                </tr>

            </table>
			
</div>
</div>

<pagebreak>
<?php }?>

    
</body>




</html>