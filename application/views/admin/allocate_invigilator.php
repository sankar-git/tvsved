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
	       <?php if($role_id > 3 || $role_id == 0) {?>
            <form role="form" name="attendance_form" id="attendance_form"  method="POST" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				<div class="form-group col-md-3">
					  <label for="campus_id">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgramByCampus();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id;?>" <?php if($campus_id == $campus->id){?>selected<?php } ?>><?php echo $campus->campus_name;?></option>
						  <?php }?>
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
						
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control" >
						  <option value="">Select Batch</option>
						
					  </select>
					</div>
					
					<div class="form-group col-md-3">
					<label for="attendance_date">&nbsp;</label><br/>
               <button type="submit" class="btn btn-success" >View</button>
			   <span class="showMsg" id="showMsg"></span>
				  <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
              </div>
					
				
               </div>
				
			    </div>
			</form><?php } ?>
            <div class="box-footer" >
               <p style="color:green" align="center"> <?php echo $this->session->flashdata('message'); ?></p>
			    <!--<div style="float:left;">
				  <a class="btn btn-info " href="<?php echo site_url('course/assignCourse11'); ?>"> Excel Download</a>
				</div>-->
				<?php if($role_id>3 || $role_id==0){?>
				 <!--<div style="float:right;">
				  <a class="btn btn-primary " href="<?php echo site_url('timetable/addTimeTable'); ?>"><i class="fa fa-plus"></i> Add Time-Table</a>
				</div>-->
				<?php }?>
          </div>
            <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
									<th>S.No</th>
									<th>Campus</th>
									<th>Degree</th>
									<th>Semester</th>
									<th>Batch</th>
									<th>Course</th>
									<th>Discipline</th>
									<th>Invigilators</th>
									<th>Hall Superindent</th>
									<th>Exam Type</th>
									<th>Examination</th>
                                    <th>Date</th>
                                    <th>Slot</th>
									<th>Room</th><?php if($role_id>3 || $role_id==0){?>
									<th>Action</th><?php }?>
									
								</tr>
							</thead>
									<tbody>
								
									<?php if(count(@$time_table)>0){ $i=0;foreach ($time_table as $vieww): 
                                       //print_r($assign_list); exit;
                                        $teacher_name='';
                                        $hall_superindent_name='';
                                        if(!empty($vieww->teacher_id)) {
                                            $teacher_res = get_teacher_name($vieww->teacher_id);
                                            if ($teacher_res[0]['name'] != '')
                                                $teacher_name = $teacher_res[0]['name'];
                                        }
                                    if(!empty($vieww->hall_superindent)) {
                                        $hall_superindent_res = get_teacher_name($vieww->hall_superindent);
                                        if ($hall_superindent_res[0]['name'] != '')
                                            $hall_superindent_name = $hall_superindent_res[0]['name'];
                                    }
									$i++;?>
									<tr>
									<td><?php echo $i; ?></td>

									<td><?php echo $vieww->campus_name;?></td>
									<td><?php echo $vieww->degree_name;?></td>
									<td><?php echo $vieww->semester_name;?></td>
									<td nowrap><?php echo $vieww->batch_name;?></td>
									<td><?php echo $vieww->course_title;?></td>
									<td><?php echo $vieww->discipline_name;?></td>
									<td><?php echo ucfirst($teacher_name);?></td>
									<td><?php echo ucfirst($hall_superindent_name);?></td>
                                    <td nowrap><?php if($vieww->exam_type == 1) echo "Regular"; else echo "Cap";?></td>
                                    <td nowrap><?php echo ucfirst(str_replace("_"," ",$vieww->examination));?></td>
                                    <td nowrap><?php echo $vieww->exam_date;?></td>
                                    <td nowrap><?php echo $vieww->slot_name;?></td>
									<td><?php echo $vieww->room_name;?></td>
									
									<?php $title = 'Activate';
									if($vieww->status==1){
										$btnClass = 'btn-success';
										
										$title = 'De-activate';
									}else {
										$btnClass = 'btn-warning';
									}?>
								<?php if($role_id>3 || $role_id==0){?>
									<td>
										<div class="btn-group" style="width:140px;">
											<a class="btn btn-sm btn-info" href="<?php echo site_url('timetable/editTimeTable/'.$vieww->id);?>" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
											<!--<a class="btn btn-sm btn-info" href="<?php echo site_url('timetable/detailTimeTable/'.$vieww->id);?>" title="View" data-toggle="tooltip"><i class="fa fa-eye"></i></a>
						
											 <a class="btn btn-sm btn-danger" href="<?php echo site_url('timetable/deleteTimeTable/'.$vieww->id);?>" onclick="return areyousure();" title="Delete" data-toggle="tooltip"><i class="fa fa-trash-o"></i> </a>
                                             <a class="btn btn-sm <?php echo $btnClass; ?>" href="<?php echo base_url(); ?>timetable/statusTimetable/<?php echo $vieww->id.'/'.$vieww->status; ?>" title="<?php echo $title; ?>" data-toggle="tooltip"><i class="fa fa-undo"></i><?php if($vieww->status=='1') { ?> Active<?php }else { ?> Inactive<?php } ?></a>-->
										</div>
									</td>
									<?php }?>
									</tr>
									<?php endforeach; }?>
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
			<?php if(!empty($batch_id)){?>
			$("#batch_id").val(<?php echo $batch_id;?>);
			<?php } ?>
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
			
			$("#semester_id").append(option_brand+data);
			<?php if(!empty($semester_id)){?>
			$("#semester_id").val(<?php echo $semester_id;?>);
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
			data: {'program_id':program_id,'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_id').empty();
			$("#degree_id").append(option_brand+data);
			<?php if(!empty($degree_id)){?>
				$("#degree_id").val(<?php echo $degree_id;?>)
				getSemesterbyDegree();
				getBatchbyDegree();
			<?php } ?>
			 }
		});
	}
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
			<?php if(!empty($campus_id)){?>
			$("#program_id").val(<?php echo $program_id;?>)
			getDegreebyProgram();
			<?php } ?>
			
			 }
		});	
	}
	<?php if(!empty($campus_id)){?>
	getProgramByCampus();
	<?php } ?>
	$(document).ready(function() {
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
	function areyousure(){
		return confirm('Are you sure you want to delete?');
	}
	
	$(document).ready(function () {
		$('#example').DataTable();
	});
    
 </script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?>