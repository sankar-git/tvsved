<?php  $this->load->view('admin/helper/header');?>
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

      <div class="row">
        <div class="col-md-3">
           <!-- Profile Image -->
          <div class="box box-primary">
		    
            <div class="box-body box-profile">
              <img   height="50px;" width="50px;"  class="profile-user-img img-responsive img-circle" src="<?php echo base_url();?>uploads/user_images/student/<?php echo $user_row->user_image;?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $user_row->first_name.' '. $user_row->last_name;?></h3>
			  <!-- <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">13,287</a>
                </li>
              </ul>-->
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
              <!--<li><a href="#timeline" data-toggle="tab">Payment History</a></li>
              <li><a href="#settings" data-toggle="tab">My Assign Courses</a></li>-->
            </ul>
			
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
			  
			   <form class="form-horizontal" method="post" name="user_update_form" id="user_update_form" action="<?php echo base_url();?>profile/updateProfile" enctype="multipart/form-data">
				<input type="hidden" class="form-control" id="role_id" name="role_id" value="<?php echo $user_row->role_id;?>">
                 <div class="form-group">
				 
                    <label for="inputName" class="col-sm-1 control-label">Firstname</label>
                    <div class="col-sm-3">
                      <!--<input type="first_name" class="form-control" id="first_name" name="first_name" value="<?php echo $user_row->first_name;?>" placeholder="First Name" readonly>-->
					  <h5><?php echo $user_row->first_name;?></h5>
                    </div>
					
					  <label for="inputName" class="col-sm-1 control-label">Lastname</label>

                    <div class="col-sm-3">
                      <!--<input type="last_name" class="form-control"  id="last_name" name="last_name" value="<?php echo $user_row->last_name;?>" placeholder="Last Name" readonly>-->
					  <h5><?php echo $user_row->last_name;?></h5>
                    </div>
					
					  <label for="inputName" class="col-sm-1  control-label">Email</label>

                      <div class="col-sm-3">
                      <input type="email" class="form-control"  id="email" name="email" value="<?php echo $user_row->email;?>" placeholder="Email" >
					  <span id="emailVerified"></span>
                    </div>
				 </div>
				 
				 <div class="form-group">
                    <label for="inputName" class="col-sm-1 control-label">Contact No.</label>
                     <div class="col-sm-3">
                      <input type="number" class="form-control"  id="contact_number" name="contact_number" value="<?php echo $user_row->contact_number;?>" placeholder="Contact No" >
					  
                    </div>
					<!-- <label for="inputName" class="col-sm-1 control-label">Roll</label>
                    <div class="col-sm-3">
                      <input type="roll" class="form-control"  id="roll" name="roll" value="<?php echo $user_row->roll;?>" placeholder="Role" readonly>
                    </div>-->
					<label for="inputName" class="col-sm-1  control-label">Gender</label>
                    <div class="col-sm-3">
                      <!--<select name="gender" id="gender" class="form-control" disabled>
						      <option value="">--Select Gender--</option>
							  <option value="male" <?php if($user_row->gender=='male'){ echo "selected"; }?> >Male</option>
							  <option value="male" <?php if($user_row->gender=='female'){ echo "selected"; }?> >Female</option>
					  </select> -->
					   <h5><?php echo ucfirst($user_row->gender);?> </h5>
                    </div>
					<label for="inputName" class="col-sm-1 control-label">Batch</label>
                    <div class="col-sm-3">
                       <!--<select name="batch_id" id="batch_id" class="form-control" disabled>
						      <option value="">--Select Batch--</option>
							  <?php $batch_name=''; foreach($batches as $batch){?>
							  <option value="<?php echo $batch->id;?>" <?php if($user_row->batch_id==$batch->id){ $batch_name=$batch->batch_name; echo "selected";}?>><?php echo $batch->batch_name;?></option>
							  <?php } ?>
					   </select> -->
					   <h5><?php echo $batch_name;?> </h5>
                    </div>
				 </div>
				 <div class="form-group">
                    
					<label for="inputName" class="col-sm-1 control-label">Campus</label>

                    <div class="col-sm-3">
						 <!--<select name="campus_id" id="campus_id" class="form-control" disabled>
								  <option value="">--Select Campus--</option>
							 <?php $campus_name=''; foreach($campuses as $campus){?>
							  <option value="<?php echo $campus->id;?>" <?php if($user_row->campus_id==$campus->id){ $campus_name=$campus->campus_name;echo "selected";}?>><?php echo $campus->campus_name;?></option>
							  <?php } ?>
						</select> -->
						 <h5><?php echo $campus_name;?> </h5>
                    </div>
					 <label for="inputName" class="col-sm-1  control-label">Degree</label>

                    <div class="col-sm-3">
						 <!--<select name="degree_id" id="degree_id" class="form-control" disabled>
								  <option value="">--Select Degree--</option>
							<?php $degree_name=''; foreach($degrees as $degree){?>
							  <option value="<?php echo $degree->id;?>" <?php if($user_row->degree_id==$degree->id){ $degree_name = $degree->degree_name;echo "selected"; }?>><?php echo $degree->degree_name;?></option>
							<?php } ?>
						</select> -->
						<h5><?php echo $degree_name;?> </h5>
                    </div>
					<label for="inputName" class="col-sm-1  control-label">Type</label>
					 <div class="col-sm-3">
						<!--<select name="type_id" id="type_id" class="form-control" disabled>
							  <option value="">--Select Type--</option>
							  <option value="1" <?php if($user_row->course_type=='1'){echo "selected";}?>>Full Time</option>
							  <option value="2" <?php if($user_row->course_type=='2'){echo "selected";}?>>Part Time</option>
						</select> -->
						<h5><?php 
						if($user_row->course_type=='1'){echo "Full Time";}
						if($user_row->course_type=='2'){echo "Part Time";}?></h5>
						
                    </div>
				  </div>
				 
				<div class="form-group">
					<label for="inputName" class="col-sm-1 control-label">Religion</label>
                    <div class="col-sm-3">
                       <!--<select name="religion" id="religion" class="form-control" disabled>
						      <option value="">--Select Religion--</option>
							  <option value="1" <?php if($user_row->religion=='1'){echo "selected";}?>>Muslim</option>
							  <option value="2" <?php if($user_row->religion=='2'){echo "selected";}?>>Hindu</option>
							  <option value="3" <?php if($user_row->religion=='3'){echo "selected";}?>>Christian</option>
					   </select>-->
					   <h5><?php 
						if($user_row->religion=='1'){echo "Muslim";}
						if($user_row->religion=='2'){echo "Hindu";}
						if($user_row->religion=='3'){echo "Christian";}?></h5>
                    </div>
					<label for="inputName" class="col-sm-1 control-label">Nationality</label>

                    <div class="col-sm-3">
						 <!--<select name="nationality" id="nationality" class="form-control" disabled>
								  <option value="">--Select Nationality--</option>
								  <option value="1" <?php if($user_row->nationality=='1'){echo "selected";}?>>Indian</option>
								  <option value="2" <?php if($user_row->nationality=='2'){echo "selected";}?>>Hindu</option>
								  <option value="3" <?php if($user_row->nationality=='3'){echo "selected";}?>>Christian</option>
						</select> -->
						<h5>&nbsp;&nbsp;<?php 
						if($user_row->nationality=='1'){echo "Indian";}
						if($user_row->nationality=='2'){echo "Hindu";}
						if($user_row->nationality=='3'){echo "Christian";}?></h5>
                    </div>
					<label for="inputName" class="col-sm-1  control-label">Zip</label>
                    <div class="col-sm-3">
                      <!--<input type="zip_code" class="form-control" id="zip_code" name="zip_code" value="<?php echo $user_row->zip_code;?>" placeholder="Zip" readonly>-->
					  <h5><?php echo $user_row->zip_code;?> </h5>
                    </div>
				 </div>
				 
				  <div class="form-group">
				  
					
                    <label for="inputName" class="col-sm-1 control-label">Country</label>

                    <div class="col-sm-3">
                     <!--<select name="country" id="country" class="form-control" disabled>
						  <option value="">Select Country</option>
						  <?php $country_name=''; foreach($countries as $country){?>
							  <option value="<?php echo $country->id;?>" <?php if($user_row->country_id==$country->id){ $country_name =$country->country_name ;echo "selected"; }?>><?php echo $country->country_name;?></option>
						  <?php } ?>
					  </select>-->
					  <h5><?php echo $country_name;?> </h5>
                    </div>
					 <label for="inputName" class="col-sm-1 control-label">State</label>
                    <div class="col-sm-3">
                      <!--<select name="state" id="state" class="form-control" disabled>
						   <option value="1">Select Country</option>
						  <?php $state_name=''; foreach($states as $state){ ?>
							  <option value="<?php echo $state->id;?>"<?php if($user_row->state_id==$state->id){ $state_name =  $state->state; echo "selected"; }?>><?php echo $state->state;?></option>
							
						  <?php } ?>
					  </select>-->
					  <h5><?php echo $state_name;?> </h5>
                    </div>
					</div>
				  <div class="form-group">
                    <div class="col-sm-2">
                      <button type="submit" class="btn btn-danger">Update</button>
                    </div>
					<div class=" col-sm-10">
                      <h4 class="box-title" style="color:green"><?php echo $this->session->flashdata('message'); ?></h4> 
                    </div>
					
                  </div>
				
				 </form>
				 <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->

