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
        <li class="active"> <?=$page_title;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       
	   <div class="box box-primary">
	       
           <div class="box-footer" >
               <p style="color:green" align="center"> <?php echo $this->session->flashdata('message'); ?></p>
			   <form role="form" name="student_form" id="student_form" action="<?php echo base_url();?>admin/listStudent" method="post" enctype="multipart/form-data">
			   <div class="row">
				   <div class="form-group col-md-3">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){
							  if($campus_id == $campus->id)
								  $selected="selected";
							  else
								  $selected="";
							  ?>
						  <option value="<?php echo $campus->id; ?>" <?php echo $selected;?>><?php echo $campus->campus_name; ?></option>
						 
						  <?php } ?>
					  </select>
			    </div>
					
					<div class="form-group col-md-3">
					  <label for="program_id">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
						  <option value="">--Select Program--</option>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree();" >
						  <option value="">--Select Degree--</option>
						 
					  </select>
					</div>
				    <div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control">
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ 
						  if($batch_id == $batch->id)
								  $selected="selected";
							  else
								  $selected="";
						  ?>
						  <option value="<?php echo $batch->id;?>" <?php echo $selected;?>><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
					
					<!--<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control">
						  <option value="">Select Semester</option>
						  
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="course-group">Discipline<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="discipline_id" id="discipline_id" onchange="getCourseByIds();">
					   
						  <option value="">Select Discipline</option>
					  </select>
					</div>-->
			     
			   
					
					<div class="form-group col-md-3">
					<label for="attendance_date">&nbsp;</label><br/>
               <button type="submit" class="btn btn-success" >Submit</button>
			   <span class="showMsg" id="showMsg"></span>
				  <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
              </div>
				
			  </div>

          </div>
		  </form>
            <div class="box-body table-responsive">
						
							 <table id="example" class="table dataTable no-footer" cellspacing="0">
								<thead>
								<tr>
									<th>S.No</th>
									<th>Name</th>
									<th>Image</th>
									<th>Email</th>
									<th>Student ID</th>
									<th>Contact Number</th>
									<th width="260px">Action</th>
									
								</tr>
							</thead>
									<tbody>
								
									<?php $i=0;foreach ($user_list as $users): $i++;?>
									<tr>
									
									<td><?php echo $i; ?></td>
									
									<td><?php echo ucfirst($users->first_name);?></td>
									
									<td>
									<?php if($users->user_image!='' && file_exists('uploads/user_images/student/'.$users->user_image)){?>
									<img style="width:50px;height:50px;" src="<?php echo base_url('uploads/user_images/student/'.$users->user_image);?>" alt="current"/>
									<?php } else {?>
									<img style="width:50px;height:50px;" src="<?php echo base_url('uploads/user_images/student/');?>/no_image.jpg" alt="current"/>
									<?php }?>
									</td>
									<td><?php echo $users->email;?></td>
									<td><?php echo $users->user_unique_id;?></td>
									<td><?php echo $users->contact_number;?></td>
									
								
								 
										
									<?php $title = 'Activate';
									if($users->status==0){
										$btnClass = 'btn-warning';
										$title = 'De-activate';
									}else {
										$btnClass = 'btn-success';
									}?>
								
									<td>
										
										<div class="btn-group outer">
											<a class="btn btn-sm btn-info inner" href="<?php echo base_url(); ?>admin/editUser/<?php echo $users->uid.'/1'; ?>" title="Edit" data-toggle="tooltip"><!-- <i class="fa fa-pencil"></i> -->Edit</a>
						
											<!-- <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>admin/deleteUser/<?php echo $users->uid.'/1'; ?>" onclick="return areyousure();" title="Delete" data-toggle="tooltip"><i class="fa fa-trash-o"></i> </a>-->

											 <a class="btn btn-sm btn-primary inner" href="<?php echo base_url(); ?>admin/editUser/<?php echo $users->uid.'/'.$users->role_id; ?>" title="View Detail" data-toggle="tooltip"><!-- <i class="fa fa-eye"></i> -->View Details</a>
											 
											 <a class="btn btn-sm  inner <?php echo $btnClass; ?>" href="<?php echo base_url(); ?>admin/studentStatus/<?php echo $users->uid.'/'.$users->status; ?>" title="<?php echo $title; ?>" data-toggle="tooltip"><i class="fa fa-undo"></i><?php if($users->status=='1') { ?> Active<?php }else { ?> Inactive<?php } ?></a>
											  <a class="btn btn-sm  inner btn-danger" onclick="return confirm('Are you sure to delete?');" href="<?php echo base_url(); ?>admin/deleteUser/<?php echo $users->uid.'/1'; ?>" title="<?php echo $title; ?>" data-toggle="tooltip"><i class="fa fa-trash-o"></i> Delete</a>
										</div>
									</td>
									</tr>
									<?php endforeach;?>
							</tbody>
						</table>
	
	
					</div>
           	
			
       
          </div>
	   <!-- ./col -->
      </div>
      <!-- /.row -->
	  
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
  $(document).ready(function () {
		$('#example').DataTable();
	});
	function areyousure(){
		return confirm('Are you sure you want to delete?');
	}
	$(document).ready(function() {
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
    
   $("#user_form").validate({
		rules: {
			user_type: "required"
		},
		messages: {
			user_type: "Select UserType"
			},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	function getProgram()
	{
		var campus_id =$('#campus_id').val();
		//alert(campus_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getProgramByCampus',
			data: {'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Program--</option>';
			$('#program_id').empty();
			$("#program_id").append(option_brand+data);
			<?php if($program_id>0){?>
				$("#program_id").val(<?php echo $program_id;?>);
				getDegreebyProgram();
			<?php } ?>
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
			data: {'campus_id':campus_id,'program_id':program_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_id').empty();
			$("#degree_id").append(option_brand+data);
			<?php if($degree_id>0){?>
				$("#degree_id").val(<?php echo $degree_id;?>);
				getSemesterbyDegree();
			<?php } ?>
			 }
		});
	}
	
	function getSemesterbyDegree(){
		var degree_id =$('#degree_id').val();
		getDisciplineByDegreeId();
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
	
	function getCourseByIds()
	{
		 //$('#courseCon').removeClass('hidden');
		var $form =$("#attendance_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getCourseByIds',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				
			//var  option_brand = '<option value="">--Select Courses--</option>';
			$('#course_id').empty();
			$("#course_id").append(data);
			$('#course_id').multiselect('rebuild');
			 }
		});
	}
	
	function getDisciplineByDegreeId()
	{
		
		var degree_id =$('#degree_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDisciplineByDegreeId',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Discipline--</option>';
			$('#discipline_id').empty();
			$("#discipline_id").append(option_brand+data);
			 }
		});
	}
	$(document).ready(function () {
		<?php if($campus_id>0){?>
			getProgram();
		<?php } ?>
	});
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 