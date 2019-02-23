<?php //p($user_row); exit;?>
<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');?>
<style >
.error{
 color:red;	
}
.bg-info{padding:7px;background-color:#c3c3c3;}
.form-control{padding:0px;}
.col-sm-6{ margin-top:1px;}
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

      <div class="row">
        <div class="col-md-3">
           <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
			<?php if(!empty($user_row->parent_image)){?>
              <img   height="50px;" width="50px;"  class="profile-user-img img-responsive img-circle" src="<?php echo base_url();?>uploads/user_images/student/" alt="User profile picture">
			<?php } else {?>
			
              <img   height="50px;" width="50px;"  class="profile-user-img img-responsive img-circle" src="<?php echo base_url();?>uploads/user_images/student/no_image.jpg" alt="User profile picture">
			<?php } ?>
              <h3 class="profile-username text-center"></h3>
			   <ul class="list-group list-group-unbordered">
               <!-- <li class="list-group-item">
                  <b>Total Campus</b> <a class="pull-right"><?php //echo count($campuses);?></a>
                </li>
                <li class="list-group-item">
                  <b>Total Student</b> <a class="pull-right"><?php //echo count($students);?></a>
                </li>
                <li class="list-group-item">
                  <b>Total Degree</b> <a class="pull-right"><?php //echo count($degrees);?></a>
                </li>
				-->
              </ul>
              <!--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">My Details</a></li>
             <!-- <li><a href="#attendance" data-toggle="tab">Student Attandance</a></li>-->
			</ul>
			
            <div class="tab-content">
			   <div class="active tab-pane mydetails" id="activity">
			    <form  class="form-horizontal" method="post" name="user_update_form" id="user_update_form" action="<?php echo base_url();?>profile/updateTeacherProfile" enctype="multipart/form-data">
				<input type="hidden" class="form-control" id="first_name" name="first_name" value="<?php echo  $user_row->first_name.' '.$user_row->last_name;?>">
				<input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $user_row->user_id;?>">
				  <input type="hidden" class="form-control" id="role_id" name="role_id" value="<?php echo $user_row->role_id;?>">
				  <input type="hidden" class="form-control" id="otp_flag" name="otp_flag" value="<?php echo $otp_flag;?>">
				  <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">Name</label>
                    <div class="col-sm-8"><h5><?php echo  $user_row->first_name.' '.$user_row->last_name;?></h5></div>
                  </div>
                 <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">Email</label>
                    <div class="col-sm-8" style="padding-left:1px;padding-right:0px;"><input type="text" class="form-control" id="email" name="email" value="<?php echo  $user_row->email;?>" style="width:80%" placeholder="Email"><div style="position:absolute;right:-20px;top:0px;"><?php if(@$email_pending == true){ ?><span class="error">Approval<br>Pending</span><?php }else{?><a class="btn btn-success" style="padding:5px 8px" role="button" href="javascript:updateEmail();" >Update</a><?php } ?></div>					
					</div>
                  </div><div class="clearfix"></div>
				  <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">Contact No</label>
                    <div class="col-sm-8" style="padding-left:1px;padding-right:0px;"><input type="text" class="form-control" id="contact_number" name="contact_number" style="width:80%" value="<?php echo  $user_row->contact_number;?>" placeholder="Contact No"><div style="position:absolute;right:-26px;top:0px;"><?php if(@$mobile_pending == true){ ?><span class="error">Approval&nbsp;<br>Pending</span><?php }else{?><a class="btn btn-success" style="padding:5px 8px" role="button" href="javascript:updateContact();" >Update</a><?php } ?></div>	</div>
                  </div>
				  <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">Gender</label>
                    <div class="col-sm-8">
					<!--<select name="gender" id="gender" class="form-control" >
						    <option value="">--Select Gender--</option>
						    <option value="male" <?php if($user_row->gender=="male"){ $gender = 'Male';}?>>Male</option>
						    <option value="female" <?php if($user_row->gender=="female"){$gender = 'Female';}?>>Female</option>
					   
					  </select>-->
					<h5><?php echo  @$gender;?></h5></div>
                  </div>
				  <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">DOB</label>
                    <div class="col-sm-8"><h5><?php echo  $user_row->dob;?></h5></div>
				 </div>
				 <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">Employee Id</label>
                    <div class="col-sm-8"><h5><?php echo  $user_row->employee_id;?></h5></div>
				 </div>
				 <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">Qualification</label>
                    <div class="col-sm-4"><h5><?php echo  $user_row->qualification;?></h5></div>
				 </div>
				 <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">DOJ</label>
                    <div class="col-sm-8"><h5><?php echo  $user_row->date_of_joining;?></h5></div>
				 </div>
				 <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">Designation</label>
                    <div class="col-sm-8">
					<!--<select name="designation" id="designation" class="form-control" disabled>
						<option value="">--Select Discipline--</option>
						<option value="1" <?php if($user_row->designation=='1'){ $designation = 'Professor'; echo "selected";}?>>Professor</option>
						<option value="2" <?php if($user_row->designation=='2'){$designation = 'Assistant Professor';echo "selected";}?>>Assistant Professor</option>
						<option value="3" <?php if($user_row->designation=='3'){$designation = 'Associate Professor';echo "selected";}?>>Associate Professor</option>
						<option value="4" <?php if($user_row->designation=='4'){$designation = 'Director(Physical Education)';echo "selected";}?>>Director(Physical Education)</option>
						<option value="5" <?php if($user_row->designation=='5'){$designation = 'Asst. Director(Physical Education)';echo "selected";}?>>Asst. Director(Physical Education)</option>
						<option value="6" <?php if($user_row->designation=='6'){$designation = 'Deputy Director(Physical Education)';echo "selected";}?>>Deputy Director(Physical Education)</option>
						<option value="7" <?php if($user_row->designation=='7'){$designation = 'Assistant Librarian';echo "selected";}?>>Assistant Librarian</option>
					</select>-->
					
					<h5><?php echo  @$designation;?></h5></div>
				 </div>
				  <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">Department</label>
                    <div class="col-sm-8"><h5><?php echo  $user_row->department;?></h5></div>
				 </div>
				 <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">Campus</label>
                    <div class="col-sm-8">
					<!--<select name="campus" id="campus" disabled class="form-control">
						      <option value="">--Select Campus--</option>
							  <?php $campus=''; foreach($campuses as $campus_Val){
								?>
							   <option value="<?php echo $campus_Val->id;?>" <?php if($user_row->campus==$campus_Val->id){ $campus =$campus_Val->campus_name; echo "selected";}?>><?php echo $campus_Val->campus_name;?></option>
							  <?php }?>
				       </select>-->
					<h5><?php echo  $campus;?></h5></div>
				 </div>
				 <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">Discipline</label>
                    <div class="col-sm-8">
					<!--<select name="discipline_id" id="discipline_id" disabled class="form-control">
						    <option value="">--Select Discipline--</option>
						 <?php $discipline_name=''; foreach($disciplines as $discipline){?>
					      <option value="<?php echo $discipline->id;?>" <?php if($user_row->discipline==$discipline->id){ $discipline_name =$discipline->discipline_name;echo "selected";}?>><?php echo $discipline->discipline_name;?></option>
					     <?php } ?>-->
					<h5><?php echo  $discipline_name;?></h5></div>
				 </div>
				 <div class="form-group">
				     <div class="col-sm-3">
                   
					<!--<button type="submit" class="btn btn-primary">Submit</button>-->
                    </div>
				 </div>
			</form>
				 </div>
				 
             
				<!--<div class="tab-pane" id="attendance">
				<div class="row">
				<div class="col-md-12">
				<div class="box">
				<div class="box-header with-border">
				<h3 class="box-title"><form method="post" enctype="multipart/form-data">
				<div class="">
				</form></h3>
				</div>
				
				<div class="box-body">
				<table class="table table-bordered">
				<tbody><tr>
				  <th style="width: 10px">#</th>
				  <th>Task</th>
				  <th>Progress</th>
				  <th style="width: 40px">Label</th>
				</tr>
				<tr>
				  <td>1.</td>
				  <td>Update software</td>
				  <td>
					<div class="progress progress-xs">
					  <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
					</div>
				  </td>
				  <td><span class="badge bg-red">55%</span></td>
				</tr>
				<tr>
				  <td>2.</td>
				  <td>Clean database</td>
				  <td>
					<div class="progress progress-xs">
					  <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
					</div>
				  </td>
				  <td><span class="badge bg-yellow">70%</span></td>
				</tr>
				<tr>
				  <td>3.</td>
				  <td>Cron job running</td>
				  <td>
					<div class="progress progress-xs progress-striped active">
					  <div class="progress-bar progress-bar-primary" style="width: 30%"></div>
					</div>
				  </td>
				  <td><span class="badge bg-light-blue">30%</span></td>
				</tr>
				<tr>
				  <td>4.</td>
				  <td>Fix and squish bugs</td>
				  <td>
					<div class="progress progress-xs progress-striped active">
					  <div class="progress-bar progress-bar-success" style="width: 90%"></div>
					</div>
				  </td>
				  <td><span class="badge bg-green">90%</span></td>
				</tr>
				</tbody></table>
				</div>
				
				<div class="box-footer clearfix">
				<ul class="pagination pagination-sm no-margin pull-right">
				<li><a href="#">«</a></li>
				<li><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">»</a></li>
				</ul>
				</div>
				</div>
				


				</div>				
				</div>

				</form>
				</div>-->
			  
			 <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

  


</section>
	
	<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
	<form name="frm_otp" id="frm_otp" action="<?php echo base_url();?>profile/updateOTP" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">OTP</h4>
      </div>
      <div class="modal-body">
	  <div class=" col-sm-12">
		<h4 class="box-title" style="color:red"><?php echo $this->session->flashdata('message'); ?></h4> 
        <p>Please enter the OTP.</p>
		<input type="text" name="otp" id="otp" maxlength="4" />
		<a href="<?php echo base_url();?>profile/resendotp/<?php echo time();?>">Re send OTP</a>
	</div>
		<div class=" col-sm-12"><small>Your OTP Valid for 15 minutes</small></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" >Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	  </form>
    </div>

  </div>
</div>
	
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
	
	function updateContact(){
		$('#update_contact').val(1);$('#user_update_form').submit();
	}
	$(document).ready(function() {
		if($('#otp_flag').val() == '1')
			$('#myModal').modal('show');
		$("#dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
		
	});
    
	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 