<!-- Modal -->
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
        <p>Please enter the OTP.</p>
		<input type="text" name="otp" id="otp" maxlength="4" />
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
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs">Read more</a>
                        <a class="btn btn-danger btn-xs">Delete</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                      <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-camera bg-purple"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                      <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                      <div class="timeline-body">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
			  
			  
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
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
	
	
	
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
	
	$(document).ready(function() {
		<?php if($otp_flag == 1){?>
		$('#myModal').modal('show');
		<?php }?>
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
	function changeEmail()
	{
		var email=$('#email').val();
		//alert(mobile_number); return false;
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>profile/getNewEmail',
			data: {'email':email},
			success: function(data){
				//alert(data);
                if(data==1)
				{
					 $('#emailVerified').append('Email updated Successfully');
				}
				else{
					 $('#emailVerified').append('Email not updated Successfully');
				}				
			}
		});
	}
	
	$('#verifyotp').hide();
    function sendOtp()
	{
		var mobile_number=$('#contact_number').val();
		//alert(mobile_number); return false;
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>profile/getContactNumber',
			data: {'mobile_number':mobile_number},
			success: function(data){
				//alert(data);
                if(data)
				{
					 $('#verifyotp').show();
				}
				else{
					 $('#verifyotp').hide();
				}				
			}
		});
	}
	function verifyMe()
	{
		var verifyotp=$('#verifyotp').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>profile/verifyMe',
			data: {'verifyotp':verifyotp},
			success: function(data){
				//alert(data); 
				if(data==1)
				{
				  $('#verify').append('Mobile Number Verified & Changed');
				  $('#verifyotp').hide()
				}
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
   $("#campus_and_degree_form").validate({
		rules: {
			campus_id: "required",
			program_id: "required",
			degree_id: "required"
		
			
			
		},
		messages: {
			campus_id: "Select Campus Name",
			program_id: "Select Program Name",
			degree_id:"Select Degree Name"
		
			
				
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	$("#frm_otp").validate({
		rules: {
			otp: "required"	
		},
		messages: {
			otp: "Please enter 4 digit OTP"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	$("#user_update_form").validate({
		rules: {
			contact_number: {
				required:true,
				  minlength:9,
				  maxlength:10,
				  number: true
			},
			email:{ 
				required:true,
				email:true
			}
		},
		messages: {
			contact_number: "Please enter contact number",
			email: "Please enter email"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 