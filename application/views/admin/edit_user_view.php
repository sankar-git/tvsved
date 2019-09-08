<?php
//print_r($user_row); exit;
//ini_set("display_errors","Off");
//error_reporting(0);
  $session_data = $this->session->userdata('sms');
  $data= menuAccess($session_data[0]->id,$session_data[0]->role_id);
  //print_r($data);
 $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');?>
<style >
.error{
 color:red;	
}
</style>
<script>

$(document).ready(function() {
		
		<?php if(@$user_education[0]['group'] != '')?>
			setgroup('<?php echo @$user_education[0]['group'];?>');	
	});
function setgroup(val)
	{
		
		$('#phydiv').hide();
		$('#chediv').hide();
		$('#biodiv').hide();
		$('#botdiv').hide();
		$('#zoodiv').hide();
		$('#fishdiv').hide();
		
		if(val != '')
		{
			if(val == 'group1')
			{
				$('#phydiv').show();
				$('#chediv').show();
				$('#biodiv').show();
			}
			if(val == 'group2')
			{
				$('#phydiv').show();
				$('#chediv').show();
				$('#botdiv').show();
				$('#zoodiv').show();
			}
			if(val == 'vocational')
			{
				$('#phydiv').show();
				$('#chediv').show();
				$('#biodiv').show();
				$('#fishdiv').show();
			}
			
		}	
	}
