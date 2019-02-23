<?php //p($dummy_number_report[0]['degree_name']); exit;?>

<!DOCTYPE html>
<html>
<head>
    <title>Subject Wise Pass Fail List</title>
<!--     <style>
        .table {
            border: 1px solid black;
            border-collapse: collapse;
        }

            .table th {
                border: 1px solid black;
                border-collapse: collapse;
                height: 35px;
            }

                .table th td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }

            .table tr td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 12px;
            }
    </style>
</head>


<body>
    <div style="padding:20px 20px 20px 20px; width:852px; font-family:Arial, Helvetica, sans-serif; border:solid 1px;">
        <div id="dummy">
            <table>
                <tr>
                    <td><div><span class="logo"><img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:20px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td>
                                        <div>
                                            <p align="center" style=" font-size:15px;">B.V.Sc. & A.H. DEGREE SUBJECT WISE MARK REPORT</p>
                                            
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
                    <td><div><b>College :</b>&nbsp;&nbsp;<?php echo $subject_wise_list[0]->campus_name;?></div></td>
                    <td>
                        <div>
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                    <td><div><b>Batch &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>&nbsp;<?php echo $subject_wise_list[0]->batch_name;?></div></td>
                </tr>
                <tr>
                    <td><div><b>Subject ID &nbsp;:</b>&nbsp;&nbsp;<?php echo $subject_wise_list[0]->course_code;?></div></td>
                   
                  
                </tr>
                <tr>
                    <td><div><b>Subject Name &nbsp;:</b>&nbsp;&nbsp; <?php echo $subject_wise_list[0]->course_title;?>                </div></td>
                    <td>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                   
                </tr>
            </table>


            <br /><br /> 


 -->        



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
          padding:2px 0px;

        }
        
        .student_table,
        .student_sub_table{
            width:100%;
            padding:0px;
            margin:0px;
            border-collapse: collapse;
            font-size:12px;
        }


        .student_table td,
        .student_table th{
            padding:2px;
            border: 1px solid black;
            font-size:12px;
          }  


          .student_sub_table td,
          .student_sub_table th{
            padding:0px;
            border:none;

          }

         




    </style>
</head>


<body>
	<?php if(!isset($_POST['downloadpdf'])){?>
	<form name="genpdf" id="genpdf" action="" method="post">
	<?php foreach($_POST as $key=>$val){?>
		<input type="hidden" name="<?php echo $key;?>" value="<?php echo $val;?>" />
	<?php } ?>
	<input type="hidden" name="downloadpdf" value="true" />
	</form>
	<?php } ?>
    <div style="padding:0px; width:100%; font-family:Arial, Helvetica, sans-serif; ">

        <div class="header">
            <table style="padding:0px; margin:0px;border-collapse: collapse;">
                <tr>
                    <td >
                        <img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png" style="padding:10px 20px 10px 0px;">
                    </td>
                    <td style="text-align:center; line-height:1.5">
                        <h4>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</h4>
                      
                        <h5>B.V.Sc. & A.H(Failed Student List)</h5>
						<?php if(!isset($_POST['downloadpdf'])){?>
                        <h5><a href="javascript:;" onclick="document.genpdf.submit();">Download PDF</a></h5>
						<?php } ?>
                    </td>
                </tr>
            </table>
            
        </div>
        <div class="pdf_container">
            <table class="sub-detail-tbl" style="width:100%;padding:20px 0px; margin:0px; border-collapse: collapse; margin:20px 0px;Lline-height:1.5">
                <tr>
                    <td>
                        <b>College : </b> <?php echo $subject_wise_list[0]->campus_name;?>
                    </td>
                    <td style="text-align:right">
                        <b>Batch :</b> <?php  echo $subject_wise_list[0]->batch_name; ?>
                    </td>
                </tr>

                 <tr>
                    <td>
                        <b>Subject Name &nbsp;:</b>&nbsp;&nbsp; <?php echo $subject_wise_list[0]->course_title;?>
                    </td>
                    <td style="text-align: right;">
                        <b>Subject ID &nbsp;:</b>&nbsp;&nbsp;<?php echo $subject_wise_list[0]->course_code;?>
                    </td>
                    
                </tr>


             </table>   



