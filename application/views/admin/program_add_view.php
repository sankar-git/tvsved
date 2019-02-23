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
            <form role="form" name="program_form" id="program_form" method="post" action="<?php echo base_url();?>program/saveProgram" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-4">
					  <label for="degree_code">Program Code<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="program_code" name="program_code" placeholder="Enter Program Code">
					</div>
					<div class="form-group col-md-4">
					  <label for="degree_name">Program Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="program_name" name="program_name" placeholder="Enter Program Name">
					</div>
					<div class="form-group col-md-4">
					  <label for="degree_name">Program Description<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="program_description" name="program_description" placeholder="Enter Program Description">
					</div>
               </div>
			 </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save</button>
				 <button type="reset" class="btn btn-danger">Reset</button>
				  <div style="float:right;">
				  <a class="btn btn-primary" href="<?php echo site_url('program/listProgram'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
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

   $("#program_form").validate({
		rules: {
			program_code: "required",
			program_name: "required",
			program_description: "required"
			
		},
		messages: {
			program_code: "Program Code Is Required.",
			program_name:"Program Name Is Reqiured.", 
			program_description:"Program Description Is Reqiured."
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 