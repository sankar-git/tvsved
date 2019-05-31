
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
            <form role="form" name="generate_class_grade_view" id="generate_class_grade_view" method="post" action="" enctype="multipart/form-data">
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
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree();" >
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
					   <select class="form-control" name="course_id" id="course_id">
					   
						  <option value="">Select Course</option>
						
						
					  </select>
					</div>
					 <div class="form-group col-md-4">
					  <label for="month">Month<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="month" id="month">
					   
						  <option value="">Select Month</option>
						<?php for($i=1;$i<=12;$i++){ ?>
						<option value="<?php echo date('F', mktime(0,0,0,$i, 1, date('Y')));?>"><?php echo date('F', mktime(0,0,0,$i, 1, date('Y')));?></option>
						<?php }?>
					  </select>
					</div>
					 <div class="form-group col-md-4">
					  <label for="year">Year<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="year" id="year">
					   
						  <option value="">Select Year</option>
							<?php for($i=date('Y')-10;$i<=date('Y');$i++){?>
							<option value="<?php echo $i;?>"><?php echo $i;?></option>
							<?php }?>
						
					  </select>
					</div>
			    </div>
			   
			   
			  </div>
			  
			  
			  
			  <div id="reportSec" style="display:none">
				   <div class="box-body table-responsive">
			     
					  <div style="float:left;line-height:3.5">
					  <!--<<input type="submit"  name="reg_students" style="margin-left:10px;" id="reg_students" value="REG Students" class="btn btn-primary" formtarget="_blank">-->
					  <input type="submit"  name="class_grade" style="margin-left:10px;" id="class_grade" value="Final Subject Wise Mark " class="btn btn-primary" formtarget="_blank">
					
					  <!--<input type="submit"  name="empty" style="margin-left:10px;" id="empty" value="Final Subject Result" class="btn btn-primary" formtarget="_blank">
					  <input type="submit"  name="blank" style="margin-left:10px;" id="blank" value="Moderation Mark" class="btn btn-primary" formtarget="_blank">
					  <input type="submit"  name="dummy" style="margin-left:10px;" id="dummy" value="Deficit" class="btn btn-primary" formtarget="_blank">-->
					  <input type="submit"  name="pass_fail_list" style="margin-left:10px;" id="pass_fail_list" value="Subject Wise Pass Fail List" class="btn btn-primary" formtarget="_blank">
					  <input type="submit"  name="failed_list" style="margin-left:10px;" id="failed_list" value="Failed List" class="btn btn-primary" formtarget="_blank">
					  <!--<<input type="submit"  name="attendance" style="margin-left:10px;" id="attendance" value="Attendance" class="btn btn-primary" formtarget="_blank">-->
					  <input type="submit"  name="subject_wise_mark" style="margin-left:10px;" id="subject_wise_mark" value="Subject Wise Mark" class="btn btn-primary" formtarget="_blank">
					 </div>
				 </div>
			  </div>
			  
			   <div class="box-body">
			    <div class="row">
				<?php echo @$subject_wise_pass_fail_list;?>
				</div>
				</div>
				
			  
			  <!-- /.box-body -->
			  

           
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
	function getSemesterbyDegree(){
		var degree_id =$('#degree_id').val();
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
			 }
		});
	}
	function getDisciplineByDegreeId()
	{
		
		var degree_id =$('#degree_id').val();
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
	function getDegreebyProgram()
	{
		
		var program_id =$('#program_id').val();
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
	/*function getCourseByIds()
	{
		var $form =$("#generate_class_grade_view");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getCourseByIds',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				if (!$.trim(data)){   
					 $("#reportSec").hide();
				}
				else{   
					
					 $("#reportSec").show();
				}
			var  option_brand = '<option value="">--Select Courses--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
			 }
		});
	}*/
	function getCourseByIds()
	{
		if($('#campus_id').val() == 5 || $('#campus_id').val() == 6)
			var ajaxurl = '<?php echo base_url();?>marks/getCourseByIds';
		else
			var ajaxurl = '<?php echo base_url();?>marks/getCourseGroupByIds';
		var $form =$("#generate_class_grade_view");
		$.ajax({
			type:'POST',
			url:ajaxurl,
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				if (!$.trim(data)){   
					 $("#reportSec").hide();
				}
				else{   
					
					 $("#reportSec").show();
				}
			var  option_brand = '<option value="">--Select Courses--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
			 }
		});
	}
	
	function saveUGInternalMarks()
	{
		//alert("hello");return false;
		var $form =$("#generate_class_grade_view");
		
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
		var $form =$("#generate_class_grade_view");
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
  
  
 