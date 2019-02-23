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
	       
            <div class="box-footer" >
               <p style="color:green" align="center"> <?php echo $this->session->flashdata('message'); ?></p>
			     <!--<div style="float:left;">
				  <form method="post" action="<?php echo base_url();?>discipline/downloadCourse">
                                  <input style="background: #1870BB;border: none;color: #fff;padding: 5px 10px;font-size: 13px;" type="submit" value="Download Excel" name="courseExcel">
                  </form>
				</div>-->
				<div class="form-group col-md-4">
						
						 <a class="btn btn-primary " href="<?php echo base_url();?>assets/template/PG_Course_Template.csv">Download PG Course Template</a><br/><br/>
						 <a  class="btn btn-primary " href="<?php echo base_url();?>assets/template/UG_Course_Template.csv">Download UG Course Template</a>
						 
						</div>
						<div class="form-group col-md-3">
					    <form name="courseUpload" id="courseUpload" action="<?php echo base_url();?>discipline/upload" >
						  <label for="campus">Upload Course Excel Format<span style="color:red;font-weight: bold;">*</span></label>
						   <input type="file"  name="userfile" id="userfile"  class="btn btn-primary">  
						   <div class="form-group col-md-5" style="text-align:left; padding-left:40px; padding-top:25px;">
					<input style="background: #1870BB;border: none;color: #fff;padding: 5px 10px;font-size: 13px;" type="submit" value="Upload" name="uploadStuExcel">
					</form>
					</div>
					</div>
					
				 <div style="float:right;" class="form-group col-md-3">
				 <br><br>
				  <a class="btn btn-primary " href="<?php echo site_url('discipline/addCourse'); ?>"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add Course</a>
				</div>
          </div>
		   <div class="box-body"> <form role="form" name="course_view" id="course_view" method="post" action="" enctype="multipart/form-data">
		  <div class="row">
				<div class="form-group col-md-4">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id; ?>" <?php if(@$this->input->post('campus_id')==$campus->id){echo "selected";}?>><?php echo $campus->campus_name; ?></option>
						 
						  <?php } ?>
					  </select>
			    </div>
					
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
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree();" >
						  <option value="">--Select Degree--</option>
						 
					  </select>
					</div>
				</div>
				
				
			   <div class="row">
				  
					
					
					<div class="form-group col-md-4">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control">
						  <option value="">Select Semester</option>
						  <?php foreach($semesters as $semester){ ?>
						  <option value="<?php echo $semester->id;?>"><?php echo $semester->semester_name;?></option>
						  <?php } ?>
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
				</div>
				
				
						
						
				</form>
			</div>
            <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
									<th>S.No</th>
									<th>Course Code</th>
									<th>Course Title</th>
									<th>Course Group</th>
									<th>Theory Credit</th>
									<th>Practicle Credit</th>
									<th>Discipline Name</th>
									<th width="100px">Action</th>
									
								</tr>
							</thead>
									<tbody>
								
									<?php $i=0;foreach ($course_list as $course): $i++;?>
									<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $course->course_code;?></td>
									<td><?php echo $course->course_title;?></td>
									<td><?php echo $course->course_subject_name;?></td>
									<td><?php echo $course->theory_credit;?></td>
									<td><?php echo $course->practicle_credit;?></td>
									<td><?php echo $course->discipline_name;?></td>
									<?php $title = 'Activate';
									if($course->status==1){
										$btnClass = 'btn-success';
										
										$title = 'De-activate';
									}else {
										$btnClass = 'btn-warning';
									}?>
								
									<td>
										<div class="btn-group" style="width:188px;display: flex !important;">
											<a class="btn btn-sm btn-info" style="margin-right: 4px;" href="<?php echo site_url('discipline/editCourse/'.$course->id);?>" title="Edit" data-toggle="tooltip"><!-- <i class="fa fa-pencil"></i> -->Edit</a>
											<a class="btn btn-sm btn-info" style="margin-right: 4px;" href="<?php echo site_url('discipline/detailCourse/'.$course->id);?>" title="View" data-toggle="tooltip"><!-- <i class="fa fa-eye"></i> -->View Details</a>
						
											<!-- <a class="btn btn-sm btn-danger" href="<?php echo site_url('discipline/deleteCourse/'.$course->id);?>" onclick="return areyousure();" title="Delete" data-toggle="tooltip"><i class="fa fa-trash-o"></i> </a>>-->
                                             <a class="btn btn-sm <?php echo $btnClass; ?>" href="<?php echo base_url(); ?>discipline/courseStatus/<?php echo $course->id.'/'.$course->status; ?>" title="<?php echo $title; ?>" data-toggle="tooltip"><i class="fa fa-undo"></i><?php if($course->status=='1') { ?> Active<?php } else { ?> Inactive<?php } ?></a>
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
				getSemesterbyDegree()
			<?php }?>
			 }
		});
	}
	$(document).ready(function() {
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
	function areyousure(){
		return confirm('Are you sure you want to delete?');
	}
	
	$(document).ready(function () {
		$('#example').DataTable();
		<?php if(@$this->input->post('campus_id')!=''){?>
		getProgram();
		<?php }?>
	});
    
 </script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 