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
            <form role="form" name="degree_form" id="degree_form" method="post" action="<?php echo base_url();?>master/saveSlot" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					
					<div class="form-group col-md-6">
						<input type="hidden" name="id" id="id" value="<?php echo @$slot_row[0]->id;?>" />
					  <label for="degree_name">Slot Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="slot_name" name="slot_name" value="<?php echo @$slot_row[0]->slot_name;?>" placeholder="Enter Room Name">
					</div>
					
               </div>
			  
			  </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save</button>
				 <button type="reset" class="btn btn-danger">Reset</button>
				 <div style="float:right;">
				  <a class="btn btn-primary" href="<?php echo site_url('master/listexam_slot'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
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

   $("#degree_form").validate({
		rules: {
			slot_name: "required"
			
		},
		messages: {
			slot_name: " Slot Name is required."
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 