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
            <form role="form" name="course_assign" id="course_assign" method="post" action="<?php echo base_url();?>course/saveAssignCourse" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				<div class="form-group col-md-3">
					  <label for="campus_id">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgramByCampus();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id;?>" <?php if($this->input->get('campus_id')==$campus->id) echo "selected" ;?>><?php echo $campus->campus_name;?></option>
						  <?php }?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram(),getSyllabusYearbyProgram();">
						  <option value="">--Select Program--</option>
						  <?php foreach($programs as $program){?>
						  <option value="<?php echo $program->id; ?>"><?php echo $program->program_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree()" >
						  <option value="">--Select Degree--</option>
						 
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control">
						  <option value="">Select Semester</option>
						  
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Previous Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="previous_semester_id" id="previous_semester_id" class="form-control">
						  <option value="">Select Semester</option>
						 
					  </select>
					</div>
				<div class="form-group col-md-3">
					  <label for="course-group">Syllabus Year<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="syllabus_year" id="syllabus_year">
						  <option value="">Select Syllabus Year</option>
						
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control" onchange="getCourseList();">
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>"><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
               </div>
			   
			  
			  </div>
			  
			  
			    <div id="courseList" style="display:none11">
				   <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
								    <th><input type="checkbox"  id="select_all">Select All</th>
								    <th>Program</th>
									<th>Discipline</th>
									<th>Degree</th>
									<th>Course</th>
									
								</tr>
							</thead>
							<tbody id="tr_list">
								
							</tbody>
						</table>
	
	
					</div>
				 </div>
              <!-- /.box-body -->
			  
			 

              <div class="box-footer">
               <button type="submit" class="btn btn-success">Assign</button>
			   <button type="reset" class="btn btn-danger">Reset</button>
				  <div style="float:right;">
				  <a class="btn btn-primary" href="<?php echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
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
	
	function getSemesterbyDegree()
	{
		var degree_id =$('#degree_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getSemesterByDegree',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Semester--</option>';
			$('#semester_id').empty();
			$('#previous_semester_id').empty();
			$("#semester_id").append(option_brand+data);
			$("#previous_semester_id").append(option_brand+data);
			 }
		});
	}
    function getCourseList()
	{
		var $form =$("#course_assign");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getCourseList',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				
			$('#courseList').show();
			$('#tr_list').html(data);
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
   $("#course_assign").validate({
		rules: {
			program_id: "required",
			degree_id: "required",
			semester_id: "required",
			
			syllabus_year:"required",
			batch_id:"required"
			
			
			
		},
		messages: {
			program_id: "Select Program Name",
			degree_id:"Select Degree Name",
			semester_id: "Select Discipline Name",
			
			syllabus_year:"Select Syllabus Year Name",
			batch_id:"Select Semester Name"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
		//select all checkboxes
$("#select_all").change(function(){  //"select all" change 
    $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
});

//".checkbox" change 
$('.checkbox').change(function(){ 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(false == $(this).prop("checked")){ //if this item is unchecked
        $("#select_all").prop('checked', false); //change "select all" checked status to false
    }
    //check "select all" if all checkbox items are checked
    if ($('.checkbox:checked').length == $('.checkbox').length ){
        $("#select_all").prop('checked', true);
    }
});
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 