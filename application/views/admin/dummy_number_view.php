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
            <form role="form" name="dummy_number_generate_form" id="dummy_number_generate_form" method="post" enctype="multipart/form-data">
			
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-4">
					  <label for="campus">College<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control">
						  <option value="">--Select College--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-4">
					  <label for="batch">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control">
						  <option value="">--Select Batch--</option>
						  <?php foreach($batches as $batch){?>
						  <option value="<?php echo $batch->id; ?>"><?php echo $batch->batch_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					
					<div class="form-group col-md-4">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" >
						  <option value="">--Select Degree--</option>
						   <?php foreach($degrees as $degree){?>
						 <option value="<?php echo $degree->id; ?>"><?php echo $degree->degree_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
				 </div>
				 
				  <div class="row">
						<div class="form-group col-md-2">
					     <label for="from_range">Range From<span style="color:red;font-weight: bold;">*</span></label>
						  <select class="form-control" name="range_from" id="range_from" >
							  <option value="">--Select Range--</option>
							  <?php for($i=10000; $i<=90000; $i=$i+10000){?>
							    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							  <?php } ?>
						  </select>
					    </div>
						
						<div class="form-group col-md-2">
						  <label for="to_range">Range To<span style="color:red;font-weight: bold;">*</span></label>
						  <select class="form-control" name="range_to" id="range_to" >
							  <option value="">--Select Range--</option>
							  <?php for($i=20000; $i<=99999; $i=$i+10000){?>
							    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							  <?php } ?>
						  </select>
					    </div>
						
						<div class="form-group col-md-2">
						<label for="campus">Month<span style="color:red;font-weight: bold;">*</span></label>
					    <select name="month_name" id="month_name" class="form-control">
						  <option value="">--Select Exam Month--</option>
						  <?php $months = array("Jan", "Feb", "Mar","Apr","May","June","July","Aug","Sept","Oct","Nov","Dec");
						  foreach($months as $month_name){?>
						  <option value="<?php echo $month_name; ?>"><?php echo $month_name; ?></option>
						  <?php } ?>
					    </select>
					    </div>
					
				  </div>
				 
			   
			  
			  </div>
              <!-- /.box-body -->

              <div class="box-footer">
               <input type="submit" name="dummy_number_generate" id="dummy_number_generate" value="Generate" class="btn btn-primary"/>
			 <!-- <input type="submit" name="show_dummy_number" id="show_dummy_number" value="Show" class="btn btn-info"/>-->
				
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
   $("#dummy_number_generate_form").validate({
		rules: {
			campus_id: "required",
			batch_id: "required",
			degree_id: "required",
			range_from: "required",
			range_to: "required",
			month_name: "required"
		
			
			
		},
		messages: {
			campus_id: "Select Campus Name",
			batch_id: "Select Batch Name",
			degree_id:"Select Degree Name",
			range_from:"Select From Range",
			range_to:"Select To Range",
			month_name:"Select Month Name"
		
			
				
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 