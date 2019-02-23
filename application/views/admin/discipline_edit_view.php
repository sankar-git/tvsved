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
            <form role="form" name="discipline_form" id="discipline_form" method="post" action="<?php echo base_url('discipline/updateDiscipline/'.$discipline_row->id);?>" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-4">
					  <label for="discipline_code">Discipline Code<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="discipline_code" name="discipline_code" value="<?php echo $discipline_row->discipline_code;?>" placeholder="Enter Discipline">
					</div>
					<div class="form-group col-md-4">
					  <label for="discipline_name">Discipline Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="discipline_name" name="discipline_name" value="<?php echo $discipline_row->discipline_name;?>" placeholder="Enter Discipline Name">
					</div>
					<div class="form-group col-md-4">
					  <label for="type">Discipline Type<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="type" id="type" class="form-control">
						      <option value="">--Select Type--</option>
							  <option value="A"  <?php if($discipline_row->type=='A'){ echo "selected"; }?>>Arts</option>
							  <option value="E"  <?php if($discipline_row->type=='E'){ echo "selected"; }?>>Engineering</option>
					  </select> 
					</div>
               </div>
			  </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save</button>
				 <div style="float:right;">
				  <a class="btn btn-primary" href="<?php echo site_url('discipline/viewDiscipline'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
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

   $("#discipline_form").validate({
		rules: {
			discipline_code: "required",
			discipline_name: "required",
			type: "required"
			
		},
		messages: {
			discipline_code: " Discipline Code Is Required.",
			discipline_name:"Discipline Name Is Reqiured.",
			type:"Discipline Type Is Reqiured."
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 