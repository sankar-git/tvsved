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
            <form role="form" name="batch_form" id="batch_form" method="post" action="<?php echo base_url();?>batch/updateBatch/<?php echo $batch_row->id;?>" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				    <div class="form-group col-md-3">
					  <label for="degree_code">Syllabus-Year<span style="color:red;font-weight: bold;">*</span></label>
					  <select  class="form-control" name="syllabus_year_id" id="syllabus_year_id">
					  <option value="">Select Syllabus Year</option>
					  <?php foreach($syllabus as $syllaus_value){?>
					  <option value="<?php echo $syllaus_value->id;?>" <?php if($batch_row->syllabus_id==$syllaus_value->id){echo "selected";}?>><?php echo $syllaus_value->syllabus_year;?></option>
					  <?php }?>				 
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree_code">Batch Start Year<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="batch_start_year" name="batch_start_year" value="<?php echo $batch_row->batch_start_year;?>" placeholder="Enter Batch Start Year">
					</div>
					<div class="form-group col-md-3">
					  <label for="degree_name">Batch Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="batch_name" name="batch_name" value="<?php echo $batch_row->batch_name;?>"placeholder="Enter Batch Name">
					</div>
					
               </div>
			 </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save</button>
				
				  <div style="float:right;">
				  <a class="btn btn-primary" href="<?php echo site_url('batch/listBatch'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
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

   $("#batch_form").validate({
		rules: {
			syllabus_year_id: "required",
			batch_start_year: "required",
			batch_name: "required"
			
			
		},
		messages: {
			syllabus_year_id: "Syllabus Year Is Required.",
			batch_start_year: "Batch Start Year Is Required.",
			batch_name:"Batch Name Is Reqiured." 
			
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 