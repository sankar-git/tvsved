<?php
 $session_data = $this->session->userdata('sms');
 //p($session_data[0]); exit;
 //p($session_data[0]->permission_status); exit;
 $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');
     
	  
?>
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
			<center>
			<div class="row" style="padding-left:30px;" align="rignt">
			 <div class="form-group col-md-4">
					  <label for="wwe">Upload Type<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="upload_type" id="upload_type" onchange="ChangeUploadView();">
						  <option value="">--Select College Type--</option>
						   <option value="B">BVSC</option>
						   <option value="A">BTECH</option>
						 
					 </select>
		      </div>
			  </div>
			  </center>
			 <div id="bvscccc">
            <form role="form" name="ug_marks_upload_view" id="ug_marks_upload_view" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				<?php if($session_data[0]->permission_status=='1'){?>
				<div class="form-group col-md-4">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>
						 
						  <?php } ?>
					  </select>
			    </div>
				<?php }else{?>
				
				<div class="form-group col-md-4">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <?php if($campus->id==$session_data[0]->subadmin_campus_id){?>
						  <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>
						  <?php }?>
						  <?php } ?>
					  </select>
			    </div>
				<?php }?>
				
					<div class="form-group col-md-4">
					  <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
						  <option value="">--Select Program--</option>
						  <?php foreach($programs as $program){?>
						  <option value="<?php echo $program->id; ?>"><?php echo $program->program_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-4">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="uploadView();">
						  <option value="">--Select Degree--</option>
						 
					  </select>
					</div>
				</div>
				
				
			   <div class="row">
				    <div class="form-group col-md-4">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control">
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>"><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
					
					<div class="form-group col-md-4">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control">
						  <option value="">Select Semester</option>
						  <?php foreach($semesters as $semester){ ?>
						  <option value="<?php echo $semester->id;?>"><?php echo $semester->semester_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
					
					<div class="form-group col-md-4">
					  <label for="course-group">Discipline<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="discipline_id" id="discipline_id" onchange="getCourseByIds();">
					   
						  <option value="">Select Discipline</option>
						  <?php foreach($disciplines as $discipline){?>
						    <option value="<?php echo $discipline->id;?>"><?php echo $discipline->discipline_name;?></option>
						  <?php } ?>
						
					  </select>
					</div>
					
					
				
					
               </div>
			   
               <div class="row">
			     <div class="form-group col-md-4">
					  <label for="course-group">Course<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="course_id" id="course_id">
					   
						  <option value="">Select Course</option>
						
						
					  </select>
					</div>
				  <div class="form-group col-md-4">
				  <label for="course-group">Date Of Start<span style="color:red;font-weight: bold;">*</span></label>
				   <select class="form-control" name="date_of_start" id="date_of_start">
				   </select>
				</div>
				<?php if($session_data[0]->upload_type=='1'){?>
				  <div class="form-group col-md-4" id="itemsImport" style="display:none;">
				  <label for="course-group">Items to be Import<span style="color:red;font-weight: bold;">*</span></label>
				   <select class="form-control" name="marks_type" id="marks_type" onchange="getStudentAssignedMarks();">
					  <option value="0">-Select Marks Type-</option>
					  <option value="1">Internal Marks</option>
					  <option value="2">External Marks</option>
				   </select>
				  </div>
				<?php } elseif($session_data[0]->upload_type=='2'){?>
					 <div class="form-group col-md-4" id="itemsImport" style="display:none;">
				       <label for="course-group">Items to be Import<span style="color:red;font-weight: bold;">*</span></label>
				       <select class="form-control" name="marks_type" id="marks_type" onchange="getStudentAssignedMarks();">
						   <option value="0">-Select Marks Type-</option>
						   <option value="1">Internal Marks</option>
						 
					  </select>
				     </div>
				<?php }else{?>
				     <div class="form-group col-md-4" id="itemsImport" style="display:none;">
				       <label for="course-group">Items to be Import<span style="color:red;font-weight: bold;">*</span></label>
				       <select class="form-control" name="marks_type" id="marks_type" onchange="getStudentAssignedMarks();">
						   <option value="0">-Select Marks Type-</option>
						   <option value="2">External Marks</option>
					  </select>
				     </div>
				<?php }?>
			  </div>
			  
			  
			  
			  </div>
			  <div id="bvsc">
			   <div id="courseList" class="courseList" style="display:none" >
			        <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr id="internal" class="internal">
								    <th>Unique Id</th>
								    <!--<th>Student Id</th>-->
								    <th>Student Name</th>
									<th><span style="margin-left: 47px;">INTERNAL</span></br><span>FIRST(10)</span><span>FIRST(10)</span><span>FIRST(10)</span></th>
									<th><span style="margin-left: 47px;">PRACTICAL</span></br><span>PAPER-I(60)</span><span>PAPER-II(60)</span></th>
									
									
								</tr>
								
								<tr id="external" class="external">
								    <th>Unique Id</th>
								   <!-- <th>Student Id</th>-->
								    <th>Student Name</th>
									<th><span style="margin-left: 47px;">INTERNAL</span></br><span>FIRST(10)</span><span>FIRST(10)</span><span>FIRST(10)</span></th>
									<th><span style="margin-left: 47px;">PRACTICAL</span></br><span>PAPER-I(60)</span><span>PAPER-II(60)</span></th>
									<th><span style="margin-left: 47px;">EXTERNAL</span></br><span>PAPER-I(100)</span><span>PAPER-II(100)</span></th>
									
									
								</tr>
							</thead>
							<tbody id="trlist" class="trlist">
								
							</tbody>
						</table>
	                </div>
				</div>
			</div>
		
				
			  
              <!-- /.box-body -->

              <div class="box-footer">
               <button type="button" class="btn btn-success" onclick="saveUGInternalMarksNew();">Save</button>
			  </div>
			  
            </form>
			</div>
			<!--****************************B.Tech ******************************************************************-->
			<div id="btechhh" style="display:none">
			    <form role="form" name="ug_marks_upload_view_btech" id="ug_marks_upload_view_btech" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				<?php if($session_data[0]->permission_status=='1'){?>
				<div class="form-group col-md-4">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_idd" id="campus_idd" class="form-control" onchange="getProgramm();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>
						 
						  <?php } ?>
					  </select>
			    </div>
				<?php } else { ?>
				   <div class="form-group col-md-4">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_idd" id="campus_idd" class="form-control" onchange="getProgramm();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <?php if($campus->id==$session_data[0]->subadmin_campus_id){?>
						  <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>
						 
						  <?php }} ?>
					  </select>
			    </div>
				<?php }?>
				
				
					<div class="form-group col-md-4">
					  <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_idd" id="program_idd" class="form-control" onchange="getDegreebyProgramm();">
						  <option value="">--Select Program--</option>
						  <?php foreach($programs as $program){?>
						  <option value="<?php echo $program->id; ?>"><?php echo $program->program_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-4">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_idd" id="degree_idd">
						  <option value="">--Select Degree--</option>
						 
					  </select>
					</div>
				</div>
				
				
			   <div class="row">
				    <div class="form-group col-md-4">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_idd" id="batch_idd" class="form-control">
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>"><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
					
					<div class="form-group col-md-4">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_idd" id="semester_idd" class="form-control">
						  <option value="">Select Semester</option>
						  <?php foreach($semesters as $semester){ ?>
						  <option value="<?php echo $semester->id;?>"><?php echo $semester->semester_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
					
					<div class="form-group col-md-4">
					  <label for="course-group">Discipline<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="discipline_idd" id="discipline_idd" onchange="getCourseByIdss();">
					   
						  <option value="">Select Discipline</option>
						  <?php foreach($disciplines as $discipline){?>
						    <option value="<?php echo $discipline->id;?>"><?php echo $discipline->discipline_name;?></option>
						  <?php } ?>
						
					  </select>
					</div>
					
					
				
					
               </div>
			   
               <div class="row">
			     <div class="form-group col-md-4">
					  <label for="course-group">Course<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="course_idd" id="course_idd">
					   
						  <option value="">Select Course</option>
						
						
					  </select>
					</div>
				  <div class="form-group col-md-4">
				  <label for="course-group">Date Of Start<span style="color:red;font-weight: bold;">*</span></label>
				   <select class="form-control" name="date_of_startt" id="date_of_startt">
				   </select>
				</div>
			<?php if($session_data[0]->upload_type=='1'){?>
			  <div class="form-group col-md-4" id="itemsImportt" style="display:none;">
			  <label for="course-group">Items to be Import<span style="color:red;font-weight: bold;">*</span></label>
			   <select class="form-control" name="marks_typee" id="marks_typee" onchange="getStudentAssignedMarkss();">
			      <option value="0">-Select Marks Type-</option>
			      <option value="1">Internal Marks</option>
			      <option value="2">External Marks</option>
				  
			   </select>
			  </div>
			<?php } elseif($session_data[0]->upload_type=='2'){?>
			   <div class="form-group col-md-4" id="itemsImportt" style="display:none;">
			  <label for="course-group">Items to be Import<span style="color:red;font-weight: bold;">*</span></label>
			   <select class="form-control" name="marks_typee" id="marks_typee" onchange="getStudentAssignedMarkss();">
			      <option value="0">-Select Marks Type-</option>
			      <option value="1">Internal Marks</option>
			   </select>
			  </div>
			  <?php }else{?>
			  <div class="form-group col-md-4" id="itemsImportt" style="display:none;">
			  <label for="course-group">Items to be Import<span style="color:red;font-weight: bold;">*</span></label>
			   <select class="form-control" name="marks_typee" id="marks_typee" onchange="getStudentAssignedMarkss();">
			      <option value="0">-Select Marks Type-</option>
			      <option value="2">External Marks</option>
			   </select>
			  </div>
			  <?php }?>
			  </div>
			 </div>
			  <div id="bvscwewew">
			   <div id="courseList" class="courseList" style="display:none" >
			        <div class="box-body table-responsive">
						    <table id="example" class="table table-bordered table-hover">
							<thead>
								<tr id="internal" class="internal">
								    <th>Unique Id</th>
								    <th>Student Name</th>
									<th>Internal Theory(30)</th>
									<th>Internal Practical(20)</th>
								</tr>
								<tr id="external" class="external">
								    <th>Unique Id</th>
								    <th>Student Name</th>
									<th>Theory(30)</th>
									<th>Practical(20)</th>
									<th>External Theory(50)</th>
									<!--<th>External Practical(100)</th>-->
							    </tr>
							</thead>
							<tbody id="trlisttt" class="trlist">
							</tbody>
						</table>
	                </div>
				</div>
			</div>
			
				
			  
              <!-- /.box-body -->

              <div class="box-footer">
               <button type="button" class="btn btn-success" onclick="saveUGInternalMarksBtech();">Save</button>
			  </div>
			  
            </form>
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
	
	$(document).ready(function() {
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
	function ChangeUploadView()
	{
		var upload_type =$('#upload_type').val();
		if(upload_type=='A')
		{
			$('#btechhh').show();
			$('#bvscccc').hide();
			
			
		}
		if(upload_type=='B')
		{
			$('#btechhh').hide();
			$('#bvscccc').show();
		}
		//alert(upload_type);
	}
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
			 }
		});
	}
	function getProgramm()
	{
		var campus_idd =$('#campus_idd').val();
		//alert(campus_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getProgramByCampus',
			data: {'campus_id':campus_idd},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Program--</option>';
			$('#program_idd').empty();
			$("#program_idd").append(option_brand+data);
			 }
		});
	}
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
	function getDegreebyProgramm()
	{
		var program_idd =$('#program_idd').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDegreebyProgram',
			data: {'program_id':program_idd},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_idd').empty();
			$("#degree_idd").append(option_brand+data);
			 }
		});
	}
	function getSyllabusYearbyProgram()
	{
		var program_id =$('#program_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getSyllabusYearbyProgram',
			data: {'program_id':program_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Syllabus Year--</option>';
			$('#syllabus_year').empty();
			$("#syllabus_year").append(option_brand+data);
			 }
		});
	}
	function getCourseByIds()
	{
		var $form =$("#ug_marks_upload_view");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getCourseByIds',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				if (!$.trim(data)){   
					 $("#itemsImport").hide();
				}
				else{   
					
					 $("#itemsImport").show();
				}
			var  option_brand = '<option value="">--Select Courses--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
			 }
		});
	}
	
	function getCourseByIdss()
	{
		var $form =$("#ug_marks_upload_view_btech");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getCourseByIdss',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				if (!$.trim(data)){   
					 $("#itemsImportt").hide();
				}
				else{   
					
					 $("#itemsImportt").show();
				}
			var  option_brand = '<option value="">--Select Courses--</option>';
			$('#course_idd').empty();
			$("#course_idd").append(option_brand+data);
			 }
		});
	}
	
	function saveUGInternalMarksNew()
	{
		//alert("hello");return false;
		var $form =$("#ug_marks_upload_view");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/saveUGInternalMarksNew',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false;
                				
				if(data==0)
				{
					alert("Marks Update Successfully"); 
				}
				if(data==1)
				{
					alert("Marks Saved Successfully");
				}
			   
			 }
		});
	}
	function saveUGInternalMarksBtech()
	{
		//alert("hello");return false;
		var $form =$("#ug_marks_upload_view_btech");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/saveUGInternalMarksBtech',
			data: $form.serialize(),
			success: function(data){
				
				if(data==0)
				{
					alert("Marks Update Successfully"); 
				}
				if(data==1)
				{
					alert("Marks Saved Successfully");
				}
				
			
			 }
		});
	}
	
	
	function getStudentAssignedMarks()
	{   var uploadType=$('#marks_type').val();
	           
		        $(".courseList").show();
				
		 
	     if(uploadType=='1')
		 {
			 $(".internal").show();
			 $(".external").hide(); 
		 }
		 if(uploadType=='2')
		 {
			$(".external").show(); 
		    $(".internal").hide();
		 }
		var $form =$("#ug_marks_upload_view");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getStudentAssignedMarks',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false;
			$('.trlist').empty();	
			$('.trlist').append(data);
			 }
		});
	}
	
	function getStudentAssignedMarkss() //for btech
	{   var uploadType=$('#marks_typee').val();
	           
		        $(".courseList").show();
				
		 
	     if(uploadType=='1')
		 {
			 $(".internal").show();
			 $(".external").hide(); 
		 }
		 if(uploadType=='2')
		 {
			$(".external").show(); 
		    $(".internal").hide();
		 }
		var $form =$("#ug_marks_upload_view_btech");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getStudentAssignedMarkss',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false;
			$('.trlist').empty();	
			$('.trlist').append(data);
			 }
		});
	}
	
   $("#course_assign").validate({
		rules: {
			program_id: "required",
			degree_id: "required",
			semester_id: "required",
			previous_semester_id:"required",
			syllabus_year:"required",
			batch_id:"required"
			
			
			
		},
		messages: {
			program_id: "Select Program Name",
			degree_id:"Select Degree Name",
			semester_id: "Select Discipline Name",
			previous_semester_id:"Select Course Group Name",
			syllabus_year:"Select Syllabus Year Name",
			batch_id:"Select Semester Name"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	function getInternal(id)
	{
		//var hour = $(this).closest('tr').find('.hour').val();
		//var row = $(this).closest('tr');
		//alert($(this).prev('input').attr('id'));
		
		//var inputtt = $(row).find('input');
		//alert(inputtt); return false;
	}
	function uploadView()
	{
		var degreeType=$('#degree_id').val();
		
		//alert(degreeType); return false;
		if(degreeType=='1')
		{
		 $('#bvsc').show();
		 $('#btech').hide();
		}
		if(degreeType=='2')
		{
		 $('#bvsc').hide();
		 $('#btech').show();
		}
		 
		
	}
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 