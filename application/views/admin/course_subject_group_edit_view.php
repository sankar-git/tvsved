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
        <?=$page_title;?>
      
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$page_title;?></li>
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
            <form role="form" name="course_group_form" id="course_group_form" method="post" action="<?php echo base_url('course/updateCourseSubjectGroup/'.$course_group_row->id);?>" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row" class="col-md-6">
					
					<div class="form-group col-md-3">
					  <label for="degree_name">Course Group Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="course_subject_name" name="course_subject_name" value="<?php echo $course_group_row->course_subject_name;?>" placeholder="Enter Course Group Name">
					</div>
					<div class="form-group col-md-3">
					  <label for="degree_name">Course Group Title<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="course_subject_title" name="course_subject_title" value="<?php echo $course_group_row->course_subject_title;?>" placeholder="Enter Course Group Title">
					</div>
					
               </div>
			 </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Update</button>
				  <div style="float:right;">
				  <a class="btn btn-primary" href="<?php echo site_url('course/listCourseSubjectGroup'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
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

   $("#course_group_form").validate({
		rules: {
			course_group_code: "required",
			course_group_name: "required"
			
			
		},
		messages: {
			course_group_code: "Course Group Code Is Required.",
			course_group_name:"Course Group Name Is Reqiured." 
		 },
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 