<hr>



     <table class="table" width="200%" style="border:solid 1px black; font-size:10px; ">
                <tr>
                    <th rowspan="3" style="font-weight:800 !important;">S.No.</th>
                    <th rowspan="3" style="font-weight:800 !important;">ID.No.</th>
                    <th rowspan="3" style="font-weight:800 !important;">Name</th>
                    <th colspan="4" scope="colgroup" style="font-weight:800 !important;">INTERNAL</th>
                    <th colspan="5" scope="colgroup" style="font-weight:800 !important;">THEORY</th>
                    <th colspan="1" scope="colgroup" style="font-weight:800 !important;">TOTAL</th>
                    <th colspan="4" scope="colgroup" style="font-weight:800 !important;">PRACTICAL</th>
                    <th colspan="1" scope="colgroup" style="font-weight:800 !important;">TOTAL</th>
                    <th colspan="1" scope="colgroup" style="font-weight:800 !important;">TOTAL</th>
                    <th rowspan="3" style="font-weight:800 !important;">RESULT</th>
                </tr>
                <tr>
                    <th scope="col">FIRST</th>
                    <th scope="col">SECOND</th>
                    <th scope="col">THIRD</th>
                    <th scope="col">TOTAL</th> 
                    <th scope="col">PAPER-I</th>
                    <th scope="col">PAPER-I</th>
                    <th scope="col">PAPER-II</th>
                    <th scope="col">PAPER-II</th>
                    <th scope="col">TOTAL</th>
                    <th scope="col">INTERNAL + THEORY</th> 
                    <th scope="col">PAPER-I</th>
                    <th scope="col">PAPER-I</th>
                    <th scope="col">PAPER-II</th>
                    <th scope="col">PAPER-II</th>
                    <th scope="col">PRACTICAL</th>
                    <th scope="col">INTERNAL + THEORY + PRACTICAL</th>
                </tr>
                <tr>
                    <th scope="col">(10)</th>
                    <th scope="col">(10)</th>
                    <th scope="col">(10)</th>
                    <th scope="col">(20)</th>
                    <th scope="col">(100)</th>
                    <th scope="col">(20)</th>
                    <th scope="col">(100)</th>
                    <th scope="col">(20)</th>
                    <th scope="col">(40)</th>
                    <th scope="col">(60)</th>
                    <th scope="col">(60)</th>
                    <th scope="col">(20)</th>
                    <th scope="col">(60)</th>
                    <th scope="col">(20)</th>
                    <th scope="col">(40)</th>
                    <th scope="col">(100)</th>
                </tr>

                <tr>
                    
                </tr>
                <!--<tr>
                    <td>VAN-I</td>
                    <td>VAN-II</td>
                    <td>VPY-I</td>
                    <td>THEORY</td>
                    <td>VPY-II</td>
                    <td>LPM-I</td>
                    <td>LPM-II</td>
                    <td>LPM-II</td>
                    <td>PASS</td>
                    <td>LPM-II</td>
                    <td>PASS</td>
                    <td>THEORY</td>
                    <td>VPY-II</td>
                    <td>LPM-I</td>
                    <td>LPM-II</td>
                    <td>LPM-II</td>
                    <td>PASS</td>
                    <td>LPM-II</td>
                    <td>PASS</td>
                    <td>PASS</td>
					
					
				
                </tr>-->
				<?php $i=0;
                      $theory_externals='';
                      $practical_externals='';
					  $theory_marks_40='';
					  $internal_plus_theory='';
					  $paper1_20='';
					  $paper2_20='';
					  $paper1_20s='';
					  $paper2_20s='';
					  $paper_20='';
					  $total_subject_aggregate='';
				      foreach($subject_wise_list as $subject_wise_val){$i++;
				                       
				      $theory_externals=$subject_wise_val->theory_external/5;
				      $practical_externals=$subject_wise_val->practical_external/5;
					  $theory_marks_40=$theory_externals+$practical_externals;
					  $internal_plus_theory=$subject_wise_val->theory_internal+$theory_marks_40;
					  
					  $paper1_20=$subject_wise_val->theory_paper1/3;
					  $paper1_20s=number_format($paper1_20,2);
					  $paper2_20=$subject_wise_val->theory_paper2/3;
					  $paper2_20s=number_format($paper2_20,2);
					  $paper_20=$paper1_20s+$paper2_20s;
					  $total_subject_aggregate=$internal_plus_theory+$paper_20;
				?>
				<tr>
				
					
					<td><?php echo $i;?></td>
                    <td><?php echo $subject_wise_val->user_unique_id;?></td>
                    <td><?php echo $subject_wise_val->first_name;?></td>
                    <td><?php echo $subject_wise_val->theory_internal1;?></td>
                    <td><?php echo $subject_wise_val->theory_internal2;?></td>
                    <td><?php echo $subject_wise_val->theory_internal3;?></td>
                    <td><?php echo $subject_wise_val->theory_internal;?></td>
                    <td><?php echo $subject_wise_val->theory_external;?></td>
                    <td><?php echo $theory_externals;?></td>
                    <td><?php echo $subject_wise_val->practical_external;?></td>
                    <td><?php echo $practical_externals;?></td>
                    <td><?php echo $theory_marks_40;?></td>
                    <td><?php echo $internal_plus_theory;?></td>
                    <td><?php echo $subject_wise_val->theory_paper1;?></td>
                    <td><?php echo $paper1_20s;?></td>
                    <td><?php echo $subject_wise_val->theory_paper2;?></td>
                    <td><?php echo $paper2_20s;?></td>
                    <td><?php echo $paper_20;?></td>
                    <td><?php echo $total_subject_aggregate;?></td>
                    <td><?php echo $subject_wise_val->passfail_status;?></td>
				   </tr>
					<?php }?>
				

            </table>
           <!-- <table width="100%">
                <tr>
                    <td>
                        <div>
                            <table class="table" width="100%">
                                <tr style="border:solid 1px;">
                                    <th colspan="2">
                                        CURRENT SEMESTER
                                    </th>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div>
                            <table class="table" width="100%">
                                <tr style="border:solid 1px;">
                                    <th colspan="2">
                                        UPTO LAST SEMESTER
                                    </th>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div>
                            <table class="table" width="100%">
                                <tr style="border:solid 1px;">
                                    <th colspan="2">
                                        OVER ALL GRADE POINT AVERAGE
                                    </th>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>

                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                                <tr>
                                    <td>Credit Points</td>
                                    <td>159.65</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>-->
        </div>
    </div>
</body>




</html>
