<?php  foreach($reg_cards as $key=>$regdata){?>
<?php $this->load->model('Generate_model');$this->load->view('admin/pdf/reg_card_header',$regdata);?> 
<h5 align="center">COURSES REGISTERED</h5>      
            <table id="table" width="100%" class="table">
                <tr>
                    <th align="center" style=" font-size:13px;">SI.No.</th>
                    <th align="center" style=" font-size:13px;">Course Title</th>
                    <th align="center" style=" font-size:13px;">Credit Hours</th>
                    <th align="center" style=" font-size:13px;">Course Teacher</th>
                    <th align="center" style=" font-size:13px;">Remarks</th>
                </tr>
                <tbody>
                    <?php $i=1;foreach($regdata['subjectList'] as $subjects){?>
                    <tr>
                    <td align="center" style=" font-size:13px;"><?php echo $i; ?></td>
                    <td align="center" style=" font-size:13px;"><?php 
                    $crs_cod = explode("-",$subjects['course_code']);
                    $cod = $crs_cod[0];
                    //$course_title = $this->Generate_model->get_coursesubj_name($crs_cod[0]);
                    if($subjects['course_subject_id'] == 22){
                        echo $cod.' (Non Credit Course)';
                    }elseif(!empty($subjects['course_subject_id'])){
                        echo $subjects['course_subject_title'];
                    }else
                        echo $subjects['course_title'];
                      
                    ?></td>
                    <td align="center" style=" font-size:13px;"><?php echo $subjects['theory_credit'].'+'.$subjects['practicle_credit']?></td>
                    <td align="center" width="20%" style=" font-size:13px;"></td>
                    <td align="center" style=" font-size:13px;">First Time</td>
                    </tr>
                    <?php $i++; }?>
                </tbody>
            </table> <br /><br /><br /><br />
        <div>
            <table width="100%">
                        <tr style="font-size:10px; font-weight:bold;">
                            <td width="20%" align="center"><div>Signature Of<br />Student</div></td>
                            <td width="20%" align="center"><div>Student's Counsellor<br />With Name & Designation </div></td>
                            <td width="20%" align="center"><div>Signature Of<br /> Dean </div></td>
                            <td width="20%" align="center"><div>Signature of<br />Registar</div></td>
                        </tr>
                    </table>
        </div>
            	
	<?php if($key+1 < count($reg_cards)){?>
	<!--<tocpagebreak>-->
    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>  
	<?php } }?>
</body>
</html>