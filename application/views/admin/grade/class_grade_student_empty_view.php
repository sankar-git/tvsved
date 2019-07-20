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
                    <td><div><span class="logo"><img height="90" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png"></span></div></td>
                    <td>
                        <div>
                            <table>
                                <tr><td><div><div style="margin-left:30px; font-weight:bold; font-size:16px;"><p>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</p></div></div></td></tr><br />
                                <tr>
                                    <td align="center">
                                            <p align="center" style=" font-size:14px;"><b><?php echo $aggregate_marks[0]->discipline_code;?></b></p><br />
                                            <p align="center" style=" font-size:14px; padding:10px 0px 0px 0px;"><b>
                                            RESULTS</b>
                                            </p>
                                    </td>
                                    <!-- <td align="center">
                                            <p></p>                           
                                    </td> -->
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
         <h6 align="center"><?php echo strtoupper($aggregate_marks[0]->semester_name);?> FINAL EXAMINATION RESULTS</h6>
		
	</p> -->
    <div style="padding:0px; width:100%; font-family:Arial, Helvetica, sans-serif; ">
        <div class="pdf_container">
             <table class="sub-detail-tbl" width="100%" style="font-size:12px;">
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
                    <td> : <?php if(!empty($date_of_exam)){ $doe = explode("-", $date_of_exam); $mon_nam = gregoriantojd($doe[1],$doe[0],$doe[2]);
                    echo jdmonthname($mon_nam,0).' '.$doe[2];}else{
                        echo " Select Month & Year ";
                    }?></td>
                </tr>
                <tr>
                   <td><b>Subject</b></td>
                   <td> : <?php echo $aggregate_marks[0]->course_title;?></td>
                    <td><b>Credit Hours</b></td>
                    <td> : <?php echo $aggregate_marks[0]->theory_credit.'+'.$aggregate_marks[0]->practicle_credit;?></td>
                </tr>
            </table>
           <!--  <table class="sub-detail-tbl" style="width:100%;padding:10px 0px; margin:0px; border-collapse: collapse; margin:10px 0px;Lline-height:1.5">
				<tr>
                    <td align="left" width="20%" style="vertical-align:top;font-weight:bold;">College &nbsp;:&nbsp;</td>
					<td align="left" style="vertical-align:top;"><?php echo $aggregate_marks[0]->campus_name;?></td>			
                    <td align="right" style="vertical-align:top;font-weight:bold;">Batch &nbsp;:&nbsp;</td>
                    <td align="right" style="vertical-align:top;"><?php echo $aggregate_marks[0]->batch_name;?></td> 		
					
            
                   
                </tr>
                <tr>
					<td align="right" width="20%" style="vertical-align:top;font-weight:bold;">Examination</td>
					<td align="left" style="vertical-align:top;">&nbsp;</td>
                    <td align="right" width="250px" style="vertical-align:top;font-weight:bold;">Month & Year of Exam &nbsp;:&nbsp;</td>
                    <td align="right" style="vertical-align:top;"><?php echo $month.' - '.$year;?></td>
                    
                </tr>
             </table> -->

        <div class="table_holder">
           
		<table class="table" width="100%" style="border:solid 1px black; ">
                <tr>
                    <th width="10%" style="font-weight:bold;">S.No.</th>
                    <th width="10%" style="font-weight:bold;">ID No.</th>
                    <th width="30%" style="font-weight:bold;">NAME</th>
					<?php foreach($courseGroup as $key=>$value){ 
                        $corse_name = $this->Generate_model->get_coursesubj_name($value);?>
                    <th width="10%" style="font-weight:bold;"><?php echo $corse_name;?></th>
					<?php } ?>
					<th width="10%" style="font-weight:bold;">RESULT</th>
                </tr>
<?php $counter=0; foreach($result_marks as $name=>$courseGroupArr){ 
			$result_str ='';
			foreach($courseGroupArr as $groupname=>$marksArr){
				//print_r($marks);exit;
				foreach($marksArr as $key=>$marks){
					$result[$name][$groupname][] = $marks->result;
				}
				$result[$name][$groupname] = array_unique($result[$name][$groupname]);
				if(count($result[$name][$groupname])>1)
					$result[$name][$groupname] = 'FAIL';
				else
					$result[$name][$groupname] = $result[$name][$groupname][0];
				
			}
			//print_r($result[$name]);exit;
			$counter++;
			?>
				<tr>	
					
					<td  style="padding:2px;"><?php echo $counter;?></td>
                    <td  style="padding:2px;"><?php echo $marks->user_unique_id;?></td>
                    <td  align="left" style="padding:2px;"> <?php echo ucfirst($marks->first_name).' '.ucfirst($marks->last_name);?></td>
                    <?php $passcnt=0;$failcnt=0; foreach($courseGroup as $key=>$value){ 
					if($result[$name][$value] == 'FAIL' || $result[$name][$value] == 'ABSENT') 
						$failcnt++;
					else
						$passcnt++;
					?>
					<td  style="padding:2px;"><?php echo $result[$name][$value];?></td>
					<?php } ?>
                    <td  style="padding:2px;"><?php if($passcnt == count($courseGroup)) echo "PASS";elseif($failcnt<3) echo "CAP"; else echo "FAIL";?> </td>
				</tr>			
			<?php  } ?>
            </table>


            
             
        </div>












        </div>




    
</body>




</html>