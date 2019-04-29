<?php  foreach($hall_tickets as $key=>$halldata){?>
<?php $this->load->view('admin/pdf/pdf_header',$halldata);?>
            
            <table id="table" width="100%" class="table">

                <tr>
                    <td align="center" style=" font-size:13px; font-weight:bold;" colspan="2">
                        <div>
                            <table width="100%" id="table2" class="tableLevelTwo">
                                <tr style="height:100px; border:none;">
                                    <td style="border:none;" align="center">
                                        <div>
                                            <!--<img src="<?php echo base_url('');?>assets/admin/dist/img/logo.jpg"  alt="loading..." height="50px"/>-->
                                            
                                    <?php if(!empty($halldata['user_image']) && file_exists('uploads/user_images/student/'. $halldata['user_image'])){?>
									<img style="height:70px;width:70px;" src="<?php echo base_url('uploads/user_images/student/'. $halldata['user_image']);?>" alt="current"/>
									<?php } else {?>
									<img style="height:50px;width:50px;" src="<?php echo base_url('uploads/user_images/student/');?>/no_image.jpg" alt="current"/>
									<?php }?>
                                            
                                        </div>
                                    </td>
                                </tr>
                                <tr style="border:none">
                                    <td >
                                        <div style="padding-left:20px"><?php echo $halldata['user_unique_id'];?></div>
                                    </td>
                                </tr>
                                <tr style=" border:none;">
                                    <td style="font-size:9px; padding:0;">
                                        <div style=""><?php echo $halldata['first_name'].' '.$halldata['last_name']?></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td align="center" height="100%"  valign="top" style=" font-size:14px; font-weight:bold;">
                      
                            <table width="100%" id="table3" class="tableLevelTwo">
                                <tr>

                                    <!--<th style="width:100px; font-size:11px; font-weight:bold;">Date</th>-->
                                    <th style="width:70%; font-size:13px; font-weight:bold;border-top:none;border-right:none;border-left:none;">Subjects</th>
                                    <th style="width:30%; font-size:13px; font-weight:bold;border-top:none;border-right:none;border-left:none;">Exam Date</th>

                                </tr>
                              <?php $i=0; foreach($halldata['subjectList'] as $subjects){?>
                                <tr >
                                    <!--<td align="center" style=" font-size:11px; font-weight:bold;">22-03-2017</td>-->
                                    <td align="left" style=" font-size:13px;border-top:none;border-left:none; ">&nbsp;<?php echo $subjects['course_title'];?></td>
									<td align="center" style=" font-size:13px;border-top:none;border-right:none;border-left:none;"><?php echo $subjects['exam_date'];?></td>
                                </tr>
								 <?php $i++;}?>
                           </table>
                        
                    </td>
                </tr>
            </table>
            <br />
            <br />
            <table width="100%">
                <tr>
                    <td align="left" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>Attested</div></td>
                    <td align="right" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>Signature of the Dean</div></td>
                    <td align="right" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>Signature of the Candidate</div></td>
                </tr>

            </table>
            <br />
            <br />
            <table width="100%">
                <tr>
                    <td align="left" style=" font-size:12px; font-weight:bold;text-transform: uppercase;"><div>University Seal</div></td>
                    <td align="left" style=" font-size:12px; font-weight:bold; padding-left:0px;text-transform: uppercase;"><div>Controller of Examinations</div></td>
                    <td align="right" style=" font-size:12px; font-weight:bold; padding-right:30px;text-transform: uppercase;"><div>Registrar</div></td>
                </tr>
            </table>
        </div>
    </div>
	<?php if($key+1 < count($hall_tickets)){?>
	<!--<tocpagebreak>-->
	<br/><br/>
	<?php } }?>
