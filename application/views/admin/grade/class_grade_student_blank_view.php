<html>
<head>
    <title>Moderation Mark</title>


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
					<td align="left" width="250px" style="vertical-align:top;font-weight:bold;margin-left:1px;"><?php echo $subject_wise_list[0]->campus_code;?></td>					
					<td align="right" width="240px" style="vertical-align:top;font-weight:bold;">Batch &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
					<td align="left"width="250px" style="vertical-align:top;font-weight:bold;"><?php echo $subject_wise_list[0]->batch_name;?></td>                
                   
                </tr>
                <tr>
                    <td align="left" width="80px" style="vertical-align:top;font-weight:bold;"></td>
					<td align="left" width="250px" style="vertical-align:top;font-weight:bold;"></td>
                    <td align="right" width="240px" style="vertical-align:top;font-weight:bold;">Exam&nbsp;&nbsp;:&nbsp;&nbsp;</td>
					<td align="left"width="250px" style="vertical-align:top;font-weight:bold;"></td>
                    
                </tr>
				<tr>
                    <td align="left" width="80px" style="vertical-align:top;font-weight:bold;">Subject &nbsp;:&nbsp;</td>
					<td align="left" width="250px" style="vertical-align:top;font-weight:bold;"><?php echo $subject_wise_list[0]->course_code;?></td>
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
					  $display = 'fail_list';
				      foreach($subject_wise_list as $key=>$subject_wise_val){
						  
						  
				                       
				      $theory_externals=$subject_wise_val->theory_external1/5;
				      $practical_externals=$subject_wise_val->theory_external2/5;
					  $theory_marks_40=$theory_externals+$practical_externals;
					  $internal_plus_theory=$subject_wise_val->theory_internal+$theory_marks_40;
					  
					  $paper1_20=$subject_wise_val->theory_paper1/3;
					  $paper1_20s=number_format($paper1_20,2);
					  $paper2_20=$subject_wise_val->theory_paper2/3;
					  $paper2_20s=number_format($paper2_20,2);
					  $paper_20=$paper1_20s+$paper2_20s;
					  $total_subject_aggregate=$internal_plus_theory+$paper_20;
					   $numbers = array( $subject_wise_val->theory_internal1,$subject_wise_val->theory_internal2,$subject_wise_val->theory_internal3); 
					   rsort($numbers);
					  $theory_internal_total = $numbers[0]/4 + $numbers[1]/4;
					  if($display == 'fail_list'){
						if(($theory_internal_total+$theory_marks_40) >=30 && $paper_20>=20 && ($theory_internal_total+$theory_marks_40+$paper_20)>=50)
						  continue;
					  }
					  $i++;
				?>
				<tr>	
					
					<td  align="center" style="padding:2px;"><?php echo $i;?></td>
                    <td  align="center" style="padding:2px;"></td>
                    <td  align="left" style="padding:2px; vertical-align:bottom;"><?php echo $subject_wise_val->first_name.' '.$subject_wise_val->last_name;?></td>
                    <?php $theory_marks_40=0; for($j=1;$j<=$course_count;$j++){ $var = "theory_external".$j; $theory_marks_40+=$subject_wise_val->{$var}/5;?>
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->{$var});?></td>
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->{$var}/5);?></td>
					<?php }?>
                    <td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
					<td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
                    <td  align="center" style="padding:2px;">-</td>
				</tr>				
<?php }?>
            </table>    
             
        </div>

        </div>




    
</body>

</html>