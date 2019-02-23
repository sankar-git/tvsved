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
              <div class="box-body">
			   <input type="hidden" name="id" id="id" value="<?php echo @$feedbacks_result->id;?>" />
			    <div class="row">
				  <!--  <div class="form-group col-md-3">
					  
					  <input type="hidden" name="id" id="id" value="<?php echo @$feedbacks_result->id;?>" />
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" >
						  <option value="">--Select Degree--</option>
						  <?php foreach($degrees as $degree){?>
					  <option value="<?php echo $degree->id; ?>" <?php if($degree->id == @$feedbacks_result->degree_id){ ?> selected <?php }?> ><?php echo $degree->degree_name; ?></option>
					 
					  <?php } ?>
						 
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control">
						  <option value="">Select Semester</option>
						  <?php foreach($semesters as $semester){ ?>
						  <option value="<?php echo $semester->id;?>" <?php  if($semester->id == @$feedbacks_result->semester_id){ ?> selected <?php }?>><?php echo $semester->semester_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
               </div>
			   <div class="row">
					<div class="form-group col-md-3">
					  <label for="batch">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control" onchange="getCourseByPDS();">
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>" <?php if($batch->id == @$feedbacks_result->batch_id){ ?> selected <?php }?>><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>-->
					<div class="form-group col-md-3">
					  <label for="batch">Question/Information<span style="color:red;font-weight: bold;">*</span></label>
					  <textarea type="text" name="question" id="question" class="form-control" ><?php echo @$feedbacks_result->question;?></textarea>
					</div>
					
					
					<div class="form-group col-md-3">
					<label for="attendance_date">&nbsp;</label><br/>
               <input  type="submit" name="submit" class="btn btn-success" value="<?php if(@$feedbacks_result->id>0){?>Update<?php }else {?>Save<?php }?>" />
			   <span class="showMsg" id="showMsg"></span>
				  <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
              </div>
				</div>	
			  </div>
			  <div id="courseList" style="display:none11">
				   <div class="box-body table-responsive">
						    <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
								    <th>S.No.</th>
									<!--<th>Degree</th>
									<th>Semester</th>
									<th>Batch</th>-->
									<th>Question</th>
									
									<th>Action</th>
									
								</tr>
							</thead>
							<tbody id="tr_list">
							<?php foreach($feedbacks as $key=>$val){?>
									<tr><td><?php echo $key+1;?></td>
									<!--<td><?php echo $val['degree_name'];?></td>
									<td><?php echo $val['semester_name'];?></td>
									<td><?php echo $val['batch_name'];?></td>-->
									<td><?php echo $val['question'];?></td>
									
									<?php $title = 'Activate';
									if($val['status']==0){
										$btnClass = 'btn-warning';
										$title = 'De-activate';
									}else {
										$btnClass = 'btn-success';
									}?>
									<td><div class="btn-group" style="width:180px;">
											<a class="btn btn-sm btn-info" href="<?php echo site_url('feedback/add/'.$val['id']);?>" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
						
											 
											 <a class="btn btn-sm <?php echo $btnClass; ?>" href="<?php echo base_url(); ?>feedback/feedbackStatus/<?php echo $val['id']; ?>/<?php echo $val['status']; ?>" title="<?php echo $title; ?>" data-toggle="tooltip"><i class="fa fa-undo"></i><?php if($val['status']=='Y') { ?> Active<?php }else { ?> Inactive<?php } ?></a>
										</div></td></tr>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

  <script type="text/javascript">
	

	
    $(document).ready(function () {
		$('#example').DataTable();
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
	function getCourseByPDS()
	{
		var $form = $("#attendance_form");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getCourseByPDS',
			data: $form.serialize(),
			success: function(data){
			var  option_brand = '<option value="">--Select Course--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
		
			 }
		});
	}
	function getStudentAssignByCourse()
	{
		
		var $form = $("#attendance_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getStudentAssignByCourse',
			data: $form.serialize(),
			success: function(data){
			//$('#courseList').show();
			$('#tr_list').html(data);
			//$.dataTable.draw(false);
	
		    }
		});
	}
	
   $("#feedback_form").validate({
		rules: {
			
			//degree_id: "required",
			//semester_id: "required",
			
			//batch_id:"required",
			question:"required"
			
			
			
		},
		messages: {
			
			//degree_id:"Select Degree ",
			//semester_id: "Select Semester",
		
			//batch_id:"Select Batch",
			question:"Please enter question"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
		
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 