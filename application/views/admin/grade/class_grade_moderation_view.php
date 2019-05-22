<html>
<head>
 
    <style>
        .table {
             
            border-collapse: collapse;
            padding:0px !important;
        }

            .table tr th {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 0px 0px 0px 0px !important;
                font-size: 14px;
				font-weight:bold;
				height:31px;
            }

                .table th td {
                     
                    border-collapse: collapse;
                    padding: 0px 0px 0px 0px !important;
                }

            .table tr td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 12px;
				font-weight:normal;
                padding: 0px 0px 0px 0px !important;
				height:31px;
				text-align:center;
				
            }

        .pdf_container{
            width:100%;
            display:block;
            padding:0px;
            margin:0px;
        }   

    </style>
</head>


<body>
	<p align="center">
	     <h5 align="center">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY </h5>
         <h6 align="center"><?php echo $aggregate_marks[0]->discipline_code.'. ('.strtoupper($aggregate_marks[0]->discipline_name).')';?></h6>
         <h6 align="center"><?php echo strtoupper($aggregate_marks[0]->semester_name);?> Moderation Marks</h6>
		
	</p>
    <div style="padding:0px; width:100%; font-family:Arial, Helvetica, sans-serif; ">
        <div class="pdf_container">
            <table class="sub-detail-tbl" style="width:100%;padding:10px 0px; margin:0px; border-collapse: collapse; margin:10px 0px;Lline-height:1.5">
				<tr>
                    <td align="left" width="90px" style="vertical-align:top;font-weight:bold;">College &nbsp;&nbsp;:&nbsp;&nbsp;</td>
					<td align="left" width="200px" style="vertical-align:top;font-weight:bold;margin-left:1px;"><?php echo $aggregate_marks[0]->campus_code;?></td>					
					<td align="right" width="250px" style="vertical-align:top;font-weight:bold;">Month & Year of Exam &nbsp;:&nbsp;</td>
					<td align="left"width="250px" style="vertical-align:top;font-weight:bold;"><?php echo $month.' - '.$year;?></td>
            
                   
                </tr>
                <tr>
					<td align="right" width="90px" style="vertical-align:top;font-weight:bold;"></td>
					<td align="left"width="200px" style="vertical-align:top;font-weight:bold;">&nbsp;</td>
                    <td align="right" width="250px" style="vertical-align:top;font-weight:bold;">Batch &nbsp;:&nbsp;</td>
					<td align="left" width="250px" style="vertical-align:top;font-weight:bold;"><?php echo $aggregate_marks[0]->batch_name;?></td>  
                    
                </tr>
             </table>

        <div class="table_holder">
           
		<table class="table" width="100%" style="border:solid 1px black; ">
                <tr>
                    <th rowspan="2" width="5%" style="font-weight:bold;">SI.No.</th>
                    <th rowspan="2" width="15%" style="font-weight:bold;">ID No.</th>
                    <th rowspan="2" width="30%" style="font-weight:bold;">NAME</th>
					<?php foreach($courseGroup as $key=>$value){?>
                    <th colspan="2" width="10%" style="font-weight:bold;"><?php echo $value;?></th>
					<?php } ?>
					<th rowspan="2" width="20%" style="font-weight:bold;">Remarks</th>
                </tr>
				<tr>
				<?php foreach($courseGroup as $key=>$value){?>
					<th width="10%" style="font-weight:bold;">Theroy</th>
					<th  width="10%" style="font-weight:bold;">Prac</th>
				<?php } ?>
				</tr>
				
<?php $counter=0; foreach($result_marks as $name=>$courseGroupArr){ 
			$result_str ='';	//echo "<pre>";print_r($courseGroupArr);exit;
			foreach($courseGroupArr as $groupname=>$marksArr){
				
				foreach($marksArr as $key=>$marks){
					$result[$name][$groupname]['prac'] = $marks->prac_diff;
					$result[$name][$groupname]['theroy'] = $marks->theory_diff;
				}
				
				
			}
		//	p($result);exit;
			$counter++;
			?>
				<tr>	
					
					<td  style="padding:2px;"><?php echo $counter;?></td>
                    <td  style="padding:2px;"><?php echo $marks->user_unique_id;?></td>
                    <td  align="left" style="padding:2px;"> <?php echo ucfirst($marks->first_name).' '.ucfirst($marks->last_name);?></td>
                    <?php $passcnt=0;$failcnt=0; foreach($courseGroup as $key=>$value){  
					?>
					<td  style="padding:2px;"><?php echo $result[$name][$value]['theroy'];?></td>
					<td  style="padding:2px;"><?php echo $result[$name][$value]['prac'];?></td>
					<?php } ?>
                    <td  style="padding:2px;">-</td>
				</tr>			
			<?php  } ?>
            </table>


            
             
        </div>












        </div>




    
</body>




</html>