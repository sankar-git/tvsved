<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');?>
<style >
.error{
 color:red;	
}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/css/bootstrap.min.css"
        rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
        rel="stylesheet" type="text/css" />
    <script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
        type="text/javascript"></script>

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
            <form role="form" name="batch_form" id="batch_form" method="post" action="<?php echo base_url();?>message/sendMessage" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				    <div class="form-group col-md-3">
					  <label for="user_type">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select  class="form-control" name="campus_id" id="campus_id" onchange="getUsersByCampus();">
						  <option value="">Select Campus</option>
						  <?php foreach($campuses as $campus){?>
						    <option value="<?php echo $campus->id;?>"><?php echo $campus->campus_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree_code">User<span style="color:red;font-weight: bold;">*</span></label>
					 <select  class="form-control" name="userlist[]" id="userlist">
				     </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree_name">Message<span style="color:red;font-weight: bold;">*</span></label>
					  <textarea type="text" class="form-control" id="message" name="message" placeholder="Enter Message"></textarea>
					</div>
					
               </div>
			 </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Send</button>
				 <button type="reset" class="btn btn-danger">Reset</button>
				  <div style="float:right;">
				  <!--<a class="btn btn-primary" href="<?php echo site_url('batch/listBatch'); ?>"><i class="fa fa-arrow-left"></i> Back</a>-->
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
	function getUsersByCampus()
	{
		var campus_id = $("#campus_id").val();
		//alert(campus_id); return false;
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>message/getUsersByCampus',
			data: {'campus_id':campus_id},
			success: function(data){
			//alert(data); return false;
			$("#userlist").empty();
			$("#userlist").attr("multiple","multiple");
			$("#userlist").multiselect('destroy');
			$("#userlist").append(data);
			$('#userlist').multiselect({ 
			// enableClickableOptGroups: true, 
			enableFiltering: true,  
			includeSelectAllOption: true,   
			}); 
			 }
		});
		
	}
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
			syllabus_year_id: "Syllabus Year Is Required..",
			batch_start_year: "Batch Start Year Is Required.",
			batch_name:"Batch Name Is Reqiured." 
			
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
	
	 <script type="text/javascript">
        $(function () {
            $('#userlist').multiselect({
                includeSelectAllOption: true
            });
            $('#btnSelected').click(function () {
                var selected = $("#userlist option:selected");
              
               
            });
        });
    </script>
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 