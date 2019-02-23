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
            <form role="form" name="degree_form" id="degree_form" method="post" action="<?php echo base_url();?>master/saveClassRoom" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					
					<div class="form-group col-md-6">
						<input type="hidden" name="id" id="id" value="<?php echo @$class_room_row[0]->id;?>" />
					  <label for="degree_name">Class Room Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="room_name" name="room_name" value="<?php echo @$class_room_row[0]->room_name;?>" placeholder="Enter Room Name">
					</div>
					<div class="form-group col-md-6">
					<label for="campus_id">Campus<span style="color:red;font-weight: bold;">*</span></label>
					    <select name="campus_id" id="campus_id" class="form-control">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campus_list as $campus){?>
						  <option value="<?php echo $campus->id;?>" <?php if(@$class_room_row[0]->campus_id == $campus->id){?>selected<?php }?> ><?php echo $campus->campus_name;?></option>
						<?php }?>
					  </select>
					  </div>
               </div>
			  
			  </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save</button>
				 <button type="reset" class="btn btn-danger">Reset</button>
				 <div style="float:right;">
				  <a class="btn btn-primary" href="<?php echo site_url('master/listclassroom'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
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
			room_name: "required",
			campus_id: "required"
			
		},
		messages: {
			room_name: " Room Name is required.",
			campus_id:"Campus Name is Reqiured."
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 