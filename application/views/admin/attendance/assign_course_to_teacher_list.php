<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');
        $sessdata= $this->session->userdata('sms');
		$id = $sessdata[0]->id;
		$role_id = $sessdata[0]->role_id;
		
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
            <form role="form" name="attendance_form" id="attendance_form" method="post" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				   <div class="form-group col-md-3">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram(),get_teacher_list();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>
						 
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
						  <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>"><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
					
					<div class="form-group col-md-3">
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
					</div>
			     <div id="courseCon" class="form-group col-md-3 ">
					  <label for="course_id">Course<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control"  multiple="multiple"   id="course_id" name="course_id"></select>
					</div> 
					<div id="teacherCon" class="form-group col-md-3 " >
					  <label for="teacher_id">Teacher<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control"  multiple="multiple"  id="teacher_id" name="teacher_id"></select>
					</div>
			   
					
					<div class="form-group col-md-3">
					<label for="attendance_date">&nbsp;</label><br/>
               <button type="button" class="btn btn-success" onclick="saveAttendance();">Submit</button>
			   <span class="showMsg" id="showMsg"></span>
				  <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
              </div>
				
			  </div>
			   <div id="courseList" style="display:none11">
				   <div class="box-body table-responsive">
						    <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
								    <th>S.No.</th>
									<th>Degree</th>
									<th>Semester</th>
									<th>Batch</th>
									<th>Course</th>
									<th>Teacher</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="tr_list">
							</tbody>
						</table>
	                </div>
			  </div>
              <!-- /.box-body -->
			  <div class="box-footer">
               <button type="button" class="btn btn-success" onclick="saveAttendance();">Submit</button>
			   <span class="showMsg" id="showMsg"></span>
				  <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
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
 

	</script>	

  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
