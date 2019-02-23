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
            <form role="form" name="course_approval_form" id="course_approval_form" method="POST" action="<?php echo base_url();?>course/saveStudentAssignedCourse11" enctype="multipart/form-data">
			
              <div class="box-body">
			    <div class="row" align="middle">
			   <div class="form-group col-md-4">
					  <label for="campus">Assign Type<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="assign_type" id="assign_type" class="form-control" onclick="currentAssignDiv();">
						  <option value="">--Select Assign Type--</option>
						  <option value="course">Course Wise</option>
						  <option value="student">Student Wise</option>
						  <option value="qualifying">Qualifying Exam Status(PG-Research Paper)</option>
						
					  </select>
					</div>
				</div>
				
				
				<div id="student_wise" >
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
					  <select name="batch_id" id="batch_id" class="form-control" onchange="getCourseByCDB();">
						  <option value="">--Select Batch--</option>
						  <?php foreach($batches as $batch){?>
						  <option value="<?php echo $batch->id; ?>"><?php echo $batch->batch_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					
					<div class="form-group col-md-4">
					  <label for="semester_id">Course<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="course_id" id="course_id" class="form-control">
						  <option value="">--Select Course--</option>
					</select>
					</div>
					
					<div class="form-group col-md-4">
					  <label for="semester_id">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control" onchange="getStudentWithCourse(this.value);">
						  <option value="">--Select Semester--</option>
					</select>
					</div>
					
				 </div>
				  <div class="row">
					<div class="form-group col-md-4">
					  <label for="batch_id">Status<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="assign_status" id="assign_status" class="form-control" onchange="assignedOrNot();">
						<option value="1">Assign</option> 
						<option value="2">Assigned</option> 
					  </select>
					</div>
				   </div>
				 </div>
			 
			  </div>
			  <div id="studentList" style="display:none">
				   <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
								    <th><input type="checkbox"  id="select_all">Select All</th>
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
            
				 <button type="button" name="assign" id="assign" value="Register" onclick="registerCourseToStudents();" class="btn btn-success"/>Register</button>
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
		//alert(campus_id); return false;
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getProgramByCampusId',
			data: {'campus_id':campus_id},
			success: function(data){
				//alert(data); 
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
	
	function ggetDegreebyProgram()
	{
		var program_id =$('#pprogram_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDegreebyProgram',
			data: {'program_id':program_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#ddegree_id').empty();
			$("#ddegree_id").append(option_brand+data);
			 }
		});
	}
	function assignedOrNot(status)
	{
		var $form = $("#course_approval_form");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>assignment/assignedOrNot',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false;
				$('#tr_list_student').html(data);
			
			 }
		});
	}
	function getStudentWithCourse(semester_id)
	{
		//alert(semester_id); return false;
		if(semester_id!='')
		{
			$('#studentList').show();
		}
		else{
			$('#studentList').hide();
		}
		var $form = $("#course_approval_form");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>assignment/getStudentWithCourse',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false;
				$('#tr_list_student').html(data);
			
			 }
		});
	}
	
	function getCourseByCDB()
	{
		var $form =$("#course_approval_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>assignment/getCourseByCDB',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Course--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
			 }
		});
	}
	
	function registerCourseToStudents()
	{
		var $form =$("#course_approval_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>assignment/registerCourseToStudent',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false;
		        if(data==1)
				{
					alert('Course successfully aproved to students.');
				}
				else
				{
					alert('Course not aproved to students.');
				}
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
			 }
		});
	}
	
	function get_courseby_discipline()
	{
		var discipline_id =$('#discipline_id').val();
		//alert(batch_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/get_courseby_discipline',
			data: {'discipline_id':discipline_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Course--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
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
		var $form = $("#campus_and_degree_form");
		
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
  
  
  //select all checkboxes
$("#select_all").change(function(){  //"select all" change 
    $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
});

//".checkbox" change 
$('.checkbox').change(function(){ 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(false == $(this).prop("checked")){ //if this item is unchecked
        $("#select_all").prop('checked', false); //change "select all" checked status to false
    }
    //check "select all" if all checkbox items are checked
    if ($('.checkbox:checked').length == $('.checkbox').length ){
        $("#select_all").prop('checked', true);
    }
});
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 