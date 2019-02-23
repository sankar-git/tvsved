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
            <form role="form" name="course_form" id="course_form" method="post" action="<?php echo base_url();?>discipline/updateCourse/<?php echo $course_row->id;?>" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" disabled>
						  <option value="">--Select Program--</option>
						  <?php foreach($programs as $program){?>
						  <option value="<?php echo $program->id; ?>" <?php if($course_row->program_id==$program->id){echo "selected";}?>><?php echo $program->program_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" disabled>
						  <option value="">--Select Degree--</option>
						   <?php foreach($degrees as $degree){?>
						  <option value="<?php echo $degree->id; ?>" <?php if($course_row->degree_id==$degree->id){echo "selected";}?>><?php echo $degree->degree_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="discipline">Discipline<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="discipline_id" id="discipline_id" disabled>
						  <option value="">--Select Discipline--</option>
						  <?php foreach($disciplines as $disc){?>
						  <option value="<?php echo $disc->id;?>" <?php if($course_row->discipline_id==$disc->id){echo "selected";}?>><?php echo $disc->discipline_name;?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="course-group">Course Group<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="course_group_id" id="course_group_id" disabled>
						  <option value="">--Select Course Group--</option>
						  <?php foreach($course_groups as $course_group){?>
						  <option value="<?php echo $course_group->id;?>" <?php if($course_row->course_group_id==$course_group->id){echo "selected";}?>><?php echo $course_group->course_group_name;?></option>
						  <?php } ?>
					  </select>
					</div>
				
               </div>
			   
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="course-group">Syllabus Year<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="syllabus_year" id="syllabus_year" disabled>
						  <option value="">Select Syllabus Year</option>
						  <?php foreach($syllabus_years as $syllabus_year_list){?>
						  <option value="<?php echo $syllabus_year_list->id;?>" <?php if($course_row->syllabus_id==$syllabus_year_list->id){echo "selected";}?>><?php echo $syllabus_year_list->syllabus_year;?></option>
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester</label>
					  <select name="semester_id" id="semester_id" class="form-control" disabled>
						  <option value="">Select Semester</option>
						  <?php foreach($semesters as $semester){ ?>
						  <option value="<?php echo $semester->id;?>" <?php if($course_row->semester_id==$semester->id){echo "selected";}?>><?php echo $semester->semester_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="course_code">Course Code<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="course_code" name="course_code" value="<?php echo $course_row->course_code?>" placeholder="Enter Course Code" readonly>
					</div>
					<div class="form-group col-md-3">
					  <label for="course_title">Course Title.<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="course_title" name="course_title" value="<?php echo $course_row->course_title;?>" placeholder="Enter Course Title" readonly>
					</div>
					
               </div>	
			   
			    <div class="row">
				    <div class="form-group col-md-3">
					  <label for="theory_credit">Theory Credits.<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="theory_credit" name="theory_credit" value="<?php echo $course_row->theory_credit;?>" placeholder="Enter Theory Credits" readonly>
					</div>
					<div class="form-group col-md-3">
					  <label for="practicle_credit">Practicle Credits.<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="practicle_credit" name="practicle_credit" value="<?php echo $course_row->practicle_credit?>" placeholder="Enter Practicle Credits" readonly>
					</div>
					<div class="form-group col-md-3">
					  <label for="course-group">Subject Group<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" readonly name="course_subject_id" id="course_subject_id">
						  <option value="">--Select Subject Group--</option>
						  <?php foreach($subject_groups as $subject_group){?>
						  <option value="<?php echo $subject_group->id;?>" <?php if($course_row->course_subject_id==$subject_group->id){echo "selected";}?>><?php echo $subject_group->course_subject_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
               </div>
			  </div>
              <!-- /.box-body -->

              <div class="box-footer">
              <a class="btn btn-primary" href="<?php echo site_url('discipline/viewCourse'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				  
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

   $("#course_form").validate({
		rules: {
			program_id: "required",
			degree_id: "required",
			discipline_id: "required",
			course_group_id:"required",
			syllabus_year:"required",
			semester_id:"required",
			course_code:"required",
			course_title:"required",
			theory_credit:"required",
			practicle_credit:"required",
			
			pincode: {
				required:true,
				digits: true,
				minlength:6,
				maxlength:6
			},
			contact_number: {
				required:true,
				digits: true,
				minlength:10,
				maxlength:10
			},
			mobile_number: {
				required:true,
				digits: true,
				minlength:10,
				maxlength:10
			},
			email:{
				required:true,
				email:true
			},
			
			
			dob:"required",
			sales_email:{
				required:true,
				email:true
			},
			address_name: 'required',
		
			imei_number: {
				required:true,
				digits: true,
				minlength:15,
				maxlength:15
			},
			//driver_image: 'required',
			
			member_address: 'required'
			
		},
		messages: {
			program_id: "Select Program Name",
			degree_id:"Select Degree Name",
			discipline_id: "Select Discipline Name",
			course_group_id:"Select Course Group Name",
			syllabus_year:"Select Syllabus Year Name",
			semester_id:"Select Semester Name",
			course_code:"Enter Course Code",
			course_title:"Enter Course Title",
			theory_credit:"Enter Theory Credits",
			practicle_credit:"Enter Practicle Credits",
			//user_image  	 : "Select an image to upload",
			
				pincode:{ 
					required: "Pincode Number is required",
					minlength: "Enter valid 6 digit Phone Number",
					maxlength: "Enter valid 6 digit Phone Number",
					digits : "Pincode Number Accept only Numbers"
			},
			contact_number:{ 
					required: "Contact Number is required",
					minlength: "Enter valid 10 digit Phone Number",
					maxlength: "Enter valid 10 digit Phone Number",
					digits : "Contact Number Accept only Numbers"
			},
			mobile_number:{ 
					required: "Mobile Number is required",
					minlength: "Enter valid 10 digit Phone Number",
					maxlength: "Enter valid 10 digit Phone Number",
					digits : "Mobile Number Accept only Numbers"
			},
		email:{
				required:"Please enter  email.",
				email:"Please enter valid  email."
			},
			
			dob: "DOB Is Required",
			sales_email:{
				required:"Please enter sales email.",
				email:"Please enter valid sales email."
			},
		 address_name   : "Address is required",
			imei_number:{ 
					required: "IMEI Number is required",
					minlength: "Enter valid 15 digit IMEI Number",
					maxlength: "Enter valid 15 digit IMEI Number",
					digits : "IMEI Number Accept only Numbers"
			},
		   // driver_image  	 : "Select an image to upload",
			member_address   : "Address is required"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 