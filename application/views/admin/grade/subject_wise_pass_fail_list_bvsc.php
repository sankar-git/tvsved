<?php //p($dummy_number_report[0]['degree_name']); exit;?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $title;?></title>
<style>
        .table {
             
            border-collapse: collapse;
            padding:0px !important;
        }

            .table th {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 0px 0px 0px 0px !important;
                font-size: 14px;
            }

                .table th td {
                     
                    border-collapse: collapse;
                    padding: 0px 0px 0px 0px !important;
                }

            .table tr td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 14px;
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
	
		<p align="center">
	     <h4 align="center">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY <BR />
          B.V.Sc. & A.H. - DEGREE - <?php echo strtoupper($title);?></h4>
			<?php if(!isset($_POST['downloadpdf'])){?>
                <h5 align="center"><a href="javascript:;" onclick="document.genpdf.submit();">Download PDF</a></h5>
			<?php } ?>		 
	   </p>
	  
	
    <div style="padding:0px; width:100%; font-family:Arial, Helvetica, sans-serif; ">
        <div class="pdf_container">
			<table class="sub-detail-tbl" style="width:100%; margin:0px; border-collapse: collapse; margin:20px 0px;Line-height:1.5">
				<tr>
                    <td align="left" width="20%" style="vertical-align:top;font-weight:bold;">College</td>
					<td align="left" width="50%" style="vertical-align:top;font-weight:bold;;">:&nbsp;<?php echo $subject_wise_list[0]->campus_code;?></td>					
					<td align="left" width="15%" style="vertical-align:top;font-weight:bold;">Batch</td>
					<td align="left"width="20%" style="vertical-align:top;font-weight:bold;">:&nbsp;<?php  echo $subject_wise_list[0]->batch_name; ?></td>                
                   
                </tr>
                <tr>
                    <td align="left"  width="20%" style="vertical-align:top;font-weight:bold;">Subject ID</td>
					<td align="left"  width="50%" style="vertical-align:top;font-weight:bold;">:&nbsp;<?php if(empty($subject_wise_list[0]->course_subject_name)) echo $subject_wise_list[0]->course_code; else echo $subject_wise_list[0]->course_subject_name;?></td>
                    <td align="left" width="15%" style="vertical-align:top;font-weight:bold;">Exam</td>
					<td align="left"  width="20%" style="vertical-align:top;font-weight:bold;">:&nbsp;Annual Board</td>
                    
                </tr>
				<tr>
                    <td align="left"  width="20%" style="vertical-align:top;font-weight:bold;">Subject Name</td>
					<td align="left"  width="50%" style="vertical-align:top;font-weight:bold;">:&nbsp;<?php if(empty($subject_wise_list[0]->course_subject_title)) echo $subject_wise_list[0]->course_title; else echo $subject_wise_list[0]->course_subject_title;?></td>
                    <td align="left" width="15%" style="vertical-align:top;font-weight:bold;">Annual Board</td>
					<td align="left"  width="20%" style="vertical-align:top;font-weight:bold;">:&nbsp;First</td>
                    
                </tr>
             </table> 			 

            <table class="table" width="100%" style="border:solid 1px black; font-size:14px; ">
                <tr>
                    <th rowspan="3" style="font-weight:bold;padding:2px;">S.No.</th>
                    <th rowspan="3" style="font-weight:bold;padding:2px;width:120px;">ID.No.</th>
                    <th rowspan="3" style="font-weight:bold;padding:2px;width:350px;">Name</th>
                    <th colspan="4" scope="colgroup" style="font-weight:bold;padding:2px;">INTERNAL</th>
                    <th colspan="<?php echo $course_count*2+1;?>" scope="colgroup" style="font-weight:bold;padding:2px;">THEORY</th>
                    <th colspan="1" scope="colgroup" style="font-weight:bold;padding:2px;">TOTAL</th>
                    <th colspan="<?php echo $course_count*2;?>" scope="colgroup" style="font-weight:bold;padding:2px;">PRACTICAL</th>
                    <th colspan="1" scope="colgroup" style="font-weight:bold;padding:2px;">TOTAL</th>
                    <th colspan="1" scope="colgroup" style="font-weight:bold;padding:2px;">TOTAL</th>
                    <th rowspan="3" style="font-weight:bold;padding:2px;">RESULT</th>
                </tr>
                <tr>
                    <th scope="col" style="padding:2px;width:70px;">FIRST</th>
                    <th scope="col"  style="padding:2px;width:70px;">SECOND</th>
                    <th scope="col"  style="padding:2px;width:70px;">THIRD</th>
                    <th scope="col"  style="padding:2px;width:70px;">TOTAL</th> 
					<?php for($j=0;$j<$course_count;$j++){?>
                    <th scope="col"  style="padding:2px;width:70px;">PAPER-<?php echo $numeralCodes[$j];?></th>
                    <th scope="col"  style="padding:2px;width:70px;">PAPER-<?php echo $numeralCodes[$j];?></th>
                   
					<?php }  ?>
					
                    <th scope="col"  style="padding:2px;width:70px;">TOTAL</th>
                    <th scope="col"  style="padding:2px;width:70px;">INTERNAL + THEORY</th> 
                    <?php for($j=0;$j<$course_count;$j++){?>
                    <th scope="col"  style="padding:2px;width:70px;">PAPER-<?php echo $numeralCodes[$j];?></th>
                    <th scope="col"  style="padding:2px;width:70px;">PAPER-<?php echo $numeralCodes[$j];?></th>
                   
					<?php }  ?>
                    <th scope="col"  style="padding:2px;width:70px;">PRACTICAL</th>
                    <th scope="col"  style="padding:2px;width:70px;">INTERNAL + THEORY + PRACTICAL</th>
                </tr>
                <tr>
                    <th scope="col"  style="padding:2px;">(10)</th>
                    <th scope="col" style="padding:2px;">(10)</th>
                    <th scope="col"  style="padding:2px;">(10)</th>
                    <th scope="col"  style="padding:2px;">(20)</th>
					<?php for($j=0;$j<$course_count;$j++){?>
                    <th scope="col"  style="padding:2px;">(100)</th>
                    <th scope="col"  style="padding:2px;">(20)</th>
					<?php }?>
                    
                    <th scope="col"  style="padding:2px;">(40)</th>
                    <th scope="col"  style="padding:2px;">(60)</th>
                    <?php for($j=0;$j<$course_count;$j++){?>
					<th scope="col"  style="padding:2px;">(60)</th>
                    <th scope="col"  style="padding:2px;">(20)</th>
                    <?php }  ?>
                    <th scope="col"  style="padding:2px;">(40)</th>
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
				      foreach($subject_wise_list as $subject_wise_val){
						  
						  
				                       
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
				
					
					<td  align="center" style="padding:2px;height:30px;"><?php echo $i;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $subject_wise_val->user_unique_id;?></td>
                    <td  align="left" style="padding:2px;"><?php echo $subject_wise_val->first_name;?></td>
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->theory_internal1/4);?></td>
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->theory_internal2/4);?></td>
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->theory_internal3/4);?></td>
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($theory_internal_total);?></td>
					<?php $theory_marks_40=0; for($j=1;$j<=$course_count;$j++){ $var = "theory_external".$j; $theory_marks_40+=$subject_wise_val->{$var}/5;?>
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->{$var});?></td>
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->{$var}/5);?></td>
					<?php }?>
                    
                    <td  align="center" style="padding:2px;"><?php if($course_count == 1) $theory_marks_40=$theory_marks_40*2;  elseif($course_count > 2) $theory_marks_40=$theory_marks_40*2/$course_count;  echo round_two_digit($theory_marks_40);?></td>
                    <td  align="center" style="padding:2px;font-weight:bold"><?php echo round_two_digit($theory_internal_total+$theory_marks_40);?></td>
					<?php $paper_20=0; for($j=1;$j<=$course_count;$j++){ $var = "theory_paper".$j; $paper_20+=$subject_wise_val->{$var}/3;?>
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->{$var});?></td>
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->{$var}/3);?></td>
					<?php }?>
                  
                    <td  align="center" style="padding:2px;font-weight:bold" ><?php $paper_20=($paper_20*2)/$course_count;  echo round_two_digit($paper_20);?></td>
                    <td  align="center" style="padding:2px;font-weight:bold"><?php echo round_two_digit($theory_internal_total+$theory_marks_40+$paper_20);?></td>
                    <td  align="center" style="padding:2px;"><?php if(($theory_internal_total+$theory_marks_40) >=30 && $paper_20>=20 && ($theory_internal_total+$theory_marks_40+$paper_20)>=50) echo "PASS"; else echo "FAIL";?></td>
				   </tr>
					<?php }?>
				

            </table>

        </div>
    </div>
</body>




</html>
