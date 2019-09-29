<script src="https://code.jquery.com/jquery-3.3.1.js"></script>	
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>	
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>	
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>	
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>	
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<?php //p($this->session->userdata('sms')); exit;
$sessdata= $this->session->userdata('sms');
		if($sessdata[0]->role_id == 5){
			$role_id = 1;
			$campus_id = $user_row->campus_id;
			$id = $user_row->id;
		}else{
			$id = $sessdata[0]->id;
			$role_id = $sessdata[0]->role_id;
			$campus_id = $sessdata[0]->campus_id;
		}
?>
<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');
        
?>
<style >
.error{
 color:red;	
}
div.stars {
  width: 300px;
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
            

            <div class="tab-content">
			  <form role="form" name="feedback_form" id="feedback_form" action="<?php echo base_url();?>process/feedbackForm" method="post" enctype="multipart/form-data">
			  <div class="row">
				   <div class="form-group col-md-3">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram(),get_teacher_list(); $('#sender_campus').val(this.val);">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){ if($campus->id == $sessdata[0]->campus_id){?>
						  <option value="<?php echo $campus->id; ?>" <?php if(isset($_POST['campus_id']) && $_POST['campus_id'] == $campus->id) echo "selected"; ?>><?php echo $campus->campus_name; ?></option>
						 
						  <?php } } ?>
					  </select>
			    </div>
					
					<div class="form-group col-md-3">
					  <label for="program_id">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram(); $('#sender_program').val(this.val);">
						  <option value="">--Select Program--</option>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree(); $('#sender_degree').val(this.val);" >
						  <option value="">--Select Degree--</option>
						 
					  </select>
					</div>
				
				
				
			  
				    <div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control" onchange="$('#sender_batch').val(this.value);">
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ ?>
<option value="<?php echo $batch->id;?>" <?php if(isset($_POST['batch_id']) && $_POST['batch_id'] == $batch->id){?> selected $('#sender_batch').val(<?=$_POST['batch_id']?>); <?php }?>><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
					
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control" onchange="$('#sender_semester').val(this.val);">
						  <option value="">Select Semester</option>
						  
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="course-group">Discipline<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="discipline_id" id="discipline_id" onchange="$('#sender_discipline').val(this.value);">
					   
						  <option value="">Select Discipline</option>
					  </select>
					</div>
			     
					<div id="teacherCon" class="form-group col-md-3 " >
					  <label for="teacher_id">Teacher<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control"  id="teacher_id" name="teacher_id" onchange="$('#sender_teacher').val(this.value);">
					   <option value="">Select Teacher</option>
					   </select>
					</div>
			   
					
					<div class="form-group col-md-3">
					<label for="attendance_date">&nbsp;</label><br/>
               <button type="submit" class="btn btn-success" >Submit</button>
			   <span class="showMsg" id="showMsg"></span>
				  <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
              </div>
				
			  </div>
			</form>
              <div class="active tab-pane mydetails" id="feedback">
			  <?php if(!$feedbacks_already_submitted){ $res=[]; if(isset($feedbacks[0])) $res = $feedbacks[0]; if(count($res)>0){ ?>
			    <form  class="form-horizontal" method="post" name="feedback_form" id="feedback_form" action="<?php echo base_url();?>process/sendFeedback" enctype="multipart/form-data">
			<input type="hidden" class="form-control" id="sender_id" name="sender_id" value="<?php echo $id;?>">
			<input type="hidden" class="form-control" id="sender_role" name="sender_role" value="<?php echo $role_id;?>">
			<input type="hidden" class="form-control" id="sender_campus" name="sender_campus" value="">
			<input type="hidden" class="form-control" id="sender_program" name="sender_program" value="">
			<input type="hidden" class="form-control" id="sender_degree" name="sender_degree" value="">
			<input type="hidden" class="form-control" id="sender_batch" name="sender_batch" value="">
			<input type="hidden" class="form-control" id="sender_semester" name="sender_semester" value="">
			<input type="hidden" class="form-control" id="sender_discipline" name="sender_discipline" value="">
			<input type="hidden" class="form-control" id="sender_teacher" name="sender_teacher" value="">
			<input type="hidden" class="form-control" id="feedback_id" name="feedback_id" value="<?php echo $res['id'];?>">
                 <div id="courseList" style="display:none11">
				   <div class="box-body table-responsive">
						    <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
								    <th>S.No.</th>
									<!--<th>Degree</th>
									<th>Semester</th>
									<th>Batch</th>-->
									<th>Question</th>
									
									<th>Action</th>
									
								</tr>
							</thead>
							<tbody id="tr_list">
							<?php foreach($feedbacks as $key=>$val){?>
									<tr id="<?=$val['id']?>"><td><?php echo $key+1;?></td>
									<!--<td><?php echo $val['degree_name'];?></td>
									<td><?php echo $val['semester_name'];?></td>
									<td><?php echo $val['batch_name'];?></td>-->
									<td><?php echo $val['question'];?></td>
									

									<td><div class="btn-group" >
									 <input type="hidden" name="rate_value[<?=$val['id']?>]" id="rate_value[<?=$val['id']?>]" value=""/>
									 <input type="hidden" name="question[]" id="question[]" value="<?=$val['id']?>"/>
									 
											 <div class="stars_<?=$val['id']?>">
								
									<input class="star star-5" id="star-5<?=$val['id']?>" type="radio" value="5" name="star<?=$val['id']?>" onclick="rateMe('5','<?php echo $id;?>',<?=$val['id']?>)" />
									<label class="star star-5" for="star-5<?=$val['id']?>"></label>
									<input class="star star-4" id="star-4<?=$val['id']?>" type="radio" value="4" name="star<?=$val['id']?>" onclick="rateMe('4','<?php echo $id;?>',<?=$val['id']?>)"/>
									<label class="star star-4" for="star-4<?=$val['id']?>"></label>
									<input class="star star-3" id="star-3<?=$val['id']?>" type="radio" value="3" name="star<?=$val['id']?>" onclick="rateMe('3','<?php echo $id;?>',<?=$val['id']?>)"/>
									<label class="star star-3" for="star-3<?=$val['id']?>"></label>
									<input class="star star-2" id="star-2<?=$val['id']?>" type="radio" value="2" name="star<?=$val['id']?>" onclick="rateMe('2','<?php echo $id;?>',<?=$val['id']?>)"/>
									<label class="star star-2" for="star-2<?=$val['id']?>"></label>
									<input class="star star-1" id="star-1<?=$val['id']?>" type="radio" value="1" name="star<?=$val['id']?>" onclick="rateMe('1','<?php echo $id;?>',<?=$val['id']?>)"/>
									<label class="star star-1" for="star-1<?=$val['id']?>"></label>
								 
								</div>
										</div></td></tr>
							<?php }?>
							</tbody>
						</table>
	                </div>
								   <div class="col-sm-3">
                       <button type="submit" class="btn btn-success" id="send"  name="send" >Send</button>
                    </div>
			  </div>

				</form>
			  <?php }else{ echo "No Feedback available now";} }else{ echo "Feedback Already Submitted";} ?>
				 </div>
				 
         <!-- /.tab-pane -->

      
			  
				    
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
		<?php if(isset($_POST['campus_id']) && $_POST['campus_id'] != '' && $_POST['campus_id'] != '0') {?>
		getProgram(),get_teacher_list();
		<?php }?>
		<?php if(isset($_POST['program_id']) && $_POST['program_id'] != '' && $_POST['program_id'] != '0') {?>
		getDegreebyProgram();
		<?php }?>
		<?php if(isset($_POST['degree_id']) && $_POST['degree_id'] != '' && $_POST['degree_id'] != '0') {?>
		getSemesterbyDegree();
		$('#sender_degree').val(<?=$_POST['degree_id']?>);
		<?php }?>
		<?php if(isset($_POST['batch_id']) && $_POST['batch_id'] != '' && $_POST['batch_id'] != '0') {?>
		$('#sender_batch').val(<?=$_POST['batch_id']?>);
		<?php }?>
		<?php if(isset($_POST['semester_id']) && $_POST['semester_id'] != '' && $_POST['semester_id'] != '0') {?>
		$('#sender_semester').val(<?=$_POST['semester_id']?>);
		<?php }?>
		<?php if(isset($_POST['teacher_id']) && $_POST['teacher_id'] != '' && $_POST['teacher_id'] != '0') {?>
		$('#sender_teacher').val(<?=$_POST['teacher_id']?>);
		$('#teacher_id').val(<?=$_POST['teacher_id']?>);
		<?php }?>
		
		$('#campus_id').on('change', function() {
			$('#courseList').hide();
		});
		$('#program_id').on('change', function() {
			$('#courseList').hide();
		});
		$('#degree_id').on('change', function() {
			$('#courseList').hide();
		});
		$('#batch_id').on('change', function() {
			$('#courseList').hide();
		});
		$('#semester_id').on('change', function() {
			$('#courseList').hide();
		});
		$('#discipline_id').on('change', function() {
			$('#courseList').hide();
		});
		$('#course_id').on('change', function() {
			$('#courseList').hide();
		});
		$('#teacher_id').on('change', function() {
			$('#courseList').hide();
		});
		
	});
	function rateMe(value,id,colid)
   {
     var user_id=id;
     var rating_id=value;
	
     $('#rate_value['+colid+']').val(rating_id);
	 
   }
	
    function sendFeedBack(){
		var sender_id =$('#sender_id').val();
		var sender_role =$('#sender_role').val();
		var sender_campus =$('#sender_campus').val();
		var rate_value =$('#rate_value').val();
		var feedback_id =$('#feedback_id').val();
		
		var feedback_message =$('#feedback_message').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>process/sendFeedback',
			data: {'feedback_id':feedback_id,'sender_id':sender_id,'sender_campus':sender_campus,'rate_value':rate_value,'feedback_message':feedback_message},
			success: function(data){
				
				if(data==1){
					//alert('hello');
					alert('Feedback Send Successfully.');
					$('#feedback_form')[0].reset();
					window.location.reload()
				}
				else{
					alert('Feedback Not Send Successfully.');
					$('#feedback_form')[0].reset();
					window.location.reload();
				}
			
			 }
		});
		
	}
	
	 function get_teacher_list(){
	  
	 var campus_id =$('#campus_id').val();
	 $('#sender_campus').val(campus_id);
		//alert(campus_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/get_teacher',
			data: {'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			//var  option_brand = '<option value="">--Select Teacher--</option>';
			$('#teacher_id').empty();
			$("#teacher_id").append(data);
			$('#teacher_id').multiselect('rebuild');
			<?php if(isset($_POST['teacher_id']) && $_POST['teacher_id'] != '' && $_POST['teacher_id'] != '0') {?>
		$("#teacher_id").val(<?=$_POST['teacher_id'][0]?>);
		<?php }?>
			 }
		}); 
	  
  }
  function getProgram()
	{
		var campus_id =$('#campus_id').val();
		 $('#sender_campus').val(campus_id);
		//alert(campus_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getProgramByCampus',
			data: {'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Program--</option>';
			$('#program_id').empty();
			$("#program_id").append(option_brand+data);
			
			<?php if(isset($_POST['program_id']) && $_POST['program_id'] != '' && $_POST['program_id'] != '0') {?>
		$("#program_id").val(<?=$_POST['program_id']?>);
		//getDegreebyProgram();
		<?php }?>
			 }
		});
	}
	function getDegreebyProgram()
	{
		
		var program_id =$('#program_id').val();
		if(program_id == '')
		{
			<?php if(isset($_POST['program_id']) && $_POST['program_id'] != '' && $_POST['program_id'] != '0') {?>
				program_id = <?=$_POST['program_id']?>;
			//getDegreebyProgram();
			<?php }?>
		}
		 $('#sender_program').val(program_id);
		var campus_id =$('#campus_id').val();
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDegreebyProgram',
			data: {'campus_id':campus_id,'program_id':program_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_id').empty();
			$("#degree_id").append(option_brand+data);
			<?php if(isset($_POST['degree_id']) && $_POST['degree_id'] != '' && $_POST['degree_id'] != '0') {?>
		$("#degree_id").val(<?=$_POST['degree_id']?>);
		<?php }?>
			 }
		});
	}
	function getSemesterbyDegree(){
		var degree_id =$('#degree_id').val();
		$('#sender_degree').val(degree_id);
		if(degree_id == '')
		{
			<?php if(isset($_POST['degree_id']) && $_POST['degree_id'] != '' && $_POST['degree_id'] != '0') {?>
				degree_id = <?=$_POST['degree_id']?>;
			//getDegreebyProgram();
			<?php }?>
		}
		getDisciplineByDegreeId();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>generate/getSemesterbyDegree',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Semester--</option>';
			$('#semester_id').empty();
			$("#semester_id").append(option_brand+data);
			<?php if(isset($_POST['semester_id']) && $_POST['semester_id'] != '' && $_POST['semester_id'] != '0') {?>
			
		$("#semester_id").val(<?=$_POST['semester_id']?>);
		$("#sender_discipline").val(<?=$_POST['semester_id']?>);
		
		<?php }?>
			 }
		});
	}
	function getDisciplineByDegreeId()
	{
		
		var degree_id =$('#degree_id').val();
		if(degree_id == '')
		{
			<?php if(isset($_POST['degree_id']) && $_POST['degree_id'] != '' && $_POST['degree_id'] != '0') {?>
				degree_id = <?=$_POST['degree_id']?>;
			//getDegreebyProgram();
			<?php }?>
		}
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDisciplineByDegreeId',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Discipline--</option>';
			$('#discipline_id').empty();
			$("#discipline_id").append(option_brand+data);
			<?php if(isset($_POST['discipline_id']) && $_POST['discipline_id'] != '' && $_POST['discipline_id'] != '0') {?>
			
		$("#discipline_id").val(<?=$_POST['discipline_id']?>);
		<?php }?>
			 }
		});
	}
	function getCourseByIds()
	{
		 //$('#courseCon').removeClass('hidden');
		var $form =$("#feedback_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getCourseByIds',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				
			//var  option_brand = '<option value="">--Select Courses--</option>';
			$('#course_id').empty();
			$("#course_id").append(data);
			$('#course_id').multiselect('rebuild');
			 }
		});
	}
	 $("#feedback_form").validate({
		rules: {
			campus_id:"required",
			program_id: "required",
			degree_id: "required",
			semester_id: "required",
			teacher_id: "required",
			batch_id:"required",
			discipline_id:"required"
			
			
			
		},
		messages: {
			campus_id:"Select Campus",
			program_id:"Select Program ",
			degree_id:"Select Degree ",
			semester_id: "Select Semester",
			teacher_id: "Select Teacher",
			batch_id:"Select Batch",
			discipline_id:"Select Discipline"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	

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
	$("#frmpayment").validate({
		rules: {
			program_id: "required",
			semester_id: "required",
			report_card: "required",
			amount: "required"
		
			
			
		},
		messages: {
			program_id: "Select Program",
			semester_id: "Please select anyone",
			report_card:"Select Payment Type",
			amount:"Amount is Blank"
		
			
				
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	 $("#course_assign").validate({
		rules: {
			program_id: "required",
			degree_id: "required",
			semester_id: "required",
			previous_semester_id:"required",
			syllabus_year:"required",
			batch_id:"required"
			
			
			
		},
		messages: {
			program_id: "Select Program Name",
			degree_id:"Select Degree Name",
			semester_id: "Select Discipline Name",
			previous_semester_id:"Select Course Group Name",
			syllabus_year:"Select Syllabus Year Name",
			batch_id:"Select Semester Name"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	function change_report_card(report_value){
		//alert(report_value);
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
$(document).ready(function() {
	
	$('.semester_id').on('change', function() {
		if($(this).find('option:selected').html() !=''){
		$.get( "getfeeamount", {"_": $.now(), name: $(this).find('option:selected').html(),type: $('#report_card').find('option:selected').html()} )
		  .done(function( data ) {
			$("#amount").val(data);
		});
		}else{
			$("#amount").val('');
		}
		$("#semester_value").val($(this).find('option:selected').html());
	});
	$('#report_card').on('change', function() {
		change_report_card($(this).find('option:selected').val());
	});
	var url = window.location.href;
	var activeTab = url.substring(url.indexOf("#") + 1);
	if($('a[href="#'+ activeTab +'"]').length>0){
		$('a[href="#'+ activeTab +'"]').tab('show');
		setTimeout(function() {
			$(window).scrollTop(0 );
		}, 5);
	}else{
		$('a[href="#report_card"]').tab('show');
			setTimeout(function() {
				$(window).scrollTop(0 );
			}, 5);
			$('select#report_card').val(activeTab);
			change_report_card(activeTab);
	}
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
			$('select.semester_id').val('');
		}
	});
    
} );
	
</script>
	
<?php $this->load->view('admin/helper/footer');?> 
  
  
 