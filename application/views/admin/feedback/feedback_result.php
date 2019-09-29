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
            <form role="form" name="feedback_form" id="feedback_form" action="<?php echo base_url();?>feedback/save" id="attendance_form" method="post" enctype="multipart/form-data">
             
			  <div id="courseList" style="display:none11">
				   <div class="box-body table-responsive">
						    <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
								    <th>S.No.</th>
									<th>Campus</th>
									<th>Program</th>
									<th>Degree</th>
									<th>Semester</th>
									<th>Batch</th>
									<th>Question</th>
									<th>Student</th>
									<th>Teacher</th>
									<th>Rate</th>
									<th>Comments</th>
									
								</tr>
							</thead>
							<tbody id="tr_list">
							<?php foreach($result as $key=>$val){?>
									<tr><td><?php echo $key+1;?></td>
									<td><?php echo $val['campus_name'];?></td>
									<td><?php echo $val['program_name'];?></td>
									<td><?php echo $val['degree_name'];?></td>
									<td><?php echo $val['semester_name'];?></td>
									<td><?php echo $val['batch_name'];?></td>
									<td><?php echo $val['question'];?></td>
									<td><?php echo $val['student_name'];?></td>
									<td><?php echo $val['teacher_name'];?></td>
									<td><?php echo $val['rate'];?></td>
									<td><?php echo $val['message'];?></td>
									
							<?php }?>
							</tbody>
						</table>
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
	
	
    $(document).ready(function () {
		$('#example').DataTable();
	});
	</script>
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 