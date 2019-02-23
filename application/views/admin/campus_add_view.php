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
            <form role="form" name="addcampus" id="addcampus" method="post" action="<?php echo base_url();?>campus/saveCampus" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="campus_code"><i class="fa fa-user-circle-o"></i> Campus Code<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="campus_code" name="campus_code"  placeholder="Enter Campus Code">
					  <span class="errorMsg"></span>
					</div>
					<div class="form-group col-md-3">
					  <label for="password_text"><i class="fa fa-lock"></i> Campus Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="campus_name" name="campus_name" placeholder="Enter Campus Name">
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1"><i class="fa fa-user-circle-o"></i> Campus Short Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="campus_short_name" name="campus_short_name" placeholder="Enter campus Short Name">
					</div>
					<div class="form-group col-md-3">
						  <label for="address_line1"> Address Line1</label>
						  <input type="text" class="form-control" id="address_line1" name="address_line1" placeholder="Address Line1">
						  
				    </div>
               </div>
			   
			   
			           <div class="row">
						
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
						<div class="form-group col-md-3">
						  <label for="address_line1"> Landline No</label>
						  <input type="text" class="form-control" id="landline_number" name="landline_number" placeholder="Landline No">
						  
						</div>
				   </div>
				   
				    <div class="row">
				<div class="form-group col-md-3">
						  <label for="address_line2">Mobile No.</label>
						  <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3">Fax No.</label>
						  <input type="text" class="form-control" id="fax_number" name="fax_number" placeholder="Fax Number">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line4">Email</label>
						  <input type="text" class="form-control" id="email" name="email" placeholder="Email">
						</div>
					<div class="form-group col-md-3">
						  <label for="login_id">Login Id<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="login_id" name="login_id" placeholder="Login Id">
						  
					</div>
				</div>
				   <div class="row">
						<div class="form-group col-md-3">
						  <label for="address_line1">Password<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
						  
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line1">Confirm Password<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
						  
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line2">Dean Name<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="dean_name" name="dean_name" placeholder="Dean Name">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3">Dean Phone No.<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="dean_phone_number" name="dean_phone_number" placeholder="Dean Phone No" maxlength="10">
						</div>
						<div class="form-group col-md-3">
						  <label for="dean_email">Dean Email<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="text" class="form-control" id="dean_email" name="dean_email" placeholder="Dean Email">
						</div>
				   </div>
				   
				   
               </div>
			     
			 </div>
              <!-- /.box-body -->

              <div class="box-footer" style="text-align: center;">
                <button type="submit" class="btn btn-primary" style="width: 108px;height: 47px;">Save</button>
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
	
   $("#addcampus").validate({
		rules: {
			campus_code: "required",
			campus_name: "required",
			campus_short_name: "required",
			login_id:"required",
			password: "required",
                confirm_password: {
                    equalTo: "#password"
                },
			dean_name:"required",	
			dean_phone_number:"required",	
			dean_email:"required",	
				
			},
		messages: {
			campus_code: "Campus Code  Is Required",
			campus_name:"Campus Name Is Required",
			campus_short_name: "Campus Short Name  Is Required",
			login_id:"Login Id Is Required",
			 password: " Password Is Required",
			 messages: {
                password: " Enter Password",
                confirmpassword: "Confirm Password Same as Password"
            },
			dean_name: "Dean Name  Is Required",
			dean_phone_number: "Dean Phone Number Is Required",
			dean_email: "Dean Email  Is Required"
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 