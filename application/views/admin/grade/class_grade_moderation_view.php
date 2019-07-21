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
    <table>
                <tr>
                    <td><div><span class="logo"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td><br />
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:16px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr>
                                <tr>
                                    <td align="center">
                                            <p align="center" style=" font-size:14px;"><b><?php echo $aggregate_marks[0]->discipline_code;?></b></p><br />
                                            <p align="center" style=" font-size:14px; padding:10px 0px 0px 0px;"><b>
                                            DEFICIT MARK REPORT</b>
                                            </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <hr />
	<!-- <p align="center">
	     <h5 align="center">TAMILNADU VETERINARY AND ANIMAL SCIENCES UNIVERSITY </h5>
         <h6 align="center"><?php echo $aggregate_marks[0]->discipline_code.'. ('.strtoupper($aggregate_marks[0]->discipline_name).')';?></h6>
         <h6 align="center"><?php echo strtoupper($aggregate_marks[0]->semester_name);?> Moderation Marks</h6>
		
	</p> -->
    <div style="padding:0px; width:100%; font-family:Arial, Helvetica, sans-serif; ">
        <div class="pdf_container">
            <table width="100%" class="sub-detail-tbl" style="font-size:12px;">
                <tr>
                    <td><b>College</b></td>
                    <td> : <?php echo $aggregate_marks[0]->campus_name;?></td>
                    <td><b>Batch</b></td>
                    <td> : <?php echo $aggregate_marks[0]->batch_name;?></td>
                </tr>
                <tr>
                    <td><b>Examination</b></td>
                    <td > : <?php echo $aggregate_marks[0]->semester_name.'-'."Annual";?></td>
                    <td><b>Month & Year</b></td>
                    <td> : <?php if(!empty($month) && !empty($year)){ 
                    echo $month.' '.$year;}else{echo "Select Month&Year of Exam";}?></td>
                </tr>
            </table>
            

        <div class="table_holder">
           
		<table class="table" width="100%" style="border:solid 1px black; ">
                <tr>
                    <th rowspan="2" width="5%" style="font-weight:bold;">SI.No.</th>
                    <th rowspan="2" width="15%" style="font-weight:bold;">ID No.</th>
                    <th rowspan="2" width="30%" style="font-weight:bold;">NAME</th>
					<?php foreach($courseGroup as $key=>$value){?>
                    <th colspan="2" width="20%" style="font-weight:bold;"><?php 
                    $title = $this->Gradechart_model->get_title_bycode($value); echo $title;?></th>
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
        <div>
            <h5 align="left">Suggest Moderation Mark :</h5>
            <?php foreach($courseGroup as $key=>$value){?>
                <label width="50%"><?php $title = $this->Gradechart_model->get_title_bycode($value); 
                echo $title;?></label> :____________________<br />
            <?php } ?>
            
        </div>

        </div>




    
</body>




</html>