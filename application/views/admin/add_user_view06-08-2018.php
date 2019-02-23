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
					<div class="form-group col-md-3">
					  <label for="password_text"><i class="fa fa-lock"></i> Password<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1"><i class="fa fa-user-circle-o"></i> First Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name">
					</div>
					<div class="form-group col-md-3">
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
					  <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Enter Contact Number">
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
					  <label for="exampleInputEmail1"><i class="fa fa-image"></i> User Image</label>
					  <input type="file" class="form-control" id="user_image" name="user_image">
					</div>
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-intersex custom"></i> Gender<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="gender" id="gender" class="form-control">
					  <option value="">--Select Gender--</option>
					  <option value="male">Male</option>
					  <option value="female">Female</option>
					  </select>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> DOB<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="dob" name="dob" placeholder="Enter Date Of Birth">
					</div>
					
               </div>
			   <!--student other details start-->
                <div id="studentDiv" style="display:none">
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
				
				<div><i class="fa fa-user"></i> Parent Info</div>
				
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
						  <label for="father_contact"><i class="fa fa-phone"></i> Father Contact<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="father_contact" name="father_contact" placeholder="Enter Father Contact">
						</div>
				   </div>
				   <div class="row">
						<div class="form-group col-md-3">
						  <label for="parent"><i class="fa fa-phone"></i> Alternate Contact<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="alternate_contact" name="alternate_contact" placeholder="Enter Alternate Contact">
						 
						</div>
						<div class="form-group col-md-3">
						  <label for="mother"><i class="fa fa-envelope"></i> Father Email<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="father_email" name="father_email" placeholder="Enter Father Email">
						</div>
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
				   </div>
				    <div class="row">
						<div class="form-group col-md-3">
						  <label for="address"><i class="fa fa-address-book-o"></i> Address<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
						 
						</div>
						
						<div class="form-group col-md-3">
						  <label for="religion"><i class="fa fa-flag"></i> Country<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="country_id" id="country_id" class="form-control" onchange="getState();">
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
						  <label for="zip"><i class="fa fa-map-pin"></i> Zip<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Enter Zip Code">
						 
						</div>
				   </div>
				   <div class="row">
				   <div class="form-group col-md-3">
					  <label for="parent_image"><i class="fa fa-image"></i> Parent Photo</label>
					  <input type="file" class="form-control" id="parent_image" name="parent_image" >
					</div>
				  </div>
				  <div><i class="fa fa-book"></i> Academic Info</div>
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
					  <label for="roll"><i class="fa fa-ship"></i> Roll</label>
					    <input type="text" class="form-control" id="roll" name="roll" placeholder="Enter Roll">
					</div>
				  </div>
				   <div class="row">
				   <div class="form-group col-md-3">
					  <label for="last_school"><i class="fa fa-address-book"></i> Last School</label>
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
		
	});
	$(document).ready(function() {
		$("#date_of_joining").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
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
	function getState()
	{
		var country_id =$('#country_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>admin/getState',
			data: {'country_id':country_id},
			success: function(data){
			var  option_brand = '<option value="">--Select State--</option>';
			$('#state_id').empty();
			$("#state_id").append(option_brand+data);
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
		}
	    if(usertype=='2')
		{
			//alert("hello");
			$('#teacherDiv').show();
			$('#studentDiv').hide();
			$('#parentDiv').hide();
		}
		if(usertype=='3')
		{
		   $('#parentDiv').show();
		   $('#studentDiv').hide();
		   $('#teacherDiv').hide();		 
		}
	}
	
   $("#userform").validate({
		rules: {
			username: "required",
			password: "required",
			first_name: "required",
			last_name:"required",
			state_id:"required",
			pincode: {
				required:true,
				digits: true,
				minlength:6,
				maxlength:6
			},
			contact_number: {
				required:true,
				digits: true,
				minlength:10,
				maxlength:10
			},
			mobile_number: {
				required:true,
				digits: true,
				minlength:10,
				maxlength:10
			},
			email:{
				required:true,
				email:true
			},
			
			
			dob:"required",
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
			
			member_address: 'required'
			
		},
		messages: {
			username: "User Name  Is Required",
			password:"Password Is Required",
			first_name: "First Name  Is Required",
			last_name:"Last Name Is Required",
			
			//user_image  	 : "Select an image to upload",
			
				pincode:{ 
					required: "Pincode Number is required",
					minlength: "Enter valid 6 digit Phone Number",
					maxlength: "Enter valid 6 digit Phone Number",
					digits : "Pincode Number Accept only Numbers"
			},
			contact_number:{ 
					required: "Contact Number is required",
					minlength: "Enter valid 10 digit Phone Number",
					maxlength: "Enter valid 10 digit Phone Number",
					digits : "Contact Number Accept only Numbers"
			},
			mobile_number:{ 
					required: "Mobile Number is required",
					minlength: "Enter valid 10 digit Phone Number",
					maxlength: "Enter valid 10 digit Phone Number",
					digits : "Mobile Number Accept only Numbers"
			},
		email:{
				required:"Please enter  email.",
				email:"Please enter valid  email."
			},
			
			dob: "DOB Is Required",
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
			member_address   : "Address is required"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 