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
           <div class="box-body">
		    <div class="col-lg-12" align="center">
                        <div class='flashmsg'>
                           <?php
                              if($excelErr!=""){
                                echo $excelErr; 
                              }
                              ?>
                        </div>
                     </div>
			    <div class="row">
						<div class="form-group col-md-4">
						
						 <label for="campus">Download Student Excel Format<span style="color:red;font-weight: bold;">*</span></label>
						  <form method="post" action="<?php echo base_url();?>student/downloadStudentFormat" enctype="multipart/form-data"> 
									  <input style="background: #1870BB;border: none;color: #fff;padding: 5px 10px;font-size: 13px;" type="submit" value="Download Excel" name="downloadExcel">
						 
						</div>
					
					<div class="form-group col-md-3">
					    
						  <label for="campus">Upload Student Excel Format<span style="color:red;font-weight: bold;">*</span></label>
						   <input type="file"  name="userfile" id="userfile"  class="btn btn-primary">  
					</div>
					<div class="form-group col-md-5" style="text-align:left; padding-left:40px; padding-top:25px;">
					<input style="background: #1870BB;border: none;color: #fff;padding: 5px 10px;font-size: 13px;" type="submit" value="Upload" name="uploadStuExcel">
					</div>
					 </form>
			 </div>
			 </div>
             
			
              <!-- /.box-body -->
		
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
  
  
 