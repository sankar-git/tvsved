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
					<div class="form-group col-md-3">
					  <label for="campus">College<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control"  onchange="getProgramByCampus();">
						  <option value="">--Select College--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
						  <option value="">--Select Program--</option>
						   
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree(),getBatchbyDegree();">
						  <option value="">--Select Degree--</option>
						   
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control" >
						  <option value="">Select Semester</option>
						<?php // foreach($semesters as $semester) {?>
						 <!--<option value="<?php echo $semester->id;?>"><?php echo $semester->semester_name;?></option>-->
						<?php // } ?>
					  </select>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="batch">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control">
						  <option value="">--Select Batch--</option>
						  <?php foreach($batches as $batch){?>
						  <option value="<?php echo $batch->id; ?>"><?php echo $batch->batch_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					
					
				 
				  <div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Exam<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="exam_type" id="exam_type" class="form-control">
						  <option value="">Select Type</option>
						  <option value="1">Regular</option>						  
						  <option value="2">Cap</option>						  
					  </select>
					</div>
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
						
						<div class="form-group col-md-2" style="margin-top:25px">
						<input type="submit" name="dummy_number_generate" id="dummy_number_generate" value="Generate" class="btn btn-primary"/>
					    </div>
					
				  </div>
				 
			   
			  
			  </div>
              <!-- /.box-body -->

              <div class="box-footer">
               
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
    function getProgramByCampus()
	{
	  var campus_id =$('#campus_id').val();
	 // alert(campus_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>generate/getProgramByCampus',
			data: {'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Program--</option>';
			$('#program_id').empty();
			$("#program_id").append(option_brand+data);
			
			 }
		});	
	}
	function getDegreebyProgram()
	{
		var program_id =$('#program_id').val();
		var campus_id =$('#campus_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDegreebyProgram',
			data: {'program_id':program_id,'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_id').empty();
			$("#degree_id").append(option_brand+data);
			 }
		});
	}
	function getSemesterbyDegree(){
		var degree_id =$('#degree_id').val();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>generate/getSemesterbyDegree',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Semester--</option>';
			$('#semester_id').empty();
			$("#semester_id").append(option_brand+data);
			 }
		});
	}
	function getBatchbyDegree()
	{
		var degree_id =$('#degree_id').val();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>generate/getBatchbyDegree',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Batch--</option>';
			$('#batch_id').empty();
			$("#batch_id").append(option_brand+data);
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
  
  
 