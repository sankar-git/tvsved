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
            <form role="form" name="degree_form" id="degree_form" method="post" action="<?php echo base_url();?>master/saveDegree" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-6">
					  <label for="degree_code">Degree  Code<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="degree_code" name="degree_code" placeholder="Enter Degree Code">
					</div>
					<div class="form-group col-md-6">
					  <label for="degree_name">Degree Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="degree_name" name="degree_name" placeholder="Enter Degree Name">
					</div>
					
               </div>
			    <div class="row">
					<div class="form-group col-md-6">
					  <label for="discipline_code">Discipline Name<span style="color:red;font-weight: bold;">*</span></label>
					    <select name="discipline_id" id="discipline_id" class="form-control">
						  <option value="">--Select Discipline--</option>
						  <?php foreach($discipline_list as $discipline){?>
						  <option value="<?php echo $discipline->id;?>"><?php echo $discipline->discipline_name;?></option>
						<?php }?>
					  </select>
					</div>
					<div class="form-group col-md-6">
					  <label for="discipline_name">Program Name<span style="color:red;font-weight: bold;">*</span></label>
					   <select name="program_id" id="program_id" class="form-control">
						  <option value="">--Select Program--</option>
						 <?php foreach($programs as $program){?>
						  <option value="<?php echo $program->id;?>"><?php echo $program->program_name;?></option>
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
				  <a class="btn btn-primary" href="<?php echo site_url('master/listDegree'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
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
			degree_code: "required",
			degree_name: "required",
			discipline_id: "required",
			program_id: "required"
			
		},
		messages: {
			degree_code: " Degree Code Is Required.",
			degree_name:"Degree Name Is Reqiured.",
			discipline_id:"Discipline Name Is Reqiured.",
			program_id:"Program Name Is Reqiured."
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 