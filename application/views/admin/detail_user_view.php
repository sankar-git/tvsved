<?php
//print_r($user_row); exit;
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
		
		<?php if($user_education[0]['group'] != '')?>
			setgroup('<?=$user_education[0]['group']?>');	
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
            <form role="form" name="userform" id="userform" method="post" action="<?php echo base_url();?>admin/updateUser/<?php echo $userid;?>" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1"><i class="fa fa-user-circle-o"></i> First Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user_row->first_name;?>" placeholder="Enter First Name">
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-user-circle-o"></i> Last Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user_row->last_name;?>" placeholder="Enter Last Name" >
					</div>
					
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1"><i class="fa fa-user-circle-o"></i>Username<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="username" name="username" value="<?php echo $user_row->username;?>" placeholder="Enter Username" readonly>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-user-circle-o"></i>Password<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="password" name="password" value="<?php echo $user_row->password;?>" placeholder="Enter Password" readonly>
					</div>
					
					
               </div>
			   
			    <div class="row">
				    <div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-envelope"></i> Email<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_row->email;?>" placeholder=" Enter Email">
					</div>
				    <div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-phone"></i> Contact No.<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $user_row->contact_number;?>" placeholder="Enter Contact Number">
					</div>
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-universal-access" aria-hidden="true"></i> Role<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="user_type" id="user_type" class="form-control" disabled>
					  <option value="">--Select Role--</option>
					  <?php foreach($roles as $role){?>
					  <option value="<?php echo $role->id;?>"<?php if($user_row->urole_id==$role->id) echo "selected";?>><?php echo $role->role_name;?></option>
					 
					  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-intersex custom"></i> Gender<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="gender" id="gender" class="form-control">
					  <option value="">--Select Gender--</option>
					  <option value="male" <?php if($user_row->gender=='male') {echo "selected";} ?>>Male</option>
					  <option value="female" <?php if($user_row->gender=='female')  {echo "selected";} ?>>Female</option>
					  </select>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1"><i class="fa fa-image"></i> User Image</label>
					  <input type="file" class="form-control" id="user_image" name="user_image">
					  <?php if($user_row->user_image == '') $image = 'no_image.jpg'; else $image = $user_row->user_image;?>
					  <span><img src="<?php echo base_url();?>uploads/user_images/student/<?php echo $image;?>" height="50px" width="50px"></span>
					   <input type="hidden" class="form-control" id="user_old_image" name="user_old_image" value="<?php echo $user_row->user_image;?>">
					</div>
					
					
					<div class="form-group col-md-3">
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> DOB<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="dob" name="dob" value="<?php echo $user_row->dob;?>" placeholder="Enter Date Of Birth">
					</div>
					
					<div class="form-group col-md-3">&nbsp;</div>
               </div>
			   <!--student other details start-->
			 
                <div id="studentDiv">
				<div class="form-group col-md-12"><i class="fa fa-book"></i> Basic Info</div>
				<div class="row">
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-intersex custom"></i> Blood Group<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="bloodgroup" id="bloodgroup" class="form-control">
					  <option value="">--Select Blood Group--</option>
					  <option value="A" <?php if($user_row->blood_group == "A") echo "selected";?>>A</option>
					  <option value="A+" <?php if($user_row->blood_group == "A+") echo "selected";?>>A+</option>
					  <option value="AB-" <?php if($user_row->blood_group == "AB-") echo "selected";?>>AB-</option>
					  <option value="B+" <?php if($user_row->blood_group == "B+") echo "selected";?>>B+</option>
					  <option value="B-" <?php if($user_row->blood_group == "B-") echo "selected";?>>B-</option>
					  <option value="AB+" <?php if($user_row->blood_group == "AB+") echo "selected";?>>AB+</option>
					  </select>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-intersex custom"></i> Mother Tongue<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="mothertongue" id="mothertongue" class="form-control">
					  <option value="">--Select Mother Tongue--</option>
					  <option value="English" <?php if($user_row->mother_tongue == "English") echo "selected";?>>English</option>
					  <option value="Tamil" <?php if($user_row->mother_tongue == "Tamil") echo "selected";?>>Tamil</option>
					  <option value="Telugu" <?php if($user_row->mother_tongue == "Telugu") echo "selected";?>>Telugu</option>
					  <option value="Malayalam" <?php if($user_row->mother_tongue == "Malayalam") echo "selected";?>>Malayalam</option>
					  <option value="Hindi" <?php if($user_row->mother_tongue == "Hindi") echo "selected";?>>Hindi</option>
					  <option value="Kannada" <?php if($user_row->mother_tongue == "Kannada") echo "selected";?>>Kannada</option>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> Day Scholar/Hosteller<span style="color:red;font-weight: bold;">*</span></label>
					   <select name="residenttype" id="residenttype" class="form-control" >
					  <option value="">--Select Resident Type--</option>
					  
					  <option value="Day Scholar" <?php if($user_row->resident_type == "Day Scholar") echo "selected";?>>Day Scholar</option>
					  <option value="Hosteller" <?php if($user_row->resident_type == "Hosteller") echo "selected";?>>Hosteller</option>
					 
					 
					  </select>
					</div>
					<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-venus custom"></i> Religion<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="religion" id="religion" class="form-control">
						      <option value="">--Select Religion--</option>
							  <option value="1" <?php if($user_row->religion=="1"){echo "selected";}?>>Muslim</option>
							  <option value="2" <?php if($user_row->religion=="2"){echo "selected";}?>>Hindu</option>
							  <option value="3" <?php if($user_row->religion=="3"){echo "selected";}?>>Christian</option>
						   </select> 
						</div>
						<div class="form-group col-md-3">
						  <label for="nationality"><i class="fa fa-flag"></i> Nationality<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="nationality" id="nationality" class="form-control">
						      <option value="">--Select Nationality--</option>
							  <option value="1"  <?php if($user_row->nationality=="1"){echo "selected";}?>>Indian</option>
							  <option value="2"  <?php if($user_row->nationality=="2"){echo "selected";}?>>Non-Indian</option>
							
						   </select> 
						</div>
						<div class="form-group col-md-3">
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> Community<span style="color:red;font-weight: bold;">*</span></label>
					   <select name="community" id="community" class="form-control" onchange="getCaste();">
					  <option value="">--Select Community--</option>
					  <?php foreach($community as $rescom){?>
					  <option value="<?php echo $rescom->id;?>" <?php if($user_row->community == $rescom->id) echo "selected";?>><?php echo $rescom->name;?></option>
					 
					  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="caste"><i class="fa fa-birthday-cake"></i> Caste<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="caste" id="caste" class="form-control" >
					  <option value="">--Select Caste--</option>
					  </select>
					</div>
					
					
				</div>
				
				<div class="row">
						<div class="form-group col-md-3">
						  <label for="parent"><i class="fa fa-user-circle-o"></i>Batch<span style="color:red;font-weight: bold;">*</span></label>
						  <select name="batch_id" id="batch_id" class="form-control">
							  <option value="">--Select Batch--</option>
							  <?php foreach($batches as $batch){?>
							  <option value="<?php echo $batch->id;?>" <?php if($user_row->batch_id == $batch->id) echo "selected";?>><?php echo $batch->batch_name;?></option>
							  <?php }?>
						  </select>
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-female"></i>Campus<span style="color:red;font-weight: bold;">*</span></label>
						 <select name="campus_id" id="campus_id" class="form-control" onchange="getDegree();">
							  <option value="">--Select Campus--</option>
							 <?php foreach($campuses as $campus){?>
							  <option value="<?php echo $campus->id;?>" <?php if($user_row->campus_id == $campus->id) echo "selected";?>><?php echo $campus->campus_name;?></option>
							  <?php }?>
						  </select>
						</div>
						<div class="form-group col-md-3">
						  <label for="occupation"><i class="fa fa-tasks"></i>Degree<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="degree_id" id="degree_id" class="form-control">
							  <option value="">--Select Degree--</option>
							  <option value="A" <?php if($user_row->degree_id == "1") echo "selected";?>>A</option>
							  <option value="B" <?php if($user_row->degree_id == "2") echo "selected";?>>B</option>
							 
						  </select>
						</div>
						<div class="form-group col-md-3">
						  <label for="father_contact">Type<span style="color:red;font-weight: bold;">*</span></label>
						  <select name="course_type" id="course_type" class="form-control">
							  <option value="">--Select Type--</option>
							  <option value="1" <?php if($user_row->course_type == "1") echo "selected";?>>Full Time</option>
							  <option value="2" <?php if($user_row->course_type == "2") echo "selected";?>>Part Time</option>
						  </select>
						</div>
				   </div>
				
				
				
				
				     <div class="row">
					 <div class="form-group col-md-12"><i class="fa fa-book"></i> Permanent Address</div>
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Address<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="<?=$user_row->address?>">
						 
						</div>
						
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Street<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="street" name="street" placeholder="Enter Street" value="<?=$user_row->street?>">
						 
						</div>
						
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Country<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="country_id" id="country_id" class="form-control" onchange="getState('state_id');">
						      <option value="">--Select Country--</option>
							  <?php foreach($countries as $country) { ?>
							  <option value="<?php echo $country->id;?>" <?php if($user_row->country_id == $country->id){echo "selected";}?>><?php echo $country->country_name;?></option>
							
							  <?php } ?>
						   </select> 
						</div>
										   
						<div class="form-group col-md-3">
						  <label for="state"><i class="fa fa-flag"></i> State<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="state_id" id="state_id" class="form-control">
						      <option value="">--Select State--</option>
							</select> 
						</div>
						</div>
				   <div class="row">
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> City<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="city_id" id="city_id" class="form-control" >
						      <option value="">--Select City--</option>
							  <?php foreach($city as $cities) { ?>
							  <option value="<?php echo $cities->city_id;?>" <?php if($user_row->city_id == $cities->city_id){echo "selected";}?>><?php echo $cities->city;?></option>
							
							  <?php } ?>
						   </select> 
						</div>
						<div class="form-group col-md-3">
						  <label for="zip"><i class="fa fa-map-pin"></i> Zip Code<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="zip_code" maxlength="6" name="zip_code" placeholder="Enter Zip Code" value="<?=$user_row->zip_code?>">
						 
						</div>
						
						<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-female"></i> Guardian/Spouse Name<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="guardian_name" name="guardian_name" placeholder="Enter Guardian/Spouse Name" value="<?=$user_row->guardian_name?>">
						</div>
				   </div>
				   
				     <div class="row">
					  <div class="form-group col-md-12"><i class="fa fa-book"></i> Local Address</div>
					  
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Address<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address_local" name="address_local" placeholder="Enter Address" value="<?=$user_row->address_local?>">
						 
						</div>
						
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Street<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="street_local" name="street_local" placeholder="Enter Street" value="<?=$user_row->street_local?>">
						 
						</div>
						
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Country<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="country_id_local" id="country_id_local" class="form-control" onchange="getState('state_id_local');">
						      <option value="">--Select Country--</option>
							  <?php foreach($countries as $country) { ?>
							  <option value="<?php echo $country->id;?>" <?php if($user_row->country_id_local == $country->id){echo "selected";}?>><?php echo $country->country_name;?></option>
							
							  <?php } ?>
						   </select> 
						</div>
										   
						<div class="form-group col-md-3">
						  <label for="state"><i class="fa fa-flag"></i> State<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="state_id_local" id="state_id_local" class="form-control">
						      <option value="">--Select State--</option>
							</select> 
						</div>
						</div>
				   <div class="row">
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> City<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="city_id_local" id="city_id_local" class="form-control" >
						      <option value="">--Select City--</option>
							  <?php foreach($city as $cities) { ?>
							  <option value="<?php echo $cities->city_id;?>" <?php if($user_row->city_id_local == $cities->city_id){echo "selected";}?>><?php echo $cities->city;?></option>
							
							  <?php } ?>
						   </select> 
						</div>
						<div class="form-group col-md-3">
						  <label for="zip"><i class="fa fa-map-pin"></i> Zip Code<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="zip_code_local" maxlength="6" name="zip_code_local" placeholder="Enter Zip Code" value="<?=$user_row->zip_code_local?>">
						 
						</div>
						
						<div class="form-group col-md-3">
						  <label for="state"><i class="fa fa-flag"></i> Type of scholarship Received<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="scholarship" id="scholarship" class="form-control">
						      <option value="">--Select Type of scholarship Received--</option>
						      <option value="A"  <?php if($user_row->scholarship == "A"){echo "selected";}?>>A</option>
						      <option value="B"  <?php if($user_row->scholarship == "B"){echo "selected";}?>>B</option>
							</select> 
						</div>
						
						
				   </div>
				   
				 <div class="form-group col-md-12"><i class="fa fa-book"></i> Pre Academic Info</div>
				  <div class="row">
				   <div class="form-group col-md-3">
					  <label for="registration"><i class="fa fa-registered"></i> Registration</label>
					    <input type="text" class="form-control" id="registration" name="registration" placeholder="Enter Registration" value="<?php echo $user_row->registration;?>">
					</div>
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i> Class</label>
					    <input type="text" class="form-control" id="class_name" name="class_name" placeholder="Enter Class" value="<?php echo $user_row->class_name;?>">
					</div>
					<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Section</label>
					     <select name="section_id" id="section_id" class="form-control">
						      <option value="">--Select Section--</option>
							  <option value="A" <?php if($user_row->section_id == "A"){echo "selected";}?>>A</option>
							  <option value="B" <?php if($user_row->section_id == "B"){echo "selected";}?>>B</option>
							</select>
					</div>
					<div class="form-group col-md-3">
					  <label for="roll"><i class="fa fa-ship"></i>Roll</label>
					    <input type="text" class="form-control" id="roll" name="roll" placeholder="Enter Roll" value="<?php echo $user_row->roll;?>">
					</div>
				  </div>
				  
				  <div class="row">
						<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Month of Passing</label>
					     <select name="monthpassing" id="monthpassing" class="form-control">
						      <option value="">--Select Month--</option>
							  <option value="January" <?php if($user_row->month_passing == "January"){echo "selected";}?>>January</option>
							  <option value="February" <?php if($user_row->month_passing == "February"){echo "selected";}?>>February</option>
							  <option value="March" <?php if($user_row->month_passing == "March"){echo "selected";}?>>March</option>
							  <option value="April" <?php if($user_row->month_passing == "April"){echo "selected";}?>>April</option>
							  <option value="May" <?php if($user_row->month_passing == "May"){echo "selected";}?>>May</option>
							  <option value="June"<?php if($user_row->month_passing == "June"){echo "selected";}?>>June</option>
							  <option value="July" <?php if($user_row->month_passing == "July"){echo "selected";}?>>July</option>
							  <option value="August" <?php if($user_row->month_passing == "August"){echo "selected";}?>>August</option>
							  <option value="September" <?php if($user_row->month_passing == "September"){echo "selected";}?>>September</option>
							  <option value="October" <?php if($user_row->month_passing == "October"){echo "selected";}?>>October</option>
							  <option value="November" <?php if($user_row->month_passing == "November"){echo "selected";}?>>November</option>
							  <option value="December" <?php if($user_row->month_passing == "December"){echo "selected";}?>>December</option>
							  
							</select>
					</div>
						
						<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Year of Passing</label>
					     <select name="yearpassing" id="yearpassing" class="form-control">
						      <option value="">--Select Year--</option>
							  <?php for($i=date('Y')-10;$i<=date('Y');$i++){?>
							
							  <option value="<?php echo $i;?>" <?php if($user_row->year_passing == $i){echo "selected";}?>><?php echo $i;?></option>
							
							  <?php } ?>
							</select>
					</div>
						
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Medium of Instruction<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="medium_instr" id="medium_instr" class="form-control" >
						      <option value="">--Select Medium of Instruction--</option>
							  
							  <option value="English" <?php if($user_row->medium_instr == "English"){echo "selected";}?>>English</option>
							  <option value="Tamil" <?php if($user_row->medium_instr == "Tamil"){echo "selected";}?>>Tamil</option>
							  <option value="Telugu" <?php if($user_row->medium_instr == "Telugu"){echo "selected";}?>>Telugu</option>
							  <option value="Hindi" <?php if($user_row->medium_instr == "Hindi"){echo "selected";}?>>Hindi</option>
							
							  
						   </select> 
						</div>
										   
						<div class="form-group col-md-3">
						  <label for="state"><i class="fa fa-flag"></i> Mode of Admission<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="modeofadmission" id="modeofadmission" class="form-control">
						      <option value="">--Select Mode of Admission--</option>
						      <option value="N/A" <?php if($user_row->mode_of_admission == "N/A"){echo "selected";}?>>N/A</option>
						      <option value="General" <?php if($user_row->mode_of_admission == "General"){echo "selected";}?>>General</option>
						      <option value="Reserved" <?php if($user_row->mode_of_admission == "Reserved"){echo "selected";}?>>Reserved</option>
							</select> 
						</div>
						</div>
				    <div class="row">
				   <div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i>Group</label>
					     <select name="group" id="group" class="form-control" onchange="setgroup(this.value);">
						      <option value="">--Select Group--</option>
							  <option value="group1" <?php if(@$user_education[0]['group'] == "group1"){echo "selected";}?> >Group 1</option>
							<option value="group2" <?php if(@$user_education[0]['group'] == "group2"){echo "selected";}?> >Group 2</option>
							  <option value="vocational" <?php if(@$user_education[0]['group'] == "vocational"){echo "selected";}?> >Vocational</option>
							 
							</select>
					</div>
					</div>
					<div class="row">
					<div class="form-group col-md-3" id="phydiv" style="display:none">
					  <label for="roll"><i class="fa fa-ship"></i>Physics</label>
					    <input type="text" class="form-control" id="physics" name="physics" placeholder="Enter Marks" value="<?php echo @$user_education[0]['physics_theory'];?>">
					</div>
					
					<div class="form-group col-md-3" id="chediv" style="display:none">
					  <label for="roll"><i class="fa fa-ship"></i>Chemistry</label>
					    <input type="text" class="form-control" id="chemistry" name="chemistry" placeholder="Enter Marks" value="<?php echo @$user_education[0]['chemistry_theory'];?>">
					</div>
					
					<div class="form-group col-md-3" id="biodiv" style="display:none">
					  <label for="roll"><i class="fa fa-ship"></i>Biology</label>
					    <input type="text" class="form-control" id="biology" name="biology" placeholder="Enter Marks" value="<?php echo @$user_education[0]['biology_theory'];?>">
					</div>
					
					<div class="form-group col-md-3" id="botdiv" style="display:none">
					  <label for="roll"><i class="fa fa-ship"></i>Botany</label>
					    <input type="text" class="form-control" id="botany" name="botany" placeholder="Enter Marks" value="<?php echo @$user_education[0]['botany_theory'];?>">
					</div>
					
					<div class="form-group col-md-3" id="zoodiv" style="display:none">
					  <label for="roll"><i class="fa fa-ship"></i>Zoology</label>
					    <input type="text" class="form-control" id="zoology" name="zoology" placeholder="Enter Marks" value="<?php echo @$user_education[0]['zoology_theory'];?>">
					</div>
					<div class="form-group col-md-3" id="fishdiv" style="display:none">
					  <label for="roll"><i class="fa fa-ship"></i>Fisheries</label>
					    <input type="text" class="form-control" id="fisheries" name="fisheries" placeholder="Enter Marks" value="<?php echo @$user_education[0]['vocational_theory'];?>">
					</div>
				   </div>
				   <div class="row">
						<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i>Reserved</label>
					     <select name="reserved" id="reserved" class="form-control">
						      <option value="">--Select Reserved--</option>
							   <option value="A" <?php if($user_row->reserved == "A"){echo "selected";}?>>A</option>
							    <option value="B" <?php if($user_row->reserved == "B"){echo "selected";}?>>B</option>
							</select>
					</div>
						
						<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Quota</label>
					     <select name="quota" id="quota" class="form-control">
						      <option value="">--Select Quota--</option>
							  <option value="A" <?php if($user_row->quota == "A"){echo "selected";}?>>A</option>
							    <option value="B" <?php if($user_row->quota == "B"){echo "selected";}?>>B</option>
							</select>
					</div>
						
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Remarks<span style="color:red;font-weight: bold;">*</span></label>
						   <textarea name="remark" id="remark" class="form-control"><?php echo $user_row->remark;?></textarea> 
						</div>
										   
						
						</div>
				  
				   <div class="row">
				   <div class="form-group col-md-3">
					  <label for="last_school"><i class="fa fa-address-book"></i>Last School</label>
					    <input type="text" class="form-control" id="last_school" name="last_school" placeholder="Enter School" value="<?php echo $user_row->last_school;?>">
					</div>
					 <div class="form-group col-md-3">
					  <label for="last_std"><i class="fa fa-file-text-o"></i> Last STD</label>
					    <input type="text" class="form-control" id="last_std" name="last_std" placeholder="Enter STD" value="<?php echo $user_row->last_std;?>">
					</div>
					 <div class="form-group col-md-3">
					  <label for="marks_obtained"><i class="fa fa-percent"></i> Marks Obtained</label>
					    <input type="text" class="form-control" id="marks_obtained" name="marks_obtained" placeholder="Enter %Marks" value="<?php echo $user_row->marks_obtained;?>">
					</div>
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-life-bouy"></i> Sports</label>
					     <select name="sports_id" id="sports_id" class="form-control">
						      <option value="">--Select Sport--</option>
							  <option value="cricket" <?php if($user_row->sports_id == "cricket"){echo "selected";}?>>Cricket</option>
							  <option value="football" <?php if($user_row->sports_id == "football"){echo "selected";}?>>Football</option>
							  <option value="tenis" <?php if($user_row->sports_id == "tenis"){echo "selected";}?>>Tenis</option>
						</select>
					</div>
				  </div>
				  
				    <div class="row">
					<div class="form-group col-md-12"><i class="fa fa-book"></i>Academic Info</div>
				  <div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Student Status</label>
					     <select name="student_status" id="student_status" class="form-control">
						      <option value="">--Select Student Status--</option>
							  <option value="Active" <?php if($user_row->student_status == "Active"){echo "selected";}?>>Active</option>
							<option value="Dismissed" <?php if($user_row->student_status == "Dismissed"){echo "selected";}?>>Dismissed</option>
							  <option value="With held" <?php if($user_row->student_status == "With held"){echo "selected";}?>>With held</option>
							  <option value="Dis-continued" <?php if($user_row->student_status == "Dis-continued"){echo "selected";}?>>Dis-continued</option>
							</select>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Medical Ground with Permission</label>
					     <select name="medical_permission" id="medical_permission" class="form-control">
						      <option value="">--Select Permission--</option>
							  <option value="Yes" <?php if($user_row->medical_permission == "Yes"){echo "selected";}?>>Yes</option>
							  <option value="No" <?php if($user_row->medical_permission == "No"){echo "selected";}?>>No</option>
							</select>
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i> Date Of Admission</label>
					    <input type="text" class="form-control" id="doa" name="doa" placeholder="Enter Date Of Admission" value="<?php echo $user_row->doa;?>">
					</div>
					
					<div class="form-group col-md-3">
					  <label for="roll"><i class="fa fa-ship"></i>Date Of Passing</label>
					    <input type="text" class="form-control" id="dop" name="dop" placeholder="Enter Date Of Passing" value="<?php echo $user_row->dop;?>">
					</div>
				  </div>
				  
				  
				    <div class="row">
				  <div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i>Internship Grade</label>
					     <select name="internship_grade" id="internship_grade" class="form-control">
						      <option value="">--Select Internship Grade--</option>
							  <option value="A" <?php if($user_row->internship_grade == "A"){echo "selected";}?>>A</option>
							<option value="B" <?php if($user_row->internship_grade == "B"){echo "selected";}?>>B</option>
							  <option value="C" <?php if($user_row->internship_grade == "C"){echo "selected";}?>>C</option>
							  <option value="D" <?php if($user_row->internship_grade == "D"){echo "selected";}?>>D</option>
							</select>
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Ward Counsellor</label>
					    <input type="text" class="form-control" id="ward_counsellor" name="ward_counsellor" placeholder="Enter Ward Counsellor" value="<?php echo $user_row->ward_counsellor;?>">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Extra curricular activities</label>
					    <textarea class="form-control" id="extra_activites" name="extra_activites" placeholder="Enter Date Of Admission"><?php echo $user_row->extra_activites;?></textarea>
					</div>
					
					
				  </div>
				  
				  <div><i class="fa fa-user"></i> Parent Info</div>
				
					<div class="row">
						<div class="form-group col-md-3">
						  <label for="parent"><i class="fa fa-user-circle-o"></i> Parent Name<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="parent_name" name="parent_name" value="<?php echo $user_row->parent_name;?>" placeholder="Enter Parent Name">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-female"></i> Mother Name<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="mother_name" name="mother_name" value="<?php echo $user_row->mother_name;?>" placeholder="Enter Mother Name">
						</div>
						<div class="form-group col-md-3">
						  <label for="occupation"><i class="fa fa-tasks"></i> Occupation<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="occupation" id="occupation" class="form-control">
							  <option value="">--Select Occupation--</option>
							  <option value="1" <?php if($user_row->occupation=='1') {echo "selected";}?>>Cultivation</option>
							  <option value="2" <?php if($user_row->occupation=='2') {echo "selected";}?>>Business</option>
						  </select>
						</div>
						<div class="form-group col-md-3">
						  <label for="father_contact"><i class="fa fa-phone"></i> Father Contact<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="father_contact" name="father_contact" value="<?php echo $user_row->father_contact;?>" placeholder="Enter Father Contact">
						</div>
				   </div>
				   <div class="row">
						<div class="form-group col-md-3">
						  <label for="parent"><i class="fa fa-phone"></i> Alternate Contact<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="alternate_contact" name="alternate_contact" value="<?php echo $user_row->father_contact;?>" placeholder="Enter Alternate Contact">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-envelope"></i> Father Email<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="father_email" name="father_email" value="<?php echo $user_row->father_contact;?>" placeholder="Enter Father Email">
						</div>
						
						<div class="form-group col-md-3">
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> Annual Income<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="annualincome" name="annualincome" placeholder="Enter Annual Income" value="<?=$user_row->annual_income?>">
					</div>
						
						 <div class="form-group col-md-3">
					  <label for="parent_image"><i class="fa fa-image"></i> Parent Photo</label>
					  <input type="file" class="form-control" id="parent_image" name="parent_image" >
					   <?php if($user_row->user_image == '') $image = 'no_image.jpg'; else $image = $user_row->parent_image;?>
					  <span><img src="<?php echo base_url();?>uploads/user_images/parent/<?php echo $image;?>" height="50px" width="50px"></span>
					   <!-- <span><img src="<?php echo base_url();?>uploads/user_images/parent/<?php echo $user_row->parent_image;?>" height="50px" width="50px"></span>-->
						  <input type="hidden" class="form-control" id="parent_old_image" name="parent_old_image" value="<?php echo $user_row->parent_image;?>">
					</div>
				   </div>
				  
				   <div class="row">
				<div class="form-group col-md-12"><i class="fa fa-user"></i> Parent Login Info</div>
				</div>
				 <div class="row">
				   <div class="form-group col-md-3">
					  <label for="parent_username"><i class="fa fa-user-circle-o"></i>Parent Username</label>
					    <input type="text" class="form-control" id="parent_username" name="parent_username" placeholder="Enter Parent Username" <?php echo $user_row->parent_name;?>>
					</div>
					 <div class="form-group col-md-3">
					  <label for="parent_password"><i class="fa fa-lock"></i>Parent Password</label>
					    <input type="password" class="form-control" id="parent_password" name="parent_password" placeholder="Enter Parent Password" <?php echo $user_row->father_password;?>>
					</div>
					 
				  </div>
				   
               </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
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
		<?php if($user_row->community != '')?>
		{
			getCaste(); 
		}
		<?php if($user_row->country_id != '')?>
			getState('state_id');
		<?php if($user_row->country_id_local != '')?>
			getState('state_id_local');	
		<?php if($user_row->group != '')?>
			setgroup(<?=$user_row->group?>);	
	});
	
	
	
	
	
   
	function getState(id)
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
			 }
		});
	}
	

	
	
   $("#userform").validate({
		rules: {
			username: "required",
			password: "required",
			first_name: "required",
			last_name:"required",
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
			zip_code_local:{
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
			last_name:"Last Name Is Required",
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
			zip_code_local:{ 
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
			
			
			document.getElementById("caste").value = <?=$user_row->caste;?>;
			 }
		});
	}
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 