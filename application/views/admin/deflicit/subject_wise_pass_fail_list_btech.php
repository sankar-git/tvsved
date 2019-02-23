
				<thead>
                <tr>
				    <th rowspan="3">S.No.</th>
                    <th rowspan="3">I.D.No.</th>
                    <th rowspan="3">STUDENT NAME</th> 
                    <th <?php if($subject_wise_list[0]->practicle_credit >0 && $subject_wise_list[0]->theory_credit >0){?> colspan="2" <?php }?> >INTERNAL</th>
                    <th rowspan="3" scope="colgroup">TOTAL<br/>INTERNAL<br/><?php if($subject_wise_list[0]->practicle_credit >0 && $subject_wise_list[0]->theory_credit >0){?>(30+20)<?php }else{?>(50)<?php }?> </th>
                    <th colspan="1" scope="colgroup">EXTERNAL</th>
                    <th rowspan="3" scope="colgroup">TOTAL<br/>%<br/>(Max.100)</th>
                    <th rowspan="3">GRADE<br/>POINT<br/>(Max.10)</th> 
                    <th rowspan="3">RESULT</th>
                   
                </tr>
                <tr>
				<?php if($subject_wise_list[0]->theory_credit > 0){ ?>
                    <th scope="col">THEORY</th>
					<?php } ?>
					<?php if($subject_wise_list[0]->practicle_credit > 0){ ?>
                    <th scope="col">PRACTICAL</th>
                    <?php } ?>
                    <th scope="col">THEORY</th>
                    
                    
                </tr>
                <tr>
					<?php if($subject_wise_list[0]->practicle_credit == 0){?>
                    <th scope="col">(Max.50)</th>
					<?php }elseif($subject_wise_list[0]->theory_credit > 0){ ?>
                    <th scope="col">(Max.30)</th>
					<?php } ?>
					<?php if($subject_wise_list[0]->theory_credit == 0){?>
                    <th scope="col">(Max.50)</th>
					<?php }elseif($subject_wise_list[0]->practicle_credit > 0){ ?>
                    <th scope="col">(Max.20)</th>
					<?php } ?>
                    
                    <th scope="col">(Max.50)</th>
                    
                </tr>
                </thead><tbody>
				<?php 
				$i=0;
				$total_internal_sum='';
				$subject_total_sum='';
				$percent_subject='';
				$subject_sum_percent100='';
				$subject_sum_percent10='';
				foreach($subject_wise_list as $subject_wise_val){$i++;
				       //$total_internal_sum = number_format($subject_wise_val->theory_internal1+$subject_wise_val->practical_internal,2);
						if($subject_wise_list[0]->theory_credit > 0 && $subject_wise_list[0]->practicle_credit > 0) 
							$total_internal_sum = number_format($subject_wise_val->theory_internal1 + $subject_wise_val->practical_internal,2);
						elseif($subject_wise_list[0]->theory_credit > 0 ) 
							$total_internal_sum = $subject_wise_val->theory_internal1;
						elseif($subject_wise_list[0]->practicle_credit > 0 )
							$total_internal_sum = $subject_wise_val->practical_internal;
							
					   $subject_total_sum = $total_internal_sum+$subject_wise_val->theory_external1;
					   $percent_subject = $subject_total_sum*100/100;
					   $subject_sum_percent100=number_format($percent_subject,2);
					   $subject_sum_percent10= number_format($subject_total_sum/10,2);
					  // p($subject_sum_percent); exit;
					  if($total_internal_sum>=25 && $subject_wise_val->theory_external1>=25)
						  $passfail_status = 'PASS';
					  else
						  $passfail_status = 'FAIL';
					  if($display == 'fail_list'){
						  if($passfail_status == 'PASS')
							  continue;
					  }
				?>
				 <tr>
                    <td><?php echo $i;?></td>
					<td><?php echo $subject_wise_val->user_unique_id;?></td>
                    <td nowrap><?php echo $subject_wise_val->first_name;?></td>
					<?php if($subject_wise_list[0]->theory_credit > 0){ ?>
                    <td align="center"><?php echo ($subject_wise_val->theory_internal1>0)?number_format($subject_wise_val->theory_internal1,2):number_format(0,2);?></td>
					<?php } ?>
					<?php if($subject_wise_list[0]->practicle_credit > 0){ ?>
                    <td align="center"><?php echo ($subject_wise_val->practical_internal>0)?number_format($subject_wise_val->practical_internal,2):number_format(0,2);?></td>
					<?php } ?>
                    <td align="center"><?php echo $total_internal_sum;?></td>
                    <td align="center"><?php echo ($subject_wise_val->theory_external1>0)?number_format($subject_wise_val->theory_external1,2):number_format(0,2);?></td>
                    <td align="center"><?php echo $subject_sum_percent100;?></td>
                    <td align="center"><?php echo $subject_sum_percent10;?></td>
                    <td align="center"><?php echo $passfail_status;?></td>
                   
                </tr>
                <?php } ?>
            </tbody>
