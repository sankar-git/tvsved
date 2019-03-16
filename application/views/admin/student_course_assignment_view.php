<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');?>
<style >
.error{
 color:red;	
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
      <!-- Small boxes (Stat box) -->
      <div class="row">
       
	   <div class="box box-primary">
	   
            <div class="box-header with-border">
              <h3 class="box-title" style="color:green"><?php echo $this->session->flashdata('message'); ?></h3>   
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="course_approval_form" id="course_approval_form" method="POST" action="<?php echo base_url();?>course/saveStudentAssignedCourse" enctype="multipart/form-data">
			
              <div class="box-body">
			    <div class="row" align="middle">
			   <div class="form-group col-md-4">
					  <label for="campus">Assign Type<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="assign_type" id="assign_type" class="form-control" onclick="currentAssignDiv();">
						  <option value="">--Select Assign Type--</option>
						  <option value="course">Course Wise</option>
						  <option value="student">Student Wise</option>
					  </select>
					</div>
				</div>
				
				
				<div id="student_wise" style="display:none" >
				<div class="row">
					<div class="form-group col-md-4">
					  <label for="campus">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgramByCampusId();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-4">
					  <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
						  <option value="">--Select Program--</option>
						  <?php //foreach($programs as $program){?>
						  <!--<option value="<?php //echo $program->id; ?>"><?php //echo $program->program_name; ?></option>-->
						 
						  <?php //} ?>
					  </select>
					</div>
					
					<div class="form-group col-md-4">
					  <label for="degree">Degree Name<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterByDegree(),getBatchByDegreeId();">
						  <option value="">--Select Degree--</option>
						   <?php //foreach($degrees as $degree){?>
						 <!-- <option value="<?php //echo $degree->id; ?>"><?php //echo $degree->degree_name; ?></option>-->
						 
						  <?php// } ?>
					  </select>
					</div>
				 </div>
				 
				 
				  <div class="row">
					<div class="form-group col-md-4">
					  <label for="batch_id">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control" >
						  <option value="">--Select Batch--</option>
						  <?php foreach($batches as $batch){?>
						  <option value="<?php echo $batch->id; ?>"><?php echo $batch->batch_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-4">
					  <label for="semester_id">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control" onchange="getStudentByDegreeCampusBatchAndSemester();">
						  <option value="">--Select Program--</option>
						 
					  </select>
					</div>
					
					<div class="form-group col-md-4">
					  <label for="degree">Student<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="student_id" id="student_id" onclick="showStatus(this.value);">
						  <option value="">--Select Student--</option>
						   <?php //foreach($degrees as $degree){?>
						 <!-- <option value="<?php //echo $degree->id; ?>"><?php //echo $degree->degree_name; ?></option>-->
						 
						  <?php// } ?>
					  </select>
					</div>
				 </div>
				 
				 <div class="row" id="statusDiv" >
				 	<div class="form-group col-md-4">
					  <label for="batch_id">Status<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="status_id" id="status_id" class="form-control">
						  <option value="">Select Status Type</option>
						 
						  <option value="1">Registered</option>
						  <option value="2">Not Registered</option>
						 
						
					  </select>
					</div>
				 </div>
				 <div class="box-footer">
            
				 <button type="button" name="assign" id="assign" value="Register" onclick="registerCourse();" class="btn btn-success"/>Register</button>
              </div>
				 </div>
			 
			 
			  <!---------------------Course Wise - Start------------------------->
			 	
				<div id="course_wise"  style="display:none" >
				<div class="row">
					<div class="form-group col-md-4">
					  <label for="campus">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="ccampus_id" id="ccampus_id" class="form-control" onchange="ggetProgramByCampusId();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-4">
					  <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="pprogram_id" id="pprogram_id" class="form-control" onchange="ggetDegreebyProgram();">
						  <option value="">--Select Program--</option>
						  <?php foreach($programs as $program){?>
						  <option value="<?php echo $program->id; ?>"><?php echo $program->program_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					
					<div class="form-group col-md-4">
					  <label for="degree">Degree Name<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="ddegree_id" id="ddegree_id" onchange="ggetSemesterByDegree(),ggetBatchByDegreeId(),ggetDisciplineByDegreeId();">
						  <option value="">--Select Degree--</option>
						   <?php //foreach($degrees as $degree){?>
						 <!-- <option value="<?php //echo $degree->id; ?>"><?php //echo $degree->degree_name; ?></option>-->
						 
						  <?php// } ?>
					  </select>
					</div>
				 </div>
				 
				 
				  <div class="row">
					<div class="form-group col-md-4">
					  <label for="batch_id">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="bbatch_id" id="bbatch_id" class="form-control" onchange="loadCourse();">
						  <option value="">--Select --</option>
						  <?php foreach($batches as $batch){?>
						  <option value="<?php echo $batch->id; ?>"><?php echo $batch->batch_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-4">
					  <label for="semester_id">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="ssemester_id" id="ssemester_id" class="form-control" onchange="loadCourse();">
						  <option value="">--Select Program--</option>
						 
					  </select>
					</div>
					
					<div class="form-group col-md-4">
					  <label for="discipline">Discipline<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="discipline_id" id="discipline_id" onchange="loadCourse();">
						  <option value="">--Select Discipline--</option>
						   <?php //foreach($disciplines as $discipline){?>
						  <!-- <option value="<?php echo $discipline->id; ?>"><?php echo $discipline->discipline_name; ?></option>-->
						 
						  <?php // } ?>
					  </select>
					</div>
				 </div>
				 
				 <div class="row">
				 	<div class="form-group col-md-4">
					  <label for="course_id">Course<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="course_id[]" multiple id="course_id" class="form-control" onchange="get_student_list_course(this.value);">
						  <!--<option value="">Select Course</option>-->
						 
						 </select>
					</div>
					<div class="form-group col-md-4" style="display:none" id="examtype_con">
					  <label for="exam_type">Exam<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="exam_type"  id="exam_type" class="form-control" >
						  <option value="">Select Exam</option>
						  <option value="Annual Board">Annual Board</option>
						  <option value="CAP">CAP</option>
						 
						 </select>
					</div>
					</div>
					 <div class="box-footer">
            
				 <button type="button" name="assign" id="assign" value="Register" onclick="registerCourse();" class="btn btn-success"/>Register</button>
              </div>
				 </div>
				 <!---------------------Course Wise -------------------------->
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
				 
			 </div>
			  <div id="studentList" style="display:none">
				   <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
								    <th></th>
								    <th>S.No</th>
									<th>Student Id</th>
									<th>Student Name</th>
									
								</tr>
							</thead>
							<tbody id="tr_list_student">
								
							</tbody>
						</table>
	
	
					</div>
				 </div>
				 
				 
				  <div id="courseList" style="display:none">
				   <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
								    <th>Assign</th>
								    <th>S.No</th>
									<th>Course Code</th>
									<th>Course Title</th>
									<th>Theory Credits</th>
									<th>Practical Credits</th>
								</tr>
							</thead>
							<tbody id="tr_list">
								
							</tbody>
						</table>
	
	
					</div>
				 </div>
			 
			 
              <!-- /.box-body -->

              <div class="box-footer">
            
				 <button type="button" name="assign" id="assign" value="Register" onclick="registerCourse();" class="btn btn-success"/>Register</button>
              </div>
            </form>
			
          </div>
	   <!-- ./col -->
      </div>
      <!-- /.row -->
	  
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
	
	$(document).ready(function() {
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		/*$('#student_id').multiselect({
			        	includeSelectAllOption: true,
			        	enableFiltering: true,
						buttonWidth: '345px',
                        maxHeight: 350
						
			        });*/
		$('#course_id').multiselect({
				includeSelectAllOption: true,
				enableFiltering: true,
				buttonWidth: '345px',
				maxHeight: 350,
				onChange: function(element, checked) {
						get_student_list_course($('#course_id').val());
				}
			});
		//$('#example-getting-started').multiselect();
	});
    function showStatus(id)
	{
		if(id!='')
		{
			$('#statusDiv').show();
		}
		else {
			$('#statusDiv').hide();
		}
	}
	function currentAssignDiv()
	{
		var assign_type =$('#assign_type').val();
		
		if(assign_type=='student')
		{   
			$('#student_wise').show();
			$('#course_wise').hide();
			$('#qualifying_exam').hide();
		}
	    if(assign_type=='course')
		{
			
			$('#course_wise').show();
			$('#student_wise').hide();
			$('#qualifying_exam').hide();
		}
		if(assign_type=='qualifying')
		{
		   $('#qualifying_exam').show();
		   $('#course_wise').hide();
		   $('#student_wise').hide();		 
		}
	}
	function getProgramByCampusId()
	{
		var campus_id =$('#campus_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getProgramByCampusId',
			data: {'campus_id':campus_id},
			success: function(data){
				
			var  option_brand = '<option value="">--Select Program--</option>';
			$('#program_id').empty();
			$("#program_id").append(option_brand+data);
			 }
		});
	}
	function ggetProgramByCampusId()
	{
		var campus_id =$('#ccampus_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getProgramByCampusId',
			data: {'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Program--</option>';
			$('#pprogram_id').empty();
			$("#pprogram_id").append(option_brand+data);
			 }
		});
	}
	function getSemesterByDegree()
	{
		var degree_id =$('#degree_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getSemesterByDegree',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Semester--</option>';
			$('#semester_id').empty();
			$("#semester_id").append(option_brand+data);
			 }
		});
	}
	
	function ggetSemesterByDegree()
	{
		var degree_id =$('#ddegree_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getSemesterByDegree',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Semester--</option>';
			$('#ssemester_id').empty();
			$("#ssemester_id").append(option_brand+data);
			 }
		});
	}
	
	function ggetDisciplineByDegreeId()
	{
		
		var degree_id =$('#ddegree_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDisciplineByDegreeId',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Discipline--</option>';
			$('#discipline_id').empty();
			$("#discipline_id").append(option_brand+data);
			 }
		});
	}
	function getBatchByDegreeId()
	{
		
		var degree_id =$('#degree_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getBatchByDegreeId',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Batch--</option>';
			$('#batch_id').empty();
			$("#batch_id").append(option_brand+data);
			 }
		});
	}
	
	function ggetBatchByDegreeId()
	{
		
		var degree_id =$('#ddegree_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getBatchByDegreeId',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Batch--</option>';
			$('#bbatch_id').empty();
			$("#bbatch_id").append(option_brand+data);
			 }
		});
	}
	function getDegreebyProgram()
	{
		var program_id =$('#program_id').val();
		var campus_id =$('#campus_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDegreebyProgram',
			data: {'program_id':program_id,'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_id').empty();
			$("#degree_id").append(option_brand+data);
			 }
		});
	}
	
	function ggetDegreebyProgram()
	{
		var program_id =$('#pprogram_id').val();
		var campus_id =$('#ccampus_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDegreebyProgram',
			data: {'program_id':program_id,'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#ddegree_id').empty();
			$("#ddegree_id").append(option_brand+data);
			 }
		});
	}
	function getStudentByDegreeCampusBatchAndSemester()
	{
		var $form =$("#course_approval_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getStudentByDegreeCampusBatchAndSemester',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
			//var  option_brand = '';
			var  option_brand = '<option value="">--Select Student--</option>';
			$('#student_id').empty();
			$("#student_id").append(option_brand+data);
			//$('#student_id').multiselect('rebuild');
			 }
		});
		
		
		
		
	}
	
	
	function getStudentByDegreeCampusBatch()
	{
		var batch_id =$('#batch_id').val();
		//alert(batch_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getStudentByDegreeCampusBatch',
			data: {'batch_id':batch_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Student--</option>';
			$('#student_iddddd').empty();
			$("#student_iddddd").append(option_brand+data);
			
			 }
		});
	}
	
	function ggetStudentByDegreeCampusBatch()
	{
		var batch_id =$('#batch_id').val();
		//alert(batch_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getStudentByDegreeCampusBatch',
			data: {'batch_id':batch_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Student--</option>';
			$('#student_id').empty();
			$("#student_id").append(option_brand+data);
			$('#student_id').multiselect('refresh');
			 }
		});
	}
	
	function get_courseby_discipline()
	{
		loadCourse();
	}
	function loadCourse(){
		var discipline_id =$('#discipline_id').val();
		get_student_list_course(discipline_id);
		//var campus_id =$('#ccampus_id').val();
		var program_id =$('#pprogram_id').val();
		var degree_id =$('#ddegree_id').val();
		//var batch_id =$('#bbatch_id').val();
		var semester_id =$('#ssemester_id').val();
		//alert(batch_id); 
		if(discipline_id!='' && program_id!='' && degree_id!='' && semester_id!=''){
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/get_courseby_discipline',
			data: {'discipline_id':discipline_id,'program_id':program_id,'degree_id':degree_id,'semester_id':semester_id},
			success: function(data){
				//alert(data); 
			//var  option_brand = '<option value="">--Select Course--</option>';
			var option_brand='';
			$('#course_id').empty();
			$("#course_id").append(data);
			$('#course_id').multiselect('rebuild');
			 }
		});
		}else{
			$('#course_id').empty();
			$('#course_id').multiselect('rebuild');
		}
	}
   $("#course_approval_form").validate({
		rules: {
			ccampus_id: "required",
			pprogram_id: "required",
			ddegree_id: "required"
		
			
			
		},
		messages: {
			ccampus_id: "Select Campus Name",
			pprogram_id: "Select Program Name",
			ddegree_id:"Select Degree Name"
		
			
				
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	function registerdStudentList(reg)
	{
		//alert(reg); 
	}
	$(document).ready(function(){
		$('#selAll').click(function(){   
		  $('.chkApp').each(function() { // loop through each checkbox
			  this.checked = true;       // select all checkboxes with class "checkbox1"               
		  });
		});
    });
  $(document).ready(function(){
    $('#DeselAll').click(function(){   
      $('.chkApp').each(function() { // loop through each checkbox
          this.checked = false;      // select all checkboxes with class "checkbox1"               
      });
    });

  });
  
  $(document).ready(function(){
	  $("#ccampus_id").on("change", function() {
		 if($("#ccampus_id").val()>=1 && $("#ccampus_id").val()<=4)
			 $('#examtype_con').show();
		 else if($("#ccampus_id").val()>4 && $("#ccampus_id").val()<=6)
			 $('#examtype_con').hide();
		 else
			 $('#examtype_con').hide();
	  });
	  $("#status_id").on("change", function() {
		$('#courseList').show(); 
		var $form = $("#course_approval_form");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/get_selected_student_course_list',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				 $('#tr_list').html(data);
		
			 }
		});
	});
 });
  
  function registerCourse()
  {
	if($("#ccampus_id").val()>=1 && $("#ccampus_id").val()<=4){
		if($('#examtype').val() == ''){
		alert('Please select exam');return false;}
	}
		 
		var $form = $("#course_approval_form");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/saveStudentCourse',
			data: $form.serialize(),
			success: function(data){
				alert("Course successfully approved to student"); 
				// $('#tr_list').html(data);
		
			 }
		});
	
  }
  
  function get_student_list_course(val)
  {
	  	 if(val!='')
			 
			 {
				$('#studentList').show(); 
			 }
			 else{
				$('#studentList').hide();  
			 }
		var $form = $("#course_approval_form");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getStudentListByCourse',
			data: $form.serialize(),
			success: function(data){
				//alert(data);
                if(data=='')	
                {
					$('#tr_list_student').html('No data found');
				}	
               else{				
				$('#tr_list_student').html(data);
               }
			 }
		});
  }
	</script>	
  
  
<script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-multiselect.css" type="text/css"/>

  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 