</script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $page_title;?>
      
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $page_title;?>></li>
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
              
                  
           
		
<?php// print_r($user_row);?>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="userform" id="userform" method="post" action="<?php echo base_url();?>admin/updateUser/<?php echo @$userid;?>/<?php echo @$user_row->role_id;?>" enctype="multipart/form-data">
              <div class="box-body">
			  <div class="box-header float-right  col-md-8">
                 <button type="submit" class="btn btn-primary">Save</button>
              </div>
			  <div class="box-header float-right  col-md-4">
                 <button type="button" onclick="history.go(-1);" class="btn btn-secondary"><< Back</button>
              </div>
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1"><i class="fa fa-user-circle-o"></i> Name</label>
					  <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo @$user_row->first_name;?>" placeholder="Enter Student Name">
					</div>
					<!--<div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-user-circle-o"></i> Last Name</label>
					  <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo @$user_row->last_name;?>" placeholder="Enter Last Name" >
					</div>-->
					
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1"><i class="fa fa-user-circle-o"></i>Username</label>
					  <input type="text" class="form-control" id="username" name="username" value="<?php echo @$user_row->username;?>" placeholder="Enter Username" <?php if($userid>0){?> readonly <?php } ?>>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-user-circle-o"></i>Password</label>
					  <input type="text" class="form-control" id="password" name="password" value="<?php echo @$user_row->password;?>" placeholder="Enter Password" >
					</div>
					
					
             
				    <div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-envelope"></i> Email</label>
					  <input type="email" class="form-control" id="email" name="email" value="<?php echo @$user_row->email;?>" placeholder=" Enter Email">
					</div>
				    <div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-phone"></i> Contact No.</label>
					  <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo @$user_row->contact_number;?>" placeholder="Enter Contact Number">
					</div>
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-universal-access" aria-hidden="true"></i> Role</label>
					  <select name="user_type" id="user_type" class="form-control" onchange="detailDiv();" <?php if($userid>0){?> disabled <?php } ?>>
					  <option value="">--Select Role--</option>
					  <?php foreach($roles as $role){?>
					  <option value="<?php echo $role->id;?>"<?php if(@$user_row->role_id==$role->id) echo "selected";?>><?php echo $role->role_name;?></option>
                          <?php if($role_id == 5){ ?>
					  <option value="<?php echo $role_id;?>"<?php echo "selected";?>>Parent</option>
					 <?php }
					  } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-intersex custom"></i> Gender</label>
					  <select name="gender" id="gender" class="form-control">
					  <option value="">--Select Gender--</option>
					  <option value="Male" <?php if(strtolower(@$user_row->gender)=='male') {echo "selected";} ?>>Male</option>
					  <option value="Female" <?php if(strtolower(@$user_row->gender)=='female')  {echo "selected";} ?>>Female</option>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> DOB</label>
					  <input type="text" class="form-control" id="dob" name="dob" value="<?php echo @$user_row->dob;?>" placeholder="Enter Date Of Birth">
					</div>
					<div class="form-group col-md-3">
					  <label for="user_unique_id"><i class="fa fa-user-circle-o"></i>Unique ID</label>
					  <input type="text" class="form-control" id="user_unique_id" name="user_unique_id" value="<?php echo @$user_row->user_unique_id;?>" placeholder="Enter Unique ID" >
					</div>
					<div class="form-group col-md-3">
					  <label for="application_no"><i class="fa fa-user-circle-o"></i>Student ID</label>
					  <input type="text" class="form-control" id="application_no" name="application_no" value="<?php echo @$user_row->application_no;?>" placeholder="Enter Student ID" >
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1"><i class="fa fa-image"></i> User Image</label>
					  <input type="file" class="form-control" id="user_image" name="user_image">
					  <?php if(@$user_row->user_image == '' || !file_exists('uploads/user_images/student/'.@$user_row->user_image)) $image = 'no_image.jpg'; else $image = @$user_row->user_image;?>
					  <span><img src="<?php echo base_url();?>uploads/user_images/student/<?php echo $image;?>" height="50px" width="50px"></span>
					   <input type="hidden" class="form-control" id="user_old_image" name="user_old_image" value="<?php echo @$user_row->user_image;?>">
					</div>
					
					
               </div>
			   <!--student other details start-->
			 
                <div id="studentDiv" <?php if($userid>0 && @$user_row->role_id ==1 || @$user_row->role_id == 6 ){?> <?php }else{ ?> style="display:none" <?php }?> >
				<div class="form-group col-md-12"><i class="fa fa-book"></i> Basic Info</div>
				<div class="row">
				<div class="form-group col-md-3">
					  <label for="aadhaar_no"><i class="fa fa-user-circle-o"></i> Aadhaar Number</label>
					  <input type="text" class="form-control" id="aadhaar_no" name="aadhaar_no" value="<?php echo @$user_row->aadhaar_no;?>" placeholder="Enter Aadhaar Number" />
					</div>
					<div class="form-group col-md-3">
					  <label for="nad_id"><i class="fa fa-user-circle-o"></i>NAD-ID</label>
					  <input type="text" class="form-control" id="nad_id" name="nad_id" value="<?php echo @$user_row->nad_id;?>" placeholder="Enter NAD-ID">
					</div>
					<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-user-circle-o"></i>Campus</label>
						 <select name="campus_id" id="campus_id" class="form-control" onchange="getDegree();">
							  <option value="">--Select Campus--</option>
							 <?php foreach($campuses as $campus){?>
							  <option value="<?php echo $campus->id;?>" <?php if(@$user_row->campus_id == $campus->id) echo "selected";?>><?php echo $campus->campus_name;?></option>
							  <?php }?>
						  </select>
						</div>
						<div class="form-group col-md-3">
						  <label for="occupation"><i class="fa fa-tasks"></i>Degree</label>
						   <select name="degree_id" id="degree_id" class="form-control"  onchange="getDisciplinebyDegree();">
							  <option value="">--Select Degree--</option>
							 <?php foreach($degrees as $degree){?>
							  <option value="<?php echo $degree->id;?>" <?php if(@$user_row->degree_id == $degree->id) echo "selected";?>><?php echo $degree->degree_name;?></option>
							  <?php }?>
							 
						  </select>
						</div>
						<div class="form-group col-md-3">
						  <label for="occupation"><i class="fa fa-tasks"></i>Discipline</label>
						   <select name="discipline_id" id="discipline_id" class="form-control">
							  <option value="">--Select Discipline--</option>
							 <?php foreach($disciplines as $discipline){?>
							  <option value="<?php echo $discipline->id;?>" <?php if(@$user_row->discipline_id == $discipline->id) echo "selected";?>><?php echo $discipline->discipline_name;?></option>
							  <?php }?>
							 
						  </select>
						</div>
						<div class="form-group col-md-3">
					  <label for="faculty"><i class="fa fa-user-circle-o"></i>Faculty</label>
					  <input type="text" class="form-control" id="faculty" name="faculty" value="<?php echo @$user_row->faculty;?>" placeholder="Enter Faculty" / >
					</div>
						<div class="form-group col-md-3">
						  <label for="parent"><i class="fa fa-user-circle-o"></i>Batch</label>
						  <select name="batch_id" id="batch_id" class="form-control">
							  <option value="">--Select Batch--</option>
							  <?php foreach($batches as $batch){?>
							  <option value="<?php echo $batch->id;?>" <?php if(@$user_row->batch_id == $batch->id) echo "selected";?>><?php echo $batch->batch_name;?></option>
							  <?php }?>
						  </select>
						 
						</div>
                    <div class="form-group col-md-3">
                        <label for="father_contact">Section</label>
                        <select name="section_id" id="section_id" class="form-control">
                            <option value="">--Select Section--</option>
                            <?php foreach($section as $sec_res){?>
                                <option value="<?php echo $sec_res->id;?>" <?php if(@$user_row->section_id == $sec_res->id) echo "selected";?>><?php echo $sec_res->section_name;?></option>
                            <?php }?>
                        </select>
                    </div>
						<div class="form-group col-md-3">
						  <label for="father_contact">Type</label>
						  <select name="course_type" id="course_type" class="form-control">
							  <option value="">--Select Type--</option>
							  <option value="1" <?php if(@$user_row->course_type == "1") echo "selected";?>>Full Time</option>
							  <option value="2" <?php if(@$user_row->course_type == "2") echo "selected";?>>Part Time</option>
						  </select>
						</div>
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-intersex custom"></i> Blood Group</label>
					  <select name="bloodgroup" id="bloodgroup" class="form-control">
					  <option value="">--Select Blood Group--</option>
					  <option value="A" <?php if(@$user_row->blood_group == "A") echo "selected";?>>A</option>
					  <option value="A+" <?php if(@$user_row->blood_group == "A+") echo "selected";?>>A+</option>
					  <option value="AB-" <?php if(@$user_row->blood_group == "AB-") echo "selected";?>>AB-</option>
					  <option value="B+" <?php if(@$user_row->blood_group == "B+") echo "selected";?>>B+</option>
					  <option value="B-" <?php if(@$user_row->blood_group == "B-") echo "selected";?>>B-</option>
					  <option value="AB+" <?php if(@$user_row->blood_group == "AB+") echo "selected";?>>AB+</option>
					  </select>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-intersex custom"></i> Mother Tongue</label>
					  <select name="mothertongue" id="mothertongue" class="form-control">
					  <option value="">--Select Mother Tongue--</option>
					  <option value="English" <?php if(@$user_row->mother_tongue == "English") echo "selected";?>>English</option>
					  <option value="Tamil" <?php if(@$user_row->mother_tongue == "Tamil") echo "selected";?>>Tamil</option>
					  <option value="Telugu" <?php if(@$user_row->mother_tongue == "Telugu") echo "selected";?>>Telugu</option>
					  <option value="Malayalam" <?php if(@$user_row->mother_tongue == "Malayalam") echo "selected";?>>Malayalam</option>
					  <option value="Hindi" <?php if(@$user_row->mother_tongue == "Hindi") echo "selected";?>>Hindi</option>
					  <option value="Kannada" <?php if(@$user_row->mother_tongue == "Kannada") echo "selected";?>>Kannada</option>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> Day Scholar/Hosteller</label>
					   <select name="residenttype" id="residenttype" class="form-control" >
					  <option value="">--Select Resident Type--</option>
					  
					  <option value="Day Scholar" <?php if(@$user_row->resident_type == "Day Scholar") echo "selected";?>>Day Scholar</option>
					  <option value="Hosteller" <?php if(@$user_row->resident_type == "Hosteller") echo "selected";?>>Hosteller</option>
					 
					 
					  </select>
					</div>
					<div class="form-group col-md-3">
						  <label for="place_of_birth"><i class="fa fa-map-pin"></i>Place of Birth</label>
						  <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" placeholder="Enter Place of Birth" value="<?php echo @$user_row->place_of_birth; ?>">
						 
						</div>
					
						<div class="form-group col-md-3">
						  <label for="nationality"><i class="fa fa-flag"></i> Nationality</label>
						   <select name="nationality" id="nationality" class="form-control">
						      <option value="">--Select Nationality--</option>
							  <option value="Indian"  <?php if(@$user_row->nationality=="Indian"){echo "selected";}?>>Indian</option>
							  <option value="Non-Indian"  <?php if(@$user_row->nationality=="Non-Indian"){echo "selected";}?>>Non-Indian</option>
							
						   </select> 
						</div>
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-venus custom"></i> Religion</label>
						   <select name="religion" id="religion" class="form-control">
						      <option value="">--Select Religion--</option>
							   <option value="Hindu" <?php if(@$user_row->religion=="Hindu"){echo "selected";}?>>Hindu</option>
							  <option value="Muslim" <?php if(@$user_row->religion=="Muslim"){echo "selected";}?>>Muslim</option>
							  <option value="Christian" <?php if(@$user_row->religion=="Christian"){echo "selected";}?>>Christian</option>
							  <option value="Sikhism" <?php if(@$user_row->religion=="Sikhism"){echo "selected";}?>>Sikhism </option>
							  <option value="Jainism" <?php if(@$user_row->religion=="Jainism"){echo "selected";}?>>Jainism</option>
							  <option value="Buddhism" <?php if(@$user_row->religion=="Buddhism"){echo "selected";}?>>Buddhism</option>
							  <option value="Others" <?php if(@$user_row->religion=="Others"){echo "selected";}?>>Others</option>
						   </select> 
						</div>
						<div class="form-group col-md-3">
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> Community</label>
					   <!--<select name="community" id="community" class="form-control" onchange="getCaste();">
					  <option value="">--Select Community--</option>
					  <?php foreach($community as $rescom){?>
					  <option value="<?php echo $rescom->name;?>" <?php if(@$user_row->community == $rescom->name) echo "selected";?>><?php echo $rescom->name;?></option>
					 
					  <?php } ?>
					  </select>-->
                            <input type="text" class="form-control" id="community" name="community" placeholder="Enter community" value="<?php echo @$user_row->community; ?>">
					</div>
					<div class="form-group col-md-3">
					  <label for="caste"><i class="fa fa-birthday-cake"></i> Caste</label>
					  <!--<select name="caste" id="caste" class="form-control" >
					  <option value="">--Select Caste--</option>
					   <?php foreach($caste as $rescom){?>
					  <option value="<?php echo $rescom->name;?>" <?php if(@$user_row->caste == $rescom->name) echo "selected";?>><?php echo $rescom->name;?></option>
					 
					  <?php } ?>
					  </select>-->
                        <input type="text" class="form-control" id="caste" name="caste" placeholder="Enter caste" value="<?php echo @$user_row->caste; ?>">
					</div>
					
					
				
						
				   </div>
				
				
				
				
				     <div class="row">
					 <div class="form-group col-md-12"><i class="fa fa-book"></i> Other Details</div>
						
						
						
						
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Country</label>
						   <select name="country_id" id="country_id" class="form-control" onchange="getState('state_id');">
						      <option value="">--Select Country--</option>
							  <?php foreach($countries as $country) { ?>
							  <option value="<?php echo $country->id;?>" <?php if(@$user_row->country_id == $country->id){echo "selected";}?>><?php echo $country->country_name;?></option>
							
							  <?php } ?>
						   </select> 
						</div>
										   
						<div class="form-group col-md-3">
						  <label for="state"><i class="fa fa-flag"></i> State</label>
						   <select name="state_id" id="state_id" class="form-control">
						      <option value="">--Select State--</option>
							</select> 
						</div>
						
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> City</label>
						   <select name="city_id" id="city_id" class="form-control" >
						      <option value="">--Select City--</option>
							  <?php foreach($city as $cities) { ?>
							  <option value="<?php echo $cities->city_id;?>" <?php if(@$user_row->city_id == $cities->city_id){echo "selected";}?>><?php echo $cities->city;?></option>
							
							  <?php } ?>
						   </select> 
						</div>
						<div class="form-group col-md-3">
						  <label for="district"><i class="fa fa-map-pin"></i>District</label>
						  <input type="text" class="form-control" id="district"  name="district" placeholder="Enter District" value="<?php echo @$user_row->district;?>">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="zip"><i class="fa fa-map-pin"></i> Zip Code</label>
						  <input type="text" class="form-control" id="zip_code" maxlength="6" name="zip_code" placeholder="Enter Zip Code" value="<?php echo @$user_row->zip_code?>">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Address Line1</label>
						  <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="<?php echo @$user_row->address?>">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Address Line2</label>
						  <input type="text" class="form-control" id="address2" name="address2" placeholder="Enter Address" value="<?php echo @$user_row->address2?>">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Address Line3</label>
						  <input type="text" class="form-control" id="address3" name="address3" placeholder="Enter Address" value="<?php echo @$user_row->address3?>">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Address Line4</label>
						  <input type="text" class="form-control" id="address4" name="address4" placeholder="Enter Address" value="<?php echo @$user_row->address4?>">
						 
						</div>
						
				  
						<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Month of Passing</label>
					     <select name="monthpassing" id="monthpassing" class="form-control">
						      <option value="">--Select Month--</option>
							  <option value="January" <?php if(@$user_row->month_passing == "January"){echo "selected";}?>>January</option>
							  <option value="February" <?php if(@$user_row->month_passing == "February"){echo "selected";}?>>February</option>
							  <option value="March" <?php if(@$user_row->month_passing == "March"){echo "selected";}?>>March</option>
							  <option value="April" <?php if(@$user_row->month_passing == "April"){echo "selected";}?>>April</option>
							  <option value="May" <?php if(@$user_row->month_passing == "May"){echo "selected";}?>>May</option>
							  <option value="June"<?php if(@$user_row->month_passing == "June"){echo "selected";}?>>June</option>
							  <option value="July" <?php if(@$user_row->month_passing == "July"){echo "selected";}?>>July</option>
							  <option value="August" <?php if(@$user_row->month_passing == "August"){echo "selected";}?>>August</option>
							  <option value="September" <?php if(@$user_row->month_passing == "September"){echo "selected";}?>>September</option>
							  <option value="October" <?php if(@$user_row->month_passing == "October"){echo "selected";}?>>October</option>
							  <option value="November" <?php if(@$user_row->month_passing == "November"){echo "selected";}?>>November</option>
							  <option value="December" <?php if(@$user_row->month_passing == "December"){echo "selected";}?>>December</option>
							  
							</select>
					</div>
						
						<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Year of Passing</label>
					     <select name="yearpassing" id="yearpassing" class="form-control">
						      <option value="">--Select Year--</option>
							  <?php for($i=date('Y')-10;$i<=date('Y');$i++){?>
							
							  <option value="<?php echo $i;?>" <?php if(@$user_row->year_passing == $i){echo "selected";}?>><?php echo $i;?></option>
							
							  <?php } ?>
							</select>
					</div>
						
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Medium of Instruction</label>
						   <select name="medium_instr" id="medium_instr" class="form-control" >
						      <option value="">--Select Medium of Instruction--</option>
							  
							  <option value="English" <?php if(@$user_row->medium_instr == "English"){echo "selected";}?>>English</option>
							  <option value="Tamil" <?php if(@$user_row->medium_instr == "Tamil"){echo "selected";}?>>Tamil</option>
							  <option value="Telugu" <?php if(@$user_row->medium_instr == "Telugu"){echo "selected";}?>>Telugu</option>
							  <option value="Hindi" <?php if(@$user_row->medium_instr == "Hindi"){echo "selected";}?>>Hindi</option>
							
							  
						   </select> 
						</div>
										   
						<div class="form-group col-md-3">
						  <label for="state"><i class="fa fa-flag"></i> Mode of Admission</label>
						   <select name="modeofadmission" id="modeofadmission" class="form-control">
						      <option value="">--Select Mode of Admission--</option>
						      <option value="N/A" <?php if(@$user_row->mode_of_admission == "N/A"){echo "selected";}?>>N/A</option>
						      <option value="General" <?php if(@$user_row->mode_of_admission == "General"){echo "selected";}?>>General</option>
						      <option value="Reserved" <?php if(@$user_row->mode_of_admission == "Reserved"){echo "selected";}?>>Reserved</option>
							</select> 
						</div>
						
						<div class="form-group col-md-3">
					  <label for="reserved"><i class="fa fa-bell-o"></i>Fees Category</label>
						  <input type="text" class="form-control" id="reserved" name="reserved" placeholder="Fees Category" value="<?php echo @$user_row->reserved?>">
					</div>
						
						<div class="form-group col-md-3">
					  <label for="quota"><i class="fa fa-bell-o"></i> Scholarship</label>
					     <input type="text" class="form-control" id="quota" name="quota" placeholder="Scholarship" value="<?php echo @$user_row->quota?>">
					</div>
					<div class="form-group col-md-3">
					  <label for="quota"><i class="fa fa-bell-o"></i>Previous Exam/Degree Passed</label>
					     <input type="text" class="form-control" id="prev_exam_degree" name="prev_exam_degree" placeholder="Previous Exam/Degree Passed" value="<?php echo @$user_row->prev_exam_degree?>">
					</div>
					<div class="form-group col-md-3">
					  <label for="quota"><i class="fa fa-bell-o"></i>Previous Exam-Group / Discipline</label>
					     <input type="text" class="form-control" id="prev_exam_discipline" name="prev_exam_discipline" placeholder="Previous Exam-Group / Discipline" value="<?php echo @$user_row->prev_exam_discipline?>">
					</div>
						 <div class="form-group col-md-3">
					  <label for="last_school"><i class="fa fa-address-book"></i>School / Institution last studied</label>
					    <input type="text" class="form-control" id="last_school" name="last_school" placeholder="School / Institution last studied" value="<?php echo @$user_row->last_school;?>">
					</div>
					 <div class="form-group col-md-3">
					  <label for="last_std"><i class="fa fa-file-text-o"></i>Board / University last studied</label>
					    <input type="text" class="form-control" id="last_std" name="last_std" placeholder="Board / University last studied" value="<?php echo @$user_row->last_std;?>">
					</div>
					 <div class="form-group col-md-3">
					  <label for="marks_obtained"><i class="fa fa-percent"></i> Marks Obtained</label>
					    <input type="text" class="form-control" id="marks_obtained" name="marks_obtained" placeholder="Enter %Marks" value="<?php echo @$user_row->marks_obtained;?>">
					</div>
					<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Student Status</label>
					     <select name="student_status" id="student_status" class="form-control">
						      <option value="">--Select Student Status--</option>
							  <option value="Active" <?php if(@$user_row->student_status == "Active"){echo "selected";}?>>Active</option>
							<option value="Dismissed" <?php if(@$user_row->student_status == "Dismissed"){echo "selected";}?>>Dismissed</option>
							<option value="Dismissed" <?php if(@$user_row->student_status == "Suspended"){echo "selected";}?>>Suspended</option>
							  <option value="With held" <?php if(@$user_row->student_status == "With held"){echo "selected";}?>>With held</option>
							  <option value="Dis-continued" <?php if(@$user_row->student_status == "Dis-continued"){echo "selected";}?>>Dis-continued</option>
							</select>
					</div>
					
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i> Date Of Admission</label>
					    <input type="text" class="form-control" id="doa" name="doa" placeholder="Enter Date Of Admission" value="<?php echo @$user_row->doa;?>">
					</div>
					
					<div class="form-group col-md-3">
					  <label for="roll"><i class="fa fa-ship"></i>Date Of Passing</label>
					    <input type="text" class="form-control" id="dop" name="dop" placeholder="Enter Date Of Passing" value="<?php echo @$user_row->dop;?>">
					</div>
				
				 
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Ward Counsellor</label>
					    <input type="text" class="form-control" id="ward_counsellor" name="ward_counsellor" placeholder="Enter Ward Counsellor" value="<?php echo @$user_row->ward_counsellor;?>">
					</div>
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Title of Thesis</label>
						   <textarea name="title_of_thesis" id="title_of_thesis" placeholder="Title of Thesis" class="form-control"><?php echo @$user_row->title_of_thesis;?></textarea> 
						</div>
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Remarks1</label>
						   <textarea name="remark" id="remark" placeholder="Remarks1" class="form-control"><?php echo @$user_row->remark;?></textarea> 
						</div>
										   
						<div class="form-group col-md-3">
						  <label for="remark2"><i class="fa fa-flag"></i> Remarks2</label>
						   <textarea name="remark2" id="remark2" placeholder="Remarks2" class="form-control"><?php echo @$user_row->remark2;?></textarea> 
						</div>
						<div class="form-group col-md-3">
						  <label for="remark3"><i class="fa fa-flag"></i> Remarks3</label>
						   <textarea name="remark3" id="remark3" placeholder="Remarks3" class="form-control"><?php echo @$user_row->remark3;?></textarea> 
						</div>
						<div class="form-group col-md-3">
						  <label for="remark4"><i class="fa fa-flag"></i> Remarks4</label>
						   <textarea name="remark4" id="remark4" placeholder="Remarks4" class="form-control"><?php echo @$user_row->remark4;?></textarea> 
						</div>
						<div class="form-group col-md-3">
						  <label for="remark5"><i class="fa fa-flag"></i> Remarks5</label>
						   <textarea name="remark5" id="remark5" placeholder="Remarks5" class="form-control"><?php echo @$user_row->remark5;?></textarea> 
						</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Extra curricular activities</label>
					    <textarea class="form-control" id="extra_activites" name="extra_activites" placeholder="Enter Date Of Admission"><?php echo @$user_row->extra_activites;?></textarea>
					</div>
					
					
				  </div>
				  
				  <div><i class="fa fa-user"></i> Parent Info</div>
				
					<div class="row">
						<div class="form-group col-md-3">
						  <label for="parent_name"><i class="fa fa-user-circle-o"></i> Father Name</label>
						  <input type="text" class="form-control" id="parent_name" name="parent_name" value="<?php echo @$user_row->parent_name;?>" placeholder="Enter Parent Name">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="mother_name"><i class="fa fa-female"></i> Mother Name</label>
						  <input type="text" class="form-control" id="mother_name" name="mother_name" value="<?php echo @$user_row->mother_name;?>" placeholder="Enter Mother Name">
						</div>
						<div class="form-group col-md-3">
						  <label for="father_contact"><i class="fa fa-phone"></i>Parent Contact Number</label>
						  <input type="text" class="form-control" id="father_contact" name="father_contact" value="<?php echo @$user_row->father_contact;?>" placeholder="Enter Parent Contact Number" />
						</div>
						<div class="form-group col-md-3">
						  <label for="father_email"><i class="fa fa-envelope"></i>Parent e-mail</label>
						  <input type="text" class="form-control" id="father_email" name="father_email" value="<?php echo @$user_row->father_email;?>" placeholder="Enter Parent e-mail">
						</div>
						<div class="form-group col-md-3">
						  <label for="occupation"><i class="fa fa-tasks"></i> Partent Occupation</label>
						     <input type="text" class="form-control" id="occupation" name="occupation" value="<?php echo @$user_row->occupation;?>" placeholder="Enter Partent Occupation">
						</div>
						<div class="form-group col-md-3">
					  <label for="annualincome"><i class="fa fa-birthday-cake"></i>Annual Family Income</label>
					  <input type="text" class="form-control" id="annualincome" name="annualincome" placeholder="Enter Annual Family Income" value="<?php echo @$user_row->annual_income?>">
					</div>
						
						<div class="form-group col-md-3">
						  <label for="guardian_name"><i class="fa fa-female"></i> Guardian/Spouse Name</label>
						  <input type="text" class="form-control" id="guardian_name" name="guardian_name" placeholder="Enter Guardian/Spouse Name" value="<?php echo @$user_row->guardian_name?>">
						</div>
						<div class="form-group col-md-3">
						  <label for="alternate_contact"><i class="fa fa-phone"></i> Guardian/Spouse Contact Number</label>
						  <input type="text" class="form-control" id="alternate_contact" name="alternate_contact" value="<?php echo @$user_row->alternate_contact;?>" placeholder="Guardian/Spouse Contact Number" />
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="spouse_email"><i class="fa fa-envelope"></i>Guardian/Spouse e-mail</label>
						  <input type="text" class="form-control" id="spouse_email" name="spouse_email" value="<?php echo @$user_row->spouse_email;?>" placeholder="Guardian/Spouse Contact Number" />
						 
						</div>
						

						
						
						
				   </div>
				  
				   <div class="row">
				<div class="form-group col-md-12"><i class="fa fa-user"></i> Parent Login Info</div>
				</div>
				 <div class="row">
				   <div class="form-group col-md-3">
					  <label for="parent_username"><i class="fa fa-user-circle-o"></i>Parent Username</label>
					    <input type="text" class="form-control" id="parent_username" name="parent_username" placeholder="Enter Parent Username" <?php echo @$user_row->parent_name;?>>
					</div>
					 <div class="form-group col-md-3">
					  <label for="parent_password"><i class="fa fa-lock"></i>Parent Password</label>
					    <input type="password" class="form-control" id="parent_password" name="parent_password" placeholder="Enter Parent Password" <?php echo @$user_row->father_password;?>>
					</div>
					 
				  </div>
				   
               </div>
			    <div id="otherRoleDiv" style="display:none">
				<div><i class="fa fa-book"></i>Other Information</div>
					<div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1"> Address Line1</label>
						  <input type="text" class="form-control" id="address_line1" name="address_line1" placeholder="Address Line1">
						  
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line2"> Address Line2</label>
						  <input type="text" class="form-control" id="address_line2" name="address_line2" placeholder="Address Line2">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3"> Address Line3</label>
						  <input type="text" class="form-control" id="address_line3" name="address_line3" placeholder="Address Line3">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4"> Address Line4</label>
						  <input type="text" class="form-control" id="address_line4" name="address_line4" placeholder="Address Line4">
						</div>
				   </div>
				   <div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1"> Landline No</label>
						  <input type="text" class="form-control" id="landline_number" name="landline_number" placeholder="Landline No">
						  
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line2">Employment Id</label>
						  <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="Employment Id">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3">Qualification</label>
						  <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Qualification">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4">Date of Join</label>
						  <input type="text" class="form-control" id="date_of_joining" name="date_of_joining" placeholder="Date of Join">
						</div>
				   </div>
				   
				    <div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1">Designation</label>
						    <select name="designation" id="designation" class="form-control" >
						      <option value="">--Select Designation--</option>
							  <option value="1">Professor</option>
							  <option value="2">Assistant Professor</option>
							  <option value="3">Associate Professor</option>
							  <option value="4">Director(Physical Education)</option>
							  <option value="5">Asst. Director(Physical Education)</option>
							  <option value="6">Deputy Director(Physical Education)</option>
							  <option value="7">Assistant Librarian</option>
						    </select>
						  
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line2">Department</label>
						  <input type="text" class="form-control" id="department" name="department" placeholder="Department">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3">Campus<span style="color:red;font-weight: bold;">*</span></label>
						  <select name="campus" id="campus" class="form-control">
						      <option value="">--Select Campus--</option>
							  <?php foreach($campuses as $campus){?>
							   <option value="<?php echo $campus->id;?>"><?php echo $campus->campus_name;?></option>
							  <?php }?>
						    </select>
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4">Discipline<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="discipline_id_1" id="discipline_id_1" class="form-control">
						    <option value="">--Select Discipline--</option>
						 <?php foreach($disciplines as $discipline){?>
					      <option value="<?php echo $discipline->id;?>"><?php echo $discipline->discipline_name;?></option>
					     <?php } ?>
					  </select>
						</div>
				   </div>
               </div>
			    
			     <!--teacher other details end-->
				 
				    <!--subadmin other details start-->
              
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save</button>
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
	
	$(document).ready(function() {
		$("#dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		$("#doa").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		$("#dop").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		$("#date_of_joining").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		<?php if(@$user_row->community != '')?>
		{
			getCaste(); 
		}
		<?php if(@$user_row->country_id != '')?>
			getState('state_id',"<?php echo @$user_row->state_id;?>");
		
		<?php if(@$user_row->group != '')?>
			setgroup(<?php echo @$user_row->group;?>);	
		<?php if(@$user_row->discipline_id != '')?>
			getDisciplinebyDegree();
	});
	
	
	
	
	function getDisciplinebyDegree()
	{
		var degree_id =$('#degree_id').val();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDisciplineByDegreeId',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Discipline--</option>';
			$('#discipline_id').empty();
			$("#discipline_id").append(option_brand+data);
				<?php if(@$user_row->discipline_id != '') {?>
				$('#discipline_id').val(<?php echo @$user_row->discipline_id;?>);
			<?php } ?>
			 }
		});
	}
   
	function getState(id,state_id)
	{
		var country_id =$('#country_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>admin/getState',
			data: {'country_id':country_id},
			success: function(data){
			var  option_brand = '<option value="">--Select State--</option>';
			$('#'+id).empty();
			$("#"+id).append(option_brand+data);
			$("#"+id).val(state_id);
			 }
		});
	}
	

	
	
   $("#userform").validate({
		rules: {
			username: "required",
			password: "required",
			first_name: "required",
		
			/*unique_id:"required",
			caste:"required",*/
			user_type:"required",
			pincode: {
				required:false,
				digits: true,
				minlength:6,
				maxlength:6
			},
			contact_number: {
				required:false,
				digits: true,
				minlength:10,
				maxlength:10,
				notEqualTo: ['#father_contact', '#alternate_contact']
			},
			father_contact: {
				required:false,
				digits: true,
				minlength:10,
				maxlength:10,
				notEqualTo: ['#contact_number', '#alternate_contact']
			},
			alternate_contact: {
				required:false,
				digits: true,
				minlength:10,
				maxlength:10,
				notEqualTo: ['#contact_number', '#father_contact']
			},
			
			email:{
				required:false,
				email:true
			},
			father_email:{
				required:false,
				email:true
			},
			zip_code:{
				required:false,
				digits: true,
				minlength:6,
				maxlength:6
			},
			
			gender:"required",
			
			/*dob:"required",
			community:"required",
			caste:"required",
			batch_id:"required",
			campus_id:"required",
			degree_id:"required",
			course_type:"required",
			parent_name:"required",
			mother_name:"required",
			occupation:"required",
			father_contact:"required",
			father_email:"required",
			alternate_contact:"required",
			religion:"required",
			nationality:"required",
			address:"required",
			country_id:"required",
			state_id:"required",
			
			parent_username:"required",
			parent_password:"required",
			sales_email:{
				required:true,
				email:true
			},
			address_name: 'required',
		
			imei_number: {
				required:true,
				digits: true,
				minlength:15,
				maxlength:15
			},
			//driver_image: 'required',
			
			member_address: 'required'*/
			
		},
		messages: {
			username: "User Name  Is Required",
			password:"Password Is Required",
			first_name: "First Name  Is Required",
			
			/*community:"Community Is Required",
			caste:"Caste Is Required",*/
			user_type:"Select Role Is Required",
			
			//user_image  	 : "Select an image to upload",
			
			pincode:{ 
					required: "Pincode Number is required",
					minlength: "Enter valid 6 digit Phone Number",
					maxlength: "Enter valid 6 digit Phone Number",
					digits : "Pincode Number Accept only Numbers"
			},
			contact_number:{ 
					/*required: "Contact Number is required",*/
					minlength: "Enter valid 10 digit Phone Number",
					maxlength: "Enter valid 10 digit Phone Number",
					digits : "Contact Number Accept only Numbers",
					notEqualTo: "Not equal to Father Contact/Alternate Contact"
			},
			father_contact:{ 
					/*required: "Contact Number is required",*/
					minlength: "Enter valid 10 digit Phone Number",
					maxlength: "Enter valid 10 digit Phone Number",
					digits : "Contact Number Accept only Numbers",
					notEqualTo: "Not equal to Contact/Alternate Contact"
			},
			alternate_contact:{ 
					/*required: "Contact Number is required",*/
					minlength: "Enter valid 10 digit Phone Number",
					maxlength: "Enter valid 10 digit Phone Number",
					digits : "Contact Number Accept only Numbers",
					notEqualTo: "Not equal to Contact/Father Contact"
			},
			email:{
				/*required:"Please enter  email.",*/
				email:"Please enter valid email."
			},
			father_email:{
				/*required:"Please enter  email.",*/
				email:"Please enter valid email."
			},
			zip_code:{ 
					/*required:"Zipcode is required.",*/
					minlength: "Enter valid 6 digit Number",
					maxlength: "Enter valid 6 digit Number",
					digits : "Pincode Number Accept only Numbers"
			},
			
			unique_id: "Student Unique Id Required",
			gender: "Gender Is Required",
			/*dob: "DOB Is Required",
			batch_id: "Select Batch Is Required",
			campus_id:"Campus required",
			degree_id:"Degree required",
			course_type:"Type required",
			
			parent_name:"Parent Name required",
			mother_name:"Mother Name required",
			occupation:"Occupation required",
			father_contact:"Father Contact required",
			father_email:"Father Contact Email",
			alternate_contact:"Alternate Contact required",
			religion:"Religion required",
			nationality:"Nationality required",
			address:"Address required",
			country_id:"Country required",
			state_id:"State required",
			
			parent_username:"Parent Username required",
			parent_password:"Parent Password required",
			sales_email:{
				required:"Please enter sales email.",
				email:"Please enter valid sales email."
			},
		 address_name   : "Address is required",
			imei_number:{ 
					required: "IMEI Number is required",
					minlength: "Enter valid 15 digit IMEI Number",
					maxlength: "Enter valid 15 digit IMEI Number",
					digits : "IMEI Number Accept only Numbers"
			},
		   // driver_image  	 : "Select an image to upload",
			member_address   : "Address is required"*/
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	
	
	
	function getCaste()
	{
		
		var community =$('#community').val();
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>admin/getCaste',
			data: {'community':community},
			success: function(data){
			var  option_brand = '<option value="">--Select Caste--</option>';
			$('#caste').empty();
			$("#caste").append(option_brand+data);
			
			
			document.getElementById("caste").value = "<?php echo @$user_row->caste;?>";
			 }
		});
	}
	function detailDiv()
	{
		var usertype =$('#user_type').val();
		if(usertype=='1' || usertype=='6')
		{   
			$('#studentDiv').show();
			$('#otherRoleDiv').hide();
		}else{
			$('#studentDiv').hide();
			$('#otherRoleDiv').show();
		}
	}
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 