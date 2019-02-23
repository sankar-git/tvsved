<script src="https://code.jquery.com/jquery-3.3.1.js"></script>	
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>	
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>	
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>	
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>	
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<?php //p($user_row); exit;?>
<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');
        $sessdata= $this->session->userdata('sms');
		$id = $sessdata[0]->id;
		$role_id = $sessdata[0]->role_id;
		$campus_id = $sessdata[0]->campus_id;
?>
<style >
.error{
 color:red;	
}
div.stars {
  width: 270px;
  display: inline-block;
}

input.star { display: none; }

label.star {
  float: right;
  padding: 10px;
  font-size: 36px;
  color: #444;
  transition: all .2s;
}

input.star:checked ~ label.star:before {
  content: '\f005';
  color: #FD4;
  transition: all .25s;
}

input.star-5:checked ~ label.star:before {
  color: #FE7;
  text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #F62; }

label.star:hover { transform: rotate(-15deg) scale(1.3); }

label.star:before {
  content: '\f006';
  font-family: FontAwesome;
}

</style>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <?php echo $page_title;?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $page_title;?></li>
      </ol>
    </section>

    <!-- Main content -->
<section class="content">

      <div class="row">
      
        <!-- /.col -->
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active" <?php if($role_id == 6){?> style="display:none;"<?php }?>><a href="#feedback" data-toggle="tab">FeedBack</a></li>
             <!--<li><a href="#timeline" data-toggle="tab">Payment History</a></li>-->
              <li><a href="#report_card" data-toggle="tab">Report Card</a></li>
			  
              
              <li><a href="#payment_details" data-toggle="tab">My Payment Details</a></li>
			  <!-- <li><a href="#result" data-toggle="tab">Student Result</a></li>-->
            </ul>
			
            <div class="tab-content">
			
			
              <div class="active tab-pane mydetails" id="feedback">
			  
			    <form  class="form-horizontal" method="post" name="feedback_form" id="feedback_form" action="" enctype="multipart/form-data">
			<input type="hidden" class="form-control" id="sender_id" name="sender_id" value="<?php echo $id;?>">
			<input type="hidden" class="form-control" id="sender_role" name="sender_role" value="<?php echo $role_id;?>">
			<input type="hidden" class="form-control" id="sender_campus" name="sender_campus" value="<?php echo $campus_id;?>">
                 <div class="form-group">
				 <div class="row">
				       <label for="inputName" class="col-sm-1 control-label">Rating</label></br>
				       <div class="col-sm-3">
                                 <div class="stars">
								
									<input class="star star-5" id="star-5" type="radio" value="5" name="star"onclick="rateMe('5','<?php echo $id;?>')" />
									<label class="star star-5" for="star-5"></label>
									<input class="star star-4" id="star-4" type="radio" value="4" name="star" onclick="rateMe('4','<?php echo $id;?>')"/>
									<label class="star star-4" for="star-4"></label>
									<input class="star star-3" id="star-3" type="radio" value="3" name="star" onclick="rateMe('3','<?php echo $id;?>')"/>
									<label class="star star-3" for="star-3"></label>
									<input class="star star-2" id="star-2" type="radio" value="2" name="star"onclick="rateMe('2','<?php echo $id;?>')"/>
									<label class="star star-2" for="star-2"></label>
									<input class="star star-1" id="star-1" type="radio" value="1" name="star" onclick="rateMe('1','<?php echo $id;?>')"/>
									<label class="star star-1" for="star-1"></label>
								 
								</div>
                        </div>
				  </div>
				    <input type="hidden" name="rate_value" id="rate_value" value=""/>
                    <label for="inputName" class="col-sm-1  control-label" >Message</label>
                    <div class="col-sm-3">
                      <textarea type="text" class="form-control" id="feedback_message" name="feedback_message" value="" placeholder="Message"></textarea>
                    </div>
                  
					 <div class="col-sm-3">
                       <button type="button" class="btn btn-success" id="send"  name="send"/ onclick="sendFeedBack();">Send</button>
                    </div>
				 </div>
				</form>
				 </div>
				 
         <!-- /.tab-pane -->

              <div class="tab-pane " id="report_card" >
                <form class="form-horizontal" method="POST" action="<?php echo base_url();?>payment/testPayment/1" enctype="multipart/form-data">
				   <input type="hidden" name="user_id" id="user_id" value="<?php echo $id;?>"/>
				   <input type="hidden" name="role_id" id="role_id" value="<?php echo $role_id;?>"/>
				   <div class="form-group">
				   <label for="inputName" class="col-sm-1 control-label"  name="report_card">Report Card</label>
                    <div class="col-sm-3">
                      <select name="report_card" id="report_card" class="form-control">
						      <option value="">--Select Report Card--</option>
						      <option value="duplicate_certificate">Duplicate Certificate</option>
						      <option value="re-evaluation">Re-Evaluation</option>
						      <option value="exam_fees">Exam Fees</option>
						      <option value="year_wise_marksheet">Yearwise Marksheet</option>
						      <option value="transcript">Transcript</option>
						      <option value="consolidate">Consolidate</option>
					  </select> 
                    </div>
					<label for="inputName" class="col-sm-1 control-label transcript hidden" name="transcript_type">Type</label>
                    <div class="col-sm-3 transcript hidden">
                      <select name="transcript_type" id="transcript_type" class="form-control transcript_type">
						     <option value="">--Select Type--</option>
						     <option value="Consolidate Marksheet">Consolidate Marksheet</option>
						     <option value="Transfer">Transfer</option>
						     <option value="Migration">Migration</option>
						     <option value="Professional">Professional</option>
					  </select> 
                    </div>
					<label for="inputName" class="col-sm-1 control-label consolidate hidden" name="consolidate_type">Type</label>
                    <div class="col-sm-3 consolidate hidden">
                      <select name="consolidate_type" id="consolidate_type" class="form-control consolidate_type">
						     <option value="">--Select Type--</option>
						     <option value="Degree Certiicate">Degree Certiicate</option>
					  </select> 
                    </div>
					
                  <label for="inputName" class="col-sm-1 program control-label hidden" id="program" name="program">Program</label>
                    <div class="col-sm-3 program hidden">
                      <select name="program_id" id="program_id" class="form-control">
						      <!--<option value="">--Select Program--</option>-->
							  <?php //foreach($programs as $view){
								  if(isset($user_row->program_id)){
								  ?>
							  <option value="<?php echo $user_row->program_id;?>"><?php echo $user_row->program_name;?></option>
							 
								  <?php } // }?>
							 
					  </select> 
                    </div>
				    <label for="inputName" class="col-sm-1 control-label re-evaluation hidden" id="semester" name="semester">Year</label>
                    <div class="col-sm-3 re-evaluation hidden">
                      <select name="semester_id" id="semester_id" class="form-control semester_id" >
						      <option value="">--Select Year--</option>
							  <?php foreach($semesters as $semvalue){?>
							   <option value="<?php echo $semvalue['semester_id'];?>"><?php echo $semvalue['semester_name'];?></option>
							 <?php }?>
					  </select> 
                    </div>
					
					<label for="inputName" class="col-sm-1 control-label duplicate_certificate hidden" id="semester" name="semester">Year</label>
                    <div class="col-sm-3 duplicate_certificate hidden">
                      <select name="semester_id" id="semester_id" class="form-control semester_id" >
						      <option value="">--Select Year--</option>
							  <?php foreach($semesters as $semvalue){?>
							   <option value="<?php echo $semvalue['semester_name'];?>"><?php echo $semvalue['semester_name'];?></option>
							 <?php }?>
							 <option value="All Professional Year">All Professional Year</option>
							 <option value="Consolidate Marksheet">Consolidate Marksheet</option>
							 <option value="Transfer">Transfer</option>
							 <option value="Migration">Migration</option>
							 <option value="Professional">Professional</option>
							 <option value="Degree Certiicate">Degree Certiicate</option>
					  </select> 
                    </div>
					
					<label for="inputName" class="col-sm-1 control-label year_wise_marksheet hidden" id="semester" name="semester">Year</label>
                    <div class="col-sm-3 year_wise_marksheet hidden">
                      <select name="semester_id" id="semester_id" class="form-control semester_id" >
						      <option value="">--Select Year--</option>
							  <?php foreach($semesters as $semvalue){?>
							   <option value="<?php echo $semvalue['semester_name'];?>"><?php echo $semvalue['semester_name'];?></option>
							 <?php }?>
							 <option value="7">All Professional Year</option>
					  </select> 
                    </div>
                    </div>
				  <div class="form-group">
				  <label for="inputName" class="col-sm-1  control-label" >Amount</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="amount" readonly name="amount" value=""/>
                   
                  </div>
				   <div class="col-sm-3">
                      <input type="submit" class="btn btn-success" id="payment_now1" name="payment_now1" value="Apply Now"/>
                  </div>
				  </div>
                </form>
              </div>
			  
			    <div class="tab-pane duplicate_certificate" id="evaluation" >
                   <form class="form-horizontal" method="POST" action="<?php echo base_url();?>payment/testPayment/2" enctype="multipart/form-data">
				   <input type="hidden" name="user_id" id="user_id" value="<?php echo $id;?>"/>
				   <input type="hidden" name="role_id" id="role_id" value="<?php echo $role_id;?>"/>
				   <div class="form-group">
                  <label for="inputName" class="col-sm-1 control-label" id="program" name="program">Program</label>
                    <div class="col-sm-3">
                      <select name="program_id" id="program_id" class="form-control">
						      <!--<option value="">--Select Program--</option>-->
							  <?php // foreach($programs as $view){
								  if(isset($user_row->program_id)){
								  ?>
							  <option value="<?php echo $user_row->program_id;?>"><?php echo $user_row->program_name;?></option>
							 
								  <?php } // }?>
							 
					  </select> 
                    </div>
				    <label for="inputName" class="col-sm-1 control-label" id="semester" name="semester">Semester</label>
                    <div class="col-sm-3">
                      <select name="semester_id" id="semester_id" class="form-control" >
						      <option value="">--Select Semester--</option>
							  <?php foreach($semesters as $semvalue){?>
							   <option value="<?php echo $semvalue['semester_id'];?>"><?php echo $semvalue['semester_name'];?></option>
							 <?php }?>
							 
					  </select> 
                    </div>
                    </div>
				  <div class="form-group">
				  <label for="inputName" class="col-sm-1  control-label" >Amount</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="amount" name="amount" readonly value=""/>
                   
                  </div>
				   <div class="col-sm-3">
                      <input type="submit" class="btn btn-success" id="payment_now" name="payment_now" value="Apply Now"/>
                  </div>
				  </div>
                </form>
              </div>
			  
			  <div class="tab-pane duplicate_certificate" id="exam_fees" >
                   <form class="form-horizontal" method="POST" action="<?php echo base_url();?>payment/testPayment/3" enctype="multipart/form-data">
				   <input type="hidden" name="user_id" id="user_id" value="<?php echo $id;?>"/>
				   <input type="hidden" name="role_id" id="role_id" value="<?php echo $role_id;?>"/>
				   <div class="form-group">
                  <label for="inputName" class="col-sm-1 control-label" id="program" name="program">Program</label>
                    <div class="col-sm-3">
                      <select name="program_id" id="program_id" class="form-control">
						      <!--<option value="">--Select Program--</option>-->
							  <?php // foreach($programs as $view){
								  if(isset($user_row->program_id)){
								  ?>
							  <option value="<?php echo $user_row->program_id;?>"><?php echo $user_row->program_name;?></option>
							 
								  <?php } // }?>
							 
					  </select> 
                    </div>
					<label for="syllabus_year" class="col-sm-1 control-label" id="program" name="program">Year</label>
				    <div class="col-sm-3">
					  
					   <select class="form-control" name="syllabus_year" id="syllabus_year">
						  <option value="">Year</option>
						  <?php foreach($syllabus_years as $syllabus_year_row){ ?>
						  <option value="<?php echo $syllabus_year_row->id;?>"><?php echo $syllabus_year_row->syllabus_year;?></option>
						  <?php } ?>
					  </select>
					</div>
					</div>
				  <div class="form-group">
				  <label for="inputName" class="col-sm-1  control-label" >Amount</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="amount" name="amount" value=""/>
                   
                  </div>
				   <div class="col-sm-3">
                      <input type="submit" class="btn btn-success" id="payment_now" name="payment_now" value="Apply Now"/>
                  </div>
				  </div>
                </form>
              </div>
              
			  
			  <div class="tab-pane duplicate_certificate" id="Overall_Consolidated" >
                   <form class="form-horizontal" method="POST" action="<?php echo base_url();?>payment/testPayment/4" enctype="multipart/form-data">
				   <input type="hidden" name="user_id" id="user_id" value="<?php echo $id;?>"/>
				   <input type="hidden" name="role_id" id="role_id" value="<?php echo $role_id;?>"/>
				   <div class="form-group">
                  <label for="inputName" class="col-sm-1 control-label" id="program" name="program">Program</label>
                    <div class="col-sm-3">
                      <select name="program_id" id="program_id" class="form-control">
						      <!--<option value="">--Select Program--</option>-->
							  <?php // foreach($programs as $view){
								  if(isset($user_row->program_id)){
								  ?>
							  <option value="<?php echo $user_row->program_id;?>"><?php echo $user_row->program_name;?></option>
							 
								  <?php } // }?>
							 
					  </select> 
                    </div>
					<label for="syllabus_year" class="col-sm-1 control-label" id="program" name="program">Year</label>
				    <div class="col-sm-3">
					  
					   <select class="form-control" name="syllabus_year" id="syllabus_year">
						  <option value="">Year</option>
						  <?php foreach($syllabus_years as $syllabus_year_row){ ?>
						  <option value="<?php echo $syllabus_year_row->id;?>"><?php echo $syllabus_year_row->syllabus_year;?></option>
						  <?php } ?>
					  </select>
					</div>
                    </div>
				  <div class="form-group">
				  <label for="inputName" class="col-sm-1  control-label" >Amount</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="amount" name="amount" value=""/>
                   
                  </div>
				   <div class="col-sm-3">
                      <input type="submit" class="btn btn-success" id="payment_now" name="payment_now" value="Apply Now"/>
                  </div>
				  </div>
                </form>
              </div>
			  
			  <div class="tab-pane duplicate_certificate" id="Year_Wise_Consolidated" >
                   <form class="form-horizontal" method="POST" action="<?php echo base_url();?>payment/testPayment/5" enctype="multipart/form-data">
				   <input type="hidden" name="user_id" id="user_id" value="<?php echo $id;?>"/>
				   <input type="hidden" name="role_id" id="role_id" value="<?php echo $role_id;?>"/>
				   <div class="form-group">
                  <label for="program_id" class="col-sm-1 control-label" id="program" name="program">Program</label>
                    <div class="col-sm-3">
                      <select name="program_id" id="program_id" class="form-control">
						      <!--<option value="">--Select Program--</option>-->
							  <?php // foreach($programs as $view){
								  if(isset($user_row->program_id)){
								  ?>
							  <option value="<?php echo $user_row->program_id;?>"><?php echo $user_row->program_name;?></option>
							 
								  <?php } // }?>
							 
					  </select> 
                    </div>
					<label for="syllabus_year" class="col-sm-1 control-label" id="program" name="program">Year</label>
				    <div class="col-sm-3">
					   <select class="form-control" name="syllabus_year" id="syllabus_year">
						  <option value="">Year</option>
						  <?php foreach($syllabus_years as $syllabus_year_row){ ?>
						  <option value="<?php echo $syllabus_year_row->id;?>"><?php echo $syllabus_year_row->syllabus_year;?></option>
						  <?php } ?>
					  </select>
					</div>
                    </div>
				  <div class="form-group">
				  <label for="inputName" class="col-sm-1  control-label" >Amount</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="amount" name="amount" value=""/>
                   
                  </div>
				   <div class="col-sm-3">
                      <input type="submit" class="btn btn-success" id="payment_now" name="payment_now" value="Apply Now"/>
                  </div>
				  </div>
                </form>
              </div>
			  
			     <div class="tab-pane payment_details" id="payment_details" >
                  
				    <table class="table" width="100%" id="example">
                <tbody>
				<tr>
                  <th>S.No.</th>
                  <th>Program</th>
                  <th>Semester</th>
                  <th>Type</th>
                  <th>Amount</th>
                  <th>Transaction Id</th>
                  <th>Transaction Date</th>
                  <th>Invoice</th>
                  <th>Status</th>
                </tr>
				<?php $i=0;foreach($payments as $payment){$i++;?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $payment->program_name;?></td>
                  <td><?php echo $payment->semester_name;?></td>
                  <td><?php echo $payment->payment_type;?></td>
                  <td><?php echo $payment->amt;?></td>
                  <td><?php echo $payment->mer_txn;?></td>
                  <td>
                    <?php echo $payment->date;?>
                  </td>
				  <td>
					<?php if($payment->f_code == 'Ok'){?>
                    <a href="<?php echo base_url();?>payment/downloadReceipt/<?php echo $payment->mer_txn;?>">Download Invoice</a>
					<?php }else echo '-'; ?>
                  </td>
                 <td>
                    <?php echo $payment->desc;?>
                  </td>
                </tr>
				<?php }?>
              </tbody></table>
               
              </div>
			  
			  
			  
			   <div class="tab-pane" id="result">
                <form class="form-horizontal" method="POST" action="<?php echo base_url();?>profile/myStudentResult">
				  <div class="form-group">
			       <input type="hidden" class="form-control" id="student_id" name="student_id" value="">
				   <input type="hidden" class="form-control" id="role_id" name="role_id" value="">
				   <input type="hidden" class="form-control" id="batch_id" name="batch_id" value="">
				   <input type="hidden" class="form-control" id="degree_id" name="degree_id" value="">
				    <label for="inputName" class="col-sm-1 control-label">Semester</label>
                    <div class="col-sm-3">
                      <select name="semester_id" id="semester_id" class="form-control">
						      <option value="">--Select Semester--</option>
							  
							 <option value="1" >1</option>
							  
					  </select> 
                    </div>
					
					<label for="inputName" class="col-sm-1 control-label" id="gender" name="gender">Program</label>
                    <div class="col-sm-3">
                      <select name="program_id" id="program_id" class="form-control">
						      <option value="">--Select Program--</option>
							  
							 <option value="">o</option>
							 
					  </select> 
                    </div>
					
					
                    <div class="col-sm-4">
                      <button type="sbmit" class="btn btn-success" id="submit" formtarget="_blank" name="submit"/>Generate</button><span class="feedback" id="feedback" ></span>
                    </div>
					
                  </div>
				  
				   
				
                  </div>
				    
                </form>
              </div>
			  
			  
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</section>
 </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
	
	$(document).ready(function() {
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
	function rateMe(value,id)
   {
     var user_id=id;
     var rating_id=value;
     $('#rate_value').val(rating_id);
	 
   }
	
    function sendFeedBack(){
		var sender_id =$('#sender_id').val();
		var sender_role =$('#sender_role').val();
		var sender_campus =$('#sender_campus').val();
		var rate_value =$('#rate_value').val();
		
		var feedback_message =$('#feedback_message').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>process/sendFeedback',
			data: {'sender_id':sender_id,'sender_campus':sender_campus,'rate_value':rate_value,'feedback_message':feedback_message},
			success: function(data){
				
				if(data==1){
					//alert('hello');
					alert('Feedback Send Successfully.');
					$('#feedback_form')[0].reset();
				}
				else{
					alert('Feedback Not Send Successfully.');
					$('#feedback_form')[0].reset();
				}
			
			 }
		});
		
	}
	function getDegreebyProgram()
	{
		var program_id =$('#program_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDegreebyProgram',
			data: {'program_id':program_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_id').empty();
			$("#degree_id").append(option_brand+data);
			 }
		});
	}
   $("#campus_and_degree_form").validate({
		rules: {
			campus_id: "required",
			program_id: "required",
			degree_id: "required"
		
			
			
		},
		messages: {
			campus_id: "Select Campus Name",
			program_id: "Select Program Name",
			degree_id:"Select Degree Name"
		
			
				
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
$(document).ready(function() {
	function change_report_card(report_value){
		$("#amount").val('');
		if(report_value == 'transcript' || report_value == 'consolidate' || report_value == '')
			$('.program').addClass('hidden');
		else
			$('.program').removeClass('hidden');
		
		if(report_value == 're-evaluation' || report_value == 'exam_fees'){
			$('.re-evaluation').removeClass('hidden');
			$('.year_wise_marksheet').addClass('hidden');
			$('.consolidate').addClass('hidden');
			$('.transcript').addClass('hidden');
			$('.duplicate_certificate').addClass('hidden');
		}else if(report_value == 'duplicate_certificate'){
			$('.duplicate_certificate').removeClass('hidden');
			$('.year_wise_marksheet').addClass('hidden');
			$('.consolidate').addClass('hidden');
			$('.re-evaluation').addClass('hidden');
			$('.transcript').addClass('hidden');
		}else if(report_value == 'transcript'){
			$('.transcript').removeClass('hidden');
			$('.year_wise_marksheet').addClass('hidden');
			$('.consolidate').addClass('hidden');
			$('.re-evaluation').addClass('hidden');
			$('.duplicate_certificate').addClass('hidden');
		}else if(report_value == 'year_wise_marksheet'){
			$('.year_wise_marksheet').removeClass('hidden');
			$('.transcript').addClass('hidden');
			$('.consolidate').addClass('hidden');
			$('.re-evaluation').addClass('hidden');
			$('.duplicate_certificate').addClass('hidden');
		}else if(report_value == 'consolidate'){
			$('.consolidate').removeClass('hidden');
			$('.transcript').addClass('hidden');
			$('.year_wise_marksheet').addClass('hidden');
			$('.re-evaluation').addClass('hidden');
			$('.duplicate_certificate').addClass('hidden');
		}else{
			$('.consolidate').addClass('hidden');
			$('.transcript').addClass('hidden');
			$('.year_wise_marksheet').addClass('hidden');
			$('.re-evaluation').addClass('hidden');
			$('.duplicate_certificate').addClass('hidden');
		}
	}
	$('.semester_id,.transcript_type,.consolidate_type').on('change', function() {
		if($(this).find('option:selected').text() !=''){
		$.get( "getfeeamount", {"_": $.now(), name: $(this).find('option:selected').text(),type: $('#report_card').find('option:selected').text()} )
		  .done(function( data ) {
			$("#amount").val(data);
		});
		}else{
			$("#amount").val('');
		}
	});
	$('#report_card').on('change', function() {
		change_report_card(this.value);
	});
	var url = window.location.href;
	var activeTab = url.substring(url.indexOf("#") + 1);
	$('a[href="#'+ activeTab +'"]').tab('show');
	setTimeout(function() {
        $(window).scrollTop(0 );
    }, 5);
	$('.treeview-menu a').click(function(){
		 var scrollHeight = $(document).scrollTop();
		var url = $(this).attr('href');
		var activeTab = url.substring(url.indexOf("#") + 1);
		if($('a[href="#'+ activeTab +'"]').length>0){
			$('a[href="#'+ activeTab +'"]').tab('show');
			setTimeout(function() {
				$(window).scrollTop(scrollHeight );
			}, 5);
		}else{
			console.log(activeTab);
			$('a[href="#report_card"]').tab('show');
			setTimeout(function() {
				$(window).scrollTop(scrollHeight );
			}, 5);
			$('select#report_card').val(activeTab);
			change_report_card(activeTab);
		}
	});
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            }
        ]
    } );
} );
	
</script>
	
<?php $this->load->view('admin/helper/footer');?> 
  
  
 