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
               <form role="form" name="student_form" id="student_form" action="<?php echo base_url();?>admin/listUser/<?php echo $role_type;?>" method="post" enctype="multipart/form-data">
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
                        <?php if($role_type == 'student' || $role_type == 'alumini'){?>
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
                        <?php } ?>

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
                           <!--<input type="submit" name="userExcel" id="userExcel" class="btn btn-primary" value="Excel"/>-->

                           <span class="showMsg" id="showMsg"></span>
                           <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
                       </div>

                   </div>


               </form>
			     <!--<div style="float:left;">
				 <form class="form-inline" name="user_form" id="user_form" method="post" action="<?php echo base_url();?>admin/downloadUserExcel">
				  <div class="form-group">
					<select name="user_type" id="user_type" class="form-control" >
					  <option value="">--Select Role--</option>
					  <?php foreach($roles as $role){?>
					  <option value="<?php echo $role->id;?>"><?php echo $role->role_name;?></option>
					 
					  <?php } ?>
					  </select>
				  </div>

				 
				</form>
				</form>

				</div>-->
				 <div style="float:right;">
                     <form class="form-inline" name="user_form" id="user_form" method="post" action="<?php echo base_url();?>admin/downloadUserExcel">
				        <a class="btn btn-primary " href="<?php echo site_url('admin/addUser'); ?>"><i class="fa fa-plus"></i> Add User</a>
                         <input type="submit" name="userPdf" id="userPdf" class="btn btn-primary" value="Export PDF" />
                         <input type="submit" name="csvDownload" id="csvDownload" class="btn btn-primary" value="Export CSV" />
                         <input type="hidden" name="role_type" id="role_type" class="btn btn-primary" value="<?php echo $role_type;?>" />
                         <input type="hidden" name="campus" id="campus" class="btn btn-primary" value="<?php echo $campus_id;?>" />
                         <input type="hidden" name="program" id="program" class="btn btn-primary" value="<?php echo $program_id;?>" />
                         <input type="hidden" name="degree" id="degree" class="btn btn-primary" value="<?php echo $degree_id;?>" />
                         <input type="hidden" name="batch" id="batch" class="btn btn-primary" value="<?php echo $batch_id;?>" />
                     </form>
				</div>
          </div>
            <div class="box-body table-responsive">
						
							 <table id="example" class="table dataTable no-footer" cellspacing="0">
								<thead>
								<tr>
									<th>S.No</th>
									<th>Name</th>
									<th>Image</th>
									<th>Email</th>
                                    <?php if($role_type == 'student' || $role_type == 'alumini'){?>
                                        <th>Student ID</th>
                                    <?php }else{ ?>
									<th>User Type</th>
                                    <?php } ?>
									<th>Contact Number</th>
									<th width="170px">Action</th>
									
								</tr>
							</thead>
									<tbody>
								
									<?php $i=0;foreach ($user_list as $users){ $i++;?>
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
                                        <?php if($role_type == 'student' || $role_type == 'alumini'){?>
                                            <td><?php echo $users->user_unique_id;?></td>
                                        <?php }else{ ?>
                                            <td><?php if($users->role_id == 0 || $users->role_id == '') echo "Super Admin";elseif($users->role_id == 5) echo "Parent";else echo $users->role_name;
                                                ?></td>
                                        <?php } ?>

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
											<a class="btn btn-sm btn-info inner" href="<?php echo base_url(); ?>admin/editUser/<?php echo $users->id.'/'.$users->role_id; ?>" title="Edit" data-toggle="tooltip"><!-- <i class="fa fa-pencil"></i> -->Edit</a>
						
											<!-- <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>admin/deleteUser/<?php echo $users->id.'/'.$users->role_id; ?>" onclick="return areyousure();" title="Delete" data-toggle="tooltip"><i class="fa fa-trash-o"></i> </a>

											 <a class="btn btn-sm btn-primary inner" href="<?php echo base_url(); ?>admin/editUser/<?php echo $users->id.'/'.$users->role_id; ?>" title="View Detail" data-toggle="tooltip">View Details</a>-->
											 
											 <a class="btn btn-sm  inner <?php echo $btnClass; ?>" href="<?php echo base_url(); ?>admin/studentStatus/<?php echo $users->id.'/'.$users->status; ?>" title="<?php echo $title; ?>" data-toggle="tooltip"><i class="fa fa-undo"></i><?php if($users->status=='1') { ?> Active<?php }else { ?> Inactive<?php } ?></a>
											  <a class="btn btn-sm  inner btn-danger" onclick="return confirm('Are you sure to delete?');" href="<?php echo base_url(); ?>admin/deleteUser/<?php echo $users->id.'/0'; ?>" title="<?php echo $title; ?>" data-toggle="tooltip"><i class="fa fa-trash"></i>Delete</a>
										</div>
									</td>
									</tr>
									<?php } ?>
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
              }
          });
      }
	function areyousure(){
		return confirm('Are you sure you want to delete?');
	}
	$(document).ready(function() {
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
    $(document).ready(function () {
		$('#example').DataTable();
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
      $(document).ready(function () {
          <?php if($campus_id>0){?>
          getProgram();
          <?php } ?>
      });
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 