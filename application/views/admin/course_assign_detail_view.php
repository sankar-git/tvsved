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
            <form role="form" name="course_assign" id="course_assign" method="post" action="<?php echo base_url();?>course/updateAssignCourse/<?php echo $course_assign_row->id;?>" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram(),getSyllabusYearbyProgram();" disabled>
						  <option value="">--Select Program--</option>
						  <?php foreach($programs as $program){?>
						  <option value="<?php echo $program->id; ?>" <?php if($course_assign_row->program_id==$program->id){echo "selected";}?>><?php echo $program->program_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" disabled>
						  <option value="">--Select Degree--</option>
						    <?php foreach($degrees as $degree){?>
						  <option value="<?php echo $degree->id; ?>" <?php if($course_assign_row->degree_id==$degree->id){echo "selected";}?>><?php echo $degree->degree_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control" disabled>
						  <option value="">Select Semester</option>
						  <?php foreach($semesters as $semester){ ?>
						  <option value="<?php echo $semester->id;?>" <?php if($course_assign_row->semester_id==$semester->id){echo "selected";}?>><?php echo $semester->semester_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Previous Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="previous_semester_id" id="previous_semester_id" class="form-control" disabled>
						  <option value="">Select Semester</option>
						  <?php foreach($semesters as $semester){ ?>
						  <option value="<?php echo $semester->id;?>"  <?php if($course_assign_row->previous_semester_id==$semester->id){echo "selected";}?>><?php echo $semester->previous_semester_name;?></option>
						  <?php } ?>
					  </select>
					</div>
				
               </div>
			   
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="course-group">Syllabus Year<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="syllabus_year" id="syllabus_year" disabled>
						  <option value="">Select Syllabus Year</option>
						  <?php foreach($syllabus_years as $syllabus_year_row){ ?>
						  <option value="<?php echo $syllabus_year_row->id;?>" <?php if($course_assign_row->syllabus_year_id==$syllabus_year_row->id){echo "selected";}?>><?php echo $syllabus_year_row->syllabus_year;?></option>
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control" disabled>
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>" <?php if($course_assign_row->batch_id==$batch->id){echo "selected";}?>><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
				</div>	
			   
			  </div>
              <!-- /.box-body -->

              <div class="box-footer">
               <div style="float:right;">
				  <a class="btn btn-primary" href="<?php echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>
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
  
  
 