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
                font-size: 13px;
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
	     <h5 align="center">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY </h5>
         <h6 align="center">B.V.Sc. & A.H. - DEGREE SUBJECT WISE MARK REPORT</h6><?php if(!isset($_POST['downloadpdf'])){?>
                <h5 align="center"><a href="javascript:;" onclick="document.genpdf.submit();">Download PDF</a></h5>
			<?php } ?>
		
	</p>
    <div style="padding:0px; width:100%; font-family:Arial, Helvetica, sans-serif; ">
        <div class="pdf_container">
			<table class="sub-detail-tbl" style="width:100%;padding:20px 0px; margin:0px; border-collapse: collapse; margin:20px 0px;Lline-height:1.5">
				<tr>
                    <td align="left" width="150px" style="vertical-align:top;font-weight:bold;">College &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
					<td align="left" width="250px" style="vertical-align:top;font-weight:bold;margin-left:1px;"><?php echo $subject_wise_list[0]->campus_name;?></td>					
					<td align="right" width="350px" style="vertical-align:top;font-weight:bold;">Batch &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
					<td align="left"width="350px" style="vertical-align:top;font-weight:bold;"><?php  echo $subject_wise_list[0]->batch_name; ?></td>                
                   
                </tr>
                <tr>
                    <td align="left" width="150px" style="vertical-align:top;font-weight:bold;">Subject ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
					<td align="left" width="250px" style="vertical-align:top;font-weight:bold;"><?php  echo $subject_wise_list[0]->course_code; ?></td>
                    <td align="right" width="350px" style="vertical-align:top;font-weight:bold;">Exam&nbsp;&nbsp;:&nbsp;&nbsp;</td>
					<td align="left"width="350px" style="vertical-align:top;font-weight:bold;">Annual Board</td>
                    
                </tr>
				<tr>
                    <td align="left" width="150px" style="vertical-align:top;font-weight:bold;">Subject Name &nbsp;:</td>
					<td align="left" width="250px" style="vertical-align:top;font-weight:bold;"><?php  echo $subject_wise_list[0]->course_title; ?></td>
                    <td align="right" width="350px" style="vertical-align:top;font-weight:bold;">Annual Board&nbsp;&nbsp;:&nbsp;&nbsp;</td>
					<td align="left"width="350px" style="vertical-align:top;font-weight:bold;">First</td>
                    
                </tr>
             </table>  
			 
            <table class="table" width="100%" style="border:solid 1px black; font-size:10px; ">
                <tr>
                    <th rowspan="3" style="font-weight:bold;padding:2px;">S.No.</th>
                    <th rowspan="3" style="font-weight:bold;padding:2px;width:120px;">ID.No.</th>
                    <th rowspan="3" style="font-weight:bold;padding:2px;width:350px;">Name</th>
                    <th colspan="4" scope="colgroup" style="font-weight:bold;padding:2px;">INTERNAL</th>
                    <th colspan="5" scope="colgroup" style="font-weight:bold;padding:2px;">THEORY</th>
                    <th colspan="1" scope="colgroup" style="font-weight:bold;padding:2px;">TOTAL</th>
                    <th colspan="4" scope="colgroup" style="font-weight:bold;padding:2px;">PRACTICAL</th>
                    <th colspan="1" scope="colgroup" style="font-weight:bold;padding:2px;">TOTAL</th>
                    <th colspan="1" scope="colgroup" style="font-weight:bold;padding:2px;">TOTAL</th>
                    <th rowspan="3" style="font-weight:bold;padding:2px;">RESULT</th>
                </tr>
                <tr>
                    <th scope="col" style="padding:2px;width:70px;">FIRST</th>
                    <th scope="col"  style="padding:2px;width:70px;">SECOND</th>
                    <th scope="col"  style="padding:2px;width:70px;">THIRD</th>
                    <th scope="col"  style="padding:2px;width:70px;">TOTAL</th> 
                    <th scope="col"  style="padding:2px;width:70px;">PAPER-I</th>
                    <th scope="col"  style="padding:2px;width:70px;">PAPER-I</th>
                    <th scope="col"  style="padding:2px;width:70px;">PAPER-II</th>
                    <th scope="col"  style="padding:2px;width:70px;">PAPER-II</th>
                    <th scope="col"  style="padding:2px;width:70px;">TOTAL</th>
                    <th scope="col"  style="padding:2px;width:70px;">INTERNAL + THEORY</th> 
                    <th scope="col"  style="padding:2px;width:70px;">PAPER-I</th>
                    <th scope="col"  style="padding:2px;width:70px;">PAPER-I</th>
                    <th scope="col"  style="padding:2px;width:70px;">PAPER-II</th>
                    <th scope="col"  style="padding:2px;width:70px;">PAPER-II</th>
                    <th scope="col"  style="padding:2px;width:70px;">PRACTICAL</th>
                    <th scope="col"  style="padding:2px;width:70px;">INTERNAL + THEORY + PRACTICAL</th>
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
				
					
					<td  align="center" style="padding:2px;height:30px;"><?php echo $i;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $subject_wise_val->user_unique_id;?></td>
                    <td  align="left" style="padding:2px;"><?php echo $subject_wise_val->first_name;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $subject_wise_val->theory_internal1;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $subject_wise_val->theory_internal2;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $subject_wise_val->theory_internal3;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $subject_wise_val->theory_internal;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $subject_wise_val->theory_external;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $theory_externals;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $subject_wise_val->practical_external;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $practical_externals;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $theory_marks_40;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $internal_plus_theory;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $subject_wise_val->theory_paper1;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $paper1_20s;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $subject_wise_val->theory_paper2;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $paper2_20s;?></td>
                    <td  align="center" style="padding:2px;" ><?php echo $paper_20;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $total_subject_aggregate;?></td>
                    <td  align="center" style="padding:2px;"><?php echo $subject_wise_val->passfail_status;?></td>
				   </tr>
					<?php }?>
				

            </table>
     
    </div>
</body>




</html>
