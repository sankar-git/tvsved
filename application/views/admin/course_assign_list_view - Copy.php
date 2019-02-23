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
				  <a class="btn btn-info " href="<?php echo site_url('course/assignCourse11'); ?>"> Excel Download</a>
				</div>-->
				 <div style="float:right;">
				  <a class="btn btn-primary " href="<?php echo site_url('course/assignCourse'); ?>"><i class="fa fa-plus"></i> Assign Course</a>
				</div>
          </div>
            <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
									<th>S.No</th>
									<th>Program</th>
									<th>Degree</th>
									<th>Semester</th>
									<th>Prevoius Semester</th>
									<th>Syllabus Year</th>
									<th>Batch</th>
									<th width="100px">Action</th>
									
								</tr>
							</thead>
									<tbody>
								
									<?php $i=0;foreach ($course_assign_list as $assign_list): 
                                       //print_r($assign_list); exit;
									$i++;?>
									<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $assign_list->program_name;?></td>
									<td><?php echo $assign_list->degree_name;?></td>
									<td><?php echo $assign_list->semester_name;?></td>
									<td><?php echo $assign_list->previous_semester;?></td>
									<td><?php echo $assign_list->syllabus_year;?></td>
									<td><?php echo $assign_list->batch_name;?></td>
									<?php $title = 'Activate';
									if($assign_list->status==1){
										$btnClass = 'btn-success';
										
										$title = 'De-activate';
									}else {
										$btnClass = 'btn-warning';
									}?>
								
									<td>
										<div class="btn-group" style="width:180px;">
											<a class="btn btn-sm btn-info" href="<?php echo site_url('course/editAssigCourse/'.$assign_list->caid);?>" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
											<a class="btn btn-sm btn-info" href="<?php echo site_url('course/viewAssigCourse/'.$assign_list->caid);?>" title="View" data-toggle="tooltip"><i class="fa fa-eye"></i></a>
						
											 <a class="btn btn-sm btn-danger" href="<?php echo site_url('course/deleteAssignCourse/'.$assign_list->caid);?>" onclick="return areyousure();" title="Delete" data-toggle="tooltip"><i class="fa fa-trash-o"></i> </a>
                                             <a class="btn btn-sm <?php echo $btnClass; ?>" href="<?php echo base_url(); ?>course/assignCourseStatus/<?php echo $assign_list->caid.'/'.$assign_list->status; ?>" title="<?php echo $title; ?>" data-toggle="tooltip"><i class="fa fa-undo"></i><?php if($assign_list->status=='1') { ?> Active<?php }else { ?> Inactive<?php } ?></a>
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
  
  
 