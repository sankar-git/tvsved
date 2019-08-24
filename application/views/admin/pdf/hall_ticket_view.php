<?php  foreach($hall_tickets as $key=>$halldata){ 
?>
<?php $this->load->view('admin/pdf/pdf_header',$halldata);?>      
            <table id="table" width="100%" class="table">

                <tr>
                    <td align="center" width="150" style="font-size:13px; font-weight:bold;" colspan="2">
                        <div>
                            <table width="100%" id="table2" class="tableLevelTwo">
                                <tr style="border:none;">
                                    <td style="border:none;height:90px;width:80px;padding-top:10px;" align="center">
                                        <div style="padding-bottom:0px;">
                                            <!--<img src="<?php echo base_url('');?>assets/admin/dist/img/logo.jpg"  alt="loading..." height="50px"/>-->
                                            
                                    <?php if(!empty($halldata['user_image']) && file_exists('uploads/user_images/student/'. $halldata['user_image'])){?>
									<img style="height:90px;width:80px;" src="<?php echo base_url('uploads/user_images/student/'. $halldata['user_image']);?>" alt="current"/>
									<?php } else {?>
									<img style="height:90px;width:80px;" src="<?php echo base_url('uploads/user_images/student/');?>/no_image.jpg" alt="current"/>
									<?php }?>
                                            
                                        </div>
                                    </td>
                                </tr>
								<hr />
                                <tr style="vertical-align:center">
                                    <td style="text-align:center;border:none;vertical-align:center">									
                                        <div style="padding-left:20px;font-weight:bold;"><?php echo $halldata['first_name'].' '.$halldata['last_name']?><br/><?php echo $halldata['user_unique_id'];?></div>
                                    </td>
									<br />
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td align="center" width="500" height="100%"  valign="top" style="font-size:14px; font-weight:bold;">
							
                            <table width="100%" id="table3" class="tableLevelTwo">
                                <tr >

                                    <!--<th style="width:100px; font-size:11px; font-weight:bold;">Date</th>-->
                                    <th style="width:100%; font-size:14px; font-weight:bold; border-top:none;border-right:none;border-left:none;">SUBJECTS</th>

                                </tr>
								 <tr ><td align="left" style="vertical-align:middle; font-size:14px; border-top:none;border-right:none;border-left:none;border-bottom:none;padding-top:8px;padding-bottom:8px;">
                              <?php $i=0; foreach($halldata['subjectList'] as $subjects){?>
                               							
                                    <!--<td align="center" style=" font-size:11px; font-weight:bold;">22-03-2017</td>-->
                                    <p align="left">&nbsp;<?php echo $subjects['course_title'];?></p>
                                
								 <?php $i++;}?>
							</td></tr>										 
                           </table>
                        
                    </td>
                </tr>
            </table>
            <br />     
            <table width="100%">
                <tr>
                    <td align="left" style="width:30%; font-size:12px; font-weight:bold;text-transform: uppercase;"><div></div></td>
                    <td align="center" style="width:35%; font-size:12px; font-weight:bold;text-transform: uppercase;"><div>&nbsp;</div></td>
                    <td align="center" style="width:30%; font-size:12px; font-weight:bold;text-transform: uppercase;"><div>&nbsp;</div></td>
                </tr>

            </table>
            <table width="100%">
                <tr>
                    <td align="left" style="width:30%; font-size:12px; font-weight:bold;text-transform: uppercase;"><div>&nbsp;</div></td>
                    <td align="center" style="width:35%; font-size:12px; font-weight:bold;text-transform: uppercase;"><div>Signature of the Dean</div></td>
                    <td align="center" style="width:30%; font-size:12px; font-weight:bold;text-transform: uppercase;"><div>Signature of the Candidate</div></td>
                </tr>

            </table>
			<table width="100%">
                <tr>
                    <td align="left" style="width:30%; font-size:12px; font-weight:bold;text-transform: uppercase;"><div>University Seal</div></td>
                    <td align="center" style="width:35%; font-size:12px; font-weight:bold; text-transform: uppercase;"><div>&nbsp;</div></td>
                    <td align="center" style="width:30%; font-size:12px; font-weight:bold; text-transform: uppercase;"><div>&nbsp;</div></td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td align="left" style="width:30%; font-size:12px; font-weight:bold;text-transform: uppercase;"><div>&nbsp;</div></td>
                    <td align="center" style="width:35%; font-size:12px; font-weight:bold; text-transform: uppercase;"><div>Controller of Examinations</div></td>
                    <td align="center" style="width:30%; font-size:12px; font-weight:bold; text-transform: uppercase;"><div>Registrar</div></td>
                </tr>
            </table>
        </div>
    </div>	
	<?php if($key+1 < count($hall_tickets) && (($key+1)%2)==1){?>
	<div style="border:1px dotted #000;"></div>
	<?php }  if((($key+1)%2)==0){  ?>
    <pagebreak>
    <?php } } ?>
</body>
</html>