<?php 
//p($user_row); exit;
$this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');?>
<style >
.error{
 color:red;	
}
.bg-info{padding:7px;background-color:#c3c3c3;}

.col-sm-6{ margin-top:2px;}
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
			   <ul class="list-group list-group-unbordered">
                <!--<li class="list-group-item">
                  <b>Total Campus</b> <a class="pull-right"><?php //echo count($campuses);?></a>
                </li>
                <li class="list-group-item">
                  <b>Total Student</b> <a class="pull-right"><?php //echo count($students);?></a>
                </li>
                <li class="list-group-item">
                  <b>Total Degree</b> <a class="pull-right"><?php //echo count($degrees);?></a>
                </li>-->
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
             <!-- <li><a href="#timeline" data-toggle="tab">Payment History</a></li>
              <li><a href="#settings" data-toggle="tab">My Assign Courses</a></li>-->
            </ul>
			
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
			  
			    <form  class="form-horizontal" method="post" name="user_update_form" id="user_update_form" action="<?php echo base_url();?>profile/updateProfile" enctype="multipart/form-data">
				<input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $user_row->role_id;?>">
				  <input type="hidden" class="form-control" id="role_id" name="role_id" value="<?php echo $user_row->role_id;?>">
                <div class="col-sm-6">
                    <label for="inputName" class="col-sm-4  bg-info control-label">Firstname</label>
                    <div class="col-sm-8" style="padding-left:5px;">
                      <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user_row->first_name;?>" placeholder="First Name">
                    </div>
                    </div>
					<div class="col-sm-6">
					  <label for="inputName" class="col-sm-4  bg-info control-label">Lastname</label>

                    <div class="col-sm-8" style="padding-left:5px;">
                      <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user_row->last_name;?>" placeholder="Last Name">
                    </div>
                    </div>
					<div class="col-sm-6">
					  <label for="inputName" class="col-sm-4  bg-info control-label" >Email</label>

                    <div class="col-sm-8" style="padding-left:5px;">
                      <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_row->email;?>" placeholder="Email">
                    </div>
				 </div>
				 
				<div class="col-sm-6">
                    <label for="inputName" class="col-sm-4   bg-info control-label">Contact No.</label>

                    <div class="col-sm-8" style="padding-left:5px;">
                      <input type="text" maxlength="10" class="form-control" id="contact_number" name="contact_number" value="<?php echo $user_row->contact_number;?>" placeholder="Contact No">
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  bg-info control-label">Gender</label>
                    <div class="col-sm-8" style="padding-left:5px;">
                      <select name="gender" id="gender" class="form-control">
						      <option value="">--Select Gender--</option>
							  <option value="male" <?php if($user_row->gender=='male'){ echo "selected"; }?> >Male</option>
							  <option value="male" <?php if($user_row->gender=='female'){ echo "selected"; }?> >Female</option>
					  </select> 
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  bg-info control-label">DOB</label>
                      <div class="col-sm-8" style="padding-left:5px;">
                      <input type="text" class="form-control" id="dob" name="dob"  value="<?php echo $user_row->dob;?>" placeholder="DOB">
                    </div>
					 </div>
					 <!--<div class="col-sm-6">
						<label for="inputName" class="col-sm-4  bg-info control-label">Caste</label>
						  <div class="col-sm-8" style="padding-left:5px;">
						  <input type="text" class="form-control" id="caste" name="caste"  value="<?php echo $user_row->caste;?>" placeholder="Caste">
						</div>
				    </div>-->
				  <div class="form-group">
                    <div class="col-sm-10" style="margin:15px;">
                      <button type="submit" class="btn btn-success">Update</button>
                    </div>
					
					  <div class=" col-sm-2">
                     <!-- <button type="submit" class="btn btn-primary">Back</button>-->
                    </div>
					
                  </div>
				 </form>
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
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
    
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
   $("#user_update_form").validate({
		rules: {
			contact_number: {
				required:true,
				  minlength:10,
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
  
  
 