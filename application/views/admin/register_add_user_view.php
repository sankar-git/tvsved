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
  
  
 