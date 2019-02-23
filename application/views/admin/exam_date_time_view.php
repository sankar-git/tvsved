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
            <form role="form" name="exam_date_month_form" id="exam_date_month_form" method="post" enctype="multipart/form-data">
			
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-4">
					  <label for="campus">Month<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="month_name" id="month_name" class="form-control">
						  <option value="">--Select College--</option>
						  <?php $months = array("Jan", "Feb", "Mar","Apr","May","June","July","Aug","Sept","Oct","Nov","Dec");
						  foreach($months as $month_name){?>
						  <option value="<?php echo $month_name; ?>"><?php echo $month_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-4">
					 <label for="date">Date<span style="color:red;font-weight: bold;">*</span></label>
					 
					</div>
					
				
				 </div>
				 
				 </div>
              <!-- /.box-body -->

              <div class="box-footer">
               <input type="submit" name="add_month_date" id="add_month_date" value="Save" class="btn btn-success"/>
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
   $("#campus_and_degree_form").validate({
		rules: {
			campus_id: "required",
			program_id: "required",
			degree_id: "required"
		
			
			
		},
		messages: {
			campus_id: "Select Campus Name",
			program_id: "Select Program Name",
			degree_id:"Select Degree Name"
		
			
				
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 