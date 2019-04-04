<?php //p($this->session->userdata('sms')); exit;
$sessdata= $this->session->userdata('sms');
		$id = $sessdata[0]->id;
		$role_id = $sessdata[0]->role_id;
?>
<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');

?>
<style >
.error{
 color:red;	
}
.bg-info{padding:7px 3px;background-color:#c3c3c3;}
.form-control{padding:0px;}
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
			<?php if(!empty($user_row->user_image)){?>
              <img   height="50px;" width="50px;"  class="profile-user-img img-responsive img-circle" src="<?php echo base_url();?>uploads/user_images/parent/<?php echo $user_row->user_image;?>" alt="User profile picture">
			<?php } else {?>
			
              <img   height="50px;" width="50px;"  class="profile-user-img img-responsive img-circle" src="<?php echo base_url();?>uploads/user_images/student/no_image.jpg" alt="User profile picture">
			<?php } ?>
              <h3 class="profile-username text-center"><?php echo $user_row->first_name;?></h3>
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
             <!--<li><a href="#timeline" data-toggle="tab">Payment History</a></li>-->
              <li><a href="#settings" data-toggle="tab">Student Details</a></li>
			  <!-- <li><a href="#result" data-toggle="tab">Student Result</a></li>-->
            </ul>
			
            <div class="tab-content">
			
			
              <div class="active tab-pane mydetails" id="activity">
			  
			    <form  class="form-horizontal" method="post" name="user_update_form" id="user_update_form" action="<?php echo base_url();?>profile/updateProfile" enctype="multipart/form-data">
				<input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $user_row->role_id;?>">
				  <input type="hidden" class="form-control" id="role_id" name="role_id" value="<?php echo $user_row->role_id;?>">
				  <input type="hidden" class="form-control" id="update_contact" name="update_contact" value="">
				  <div class="col-sm-6">
                    <label for="inputName" class="col-sm-4 control-label  bg-info">First Name</label>
                     <div class="col-sm-8" style="padding-left:3px;padding-right:0px;"><h5><?php echo $user_row->first_name;?></h5>
                    </div>
                    </div><div class="clearfix"></div>
					 <div class="col-sm-6">
                    <label for="inputName" class="col-sm-4 control-label bg-info">Contact No</label>
                     <div class="col-sm-8" style="padding-left:3px;padding-right:0px;">
                      <input type="text" maxlength="10" style="width:80%" class="form-control"  id="contact_number" name="contact_number" value="<?php echo $user_row->contact_number;?>" placeholder="Contact No" />	<div style="position:absolute;right:-20px;top:0px;"><?php if(@$mobile_pending == true){ ?><span class="error">Approval&nbsp;<br>Pending</span><?php }else{?><a class="btn btn-success" style="padding:5px 8px" role="button" href="javascript:updateContact();" >Update</a><?php } ?></div>			  
                    </div>
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-6" style="margin-top:2px">
					 <label for="email" class="col-sm-4  control-label bg-info">Email</label>

                      <div class="col-sm-8" style="padding-left:3px;padding-right:0px;">
                      <input type="email" style="width:80%" class="form-control"  id="email" name="email" value="<?php echo $user_row->email;?>" placeholder="Email" /><div style="position:absolute;right:-20px;top:0px;"><?php if(@$email_pending == true){ ?><span class="error">Approval<br>Pending</span><?php }else{?><a class="btn btn-success" style="padding:5px 8px" role="button" href="javascript:updateEmail();" >Update</a><?php } ?></div>
                    </div>
                    </div>
					<div class="form-group">
                    
					<div class="col-sm-6">
                      <!--<button type="submit" class="btn btn-danger">Update</button>-->
                    </div>
					<div class=" col-sm-6">
                      <h4 class="box-title" style="color:green"><?php echo $this->session->flashdata('message'); ?></h4> 
                    </div>
					
                  </div>
				</form>
				 </div>
				 
          
			  
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                
			  
			   <form class="form-horizontal" method="post" name="user_update_form" id="user_update_form" action="<?php echo base_url();?>profile/updateProfile" enctype="multipart/form-data">
				<input type="hidden" class="form-control" id="role_id" name="role_id" value="<?php echo $student_row->role_id;?>">
				<div class="col-sm-6">
						<label for="inputName" class=" col-sm-4  bg-info control-label">Student ID</label>
						<div class="col-sm-8">
							<h5>&nbsp;<?php echo $student_row->user_unique_id;?></h5>
						</div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 bg-info  control-label">Name</label>
                    <div class="col-sm-8">
                      <!--<input type="first_name" class="form-control" id="first_name" name="first_name" value="<?php echo $student_row->first_name;?>" placeholder="First Name" readonly>-->
					  <h5><?php echo $student_row->first_name;?></h5>
					  
                    </div>
                    </div>
					<div class="col-sm-6">
					 <label for="email" class="col-sm-4  control-label bg-info">Email</label>
					<div class="col-sm-8" >
					 <h5><?php echo $student_row->email;?></h5>
                    </div>
                      
                    </div>
                 <div class="col-sm-6">
				 <label for="inputName" class="col-sm-4 control-label  bg-info">Gender</label>
                    <div class="col-sm-8">
                      <!--<select name="gender" id="gender" class="form-control" disabled>
						      <option value="">--Select Gender--</option>
							  <option value="male" <?php if($student_row->gender=='male'){ echo "selected"; }?> >Male</option>
							  <option value="male" <?php if($student_row->gender=='female'){ echo "selected"; }?> >Female</option>
					  </select> -->
					   <h5><?php echo ucfirst($student_row->gender);?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					  <label for="inputName" class="col-sm-4 control-label bg-info">DOB</label>
                    <div class="col-sm-8">
                      <!--<input type="last_name" class="form-control"  id="last_name" name="last_name" value="<?php echo $student_row->last_name;?>" placeholder="Last Name" readonly>-->
					  <h5><?php echo $student_row->dob;?></h5>
                    </div>
                    </div>
					 <div class="col-sm-6">
                    <label for="inputName" class="col-sm-4 control-label bg-info">Contact No</label>
                     <div class="col-sm-8" >
					 <h5><?php echo $student_row->contact_number;?></h5>
                    </div>	
					</div>
					<div class="clearfix"></div>
					
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">Aadhaar Number</label>
                    <div class="col-sm-8">
                      
					   <h5><?php echo $student_row->aadhaar_no;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">NAD-ID</label>
                    <div class="col-sm-8">
					   <h5><?php echo $student_row->nad_id;?> </h5>
                    </div>
                    </div>
					<div class="clearfix"></div>
					
					
					
                    
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">Blood Group</label>
					 <div class="col-sm-8">
                     <h5 ><?php echo $student_row->blood_group;?></h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">Mother Tongue</label>
					 <div class="col-sm-8">
                     <h5 ><?php echo $student_row->mother_tongue;?></h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">DayScholar/Hostell</label>
					 <div class="col-sm-8">
                     <h5 ><?php echo $student_row->resident_type;?></h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">Place of Birth</label>
					 <div class="col-sm-8">
                     <h5 ><?php echo $student_row->place_of_birth;?></h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">Nationality</label>
					 <div class="col-sm-8">
                     <h5 ><?php echo $student_row->nationality;?></h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">Religion</label>
					 <div class="col-sm-8">
                     <h5 ><?php echo $student_row->religion;?></h5>
                    </div>
                    </div>
					 <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">Community</label>
					 <div class="col-sm-8">
                     <h5 ><?php echo $student_row->community;?></h5>
                    </div>
                    </div>
					 <div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">Caste</label>
					 <div class="col-sm-8">
                     <h5 ><?php echo $student_row->caste;?></h5>
                    </div>
                    </div>
					
					 <div class="col-sm-6">
                    <label for="inputName" class="col-sm-4 control-label bg-info">Country</label>
                    <div class="col-sm-8">
                     <!--<select name="country" id="country" class="form-control" disabled>
						  <option value="">Select Country</option>
						  <?php $country_name=''; foreach($countries as $country){?>
							  <option value="<?php echo $country->id;?>" <?php if($student_row->country_id==$country->id){ $country_name =$country->country_name ;echo "selected"; }?>><?php echo $country->country_name;?></option>
						  <?php } ?>
					  </select>-->
					  <h5><?php echo $country_name;?> </h5>
                    </div>
					
					</div>
					<div class="col-sm-6">
					 <label for="inputName" class="col-sm-4 control-label bg-info">State</label>
                    <div class="col-sm-8">
                      <!--<select name="state" id="state" class="form-control" disabled>
						   <option value="1">Select Country</option>
						  <?php $state_name=''; foreach($states as $state){ ?>
							  <option value="<?php echo $state->id;?>"<?php if($student_row->state_id==$state->id){ $state_name =  $state->state; echo "selected"; }?>><?php echo $state->state;?></option>
							
						  <?php } ?>
					  </select>-->
					  <h5><?php echo $state_name;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">City</label>
					 <div class="col-sm-8">
					 <?php $city_name=''; foreach($city as $cities) { 
								if(@$student_row->city_id == $cities->city_id){ $city_name =  $cities->city; }
							 } ?>
                     <h5 ><?php echo $city_name;?></h5>
                    </div>
                    </div>
					<div class="col-sm-6">
						<label for="inputName" class="col-sm-4 control-label bg-info">Address1</label>
						<div class="col-sm-8"><h5><?php echo $student_row->address;?></h5>
						</div>					
					</div>
					<div class="col-sm-6">
						<label for="inputName" class="col-sm-4 control-label bg-info">Address2</label>
						<div class="col-sm-8"><h5><?php echo $student_row->address2;?></h5>
						</div>					
					</div>
					<div class="col-sm-6">
						<label for="inputName" class="col-sm-4 control-label bg-info">Address3</label>
						<div class="col-sm-8"><h5><?php echo $student_row->address3;?></h5>
						</div>					
					</div>
					<div class="col-sm-6">
						<label for="inputName" class="col-sm-4 control-label bg-info">Address4</label>
						<div class="col-sm-8"><h5><?php echo $student_row->address4;?></h5>
						</div>					
					</div>					
					
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Pin Code</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->zip_code;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info"> Month of Passing</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->month_passing;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info"> Year of Passing</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->year_passing;?> </h5>
                    </div>
                    </div>
					
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Medium of Instruction</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->medium_instr;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Mode of Admission</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->mode_of_admission;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Fees Category</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->reserved;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Scholarship</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->quota;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Prev Exam/Degree Passed</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->prev_exam_degree;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Previous Exam-Group / Discipline</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->prev_exam_discipline;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">School /Institution last studied</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->last_school;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Board / University last studied</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->last_std;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">% Marks Obtained</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->marks_obtained;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Date Of Admission</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->doa;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Date Of Passing</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->dop;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Ward Counsellor</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->ward_counsellor;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Title of Thesis</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->title_of_thesis;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Remarks1</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->remark;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Remarks1</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->remark2;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Remarks3</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->remark3;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Remarks4</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->remark4;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Remarks5</label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->remark5;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Extra curricular </label>
                    <div class="col-sm-8">
					  <h5><?php echo $student_row->extra_activites;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">Discipline</label>
                    <div class="col-sm-8">
                       <!--<select name="batch_id" id="batch_id" class="form-control" disabled>
						      <option value="">--Select Batch--</option>
							  <?php $discipline_name=''; foreach($disciplines as $discipline){?>
							  <option value="<?php echo $discipline->id;?>" <?php if(@$student_row->discipline_id == $discipline->id){$discipline_name = $discipline->discipline_name; echo "selected";}?>><?php echo $discipline->discipline_name;?></option>
							  <?php }?>
					   </select> -->
					   <h5><?php echo $discipline_name;?> </h5>
                    </div>
                    </div>
						<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">Faculty</label>
					 <div class="col-sm-8">
                     <h5 ><?php echo $student_row->faculty;?></h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">Batch</label>
                    <div class="col-sm-8">
                       <!--<select name="batch_id" id="batch_id" class="form-control" disabled>
						      <option value="">--Select Batch--</option>
							  <?php $batch_name=''; foreach($batches as $batch){?>
							  <option value="<?php echo $batch->id;?>" <?php if($student_row->batch_id==$batch->id){ $batch_name=$batch->batch_name; echo "selected";}?>><?php echo $batch->batch_name;?></option>
							  <?php } ?>
					   </select> -->
					   <h5><?php echo $batch_name;?> </h5>
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4  control-label bg-info">Type</label>
					 <div class="col-sm-8">
						<!--<select name="type_id" id="type_id" class="form-control" disabled>
							  <option value="">--Select Type--</option>
							  <option value="1" <?php if($student_row->course_type=='1'){echo "selected";}?>>Full Time</option>
							  <option value="2" <?php if($student_row->course_type=='2'){echo "selected";}?>>Part Time</option>
						</select> -->
						<h5><?php 
						if($student_row->course_type=='1'){echo "Regular";}
						if($student_row->course_type=='2'){echo "Part Time";}?></h5>
						
                    </div>
                    </div>
					<div class="col-sm-6">
					<label for="inputName" class="col-sm-4 control-label bg-info">Campus</label>

                    <div class="col-sm-8">
						 <!--<select name="campus_id" id="campus_id" class="form-control" disabled>
								  <option value="">--Select Campus--</option>
							 <?php $campus_name=''; foreach($campuses as $campus){?>
							  <option value="<?php echo $campus->id;?>" <?php if($student_row->campus_id==$campus->id){ $campus_name=$campus->campus_name;echo "selected";}?>><?php echo $campus->campus_name;?></option>
							  <?php } ?>
						</select> -->
						 <h5><?php echo $campus_name;?> </h5>
                    </div>
                    </div>
					
					
				 
				 <div class="col-sm-6">
                     <label for="inputName" class="col-sm-4  control-label bg-info">Degree</label>
				
                    <div class="col-sm-8">
						 <!--<select name="degree_id" id="degree_id" class="form-control" disabled>
								  <option value="">--Select Degree--</option>
							<?php $degree_name=''; foreach($degrees as $degree){?>
							  <option value="<?php echo $degree->id;?>" <?php if($student_row->degree_id==$degree->id){ $degree_name = $degree->degree_name;echo "selected"; }?>><?php echo $degree->degree_name;?></option>
							<?php } ?>
						</select> -->
						<h5><?php echo $degree_name;?> </h5>
                    </div>
                    </div>
				  <div class="form-group">
                    
					<div class="col-sm-6">
                      <!--<button type="submit" class="btn btn-danger">Update</button>-->
                    </div>
					<div class=" col-sm-6">
                      <h4 class="box-title" style="color:green"><?php echo $this->session->flashdata('message'); ?></h4> 
                    </div>
					
                  </div>
				 </form>
				 <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->


				 
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
	function updateEmail(){
		$('#update_contact').val(2);$('#user_update_form').submit();
	}
	$(document).ready(function() {
		<?php if($otp_flag == 1){?>
		$('#myModal').modal('show');
		<?php }?>
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
			},
			firstname:{ 
				required:true
			}
		},
		messages: {
			contact_number: "Please enter contact no",
			email: "Please enter email",
			firstname: "Please enter first name"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 