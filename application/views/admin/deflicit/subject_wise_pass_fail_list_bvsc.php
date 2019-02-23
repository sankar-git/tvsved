			<thead>
                <tr>
                    <th rowspan="3" style="font-weight:bold;padding:2px;">S.No.</th>
                    <th rowspan="3" style="font-weight:bold;padding:2px;width:120px;">ID.No.</th>
                    <th rowspan="3" style="font-weight:bold;padding:2px;width:350px;">Name</th>
                    <th  scope="colgroup" style="font-weight:bold;padding:2px;text-align:center;vertical-align:middle">INTERNAL</th>
                    <th colspan="<?php echo $course_count+1;?>" scope="colgroup" style="font-weight:bold;padding:2px;text-align:center;vertical-align:middle">THEORY</th>
                    <th colspan="1" scope="colgroup" style="font-weight:bold;padding:2px;">TOTAL</th>
                    <th colspan="<?php echo $course_count;?>" scope="colgroup" style="font-weight:bold;padding:2px;text-align:center;vertical-align:middle">PRACTICAL</th>
                    <th colspan="1" scope="colgroup" style="font-weight:bold;padding:2px;">TOTAL</th>
                    <th colspan="1" scope="colgroup" style="font-weight:bold;padding:2px;text-align:center;vertical-align:middle">TOTAL</th>
                    <th rowspan="3" align="center" style="font-weight:bold;padding:2px;text-align:center;vertical-align:middle">RESULT</th>
                    <th colspan="2" rowspan="2" align="center" style="font-weight:bold;padding:2px;text-align:center;vertical-align:middle">DEFLICIT</th>
                </tr>
                <tr>
                    <!--<th scope="col" style="padding:2px;width:70px;">FIRST</th>
                    <th scope="col"  style="padding:2px;width:70px;">SECOND</th>
                    <th scope="col"  style="padding:2px;width:70px;">THIRD</th>-->
                    <th scope="col"  style="padding:2px;width:70px;text-align:center;vertical-align:middle">TOTAL</th> 
					<?php for($j=0;$j<$course_count;$j++){?>
                    <th scope="col"  style="padding:2px;width:70px;text-align:center;vertical-align:middle">PAPER-<?php echo $numeralCodes[$j];?></th>
                    <!--<th scope="col"  style="padding:2px;width:70px;">PAPER-<?php echo $numeralCodes[$j];?></th>-->
                   
					<?php }  ?>
					
                    <th scope="col"  style="padding:2px;width:70px;text-align:center;vertical-align:middle">TOTAL</th>
                    <th scope="col"  style="padding:2px;width:70px;text-align:center;vertical-align:middle">INTERNAL + THEORY</th> 
                    <?php for($j=0;$j<$course_count;$j++){?>
                    <th scope="col"  style="padding:2px;width:70px;text-align:center;vertical-align:middle">PAPER-<?php echo $numeralCodes[$j];?></th>
                    <!--<th scope="col"  style="padding:2px;width:70px;">PAPER-<?php echo $numeralCodes[$j];?></th>-->
                   
					<?php }  ?>
                    <th scope="col"  style="padding:2px;width:70px;text-align:center;vertical-align:middle">PRACTICAL</th>
                    <th scope="col"  style="padding:2px;width:70px;text-align:center;vertical-align:middle">INTERNAL + THEORY + PRACTICAL</th>
                </tr>
                <tr>
                    <!--<th scope="col"  style="padding:2px;">(10)</th>
                    <th scope="col" style="padding:2px;">(10)</th>
                    <th scope="col"  style="padding:2px;">(10)</th>-->
                    <th scope="col"  style="padding:2px;text-align:center;vertical-align:middle">(20)</th>
					<?php for($j=0;$j<$course_count;$j++){?>
                    <!--<th scope="col"  style="padding:2px;">(100)</th>-->
                    <th scope="col"  style="padding:2px;text-align:center;vertical-align:middle">(20)</th>
					<?php }?>
                    
                    <th scope="col"  style="padding:2px;text-align:center;vertical-align:middle">(40)</th>
                    <th scope="col"  style="padding:2px;text-align:center;vertical-align:middle">(60)</th>
                    <?php for($j=0;$j<$course_count;$j++){?>
					<!--<th scope="col"  style="padding:2px;">(60)</th>-->
                    <th scope="col"  style="padding:2px;text-align:center;vertical-align:middle">(20)</th>
                    <?php }  ?>
                    <th scope="col"  style="padding:2px;text-align:center;vertical-align:middle">(40)</th>
                    <th scope="col"  style="padding:2px;text-align:center;vertical-align:middle">(100)</th>
					<th scope="col"  style="padding:2px;width:70px;text-align:center;vertical-align:middle">THEORY</th>
					<th scope="col"  style="padding:2px;width:70px;text-align:center;vertical-align:middle">PRACTICAL</th>
                </tr>
		</thead><tbody>
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
                    <!--<td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->theory_internal1/4);?></td>
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->theory_internal2/4);?></td>
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->theory_internal3/4);?></td>-->
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($theory_internal_total);?></td>
					<?php $theory_marks_40=0; for($j=1;$j<=$course_count;$j++){ $var = "theory_external".$j; $theory_marks_40+=$subject_wise_val->{$var}/5;?>
                    <!--<td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->{$var});?></td>-->
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->{$var}/5);?></td>
					<?php }?>
                    
                    <td  align="center" style="padding:2px;"><?php if($course_count == 1) $theory_marks_40=$theory_marks_40*2;  elseif($course_count > 2) $theory_marks_40=$theory_marks_40*2/$course_count;  echo round_two_digit($theory_marks_40);?></td>
                    <td  align="center" style="padding:2px;font-weight:bold"><?php echo round_two_digit($theory_internal_total+$theory_marks_40);?></td>
					<?php $paper_20=0; for($j=1;$j<=$course_count;$j++){ $var = "theory_paper".$j; $paper_20+=$subject_wise_val->{$var}/3;?>
                    <!--<td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->{$var});?></td>-->
                    <td  align="center" style="padding:2px;"><?php echo round_two_digit($subject_wise_val->{$var}/3);?></td>
					<?php }?>
                  
                    <td  align="center" style="padding:2px;font-weight:bold" ><?php $paper_20=($paper_20*2)/$course_count;  echo round_two_digit($paper_20);?></td>
                    <td  align="center" style="padding:2px;font-weight:bold"><?php echo round_two_digit($theory_internal_total+$theory_marks_40+$paper_20);?></td>
                    <td  align="center" style="padding:2px;"><?php if(($theory_internal_total+$theory_marks_40) >=30 && $paper_20>=20 && ($theory_internal_total+$theory_marks_40+$paper_20)>=50) echo "PASS"; else echo "FAIL";?></td>
					<td  align="center" style="padding:1px;text-align:center;vertical-align:middle">
					<?php if(round_two_digit($theory_internal_total+$theory_marks_40)<30 && round_two_digit($paper_20)>=20) {?>
					<!--<input style="width:50px;" type="text" name="thoery[<?php echo $subject_wise_val->student_id;?>]" id="thoery" value="<?php if(round_two_digit($theory_internal_total+$theory_marks_40)<30) echo round_two_digit(30-($theory_internal_total+$theory_marks_40));?>" />-->
					<?php if(round_two_digit($theory_internal_total+$theory_marks_40)<30) echo round_two_digit(30-($theory_internal_total+$theory_marks_40));?>
					<?php } elseif(round_two_digit($theory_internal_total+$theory_marks_40)<30) echo round_two_digit(30-($theory_internal_total+$theory_marks_40)); else  echo '-';?>
					</td>
					<td  align="center" style="padding:1px;text-align:center;vertical-align:middle">
					<?php if(round_two_digit($paper_20)<20) {
						echo round_two_digit(20-$paper_20);
					} else echo '-';?>
					</td>
					
				   </tr>
					<?php }?>
				</tbody>
