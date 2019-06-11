<?php 
$session_data = $this->session->userdata('sms');
$this->load->view('admin/helper/header');?>
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
           <div class="box-body"> <form role="form" name="course_view" id="course_view" method="post" action="" enctype="multipart/form-data">
		  <div class="row">
				<div class="form-group col-md-3">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id; ?>" <?php if(@$this->input->post('campus_id')==$campus->id){echo "selected";}?>><?php echo $campus->campus_name; ?></option>
						 
						  <?php } ?>
					  </select>
			    </div>
					
					<div class="form-group col-md-3">
					  <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
						  <option value="">--Select Program--</option>
						  <?php foreach($programs as $program){?>
						  <option value="<?php echo $program->id; ?>"><?php echo $program->program_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree(),getBatchbyDegree();" >
						  <option value="">--Select Degree--</option>
						 
					  </select>
					</div>
				
				  
					
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control" >
						  <option value="">Select Batch</option>
						
					  </select>
					</div>
					
					
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control">
						  <option value="">Select Semester</option>
						  <?php foreach($semesters as $semester){ ?>
						  <option value="<?php echo $semester->id;?>"><?php echo $semester->semester_name;?></option>
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
					<div class="form-group col-md-3">
					<label for="attendance_date">&nbsp;</label><br/>
               <button type="submit" class="btn btn-success" >Submit</button>
			   <span class="showMsg success" id="showMsg"></span>
				  <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
              </div>
				</div></form>
			</div>
			 
			 
			
				   <div class="box-body table-responsive">
			       
						 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
								   
								    <th>S.No</th>
									<th>Campus</th>
									<th>Program</th>
									<th>Degree</th>
									<th>Semster</th>
									<th>Batch</th>
									<th>Student</th>
									<th>Course Name</th>
									<th>Type</th>
									<th width="100px">Action</th>
									<!--<th>Print(PDF)</th>-->
								</tr>
							</thead>
							<tbody >
								<?php $i=0;foreach ($course_assign_list as $course){ $i++;?>
									
									<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $course->campus_name;?></td>
									<td><?php echo $course->program_name;?></td>
									<td><?php echo $course->degree_name;?></td>
									<td><?php echo $course->semester_name;?></td>
									<td nowrap><?php echo $course->batch_name;?></td>
									<td><?php echo $course->first_name.' '.$course->last_name;?></td>
									<td><?php echo $course->course_title;?></td>
									<td><?php if($course->exam_type == 2) echo "CAP"; else echo "Regular";?></td>
									<td width="100px"><a onclick="return confirm('Are you sure to Deregister');" href="<?php echo base_url(); ?>course/deleteStudentCourseAssignment/<?php echo $course->id; ?>">Deregister</a></td>
									</tr>
									
									<?php } ?>
							</tbody>
						</table>
	            </div>
				
			 
              <!-- /.box-body -->

              
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
	  $('#example').DataTable();
		//$("#start_date").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		//$("#date_of_closure11").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
    
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
			<?php if(@$this->input->post('batch_id')!=''){?>	
				$('#batch_id').val('<?php echo $this->input->post('batch_id');?>');
			<?php }?>
			
			 }
		});
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
			<?php if(@$this->input->post('program_id')!=''){?>
				$('#program_id').val(<?php echo $this->input->post('program_id');?>);
				getDegreebyProgram();
			<?php }?>
			 }
		});
	}
	function getSemesterbyDegree(){
		var degree_id =$('#degree_id').val();
		//getDisciplineByDegreeId();
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
			<?php if(@$this->input->post('semester_id')!=''){?>
				$('#semester_id').val(<?php echo $this->input->post('semester_id');?>);
				
			<?php }?>
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
			<?php if(@$this->input->post('degree_id')!=''){?>
				$('#degree_id').val(<?php echo $this->input->post('degree_id');?>);
				getSemesterbyDegree();
				getBatchbyDegree();
			<?php }?>
			 }
		});
	}
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?>