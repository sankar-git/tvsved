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
			   <div style="float:right;">
				  <a class="btn btn-primary " href="<?php echo site_url('campus/listCampus'); ?>"><i class="fa fa-arrow-left"></i>Back</a>
				</div>
            </div>
              
           <!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="addcampus" id="addcampus" method="post" action="#" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="campus_code"><i class="fa fa-user-circle-o"></i> Campus Code</label>
					  <input type="text" class="form-control" id="campus_code" name="campus_code" value="<?php echo $campus_row->campus_code;?>"  placeholder="Enter Campus Code" readonly>
					  <span class="errorMsg"></span>
					</div>
					<div class="form-group col-md-3">
					  <label for="password_text"><i class="fa fa-lock"></i> Campus Name</label>
					  <input type="text" class="form-control" id="campus_name" name="campus_name" value="<?php echo $campus_row->campus_name;?>"  placeholder="Enter Campus Name" readonly>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1"><i class="fa fa-user-circle-o"></i> Campus Short Name</label>
					  <input type="text" class="form-control" id="campus_short_name" name="campus_short_name" value="<?php echo $campus_row->campus_short_name;?>"  placeholder="Enter campus Short Name" readonly>
					</div>
					<div class="form-group col-md-3">
						  <label for="address_line1"> Address Line1</label>
						  <input type="text" class="form-control" id="address_line1" name="address_line1" value="<?php echo $campus_row->address1;?>"  placeholder="Address Line1" readonly>
						  
				    </div>
               </div>
			   
			   
			           <div class="row">
						
						<div class="form-group col-md-3">
						  <label for="address_line2"> Address Line2</label>
						  <input type="text" class="form-control" id="address_line2" name="address_line2" value="<?php echo $campus_row->address2;?>"  placeholder="Address Line2" readonly>
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3"> Address Line3</label>
						  <input type="text" class="form-control" id="address_line3" name="address_line3" value="<?php echo $campus_row->address3;?>"  placeholder="Address Line3" readonly>
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4"> Address Line4</label>
						  <input type="text" class="form-control" id="address_line4" name="address_line4" value="<?php echo $campus_row->address4;?>"  placeholder="Address Line4" readonly>
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line1"> Landline No</label>
						  <input type="text" class="form-control" id="landline_number" name="landline_number" value="<?php echo $campus_row->landline_number;?>" readonly>
						  
						</div>
				   </div>
				   
				    <div class="row">
				<div class="form-group col-md-3">
						  <label for="address_line2">Mobile No.</label>
						  <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo $campus_row->mobile_number;?>"  placeholder="Enter Mobile Number" readonly>
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3">Fax No.</label>
						  <input type="text" class="form-control" id="fax_number" name="fax_number" value="<?php echo $campus_row->fax_number;?>"  placeholder="Fax Number" readonly>
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4">Email</label>
						  
						  <input type="text" class="form-control" id="email" name="email" value="<?php echo $campus_row->email;?>"  placeholder="Email" readonly>
						</div>
					<div class="form-group col-md-3">
						  <label for="login_id">Login Id</label>
						  <input type="text" class="form-control" id="login_id" name="login_id" value="<?php echo $campus_row->login_id;?>" readonly>
						  
					</div>
				</div>
				   <div class="row">
						
						<div class="form-group col-md-3">
						  <label for="address_line2">Dean Name</label>
						  <input type="text" class="form-control" id="dean_name" name="dean_name" value="<?php echo $campus_row->dean_name;?>" readonly>
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3">Dean Phone No.</label>
						  <input type="text" class="form-control" id="dean_phone_number" name="dean_phone_number" value="<?php echo $campus_row->dean_phone_number;?>" readonly>
						</div>
						<div class="form-group col-md-3">
						  <label for="dean_email">Dean Email</label>
						  <input type="text" class="form-control" id="dean_email" name="dean_email" value="<?php echo $campus_row->dean_email;?>" readonly>
						</div>
				   </div>
				   
				   
               </div>
			     
			 </div>
              <!-- /.box-body -->
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
  
  
 