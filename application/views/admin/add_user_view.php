<?php 
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add User
      
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $title;?></li>
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
            <form role="form" name="userform" id="userform" method="post" action="<?php echo base_url();?>admin/saveUser" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="username_data"><i class="fa fa-user-circle-o"></i> Username<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="username" name="username" onblur="checkUser();" placeholder="Enter Username">
					  <span class="errorMsg"></span>
					</div>
					<div class="form-group col-md-2">
					  <label for="password_text"><i class="fa fa-lock"></i>Password<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="password" name="password" placeholder="Password">
					</div>
					<div class="form-group col-md-2">
					  <label for="password_text"><i class="fa fa-lock"></i>Unique Id<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="unique_id" name="unique_id" placeholder="Student Unique Id">
					</div>
					<div class="form-group col-md-2">
					  <label for="exampleInputEmail1"><i class="fa fa-user-circle-o"></i> First Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name">
					</div>
					<div class="form-group col-md-2">
					  <label for="exampleInputPassword1"><i class="fa fa-user-circle-o"></i> Last Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name">
					</div>
               </div>
			   
			    <div class="row">
				    <div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-envelope"></i> Email<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="email" class="form-control" id="email" name="email" placeholder=" Enter Email">
					</div>
				    <div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-phone"></i> Contact No.<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="contact_number" maxlength="10" name="contact_number" placeholder="Enter Contact Number">
					</div>
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-universal-access" aria-hidden="true"></i> Role<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="user_type" id="user_type" class="form-control" onchange="detailDiv();">
					  <option value="">--Select Role--</option>
					  <?php foreach($roles as $role){?>
					  <option value="<?php echo $role->id;?>"><?php echo $role->role_name;?></option>
					 
					  <?php } ?>
					  </select>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> DOB<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="dob" name="dob" placeholder="Enter Date Of Birth">
					</div>
					
					</div>
			   
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-intersex custom"></i> Gender<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="gender" id="gender" class="form-control">
					  <option value="">--Select Gender--</option>
					  <option value="male">Male</option>
					  <option value="female">Female</option>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1"><i class="fa fa-image"></i> User Image</label>
					  <input type="file" class="form-control" id="user_image" name="user_image">
					</div>
					
					
					<div class="form-group col-md-3">&nbsp;</div>
				</div>
				
			
				
			   <!--student other details start-->
                <div id="studentDiv" style="display:none">
				
					<div class="row"><br>
					<div class="form-group col-md-12"><i class="fa fa-book"></i> Basic Info</div>
					<br>
					<div class="form-group col-md-3">
					  <label for="password_text"><i class="fa fa-lock"></i>Application No<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="applicationno" name="applicationno" placeholder="Application No">
					</div>
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-intersex custom"></i> Blood Group<span style="color:red;font-weight: bold;">*</span></label>
					 
					 <select name="bloodgroup" id="bloodgroup" class="form-control">
					  <option value="">--Select Blood Group--</option>
					  <option value="A" >A</option>
					  <option value="A+">A+</option>
					  <option value="AB-">AB-</option>
					  <option value="B+" >B+</option>
					  <option value="B-">B-</option>
					  <option value="AB+">AB+</option>
					  </select>
					  </select>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-intersex custom"></i> Mother Tongue<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="mothertongue" id="mothertongue" class="form-control">
					  <option value="">--Select Mother Tongue--</option>
					  <option value="English">English</option>
					  <option value="Tamil">Tamil</option>
					  <option value="Telugu">Telugu</option>
					  <option value="Malayalam">Malayalam</option>
					  <option value="Hindi">Hindi</option>
					  <option value="Kannada">Kannada</option>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> Day Scholar/Hosteller<span style="color:red;font-weight: bold;">*</span></label>
					   <select name="residenttype" id="residenttype" class="form-control" >
					  <option value="">--Select Resident Type--</option>
					  
					  <option value="Day Scholar">Day Scholar</option>
					  <option value="Hosteller">Hosteller</option>
					 
					 
					  </select>
					</div>
					
				</div>
				
				<div class="row">
									<div class="form-group col-md-3">

						  <label for="religion"><i class="fa fa-venus custom"></i> Religion<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="religion" id="religion" class="form-control">
						      <option value="">--Select Religion--</option>
							  <option value="1">Muslim</option>
							  <option value="2">Hindu</option>
							  <option value="3">Christian</option>
						   </select> 
						</div>
						<div class="form-group col-md-3">
						  <label for="nationality"><i class="fa fa-flag"></i> Nationality<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="nationality" id="nationality" class="form-control">
						      <option value="">--Select Nationality--</option>
							  <option value="1">Indian</option>
							  <option value="2">Hindu</option>
							  <option value="3">Christian</option>
						   </select> 
						</div>
						<div class="form-group col-md-3">
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> Community<span style="color:red;font-weight: bold;">*</span></label>
					   <select name="community" id="community" class="form-control" onchange="getCaste();">
					  <option value="">--Select Community--</option>
					  <?php foreach($community as $rescom){?>
					  <option value="<?php echo $rescom->id;?>"><?php echo $rescom->name;?></option>
					 
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
							  <option value="<?php echo $batch->id;?>"><?php echo $batch->batch_name;?></option>
							  <?php }?>
						  </select>
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-female"></i>Campus<span style="color:red;font-weight: bold;">*</span></label>
						 <select name="campus_id" id="campus_id" class="form-control" onchange="getDegree();">
							  <option value="">--Select Campus--</option>
							 <?php foreach($campuses as $campus){?>
							  <option value="<?php echo $campus->id;?>"><?php echo $campus->campus_name;?></option>
							  <?php }?>
						  </select>
						</div>
						<div class="form-group col-md-3">
						  <label for="occupation"><i class="fa fa-tasks"></i>Degree<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="degree_id" id="degree_id" class="form-control">
							  <option value="">--Select Degree--</option>
							 <option value="1">A</option>
							  <option value="2">B</option>
						  </select>
						</div>
						<div class="form-group col-md-3">
						  <label for="father_contact">Type<span style="color:red;font-weight: bold;">*</span></label>
						  <select name="course_type" id="course_type" class="form-control">
							  <option value="">--Select Type--</option>
							  <option value="1">Full Time</option>
							  <option value="2">Part Time</option>
						  </select>
						</div>
				   </div>
				
				    <div class="row">
					<br>
					<div class="form-group col-md-12"><i class="fa fa-book"></i> Permanent Address</div>
					<br>
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Address 1<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
						 
						</div>
						
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Address 2<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address2" name="address2" placeholder="Enter Address">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Address 3<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address3" name="address3" placeholder="Enter Address">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Address 4<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address4" name="address4" placeholder="Enter Address">
						 
						</div>
						</div>
						 <div class="row">
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Country<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="country_id" id="country_id" class="form-control" onchange="getState('state_id');">
						      <option value="">--Select Country--</option>
							  <?php foreach($countries as $country) { ?>
							  <option value="<?php echo $country->id;?>"><?php echo $country->country_name;?></option>
							
							  <?php } ?>
						   </select> 
						</div>
										   
						<div class="form-group col-md-3">
						  <label for="state"><i class="fa fa-flag"></i> State<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="state_id" id="state_id" class="form-control">
						      <option value="">--Select State--</option>
							</select> 
						</div>
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> City<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="city_id" id="city_id" class="form-control" >
						      <option value="">--Select City--</option>
							  <?php foreach($city as $cities) { ?>
							  <option value="<?php echo $cities->city_id;?>"><?php echo $cities->city;?></option>
							
							  <?php } ?>
						   </select> 
						</div>
						<div class="form-group col-md-3">
						  <label for="zip"><i class="fa fa-map-pin"></i> Zip Code<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="zip_code" maxlength="6" name="zip_code" placeholder="Enter Zip Code">
						 
						</div>
						</div>
				   <div class="row">
						
						
						<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-female"></i> Guardian/Spouse Name<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="guardian_name" name="guardian_name" placeholder="Enter Guardian/Spouse Name">
						</div>
						<div class="form-group col-md-3">
						   <label for="state"><i class="fa fa-flag"></i>Academic/Vocational<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="academicvocational" id="academicvocational" class="form-control">
						      <option value="">--Select Academic/Vocational--</option>
						      <option value="Academic">Academic</option>
						      <option value="Vocational">Vocational</option>
							</select> 
						</div>
				   </div>
				   
				     <div class="row">
					 <br>
					<div class="form-group col-md-12"><i class="fa fa-book"></i> Local Address</div>
					<br>
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Address<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address_local" name="address_local" placeholder="Enter Address">
						 
						</div>
						
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Street<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="street_local" name="street_local" placeholder="Enter Street">
						 
						</div>
						
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Country<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="country_id_local" id="country_id_local" class="form-control" onchange="getState('state_id_local');">
						      <option value="">--Select Country--</option>
							  <?php foreach($countries as $country) { ?>
							  <option value="<?php echo $country->id;?>"><?php echo $country->country_name;?></option>
							
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
						   <select name="city_id" id="city_id" class="form-control" >
						      <option value="">--Select City--</option>
							  <?php foreach($city as $cities) { ?>
							  <option value="<?php echo $cities->city_id;?>"><?php echo $cities->city;?></option>
							
							  <?php } ?>
						   </select> 
						</div>
						<div class="form-group col-md-3">
						  <label for="zip"><i class="fa fa-map-pin"></i> Zip Code<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="zip_code_local" maxlength="6" name="zip_code_local" placeholder="Enter Zip Code">
						 
						</div>
						
						<div class="form-group col-md-3">
						  <label for="state"><i class="fa fa-flag"></i> Type of scholarship Received<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="scholarship" id="scholarship" class="form-control">
						      <option value="">--Select Type of scholarship Received--</option>
						      <option value="A">A</option>
						      <option value="B">B</option>
							</select> 
						</div>
						
						
				   </div>
				  
				  <div class="row">
				<div class="form-group col-md-12"><i class="fa fa-book"></i> Pre Academic Info</div>
				</div>
				 
				   <div class="row">
				   <div class="form-group col-md-3">
					  <label for="registration"><i class="fa fa-registered"></i> Registration</label>
					    <input type="text" class="form-control" id="registration" name="registration" placeholder="Enter Registration">
					</div>
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i> Class</label>
					    <input type="text" class="form-control" id="class_name" name="class_name" placeholder="Enter Class">
					</div>
					<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Section</label>
					     <select name="section_id" id="section_id" class="form-control">
						      <option value="">--Select Section--</option>
							  <option value="A">A</option>
							  <option value="B">B</option>
							</select>
					</div>
					<div class="form-group col-md-3">
					  <label for="roll"><i class="fa fa-ship"></i>Roll</label>
					    <input type="text" class="form-control" id="roll" name="roll" placeholder="Enter Roll">
					</div>
				  </div>
				  
				  <div class="row">
						<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Month of Passing</label>
					     <select name="monthpassing" id="monthpassing" class="form-control">
						      <option value="">--Select Month--</option>
							  <option value="January">January</option>
							  <option value="February">February</option>
							  <option value="March">March</option>
							  <option value="April">April</option>
							  <option value="May">May</option>
							  <option value="June">June</option>
							  <option value="July">July</option>
							  <option value="August">August</option>
							  <option value="September">September</option>
							  <option value="October">October</option>
							  <option value="November">November</option>
							  <option value="December">December</option>
							  
							</select>
					</div>
						
						<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Year of Passing</label>
					     <select name="yearpassing" id="yearpassing" class="form-control">
						      <option value="">--Select Year--</option>
							  <?php $year = 2019;for($i=2019;$i<=2000;$i--) { ?>
							  <option value="<?php echo $i;?>"><?php echo $i;?></option>
							
							  <?php } ?>
							</select>
					</div>
						
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Medium of Instruction<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="medium_instr" id="medium_instr" class="form-control" >
						      <option value="">--Select Medium of Instruction--</option>
							  
							  <option value="English">English</option>
							  <option value="Tamil">Tamil</option>
							  <option value="Telugu">Telugu</option>
							  <option value="Hindi">Hindi</option>
							
							  
						   </select> 
						</div>
										   
						<div class="form-group col-md-3">
						  <label for="state"><i class="fa fa-flag"></i> Mode of Admission<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="modeofadmission" id="modeofadmission" class="form-control">
						      <option value="">--Select Mode of Admission--</option>
						      <option value="N/A">N/A</option>
						      <option value="General">General</option>
						      <option value="Reserved">Reserved</option>
							</select> 
						</div>
						</div>
				 
				   <div class="row">
				   <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Board of Examination</label>
					    <input type="text" class="form-control" id="boardexam" name="boardexam" placeholder="Enter Board of Examination">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Number of attempts</label>
					    <input type="text" class="form-control" id="attempts" name="attempts" placeholder="Enter Number of attempts">
					</div>
				   <div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i>Group</label>
					     <select name="group" id="group" class="form-control" onchange="setgroup(this.value);">
						      <option value="">--Select Group--</option>
							  <option value="group1">Group 1</option>
							<option value="group2">Group 2</option>
							  <option value="vocational">Vocational</option>
							 
							</select>
					</div>
					</div>
					  <div class="row" id="commdiv" style="display:none">
				<div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Language</label>
					    <input type="text" class="form-control" id="language" name="language" placeholder="Enter Language">
					</div>
					
					 <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>English</label>
					    <input type="text" class="form-control" id="english" name="english" placeholder="Enter English">
					</div>
					
					   <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Mathematics</label>
					    <input type="text" class="form-control" id="mathematics" name="mathematics" placeholder="Enter Mathematics">
					</div>
					
					
				  </div>
				  
				  <div class="row" id="phydiv" style="display:none">
				<div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Physics Theory</label>
					    <input type="text" class="form-control" id="physics_theory" name="physics_theory" placeholder="Enter Physics Theory">
					</div>
					
					 <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Physics Practical</label>
					    <input type="text" class="form-control" id="physics_practical" name="physics_practical" placeholder="Enter Physics Practical">
					</div>
					
					   <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Physics Total</label>
					    <input type="text" class="form-control" id="physics_total" name="physics_total" placeholder="Enter Physics Total">
					</div>
					
					
				  </div>
				  
				  <div class="row" id="chediv" style="display:none">
				<div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Chemistry Theory</label>
					    <input type="text" class="form-control" id="chemistry_theory" name="chemistry_theory" placeholder="Enter Chemistry Theory">
					</div>
					
					 <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Chemistry Practical</label>
					    <input type="text" class="form-control" id="chemistry_practical" name="chemistry_practical" placeholder="Enter Chemistry Practical">
					</div>
					
					   <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Chemistry Total</label>
					    <input type="text" class="form-control" id="chemistry_total" name="chemistry_total" placeholder="Enter Chemistry Total">
					</div>
					
					
				  </div>
				  
				   <div class="row" id="biodiv" style="display:none">
				<div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Biology Theory</label>
					    <input type="text" class="form-control" id="biology_theory" name="biology_theory" placeholder="Enter Biology Theory">
					</div>
					
					 <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Biology Practical</label>
					    <input type="text" class="form-control" id="biology_practical" name="biology_practical" placeholder="Enter Biology Practical">
					</div>
					
					   <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Biology Total</label>
					    <input type="text" class="form-control" id="biology_total" name="biology_total" placeholder="Enter Biology Total">
					</div>
					
					
				  </div>
				  
				    <div class="row" id="botdiv" style="display:none">
				<div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Botany Theory</label>
					    <input type="text" class="form-control" id="botany_theory" name="botany_theory" placeholder="Enter Botany Theory">
					</div>
					
					 <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Botany Practical</label>
					    <input type="text" class="form-control" id="botany_practical" name="botany_practical" placeholder="Enter Botany Practical">
					</div>
					
					   <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Botany Total</label>
					    <input type="text" class="form-control" id="botany_total" name="botany_total" placeholder="Enter Botany Total">
					</div>
					
					
				  </div>
				  
				   <div class="row" id="zoodiv" style="display:none">
				<div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Zoology Theory</label>
					    <input type="text" class="form-control" id="zoology_theory" name="zoology_theory" placeholder="Enter Zoology Theory">
					</div>
					
					 <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Zoology Practical</label>
					    <input type="text" class="form-control" id="zoology_practical" name="zoology_practical" placeholder="Enter Zoology Practical">
					</div>
					
					   <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Zoology Total</label>
					    <input type="text" class="form-control" id="zoology_total" name="zoology_total" placeholder="Enter Zoology Total">
					</div>
					
					
				  </div>
				  
				   <div class="row" id="otherdiv" style="display:none">
				<div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Other Theory</label>
					    <input type="text" class="form-control" id="other_theory" name="other_theory" placeholder="Enter Other Theory">
					</div>
					
					 <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Other Practical</label>
					    <input type="text" class="form-control" id="other_practical" name="other_practical" placeholder="Enter Other Practical">
					</div>
					
					   <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Other Total</label>
					    <input type="text" class="form-control" id="other_total" name="other_total" placeholder="Enter Other Total">
					</div>
					
					
				  </div>
				  
				   <div class="row" id="fishdiv" style="display:none">
				<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Vocational Theory</label>
					    <input type="text" class="form-control" id="vocational_theory" name="vocational_theory" placeholder="Enter Vocational Theory">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Vocational Practical 1</label>
					    <input type="text" class="form-control" id="vocational_practical1" name="vocational_practical1" placeholder="Enter Vocational Practical 1 ">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Vocational Practical 2</label>
					    <input type="text" class="form-control" id="vocational_practical2" name="vocational_practical2" placeholder="Enter Vocational Practical 2">
					</div>
					
					   <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Vocational Total</label>
					    <input type="text" class="form-control" id="vocational_total" name="vocational_total" placeholder="Enter Vocational Total">
					</div>
					
					
				  </div>
				  
				     <div class="row" id="totdiv" style="display:none">
				<div class="form-group col-md-4" >
					  <label for="class"><i class="fa fa-list-alt"></i>Total</label>
					    <input type="text" class="form-control" id="total" name="total" placeholder="Enter Total">
					</div>
					
					 <div class="form-group col-md-4">
					  <label for="class"><i class="fa fa-list-alt"></i>Total Aggregate</label>
					    <input type="text" class="form-control" id="total_aggregate" name="total_aggregate" placeholder="Enter Total Aggregate">
					</div>
					
					   
					
					
				  </div>
				  
					<!-- <div class="row">
					<div class="form-group col-md-3" id="phydiv" style="display:none">
					  <label for="roll"><i class="fa fa-ship"></i>Physics</label>
					    <input type="text" class="form-control" id="physics" name="physics" placeholder="Enter Marks">
					</div>
					
					<div class="form-group col-md-3" id="chediv" style="display:none">
					  <label for="roll"><i class="fa fa-ship"></i>Chemistry</label>
					    <input type="text" class="form-control" id="chemistry" name="chemistry" placeholder="Enter Marks">
					</div>
					
					<div class="form-group col-md-3" id="biodiv" style="display:none">
					  <label for="roll"><i class="fa fa-ship"></i>Biology</label>
					    <input type="text" class="form-control" id="biology" name="biology" placeholder="Enter Marks">
					</div>
					
					<div class="form-group col-md-3" id="botdiv" style="display:none">
					  <label for="roll"><i class="fa fa-ship"></i>Botany</label>
					    <input type="text" class="form-control" id="botany" name="botany" placeholder="Enter Marks">
					</div>
					
					<div class="form-group col-md-3" id="zoodiv" style="display:none">
					  <label for="roll"><i class="fa fa-ship"></i>Zoology</label>
					    <input type="text" class="form-control" id="zoology" name="zoology" placeholder="Enter Marks">
					</div>
					<div class="form-group col-md-3" id="fishdiv" style="display:none">
					  <label for="roll"><i class="fa fa-ship"></i>Fisheries</label>
					    <input type="text" class="form-control" id="fisheries" name="fisheries" placeholder="Enter Marks">
					</div>
				   </div>
				   -->
				   
				   <div class="row">
						<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i>Reserved</label>
					     <select name="reserved" id="reserved" class="form-control">
						      <option value="">--Select Reserved--</option>
							   <option value="A">A</option>
							    <option value="B">B</option>
							</select>
					</div>
						
						<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Quota</label>
					     <select name="quota" id="quota" class="form-control">
						      <option value="">--Select Quota--</option>
							  <option value="A">A</option>
							    <option value="B">B</option>
							</select>
					</div>
						
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Remarks<span style="color:red;font-weight: bold;">*</span></label>
						   <textarea name="medium_instr" id="medium_instr" class="form-control"></textarea> 
						</div>
										   
						
						</div>
				  
				   <div class="row">
				   <div class="form-group col-md-3">
					  <label for="last_school"><i class="fa fa-address-book"></i>Last School</label>
					    <input type="text" class="form-control" id="last_school" name="last_school" placeholder="Enter School">
					</div>
					 <div class="form-group col-md-3">
					  <label for="last_std"><i class="fa fa-file-text-o"></i> Last STD</label>
					    <input type="text" class="form-control" id="last_std" name="last_std" placeholder="Enter STD">
					</div>
					 <div class="form-group col-md-3">
					  <label for="marks_obtained"><i class="fa fa-percent"></i> Marks Obtained</label>
					    <input type="text" class="form-control" id="marks_obtained" name="marks_obtained" placeholder="Enter %Marks">
					</div>
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-life-bouy"></i> Sports</label>
					     <select name="sports_id" id="sports_id" class="form-control">
						      <option value="">--Select Sport--</option>
							  <option value="cricket">Cricket</option>
							  <option value="football">Football</option>
							  <option value="tenis">Tenis</option>
						</select>
					</div>
				  </div>
				  
				    <div class="row">
					<div class="form-group col-md-12"><i class="fa fa-book"></i> Academic Info</div>
				  <div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Student Status</label>
					     <select name="student_status" id="student_status" class="form-control">
						      <option value="">--Select Student Status--</option>
							  <option value="Active">Active</option>
							<option value="Dismissed">Dismissed</option>
							  <option value="With held">With held</option>
							  <option value="Dis-continued">Dis-continued</option>
							</select>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i> Medical Ground with Permission</label>
					     <select name="medical_permission" id="medical_permission" class="form-control">
						      <option value="">--Select Permission--</option>
							  <option value="Yes">Yes</option>
							  <option value="No">No</option>
							</select>
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i> Date Of Admission</label>
					    <input type="text" class="form-control" id="doa" name="doa" placeholder="Enter Date Of Admission">
					</div>
					
					<div class="form-group col-md-3">
					  <label for="roll"><i class="fa fa-ship"></i>Date Of Passing</label>
					    <input type="text" class="form-control" id="dop" name="dop" placeholder="Enter Date Of Passing">
					</div>
				  </div>
				  
				  
				    <div class="row">
				  <div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i>Internship Grade</label>
					     <select name="internship_grade" id="internship_grade" class="form-control">
						      <option value="">--Select Internship Grade--</option>
							  <option value="A">A</option>
							<option value="B">B</option>
							  <option value="C">C</option>
							  <option value="D">D</option>
							</select>
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Ward Counsellor</label>
					    <input type="text" class="form-control" id="ward_counsellor" name="ward_counsellor" placeholder="Enter Ward Counsellor">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Extra curricular activities</label>
					    <textarea class="form-control" id="extra_activites" name="extra_activites" placeholder="Enter Date Of Admission"></textarea>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="roll"><i class="fa fa-ship"></i>Remark</label>
					   <textarea class="form-control" id="remark" name="remark" placeholder="Enter Remark"></textarea>
					</div>
				  </div>
				  
				  
				  
				  <div class="row">
				  <div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i>Courses Applied</label>
					     <select name="coursesapplied" id="coursesapplied" class="form-control">
						      <option value="">--Select Courses Applied--</option>
							  <option value="A">A</option>
							<option value="B">B</option>
							  <option value="C">C</option>
							  <option value="D">D</option>
							</select>
					</div>
					
					<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-female"></i>Campus Preference 1<span style="color:red;font-weight: bold;">*</span></label>
						 <select name="campus_preference1" id="campus_preference1" class="form-control" >
							  <option value="">--Select Campus--</option>
							 <?php foreach($campuses as $campus){?>
							  <option value="<?php echo $campus->id;?>"><?php echo $campus->campus_name;?></option>
							  <?php }?>
						  </select>
						</div>
					
					<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-female"></i>Campus Preference 2<span style="color:red;font-weight: bold;">*</span></label>
						 <select name="campus_preference2" id="campus_preference2" class="form-control" >
							  <option value="">--Select Campus--</option>
							 <?php foreach($campuses as $campus){?>
							  <option value="<?php echo $campus->id;?>"><?php echo $campus->campus_name;?></option>
							  <?php }?>
						  </select>
						</div>
					
					<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-female"></i>Campus Preference 3<span style="color:red;font-weight: bold;">*</span></label>
						 <select name="campus_preference3" id="campus_preference3" class="form-control" >
							  <option value="">--Select Campus--</option>
							 <?php foreach($campuses as $campus){?>
							  <option value="<?php echo $campus->id;?>"><?php echo $campus->campus_name;?></option>
							  <?php }?>
						  </select>
						</div>
				  </div>
				  
				  <div class="row">
				  <div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-female"></i>Campus Preference 4<span style="color:red;font-weight: bold;">*</span></label>
						 <select name="campus_preference4" id="campus_preference4" class="form-control" >
							  <option value="">--Select Campus--</option>
							 <?php foreach($campuses as $campus){?>
							  <option value="<?php echo $campus->id;?>"><?php echo $campus->campus_name;?></option>
							  <?php }?>
						  </select>
						</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Nativity</label>
					    <input type="text" class="form-control" id="nativity" name="nativity" placeholder="Enter Nativity">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>District</label>
					    					    <input type="text" class="form-control" id="district" name="district" placeholder="Enter District">

					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Aadhaar Number</label>
					    <input type="text" class="form-control" id="aadhaarno" name="aadhaarno" placeholder="Enter Aadhaar No"/>
					</div>
				  </div>
				  
				<div class="row">
				 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Place of Birth</label>
					    <input type="text" class="form-control" id="pob" name="pob" placeholder="Enter Place of Birth">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i>Differently Abled</label>
					     <select name="differentlyabled" id="differentlyabled" class="form-control">
						      <option value="">--Select Differently Abled--</option>
							  <option value="Yes">Yes</option>
							<option value="No">No</option>
							</select>
					</div>
					
					  <div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i>Children of Ex-servicemen</label>
					     <select name="exservicemen" id="exservicemen" class="form-control">
						      <option value="">--Select Children of Ex-servicemen--</option>
							  <option value="Yes">Yes</option>
							<option value="No">No</option>
							</select>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i>Children of Freedom Fighter</label>
					     <select name="freedomfighter" id="freedomfighter" class="form-control">
						      <option value="">--Select Children of Freedom Fighter--</option>
							  <option value="Yes">Yes</option>
							<option value="No">No</option>
							</select>
					</div>
				  </div>
				  
				  
				  <div class="row">
				<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i>First Graduate</label>
					     <select name="firstgraduate" id="firstgraduate" class="form-control">
						      <option value="">--Select First Graduate--</option>
							  <option value="Yes">Yes</option>
							<option value="No">No</option>
							</select>
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Place of Residence</label>
					    <input type="text" class="form-control" id="placeofresidence" name="placeofresidence" placeholder="Enter Place of Residence">
					</div>
					
					   <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Landline No</label>
					    <input type="text" class="form-control" id="landlineno" name="landlineno" placeholder="Enter Landline No">
					</div>
					
					<div class="form-group col-md-3">
					  <label for="section"><i class="fa fa-bell-o"></i>Academic/Vocational</label>
					     <select name="acadevocat" id="acadevocat" class="form-control">
						      <option value="">--Select Academic/Vocational--</option>
							  <option value="Academic">Academic</option>
							<option value="Vocational">Vocational</option>
							</select>
					</div>
				  </div>
				  
				  
				 
				  
				  
				  <div class="row">
				  <div class="form-group col-md-12"><i class="fa fa-user"></i> XII - INFO</div>
				  
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Name and School Address</label>
					    <input type="text" class="form-control" id="xii_school" name="xii_school" placeholder="Enter Name and School Address">
					</div>	
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Year of Study</label>
					    <input type="text" class="form-control" id="xii_year_of_study" name="xii_year_of_study" placeholder="Enter Year of Study">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Place of Study</label>
					    <input type="text" class="form-control" id="xii_place_of_study" name="xii_place_of_study" placeholder="Enter Place of Study">
					</div>
					
					   <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>State of Study</label>
					    <input type="text" class="form-control" id="xii_state_of_study" name="xii_state_of_study" placeholder="Enter State of Study">
					</div>
					
				  </div>
				  
				  
				  	<div class="row">
				  <div class="form-group col-md-12"><i class="fa fa-user"></i> XI - INFO</div>
				  
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Name and School Address</label>
					    <input type="text" class="form-control" id="xi_school" name="xi_school" placeholder="Enter Name and School Address">
					</div>	
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Year of Study</label>
					    <input type="text" class="form-control" id="xi_year_of_study" name="xi_year_of_study" placeholder="Enter Year of Study">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Place of Study</label>
					    <input type="text" class="form-control" id="xi_place_of_study" name="xi_place_of_study" placeholder="Enter Place of Study">
					</div>
					
					   <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>State of Study</label>
					    <input type="text" class="form-control" id="xi_state_of_study" name="xi_state_of_study" placeholder="Enter State of Study">
					</div>
					
				  </div>
				  
				  <div class="row">
				  <div class="form-group col-md-12"><i class="fa fa-user"></i> X - INFO</div>
				  
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Name and School Address</label>
					    <input type="text" class="form-control" id="x_school" name="x_school" placeholder="Enter Name and School Address">
					</div>	
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Year of Study</label>
					    <input type="text" class="form-control" id="x_year_of_study" name="x_year_of_study" placeholder="Enter Year of Study">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Place of Study</label>
					    <input type="text" class="form-control" id="x_place_of_study" name="x_place_of_study" placeholder="Enter Place of Study">
					</div>
					
					   <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>State of Study</label>
					    <input type="text" class="form-control" id="x_state_of_study" name="x_state_of_study" placeholder="Enter State of Study">
					</div>
					
				  </div>
				  
				    <div class="row">
				  <div class="form-group col-md-12"><i class="fa fa-user"></i> IX - INFO</div>
				  
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Name and School Address</label>
					    <input type="text" class="form-control" id="ix_school" name="ix_school" placeholder="Enter Name and School Address">
					</div>	
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Year of Study</label>
					    <input type="text" class="form-control" id="ix_year_of_study" name="ix_year_of_study" placeholder="Enter Year of Study">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Place of Study</label>
					    <input type="text" class="form-control" id="ix_place_of_study" name="ix_place_of_study" placeholder="Enter Place of Study">
					</div>
					
					   <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>State of Study</label>
					    <input type="text" class="form-control" id="ix_state_of_study" name="ix_state_of_study" placeholder="Enter State of Study">
					</div>
					
				  </div>
				  
				  
				   <div class="row">
				  <div class="form-group col-md-12"><i class="fa fa-user"></i> VIII - INFO</div>
				  
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Name and School Address</label>
					    <input type="text" class="form-control" id="vii_school" name="vii_school" placeholder="Enter Name and School Address">
					</div>	
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Year of Study</label>
					    <input type="text" class="form-control" id="vii_year_of_study" name="vii_year_of_study" placeholder="Enter Year of Study">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Place of Study</label>
					    <input type="text" class="form-control" id="vii_place_of_study" name="vii_place_of_study" placeholder="Enter Place of Study">
					</div>
					
					   <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>State of Study</label>
					    <input type="text" class="form-control" id="vii_state_of_study" name="vii_state_of_study" placeholder="Enter State of Study">
					</div>
					
				  </div>
				  
				  
				   <div class="row">
				 
				  
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Transaction ID</label>
					    <input type="text" class="form-control" id="transaction_id" name="transaction_id" placeholder="Enter Transaction ID">
					</div>	
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Transaction Date</label>
					    <input type="text" class="form-control" id="transaction_date" name="transaction_date" placeholder="Enter Transaction Date">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Submission Status</label>
					    <input type="text" class="form-control" id="submission_status" name="submission_status" placeholder="Enter Submission Status">
					</div>
					
					   <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Submission Date</label>
					    <input type="text" class="form-control" id="submission_date" name="submission_date" placeholder="Enter Submission Date">
					</div>
					
				  </div>
				  
				  
				  <div class="row">
				 
				  
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Received Status</label>
					    <input type="text" class="form-control" id="received_status" name="received_status" placeholder="Enter Received Status">
					</div>	
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Received Date</label>
					    <input type="text" class="form-control" id="received_date" name="received_date" placeholder="Enter Received Date">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Reason for Rejection</label>
					    <input type="text" class="form-control" id="reason_for_rejection" name="reason_for_rejection" placeholder="Enter Reason for Rejection">
					</div>
					
					   <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Overall Rank</label>
					    <input type="text" class="form-control" id="overall_rank" name="overall_rank" placeholder="Enter Overall Rank">
					</div>
					
				  </div>
				  
				   <div class="row">
				 
				  
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Community Rank</label>
					    <input type="text" class="form-control" id="community_rank" name="community_rank" placeholder="Enter Community Rank">
					</div>	
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Selected Under Category</label>
					    <input type="text" class="form-control" id="under_category" name="under_category" placeholder="Enter Selected Under Category">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Selected Under College</label>
					    <input type="text" class="form-control" id="under_college" name="under_college" placeholder="Enter Selected Under College">
					</div>
					
					   <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Fee Status</label>
					    <input type="text" class="form-control" id="fee_status" name="fee_status" placeholder="Enter Fee Status">
					</div>
					
				  </div>
				  
				   <div class="row">
				 
				  
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Receipt</label>
					    <input type="text" class="form-control" id="receipt" name="receipt" placeholder="Enter Receipt">
					</div>	
					<div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Receipt Date</label>
					    <input type="text" class="form-control" id="receipt_date" name="receipt_date" placeholder="Enter Receipt Date">
					</div>
					
					 <div class="form-group col-md-3">
					  <label for="class"><i class="fa fa-list-alt"></i>Receipt Remark</label>
					    <input type="text" class="form-control" id="receipt_remark" name="receipt_remark" placeholder="Enter Receipt Remark">
					</div>
					
					   
					
				  </div>
				  
				  
				  
				  <div class="row">
				<div class="form-group col-md-12"><i class="fa fa-user"></i> Parent Info</div>
				</div>
					<div class="row">
						<div class="form-group col-md-3">
						  <label for="parent"><i class="fa fa-user-circle-o"></i> Parent Name<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="parent_name" name="parent_name" placeholder="Enter Parent Name">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-female"></i> Mother Name<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="mother_name" name="mother_name" placeholder="Enter Mother Name">
						</div>
						<div class="form-group col-md-3">
						  <label for="occupation"><i class="fa fa-tasks"></i> Occupation<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="occupation" id="occupation" class="form-control">
							  <option value="">--Select Occupation--</option>
							  <option value="1">Cultivation</option>
							  <option value="2">Business</option>
						  </select>
						</div>
						
						<div class="form-group col-md-3">
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> Annual Income<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="annualincome" name="annualincome" placeholder="Enter Annual Income">
					</div>
						
						<div class="form-group col-md-3">
						  <label for="father_contact"><i class="fa fa-phone"></i> Father Contact<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="father_contact" name="father_contact" placeholder="Enter Father Contact">
						</div>
				   
				  
						<div class="form-group col-md-3">
						  <label for="parent"><i class="fa fa-phone"></i> Alternate Contact<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="alternate_contact" name="alternate_contact" placeholder="Enter Alternate Contact">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-envelope"></i> Father Email<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="father_email" name="father_email" placeholder="Enter Father Email">
						</div>
						 <div class="form-group col-md-3">
					  <label for="parent_image"><i class="fa fa-image"></i> Parent Photo</label>
					  <input type="file" class="form-control" id="parent_image" name="parent_image" >
					</div>
						
				   </div>
				  
				  
				   <div class="row">
				<div class="form-group col-md-12"><i class="fa fa-user"></i> Parent Login Info</div>
				</div>
				 <div class="row">
				   <div class="form-group col-md-3">
					  <label for="parent_username"><i class="fa fa-user-circle-o"></i>Parent Username</label>
					    <input type="text" class="form-control" id="parent_username" name="parent_username" placeholder="Enter Parent Username">
					</div>
					 <div class="form-group col-md-3">
					  <label for="parent_password"><i class="fa fa-lock"></i>Parent Password</label>
					    <input type="password" class="form-control" id="parent_password" name="parent_password" placeholder="Enter Parent Password">
					</div>
					 
				  </div>
				   
               </div>
			     <!--student other details end-->
               <!--teacher other details start-->
                <div id="teacherDiv" style="display:none">
				<div><i class="fa fa-book"></i>Teacher Info</div>
					<div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1"> Address Line1<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address_line1" name="address_line1" placeholder="Address Line1">
						  
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line2"> Address Line2<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address_line2" name="address_line2" placeholder="Address Line2">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3"> Address Line3<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address_line3" name="address_line3" placeholder="Address Line3">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4"> Address Line4<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address_line4" name="address_line4" placeholder="Address Line4">
						</div>
				   </div>
				   <div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1"> Landline No<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="landline_number" name="landline_number" placeholder="Landline No">
						  
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line2">Employment Id<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="Employment Id">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3">Qualification<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Qualification">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4">Date of Join<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="date_of_joining" name="date_of_joining" placeholder="Date of Join">
						</div>
				   </div>
				   
				    <div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1">Designation<span style="color:red;font-weight: bold;">*</span></label>
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
						  <label for="address_line2">Department<span style="color:red;font-weight: bold;">*</span></label>
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
						   <select name="discipline_id" id="discipline_id" class="form-control">
						    <option value="">--Select Discipline--</option>
						 <?php foreach($disciplines as $discipline){?>
					      <option value="<?php echo $discipline->id;?>"><?php echo $discipline->discipline_name;?></option>
					     <?php } ?>
					  </select>
						</div>
				   </div>
               </div>
			     <!--teacher other details end-->
			   <!--teacher other details start-->
                <div id="parentDiv" style="display:none">
				<div><i class="fa fa-book"></i>User Info</div>
				  
					<div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1"> Address Line1<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="user_address_line1" name="user_address_line1" placeholder="Address Line1">
						  
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line2"> Address Line2<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="user_address_line2" name="user_address_line2" placeholder="Address Line2">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3"> Address Line3<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="user_address_line3" name="user_address_line3" placeholder="Address Line3">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4"> Address Line4<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="user_address_line4" name="user_address_line4" placeholder="Address Line4">
						</div>
				   </div>
				   <div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1"> Landline No<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="user_landline_number" name="landline_number">
						  
						</div>
						
					</div>
				   
               </div>
			     <!--teacher other details end-->
				 
				    <!--subadmin other details start-->
               <div id="subadminDiv" style="display:none">
				<div><i class="fa fa-book"></i>User Info</div>
				  
					<div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1"> Address Line1<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="user_address_line1" name="user_address_line1" placeholder="Address Line1">
						  
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line2"> Address Line2<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="user_address_line2" name="user_address_line2" placeholder="Address Line2">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3"> Address Line3<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="user_address_line3" name="user_address_line3" placeholder="Address Line3">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4"> Address Line4<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="user_address_line4" name="user_address_line4" placeholder="Address Line4">
						</div>
				   </div>
				   
				    <div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1"> Landline No<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="user_landline_number" name="landline_number">
						</div>
						<div class="form-group col-md-3">
						   <label for="address_line4">Permission</label>
						   <select name="permission_id" id="permission_id" class="form-control" onchange="getCollegeDiv();">
						    <option value="1">All</option>
						    <option value="2">Particular</option>
						   </select>
						</div>
						<div class="form-group col-md-3" id="campusDiv" style="display:none;">
						  <label for="address_line4">Campus</label>
						   <select name="subadmin_campus_id" id="subadmin_campus_id" class="form-control">
						    <option value="">--Select Campus--</option>
						    <?php foreach($campuses as $campus){?>
					           <option value="<?php echo $campus->id;?>"><?php echo $campus->campus_name;?></option>
					        <?php } ?>
					      </select>
						</div>
						
						<div class="form-group col-md-3">
						   <label for="address_line4">Marks Upload Permission</label>
						   <select name="marks_upload_permission" id="marks_upload_permission" class="form-control">
						    <option value="1">All</option>
						    <option value="2">Internal</option>
						    <option value="3">External</option>
						   </select>
						</div>
						
					</div>
				</div>
			     <!--subadmin other details end-->
				 
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
	function getCollegeDiv()
	{
		 var permission = $("#permission_id").val();
		 //alert(permission); return false;
		 if(permission=='2')
		{   
			$('#campusDiv').show();
			
		}
		else{
			$('#campusDiv').hide();
		}
		
	}
	$(document).ready(function() {
		$("#dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		$("#doa").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		$("#dop").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		$("#date_of_joining").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
	
	function setgroup(val)
	{
		$('#phydiv').hide();
		$('#commdiv').hide();
		$('#chediv').hide();
		$('#biodiv').hide();
		$('#botdiv').hide();
		$('#zoodiv').hide();
		$('#otherdiv').hide();
		$('#fishdiv').hide();
		$('#totdiv').hide();
		
		if(val != '')
		{
			if(val == 'group1')
			{
				$('#phydiv').show();
				$('#commdiv').show();
				$('#otherdiv').show();
				$('#chediv').show();
				$('#biodiv').show();
				$('#totdiv').show();
			}
			if(val == 'group2')
			{
				$('#phydiv').show();
				$('#commdiv').show();
				$('#otherdiv').show();
				$('#chediv').show();
				$('#botdiv').show();
				$('#zoodiv').show();
				$('#totdiv').show();
			}
			if(val == 'vocational')
			{
				$('#phydiv').show();
				$('#commdiv').show();
				$('#otherdiv').show();
				$('#chediv').show();
				$('#biodiv').show();
				$('#fishdiv').show();
				$('#totdiv').show();
			}
			
		}	
	}
	
	
	function getDegree()
	{
		var campus_id =$('#campus_id').val();
		//alert(campus_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>admin/getDegree',
			data: {'campus_id':campus_id},
			success: function(data){
				//alert(data);
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_id').empty();
			$("#degree_id").append(option_brand+data);
			 }
		});
	}
	
    function checkUser()
	{
		var username =$('#username').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>admin/getUser',
			data: {'username':username},
			success: function(data){
				
				if(data==1){
					$('.errorMsg').html('Username already exist!!').css("color", "red");
				}
				else {
					$('.errorMsg').html('');
				}
			},
		});
	}
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
			 }
		});
	}

	function detailDiv()
	{
		var usertype =$('#user_type').val();
		if(usertype=='1')
		{   
			$('#studentDiv').show();
			$('#teacherDiv').hide();
			$('#parentDiv').hide();
			$('#subadminDiv').hide();
			
		}
	    if(usertype=='2')
		{
			//alert("hello");
			$('#teacherDiv').show();
			$('#studentDiv').hide();
			$('#parentDiv').hide();
			$('#subadminDiv').hide();
			
		}
		if(usertype=='3')
		{
		   $('#parentDiv').show();
		   $('#studentDiv').hide();
		   $('#teacherDiv').hide();	
		   $('#subadminDiv').hide();	
           		   
		}
		if(usertype=='4')
		{
		   $('#parentDiv').hide();
		   $('#studentDiv').hide();
		   $('#teacherDiv').hide();
		   $('#subadminDiv').show();
		}
	}
	jQuery.validator.addMethod("notEqualTo",
		function (value, element, param) {
			var notEqual = true;
			value = $.trim(value);
			for (i = 0; i < param.length; i++) {

				var checkElement = $(param[i]);
				var success = !$.validator.methods.equalTo.call(this, value, element, checkElement);
				// console.log('success', success);
				if(!success)
					notEqual = success;
			}

			return this.optional(element) || notEqual;
		},
		"Please enter a diferent value."
	);
   $("#userform").validate({
		rules: {
			username: "required",
			password: "required",
			first_name: "required",
			last_name:"required",
			unique_id:"required",
			/*caste:"required",*/
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
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 