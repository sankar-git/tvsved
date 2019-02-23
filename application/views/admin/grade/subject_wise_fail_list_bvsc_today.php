<?php //p($dummy_number_report[0]['degree_name']); exit;?>

<!DOCTYPE html>
<html>
<head>
    <title>Subject Wise Fail List</title>
    
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
                        <b>Subject Code : </b><?php  echo $subject_wise_list[0]->course_code; ?> (<?php echo $subject_wise_list[0]->theory_credit;?>+<?php echo $subject_wise_list[0]->practicle_credit;?>)
                    </td>
                    <td style="text-align: right;">
                        <b>Subject : </b> <?php  echo $subject_wise_list[0]->course_title; ?>
                    </td>
                    
                </tr>


             </table>   



<hr>

            <table class="table" width="200%" style="border:solid 1px black; font-size:10px; ">
                <tr>
                    <th rowspan="3" style="font-weight:800 !important;padding:2px;">S.No.</th>
                    <th rowspan="3" style="font-weight:800 !important;padding:2px;">ID.No.</th>
                    <th rowspan="3" style="font-weight:800 !important;padding:2px;">Name</th>
                    <th colspan="4" scope="colgroup" style="font-weight:800 !important;padding:2px;">INTERNAL</th>
                    <th colspan="5" scope="colgroup" style="font-weight:800 !important;padding:2px;">THEORY</th>
                    <th colspan="1" scope="colgroup" style="font-weight:800 !important;padding:2px;">TOTAL</th>
                    <th colspan="4" scope="colgroup" style="font-weight:800 !important;padding:2px;">PRACTICAL</th>
                    <th colspan="1" scope="colgroup" style="font-weight:800 !important;padding:2px;">TOTAL</th>
                    <th colspan="1" scope="colgroup" style="font-weight:800 !important;padding:2px;">TOTAL</th>
                    <th rowspan="3" style="font-weight:800 !important;padding:2px;">RESULT</th>
                </tr>
                <tr>
                    <th scope="col" style="padding:2px;">FIRST</th>
                    <th scope="col"  style="padding:2px;">SECOND</th>
                    <th scope="col"  style="padding:2px;">THIRD</th>
                    <th scope="col"  style="padding:2px;">TOTAL</th> 
                    <th scope="col"  style="padding:2px;">PAPER-I</th>
                    <th scope="col"  style="padding:2px;">PAPER-I</th>
                    <th scope="col"  style="padding:2px;">PAPER-II</th>
                    <th scope="col"  style="padding:2px;">PAPER-II</th>
                    <th scope="col"  style="padding:2px;">TOTAL</th>
                    <th scope="col"  style="padding:2px;">INTERNAL + THEORY</th> 
                    <th scope="col"  style="padding:2px;">PAPER-I</th>
                    <th scope="col"  style="padding:2px;">PAPER-I</th>
                    <th scope="col"  style="padding:2px;">PAPER-II</th>
                    <th scope="col"  style="padding:2px;">PAPER-II</th>
                    <th scope="col"  style="padding:2px;">PRACTICAL</th>
                    <th scope="col"  style="padding:2px;">INTERNAL + THEORY + PRACTICAL</th>
                </tr>
                <tr>
                    <th scope="col"  style="padding:2px;">(10)</th>
                    <th scope="col" style="padding:2px;">(10)</th>
                    <th scope="col"  style="padding:2px;">(10)</th>
                    <th scope="col"  style="padding:2px;">(20)</th>
                    <th scope="col"  style="padding:2px;">(100)</th>
                    <th scope="col"  style="padding:2px;">(20)</th>
                    <th scope="col"  style="padding:2px;">(100)</th>
                    <th scope="col"  style="padding:2px;">(20)</th>
                    <th scope="col"  style="padding:2px;">(40)</th>
                    <th scope="col"  style="padding:2px;">(60)</th>
                    <th scope="col"  style="padding:2px;">(60)</th>
                    <th scope="col"  style="padding:2px;">(20)</th>
                    <th scope="col"  style="padding:2px;">(60)</th>
                    <th scope="col"  style="padding:2px;">(20)</th>
                    <th scope="col"  style="padding:2px;">(40)</th>
                    <th scope="col"  style="padding:2px;">(100)</th>
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
				
					
					<td  style="padding:2px;"><?php echo $i;?></td>
                    <td  style="padding:2px;"><?php echo $subject_wise_val->user_unique_id;?></td>
                    <td  style="padding:2px;"><?php echo $subject_wise_val->first_name;?></td>
                    <td  style="padding:2px;"><?php echo $subject_wise_val->theory_internal1;?></td>
                    <td  style="padding:2px;"><?php echo $subject_wise_val->theory_internal2;?></td>
                    <td  style="padding:2px;"><?php echo $subject_wise_val->theory_internal3;?></td>
                    <td  style="padding:2px;"><?php echo $subject_wise_val->theory_internal;?></td>
                    <td  style="padding:2px;"><?php echo $subject_wise_val->theory_external;?></td>
                    <td  style="padding:2px;"><?php echo $theory_externals;?></td>
                    <td  style="padding:2px;"><?php echo $subject_wise_val->practical_external;?></td>
                    <td  style="padding:2px;"><?php echo $practical_externals;?></td>
                    <td  style="padding:2px;"><?php echo $theory_marks_40;?></td>
                    <td  style="padding:2px;"><?php echo $internal_plus_theory;?></td>
                    <td  style="padding:2px;"><?php echo $subject_wise_val->theory_paper1;?></td>
                    <td  style="padding:2px;"><?php echo $paper1_20s;?></td>
                    <td  style="padding:2px;"><?php echo $subject_wise_val->theory_paper2;?></td>
                    <td  style="padding:2px;"><?php echo $paper2_20s;?></td>
                    <td  style="padding:2px;" ><?php echo $paper_20;?></td>
                    <td  style="padding:2px;"><?php echo $total_subject_aggregate;?></td>
                    <td  style="padding:2px;"><?php echo $subject_wise_val->passfail_status;?></td>
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
</body>




</html>
