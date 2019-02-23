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
            <form role="form" name="pg_marks_upload_view" id="pg_marks_upload_view" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				<div class="form-group col-md-4">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram()">
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
						  <?php foreach($programs as $program){?>
						  <option value="<?php echo $program->id; ?>"><?php echo $program->program_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-4">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" >
						  <option value="">--Select Degree--</option>
						 
					  </select>
					</div>
				</div>
				
				
			   <div class="row">
				    <div class="form-group col-md-4">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control">
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>"><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
					
					<div class="form-group col-md-4">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control" onchange="getStudentList();">
						  <option value="">Select Semester</option>
						  <?php foreach($semesters as $semester){ ?>
						  <option value="<?php echo $semester->id;?>"><?php echo $semester->semester_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
				</div>
			   
               <div class="row">
			     <div class="form-group col-md-4">
					  <label for="course-group">Student<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="student_id" id="student_id">
					     <option value="">Select Student</option>
					   </select>
				 </div>
				 <div class="form-group col-md-4">
				  <label for="course-group">Items to be Import<span style="color:red;font-weight: bold;">*</span></label>
				   <select class="form-control" name="marks_type" id="marks_type" onclick="getStudentAssignCourseList();">
					  <option value="1">Internal Marks</option>
					  <option value="2">External Marks</option>
				   </select>
				 </div>
			  </div>
			  </div>
			  	  <div id="courseList" style="display:none">
				   <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr id="internal">
								    <th>Course Code</th>
								    <th>Course Title</th>
									<th>Credit Hours</th>
									<th>Internal Theory(20)</th>
									<th>Term Paper(10)</th>
									<th>Internal Practical(50/100)</th>
								</tr>
								<tr id="external">
								    <th>Course Code</th>
								    <th>Course Title</th>
									<th>Credit Hours</th>
									<th>External Theory(70/100)</th>
								</tr>
							</thead>
							<tbody id="trlist">
								
							</tbody>
						</table>
	
	
					</div>
				 </div>
			  
              <!-- /.box-body -->

              <div class="box-footer">
               <button type="button" class="btn btn-success" onclick="savePGInternalMarks();">Save</button>
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
	function getStudentAssignCourseList()
	{
		 var uploadType=$('#marks_type').val();
	    // alert(uploadType); return false;
		  $("#courseList").show();
	     if(uploadType=='1')
		 {
			 $("#internal").show();
			 $("#external").hide(); 
		 }
		 if(uploadType=='2')
		 {
			$("#external").show(); 
		    $("#internal").hide();
		 }
		var $form =$("#pg_marks_upload_view");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getStudentAssignCourseList',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false;
				$('#trlist').empty();	
				$('#trlist').append(data);
			 }
		});
	}
	function getStudentList()
	{
		var $form =$("#pg_marks_upload_view");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getStudentList',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false;
			var  option_brand = '<option value="">--Select Student--</option>';
			$('#student_id').empty();
			$("#student_id").append(option_brand+data);
			 }
		});
	}
    function getProgram()
	{
		var campus_id =$('#campus_id').val();
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
	function getSyllabusYearbyProgram()
	{
		var program_id =$('#program_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getSyllabusYearbyProgram',
			data: {'program_id':program_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Syllabus Year--</option>';
			$('#syllabus_year').empty();
			$("#syllabus_year").append(option_brand+data);
			 }
		});
	}
	function getCourseByIds()
	{
		var $form =$("#ug_marks_upload_view");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getCourseByIds',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Courses--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
			 }
		});
	}
	function savePGInternalMarks()
	{
		//alert("hello");return false;
		var $form =$("#pg_marks_upload_view");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/savePGInternalMarks',
			data: $form.serialize(),
			success: function(data){
				alert(data); return false; 
				if(data==0)
				{
					alert("Marks Not Saved");
				}
				if(data==1)
				{
					alert("Marks Saved Successfully");
				}
			}
		});
	}
	
	
	
	function saveUGInternalMarks()
	{
		//alert("hello");return false;
		var $form =$("#ug_marks_upload_view");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/saveUGInternalMarks',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false; 
				if(data==0)
				{
					alert("Marks Not Saved");
				}
				if(data==1)
				{
					alert("Marks Saved Successfully");
				}
			
			 }
		});
	}
	
	function getStudentAssignedMarks()
	{   var uploadType=$('#marks_type').val();
	     
		  $("#courseList").show();
	     if(uploadType=='1')
		 {
			 $("#internal").show();
			 $("#external").hide(); 
		 }
		 if(uploadType=='2')
		 {
			$("#external").show(); 
		    $("#internal").hide();
		 }
		var $form =$("#ug_marks_upload_view");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getStudentAssignedMarks',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false;
			$('#trlist').empty();	
			$('#trlist').append(data);
			 }
		});
	}
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
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 