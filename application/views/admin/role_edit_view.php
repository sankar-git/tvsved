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
            <form role="form" name="role_form" id="role_form" method="post" action="<?php echo base_url();?>rolemaster/updateRole/<?php echo $role_row->id;?>" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				   <div class="form-group col-md-3">
					  <label for="degree_code">Role Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="role_name" name="role_name" value="<?php echo $role_row->role_name;?>" placeholder="Enter Batch Start Year">
					</div>
				</div>
			 </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save</button>
				
				  <div style="float:right;">
				  <a class="btn btn-primary" href="<?php echo site_url('rolemaster/listRole'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
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

     $("#role_form").validate({
		rules: {
			role_name: "required",
			role_description: "required"
			
			
			
		},
		messages: {
			role_name: "Role Name Is Required..",
			role_description: "Role Description Is Required."
			
			
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 