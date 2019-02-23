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
            <form role="form" name="userform" id="userform" method="post" action="<?php echo base_url();?>admin/updateTeacher/<?php echo $user_row->id;?>" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1"><i class="fa fa-user-circle-o"></i> First Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user_row->first_name?>" placeholder="Enter First Name">
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-user-circle-o"></i> Last Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user_row->last_name;?>" placeholder="Enter Last Name">
					</div>
					 <div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-envelope"></i> Email<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_row->email?>" placeholder=" Enter Email">
					</div>
				    <div class="form-group col-md-3">
					  <label for="exampleInputPassword1"><i class="fa fa-phone"></i> Contact No.<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $user_row->contact_number?>" placeholder="Enter Contact Number">
					</div>
               </div>
			   
			    <div class="row">
				   
					<div class="form-group col-md-3">
					  <label for="user_type"><i class="fa fa-universal-access" aria-hidden="true"></i> Role<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="user_type" id="user_type" class="form-control" onchange="detailDiv();">
					  <option value="">--Select Role--</option>
					 <?php foreach($roles as $role){?>
					  <option value="<?php echo $role->id;?>"<?php if($user_row->role_id==$role->id) echo "selected";?>><?php echo $role->role_name;?></option>
					 
					  <?php } ?>
					  </select>
					</div>
					
					
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1"><i class="fa fa-image"></i> User Image</label>
					  <input type="file" class="form-control" id="user_image" name="user_image">
					  <span><img src="<?php echo base_url();?>uploads/user_images/student/<?php echo $user_row->user_image;?>" height="50px" width="50px"></span>
					   <input type="hidden" class="form-control" id="user_old_image" name="user_old_image" value="<?php echo $user_row->user_image;?>">
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
					  <label for="date_of_birth"><i class="fa fa-birthday-cake"></i> DOB<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="dob" name="dob" value="<?php echo $user_row->dob;?>" placeholder="Enter Date Of Birth">
					</div>
					
               </div>
			
               <!--teacher other details start-->
                <div id="teacherDiv">
				<div><i class="fa fa-book"></i>Teacher Info</div>
					<div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1"> Address Line1<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address_line1" name="address_line1" value="<?php echo $user_row->address_line1?>" placeholder="Address Line1">
						  
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line2"> Address Line2<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address_line2" name="address_line2" value="<?php echo $user_row->address_line2;?>" placeholder="Address Line2">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3"> Address Line3<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address_line3" name="address_line3" value="<?php echo $user_row->address_line3;?>" placeholder="Address Line3">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4"> Address Line4<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="address_line4" name="address_line4"  value="<?php echo $user_row->address_line4;?>" placeholder="Address Line4">
						</div>
				   </div>
				   <div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1"> Landline No<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="landline_number" name="landline_number" value="<?php echo $user_row->landline_number?>" placeholder="Landline No">
						  
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line2">Employment Id<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="employee_id" name="employee_id" value="<?php echo $user_row->employee_id;?>" placeholder="Employment Id">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3">Qualification<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="qualification" name="qualification" value="<?php echo $user_row->qualification?>" placeholder="Qualification">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4">Date of Join<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="date_of_joining" name="date_of_joining" value="<?php echo $user_row->date_of_joining;?>" placeholder="Date of Join">
						</div>
				   </div>
				   
				    <div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1">Designation<span style="color:red;font-weight: bold;">*</span></label>
						    <select name="designation" id="designation" class="form-control" >
						      <option value="">--Select Designation--</option>
							  <option value="1" <?php if($user_row->designation=='1') {echo "selected";} ?> >Professor</option>
							  <option value="2" <?php if($user_row->designation=='2') {echo "selected";} ?>>Assistant Professor</option>
							  <option value="3" <?php if($user_row->designation=='3') {echo "selected";} ?>>Associate Professor</option>
							  <option value="4" <?php if($user_row->designation=='4') {echo "selected";} ?>>Director(Physical Education)</option>
							  <option value="5" <?php if($user_row->designation=='5') {echo "selected";} ?>>Asst. Director(Physical Education)</option>
							  <option value="6" <?php if($user_row->designation=='6') {echo "selected";} ?>>Deputy Director(Physical Education)</option>
							  <option value="7" <?php if($user_row->designation=='7') {echo "selected";} ?>>Assistant Librarian</option>
						    </select>
						  
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line2">Department<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="department" name="department" value="<?php echo $user_row->first_name?>" placeholder="Department">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3">Campus<span style="color:red;font-weight: bold;">*</span></label>
						  <select name="campus" id="campus" class="form-control">
						      <option value="">--Select Campus--</option>
							  <?php foreach($campuses as $campus) { ?>
							   <option value="<?php echo $campus->id;?>"  <?php if($user_row->campus==$campus->id){echo "selected";}?>><?php echo $campus->campus_name;?></option>
							  <?php } ?>
						    </select>
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4">Discipline<span style="color:red;font-weight: bold;">*</span></label>
						   <select name="discipline_id" id="discipline_id" class="form-control">
						    <option value="">--Select Discipline--</option>
						 <?php foreach($disciplines as $discipline){?>
					      <option value="<?php echo $discipline->id;?>" <?php if($user_row->discipline==$discipline->id){echo "selected";}?>><?php echo $discipline->discipline_name;?></option>
					     <?php } ?>
					  </select>
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
  
  
 