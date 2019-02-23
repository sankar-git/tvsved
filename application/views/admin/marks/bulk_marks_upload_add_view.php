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
            <form role="form" name="ug_marks_upload_view" id="ug_marks_upload_view" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				<div class="form-group col-md-4">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram();">
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
					  <select name="semester_id" id="semester_id" class="form-control">
						  <option value="">Select Semester</option>
						  <?php foreach($semesters as $semester){ ?>
						  <option value="<?php echo $semester->id;?>"><?php echo $semester->semester_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
					
					<div class="form-group col-md-4">
					  <label for="course-group">Discipline<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="discipline_id" id="discipline_id" onchange="getCourseByIds();">
					   
						  <option value="">Select Discipline</option>
						  <?php foreach($disciplines as $discipline){?>
						    <option value="<?php echo $discipline->id;?>"><?php echo $discipline->discipline_name;?></option>
						  <?php } ?>
						
					  </select>
					</div>
					
					
				
					
               </div>
			   
               <div class="row">
			     <div class="form-group col-md-4">
					  <label for="course-group">Course<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="course_id" id="course_id" onchange="getStudentAssignedMarks();">
					   
						  <option value="">Select Course</option>
						
						
					  </select>
					</div>
				  <div class="form-group col-md-4">
				  <label for="course-group">Date Of Start<span style="color:red;font-weight: bold;">*</span></label>
				   <select class="form-control" name="date_of_start" id="date_of_start">
				   </select>
				</div>
			</div>
			  
			  
			  
			  </div>
			   <div id="courseList" style="display:none">
				   <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr id="internal">
								    <th>Student Unique Id</th>
								    <th>Student Name</th>
									<th>Internal Theory(20)</th>
									<th>Internal Practical(20)</th>
									<th>External Theory(100)</th>
									<th>External Practical(100)</th>
									
								</tr>
							</thead>
							<tbody id="trlist">
								
							</tbody>
						</table>
	
	
					</div>
				 </div>
			  
              <!-- /.box-body -->

              <div class="box-footer">
               <button type="button" class="btn btn-success" onclick="saveMarks();">Save</button>
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
    function getProgram()
	{
		var campus_id =$('#campus_id').val();
		//alert(campus_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>bulkupload/getProgramByCampus',
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
			url:'<?php echo base_url();?>bulkupload/getCourseByIds',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				if (!$.trim(data)){   
					 $("#itemsImport").hide();
				}
				else{   
					
					 $("#itemsImport").show();
				}
			var  option_brand = '<option value="">--Select Courses--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
			 }
		});
	}
	
	function saveMarks()
	{
		//alert("hello");return false;
		var $form =$("#ug_marks_upload_view");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>bulkupload/saveMarks',
			data: $form.serialize(),
			success: function(data){
			//	alert(data); return false; 
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
	{   
	   $("#courseList").show();
	   var $form =$("#ug_marks_upload_view");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>bulkupload/getStudentAssignedMarks',
			data: $form.serialize(),
			success: function(data){
			//	alert(data); return false;
			$('#trlist').empty();	
			$('#trlist').append(data);
			 }
		});
	}
   $("#ug_marks_upload_view").validate({
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
  
  
 