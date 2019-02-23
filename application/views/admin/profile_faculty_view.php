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
.bg-info{padding:7px;background-color:#c3c3c3;}
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
			<?php if(!empty($user_row->user_image) && file_exists('uploads/user_images/parent/'.$user_row->user_image)){?>
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
             
			  <!-- <li><a href="#result" data-toggle="tab">Student Result</a></li>-->
            </ul>
			
            <div class="tab-content">
			
			
              <div class="active tab-pane mydetails" id="activity">
			  
			    <form  class="form-horizontal" method="post" name="user_update_form" id="user_update_form" action="<?php echo base_url();?>profile/updateProfile" enctype="multipart/form-data">
				<input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $user_row->role_id;?>">
				  <input type="hidden" class="form-control" id="role_id" name="role_id" value="<?php echo $user_row->role_id;?>">
				  <input type="hidden" class="form-control" id="first_name" name="first_name" value="<?php echo $user_row->first_name;?>">
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
  
  
 